(function($) {
	mg_muuri_objs 		= []; // associative array (grid_id => obj) containing muuri objects to perform operations
	$mg_sel_grid 		= false; // set displayed item's grid id
	mg_mobile_mode 		= []; // associative array (grid_id => bool) to know which grid is in mobile mode
	
	var lb_is_shown 	= false; // lightbox shown flag
	var lb_switch_dir 	= false; // which sense lightbox is switching (prev/next)
	var video_h_ratio 	= 0.562; // video aspect ratio
	
	var grid_true_ids	= []; // to avoid useless codes - store IDs related to temp ones 
	var grid_is_shown	= []; // associative array (grid_id => bool) to know which grid is shown (first items be shown are so)
	var grids_width		= []; // array used to register grid size changes
	var mg_grid_pag 	= []; // associative array (grid_id => int) to know which page the grid is currently displays
	
	mg_grid_filters 	= []; /* multidimensional array containing applied filters. NB: filter key is the first class part to use (eg. mg_pag_ or mgc_) 
								(grid_id => array(
									'filter_key' => {
										condition 	: AND / OR (string) - use OR if value is an array 
										val			: the filter value (array) - eg. use [5] to filter category 5 (.mgc_5)
									}
								) 
							   */
	
	var txt_under_h		= []; // associative array (item_id => val) used to store text under items height for persistent check 
	var items_cache		= []; // avoid fetching again same item
	
	mg_slider_autoplay 	= []; // array (slider_id => bool) used to know which sliders needs to be autoplayed
	mg_player_objects 	= []; // player objects array
	mg_audio_tracklists = []; // array of tracklists
	mg_audio_is_playing = []; // which track is playing for each player
	
	var mg_deeplinked	= false; // flag to know whether to use history.replaceState
	var mg_hashless_url	= false; // page URL without eventual hashes
	var mg_url_hash		= ''; // URL hashtag
	
	// body/html style vars
	var mg_html_style = ''; 
	var mg_body_style = '';
	mg_fullpage_w = 0;

	// CSS3 loader code
	mg_loader =
	'<div class="mg_loader">'+
		'<div class="mgl_1"></div><div class="mgl_2"></div><div class="mgl_3"></div><div class="mgl_4"></div>'+
	'</div>';

	// event for touch devices that are not webkit
	var mg_generic_touch_event = (!("ontouchstart" in document.documentElement) /*|| navigator.userAgent.match(/(iPad|iPhone|iPod)/g)*/) ? '' : ' touchstart';
	


	// doc ready - append lightbox codes, manage deeplinks
	$(document).ready(function($) {
		mg_append_lightbox();
		mg_apply_deeplinks(true);
	});
	
	
	
	// dynamic grid initialization
	mg_init_grid = function(temp_grid_id, pag) {
		if(!$('#'+temp_grid_id).length) {return false;}
		
		grid_true_ids[temp_grid_id] = $('#'+temp_grid_id).data('grid-id');
		grid_is_shown[temp_grid_id] = false;
		
		// if doesn't exist - append lightbox code
		if(!$('#mg_lb_wrap').length) {
			mg_append_lightbox();
		}
		
		// inline txt items with video bg - use polyfill
		objectFitPolyfill(document.querySelectorAll('.mg_inl_txt_video_bg'));
		
		mg_grid_pag[temp_grid_id] = pag;
		grid_setup(temp_grid_id);
	};
	mg_async_init = function(grid_id, pag) {mg_init_grid(grid_id, pag);}; // retrocompatibility



	// layout and execute grid
	var grid_setup = function(grid_id) {
		evenize_grid_w(grid_id, true);
		mg_pagenum_btn_vis(grid_id);
		mg_txt_under_sizer(grid_id);
		
		item_img_switch(grid_id);
		
		// hook to perform actions right before items showing
		$(window).trigger('mg_pre_grid_init', [grid_id]);	
		
		// initialize muuri and the rest
		chitemmuuri(grid_id);
	};



	// always keep grids to have even width to reduce sizing problems  - ignore grid_id to evenize all
	var evenize_grid_w = function(grid_id, on_init) {
		var $grid = (typeof(grid_id) == 'undefined') ? jQuery('.mg_items_container') : jQuery('#'+grid_id+' .mg_items_container');
		if(!$grid.length) {return false;}
		
		if($grid.length == 1) {
			
			if(!$grid.outerWidth() || $grid.outerWidth() % 2 === 0) {
				return true;
			}
			else {
				// toggle mg_not_even_w class?	
				$grid.toggleClass('mg_not_even_w');
				
				if(typeof(on_init) == 'undefined') {
					mg_relayout_grid(grid_id);
				}
			}	
		}
		else {
			$grid.each(function() { 
				evenize_grid_w( $(this).parents('.mg_grid_wrap').attr('id') );
            });
		}
	};


	// switches images URL between desktop and mobile mode - must be used also to set the initial image
	var item_img_switch = function(grid_id, $forced_items) {
		var $grid 			= $('#'+grid_id); 
		var safe_mg_mobile 	= (typeof(mg_mobile) == 'undefined') ? 800 : mg_mobile;
		var first_init 		= ($('#'+grid_id+'.mg_muurified').length) ? false : true;
		var has_forced_items= (typeof($forced_items) == 'undefined') ? false : true;
		var trigger_action 	= (first_init || has_forced_items) ? false : true;
		
		// find items
		var $items = (has_forced_items) ? $forced_items.find('.mgi_main_thumb') : $('#'+ grid_id +' .mg_box').not('.mg_pag_hide, .mg_cat_hide, .mg_search_hide').find('.mgi_main_thumb');
		
		// get wrapper's width
		var grid_wrap_width = $('#'+grid_id).parent().width();
		
		// zero width - return false
		if(!grid_wrap_width) {return false;} 
		
		// no mobile mode flag? set it to false by deafult
		if(typeof(mg_mobile_mode[grid_id]) == 'undefined') {mg_mobile_mode[grid_id] = false;}	


		// mobile
		if(grid_wrap_width < safe_mg_mobile && (!mg_mobile_mode[grid_id] || first_init || has_forced_items)) {
			$items.each(function() {
                $(this).css('background-image', "url('"+ $(this).data('mobileurl') +"')");
            });

			mg_mobile_mode[grid_id] = true;
			$grid.addClass('mg_mobile_mode');
			
			if(trigger_action) {
				$(window).trigger('mg_mobile_mode_switch', [grid_id]);
			}
			return true;
		}

		// desktop
		if(grid_wrap_width >= safe_mg_mobile && (mg_mobile_mode[grid_id] || first_init || has_forced_items)) {
			$items.each(function() {
                $(this).css('background-image', "url('"+ $(this).data('fullurl') +"')");
            });
			
			mg_mobile_mode[grid_id] = false;
			$grid.removeClass('mg_mobile_mode');
			
			if(trigger_action) {
				$(window).trigger('mg_mobile_mode_switch', [grid_id]);
			}
			return true;
		}
	};
	
	
	// "read" texts under height and manage items to be properly arranged
	mg_txt_under_sizer = function(grid_id, relayout) {
		$('#'+ grid_id +' .mg_grid_title_under .mg_has_txt_under').each(function() {
			var $item = $(this);
			var iid = $item.attr('id'); 
			
			var old_val = (typeof( txt_under_h[iid] ) == 'undefined') ? false : txt_under_h[iid];
			var new_val = $item.find('.mgi_txt_under').outerHeight(true);
			
			if(old_val === false || old_val != new_val) {
				txt_under_h[iid] = new_val;
				$item.css('margin-bottom', new_val);
			}
		});
		
		if(typeof(relayout) != 'undefined') {
			mg_relayout_grid(grid_id);	
		}
	};
	

	
	////////////////////////////////////////////////////
	
	
	
	var hide_grid_loader = function(grid_id) {
		$('#'+ grid_id +' .mg_items_container').stop().fadeTo(300, 1);
		$('#'+grid_id).find('.mg_loader').stop().fadeOut(300);
	};
	
	
	var show_grid_loader = function(grid_id) {
		$('#'+ grid_id +' .mg_items_container').stop().fadeTo(300, 0.25);
		$('#'+grid_id).find('.mg_loader').stop().fadeIn(300);
	};
	
	
	
	// God bless Muuri
	var chitemmuuri = function(grid_id) {

		mg_muuri_objs[grid_id] = new Muuri( jQuery('#'+ grid_id +' .mg_items_container')[0] , {
			items					: jQuery('#'+ grid_id +' .mg_items_container')[0].getElementsByClassName('mg_box'),
			containerClass			: 'mg-muuri',
			itemClass				: 'mg-muuri-item',
			itemVisibleClass		: 'mg-muuri-shown',
			itemHiddenClass			: 'mg-muuri-hidden',
			layoutOnResize			: false,
			layout					: {
				fillGaps : true,
				alignRight : mg_rtl,
			},
							
			showAnimation: function(showDuration, showEasing, visibleStyles) {
				return {
					start: function() {},
					stop: function() {},
				};
			},
    		hideAnimation: function(hideDuration, hideEasing, hiddenStyles) {
				return {
					start: function() {},
					stop: function() {},
				};
			},
		});
		
		jQuery('#'+ grid_id).addClass('mg_muurified');
		
		// run filters - second parameter allows preload and show items
		mg_exec_filters(grid_id, true);
	};
	
	
	// recall muuri to layout again grid elements - ignore grid_id  to relayout all  
	mg_relayout_grid = function(grid_id) {

		// layout everything or just one?
		if(typeof(grid_id) == 'undefined') {
			$('.mg_muurified').each(function() { 
				mg_relayout_grid( $(this).attr('id') );
            });
		} 
		else {
			if(typeof(mg_muuri_objs[grid_id]) != 'undefined') {
				mg_muuri_objs[grid_id].refreshItems();
				mg_muuri_objs[grid_id].layout(true);	
			}
			else {
				console.error('Grid #'+grid_id+' not found or not initialized');	
			}
		}
	};
	
	
	
	// track grids width size change - persistent interval
	$(document).ready(function() {
		setInterval(function() {
			$('.mg_grid_wrap').each(function() {
                var gid = $(this).attr('id');
				var new_w = Math.round($(this).width());
				
				if(typeof(grids_width[gid]) == 'undefined') {
					grids_width[gid] = new_w;	
					return true;
				}
				
				// trigger only if size is different
				if(grids_width[gid] != new_w) {
					grids_width[gid] = new_w;
					
					if(new_w) {
						$(window).trigger('mg_resize_grid', [gid]);		
					}
				}
            });
		}, 200);
	});
	
	// standard MG operations on resize
	$(window).on('mg_resize_grid', function(e, grid_id) {
		
		// if not initialized (eg. tabbed grids) - init now
		if(!$('#'+grid_id+'.mg_muurified').length) {
			grid_setup(grid_id);	
		}
		else {
			mg_relayout_grid(grid_id);
			item_img_switch(grid_id);
			evenize_grid_w(grid_id);
			mg_pagenum_btn_vis(grid_id);
			
			mg_txt_under_sizer(grid_id);
			mg_responsive_txt(grid_id);				
		
			// inline players - resize to adjust tools size
			setTimeout(function() {
				mg_adjust_inl_player_size();
			}, 800);
		}
	});
	
	
	
	////////////////////////////////////////////////////
	
	

	// loads only necessary items (passed via $items) and triggers mg_display_boxes()
	mg_maybe_preload = function(grid_id, $items, callback) {
		mg_responsive_txt(grid_id);
		
		// hide "no items" message
		$('#'+grid_id +'.mg_no_results').removeClass('mg_no_results');
		var $subj = $items;
		
		
		// if no items have a featured image or everything is ready - show directly
		if(!$subj.not('.mgi_ready, .mg_inl_slider, .mg_inl_text').find('.mgi_main_thumb').length) {
			$subj.mg_display_boxes(grid_id);
			
			if(typeof(callback) == 'function') {
				callback.call();	
			}
		}
		
		// otherwise preload images first
		else {
			if($('#'+grid_id +' .mg_loader').is(':hidden')) {
				show_grid_loader(grid_id);	
			}
			
			// trick to use preloader without tweaks - simulate img tags
			var $preload_wrap = jQuery('<div></div>');
			$subj.not('.mgi_ready').find('.mgi_main_thumb').each(function() {
            	var src = (mg_mobile_mode[grid_id]) ? $(this).attr('data-mobileurl') : $(this).attr('data-fullurl');
				$preload_wrap.append('<img src="'+ src +'" />');  
            });
			
			$preload_wrap.find('img').lcweb_lazyload({
				allLoaded: function(url_arr, width_arr, height_arr) {
					$subj.mg_display_boxes(grid_id);
					
					if(typeof(callback) == 'function') {
						callback.call();	
					}
				}
			});
		}
	};
	
	
	
	// show boxes, initializing players and sliders
	$.fn.mg_display_boxes = function(grid_id) {
		var $boxes = this;
		var grid_initiated = (grid_is_shown[grid_id]) ? true : false;
		
		hide_grid_loader(grid_id);
		
		var a = 0;
		var delay = (mg_delayed_fx && !grid_is_shown[grid_id]) ? 170 : 0; // no delay if grid is already shown
		var total_delay = this.length * delay;
		
		$boxes.each(function(i, v) {
			var $subj = $(this);
			var true_delay = delay * a;
			
			// mark items as managed
			$subj.addClass('mgi_ready');
			
			// show
			setTimeout(function() {
				$subj.addClass('mgi_shown');

				// keburns effects - init
				$subj.mg_item_img_to_kenburns();

				// inline slider - init
				if( $subj.hasClass('mg_inl_slider') ) {
					var sid = $subj.find('.mg_inl_slider_wrap').attr('id');
					mg_inl_slider_init(sid);
				}
				
				// inline video - init and eventually autoplay
				if($subj.find('.mg_self-hosted-video').length) {
					var pid = '#' + $subj.find('.mg_sh_inl_video').attr('id');
					mg_video_player(pid, true);
					
					var inl_player = true; 
				}

				// webkit fix for inline vimeo/youtube fullscreen mode + avoid bounce back on self-hosted fullscreen mode
				if( $subj.hasClass('mg_inl_video') && !$subj.find('.mg_sh_inl_video').length) {
					if(navigator.userAgent.indexOf('Chrome/') != -1 || navigator.appVersion.indexOf("Safari/") != -1) {
						setTimeout(function() {
							$subj.find('.mg_shadow_div').css('transform', 'none').css('animation', 'none').css('-webkit-transform', 'none').css('-webkit-animation', 'none').css('opacity', 1);				
						}, 350);
					}	
				}

				// inline audio - init and show
				if( $subj.hasClass('mg_inl_audio') && $subj.find('.mg_inl_audio_player').length ) {
					setTimeout(function() {
						var pid = '#' + $subj.find('.mg_inl_audio_player').attr('id');
						init_inl_audio(pid);
					}, 350);
						
					var inl_player = true; 
				}
				
				// fix inline player's progressbar when everything has been shown
				if(typeof(inl_player) != 'undefined') {
					setTimeout(function() {
						var player_id = '#' + $subj.find('.mg_inl_audio_player, .mg_sh_inl_video').attr('id');
						mg_adjust_inl_player_size(player_id);
					}, 400);
				}
				
				// inline text with video bg - init
				if( $subj.find('.mg_inl_txt_video_bg').length ) {
					var video = $subj.find('.mg_inl_txt_video_bg')[0];
					video.currentTime = 0;
					video.play();
				}
				
			}, true_delay);
			
			a++;
		});
		
		
		// actions after grid is fully shown
		setTimeout(function() {
			
			// actions on very first grid showing
			if(!grid_initiated) {
				grid_is_shown[grid_id] = true;
				$('#'+ grid_id +' .mg_no_init_loader').removeClass('mg_no_init_loader');
				
				// remove initial classes and manage everything with muuri
				$('#'+ grid_id).addClass('mgi_shown');

				// add an hook for custom actions
				$(window).trigger('mg_grid_shown', [grid_id]);
			}	
			
			// fix fucking webkit rendering bug
			webkit_blurred_elems_fix(grid_id);		
		}, total_delay);
		
		
		// boxes are ready - trigger action passing grid id, managed items and grid_initiated boolean
		$(window).trigger('mg_items_ready', [grid_id, $boxes, grid_initiated]);
		return true;
	};
	
	
	
	//////////////////////////////////////////////////////////////////////////

	
	
	// EXECUTE FILTERS
	//// elaborates filters and applied the "mg_filtered" class to be used by muuri - reads values from mg_grid_filter 
	mg_exec_filters = function(grid_id, on_init) {
		var $grid = $('#'+grid_id);
		
		if(typeof(mg_grid_filters[grid_id]) != 'object' || $grid.hasClass('mg_is_filtering')) {
			return false;
		}
		var mgf = mg_grid_filters[grid_id];
		
		// reset
		$grid.addClass('mg_is_filtering');
		$grid.find('.mg_no_results').removeClass('mg_no_results');
		$grid.find('.mg_box').removeClass('mg_filtered mg_hidden_pag');
		
		// find items to be shown
		var $all_items = $('#'+grid_id +' .mg_box');
		var $items = $all_items;
		
		
		// ignore pagination?
		if(Object.keys(mgf).length > 1 && typeof(mgf['mg_pag_']) != 'undefined' && !mg_monopage_filter) {
			$grid.find('.mg_pag_wrap').fadeOut(400); // hide pagination wrap	
			var ignore_pag = true;
		} else {
			$grid.find('.mg_pag_wrap').fadeIn(400); // hide pagination wrap	
			var ignore_pag = false;
		}
		
		
		// filter style (reduce opacity only on 1-page grids or if calculating pagination)
		var behav = 'standard';
		if(mg_filters_behav != 'standard') {
			if(!$grid.find('.mg_pag_wrap').length || mg_monopage_filter) {
				behav = mg_filters_behav;	

			}

		}
			

		// filter
		for(var key in mg_grid_filters[grid_id]) {
			var data = mg_grid_filters[grid_id][key];
			if(typeof(data.val) != 'object' || !data.val.length || typeof(data.condition) == 'undefined') {continue;}

			// trick to filter on every page
			if(ignore_pag && key == 'mg_pag_') {continue;}


			// AND condition
			if(data.condition == 'AND') {
				var selector = ''; 	
				$.each(data.val, function(i,v) {
					selector += '.'+ key + v;
				});
			}
			
			// OR condition
			else {
				var selector = []; 	
				$.each(data.val, function(i,v) {
					selector.push( '.'+ key + v);
				});
				selector = selector.join(' , ');
			}
			
			//console.log(selector); // debug 
			$items = $items.filter(selector);
			
			
			// if filtering by page - add another class for excluded ones
			if(key == 'mg_pag_') {
				$all_items.not(selector).addClass('mg_hidden_pag');	
			}
		}
		
		// class flagging remaining items 
		$items.addClass('mg_filtered');
		var $shown_items = (behav == 'standard') ? $items : $all_items.not('.mg_hidden_pag');
		
		// which class to use with muuri?
		var muuri_filter = (behav == 'standard') ? '.mg_filtered' : '*:not(.mg_hidden_pag)';

		// switch image for shown items
		item_img_switch(grid_id, $shown_items);
		
		
		////
		// opacity filters - use JS
		if(behav != 'standard') {
			var opacity_val = (behav == '0_opacity') ? 0 : 0.4;
			$all_items.not('.mg_filtered').addClass('mgi_low_opacity_f').fadeTo(450, opacity_val);
			$items.removeClass('mgi_low_opacity_f').fadeTo(450, 1);
		}
		////
		

		// on grid init - just set classes and trigger preload
		if(typeof(on_init) != 'undefined') {
			$grid.find('.mg_items_container').removeClass('mgic_pre_show');
			
			mg_maybe_preload(grid_id, $shown_items);	
			mg_muuri_objs[grid_id].filter(muuri_filter);	
			
			mg_filter_no_results(grid_id);
			$grid.removeClass('mg_is_filtering');
		}
		
		
		// otherwise be sure items are ready before filtering
		else {
			mg_maybe_preload(grid_id, $shown_items, function() {
				mg_muuri_objs[grid_id].filter(muuri_filter);
				
				mg_filter_no_results(grid_id);
				$grid.removeClass('mg_is_filtering');
				
				// trigger action to inform that items are filtered (and new ones could be shown)
				$(window).trigger('mg_filtered_grid', [grid_id]);
			});
			
			// pause hidden players and sliders (be sure to use it after maybe_preload() )
			mg_pause_inl_players(grid_id);
		}
	};
	
	
	// shown items count - toggle "no results" box
	var mg_filter_no_results = function(grid_id) {
		
		if($('#'+ grid_id +' .mg-muuri-shown').length) {
			$('#'+ grid_id +' .mg_items_container').removeClass('mg_no_results');
		} else {
			$('#'+ grid_id +' .mg_items_container').addClass('mg_no_results');
		}
	};
	
	
	// dropdown filters management
	$(document).delegate('.mg_mobile_mode .mg_dd_mobile_filters .mgf_inner', 'click', function(e) {
		e.preventDefault();
		e.stopImmediatePropagation();
		
		var $this = $(this);
		if(typeof(mg_dd_toggle_timeout) != 'undefined') {clearTimeout(mg_dd_toggle_timeout)}
		
		mg_dd_toggle_timeout = setTimeout(function() {
			$this.toggleClass('mgf_dd_expanded');
		}, 50);
	});
	
	
	
	//////////////////////////////////////////////////////////////////////////
	
	
	
	// PAGINATE ITEMS
	$(document).ready(function() {
		
		// prev/next buttons
		$(document).delegate('.mg_next_page:not(.mg_pag_disabled), .mg_prev_page:not(.mg_pag_disabled)', 'click'+mg_generic_touch_event, function() {
			var cmd = ($(this).hasClass('mg_next_page')) ? 'next' : 'prev';
			mg_paginate(cmd, $(this).parents('.mg_grid_wrap').attr('id') );
		});
		
		
		// page buttos and dots
		$(document).delegate('.mg_pag_btn_nums > div:not(.mg_sel_pag), .mg_pag_btn_dots > div:not(.mg_sel_pag)', 'click'+mg_generic_touch_event, function() {
			var pag = $(this).data('pag');
			var grid_id = $(this).parents('.mg_grid_wrap').attr('id'); 
			
			jQuery(this).parents('.mg_pag_wrap').find('> div').removeClass('mg_sel_pag');
			jQuery(this).addClass('mg_sel_pag');
			
			
			mg_pagenum_btn_vis(grid_id);
			mg_paginate(pag, grid_id);
		});
	});
	
	
	// perform pagination - direction accepts "next" / "prev" or the page number

	mg_paginate = function(direction, grid_id) {
		if($('#'+grid_id).hasClass('mg_is_filtering')) {
			return false;	
		}
		
		var temp_gid = grid_id;
		var gid = $('#'+temp_gid).data('grid-id');
		
		var tot_pags = parseInt($('#mgp_'+temp_gid).data('tot-pag'));
		var curr_pag =  parseInt(mg_grid_pag[temp_gid]);

		
		// next/prev case
		if($.inArray(direction, ['next', 'prev']) !== -1) {
			if( // ignore in these cases
				(direction == 'next' && curr_pag >= tot_pags) ||
				(direction == 'prev' && curr_pag <= 1)
			) {
				return false;	
			}
			
			// update pag vars
			var new_pag = (direction == 'next') ? curr_pag + 1 : curr_pag - 1;	
		}

		// direct pagenum submission
		else {
			var new_pag = parseInt(direction);
			if(new_pag < 1 || new_pag > tot_pags || new_pag == curr_pag) {
				return false;	
			}
		}

		
		// set class
		mg_grid_pag[temp_gid] = new_pag;	
		
		// set/remove deeplink
		if(new_pag == 1) {
			mg_remove_deeplink('page' ,'mgp_'+gid);
		} else {
			mg_set_deeplink('page', 'mgp_'+gid, new_pag);
		}
		
		// manage disabled class
		if(new_pag == 1) {
			$('#mgp_'+temp_gid+' .mg_prev_page').addClass('mg_pag_disabled');
		} else {
			$('#mgp_'+temp_gid+' .mg_prev_page').removeClass('mg_pag_disabled');
		}
		
		if(new_pag == tot_pags) {
			$('#mgp_'+temp_gid+' .mg_next_page').addClass('mg_pag_disabled');
		} else {
			$('#mgp_'+temp_gid+' .mg_next_page').removeClass('mg_pag_disabled');
		}
		
		// manage current pag number if displayed
		if($('#mgp_'+temp_gid+' .mg_nav_mid span').length) {
			$('#mgp_'+temp_gid+' .mg_nav_mid span').text(new_pag);	
		}
		
		
		// update filter
		mg_grid_filters[ temp_gid ]['mg_pag_'] = {
			condition 	: 'AND',
			val			: [new_pag]
		};
		mg_exec_filters(temp_gid);
		
		
		// move to grids top
		jQuery('html, body').animate({'scrollTop': jQuery('#'+temp_gid).offset().top - 15}, 300);
	};
	
	
	// track grid's width and avoid pagenum and dots to go on two lines
	var mg_pagenum_btn_vis = function(grid_id) {
		if(!$('#'+grid_id).find('.mg_pag_btn_nums, .mg_pag_btn_dots').length) {
			return false;	
		}

		var $pag_wrap = $('#'+grid_id).find('.mg_pag_wrap'); 
		var $btns = $('#'+grid_id).find('.mg_pag_btn_nums, .mg_pag_btn_dots').find('> div');
		
		// reset
		$pag_wrap.removeClass('mg_hpb_after mg_hpb_before');
		$btns.removeClass('mg_hidden_pb');
		
		// there must be at least 5 buttons
		if($btns.length <= 5) {return false;}
		
		
		// calculate overall btns width
		var btns_width = 0;
		$btns.each(function() {
            btns_width += jQuery(this).outerWidth(true) + 1; // add 1px to avoid any issue
        });  
		

		// act if is wider
		if(btns_width > $pag_wrap.outerWidth()) {
			var $sel_btn = $('#'+grid_id+' .mg_sel_pag');
			var curr_pag = parseInt($sel_btn.data('pag'));
			var tot_pages = parseInt($btns.last().data('pag'));
			
			// count dots width
			var dots_w = (curr_pag <= 2 || curr_pag >= (tot_pages - 1)) ? 26 : 52; // width = 16px + add 10px margin
			
			var diff = btns_width + dots_w - $pag_wrap.outerWidth() ;
			var last_btn_w = $btns.last().outerWidth(true);
			var to_hide = Math.ceil( diff / last_btn_w );

			// manage pag btn visibility
			if(curr_pag <= 2 || curr_pag >= (tot_pages - 1)) {
			var to_hide_sel = [];
			
				if(curr_pag <= 2) {
					$pag_wrap.addClass('mg_hpb_after');		
					
					for(a=0; a < to_hide; a++) {
						to_hide_sel.push('[data-pag='+ (tot_pages - a) +']');	
					}
				}
				else if( curr_pag >= (tot_pages - 1)) {
					$pag_wrap.addClass('mg_hpb_before');	
					
					for(a=0; a < to_hide; a++) {
						to_hide_sel.push('[data-pag='+ (1 + a) +']');	
					}
				}
				
				$btns.filter( to_hide_sel.join(',') ).addClass('mg_hidden_pb');
			}
			
			else {
				$pag_wrap.addClass('mg_hpb_before mg_hpb_after');	
				var to_keep_sel = ['[data-pag='+ curr_pag +']'];
				
				// use opposite system: selected is the center and count how to keep 
				var to_keep = (tot_pages - 1) - to_hide;

				var to_keep_pre = Math.floor( to_keep / 2 );
				var to_keep_post = Math.ceil( to_keep / 2 );
				
				// if pre/post already reaches the edge, sum remaining ones on the other side
				var reach_pre = curr_pag - to_keep_pre;
				var reach_post = curr_pag + to_keep_post;
				
				if(reach_pre <= 1) {
					$pag_wrap.removeClass('mg_hpb_before');	
					to_keep_post = to_keep_post + (reach_pre * -1 + 1);	
				}
				else if(reach_post >= tot_pages) {
					$pag_wrap.removeClass('mg_hpb_after');	
					to_keep_pre = to_keep_pre + (reach_post - (tot_pages - 1));	
				}
				
				for(a=1; a <= to_keep_pre; a++) {
					to_keep_sel.push('[data-pag='+ (curr_pag - a) +']');	
				}
				for(a=1; a <= to_keep_post; a++) {
					to_keep_sel.push('[data-pag='+ (curr_pag + a) +']');	
				}
				
				$btns.not( to_keep_sel.join(',') ).addClass('mg_hidden_pb');
			}	
		}
	};
	
	
	//////
	
	
	// Infinite Scroll
	$(document).ready(function() {
		$(document).delegate('.mg_load_more_btn', 'click'+mg_generic_touch_event, function() {
			var $pwrap = $(this).parents('.mg_pag_wrap');
			var grid_id = $(this).parents('.mg_grid_wrap').attr('id');
			
			var curr_pag = parseInt($pwrap.attr('data-init-pag'));
			var tot_pags = parseInt($pwrap.attr('data-tot-pag'));
			
			if($('#'+grid_id).hasClass('mg_is_filtering') || curr_pag >= tot_pags) {
				return false;	
			}
			
			var newpag = curr_pag + 1;
			$pwrap.attr('data-init-pag', newpag);

			// filter showing every page until now
			var filter_val = [];
			for(a = 1; a <= newpag ; a++) {filter_val.push(a);}
			
			mg_grid_filters[ grid_id ]['mg_pag_'] = {
				condition 	: 'OR',
				val			: filter_val
			};
			mg_exec_filters(grid_id);
			
			// reached final page? hide button
			if(newpag >= tot_pags) {
				$pwrap.fadeOut(300, function() {
					$('#'+grid_id).animate({paddingBottom : 0}, 400);		
				});
			}
		});
	});
	
	
	///////////////////////////////////////////////
	


	// items category filter
	$(document).ready(function() {
		$(document).delegate('.mgf:not(.mgf_selected)', 'click', function(e) {
			e.preventDefault();

			var $grid = $(this).parents('.mg_grid_wrap');
			var temp_gid = $grid.attr('id'); 
			var gid = $grid.data('grid-id');
			var sel = $(this).data('filter-id');
			var txt = $(this).text();
			
			// already filtering? stop
			if($grid.hasClass('mg_is_filtering') ) {return false;}

			// button selection manag
			$grid.find('.mgf').removeClass('mgf_selected');
			$(this).addClass('mgf_selected');
			
			// no filter - clear filtering db and deeplink
			if(!sel || sel == '*') {
				delete mg_grid_filters[ temp_gid ]['mgc_'];
				mg_remove_deeplink('category', 'mgc_'+gid);
			}
			
			// filter selected - update db and deeplink
			else {
				mg_grid_filters[ temp_gid ]['mgc_'] = {
					condition 	: 'AND',
					val			: [sel]
				};
				mg_set_deeplink('category', 'mgc_'+gid, sel, txt);
			}
				
			mg_exec_filters(temp_gid);
			
			
			// mgf_noall_placeh removal
			if($grid.find('.mgf_noall_placeh').length) {
				$grid.find('.mgf_noall_placeh').remove();	
			}
		});
	});



	///////////////////////////////////////////////
	


	// items search 
	$(document).delegate('.mgf_search_form input', 'keyup', function() {
		
		if(typeof(mg_search_defer) != 'undefined') {clearTimeout(mg_search_defer);}
		var $this = $(this); 
		
		mg_search_defer = setTimeout(function() { 
			var $grid = $this.parents('.mg_grid_wrap');
			var temp_gid = $grid.attr('id'); 
			var gid = $grid.data('grid-id');
			var val = $.trim( $this.val() );
			
			// reset class
			$grid.find('.mg_box').removeClass('mg_search_res');
			

			// is searching
			if(val && val.length > 2) {
				$grid.find('.mgf_search_form').addClass('mgs_has_txt');	
				
				// elaborate search string to match items
				var src_arr = val.toLowerCase().split(' ');
				var matching = [];
	
				// cyle and check each searched term 
				$grid.find('.mg_box:not(.mg_spacer)').each(function() {
					var src_attr = $(this).data('mg-search').toLowerCase();
					var rel = $(this).data('item-id');
					
					$.each(src_arr, function(i, word) {						
						if( src_attr.indexOf(word) !== -1 ) {
							matching.push( rel );
							return false;	
						}
					});
				});
	
				// add class to matched elements
				$.each(matching, function(i, v) {
					$grid.find('.mg_box[data-item-id='+ v +']').addClass('mg_search_res');
				});
				
				
				// set filter engine to match mg_search_res
				mg_grid_filters[ temp_gid ]['mg_search_res'] = {
					condition 	: 'AND',
					val			: ['']
				};
				
				mg_set_deeplink('search', 'mgs_'+gid, val);
			} 
			
			
			// deleting research
			else {
				$grid.find('.mgf_search_form').removeClass('mgs_has_txt');		
				delete mg_grid_filters[ temp_gid ]['mg_search_res']; 
				mg_remove_deeplink('search', 'mgs_'+gid);
			}
			
			
			// filter to show results
			mg_exec_filters(temp_gid);
		}, 300);
	});


	// reset search
	$(document).delegate('.mgf_search_form.mgs_has_txt i', 'click'+mg_generic_touch_event, function() {
		var $grid = $(this).parents('.mg_grid_wrap');
		var $input = $grid.find('.mgf_search_form input'); 
		
		if($grid.hasClass('mg_is_filtering')) {return false;}
		
		if($.trim( $input.val() ) && $input.val().length > 2) {
			$input.val('');
			$input.trigger('keyup');	
		}
	});
	

	// disable enter key
	jQuery(document).on("keypress", ".mgf_search_form input", function(e) { 
		return e.keyCode != 13;
	});
	


	// custom filtering behavior
	$.fn.mg_custom_iso_filter = function( options ) {
		options = $.extend({
			filter: '*',
			hiddenStyle: { opacity: 0.2 },
			visibleStyle: { opacity: 1 }
		}, options );

		this.each( function() {
			var $items = $(this).children();
			var $visible = $items.filter( options.filter );
			var $hidden = $items.not( options.filter );

			$visible.clearQueue().animate( options.visibleStyle, 300 ).removeClass('mg_disabled');
			$hidden.clearQueue().animate( options.hiddenStyle, 300 ).addClass('mg_disabled');
		});
	};
	
	
	
	
	////////////////////////////////////////////
	
	

	// video poster - handle click
	$(document).ready(function() {
		// grid item
		$(document).delegate('.mg_inl_video:not(.mgi_iv_shown)', 'click'+mg_generic_touch_event, function(e){
			var $this = $(this);
			$this.addClass('mgi_iv_shown');
			
			// video iframe
			if($this.find('.mg_video_iframe').length) {
				var autop = $this.find('.mg_video_iframe').data('autoplay-url');
				$this.find('.mg_video_iframe').attr('src', autop).show();
	
				setTimeout(function() { // wait a bit to let iframe populate
					$this.find('.mgi_thumb_wrap, .mgi_overlays').fadeTo(350, 0, function() {
						$this.parents('.mg_video_iframe').css('z-index', 100);
						$(this).remove();
					});
				}, 50);
			}
			
			// self-hosted
			else {
				$this.find('.mgi_thumb_wrap, .mgi_overlays').fadeTo(350, 0, function() {
					$(this).remove();
					
					var pid = '#' + $this.find('.mg_sh_inl_video').attr('id');
					var player_obj = mg_player_objects[pid];
					player_obj.play();
				});
			}
		});

		// lightbox
		$(document).delegate('#mg_lb_video_poster, #mg_ifp_ol', 'click'+mg_generic_touch_event, function(e){
			var autop = $('#mg_lb_video_poster').data('autoplay-url');
			if(typeof(autop) != 'undefined') {
				$('#mg_lb_video_wrap').find('iframe').attr('src', autop);
			}

			$('#mg_ifp_ol').fadeOut(120);
			$('#mg_lb_video_poster').fadeOut(400);
		});
	});


	// show&play inline audio on overlay click
	$(document).ready(function(e) {
        $('body').delegate('.mg_box.mg_inl_audio:not(.mgi_ia_shown)', 'click'+mg_generic_touch_event, function() {
			var $this = jQuery(this);
			$this.addClass('mgi_ia_shown');
			
			// soundCloud
			if($this.find('.mg_soundcloud_embed').length) {
				var sc_url = $this.find('.mg_soundcloud_embed').data('lazy-src');
				$this.find('.mg_soundcloud_embed').attr('src', sc_url).removeData('lazy-src');
				
				setTimeout(function() { // wait a bit to let iframe populate
					$this.find('.mgi_thumb_wrap, .mgi_overlays').fadeTo(350, 0, function() {
						$this.find('.mg_soundcloud_embed').css('z-index', 100);
						$(this).remove();
					});
				}, 50);
			}
			
			// self-hosted 
			else {
				var player_id = '#' + $this.find('.mg_inl_audio_player').attr('id');
				init_inl_audio(player_id, true);	
				
				$this.find('.mgi_overlays').fadeOut(350, function() {
					$(this).remove();
				});
			}
		});
	});



	// touch devices hover effects
	if( mg_is_touch_device() ) {
		$('.mg_box').bind('touchstart', function() { $(this).addClass('mg_touch_on'); });
		$('.mg_box').bind('touchend', function() { $(this).removeClass('mg_touch_on'); });
	}
	
	
	

	//////////////////////////////////////////////////////////////////////////




	/***************************************
	************** LIGHTBOX ****************
	***************************************/


	// append the lightbox code to the website
	mg_append_lightbox = function() {
		if(typeof(mg_lightbox_mode) != 'undefined') {

			// deeplinked lightbox - stop here
			if($('#mg_deeplinked_lb').length) {
				$mg_lb_contents = $('#mg_lb_contents');
				$('html').addClass('mg_lb_shown');
				lb_is_shown = true;
				return true;
			}


			/// remove existing one
			if($('#mg_lb_wrap').length) {
				$('#mg_lb_wrap, #mg_lb_background').remove();
			}

			// touchswipe class
			var ts_class = (mg_lb_touchswipe) ? 'class="mg_touchswipe"' : '';

			$('body').append(''+
			'<div id="mg_lb_wrap" '+ts_class+'>'+
				'<div id="mg_lb_loader">'+ mg_loader + '</div>' +
				'<div id="mg_lb_contents" class="mg_lb_pre_show_next"></div>'+
				'<div id="mg_lb_scroll_helper" class="'+ mg_lightbox_mode +'"></div>'+
			'</div>'+
			'<div id="mg_lb_background" class="'+ mg_lightbox_mode +'"></div>');

			$mg_lb_contents = $('#mg_lb_contents');
		}
	};


	// open item trigger
	$(document).ready(function() {
		$(document).delegate('.mgi_has_lb:not(.mg-muuri-hidden, .mgi_low_opacity_f)', 'click', function(e){
			// elements to ignore -> mgom socials
			var $e = $(e.target);
			if(!lb_is_shown && !$e.hasClass('mgom_fb') && !$e.hasClass('mgom_tw') && !$e.hasClass('mgom_pt') && !$e.hasClass('mgom_gp') && !$e.hasClass('mg_quick_edit_btn')) {
				var $subj = $(this);
				
				var pid = $subj.data('item-id');
				$mg_sel_grid = $subj.parents('.mg_grid_wrap');

				// open
				mg_open_item(pid);
			}
		});
	});

	
	// remove site scrollbar when lightbox is on
	mg_remove_scrollbar = function() {
		mg_html_style = (typeof($('html').attr('style')) != 'undefined') ? $('html').attr('style') : '';
		mg_body_style = (typeof($('body').attr('style')) != 'undefined') ? $('body').attr('style') : '';
		
		// avoid page scrolling and maintain contents position
		var orig_page_w = $(window).width();
		$('html').css({
			'overflow' 		: 'hidden',
			'touch-action'	: 'none'
		});

		$('body').css({
			'overflow' 		: 'visible',
			'touch-action'	: 'none'	
		});	
		
		mg_fullpage_w = $(window).width();
		$('html').css('margin-right', ($(window).width() - orig_page_w));
	};



	// OPEN ITEM
	mg_open_item = function(item_id, deeplinked_lb) {
		mg_remove_scrollbar();
		$('#mg_lb_wrap').show();

		// mobile trick to focus lightbox contents
		if($(window).width() < 1000) { 
			$mg_lb_contents.delay(20).trigger('click');
		}

		// open only if is not deeplinked
		if(typeof(deeplinked_lb) == 'undefined') {
			setTimeout(function() {
				$('#mg_lb_loader, #mg_lb_background').addClass('mg_lb_shown');
				mg_get_item_content(item_id);
			}, 50);
		}
	};


	// get item's content
	mg_get_item_content = function(pid, on_item_switch) {
		$mg_lb_contents.removeClass('mg_lb_shown');
		var gid = $mg_sel_grid.attr('id');
		var true_gid = $mg_sel_grid.data('grid-id');

		// set attributes to know related grid and item ID
		$('#mg_lb_wrap').data('item-id', pid).data('grid-id', gid);

		// set deeplink
		var item_title = $('.mgi_'+pid+' .mgi_main_thumb').data('item-title');
		mg_set_deeplink('item', 'mgi_'+true_gid, pid, item_title);

		// get prev and next items ID to compose nav arrows
		var nav_arr = [];
		var curr_pos = 0;

		$mg_sel_grid.find('.mgi_has_lb').not('.mg-muuri-hidden').each(function(i, el) {
			var item_id = $(this).data('item-id');

			nav_arr.push(item_id);
			if(item_id == pid) {curr_pos = i;}
		});
		
		// prev/next switch 
		if(mg_lb_carousel) {
			// nav - prev item
			var prev_id = (curr_pos !== 0) ? nav_arr[(curr_pos - 1)] : nav_arr[(nav_arr.length - 1)];
			
			// nav - next item
			var next_id = (curr_pos != (nav_arr.length - 1)) ? nav_arr[(curr_pos + 1)] : nav_arr[0];
		}
		else {
			// nav - prev item
			var prev_id = (curr_pos !== 0) ? nav_arr[(curr_pos - 1)] : 0;
			
			// nav - next item
			var next_id = (curr_pos != (nav_arr.length - 1)) ? nav_arr[(curr_pos + 1)] : 0;
		}
	
		
		// create a static cache id to avoid doubled ajax calls
		var static_cache_id = ''+ prev_id + pid + next_id;
	

		// check in static cache
		if(typeof(items_cache[static_cache_id]) != 'undefined') {
			var delay = (typeof(on_item_switch) == 'undefined') ? 320 : 0; // avoid lightbox to be faster than background on initial load
			
			setTimeout(function() {
				fill_lightbox( items_cache[static_cache_id] );	
			}, delay);
		}
		
		// perform ajax call
		else {
			var cur_url = location.href;
			var data = {
				mg_lb	: 'mg_lb_content',
				pid		: pid,
				prev_id : prev_id,
				next_id : next_id
			};
			mg_get_item_ajax = $.post(cur_url, data, function(response) {
				
				if(static_cache_id) {
					items_cache[static_cache_id] = response;
				}
				
				fill_lightbox(response);
			});
		}

		return true;
	};
	
	
	// POPULATE LIGHTBOX AND SHOW BOX
	var fill_lightbox = function(lb_contents) {
		if(!lb_switch_dir) {lb_switch_dir = 'next';}
		$mg_lb_contents.html(lb_contents).attr('class', 'mg_lb_pre_show_'+lb_switch_dir);

		// older IE iframe bg fix
		if(mg_is_old_IE() && $('#mg_lb_contents .mg_item_featured iframe').length) {
			$('#mg_lb_contents .mg_item_featured iframe').attr('allowTransparency', 'true');
		}

		// init self-hosted videos without poster
		if($('.mg_item_featured .mg_me_player_wrap.mg_self-hosted-video').length && !$('.mg_item_featured .mg_me_player_wrap.mg_self-hosted-video > img').length) {
			mg_video_player('#mg_lb_video_wrap');
		}
		
		// show with a little delay to be smoother
		setTimeout(function() {
			$('#mg_lb_loader').removeClass('mg_lb_shown');
			$mg_lb_contents.attr('class', 'mg_lb_shown').focus();
			$('html').addClass('mg_lb_shown');
			
			lb_is_shown = true;
			lb_switch_dir = false;
		}, 50);
	};
	

	// switch item - arrow click
	$(document).ready(function() {
		$(document).delegate('.mg_nav_active > *', 'click'+mg_generic_touch_event, function(){
			lb_switch_dir = ($(this).parents('.mg_nav_active').hasClass('mg_nav_next')) ? 'next' : 'prev';
			
			var pid = $(this).parents('.mg_nav_active').attr('rel');
			mg_switch_item_act(pid);
		});
	});

	// switch item - keyboards events
	$(document).keydown(function(e){
		if(lb_is_shown) {

			// prev
			if (e.keyCode == 37 && $('.mg_nav_prev.mg_nav_active').length) {
				var pid = $('.mg_nav_prev.mg_nav_active').attr('rel');
				lb_switch_dir = 'prev';
				mg_switch_item_act(pid);
			}

			// next
			if (e.keyCode == 39 && $('.mg_nav_next.mg_nav_active').length) {
				var pid = $('.mg_nav_next.mg_nav_active').attr('rel');
				lb_switch_dir = 'next';
				mg_switch_item_act(pid);
			}
		}
	});


	// switch item - touchSwipe events
	$(document).ready(function() {
		if(typeof(mg_lb_touchswipe) != 'undefined' && mg_lb_touchswipe) {
			
			var swipe_subj = document.getElementById("mg_lb_contents");
			
			new AlloyFinger(swipe_subj, {
				swipe:function(evt){
					if(evt.direction === "Left"){
						if ($('.mg_nav_next.mg_nav_active').length) {
							var pid = $('.mg_nav_next.mg_nav_active').attr('rel');
							mg_switch_item_act(pid);
						}
					}
					else if(evt.direction === "Right"){
						if ($('.mg_nav_prev.mg_nav_active').length) {
							var pid = $('.mg_nav_prev.mg_nav_active').attr('rel');
							mg_switch_item_act(pid);
						}
					}
				}
			});
		}
	});


	// SWITCH ITEM IN LIGHTBOX
	mg_switch_item_act = function(pid) {
		$('#mg_lb_loader').addClass('mg_lb_shown');
		$mg_lb_contents.attr('class', 'mg_lb_switching_'+lb_switch_dir);
		
		$('#mg_lb_top_nav, .mg_side_nav, .mg_lb_nav_side_basic, #mg_top_close').fadeOut(350, function() {
			$(this).remove();
		});

		// wait CSS3 transitions
		setTimeout(function() {
			mg_unload_lb_scripts();
			$mg_lb_contents.empty();
			mg_get_item_content(pid);
			
			lb_is_shown = false;
		}, 500);


	};


	// CLOSE LIGHTBOX
	mg_close_lightbox = function() {
		mg_unload_lb_scripts();
		if(typeof(mg_get_item_ajax) != 'undefined') {mg_get_item_ajax.abort();}
		
		if(typeof(mg_lb_realtime_actions_intval) != 'undefined') {
			clearInterval(mg_lb_realtime_actions_intval);	
		}

		$('#mg_lb_loader').removeClass('mg_lb_shown');
		$mg_lb_contents.attr('class', 'mg_closing_lb');
		
		$('#mg_lb_background').delay(120).removeClass('mg_lb_shown');
		$('#mg_lb_top_nav, .mg_side_nav, #mg_top_close').fadeOut(350, function() {
			$(this).remove();
		});
		
		setTimeout(function() {
			$('#mg_lb_wrap').hide();
			$mg_lb_contents.empty();
			$('#mg_lb_background.google_crawler').fadeOut();

			// restore html/body inline CSS
			if(typeof(mg_html_style) != 'undefined') {$('html').attr('style', mg_html_style);}
			else {$('html').removeAttr('style');}

			if(typeof(mg_body_style) != 'undefined') {$('body').attr('style', mg_body_style);}
			else {$('body').removeAttr('style');}

			if(typeof(mg_scroll_helper_h) != 'undefined') {
				clearTimeout(mg_scroll_helper_h);
			}
			$('#mg_lb_scroll_helper').removeAttr('style');
			
			$mg_lb_contents.attr('class', 'mg_lb_pre_show_next');
			$('html').removeClass('mg_lb_shown');
			
			lb_is_shown = false;
		}, 500); // wait for CSS transitions

		mg_remove_deeplink('item', 'mgi_'+ $mg_sel_grid.data('grid-id') );
	};

	$(document).ready(function() {
		
		$(document).delegate('#mg_lb_background.mg_classic_lb, #mg_lb_scroll_helper.mg_classic_lb, .mg_close_lb', 'click'+mg_generic_touch_event, function(){
			mg_close_lightbox();
		});
	});


	$(document).keydown(function(e){
		if( $('#mg_lb_contents .mg_close_lb').length && e.keyCode == 27 ) { // escape key pressed
			mg_close_lightbox();
		}
	});


	// unload lightbox scripts
	var mg_unload_lb_scripts = function() {
		
		// stop persistent actions
		if(typeof(mg_lb_realtime_actions_intval) != 'undefined') {
			clearInterval(mg_lb_realtime_actions_intval);	
			jQuery('#mg_lb_scroll_helper').css('margin-top', 0);
		}
	};


	// lightbox images lazyload
	mg_lb_lazyload = function() {
		$ll_img = $('.mg_item_featured > div > img, #mg_lb_video_wrap img');
		if( $ll_img.length ) {
			mg_lb_lazyloaded = false;
			$ll_img.fadeTo(0, 0);
			
			$ll_img.lcweb_lazyload({
				allLoaded: function(url_arr, width_arr, height_arr) {
					mg_lb_lazyloaded = {
						urls 	: url_arr,
						widths	: width_arr,
						heights : height_arr	
					};
					
					$ll_img.fadeTo(300, 1);
					$('.mg_item_featured .mg_loader').fadeOut('fast');
					$('.mg_item_featured').mg_item_img_to_kenburns();
					
					if($('#mg_lb_feat_img_wrap').length) {
						$('#mg_lb_feat_img_wrap').fadeTo(300, 1);	
					}
					
					// for video poster
					if( $('#mg_ifp_ol').length )  {
						$('#mg_ifp_ol').delay(300).fadeIn(300);
						setInterval(function() {
							$('#mg_lb_video_wrap > img').css('display', 'block'); // fix for poster image click
						}, 200);
					}

					// for self-hosted video
					if( $('.mg_item_featured .mg_self-hosted-video').length )  {
						$('#mg_lb_video_wrap').fadeTo(0, 0);
						mg_video_player('#mg_lb_video_wrap');
						$('#mg_lb_video_wrap').fadeTo(300, 1);
					}

					// for mp3 player
					if( $('.mg_item_featured .mg_lb_audio_player').length )  {

						var player_id = '#' + $('.mg_lb_audio_player').attr('id');
						mg_audio_player(player_id);

						$('.mg_item_featured .mg_lb_audio_player').fadeIn();
					}
				}
			});
		}
	};


	// lightbox persistent interval actions
	mg_lb_realtime_actions = function() {
		if(typeof(mg_lb_realtime_actions_intval) != 'undefined') {
			clearInterval(mg_lb_realtime_actions_intval);	
		}
		mg_lb_realtime_actions_intval = setInterval(function() {
			var $feat = $('.mg_item_featured');
			
			
			// keep scrollhelper visible
			jQuery('#mg_lb_scroll_helper').css('margin-top', jQuery('#mg_lb_wrap').scrollTop());
			
			
			// if scroller is shown - manage HTML margin and external buttons position
			if($('#mg_lb_contents').outerHeight(true) > $(window).height()) {
				$('#mg_lb_wrap').addClass('mg_lb_has_scroll');
				
				var diff = mg_fullpage_w - $('#mg_lb_scroll_helper').outerWidth(true);
				$('#mg_top_close, .mg_side_nav_next').css('right', diff);
			}
			else {
				$('#mg_lb_wrap').removeClass('mg_lb_has_scroll');
				$('#mg_top_close, .mg_side_nav_next').css('right', 0);
			}
			
			
			// video - prior checks and height calculation
			if($('.mg_lb_video').length) {
				if( $('.mg_item_featured .mg_video_iframe').length ) {	// iframe
					var $video_subj = $('#mg_lb_video_wrap, #mg_lb_video_wrap .mg_video_iframe');
				}
				else { // self-hosted
					var $video_subj = $('.mg_item_featured .mg_self-hosted-video .mejs-container, .mg_item_featured .mg_self-hosted-video video');
				}
				
				var new_video_h = Math.ceil($feat.width() * video_h_ratio);
			}
			
			/////////

			// fill side-layout space if lightbox is smaller than screen's height 
			if($('.mg_lb_feat_match_txt').length && $('#mg_lb_contents').outerHeight(true) < $(window).height() && $(window).width() > 860) {
				var txt_h = $('.mg_item_content').outerHeight();
				
				// remove comments height to avoid bad results
				/*if($('#mb_lb_comments_wrap').length) {
					txt_h = txt_h - $('#mb_lb_comments_wrap').outerHeight('true');	
				}*/
					
					
				// single image and audio
				if(typeof(mg_lb_lazyloaded) != 'undefined' && mg_lb_lazyloaded && !$('.mg_galleria_slider_wrap').length) {
					var player_h = ($('.mg_lb_audio').length) ? $('.mg_lb_audio_player').outerHeight(true) : 0;	
				  
					// calculate what would be original height
					var real_img_h = Math.round((mg_lb_lazyloaded.heights[0] * $feat.width()) / mg_lb_lazyloaded.widths[0]);

					if((real_img_h + player_h) < txt_h && $feat.height() != txt_h) {
						$feat.addClass('mg_lb_feat_matched');
						$feat.find('img').css('height', (txt_h - player_h)).addClass('mg_lb_img_fill');	
					} 
					else if(real_img_h > txt_h) {
						$feat.removeClass('mg_lb_feat_matched');
						$feat.find('img').removeAttr('style').removeClass('mg_lb_img_fill');
					}
				}
			
				// video
				if($('.mg_lb_video').length) {
					if(new_video_h < txt_h) {new_video_h = txt_h;}
					
					if($video_subj.height() != new_video_h) {
						if($('.mg_item_featured .mg_video_iframe').length) {
							$video_subj.attr('height', new_video_h);
						} else {
							$video_subj.css('height', new_video_h).css('max-height', new_video_h).css('min-height', new_video_h);


						}	
					}
				}
				
				// slider 
				if($('.mg_galleria_slider_wrap').length) {
					var new_slider_h = txt_h - parseInt( $('.mg_galleria_slider_wrap').css('padding-bottom'));
				}
				
			}
				
			// normal sizing
			else {
				
				// single image and audio
				if(typeof(mg_lb_lazyloaded) != 'undefined' && mg_lb_lazyloaded && $feat.hasClass('mg_lb_feat_matched')) {
					$feat.removeClass('mg_lb_feat_matched');
					$feat.find('img').removeAttr('style').removeClass('mg_lb_img_fill');	
				}
				
				// video
				if($('.mg_lb_video').length) {
					if($video_subj.height() != new_video_h) {
						if($video_subj.is('div')) {
							$video_subj.css('height', new_video_h).css('max-height', new_video_h).css('min-height', new_video_h);
						} else {
							$video_subj.attr('height', new_video_h);
						}
					}
				}
				
				// slider 
				if($('.mg_galleria_slider_wrap').length) {
					var slider_id = '#'+ $('.mg_galleria_slider_wrap').attr('id');
					var new_slider_h = ($('.mg_galleria_responsive').length) ? Math.ceil($('.mg_galleria_responsive').width() * mg_galleria_height(slider_id)) : mg_galleria_height(slider_id); 
				}
			}
			
			//////////
			
			// slider resizing
			if(typeof(mg_lb_slider) != 'undefined' && typeof(new_slider_h) != 'undefined') {
				if(
					typeof(mg_galleria_h) == 'undefined' ||
					mg_galleria_h != new_slider_h || 
					$('.mg_galleria_slider_wrap').width() != $('.galleria-stage').width()
				) { 
					if(typeof(mg_slider_is_resizing) == 'undefined' || !mg_slider_is_resizing)  {
						mg_galleria_h = new_slider_h; 
						resize_galleria(new_slider_h);
					}
				}
			}
			
			// hook for customizations
			$(window).trigger('mg_lb_realtime_actions');
		}, 20);
	};



	////////////////////////////////////////////////



	// get URL query vars and returns them into an associative array
	var get_url_qvars = function() {
		mg_hashless_url = decodeURIComponent(window.location.href);
		
		if(mg_hashless_url.indexOf('#') !== -1) {
			var hash_arr = mg_hashless_url.split('#');
			mg_hashless_url = hash_arr[0];
			mg_url_hash = '#' + hash_arr[1];
		}
		
		// detect
		var qvars = {};
		var raw = mg_hashless_url.slice(mg_hashless_url.indexOf('?') + 1).split('&');
		
		$.each(raw, function(i, v) {
			var arr = v.split('=');
			qvars[arr[0]] = arr[1];
		});	
		
		return qvars;
	};
	
	
	// create slug from a string - for better deeplinked urls
	var string_to_slug = function(str) {
		str = str.replace(/^\s+|\s+$/g, ''); // trim
		str = str.toLowerCase();
		
		// remove accents, swap ñ for n, etc
		var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
		var to   = "aaaaeeeeiiiioooouuuunc------";
		for (var i=0, l=from.length ; i<l ; i++) {
		  str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
		}
		
		str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
		  .replace(/\s+/g, '-') // collapse whitespace and replace by -
		  .replace(/-+/g, '-'); // collapse dashes
		
		return str;
	}


	/*
	 * Global function to set media grid deeplinks
	 *
	 * key (string) - the subject - to know if it has to be deeplinked (item, category, search, page)
	 * subj (string) - attribute name
	 * val (int) - deeplink value (cat ID - item ID - etc)
	 * txt (string) - optional value to attach a text to value 
	 */
	mg_set_deeplink = function(key, subj, val, txt) {
		if(!mg_deeplinked_elems.length || $.inArray(key, mg_deeplinked_elems) === -1) {return false;}
		
		var qvars = get_url_qvars(); // get query vars and set clean URL + eventual hash 

		// setup deeplink part
		var true_val = (typeof(txt) != 'undefined' && txt) ? val +'/'+ string_to_slug(txt) : val;
		var dl_part = subj +'='+ true_val + mg_url_hash;
		
		
		// if URL doesn't have attributes
		if(mg_hashless_url.indexOf('?') === -1) {
			history.pushState(null, null, mg_hashless_url +'?'+ dl_part);
		}
		else {

			// if new deeplink already exists

			if(typeof(qvars[subj]) != 'undefined' && qvars[subj] == true_val) {
				return true;	
			}
			
			// re-compose URL
			var new_url = mg_hashless_url.slice(0, mg_hashless_url.indexOf('?') + 1);

			// (if found) discard attribute to be set
			var a = 0;
			var has_other_qvars = false;
			var this_attr_exists = false;
			
			$.each(qvars, function(i, v) {
				if(typeof(i) == 'undefined') {return;}
				if(a > 0) {new_url += '&';}
				
				if(i != subj) {
					new_url += (v) ? i+'='+v : i; 
					
					has_other_qvars = true;
					a++;	

				}
				else {
					this_attr_exists = true;	
				}
			});
				
			if(has_other_qvars) {new_url += '&';}		
			new_url += dl_part;


			if(mg_deeplinked && this_attr_exists && !mg_full_deeplinking) { 
				history.replaceState(null, null, new_url);
			} else {
				history.pushState(null, null, new_url);	
				mg_deeplinked = true;
			}
		}
	};


	// apply deeplink to page grids
	mg_apply_deeplinks = function(on_init) {
		var qvars = get_url_qvars();
		
		$.each(qvars, function(subj, val) {
			if(typeof(val) == 'undefined') {return;}
			var gid = subj.substr(4);
			
			// clean texts from deeplinked val
			var raw_val = val.split('/');
			val = raw_val[0]; 
			
			
			
			// at the moment - no actions on init except search
			if(!on_init) {
			
				// item deeplink - not on first init
				if(subj.indexOf('mgi_') !== -1) {
					
					// check item existence
					if(!$('#mg_grid_'+ gid +' .mg_closed.mgi_'+ val).length) {return;}
					
					// if lightbox is already opened
					if($('.mg_item_content').length) {
	
						// grid item is already shown?
						if($('#mg_lb_wrap').data('item-id') == val && $('#mg_lb_wrap').data('grid-id') == gid) {return;}
	
						// unload lightbox
						$mg_sel_grid = $('#mg_grid_'+gid);
						$('#mg_lb_loader').addClass('mg_lb_shown');
						mg_get_item_content(val);
					}
					
					else {
						// simulate click on item
						$('#mg_grid_'+ gid +' .mgi_'+ val).trigger('click');
					}
				}
				
				// category deeplink - not on first init
				if(subj.indexOf('mgc_') !== -1) {
					var $f_subj = (val == '*') ? $('#mgf_'+ gid +' .mgf_all') : $('#mgf_'+ gid +' .mgf_id_'+ val);
					
					// check filter existence
					if(!$f_subj.not('.mg_cats_selected').length) {return;}
					$f_subj.trigger('click');
				}
				
				// pagination deeplink - not on first init
				if(subj.indexOf('mgp_') !== -1 && $('#mgp_'+gid).length) {
					if(typeof(mg_grid_pag['mg_grid_' + gid ]) == 'undefined' || mg_grid_pag['mg_grid_' + gid ] == val) {return;}
					
					var subj = (mg_grid_pag['mg_grid_' + gid ] > val) ? '.mg_prev_page' : '.mg_next_page'; 
					$('#mgp_'+gid+' '+subj).not('.mg_pag_disabled').trigger('click');
				}
				
			}
				
			
			// search deeplink
			if(subj.indexOf('mgs_') !== -1) {
				if(typeof(on_init) == 'undefined') {
					$('#mgs_'+ gid+' input').val(decodeURIComponent(val)).submit();
				} else {
					setTimeout(function() {
						$('#mgs_'+ gid+' input').submit();
					}, 20);	
				}
			}
		});
		
				
		// step back from opened lightbox
		if(mg_hashless_url.indexOf('mgi_') === -1 && $('.mg_item_content').length) {
			$('.mg_close_lb').trigger('click');	
		}	
		
		// step back for each grid
		$('.mg_grid_wrap').each(function() {
			var gid = $(this).attr('id').substr(8);

			// from category deeplink
			var $mgc = $(this).find('.mg_cats_selected');
			if(mg_hashless_url.indexOf('mgc_'+gid) === -1 && $mgc.length && !$mgc.hasClass('mg_def_filter')) {
				$(this).find('.mg_def_filter').trigger('click');	
			}
			
			// from pagination
			if(mg_hashless_url.indexOf('mgp_'+gid) === -1 && $('#mgp_'+gid).length && $('#mgs_'+ gid+' input').val()) {
				mavo_to_pag_1(gid, $('#mgp_'+gid+' .mg_prev_page'));
			}
			
			// from search
			if(mg_hashless_url.indexOf('mgs_'+gid) === -1 && $('#mgs_'+gid).length && $('#mgs_'+ gid+' input').val()) {
				$('#mgs_'+ gid+' input').val('').submit();
			}
		});
	};
	
	
	// remove deeplink - check mg_set_deeplink() legend to know more about params
	mg_remove_deeplink = function(key, subj) {
		if(!mg_deeplinked_elems.length || $.inArray(key, mg_deeplinked_elems) === -1) {return false;}
		
		var qvars = get_url_qvars();
		if(typeof(qvars[subj]) == 'undefined') {return false;}
		
		// discard attribute to be removed
		var parts = [];
		$.each(qvars, function(i, v) {
			if(typeof(i) != 'undefined' && i && i != subj) {
				var val = (v) ? i+'='+v : i;
				parts.push(val);	
			}
		});
		
		var qm = (parts.length) ? '?' : '';	
		var new_url = mg_hashless_url.slice(0, mg_hashless_url.indexOf('?')) + qm + parts.join('&') + mg_url_hash;

		history.pushState(null, null, new_url);	
		
		if(mg_hashless_url.indexOf('mgi_') === -1 && mg_hashless_url.indexOf('mgc_') === -1 && mg_hashless_url.indexOf('mgp_') === -1 && mg_hashless_url.indexOf('mgs_') === -1) {
			mg_deeplinked = false;
		}	
	};
	
	
	// detect URL changes
	window.onpopstate = function(e) {
		mg_apply_deeplinks();
		
		if(mg_hashless_url.indexOf('mgi_') === -1 && mg_hashless_url.indexOf('mgc_') === -1 && mg_hashless_url.indexOf('mgp_') === -1 && mg_hashless_url.indexOf('mgs_') === -1) {
			mg_deeplinked = false;
		}
	};
	
	
	
	////////////////////////////////////////////////////////////////
	// initialize inline sliders 
	mg_inl_slider_init = function(sid) {
		$('#'+sid).lc_micro_slider({
			slide_fx 		: mg_inl_slider_fx,
			slide_easing	: mg_inl_slider_easing,
			touchswipe		: mg_inl_slider_touch,
			slideshow_cmd	: mg_inl_slider_play_btn,
			autoplay		: false,
			animation_time	: mg_inl_slider_fx_time,
			slideshow_time	: mg_inl_slider_intval,
			pause_on_hover	: mg_inl_slider_pause_on_h,
			loader_code		: mg_loader,
			nav_dots		: false,
			debug			: false
		});
		
		// autoplay here - to be run also on filters
		if( $('#'+sid).hasClass('mg_autoplay_slider') ) {
			$('#'+sid).lcms_start_slideshow();
		}
    };
	
	
	// turns item's image into a ken burns slider
	$.fn.mg_item_img_to_kenburns = function() {
		this.find('.mg_kenburnsed_item').lc_micro_slider({
			slideshow_time	: mg_kenburns_timing,
			pause_on_hover	: false,
			slideshow_cmd	: false,
			nav_dots		: false,
			nav_arrows		: false,
			loader_code		: mg_loader,
			debug			: false
		});
	};

	
	//// ken burns effect
	// catch event	
	$(document).ready(function() {
		$('body').delegate('.mg_kenburns_slider', 'lcms_initial_slide_shown lcms_new_active_slide', function(e, slide_index) {	
			var $subj = $(this).find('.lcms_slide[rel='+slide_index+'] .lcms_bg');
			var time = $(this).data('lcms_settings').slideshow_time;

			$subj.css('transition-duration', (time / 1000)+'s');	
			mg_lcms_apply_kenburns_css($subj, time);
		});
	});
	
	
	// apply css for kenburns
	var mg_lcms_apply_kenburns_css = function($subj, time) {
		if(!$subj.length) {return false;}
		
		vert_prop = mg_lcms_kenburns_size_prop('vert');
		horiz_prop = mg_lcms_kenburns_size_prop('horiz');
		var props = {};	
			
		if($subj.hasClass('mg_lcms_kb_zoomed')) {
			props['top']	= '0';
			props['right'] 	= '0';
			props['bottom'] = '0';
			props['left'] 	= '0';
				
			$subj.removeClass('mg_lcms_kb_zoomed');
		}
		else {
			props[ vert_prop ] 	= '-25%';
			props[ horiz_prop ] = '-25%';

			$subj.addClass('mg_lcms_kb_zoomed');
		}
		
		props['background-position'] = mg_lcms_kenburns_bgpos_prop() +' '+ mg_lcms_kenburns_bgpos_prop();
		$subj.css(props);
		
		setTimeout(function() {
			mg_lcms_apply_kenburns_css($subj, time, vert_prop, horiz_prop);
		}, time);
	};
	
	// get random value for random direction
	var mg_lcms_kenburns_size_prop = function(direction) {
	   var vals = (direction == 'horiz') ? ["left", "right"] : ["top", "bottom"];
	   return vals[Math.floor(Math.random() * vals.length)];
	};
	
	var mg_lcms_kenburns_bgpos_prop = function() {
	   var vals = ['0%', '100%'];
	   return vals[Math.floor(Math.random() * vals.length)];
	};
	
	


	///////////////////////////////////////////////////////////////////////////
	// galleria slider functions

	// manage slider initial appearance
	mg_galleria_show = function(sid) {
		setTimeout(function() {
			if( $(sid+' .galleria-stage').length) {
				$(sid).removeClass('mg_show_loader');
				$(sid+' .galleria-container').fadeTo(400, 1);
			} else {
				mg_galleria_show(sid);
			}
		}, 50);
	};


	// manage the slider proportions on resize
	mg_galleria_height = function(sid) {
		if( $(sid).hasClass('mg_galleria_responsive')) {
			return parseFloat( $(sid).data('asp-ratio') );
		} else {
			return parseInt($(sid).data('slider-h'));
		}
	};


	var resize_galleria = function(new_h) {
		mg_slider_is_resizing = setTimeout(function() {
			$('.mg_galleria_slider_wrap, .galleria-container').css('min-height', new_h);
			
			setTimeout(function() {
				mg_lb_slider.resize();	
			}, 500);
			
			mg_slider_is_resizing = false;
		}, 20);

	};



	// Initialize Galleria
	mg_galleria_init = function(sid, inline_slider) {
		Galleria.run(sid, {
			theme				: 'mediagrid',
			height				: ($('.mg_lb_feat_match_txt').length && $(window).width() > 860) ? $('.mg_item_content').outerHeight() : mg_galleria_height(sid),
			swipe				: true,
			thumbnails			: true,
			transition			: mg_galleria_fx,
			fullscreenDoubleTap	: false,
			responsive			: false,
			wait				: true,

			initialTransition	: 'flash',
			transitionSpeed		: mg_galleria_fx_time,
			imageCrop			: mg_galleria_img_crop,
			extend				: function() {
				mg_lb_slider = this;
				$(sid+' .galleria-loader').append(mg_loader);

				if(typeof(mg_slider_autoplay[sid]) != 'undefined' && mg_slider_autoplay[sid]) {
					$(sid+' .galleria-mg-play').addClass('galleria-mg-pause');
					mg_lb_slider.play(mg_galleria_interval);
				}

				// play-pause
				$(sid+' .galleria-mg-play').click(function() {
					$(this).toggleClass('galleria-mg-pause');
					mg_lb_slider.playToggle(mg_galleria_interval);
				});

				// thumbs navigator toggle
				$(sid+' .galleria-mg-toggle-thumb').click(function() {
					var $mg_slider_wrap = $(this).parents('.mg_galleria_slider_wrap');


					if( $mg_slider_wrap.hasClass('galleria-mg-show-thumbs') || $mg_slider_wrap.hasClass('mg_galleria_slider_show_thumbs') ) {
						$mg_slider_wrap.stop().animate({'padding-bottom' : '0px'}, 400);
						$mg_slider_wrap.find('.galleria-thumbnails-container').stop().animate({'bottom' : '10px', 'opacity' : 0}, 400);

						$mg_slider_wrap.removeClass('galleria-mg-show-thumbs');
						if( $mg_slider_wrap.hasClass('mg_galleria_slider_show_thumbs') ) {
							$mg_slider_wrap.removeClass('mg_galleria_slider_show_thumbs');
						}
					}
					else {
						$mg_slider_wrap.stop().animate({'padding-bottom' : '56px'}, 400);
						$mg_slider_wrap.find('.galleria-thumbnails-container').stop().animate({'bottom' : '-60px', 'opacity' : 1}, 400);

						$mg_slider_wrap.addClass('galleria-mg-show-thumbs');
					}
				});
			}
		});
	};
	
	
	// hide caption if play a slider video
	$(document).ready(function() {
		$('body').delegate('.mg_galleria_slider_wrap .galleria-images', 'click', function(e) {
			setTimeout(function() {
				if( $('.mg_galleria_slider_wrap .galleria-image:first-child .galleria-frame').length) {
					$('.mg_galleria_slider_wrap .galleria-stage .galleria-info-text').slideUp();	
				}
			}, 500);
		});
	});



	//////////////////////////////////////////////////////////////////
	// mediaelement audio/video player functions

	// init video player
	mg_video_player = function(player_id, is_inline) {
		if(!$(player_id).length) {return false;}
		
		// wait until mediaelement script is loaded
		if(typeof(MediaElementPlayer) != 'function') {
			setTimeout(function() {
				mg_video_player(player_id, is_inline);
			}, 50);
			return false;
		}

		if(typeof(is_inline) == 'undefined') {
			var features = ['playpause','current','progress','duration','volume','fullscreen'];
		} else {
			var features = ['playpause','current','progress','volume','fullscreen'];
		}
		
		var player_obj = new MediaElementPlayer(player_id+' video',{
			audioVolume: 'vertical',
			startVolume: 1,
			features: features
		});
		
		mg_player_objects[player_id] = player_obj;
		
		// autoplay
		if($(player_id).hasClass('mg_video_autoplay')) {
			if(typeof(is_inline) == 'undefined') {
				player_obj.play();
			} 
			else {
				setTimeout(function() {
					if(!$(player_id).parents('.mg_box').hasClass('isotope-hidden')) {
						var delay = setInterval(function() {
							if($(player_id).parents('.mg_box').hasClass('mg_shown')) {
								player_obj.play();	
								clearInterval(delay);
							}
						}, 50);
					}
				}, 100);
			}
		}
	};


	// store player playlist and the currently played track - init player
	mg_audio_player = function(player_id, is_inline) {
		
		// wait until mediaelement script is loaded
		if(typeof(MediaElementPlayer) != 'function') {
			setTimeout(function() {
				mg_audio_player(player_id, is_inline);
			}, 50);
			return false;
		}
		
		// if has multiple tracks
		if($(player_id).find('source').length > 1) {

			mg_audio_tracklists[player_id] = [];
			$(player_id).find('source').each(function(i, v) {
                mg_audio_tracklists[player_id].push( $(this).attr('src') );
            });

			if(typeof(is_inline) == 'undefined') {
				var features = ['mg_prev','playpause','mg_next','current','progress','duration','mg_loop','volume','mg_tracklist'];
			} else {
				var features = ['mg_prev','playpause','mg_next','current','progress','mg_loop','volume','mg_tracklist'];
			}

			var success_function = function (player, domObject) {
				player.addEventListener('ended', function (e) {
					var player_id = '#' + $(this).parents('.mg_me_player_wrap').attr('id');
					mg_audio_go_to(player_id, 'next', true);
				}, false);
			};
		}

		else {
			var features = ['playpause','current','progress','duration','mg_loop','volume'];
			var success_function = function() {};
		}


		// init
		var player_obj = new MediaElementPlayer(player_id+' audio',{
			audioVolume: 'vertical',
			startVolume: 1,
			features: features,
			loop: mg_audio_loop,
			success: success_function,
			alwaysShowControls: true
		});

		mg_player_objects[player_id] = player_obj;
		mg_audio_is_playing[player_id] = 0;

		// autoplay
		if($(player_id).hasClass('mg_audio_autoplay')) {
			player_obj.play();
		}
	};


	// go to track - prev / next / track_num
	mg_audio_go_to = function(player_id, direction, autonext) {
		var t_list = mg_audio_tracklists[player_id];
		var curr = mg_audio_is_playing[player_id];


		if(direction == 'prev') {
			var track_num = (!curr) ? (t_list.length - 1) : (curr - 1);
			var track_url = t_list[track_num];
			mg_audio_is_playing[player_id] = track_num;
		}
		else if(direction == 'next') {
			// if hasn't tracklist and loop is disabled, stop
			if(typeof(autonext) != 'undefined' && !$(player_id+' .mejs-mg-loop-on').length) {
				return false;
			}

			var track_num = (curr == (t_list.length - 1)) ? 0 : (curr + 1);
			var track_url = t_list[track_num];
			mg_audio_is_playing[player_id] = track_num;
		}
		else {
			var track_url = t_list[(direction - 1)];
			mg_audio_is_playing[player_id] = (direction - 1);
		}

		// set player to that url
		var $subj = mg_player_objects[player_id];
		$subj.pause();
		$subj.setSrc(track_url);
		$subj.play();

		// set tracklist current track
		$(player_id +'-tl li').removeClass('mg_current_track');
		$(player_id +'-tl li[rel='+ (mg_audio_is_playing[player_id] + 1) +']').addClass('mg_current_track');
	};
	
	
	// initialize inline audio player
	var init_inl_audio = function(player_id, autoplay) {
		mg_audio_player(player_id, true);
		
		$(player_id).addClass('mg_inl_audio_shown');
		
		// enable playlist
		if($(player_id+'-tl').length) {
			$(player_id+'-tl').show();	
		}
		
		// autoplay
		setTimeout(function() {
			mg_check_inl_audio_icons_vis();
			
			if(typeof(autoplay) != 'undefined') {
				var player_obj = mg_player_objects[player_id];
				player_obj.play();		
			}
		}, 300);
	};
	

	// add custom mediaelement buttons
	$(document).ready(function(e) {
		mg_mediael_add_custom_functions();
	});
	
	var mg_mediael_add_custom_functions = function() {
		
		// wait until mediaelement script is loaded
		if(typeof(MediaElementPlayer) != 'function') {
			setTimeout(function() {
				mg_mediael_add_custom_functions();
			}, 50);
			return false;
		}
		
		
		// prev
		MediaElementPlayer.prototype.buildmg_prev = function(player, controls, layers, media) {
			var prev = $('<div class="mejs-button mejs-mg-prev" title="previous track"><button type="button"></button></div>')
			// append it to the toolbar
			.appendTo(controls)
			// add a click toggle event
			.click(function() {
				var player_id = '#' + $('#'+player.id).parent().attr('id');
				mg_audio_go_to(player_id, 'prev');
			});
		}

		// next
		MediaElementPlayer.prototype.buildmg_next = function(player, controls, layers, media) {
			var prev = $('<div class="mejs-button mejs-mg-next" title="previous track"><button type="button"></button></div>')
			// append it to the toolbar
			.appendTo(controls)
			// add a click toggle event
			.click(function() {
				var player_id = '#' + $('#'+player.id).parent().attr('id');
				mg_audio_go_to(player_id, 'next');
			});
		}

		// tracklist toggle
		MediaElementPlayer.prototype.buildmg_tracklist = function(player, controls, layers, media) {
			var tracklist =
			$('<div class="mejs-button mejs-mg-tracklist-button ' +
				(($('#'+player.id).parent().hasClass('mg_show_tracklist')) ? 'mejs-mg-tracklist-on' : 'mejs-mg-tracklist-off') + '" title="'+
				(($('#'+player.id).parent().hasClass('mg_show_tracklist')) ? 'hide' : 'show') +' tracklist"><button type="button"></button></div>')
			// append it to the toolbar
			.appendTo(controls)
			// add a click toggle event
			.click(function() {
				if ($('#'+player.id).find('.mejs-mg-tracklist-on').length) {
					$('#'+player.id).parents('.mg_media_wrap').find('.mg_audio_tracklist').removeClass('mg_iat_shown');
					tracklist.removeClass('mejs-mg-tracklist-on').addClass('mejs-mg-tracklist-off').attr('title', 'show tracklist');
				} 
				else {
					$('#'+player.id).parents('.mg_media_wrap').find('.mg_audio_tracklist').addClass('mg_iat_shown');
					tracklist.removeClass('mejs-mg-tracklist-off').addClass('mejs-mg-tracklist-on').attr('title', 'hide tracklist');
				}
			});
		}

		// loop toggle
		MediaElementPlayer.prototype.buildmg_loop = function(player, controls, layers, media) {
			var loop =
			$('<div class="mejs-button mejs-mg-loop-button ' +
				((player.options.loop) ? 'mejs-mg-loop-on' : 'mejs-mg-loop-off') + '" title="'+
				((player.options.loop) ? 'disable' : 'enable') +' loop"><button type="button"></button></div>')
			// append it to the toolbar
			.appendTo(controls)
			// add a click toggle event
			.click(function() {
				player.options.loop = !player.options.loop;
				if (player.options.loop) {
					loop.removeClass('mejs-mg-loop-off').addClass('mejs-mg-loop-on').attr('title', 'disable loop');
				} else {
					loop.removeClass('mejs-mg-loop-on').addClass('mejs-mg-loop-off').attr('title', 'enable loop');
				}
			});
		}
	};


	// change track clicking on tracklist
	$(document).ready(function(e) {
        $(document).delegate('.mg_audio_tracklist li:not(.mg_current_track)', 'click'+mg_generic_touch_event, function() {
			var player_id = '#' + $(this).parents('ol').attr('id').replace('-tl', '');
			var num = $(this).attr('rel');

			mg_audio_go_to(player_id, num);
		});
    });

	
	// pause inline players and inl text's video bg and sliders
	mg_pause_inl_players = function(grid_id) {
		var $subj = $('#'+ grid_id+' .mg-muuri-hidden, #'+ grid_id+' .mgi_low_opacity_f');
		
		// audio/video player
		$subj.find('.mg_sh_inl_video, .mg_inl_audio_player').each(function() {
			if( typeof(mg_player_objects) != 'undefined' && typeof( mg_player_objects[ '#' + this.id ] ) != 'undefined') {
				var $subj = mg_player_objects[ '#' + this.id ];
				$subj.pause();
			}
		});	
		
		// inline text's video bg
		$subj.find('.mg_inl_txt_video_bg').each(function() {
			var video = jQuery(this)[0];
			video.pause();
		});	
		
		// inline slider
		$subj.find('.mg_inl_slider_wrap').each(function() { 
		   $('#'+ $(this).attr('id') ).lcms_stop_slideshow();
        });
	};

	
	// adjust players size
	var mg_adjust_inl_player_size = function(item_id) {
		var $subj = (typeof(item_id) != 'undefined') ? $(item_id) : $('.mg_inl_audio_player, .mg_sh_inl_video');
		mg_check_inl_audio_icons_vis();
		
		$subj.each(function() {
			if(typeof(mg_player_objects) != 'undefined' && typeof(mg_player_objects[ '#' + this.id ]) != 'undefined') {
				
				var player = mg_player_objects[ '#' + this.id ];
				player.setControlsSize();
			}
		});	
	};
	
	
	// hide audio player commands in tiny items
	var mg_check_inl_audio_icons_vis = function() {
		$('.mg_inl_audio').not('.mg-muuri-hidden').each(function() {
			if( $(this).find('.img_wrap').width() >= 195) {
				$(this).find('.img_wrap > div').css('overflow', 'visible');	
			} else {
				$(this).find('.img_wrap > div').css('overflow', 'hidden');	
			}
		});
	};
	



	/////////////////////////////////////////////////////////////
	// UTILITIES

	function mg_responsive_txt(gid) {
		var $subj = $('#'+gid+ ' .mg_inl_txt_rb_txt_resize .mg_inl_txt_contents').find('p, b, div, span, strong, em, i, h6, h5, h4, h3, h2, h1');

		// setup original text sizes and reset
		$('#'+gid+' .mg_inl_txt_wrap').removeClass('mg_it_resized');
		$subj.each(function() {
			if(typeof( $(this).data('orig-size') ) == 'undefined') {
				$(this).data('orig-size', $(this).css('font-size'));
				$(this).data('orig-lheight', $(this).css('line-height'));
			}

			// reset
			$(this).removeClass('mg_min_reached mg_inl_txt_top_margin_fix mg_inl_txt_btm_margin_fix mg_inl_txt_top_padding_fix mg_inl_txt_btm_padding_fix');
			$(this).css('font-size', $(this).data('orig-size'));
			$(this).css('line-height', $(this).data('orig-lheight'));
        });

		$('#'+gid+ ' .mg_inl_txt_contents').each(function() {

			// not for auto-height
			if(
				(!mg_mobile_mode[gid] && !$(this).parents('.mg_box').hasClass('mgis_h_auto')) ||
				(mg_mobile_mode[gid] && !$(this).parents('.mg_box').hasClass('mgis_m_h_auto'))
			) {
				var max_height = $(this).parents('.mg_media_wrap').height();

				if(max_height < $(this).outerHeight()) {
					$('#'+gid+' .mg_inl_txt_wrap').addClass('mg_it_resized');
					
					var a = 0;
					while( max_height < $(this).outerHeight()) {
						if(a == 0) {
							// check and eventually reduce big margins and paddings at first
							$subj.each(function(i, v) {
								if( parseInt($(this).css('margin-top')) > 10 ) {$(this).addClass('mg_inl_txt_top_margin_fix');}
								if( parseInt($(this).css('margin-bottom')) > 10 ) {$(this).addClass('mg_inl_txt_btm_margin_fix');}

								if( parseInt($(this).css('padding-top')) > 10 ) {$(this).addClass('mg_inl_txt_top_padding_fix');}
								if( parseInt($(this).css('padding-bottom')) > 10 ) {$(this).addClass('mg_inl_txt_btm_padding_fix');}
							});
						}
						else {
							$subj.each(function(i, v) {
								var new_size = parseFloat( $(this).css('font-size')) - 1;
								if(new_size < 11) {new_size = 11;}

								var new_lheight = parseInt( $(this).css('line-height')) - 1;
								if(new_lheight < 14) {new_lheight = 14;}

								$(this).css('font-size', new_size).css('line-height', new_lheight+'px');

								if(new_size == 11 && new_lheight == 14) { // resizing limits
									$(this).addClass('mg_min_reached');
								}
							});

							// if any element has reached min size
							if( $('#'+gid+ ' .mg_inl_txt_contents .mg_min_reached').length ==  $subj.length) {
								return false;
							}
						}

						a++;
					}
				}
			}
        });
	};


	// webkit transformed items rendering fix
	var webkit_blurred_elems_fix = function(grid_id) {
		if('WebkitAppearance' in document.documentElement.style) {
			$('#mg_wbe_fix_'+grid_id).remove();
	
			setTimeout(function() {
				$('head').append('<style type="text/css" id="mg_wbe_fix_'+ grid_id +'">.mg_'+grid_id+' .mg_box_inner {-webkit-font-smoothing: subpixel-antialiased;}</style>');
			}, 600);
		}
	};


	// check for touch device
	function mg_is_touch_device() {
		return !!('ontouchstart' in window);
	};


	// check if the browser is IE8 or older
	function mg_is_old_IE() {
		if( navigator.appVersion.indexOf("MSIE 8.") != -1 ) {return true;}
		else {return false;}
	};
	
	
	// facebook direct contents share
	mg_fb_direct_share = function(url, title, txt, img) {
		FB.ui({
			method: 'share_open_graph',
			action_type: 'og.shares',
			action_properties: JSON.stringify({
				object: {
					'og:url'		: url,
					'og:title'		: title,
					'og:description': txt,
					'og:image'		: img,
				}
			})
		},
		function (response) {
			window.close();
		});			
	};

})(jQuery);
(function(){
	var mg_H = 520;
	var mg_W = 570;
	
	
	// show lightbox on icon's click
	jQuery(document).ready(function(e) {
		jQuery(document).undelegate('#mg_scw_btn', "click").delegate('#mg_scw_btn', "click", function () {
			$mg_scw_editor_wrap = jQuery(this).parents('.wp-editor-wrap');
			
			jQuery.magnificPopup.open({
				items : {
					src: '#mediagrid_sc_wizard > *',
					type: 'inline'
				},
				mainClass	: 'mg_sc_wizard_lb',
				closeOnContentClick	: false,
				closeOnBgClick		: false, 
				preloader	: false,
				callbacks	: {
				  beforeOpen: function() {
					if(jQuery(window).width() < 800) {
					  this.st.focus = false;
					}
				  },
				  open : function() {
					  
					mg_live_chosen();	
					mg_live_checks(); 
					mg_mce_colpick(); 
					
					
					// tabify through select
					var lb_class = ".mg_sc_wizard_lb"
					
					jQuery(lb_class+' .lcwp_scw_choser option').each(function() {
						var val = jQuery(this).attr('value');
						
						if(!jQuery(this).is(':selected')) {
							jQuery(lb_class +' '+ val).hide();	
						} else {
							jQuery(lb_class +' '+ val).show();		
						}
					});
					
					// on select change
					jQuery(lb_class).delegate('.lcwp_scw_choser', 'change', function(e) {
						e.preventDefault();
						
						jQuery(lb_class+' .lcwp_scw_choser option').each(function() {
							var val = jQuery(this).attr('value');
						
							if(!jQuery(this).is(':selected')) {
								jQuery(lb_class +' '+ val).hide();	
							} else {
								jQuery(lb_class +' '+ val).show();		
							}
						});
					});
				  }
				}
			});
			jQuery(document).delegate('.mfp-wrap.mg_sc_wizard_lb', 'click', function(e) {
				if(jQuery(e.target).hasClass('mfp-container')) {
					jQuery.magnificPopup.close();
				}
			});
		});
	});



	////////////////////////////////////////////////////



	// colorpicker
	function mg_mce_colpick() {
		jQuery('.mg_tinymce_lb_wrap .lcwp_colpick input').each(function() {
			var curr_col = jQuery(this).val().replace('#', '');
			jQuery(this).colpick({
				layout:'rgbhex',
				submit:0,
				color: curr_col,
				onChange:function(hsb,hex,rgb, el, fromSetColor) {
					if(!fromSetColor){ 
						jQuery(el).val('#' + hex);
						jQuery(el).parents('.lcwp_colpick').find('.lcwp_colblock').css('background-color','#'+hex);
					}
				}
			}).keyup(function(){
				jQuery(this).colpickSetColor(this.value);
				jQuery(this).parents('.lcwp_colpick').find('.lcwp_colblock').css('background-color', this.value);
			});  
		});
	}


	// toggle fields related to filters
	jQuery(document).delegate('.mg_sc_wizard_lb #mg_filter_grid', 'lcs-statuschange', function() {
		if( jQuery(this).is(':checked') ) {
			jQuery('.mg_scw_ff').slideDown('fast');	
		} else {
			jQuery('.mg_scw_ff').slideUp('fast');	
		}
	});
	



	////////////////////////////////////////////////////////
	///// shortcode insertion
	
	jQuery(document).delegate('.mg_sc_insert_grid', "click", function (e) {
		var $subj = jQuery('.mg_sc_wizard_lb');
		
		var gid = $subj.find('#mg_grid_choose').val();
		var sc = '[mediagrid gid="'+gid+'"';
		
		//  titles under
		if( $subj.find('#mg_title_under').val() != 0) {
			sc += ' title_under="'+ $subj.find('#mg_title_under').val() +'"';
		}
		
		//  pagination system
		if( $subj.find('#mg_pag_sys').val() ) {
			sc += ' pag_sys="'+ $subj.find('#mg_pag_sys').val() +'"';
		}
		
		//  search bar
		if( $subj.find('#mg_search_bar').is(':checked') ) {
			sc += ' search="1"';
		}

		// filter
		if( $subj.find('#mg_filter_grid').is(':checked') ) {
			var filter = 1;
			sc += ' filter="'+filter+'"';
		} 
		else {var filter = 0;}
		
		
		// filter options
		if(filter) {
			// hide "all" filter
			if( $subj.find('#mg_filters_align').val() != 'top' ) {
				sc += ' filters_align="'+ $subj.find('#mg_filters_align').val() +'"';
			}
			
			// hide "all" filter
			if( $subj.find('#mg_hide_all').is(':checked') ) {
				sc += ' hide_all="1"';
			}
			
			// select default filter
			if( $subj.find('#mg_def_filter').val() != '' ) {
				sc += ' def_filter="'+ $subj.find('#mg_def_filter').val() +'"';
			}
		}
		
		// custom mobile treshold
		var cmt = parseInt(jQuery('#mg_mobile_treshold').val(), 10);
		if(cmt) {
			sc += ' mobile_tresh="'+ cmt +'"';	
		}


		////////////////////////////////////////////
		
		
		// custom cells margin
		if($subj.find('#mg_cells_margin').val() != '') {
			sc += ' cell_margin="'+ parseInt($subj.find('#mg_cells_margin').val()) +'"';	
		}
		
		// custom borders width
		if($subj.find('#mg_border_w').val() != '') {
			sc += ' border_w="'+ parseInt($subj.find('#mg_border_w').val()) +'"';	
		}
		
		// custom borders color
		if($subj.find('#mg_border_color').val() != '') {
			sc += ' border_col="'+ $subj.find('#mg_border_color').val() +'"';	
		}
		
		// custom border radius
		if($subj.find('#mg_cells_radius').val() != '') {
			sc += ' border_rad="'+ parseInt($subj.find('#mg_cells_radius').val()) +'"';	
		}
		
		// custom outline display
		if($subj.find('#mg_outline').val() != '') {
			sc += ' outline="'+ parseInt($subj.find('#mg_outline').val()) +'"';	
		}
		
		// custom outline color
		if($subj.find('#mg_outline_color').val() != '') {
			sc += ' outline_col="'+ $subj.find('#mg_outline_color').val() +'"';	
		}

		// custom shadow display
		if($subj.find('#mg_shadow').val() != '') {
			sc += ' shadow="'+ parseInt($subj.find('#mg_shadow').val()) +'"';	
		}

		// custom outline color
		if($subj.find('#mg_txt_under_color').val() != '') {
			sc += ' txt_under_col="'+ $subj.find('#mg_txt_under_color').val() +'"';	
		}


		///// OVERLAY MANAGER ADD-ON ///////////
		////////////////////////////////////////
		if($subj.find('#mg_custom_overlay').length && $subj.find('#mg_custom_overlay').val()) {
			sc += ' overlay="'+ $subj.find('#mg_custom_overlay').val() +'"';	
		}
		////////////////////////////////////////



		// allow add-ons to inject parameters into the shortcode
		mg_sc = sc;
		jQuery(window).trigger('mg_sc_creation_hook');


		mg_sc += ']';
		
		
		// inserts the shortcode into the active editor
		if( $mg_scw_editor_wrap.find('#wp-content-editor-container > textarea').is(':visible') ) {
			var val = $mg_scw_editor_wrap.find('#wp-content-editor-container > textarea').val() + mg_sc;
			$mg_scw_editor_wrap.find('#wp-content-editor-container > textarea').val(val);	
		}
		else {tinymce.activeEditor.execCommand('mceInsertContent', false, mg_sc);}
		
		
		// closes magpopup
		jQuery.magnificPopup.close();
	});
	
	
})();

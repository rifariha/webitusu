<?php 
include_once(MG_DIR . '/classes/grid_builder_engine.php'); 
include_once(MG_DIR . '/functions.php'); 


// builder class to get fixed code blocks
$gbe = new mg_grid_builder_engine(0);


// style to dynamically size items
echo
'<style type="text/css">';

	// default values (valid also for "auto" height)
	echo '.mg_box {
		width: calc((100% - 1px) * 0.25); 
		padding-bottom: calc((100% - 1px) * 0.25 - 6px); /* SUBTRACT ITEMS MARGIN */
	}';

	// desktop sizes
	foreach(mg_sizes() as $key => $data) {
		echo '.mg_box[data-w="'.$key.'"] {width: calc((100% - 1px) * '. $data['perc'] .');}';
		echo '.mg_box[data-h="'.$key.'"] {padding-bottom: calc((100% - 1px) * '. $data['perc'] .' - 6px);}'; // SUBTRACT ITEMS MARGIN
	}
	
	// mobile sizes
	foreach(mg_mobile_sizes() as $key => $data) {
		echo '.mg_mobile_builder .mg_box[data-mw="'.$key.'"] {width: calc((100% - 1px) * '. $data['perc'].');}';
		echo '.mg_mobile_builder .mg_box[data-mh="'.$key.'"] {padding-bottom: calc((100% - 1px) * '. $data['perc'].' - 6px);}'; // SUBTRACT ITEMS MARGIN
	}

echo
'</style>';
?>



<div class="wrap" style="direction:ltr;">  
	<div class="icon32"><img src="<?php echo MG_URL .'/img/mg_icon.png'; ?>" alt="mediagrid" /><br/></div>
    
    <h1 class="lcwp_page_title" style="border: none;">
		<?php _e( 'Grid Builder', 'mg_ml') ?>
        <a href="javascript:void(0)" id="add_grid_trigger" class="page-title-action"><?php _e('Add New Grid', 'mg_ml') ?></a>
    </h1>
    

	<?php // GRIDS DROPDOWN AND MAIN BUTTONS TO PREVIEW AND SAVE ?>
	<div id="mg_grids_choice">
        <form class="form-wrap">
            <div id="mg_grids_dd" class="mg_grids_no_sel mg_grids_dd_shown">
                <div id="mg_grids_dd_sel" title="<?php echo esc_attr( __('chosen grid', 'mg_ml')) ?>"><em>.. <?php _e('select grid', 'mg_ml') ?> ..</em></div>
               
                <div id="mg_grids_dd_list">
                    <?php echo mg_builder_grids_list(); ?>
                </div>
            </div>
    	</form>        
    </div>
    

	
    <?php // BUILDER'S BODY ?>
    <div id="poststuff" class="mg_grid_builder_outer_wrap metabox-holder has-right-sidebar" style="overflow: hidden;">
    	<form class="form-wrap">
        
			<?php // SIDEBAR ?>
            <div id="side-info-column" class="mg_grid_builder_side inner-sidebar">
                <div id="mg_select_grid_infographic">.. <?php _e('no grid selected', 'mg_ml') ?> ..</div>
            </div>
    	
        	<?php // PAGE CONTENT ?>
          	<div id="post-body">
              	<div id="post-body-content" class="mg_grid_builder_main">
					
              	</div>
       		</div>
        
        </form>
        <br class="clear" />
    </div>
</div>  





<?php // SCRIPTS ?>
<script src="<?php echo MG_URL; ?>/js/functions.js" type="text/javascript"></script>
<script src="<?php echo MG_URL; ?>/js/chosen/chosen.jquery.min.js" type="text/javascript"></script>
<script src="<?php echo MG_URL; ?>/js/lc-switch/lc_switch.min.js" type="text/javascript"></script>

<script src="<?php echo MG_URL; ?>/js/muuri/assets/velocity.min.js" type="text/javascript"></script>
<script src="<?php echo MG_URL; ?>/js/muuri/assets/hammer.min.js" type="text/javascript"></script>
<script src="<?php echo MG_URL; ?>/js/muuri/muuri.velocity-based.min.js" type="text/javascript"></script>


<script type="text/javascript">
jQuery(document).ready(function($) {
	var ajax_acting_in_toast 	= false;
	var is_loading_grid 		= false;
	
	var is_changing_comp	= false;

	var mg_sel_grid		= 0;
	var mg_mobile 		= false;
	var mg_easy_sorting = false;
	var muuri_obj 		= false;
	var new_item_pos 	= <?php echo (get_option('mg_builder_behav', 'append') == 'prepend') ? 0 : -1; ?>; // where to place new items (before or after existing ones)
	
	
	/*** GRIDS LIST ACTIONS ***/

	// grids selection dropdown - click events
	jQuery(document).on('click', '#mg_grids_dd:not(.mg_grids_no_sel) #mg_grids_dd_sel', function(){
		
		if(jQuery('#mg_grids_dd').hasClass('mg_grids_dd_shown')) {
			jQuery('#mg_grids_dd').removeClass('mg_grids_dd_shown').addClass('mg_grids_dd_closed');
		} else {
			jQuery('#mg_grids_dd').addClass('mg_grids_dd_shown').removeClass('mg_grids_dd_closed');	
		}
	});
	

	// grid selection
	jQuery(document).delegate('#mg_grids_dd_list .mg_dd_list_item:not(.mg_gddl_sel)', 'click', function(e) {
		if(is_loading_grid || $(e.target).hasClass('mg_grids_list_btn')) {return true;}
		
		mg_mobile = false;
		jQuery('.mg_grid_builder_main').removeClass('mg_mobile_builder');
		
		is_loading_grid = true;
		mg_sel_grid = parseInt(jQuery(this).attr('rel'));

		// close dropdown and set name
		jQuery('.mg_gddl_sel').removeClass('mg_gddl_sel');
		jQuery(this).addClass('mg_gddl_sel');
		
		jQuery('#mg_grids_dd').removeClass('mg_grids_no_sel mg_grids_dd_shown').addClass('mg_grids_dd_closed');
		jQuery('#mg_grids_dd_sel').text( jQuery(this).find('.mg_grid_tit').text() );		
	
	
		// load builder
		jQuery('.mg_grid_builder_main').empty();
		jQuery('.mg_grid_builder_side > *').not('#mg_select_grid_infographic').remove();
		jQuery('#mg_select_grid_infographic').hide();
		jQuery('.mg_grid_builder_outer_wrap').addClass('mg_big_loader');

		var data = {
			action: 'mg_grid_builder',
			grid_id: mg_sel_grid,
			'lcwp_nonce': '<?php echo wp_create_nonce('lcwp_nonce') ?>'
		};
		
		jQuery.post(ajaxurl, data, function(response) {
			jQuery('.mg_grid_builder_outer_wrap').removeClass('mg_big_loader');
			jQuery('.mg_grid_builder_main').html(response);
			
			var resp = jQuery.parseJSON(response);
			
			jQuery('.mg_grid_builder_side').prepend( resp.side );
			jQuery('.mg_grid_builder_main').html( resp.main );
			
			mg_live_chosen();
			mg_live_checks();
			
			chitemmuuri();
			mg_items_num_pos();
			
			// dynamic builder - manage dropdowns visibility
			jQuery("#mg_dgb_src_list select[name=mg_items_src]").trigger("mg_dbs_added");
			
			mg_mobile = false;	
			mg_easy_sorting = false;
			is_loading_grid = false;
		});	
	});
	

	// grids search
	jQuery('.mg_dd_list_search input').keydown(function() {
		if(typeof(mg_grid_search_timeout) != 'undefined') {clearTimeout(mg_grid_search_timeout);}
		
		mg_grid_search_timeout = setTimeout(function() {
			var val = jQuery.trim(jQuery('.mg_dd_list_search input').val());
			jQuery('.mg_dd_list_nogrids').remove();
			
			// empty - show all
			if(!val) {
				jQuery('.mg_dd_list_item').show();
			}
			else {
				var src_arr = val.toLowerCase().split(' ');

				// cyle and check each searched term 
				jQuery('.mg_dd_list_item').each(function() {
					var grid_txt = $(this).find('em').text().replace('#', '') +' '+ $(this).find('.mg_grid_tit').text().toLowerCase();
					var matching = true;
					
					$.each(src_arr, function(i, word) {						
						if(grid_txt.indexOf(word) === -1) {
							matching = false;
							return false;	
						}
					});
					
					if(!matching) {
						jQuery(this).hide();	
					} else {
						jQuery(this).show();	
					}
				});

				// no grid left - append a message
				if(!jQuery('.mg_dd_list_item:visible').length) {
					jQuery('.mg_items_list_scroll').append('<div class="mg_dd_list_nogrids"><em><?php echo esc_attr(__('No grids found', 'mg_ml')) ?> ..</em></div>');	
				}
			}
		}, 80);
	});
	
	
	
	///////////////////////////
	
	
	
	// load grid list
	reload_grids_list = function() {
		jQuery('#mg_grids_dd_list').html('<div style="height: 70px; width: 100%;" class="lcwp_loading"></div>');
		
		var data = {
			'action': 'mg_get_grids_list',
			'lcwp_nonce': '<?php echo wp_create_nonce('lcwp_nonce') ?>'
		};
		jQuery.post(ajaxurl, data, function(response) {	
			jQuery('#mg_grids_dd_list').html(response);
		});	
	};
	
	
	
	// add grid
	jQuery('#add_grid_trigger').click(function() {
		if(ajax_acting_in_toast) {return false;}
		
		var html = 
		"<form id='mg_add_grid_form'><input type='text' placeholder='<?php echo esc_attr(__("Grid's name", 'mg_ml')) ?> ..' autocomplete='off' maxlength='100' style='width: 100%; margin-bottom: 15px;' />"+
		"<input type='button' value='<?php  echo esc_attr(__('Add Grid', 'mg_ml')) ?>' class='button-primary' style='margin-right: 15px; vertical-align: top;' />"+
		"<input type='button' value='<?php  echo esc_attr(__('Close', 'mg_ml')) ?>' class='button-secondary' style='vertical-align: top;' /></form>";
		
		mg_toast_message('modal', html);
	});
	jQuery(document).on('click', '#mg_add_grid_form .button-secondary', function() {
		if(ajax_acting_in_toast) {return false;}
		jQuery('#lc_toast_mess').removeClass('lc_tm_shown');
	});
	
	// perform addition
	jQuery('body').delegate('#mg_add_grid_form .button-primary', 'click', function() {
		jQuery('.mg_toast_ajax_response').remove();
		
		var grid_name = jQuery.trim(jQuery('#mg_add_grid_form input[type=text]').val());
		if(!jQuery.trim(grid_name)) {return false;}
		
		ajax_acting_in_toast = true;
		jQuery('#mg_add_grid_form input[type=text]').attr('disabled', 'disabled');
		
		var data = {
			action: 'mg_add_grid',
			grid_name: grid_name,
			lcwp_nonce: '<?php echo wp_create_nonce('lcwp_nonce') ?>'
		};
		jQuery.post(ajaxurl, data, function(response) {
			if(jQuery.trim(response) == 'success') {
				jQuery('#mg_add_grid_form input[type=text]').after('<div class="mg_toast_ajax_response mg_tar_success"><?php echo esc_attr( __('Grid successfully added!', 'mgom_ml')) ?></div>');
				
				setTimeout(function() {
					jQuery('#lc_toast_mess').removeClass('lc_tm_shown');
					reload_grids_list();
				}, 1200);
			} 
			else {
				jQuery('#mg_add_grid_form input[type=text]').after('<div class="mg_toast_ajax_response mg_tar_error">'+ response +'</div>');
				jQuery('#mg_add_grid_form input[type=text]').removeAttr('disabled');
			}
			
			ajax_acting_in_toast = false;
		});
	});
	
	
	
	// clone grid
	jQuery(document).on('click', '.mg_clone.mg_grids_list_btn', function() {
		if(ajax_acting_in_toast) {return false;}
		
		var html = 
		"<form id='mg_clone_grid_form'><input type='text' placeholder='<?php echo esc_attr(__("Cloned grid's name", 'mg_ml')) ?> ..' autocomplete='off' maxlength='100' style='width: 100%; margin-bottom: 15px;' />"+
		"<input type='button' value='<?php  echo esc_attr(__('Clone', 'mg_ml')) ?>' class='button-primary' rel='"+ jQuery(this).attr('rel') +"' style='margin-right: 15px; vertical-align: top;' />"+
		"<input type='button' value='<?php  echo esc_attr(__('Close', 'mg_ml')) ?>' class='button-secondary' style='vertical-align: top;' /></form>";
		
		mg_toast_message('modal', html);
	});
	jQuery(document).on('click', '#mg_clone_grid_form .button-secondary', function() {
		if(ajax_acting_in_toast) {return false;}
		jQuery('#lc_toast_mess').removeClass('lc_tm_shown');
	});
	
	// perform cloning
	jQuery('body').delegate('#mg_clone_grid_form .button-primary', 'click', function() {
		var grid_id  = jQuery(this).attr('rel');
		jQuery('.mg_toast_ajax_response').remove();
		
		var new_name = jQuery('#mg_clone_grid_form input[type=text]').val();
		if(!jQuery.trim(new_name)) {return false;}
		
		ajax_acting_in_toast = true;
		jQuery('#mg_clone_grid_form input[type=text]').attr('disabled', 'disabled');
		
		var data = {
			action: 'mg_clone_grid',
			grid_id: grid_id,
			new_name: new_name,
			lcwp_nonce: '<?php echo wp_create_nonce('lcwp_nonce') ?>'
		};
			
		jQuery.post(ajaxurl, data, function(response) {
			if(jQuery.trim(response) == 'success') {
				jQuery('#mg_clone_grid_form input[type=text]').after('<div class="mg_toast_ajax_response mg_tar_success"><?php echo esc_attr( __('Grid successfully cloned!', 'mgom_ml')) ?></div>');
				
				setTimeout(function() {
					jQuery('#lc_toast_mess').removeClass('lc_tm_shown');
					reload_grids_list();
				}, 1200);
			} 
			else {
				jQuery('#mg_clone_grid_form input[type=text]').after('<div class="mg_toast_ajax_response mg_tar_error">'+ response +'</div>');
				jQuery('#mg_clone_grid_form input[type=text]').removeAttr('disabled');
			}
			
			ajax_acting_in_toast = false;
		});
	});
	
	
	
	// rename grid
	jQuery(document).on('click', '.mg_edit_name.mg_grids_list_btn', function() {
		if(ajax_acting_in_toast) {return false;}
		var curr_name = jQuery(this).parents('.mg_dd_list_item').find('.mg_grid_tit').text().replace(/'/g, "\'"); 
		
		var html = 
		"<form id='mg_rename_grid_form'><input type='text' value='"+ curr_name +"' placeholder='<?php echo esc_attr(__("New grid's name", 'mg_ml')) ?> ..' autocomplete='off' maxlength='100' style='width: 100%; margin-bottom: 15px;' />"+
		"<input type='button' value='<?php  echo esc_attr(__('Rename', 'mg_ml')) ?>' class='button-primary' rel='"+ jQuery(this).attr('rel') +"' style='margin-right: 15px; vertical-align: top;' />"+
		"<input type='button' value='<?php  echo esc_attr(__('Close', 'mg_ml')) ?>' class='button-secondary' style='vertical-align: top;' /></form>";
		
		mg_toast_message('modal', html);
	});
	jQuery(document).on('click', '#mg_rename_grid_form .button-secondary', function() {
		if(ajax_acting_in_toast) {return false;}
		jQuery('#lc_toast_mess').removeClass('lc_tm_shown');
	});
	
	// perform renaming
	jQuery('body').delegate('#mg_rename_grid_form .button-primary', 'click', function() {
		var grid_id  = jQuery(this).attr('rel');
		jQuery('.mg_toast_ajax_response').remove();
		
		var old_name = jQuery('.mgg_'+grid_id+' .mg_grid_tit').text();
		var new_name = jQuery.trim(jQuery('#mg_rename_grid_form input[type=text]').val());
		if(!jQuery.trim(new_name) || old_name === new_name) {return false;}
		
		ajax_acting_in_toast = true;
		jQuery('#mg_rename_grid_form input[type=text]').attr('disabled', 'disabled');
		
		var data = {
			action: 'mg_rename_grid',
			grid_id: grid_id,
			new_name: new_name,
			lcwp_nonce: '<?php echo wp_create_nonce('lcwp_nonce') ?>'
		};
			
		jQuery.post(ajaxurl, data, function(response) {
			if(jQuery.trim(response) == 'success') {
				jQuery('#mg_rename_grid_form input[type=text]').after('<div class="mg_toast_ajax_response mg_tar_success"><?php echo esc_attr( __('Grid successfully renamed!', 'mgom_ml')) ?></div>');
				jQuery('.mgg_'+grid_id+' .mg_grid_tit').text(new_name);
				
				setTimeout(function() {
					jQuery('#lc_toast_mess').removeClass('lc_tm_shown');
				}, 1200);
			} 
			else {
				jQuery('#mg_rename_grid_form input[type=text]').after('<div class="mg_toast_ajax_response mg_tar_error">'+ response +'</div>');
				jQuery('#mg_rename_grid_form input[type=text]').removeAttr('disabled');
			}
			
			ajax_acting_in_toast = false;
		});
	});
	
	
	
	// delete grid
	jQuery(document).delegate('.mg_del_grid.mg_grids_list_btn', 'click', function() {
		var $grid_list_item = jQuery(this).parents('.mg_dd_list_item');
		var grid_id  = $grid_list_item.attr('rel');
		
		// not if another grid operation is being performed
		if(ajax_acting_in_toast || is_loading_grid) {return false;}
		
		// ask before proceeding
		if(confirm('<?php echo esc_attr( __('This will DEFINITIVELY delete the grid. Continue?', 'mg_ml')) ?>')) {
			is_loading_grid = true;
			ajax_acting_in_toast = true;
			
			$grid_list_item.fadeTo(200, 0.5);
			
			var data = {
				action: 'mg_del_grid',
				grid_id: grid_id
			};
			jQuery.post(ajaxurl, data, function(response) {
				if(jQuery.trim(response) == 'success') {
					
					// if is this one opened
					if(mg_sel_grid == grid_id) {
						jQuery('.mg_grid_builder_main').empty();
						jQuery('#mg_select_grid_infographic').show();
						jQuery('.mg_grid_builder_side > *').not('#mg_select_grid_infographic').remove();
						
						mg_sel_grid = false;
					}
					
					$grid_list_item.remove();
				}
				else {
					$grid_list_item.fadeTo(0, 1);
					alert(response);
				}
				
				is_loading_grid = false;
				ajax_acting_in_toast = false;
			});
		}
	});
	
	
	
	
	///////////////////////////
	


	
	// manual/dynamic grid switch - reload main builder
	jQuery(document).delegate('select[name=mg_grid_composition]', 'change', function() {
		if(is_changing_comp) {return false;}
		
		var new_comp = jQuery(this).val();
		var old_comp = (new_comp == 'dynamic') ? 'manual' : 'dynamic';
		
		// no confirm if no item in manual or no source in dynamic
		if(
			(old_comp == 'manual' && !jQuery('.mg_box').length) ||
			(old_comp == 'dynamic' && !jQuery('.mg_items_source').length && !jQuery('.mg_box').length) ||
			confirm("<?php _e('Any unsaved change in grid composition will be lost. Continue?', 'mg_ml') ?>")
		) {
			
			// composition changed
			if(new_comp == 'dynamic') {
				jQuery('.mg_dynamic_grid_opt').slideDown();	
				jQuery('.mg_manual_grid_opt').slideUp();	
				
				if(!jQuery('input[name=mg_dynamic_repeat]').is(':checked')) {
					jQuery('input[name=mg_dynamic_limit]').parents('.mg_dynamic_grid_opt').stop().hide();
				}
			} 
			else {
				jQuery('.mg_dynamic_grid_opt').slideUp();	
				jQuery('.mg_manual_grid_opt').slideDown();
			}
			
			
			// reset bulk sizers
			jQuery('#mg_bulk_w, #mg_bulk_h').show();	
			jQuery('#mg_bulk_mw, #mg_bulk_mh, #dynamic_auto_mh_fb').hide();		
			
						
			// recall main builder
			var $wrap = jQuery('.mg_grid_builder_main');
			$wrap.html('<div class="mg_big_loader" style="min-height: 200px;"></div>');
			
			var data = {
				action		: 'mg_bcc_builder_main',
				grid_id		: mg_sel_grid,
				composition	: new_comp,
				lcwp_nonce	: '<?php echo wp_create_nonce('lcwp_nonce') ?>'
			};
			jQuery.post(ajaxurl, data, function(response) {
				$wrap.html(response);
				chitemmuuri();
				
				mg_items_num_pos();
				mg_live_chosen();
				
				// dynamic builder - manage dropdowns visibility
				jQuery("#mg_dgb_src_list select[name=mg_items_src]").trigger("mg_dbs_added");
				
				mg_mobile = false;	
				mg_easy_sorting = false;
			});
		}
		
		else {
			jQuery("select[name=mg_grid_composition] option").removeAttr('selected');
			jQuery("select[name=mg_grid_composition] option[value='"+ old_comp +"']").attr('selected', 'selected');
			
			jQuery("select[name=mg_grid_composition]").trigger("chosen:updated");
			return false;
		}	
	});
	
	
	
	// save grid
	jQuery('body').delegate('input[name=mg_save_grid]', 'click', function() {
		var $btn = jQuery(this);
		var comp = jQuery('select[name=mg_grid_composition]').val();
		
		if($btn.hasClass('mg_saving_grid')) {return false;}
		
		// base atts
		var data = {
			action		: 'mg_save_grid',
			grid_id		: mg_sel_grid,
			composition : comp,
			structure 	: get_grid_structure(),  
			lcwp_nonce	: '<?php echo wp_create_nonce('lcwp_nonce') ?>'
		}
		
		// enqueue side opts
		if(comp == 'dynamic') {
			data.dynamic_src 		= mg_dyn_grid_sources(),
			data.dynamic_repeat 	= jQuery('input[name=mg_dynamic_repeat]').is(':checked') ? 1 : 0;
			data.dynamic_limit 		= jQuery('input[name=mg_dynamic_limit]').val();	
			data.dynamic_per_page 	= jQuery('input[name=mg_dynamic_per_page]').val();	
			data.dynamic_orderby 	= jQuery('select[name=mg_dynamic_orderby]').val();	
			data.dynamic_random 	= jQuery('input[name=mg_dynamic_random]').is(':checked') ? 1 : 0;
			data.dynamic_auto_h_fb 	= {
				'h' 	:	jQuery('select[name=dynamic_auto_h_fb]').val(),
				'm_h'	:	jQuery('select[name=dynamic_auto_mh_fb]').val(),
			}
		}

		// call
		$btn.addClass('mg_saving_grid').fadeTo(200, 0.5);
	
		jQuery.post(ajaxurl, data, function(response) {
			var resp = jQuery.trim(response); 

			if(resp == 'success') {
				mg_toast_message('success', "<?php echo esc_attr( __('Grid successfully saved!', 'mg_ml')) ?>");
			} else {
				mg_toast_message('error', resp);
			}
			
			$btn.removeClass('mg_saving_grid').fadeTo(200, 1);
		});	
	});
	
	
	// retrieve grid structure to be saved
	var get_grid_structure = function() {
		var struct = [];
		
		muuri_obj.getItems().forEach(function (item, i) {
			var $item = jQuery(item._element);
			var item_data = {
				'id'	: $item.find('input[name="grid_items[]"]').val(),
				'w'		: $item.attr('data-w'),
				'h'		: $item.attr('data-h'),
				'm_w'	: $item.attr('data-mw'),
				'm_h'	: $item.attr('data-mh'),
			};
			
			// if spacer - add also visibility
			if(item_data.id == 'spacer') {
				item_data.vis = $item.find('.mg_spacer_vis_dd').val()				
			}

			struct.push(item_data);
		});
		
		return struct;
	};
	
	
	// preview grid
	jQuery('body').delegate('#preview_grid', "click", function() {
		var url = jQuery(this).data('pv-url') + '?mg_preview=' + mg_sel_grid;
		window.open(url,'_blank');
	});
	
	
	// expanded mode toggle
	jQuery('body').delegate('#mg_expand_builder', "click", function() {
		if(jQuery('#wpcontent').hasClass('mg_expanded_builder')) {
			jQuery('#wpcontent').removeClass('mg_expanded_builder');	
		} else {
			jQuery('#wpcontent').addClass('mg_expanded_builder');	
		}
		
		mg_relayout_grid();
	});
	
	
	
	
	/**********************************************/
	/************ DYNAMIC COMPOSITION *************/
	/**********************************************/
	
	
	// repeated structure - toggle limit visibility
	jQuery('body').delegate('input[name=mg_dynamic_repeat]', 'lcs-statuschange', function() {
		if(jQuery(this).is(':checked')) {
			jQuery('input[name=mg_dynamic_limit]').parents('.mg_dynamic_grid_opt').slideDown();
		} else {
			jQuery('input[name=mg_dynamic_limit]').parents('.mg_dynamic_grid_opt').slideUp();
		}
	});
	
	
	// add source 
	jQuery(document).on('click', '#mg_add_source', function() {
		if(!jQuery('#mg_dgb_src_list thead').length) {
			jQuery('#mg_dgb_src_list').prepend(
			'<thead>'+
				'<tr>'+
					'<th style="width: 29%;"><?php _e('Post type and taxonomy', 'mg_ml') ?></th>'+
					'<th style="width: 29%;"><?php _e('Specific term association?', 'mg_ml') ?></th>'+
					'<th style="width: 29%;"><?php _e('Specific item type?', 'mg_ml') ?></th>'+
					'<th style="width: 13%;"></th>'+
				'</tr>'+
			'</thead><tbody></tbody>');	
		}
		
		jQuery('#mg_dgb_src_list tbody').append('<?php echo str_replace("'", "\'", $gbe->dynamic_src_code()); ?>');
		
		jQuery('#mg_dgb_src_list select[name=mg_items_src]').last().trigger('mg_dbs_added');
		mg_live_chosen();
	});
	
	
	// remove source
	jQuery(document).on('click', 'input[name=mg_dgb_del_src]', function() {
		if(confirm("<?php echo esc_attr( __('Do you really want to remove this source?', 'mg_ml')) ?>")) {
			if(jQuery('#mg_dgb_src_list tbody tr').length > 1) {
				jQuery(this).parents('tr').remove();	
			} else {
				jQuery('#mg_dgb_src_list').empty();	
			}
		}
		else {return false;}
	});
	
	
	// update terms changing post type
	jQuery(document).delegate('#mg_dgb_src_list select[name=mg_items_src]', 'change', function() {
		var $parent = jQuery(this).parents('tr');
		
		// loader
		$parent.find('.mg_items_src_tax_wrap').html('<div style="width: 20px; height: 20px;" class="lcwp_loading"></div>');
		
		var data = {
			action: 'mg_sel_cpt_source',
			cpt: jQuery(this).val()
		};
		jQuery.post(ajaxurl, data, function(response) {
			$parent.find('.mg_items_src_tax_wrap').html(response);
			mg_live_chosen();
		});
	});
	
	
	// toggle MG item dropdown visibility in sources
	jQuery(document).on('change mg_dbs_added', '#mg_dgb_src_list select[name=mg_items_src]', function() {
		if(jQuery(this).val().indexOf('mg_items') !== -1) {
			jQuery(this).parents('tr').find('.mg_items_type_wrap .chosen-container').fadeTo(100, 1);
		} else {
			jQuery(this).parents('tr').find('.mg_items_type_wrap .chosen-container').fadeTo(100, 0);
		}
	});
	
	
	// get dynamic grid sources
	var mg_dyn_grid_sources = function() {
		var src = [];
		
		jQuery('#mg_dgb_src_list tbody tr').each(function() {
            var pt_n_tax = jQuery(this).find('select[name=mg_items_src]').val();
			
			var src_data = {
				'pt_n_tax'	: pt_n_tax,
				'term'		: (jQuery(this).find('select[name=mg_cpt_tax_term]').length) ? jQuery(this).find('select[name=mg_cpt_tax_term]').val() : '',
				'mg_type'	: (pt_n_tax.indexOf('mg_items') !== -1) ? jQuery(this).find('select[name=mg_items_type]').val() : ''
			};
			src.push(src_data);
        });
		return src;
	};
	
	
	// add block to dynamic builder
	jQuery(document).on('click', '#mg_add_block', function() {
		if(!jQuery('#mg_visual_builder_wrap ul .mg_box').length) {
			jQuery('#mg_visual_builder_wrap ul').empty();
		}
		
		var $item = jQuery('<?php echo str_replace("'", "\'", $gbe->item_code('item')); ?>');
		muuri_obj.add([ $item[0] ], {index: new_item_pos});
		
		mg_items_num_pos();
	});
	
	
	
	
	/**********************************************/
	/************* MANUAL COMPOSITION *************/
	/**********************************************/
	
	
	/*** ITEMS PICKER ***/
	var picker_page = 1;
	var querying_items = false;
		
	// update terms changing post type
	jQuery(document).delegate('#mg_mgb_picker_wrap select[name=mg_items_src]', 'change', function() {
		query_items();
		
		// manage mg items type visibility
		if(jQuery(this).val().indexOf('mg_items') !== -1) {
			jQuery('#mg_items_type_wrap .chosen-container, #mg_items_type_wrap > label').fadeTo(100, 1);
		} else {
			jQuery('#mg_items_type_wrap .chosen-container, #mg_items_type_wrap > label').fadeTo(100, 0);
		}
		
		// loader
		jQuery('#mg_items_src_tax_wrap > *').not('label').remove();
		jQuery('#mg_items_src_tax_wrap').append('<div style="width: 20px; height: 20px;" class="lcwp_loading"></div>');
		
		var data = {
			action: 'mg_sel_cpt_source',
			cpt: jQuery(this).val()
		};
		jQuery.post(ajaxurl, data, function(response) {
			jQuery('#mg_items_src_tax_wrap > div').replaceWith(response);
			mg_live_chosen();
		});
	});
	
	
	// items search
	jQuery(document).on('keyup', "#mg_gb_item_search", function() {
		if(typeof(mg_gbis_acting) != 'undefined') {clearTimeout(mg_gbis_acting);}
		mg_gbis_acting = setTimeout(function() {

			var src_string = jQuery.trim( jQuery("#mg_gb_item_search").val() );
			if(src_string.length) {
				jQuery('.mg_gbis_del').fadeIn(200);
			}
			else {
				jQuery('.mg_gbis_del').fadeOut(200);
			}	
			
			query_items();
		}, 400);
	});
	jQuery('body').on('click', '.mg_gbis_mag', function() {
		jQuery("#mg_gb_item_search").trigger('keyup');
	});
	jQuery('body').on('click', '.mg_gbis_del', function() {
		jQuery("#mg_gb_item_search").val('').trigger('keyup');
	});
	
	
	// query on term or tem type change
	jQuery(document).on('change', "#mg_mgb_picker_wrap select[name=mg_cpt_tax_term], #mg_mgb_picker_wrap select[name=mg_items_type]", function() {
		query_items();
	});
	
	
	// change items per page
	jQuery(document).on('keyup', "input[name=mgb_ip_limit]", function() {
		if(typeof(mg_gbpp_acting) != 'undefined') {clearTimeout(mg_gbpp_acting);}
		mg_gbpp_acting = setTimeout(function() {

			var val = parseInt(jQuery('input[name=mgb_ip_limit]').val());
			
			// sanitize
			if(!val || val < 16 || val > 70) {
				jQuery('input[name=mgb_ip_limit]').val(16);	
			}
			
			// reset page and query
			picker_page = 1;
			query_items();
		}, 400);
	});


	// next/prev page
	jQuery(document).on('click', "input[name=mgb_ip_next], input[name=mgb_ip_prev]", function() {
		if(!querying_items) {

			if(jQuery(this).attr('name') == 'mgb_ip_next') {
				picker_page++;
			}
			else {
				picker_page--;
			}
			query_items();
		}
	});

	
	// perform items query
	var query_items = function() {
		if(!querying_items) {
			querying_items = true;	
			
			jQuery('.mbb_ip_page_counter span').first().text(picker_page);
			jQuery('#mg_gb_item_picker').html('<div class="mg_big_loader" style="min-height: 100px;"></div>');
			
			var data = {
				action		: 'mg_builder_query_items',
				pt_n_tax	: jQuery('select[name=mg_items_src]').val(),
				term		: (jQuery('select[name="mg_cpt_tax_term"]').length) ? jQuery('select[name="mg_cpt_tax_term"]').val() : '', 
				search		: jQuery('#mg_gb_item_search').val(), 
				mg_item_type: jQuery('select[name="mg_items_type"]').val(), 
				per_page	: jQuery('input[name="mgb_ip_limit"]').val(), 
				page		: picker_page,
				lcwp_nonce	: '<?php echo wp_create_nonce('lcwp_nonce') ?>'
			};
			jQuery.post(ajaxurl, data, function(response) {
				var resp = jQuery.parseJSON(response);
				querying_items = false;	
				
				jQuery('#mg_gb_item_picker').html(resp.items);
				jQuery('.mbb_ip_page_counter span').last().text(resp.tot_pages);
				
				if(picker_page >= resp.tot_pages) {
					jQuery('input[name=mgb_ip_next]').hide();	
				} else {
					jQuery('input[name=mgb_ip_next]').show();		
				}
				
				if(picker_page < 2) {
					jQuery('input[name=mgb_ip_prev]').hide();	
				} else {
					jQuery('input[name=mgb_ip_prev]').show();		
				}
			});
		}
	};
		
		
	
	
	////////////////////////////////////////////////////
	



	// sortable masonry
	var chitemmuuri = function() {
		muuri_obj = new Muuri( jQuery('#mg_sortable')[0] , {
			items: jQuery('#mg_sortable')[0].children,
			dragEnabled: true,
			dragSortInterval: 50,
			dragStartPredicate: {
				distance: 20,
				delay: 20,
			},
			layout : {
				fillGaps : true,
				alignRight : <?php echo (get_option('mg_rtl_grid')) ? 'true' : 'false' ?>,
			},
		});
		
		// after a while - re-layout to fix initial bad positioning
		setTimeout(function() {
			jQuery('#mg_sortable').addClass('mg_muurified');
			mg_relayout_grid();
			mg_items_num_pos();
			
			jQuery('.mg_spacer_vis_dd').trigger('change');
			
			// update numeration on drag end
			muuri_obj.off('dragEnd').on('dragEnd', function (item, event) {
				 mg_items_num_pos();
			});
		}, 70);
	};
	
	
	// be sure grid has always an even width
	var mg_evenize_grid_w = function() {
		var $grid = jQuery('.mg_muurified');
		if(!$grid.length) {return false;}
		
		// is even - ok
		if($grid.outerWidth() % 2 == 0) {
			return true;
		}
		else {
			// toggle mg_not_even_w class?	
			jQuery('#mg_visual_builder_wrap').toggleClass('mg_not_even_w');
			mg_relayout_grid();
		}
	};
	setInterval(mg_evenize_grid_w, 300);
	

	// re-layout grid
	mg_relayout_grid = function() {
		var $grid = jQuery('.mg_muurified');
		if(!$grid.length) {return false;}
		
		muuri_obj.refreshItems();
		muuri_obj.layout(true);	
	};
	
	
	// items numeric position - adds also true numeration attr for arrow move
	var mg_items_num_pos = function() {
		var $grid = jQuery('.mg_muurified');
		if(!$grid.length) {return false;}
		
		muuri_obj.synchronize();
	
		var a = 1
		var b = 0;
		muuri_obj.getItems().forEach(function (item, i) {
			
			jQuery(item._element).attr('data-position', b);
			var $item_num = jQuery(item._element).find('.mg_item_num');

			if($item_num.length) {
				$item_num.text(a);
				a++;	
			}
			
			b++;
		});
	};
	
	
	///////////////////////////
	
	
	// add item
	jQuery('body').delegate('#mg_gb_item_picker li', "click", function() {
		
		// if is v5 spacer - block and inform
		if(jQuery(this).find('.mgi_spacer').length) {
			alert("<?php echo esc_attr( __('Since Media Grid v6, spacer must be added using the button on top of grid preview. Please update your grids and delete this item.')) ?>");
			return false;	
		}
		
		
		var $subj = jQuery(this); 
		$subj.fadeTo(200, 0.7);

		var data = {
			action: 'mg_add_item_to_builder',
			item_id: $subj.attr('rel'),
			lcwp_nonce: '<?php echo wp_create_nonce('lcwp_nonce') ?>'
		};
		jQuery.post(ajaxurl, data, function(response) {
			if(!jQuery('#mg_visual_builder_wrap ul .mg_box').length) {
				jQuery('#mg_visual_builder_wrap ul').empty();
			}
			
			var $item = jQuery(response);
			muuri_obj.add([ $item[0] ], {index: new_item_pos});
		
			mg_items_num_pos();
			$subj.fadeTo(200, 1);
			
			// re-layout after a little while to avoid any sizing issue
			setTimeout(function() {
				mg_relayout_grid();
			}, 100);
		});
	});
	
	
	// add paginator block
	jQuery('body').delegate('#mg_add_paginator', "click", function() {
		var $grid = jQuery('.mg_muurified');
		if(!$grid.length) {return false;}

		var $item = jQuery('<?php echo str_replace("'", "\'", $gbe->paginator_code()); ?>');
		muuri_obj.add([ $item[0] ], {index: new_item_pos});
		
		mg_items_num_pos();
	});
	
	
	// add spcer block
	jQuery('body').delegate('#mg_add_spacer', "click", function() {
		var $grid = jQuery('.mg_muurified');
		if(!$grid.length) {return false;}

		var $item = jQuery('<?php echo str_replace("'", "\'", $gbe->item_code('spacer')); ?>');
		muuri_obj.add([ $item[0] ], {index: new_item_pos});
		
		mg_items_num_pos();
	});
	
	
	// spacer visibility between modes
	jQuery('body').delegate('.mg_spacer_vis_dd', "change", function() {
		var $item = jQuery(this).parents('.mg_box');
		
		switch(jQuery(this).val()) {
			case 'hidden_desktop' :
				if(mg_mobile) {
					$item.show();	
				} else {
					$item.hide();	
				}
				break;
			
			case 'hidden_mobile' :
				if(mg_mobile) {
					$item.hide();	
				} else {
					$item.show();	
				}
				break;
		
			default :
				$item.show();	 
				break;	
		}
		
		mg_relayout_grid();
	});
	
	
	
	// remove item
	jQuery('body').delegate('.del_item', "click", function() {
		var $grid = jQuery('.mg_muurified');
		if(!$grid.length) {return false;}
		
		if(confirm('<?php echo esc_attr( __('Remove item?', 'mg_ml')) ?>')) {
			var $item = jQuery(this).parents('.mg_box'); 
			muuri_obj.remove([$item[0]], {removeElements: true});
			
			mg_items_num_pos();
		}
	});


	///////////////////////////

	
	/*** standard layout - live sizing ***/
	// box resize width
	jQuery(document).delegate('#mg_visual_builder_wrap .select_w', 'change', function() {
		jQuery(this).parents('.mg_box').attr('data-w', jQuery(this).val()); // .data() doesn't work .. dunno why..!
		
		if(!mg_easy_sorting) {
			mg_relayout_grid();
		}
	});
	
	
	// box resize height
	jQuery('body').delegate('#mg_visual_builder_wrap .select_h', 'change', function() {
		jQuery(this).parents('.mg_box').attr('data-h', jQuery(this).val());
		
		if(!mg_easy_sorting) {
			mg_relayout_grid();
		}
	});
	
	
	/*** mobile layout - live sizing ***/
	// box resize width
	jQuery('body').delegate('#mg_sortable .select_m_w', 'change', function() {
		jQuery(this).parents('.mg_box').attr('data-mw', jQuery(this).val());
		
		if(!mg_easy_sorting) {
			mg_relayout_grid();
		}
	});
	
	
	// box resize height
	jQuery('body').delegate('#mg_sortable .select_m_h', 'change', function() {
		jQuery(this).parents('.mg_box').attr('data-mh', jQuery(this).val());
		
		if(!mg_easy_sorting) {
			mg_relayout_grid();
		}
	});
	
		
	
	///////////////////////////
	
	
	
	// mobile mode toggle 
	jQuery(document).delegate('#mg_mobile_view_toggle', 'click', function() {
		
		if(jQuery('.mg_mobile_builder').length) {
			jQuery(this).find('span').text('OFF');
			mg_mobile = false;
		}
		else {
			jQuery(this).find('span').text('ON');
			mg_mobile = true;	
		}
		
		jQuery(this).toggleClass('mg_active');
		jQuery('.mg_grid_builder_main').toggleClass('mg_mobile_builder');
		
		// bulk sizers - switch dropdowns
		if(mg_mobile) {
			jQuery('#mg_bulk_w, #mg_bulk_h').hide();	
			jQuery('#mg_bulk_mw, #mg_bulk_mh').show();	
		} else {
			jQuery('#mg_bulk_w, #mg_bulk_h').show();	
			jQuery('#mg_bulk_mw, #mg_bulk_mh').hide();		
		}

		jQuery('.mg_spacer_vis_dd').trigger('change');
		mg_relayout_grid();
	});
	
	
	// easy sorting mode toggle
	jQuery(document).delegate('#mg_easy_sorting_toggle', "click", function() {
		
		if(jQuery('.mg_easy_sorting').length) {
			jQuery(this).find('span').text('OFF');
			mg_easy_sorting = false;
		} 
		
		// activate
		else {
			jQuery(this).find('span').text('ON');
			mg_easy_sorting = true;
		}
		
		jQuery(this).toggleClass('mg_active');
		jQuery('#mg_sortable').toggleClass('mg_easy_sorting');	
		mg_relayout_grid();
	});
	
	
	//// bulk sizing system
	// width
	jQuery('body').delegate('#mg_bulk_w_btn', 'click', function() {
		if(confirm("<?php _e('Every grid item will be affected, continue?') ?>")) {
			var val = (mg_mobile) ? jQuery('#mg_bulk_mw').val() : jQuery('#mg_bulk_w').val();
			var dd_class = (mg_mobile) ? '.select_m_w' : '.select_w';
			
			jQuery('#mg_sortable .mg_box '+dd_class+' option').attr('selected', false);
			jQuery('#mg_sortable .mg_box '+dd_class+' option[value="'+val+'"]').attr('selected', 'selected');
			
			jQuery('#mg_sortable '+dd_class).trigger('change');
		}
	});
	
	// height
	jQuery('body').delegate('#mg_bulk_h_btn', 'click', function() {
		if(confirm("<?php _e('Every grid item will be affected, continue?') ?>")) {
			var val = (mg_mobile) ? jQuery('#mg_bulk_mh').val() : jQuery('#mg_bulk_h').val();
			var dd_class = (mg_mobile) ? '.select_m_h' : '.select_h';
			
			if(val == 'auto') {
				jQuery('#mg_sortable .mg_box').not('.mg_inl_slider_type, .mg_inl_video_type').find(dd_class+' option').attr('selected', false);
				jQuery('#mg_sortable .mg_box').not('.mg_inl_slider_type, .mg_inl_video_type').find(dd_class+' option[value="'+val+'"]').attr('selected', 'selected');
			} else {
				jQuery('#mg_sortable .mg_box '+dd_class+' option').attr('selected', false);
				jQuery('#mg_sortable .mg_box '+dd_class+' option[value="'+val+'"]').attr('selected', 'selected');
			}
				
			jQuery('#mg_sortable '+dd_class).trigger('change');
		}
	});
	
	
	// move item with arrows
	jQuery(document).delegate('.mg_move_item_bw, .mg_move_item_fw', 'click', function(ui) {
		var $grid = jQuery('.mg_muurified');
		if(!$grid.length) {return false;}
	
		var $item = jQuery(this).parents('li');
		var curr_pos = parseInt( $item.attr('data-position') );
		
		console.log(curr_pos);
		
		var opt = {
			'action' : 'swap'
		};

		// backwards
		if(jQuery(this).hasClass('mg_move_item_bw') && curr_pos) {
			var $to_swap = jQuery('.mg_box[data-position="'+ (curr_pos - 1) +'"]');
			muuri_obj.move($item[0], $to_swap[0], opt);
		}
		
		// forwards
		if(jQuery(this).hasClass('mg_move_item_fw') && curr_pos < (jQuery('.mg_box').length - 1)) {
			var $to_swap = jQuery('.mg_box[data-position="'+ (curr_pos + 1) +'"]');
			
			console.log($to_swap);
			muuri_obj.move($item[0], $to_swap[0], opt);
		}

		mg_relayout_grid();
		mg_items_num_pos();
	});
	

	
	///////////////////////////


	// disable enter key on input fields
	jQuery(document).on("keypress", ".form-wrap", function(event) { 
		return event.keyCode != 13;
	});



	// keep sidebar visible
	jQuery(window).scroll(function() {
		var $subj = jQuery('.mg_grid_builder_side');
		
		if($subj.find('.postbox').length) {
			var side_h = jQuery('.mg_grid_builder_side').outerHeight();
			var top_pos = jQuery('.mg_grid_builder_side').parent().offset().top;
			var top_scroll = jQuery(window).scrollTop();
			
			// if is higher that window - ignore
			if((top_pos + side_h + 44) >= jQuery(window).height() || top_scroll <= top_pos) {
				$subj.css('margin-top', 0);	
			}
			else {
				$subj.css('margin-top', (top_scroll - top_pos + 44)); 	
			}	
		}
		else {
			$subj.css('margin-top', 0);	
		}
	});



	// toast message
	mg_toast_message = function(type, text) {
		if(!jQuery('#lc_toast_mess').length) {
			jQuery('body').append('<div id="lc_toast_mess"></div>');
			
			jQuery('head').append(
			'<style type="text/css">' +
			'#lc_toast_mess,#lc_toast_mess *{-moz-box-sizing:border-box;box-sizing:border-box}#lc_toast_mess{background:rgba(20,20,20,.2);position:fixed;top:0;right:-9999px;width:100%;height:100%;margin:auto;z-index:99999;opacity:0;filter:alpha(opacity=0);-webkit-transition:opacity .15s ease-in-out .05s,right 0s linear .5s;-ms-transition:opacity .15s ease-in-out .05s,right 0s linear .5s;transition:opacity .15s ease-in-out .05s,right 0s linear .5s}#lc_toast_mess.lc_tm_shown{opacity:1;filter:alpha(opacity=100);right:0;-webkit-transition:opacity .3s ease-in-out 0s,right 0s linear 0s;-ms-transition:opacity .3s ease-in-out 0s,right 0s linear 0s;transition:opacity .3s ease-in-out 0s,right 0s linear 0s}#lc_toast_mess:before{content:"";display:inline-block;height:100%;vertical-align:middle}#lc_toast_mess>div{position:relative;padding:13px 16px!important;border-radius:2px;box-shadow:0 2px 17px rgba(20,20,20,.25);display:inline-block;width:310px;margin:0 0 0 50%!important;left:-155px;top:-13px;-webkit-transition:top .2s linear 0s;-ms-transition:top .2s linear 0s;transition:top .2s linear 0s}#lc_toast_mess.lc_tm_shown>div{top:0;-webkit-transition:top .15s linear .1s;-ms-transition:top .15s linear .1s;transition:top .15s linear .1s}#lc_toast_mess>div>span:after{font-family:dashicons;background:#fff;border-radius:50%;color:#d1d1d1;content:"";cursor:pointer;font-size:23px;height:15px;padding:5px 9px 7px 2px;position:absolute;right:-7px;top:-7px;width:15px}#lc_toast_mess>div:hover>span:after{color:#bbb}#lc_toast_mess .lc_error{background:#fff;border-left:4px solid #dd3d36}#lc_toast_mess .lc_success{background:#fff;border-left:4px solid #7ad03a}#lc_toast_mess .lc_modal {background: #fff;}#lc_toast_mess .lc_modal > span {display: none;}' +
			'</style>');	
			
			// close toast message
			jQuery(document.body).off('click tap', '#lc_toast_mess');
			jQuery(document.body).on('click tap', '#lc_toast_mess', function() {
				if(!jQuery(this).find('.lc_modal').length) {
					jQuery('#lc_toast_mess').removeClass('lc_tm_shown');
				}
			});
		}
		
		// setup
		if(type == 'error') {
			jQuery('#lc_toast_mess').empty().html('<div class="lc_error"><p>'+ text +'</p><span></span></div>');	
		} 
		else if(type == 'modal') {
			jQuery('#lc_toast_mess').empty().html('<div class="lc_modal"><p>'+ text +'</p><span></span></div>');	
		} else {
			jQuery('#lc_toast_mess').empty().html('<div class="lc_success"><p>'+ text +'</p><span></span></div>');	
			
			setTimeout(function() {
				jQuery('#lc_toast_mess.lc_tm_shown span').trigger('click');
			}, 2150);	
		}
		
		// use a micro delay to let CSS animations act
		setTimeout(function() {
			jQuery('#lc_toast_mess').addClass('lc_tm_shown');
		}, 30);	
	}
	
});
</script>

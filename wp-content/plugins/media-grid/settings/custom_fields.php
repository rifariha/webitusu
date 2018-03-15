<?php 

// preset styles preview and setter 
function mg_preset_styles($field_id, $field, $value, $all_vals) {
	
	// build code
	echo '
	<table id="mg_preset_styles_cmd_wrap" class="widefat lcwp_settings_table">
		<tr class="mg_'. $field_id .'">
			<td class="lcwp_sf_label"><label>'. __('Choose style', 'mg_ml') .'</label></td>
			<td class="lcwp_sf_field">
				<select name="'. $field_id .'" id="mg_pred_styles" class="lcwp_sf_chosen mg_pred_styles_cf_select" autocomplete="off">
					<option value=""></option>';
				
					foreach(mg_preset_style_names() as $id => $name) {
						echo '<option value="'.$id.'">'.$name.'</option>';	
					}
		echo '
				</select>   
			</td>
			<td style="width: 50px;">
				<input name="mg_set_style" id="mg_set_style" value="'. __('Set', 'mg_ml') .'" class="button-secondary" type="button" />
			</td>
			<td><p class="lcwp_sf_note">'. __('Overrides styling options and applies preset styles', 'mg_ml') .'. '. __('Once applied, <strong>page will be reloaded</strong> with changed options', 'mg_ml') .'</p></td>
		</tr>
		<tr style="display: none;">
			<td class="lcwp_sf_label"><label>'. __('Preview', 'mg_ml') .'</label></td>
			<td colspan="3" id="mg_preset_styles_preview"></td>
		</tr>
	</table>';
	
	?>
    <script type="text/javascript">
    jQuery(document).ready(function(e) {
		
		// predefined style - preview toggle
		jQuery(document).delegate('#mg_pred_styles', "change", function() {
			var sel = jQuery('#mg_pred_styles').val();
			
			if(!sel) {
				jQuery('#mg_preset_styles_preview').empty();	
			}
			else {
				jQuery('#mg_preset_styles_cmd_wrap tr').last().show();
				
				var img_url = '<?php echo MG_URL ?>/img/preset_styles_demo/'+ sel +'.jpg';
				jQuery('#mg_preset_styles_preview').html('<img src="'+ img_url +'" />');		
			}
		});
		
		
		// set predefined style 
		jQuery(document).delegate('#mg_set_style', 'click', function() {
			var sel_style = jQuery('#mg_pred_styles').val();
			if(!sel_style) {return false;}
			
			if(confirm('<?php _e('This will overwrite your current settings, continue?', 'mg_ml') ?>')) {
				jQuery(this).replaceWith('<div style="width: 30px; height: 30px;" class="lcwp_loading"></div>');
				
				var data = {
					action: 'mg_set_predefined_style',
					style: sel_style,
					lcwp_nonce: '<?php echo wp_create_nonce('lcwp_nonce') ?>'
				};
				jQuery.post(ajaxurl, data, function(response) {
					if(jQuery.trim(response) == 'success') {
						jQuery('#lc_toast_mess').empty().html('<div class="lc_success"><p><?php echo esc_attr( __('Style successfully applied!', 'mg_ml')) ?></p><span></span></div>');	
						jQuery('#lc_toast_mess').addClass('lc_tm_shown');
						
						setTimeout(function() {
							window.location.reload();	
						}, 1500);
					}
					else {
						alert(response);	
					}
				});	
			}
		});
    });
    </script>
    <?php
}



// Easy WP thumbs - status
function mg_ewpt_status($field_id, $field, $value, $all_vals) {
	?>
	<table id="mg_ewpt_status_wrap" class="widefat lcwp_settings_table">
		<tr class="mg_<?php echo $field_id ?>">
			<td>
            	<input type="hidden" name="ewpt_status_f" value="" /> <?php //JS vis trick ?>
				<?php ewpt_wpf_form(); ?>
			</td>
		</tr>	
	</table>
    
    <script type="text/javascript">
    jQuery(document).ready(function() {
		jQuery(document).on('lcs-statuschange', 'input[name=mg_use_timthumb]', function(e) { 	
			(jQuery(this).is(':checked')) ? jQuery('#mg_ewpt_status_wrap').hide() : jQuery('#mg_ewpt_status_wrap').show();
		});
            
		// trigger on page's opening
		jQuery('input[name=mg_use_timthumb]').trigger('change').trigger('lcs-statuschange');
	});
	</script>
    <?php
}




// Lightbox overlay pattern
function mg_item_overlay_pattern_f($field_id, $field, $value, $all_vals) {
	$no_pattern_sel = (!$value || $value == 'none') ? 'mg_pattern_sel' : '';
	
	echo '
	<tr class="pc_'. $field_id .'">
		<td class="lcwp_sf_label"><label>'. __("Overlay's pattern", 'mg_ml') .'</label></td>
		<td class="lcwp_sf_field" colspan="2" style="padding-bottom: 0;">
    		<input type="hidden" value="'. $value .'" name="mg_item_overlay_pattern" id="mg_item_overlay_pattern" />
			
			<div class="mg_setting_pattern '.$no_pattern_sel.'" rel="none"> no pattern </div>';
			
			foreach(mg_patterns_list() as $pattern) {
				$sel = ($value == $pattern) ? 'mg_pattern_sel' : '';  
				echo '<div class="mg_setting_pattern '.$sel.'" rel="'.$pattern.'" style="background: url('.MG_URL.'/img/patterns/'.$pattern.') repeat top left transparent;"></div>';		
			}
	
	echo '
		</td>
	</tr>';
	
	?>
	<script type="text/javascript">
    jQuery(document).ready(function() {
		jQuery('body').delegate('.mg_setting_pattern', 'click', function() { // select a pattern
			jQuery('.mg_setting_pattern').removeClass('mg_pattern_sel');
			jQuery(this).addClass('mg_pattern_sel'); 
			
			jQuery('#mg_item_overlay_pattern').val( jQuery(this).attr('rel') );
		});
	});
	</script>
    <?php	
}





// Item type attributes
function mg_item_atts_f($field_id, $field, $value, $all_vals) {
	echo '<div id="mg_type_opt_wrap">';
	
	// WPML / Polylang sync button
	if(function_exists('icl_register_string')) {
		echo '
		<p id="mg_wpml_opt_sync_wrap">
			<input type="button" value="'. esc_attr( __('Sync with WPML', 'mg_ml')) .'" class="button-secondary" />
			<span><em>'. __('Remember to save settings before sync', 'mg_ml') .'</em></span>
		</p>';	
	} 
	elseif(function_exists('pll_register_string')) {
		echo '
		<p id="mg_wpml_opt_sync_wrap">
			<input type="button" value="'. esc_attr( __('Sync with Polylang', 'mg_ml')) .'" class="button-secondary" />
			<span><em>'. __('Remember to save settings before sync', 'mg_ml') .'</em></span>
		</p>';	
	} 
			
	
	
	foreach(mg_main_types() as $type => $name) :
	?>
    	<div class="mg_type_opt_block">
            <h3>
                <?php echo $name ?>
                <a id="opt_<?php echo $type; ?>" href="javascript:void(0)" class="mg_type_opt_add_option add-opt-h3"><?php _e('Add option', 'mg_ml') ?></a>
            </h3>
            <table class="widefat" id="<?php echo $type; ?>_opt_table">
            	<thead>
              		<tr>
                        <th style="width: 30px;"><?php _e('Icon', 'mg_ml') ?></th>
                        <th><?php _e('Attribute Name', 'mg_ml') ?></th>
                        <th></th>
                        <th style="width: 20px;"></th>
                        <th style="width: 20px;"></th>
              		</tr>
              	</thead>
              	<tbody>
                <?php
                if(is_array($all_vals['mg_'.$type.'_opt']) && count($all_vals['mg_'.$type.'_opt'])) {
                    $a = 0;
                    foreach($all_vals['mg_'.$type.'_opt'] as $type_opt) {
                        $icon = (isset($all_vals['mg_'.$type.'_opt_icon'][$a])) ? $all_vals['mg_'.$type.'_opt_icon'][$a] : '';
                        
                        echo '
                        <tr>
                            <td class="mg_type_opt_icon_trigger">
                                <i class="fa '.esc_attr($icon).'" title="'. __("set attribute's icon", 'mg_ml') .'"></i>
                                <input type="hidden" name="mg_'.$type.'_opt_icon[]" value="'. esc_attr($icon) .'" autocomplete="off" />
                            </td>
                            <td class="lcwp_field_td">
                                <input type="text" name="mg_'.$type.'_opt[]" value="'. esc_attr($type_opt) .'" maxlenght="150" />
                            </td>
                            <td></td>
                            <td><span class="lcwp_move_row"></span></td>
                            <td><span class="lcwp_del_row"></span></td>
                        </tr>';	
                        
                        $a++;
                    }
                }
				else  {
					 echo '
                        <tr>
                            <td class="mg_type_opt_icon_trigger">
                                <i class="fa" title="'. __("set attribute's icon", 'mg_ml') .'"></i>
                                <input type="hidden" name="mg_'.$type.'_opt_icon[]" value="" autocomplete="off" />
                            </td>
                            <td class="lcwp_field_td">
                                <input type="text" name="mg_'.$type.'_opt[]" value="" maxlenght="150" />
                            </td>
                            <td></td>
                            <td><span class="lcwp_move_row"></span></td>
                            <td><span class="lcwp_del_row"></span></td>
                        </tr>';	
				}
                ?>
				</tbody>
            </table>
    	</div>        
	<?php endforeach; ?>
    
    <?php 
	// WOOCOMMERCE ATTRIBUTES
	if($GLOBALS['mg_woocom_active'] && is_array($GLOBALS['mg_woocom_atts']) && count($GLOBALS['mg_woocom_atts'])) :
	?>
    	<div class="mg_type_opt_block">
            <h3 style="border: none;"><?php _e('WooCommerce products', 'mg_ml') ?></h3>
            <table class="widefat lcwp_table" id="woocom_opt_table" style="width: 100%; max-width: 450px;">
            	<thead>
              		<tr>
                		<th style="width: 30px;"><?php _e('Icon', 'mg_ml') ?></th>
                		<th><?php _e('Attribute Name', 'mg_ml') ?></th>
              		</tr>
            	</thead>
             	<tbody>
					<?php
					foreach($GLOBALS['mg_woocom_atts'] as $attr) {
						$icon = (isset($all_vals['mg_wc_attr_'.sanitize_title($attr->attribute_label).'_icon'])) ? 
							$all_vals['mg_wc_attr_'.sanitize_title($attr->attribute_label).'_icon'] : '';
						
						echo '
						<tr>
							<td class="mg_type_opt_icon_trigger">
								<i class="fa '.esc_attr($icon).'" title="'. __("set attribute's icon", 'mg_ml') .'"></i>
								<input type="hidden" name="mg_wc_attr_'. sanitize_title($attr->attribute_label) .'_icon" value="'.esc_attr($icon).'" />
							</td>
							<td class="lcwp_field_td">
								'. $attr->attribute_label .'
							</td>
						</tr>';	
					}
                ?>
            	</tbody>
            </table>
    	</div>
    <?php endif;
	
	echo '</div>'; // wrapper's closing
	
	
	// ITEM ATTRIBUTES - ICON WIZARD
	echo mg_fa_icon_picker_code( __('no icon', 'mg_ml') );
	?>
	
    
    <script type="text/javascript">
    jQuery(document).ready(function(e) {
        
    	// WPML sync button
		jQuery('body').delegate('#mg_wpml_opt_sync_wrap input', 'click', function() {
			jQuery('#mg_wpml_opt_sync_wrap span').html('<div style="width: 30px;" class="lcwp_loading"></div>');
			
			var data = {action: 'mg_options_wpml_sync'};
			jQuery.post(ajaxurl, data, function(response) {
				var resp = jQuery.trim(response);
				
				if(resp == 'success') {
					jQuery('#mg_wpml_opt_sync_wrap span').html('<?php echo esc_attr( __('Options synced succesfully!', 'mg_ml')) ?>');
				} else {
					jQuery('#mg_wpml_opt_sync_wrap span').html('<?php echo esc_attr( __('Error syncing', 'mg_ml')) ?> ..');
				}
			});	
		});
		
		
		// launch option icon wizard
		<?php mg_fa_icon_picker_js(); ?>
		
		
		// add options
		jQuery('.mg_type_opt_add_option').click(function(){
			var type_subj = jQuery(this).attr('id').substr(4);
			
			var optblock = 
			'<tr>\
				<td class="mg_type_opt_icon_trigger">\
					<i class="fa" title="<?php echo esc_attr(__("set attribute's icon", 'mg_ml')) ?>"></i>\
					<input type="hidden" name="mg_'+ type_subj +'_opt_icon[]" value="" />\
				</td>\
				<td class="lcwp_field_td"><input type="text" name="mg_'+type_subj+'_opt[]" maxlenght="150" /></td>\
				<td></td>\
				<td><span class="lcwp_move_row"></span></td>\
				<td><span class="lcwp_del_row"></span></td>\
			</tr>';
	
			jQuery('#'+ type_subj + '_opt_table tbody').append(optblock);
		});
		
		// remove opt 
		jQuery('body').delegate('.lcwp_del_row', "click", function() {
			if(confirm('<?php echo esc_attr( __('WARNING: deleting this option also related item values will be lost. Continue?', 'mg_ml')) ?>')) {
				jQuery(this).parents('tr').slideUp(function() {
					jQuery(this).remove();
				});	
			}
		});
		
		// sort opt
		jQuery('#mg_type_opt_wrap table').each(function() {
			jQuery(this).children('tbody').sortable({ handle: '.lcwp_move_row' });
			jQuery(this).find('.lcwp_move_row').disableSelection();
		});
		
    });
    </script>
	<?php	
}

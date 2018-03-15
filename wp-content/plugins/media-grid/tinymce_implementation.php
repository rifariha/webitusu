<?php
// implement tinymce button

add_action('media_buttons', 'mg_editor_btn', 19);
add_action('admin_footer', 'mg_editor_btn_content');


//action to add a custom button to the content editor
function mg_editor_btn($context) {
	$img = MG_URL . '/img/mg_icon_tinymce.png';
  
	//append the icon
	echo '
	<a id="mg_scw_btn" title="Media Grid">
	  <img src="'.$img.'" />
	</a>';
	
	$GLOBALS['mg_tinymce_editor'] = true;
}



function mg_editor_btn_content() {
	if(strpos($_SERVER['REQUEST_URI'], 'post.php') === false && strpos($_SERVER['REQUEST_URI'], 'post-new.php') === false && !isset($GLOBALS['mg_tinymce_editor'])) {return false;}
	include_once(MG_DIR . '/functions.php');
?>

	<div id="mediagrid_sc_wizard" style="display:none;">
    	<div class="lcwp_scw_choser_wrap mg_scw_choser_wrap">
            <select name="mg_scw_choser" class="lcwp_scw_choser mg_scw_choser" autocomplete="off">
                <option value="#mg_sc_main" selected="selected"><?php _e('Main parameters', 'mg_ml') ?></option>
                <option value="#mg_sc_style"><?php _e('Custom styles', 'mg_ml') ?></option>	
            </select>	
        </div>
        
        
		<div id="mg_sc_main" class="lcwp_scw_block mg_scw_block"> 
            <ul>
                <li class="lcwp_scw_field mg_scw_field">
                	<label><?php _e('Which grid?', 'mg_ml') ?></label>
               		<select id="mg_grid_choose" data-placeholder="<?php _e('Select a grid', 'mg_ml') ?> .." name="mg_grid_choose" class="lcweb-chosen" autocomplete="off">
						<?php
						foreach(get_terms('mg_grids', array('hide_empty' => 0, 'orderby' => 'name')) as $grid) {
							echo '<option value="'.$grid->term_id.'">'.$grid->name.'</option>';	
						}
                        ?>
                	</select>
                </li>
                <li class="lcwp_scw_field mg_scw_field lcwp_scwf_half">
                	<label><?php _e('Text under items?', 'mg_ml') ?></label>
               		<select id="mg_title_under" data-placeholder="<?php _e('Select an option', 'mg_ml') ?> .." name="mg_title_under" class="lcweb-chosen" autocomplete="off">
					
                    	<option value="0"><?php _e('No', 'mg_ml') ?></option>
                        <option value="1"><?php _e('Yes - attached to item', 'mg_ml') ?></option>
                        <option value="2"><?php _e('Yes - detached from item', 'mg_ml') ?></option>
                	</select>
                </li>
                <li class="lcwp_scw_field mg_scw_field lcwp_scwf_half">
                	<label><?php _e('Pagination system', 'mg_ml') ?></label>
               		<select id="mg_pag_sys" data-placeholder="<?php _e('Select an option', 'mg_ml') ?> .." name="mg_pag_sys" class="lcweb-chosen" autocomplete="off">
						
                        <option value="">(<?php _e('default one', 'mg_ml') ?>)</option>
                    	<?php
						foreach(mg_pag_layouts() as $type => $name) {
                        	echo '<option value="'.$type.'">'.$name.'</option>';	
						}
						?>
                	</select>
                </li>
                <li class="lcwp_scw_field mc_scw_field lcwp_scwf_half">
                	<label><?php _e('Enable search?', 'mg_ml') ?></label>
                    <input type="checkbox" id="mg_search_bar" name="mg_search_bar" value="1" class="ip-checkbox" autocomplete="off" />
                </li>
                <li class="lcwp_scw_field mc_scw_field lcwp_scwf_half">
                	<label><?php _e('Enable filters?', 'mg_ml') ?></label>
                    <input type="checkbox" id="mg_filter_grid" name="mg_filter_grid" value="1" class="ip-checkbox" autocomplete="off" />
                </li>
                <li class="lcwp_scw_field mg_scw_field lcwp_scwf_half mg_scw_ff" style="display: none;">
                	<label><?php _e('Filters position', 'mg_ml') ?></label>
               		<select id="mg_filters_align" data-placeholder="<?php _e('Select an option', 'mg_ml') ?> .." name="mg_filters_align" class="lcweb-chosen" autocomplete="off">
					
                    	<option value="top">(<?php _e('On top', 'mg_ml') ?>)</option>
                        <option value="left">(<?php _e('Left side', 'mg_ml') ?>)</option>
                        <option value="right">(<?php _e('Right side', 'mg_ml') ?>)</option>
                	</select>
                </li>
                <li class="lcwp_scw_field mc_scw_field lcwp_scwf_half mg_scw_ff" style="display: none;">
                	<label><?php _e('Hide "All" filter? <em>(to show every item)</em>', 'mg_ml') ?></label>
                    <input type="checkbox" id="mg_hide_all" name="mg_hide_all" value="1" class="ip-checkbox" autocomplete="off" />
                </li>
                <li class="lcwp_scw_field mg_scw_field mg_scw_ff mg_scw_def_filter lcwp_scwf_half" style="display: none;">
                	<label><?php _e('Default filter', 'mg_ml') ?></label>
               		<select id="mg_def_filter" data-placeholder="<?php _e('Select an option', 'mg_ml') ?> .." name="mg_def_filter" class="lcweb-chosen" autocomplete="off">
						
                        <option value="">(<?php _e('none', 'mg_ml') ?>)</option>
						<?php
						foreach(mg_item_cats() as $cat_id => $cat_name) {
                        	echo '<option value="'.$cat_id.'">'.$cat_name.'</option>';	
						}
						?>
                	</select>
                </li>
                 <li class="lcwp_scw_field mg_scw_field lcwp_scwf_half">
                	<label>
						<?php _e('Custom mobile treshold', 'mg_ml') ?> 
                        <span class="dashicons dashicons-info" title="<?php echo esc_attr(__('Overrides global treshold. Leave empty to ignore', 'mg_ml')) ?>" style="cursor: help; opacity: 0.3;"></span>
                        </label>
               		<input type="number" step="10" min="50" max="2000" name="mg_mobile_treshold" id="mg_mobile_treshold" value="" autocomplete="off" /> px
                </li>
                
                <?php 
				// MG-OPTION - allow custom fields insertion into main scw options - structure must comply with existing one
				do_action('mg_scw_main_opts');
				?>
                
                
				<?php 
				///// OVERLAY MANAGER ADD-ON ///////////
				////////////////////////////////////////
				if(defined('MGOM_DIR')) : ?>
				<li class="lcwp_scw_field mg_scw_field">
                	<label><?php _e('Custom Overlay', 'mg_ml') ?></label>
               		<select id="mg_custom_overlay" data-placeholder="<?php _e('Select an overlay', 'mg_ml') ?> .." name="mg_custom_overlay" class="lcweb-chosen" autocomplete="off">
						
                        <option value="">(<?php _e('default one', 'mg_ml') ?>)</option>
						<?php
						$overlays = get_terms('mgom_overlays', 'hide_empty=0');
						foreach($overlays as $ol) {
							  $sel = (isset($fdata) && $ol->term_id == $fdata['mg_default_overlay']) ? 'selected="selected"' : '';
							  echo '<option value="'.$ol->term_id.'" '.$sel.'>'.$ol->name.'</option>'; 
						}
						?>
                	</select>
                </li>
				<?php endif;
				////////////////////////////////////////
				?>   
                
                
                <li class="lcwp_scw_field mg_scw_field">
                	<input type="button" class="button-primary mg_sc_insert_grid" value="<?php _e('Insert Grid', 'mg_ml') ?>" name="submit" />
                </li>
			</ul>
    	</div>
        
        
        <div id="mg_sc_style" class="lcwp_scw_block mg_scw_block"> 
            <ul>
                <li class="lcwp_scw_field mg_scw_field">
                	<strong>NB: <?php _e('leave empty textual fields to use global values', 'mg_ml') ?></strong>
	            </li>
                <li class="lcwp_scw_field mg_scw_field lcwp_scwf_half">
                	<label><?php _e('Items margin', 'mg_ml') ?></label>
               		<input type="number" name="mg_cells_margin" id="mg_cells_margin" value="" autocomplete="off" maxlength="2" /> px
                </li>
                <li class="lcwp_scw_field mg_scw_field lcwp_scwf_half">
                	<label><?php _e('Item borders width', 'mg_ml') ?></label>
               		<input type="number" name="mg_border_w" id="mg_border_w" value="" autocomplete="off" maxlength="2" /> px
                </li>
                <li class="lcwp_scw_field mg_scw_field lcwp_scwf_half">
                	<label><?php _e('Item borders color', 'mg_ml') ?></label>
               		<div class="lcwp_colpick">
                        <span class="lcwp_colblock"></span>
                        <input type="text" name="mg_border_color" id="mg_border_color" value="" autocomplete="off" />
                    </div>
                </li>
                <li class="lcwp_scw_field mg_scw_field lcwp_scwf_half">
                	<label><?php _e('Items border radius', 'mg_ml') ?></label>
               		<input type="number" name="mg_cells_radius" id="mg_cells_radius" value="" autocomplete="off" maxlength="2" /> px
                </li>
                <li class="lcwp_scw_field mg_scw_field lcwp_scwf_half">
                	<label><?php _e("Display items outline?", 'mg_ml') ?></label>
               		<select id="mg_outline" data-placeholder="<?php _e('Select an option', 'mg_ml') ?> .." name="mg_outline" class="lcweb-chosen" autocomplete="off">
                        <option value="">(<?php _e('as default', 'mg_ml') ?>)</option>
                        <option value="1"><?php _e('Yes', 'mg_ml') ?></option>
                        <option value="0"><?php _e('No', 'mg_ml') ?></option>
                	</select>
                </li>
                <li class="lcwp_scw_field mg_scw_field lcwp_scwf_half">
                	<label><?php _e('Outline color', 'mg_ml') ?></label>
               		<div class="lcwp_colpick">
                        <span class="lcwp_colblock"></span>
                        <input type="text" name="mg_outline_color" id="mg_outline_color" value="" autocomplete="off" />
                    </div>
                </li>
                <li class="lcwp_scw_field mg_scw_field lcwp_scwf_half">
                	<label><?php _e("Display items shadow?", 'mg_ml') ?></label>
               		<select id="mg_shadow" data-placeholder="<?php _e('Select an option', 'mg_ml') ?> .." name="mg_shadow" class="lcweb-chosen" autocomplete="off">
                        <option value="">(<?php _e('as default', 'mg_ml') ?>)</option>
                        <option value="1"><?php _e('Yes', 'mg_ml') ?></option>
                        <option value="0"><?php _e('No', 'mg_ml') ?></option>
                	</select>
                </li>
                <li class="lcwp_scw_field mg_scw_field lcwp_scwf_half">
                	<label><?php _e('Text under images color', 'mg_ml') ?></label>
               		<div class="lcwp_colpick">
                        <span class="lcwp_colblock"></span>
                        <input type="text" name="mg_txt_under_color" id="mg_txt_under_color" value="" autocomplete="off" />
                    </div>
                </li>
               
                <?php 
				// MG-OPTION - allow custom fields insertion into style scw options - structure must comply with existing one
				do_action('mg_scw_style_opts');
				?>
                
                <li class="lcwp_scw_field mg_scw_field">
                	<input type="button" class="button-primary mg_sc_insert_grid" value="<?php _e('Insert Grid', 'mg_ml') ?>" name="submit" />
                </li>
    		</ul>
    	</div> 
	</div> 
   
   
   
	<?php // SCRIPTS ?>
    <link rel="stylesheet" href="<?php echo MG_URL; ?>/js/magnific_popup/magnific-popup.css" media="all" />
    <script src="<?php echo MG_URL; ?>/js/magnific_popup/magnific-popup.pckg.js" type="text/javascript"></script>
	
    <script src="<?php echo MG_URL; ?>/js/functions.js" type="text/javascript"></script>
    <script src="<?php echo MG_URL; ?>/js/tinymce_btn.js" type="text/javascript"></script>
    
	<script src="<?php echo MG_URL; ?>/js/colpick/js/colpick.min.js" type="text/javascript"></script>
	<script src="<?php echo MG_URL; ?>/js/chosen/chosen.jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo MG_URL; ?>/js/lc-switch/lc_switch.min.js" type="text/javascript"></script>
<?php    
}

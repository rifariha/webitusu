<?php
// POST TYPES METABOX - applied to post types that are addable to grids


// register
function mg_pt_metabox_register() {
	include_once(MG_DIR . '/functions.php');
	
	foreach(mg_pt_list() as $pt) {
		if($pt == 'mg_items') {continue;}	
		
		add_meta_box('mg_pt_thumb_center', 'Media Grid - '. __("Thumbnail's Center", 'mg_ml'), 'mg_thumb_center_box', $pt, 'side', 'low');
		add_meta_box('mg_pt_search_helper_box', 'Media Grid - '. __('Search Helper', 'mg_ml'), 'mg_search_helper_box', $pt, 'side', 'low');
		add_meta_box('mg_pt_metabox', __('Media Grid Integration', 'mg_ml'), 'mg_pt_metabox', $pt, 'normal', 'default');
	}
}
add_action('admin_init', 'mg_pt_metabox_register');





//////////////////////////////
// CONTENTS MANAGEMENT OPTIONS

function mg_pt_metabox() {
	include_once(MG_DIR . '/functions.php');
	global $post;
	?>
    <div id="mg_item_meta_wrap" class="lcwp_mainbox_meta">
        <div id="mg_item_meta_f_wrap">
        	<?php 
			include_once(MG_DIR .'/classes/items_meta_fields.php');
			
			$imf_type = ($post->post_type == 'product') ? 'woocomm' : 'post';
			$imf = new mg_meta_fields($post->ID, $imf_type);
			
			echo $imf->get_fields_code();
			$imf->echo_type_js_code();
			?>
        </div> 
    </div>
    
    
    
    <?php // security nonce ?>
    <input type="hidden" name="mg_pt_noncename" value="<?php echo wp_create_nonce('lcwp_nonce') ?>" />
    
    <?php // ////////////////////// ?>
    
    <?php // SCRIPTS ?>
    <script src="<?php echo MG_URL; ?>/js/chosen/chosen.jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo MG_URL; ?>/js/lc-switch/lc_switch.min.js" type="text/javascript"></script>
    
    <script type="text/javascript">
	jQuery(document).ready(function($) {
		//// custom icon - picker
		<?php mg_fa_icon_picker_js(); ?>
	});
	</script>
    <?php	
	return true;	
}





//////////////////////////
// SAVING METABOX

function mg_pt_meta_save($post_id) {
	if(isset($_POST['mg_pt_noncename'])) {
		// authentication checks
		if (!wp_verify_nonce($_POST['mg_pt_noncename'], 'lcwp_nonce')) return $post_id;
		if (!current_user_can('edit_post', $post_id)) return $post_id;
		
		
		include_once(MG_DIR.'/functions.php');
		include_once(MG_DIR.'/classes/simple_form_validator.php');
		include_once(MG_DIR .'/classes/items_meta_fields.php');
				
		$validator = new simple_fv;
		$indexes = array();
		$indexes[] = array('index'=>'mg_thumb_center', 'label'=>'Thumbnail Center');
		$indexes[] = array('index'=>'mg_search_helper', 'label'=>'Search Helper');
		
		// type options
		$imf_type = (get_post_type($post_id) == 'product') ? 'woocomm' : 'post';
		$imf = new mg_meta_fields($post_id, $imf_type);
		$indexes = array_merge($indexes, (array)$imf->get_fields_validation());
		
		
		$validator->formHandle($indexes);
		$fdata = $validator->form_val;
		$error = $validator->getErrors();
		

		// clean data
		foreach($fdata as $key=>$val) {
			if(!is_array($val)) {
				$fdata[$key] = stripslashes($val);
			}
			else {
				$fdata[$key] = array();
				foreach($val as $arr_val) {$fdata[$key][] = stripslashes($arr_val);}
			}
		}

		// save data
		foreach($fdata as $key=>$val) {
			update_post_meta($post_id, $key, $fdata[$key]); 
		}
		
		
		// assign MG cats to this post
		if(!is_array($fdata['mg_post_cats'])) {$fdata['mg_post_cats'] = array();}
		wp_set_post_terms($post_id, $fdata['mg_post_cats'], 'mg_item_categories', $append = false);
	}

    return $post_id;
}
add_action('save_post','mg_pt_meta_save');
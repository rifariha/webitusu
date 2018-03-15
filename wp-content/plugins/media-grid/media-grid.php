<?php
/* 
Plugin Name: Media Grid |  VestaThemes.com
Plugin URI: http://www.lcweb.it/media-grid
Description: The revolutionary engine to create layout-free grids. Supporting any multimedia type and bringing an unique lightbox!
Author: Luca Montanari
Version: 6.05
Author URI: http://www.lcweb.it
*/  


/////////////////////////////////////////////
/////// MAIN DEFINES ////////////////////////
/////////////////////////////////////////////

// plugin path
$wp_plugin_dir = substr(plugin_dir_path(__FILE__), 0, -1);
define('MG_DIR', $wp_plugin_dir);

// plugin url
$wp_plugin_url = substr(plugin_dir_url(__FILE__), 0, -1);
define('MG_URL', $wp_plugin_url);

// plugin version
define('MG_VER', 6.05);


// timthumb url - also for MU
if(is_multisite()){ define('MG_TT_URL', MG_URL . '/classes/timthumb_MU.php'); }
else { define( 'MG_TT_URL', MG_URL . '/classes/timthumb.php'); }




/////////////////////////////////////////////
/////// FORCING DEBUG ///////////////////////
/////////////////////////////////////////////

if(isset($_REQUEST['mg_php_debug'])) {
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);	
}




/////////////////////////////////////////////
/////// MULTILANGUAGE SUPPORT ///////////////
/////////////////////////////////////////////

function mg_multilanguage() {
	$param_array = explode(DIRECTORY_SEPARATOR, MG_DIR);
 	$folder_name = end($param_array);
	load_plugin_textdomain( 'mg_ml', false, $folder_name . '/languages'); 
}
add_action('init', 'mg_multilanguage', 1);




/////////////////////////////////////////////
/////// MAIN SCRIPT & CSS INCLUDES //////////
/////////////////////////////////////////////


// global script enqueuing
function mg_global_scripts() {
	wp_enqueue_script('jquery');
	
	// force latest fontawesome version
	wp_dequeue_style('fontawesome');
	wp_enqueue_style('fontawesome', MG_URL . '/css/font-awesome/css/font-awesome.min.css', 999, '4.7.0');


	// admin
	if (is_admin()) {  
		wp_enqueue_style('mg_admin', MG_URL . '/css/admin.css', 999, MG_VER);
		wp_enqueue_style('mg_settings', MG_URL . '/settings/settings_style.css', 999, MG_VER);	
		
		// chosen
		wp_enqueue_style( 'lcwp-chosen-style', MG_URL.'/js/chosen/chosen.css', 999);
		
		// lcweb switch
		wp_enqueue_style( 'lc-switch', MG_URL.'/js/lc-switch/lc_switch.css', 999);
		
		// colorpicker
		wp_enqueue_style( 'mg-colpick', MG_URL.'/js/colpick/css/colpick.css', 999);
		
		// LCWP jQuery ui
		wp_enqueue_style( 'lcwp-ui-theme', MG_URL.'/css/ui-wp-theme/jquery-ui-1.8.17.custom.css', 999);
		
		// sortable
		wp_enqueue_script('jquery-ui-sortable');
		
		// slider
		wp_enqueue_script('jquery-ui-slider');
		
		// lightbox and thickbox
		wp_enqueue_style('thickbox');
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
	}
	
	
	// frontend
	if (!is_admin()) {
		// frontent JS on header or footer
		if(get_option('mg_js_head') != '1') {
			wp_enqueue_script('mg-frontend-js', MG_URL.'/js/frontend.js', 100, MG_VER, true);	
		} else { 
			wp_enqueue_script('mg-frontend-js', MG_URL.'/js/frontend.js', 900, MG_VER);
		}

		// frontend css
		if(!get_option('mg_inline_css') && !get_option('mg_force_inline_css')) {
			wp_enqueue_style('mg-custom-css', MG_URL. '/css/custom.css', 100, MG_VER);	
		}
		else {add_action('wp_head', 'mg_inline_css', 989);}	
	}
}
add_action('wp_enqueue_scripts', 'mg_global_scripts', 900);
add_action('admin_enqueue_scripts', 'mg_global_scripts');


// use frontend CSS inline
function mg_inline_css(){
	echo '<style type="text/css">';
	include_once(MG_DIR.'/frontend_css.php');
	echo '</style>';
}





/////////////////////////////////////////////
/////// MAIN INCLUDES ///////////////////////
/////////////////////////////////////////////

// admin menu and cpt and taxonomy
include_once(MG_DIR . '/admin_menu.php');

// taxonomy options 
include_once(MG_DIR . '/taxonomy_options.php');

// mg items metaboxes
include_once(MG_DIR . '/metaboxes.php');

// post types metabox
include_once(MG_DIR . '/post_types_metabox.php');

// shortcode
include_once(MG_DIR . '/shortcode.php');

// tinymce button
include_once(MG_DIR . '/tinymce_implementation.php');

// ajax
include_once(MG_DIR . '/ajax.php');

// dynamic javascript and CSS for footer
include_once(MG_DIR . '/dynamic_footer.php');

// grid preview
include_once(MG_DIR . '/grid_preview.php');

// lightbox
include_once(MG_DIR . '/lightbox.php');

// lghtbox comments
include_once(MG_DIR . '/classes/lb_comments.php');



// retrieve deeplinks
include_once(MG_DIR . '/deeplinks_retrieval.php');

// lightbox deeplink launch
include_once(MG_DIR . '/lightbox_deeplink.php');



// visual composer integration
include_once(MG_DIR . '/builders_integration/visual_composer.php');

// cornerstone integration
include_once(MG_DIR . '/builders_integration/cornerstone.php');

// elementor integration
include_once(MG_DIR . '/builders_integration/elementor.php');





////////////
// AVOID issues with bad servers in settings redirect
function mg_settings_redirect_trick() {
	ob_start();
}
add_action('admin_init', 'mg_settings_redirect_trick', 1);
////////////



////////////
// EASY WP THUMBS + forcing system
function mg_ewpt() {
	if(get_option('mg_ewpt_force')) {$_REQUEST['ewpt_force'] = true;}
	include_once(MG_DIR . '/classes/easy_wp_thumbs.php');	
}
add_action('init', 'mg_ewpt', 1);
////////////



////////////
// AUTO UPDATE DELIVER
include_once(MG_DIR . '/classes/lc_plugin_auto_updater.php');
function mg_auto_updates() {
	$upd = new lc_wp_autoupdate(__FILE__, 'http://updates.lcweb.it', 'lc_updates', 'mg_init_custom_css');
}
add_action('admin_init', 'mg_auto_updates', 1);
////////////



//////////////////////////////////////////////////
// ACTIONS ON PLUGIN ACTIVATION
function mg_init_custom_css() {
	include_once(MG_DIR . '/functions.php');
	
	// create custom CSS
	if(!mg_create_frontend_css()) {update_option('mg_inline_css', 1);}
	else {delete_option('mg_inline_css');}
	
	// hack for non-latin characters (FROM v1.11)
	if(!get_option('mg_non_latin_char')) {
		if(mg_cust_opt_exists()) {delete_option('mg_non_latin_char');}	
		else {add_option('mg_non_latin_char', '1', '', 'yes');}
	}
	
	// update sliders (for versions < 1.3)
	mg_update_img_sliders();	
}
register_activation_hook(__FILE__, 'mg_init_custom_css');

// update sliders function
function mg_update_img_sliders() {
	global $wpdb;
	
	// retrieve all the items
	$args = array(
		'numberposts' => -1, 
		'post_type' => 'mg_items',
	);
	$posts_array = get_posts($args);
	
	if(is_array($posts_array)) {
	
		foreach($posts_array as $post) {
			$gallery_items = get_post_meta($post->ID, 'mg_slider_img', true);
			
			if(is_array($gallery_items) && count($gallery_items) > 0) {
				$new_array = array();
				foreach($gallery_items as $img_url) {
					if(filter_var($img_url, FILTER_VALIDATE_URL)) {
						$query = "SELECT ID FROM ".$wpdb->posts." WHERE guid='".$img_url."'";
						$id = (int)$wpdb->get_var($query);
						
						if(!is_int($id)) {var_dump($id); die('error during sliders update');}
						$new_array[] = $id;
					}
					else {$new_array[] = $img_url;}
				}
				
				delete_post_meta($post->ID, 'mg_slider_img');
				add_post_meta($post->ID, 'mg_slider_img', $new_array, true);
			}	
		}
	}
	
	return true;
}



//// save existing grids in term description (for versions < 3.0)
// use hook - on activation doesn't get custom taxonomy
add_action('admin_init', 'mg_update_grids_location', 1);
function mg_update_grids_location() {
	if(!get_option('mg_v3_update')) {
		include_once(MG_DIR . '/functions.php');
		$grids = get_terms('mg_grids', 'hide_empty=0');

		foreach($grids as $grid) {
			$items = get_option('mg_grid_'.$grid->term_id.'_items');
			$w = get_option('mg_grid_'.$grid->term_id.'_items_width');
			$h = get_option('mg_grid_'.$grid->term_id.'_items_height');
			$cats = get_option('mg_grid_'.$grid->term_id.'_cats');
			
			// create description array
			$arr = array('items' => array(), 'cats' => $cats);	
			if(is_array($items)) {
				for($a=0; $a < count($items); $a++) {
					if(!$w) {
						$cell_w = get_post_meta($items[$a], 'mg_width', true);
						$cell_h = get_post_meta($items[$a], 'mg_height', true);
					}
					else {
						$cell_w = $w[$a];
						$cell_h = $h[$a];	
					}
					
					$arr['items'][] = array(
						'id'	=> $items[$a],
						'w' 	=> $cell_w,
						'h' 	=> $cell_h,
						'm_w' 	=> (in_array($cell_w, mg_mobile_sizes())) ? $cell_w : '1_2',
						'm_h' 	=> (in_array($cell_h, mg_mobile_sizes()) || $cell_h == 'auto') ? $cell_h : '1_3'
					);
				}
			}
			wp_update_term($grid->term_id, 'mg_grids', array('description' => serialize($arr)));
		}
		update_option('mg_v3_update', 1);
	}
}



//////////////////////////////////////////////////
// REMOVE WP HELPER FROM PLUGIN PAGES

function mg_remove_wp_helper() {
	$cs = get_current_screen();
	$hooked = array('mg_items_page_mg_settings', 'mg_items_page_mg_builder');
	
	if(is_object($cs) && in_array($cs->base, $hooked)) {
		echo '
		<style type="text/css">
		#screen-meta-links {display: none;}
		</style>';	
	}
	
	//var_dump(get_current_screen()); // debug
}
add_action('admin_head', 'mg_remove_wp_helper', 999);

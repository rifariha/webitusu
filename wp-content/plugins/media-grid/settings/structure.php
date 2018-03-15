<?php 
include_once(MG_DIR . '/settings/field_options.php'); 
include_once(MG_DIR . '/settings/preset_styles.php'); 
include_once(MG_DIR . '/functions.php'); 

$ml_key = 'mg_ml';



// MG-FILTER - manipulate settings tabs
$tabs = array(
	'main_opts' 	=> __('Main Options', $ml_key),
	'lightbox' 		=> __('Lightbox', $ml_key),
	'colors' 		=> __('Colors', $ml_key),
	'typography'	=> __('Typography', $ml_key),
	'item_atts'		=> __('Item Attributes', $ml_key),
	'cust_css'		=> __('Custom CSS', $ml_key),
);
$GLOBALS['mg_settings_tabs'] = apply_filters('mg_settings_tabs', $tabs);	




// STRUCTURE
/* tabs index => array( 
	'sect_id' => array(
		'sect_name'	=> name
		'fields'	=> array(
			...
		)
	)
   )
*/

$structure = array();


####################################
########## MAIN OPTIONS ############
####################################
$structure['main_opts'] = array(
	'preset_styles' => array(
		'sect_name'	=>  __('Preset Styles', $ml_key),
		'fields' 	=> array(
			
			'preset_styles_field' => array(
				'type'		=> 'custom',
				'callback'	=> 'mg_preset_styles'
			), 
		),
	),
	
	
	'grid_layout' => array(
		'sect_name'	=>  __('Grid Layout', $ml_key),
		'fields' 	=> array(
			
			'mg_loader' => array(
				'label' 	=> __("Preloader", $ml_key),
				'type'		=> 'select',
				'val' 		=> mg_preloader_types(),
				'required'	=> true,
				'note'		=> __("Set which preloader to use for grids and lightbox", $ml_key), 
			),
			'mg_no_init_loader' => array(
				'label' => __('No loader on grid initialization?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=> __("If checked, avoid showing preloader on first grid's loading", $ml_key),
			),  
			'spcr1' => array(
				'type' => 'spacer',
			),
			
			'mg_maxwidth' => array(
				'label' 	=> __('Grids max width', $ml_key),
				'type'		=> 'slider',
				'min_val'	=> 800,
				'max_val'	=> 2500,	
				'step'		=> 50,
				'def'		=> 1200,
				'value'		=> 'px',
				'required'	=> true,
				'note'		=> __("Set grids maximum width of the grid. This parameter is used to <font style='color: #D54E21;'>manage thumbnails size and quality</font>", $ml_key),
			), 
			'mg_mobile_treshold' => array(
				'label' 	=> __('Mobile layout treshold', $ml_key),
				'type'		=> 'slider',
				'min_val'	=> 400,
				'max_val'	=> 900,	
				'step'		=> 50,
				'def'		=> 800,
				'value'		=> 'px',
				'required'	=> true,
				'note'		=> __("Set grids width treshold to switch mobile mode", $ml_key),
			), 
			'mg_cells_margin' => array(
				'label' 	=> __('Items margin', $ml_key),
				'type'		=> 'slider',
				'min_val'	=> 0,
				'max_val'	=> 30,	
				'step'		=> 1,
				'def'		=> 5,
				'value'		=> 'px',
				'required'	=> true,
				'note'		=> __("Set margin between grid items", $ml_key),
			), 
			'mg_cells_img_border' => array(
				'label' 	=> __('Items border width', $ml_key),
				'type'		=> 'slider',
				'min_val'	=> 0,
				'max_val'	=> 20,	
				'step'		=> 1,
				'def'		=> 3,
				'value'		=> 'px',
				'required'	=> true,
				'note'		=> __("Set grid items border width", $ml_key),
			), 
			'mg_cells_radius' => array(
				'label' 	=> __('Items corner radius', $ml_key),
				'type'		=> 'slider',
				'min_val'	=> 0,
				'max_val'	=> 40,	
				'step'		=> 1,
				'def'		=> 2,
				'value'		=> 'px',
				'required'	=> true,
				'note'		=> __("Set grid items corner radius", $ml_key),
			),
			'mg_cells_border' => array(
				'label' => __('Display items outline?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=> __('If checked, applies a 1px outer border to grid items', $ml_key),
			),  
			'mg_cells_shadow' => array(
				'label' => __('Display items shadow?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=> __('If checked, applies soft shadow around grid items', $ml_key),
			),  
			'mg_thumb_q' => array(
				'label' 	=> __('Thumbnails quality', $ml_key),
				'type'		=> 'slider',
				'min_val'	=> 30,
				'max_val'	=> 100,	
				'step'		=> 1,
				'def'		=> 95,
				'value'		=> '%',
				'required'	=> true,
				'note'		=> __("Set thumbnails quality. Low value = lighter but fuzzier images (default: 85%)", $ml_key),
			), 
			'mg_tu_custom_padding' => array(
				'label' 	=> __("Text under images - wrapper's padding", $ml_key),
				'type'		=> '4_numbers',
				'min_val'	=> 0,
				'max_val'	=> 40,	
				'value'		=> 'px',
				'def'		=> array(10, 7, 10, 7),
				'note'		=> __('Padding values for "text under image" mode (top-left-bottom-right)', $ml_key)
			),
			'mg_inl_txt_padding' => array(
				'label' 	=> __("Inline text items - wrapper's padding", $ml_key),
				'type'		=> '4_numbers',
				'min_val'	=> 0,
				'max_val'	=> 80,	
				'value'		=> 'px',
				'def'		=> array(15, 15, 15, 15),
				'note'		=> __('Padding values for inline text items (top-left-bottom-right)', $ml_key)
			),
			'mg_clean_inl_txt' => array(
				'label' => __('Clean inline text items?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=> __('If checked, remove shadows, borders and background for inline text items', $ml_key),
			),  
			'mg_delayed_fx' => array(
				'label' => __('Show items without delay?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=> __('If checked, show grid items together. Without delayed effect', $ml_key),
			), 
			'mg_hide_overlays' => array(
				'label' => __('Disable overlays?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=> __('If checked, overlays placed over grid images will be removed', $ml_key),
			), 
		),
	),
		
	
	'item_filters_n_search_n_pag' => array(
		'sect_name'	=>  __('Item Filters - Search - Pagination Elements', $ml_key),
		'fields' 	=> array(
			
			'mg_filters_align' => array(
				'label' 	=> __('Filters / search alignment', $ml_key),
				'type'		=> 'select',
				'val' 		=> array(
					'left' 		=> __('Left', $ml_key), 
					'center' 	=> __('Center', $ml_key),
					'right' 	=> __('Right', $ml_key)
				),
				'note'		=> __('Choose which alignment assign to filters or search bar. <strong>NB:</strong> <font style="color: #D54E21;">is discarded while using both filters and search</font>', $ml_key), 
			), 
			'mg_side_filters_width' => array(
				'label' 	=> __("Filters on side - column's width", $ml_key),
				'type'		=> 'slider',
				'min_val'	=> 100,
				'max_val'	=> 400,	
				'step'		=> 10,
				'def'		=> 160,
				'value'		=> 'px',
				'required'	=> true,
				'note'		=> __("Column's width for side filter positions", $ml_key),
			),
			'mg_filter_n_search_border_w' => array(
				'label' 	=> __("Filters and search bar border's width", $ml_key),
				'type'		=> 'slider',
				'min_val'	=> 0,
				'max_val'	=> 4,	
				'step'		=> 1,
				'def'		=> 2,
				'value'		=> 'px',
				'required'	=> true,
				'note'		=> __('<strong>NB:</strong> this applies also to pagination elements but not to textual filters', $ml_key),
			),
			'mg_filters_radius' => array(
				'label' 	=> __("Filters and search bar border radius", $ml_key),
				'type'		=> 'slider',
				'min_val'	=> 0,
				'max_val'	=> 10,	
				'step'		=> 1,
				'def'		=> 2,
				'value'		=> 'px',
				'required'	=> true,
				'note'		=> __('<strong>NB:</strong> this applies also to pagination elements but not to textual filters', $ml_key),
			),
			'mg_dd_mobile_filter' => array(
				'label' => __('Use dropdown on mobile mode?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=> __('If checked, replace filters with a dropdown on mobile mode', $ml_key),
			),
			'mg_use_old_filters' => array(
				'label' => __('Use textual filters style?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=> '',
			),   
			'mg_os_filters_separator' => array(
				'label' => __('Textual filters - separator', $ml_key),
				'type'	=> 'text',
				'note'	=> __("Specify what divides filters", $ml_key),
				
				'js_vis'=> array(
					'linked_field' 	=> 'mg_use_old_filters',
					'condition'		=> true 
				)
			),	
			'mg_all_filter_txt' => array(
				'label' => __("\"all\" filter's text", $ml_key),
				'type'	=> 'text',
				'def' 	=> 'All',
				'note'	=> __("Use a custom text for \"all\" filter's text", $ml_key),
			),
			'mg_no_results_txt' => array(
				'label' => __('"no results" text', $ml_key),
				'type'	=> 'text',
				'note'	=> __("Set a different message to be shown when no items are found searching or filtering", $ml_key),
			),
			
			'spcr1' => array(
				'type' => 'spacer',
			),
			'mg_pag_align' => array(
				'label' 	=> __('Pagination commands alignment', $ml_key),
				'type'		=> 'select',
				'val' 		=> array(
					'left' 		=> __('Left', $ml_key), 
					'center' 	=> __('Center', $ml_key),
					'right' 	=> __('Right', $ml_key)
				),
				'note'		=> ''
			), 
			'mg_pag_border_w' => array(
				'label' 	=> __("Pagination commands - border's width", $ml_key),
				'type'		=> 'slider',
				'min_val'	=> 0,
				'max_val'	=> 4,	
				'step'		=> 1,
				'def'		=> 1,
				'value'		=> 'px',
				'required'	=> true,
				'note'		=> ''
			), 
			'mg_pag_layout' => array(
				'label' 	=> __("Default pagination commands layout", $ml_key),
				'type'		=> 'select',
				'val' 		=> mg_pag_layouts(),
				'note'		=> __('Select pagination elements layout. Can be overrided creating shortcode', $ml_key), 
			),  
			'mg_monopage_filter' => array(
				'label' => __('Limit filter and search to shown page?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=>  __("If checked, only items belonging to shown page will be filtered", $ml_key),
			), 
			'mg_filters_behav' => array(
				'label' 	=> __("Filtered items behavior", $ml_key),
				'type'		=> 'select',
				'val' 		=> array(
					'standard'	=> __('Hide and reorder', $ml_key), 
					'opacity' 	=> __('Reduce opacity', $ml_key),
					'0_opacity' => __('Zero opacity', $ml_key),
 				),
				'note'		=> __("<font style='color: #D54E21;'><strong>NB:</strong> opacity-based behaviors are used only on 1-page grids or if filters are applied on shown page</font>", $ml_key), 
			),  
		),
	),
	
	
	'inl_slider' => array(
		'sect_name'	=>  __('Inline Slider Settings', $ml_key),
		'fields' 	=> array(
			  
			'mg_inl_slider_fx' => array(
				'label' 	=> __("Transition effect", $ml_key),
				'type'		=> 'select',
				'val' 		=> mg_inl_slider_fx(),
				'note'		=> __('Select transition effects between slides', $ml_key), 
			),  
			'mg_inl_slider_easing' => array(
				'label' 	=> __("Transition easing", $ml_key),
				'type'		=> 'select',
				'val' 		=> mg_easings(),
				'note'		=> __('Select transition effects easing', $ml_key), 
			),  
			'mg_inl_slider_fx_time' => array(
				'label' 	=> __("Transition duration", $ml_key),
				'type'		=> 'slider',
				'min_val'	=> 100,
				'max_val'	=> 1000,	
				'step'		=> 50,
				'def'		=> 400,
				'value'		=> 'ms',
				'required'	=> true,
				'note'		=> __("Set how much time transition takes (in milliseconds)", $ml_key),
			),
			'mg_inl_slider_interval' => array(
				'label' 	=> __("Slideshow interval", $ml_key),
				'type'		=> 'slider',
				'min_val'	=> 1000,
				'max_val'	=> 10000,	
				'step'		=> 500,
				'def'		=> 3000,
				'value'		=> 'ms',
				'required'	=> true,
				'note'		=> __("Set how long each slide will be shown (in milliseconds)", $ml_key),
			),
			'mg_inl_slider_cmd_pos' => array(
				'label' 	=> __("Commands position", $ml_key),
				'type'		=> 'select',
				'val' 		=> array(
					'top' => __("top", $ml_key),
					'mid' => __("middle", $ml_key),
				),
				'note'		=> '', 
			),  
			'mg_inl_slider_play_btn' => array(
				'label' => __('Show play/pause button?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=> __("If checked, shows play/pause button to control slideshow", $ml_key),
			),   
			'mg_inl_slider_hide_btn' => array(
				'label' => __('Hide commands on default state?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=> __("If checked, commands will be shown only on hover", $ml_key),
			),   
			'mg_inl_slider_pause_on_h' => array(
				'label' => __('Pause slideshow on hover?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=> __("If checked, pauses slideshow on mouse hover", $ml_key),
			),
			'mg_inl_slider_no_touch' => array(
				'label' => __('Disable touchswipe integration?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=> __("If checked, disables touchswipe integration", $ml_key),
			),     
		), 
	),
	
	
	'socials' => array(
		'sect_name'	=>  __('Socials', $ml_key),
		'fields' 	=> array(
			  
			'mg_twitter' => array(
				'label' => __('Use Twitter share?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=> __("If checked, displays Twitter button in lightbox", $ml_key),
			),  
			'mg_pinterest' => array(
				'label' => __('Use Pinterest share?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=> __("If checked, displays Pinterest button in lightbox", $ml_key),
			),  
			'mg_googleplus' => array(
				'label' => __('Use Google+ share?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=> __("If checked, displays Google+ button in lightbox <strong>(only with items deeplinking)</strong>", $ml_key),
			),  
			
			'mg_facebook' => array(
				'label' => __('Use Facebook share?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=> __("If checked, displays Facebook button in lightbox", $ml_key),
			),  
			'mg_fb_direct_share_app_id' => array(
				'label' => __('Facebook App ID', $ml_key),
				'type'	=> 'text',
				'note'	=> __('To use Facebook direct share you must have an <a href="https://developers.facebook.com/docs/apps/register" target="_blank">app ID</a> to use.<br>Remember to stup the app to be used by the actual domain', $ml_key),
				
				'js_vis'=> array(
					'linked_field' 	=> 'mg_facebook',
					'condition'		=>  true
				)
			),
		),
	),
	
	
	'deeplinking' => array(
		'sect_name'	=>  __('Deeplinking', $ml_key) . ' <small>('. __('system adding URL parameters for direct linking', $ml_key) .')</small>',
		'fields' 	=> array(
			  
			'mg_deeplinked_elems' => array(
				'label' 	=> __("Deeplinked elements", $ml_key),
				'type'		=> 'select',
				'multiple'	=> true,
				'val' 		=> mg_elem_to_deeplink(),
				'fullwidth'	=> true,
				'def' 		=> array_keys(mg_elem_to_deeplink()),
				'note'		=> __('Choose which grid systems will have their direct URL', $ml_key), 
			),  
			'mg_full_deeplinking' => array(
				'label' => __('Use full deeplinking?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=> __("If checked, a browser's history step is created for grid operations of the same type", $ml_key),
			),
			'spcr1' => array(
				'type' => 'spacer',
			),  
			'xml_sitemap_url' => array(
				'label' 	=> __("Items XML sitemap location", $ml_key),
				'type'		=> 'label_message',
				'content'	=> '<a href="'.MG_URL.'/items_xml_sitemap.php" target="_blank" style="color: #21759b !important;"><strong>'.MG_URL.'/items_xml_sitemap.php</strong></a>',
			),
			'mg_sitemap_baseurl' => array(
				'label' 	=> __('XML sitemap - items base-url', $ml_key),
				'type'		=> 'text',
				'fullwidth'	=> true,
				'note'		=> __("Set custom base-url to use for items link in the sitemap. By default is homepage URL", $ml_key),
			),
		),
	),
);	
		
	
// WooCommerce 
if($GLOBALS['mg_woocom_active']) {	
$structure['main_opts'] = $structure['main_opts'] + array(
	
	'woocommerce' => array(
		'sect_name'	=>  'WooCommerce',
		'fields' 	=> array(
			  
			'mg_wc_hide_add_to_cart' => array(
				'label' => __('Hide "add to cart" button?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=> __("If checked, hides AJAX add-to-cart button in lightbox", $ml_key),
			),  
			'mg_wc_hide_attr' => array(
				'label' => __('Hide product attributes?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=> __("If checked, hides product attributes in lightbox", $ml_key),
			),  
			'mg_use_wc_attr_variations' => array(
				'label' => __('Show also attributes used as variations?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=> ''
			),  
		),
	)
);
} // END WooCommerce part

	
$structure['main_opts'] = $structure['main_opts'] + array(	
	
	'various' => array(
		'sect_name'	=>  __('Various', $ml_key),
		'fields' 	=> array(
			 
			'mg_disable_rclick' => array(
				'label' => __('Disable right click?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=> __("If checked, disables right click on grid and lightbox elements", $ml_key),
			), 
			'mg_kenburns_timing' => array(
				'label' 	=> __("Ken Burns effect's timing", $ml_key),
				'type'		=> 'slider',
				'min_val'	=> 3000,
				'max_val'	=> 20000,	
				'step'		=> 200,
				'def'		=> 8600,
				'value'		=> 'ms',
				'required'	=> true,
				'note'		=> __("Set how long Ken Burns effect takes to play once (in milliseconds). <strong>Doesn't apply to inline slider</strong>", $ml_key),
			),
			'spcr1' => array(
				'type' => 'spacer',
			),   
			'mg_preview_pag' => array(
				'label' 	=> __("Grid builder - preview container", $ml_key),
				'type'		=> 'select',
				'val' 		=> mg_pages_list(),
				'note'		=> __('Choose the site page to use as preview container', $ml_key), 
			),  
			'mg_builder_behav' => array(
				'label' 	=> __("Grid builder - add item behavior", $ml_key),
				'type'		=> 'select',
				'val' 		=> array(
					'append' 	=> __('Append item', $ml_key), 
					'prepend' 	=> __('Prepend item', $ml_key),
				),
				'note'		=> __('Choose items addition behavior in grid builder', $ml_key), 
			),  
		),
	),
	
	
	'advanced' => array(
		'sect_name'	=>  __('Advanced', $ml_key),
		'fields' 	=> array(
			  
			'mg_force_inline_css' => array(
				'label' => __('Use custom CSS inline?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=> __("If checked, uses custom CSS inline <strong>(useful for multisite installations)</strong>", $ml_key),
			), 
			'mg_js_head' => array(
				'label' => __("Use javascript in website's head?", $ml_key),
				'type'	=> 'checkbox',
				'note'	=> __("<strong>Check it ONLY IF you notice some incompatibilities</strong>", $ml_key),
			),   
			'mg_rtl_grid' => array(
				'label' => __("RTL mode?", $ml_key),
				'type'	=> 'checkbox',
				'note'	=> __("Displays grids in RTL mode (eg. for hebrew)", $ml_key),
			), 
			'spcr1' => array(
				'type' => 'spacer',
			),    
			'mg_use_timthumb' => array(
				'label' => __('Use TimThumb?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=> __("If checked, use Timthumb instead of Easy WP Thumbs", $ml_key),
			),  
			'mg_ewpt_force' => array(
				'label' => __('Use Easy WP Thumbs forcing system?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=> __("Tries forcing thumbnails creation, <strong>check it ONLY if you notice thumbnail issues</strong>", $ml_key),
				
				'js_vis'=> array(
					'linked_field' 	=> 'mg_use_timthumb',
					'condition'		=> false
				)
			),   
		),
	),
	
	
	'ewpt_status' => array(
		'sect_name'	=> '',
		'fields' 	=> array(
			
			'ewpt_status' => array(
				'type'		=> 'custom',
				'callback'	=> 'mg_ewpt_status',
			), 
		),
	),
);
	
	
	
	
####################################
########### LIGHTBOX ###############
####################################		
$structure['lightbox'] = array(
	'lb_main_opts' => array(
		'sect_name'	=>  __('Lightbox Main Settings', $ml_key),
		'fields' 	=> array(
			
			'mg_lb_loader_radius' => array(
				'label' 	=> __("Lightbox loader's border radius", $ml_key),
				'type'		=> 'slider',
				'min_val'	=> 0,
				'max_val'	=> 50,	
				'step'		=> 1,
				'def'		=> 10,
				'value'		=> '%',
				'required'	=> true,
				'note'		=> __("Use 50% to render a circle - default: 18)", $ml_key),
			),
			'mg_item_width' => array(
				'label' 	=> __("Elastic width", $ml_key),
				'type'		=> 'slider',
				'min_val'	=> 30,
				'max_val'	=> 100,	
				'step'		=> 1,
				'def'		=> 70,
				'value'		=> '%',
				'required'	=> true,
				'note'		=> __("Width percentage of the lightbox in relation to the screen (default: 70)", $ml_key),
			),
			'mg_item_maxwidth' => array(
				'label' 	=> __("Maximum width", $ml_key),
				'type'		=> 'text',
				'note'		=> __("Maximum lightbox width in pixels (default: 960)", $ml_key),
			),
			'mg_lb_padding' => array(
				'label' 	=> __("Padding", $ml_key),
				'type'		=> 'slider',
				'min_val'	=> 0,
				'max_val'	=> 40,	
				'step'		=> 1,
				'def'		=> 20,
				'value'		=> 'px',
				'note'		=> __("Set lightbox padding (default 20 - if using inside commands, top padding is 40px)", $ml_key),
			),
			'mg_lb_border_w' => array(
				'label' 	=> __("Border width", $ml_key),
				'type'		=> 'slider',
				'min_val'	=> 0,
				'max_val'	=> 20,	
				'step'		=> 1,
				'def'		=> 2,
				'value'		=> 'px',
				'note'		=> ''
			),
			'mg_item_radius' => array(
				'label' 	=> __("Border radius", $ml_key),
				'type'		=> 'slider',
				'min_val'	=> 0,
				'max_val'	=> 20,	
				'step'		=> 1,
				'def'		=> 3,
				'value'		=> 'px',
				'note'		=> ''
			),
			'mg_lb_shadow' => array(
				'label' 	=> __("Shadow style", $ml_key),
				'type'		=> 'select',
				'val' 		=> array(
					'none' 	=> __('No shadow', $ml_key), 
					'soft' 	=> __('Soft', $ml_key),
					'heavy' => __('Heavy', $ml_key),
				),
				'note'		=>  ''
			),  
			'mg_lb_no_txt_fx' => array(
				'label' => __('Disable text showing effect?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=> __("If checked, disables text showing effect on lightbox opening", $ml_key),
			),  
			'mg_modal_lb' => array(
				'label' => __('Use as modal?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=> __("If checked, lightbox can be closed only used closing button", $ml_key),
			),  
			'mg_lb_touchswipe' => array(
				'label' => __('Enable touch interactions?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=> __("If checked, lightbox navigation can be done also swiping", $ml_key),
			),  
			'mg_lb_carousel' => array(
				'label' => __('Carousel mode?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=> __("If checked, navigation restart once reached last item", $ml_key),
			),  
			'mg_lb_socials_style' => array(
				'label' 	=> __("Socials style", $ml_key),
				'type'		=> 'select',
				'val' 		=> array(
					'squared' 	=> __('Squared', $ml_key), 
					'rounded'	=> __('Rounded', $ml_key),
					'minimal' 	=> __('Minimal', $ml_key),
					'old' 		=> __('Static images', $ml_key),
				),
				'note'		=>  __("Select social icons style", $ml_key),
			),  
			'mg_lb_cmd_pos' => array(
				'label' 	=> __("Commands position", $ml_key),
				'type'		=> 'select',
				'val' 		=> mg_lb_cmd_layouts(),
				'note'		=>  __("Select lightbox commands position. On mobile, detached will be moved inside", $ml_key),
			), 
			'mg_lb_inner_cmd_boxed' => array(
				'label' => __('Boxed layout for inner lightbox commands?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=> '',
			), 
			'mg_lb_entrance_fx' => array(
				'label' 	=> __("Lightbox entrance effect", $ml_key),
				'type'		=> 'select',
				'val' 		=> array(
					'static_fade' 	=> __('Static fade', $ml_key), 
					'slide_bounce'	=> __('Slide and bounce', $ml_key),
					'slide_fade' 	=> __('Slide and fade', $ml_key),
				),
				'note'		=> '',
			),   
		),
	),
	
	
	'lb_bg' => array(
		'sect_name'	=>  __('Lightbox Background', $ml_key),
		'fields' 	=> array(
			
			'mg_lb_bg_fx' => array(
				'label' 	=> __("Background showing effect", $ml_key),
				'type'		=> 'select',
				'val' 		=> mg_lb_bg_showing_fx(),
				'note'		=> '',
			),
			'mg_lb_bg_fx_time' => array(
				'label' 	=> __("Background effect's duration", $ml_key),
				'type'		=> 'slider',
				'min_val'	=> 100,
				'max_val'	=> 2000,	
				'step'		=> 100,
				'def'		=> 400,
				'value'		=> 'ms',
				'required'	=> true,
				'note'		=> __("Choose how long background showing animation takes (in milliseconds)", $ml_key),
			),
			'mg_lb_bg_fx_easing' => array(
				'label' 	=> __("Background effect's easing", $ml_key),
				'type'		=> 'select',
				'val' 		=> mg_easings(),
				'note'		=> '',
			),
		),
	),
	
	
	'lb_audio_video' => array(
		'sect_name'	=>  __('Audio & Video Players', $ml_key),
		'fields' 	=> array(
			
			'mg_video_autoplay' => array(
				'label' => __('Autoplay videos?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=> __("If checked, autoplays lightbox videos", $ml_key),
			), 
			'mg_audio_autoplay' => array(
				'label' => __('Autoplay tracks?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=> __("If checked, autoplays lightbox audio elements", $ml_key),
			), 
			'mg_show_tracklist' => array(
				'label' => __('Show audio tracklist by default?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=> ''
			), 
			'mg_audio_loop_by_default' => array(
				'label' => __('Enable audio loop by default?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=> __("If checked, enables loop function by default. Use it also to <strong>automatically play tracklist elements</strong>", $ml_key),
			), 
		),
	),
	
	
	'lb_slider' => array(
		'sect_name'	=>  __('Slider', $ml_key),
		'fields' 	=> array(
			
			'mg_lb_entrance_fx' => array(
				'label' 	=> __("Style", $ml_key),
				'type'		=> 'select',
				'val' 		=> array(
					'light' => __('Light', $ml_key), 
					'dark'	=> __('Dark', $ml_key),
				),
				'note'		=> '',
			),  
			'mg_slider_main_w' => array(
				'label' 		=> __("Height", $ml_key),
				'type'			=> 'val_n_type',
				'max_val_len'	=> 3,
				'def'			=> 55,
				'types' 		=> array(
					'%' 	=> '%', 
					'px'	=> 'px',
					'vw'	=> 'vw',
					'vh'	=> 'vh',
				),
				'note'		=> __("Default slider's height (% is related to its width)", $ml_key),
			),  
			'mg_slider_fx' => array(
				'label' 	=> __("Transition effect", $ml_key),
				'type'		=> 'select',
				'val' 		=> mg_galleria_fx(),
				'note'		=> __("Select transition effect between slides", $ml_key),
			),  
			'mg_slider_fx_time' => array(
				'label' 	=> __("Transition duration", $ml_key),
				'type'		=> 'slider',
				'min_val'	=> 100,
				'max_val'	=> 1000,	
				'step'		=> 50,
				'def'		=> 400,
				'value'		=> 'ms',
				'required'	=> true,
				'note'		=> __("Set how much time transition takes (in milliseconds)", $ml_key),
			),
			'mg_slider_interval' => array(
				'label' 	=> __("Slideshow interval", $ml_key),
				'type'		=> 'slider',
				'min_val'	=> 1000,
				'max_val'	=> 10000,	
				'step'		=> 500,
				'def'		=> 3000,
				'value'		=> 'ms',
				'required'	=> true,
				'note'		=> __("Set how long each slide will be shown (in milliseconds)", $ml_key),
			),
			'mg_lb_slider_counter' => array(
				'label' => __('Display elements counter?', $ml_key),
				'type'	=> 'checkbox',
				'note'	=> '',
			), 
		),
	),
	
	
	'lb_comments' => array(
		'sect_name'	=>  __('Comments', $ml_key),
		'fields' 	=> array(
			
			'mg_lb_comments' => array(
				'label' 	=> __("Use comments?", $ml_key),
				'type'		=> 'select',
				'val' 		=> array(
					'' 			=> __('No', $ml_key), 
					'disqus'	=> 'Disqus',
					'fb'		=> 'Facebook'
				),
				'note'		=> '',
			),  
			'mg_lbc_disqus_shortname' => array(
				'label' => __('Disqus shortname', $ml_key),
				'type'	=> 'text',
				'note'	=> __("Use the <a href='https://help.disqus.com/customer/portal/articles/466208' target='_blank'>Disqus shortname</a>", $ml_key),
				
				'js_vis'=> array(
					'linked_field' 	=> 'mg_lb_comments',
					'condition'		=> 'disqus' 
				)
			),
			
			'mg_lbc_fb_app_id' => array(
				'label' => __('Facebook App ID', $ml_key),
				'type'	=> 'text',
				'note'	=> __('To use Facebook comments you must have an <a href="https://developers.facebook.com/docs/apps/register" target="_blank">app ID</a> to use.<br>Remember to setup moderators <a href="https://developers.facebook.com/tools/comments" target="_blank">here</a>', $ml_key),
				
				'js_vis'=> array(
					'linked_field' 	=> 'mg_lb_comments',
					'condition'		=> 'fb' 
				)
			),
			'mg_lbc_fb_style' => array(
				'label' 	=> __('Style', $ml_key),
				'type'		=> 'select',
				'val' 		=> array(
					'light' => __('Light', $ml_key), 
					'dark' 	=> __('Dark', $ml_key),
				),
				'note'		=> '',
				
				'js_vis'=> array(
					'linked_field' 	=> 'mg_lb_comments',
					'condition'		=> 'fb' 
				)
			),
		),
	),
);	




####################################
############ COLORS ################
####################################		
$structure['colors'] = array(
	'grid_items' => array(
		'sect_name'	=>  __('Grid Items', $ml_key),
		'fields' 	=> array(
			
			'mg_loader_color' => array(
				'label' 	=> __("Grid's loading animation color", $ml_key),
				'type'		=> 'color',
				'def'		=> '#999999',
				'required'	=> true,
			),
			'mg_img_border_color' => array(
				'label' 	=> __("Items border color", $ml_key),
				'type'		=> 'color',
				'def'		=> '#e0e0e0',
				'required'	=> true,
			),
			'mg_img_border_opacity' => array(
				'label' 	=> __("Items border opacity", $ml_key),
				'type'		=> 'slider',
				'min_val'	=> 0,
				'max_val'	=> 100,	
				'step'		=> 5,
				'def'		=> 100,
				'value'		=> '',
				'required'	=> true,
			),
			'mg_cells_border_color' => array(
				'label' 	=> __("Items outline color", $ml_key),
				'type'		=> 'color',
				'def'		=> '#aaaaaa',
				'required'	=> true,
			),
		),
	),
	
	
	'items_ol' => array(
		'sect_name'	=>  __('Item overlays', $ml_key),
		'fields' 	=> array(
			
			'mg_main_overlay_color' => array(
				'label' 	=> __("Main overlay's color", $ml_key),
				'type'		=> 'color',
				'def'		=> '#f8f8f8',
				'required'	=> true,
			),
			'mg_main_overlay_opacity' => array(
				'label' 	=> __("Main overlay's opacity", $ml_key),
				'type'		=> 'slider',
				'min_val'	=> 0,
				'max_val'	=> 100,	
				'step'		=> 5,
				'def'		=> 85,
				'value'		=> '',
				'required'	=> true,
			),
			'mg_overlay_title_color' => array(
				'label' 	=> __("Main overlay - texts color", $ml_key),
				'type'		=> 'color',
				'def'		=> '#444444',
				'required'	=> true,
			),
			'mg_second_overlay_color' => array(
				'label' 	=> __("Corner overlay's color", $ml_key),
				'type'		=> 'color',
				'def'		=> '#595959',
				'required'	=> true,
			),
			'mg_icons_col' => array(
				'label' 	=> __("Corner overlay - icons color", $ml_key),
				'type'		=> 'color',
				'def'		=> '#ffffff',
				'required'	=> true,
			),
			'spcr1' => array(
				'type' => 'spacer',
			),  
			'mg_txt_under_color' => array(
				'label' 	=> __("Texts under image's color", $ml_key),
				'type'		=> 'color',
				'def'		=> '#555555',
				'required'	=> true,
				'note'		=> __('Color applied for grids using "text under images" mode', $ml_key),
			),
		),
	),
	
	
	'filters_n_search' => array(
		'sect_name'	=>  __('Item Filters and Search Bar', $ml_key),
		'fields' 	=> array(
   
			'mg_filters_txt_color' => array(
				'label' 	=> __("Filters text color", $ml_key) .' - '. __('default state', $ml_key),
				'type'		=> 'color',
				'def'		=> '#707070',
				'required'	=> true,
			),
			'mg_filters_bg_color' => array(
				'label' 	=> __("Filters background color", $ml_key) .' - '. __('default state', $ml_key),
				'type'		=> 'color',
				'def'		=> '#f5f5f5',
				'allow_transparent'	=> true,
				'required'	=> true,
				'note'		=> __('accepts also "transparent" value', $ml_key),
			),
			'mg_filters_border_color' => array(
				'label' 	=> __("Filters border color", $ml_key) .' - '. __('default state', $ml_key),
				'type'		=> 'color',
				'def'		=> '#f5f5f5',
				'allow_transparent'	=> true,
				'required'	=> true,
				'note'		=> __('accepts also "transparent" value', $ml_key),
			),
			'mg_filters_txt_color_h' => array(
				'label' 	=> __("Filters text color", $ml_key) .' - '. __('hover state', $ml_key),
				'type'		=> 'color',
				'def'		=> '#707070',
				'required'	=> true,
			),
			'mg_filters_bg_color_h' => array(
				'label' 	=> __("Filters background color", $ml_key) .' - '. __('hover state', $ml_key),
				'type'		=> 'color',
				'def'		=> '#ffffff',
				'allow_transparent'	=> true,
				'required'	=> true,
				'note'		=> __('accepts also "transparent" value', $ml_key),
			),
			'mg_filters_border_color_h' => array(
				'label' 	=> __("Filters border color", $ml_key) .' - '. __('hover state', $ml_key),
				'type'		=> 'color',
				'def'		=> '#909090',
				'allow_transparent'	=> true,
				'required'	=> true,
				'note'		=> __('accepts also "transparent" value', $ml_key),
			),
			'mg_filters_txt_color_sel' => array(
				'label' 	=> __("Filters text color", $ml_key) .' - '. __('selected state', $ml_key),
				'type'		=> 'color',
				'def'		=> '#5e5e5e',
				'required'	=> true,
			),
			'mg_filters_bg_color_sel' => array(
				'label' 	=> __("Filters background color", $ml_key) .' - '. __('selected state', $ml_key),
				'type'		=> 'color',
				'def'		=> '#f0f0f0',
				'allow_transparent'	=> true,
				'required'	=> true,
				'note'		=> __('accepts also "transparent" value', $ml_key),
			),
			'mg_filters_border_color_sel' => array(
				'label' 	=> __("Filters border color", $ml_key) .' - '. __('selected state', $ml_key),
				'type'		=> 'color',
				'def'		=> '#999999',
				'allow_transparent'	=> true,
				'required'	=> true,
				'note'		=> __('accepts also "transparent" value', $ml_key),
			),
			
			'spcr1' => array(
				'type' => 'spacer',
			),
			
			'mg_search_txt_color' => array(
				'label' 	=> __("Search bar text color", $ml_key) .' - '. __('default state', $ml_key),
				'type'		=> 'color',
				'def'		=> '#707070',
				'required'	=> true,
			),
			'mg_search_bg_color' => array(
				'label' 	=> __("Search bar background color", $ml_key) .' - '. __('default state', $ml_key),
				'type'		=> 'color',
				'def'		=> '#f5f5f5',
				'allow_transparent'	=> true,
				'required'	=> true,
				'note'		=> __('accepts also "transparent" value', $ml_key),
			),
			'mg_search_border_color' => array(
				'label' 	=> __("Search bar border color", $ml_key) .' - '. __('default state', $ml_key),
				'type'		=> 'color',
				'def'		=> '#f5f5f5',
				'allow_transparent'	=> true,
				'required'	=> true,
				'note'		=> __('accepts also "transparent" value', $ml_key),
			),
			'mg_search_txt_color_h' => array(
				'label' 	=> __("Search bar text color", $ml_key) .' - '. __('active state', $ml_key),
				'type'		=> 'color',
				'def'		=> '#5e5e5e',
				'required'	=> true,
			),
			'mg_search_bg_color_h' => array(
				'label' 	=> __("Search bar background color", $ml_key) .' - '. __('active state', $ml_key),
				'type'		=> 'color',
				'def'		=> '#ffffff',
				'allow_transparent'	=> true,
				'required'	=> true,
				'note'		=> __('accepts also "transparent" value', $ml_key),
			),
			'mg_search_border_color_h' => array(
				'label' 	=> __("Search bar border color", $ml_key) .' - '. __('active state', $ml_key),
				'type'		=> 'color',
				'def'		=> '#707070',
				'allow_transparent'	=> true,
				'required'	=> true,
				'note'		=> __('accepts also "transparent" value', $ml_key),
			),
		),
	),
	
	
	'pag_btns' => array(
		'sect_name'	=>  __('Pagination Elements', $ml_key),
		'fields' 	=> array(
   
   			'mg_pag_txt_col' => array(
				'label' 	=> __("Texts and arrows color", $ml_key) .' - '. __('default state', $ml_key),
				'type'		=> 'color',
				'def'		=> '#707070',
				'required'	=> true,
			),
			'mg_pag_bg_col' => array(
				'label' 	=> __("Background color", $ml_key) .' - '. __('default state', $ml_key),
				'type'		=> 'color',
				'def'		=> '#f5f5f5',
				'allow_transparent'	=> true,
				'required'	=> true,
				'note'		=> __('accepts also "transparent" value', $ml_key),
			),
			'mg_pag_border_col' => array(
				'label' 	=> __("Border color", $ml_key) .' - '. __('default state', $ml_key),
				'type'		=> 'color',
				'def'		=> '#f5f5f5',
				'required'	=> true,
			),
			
			'spcr1' => array(
				'type' => 'spacer',
			),
			
			'mg_pag_txt_col_h' => array(
				'label' 	=> __("Texts and arrows color", $ml_key) .' - '. __('active state', $ml_key),
				'type'		=> 'color',
				'def'		=> '#5e5e5e',
				'required'	=> true,
			),
			'mg_pag_bg_col_h' => array(
				'label' 	=> __("Background color", $ml_key) .' - '. __('active state', $ml_key),
				'type'		=> 'color',
				'def'		=> '#f0f0f0',
				'allow_transparent'	=> true,
				'required'	=> true,
				'note'		=> __('accepts also "transparent" value', $ml_key),
			),
			'mg_pag_border_col_h' => array(
				'label' 	=> __("Border color", $ml_key) .' - '. __('active state', $ml_key),
				'type'		=> 'color',
				'def'		=> '#999999',
				'required'	=> true,
			),
		),
	),
	
	
	'lb' => array(
		'sect_name'	=>  __('Lightbox', $ml_key),
		'fields' 	=> array(
   
			'mg_item_overlay_color' => array(
				'label' 	=> __("Overlay color", $ml_key),
				'type'		=> 'color',
				'def'		=> '#f9f9f9',
				'required'	=> true,
				'note'		=> __("Fullscreen lightbox overlay color", $ml_key),
			),
			'mg_item_overlay_opacity' => array(
				'label' 	=> __("Overlay opacity", $ml_key),
				'type'		=> 'slider',
				'min_val'	=> 0,
				'max_val'	=> 100,	
				'step'		=> 5,
				'def'		=> 75,
				'value'		=> '%',
				'required'	=> true,
				'note'		=> __("Fullscreen lightbox overlay opacity", $ml_key),
			),
			'mg_item_overlay_pattern' => array(
				'type'		=> 'custom',
				'callback'	=> 'mg_item_overlay_pattern_f',
				'validation'=> array(
					array('index' => 'mg_item_overlay_pattern', 'label' => 'Lb overlay pattern'),
				)
			), 
			'mg_item_bg_color' => array(
				'label' 	=> __("Background color", $ml_key),
				'type'		=> 'color',
				'def'		=> '#ffffff',
				'required'	=> true,
			),
			'mg_item_border_color' => array(
				'label' 	=> __("Border color", $ml_key),
				'type'		=> 'color',
				'def'		=> '#e6e6e6',
				'required'	=> true,
			),
			'mg_item_txt_color' => array(
				'label' 	=> __("Text color", $ml_key),
				'type'		=> 'color',
				'def'		=> '#333333',
				'required'	=> true,
			),
			'mg_item_hr_color' => array(
				'label' 	=> __("Separators color", $ml_key),
				'type'		=> 'color',
				'def'		=> '#d4d4d4',
				'required'	=> true,
				'note'		=> __("Lightbox elements separator color", $ml_key),
			),
			'mg_item_icons_color' => array(
				'label' 	=> __("Icons color", $ml_key),
				'type'		=> 'color',
				'def'		=> '#3a3a3a',
				'required'	=> true,
				'note'		=> __("Lightbox commands, loader and social icons color", $ml_key),
			),
			'mg_item_cmd_bg' => array(
				'label' 	=> __("Commands background", $ml_key),
				'type'		=> 'color',
				'def'		=> '#f1f1f1',
				'required'	=> true,
				'note'		=> __('Background color for "inside boxed" and "upon" commands', $ml_key),
			),
		),
	),
);





####################################
########## TYPOGRAPHY ##############
####################################		
$structure['typography'] = array(
	'grid_items' => array(
		'sect_name'	=>  __('Grid Items', $ml_key),
		'fields' 	=> array(
			
			'mg_ol_font_size' => array(
				'label' 	=> __("Main overlay - font size", $ml_key),
				'type'		=> 'slider',
				'min_val'	=> 8,
				'max_val'	=> 25,	
				'step'		=> 1,
				'def'		=> 15,
				'value'		=> 'px',
				'required'	=> true,
			),
			'mg_mobile_ol_font_size' => array(
				'label' 	=> __("Main overlay - font size (on mobile)", $ml_key),
				'type'		=> 'slider',
				'min_val'	=> 8,
				'max_val'	=> 25,	
				'step'		=> 1,
				'def'		=> 13,
				'value'		=> 'px',
				'required'	=> true,
			),
			'mg_ol_font_family' => array(
				'label' => __('Main overlay - font family', $ml_key),
				'type'	=> 'text',
				'note'	=> __("Leave empty to use the default one", $ml_key),
			),
			
			'spcr1' => array(
				'type' => 'spacer',
			),
			
			'mg_txt_under_font_size' => array(
				'label' 	=> __("Text under items - font size", $ml_key),
				'type'		=> 'slider',
				'min_val'	=> 8,
				'max_val'	=> 25,	
				'step'		=> 1,
				'def'		=> 15,
				'value'		=> 'px',
				'required'	=> true,
			),
			'mg_mobile_txt_under_font_size' => array(
				'label' 	=> __("Text under items - font size (on mobile)", $ml_key),
				'type'		=> 'slider',
				'min_val'	=> 8,
				'max_val'	=> 25,	
				'step'		=> 1,
				'def'		=> 13,
				'value'		=> 'px',
				'required'	=> true,
			),
			'mg_txt_under_font_family' => array(
				'label' => __('Text under items - font family', $ml_key),
				'type'	=> 'text',
				'note'	=> __("Leave empty to use the default one", $ml_key),
			),
		),
	),
	
	
	'filters_n_search_n_pag' => array(
		'sect_name'	=>  __('Filters - Search Bar', $ml_key),
		'fields' 	=> array(
			
			'mg_filters_font_size' => array(
				'label' 	=> __("Font size (on desktop)", $ml_key),
				'type'		=> 'slider',
				'min_val'	=> 8,
				'max_val'	=> 25,	
				'step'		=> 1,
				'def'		=> 14,
				'value'		=> 'px',
				'required'	=> true,
			),
			'mg_mobile_filters_font_size' => array(
				'label' 	=> __("Font size (on mobile)", $ml_key),
				'type'		=> 'slider',
				'min_val'	=> 8,
				'max_val'	=> 25,	
				'step'		=> 1,
				'def'		=> 12,
				'value'		=> 'px',
				'required'	=> true,
			),
			'mg_filters_font_family' => array(
				'label' => __('Font family', $ml_key),
				'type'	=> 'text',
				'note'	=> __("Leave empty to use the default one", $ml_key),
			),
		),
	),
	
	
	'lb' => array(
		'sect_name'	=>  __('Lightbox', $ml_key),
		'fields' 	=> array(
			
			'mg_lb_title_font_size' => array(
				'label' 	=> __("Title - font size", $ml_key),
				'type'		=> 'slider',
				'min_val'	=> 14,
				'max_val'	=> 35,	
				'step'		=> 1,
				'def'		=> 20,
				'value'		=> 'px',
				'required'	=> true,
			),
			'mg_mobile_lb_title_font_size' => array(
				'label' 	=> __("Title - font size (on mobile)", $ml_key),
				'type'		=> 'slider',
				'min_val'	=> 14,
				'max_val'	=> 35,	
				'step'		=> 1,
				'def'		=> 17,
				'value'		=> 'px',
				'required'	=> true,
			),
			'mg_lb_title_font_family' => array(
				'label' => __('Title - font family', $ml_key),
				'type'	=> 'text',
				'note'	=> __("Leave empty to use the default one", $ml_key),
			),
			
			'spcr1' => array(
				'type' => 'spacer',
			),
			
			'mg_lb_txt_font_size' => array(
				'label' 	=> __("Text - font size", $ml_key),
				'type'		=> 'slider',
				'min_val'	=> 8,
				'max_val'	=> 25,	
				'step'		=> 1,
				'def'		=> 15,
				'value'		=> 'px',
				'required'	=> true,
			),
			'mg_mobile_lb_txt_font_size' => array(
				'label' 	=> __("Text - font size (on mobile)", $ml_key),
				'type'		=> 'slider',
				'min_val'	=> 8,
				'max_val'	=> 25,	
				'step'		=> 1,
				'def'		=> 13,
				'value'		=> 'px',
				'required'	=> true,
			),
			'mg_lb_txt_font_family' => array(
				'label' => __('Text - font family', $ml_key),
				'type'	=> 'text',
				'note'	=> __("Leave empty to use the default one", $ml_key),
			),
		),
	),
);





####################################
######## ITEM ATTRIBUTES ###########
####################################		

$ia_validation_arr = array();
foreach(mg_main_types() as $type => $name) {
	$ia_validation_arr[] = array(
		'index' => 'mg_'.$type.'_opt_icon',
		'label' => $name 
	);	
	$ia_validation_arr[] = array(
		'index' 	=> 'mg_'.$type.'_opt',
		'label' 	=> $name . __('attributes', $ml_key),
		'max_len'	=> 150
	);	
}

if($GLOBALS['mg_woocom_active'] && is_array($GLOBALS['mg_woocom_atts'])) {
	foreach($GLOBALS['mg_woocom_atts'] as $attr) {
		$ia_validation_arr[] = array(
			'index' => 'mg_wc_attr_'. sanitize_title($attr->attribute_label) .'_icon',
			'label' => 'WooCommerce '. $attr->attribute_label .' attributes icon'
		);	
	}
}


$structure['item_atts'] = array(
	'item_atts_wrap' => array(
		'sect_name'	=>  __('Item Attributes', $ml_key),
		'fields' 	=> array(
			
			'item_atts_block' => array(
				'type'		=> 'custom',
				'callback'	=> 'mg_item_atts_f',
				'validation'=> $ia_validation_arr
			), 
		),
	),
);





####################################
########### CUSTOM CSS #############
####################################		
$structure['cust_css'] = array(	
	'custom_css_wrap' => array(
		'sect_name'	=>  __('High-priority code - applied to Media Grid elements', $ml_key),
		'fields' 	=> array(
		
			'mg_custom_css' => array(
				'label' 	=> __('Custom CSS', $ml_key),
				'type'		=> 'code_editor',
				'language'	=> 'css',
			),
		),
	),
);





// No overlay manager? add an advertising!
if(!defined('MGOM_DIR')) {
	$structure['main_opts']['grid_layout']['fields']['mgom_adv_spacer'] = array(
		'type' => 'spacer',
	);
	$structure['main_opts']['grid_layout']['fields']['mgom_adv'] = array(
		'type'		=> 'message',
		'content'	=> '
			<style type="text/css">
			.mg_mgom_adv td {
				background: #629c2c url("'. MG_URL .'/img/lc_pattern.png") repeat scroll left 5px;	
				border-bottom: none;
			}
			.mg_mgom_adv td h3 {
				margin: 7px 0;
				font-size: 16px;
				text-shadow: 0 0 2px rgba(0,0 ,0,0.15);
				letter-spacing: 0.05px;
			}
			.mg_mgom_adv td a, .mg_mgom_adv td a:hover {
				color: #fff;	
			}
			.mg_mgom_adv td a:focus {
				box-shadow: none;	
			}
			.mg_mgom_adv td span {
				display: inline-block;
				border: 2px solid #fff;
				padding: 6px 10px;
				position: relative;
				bottom: 0px;
				left: 15px;
				font-size: 14px;
				border-radius: 1px;
				
				-webkit-transition: all .2s ease; 
				-ms-transition: 	all .2s ease; 
				transition: 		all .2s ease; 
			}
			.mg_mgom_adv td a:hover span {
				border-color: transparent;
				background: #fff;
				color: #629c2c;
				text-shadow: none;
			}
			</style>
		
			<h3><a href="https://lcweb.it/media-grid/overlay-manager-addon?ref=mgs" target="_blank">Need more? Give an unique touch to your grids with the Overlay Manager add-on <span>check it!</span></a></h3>
		',
	);	
}



// MG-FILTER - manipulate settings structure
$GLOBALS['mg_settings_structure'] = apply_filters('mg_settings_structure', $structure);

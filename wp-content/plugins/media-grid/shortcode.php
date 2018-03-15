<?php
// SHORTCODE DISPLAYING THE GRID

// [mediagrid] 
function mg_shortcode( $grid_atts, $content = null ) {
	
	include_once(MG_DIR .'/classes/items_renderer.php');
	include_once(MG_DIR .'/classes/overlay_manager.php');
	include_once(MG_DIR .'/functions.php'); 
	
	$grid_atts = shortcode_atts( array(
		'gid'			=> '',
		'cat' 			=> '',
		'pag_sys'		=> '',
		'filter' 		=> 0,
		'title_under' 	=> 0,
		'filters_align' => 'top',
		'hide_all' 		=> 0,
		'def_filter' 	=> 0,
		'search'		=> 0,
		'mobile_tresh'	=> 0,
		
		'cell_margin'	=> '',
		'border_w'		=> '',
		'border_col'	=> '',
		'border_rad'	=> '',
		'outline'		=> '',
		'outline_col'	=> '',
		'shadow'		=> '',
		'txt_under_col'	=> '',
		
		'overlay'		=> 'default',
	), $grid_atts);
	extract($grid_atts);


	if(empty($cat) && empty($gid)) {return '';}
	$grid_id = (empty($cat)) ? (int)$gid : (int)$cat;
	
	$grid_temp_id = uniqid();
	$grid_classes = array('mg_grid_wrap', 'mg_grid_'.$grid_id); 
	$grid_atts['grid_temp_id'] = $grid_temp_id;
	
	
	// if no filter - be sure position is top to avoid search misplacing
	if(empty($filter)) {
		$filters_align = 'top';
		$grid_atts['filters_align'] = 'top';	
	}
	
	
	// deeplink vars setup
	if(isset($GLOBALS['mg_deeplinks']) && isset($GLOBALS['mg_deeplinks']['gid_'.$grid_id]) ) {
		
		// check for deeplinked page
		$grid_atts['dl_pag'] = (isset($GLOBALS['mg_deeplinks']['gid_'.$grid_id]['mgp'])) ? (int)$GLOBALS['mg_deeplinks']['gid_'.$grid_id]['mgp'] : false;
		
		// check for deeplinked category
		$grid_atts['dl_cat'] = (isset($GLOBALS['mg_deeplinks']['gid_'.$grid_id]['mgc'])) ? (int)$GLOBALS['mg_deeplinks']['gid_'.$grid_id]['mgc'] : false;
		
		// check for deeplinked search
		$grid_atts['dl_search'] = (isset($GLOBALS['mg_deeplinks']['gid_'.$grid_id]['mgs'])) ? $GLOBALS['mg_deeplinks']['gid_'.$grid_id]['mgs'] : false;
	} 
	else {
		$grid_atts['dl_pag'] = $grid_atts['dl_search'] = false;		
	}
	
	
	// overlay manager class
	$ol_man = new mg_overlay_manager($overlay, $title_under);
	
	// items rendered  class
	$ir = new mg_items_renderer($grid_id, $ol_man, $grid_atts);
	if(empty($ir->queried_items)) {return '';} // no items - stop here
	
	
	// store items code - this is REQUIRED to setup other elements such as grid filteres
	$items_code = $ir->render_items();

	
	// custom styling codes
	if($cell_margin !== '' || $border_w !== '' || !empty($border_col) || $border_rad !== '' || $outline !== '' || !empty($outline_col) || $shadow !== '' || !empty($txt_under_col)) {
		
		$cs_pre = '.mg_'. $grid_temp_id;
		$cust_styles = '
		<style type="text/css">';
		
		if($cell_margin !== '')		{
			$cell_margin = (int)$cell_margin;
			
			$cust_styles .= 
			$cs_pre.' .mg_box { 
				border-width: 0 '. $cell_margin .'px '. $cell_margin .'px 0; 
			}'.
			$cs_pre.'.mg_rtl_mode .mg_box {
				left: calc((15px + '. $cell_margin .'px) * -1) !important;
			}'.
			$cs_pre.' .mg_items_container {
				width: calc(100% + 20px + '. $cell_margin .'px);
			}'.
			$cs_pre.' .mg_items_container.mg_not_even_w {
				width: calc(100% + 20px '. $cell_margin .'px + 1px);	
			}';
			
			// override items sizing
			foreach(mg_sizes() as $key => $data) {
				$cust_styles .= $cs_pre.' .mgis_h_'.$key.' {padding-bottom: calc('. $data['perc'] * 100 .'% - '. round($data['perc'] * 20) .'px - '. $cell_margin .'px);}';
			}
			foreach(mg_mobile_sizes() as $key => $data) {
				$cust_styles .= $cs_pre.'.mg_mobile_mode .mgis_m_h_'.$key.' {padding-bottom: calc('. $data['perc'] * 100 .'% - '. round($data['perc'] * 20) .'px - '. $cell_margin .'px);}';
			}
		}
		if($border_w !== '')  		{
			$cust_styles .= 
				$cs_pre.' .mg_box_inner {
					padding: '. (int)$border_w .'px;
				}'.
				$cs_pre.' .mg_grid_wrap:not(.mg_mobile_mode) .mgis_h_auto .mg_inl_txt_media_bg,'.
				$cs_pre.' .mg_mobile_mode .mgis_m_h_auto .mg_inl_txt_media_bg,'.
				$cs_pre.' .mgi_overlays {
					top: '. (int)$border_w .'px;
					bottom: '. (int)$border_w .'px;
					left: '. (int)$border_w .'px;
					right: '. (int)$border_w .'px; 
				}';
		}
		if(!empty($border_col)) 		{
			$cust_styles .= $cs_pre.' .mg_box_inner, '.$cs_pre.' .mg_tu_attach .mgi_txt_under {background: '. $border_col .';}';
		}
		if($border_rad !== '')		{
			$cust_styles .= 
				$cs_pre.' .mg_box_inner,'.
				$cs_pre.' .mg_box .mg_media_wrap,'.
				$cs_pre.' .mgi_overlays,'.
				$cs_pre.' .mg_inl_slider_wrap .lcms_content,'.
				$cs_pre.' .mg_inl_slider_wrap .lcms_nav *,'.
				$cs_pre.' .mg_inl_slider_wrap .lcms_play {
			  		border-radius: '. (int)$border_rad .'px;
				}'.
				$cs_pre.' .mg_tu_attach .mgi_txt_under {
					border-bottom-left-radius: '. (int)$border_rad .'px;
					border-bottom-right-radius: '. (int)$border_rad .'px;	
				}';
		}
		
		if($outline == 1) {
			$cust_styles .= 
				$cs_pre.' .mg_box_inner {border-width: 1px;}'.
				$cs_pre.' .mg_tu_attach .mgi_txt_under {
					border-width: 0px 1px 1px;
					margin-top: -1px;
				}'; 
		} elseif($outline !== '') {
			$cust_styles .= $cs_pre.' .mg_box_inner, '.$cs_pre.' .mg_tu_attach .mgi_txt_under {border-width: 0px;}';	
			$cust_styles .= $cs_pre.' .mg_tu_attach .mgi_txt_under {margin-top: 0;}';	
		}
		
		if(!empty($outline_col)) 	{
			$cust_styles .= $cs_pre.' .mg_box_inner {border-color: '.$outline_col.';}';
		}	
		
		if($shadow == 1) {
			$cust_styles .= $cs_pre.' .mg_grid_wrap {padding: 4px;}';
			$cust_styles .= $cs_pre.' .mg_box:not(.mg_spacer) .mg_box_inner {box-shadow: 0px 0px 4px rgba(25, 25, 25, 0.3);}';
			$cust_styles .= 
				$cs_pre.' .mg_tu_attach .mgi_txt_under {
					box-shadow: 4px 0px 4px -4px rgba(25, 25, 25, 0.3), -4px 0px 4px -4px rgba(25, 25, 25, 0.3), 0 4px 4px -4px rgba(25, 25, 25, 0.3);
				}';	
		} 
		elseif($shadow !== '') {
			$cust_styles .= $cs_pre.' .mg_grid_wrap {padding:0;}';
			$cust_styles .= $cs_pre.' .mg_box_inner, '.$cs_pre.' .mg_tu_attach .mgi_txt_under {box-shadow: none;}';	
		}
		
		if(!empty($txt_under_col))	{
			$cust_styles .= $cs_pre.' .mgi_txt_under {color: '.$txt_under_col.';}';
		}	
		
		$cust_styles .= '
		</style>';
	}
	else {$cust_styles = '';}
	
	
	
	// search code template
	if($search) {
		$mgs_has_txt_class = ($grid_atts['dl_search']) ? 'mgs_has_txt' : '';
		
		$search_code = '
		<form id="mgs_'.$grid_id.'" class="mgf_search_form '.$mgs_has_txt_class.'">
			<input type="text" value="'. esc_attr($grid_atts['dl_search']) .'" placeholder="'. __('search', 'mg_ml') .' .." autocomplete="off" />
			<i class="fa fa-search"></i>
		</form>';
	} 
	else {$search_code = '';}

	
	
	// filters management
	if($filter) {
		include_once(MG_DIR .'/classes/grid_filters.php');
		
		$filter_rules = array(
			'align' 	 => $filters_align,
			'def_filter' => $def_filter, 
			'hide_all'	 => $hide_all
		);
		$gf = new mg_grid_filters($grid_id, $filter_rules, $ir->items_term);
		$filters = $gf->get_filters_code();
		
		
		// filters align class and code composition
		switch($filters_align) {
			case 'left' 	: $grid_classes[] = 'mg_left_filters'; break;	
			case 'right' 	: $grid_classes[] = 'mg_right_filters'; break;	
			default 		: $grid_classes[] = 'mg_top_filters'; break;	
		}
	}
	else {
		$filters = '';
		$grid_classes[] = 'mg_no_filters';
	}


	// deeplinking class
	if(!get_option('mg_disable_dl')) {$grid_classes[] = 'mg_deeplink';} 
	
	// RTL mode class
	if(get_option('mg_rtl_grid')) {$grid_classes[] = 'mg_rtl_mode';} 
	
	// search box class
	if($search) {$grid_classes[] = 'mg_has_search';}
	
	
	// custom mobile treshold
	$cmt_attr = ((int)$grid_atts['mobile_tresh']) ? 'data-mobile-treshold="'. (int)$grid_atts['mobile_tresh'] .'"' : '';
		
	
	// has pages class
	$curr_pag = 1;
	if($ir->grid_has_pag) {$grid_classes[] = 'mg_has_pag';}
	
	
	///////////////////////////
	
	// MG-FILTER - allow custom classes to be applied to grid wrapper - passes already applied classes array and grid atts array (given by shortcode)
	$grid_classes = (array)apply_filters('mg_grid_classes', $grid_classes, $grid_atts);
	
	// MG-FILTER - allow custom attributes to be applied to grid wrapper - must be an associative array (att-name => att-val) 
	$grid_html_atts = (array)apply_filters('mg_grid_atts', array(), $grid_atts);
	$atts = '';
	foreach($grid_html_atts as $att => $val) {
		$atts .= ' '. $att .'="'. str_replace('"', '', $val) .'"';	
	}

	///////////////////////////


	### init
	$grid = $cust_styles. 
	'<div id="'.$grid_temp_id.'" data-grid-id="'.$grid_id.'" class="mg_'.$grid_temp_id.' '. implode(' ', $grid_classes) .'" '.$cmt_attr.' '.$atts.'>';
		
		
		// SEARCH AND FILTERS WRAPPER
		if(!empty($search_code) || !empty($filters)) {
			$ag_elem_align = (empty($search_code) || empty($filters)) ? 'mg_ag_align_'. get_option('mg_filters_align', 'left') : '';
			
			$grid .= '
			<div class="mg_above_grid mgag_'.$grid_id.' '.$ag_elem_align.'">'. 
				$search_code .
				$filters .	
			'</div>';
		}


		// title under - wrap class
		switch($title_under) {
			case 0 : $tit_under_class = ''; break;
			case 1 : $tit_under_class = 'mg_grid_title_under mg_tu_attach'; break;
			case 2 : $tit_under_class = 'mg_grid_title_under mg_tu_detach'; break;	
		}
		
		
		// "no results" text attribute to be used by css 
		$nores_txt = (!get_option('mg_no_results_txt')) ? __('no results', 'mg_ml') : get_option('mg_no_results_txt');
		$nores_attr = 'data-nores-txt="'. esc_attr($nores_txt) .'"';
		
		
		// items container
		$grid .=
		mg_preloader(true) . 
		'<div class="mg_items_container mgic_pre_show '.$tit_under_class.' '.$ol_man->txt_vis_class.'"  data-mg-pag="'.$curr_pag.'" '.$nores_attr.' '.$ol_man->img_fx_attr.'>'. 
			
			$items_code;
			
		// close items container
		$grid .= 
		'</div>';
	


	
		/////////////////////////		
		// PAGINATION BUTTONS
		if(in_array('mg_has_pag', $grid_classes)) {
			$tot_pag = $ir->page;
			
			// layout classes
			$pag_layout = (!empty($pag_sys)) ? $pag_sys : get_option('mg_pag_layout', 'standard');

			switch($pag_layout) {
				case 'standard' 	: $pl_class = 'mg_pag_standard'; break;
				case 'only_num' 	: $pl_class = 'mg_pag_onlynum'; break;
				default 			: $pl_class = 'mg_'.$pag_layout; break;
			}

			// deeplinked page check against tot pages
			if($grid_atts['dl_pag']) {
				$curr_pag = $grid_atts['dl_pag'];
				if($grid_atts['dl_pag'] > $tot_pag) {$curr_pag = $tot_pag;}
			}
		
			// compose
			$grid .= '
			<div id="mgp_'.$grid_temp_id.'" class="mg_pag_wrap '.$pl_class.'" data-init-pag="'.$curr_pag.'" data-tot-pag="'.$tot_pag.'">';
				
				// next/prev button types
				if(in_array($pag_layout, array('standard', 'only_num', 'only_arr_dt'))) {
				
					// mid nav - layout code
					if($pag_layout == 'standard') {
						$mid_code = '<div class="mg_nav_mid"><div>'. __('page', 'mg_ml') .' <span>'.$curr_pag.'</span> '. __('of', 'mg_ml') .' '.$tot_pag.'</div></div>';	
					}
					elseif($pag_layout == 'only_num') {
						$mid_code = '<div class="mg_nav_mid"><div><span>'.$curr_pag.'</span> <font>/</font> '.$tot_pag.'</div></div>';	
					}
					else {
						$mid_code = '';
					}
					
					// disabled class management
					$prev_dis = ($curr_pag == 1) ? 'mg_pag_disabled' : '';
					$next_dis = ($curr_pag == $tot_pag) ? 'mg_pag_disabled' : '';
					
					$grid .= '
					<div class="mg_prev_page '.$prev_dis.'" title="'. __('previous page', 'mg_ml') .'"><i></i></div>
					'.$mid_code.'
					<div class="mg_next_page '.$next_dis.'" title="'. __('next page', 'mg_ml') .'"><i></i></div>';
				}
				
				
				// page buttons
				else if(in_array($pag_layout, array('pag_btn_nums', 'pag_btn_dots'))) {
					for($a=1; $a <= $tot_pag; $a++) {
						$sel = ($a == $curr_pag) ? 'mg_sel_pag' : '';
						$grid .= '<div data-pag="'.$a.'" class="mg_hidden_pb '.$sel.'" title="'. __('Go to page', 'mg_ml') .' '.$a.'">'. $a .'</div>'; 	
					}	
				}
				
				
				// infinite scroll
				else {
					$grid .= '<div class="mg_load_more_btn"><i class="fa fa-plus-circle" aria-hidden="true"></i> '. __('Show more', 'mg_ml') .'</div>';
				}
	
			$grid .= '</div>';
		} // pagination end
	
	
	
	
	// grid end
	$grid .= 
	'</div>';




	// js - init grid
	$grid .= '
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		mg_grid_filters["'.$grid_temp_id.'"] = [];'; 
		
		
		// page filter
		if(in_array('mg_has_pag', $grid_classes)) {
			$grid .= "
			mg_grid_filters['".$grid_temp_id."']['mg_pag_'] = {
				condition 	: 'AND',
				val 		: [".$curr_pag."]
			};";
		}
		
		// category filter
		if($filter && !empty($gf->applied_filter)) {
			$grid .= "
			mg_grid_filters['".$grid_temp_id."']['mgc_'] = {
				condition 	: 'AND',
				val 		: [".$gf->applied_filter."]
			};";	
		}
		
		// search initial filter
		if($search && $grid_atts['dl_search']) {
			$grid .= "
			mg_grid_filters['".$grid_temp_id."']['mg_search_res'] = {
				condition 	: 'AND',
				val 		: ['']
			};";	
		}
		
		
		// start the engine!
		$grid .= '
		jQuery(window).trigger("mg_pre_grid_init", ["'. $grid_temp_id .'"]);
	
		if(typeof(mg_init_grid) == "function" ) {
			mg_init_grid("'.$grid_temp_id.'", '.$curr_pag.');
		}
		
		jQuery(window).trigger("mg_post_grid_init", ["'. $grid_temp_id .'"]);
	});
	</script>';


	// MG-FILTER - ablity to injec/edit grid's HTML code - passes grid ID, the temporary ID and grid and grid atts array (given by shortcode)
	$grid = apply_filters('mg_grid_code', $grid, $grid_id, $grid_temp_id, $grid_atts);
	

	return str_replace(array("\r", "\n", "\t", "\v"), '', $grid);
}
add_shortcode('mediagrid', 'mg_shortcode');

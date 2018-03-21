<?php
/*
	Plugin name: Event Calendars
	Plugin URI: http://total-soft.pe.hu/event-calendars
	Description: New Revolutionary Event Calendar from Total Soft. This Event calendar is different from all of its charm. It is very flexible and easy to install and integrate into your website. Calendar is the best if you want to be original on your website.
	Version: 1.0.4
	Author: totalsoft
	Author URI: http://total-soft.pe.hu/
*/
	require_once(dirname(__FILE__) . '/Includes/Event-Calendar-Widget.php');
 	require_once(dirname(__FILE__) . '/Includes/Event-Calendar-Ajax.php');
 	add_action('wp_enqueue_scripts', 'Total_Soft_EvCal_Widget_Style');

 	function Total_Soft_EvCal_Widget_Style(){
 		wp_register_style('Event_Calendar_TS', plugins_url('/CSS/Event-Calendar-Widget.css',__FILE__ ));
		wp_enqueue_style('Event_Calendar_TS');	
		wp_register_script('Event_Calendar_TS',plugins_url('/JS/Event-Calendar-Widget.js',__FILE__),array('jquery','jquery-ui-core'));
		wp_localize_script('Event_Calendar_TS', 'object', array('ajaxurl' => admin_url('admin-ajax.php')));
		wp_enqueue_script('Event_Calendar_TS');
		wp_enqueue_script("jquery");

		wp_register_style('fontawesome-css', plugins_url('/CSS/totalsoft.css', __FILE__)); 
  		wp_enqueue_style('fontawesome-css');
 	}

 	add_action('widgets_init', 'Total_Soft_EvCal_Widget_Reg');

 	function Total_Soft_EvCal_Widget_Reg(){
 		register_widget('Event_Calendar_TS');
 	}

	add_action("admin_menu", 'Total_Soft_EvCal_Admin_Menu');

	function Total_Soft_EvCal_Admin_Menu(){
		$complete_url = wp_nonce_url( $bare_url, 'edit-menu_'.$comment_id, 'TS_EvCal_Nonce' );
		add_menu_page('Admin Menu',__( 'Calendar', 'Event-Calendar' ), 'manage_options','Event Calendar TS' . $complete_url, 'Add_New_Event_Calendar',plugins_url('/Images/admin.png',__FILE__));
 		add_submenu_page('Event Calendar TS' . $complete_url, 'Admin Menu', __( 'Calendar Manager', 'Event-Calendar' ), 'manage_options', 'Event Calendar TS' . $complete_url, 'Add_New_Event_Calendar');
 		add_submenu_page('Event Calendar TS' . $complete_url, 'Admin Menu', __( 'Theme Manager', 'Event-Calendar' ), 'manage_options', 'Total Soft Events' . $complete_url, 'Total_Soft_Theme_Calendar');
 		add_submenu_page('Event Calendar TS' . $complete_url, 'Admin Menu', __( 'Total Products', 'Event-Calendar' ), 'manage_options', 'Total Soft Products' . $complete_url, 'Total_Soft_Product_Cal_Ev');
	}

	add_action('admin_init', 'Total_Soft_EvCal_Admin_Style');

	function Total_Soft_EvCal_Admin_Style(){
		wp_enqueue_style('wp-color-picker');
		wp_enqueue_script('wp-color-picker');

		wp_register_style('Event_Calendar_TS', plugins_url('/CSS/Event-Calendar-Admin.css',__FILE__));
		wp_enqueue_style('Event_Calendar_TS' );	
		wp_register_script('Event_Calendar_TS', plugins_url('/JS/Event-Calendar-Admin.js',__FILE__),array('jquery','jquery-ui-core'));
		wp_localize_script('Event_Calendar_TS','object', array('ajaxurl'=>admin_url('admin-ajax.php')));
		wp_enqueue_script('Event_Calendar_TS');
		wp_enqueue_script("jquery");
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-sortable');

		wp_register_style('fontawesome-css', plugins_url('/CSS/totalsoft.css', __FILE__)); 
  		wp_enqueue_style('fontawesome-css');	
	}

	function Add_New_Event_Calendar()
	{
 		require_once(dirname(__FILE__) . '/Includes/Event-Calendar-New.php');
	}
	function Total_Soft_Theme_Calendar()
	{
 		require_once(dirname(__FILE__) . '/Includes/Event-Calendar-Theme.php');
	}
	function TotalSoftEvCalInstall()
	{
 		require_once(dirname(__FILE__) . '/Includes/Event-Calendar-Install.php');
	}
	function Total_Soft_Product_Cal_Ev()
	{
 		require_once(dirname(__FILE__) . '/Includes/Total-Soft-Products.php');
	}
	register_activation_hook(__FILE__,'TotalSoftEvCalInstall');

	function Total_SoftEvCal_Short_ID($atts, $content = null)
	{
		$atts=shortcode_atts(
			array(
				"id"=>"1"
			),$atts
		);
		return Total_Soft_Draw_EvCal($atts['id']);
	}
	add_shortcode('Event_Calendar_TS', 'Total_SoftEvCal_Short_ID');
	function Total_Soft_Draw_EvCal($Cal)
	{
		ob_start();	
			$args = shortcode_atts(array('name' => 'Widget Area','id'=>'','description'=>'','class'=>'','before_widget'=>'','after_widget'=>'','before_title'=>'','AFTER_TITLE'=>'','widget_id'=>'','widget_name'=>'Total Soft Calendar'), $Cal, 'Event_Calendar_TS' );
			$Event_Calendar_TS=new Event_Calendar_TS;

			$instance=array('Event_Calendar_TS'=>$Cal);
			$Event_Calendar_TS->widget($args,$instance);	
			$cont[]= ob_get_contents();
		ob_end_clean();	
		return $cont[0];		
	}
	
	function TotalSoft_Cal_Ev_Color() 
	{
	    wp_enqueue_script(
	        'alpha-color-picker',
	        plugins_url('/JS/alpha-color-picker.js', __FILE__),	       
	        array( 'jquery', 'wp-color-picker' ), // You must include these here.
	        null,
	        true
	    );
	    wp_enqueue_style(
	        'alpha-color-picker',
	        plugins_url('/CSS/alpha-color-picker.css', __FILE__),
	        array( 'wp-color-picker' ) // You must include these here.
	    );
	}
	add_action( 'admin_enqueue_scripts', 'TotalSoft_Cal_Ev_Color' );
?>
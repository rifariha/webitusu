<?php
/*
Plugin Name: Spiffy Calendar
Plugin URI:  http://www.spiffycalendar.spiffyplugins.ca
Description: A full featured, simple to use Spiffy Calendar plugin for WordPress that allows you to manage and display your events and appointments.
Version:     3.6.1
Author:      Spiffy Plugins
Author URI:  http://spiffyplugins.ca
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: spiffy-calendar

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.		See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA		02110-1301		USA
*/

// Define the tables used by Spiffy Calendar
global $wpdb;
define('WP_SPIFFYCAL_TABLE', $wpdb->prefix . 'spiffy_calendar');
define('WP_SPIFFYCAL_CATEGORIES_TABLE', $wpdb->prefix . 'spiffy_calendar_categories');

// Version checks
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
define ('SPIFFYCAL_BONUS_MINIMUM_VERSION', '2.7');

// Widget definitions
require_once (plugin_dir_path(__FILE__) . 'includes/spiffy-featured-widget.php');
require_once (plugin_dir_path(__FILE__) . 'includes/spiffy-minical-widget.php');
require_once (plugin_dir_path(__FILE__) . 'includes/spiffy-today-widget.php');
require_once (plugin_dir_path(__FILE__) . 'includes/spiffy-upcoming-widget.php');

if (!class_exists("Spiffy_Calendar")) {
Class Spiffy_Calendar
{
	private $gmt_offset = null;
	private $spiffy_options = 'spiffy_calendar_options';
	private $spiffy_version = "3.5.6";	// database format version number
	private $spiffycal_menu_page;
	private $categories = array();
	private $bonus_addons;				// set true if bonus addons available
	public $spiffy_icon = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4iICJodHRwOi8vd3d3LnczLm9yZy9HcmFwaGljcy9TVkcvMS4xL0RURC9zdmcxMS5kdGQiPjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiIHdpZHRoPSIyNnB4IiBoZWlnaHQ9IjI2cHgiIHZpZXdCb3g9IjAgMCAyNiAyNiIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwIDAgMjYgMjYiIHhtbDpzcGFjZT0icHJlc2VydmUiPjxnPjxyZWN0IHg9Ii0xIiB5PSIxOSIgZmlsbD0iI0NDREJFOCIgd2lkdGg9IjgiIGhlaWdodD0iOCIvPjxyZWN0IHg9IjkiIHk9IjE5IiBmaWxsPSIjQ0NEQkU4IiB3aWR0aD0iNyIgaGVpZ2h0PSI4Ii8+PHJlY3QgeD0iMTgiIHk9IjEiIGZpbGw9IiNDQ0RCRTgiIHdpZHRoPSI3IiBoZWlnaHQ9IjciLz48cmVjdCB4PSItMSIgeT0iMTAiIGZpbGw9IiNDQ0RCRTgiIHdpZHRoPSI4IiBoZWlnaHQ9IjciLz48cmVjdCB4PSIxOCIgeT0iMTAiIGZpbGw9IiNDQ0RCRTgiIHdpZHRoPSI3IiBoZWlnaHQ9IjciLz48cmVjdCB4PSI5IiB5PSIxIiBmaWxsPSIjQ0NEQkU4IiB3aWR0aD0iNyIgaGVpZ2h0PSI3Ii8+PHJlY3QgeD0iOSIgeT0iMTAiIGZpbGw9IiNDQ0RCRTgiIHdpZHRoPSI3IiBoZWlnaHQ9IjciLz48L2c+PC9zdmc+';
	private $mod_rewrite_months = array(1=>'jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec');
	
	function __construct()
	{
		// Admin stuff
		add_action('init', array($this, 'calendar_init_action'));
		add_action('admin_init', array($this, 'bonus_addons_check'));
		add_action('admin_menu', array($this, 'admin_menu'), 10);
		add_action('admin_bar_menu', array($this, 'admin_toolbar'), 999 );
		add_filter('spiffycal_settings_tabs_array', array($this, 'settings_tabs_array_default'), 9);
		add_action('spiffycal_settings_tab_events', array($this, 'settings_tab_events'));
		add_action('spiffycal_settings_update_events', array($this, 'settings_update_events'));
		add_action('spiffycal_settings_tab_event_edit', array($this, 'settings_tab_event_edit'));
		add_action('spiffycal_settings_tab_theme', array($this, 'settings_tab_bonus'));
		add_action('spiffycal_settings_tab_tickets', array($this, 'settings_tab_bonus'));
		add_action('spiffycal_settings_tab_frontend_submit', array($this, 'settings_tab_bonus'));
		add_action('spiffycal_settings_update_event_edit', array($this, 'settings_update_event_edit'));
		add_action('spiffycal_settings_tab_categories', array($this, 'settings_tab_categories'));
		add_action('spiffycal_settings_update_categories', array($this, 'settings_update_categories'));
		add_action('spiffycal_settings_tab_options', array($this, 'settings_tab_options'));
		add_action('spiffycal_settings_update_options', array($this, 'settings_update_options'));

		add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));

		// Enable the ability for the calendar to be loaded from pages
		add_shortcode('spiffy-calendar', array($this, 'calendar_insert'));	
		add_shortcode('spiffy-minical', array($this, 'minical_insert'));	
		add_shortcode('spiffy-upcoming-list', array($this, 'upcoming_insert'));
		add_shortcode('spiffy-todays-list', array($this, 'todays_insert'));
		add_shortcode('spiffy-week', array($this, 'weekly_insert'));
		
		// Mailpoet shortcode support
		add_filter('wysija_shortcodes', array($this, 'mailpoet_shortcodes_custom_filter'), 10, 2);

		// Add the functions that put style information in the header
		add_action('wp_enqueue_scripts', array($this, 'calendar_styles'));

		// Add the function that deals with deleted users
		add_action('delete_user', array($this, 'deal_with_delete_user'));
		
		// Admin screen option handling
		add_filter('set-screen-option', array($this, 'admin_menu_set_option'), 10, 3);
	}

	function bonus_addons_active() {
		return $this->bonus_addons;
	}
	
	function bonus_addons_check () {
		$this->bonus_addons = is_plugin_active( 'spiffy-calendar-addons/spiffy-calendar-addons.php' );
	}
	
	/*
	** Make sure Spiffy Calendar database tables are installed and up to date, if not fix them
	*/
	function check_db()	{
		global $wpdb;

		// Compare saved option to the current version
		$options = $this->get_options();
		if ($options['calendar_version'] == $this->spiffy_version)
			return;
		
		// Assume this is a new install until we prove otherwise
		$new_install = true;
		$wp_spiffycal_exists = false;

		// Determine if the calendar exists
		$sql = "SHOW TABLES LIKE '" . WP_SPIFFYCAL_TABLE . "'";
		$ans =  $wpdb->get_results($sql);
		if (count($ans) > 0) {
			$new_install = false;  // event table already exists. assume other tables does too.
		}

		if ( $new_install == true ) {
			// Fresh install - create tables
			$sql = "CREATE TABLE " . WP_SPIFFYCAL_TABLE . " (
				event_id INT(11) NOT NULL AUTO_INCREMENT,
				event_begin DATE NOT NULL,
				event_end DATE NOT NULL,
				event_title VARCHAR(60) NOT NULL COLLATE utf8_general_ci,
				event_desc TEXT NOT NULL COLLATE utf8_general_ci,
				event_all_day CHAR(1) DEFAULT 'T' COLLATE utf8_general_ci,
				event_time TIME,
				event_end_time TIME,
				event_recur CHAR(1) COLLATE utf8_general_ci,
				event_recur_multiplier INT(2) DEFAULT 1,
				event_repeats INT(3),
				event_hide_events CHAR(1) DEFAULT 'F' COLLATE utf8_general_ci,
				event_show_title CHAR(1) DEFAULT 'F' COLLATE utf8_general_ci,
				event_author BIGINT(20) UNSIGNED,
				event_category BIGINT(20) UNSIGNED NOT NULL DEFAULT 1,
				event_link TEXT COLLATE utf8_general_ci,
				event_image BIGINT(20) UNSIGNED,
				PRIMARY KEY (event_id)
			)";
			$wpdb->get_results($sql);

			$sql = "CREATE TABLE " . WP_SPIFFYCAL_CATEGORIES_TABLE . " ( 
				category_id INT(11) NOT NULL AUTO_INCREMENT, 
				category_name VARCHAR(30) NOT NULL COLLATE utf8_general_ci, 
				category_colour VARCHAR(30) NOT NULL COLLATE utf8_general_ci, 
				PRIMARY KEY (category_id) 
			 )";
			$wpdb->get_results($sql);

			$sql = "INSERT INTO " . WP_SPIFFYCAL_CATEGORIES_TABLE .
				" SET category_id=1, category_name='General', category_colour='#000000'";
			$wpdb->get_results($sql);

		} else if ($options['calendar_version'] == '3.5.0') {
			// Updates required for db version 3.5.0
			$this->db_update_collation();
		} else if ($options['calendar_version'] == '3.4.0') {
			// Updates required for db version 3.4.0
			$this->db_update_titles();
			$this->db_update_collation();
		} else {
			// Tables exist in some form before version numbers were implemented. 
			$this->db_update_titles();

			// Check whether the newer columns are in the event table 
			$samples = $wpdb->get_results( 'SELECT * FROM '. WP_SPIFFYCAL_TABLE . ' LIMIT 1', OBJECT);
            if (count($samples) == 0) {
				// no events found, insert a dummy event to get the structure
				$result = $wpdb->get_results("INSERT " . WP_SPIFFYCAL_TABLE . " SET event_title='temp'");				
				$samples = $wpdb->get_results( 'SELECT * FROM '. WP_SPIFFYCAL_TABLE . ' LIMIT 1', OBJECT);
				if (count($samples) == 0) {
					// event insert failed, something is seriously wrong. Turn on message to enable logging.
					//error_log ("Spiffy Calendar table cannot be updated");
				} else {
					$sql = $wpdb->prepare("DELETE FROM " . WP_SPIFFYCAL_TABLE . " WHERE event_id=%d", $samples[0]->event_id);
					$wpdb->get_results($sql);
				}
			}
			
			// Check for newer columns
			$hide_ok = false;
			$mult_ok = false;
			foreach ($samples as $sample) {
				if (!isset($sample->event_hide_events)) {
					// Old version of the table found. Add two new columns.
					$sql = "ALTER TABLE " . WP_SPIFFYCAL_TABLE . " ADD COLUMN event_hide_events CHAR(1) NOT NULL DEFAULT 'F' COLLATE utf8_general_ci";
					$wpdb->get_results($sql);
					$sql = "ALTER TABLE " . WP_SPIFFYCAL_TABLE . " ADD COLUMN event_show_title CHAR(1) NOT NULL DEFAULT 'F' COLLATE utf8_general_ci";
					$wpdb->get_results($sql);
				}
				
				// Check for event_recur_multiplier column
				if (!isset($sample->event_recur_multiplier)) {
					// Old version of the table found. Add new column.
					$sql = "ALTER TABLE " . WP_SPIFFYCAL_TABLE . " ADD COLUMN event_recur_multiplier INT(2) NOT NULL DEFAULT 1";
					$wpdb->get_results($sql);
				}
				
				// Check for event_all_day column
				if (!isset($sample->event_all_day)) {
					// Older version of the table found, add new column.
					$sql = "ALTER TABLE " . WP_SPIFFYCAL_TABLE . " ADD COLUMN event_all_day CHAR(1) DEFAULT 'T' COLLATE utf8_general_ci";
					$wpdb->get_results($sql);
					
					// Set this column false on all events with non-zero event_time
					$sql = "UPDATE ".WP_SPIFFYCAL_TABLE." SET event_all_day='F' WHERE event_time != '00:00:00'";
					$wpdb->get_results($sql);
				}
			}

			// Set collation on all text fields
			$this->db_update_collation();
		}
		
		// Update the store version
		$options['calendar_version'] = $this->spiffy_version;
		update_option($this->spiffy_options, $options);		
	}

	/*
	** Text fields in db needs update to utf8_general_ci
	*/
	function db_update_collation () {
		global $wpdb;
		
		$sql = "ALTER TABLE " . WP_SPIFFYCAL_TABLE . " 
			MODIFY COLUMN event_title VARCHAR(60) NOT NULL COLLATE utf8_general_ci,
			MODIFY COLUMN event_desc TEXT NOT NULL COLLATE utf8_general_ci,
			MODIFY COLUMN event_all_day CHAR(1) DEFAULT 'T' COLLATE utf8_general_ci,
			MODIFY COLUMN event_recur CHAR(1) COLLATE utf8_general_ci,
			MODIFY COLUMN event_hide_events CHAR(1) DEFAULT 'F' COLLATE utf8_general_ci,
			MODIFY COLUMN event_show_title CHAR(1) DEFAULT 'F' COLLATE utf8_general_ci,
			MODIFY COLUMN event_link TEXT COLLATE utf8_general_ci
				";
		$wpdb->get_results($sql);
		
		$sql = "ALTER TABLE " . WP_SPIFFYCAL_CATEGORIES_TABLE . "
			MODIFY COLUMN category_name VARCHAR(30) NOT NULL COLLATE utf8_general_ci,
			MODIFY COLUMN category_colour VARCHAR(30) NOT NULL COLLATE utf8_general_ci
				";
		$wpdb->get_results($sql);
	}

	/*
	** Title field in db needs update from 30 chars to 60 chars
	*/
	function db_update_titles () {
		global $wpdb;
		
		$sql = "ALTER TABLE " . WP_SPIFFYCAL_TABLE . " MODIFY COLUMN event_title VARCHAR(60) NOT NULL COLLATE utf8_general_ci";
		$wpdb->get_results($sql);
	}

	function calendar_init_action() {		
		// Localization
		load_plugin_textdomain('spiffy-calendar', false, basename( dirname( __FILE__ ) ) . '/languages' );
		
		$this->check_db();

		// Dashboard stuff follows, quit if not in admin area
		if (!is_admin()) return;
	
		// Shortcode generator
		require_once (plugin_dir_path(__FILE__) . 'includes/shortcode-buttons.php');

		// Check bonus add-ons version
		if (is_plugin_active('spiffy-calendar-addons/spiffy-calendar-addons.php')) {

			/* Make sure the bonus plugin is installed at the minimum version */
			$bonus_plugin_data = get_plugin_data( WP_PLUGIN_DIR . '/' . 'spiffy-calendar-addons/spiffy-calendar-addons.php' );
			$bonus_plugin_version = $bonus_plugin_data['Version'];

			if (version_compare($bonus_plugin_version, SPIFFYCAL_BONUS_MINIMUM_VERSION, '<')) {
				add_action('admin_notices', array($this, 'admin_spiffycal_version_error') );  
				return;
			}
		}
		
	}

	/* Admin error messages */
	function admin_spiffycal_version_error() {
		echo '<div id="message" class="error">';
		echo '<p><strong>'. __('Spiffy Calendar Bonus Add-Ons plugin version ', 'spiffy-calendar') . SPIFFYCAL_BONUS_MINIMUM_VERSION . __(' (or above) must be activated for this version of the Spiffy Calendar.', 'spiffy-calendar') . '</strong></p>';
		echo '</div>';
	}
	
	function get_options() {
		
		// Merge default options with the saved values
		$use_options = array(
						'calendar_version' => '1.0.0',	// default to old version to force proper DB updates when needed
						'calendar_style' => '',
						'can_manage_events' => 'edit_posts',
						'display_author' => 'false',
						'limit_author' => 'false',
						'display_detailed' => 'false',
						'display_jump' => 'false',
						'display_weeks' => 'false',
						'display_upcoming_days' => 7,
						'enable_categories' => 'false',
						'enable_new_window' => 'false',
						'enable_expanded_mini_popup' => 'false',
						'responsive_width' => 0,
					);
		$saved_options = get_option($this->spiffy_options);
		if (!empty($saved_options)) {
			foreach ($saved_options as $key => $option)
				$use_options[$key] = $option;
		}

		return $use_options;
	}
	
	/*
	** Deal with events posted by a user when that user is about to be deleted
	*/
	function deal_with_delete_user($id)
	{
		global $wpdb;

		// Reassign author appropriately based on the delete request
		switch ( $_REQUEST['delete_option'] ) {
			case 'delete':
				$sql = $wpdb->prepare("UPDATE ".WP_SPIFFYCAL_TABLE." SET event_author=".$wpdb->get_var("SELECT MIN(ID) FROM ".$wpdb->prefix."users",0,0)." WHERE event_author=%d",$id);
				break;
			case 'reassign':
				$sql = $wpdb->prepare("UPDATE ".WP_SPIFFYCAL_TABLE." SET event_author=".$_REQUEST['reassign_user']." WHERE event_author=%d",$id);
				break;
		}
		
		// Do the query
		$wpdb->get_results($sql);
	}

	/*
	** Add the calendar front-end styles and scripts
	*/
	function calendar_styles() {
		wp_register_script( 'spiffycal-scripts', plugins_url('js/spiffy_frontend_utility.js', __FILE__), array('jquery'), '1.0', true );
		wp_register_style ('spiffycal-styles', plugins_url('styles/default.css', __FILE__), array(), 
							filemtime( plugin_dir_path(__FILE__) . 'styles/default.css'));
		$options = $this->get_options();
        if ($options['calendar_style'] != '') {
			wp_add_inline_style( 'spiffycal-styles', stripslashes($options['calendar_style']) );
		}
		if ($options['responsive_width'] > 0) {
			$responsive = '@media screen and ( max-width: ' . absint($options['responsive_width']) . 'px ) {
.spiffy.calendar-table.bigcal {
	border-collapse:collapse !important;
	border-spacing:0px !important;
}
.spiffy.calendar-table.bigcal tr {
	border:none;
}
.spiffy.calendar-table.bigcal td.day-with-date, .spiffy.calendar-table.bigcal td.calendar-date-switcher
 {
	width:100%;
	display:block;
	height: auto;
	text-align: left !important;
	padding: 3px !important;
	border-top: solid 1px rgba(255, 255, 255, .2) !important;
	box-sizing: border-box;
}
.spiffy.calendar-table.bigcal td.spiffy-day-1 {
    border-top: none !important;
}
.spiffy.calendar-table.bigcal .weekday-titles, .spiffy.calendar-table.bigcal .day-without-date {
	display: none !important;
}
.calnk-link span.spiffy-popup {
	width: 80%;
}
.spiffy.calendar-table.bigcal .event {
	padding:0 !important;
}
}';
			wp_add_inline_style( 'spiffycal-styles', $responsive );
		}
	}

	/*
	** Add the admin menu
	*/
	function admin_menu() {
		global $wpdb;

		// Set admin as the only one who can use Calendar for security
		$allowed_group = 'manage_options';

		// Use the database to *potentially* override the above if allowed
		$options = $this->get_options();
		$allowed_group = $options['can_manage_events'];

		// Add the admin panel pages for Calendar. Use permissions pulled from above
		 if (function_exists('add_menu_page')) {
			$this->spiffycal_menu_page = add_menu_page(__('Spiffy Calendar','spiffy-calendar'), __('Spiffy Calendar','spiffy-calendar'),
						$allowed_group, 'spiffy-calendar', array($this, 'admin_menu_output'), $this->spiffy_icon);
			add_action( "load-{$this->spiffycal_menu_page}", array($this, 'admin_menu_options') );
						
			// Add shortcuts to the tabs, first must be duplicate of main
			add_submenu_page( 'spiffy-calendar', __('Spiffy Calendar', 'spiffy-calendar'), __('Manage Events', 'spiffy-calendar'), 
							$allowed_group, 'spiffy-calendar');
			add_submenu_page( 'spiffy-calendar', __('Spiffy Calendar', 'spiffy-calendar'), __('Add Event', 'spiffy-calendar'), 
							$allowed_group, 'admin.php?page=spiffy-calendar&tab=event_edit&action=add' );		
			add_submenu_page( 'spiffy-calendar', __('Spiffy Calendar', 'spiffy-calendar'), __('Categories', 'spiffy-calendar'), 
							'manage_options', 'admin.php?page=spiffy-calendar&tab=categories' );		
			add_submenu_page( 'spiffy-calendar', __('Spiffy Calendar', 'spiffy-calendar'), __('Options', 'spiffy-calendar'), 
							'manage_options', 'admin.php?page=spiffy-calendar&tab=options' );		
		 }
	}

	/*
	** Define the options used on admin settings page
	*/
	function admin_menu_options() {
		$option = 'per_page';
 
		$args = array(
			'label' => __('Number of events per page','spiffy-calendar').':',
			'default' => 10,
			'option' => 'spiffy_events_per_page'
		);
		 
		add_screen_option( $option, $args );
	}

	/*
	** Construct the admin settings page
	*/
	function admin_menu_output() {
		global $options_page;

		// verify user has permission
		$allowed_group = 'manage_options';

		// Use the database to potentially override the above if allowed
		$options = $this->get_options();
		$allowed_group = $options['can_manage_events'];

		if (!current_user_can($allowed_group))
			wp_die(__('Sorry, but you have no permission to change settings.','spiffy-calendar'));	

		// update the settings for the current tab
		if ( isset($_POST['save_spiffycal']) && ($_POST['save_spiffycal'] == 'true') && 
					check_admin_referer('update_spiffycal_options')) {
			$current_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'events';
			do_action ( 'spiffycal_settings_update_' . $current_tab);
		}

		// Get tabs for the settings page
		$tabs = apply_filters( 'spiffycal_settings_tabs_array', array() );
		
		// proceed with the settings form
		$options = $this->get_options();
		//print_r($_POST);
		include 'includes/admin/admin-settings.php';
		include 'includes/admin/admin-settings-promo.php';
	}
	
	/*
	** Filter to set our custom admin menu options
	*/
	function admin_menu_set_option($status, $option, $value) {
		return $value;
	}
	
	/*
	** Add the menu shortcuts to the admin toolbar
	*/
	function admin_toolbar ($wp_admin_bar) {

		// Check user permissions
		$options = $this->get_options();
		$allowed_group = $options['can_manage_events'];
		
		if (!current_user_can($allowed_group)) return;
		
		// WP +New node
		$wp_admin_bar->add_node( array(
			'id'    => 'spiffy_new_event_node',
			'title' => __('Spiffy Event', 'spiffy-calendar'),
			'parent' => 'new-content',
			'href'  => admin_url('admin.php?page=spiffy-calendar&tab=event_edit&action=add')
			) );
		
		// Our own Spiffy node
		$wp_admin_bar->add_node( array(
			'id'    => 'spiffy_main_node',
			'title' => __('Spiffy Calendar', 'spiffy-calendar'),
			'href'  => admin_url('admin.php?page=spiffy-calendar&tab=events')
			) );
		$wp_admin_bar->add_node( array(
			'id'    => 'spiffy_edit_events_node',
			'title' => __('Manage Events', 'spiffy-calendar'),
			'parent' => 'spiffy_main_node',
			'href'  => admin_url('admin.php?page=spiffy-calendar&tab=events')
			) );
		$wp_admin_bar->add_node( array(
			'id'    => 'spiffy_add_event_node',
			'title' => __('Add Event', 'spiffy-calendar'),
			'parent' => 'spiffy_main_node',
			'href'  => admin_url('admin.php?page=spiffy-calendar&tab=event_edit&action=add')
			) );
		if (current_user_can('manage_options')) {
			$wp_admin_bar->add_node( array(
				'id'    => 'spiffy_categories_node',
				'title' => __('Categories', 'spiffy-calendar'),
				'parent' => 'spiffy_main_node',
				'href'  => admin_url('admin.php?page=spiffy-calendar&tab=categories')
				) );
			$wp_admin_bar->add_node( array(
				'id'    => 'spiffy_options_node',
				'title' => __('Options', 'spiffy-calendar'),
				'parent' => 'spiffy_main_node',
				'href'  => admin_url('admin.php?page=spiffy-calendar&tab=options')
				) );
		}
	}
	
	/*
	** Add the default tabs to the settings tab array
	*/
	function settings_tabs_array_default ($settings_tabs ) {

		if (current_user_can('manage_options')) {
			// admins have access to all tabs
			$default_tabs = array (
							'events' =>  __( 'Events', 'spiffy-calendar' ),
							'event_edit' =>  __( 'Add/Edit Event', 'spiffy-calendar' ),
							'categories' => __( 'Categories', 'spiffy-calendar' ),
							'options' => __( 'Options', 'spiffy-calendar' ),
							// Bonus tabs will be overwritten when bonus addons installed
							'theme' => __( 'Themes', 'spiffy-calendar' ),
							'tickets' => __( 'Tickets', 'spiffy-calendar' ),
							'frontend_submit' => __( 'Front End Submit', 'spiffy-calendar' ));
		} else {
			// edit event permission is configurable (default is edit_events)
			$options = $this->get_options();
			$allowed_group = $options['can_manage_events'];
			
			if (current_user_can($allowed_group)) {
				$default_tabs = array (
							'events' =>  __( 'Events', 'spiffy-calendar' ),
							'event_edit' =>  __( 'Add/Edit Event', 'spiffy-calendar' ),
							);
			}
		}
		
		return $default_tabs + $settings_tabs;
	}
	
	/*
	** Output the admin settings page for the "Categories" tab
	*/
	function settings_tab_categories() {
		$options = $this->get_options();
		include 'includes/admin/admin-settings-tab-categories.php';
	}
	
	/*
	** Output the admin settings page for the "Events" tab
	*/
	function settings_tab_events() {
		$options = $this->get_options();
		include 'includes/admin/admin-settings-tab-event-list.php';
	}

	/*
	** Output the admin settings page for the "Add Event" tab
	*/
	function settings_tab_event_edit() {
		$options = $this->get_options();
		include 'includes/admin/admin-settings-tab-event-edit.php';
	}

	/*
	** Output the admin settings page for the "Options" tab
	*/
	function settings_tab_options() {
		$options = $this->get_options();
		include 'includes/admin/admin-settings-tab-options.php';
	}

	/*
	** Output the admin settings page for the bonus tabs
	*/
	function settings_tab_bonus() {
		$options = $this->get_options();
		include 'includes/admin/admin-settings-tab-bonus.php';
	}

	/*
	** Save the "Categories" tab updates
	*/
	function settings_update_categories() {
		global $wpdb;
		
		$options = $this->get_options();

		// Look for category delete requests
		foreach($_POST as $key => $value) {
			$k_array = explode("_", $key, 2); 
			if(isset($k_array[0]) && $k_array[0] == "delete") {
				$category_id = $k_array[1];
				$sql = $wpdb->prepare("DELETE FROM " . WP_SPIFFYCAL_CATEGORIES_TABLE . " WHERE category_id=%d", $category_id);
				$wpdb->get_results($sql);
				$sql = $wpdb->prepare("UPDATE " . WP_SPIFFYCAL_TABLE . " SET event_category=1 WHERE event_category=%d", $category_id);
				$wpdb->get_results($sql);
				echo "<span class=\"updated\"><p><strong>".__('Category deleted successfully','spiffy-calendar')."</strong></p></span>";
				
				return; // no more work to do
			}
		}
	
		if (isset($_POST['add_category'])) {
			// Adding new category. Check name and color
			if (isset($_POST['category_name']) && ($_POST['category_name'] != '') && isset($_POST['category_colour']) && ($_POST['category_colour'] != '')) {
				$category_name = sanitize_text_field( $_POST['category_name'] );
				
				// Proceed with the save		
				$sql = $wpdb->prepare("INSERT INTO " . WP_SPIFFYCAL_CATEGORIES_TABLE . " SET category_name='%s', category_colour='%s'",
							$category_name, $_POST['category_colour']);
				$wpdb->get_results($sql);
				echo "<span id=\"message\" class=\"updated\"><p>".__('Category added successfully','spiffy-calendar')."</p></span>";
				
				// Clear post parameters to avoid repeat
				$_POST['category_name'] = $_POST['category_colour'] = '';
			} else {
				echo "<span id=\"message\" class=\"error\"><p>".__('Missing category name or color, not saved.','spiffy-calendar')."</p></span>";	
			}
		} else if (isset($_POST['update_category'])) {
			if (isset($_POST['category_id']) 
						&& isset($_POST['category_name_edit']) && ($_POST['category_name_edit'] != '')
						&& isset($_POST['category_colour_edit']) && ($_POST['category_colour_edit']) 
					) {
				// Proceed with the save
				$sql = $wpdb->prepare("UPDATE " . WP_SPIFFYCAL_CATEGORIES_TABLE . " SET category_name='%s', category_colour='%s' WHERE category_id=%d", 
								$_POST['category_name_edit'], $_POST['category_colour_edit'], $_POST['category_id']);
				$wpdb->get_results($sql);
				echo "<span class=\"updated\"><p><strong>".__('Category edited successfully','spiffy-calendar')."</strong></p></span>";
			} else {
				echo "<span id=\"message\" class=\"error\"><p>".__('Missing category name or color, not updated.','spiffy-calendar')."</p></span>";
				// Restore the edit form
				$_POST['edit_'.$_POST['category_id']] = 'submit';
			}
		}
	}
	
	/*
	** Save the "Events" tab updates
	*/
	function settings_update_events() {
		// no submit action possible on this tab
	}

	/*
	** Save the "Add Event" tab updates
	*/
	function settings_update_event_edit() {
		global $current_user, $wpdb, $spiffy_user_input;
		
		$options = $this->get_options();
		
		// First some quick cleaning up 
		$edit = $create = $save = false;

		// Note: Delete requests are handled in the event-list-table.php
		
		// Collect and clean up user input
		$action = !empty($_POST['action']) ? $_POST['action'] : '';
		$event_id = !empty($_POST['event_id']) ? $_POST['event_id'] : '';
		$title = !empty($_POST['event_title']) ? sanitize_text_field ( $_POST['event_title'] ) : '';
		$desc = !empty($_POST['event_desc']) ? implode( "\n", array_map( 'sanitize_text_field', explode( "\n", $_POST['event_desc'] ))) : ''; // preserve new lines
		$begin = !empty($_POST['event_begin']) ? sanitize_text_field ( $_POST['event_begin'] ) : '';
		$end = !empty($_POST['event_end']) ? sanitize_text_field ( $_POST['event_end'] ) : '';
		$time = !empty($_POST['event_time']) ? sanitize_text_field ( $_POST['event_time'] ) : '';
		$end_time = !empty($_POST['event_end_time']) ? sanitize_text_field ( $_POST['event_end_time'] ) : '';
		$recur = !empty($_POST['event_recur']) ? sanitize_text_field ( $_POST['event_recur'] ) : 'S';
		$recur_multiplier = !empty($_POST['event_recur_multiplier']) ? sanitize_text_field ( $_POST['event_recur_multiplier'] ) : 1;
		$repeats = !empty($_POST['event_repeats']) ? $_POST['event_repeats'] : 0;
		$hide_events = !empty($_POST['event_hide_events']) ? $_POST['event_hide_events'] : '';
		$show_title = !empty($_POST['event_show_title']) ? $_POST['event_show_title'] : '';
		$event_image = !empty($_POST['event_image']) ? $_POST['event_image'] : '';
		$event_remove_image = !empty($_POST['event_remove_image']) ? $_POST['event_remove_image'] : 'false';
		$category = !empty($_POST['event_category']) ? $_POST['event_category'] : '';
		$event_author = !empty($_POST['event_author']) ? $_POST['event_author'] : $current_user->ID;
		$linky = !empty($_POST['event_link']) ? $_POST['event_link'] : '';

		if ( ($action == 'submit_edit_event') && (empty($event_id)) ) {
			// Missing event id for update?
			?>
		
	<div class="error"><p><strong><?php _e('Failure','spiffy-calendar'); ?>:</strong> <?php _e("You can't update an event if you haven't submitted an event id",'spiffy-calendar'); ?></p></div>

			<?php		
		} else if ( isset($_POST['submit_add_event']) || isset($_POST['submit_edit_event']) )	{

			// Deal with adding/updating an event 

			// Perform some validation on the submitted dates - this checks for valid years and months
			$begin = date( 'Y-m-d',strtotime($begin) );
			$end = ($end == '')? $begin : date( 'Y-m-d',strtotime($end) );
			$date_format_one = '/^([0-9]{4})-([0][1-9])-([0-3][0-9])$/';
			$date_format_two = '/^([0-9]{4})-([1][0-2])-([0-3][0-9])$/';
			if ((preg_match($date_format_one,$begin) || preg_match($date_format_two,$begin)) && 
					(preg_match($date_format_one,$end) || preg_match($date_format_two,$end))) {

				// We know we have a valid year and month and valid integers for days so now we do a final check on the date
				$begin_split = explode('-',$begin);
				$begin_y = $begin_split[0]; 
				$begin_m = $begin_split[1];
				$begin_d = $begin_split[2];
				$end_split = explode('-',$end);
				$end_y = $end_split[0];
				$end_m = $end_split[1];
				$end_d = $end_split[2];
				if (checkdate($begin_m,$begin_d,$begin_y) && checkdate($end_m,$end_d,$end_y)) {
					// Ok, now we know we have valid dates, we want to make sure that they are either equal or that 
					// the end date is later than the start date
					if (strtotime($end) >= strtotime($begin)) {
					} else {
						$error_found = 1;
						?>

	<div class="error"><p><strong><?php _e('Error','spiffy-calendar'); ?>:</strong> <?php _e('Your event end date must be either after or the same as your event begin date','spiffy-calendar'); ?></p></div>

						 <?php
					}
				 } else {
					?>

	<div class="error"><p><strong><?php _e('Error','spiffy-calendar'); ?>:</strong> <?php _e('Your date formatting is correct but one or more of your dates is invalid. Check for number of days in month and leap year related errors.','spiffy-calendar'); ?></p></div>

					<?php
				}
			} else {
				?>

	<div class="error"><p><strong><?php _e('Error','spiffy-calendar'); ?>:</strong> <?php _e('Both start and end dates must be entered and be in the format YYYY-MM-DD','spiffy-calendar'); ?></p></div>

				<?php
			}

			// We check for a valid time, or an empty one
			if ($time == '') {
				$all_day = 'T';
			} else {
				$all_day = 'F';
			}
			$time = ($time == '')?'00:00:00':date( 'H:i:00',strtotime($time) );

			// We check for a valid end time, or an empty one
			$end_time = ($end_time == '')?'00:00:00':date( 'H:i:00',strtotime($end_time) );

			// We check to make sure the URL is all right
			if (preg_match('/^(http)(s?)(:)\/\//',$linky) || $linky == '') {
			} else {
				$error_found = 1;
				?>

	<div class="error"><p><strong><?php _e('Error','spiffy-calendar'); ?>:</strong> <?php _e('Invalid link URL','spiffy-calendar'); ?></p></div>

				<?php
			}
			// The title must be non-blank and sanitized
			if ($title != '') {
			} else {
				$error_found = 1;
				?>

	<div class="error"><p><strong><?php _e('Error','spiffy-calendar'); ?>:</strong> <?php _e('The event title must not be blank','spiffy-calendar'); ?></p></div>

				<?php
			}
			// We run some checks on recurrance
			$repeats = (int)$repeats;
			if ( ($repeats == 0 && $recur == 'S') || 
				 (($repeats >= 0) && ($recur == 'W' || $recur == 'D' || $recur == 'M' || $recur == 'Y' || $recur == 'U'))
				) {
				 // all good
			} else {
				$error_found = 1;
				?>

	<div class="error"><p><strong><?php _e('Error','spiffy-calendar'); ?>:</strong> <?php _e('The repetition value must be 0 unless a type of recurrance is selected, otherwise it must be greater than or equal to 0. ','spiffy-calendar'); ?></p></div>

			<?php 
			}
			
			$recur_multiplier = (int)$recur_multiplier;
			if ( ($recur_multiplier > 1) && ($recur_multiplier <= 199) && ($recur == 'D') ) {
			} elseif ( ($recur != 'D') && ($recur_multiplier == 1) ) {
			} else {
				$error_found = 1;
				?>
				
	<div class="error"><p><strong><?php _e('Error','spiffy-calendar'); ?>:</strong> <?php _e('The number of custom days in the interval must be greater than 1 and less than 200 for a custom day recur event, or 1 for other recur types.','spiffy-calendar'); ?></p></div>
				<?php
			}
			
			// Done checks - attempt to insert or update
			if ( !isset($error_found) ) {

				// Inspection passed, now add/insert
				
				// unlink image if requested
				if ($event_remove_image === 'true') $event_image = '';
	
				if ( isset ($_POST['submit_add_event']) ) {
					$sql = $wpdb->prepare("INSERT " . WP_SPIFFYCAL_TABLE . " SET event_title='%s', event_desc='%s', event_begin='%s', event_end='%s', event_all_day='%s', event_time='%s', event_end_time='%s', event_recur='%s', event_recur_multiplier='%s', event_repeats='%s', event_hide_events='%s', event_show_title='%s', event_image='%s', event_author=%d, event_category=%d, event_link='%s'", $title, $desc, $begin, $end, $all_day, $time, $end_time, $recur, $recur_multiplier, $repeats, $hide_events, $show_title, $event_image, $event_author, $category, $linky);
					$result = $wpdb->get_results($sql);
				} else {
					$sql = $wpdb->prepare("UPDATE " . WP_SPIFFYCAL_TABLE . " SET event_title='%s', event_desc='%s', event_begin='%s', event_end='%s', event_all_day='%s', event_time='%s', event_end_time='%s', event_recur='%s', event_recur_multiplier='%s', event_repeats='%s', event_hide_events='%s', event_show_title='%s', event_image='%s', event_author=%d, event_category=%d, event_link='%s' WHERE event_id='%s'", $title, $desc, $begin, $end, $all_day, $time, $end_time, $recur, $recur_multiplier, $repeats, $hide_events, $show_title, $event_image, $event_author, $category, $linky, $event_id);
					$result = $wpdb->get_results($sql);
				}
				
				if ($wpdb->last_error) { 
					$_POST['errors'] = true;
					if ( isset ($_POST['submit_add_event']) ) {
						?>

	<div class="error">
		<p><strong><?php _e('Error','spiffy-calendar'); ?>:</strong> <?php _e('The event could not be added to the database. This may indicate a problem with your database or the way in which it is configured.','spiffy-calendar'); ?></p>
		<p><? if (is_admin()) echo $wpdb->last_error; ?></p>
	</div>

						<?php
					} else {
						?>

	<div class="error">
		<p><strong><?php _e('Error','spiffy-calendar'); ?>:</strong> <?php _e('The event could not be updated. This may indicate a problem with your database or the way in which it is configured.','spiffy-calendar'); ?></p>
		<p><? if (is_admin()) echo $wpdb->last_error; ?></p>
	</div>

						<?php
					}
				} else if ( isset ($_POST['submit_add_event']) ) {
					?>

	<div class="updated"><p><?php _e('Event added. It will now show in your calendar.','spiffy-calendar'); ?></p></div>

					<?php
				} else if ( isset ($_POST['submit_edit_event']) ) {
					?>

	<div class="updated"><p><?php _e('Event updated successfully.','spiffy-calendar'); ?></p></div>

					<?php
				}

			} else {
				// The form is going to be rejected due to field validation issues
				$_POST['errors'] = true;
			}
			
			// If there are any errors, save the user input for a re-try
			if (isset($_POST['errors']) && ($_POST['errors'] == true)) {
				$spiffy_user_input = new stdClass();
				$spiffy_user_input->event_title = $title;
				$spiffy_user_input->event_desc = $desc;
				$spiffy_user_input->event_begin = $begin;
				$spiffy_user_input->event_end = $end;
				$spiffy_user_input->event_all_day = $all_day;
				$spiffy_user_input->event_time = $time;
				$spiffy_user_input->event_end_time = $end_time;
				$spiffy_user_input->event_recur = $recur;
				$spiffy_user_input->event_recur_multiplier = $recur_multiplier;
				$spiffy_user_input->event_repeats = $repeats;
				$spiffy_user_input->event_hide_events = $hide_events;
				$spiffy_user_input->event_show_title = $show_title;
				$spiffy_user_input->event_image = $event_image;
				$spiffy_user_input->event_remove_image = $event_remove_image;
				$spiffy_user_input->event_category = $category;
				$spiffy_user_input->event_link = $linky;				
			}
		}		
	}

	/*
	** Save the "Options" tab updates
	*/
	function settings_update_options() {

		$options = $this->get_options();
		
		if ($_POST['permissions'] == 'subscriber') { $options['can_manage_events'] = 'read'; }
		else if ($_POST['permissions'] == 'contributor') { $options['can_manage_events'] = 'edit_posts'; }
		else if ($_POST['permissions'] == 'author') { $options['can_manage_events'] = 'publish_posts'; }
		else if ($_POST['permissions'] == 'editor') { $options['can_manage_events'] = 'moderate_comments'; }
		else if ($_POST['permissions'] == 'admin') { $options['can_manage_events'] = 'manage_options'; }
		else { $options['can_manage_events'] = 'manage_options'; }

		$options['calendar_style'] = sanitize_textarea_field($_POST['style']);
		$options['display_upcoming_days'] = absint($_POST['display_upcoming_days']);

		if ($_POST['display_author'] == 'on') {
			$options['display_author'] = 'true';
		} else {
			$options['display_author'] = 'false';
		}

		if ($_POST['limit_author'] == 'on') {
			$options['limit_author'] = 'true';
		} else {
			$options['limit_author'] = 'false';
		}

		if ($_POST['display_detailed'] == 'on') {
			$options['display_detailed'] = 'true';
		} else {
			$options['display_detailed'] = 'false';
		}

		if ($_POST['display_jump'] == 'on') {
			$options['display_jump'] = 'true';
		} else {
			$options['display_jump'] = 'false';
		}

		if ($_POST['display_weeks'] == 'on') {
			$options['display_weeks'] = 'true';
		} else {
			$options['display_weeks'] = 'false';
		}

		if ($_POST['enable_categories'] == 'on') {
			$options['enable_categories'] = 'true';
		} else {
			$options['enable_categories'] = 'false';
		}

		if ($_POST['enable_new_window'] == 'on') {
			$options['enable_new_window'] = 'true';
		} else {
			$options['enable_new_window'] = 'false';
		}

		if ($_POST['enable_expanded_mini_popup'] == 'on') {
			$options['enable_expanded_mini_popup'] = 'true';
		} else {
			$options['enable_expanded_mini_popup'] = 'false';
		}
		
		$options['responsive_width'] = abs((int)$_POST['responsive_width']);

		// Check to see if we are removing custom styles
		if (isset($_POST['reset_styles'])) {
			if ($_POST['reset_styles'] == 'on') {
				$options['calendar_style'] = '';
			}
		}
		update_option($this->spiffy_options, $options);

		echo "<div class=\"updated\"><p><strong>".__('Settings saved','spiffy-calendar').".</strong></p></div>";		
	}
	
	// Function to add the javascript to the admin pages
	function admin_scripts($hook)
	{ 
		if ( $hook == $this->spiffycal_menu_page ) {			
			// Date picker script
			wp_enqueue_style ( 'spiffycal-styles', plugins_url('calendrical/calendrical.css', __FILE__));
			wp_enqueue_script( 'spiffy_calendar_script', plugins_url('calendrical/jquery.calendrical.js', __FILE__), array('jquery') );

			// Media api
			wp_enqueue_media();
			
			// Add the color picker css file       
			wp_enqueue_style( 'wp-color-picker' ); 
			
			// Spiffy Calendar utility scripts
			wp_enqueue_script( 'spiffy_calendar_utilites', plugins_url('js/spiffy_utility.js', __FILE__), array('wp-color-picker', 'jquery'), '1.7', true );
		} 
	}

	// Front end scripts and styles are needed
	function enqueue_frontend_scripts_and_styles() {
		wp_enqueue_script('spiffycal-scripts');
		wp_enqueue_style ('spiffycal-styles');
	}
	
	// Calendar shortcode
	function calendar_insert($attr)
	{
		$this->enqueue_frontend_scripts_and_styles();
		
		/*
		** Standard shortcode defaults that we support here	
		*/
		extract(shortcode_atts(array(
				'cat_list'	=> '',
		  ), $attr));

		$cal_output = apply_filters ('spiffycal_calendar', $this->calendar($cat_list), $attr);
		return $cal_output;
	}

	// Weekly calendar shortcode
	function weekly_insert($attr)
	{
		$this->enqueue_frontend_scripts_and_styles();

		/*
		** Standard shortcode defaults that we support here	
		*/
		extract(shortcode_atts(array(
				'cat_list'	=> '',
		  ), $attr));

		$cal_output = $this->weekly($cat_list);
		return $cal_output;
	}

	// Mini calendar shortcode
	function minical_insert($attr) {
		$this->enqueue_frontend_scripts_and_styles();

		/*
		** Standard shortcode defaults that we support here	
		*/
		extract(shortcode_atts(array(
				'cat_list'	=> '',
		  ), $attr));

		$cal_output = $this->minical($cat_list);
		return $cal_output;
	}

	// Upcoming events shortcode
	function upcoming_insert($attr) {
		$this->enqueue_frontend_scripts_and_styles();

		/*
		** Standard shortcode defaults that we support here	
		*/
		extract(shortcode_atts(array(
				'cat_list'	=> '',
				'limit'		=> '',
				'style'		=> '',
				'none_found' => '',
		  ), $attr));

		$cal_output = '<div class="spiffy page-upcoming-events spiffy-list-' . $style . '">'
						. $this->upcoming_events($cat_list, $limit, $style, $none_found)
						. '</div>';
		return $cal_output;
	}

	// Today's events shortcode
	function todays_insert($attr) {
		$this->enqueue_frontend_scripts_and_styles();

		/*
		** Standard shortcode defaults that we support here	
		*/
		extract(shortcode_atts(array(
				'cat_list'	=> '',
				'limit'		=> '',
				'style'		=> '',
				'show_date' => 'false',
				'none_found' => '',
		  ), $attr));

		$cal_output = '<div class="spiffy page-todays-events spiffy-list-' . $style . '">'
							. $this->todays_events($cat_list, $limit, $style, $show_date, $none_found)
							. '</div>';
		return $cal_output;
	}

	// Function to indicate the number of the day passed, eg. 1st or 2nd Sunday
	function np_of_day($date)
	{
		$instance = 0;
		$dom = date('j',strtotime($date));
		if (($dom-7) <= 0) { $instance = 1; }
		else if (($dom-7) > 0 && ($dom-7) <= 7) { $instance = 2; }
		else if (($dom-7) > 7 && ($dom-7) <= 14) { $instance = 3; }
		else if (($dom-7) > 14 && ($dom-7) <= 21) { $instance = 4; }
		else if (($dom-7) > 21 && ($dom-7) < 28) { $instance = 5; }
		return $instance;
	}

	// Function to provide date of the nth day passed (eg. 2nd Sunday)
	function dt_of_sun($date,$instance,$day)
	{
		$plan = array();
		$plan['Mon'] = 1;
		$plan['Tue'] = 2;
		$plan['Wed'] = 3;
		$plan['Thu'] = 4;
		$plan['Fri'] = 5;
		$plan['Sat'] = 6;
		$plan['Sun'] = 7;
		$proper_date = date('Y-m-d',strtotime($date));
		$begin_month = substr($proper_date,0,8).'01'; 
		$offset = $plan[date('D',strtotime($begin_month))]; 
		$result_day = 0;
		$recon = 0;
		if (($day-($offset)) < 0) { $recon = 7; }
		if ($instance == 1) { $result_day = $day-($offset-1)+$recon; }
		else if ($instance == 2) { $result_day = $day-($offset-1)+$recon+7; }
		else if ($instance == 3) { $result_day = $day-($offset-1)+$recon+14; }
		else if ($instance == 4) { $result_day = $day-($offset-1)+$recon+21; }
		else if ($instance == 5) { $result_day = $day-($offset-1)+$recon+28; }
		return substr($proper_date,0,8).$result_day;
	}

	// Function to return a prefix which will allow the correct 
	// placement of arguments into the query string.
	function permalink_prefix()
	{
		// Get the permalink structure from WordPress
		global $wp;
		$p_link = esc_url(add_query_arg( $wp->query_string, '', home_url( $wp->request ) ));

		// Based on the structure, append the appropriate ending
		if (!(strstr($p_link,'?'))) { $link_part = $p_link.'?'; } else { $link_part = $p_link.'&'; }

		return $link_part;
	}

	// Configure the "Next Day" link in the calendar
	function next_day($cur_year,$cur_month,$cur_day)
	{
		list($yy,$mm,$dd) = explode("-", date("Y-m-d", mktime(0,0,0,$cur_month,$cur_day+1,$cur_year)));

		$month = $this->mod_rewrite_months[intval($mm)];
		return '<a onclick="sessionStorage.scrollTop = jQuery(window).scrollTop();" href="' . $this->permalink_prefix() . 'daynum=' . $dd . '&amp;month=' . $month . '&amp;yr=' . $yy . '">&gt;</a>';
	}

	// Configure the "Previous Day" link in the calendar
	function prev_day($cur_year,$cur_month,$cur_day)
	{
		list($yy,$mm,$dd) = explode("-", date("Y-m-d", mktime(0,0,0,$cur_month,$cur_day-1,$cur_year)));

		$month = $this->mod_rewrite_months[intval($mm)];
		return '<a onclick="sessionStorage.scrollTop = jQuery(window).scrollTop();" href="' . $this->permalink_prefix() . 'daynum=' . $dd . '&amp;month=' . $month . '&amp;yr=' . $yy . '">&lt;</a>';
	}

	// Configure the "Next Month" link in the calendar
	function next_month($cur_year,$cur_month,$minical = false)
	{
		$next_year = $cur_year + 1;

		if ($cur_month == 12) {
			return '<a onclick="sessionStorage.scrollTop = jQuery(window).scrollTop();" href="' . $this->permalink_prefix() . 'month=jan&amp;yr=' . $next_year . '">&gt;</a>';
		} else {
			$next_month = $cur_month + 1;
			$month = $this->mod_rewrite_months[$next_month];
			return '<a onclick="sessionStorage.scrollTop = jQuery(window).scrollTop();" href="' . $this->permalink_prefix() . 'month='.$month.'&amp;yr=' . $cur_year . '">&gt;</a>';
		}
	}

	// Configure the "Previous Month" link in the calendar
	function prev_month($cur_year,$cur_month,$minical = false)
	{
		$last_year = $cur_year - 1;

		if ($cur_month == 1) {
			return '<a onclick="sessionStorage.scrollTop = jQuery(window).scrollTop();" href="' . $this->permalink_prefix() . 'month=dec&amp;yr='. $last_year .'">&lt;</a>';
		} else {
			$next_month = $cur_month - 1;
			$month = $this->mod_rewrite_months[$next_month];
			return '<a onclick="sessionStorage.scrollTop = jQuery(window).scrollTop();" href="' . $this->permalink_prefix() . 'month='.$month.'&amp;yr=' . $cur_year . '">&lt;</a>';
		}
	}

	// Print upcoming events
	function upcoming_events($cat_list = '', $event_limit = '', $style = '', $none_found = '')
	{
		global $wpdb;

		$options = $this->get_options();

		// Get number of days we should go into the future 
		$future_days = $options['display_upcoming_days'];
		$day_count = 1;

		// Compute the date range to display
		$current_timestamp = current_time('timestamp');
		list($y1,$m1,$d1) = explode("-",date("Y-m-d",mktime(1*24,0,0,date("m",$current_timestamp),date("d",$current_timestamp),date("Y",$current_timestamp))));
		list($y2,$m2,$d2) = explode("-",date("Y-m-d",mktime($future_days*24,0,0,date("m",$current_timestamp),date("d",$current_timestamp),date("Y",$current_timestamp))));
		$event_range = $this->grab_events($y1,$m1,$d1,$y2,$m2,$d2,$cat_list);
		
		$output = '';
		$event_count = 0;
		while ($day_count < $future_days+1)	{
			$this_timestamp = mktime($day_count*24,0,0,date("m",$current_timestamp),date("d",$current_timestamp),date("Y",$current_timestamp));
			list($y,$m,$d) = explode("-",date("Y-m-d", $this_timestamp));
			$events = $this->filter_events($event_range, $y, $m, $d);
			usort($events, array($this, 'time_cmp'));
			if (count($events) != 0) {
				$output .= '<li class="spiffy-upcoming-day ' . apply_filters ('spiffy_upcoming_day_classes', '') . '">';
				$output .= '<span class="spiffy-upcoming-date">';
				$upcoming_day = date_i18n(get_option('date_format'), $this_timestamp);
				$output .= apply_filters ('spiffy_upcoming_day_date', $upcoming_day, $m, $d, $y );
				$output .= '</span>';
				$output .= '<ul class="spiffy-upcoming-events">';
			} 
			foreach($events as $event) {
				$output .= '<li class="spiffy-event-details spiffy-'.$style.'">'.$this->draw_event($event, $style).'</li>';
				$event_count ++;
				if (($event_limit != '') && ($event_count >= $event_limit)) break;
			}
			if (count($events) != 0) {
				$output .= '</ul></li>';
			}
			$day_count = $day_count+1;
			if (($event_limit != '') && ($event_count >= $event_limit)) break;
		}

		if ($output != '') {
			return '<ul class="spiffy upcoming-events-list">' . $output . '</ul>';
		} else if ($none_found != '') {
			return '<p class="spiffy-none-found">' . $none_found . '</p>';
		} else {
			return '';
		}
	}

	// Render today's events
	function todays_events($cat_list = '', $event_limit = '', $style = '', $show_date = 'false', $none_found = '')
	{
		global $wpdb;

		$options = $this->get_options();

		if ($show_date == 'true') {
			$date_str = '<p class="spiffy-current-date">' . date(get_option('date_format')) . '</p>';
		} else {
			$date_str = '';
		}
		
		$output = '<ul class="spiffy todays-events-list">';
		$current_timestamp = current_time('timestamp');
		$yr = date("Y",$current_timestamp);
		$mn = date("m",$current_timestamp);
		$dy = date("d",$current_timestamp);
		$events = $this->grab_events($yr,$mn,$dy,$yr,$mn,$dy,$cat_list);
		$events = $this->filter_events($events,$yr,$mn,$dy);
		usort($events, array($this, 'time_cmp'));
		$event_count = 0;
		foreach($events as $event) {
			$output .= '<li class="spiffy-event-details spiffy-'.$style.'">'.$this->draw_event($event, $style).'</li>';
			$event_count ++;
			if (($event_limit != '') && ($event_count >= $event_limit)) break;
		}
		$output .= '</ul>';
		if (count($events) != 0) {
			return $date_str . $output;
		} else if ($none_found != '') {
			return $date_str . '<p class="spiffy-none-found">' . $none_found . '</p>';
		} else {
			return $date_str;
		}
	}

	// Function to compare time in event objects
	function time_cmp($a, $b)
	{
		if ($a->event_time == $b->event_time) {
			if ($a->event_all_day == $b->event_all_day) {
				return 0;
			} else if ($a->event_all_day == 'T') {
				return -1;
			} else {
				return 1;
			}
		}
		return ($a->event_time < $b->event_time) ? -1 : 1;
	}

	// Used to draw multiple events in a grid
	function draw_grid_events($events)
	{
		// We need to sort arrays of objects by time
		usort($events, array($this, 'time_cmp'));
		$output = '';
		// Now process the events
		foreach($events as $event) {
			$output .= $this->draw_event_popup($event).'
';
		}
		return $output;
	}

	// Read the categories into memory once when drawing events
	function get_all_categories() 
	{
		global $wpdb;

		if (count($this->categories) > 0) return;
		$sql = "SELECT * FROM " . WP_SPIFFYCAL_CATEGORIES_TABLE;
		$this->categories = $wpdb->get_results($sql);
	}

	// Draw an event in the specified style
	function draw_event ( $event, $style ) {
		if ($style == 'Expanded') {
			return $this->draw_event_expanded ($event);
		} else {
			return $this->draw_event_popup ($event);
		}
	}
	
	// Draw an event to the screen in expanded format
	function draw_event_expanded($event)
	{
		global $wpdb;

		$options = $this->get_options();
		$this->get_all_categories();

		$cat_css = '';
		$cat_class = '';
		if ($options['enable_categories'] == 'true') {
			foreach ($this->categories as $cat_details) {
				if ($cat_details->category_id == $event->event_category) {
					$cat_css = ' style="color:' . esc_html($cat_details->category_colour) . ';"';
					$cat_class = ' category_' . $cat_details->category_id;
					break;
				}
			}
		}

		// Get time formatted
		if ($event->event_all_day != "T") {
			$time = date(get_option('time_format'), strtotime($event->event_time));
		} else {
			$time = "";
		}
		if ($event->event_end_time != "00:00:00") {
			$end_time = date(get_option('time_format'), strtotime($event->event_end_time));
		} else {
			$end_time = "";
		}

		$details = '<span class="spiffy-expanded-event' . $cat_class . ' spiffy-clearfix">';
		$details .= '<span class="spiffy-title"' . $cat_css . '>';
		if ($event->event_link != '') { 
			$linky = esc_url(stripslashes($event->event_link)); 
			if ($options['enable_new_window'] == 'true') {
				$target = ' target="_blank"';
			} else {
				$target = '';
			}
			$details .= '<a href="'.$linky.'" '.$cat_css.$target.'>';
		}
		$details .= esc_html(stripslashes($event->event_title));
		if ($event->event_link != '') { 
			$details .= '</a>';
		}
		$details .= '</span><span class="spiffy-meta">';
		if ($event->event_all_day != "T") {
			$details .= '<span class="spiffy-time">'. $time;
			if ($event->event_end_time != "00:00:00") {
				$details .= ' - ' . $end_time;
			}
			$details .= '</span>';
		}
		if ($options['display_author'] == 'true') {
			if ($event->event_author > 0) {
				$e = get_userdata(stripslashes($event->event_author));
				$details .= '<span class="spiffy-author"><span>'.__('Posted by', 'spiffy-calendar').':</span> '.$e->display_name . '</span>';
			}
		}
		$details .= '</span>';
		if ($event->event_image > 0) {
			$image = wp_get_attachment_image_src( $event->event_image, 'medium');
			$details .= '<span class="spiffy-img"><img src="' . $image[0] . '" alt="" /></span>';
		}
		$details .= '<span class="spiffy-desc">' . $this->format_desc($event->event_desc) . '</span>';
		if ($event->event_link != '') { 
			$linky = esc_url(stripslashes($event->event_link)); 
			if ($options['enable_new_window'] == 'true') {
				$target = ' target="_blank"';
			} else {
				$target = '';
			}
			$details .= '<span class="spiffy-link"><a href="'.$linky.'" '.$cat_css.$target.'>'.__('More details','spiffy-calendar').' &raquo;</a></span>';
		}

		$details .= '</span>';
		return $details;
	}

	// Draw an event to the screen in popup format
	function draw_event_popup($event)
	{
		global $wpdb;

		$options = $this->get_options();
		$this->get_all_categories();

		$style = '';
		$cat_class = '';
		if ($options['enable_categories'] == 'true') {
			foreach ($this->categories as $cat_details) {
				if ($cat_details->category_id == $event->event_category) {
					$style = 'style="color:' . esc_html($cat_details->category_colour) . ';"';
					$cat_class = 'category_' . $cat_details->category_id;
					break;
				}
			}
		}

		// Get time formatted
		if ($event->event_all_day != "T") {
			$time = date(get_option('time_format'), strtotime($event->event_time));
		} else {
			$time = "";
		}
		if ($event->event_end_time != "00:00:00") {
			$end_time = date(get_option('time_format'), strtotime($event->event_end_time));
		} else {
			$end_time = "";
		}

		$popup_details = '<span class="event-title" ' . $style . '>' . esc_html(stripslashes($event->event_title)) . '</span>';
		$popup_details .= '<span class="event-title-break"></span>';
		if ($event->event_all_day != "T") {
			$popup_details .= '<strong>'.__('Time','spiffy-calendar').':</strong> ' . $time;
			if ($event->event_end_time != "00:00:00") {
				$popup_details .= ' - ' . $end_time;
			}
			$popup_details .= '<br />';
		}
		if ($event->event_image > 0) {
			$image = wp_get_attachment_image_src( $event->event_image, 'thumbnail');
			$popup_details .= '<img src="' . $image[0] . '" alt="" />';
		}
		if ($options['display_author'] == 'true') {
			if ($event->event_author > 0) {
				$e = get_userdata(stripslashes($event->event_author));
				$popup_details .= '<strong>'.__('Posted by', 'spiffy-calendar').':</strong> '.$e->display_name;
			}
		}
		if ($options['display_author'] == 'true' || $event->event_all_day != "T") {
			$popup_details .= '<span class="event-content-break"></span>';
		}
		if ($event->event_link != '') { 
			$linky = esc_url(stripslashes($event->event_link)); 
			if ($options['enable_new_window'] == 'true') {
				$target = ' target="_blank"';
			} else {
				$target = '';
			}
			$linktag = 'a';
			$linkdetails = ' href="' . $linky . '" ' . $target . ' ';
		} else { 
			$linktag = 'span';
			$linkdetails = ' onclick="return true;"';
		}

		$details = '<span class="calnk ' . $cat_class . '"><' . $linktag . $linkdetails . ' class="calnk-link" ' . $style . '><span class="calnk-box"><span class="spiffy-title">' . esc_html(stripslashes($event->event_title)) . '</span>';
		if ($options['display_detailed'] == 'true') {
			if ($time != '') {
				$details .= '<span class="calnk-time"><br />' . $time;
				if ($event->event_end_time != "00:00:00") {
					$details .= ' - ' . $end_time;
				}
				$details .= '</span>';
			}
			if ($event->event_image > 0) {
				$details .= '<br /><img alt="" class="calnk-icon" src="' . $image[0] . '" />';
			}
		}
		$details .= '<span class="spiffy-popup" '.$style.'>' . $popup_details . '' . $this->format_desc($event->event_desc) . '</span></span></' . $linktag . '></span>';

		return $details;
	}

	/*
	**  Sanitize and format the raw description ready for output
	*/
	function format_desc ($desc) {
		$data = apply_filters('spiffy_calendar_desc', wpautop(esc_textarea(stripslashes($desc))));
		return str_replace(array('<p>', '</p>'), array('<span class="ca-desc-p">', '</span>'), $data);
	}
	
	/*
	**	Grab all events for the requested date range from the DB
	**
	**  The retrieved events consist of specific scheduled events within the range, and all recurring events that
	**  fall within the same year(s)
	*/
	function grab_events($y1,$m1,$d1,$y2,$m2,$d2,$cat_list = '')
	{
		global $wpdb;

		// Get the date format right
		$date1 = $y1 . '-' . $m1 . '-' . $d1;
		$date2 = $y2 . '-' . $m2 . '-' . $d2;
		//echo 'Grabbing range '.$date1.' to '.$date2.'<br />';
		
		$date1_timestamp = strtotime($date1);
		$date2_timestamp = strtotime($date2);

		// Format the category list
		$pattern = '/^\d+(?:,\d+)*$/';
		if ($cat_list == '') { 
			$cat_sql = ''; 
		} else if ( preg_match($pattern, $cat_list) ) {
			$cat_sql = 'AND event_category in ('.$cat_list.')';
		} else {
			$cat_sql = '';
		}
				 
		// The collated SQL code
		$sql = "SELECT a.*,'Normal' AS type FROM " . WP_SPIFFYCAL_TABLE . " AS a WHERE a.event_begin <= '$date2' AND a.event_end >= '$date1' AND a.event_recur = 'S' ".$cat_sql." 
UNION ALL 
SELECT b.*,'Yearly' AS type FROM " . WP_SPIFFYCAL_TABLE . " AS b WHERE b.event_recur = 'Y' AND b.event_begin <= '$date2' AND b.event_repeats = 0 ".$cat_sql." 
UNION ALL 
SELECT c.*,'Yearly' AS type FROM " . WP_SPIFFYCAL_TABLE . " AS c WHERE c.event_recur = 'Y' AND c.event_begin <= '$date2' AND c.event_repeats != 0 AND (EXTRACT(YEAR FROM '$date1')-EXTRACT(YEAR FROM c.event_end)) <= c.event_repeats ".$cat_sql." 
UNION ALL 
SELECT d.*,'Monthly' AS type FROM " . WP_SPIFFYCAL_TABLE . " AS d WHERE d.event_recur = 'M' AND d.event_begin <= '$date2' AND d.event_repeats = 0 ".$cat_sql." 
UNION ALL
SELECT e.*,'Monthly' AS type FROM " . WP_SPIFFYCAL_TABLE . " AS e WHERE e.event_recur = 'M' AND e.event_begin <= '$date2' AND e.event_repeats != 0 AND (PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM '$date1'),EXTRACT(YEAR_MONTH FROM e.event_end))) <= e.event_repeats ".$cat_sql." 
UNION ALL
SELECT f.*,'MonthSun' AS type FROM " . WP_SPIFFYCAL_TABLE . " AS f WHERE f.event_recur = 'U' AND f.event_begin <= '$date2'  AND f.event_repeats = 0 ".$cat_sql." 
UNION ALL
SELECT g.*,'MonthSun' AS type FROM " . WP_SPIFFYCAL_TABLE . " AS g WHERE g.event_recur = 'U' AND g.event_begin <= '$date2' AND g.event_repeats != 0 AND (PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM '$date1'),EXTRACT(YEAR_MONTH FROM g.event_end))) <= g.event_repeats ".$cat_sql." 
UNION ALL
SELECT h.*,'Weekly' AS type FROM " . WP_SPIFFYCAL_TABLE . " AS h WHERE h.event_recur = 'W' AND '$date2' >= h.event_begin AND h.event_repeats = 0 ".$cat_sql." 
UNION ALL
SELECT i.*,'Weekly' AS type FROM " . WP_SPIFFYCAL_TABLE . " AS i WHERE i.event_recur = 'W' AND '$date2' >= i.event_begin AND i.event_repeats != 0 AND (i.event_repeats*7) >= (TO_DAYS('$date1') - TO_DAYS(i.event_end)) ".$cat_sql." 
UNION ALL
SELECT j.*,'Daily' AS type FROM " . WP_SPIFFYCAL_TABLE . " AS j WHERE j.event_recur = 'D' AND '$date2' >= j.event_begin AND j.event_repeats = 0 ".$cat_sql."
UNION ALL
SELECT k.*,'Daily' AS type FROM " . WP_SPIFFYCAL_TABLE . " AS k WHERE k.event_recur = 'D' AND '$date2' >= k.event_begin AND k.event_repeats != 0 AND (k.event_repeats*k.event_recur_multiplier) >= (TO_DAYS('$date1') - TO_DAYS(k.event_end)) ".$cat_sql."
ORDER BY event_id";

		// NOTE - we do not allow infinite custom days
		
		// Run the query
		$events =$wpdb->get_results($sql);
		//print_r($events);
		return $events;
	}
	
	// Filter all events already queried from a date range for a specific date
	function filter_events(array &$events,$y,$m,$d)
	{
		// Get the date format right
		$date = $y . '-' . $m . '-' . $d;
		$date_timestamp = strtotime($date);
		$arr_events = array();

		if (!empty($events)) {
			foreach($events as $event) {
				// get timestamp event times
				$event_begin_timestamp = strtotime($event->event_begin);
				$event_end_timestamp = strtotime($event->event_end);
				
				if ($event->type == 'Normal') {
					if ( ($event_begin_timestamp <= $date_timestamp) && ($event_end_timestamp >= $date_timestamp)) {
						array_push($arr_events, $event);
					}
 				} else if ($event->type == 'Yearly') {
					// Note - we can't use the basic recurrence check here due to leap days
					
					// we know the year is good, check if the event recurrence ends before the target date
					if ($event->event_repeats != 0) {
						$final_recurrence_end_timestamp = strtotime('+'.strval($event->event_repeats).' years', $event_end_timestamp);
						if ($final_recurrence_end_timestamp < $date_timestamp) {
							continue; // the final recurrence ends before the target date
						}
					}
					
					// now check the date ranges
					$year_begin = date('Y',$event_begin_timestamp);
					$year_end = date('Y',$event_end_timestamp);
					
					if ($year_begin == $year_end) {
						// if the event occurs within one year, perform the basic test
						if (date('m-d',$event_begin_timestamp) <= date('m-d',$date_timestamp) &&
							 date('m-d',$event_end_timestamp) >= date('m-d',$date_timestamp)) {
							array_push($arr_events, $event);
						}
					} else if ($year_begin < $year_end) {
						// if the event wraps around a year, the test is altered appropriately
						if (date('m-d',$event_begin_timestamp) <= date('m-d',$date_timestamp) ||
							 date('m-d',$event_end_timestamp) >= date('m-d',$date_timestamp)) {
							array_push($arr_events, $event);
						}
					}
 				} else if ($event->type == 'Monthly') {
					// Note - we can't use the basic recurrence check here due to month length variations
					
					// we know the year is good, check if the event recurrence ends before the target date
					if ($event->event_repeats != 0) {
						$final_recurrence_end_timestamp = strtotime('+'.strval($event->event_repeats).' months', $event_end_timestamp);
						if ($final_recurrence_end_timestamp < $date_timestamp) {
							continue; // the final recurrence ends before the target date
						}
					}
					
					//now check the date ranges for this event's dates
					$month_begin = date('m',$event_begin_timestamp);
					$month_end = date('m',$event_end_timestamp);

					if (($month_begin == $month_end) && ($event_begin_timestamp <= $date_timestamp)) {
						if (date('d',$event_begin_timestamp) <= date('d',$date_timestamp) &&
							date('d',$event_end_timestamp) >= date('d',$date_timestamp)) {
							array_push($arr_events, $event);
	 					}
				 	} else if (($month_begin < $month_end) && ($event_begin_timestamp <= $date_timestamp)) {
						if ( ($event->event_begin <= date('Y-m-d',$date_timestamp)) 
							&& (date('d',$event_begin_timestamp) <= date('d',$date_timestamp) 
							|| date('d',$event_end_timestamp) >= date('d',$date_timestamp)) ) {
							array_push($arr_events, $event);
	 					}
				 	}
 				} else if ($event->type == 'MonthSun') {
					// we know the year is good, check if the event recurrence ends before the target date
					if ($event->event_repeats != 0) {
						$final_recurrence_end_timestamp = strtotime('+'.strval($event->event_repeats).' months', $event_end_timestamp);
						$final_recurrence_end_timestamp += 24*60*60*7;	// add one week since this match is by day of week rather than number
						if ($final_recurrence_end_timestamp < $date_timestamp) {
							continue; // the final recurrence ends before the target date
						}
					}
					
					//now check the date ranges for this event's days of week
					$month_begin = date('m',$event_begin_timestamp);
					$month_end = date('m',$event_end_timestamp);

					// Setup some variables and get some values
					$dow = date('w',$event_begin_timestamp);
					if ($dow == 0) { $dow = 7; }
					$start_ent_this = $this->dt_of_sun($date,$this->np_of_day($event->event_begin),$dow);
					$start_ent_prev = $this->dt_of_sun(date('Y-m-d',strtotime($date.'-1 month')),$this->np_of_day($event->event_begin),$dow);
					$len_ent = $event_end_timestamp-$event_begin_timestamp;

					// The grunt work
					if (($month_begin == $month_end) && ($event_begin_timestamp <= $date_timestamp)) {
						// The checks
						if ($event_begin_timestamp <= $date_timestamp 
							&& $event_end_timestamp >= $date_timestamp) {
							// Handle the first occurrence
							array_push($arr_events, $event);
	 					}
						else if (strtotime($start_ent_this) <= $date_timestamp 
							&& $date_timestamp <= strtotime($start_ent_this)+$len_ent) {
							// Now remaining items 
							array_push($arr_events, $event);
	 					}
				 	} else if (($month_begin < $month_end) && ($event_begin_timestamp <= $date_timestamp)) {
						// The checks
						if ($event_begin_timestamp <= $date_timestamp 
							&& $event_end_timestamp >= $date_timestamp) {
							// Handle the first occurrence
							array_push($arr_events, $event);
	 					} else if (strtotime($start_ent_prev) <= $date_timestamp 
							&& $date_timestamp <= strtotime($start_ent_prev)+$len_ent) {
							 // Remaining items from prev month
							array_push($arr_events, $event);
	 					} else if (strtotime($start_ent_this) <= $date_timestamp 
							&& $date_timestamp <= strtotime($start_ent_this)+$len_ent) {
							// Remaining items starting this month
							array_push($arr_events, $event);
	 					}
				 	}
 				} else if ($event->type == 'Weekly') {
					// Perform basic recurrence test for 7 days
					if ($this->event_will_happen($date_timestamp, $event, 7, $event_begin_timestamp, $event_end_timestamp)) {
						array_push ($arr_events, $event);
					}
 				} else if ($event->type == 'Daily') {
					// Perform basic recurrence test for "event_repeats" days
					if ($this->event_will_happen($date_timestamp, $event, $event->event_recur_multiplier, $event_begin_timestamp, $event_end_timestamp)) {
						array_push ($arr_events, $event);
					}
				}
			}
		}
		// count the number of hide events
		$hide_event_count = 0;
		foreach($arr_events as $arr_event) {
			if ($arr_event->event_hide_events == 'T') { $hide_event_count++; }
		}
		if ($hide_event_count) { // hide_events event found for this date.
			// separate "hide events" from normal events
			$hide_events = array();
			$normal_events = array();
			foreach($arr_events as $arr_event) {
				if ($arr_event->event_hide_events == 'T') {
					array_push($hide_events, $arr_event);
				} else {
					array_push($normal_events, $arr_event);
				}
			}
			// use the show_title flag in the array (not the database) to
			// select which events to show after filtering on hide_events
			foreach($normal_events as $normal_event) {
				$normal_event->event_show_title = 'T';   // initialize
			}
			foreach($normal_events as $normal_event) {
				foreach($hide_events as $hide_event) {
					if ($normal_event->event_category == $hide_event->event_category) {
						// normal event has same category as hide_event: don't show it
						$normal_event->event_show_title = 'F';
						break;   // break out of inner loop
					}
				}
			}
			// create a new array of events to display
			$shown_events = array();
			// show hidden events first on calendar
			foreach($hide_events as $hide_event) {
				if ($hide_event->event_show_title == 'T') {array_push($shown_events, $hide_event);}
			}
			// then show normal events
			foreach($normal_events as $normal_event) {
				if ($normal_event->event_show_title == 'T') {array_push($shown_events, $normal_event);}
			}
			return $shown_events;			
		}
		else { return $arr_events; }
	}
	
	/*
	** Return true if the given event will occur on the given target date timestamp
	*/
	function event_will_happen ($date_timestamp, $event, $num_days, $event_begin_timestamp, $event_end_timestamp) {

		
		// Quick simple test - does the target date fall within the first occurrence of the event?
		if (($event_begin_timestamp <= $date_timestamp) && ($event_end_timestamp >= $date_timestamp)) {
			return true;
		}
				
		// Check that the target is beyond the start date of the event and before the end of the last recurrence
		if ($event_begin_timestamp <= $date_timestamp) {
			if ( ($event->event_repeats == 0) ||			// event recurs infinitely OR
				 ($event_end_timestamp + $num_days*($event->event_repeats)*(24*60*60) >= $date_timestamp) // ensure the target day falls before the end of the last recurrence
				) {
					
				// Calculate number of recurrences from first occurrence to target date
				$num_recurs_from_begin = floor(floor(($date_timestamp - $event_begin_timestamp) / (60 * 60 * 24)) / $num_days);
				$num_recurs_from_begin_remainder = (($date_timestamp - $event_begin_timestamp) / (60 * 60 * 24)) % $num_days;
				$num_recurs_from_end = floor(floor(($date_timestamp - $event_end_timestamp) / (60 * 60 * 24)) / $num_days);
				$num_recurs_from_end_remainder = floor(floor(($date_timestamp - $event_end_timestamp) / (60 * 60 * 24)) % $num_days);
				
				// Determine if a recurrence of the event falls on the target date
				 if (($num_recurs_from_begin_remainder == 0) || ($num_recurs_from_end_remainder == 0)) {
					// target date is exactly "n" recurrences from the first occurrence begin or end date
					return true;													
				} else if ($num_recurs_from_begin > $num_recurs_from_end) {
					// target date falls between the event begin and end of a recurrence
					return true;													
				}
			}
		}
		return false;
	}

	// Comparison functions for building the calendar select options
	function calendar_month_comparison($displayed_month, $month) {
		return ($displayed_month == $month)? ' selected="selected"' : '';
	}

	function calendar_year_comparison($c_year, $year) {
		return ($c_year == $year)? ' selected="selected"' : '';
	}

	// Determine the date requested for the current calendar display from the querystring, return as array (0=>year, 1=>month, 2=>day)
	function get_date_from_args () {
		global $wpdb;
		
		$current_timestamp = current_time('timestamp');
		if ( isset($_GET['yr']) && (isset($_GET['month'])) && ($_GET['yr'] >= 0) && ((int)$_GET['yr'] != 0) && ($_GET['yr'] <= 3000) ) {
			
			$year = $wpdb->prepare("%d",$_GET['yr']);
			$month = 1;
			if ($_GET['month'] == 'jan') { $month = 1; }
			else if ($_GET['month'] == 'feb') { $month = 2; }
			else if ($_GET['month'] == 'mar') { $month = 3; }
			else if ($_GET['month'] == 'apr') { $month = 4; }
			else if ($_GET['month'] == 'may') { $month = 5; }
			else if ($_GET['month'] == 'jun') { $month = 6; }
			else if ($_GET['month'] == 'jul') { $month = 7; }
			else if ($_GET['month'] == 'aug') { $month = 8; }
			else if ($_GET['month'] == 'sep') { $month = 9; }
			else if ($_GET['month'] == 'oct') { $month = 10; }
			else if ($_GET['month'] == 'nov') { $month = 11; }
			else if ($_GET['month'] == 'dec') { $month = 12; }
		 } else {
			// No valid month causes the calendar to default to today
			$year = date("Y", $current_timestamp);
			$month = date("m", $current_timestamp);
		}
		if (isset($_GET['daynum'])) {
			$day = $wpdb->prepare("%d",$_GET['daynum']);
		} else {
			$day = date("d", $current_timestamp);		
		}
		return array($year, $month, $day);
	}
	
	// Build day of week names array
	function get_day_names ($type) {
		if ($type == 'full') {
			$name_days = array(0=>__('Sunday','spiffy-calendar'),
								__('Monday','spiffy-calendar'),
								__('Tuesday','spiffy-calendar'),
								__('Wednesday','spiffy-calendar'),
								__('Thursday','spiffy-calendar'),
								__('Friday','spiffy-calendar'),
								__('Saturday','spiffy-calendar'));			
		} else {
			$name_days = array(0=>__('Su','spiffy-calendar'),
								__('Mo','spiffy-calendar'),
								__('Tu','spiffy-calendar'),
								__('We','spiffy-calendar'),
								__('Th','spiffy-calendar'),
								__('Fr','spiffy-calendar'),
								__('Sa','spiffy-calendar'));
			
		}
		if (get_option('start_of_week') != 0) {
			// Use Monday for start of week if anything other than Sunday is set
			$sunday = array_shift ($name_days);
			$name_days[6] = $sunday;
		}
		return $name_days;
	}
	
	// Determine the index of the weekday for first of the month
	function get_first_weekday ($year, $month) {
		// Week starts Sunday
		if (get_option('start_of_week') == 0) {
			$first_weekday = date("w",mktime(0,0,0,$month,1,$year));
			$first_weekday = ($first_weekday==0?1:$first_weekday+1);
		} else {
			// Otherwise assume the week starts on a Monday. Anything other 
			// than Sunday or Monday is just plain odd
			$first_weekday = date("w",mktime(0,0,0,$month,1,$year));
			$first_weekday = ($first_weekday==0?7:$first_weekday);
		}
		return ($first_weekday);
	}
	
	// Main calendar output
	function calendar($cat_list = '') {
		global $wpdb;

		$options = $this->get_options();
		$this->get_all_categories();

		// Build day of week names array
		$name_days = $this->get_day_names('full');

		// Determine month from arguments if provided
		$current_timestamp = current_time('timestamp');
		list($c_year, $c_month, $c_day) = $this->get_date_from_args();

		// Determine the index of the weekday for first of the month
		$first_weekday = $this->get_first_weekday($c_year, $c_month);

		$days_in_month = date("t", mktime (0,0,0,$c_month,1,$c_year));
		
		if ($options['display_weeks'] == 'true')
			$num_columns = 8;
		else
			$num_columns = 7;
	
		// Start the table and add the header and navigation
		$calendar_body = '';
		$calendar_body .= '
<table class="spiffy calendar-table bigcal">';


		// The header of the calendar table and the links.
		$calendar_body .= '
	<tr class="calendar-heading"><td colspan="' . $num_columns . '" class="calendar-date-switcher">
		<table class="calendar-heading-tbl">
		<tr>
			<td class="calendar-prev">' . $this->prev_month($c_year,$c_month) . '</td>
';

		// Optionally add date jumper
		if ($options['display_jump'] == 'true') {
			$calendar_body .= '
			<td class="calendar-month">
				<form method="get" action="'.htmlspecialchars($_SERVER['REQUEST_URI']).'">';

			if (isset($_SERVER['QUERY_STRING'])) { 
				$qsa = array();
				parse_str($_SERVER['QUERY_STRING'], $qsa);
				foreach ($qsa as $name => $argument) {
					if ($name != 'month' && $name != 'yr') {
						$calendar_body .= '<input type="hidden" name="'.strip_tags($name).'" value="'.strip_tags($argument).'" />';
					}
				}
			}

			// We build the months in the switcher
			$calendar_body .= '
					<select name="month">
						<option value="jan"'.$this->calendar_month_comparison($c_month, 1).'>'.__('January','spiffy-calendar').'</option>
						<option value="feb"'.$this->calendar_month_comparison($c_month, 2).'>'.__('February','spiffy-calendar').'</option>
						<option value="mar"'.$this->calendar_month_comparison($c_month, 3).'>'.__('March','spiffy-calendar').'</option>
						<option value="apr"'.$this->calendar_month_comparison($c_month, 4).'>'.__('April','spiffy-calendar').'</option>
						<option value="may"'.$this->calendar_month_comparison($c_month, 5).'>'.__('May','spiffy-calendar').'</option>
						<option value="jun"'.$this->calendar_month_comparison($c_month, 6).'>'.__('June','spiffy-calendar').'</option>
						<option value="jul"'.$this->calendar_month_comparison($c_month, 7).'>'.__('July','spiffy-calendar').'</option> 
						<option value="aug"'.$this->calendar_month_comparison($c_month, 8).'>'.__('August','spiffy-calendar').'</option> 
						<option value="sep"'.$this->calendar_month_comparison($c_month, 9).'>'.__('September','spiffy-calendar').'</option> 
						<option value="oct"'.$this->calendar_month_comparison($c_month, 10).'>'.__('October','spiffy-calendar').'</option> 
						<option value="nov"'.$this->calendar_month_comparison($c_month, 11).'>'.__('November','spiffy-calendar').'</option> 
						<option value="dec"'.$this->calendar_month_comparison($c_month, 12).'>'.__('December','spiffy-calendar').'</option> 
					</select>
					<select name="yr">';

			// The year switcher
			$current_year = date("Y",$current_timestamp);

			if ($c_year < $current_year-1) {
				$calendar_body .= sprintf('
						<option value="%1$s" selected>%1$s</option>', $c_year);
			}
			for ($year_offset = -1; $year_offset < 30; $year_offset++) {
				$option_year = $current_year + $year_offset;
				$option_select = ($option_year == $c_year)? ' selected' : '';
				$calendar_body .= sprintf('
						<option value="%1$s" %2$s>%1$s</option>', $option_year, $option_select);
			}
			if ($c_year >= $current_year+30) {
				$calendar_body .= sprintf('
						<option value="%1$s" selected>%1$s</option>', $c_year);
			}
			$calendar_body .= '
					</select>
					<input type="submit" onclick="sessionStorage.scrollTop = jQuery(window).scrollTop();" value="'.__('Go','spiffy-calendar').'" />
				</form>
			</td>';
		} else {
			$calendar_body .= '
			<td class="calendar-month">'.ucfirst(date_i18n("F", strtotime($c_year."-".$c_month."-01"))).' '.$c_year.'</td>';
		}
		$calendar_body .= '
			<td class="calendar-next">' . $this->next_month($c_year,$c_month) . '</td>
		</tr>
		</table>
	</td></tr>';

		// Print the headings of the days of the week
		$calendar_body .= '<tr class="weekday-titles">';
		if ($options['display_weeks'] == 'true') {
			$calendar_body .= '<td class="weekend-heading week-number-heading">'.__("#", 'spiffy-calendar').'</td>';		
		}
		for ($i=1; $i<=7; $i++) {
			// Colours need to be different if the starting day of the week is different
			if (get_option('start_of_week') == 0) {
				$calendar_body .= '<td class="'.($i<7&$i>1?'normal-day-heading':'weekend-heading').'">'.$name_days[$i-1].'</td>';
			} else {
				$calendar_body .= '<td class="'.($i<6?'normal-day-heading':'weekend-heading').'">'.$name_days[$i-1].'</td>';
			}
		}
		$calendar_body .= '</tr>';

		// Get all potential events for the month ready
		$potential_events = $this->grab_events($c_year,$c_month,1,$c_year,$c_month,$days_in_month,$cat_list);

		// Loop through the days, drawing each day box
		$go = FALSE;
		for ($i=1; $i<=$days_in_month;) {
			$calendar_body .= '<tr>';
			if ($options['display_weeks'] == 'true') {
				$calendar_body .= '<td class="day-without-date week-number">'.date("W", mktime (0,0,0,$c_month,$i,$c_year)) .'</td>';		
			}
			for ($ii=1; $ii<=7; $ii++) {
				if ($ii==$first_weekday && $i==1) {
					$go = TRUE;
				} elseif ($i > $days_in_month ) {
					$go = FALSE;
				}
				
				// Determine "weekend" class applicability
				$weekend = '';
				if (get_option('start_of_week') == 0) {
					$weekend = ($ii<7&$ii>1?'':' weekend');
				} else {
					$weekend = ($ii<6?'':' weekend');
				}
				
				if ($go) {
					// This box has a date in it, get the events
					$grabbed_events = $this->filter_events($potential_events, $c_year,$c_month,$i,$cat_list);
					$no_events_class = '';
					if (!count($grabbed_events)) {
						$no_events_class = ' no-events';
					}
					$calendar_body .= '	<td class="spiffy-day-' . $i . ' ' . (date("Ymd", mktime (0,0,0,$c_month,$i,$c_year))==date("Ymd",$current_timestamp)?'current-day':'').$weekend.$no_events_class.' day-with-date"><span class="day-number'.$weekend.'">'.$i++.'</span><span class="event">' . $this->draw_grid_events($grabbed_events) . '</span></td>';
				} else {
					// This box is empty
					$calendar_body .= '	<td class="day-without-date' . $weekend . '">&nbsp;</td>';
				}
			}
			$calendar_body .= '</tr>';
		}
		$calendar_body .= '</table>';

		if ($options['enable_categories'] == 'true') {
			$calendar_body .= '<table class="spiffy cat-key">';
			$calendar_body .= '<colgroup>
	<col style="width:10px; height:10px;">
	<col>
</colgroup>';
			$calendar_body .= '
<tr><td colspan="2" class="cat-key-cell"><strong>'.__('Category Key','spiffy-calendar').'</strong></td></tr>';
			$filtered_cats = explode(',',$cat_list);
			foreach($this->categories as $cat_detail) {
				if ( ($cat_list == '') || (in_array($cat_detail->category_id, $filtered_cats))) {
					$calendar_body .= '<tr><td style="background-color:' . esc_html($cat_detail->category_colour) . '; " class="cat-key-cell"></td>
<td class="cat-key-cell">&nbsp;'.$cat_detail->category_name.'</td></tr>';
				}
			}
			$calendar_body .= '</table>';
		}

		return $calendar_body;
	}

	// Draw a weekly calendar
	function weekly($cat_list = '') {
		global $wpdb;

		$options = $this->get_options();
		$this->get_all_categories();

		// Build day of week names array
		$name_days = $this->get_day_names ('full');

		// Determine date from arguments if provided
		$current_timestamp = current_time('timestamp');
		list($c_year, $c_month, $c_day) = $this->get_date_from_args();

		$first = strtotime($c_year.'-'.$c_month.'-'.$c_day);
		$day_of_week = date("N", $first);
		
		// Determine the date range from the first to last day of week
		if ((get_option('start_of_week') == 0) && ($day_of_week != 7)) {
			$first = strtotime('last Sunday', $first);
		} else if ((get_option('start_of_week') != 0) && ($day_of_week != 1)) {
			$first = strtotime('last Monday', $first);
		}
		$last = strtotime('+6 day', $first);
		$y1 = date("Y", $first);
		$m1 = date("m", $first);
		$d1 = date("d", $first);
		$y2 = date("Y", $last);
		$m2 = date("m", $last);
		$d2 = date("d", $last);
		
		if ($options['display_weeks'] == 'true')
			$num_columns = 8;
		else
			$num_columns = 7;
	
		// Start the table and add the header and navigation
		$calendar_body = '';
		$calendar_body .= '
<table class="spiffy calendar-table bigcal spiffy-weekly">';

		// The header of the calendar table and the links.
		$calendar_body .= '
	<tr class="calendar-heading"><td colspan="' . $num_columns . '" class="calendar-date-switcher">
		<table class="calendar-heading-tbl">
		<tr>
			<td class="calendar-prev">' . $this->prev_day($y1,$m1,$d1) . '</td>
';
		$calendar_body .= '
			<td class="calendar-month">'.ucfirst(date_i18n("F", strtotime($c_year."-".$c_month."-01"))).' '.$c_year.'</td>';
		$calendar_body .= '
			<td class="calendar-next">' . $this->next_day($y2,$m2,$d2) . '</td>
		</tr>
		</table>
	</td></tr>';

		// Print the headings of the days of the week
		$calendar_body .= '<tr class="weekday-titles">';
		if ($options['display_weeks'] == 'true') {
			$calendar_body .= '<td class="weekend-heading week-number-heading">'.__("#", 'spiffy-calendar').'</td>';		
		}
		for ($i=1; $i<=7; $i++) {
			// Colours need to be different if the starting day of the week is different
			if (get_option('start_of_week') == 0) {
				$calendar_body .= '<td class="'.($i<7&$i>1?'normal-day-heading':'weekend-heading').'">'.$name_days[$i-1].'</td>';
			} else {
				$calendar_body .= '<td class="'.($i<6?'normal-day-heading':'weekend-heading').'">'.$name_days[$i-1].'</td>';
			}
		}
		$calendar_body .= '</tr>';

		// Get all potential events for the month ready
		$potential_events = $this->grab_events($y1,$m1,$d1,$y2,$m2,$d2,$cat_list);

		// Loop through the days, drawing each day box
		$calendar_body .= '<tr>';
		if ($options['display_weeks'] == 'true') {
			$calendar_body .= '<td class="day-without-date week-number">'.date("W", mktime (0,0,0,$c_month,$i,$c_year)) .'</td>';		
		}
		for ($ii=1; $ii<=7; $ii++) {
			
			// Determine "weekend" class applicability
			$weekend = '';
			if (get_option('start_of_week') == 0) {
				$weekend = ($ii<7&$ii>1?'':' weekend');
			} else {
				$weekend = ($ii<6?'':' weekend');
			}
			
			// Compute the date we are displaying
			$this_date = mktime (($ii-1)*24, 0, 0, $m1, $d1, $y1);
			list($yy,$mm,$dd) = explode("-", date("Y-m-d", $this_date));
			
			// Get the events
			$grabbed_events = $this->filter_events($potential_events, $yy,$mm,$dd,$cat_list);
			$no_events_class = '';
			if (!count($grabbed_events)) {
				$no_events_class = ' no-events';
			}
			$calendar_body .= '	<td class="spiffy-day-' . $dd . ' ' . 
								(date("Ymd", mktime (0,0,0,$mm,$dd,$yy))==date("Ymd",$current_timestamp)?'current-day':'').
								$weekend.$no_events_class.' day-with-date"><span class="day-number'.$weekend.'">' . $dd . '</span><span class="event">' . $this->draw_grid_events($grabbed_events) . '</span></td>';
			 
		}
		$calendar_body .= '</tr>';

		$calendar_body .= '</table>';

		if ($options['enable_categories'] == 'true') {
			$calendar_body .= '<table class="spiffy cat-key">';
			$calendar_body .= '<colgroup>
	<col style="width:10px; height:10px;">
	<col>
</colgroup>';
			$calendar_body .= '
<tr><td colspan="2" class="cat-key-cell"><strong>'.__('Category Key','spiffy-calendar').'</strong></td></tr>';
			$filtered_cats = explode(',',$cat_list);
			foreach($this->categories as $cat_detail) {
				if ( ($cat_list == '') || (in_array($cat_detail->category_id, $filtered_cats))) {
					$calendar_body .= '<tr><td style="background-color:' . esc_html($cat_detail->category_colour) . '; " class="cat-key-cell"></td>
<td class="cat-key-cell">&nbsp;'.$cat_detail->category_name.'</td></tr>';
				}
			}
			$calendar_body .= '</table>';
		}

		return $calendar_body;
	}
	
	// Used to create a hover with all a day's events for minical
	function minical_draw_grid_events($events, $day_of_week = '')
	{
		$options = $this->get_options();
		$this->get_all_categories();

		// We need to sort arrays of objects by time
		usort($events, array($this, 'time_cmp'));
		
		// Only show anything if there are events
		$output = '';
		if (count($events)) {
			// Setup the wrapper
			$output = '<span class="calnk"><span class="mini-link calnk-link" style="background-color:#F8F9CD;" onClick="return true;">'.$day_of_week.'<span class="spiffy-popup">';
			
			// Process the events
			foreach($events as $event) {
				if ($event->event_all_day == 'T') { 
					$the_time = __('all day', 'spiffy-calendar'); 
				} else if ($event->event_end_time == '00:00:00') { 
					$the_time = __('at ', 'spiffy-calendar') . date(get_option('time_format'), strtotime($event->event_time)); 
				} else {
					$the_time = __('from ', 'spiffy-calendar') . date(get_option('time_format'), strtotime($event->event_time)); 
					$the_time .= __(' to ', 'spiffy-calendar') . date(get_option('time_format'), strtotime($event->event_end_time));
				} 
				if ($event->event_link != '') { 
					$linky = esc_url(stripslashes($event->event_link)); 
					if ($options['enable_new_window'] == 'true') {
						$target = ' target="_blank"';
					} else {
						$target = '';
					}
					$output .= '<a class="calnk-link" href="' . $linky . '" ' . $target . '>';
				}
				$cat_css = '';
				$cat_class = '';
				if ($options['enable_categories'] == 'true') {
					foreach ($this->categories as $cat_details) {
						if ($cat_details->category_id == $event->event_category) {
							$cat_css = ' style="color:' . esc_html($cat_details->category_colour) . ';"';
							$cat_class = ' category_' . $cat_details->category_id;
							break;
						}
					}
				}
				
				$output .= '<strong class="'.$cat_class.'" '.$cat_css.'>'.esc_html(stripslashes($event->event_title)).'</strong> '.$the_time.'<br />';
				if ($options['enable_expanded_mini_popup'] == 'true') {
					if ($event->event_image > 0) {
						$image = wp_get_attachment_image_src( $event->event_image, 'thumbnail');
						$output .= '<img src="' . $image[0] . '" alt="" />';
					}
					$output .= $this->format_desc($event->event_desc);
				}
				if ($event->event_link != '') {
					$output .= '</a>';
				}
			}
			// The tail
			$output .= '</span></span></span>';
		} else {
			$output .= $day_of_week;
		}
		return $output;
	}

	function minical($cat_list = '') {
		
		global $wpdb;

		// Build day of week names array
		$name_days = $this->get_day_names('mini');

		// Determine month from arguments if provided
		$current_timestamp = current_time('timestamp');
		list($c_year, $c_month, $c_day) = $this->get_date_from_args();

		// Determine the index of the weekday for first of the month
		$first_weekday = $this->get_first_weekday($c_year, $c_month);

		$days_in_month = date("t", mktime (0,0,0,$c_month,1,$c_year));

		// Start the table and add the header and naviagtion					
		$calendar_body = '';
		$calendar_body .= '<div class="spiffy-minical-block"><table class="spiffy calendar-table minical">';

		// The header of the calendar table and the links
		$calendar_body .= '<tr class="calendar-heading"><td colspan="7" class="calendar-date-switcher">
	<table class="calendar-heading-tbl">
		<tr>
			<td class="calendar-prev">' . $this->prev_month($c_year,$c_month,true) . '</td>
			<td class="calendar-month">'. ucfirst(date_i18n("F", strtotime($c_year."-".$c_month."-01"))).' '.$c_year.'</td>
			<td class="calendar-next">' . $this->next_month($c_year,$c_month,true) . '</td>
		</tr>
	</table>
 </td></tr>';

		// Print the headings of the days of the week
		$calendar_body .= '<tr class="weekday-titles">';
		for ($i=1; $i<=7; $i++) {
			// Colours need to be different if the starting day of the week is different
			if (get_option('start_of_week') == 0) {
				$calendar_body .= '	<td class="'.($i<7&$i>1?'normal-day-heading':'weekend-heading').'" style="height:0;">'.$name_days[$i-1].'</td>';
			} else {
				$calendar_body .= '	<td class="'.($i<6?'normal-day-heading':'weekend-heading').'" style="height:0;">'.$name_days[$i-1].'</td>';
			}
		}
		$calendar_body .= '</tr>';

		// Get all potential events for the month ready
		$potential_events = $this->grab_events($c_year,$c_month,1,$c_year,$c_month,$days_in_month,$cat_list);

		$go = FALSE;
		for ($i=1; $i<=$days_in_month;) {
			$calendar_body .= '<tr>';
			for ($ii=1; $ii<=7; $ii++) {
				if ($ii==$first_weekday && $i==1) {
					$go = TRUE;
				} elseif ($i > $days_in_month ) {
					$go = FALSE;
				}
				
				// Determine "weekend" class applicability
				$weekend = '';
				if (get_option('start_of_week') == 0) {
					$weekend = ($ii<7&$ii>1?'':' weekend');
				} else {
					$weekend = ($ii<6?'':' weekend');
				}

				if ($go) {
					// This box has a date in it, get the events
					$grabbed_events = $this->filter_events($potential_events, $c_year,$c_month,$i,$cat_list);
					$no_events_class = '';
					if (!count($grabbed_events)) {
						$no_events_class = ' no-events';
					}
					$calendar_body .= '	<td class="'.(date("Ymd", mktime (0,0,0,$c_month,$i,$c_year))==date("Ymd",$current_timestamp)?'current-day':'day-with-date').$weekend.$no_events_class.'" style="height:0;"><span class="day-number'.$weekend.'">'.$this->minical_draw_grid_events($grabbed_events,$i++).'</span></td>';
				} else {
					// This box is empty
					$calendar_body .= '	<td class="day-without-date' . $weekend . '" style="height:0;">&nbsp;</td>';
				}
			}
			$calendar_body .= '</tr>';
		}
		$calendar_body .= '</table>';

		// Closing div
		$calendar_body .= '</div>';

		// The actual printing is done by the calling function .
		return $calendar_body;
	}

	/*
	** Mail Poet newsletter support

	Inline styles: 
		.spiffy ul {
			list-style-type: none;
			padding: 0;
		}

		span.spiffy-upcoming-date {
			font-size: 1.5em;
			margin-bottom: 1.5em;
			display: block;
			font-weight: bold;
		}

		li.spiffy-event-details.spiffy-Expanded {
			margin-left: 0;
			margin-right: 0;
			margin-bottom: 1.5em;
		}

		.spiffy-title {
			font-size: 1.5em;
			margin-bottom: .3em;
		}

		.spiffy-link {
			font-size: 1.3em;
		}
	*/
	function mailpoet_shortcodes_custom_filter( $tag_value , $user_id) {
		if (substr($tag_value, 0, 20) == 'spiffy-upcoming-list') {
			$code = do_shortcode('['.$tag_value.' style="Expanded"]'); 
			
			// insert inline styles
			$code = str_replace('<ul', 
								'<ul style="list-style-type:none; padding:0;"', 
								$code);
			$code = str_replace('class="spiffy-upcoming-date"', 
								'style="font-size: 1.5em; margin-bottom: 1.5em; display: block; font-weight: bold;"', 
								$code);
			$code = str_replace('class="spiffy-event-details spiffy-Expanded"',
								'style="margin-left: 0; margin-right: 0; margin-bottom: 1.5em;"',
								$code);
			$code = str_replace('class="spiffy-title"',
								'style="font-size: 1.5em; margin-bottom: .3em;"',
								$code);
			$code = str_replace('class="spiffy-link"',
								'style="font-size: 1.3em"',
								$code);
			return '<span class="spiffy-newsletter">' . $code . '</span>';

		}
	}	
} // end of class definition

} // end of "if !class exists"

if (class_exists("Spiffy_Calendar")) {
	$spiffy_calendar = new Spiffy_Calendar();
}

?>
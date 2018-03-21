<?php
/**
 * Admin View: Settings tab "Events" - event list
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if (!current_user_can($options['can_manage_events']))
	wp_die(__('You do not have sufficient permissions to access this page.','spiffy-calendar'));	

// Define the admin list table for event management
require_once (plugin_dir_path(__FILE__) . 'event-list-table.php');
 
global $wpdb;	

?>
<br />
<a href="<?php echo admin_url('admin.php?page=spiffy-calendar&tab=event_edit&action=add'); ?>" class="button button-primary"><?php _e('Add New Event','spiffy-calendar'); ?></a>

<?php
// Display search string if applicable
if (!empty($_REQUEST['s'])) { ?>
	<span class="subtitle"><?php _e('Search results for', 'spiffy-calendar'); ?> "<?php echo ($_REQUEST['s']); ?>"</span>
<?php }

// Display the admin list table for event management
$spiffyEvents = new Spiffy_Events_List_Table();
$spiffyEvents->prepare_items();
?>

<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
<?php $spiffyEvents->search_box(__('Search', 'spiffy-calendar'), 'search_id'); ?>
<p style="text-align: right; font-style: italic; margin-top: 3px;"><?php _e('Search title and description', 'spiffy-calendar'); ?></p>
<?php $spiffyEvents->display(); ?>
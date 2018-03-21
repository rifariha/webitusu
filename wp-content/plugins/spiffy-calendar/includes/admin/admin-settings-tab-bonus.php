<?php
/**
 * Admin View: Settings bonus tabs
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( !$this->bonus_addons_active() ) {
?>

<h3><strong><?php _e('This bonus feature requires the ', 'spiffy-calendar');?><a href="http://spiffycalendar.spiffyplugins.ca/bonus-add-ons/" ><?php _e('Spiffy Calendar Bonus Add-Ons', 'spiffy-calendar'); ?></a></strong></h3>
<?php } ?>
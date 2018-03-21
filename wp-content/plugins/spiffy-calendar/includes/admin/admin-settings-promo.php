<?php
/**
 * Admin View: Settings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( !$this->bonus_addons_active() ) {
  //plugin is activated
?>
<div id="message" class="updated inline" style="margin-top: 35px; margin-left: 0;">
<p><a href="http://spiffycalendar.spiffyplugins.ca"><?php _e('Make a donation', 'spiffy-calendar'); ?></a> <?php _e('to this plugin and you will receive bonus add-ons and priority technical support', 'spiffy-calendar'); ?>.</p>
<ul class="ul-disc">
	<li><?php _e('Premium themes', 'spiffy-calendar'); ?></li>
	<li><?php _e('Theme Customizer', 'spiffy-calendar'); ?></li>
	<li><?php _e('ICS export', 'spiffy-calendar'); ?></li>
	<li><?php _e('CampTix ticket sales integration', 'spiffy-calendar'); ?></li>
	<li><?php _e('Front end event submit form', 'spiffy-calendar'); ?></li>
</ul>
</div>
<?php } ?>
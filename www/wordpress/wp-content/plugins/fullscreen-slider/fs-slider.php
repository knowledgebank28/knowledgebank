<?php
/**
 * Plugin Name: WP FullScreen Slider
 * Plugin URI:  https://wptoolbox.co/fullscreen-slider
 * Description: Allows you to create a fullscreen slider
 * Version:     1.0.0
 * Author:      Alex Ilie
 * Author URI:  https://wptoolbox.co
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

// Direct access security, the Akismet way
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

// Load the actual plugin code
require_once( plugin_dir_path( __FILE__ ) . 'class-fs-slider.php' );

// start the plugin
FS_Slider::get_instance();
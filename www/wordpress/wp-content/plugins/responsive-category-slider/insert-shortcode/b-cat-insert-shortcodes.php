<?php
/**
 * @package   Responsive Category Slider
 * @author     ThemeLead Team <support@themelead.com>
 * @copyright  Copyright 2014 themelead.com. All Rights Reserved.
 * @license    GPLv2 or later - http://www.gnu.org/licenses/gpl-2.0.html
 * Websites: http://www.themelead.com
 * Technical Support:  Free Forum Support - http://support.themelead.com
 */

/* ================================================================
 *
 * 
 * Class to register shortcode with TinyMCE editor
 *
 * Add to button to tinyMCE editor
 *
 */
if (!class_exists('b_InsertShortcodesBEditor')) {
	class b_InsertShortcodesBEditor{
	
		function __construct()
		{
			add_action('init',array(&$this, 'init'));
		}
		
		function init(){		
			if(is_admin()){
				// CSS for button styling
				wp_enqueue_style("ct_shortcode_admin_style", plugin_dir_url( __FILE__ ) . 'b-insert-shortcode.css');
			}

			if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
				return;
			}
		 
			if ( get_user_option('rich_editing') == 'true' ) {
				add_filter( 'mce_external_plugins', array(&$this, 'regplugins'));
				add_filter( 'mce_buttons_3', array(&$this, 'regbtns') );
				
				// remove a button. Used to remove a button created by another plugin
				remove_filter('mce_buttons_3', array(&$this, 'remobtns'));
			
			}
		}
		
		function remobtns($buttons){
			// add a button to remove
			// array_push($buttons, 'ct_shortcode_collapse');
			return $buttons;	
		}
		
		function regbtns($buttons)
		{
			// register shortcode buttons
			// array_push($buttons, [name]);
			// array_push($buttons, 'shortcode_button_name');
			array_push($buttons, 'b_insert_shortcode_editor');
			
			return $buttons;
		}
		
		function regplugins($plgs)
		{
			//Checkversion to load script
			$ver = get_bloginfo('version');
			$version_text = str_replace(".","", $ver);
			$num_version = (int)substr($version_text, 0, 2);
			if($num_version < 39){
			// $plgs['shortcode_button_name'] = get_template_directory_uri() . '/inc/shortccodes/shortcode_sample.js';
				$plgs['b_insert_shortcode_editor'] = plugin_dir_url( __FILE__ ) . 'b-insert-shortcode.js';
			}
			else {
				$plgs['b_insert_shortcode_editor'] = plugin_dir_url( __FILE__ ) . 'b-insert-shortcode-3.9.js';
			}
			return $plgs;
		}
	}
}

$ctshortcode = new b_InsertShortcodesBEditor();
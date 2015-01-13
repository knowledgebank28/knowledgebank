<?php
/**
 * Plugin Name: Responsive Category Slider
 * Plugin URI: http://themelead.com/project/responsive-category-slider-wordpress-content-slider-plugin/
 * Description: Responsive Category Slider is an amazing combination of slider and content tab. The plugin is empowered by AJAX, CSS3, Bootstrap 3 and WooCommerce compatible.
 * Version: 1.0
 * Author: ThemeLead Team <support@themelead.com>
 * Author URI: http://themelead.com
 * License: GPLv2 or later	 - http://www.gnu.org/licenses/gpl-2.0.html
 */
	//Setup our path
	define ('WPB_PATH', dirname(__FILE__) . '/' );
	
	// Global wpdb
	global $wpdb;
	
	//Create new table when to save settings
	if (!function_exists('b_create_table_save_setting_for_category_slider')){
		function b_create_table_save_setting_for_category_slider(){
			global $b_category_slider;
			global $wpdb;
			$table_name = $wpdb->prefix . 'b_responsive_category_slider'; 
			//Check table is exists, if not install new table
			if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name){
				// sql to create table for plugin
				$sql = "CREATE TABLE " . $table_name . " (
				  id int(11) NOT NULL AUTO_INCREMENT,
				  background VARCHAR(100),
				  background_img TEXT,
				  background_repeat VARCHAR(100),
				  width_ver VARCHAR(100),
				  border VARCHAR(100),
				  border_color VARCHAR(100),
				  menu_color VARCHAR(100),
				  hover_color VARCHAR(100),
				  background_color_hover VARCHAR (50),
				  slideshowSpeed VARCHAR(50),
				  theme_style VARCHAR(50),
				  hover_thumnail VARCHAR(50),
				  PRIMARY KEY  (id)
				);";
			
			// calling dbDelta which cant migrate database
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
			
			}
		}
	}
	
	//Insert id to table install - use to update database
	if(!function_exists('b_add_id_to_table_b_responsive_category_slider')){
		function b_add_id_to_table_b_responsive_category_slider(){
			global $wpdb;
			$table_name = $wpdb->prefix . 'b_responsive_category_slider';

			$wpdb->insert($table_name, array(
				'id' => 1
			));
		}
	}

	//Drop table when plugin is deactivate
	if(!function_exists('b_drop_table_setting_category_slider')){
		function b_drop_table_setting_category_slider(){
			global $wpdb;
			$table_name = $wpdb->prefix ."b_responsive_category_slider";
			$wpdb->query("DROP TABLE IF EXISTS ".$table_name);
		}
	}
	
	register_activation_hook(__FILE__, 'b_create_table_save_setting_for_category_slider');
	register_activation_hook(__FILE__, 'b_add_id_to_table_b_responsive_category_slider');
	register_deactivation_hook(__FILE__,'b_drop_table_setting_category_slider');
	
	
	//Register JS file with back-end
	if ( is_admin() ){
		if(!function_exists('b_res_cat_register_js_file')){
			function b_res_cat_register_js_file(){
				wp_enqueue_script('jquery');
				wp_enqueue_script('b_category_admin_backend', plugin_dir_url( __FILE__ ) . 'js/b-categories-backend.js', array ( 'jquery' ), '1.0', true);
			}
		}
		add_action('init', 'b_res_cat_register_js_file');
	}
	else {
		//Register CSS and JS file with font-end
		if(!function_exists('b_res_cat_register_css_and_js')){
			function b_res_cat_register_css_and_js() {
				global $wpdb;
				$table_name = $wpdb->prefix . 'b_responsive_category_slider';
				$data = $wpdb->get_row("SELECT * FROM ".$table_name." WHERE id=1");
				$data_style_theme = $data->theme_style;
				wp_register_script('ajaxHandle', plugins_url( 'js/ajaxHandle.js', __FILE__ ), array(), false, true);
				wp_enqueue_script('ajaxHandle');
				wp_localize_script('ajaxHandle', 'b_res_cat_slider_ajax_object', array('ajaxurl' => admin_url('admin-ajax.php')));
				
				wp_enqueue_style("prettyPhoto-css", plugin_dir_url( __FILE__ ) . 'css/prettyPhoto.css');
				wp_enqueue_style("b_category_admin_bootstrap", plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css');
				if(!wp_style_is('FontAwesome')) {
				wp_enqueue_style("FontAwesome", plugin_dir_url( __FILE__ ) . 'css/font-awesome.min.css');
				}
				wp_enqueue_style("b_category_admin_flexslider", plugin_dir_url( __FILE__ ) . 'css/flexslider.css');
				wp_enqueue_style("b_category_admin_style", plugin_dir_url( __FILE__ ) . 'css/b-custom.css');
				if($data_style_theme == 'fourteen'){
					wp_enqueue_style("b_twenty_fourteen", plugin_dir_url( __FILE__ ) . 'css/b-twenty-fourteen.css');
				}
				else if($data_style_theme == 'senia'){
					wp_enqueue_style("b_senia", plugin_dir_url( __FILE__ ) . 'css/b-senia.css');
				}
				else if($data_style_theme == 'themelead'){
					wp_enqueue_style("b_themelead", plugin_dir_url( __FILE__ ) . 'css/b-themelead.css');
				}
				wp_enqueue_style("b_category_custom_style", plugin_dir_url( __FILE__ ) . 'css/b-custom.css.php');
				
				wp_enqueue_script('jquery');
				
				if(!wp_script_is('flexslider')) {
				wp_enqueue_script('flexslider', plugin_dir_url( __FILE__ ) . 'js/jquery.flexslider-min.js', 'jquery','2.2.2',true);
				}
				wp_enqueue_script('jquery-prettyPhoto', plugin_dir_url( __FILE__ ) . 'js/jquery.prettyPhoto.js', 'jquery','3.1.5',true);
				wp_enqueue_script('jquery-hoverdirection', plugin_dir_url( __FILE__ ) . 'js/jquery-hoverdirection.js', 'jquery','1.1.0',true);
				wp_enqueue_script('b_category_admin_js_custom', plugin_dir_url( __FILE__ ) . 'js/b-categories.js', 'jquery','1.0',true);
				
			}
		}
		
		add_action('init', 'b_res_cat_register_css_and_js');
	}
	//Resize thumbnail for slider
	if(!function_exists('b_res_cat_size_img_thumb')){
		function b_res_cat_size_img_thumb(){
		/*crop image to horizontal rectangle*/
			add_image_size('thumb_1158x772', 1158, 772, true); //width 1 columns
			add_image_size('thumb_570x380', 570, 380, true); // with 2 columns
			add_image_size('thumb_375x250', 375, 250, true); // with 3 columns
			add_image_size('thumb_276x184', 276, 184, true); // with 4 columns
			add_image_size('thumb_180x120', 180, 120, true); //with 6 columns
			add_image_size('thumb_480x320', 480, 320, true); //width mobile
		/*crop image to square*/
			add_image_size('thumb_1158x1158', 1158, 1158, true); //width 1 columns
			add_image_size('thumb_570x570', 570, 570, true); // with 2 columns
			add_image_size('thumb_375x375', 375, 375, true); // with 3 columns
			add_image_size('thumb_276x276', 276, 276, true); // with 4 columns
			add_image_size('thumb_180x180', 180, 180, true); //with 6 columns
			add_image_size('thumb_480x480', 480, 480, true); //width mobile
		/*crop image to vertical rectangle*/
			add_image_size('thumb_1158x1737', 1158, 1737, true); //width 1 columns
			add_image_size('thumb_570x855', 570, 855, true); // with 2 columns
			add_image_size('thumb_375x562', 375, 562, true); // with 3 columns
			add_image_size('thumb_276x414', 276, 414, true); // with 4 columns
			add_image_size('thumb_180x270', 180, 270, true); //with 6 columns
			add_image_size('thumb_480x720', 480, 720, true); //width mobile	
		}
	}
	add_action('init', 'b_res_cat_size_img_thumb');
	
	
	//Loading domain translating plugin
	if(!function_exists('b_responsive_category_slider_textdomain')){
		function b_responsive_category_slider_textdomain(){
			load_plugin_textdomain('b_category_slider', false, dirname(plugin_basename(__FILE__)));
		}
	}
	add_action('init', 'b_responsive_category_slider_textdomain');
	
	//Include widget files
	include_once( WPB_PATH . 'system/widget.php');
	//add_action( 'widgets_init', 'WPB_system::widget_b_categories' );
	
	include_once( WPB_PATH . 'system/shortcode.php');
	add_shortcode('res-cat-slider', 'b_create_shortcode_categories_slider');
	
	//Include file insert shortcode to editor
	include_once('insert-shortcode/b-cat-insert-shortcodes.php');
	//Include Setting Page
	include_once('system/setting.php');
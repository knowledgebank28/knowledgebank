<?php
/**
 * @package   Responsive Category Slider
 * @author     ThemeLead Team <support@themelead.com>
 * @copyright  Copyright 2014 themelead.com. All Rights Reserved.
 * @license    GPLv2 or later - http://www.gnu.org/licenses/gpl-2.0.html
 * Websites: http://www.themelead.com
 * Technical Support:  Free Forum Support - http://support.themelead.com
 */

	//Enqueue Color Picker Select and media
	if(!function_exists('b_category_slider_enqueue_color_picker')){
		function b_category_slider_enqueue_color_picker( $hook_suffix ) {
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'color-picker-js', plugins_url('b-color-pickeer.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
			wp_enqueue_script('media-upload');
			wp_enqueue_script('thickbox');
			wp_register_script('b-media-upload', WP_PLUGIN_URL.'/responsive-category-slider/js/insert-media.js', array('jquery','media-upload','thickbox'));
			wp_enqueue_script('b-media-upload');
		}
	}
	//Enqueue media style
	if(!function_exists('b_category_slider_enqueue_style_media')){
		function b_category_slider_enqueue_style_media() {
			wp_enqueue_style('thickbox');
		}
	}
	//Add action on plugin page
	if (isset($_GET['page']) && $_GET['page'] == 'responsive-category-slider') {
		add_action( 'admin_enqueue_scripts', 'b_category_slider_enqueue_color_picker' );
		add_action('admin_print_styles', 'b_category_slider_enqueue_style_media');
	}
	
	// Add Menu Setting to backend
	if(!function_exists('b_menu_setting_category_slider')){
		function b_menu_setting_category_slider(){
			add_menu_page(__('Category Slider', 'b_category_slider'), __('Category Slider', 'b_category_slider'), 'activate_plugins', 'responsive-category-slider', 'b_custom_setting_responsive_category_slider', plugins_url( 'responsive-category-slider/images/responsive-category-slider-logo.png' ));
			add_submenu_page('slider', __('Slider', 'b_category_slider'), __('Slider', 'b_category_slider'), 'activate_plugins', 'slider', 'b_custom_setting_responsive_category_slider');
		}
	}
	add_action('admin_menu', 'b_menu_setting_category_slider');
	
	//Function Call Font-End
	if(!function_exists('b_custom_setting_responsive_category_slider')){
		function b_custom_setting_responsive_category_slider(){
			global $wpdb;
			$table_name = $wpdb->prefix . 'b_responsive_category_slider';
			//Get data from database
			$data = $wpdb->get_row("SELECT * FROM ".$table_name." WHERE id=1");
			$data_background = $data->background;
			$data_background_img = $data->background_img;
			$data_background_repeat = $data->background_repeat;
			$data_width_ver = $data->width_ver;
			$data_border = $data->border;
			$data_border_color = $data->border_color;
			$data_menu_color = $data->menu_color;
			$data_hover_color = $data->hover_color;
			$background_color_hover = $data->background_color_hover;
			//$data_img_size = $data->img_size;
			$theme_style = $data->theme_style;
			$data_hover_thumnail = $data->hover_thumnail;
			$data_slideshowSpeed = $data->slideshowSpeed;
			
			if(isset($_REQUEST['submit'])):
			$data_background = $_POST['b-select-background'];
			$data_background_img = $_POST['b_upload_image'];
			$data_background_repeat = $_POST['b_background_repeat'];
			$data_width_ver = $_POST['b-width-vertical'];
			$data_border = $_POST['b_is_border'];
			$data_border_color = $_POST['b-select-border-color'];
			$data_menu_color = $_POST['b-select-menu-color'];
			$data_hover_color = $_POST['b-hover-menu-color'];
			$background_color_hover = $_POST['b-background-color-hover'];
			//$data_img_size = $_POST['b_image_size'];
			$theme_style = $_POST['theme_style'];
			$data_hover_thumnail = $_POST['hover_thumnail'];
			$data_slideshowSpeed = $_POST['b_slideshowSpeed'];
			
			//update to database
			$wpdb->update( 
				$table_name, 
				array( 
					'background' => $data_background,
					'background_img' => $data_background_img,
					'background_repeat' => $data_background_repeat,
					'width_ver' => $data_width_ver,
					'border'	=> $data_border,
					'border_color' => $data_border_color,
					'menu_color'	=> $data_menu_color,
					'hover_color'	=> $data_hover_color,
					'background_color_hover' => $background_color_hover,
					//'img_size'	=> $data_img_size,
					'theme_style'	=> $theme_style,
					'hover_thumnail'	=> $data_hover_thumnail,
					'slideshowSpeed'	=> $data_slideshowSpeed,
				), 
				array( 'id' => 1 )
			);
			//alert message
			$message = 'Setting is updated';
			endif;
			?>
			<div class="wrap">
				<h2><?php _e('Setting for Responsive Category Slider', 'b_category_slider')?></h2>

				<?php if (!empty($message)): ?>
				<div id="message" class="updated"><p><?php echo $message ?></p></div>
				<?php endif;?>

				<form id="form" method="POST">
					<table class="form-table">
						<tbody>
							<tr>
								<th scope="row"><label><?php _e('Background Color:', 'b_category_slider')?></label></th>
								<td><input type="text" name="b-select-background" value="<?php echo $data_background;?>" data-current="<?php echo $data_background;?>" class="b-select-background" /></td>
							</tr>
							<tr>
								<th scope="row"><label><?php _e('Background images:', 'b_category_slider')?></label></th>
								<td>
									<input id="b_upload_image" type="text" size="36" name="b_upload_image" value="<?php echo $data_background_img;?>" />
									<input id="b_upload_background_image_button" type="button" value="Upload Image" />
									<p style="font-size: 12px;"><i><?php _e('Enter an URL or upload an image for the background images', 'b_category_slider')?></i></p>
								</td>
							</tr>
							<tr>
								<th scope="row"><label><?php _e('Background Repeat:', 'b_category_slider')?></label></th>
								<td>
									<select name="b_background_repeat">
										<option value="repeat" <?php echo ($data_background_repeat == 'repeat') ? 'selected' : '';?>><?php _e('Repeat', 'b_category_slider')?></option>
										<option value="repeat-x" <?php echo ($data_background_repeat == 'repeat-x') ? 'selected' : '';?>><?php _e('Repeat-x', 'b_category_slider')?></option>
										<option value="repeat-y" <?php echo ($data_background_repeat == 'repeat-y') ? 'selected' : '';?>><?php _e('Repeat-y', 'b_category_slider')?></option>
										<option value="no-repeat" <?php echo ($data_background_repeat == 'no-repeat') ? 'selected' : '';?>><?php _e('No-repeat', 'b_category_slider')?></option>
										<option value="initial" <?php echo ($data_background_repeat == 'initial') ? 'selected' : '';?>><?php _e('Initial', 'b_category_slider')?></option>
										<option value="inherit" <?php echo ($data_background_repeat == 'inherit') ? 'selected' : '';?>><?php _e('Inherit', 'b_category_slider')?></option>
									</select>
								</td>
							</tr>
							<tr>
								<th scope="row"><label><?php _e('Vertical Menu Width(pixel):', 'b_category_slider')?></label></th>
								<td>
									<input type="text" name="b-width-vertical" value="<?php echo $data_width_ver;?>" class="b-width-vertical" />
									<p style="font-size: 12px;"><i><?php _e('Unit is pixel, Value is a number', 'b_category_slider')?></i></p>
								</td>
							</tr>
							<tr>
								<th scope="row"><label><?php _e('Have border?:', 'b_category_slider')?></label></th>
								<td>
									<select name="b_is_border">
										<option value="yes" <?php echo ($data_border == 'yes') ? 'selected' : '';?>><?php _e('Yes', 'b_category_slider')?></option>
										<option value="no" <?php echo ($data_border == 'no') ? 'selected' : '';?>><?php _e('No', 'b_category_slider')?></option>
									</select>
									<p style="font-size: 12px;"><i><?php _e('This is setting for Style Default (style for Nile theme)', 'b_category_slider')?></i></p>
								</td>
							</tr>
							<tr>
								<th scope="row"><label><?php _e('Border Color:', 'b_category_slider')?></label></th>
								<td><input type="text" name="b-select-border-color" value="<?php echo $data_border_color;?>" data-current="<?php echo $data_border_color;?>" class="b-select-border-color" /></td>
							</tr>
							<tr>
								<th scope="row"><label><?php _e('Menu Color Text:', 'b_category_slider')?></label></th>
								<td><input type="text" name="b-select-menu-color" value="<?php echo $data_menu_color;?>" data-current="<?php echo $data_menu_color;?>" class="b-select-menu-color" /></td>
							</tr>
							<tr>
								<th scope="row"><label><?php _e('Menu Text Hover Color:', 'b_category_slider')?></label></th>
								<td><input type="text" name="b-hover-menu-color" value="<?php echo $data_hover_color;?>" data-current="<?php echo $data_hover_color;?>" class="b-hover-menu-color" /></td>
							</tr>
							<tr>
								<th scope="row"><label><?php _e('Background Color Hover:', 'b_category_slider')?></label></th>
								<td>
									<input type="text" name="b-background-color-hover" value="<?php echo $background_color_hover;?>" data-current="<?php echo $background_color_hover;?>" class="b-background-color-hover" />
									<p style="font-size: 12px;"><i><?php _e('This background for hover thumnail images of Themelead style, gallery and product style', 'b_category_slider')?></i></p>
								</td>
							</tr>
							<tr>
								<th scope="row"><label><?php _e('Disable hover thumbnail effect:', 'b_category_slider')?></label></th>
								<td>
									<select name="hover_thumnail">
										<option value="no" <?php echo ($data_hover_thumnail == 'no') ? 'selected' : '';?>><?php _e('No', 'b_category_slider')?></option>
										<option value="yes" <?php echo ($data_hover_thumnail == 'yes') ? 'selected' : '';?>><?php _e('Yes', 'b_category_slider')?></option>
									</select>
								</td>
							</tr>
							<tr>
								<th scope="row"><label><?php _e('Select style for special themes:', 'b_category_slider')?></label></th>
								<td>
									<select name="theme_style">
										<option value="nile" <?php echo ($theme_style == 'nile') ? 'selected' : '';?>><?php _e('Nile (Default)', 'b_category_slider')?></option>
										<option value="fourteen" <?php echo ($theme_style == 'fourteen') ? 'selected' : '';?>><?php _e('Twenty-Fourteen', 'b_category_slider')?></option>
										<option value="senia" <?php echo ($theme_style == 'senia') ? 'selected' : '';?>><?php _e('Senia', 'b_category_slider')?></option>
										<option value="themelead" <?php echo ($theme_style == 'themelead') ? 'selected' : '';?>><?php _e('Themelead', 'b_category_slider')?></option>
									</select>
								</td>
							</tr>
							<tr>
								<th scope="row"><label><?php _e('Slideshow Speed', 'b_category_slider')?></label></th>
								<td>
									<input type="text" name="b_slideshowSpeed" value="<?php echo $data_slideshowSpeed;?>" class="b_slideshowSpeed" />
									<p style="font-size: 12px;"><i><?php _e('Set the speed of the slideshow, in milliseconds, only integrity number allowed. 1 second is equal to 1000, default is 7000', 'b_category_slider')?></i></p>
								</td>
							</tr>
						</tbody>
					</table>
					<p><input type="submit" value="<?php _e('Save', 'b_category_slider')?>" id="submit" class="button-primary" name="submit"></p>

				</form>
			</div>
		<?php
		}
	}
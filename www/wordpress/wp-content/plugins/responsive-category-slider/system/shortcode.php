<?php
/**
 * @package   Responsive Category Slider
 * @author     ThemeLead Team <support@themelead.com>
 * @copyright  Copyright 2014 themelead.com. All Rights Reserved.
 * @license    GPLv2 or later - http://www.gnu.org/licenses/gpl-2.0.html
 * Websites: http://www.themelead.com
 * Technical Support:  Free Forum Support - http://support.themelead.com
 */

include_once('functions.php');
// Create Shortcode Category Slider
global $post;
if(!function_exists('b_create_shortcode_categories_slider')){
	function b_create_shortcode_categories_slider($args, $content = null){
		$type = (empty($args['cat_type'])) ? null : $args['cat_type'];
		$cat_id = (empty($args['cat'])) ? null : $args['cat'];
		$custom_post = (empty($args['custom_post'])) ? null : $args['custom_post'];
		$tax_name = (empty($args['tax_name'])) ? null : $args['tax_name'];
		$per_page = (empty($args['per_page'])) ? null : $args['per_page'];
		$list_tags = (empty($args['list_tags'])) ? null : $args['list_tags'];

		if($type == null): $type = 'category'; endif;
		if($type != 'tag' && $type != 'taxonomy' && $type != 'category'): $type = 'category'; endif;
		if($type != "taxonomy"): if($cat_id == null): $cat_id = 'category'; endif; endif;
		$style = (empty($args['style'])) ? 3 : $args['style'];
		if($style != 'post' && $style != 'events' && $style != 'gallery' && $style != 'product' && $style != 'news'): $style = 'post'; endif;
		$columns = (empty($args['columns'])) ? 3 : $args['columns'];
		if($columns != 1 && $columns != 2 && $columns != 3 && $columns != 4 && $columns != 6 ): $columns = 3; endif;
		if($per_page == null || !is_numeric($per_page)): 
			if($columns == 1): $per_page = 1; endif;
			if($columns == 2): $per_page = 4; endif;
			if($columns == 3): $per_page = 6; endif;
			if($columns == 4): $per_page = 8; endif;
			if($columns == 6): $per_page = 12; endif;
		endif;
		$pos_menu = (empty($args['pos_menu'])) ? 'horizontal' : $args['pos_menu'];
		if($pos_menu != 'horizontal' && $pos_menu != 'vertical' && $pos_menu != 'hide'): $pos_menu = 'horizontal'; endif;
		
		$order_by = (empty($args['order_by'])) ? 'date' : $args['order_by'];
		if($order_by != 'view'): $order_by = 'date'; endif;
		
		$order = (empty($args['order'])) ? 'desc' : $args['order'];
		if($order != 'asc'):  $order = 'desc'; endif;
		
		$auto_slide = (empty($args['auto_slide'])) ? 'false' : $args['auto_slide'];
		if($auto_slide != 'true'): $auto_slide = 'false'; endif;
		
		$control_nav = (empty($args['control_nav'])) ? 'on' : $args['control_nav'];
		if($control_nav != 'off'): $control_nav = 'on'; endif;
		
		$padding = (empty($args['padding'])) ? 'yes' : $args['padding'];
		if($padding != 'no'): $padding = 'yes'; endif;
		if($padding == 'no'){ $class_no_padding = 'no_padding'; }else { $class_no_padding = ''; }
		
		$image_size = (empty($args['image_ratio'])) ? 'horizontal_rectangle' : $args['image_ratio'];
		if($image_size != 'square' && $image_size != 'vertical_rectangle' && $image_size != 'full_size'): $image_size = 'horizontal_rectangle'; endif;
		
		$linkable = (empty($args['linkable'])) ? 'on' : $args['linkable'];
		if($linkable != 'off'): $linkable = 'on'; endif;
		
		$show_parent_menu = (empty($args['show_parent_menu'])) ? 'yes' : $args['show_parent_menu'];
		if($show_parent_menu != 'no'): $show_parent_menu = 'yes'; endif;
		if($show_parent_menu == 'yes'){ $class_show_parent = 'b-show-parent';} else { $class_show_parent = 'b-not-show-parent';}
		
		$class_check_hide_menu = b_check_to_hide_menu($cat_id, $tax_name, $type);
		$class_margin_horizontal = b_check_to_set_class_margin_horizontal($cat_id, $type);
		
		if (!class_exists('Mobile_Detect')):
			require_once('mobile-detect.php');
		endif;
		$b_detect = new Mobile_Detect;
		global $_b_device_;
		$_b_device_ = $b_detect->isMobile() ? ($b_detect->isTablet() ? 'tablet' : 'mobile') : 'pc';
		
		//Set plugin id to a slider
		global $plugin_id;
		$plugin_id = rand();
		
		//Get data Auto slide and theme style
		global $wpdb;
		$table_setting = $wpdb->prefix . 'b_responsive_category_slider';
		$data = $wpdb->get_row("SELECT * FROM ".$table_setting." WHERE id=1");
		$theme_style = $data->theme_style;
		$slideshowSpeed = $data->slideshowSpeed;
		if(empty($slideshowSpeed)){ $slideSpeed = 7000;} else { $slideSpeed = $slideshowSpeed; }
		$style_theme = '';
		
		if(($theme_style == null) || ($theme_style == 'nile')){ $style_theme = 'b_nile_theme';} else {$style_theme = 'b_'.$theme_style.'theme';}

		
		$html = '';
		if($pos_menu == 'vertical'){
			$html .= '<div id="b-plugins-category-'.$plugin_id.'" class="b-plugins-category b-vertical '.$style_theme.' b-columns-'.$columns.' '.$class_no_padding.' '.$class_show_parent.' '.$class_margin_horizontal.' '.$class_check_hide_menu.'" data-id="'.$plugin_id.'">';
		}
		else {
			$html .= '<div id="b-plugins-category-'.$plugin_id.'" class="b-plugins-category b-no-vertical '.$style_theme.' b-columns-'.$columns.' '.$class_no_padding.' '.$class_show_parent.' '.$class_margin_horizontal.' '.$class_check_hide_menu.'" data-id="'.$plugin_id.'">';
		}
				if($pos_menu == 'horizontal'):
				$html .= '<div class="b-menu-categories b-menu-horizontal"><div class="b-view-horizontal">';
					$html .= b_get_menu_horizontal($type, $cat_id, $tax_name, $list_tags, $plugin_id, $show_parent_menu);
				$html .= '</div></div>';
				endif;
					$html .= '<div id="b-plugins-view"><div class="b-plugins-view-in">';
				/*Check menu vertical show and hide */
				if($pos_menu == 'vertical'){
					$html .= '<div class="b-menu-categories" >';
				}
				else{
					$html .= '<div class="b-menu-categories" style="display: none;">';
				}
						$html .= '<ul class="b-menu-category">';
							$html .= b_get_menu_vertical($type, $cat_id, $tax_name, $custom_post, $style, $list_tags, $plugin_id, $image_size, $linkable, $show_parent_menu);
							$html .= '</ul></div>';
							$html .= '<div class="b-flexslider-posts">
											<div id="b-data-ajax">
												<span id="cat_type" alt="'.$type.'"></span>
												<span id="tax_name" alt="'.$tax_name.'"></span>
												<span id="custom_post" alt="'.$custom_post.'"></span>
												<span id="per_page" alt="'.$per_page.'"></span>
												<span id="columns" alt="'.$columns.'"></span>
												<span id="style" alt="'.$style.'"></span>
												<span id="order" alt="'.$order.'"></span>
												<span id="order_by" alt="'.$order_by.'"></span>
												<span id="auto_slide" alt="'.$auto_slide.'"></span>
												<span id="control_nav" alt="'.$control_nav.'"></span>
												<span id="image_size" alt="'.$image_size.'"></span>
												<span id="linkable" alt="'.$linkable.'"></span>
												<span id="b_device" alt="'.$_b_device_.'"></span>
											</div>
											<div id="b-ajax-loaded-posts"><img src="'.home_url().'/wp-content/plugins/responsive-category-slider/images/ajax-loader.gif" alt="loading..."/></div>
											<div id="b-ajax-results-html">
											<div class="b-flexslider" data-control-nav="'.$control_nav.'" data-autoslide="'.$auto_slide.'" data-slideshowspeed="'.$slideSpeed.'">
												<ul class="slides">
													<li class="b-li-child-flex">
														<div class="row">';
							
		if($type == "tag"){
			if($list_tags != null){
				$array_tags = explode(",", trim($list_tags," "));
				$args = array(
					'tag'  => $array_tags[0]
				);
			}
			else{		
				$posttags = get_tags('orderby=term_id&order=desc');
				if($posttags){
					$args = array(
						'tag'  => $posttags[0]->slug
					);
				}
				
			}
		}
		
		else if($type == "taxonomy"){
			if(!empty($tax_name) && !empty($custom_post)){
				if(empty($cat_id)){
					$args = array(
						'post_type' => $custom_post
					);
				}
				else{
					$cat_id = str_replace(" ", "", $cat_id);
					$list_id = explode(",", $cat_id);
					$filtered = array_filter($list_id, 'is_numeric');
					if($filtered == $list_id){
						$args = array(
									'post_type'	=> $custom_post,
									'tax_query' => array(
									   array(
										 'taxonomy' => $tax_name,
										 'field' => 'id',
										 'terms' => $list_id,
										 'operator' => 'IN'
										)
									)
								);
					}
					else {
						$args = array(
									'post_type'	=> $custom_post,
									'tax_query' => array(
									   array(
										 'taxonomy' => $tax_name,
										 'field' => 'slug',
										 'terms' => $list_id,
										 'operator' => 'IN'
										)
									)
								);
					}
				}
			}
			else {
				$args = array();
				$html .= '<p class="warring_message">'.__('Warning: You need to fill tax_name and custom_post in your shortcode', 'b_category_slider') . '</p>';
			}
		}
		else {
			if(is_numeric($cat_id) || $cat_id == 'category'){
				$args = array(
					'post_type' => 'post',
					'cat'		=> $cat_id
				);
			}
			else {
				$cat_obj = get_category_by_slug( $cat_id );
				$cate_id = $cat_obj->term_id;
				if(!empty($cate_id)){
					$args = array(
						'post_type' => 'post',
						'cat'		=> $cate_id
					);
				} else {
					$args = array();
					$html .= '<strong style="display: block;">'.__('"Warning: You have entered incorrect slug "', 'b_category_slider') . '</strong>';
				}
			}
		}
		if($order_by == 'date'){
			$args['orderby'] = 'date';
			$args['order'] = $order;
		}
		else {
			$args['orderby'] = 'meta_value_num';
			$args['meta_key'] = 'b_meta_views';
			$args['order']	= $order;
		}
		$args['posts_per_page'] = -1;
		
		$query = new WP_Query($args);
		$post_num = $query->post_count;
		if($post_num <= $per_page):
			echo "<style type='text/css'>#b-plugins-category-".$plugin_id." #b-plugins-view .flex-control-nav{padding: 0;}</style>";
		endif;
		if($query->have_posts()){
		$i = 0;
		while ($query->have_posts()): $query->the_post();

		if(($i > 0) && ($i%$per_page)== 0):
			$html .= "</div></li><li class='b-li-child-flex'><div class='row'>";
		endif;
		?>
			<?php $html .= b_show_posts_by_style($style, $columns, $plugin_id, $image_size, $linkable, $_b_device_);?>
		<?php
		$i++;
		endwhile; wp_reset_postdata();
		} 
		else {
			$html .= '<p align="center">'.__('No Article to display', 'b_category_slider').'</p>';
		}
		$html .= "</div></li></ul></div></div></div></div></div></div>";
		
		return $html;
	}
}
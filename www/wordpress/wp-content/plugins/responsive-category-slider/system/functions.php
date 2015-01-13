<?php
/**
 * @package   Responsive Category Slider
 * @author     ThemeLead Team <support@themelead.com>
 * @copyright  Copyright 2014 themelead.com. All Rights Reserved.
 * @license    GPLv2 or later - http://www.gnu.org/licenses/gpl-2.0.html
 * Websites: http://www.themelead.com
 * Technical Support:  Free Forum Support - http://support.themelead.com
 */
 
/*Get tags name by tag slug*/
if(!function_exists('b_GetTagName')){
	function b_GetTagName($meta){
		if (is_string($meta) || (is_numeric($meta) && !is_double($meta))
			|| is_int($meta)){
				if (is_numeric($meta))
					$meta = (int)$meta;
						if (is_int($meta))
							$TagSlug = get_term_by('id', $meta, 'post_tag');
						else
							$TagSlug = get_term_by('slug', $meta, 'post_tag');
							 
					return $TagSlug->name;
		}
	}
}

/*Check to hide menu when show responsive category slider is a slide image*/
if(!function_exists('b_check_to_hide_menu')){
	function b_check_to_hide_menu($cat_id, $tax_name, $type){
		global $wpdb;
		$table_cat = $wpdb->prefix.'term_taxonomy';
		$class_check_hide_menu = '';
		$cat_id_num = '';
		if(!isset($cat_id)): $cat_id = null; endif;
		if($type = 'category'){
			if(!empty($cat_id)){
				if(is_numeric($cat_id)){
					$cat_id_num = $cat_id;
				} 
				else {
					$category_obj = get_category_by_slug( $cat_id );
					if(!empty($category_obj)){
						$cat_id_num = $category_obj->term_id;
					} else {
						$cat_id_num = -1;
					}
				}
				
				$check_cat_exists = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE taxonomy='category' AND term_id='".$cat_id_num."'");
				$check_cat_child = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE taxonomy='category' AND parent='".$cat_id_num."'");
				if(!empty($check_cat_exists) && empty($check_cat_child)){$class_check_hide_menu = 'b-hide-menu';} else {$class_check_hide_menu = '';}
			}
			else {
				$class_check_hide_menu = '';
			}
		}
		elseif($type = 'taxonomy'){
			if(!empty($cat_id)){
				$cat_id_replace = str_replace(" ", "", $cat_id);
				$cat_id_explo = explode(",", $cat_id_replace);
				$count_catid =  count($cat_id_explo);
				if(count($cat_id_explo) === 1){
					if(is_numeric($cat_id_explo[0])){ $cat_id_num = $cat_id_explo[0];} else { $b_term = get_term_by('slug', $cat_id_explo[0], $tax_name); $cat_id_num = $b_term->term_id;}
				}
				else { 
					$cat_id_num = -1;
				}
				$check_cat_exists = $wpdb->get_row("SELECT term_id FROM ".$table_cat." WHERE taxonomy='".$tax_name."' AND term_id=".$cat_id_num);
				$check_cat_child = $wpdb->get_row("SELECT term_id FROM ".$table_cat." WHERE taxonomy='".$tax_name."' AND parent=".$cat_id_num);
				if(!empty($check_cat_exists) && empty($check_cat_child)){$class_check_hide_menu = 'b-hide-menu';} else {$class_check_hide_menu = '';}
			}
			else{
				$class_check_hide_menu = '';
			}
		}
		else{
			$class_check_hide_menu = '';
		}
		
		return $class_check_hide_menu;
	}
}

/*Check is taxonomy list cat and tag to set margin 0 menu horizontal*/
if(!function_exists('b_check_to_set_class_margin_horizontal')){
	function b_check_to_set_class_margin_horizontal($cat_id, $type){
		$class_margin_horizontal = '';
		if($type == 'taxonomy'){
			if($cat_id){
				$cat_id_replace = str_replace(" ", "", $cat_id);
				$cat_id_explo = explode(",", $cat_id_replace);
				$count_catid =  count($cat_id_explo);
				if($count_catid > 1){
					$class_margin_horizontal = 'b-not-margin-left';
				}
				else {
					$class_margin_horizontal = '';
				}
			}
		}
		elseif($type == 'tag'){
			$class_margin_horizontal = 'b-not-margin-left';
		}
		else {
			$class_margin_horizontal = '';
		}
		return $class_margin_horizontal;
	}
}

//Add custom metabox to save viewed
if(!function_exists('b_save_post_viewed_in_single')){
	function b_save_post_viewed_in_single($post_id){
		// verify if this is an auto save routine. 
		// If it is our form has not been submitted, so we dont want to do anything
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) 
		  return;
		
		// verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times
		if(isset($_POST['post_metadata']))
		if (!wp_verify_nonce($_POST['post_metadata'], 'post_metadata'))
			return;
			
		/* For later use */
		$b_meta_views = isset($_POST['b_meta_views']) ? $_POST['b_meta_views'] : '0';
		
		add_post_meta($post_id,'b_meta_views',$b_meta_views, true);
		update_post_meta($post_id,'b_meta_views',$b_meta_views);
	}
}
add_action( 'save_post', 'b_save_post_viewed_in_single' );

//Update value views in database
if(!function_exists('b_update_value_views_in_database')){
	function b_update_value_views_in_database() {
		global $post;
		if(is_single() && !is_page()){ 
			$meta_values = get_post_meta($post->ID, 'b_meta_views', true); 
			if(isset($meta_values)){
				$meta_values_new = $meta_values + 1;
				update_post_meta($post->ID,'b_meta_views',$meta_values_new);
			}else{
				add_post_meta($post_id,'b_meta_views','1', true);
			}
		}
	}
}
add_action('wp_head', 'b_update_value_views_in_database');

/*Get menu vertical category*/
if(!function_exists('b_get_menu_vertical_category')){
	function b_get_menu_vertical_category($list_cat, $style, $plugin_id, $image_size, $linkable){
		if(isset($list_cat) || ($list_cat != null)){
			$b_list_cat = new WP_Query('post_type=post&cat='.$list_cat->term_id);
		}
		else {
			$b_list_cat = new WP_Query('post_type=post');
		}
		$html = '';
		if($b_list_cat->have_posts()){
			$html .= '<div class="b-flexslider-mobie"><div class="b-flexslider"><ul class="slides b-slider-mobie">';
			while($b_list_cat->have_posts()): $b_list_cat->the_post();
				$html .= b_show_posts_mobile($style, $plugin_id, $image_size, $linkable);
			endwhile; wp_reset_postdata();
			$html .= '</ul></div></div>';	
		}
		else {
			$html .= __("<div class='b-flexslider-mobie'><p class='b-no-articles'>No articles in this category</p></div>", "b_category_slider");
		}
		return $html;
	}
}
/*Get menu vertical taxonomy*/
if(!function_exists('b_get_menu_vertical_taxonomy')){
	function b_get_menu_vertical_taxonomy($custom_post, $tax_name, $list_cat, $style, $plugin_id, $image_size, $linkable){
		$html = '';
		$args = array(
					'post_type'	=> $custom_post,
					'tax_query'	=> array(
							'taxonomy'	=> $tax_name,
							'terms'		=> $list_cat
					)
				);
		$b_list_cat = new WP_Query($args);
		if($b_list_cat->have_posts()){
			$html .= '<div class="b-flexslider-mobie"><div class="b-flexslider"><ul class="slides b-slider-mobie">';
			while($b_list_cat->have_posts()): $b_list_cat->the_post();
				$html .= b_show_posts_mobile($style, $plugin_id, $image_size, $linkable);
			endwhile; wp_reset_postdata();
			$html .= '</ul></div></div>';
		}
		else {
			$html .= __("<div class='b-flexslider-mobie'><p class='b-no-articles'>No articles in this category</p></div>", "b_category_slider");
		}
		return $html;
	}
}

/*Get post style slider*/
if(!function_exists('b_show_posts_by_style')){
	function b_show_posts_by_style($style, $columns, $plugin_id, $image_size, $linkable, $_b_device_){
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		
		$html = '';
		$thumb_size = '';
		$image_thumnail = '';
		global $wpdb;
		$table_setting = $wpdb->prefix . 'b_responsive_category_slider';
		$data = $wpdb->get_row("SELECT * FROM ".$table_setting." WHERE id=1");
		//$img_size = $data->img_size;
		$theme_style = $data->theme_style;
		if($linkable == 'on'){ $href_link = get_permalink(); }else { $href_link = 'javascript:void(0)';}
		$post_views = get_post_meta( get_the_ID(), 'b_meta_views', true);
		
		global $post;
		$url_thumb = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
		
		if($image_size == 'horizontal_rectangle' || $image_size == null){
			switch($columns){
				case 6: $thumb_size = 'thumb_180x120'; $sm = 'col-sm-4 col-xs-4'; break; 
				case 4: $thumb_size = 'thumb_276x184'; $sm = 'col-sm-6 col-xs-6'; break; 
				case 3: $thumb_size = 'thumb_375x250'; $sm = 'col-sm-4 col-xs-4'; break; 
				case 2: $thumb_size = 'thumb_570x380'; $sm = 'col-sm-6 col-xs-6';  break;
				case 1: $thumb_size = 'thumb_1158x772'; $sm = 'col-sm-12 col-xs-12'; break;
			}
		}
		else if($image_size == 'square'){
			switch($columns){
				case 6: $thumb_size = 'thumb_180x180'; $sm = 'col-sm-4 col-xs-4'; break; 
				case 4: $thumb_size = 'thumb_276x276'; $sm = 'col-sm-6 col-xs-6';  break; 
				case 3: $thumb_size = 'thumb_375x375'; $sm = 'col-sm-4 col-xs-4'; break; 
				case 2: $thumb_size = 'thumb_570x570'; $sm = 'col-sm-6 col-xs-6'; break;
				case 1: $thumb_size = 'thumb_1158x1158'; $sm = 'col-sm-12 col-xs-12'; break;
			}
		}
		else if($image_size == 'full_size'){
			switch($columns){
				case 6: $thumb_size = 'full'; $sm = 'col-sm-4 col-xs-4'; break; 
				case 4: $thumb_size = 'full'; $sm = 'col-sm-6 col-xs-6';  break; 
				case 3: $thumb_size = 'full'; $sm = 'col-sm-4 col-xs-4'; break; 
				case 2: $thumb_size = 'full'; $sm = 'col-sm-6 col-xs-6'; break;
				case 1: $thumb_size = 'full'; $sm = 'col-sm-12 col-xs-12'; break;
			}
		}
		else{
			switch($columns){
				case 6: $thumb_size = 'thumb_180x270'; $sm = 'col-sm-4 col-xs-4'; break; 
				case 4: $thumb_size = 'thumb_276x414'; $sm = 'col-sm-6 col-xs-6'; break; 
				case 3: $thumb_size = 'thumb_375x562'; $sm = 'col-sm-4 col-xs-4'; break; 
				case 2: $thumb_size = 'thumb_570x855'; $sm = 'col-sm-6 col-xs-6'; break;
				case 1: $thumb_size = 'thumb_1158x1737'; $sm = 'col-sm-12 col-xs-12'; break;
			}
		}
		
		//Check empty post thumnail to show images default
		if(empty($url_thumb)){
			if($image_size == 'horizontal_rectangle' || $image_size == null){
				switch($columns){
					case 1: $image_thumnail = '<image src="'.plugins_url( 'images/responsive-category-slider-1158x772.jpg', dirname(__FILE__)).'" title="Responsive Category Slider" alt="Free Wordpress Content slider - Wordpress plugin from ThemeLead" />'; 
							$url_thumb = plugins_url( 'images/responsive-category-slider-1158x772.jpg', dirname(__FILE__));
					break;
					default: $image_thumnail = '<image src="'.plugins_url( 'images/responsive-category-slider-570x380.jpg', dirname(__FILE__)).'" title="Responsive Category Slider" alt="Free Wordpress Content slider - Wordpress plugin from ThemeLead" />'; 
							$url_thumb = plugins_url( 'images/responsive-category-slider-570x380.jpg', dirname(__FILE__));
				}
			}else if($image_size == 'square'){
				switch($columns){
					case 1: $image_thumnail = '<image src="'.plugins_url( 'images/responsive-category-slider-1158x1158.jpg', dirname(__FILE__)).'" title="Responsive Category Slider" alt="Free Wordpress Content slider - Wordpress plugin from ThemeLead" />'; 
							$url_thumb = plugins_url( 'images/responsive-category-slider-1158x1158.jpg', dirname(__FILE__));
					break;
					default: $image_thumnail = '<image src="'.plugins_url( 'images/responsive-category-slider-570x570.jpg', dirname(__FILE__)).'" title="Responsive Category Slider" alt="Free Wordpress Content slider - Wordpress plugin from ThemeLead" />'; 
							$url_thumb = plugins_url( 'images/responsive-category-slider-570x570.jpg', dirname(__FILE__));
				}
			}else if($image_size == 'full_size'){
				switch($columns){
					case 1: $image_thumnail = '<image src="'.plugins_url( 'images/responsive-category-slider-1158x772.jpg', dirname(__FILE__)).'" title="Responsive Category Slider" alt="Free Wordpress Content slider - Wordpress plugin from ThemeLead" />'; 
							$url_thumb = plugins_url( 'images/responsive-category-slider-1158x772.jpg', dirname(__FILE__));
					break;
					default: $image_thumnail = '<image src="'.plugins_url( 'images/responsive-category-slider-570x380.jpg', dirname(__FILE__)).'" title="Responsive Category Slider" alt="Free Wordpress Content slider - Wordpress plugin from ThemeLead" />'; 
							$url_thumb = plugins_url( 'images/responsive-category-slider-570x380.jpg', dirname(__FILE__));
				}
			}else{
				switch($columns){
					case 1: $image_thumnail = '<image src="'.plugins_url( 'images/responsive-category-slider-1158x1737.jpg', dirname(__FILE__)).'" title="Responsive Category Slider" alt="Free Wordpress Content slider - Wordpress plugin from ThemeLead" />'; 
							$url_thumb = plugins_url( 'images/responsive-category-slider-1158x1737.jpg', dirname(__FILE__));
					break;
					default: $image_thumnail = '<image src="'.plugins_url( 'images/responsive-category-slider-570x855.jpg', dirname(__FILE__)).'" title="Responsive Category Slider" alt="Free Wordpress Content slider - Wordpress plugin from ThemeLead" />'; 
							$url_thumb = plugins_url( 'images/responsive-category-slider-570x855.jpg', dirname(__FILE__));
				}
			}
		}
		else{
			$image_thumnail = get_the_post_thumbnail(get_the_ID(), $thumb_size, array("alt" => get_the_title(), "class" => "b-thumb"));
		}
		
		if($theme_style == 'themelead'){
			if($style == 'gallery') {
				if($_b_device_ == 'tablet'){
					$html .= '<div class="col-md-'.(12/$columns).' '.$sm.'">
									<div class="b-themelead-style"><a href="'.$href_link.'">'.$image_thumnail.'</a></div>
							  </div>';
				}else {
					$html .=	'<div class="col-md-'.(12/$columns).' '.$sm.'">
									<div class="b-themelead-style">'.$image_thumnail.'
										<div class="b-face-post-bg">
											<div class="b-face-post" align="center">
												<h3>'.get_the_title().'</h3>
												<a href="'.$url_thumb.'" alt="" class="b-icons-search" rel="prettyPhoto[gallery-desktop'.$plugin_id.']"></a>
												<a href="'.$href_link.'" title="'.get_the_title().'" class="b-icons-link"></a>
											</div>
										</div>
									</div>
								</div>';
				}
			} 
			elseif($style == 'news'){
				$html .= '<div class="col-md-'.(12/$columns).' '.$sm.' b-latest-news">
							<div class="b-latest-news-item">
								<a href="'.$href_link.'">'.$image_thumnail.'</a>
								<div class="b-description">
									<div class="b-descript">
										<h2>'.get_the_title().'</h2>
										<span class="b-datetime">'.get_the_time("F j, Y").' <span>• '.__("Views ", "b_category_slider").': '.$post_views.'</span></span>
									</div>
								</div>';
								if($_b_device_ != 'tablet'):
									$html .= '<div class="b-mirror"><a href="'.$href_link.'"><span>'.__("Read more", "b_category_slider").'</span></a></div>';
								endif;
						$html .=	'</div></div>';
			}
			elseif($style == 'events'){
				$html .=	'<div class="col-md-'.(12/$columns).' '.$sm.'">
								<div class="b-themelead-style">'.$image_thumnail;
									if($_b_device_ != 'tablet'):
									$html .= '<div class="b-face-post-bg">
										<div class="b-face-post" align="center">
											<a href="'.$url_thumb.'" alt="" class="b-icons-search" rel="prettyPhoto[gallery-desktop'.$plugin_id.']"></a>
											<a href="'.$href_link.'" title="'.get_the_title().'" class="b-icons-link"></a>
										</div>
									</div>';
									endif;
							$html .=	'</div>
								<div class="b-themelead-style-bottom">
									<div class="b-des-posts b-events-style">
										<div class="b-time">
											<span id="b-date">'.get_the_time("j").'</span><span id="b-month">'.get_the_time("F").'</span>
										</div>
										<h3 class=""><a href="'.$href_link.'">'.get_the_title().'</a></h3>
										<p>'.get_the_time("F j, Y").'</p>
									</div>
								</div>
							</div>';
							
			} elseif($style == 'product'){
				$html .=	'<div class="col-md-'.(12/$columns).' '.$sm.'">
								<div class="b-themelead-style">'.$image_thumnail;
								if($_b_device_ != 'tablet'):
								$html .= '<div class="b-face-post-bg">
											<div class="b-face-post" align="center">
												<a href="'.$url_thumb.'" alt="" class="b-icons-search" rel="prettyPhoto[gallery-desktop'.$plugin_id.']"></a>
												<a href="'.$href_link.'" title="'.get_the_title().'" class="b-icons-link"></a>
											</div>
										</div>';
								endif;
							$html .= '</div><div class="b-themelead-style-bottom"><div class="b-product-summary">';
				if(is_plugin_active('woocommerce/woocommerce.php')):
							global $woocommerce;
							$regular_price = get_post_meta( get_the_ID(), '_regular_price', true);
							$sale_price = get_post_meta( get_the_ID(), '_sale_price' , true);
							if(empty($sale_price)) {$price = $regular_price;} else {$price = $sale_price;}

							$html .= '<p>'.get_woocommerce_currency_symbol().$price.'</p>';
						endif;
				$html .=  '<h3 class=""><a href="'.$href_link.'">'.get_the_title().'</a></h3>
						  </div></div></div>';
						  
			} elseif($style = 'post') {
				$html .=	'<div class="col-md-'.(12/$columns).' '.$sm.'">
								<div class="b-themelead-style">'.$image_thumnail;
								if($_b_device_ != 'tablet'):
								$html .= '<div class="b-face-post-bg">
											<div class="b-face-post" align="center">
												<a href="'.$url_thumb.'" alt="" class="b-icons-search" rel="prettyPhoto[gallery-desktop'.$plugin_id.']"></a>
												<a href="'.$href_link.'" title="'.get_the_title().'" class="b-icons-link"></a>
											</div>
										</div>';
								endif;
								$html .= '</div>
								<div class="b-themelead-style-bottom">
									<h3 class=""><a href="'.$href_link.'">'.get_the_title().'</a></h3>
									<p>'.get_the_time('F j, Y').'</p>
								</div>
							</div>';
			}
		}
		else{
			if($style == 'gallery') {
				if($_b_device_ == 'tablet'){
					$html .= '<div class="col-md-'.(12/$columns).' '.$sm.' b-gallery-style">
									<div class="b-hover-gallery"><div class="b-themelead-style"><a href="'.$href_link.'">'.$image_thumnail.'</a></div></div>
							  </div>';
				} else {
					$html .= '<div class="col-md-'.(12/$columns).' '.$sm.' b-gallery-style">
							<div class="b-hover-gallery">
								<div class="b-slider-thumbnail b-box"><a href="'.$href_link.'">'.$image_thumnail.'</a><div class="b-face-post b-inner">
								<a href="'.$href_link.'"><img src="'.plugins_url( 'images/b-galery-hover.png' , dirname(__FILE__) ).'" alt="view more" /></a>
								</div></div>
								</div></div>';
				}
			}
			elseif($style == 'news'){
				$html .= '<div class="col-md-'.(12/$columns).' '.$sm.' b-latest-news">
							<div class="b-latest-news-item">
								<a href="'.$href_link.'">'.$image_thumnail.'</a>
								<div class="b-description">
									<div class="b-descript">
										<h2>'.get_the_title().'</h2>
										<span class="b-datetime">'.get_the_time("F j, Y").' <span>• '.__("Views ", "b_category_slider").': '.$post_views.'</span></span>
									</div>
								</div>';
								if($_b_device_ != 'tablet'):
									$html .= '<div class="b-mirror"><a href="'.$href_link.'"><span>'.__("Read more", "b_category_slider").'</span></a></div>';
								endif;
						$html .=	'</div></div>';
			}
			elseif($style == 'events') {
				$html .= '<div class="col-md-'.(12/$columns).' '.$sm.' b-events-style">
							<div class="b-slider-thumbnail">'.$image_thumnail;
						if($_b_device_ != 'tablet'):
						$html .= '<div class="b-face-post">
							<div>
							<a href="'.$href_link.'" class="b-link-icon"><i class="fa fa-link"></i></a>
							<a href="'.$url_thumb.'" alt="" class="b-search-icon" rel="prettyPhoto[gallery-desktop'.$plugin_id.']"><i class="fa fa-search"></i></a>
							</div></div>';
						endif;
						$html .= '</div>
							<div class="b-des-posts">
								<div class="b-time">
									<span id="b-date">'.get_the_time("j").'</span><span id="b-month">'.get_the_time("F").'</span>
								</div>
								<h3 class=""><a href="'.$href_link.'">'.get_the_title().'</a></h3>
								<p>'.get_the_time("F j, Y").'</p>
						  </div></div>';
			} elseif($style == 'product') {
				$html .= '<div class="col-md-'.(12/$columns).' '.$sm.' b-gallery-style b-product-style">';
							if($_b_device_ != 'tablet'){
							$html .= '<div class="b-figcaption">
								<div class="b-slider-thumbnail"><a href="'.$href_link.'">'.$image_thumnail.'</a>
								<div class="b-face-post b-product">
								<a href="'.$href_link.'"><img src="'.plugins_url( 'images/icon_add.png' , dirname(__FILE__) ).'" alt="view more" /></a>
								</div></div></div>';
							} else {
								$html .= '<div class="b-figcaption"><a href="'.$href_link.'">'.$image_thumnail.'</a></div>';
							}
							$html .= '<div class="b-product-summary">';
						if(is_plugin_active('woocommerce/woocommerce.php')):
							global $woocommerce;
							$regular_price = get_post_meta( get_the_ID(), '_regular_price', true);
							$sale_price = get_post_meta( get_the_ID(), '_sale_price' , true);
							if(empty($sale_price)) {$price = $regular_price;} else {$price = $sale_price;}
							$html .= '<p>'.get_woocommerce_currency_symbol().$price.'</p>';
						endif;
				$html .=  '<h3 class=""><a href="'.$href_link.'">'.get_the_title().'</a></h3>
						  </div></div>';
			} elseif($style = 'post') {
				$html .= '<div class="col-md-'.(12/$columns).' '.$sm.' b-post-style">
							<div class="b-slider-thumbnail">
							<a href="'.$href_link.'">'.$image_thumnail.'</a>';
							if($_b_device_ != 'tablet'):
							$html .= '<div class="b-face-post"><div>
							<a href="'.$href_link.'" class="b-link-icon"><i class="fa fa-link"></i></a>
							<a href="'.$url_thumb.'" alt="" class="b-search-icon" rel="prettyPhoto[gallery-desktop'.$plugin_id.']"><i class="fa fa-search"></i></a>
							</div></div>';
							endif;
							$html .= '</div>
							<h3 class=""><a href="'.$href_link.'">'.get_the_title().'</a></h3>
							<p>'.get_the_time('F j, Y').'</p>
						  </div>';
			}
		}
		return $html;
	}
}

/*Get post in menu mobile*/
if(!function_exists('b_show_posts_mobile')){
	function b_show_posts_mobile($style, $plugin_id, $image_size, $linkable){
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		
		$thumb_size = '';
		$html = '';
		$image_thumnail = '';
		global $wpdb;
		$table_setting = $wpdb->prefix . 'b_responsive_category_slider';
		$data = $wpdb->get_row("SELECT * FROM ".$table_setting." WHERE id=1");
		$theme_style = $data->theme_style;
		if($linkable == 'on'){ $href_link = get_permalink(); }else { $href_link = 'javascript:void(0)';}
		$post_views = get_post_meta( get_the_ID(), 'b_meta_views', true);
		
		global $post;
		$url_thumb = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
		
		if($image_size == 'horizontal_rectangle' || $image_size == null){
			$thumb_size = 'thumb_480x320';
			
		}
		else if($image_size == 'square'){
			$thumb_size = 'thumb_480x480';
		}
		else if($image_size == 'full_size'){
			$thumb_size = 'full';
		}
		else {
			$thumb_size = 'thumb_480x720';
		}
		
		//Check empty post thumnail to show images default
		if(empty($url_thumb)){
			if($image_size == 'horizontal_rectangle' || $image_size == null){
				$image_thumnail = '<image src="http://docs.themelead.com/images/responsive-category-slider-570x380.jpg" title="Responsive Category Slider" alt="Free Wordpress Content slider - Wordpress plugin from ThemeLead" />';
				$url_thumb = 'http://docs.themelead.com/images/responsive-category-slider-570x380.jpg';
			}else if($image_size == 'square'){
				$image_thumnail = '<image src="http://docs.themelead.com/images/responsive-category-slider-570x570.jpg" title="Responsive Category Slider" alt="Free Wordpress Content slider - Wordpress plugin from ThemeLead" />';
				$url_thumb = 'http://docs.themelead.com/images/responsive-category-slider-570x570.jpg';
			}else if($image_size == 'full_size'){
				$image_thumnail = '<image src="http://docs.themelead.com/images/responsive-category-slider-570x380.jpg" title="Responsive Category Slider" alt="Free Wordpress Content slider - Wordpress plugin from ThemeLead" />';
				$url_thumb = 'http://docs.themelead.com/images/responsive-category-slider-570x380.jpg';
			}else{
				$image_thumnail = '<image src="http://docs.themelead.com/images/responsive-category-slider-570x855.jpg" title="Responsive Category Slider" alt="Free Wordpress Content slider - Wordpress plugin from ThemeLead" />';
				$url_thumb = 'http://docs.themelead.com/images/responsive-category-slider-570x855.jpg';
			}
		}
		else{
			$image_thumnail = get_the_post_thumbnail(get_the_ID(), $thumb_size, array("alt" => get_the_title(), "class" => "b-thumb"));
		}
		
		if($theme_style == 'themelead'){
			if($style == 'gallery') {
				$html .=	'<li>
								<div class="b-themelead-style"><a href="'.$href_link.'">'.$image_thumnail.'</a></div>
							</li>';
			}
			elseif($style == 'news'){
				$html .= '<li class="b-latest-news">
							<div class="b-latest-news-item">
								<a href="'.$href_link.'">'.$image_thumnail.'</a>
								<div class="b-description">
									<div class="b-descript">
										<h2>'.get_the_title().'</h2>
										<span class="b-datetime">'.get_the_time("F j, Y").' <span>• '.__("Views ", "b_category_slider").': '.$post_views.'</span></span>
									</div>
								</div>
							</div>
						 </li>';
			}
			elseif($style == 'events') {
				$html .=	'<li>
								<div class="b-themelead-style">'.$image_thumnail.'</div>
								<div class="b-themelead-style-bottom">
									<div class="b-des-posts">
										<div class="b-time">
											<span id="b-date">'.get_the_time("j").'</span><span id="b-month">'.get_the_time("F").'</span>
										</div>
										<h3 class=""><a href="'.$href_link.'">'.get_the_title().'</a></h3>
										<p>'.get_the_time("F j, Y").'</p>
									</div>
								</div>
							</li>';
			}
			elseif ($style="product"){
				$html .=	'<li>
								<div class="b-themelead-style"><a href="'.$href_link.'">'.$image_thumnail.'</a></div>
								<div class="b-themelead-style-bottom"><div class="b-product-summary">';
					if(is_plugin_active('woocommerce/woocommerce.php')):
								global $woocommerce;
								$regular_price = get_post_meta( get_the_ID(), '_regular_price', true);
								$sale_price = get_post_meta( get_the_ID(), '_sale_price' , true);
								if(empty($sale_price)) {$price = $regular_price;} else {$price = $sale_price;}
								
								$html .= '<p>'.get_woocommerce_currency_symbol().$price.'</p>';
							endif;
					$html .=  '<h3 class=""><a href="'.$href_link.'">'.get_the_title().'</a></h3>
							  </div></div></li>';
							  
			} elseif($style = 'post') {
				$html .=	'<li>
								<div class="b-themelead-style">'.$image_thumnail.'</div>
								<div class="b-themelead-style-bottom">
									<h3 class=""><a href="'.$href_link.'">'.get_the_title().'</a></h3>
									<p>'.get_the_time('F j, Y').'</p>
								</div>
							</li>';
			}
		}
		else {
			if($style == 'gallery') {
				$html .= '<li class="b-gallery-style">
							<div class="b-hover-gallery">
								<div class="b-slider-thumbnail"><a href="'.$href_link.'">'.$image_thumnail.'</a></div>
							</div>
						  </li>';
			}
			elseif($style == 'news'){
				$html .= '<li class="b-latest-news">
							<div class="b-latest-news-item">
								<a href="'.$href_link.'">'.$image_thumnail.'</a>
								<div class="b-description">
									<div class="b-descript">
										<h2>'.get_the_title().'</h2>
										<span class="b-datetime">'.get_the_time("F j, Y").' <span>• '.__("Views ", "b_category_slider").': '.$post_views.'</span></span>
									</div>
								</div>
							</div>
						 </li>';
			}
			elseif($style == 'events') {
				$html .= '<li class="b-events-style">
							<div class="b-slider-thumbnail"><a href="'.$href_link.'">'.$image_thumnail.'</a></div>
							<div class="b-des-posts">
								<div class="b-time">
									<span id="b-date">'.get_the_time("j").'</span><span id="b-month">'.get_the_time("F").'</span>
								</div>
								<h3 class=""><a href="'.$href_link.'">'.get_the_title().'</a></h3>
								<p>'.get_the_time("F j, Y").'</p>
							</div>
						  </li>';
			} elseif($style == 'product') {
				$html .= '<li class="b-gallery-style">
							<div class="b-hover-gallery">
								<div class="b-slider-thumbnail">'.$image_thumnail.'</div>
							</div><div class="b-product-summary">';
						if(is_plugin_active('woocommerce/woocommerce.php')):
							global $woocommerce;
							$regular_price = get_post_meta( get_the_ID(), '_regular_price', true);
							$sale_price = get_post_meta( get_the_ID(), '_sale_price' , true);
							if(empty($sale_price)) {$price = $regular_price;} else {$price = $sale_price;}
							$html .= '<p>'.get_woocommerce_currency_symbol().$price.'</p>';
						endif;
				$html .=	'<h3 class=""><a href="'.$href_link.'">'.get_the_title().'</a></h3>
						  </div></li>';
			
			} elseif($style = 'post') {
				$html .= '<li>
							<div class="b-slider-thumbnail"><a href="'.$href_link.'">'.$image_thumnail.'</a></div>
							<h3 class=""><a href="'.$href_link.'">'.get_the_title().'</a></h3>
							<p>'.get_the_time("F j, Y").'</p>
						  </li>';
			}
		}
		return $html;
	}
}

/*Get list menu horizontal*/
if(!function_exists('b_get_menu_horizontal')){
	function b_get_menu_horizontal($type, $cat_id, $tax_name, $list_tags, $plugin_id, $show_parent_menu){
		$html = '';
		global $wpdb;
		$table_cat = $wpdb->prefix ."term_taxonomy";
		if($type != 'tag'){
			if($type == 'category'){
				//Check isset parent
				if ($cat_id == 'category'){
					$parent = 'all';
				}
				else if(is_numeric($cat_id)){
					$parents = $wpdb->get_row("SELECT term_id FROM ".$table_cat." WHERE taxonomy='category' AND term_id=".$cat_id);
					$parent = $parents->term_id;
				}
				else{
					$category_obj = get_category_by_slug( $cat_id );
					$cat_id_slug = $category_obj->term_id;
					$parents = $wpdb->get_row("SELECT term_id FROM ".$table_cat." WHERE taxonomy='category' AND term_id=".$cat_id_slug);
					$parent = $parents->term_id;
				}
				//If parent not exists 
				if(empty($parent)){
					$html .= "<p class='warring_message'>".__("Category ID or Slug is not available")."</p>";
				} 
				else {
					//Get parent menu
					if($parent != 'all'){
						$html .= '<a name="'.$plugin_id.'" alt="'.$parent.'" class="b-vertical b-parent b-home-parent" href="#">'.get_cat_name($parent).'</a>';
					} else {
						$html .= '<a name="'.$plugin_id.'" alt="all" class="b-vertical b-parent b-home-parent" href="#">'.__("All categories", "b_category_slider").'</a>';
					}
					
					//Get menu child horizontal
					if ($cat_id == 'category'){
						$list_cats = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE taxonomy='category' AND parent=0");
					}
					else if(is_numeric($cat_id)){
						$list_cats = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE taxonomy='category' AND parent=".$cat_id);
					}
					else{
						$category_obj = get_category_by_slug( $cat_id );
						$cat_id_slug = $category_obj->term_id;
						$list_cats = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE taxonomy='category' AND parent=".$cat_id_slug);
					}
					
					$rowCount = $wpdb->num_rows;
					if($rowCount > 0){
						$html .= '<div class="b-flexslider-mb" id="b-flexs"><ul class="slides b-menu-category">';
						foreach ($list_cats as $list_cat){
							$html .= '<li>';
							$html .= '<a name="'.$plugin_id.'" alt="'.$list_cat->term_id.'" href="#">'.get_cat_name($list_cat->term_id).'</a>';
							$list_childs1 = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE taxonomy='category' AND parent=".$list_cat->term_id);
							$rowCount1 = $wpdb->num_rows;
							if($rowCount1 > 0):
							$html .= '<i class="fa fa-caret-down"></i>';
							$html .= '<ul class="b-sub-menu">';
							foreach ($list_childs1 as $list_child1){
								$html .= '<li>';
								$html .= '<a name="'.$plugin_id.'" alt="'.$list_child1->term_id.'" href="#">'.get_cat_name($list_child1->term_id).'</a>';
								$list_childs2 = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE taxonomy='category' AND parent=".$list_child1->term_id);
								$rowCount2 = $wpdb->num_rows;
								if($rowCount2 > 0):
								$html .= '<i class="fa fa-caret-down"></i>';
								$html .= '<ul class="b-sub-menu">';
								foreach ($list_childs2 as $list_child2){
									$html .= '<li>';
									$html .= '<a name="'.$plugin_id.'" alt="'.$list_child2->term_id.'" href="#">'.get_cat_name($list_child2->term_id).'</a>';
									$list_childs3 = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE taxonomy='category' AND parent=".$list_child2->term_id);
									$rowCount3 = $wpdb->num_rows;
									if($rowCount3 > 0):
										$html .= '<i class="fa fa-caret-down"></i>';
										$html .= '<ul class="b-sub-menu">';
										foreach ($list_childs3 as $list_child3){
											$html .= '<li><a name="'.$plugin_id.'" alt="'.$list_child3->term_id.'" href="#">'.get_cat_name($list_child3->term_id).'</a></li>';
										}
										$html .= '</ul>';
									endif;
									$html .= '</li>';
								}
								$html .= '</ul>';
								endif;
								$html .= '</li>';
							}
							$html .= '</ul>';
							endif;
							$html .= '</li>';
						}
						$html .= '</ul></div>';
					}
				}
			}
			else if($type == 'taxonomy'){
				//if not isset taxonomy name, to show default is category
				if($tax_name == null){
					//Show parent all categories when tax_name is not exist
					$html .= '<a name="'.$plugin_id.'" alt="all" class="b-vertical b-parent b-home-parent" href="#">'.__("All categories", "b_category_slider").'</a>';
					
					$list_cats = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE taxonomy='category' AND parent=0");
					$rowCount = $wpdb->num_rows;
					if($rowCount > 0){
						$html .= '<div class="b-flexslider-mb" id="b-flexs"><ul class="slides b-menu-category">';
						foreach ($list_cats as $list_cat){
							$html .= '<li>';
							$html .= '<a name="'.$plugin_id.'" alt="'.$list_cat->term_id.'" href="#">'.get_cat_name($list_cat->term_id).'</a>';
							$list_childs1 = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE parent=".$list_cat->term_id);
							$rowCount1 = $wpdb->num_rows;
							if($rowCount1 > 0):
							$html .= '<i class="fa fa-caret-down"></i>';
							$html .= '<ul class="b-sub-menu">';
							foreach ($list_childs1 as $list_child1){
								$html .= '<li>';
								$html .= '<a name="'.$plugin_id.'" alt="'.$list_child1->term_id.'" href="#">'.get_cat_name($list_child1->term_id).'</a>';
								$list_childs2 = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE parent=".$list_child1->term_id);
								$rowCount2 = $wpdb->num_rows;
								if($rowCount2 > 0):
								$html .= '<i class="fa fa-caret-down"></i>';
								$html .= '<ul class="b-sub-menu">';
								foreach ($list_childs2 as $list_child2){
									$html .= '<li>';
									$html .= '<a name="'.$plugin_id.'" alt="'.$list_child2->term_id.'" href="#">'.get_cat_name($list_child2->term_id).'</a>';
									$list_childs3 = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE parent=".$list_child2->term_id);
									$rowCount3 = $wpdb->num_rows;
									if($rowCount3 > 0):
										$html .= '<i class="fa fa-caret-down"></i>';
										$html .= '<ul>';
										foreach ($list_childs3 as $list_child3){
											$html .= '<li><a name="'.$plugin_id.'" alt="'.$list_child3->term_id.'" href="#">'.get_cat_name($list_child3->term_id).'</a></li>';
										}
										$html .= '</ul>';
									endif;
									$html .= '</li>';
								}
								$html .= '</ul>';
								endif;
								$html .= '</li>';
							}
							$html .= '</ul>';
							endif;
							$html .= '</li>';
						}
						$html .= '</ul></div>';
					}
				}
				else{
					$cat_id_replace = str_replace(" ", "", $cat_id);
					$cat_id_explo = explode(",", $cat_id_replace);
					$count_catid =  count($cat_id_explo);
					if(empty($cat_id)){
						$html .= '<a name="'.$plugin_id.'" alt="" class="b-vertical b-parent b-home-parent" href="#">'.__("All categories", "b_category_slider").'</a>';
						$list_cats = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE taxonomy='".$tax_name."' AND parent=0");
					}
					else {
						if(count($cat_id_explo) === 1){
							if(is_numeric($cat_id_explo[0])){
								$list_cats = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE parent=".$cat_id_explo[0]);
								if(empty($list_cats)){
									$b_term = get_term_by('id', $cat_id_explo[0], $tax_name);
									if(!empty($b_term)){
										$html .= '<a name="'.$plugin_id.'" alt="'.$b_term->term_id.'" class="b-vertical b-parent b-home-parent b-home-parent-only" href="#">'.$b_term->name.'</a>';
									} else {
										$html .= __("<p>Category ID or Slug is not available</p>", "b_category_slider");
									}
								}
							}
							else {
								$b_term = get_term_by('slug', $cat_id_explo[0], $tax_name);
								if(!empty($b_term)){
									$list_cats = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE parent=".$b_term->term_id);
									$html .= '<a name="'.$plugin_id.'" alt="'.$b_term->term_id.'" class="b-vertical b-parent b-home-parent" href="#">'.$b_term->name.'</a>';
								}else{
									$html .= __("<p>Category ID or Slug is not available</p>", "b_category_slider");
								}
							}
						}
						else {
							$filtered = array_filter($cat_id_explo, 'is_numeric');
							if($filtered == $cat_id_explo){
								$cat_id = join(',',$cat_id_explo);
								$list_cats = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE term_id IN ($cat_id) AND taxonomy='".$tax_name."'");
							}
							else {
								$string='';
								foreach($cat_id_explo as $value){
									$b_term = get_term_by('slug', $value, $tax_name);
									$term_id = $b_term->term_id;
									if(!empty($term_id)):
									$string = $string.','.$term_id;
									endif;
								}
								$cat_id = substr($string,1);
								$list_cats = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE term_id IN ($cat_id) AND taxonomy='".$tax_name."'");
							}
						}
					}
					if($list_cats){
						$rowCount = $wpdb->num_rows;
						if($rowCount > 0){
							$html .= '<div class="b-flexslider-mb" id="b-flexs"><ul class="slides b-menu-category">';
							foreach ($list_cats as $list_cat){
								$term = get_term ($list_cat->term_id, $tax_name);
								$html .= '<li>';
								if(!empty($term)){
								$html .= '<a name="'.$plugin_id.'" alt="'.$list_cat->term_id.'" href="#">'.$term->name.'</a>';
								}
								$list_childs1 = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE parent=".$list_cat->term_id);
								$rowCount1 = $wpdb->num_rows;
								if($rowCount1 > 0 && $count_catid < 2):
								$html .= '<i class="fa fa-caret-down"></i>';
								$html .= '<ul class="b-sub-menu">';
								foreach ($list_childs1 as $list_child1){
									$term1 = get_term ($list_child1->term_id, $tax_name);
									$html .= '<li>';
									if(!empty($term1)){
									$html .= '<a name="'.$plugin_id.'" alt="'.$list_child1->term_id.'" href="#">'.$term1->name.'</a>';
									}
									$list_childs2 = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE parent=".$list_child1->term_id);
									$rowCount2 = $wpdb->num_rows;
									if($rowCount2 > 0):
									$html .= '<i class="fa fa-caret-down"></i>';
									$html .= '<ul class="b-sub-menu">';
									foreach ($list_childs2 as $list_child2){
										$term2 = get_term ($list_child2->term_id, $tax_name);
										$html .= '<li>';
										if(!empty($term2)){
										$html .= '<a name="'.$plugin_id.'" alt="'.$list_child2->term_id.'" href="#">'.$term2->name.'</a>';
										}
										$list_childs3 = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE parent=".$list_child2->term_id);
										$rowCount3 = $wpdb->num_rows;
										if($rowCount3 > 0):
											$html .= '<i class="fa fa-caret-down"></i>';
											$html .= '<ul>';
											foreach ($list_childs3 as $list_child3){
												$term3 = get_term ($list_child3->term_id, $tax_name);
												if(!empty($term3)){
												$html .= '<li><a name="'.$plugin_id.'" alt="'.$list_child3->term_id.'" href="#">'.$term3->name.'</a></li>';
												}
											}
											$html .= '</ul>';
										endif;
										$html .= '</li>';
									}
									$html .= '</ul>';
									endif;
									$html .= '</li>';
								}
								$html .= '</ul>';
								endif;
								$html .= '</li>';
							}
							$html .= '</ul></div>';
						}
					}
				}
			}
		}
		else {
			if(!empty($list_tags)){
				$html .= '<div class="b-flexslider-mb" id="b-flexs"><ul class="slides b-menu-category">';
				$array_tags = explode(",", trim($list_tags," "));
				foreach ($array_tags as $value){
					$html .= '<li><a name="'.$plugin_id.'" alt="'.$value.'" href="#">'.b_GetTagName($value).'</a></li>';
				}
				$html .= '</ul></div>';
			} else {
				$html .= '<div class="b-flexslider-mb" id="b-flexs"><ul class="slides b-menu-category">';
				$posttags = get_tags('orderby=term_id&order=DESC');
				if ($posttags) {
				  foreach($posttags as $tag) {
					$html .= '<li><a name="'.$plugin_id.'" alt="'.$tag->slug.'" href="#">'.$tag->name.'</a></li>';
				  }
				}
				$html .= '</ul></div>';
			}
		}
		return $html;
	}
}


/*Get list menu vertical*/
if(!function_exists('b_get_menu_vertical')){
	function b_get_menu_vertical($type, $cat_id, $tax_name, $custom_post, $style, $list_tags, $plugin_id, $image_size, $linkable, $show_parent_menu){
		$html = '';
		global $wpdb;
		$table_cat = $wpdb->prefix ."term_taxonomy";
		if($type != 'tag'){
			if($type == 'category'){
				//Check isset parent
				if ($cat_id == 'category'){
					$parent = 'all';
				}
				else if(is_numeric($cat_id)){
					$parents = $wpdb->get_row("SELECT term_id FROM ".$table_cat." WHERE taxonomy='category' AND term_id=".$cat_id);
					$parent = $parents->term_id;
				}
				else{
					$category_obj = get_category_by_slug( $cat_id );
					$cat_id_slug = $category_obj->term_id;
					$parents = $wpdb->get_row("SELECT term_id FROM ".$table_cat." WHERE taxonomy='category' AND term_id=".$cat_id_slug);
					$parent = $parents->term_id;
				}
				
				//If parent not exists 
				if(empty($parent)){
					$html .= "<p class='warring_message'>".__("Category ID or Slug is not available")."</p>";
				} 
				else {
					//Get parent menu
					if($parent != 'all'){
						$html .= '<li class="b-li-parent">';
						$html .= '<a name="'.$plugin_id.'" alt="'.$parent.'" class="b-vertical b-parent" href="#">'.get_cat_name($parent).'</a>';
						$html .= b_get_menu_vertical_category($parents, $style, $plugin_id, $image_size, $linkable);
						$html .= '</li>';
					} else {
						$html .= '<li class="b-li-parent">';
						$html .= '<a name="'.$plugin_id.'" alt="all" class="b-vertical b-parent" href="#">'.__("All categories", "b_category_slider").'</a>';
						$html .= b_get_menu_vertical_category(null, $style, $plugin_id, $image_size, $linkable);
						$html .= '</li>';
					}
					//Get menu child
					if ($cat_id == 'category'){
						$list_cats = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE taxonomy='category' AND parent=0");
					}
					else if(is_numeric($cat_id)){
						$list_cats = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE taxonomy='category' AND parent=".$cat_id);
					}
					else{
						$category_obj = get_category_by_slug( $cat_id );
						$cat_id_slug = $category_obj->term_id;
						$list_cats = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE taxonomy='category' AND parent=".$cat_id_slug);
					}
					$rowCount = $wpdb->num_rows;
					if($rowCount > 0){
						foreach ($list_cats as $list_cat){
							$html .= '<li>';
							$html .= '<a name="'.$plugin_id.'" alt="'.$list_cat->term_id.'" class="b-vertical" href="#">'.get_cat_name($list_cat->term_id).'</a>';
							$html .= b_get_menu_vertical_category($list_cat, $style, $plugin_id, $image_size, $linkable);
							$html .= '</li>';
							$list_childs1 = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE taxonomy='category' AND parent=".$list_cat->term_id);
							$rowCount1 = $wpdb->num_rows;
							if($rowCount1 > 0):
							foreach ($list_childs1 as $list_child1){
								$html .= '<li>';
								$html .= '<a name="'.$plugin_id.'" alt="'.$list_child1->term_id.'" class="b-vertical" href="#">'.get_cat_name($list_child1->term_id).'</a>';
								$html .= b_get_menu_vertical_category($list_child1, $style, $plugin_id, $image_size, $linkable);
								$html .= '</li>';
								$list_childs2 = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE taxonomy='category' AND parent=".$list_child1->term_id);
								$rowCount2 = $wpdb->num_rows;
								if($rowCount2 > 0):
								foreach ($list_childs2 as $list_child2){
									$html .= '<li>';
									$html .= '<a name="'.$plugin_id.'" alt="'.$list_child2->term_id.'" class="b-vertical" href="#">'.get_cat_name($list_child2->term_id).'</a>';
									$html .= b_get_menu_vertical_category($list_child2, $style, $plugin_id, $image_size, $linkable);
									$html .= '</li>';
									$list_childs3 = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE taxonomy='category' AND parent=".$list_child2->term_id);
									$rowCount3 = $wpdb->num_rows;
									if($rowCount3 > 0):
										foreach ($list_childs3 as $list_child3){
											$html .= '<li>';
											$html .= '<a name="'.$plugin_id.'" alt="'.$list_child3->term_id.'" class="b-vertical" href="#">'.get_cat_name($list_child3->term_id).'</a>';
											$html .= b_get_menu_vertical_category($list_childs3, $style, $plugin_id, $image_size, $linkable);
											$html .= '</li>';
										}
									endif;			
								}
								endif;
							}
							endif;
						}
					}
				}
			}
			else if($type == 'taxonomy'){
				//if not isset taxonomy name, to show default is category
				if($tax_name == null){
					//Show parent all categories when tax_name is not exist
					$html .= '<li class="b-li-parent">';
					$html .= '<a name="'.$plugin_id.'" alt="all" class="b-vertical b-parent" href="#">'.__("All categories", "b_category_slider").'</a>';
					$html .= b_get_menu_vertical_category(null, $style, $plugin_id, $image_size, $linkable);
					$html .= '</li>';
					
					$list_cats = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE taxonomy='category' AND parent=0");
					$rowCount = $wpdb->num_rows;
					if($rowCount > 0){
						foreach ($list_cats as $list_cat){
							$html .= '<li>';
							$html .= '<a name="'.$plugin_id.'" alt="'.$list_cat->term_id.'" class="b-vertical" href="#">'.get_cat_name($list_cat->term_id).'</a>';
							$html .= b_get_menu_vertical_category($list_cat, $style, $plugin_id, $image_size, $linkable);
							$html .= '</li>';
							$list_childs1 = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE parent=".$list_cat->term_id);
							$rowCount1 = $wpdb->num_rows;
							if($rowCount1 > 0):
							foreach ($list_childs1 as $list_child1){
								$html .= '<li>';
								$html .= '<a name="'.$plugin_id.'" alt="'.$list_child1->term_id.'" class="b-vertical" href="#">'.get_cat_name($list_child1->term_id).'</a>';
								$html .= b_get_menu_vertical_category($list_child1, $style, $plugin_id, $image_size, $linkable);
								$html .= '</li>';
								$list_childs2 = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE parent=".$list_child1->term_id);
								$rowCount2 = $wpdb->num_rows;
								if($rowCount2 > 0):
								foreach ($list_childs2 as $list_child2){
									$html .= '<li>';
									$html .= '<a name="'.$plugin_id.'" alt="'.$list_child2->term_id.'" class="b-vertical" href="#">'.get_cat_name($list_child2->term_id).'</a>';
									$html .= b_get_menu_vertical_category($list_child2, $style, $plugin_id, $image_size, $linkable);
									$html .= '</li>';
									$list_childs3 = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE parent=".$list_child2->term_id);
									$rowCount3 = $wpdb->num_rows;
									if($rowCount3 > 0):
										foreach ($list_childs3 as $list_child3){
											$html .= '<li>';
											$html .= '<a name="'.$plugin_id.'" alt="'.$list_child3->term_id.'" class="b-vertical" href="#">'.get_cat_name($list_child3->term_id).'</a>';
											$html .= b_get_menu_vertical_category($list_childs3, $style, $plugin_id, $image_size, $linkable);
											$html .= '</li>';
										}
									endif;			
								}
								endif;
							}
							endif;
						}
					}
				}
				//Check with isset tax_name and custom post name
				else{
					$cat_id_replace = str_replace(" ", "", $cat_id);
					$cat_id_explo = explode(",", $cat_id_replace);
					$count_catid =  count($cat_id_explo);
					if(empty($cat_id)){
						$html .= '<li class="b-li-parent">';
						$html .= '<a name="'.$plugin_id.'" alt="" class="b-vertical b-parent" href="#">'.__("All categories", "b_category_slider").'</a>';
						$html .= b_get_menu_vertical_taxonomy($custom_post, $tax_name, '', $style, $plugin_id, $image_size, $linkable);
						$html .= '</li>';
						
						$list_cats = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE taxonomy = '".$tax_name."' AND parent=0");
					}
					else{
						if(count($cat_id_explo) === 1){
							//Get menu with custom post and taxonomy
							if(is_numeric($cat_id_explo[0])){
								$list_cats = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE parent=".$cat_id_explo[0]);
								
								$b_term = get_term_by('id', $cat_id_explo[0], $tax_name);
								if(!empty($b_term)){
									$html .= '<li class="b-li-parent">';
									$html .= '<a name="'.$plugin_id.'" alt="'.$b_term->term_id.'" class="b-vertical b-parent" href="#">'.$b_term->name.'</a>';
									$html .= b_get_menu_vertical_taxonomy($custom_post, $tax_name, $b_term->term_id, $style, $plugin_id, $image_size, $linkable);
									$html .= '</li>';
								} else {
									$html .= __("<p>Category ID or Slug is not available</p>", "b_category_slider");
								}
							}
							else {
								$b_term = get_term_by('slug', $cat_id_explo[0], $tax_name);
								if(!empty($b_term)){
									$list_cats = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE parent=".$b_term->term_id);
									$html .= '<li class="b-li-parent">';
									$html .= '<a name="'.$plugin_id.'" alt="'.$b_term->term_id.'" class="b-vertical b-parent" href="#">'.$b_term->name.'</a>';
									$html .= b_get_menu_vertical_taxonomy($custom_post, $tax_name, $b_term->term_id, $style, $plugin_id, $image_size, $linkable);
									$html .= '</li>';
								}else{
									$html .= __("<p>Category ID or Slug is not available</p>", "b_category_slider");
								}
							}
						}
						else {
							$filtered = array_filter($cat_id_explo, 'is_numeric');
							if($filtered == $cat_id_explo){
								$cat_id = join(',',$cat_id_explo);
								$list_cats = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE term_id IN ($cat_id) AND taxonomy='".$tax_name."'");
							}
							else {
								$string='';
								foreach($cat_id_explo as $value){
									$b_term = get_term_by('slug', $value, $tax_name);
									$term_id = $b_term->term_id;
									if(!empty($term_id)):
									$string = $string.','.$term_id;
									endif;
								}
								$cat_id = substr($string,1);
								$list_cats = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE term_id IN ($cat_id) AND taxonomy='".$tax_name."'");
							}
						}
					}
					if($list_cats){
						$rowCount = $wpdb->num_rows;
						if($rowCount > 0){
							foreach ($list_cats as $list_cat){
								$term = get_term ($list_cat->term_id, $tax_name);
								$html .= '<li>';
								if(!empty($term)){
								$html .= '<a name="'.$plugin_id.'" alt="'.$list_cat->term_id.'" class="b-vertical" href="#">'.$term->name.'</a>';
								}
								$html .= b_get_menu_vertical_taxonomy($custom_post, $tax_name, $list_cat->term_id, $style, $plugin_id, $image_size, $linkable);
								$html .= '</li>';
								$list_childs1 = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE parent=".$list_cat->term_id);
								$rowCount1 = $wpdb->num_rows;
								if($rowCount1 > 0 && $count_catid < 2):
								foreach ($list_childs1 as $list_child1){
									$term1 = get_term ($list_child1->term_id, $tax_name);
									$html .= '<li>';
									if(!empty($term1)){
									$html .= '<a name="'.$plugin_id.'" alt="'.$list_child1->term_id.'" class="b-vertical" href="#">'.$term1->name.'</a>';
									}
									$html .= b_get_menu_vertical_taxonomy($custom_post, $tax_name, $list_child1->term_id, $style, $plugin_id, $image_size, $linkable);
									$html .= '</li>';
									$list_childs2 = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE parent=".$list_child1->term_id);
									$rowCount2 = $wpdb->num_rows;
									if($rowCount2 > 0):
									foreach ($list_childs2 as $list_child2){
										$term2 = get_term ($list_child2->term_id, $tax_name);
										$html .= '<li>';
										if(!empty($term2)){
										$html .= '<a name="'.$plugin_id.'" alt="'.$list_child2->term_id.'" class="b-vertical" href="#">'.$term2->name.'</a>';
										}
										$html .= b_get_menu_vertical_taxonomy($custom_post, $tax_name, $list_child2->term_id, $style, $plugin_id, $image_size, $linkable);
										$html .= '</li>';
										$list_childs3 = $wpdb->get_results("SELECT term_id FROM ".$table_cat." WHERE parent=".$list_child2->term_id);
										$rowCount3 = $wpdb->num_rows;
										if($rowCount3 > 0):
											foreach ($list_childs3 as $list_child3){
												$term3 = get_term ($list_child3->term_id, $tax_name);
												$html .= '<li>';
												if(!empty($term3)){
												$html .= '<a name="'.$plugin_id.'" alt="'.$list_child3->term_id.'" class="b-vertical" href="#">'.$term3->name.'</a>';
												}
												$html .= b_get_menu_vertical_taxonomy($custom_post, $tax_name, $list_child3->term_id, $style, $plugin_id, $image_size, $linkable);
												$html .= '</li>';
											}
										endif;
									}
									endif;
								}
								endif;
							}
						}
						else 
						{
							$html .= "<p class='warring_message'>".__("This is a friendly notice to inform that you have no child category in this selected category. To remove it, please see ", "b_category_slider")."<a href='link_FAQs'>here</a></p>";
						}
					}
				}
			}
		}
		else {
			if(!empty($list_tags)){
				$array_tags = explode(",", trim($list_tags," "));
				foreach ($array_tags as $value){
					$html .= '<li>';
					$html .= '<a name="'.$plugin_id.'" alt="'.$value.'" class="b-vertical" href="#">'.b_GetTagName($value).'</a>';
					$showtag = new WP_Query('tag='.$value);
					if($showtag->have_posts()){
						$html .= '<div class="b-flexslider-mobie"><div class="b-flexslider"><ul class="slides b-slider-mobie">';
						while($showtag->have_posts()): $showtag->the_post();
							b_show_posts_mobile($style, $plugin_id, $image_size, $linkable);
						endwhile; wp_reset_postdata();
						$html .= '</ul></div></div>';
					}
					else {
						$html .= __("<div class='b-flexslider-mobie'><p class='b-no-articles'>No articles in this tag</p></div>", "b_category_slider");
					}
					$html .= '</li>';
				}
			} else {
				$posttags = get_tags('orderby=term_id&order=DESC');
				if ($posttags) {
				  foreach($posttags as $tag) {
					$html .= '<li>';
					$html .= '<a name="'.$plugin_id.'" alt="'.$tag->slug.'" class="b-vertical" href="#">'.$tag->name.'</a>';
					$showtag = new WP_Query('tag='.$tag->slug);
					if($showtag->have_posts()){
						$html .= '<div class="b-flexslider-mobie"><div class="b-flexslider"><ul class="slides b-slider-mobie">';
						while($showtag->have_posts()): $showtag->the_post();
							b_show_posts_mobile($style, $plugin_id, $image_size, $linkable);
						endwhile; wp_reset_postdata();
						$html .= '</ul></div></div>';
					}
					else {
						$html .= __("<div class='b-flexslider-mobie'><p class='b-no-articles'>No articles in this tag</p></div>", "b_category_slider");
					}
					$html .= '</li>';
				  }
				}
			}
		}
		
		return $html;
	}
}


/*Function Load  Posts Ajax*/
if(!function_exists('b_ajax_load_posts')){
	function b_ajax_load_posts(){
		global $post;
		$auto_slide = $_POST['auto_slide'];
		$type = $_POST['type']; 
		$tax_name = $_POST['tax_name']; 
		$custom_post = $_POST['custom_post'];
		$per_page = $_POST['per_page'];  
		$columns = $_POST['columns'];  
		$style = $_POST['style'];  
		$cat_id = $_POST['cat_id'];
		$cat_id = str_replace(" ", "", $cat_id);
		$order = $_POST['order'];
		$order_by = $_POST['order_by'];
		$control_nav = $_POST['control_nav'];
		$plugin_id = $_POST['plugin_id'];
		$image_size = $_POST['image_size'];
		$linkable = $_POST['linkable'];
		$_b_device_ = $_POST['b_device'];
		
		if($auto_slide == 'yes'){$auto = 'slideshow: true';} else {$auto = 'slideshow: false';}
		if($type == "tag"){
			$args = array(
				'tag'  => $cat_id
			);
		}
		else if($type == "taxonomy"){
			if(!empty($tax_name) && !empty($custom_post)){
				if(empty($cat_id)){
					$args = array(
						'post_type' => $custom_post
					);
				}
				else if(is_numeric($cat_id)){
					$args = array(
							'post_type' => $custom_post,
							'tax_query' => array(
								array(
									'taxonomy' => $tax_name,
									'terms'	   => $cat_id
								)
							 )
					);
				}
				else {
					$b_term = get_term_by('slug', $cat_id, $tax_name);
					$b_term_id = $b_term->term_id;
					$args = array(
							'post_type' => $custom_post,
							'tax_query' => array(
								array(
									'taxonomy' => $tax_name,
									'terms'	   => $b_term_id
								)
							 )
					);
				}
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
				$cate_id = (!empty($cat_obj)) ? $cat_obj->term_id : '';
				$args = array(
						'post_type' => 'post',
						'cat'		=> $cate_id
				);
			}
		}
		//Check oderby date or views
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
			echo "<div class='b-flexslider' data-control-nav='".$control_nav."' data-autoslide='".$auto_slide."'><ul class='slides'><li class='b-li-child-flex'><div class='row'>";
			$i = 0;
			while ($query->have_posts()): $query->the_post();
			$url_thumb = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
			if(($i > 0) && (($i%$per_page)==0) &&($post_num > $per_page)):
				echo "</div></li><li class='b-li-child-flex'><div class='row'>";
			endif;
			?>
				<?php echo b_show_posts_by_style($style, $columns, $plugin_id, $image_size, $linkable, $_b_device_);?>
			<?php
			$i++;
			endwhile; wp_reset_postdata();
			echo "</div></li></ul></div>";
			?>
			<script language="javascript">
				(function($){
					$(".b-plugins-category .b-flexslider").each(function(){
						var autoslide = $(this).attr("data-autoslide");
						var control_show = $(this).attr("data-control-nav");
						var slideSpeed = $(this).attr("data-slideshowspeed");
						if(autoslide === 'true'){ autoshow = true; }else { autoshow = false; }
						if(control_show === 'on'){ control_nav = true; }else{ control_nav = false;}
						$(this).flexslider({
							slideshow: autoshow,
							animation: "slide",
							controlNav: control_nav,
							slideshowSpeed: slideSpeed,
							prevText: "",
							nextText: ""
						});
					});
					$("a[rel^='prettyPhoto']").prettyPhoto();
					$('.b-box').hoverDirection();
					$('.b-box .b-inner').on('animationend', function (event) {
					var $box = $(this).parent();
					$box.filter('[class*="-leave-"]').hoverDirection('removeClass');
					});
				})(jQuery);
			</script>
		<?php
		} 
		else {
			echo __("<strong id='b-message-no-article'>No Article in this category</strong>", "b_category_slider");
		}
		die();
	}
}
add_action('wp_ajax_b_ajax_load_posts', 'b_ajax_load_posts');
add_action('wp_ajax_nopriv_b_ajax_load_posts', 'b_ajax_load_posts');
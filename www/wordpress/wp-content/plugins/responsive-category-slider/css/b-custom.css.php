<?php
/**
 * @package   Responsive Category Slider
 * @author     ThemeLead Team <support@themelead.com>
 * @copyright  Copyright 2014 themelead.com. All Rights Reserved.
 * @license    GPLv2 or later - http://www.gnu.org/licenses/gpl-2.0.html
 * Websites: http://www.themelead.com
 * Technical Support:  Free Forum Support - http://support.themelead.com
 */
 
//Load wp-load.php
$absolute_path = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
$wp_load = $absolute_path[0] . 'wp-load.php';
require_once($wp_load);

header('Content-type: text/css; charset: UTF-8');
header('Cache-control: must-revalidate');

/* Convert hexdec color string to rgb color*/
if(!function_exists('b_hex_to_rgb')){
	function b_hex_to_rgb( $colour ) {
		if ( $colour[0] == '#' ) {
				$colour = substr( $colour, 1 );
		}
		if ( strlen( $colour ) == 6 ) {
				list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
		} elseif ( strlen( $colour ) == 3 ) {
				list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
		} else {
				return false;
		}
		$r = hexdec( $r );
		$g = hexdec( $g );
		$b = hexdec( $b );
		return array( 'red' => $r, 'green' => $g, 'blue' => $b );
	}
}

//Get data custom
global $wpdb;
$table_name = $wpdb->prefix . 'b_responsive_category_slider';
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
$data_hover_thumnail = $data->hover_thumnail;
$data_theme_style = $data->theme_style;

if($background_color_hover != null){
	$array_hex = b_hex_to_rgb($background_color_hover);
	$background_color_hover_rgba = "rgba(".$array_hex['red'].", ".$array_hex['green'].", ".$array_hex['blue'].", 0.8)";
	$background_color_hover_rgba_style = "rgba(".$array_hex['red'].", ".$array_hex['green'].", ".$array_hex['blue'].", 0.5)";
}


//Check data and set custom css
if($data_background != null):
?>
	<?php if($data_theme_style != 'fourteen'){?>
	#b-plugins-view{background-color: <?php echo $data_background;?>}
	<?php } else { ?>
	#b-plugins-view .b-plugins-view-in{background-color: <?php echo $data_background;?>}
	<?php }?>
	<?php if($data_theme_style != 'fourteen'): ?>
	#b-plugins-view .flex-control-nav{background-color: <?php echo $data_background;?>}
	<?php endif;?>
	.b-plugins-category ul.slides{background: none;}
<?php 
endif;

if($data_background_img != null):
?>
	<?php if($data_theme_style != 'fourteen'){?>
	#b-plugins-view{background-image: url('<?php echo $data_background_img;?>');}
	<?php } else { ?>
	#b-plugins-view .b-plugins-view-in{background-image: url('<?php echo $data_background_img;?>');}
	<?php }?>
	.b-plugins-category ul.slides{background: none;}
<?php 
endif;

if($data_background_repeat != null):
?>
	#b-plugins-view{background-repeat: <?php echo $data_background_repeat;?>}
<?php 
endif;

if($data_width_ver != null):
?>
	.b-plugins-view-in .b-menu-categories{width: <?php echo $data_width_ver;?>px;}
	.b-plugins-category.b-vertical .b-plugins-view-in .b-flexslider-posts{margin-left: <?php echo ($data_width_ver + 10);?>px;}
	.b-plugins-category.b-vertical .flex-direction-nav .flex-prev{left: <?php echo ($data_width_ver - 50 + 10);?>px;}
	.b-plugins-category.b-vertical .b-flexslider:hover .flex-prev{left: <?php echo ($data_width_ver + 2 + 10);?>px;}
	.b-plugins-category.no_padding .b-plugins-view-in .b-menu-categories{width: <?php echo ($data_width_ver +10);?>px;}
	.b-plugins-category.b-vertical #b-ajax-loaded-posts{margin-left: <?php echo (($data_width_ver/2) - 15 + 5);?>px;}
<?php	
endif;

if($data_border == 'no'):
?>
	#b-plugins-view{border: none;}
<?php	
endif;

if($data_border_color != null && $data_border != 'no'):
?>
	#b-plugins-view .flex-control-nav, #b-plugins-view{border: 1px solid <?php echo $data_border_color;?>;}
<?php	
endif;

if($data_menu_color != null):
?>
	.b-plugins-category a.b-parent.b-home-parent, .b-plugins-category .b-menu-horizontal .b-menu-category li, .b-plugins-category .b-menu-horizontal .b-menu-category li a, .b-plugins-category ul.b-menu-category >li a{color: <?php echo $data_menu_color;?> !important;}
<?php	
endif;

if($data_hover_color != null):
?>
	.b-plugins-category a.b-parent.b-home-parent:hover, .b-plugins-category a.b-parent.b-home-parent.b-menu-active{color: <?php echo $data_hover_color;?> !important;}
	.b-plugins-category .b-menu-horizontal .b-menu-category li a:hover, .b-plugins-category ul.b-menu-category >li a:hover, ul.b-menu-category >li a.b-menu-active{color: <?php echo $data_hover_color;?> !important;}
	.b-plugins-category ul.b-menu-category >li a:before{border-bottom: 1px solid <?php echo $data_hover_color;?>;}
	.b-plugins-category .b-menu-horizontal .b-menu-category li:hover >a, .b-plugins-category .b-menu-horizontal .b-menu-category li:hover, .b-plugins-category .b-menu-horizontal .b-menu-category li.b-hori-menu-active, .b-plugins-category .b-menu-horizontal .b-menu-category li:hover >i, .b-plugins-category .b-menu-horizontal .b-menu-category li.b-hori-menu-active >i{color: <?php echo $data_hover_color;?> !important;}
	.b-slider-thumbnail .b-face-post{background: <?php echo $data_hover_color;?>;}
<?php 
endif;

if($background_color_hover != null):
?>
	.b-themelead-style .b-face-post-bg {background: <?php echo $background_color_hover_rgba;?>;}
	.b-gallery-style .b-slider-thumbnail .b-face-post{background: <?php echo $background_color_hover_rgba_style;?>;}
	.b-events-style .b-slider-thumbnail .b-face-post{background: <?php echo $background_color_hover_rgba_style;?>;}
	
<?php endif;

if($data_hover_thumnail == 'yes'):
?>
	.b-slider-thumbnail img{-webkit-filter: brightness(1); -moz-filter: brightness(1); -ms-filter: brightness(1); -o-filter: brightness(1); filter: brightness(1);}
	.b-themelead-style .b-face-post-bg, .b-gallery-style .b-slider-thumbnail .b-face-post, .b-events-style .b-slider-thumbnail .b-face-post{display: none !important;}
	.b-post-style .b-slider-thumbnail:hover .b-face-post{display: none;}
	.b-plugins-category .b-flexslider .slides .b-post-style .b-slider-thumbnail:hover >a >img, .b-plugins-category .b-flexslider .slides .b-product-style .b-slider-thumbnail:hover >a >img{-webkit-transform: none; -webkit-transition-timing-function: none; -moz-transform: none; -moz-transition-timing-function: none; transform: none;}
	.b-latest-news .b-latest-news-item >.b-mirror, .b-latest-news .b-latest-news-item:hover > .b-mirror{top: 100%; display: none;}
	.b-latest-news .b-latest-news-item:hover > .b-description{right: 0;}
<?php	
endif;
?>
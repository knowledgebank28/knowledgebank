<?php
/**
 * @package WP Theme Customizer
 */
/*
Plugin Name: WP Theme Customizer
Plugin URI: http://www.phpbaba.com/wp-theme-customizer
Description: Supercharge your <strong>Wrdpress Theme</strong> with WP Theme Customizer.Give your wordpress theme a premium look. To get started: Click the "Activate" link to the left, and Go to configuration page. Happy Blogging!...
Version: 1.0
Author: phpbaba
Author URI: http://www.phpbaba.com
*/

if( !defined('wptc_version') ) 
	define('WPTC_VERSION', 1.0);

if( !defined('WPTC_DIR') )
	define( 'WPTC_DIR', plugin_dir_path( __FILE__ ) );

if( !defined('WPTC_URL') )
	define( 'WPTC_URL', plugin_dir_url( __FILE__ ) );

//Displays Settings link after plugin activation

function display_settings_link($links = array()) {

	$settings_link = '<a href="' . admin_url('admin.php?page=wptc_theme_customizer') . '">' . __('Settings', 'wp-theme-customizer') . '</a>'; 
	
	array_unshift($links, $settings_link);
	
	return $links;
}

$plugin = plugin_basename(__FILE__); 

add_filter("plugin_action_links_$plugin", 'display_settings_link', 10, 1);

//end Displays Settings link


/*---------------------------Retrieve Information-----------------------------------*/

$wptc_op_cg = get_option('wptc_colors_general');
	
$wptc_op_bg = get_option('wptc_backgrounds_general');

//Retrieve Effect

function wptc_retrieve_effect(){
		
	$wptc_option = get_option('wptc_effect');

	if( isset ( $_COOKIE['wptc_effect']  ) ){
	
		$effect = $_COOKIE['wptc_effect'];
		
	}else if( isset( $wptc_option )  ){
	
		$effect = $wptc_option;
		
	}else{
	
		$effect = 'normal_effect';
		
	}
	
	return $effect;
		
}// end wptc_retrieve_effect


function wptc_retrieve_color(){
	
	$wptc_option = get_option('wptc_color');

	if( isset ( $_COOKIE['wptc_color']  ) ){
	
		$color = $_COOKIE['wptc_color'];
		
	}else if( isset( $wptc_option ) && !empty($wptc_option) ){
	
		$color = $wptc_option;
		
	}else{
	
		$color = '';
		
	}
	
	return $color;
	
}//end wptc_retrieve_color()


function wptc_retrieve_button_color(){
	
	$wptc_option = get_option('wptc_button_color');

	if( isset ( $_COOKIE['wptc_button_color']  ) ){
	
		$color = $_COOKIE['wptc_button_color'];
		
	}else if( isset( $wptc_option  ) && !empty($wptc_option) ){
	
		$color = $wptc_option;
		
	}else{
	
		$color = '';
		
	}
	
	return $color;
	
}//end wptc_retrieve_button_color()


function wptc_retrieve_body_bg(){
	
	$wptc_option = get_option('wptc_body_bg');

	if( isset ( $_COOKIE['wptc_body_bg'] ) ){
	
		$image = $_COOKIE['wptc_body_bg'];
		
	}else if( isset( $wptc_option )  && !empty( $wptc_option ) && $wptc_option != ''  ){
	
		$image = $wptc_option;
		
	}else{
	
		$image = '';
		
	}
	
	return $image;
	
}//end wptc_retrieve_body_bg()


function wptc_retrieve_bg_attachment(){
	
	global $wptc_op_bg;
	
	$bg_attachment = $wptc_op_bg['background_attachment'];

	if( isset( $bg_attachment ) ){ 
							
		if($bg_attachment == 1){
		
			$attachment = 'background-attachment: fixed;';
			
		}else{
			
			$attachment = 'background-attachment: scroll;';
			
		}

	}else{
	
		$attachment = 'background-attachment: scroll;';
		
	}
	
	return $attachment;
	
}//end wptc_retrieve_bg_attachment()


function wptc_retrieve_bg_position(){
	
	global $wptc_op_bg;
	
	$bg_pos = $wptc_op_bg['background_position'];

	if( isset ( $bg_pos )  ){
	
		if($bg_pos == 1){
		
			$pos = 'background-position: top left;';
		
		}else if($bg_pos == 2){
		
			$pos = 'background-position: top center;';
		
		}else if($bg_pos == 3){
		
			$pos = 'background-position: top right;';
		
		}else{
		
			$pos = 'background-position: top left;';
		
		}
		
	}else{
	
		$pos = 'background-position: top left;';
	
	}
	
	return $pos;
	
}//end wptc_retrieve_bg_position()


function wptc_retrieve_bg_repeat(){
	
	global $wptc_op_bg;
	
	$bg_type = get_option('wptc_bg_type');
	
	$bg_repeat = $wptc_op_bg['background_repeat'];
	
	if($bg_type == 'pattern'){
		
		$repeat = 'background-repeat: repeat;';
		
	}else if( $bg_type == 'image' ) {
	
		if( isset ( $bg_repeat )  ){
		
			if($bg_repeat == 1){
			
				$repeat = 'background-repeat: no-repeat;';
			
			}else if($bg_repeat == 2){
			
				$repeat = 'background-repeat: repeat;';
			
			}else if($bg_repeat == 3){
			
				$repeat = 'background-repeat: repeat-x;';
			
			}else if($bg_repeat == 4){
			
				$repeat = 'background-repeat: repeat-y;';
			
			}else{
			
				$repeat = 'background-repeat: repeat;';
			
			}
			
		}else{
			
			$repeat = 'background-repeat: repeat;';
			
		}
	
	}else{
	
		$repeat = 'background-repeat: repeat;';
	
	}

	
	return $repeat;
	
}//end wptc_retrieve_bg_repeat()

/*---------------------------end Retrieve Information-----------------------------------*/

//Insert CSS Styles in wp_head

add_action('wp_head', 'wptc_styles', 9999999999);

function wptc_styles(){

	global $wptc_op_cg;
	
	
?>
	<style type="text/css" id="wptc_styles">
	
		
		
		body, body.custom-background{
		
			<?php
				
					$image = wptc_retrieve_body_bg();
					
					if( $image != '' && !empty($image) ){
					
						echo 'background-image: url('.$image.');';
					
					}
				
				
			?>
			
			<?php echo wptc_retrieve_bg_attachment(); ?>
			
			<?php echo wptc_retrieve_bg_position(); ?>
			
			<?php echo wptc_retrieve_bg_repeat(); ?>
		
			<?php  if( isset( $wptc_op_cg['change_body_color'] ) && $wptc_op_cg['change_body_color'] == 1 ){ ?>
			
			<?php
			
				$color = wptc_retrieve_color();
				
				if( $color != '' && !empty($color) ){
				
					echo 'background-color: '.$color.';';
					
				}
			
			?>
			
			<?php } ?>
		}
		
		button, input[type="submit"], input[type="button"], input[type="reset"]{
			<?php  if( isset( $wptc_op_cg['change_buttons_color'] ) && $wptc_op_cg['change_buttons_color'] == 1 ){ ?>
			
				<?php
			
				$button_color = wptc_retrieve_color();
				
				if( $button_color != '' && !empty($button_color) ){
				
					echo 'background-color: '.$button_color.';';
					
				}
			
				?>
				
				<?php
			
				$color = wptc_retrieve_button_color();
				
				if( $color != '' && !empty($color) ){
				
					echo 'color: '.$color.';';
					
				}
			
				?>
				
				<?php if( !empty( $button_color ) && $button_color != '' ){
				?>
					
					background-image: url(<?php echo plugins_url( 'assets/button.png' , __FILE__  ) ?>);
					
					background-repeat: repeat-x;
					
					border: 1px solid #aaa;
					
					opacity: 1;
				
				<?php
				}
				?>
			
			<?php } ?>
		}
		
		button:hover, input[type="submit"]:hover, input[type="button"]:hover, input[type="reset"]:hover{
			<?php  if( isset( $wptc_op_cg['change_buttons_color'] ) && $wptc_op_cg['change_buttons_color'] == 1 ){ ?>
			
				<?php
			
				$button_color = wptc_retrieve_color();
				
				if( $button_color != '' && !empty($button_color) ){
				
					echo 'background-color: '.$button_color.';';
					
				}
			
				?>
				
				<?php
			
				$color = wptc_retrieve_button_color();
				
				if( $color != '' && !empty($color) ){
				
					echo 'color: '.$color.';';
					
				}
			
				?>
				
				<?php if( !empty( $button_color) && $button_color != '' ){
				?>
					
					background-image: url(<?php echo plugins_url( 'assets/button.png' , __FILE__  ) ?>);
					
					background-repeat: repeat-x;
					
					border: 1px solid #aaa;
					
					opacity: 0.9;
				
				<?php
				}
				?>
			
			<?php } ?>
		}
		
		button:active, input[type="submit"]:active, input[type="button"]:active, input[type="reset"]:active{
			<?php  if( isset( $wptc_op_cg['change_buttons_color'] ) && $wptc_op_cg['change_buttons_color'] == 1 ){ ?>
			
				<?php
			
				$button_color = wptc_retrieve_color();
				
				if( $button_color != '' && !empty($button_color) ){
				
					echo 'background-color: '.$button_color.';';
					
				}
			
				?>
				
				<?php
			
				$color = wptc_retrieve_button_color();
				
				if( $color != '' && !empty($color) ){
				
					echo 'color: '.$color.';';
					
				}
			
				?>
				
				<?php if( !empty( $button_color ) && $button_color != '' ){
				?>
					
					background-image: url(<?php echo plugins_url( 'assets/button.png' , __FILE__  ) ?>);
					
					background-repeat: repeat-x;
					
					border: 1px solid #aaa;
					
					opacity: 0.9;
				
				<?php
				}
				?>
			
			<?php } ?>
		}
		
		.post a, .type-post a, .type-page a{
			<?php  if( isset( $wptc_op_cg['change_links_color'] ) && $wptc_op_cg['change_links_color'] == 1 ){ ?>
			
				<?php
			
				$color = wptc_retrieve_color();
				
				if( $color != '' && !empty($color) ){
				
					echo 'color: '.$color.';';
					
				}
			
				?>
			
			<?php } ?>
		}
		
		.post a:hover, .type-post a:hover, .type-page a:hover{
			<?php  if( isset( $wptc_op_cg['change_links_color'] ) && $wptc_op_cg['change_links_color'] == 1 ){ ?>
			
				<?php
			
				$color = wptc_retrieve_color();
				
				if( $color != '' && !empty($color) ){
				
					echo 'color: '.$color.';';
					
				}
			
				?>
				
				opacity: 0.8;
			
			<?php } ?>
		}
		
		.post h1,.post h2,.post h3,.post h4,.post h5,.post h6,
		.type-post h1,.type-post h2,.type-post h3,.type-post h4,.type-post h5,.type-post h6,
		.type-page h1,.type-page h2,.type-page h3,.type-page h4,.type-page h5,.type-page h6{
			<?php  if( isset( $wptc_op_cg['change_headings_color'] ) && $wptc_op_cg['change_headings_color'] == 1 ){ ?>
			
				<?php
			
				$color = wptc_retrieve_color();
				
				if( $color != '' && !empty($color) ){
				
					echo 'color: '.$color.';';
					
				}
			
				?>
			
			<?php } ?>
		}
		
		.wptc_this_color{
		
			<?php
			
			$color = wptc_retrieve_color();
			
			if( $color != '' && !empty($color) ){
			
				echo 'color: '.$color.';';
				
			}
		
			?>
			
		}
		
		.wptc_this_bg{
		
			<?php
			
				$color = wptc_retrieve_color();
				
				if( $color != '' && !empty($color) ){
				
					echo 'background-color: '.$color.';';
					
				}
			
			?>
			
		}
		

	</style>
	
	<?php
}// end inserting wptc styles


//Insert code in wp_footer

add_action('wp_footer', 'insert_wptc_code', 999999999);

function insert_wptc_code(){

	global $wptc_op_cg;
	
	$effect = wptc_retrieve_effect();
	
	?>
	
		<script type="text/javascript">
		
		jQuery(document).ready(function(){
		
			// Body Configuration
			
				var image = '<?php echo wptc_retrieve_body_bg();?>';
				
				if( image != '' ){

					jQuery('body').css( 'background-image', 'url('+image+')' );
				
				}
			
			<?php  if( isset( $wptc_op_cg['change_body_color'] ) && $wptc_op_cg['change_body_color'] == 1 ){ ?>
			
				var color = '<?php echo wptc_retrieve_color();?>';
				
				if( color != '' ){
				
					jQuery('body').css( 'background-color', color );
					
				}
			
			<?php } ?>
			
			//end Body Configuration
			
			// Button Configuration
			
			<?php  if( isset( $wptc_op_cg['change_buttons_color'] ) && $wptc_op_cg['change_buttons_color'] == 1 ){ ?>
			
				var button_color = '<?php echo wptc_retrieve_color(); ?>';
				
				var button_text = '<?php echo wptc_retrieve_button_color();?>';
				
				if( button_color != '' ){

					jQuery('button, input[type="submit"], input[type="button"], input[type="reset"]').css({'background-color':button_color, 'background-image': 'url(<?php echo plugins_url( 'assets/button.png' , __FILE__  ) ?>)', 'background-repeat': 'repeat-x', 'border': '1px solid #aaa' });
					
				}
				
				if( button_text != '' ){

					jQuery('button, input[type="submit"], input[type="button"], input[type="reset"]').not('.wptc_button_font_preview').css({'color':button_text});
					
				}
			
			<?php } ?>
			
			//end Button Configuration
			
			//Headings and Links Color Configuration
			
			<?php  if( isset( $wptc_op_cg['change_links_color'] ) && $wptc_op_cg['change_links_color'] == 1 ){ ?>
			
				var color = '<?php echo wptc_retrieve_color();?>';
				
				if( color != '' ){
				
					jQuery('.post a, .type-post a, .type-page a').css({'color':color});
					
				}
			
			<?php } ?>
			
			<?php  if( isset( $wptc_op_cg['change_headings_color'] ) && $wptc_op_cg['change_headings_color'] == 1 ){ ?>
										
				var color = '<?php echo wptc_retrieve_color();?>';
				
				if( color != '' ){
				
						jQuery('.post :header,.type-post :header ,.type-page :header ').css({'color':color});
					
				}
										
			<?php } ?>
			
			//end Headings and Links Color Configuration
			
			<?php
			
			if( $effect == 'snow_effect' ){
			
			?>
			
				jQuery(document).snowfall({
					flakeCount : 150,
					flakeColor : '#fefefe',
					flakeIndex: 999999,
					minSize : 3,
					maxSize : 5,
					minSpeed : 3,
					maxSpeed : 4,
					round : true,
					shadow : false
				});
			
			<?php
			
			}elseif($effect == 'rain_effect'){
			
			?>
			
				jQuery(document).snowfall({
					flakeCount : 400,
					flakeColor : '#186c81',
					flakeIndex: 999999,
					minSize : 2,
					maxSize : 2.5,
					minSpeed : 18,
					maxSpeed : 20,
					round : true,
					shadow : false
				});
			
			<?php
			
			}
			
			?>
		
		
		});
		
		
		</script>
	
	<?php

}//end insert_wptc_code


require_once( WPTC_DIR . 'includes/module/module.php' );

require_once( WPTC_DIR . 'includes/admin/admin_options.php' );


	
?>

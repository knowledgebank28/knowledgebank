<?php
/**
 * @package WP Theme Customizer
 */
/*
Options Updater
*/

$root = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))));

require_once($root.'/wp-load.php');

$wptc_op_g = get_option('wptc_general_options');

if( $wptc_op_g['display_module'] == 1 ){

	$success = __('Settings saved.', 'wp-theme-customizer');

	if( is_user_logged_in() && current_user_can('manage_options') ){
	
		
		if( isset( $_POST['wptc_effect'] ) ){
		
			$effect = strip_tags( stripslashes( $_POST['wptc_effect'] ) ); 
			
			if( $effect == 'normal_effect' || $effect == 'snow_effect' || $effect == 'rain_effect' ){
			
				if( update_option( 'wptc_effect', $effect ) ){
				
					echo $success;
				
				}
			
			}
			
		}

		if( isset($_POST['wptc_color'] ) ){

			$color_now = strip_tags( stripslashes( $_POST['wptc_color'] ) ); 
			
			$comb1 = '/^#+[A-Fa-f0-9]{3}$/';
			$comb2 = '/^#+[A-Fa-f0-9]{6}$/';
					
			if( preg_match( $comb1, $color_now ) || preg_match( $comb2, $color_now ) ){
			
				if( update_option( 'wptc_color', $color_now ) ){
				
					echo $success;
				
				}
			}
		}
		
		if( isset($_POST['wptc_button_color'] ) ){

			$color_now =  strip_tags( stripslashes( $_POST['wptc_button_color'] ) );
			
			$comb1 = '/^#+[A-Fa-f0-9]{3}$/';
			$comb2 = '/^#+[A-Fa-f0-9]{6}$/';
					
			if( preg_match( $comb1, $color_now ) || preg_match( $comb2, $color_now ) ){
			
				if( update_option( 'wptc_button_color', $color_now ) ){
				
					echo $success;
				
				}
			}
		}
		
		if( isset( $_POST['wptc_body_bg'] ) && isset( $_POST['wptc_bg_type'] ) ){
		
			$image = esc_url_raw( strip_tags( stripslashes( $_POST['wptc_body_bg'] ) ) );
			
			$bg_type = strip_tags( stripslashes( $_POST['wptc_bg_type'] ) );
			
			$c_bg_type = get_option('wptc_bg_type');
			
			if( update_option( 'wptc_body_bg', $image ) ){
			
				if ( $c_bg_type == $bg_type ){
				
					echo $success;
				
				}else{
				
					if( update_option( 'wptc_bg_type', $bg_type ) ){
			
						echo $success;
					
					}else{
					
						echo $success;
					
					}
				
				}
			
			}
		}
		
	}else{
	
		wp_die( __( 'You are not allowd to do this...', '' ) );
		
	}
}

?>
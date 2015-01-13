<?php
/**
 * @package WP Theme Customizer
 */
/*
Sanitize
*/

function wptc_validate_general_options( $input ) {

		$output = array();
		
		foreach( $input as $key => $value ) {
			
			if( isset( $input[$key] ) ) {
			
				$output[$key] = strip_tags( stripslashes( $input[ $key ] ) );
				
				if(is_numeric($output[$key])){
				
					$output[$key];
					
						if( $output[$key] == 1 || $output[$key] == 2 ){
						
							$output[$key];
							
						}else{
						
						$output[$key] = 2;
						
						}
				}
				
			} // end if
			
		} // end foreach
		
		return apply_filters( 'wptc_validate_general_options', $output, $input );

} // end wptc_validate_general_options()

function wptc_validate_general_background_options( $input ) {

		$output = array();
		
		foreach( $input as $key => $value ) {
			
			if( isset( $input[$key] ) ) {
			
				$output[$key] = strip_tags( stripslashes( $input[ $key ] ) );
				
				if(is_numeric($output[$key])){
				
					$output[$key];
					
						if( $output[$key] == 1 || $output[$key] == 2  || $output[$key] == 3  || $output[$key] == 4 ){
						
							$output[$key];
							
						}else{
						
						$output[$key] = 2;
						
						}
				}
				
			} // end if
			
		} // end foreach
		
		return apply_filters( 'wptc_validate_general_options', $output, $input );

} // end wptc_validate_general_background_options()

function wptc_validate_general_single( $input ) {
	
	if( isset( $input ) ) {
			
		// Strip all HTML and PHP tags and properly handle quoted strings
		$output = strip_tags( stripslashes( $input ) );
		
		if(is_numeric($output)){
		
			$output;
			
				if( $output == 1 || $output == 2 ){
				
					$output;
					
				}else{
				
				$output = 2;
				
				}
		}else{
		
			$output = 2;
			
		}
				
	}
	
	return $output;

} // end wptc_validate_general_single()

function wptc_validate_module_skin( $input ) {

			if( isset( $input ) ) {
			
				$output = strip_tags( stripslashes( $input ) );
				
				$wptc_skins = array('modern-black','modern-white','black','white'); 
				
				if( in_array( $output, $wptc_skins ) ){
				
					$output;
					
				}else{
				
					$output = 'modern-black';
					
				}
				
			} 
			
	return $output;
	
} // end wptc_validate_skin


function wptc_validate_num( $input ) {
	
	if( isset( $input ) ) {
			
		// Strip all HTML and PHP tags and properly handle quoted strings
		
		$output = strip_tags( stripslashes( $input ) );
		
		if( is_numeric($output) ){
		
			$output;

		}else{
		
			$output = 5;
		
		}
				
	}
	
	return $output;

} // end wptc_validate_num_of_colors()

function wptc_validate_color( $input ) {
	
			
			if( isset( $input ) ) {
			
				$output = strip_tags( stripslashes( $input ) );
				
				$comb1 = '/^#+[A-Fa-f0-9]{3}$/';
				$comb2 = '/^#+[A-Fa-f0-9]{6}$/';
				
				if( preg_match( $comb1, $output ) || preg_match( $comb2, $output ) ){
				
					$output;
					
				}else{
				
					$output = '#edeee1';
				}
				
			} // end if
			
	return $output;
} // end wptc_validate_color()

function wptc_validate_image( $input ) {

	
		if( isset ( $input ) ) {
		
			$output = esc_url_raw( strip_tags( stripslashes( $input ) ) );
			
		} 
	
	
	return $output;

} // end wptc_validate_image()

function wptc_validate_mode( $input ) {

	
		if( isset ( $input ) ) {
		
			$output = strip_tags( stripslashes( $input ) );
			
		}
		
		if($output == 'day_night' || $output == 'normal_mode' ){
			
				$output;
			
		}else{
		
			$output = '';
		
		}
	
	
	return $output;

} // end wptc_validate_mode()
		

?>
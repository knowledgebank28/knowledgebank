<?php
/**
 * @package WP Theme Customizer
 */
/*
Admin Backgrounds Options
*/

/** ----------------------------------------------------------------------- *
 * 	Provides default values.
 *  ----------------------------------------------------------------------- */

function wptc_backgrounds_general_default() {
	
	$defaults = array(
			'display_images_section'	=>	'1',
			'display_patterns_section'	=>	'1',
			'background_attachment'		=>	'1',
			'background_position'		=>	'1',
			'background_repeat'			=>	'2'
	);
	
	return apply_filters( 'wptc_backgrounds_general_default', $defaults );
	
} // end wptc_backgrounds_general_default()


/* ------------------------------------------------------------------------ *
 * Settings Registration
 * ------------------------------------------------------------------------ */ 

function wptc_initialize_backgrounds_options() {

	if( false == get_option( 'wptc_backgrounds_general' ) ) {	
	
		add_option( 'wptc_backgrounds_general', apply_filters( 'wptc_backgrounds_general_default', wptc_backgrounds_general_default() ) );
		
	} // end if
	
	/*Default BG Images and Patterns*/
	
	for($u = 1; $u <= 5; $u++){
	
		if( false == get_option( 'wptc_bg_image_'.$u ) ) {	
		
			$linktoimage = plugins_url('images/bg-images/wptc_image'.$u.'.jpg', dirname(dirname(dirname(__FILE__))) );
	
			add_option( 'wptc_bg_image_'.$u, $linktoimage );
		
		}
		
	}
	
	for($u = 1; $u <= 5; $u++){
	
		if( false == get_option( 'wptc_bg_pattern_'.$u ) ) {	
		
			$linktoimage = plugins_url('images/bg-patterns/wptc_pattern'.$u.'.png', dirname(dirname(dirname(__FILE__))) );
	
			add_option( 'wptc_bg_pattern_'.$u, $linktoimage );
		
		}
		
	}
	
	/*end Default BG Images and Patterns*/

	/*----------------------------Number of Images Section---------------------------------------*/

	add_settings_section(
		'bg_images_settings_section',			// ID used to identify this section and with which to register options
		__( 'Backgrounds Settings', 'wp-theme-customizer'),// Title to be displayed on the administration page
		'wptc_backgrounds_general_section_callback',									// Callback used to render the description of the section
		'wptc_backgrounds_options'					// Page on which to add this section of options
	);
	
	add_settings_field(	
		'display_images_section',				// ID used to identify the field throughout the theme
		__( 'Display Images Section', 'wp-theme-customizer' ), // The label to the left of the option interface element
		'wptc_display_images_section_callback',	// The name of the function responsible for rendering the option interface
		'wptc_backgrounds_options',				// The page on which this option will be displayed
		'bg_images_settings_section',			// The name of the section to which this field belongs
		array(								// The array of arguments to pass to the callback. In this case, just a description.
			__( 'Display Background Images Section in module.', 'wp-theme-customizer' ),
		)
	);
	
	add_settings_field(	
		'display_patterns_section',				// ID used to identify the field throughout the theme
		__( 'Display Patterns Section', 'wp-theme-customizer' ), // The label to the left of the option interface element
		'wptc_display_patterns_section_callback',	// The name of the function responsible for rendering the option interface
		'wptc_backgrounds_options',				// The page on which this option will be displayed
		'bg_images_settings_section',			// The name of the section to which this field belongs
		array(								// The array of arguments to pass to the callback. In this case, just a description.
			__( 'Display Background Patterns Section in module.', 'wp-theme-customizer' ),
		)
	);
	
	add_settings_field(	
		'background_attachment',				// ID used to identify the field throughout the theme
		__( 'Background Attachment', 'wp-theme-customizer' ), // The label to the left of the option interface element
		'wptc_background_attachment_callback',	// The name of the function responsible for rendering the option interface
		'wptc_backgrounds_options',				// The page on which this option will be displayed
		'bg_images_settings_section',			// The name of the section to which this field belongs
		array(								// The array of arguments to pass to the callback. In this case, just a description.
			__( 'Select Background Attachment. It may be fixed or scroll.', 'wp-theme-customizer' ),
		)
	);
	
	add_settings_field(	
		'background_position',				// ID used to identify the field throughout the theme
		__( 'Background Position', 'wp-theme-customizer' ), // The label to the left of the option interface element
		'wptc_background_position_callback',	// The name of the function responsible for rendering the option interface
		'wptc_backgrounds_options',				// The page on which this option will be displayed
		'bg_images_settings_section',			// The name of the section to which this field belongs
		array(								// The array of arguments to pass to the callback. In this case, just a description.
			__( 'Select Background Position. It may be Left, Center or Right.', 'wp-theme-customizer' ),
		)
	);
	
	add_settings_field(	
		'background_repeat',				// ID used to identify the field throughout the theme
		__( 'Background Repeat', 'wp-theme-customizer' ), // The label to the left of the option interface element
		'wptc_background_repeat_callback',	// The name of the function responsible for rendering the option interface
		'wptc_backgrounds_options',				// The page on which this option will be displayed
		'bg_images_settings_section',			// The name of the section to which this field belongs
		array(								// The array of arguments to pass to the callback. In this case, just a description.
			__( 'Select either your background should be repeat or not.', 'wp-theme-customizer' ),
		)
	);
	
	/*----------------------------Background Images---------------------------------------*/

	add_settings_section(
		'bg_images_section',				// ID used to identify this section and with which to register options
		__( 'Backgrounds Images', 'wp-theme-customizer'),	// Title to be displayed on the administration page
		'wptc_bg_images_section_callback',					// Callback used to render the description of the section
		'wptc_backgrounds_options'			// Page on which to add this section of options
	);
	
	add_settings_field(	
		'wptc_bg_images',				// ID used to identify the field throughout the theme
		__( '', 'wp-theme-customizer' ), // The label to the left of the option interface element
		'wptc_bg_images_callback',	// The name of the function responsible for rendering the option interface
		'wptc_backgrounds_options',				// The page on which this option will be displayed
		'bg_images_section',			// The name of the section to which this field belongs
		array(								// The array of arguments to pass to the callback. In this case, just a description.
			__( 'Background Images', 'wp-theme-customizer' ),
		)
	);
	
	add_settings_section(
		'bg_patterns_section',				// ID used to identify this section and with which to register options
		__( 'Backgrounds Patterns', 'wp-theme-customizer'),	// Title to be displayed on the administration page
		'wptc_bg_patterns_section_callback',					// Callback used to render the description of the section
		'wptc_backgrounds_options'			// Page on which to add this section of options
	);
	
	add_settings_field(	
		'wptc_bg_patterns',				// ID used to identify the field throughout the theme
		__( '', 'wp-theme-customizer' ), // The label to the left of the option interface element
		'wptc_bg_patterns_callback',	// The name of the function responsible for rendering the option interface
		'wptc_backgrounds_options',				// The page on which this option will be displayed
		'bg_patterns_section',			// The name of the section to which this field belongs
		array(								// The array of arguments to pass to the callback. In this case, just a description.
			__( 'Background Patterns', 'wp-theme-customizer' ),
		)
	);
	
	
	register_setting('wptc_backgrounds_options','wptc_backgrounds_general', 'wptc_validate_general_background_options'); // 1)Settings Group, 2)Setting Name, 3) Sanitize Callback
	
	for($u = 1; $u <= 5; $u++){
	
		register_setting('wptc_backgrounds_options','wptc_bg_image_'.$u, 'wptc_validate_image'); // 1)Settings Group, 2)Setting Name, 3) Sanitize Callback
	
	}
	
	for($u = 1; $u <= 10; $u++){
	
		register_setting('wptc_backgrounds_options','wptc_bg_pattern_'.$u, 'wptc_validate_image'); // 1)Settings Group, 2)Setting Name, 3) Sanitize Callback
	
	}

} // end wptc_initialize_backgrounds_options()

add_action( 'admin_init', 'wptc_initialize_backgrounds_options' );

/* ------------------------------------------------------------------------ *
 * Sections Callbacks
 * ------------------------------------------------------------------------ */ 
 
function wptc_backgrounds_general_section_callback() {
	
} // end wptc_backgrounds_general_section_callback() 

function wptc_bg_images_section_callback() {

} // end bg_images_section_callback()

function wptc_bg_patterns_section_callback() {
	
} // end bg_images_section_callback()


 /* ------------------------------------------------------------------------ *
 * Fields Callbacks
 * ------------------------------------------------------------------------ */ 
 
function wptc_display_images_section_callback($args) {
	
	$options = get_option( 'wptc_backgrounds_general' );
	
	$html = '<input type="radio" id="display_images_section" name="wptc_backgrounds_general[display_images_section]" value="1"' . checked( 1, $options['display_images_section'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="display_images_section">Yes&nbsp;&nbsp;&nbsp;</label>';
	$html .= '&nbsp;';
	$html .= '<input type="radio" id="hide_images_section" name="wptc_backgrounds_general[display_images_section]" value="2"' . checked( 2, $options['display_images_section'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="hide_images_section">No&nbsp;&nbsp;&nbsp;</label>';
	$html .= '<span class="wptc_form_hint">'.$args[0].'</span>';
	
	echo $html;
	
} // end display_images_section_callback()

function wptc_display_patterns_section_callback($args) {
	
	$options = get_option( 'wptc_backgrounds_general' );
	
	$html = '<input type="radio" id="display_patterns_section" name="wptc_backgrounds_general[display_patterns_section]" value="1"' . checked( 1, $options['display_patterns_section'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="display_patterns_section">Yes&nbsp;&nbsp;&nbsp;</label>';
	$html .= '&nbsp;';
	$html .= '<input type="radio" id="hide_patterns_section" name="wptc_backgrounds_general[display_patterns_section]" value="2"' . checked( 2, $options['display_patterns_section'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="hide_patterns_section">No&nbsp;&nbsp;&nbsp;</label>';
	$html .= '<span class="wptc_form_hint">'.$args[0].'</span>';
	
	echo $html;
	
} // end display_patterns_section_callback()


function wptc_bg_images_callback() {

	for($u = 1; $u <= 5 ; $u++){
	
		$options = get_option( 'wptc_bg_image_'.$u , '' );
	
		$url = '';
		
		if( isset( $options ) ) {
		
			$url = esc_url( $options );
			
		}
		
		$html = '<div class="wptc_inc_row">';
			$html .= '<img id="wptc_image_show_'.$u.'" class="wptc_image_show" src="'.$options.'" />';
		$html .= '</div>';
		
		echo  $html;
	}
	
} // end wptc_bg_images_callback()

function wptc_bg_patterns_callback() {

	for($u = 1; $u <= 5 ; $u++){
	
		$options = get_option( 'wptc_bg_pattern_'.$u , '' );
	
		$url = '';
		
		if( isset( $options ) ) {
		
			$url = esc_url( $options );
			
		}
		
		$html = '<div class="wptc_inc_row">';
			$html .= '<img id="wptc_image_show_'.$u.'" class="wptc_image_show" src="'.$options.'" />';
		$html .= '</div>';
		
		echo  $html;
	}
	
} // end wptc_bg_images_callback()

function wptc_background_attachment_callback($args) {
	
	$options = get_option( 'wptc_backgrounds_general' );
	
	$html = '<input type="radio" id="background_attachment_fixed" name="wptc_backgrounds_general[background_attachment]" value="1"' . checked( 1, $options['background_attachment'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="background_attachment_fixed">Fixed &nbsp;&nbsp;&nbsp;</label>';
	$html .= '&nbsp;';
	$html .= '<input type="radio" id="background_attachment_scroll" name="wptc_backgrounds_general[background_attachment]" value="2"' . checked( 2, $options['background_attachment'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="background_attachment_scroll">Scroll &nbsp;&nbsp;&nbsp;</label>';
	$html .= '<span class="wptc_form_hint">'.$args[0].'</span>';
	
	echo $html;
	
} // end background_attachment_callback()

function wptc_background_position_callback($args) {
	
	$options = get_option( 'wptc_backgrounds_general' );
	
	$html = '<input type="radio" id="background_position_left" name="wptc_backgrounds_general[background_position]" value="1"' . checked( 1, $options['background_position'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="background_position_left">Left &nbsp;&nbsp;&nbsp;</label>';
	$html .= '&nbsp;';
	$html .= '<input type="radio" id="background_position_center" name="wptc_backgrounds_general[background_position]" value="2"' . checked( 2, $options['background_position'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="background_position_center">Center &nbsp;&nbsp;&nbsp;</label>';
	$html .= '&nbsp;';
	$html .= '<input type="radio" id="background_position_right" name="wptc_backgrounds_general[background_position]" value="3"' . checked( 3, $options['background_position'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="background_position_right">Right &nbsp;&nbsp;&nbsp;</label>';
	$html .= '<span class="wptc_form_hint">'.$args[0].'</span>';
	
	echo $html;
	
} // end background_position_callback()

function wptc_background_repeat_callback($args) {
	
	$options = get_option( 'wptc_backgrounds_general' );
	
	$html = '<input type="radio" id="background_repeat_no" name="wptc_backgrounds_general[background_repeat]" value="1"' . checked( 1, $options['background_repeat'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="background_repeat_no">No Repeat &nbsp;&nbsp;&nbsp;</label>';
	$html .= '&nbsp;';
	$html .= '<input type="radio" id="background_repeat_repeat" name="wptc_backgrounds_general[background_repeat]" value="2"' . checked( 2, $options['background_repeat'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="background_repeat_repeat">Repeat &nbsp;&nbsp;&nbsp;</label>';
	$html .= '&nbsp;';
	$html .= '<input type="radio" id="background_repeat_x" name="wptc_backgrounds_general[background_repeat]" value="3"' . checked( 3, $options['background_repeat'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="background_repeat_x">Repeat Horizontally &nbsp;&nbsp;&nbsp;</label>';
	$html .= '&nbsp;';
	$html .= '<input type="radio" id="background_repeat_y" name="wptc_backgrounds_general[background_repeat]" value="4"' . checked( 4, $options['background_repeat'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="background_repeat_y">Repeat Vertically &nbsp;&nbsp;&nbsp;</label>';
	$html .= '<span class="wptc_form_hint">'.$args[0].'</span>';
	
	echo $html;
	
} // end wptc_background_repeat_callback()

?>
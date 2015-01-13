<?php
/**
 * @package WP Theme Customizer
 */
/*
Admin Effects Options
*/

/** ----------------------------------------------------------------------- *
 * 	Provides default values.
 *  ----------------------------------------------------------------------- */

function wptc_effects_general_default() {
	
	$defaults = array(
			'display_snow_effect'		=>	'1',
			'display_rain_effect'		=>	'1'
	);
	
	return apply_filters( 'wptc_effects_general_default', $defaults );
	
} // end wptc_effects_general_default()

/* ------------------------------------------------------------------------ *
 * Settings Registration
 * ------------------------------------------------------------------------ */ 
 
	if( false == get_option( 'wptc_effects_general' ) ) {	
	
		add_option( 'wptc_effects_general', apply_filters( 'wptc_effects_general_default', wptc_effects_general_default() ) );
		
	} // end if
	
	if( false == get_option( 'wptc_effect' ) ) {	
	
		add_option( 'wptc_effect', 'normal_effect' );
		
	} // end if

function wptc_initialize_effects_options() {

	/*----------------------------Effects Section---------------------------------------*/

	add_settings_section(
		'effects_settings_section',			// ID used to identify this section and with which to register options
		__( 'Special Effects Settings', 'wp-theme-customizer'), // Title to be displayed on the administration page
		'wptc_effects_effects_section_callback',									// Callback used to render the description of the section
		'wptc_effects_options'					// Page on which to add this section of options
	);
	
	add_settings_field(	
		'display_snow_effect',				// ID used to identify the field throughout the theme
		__( 'Display snow effect', 'wp-theme-customizer' ), // The label to the left of the option interface element
		'wptc_display_snow_effect_callback',	// The name of the function responsible for rendering the option interface
		'wptc_effects_options',				// The page on which this option will be displayed
		'effects_settings_section',			// The name of the section to which this field belongs
		array(								// The array of arguments to pass to the callback. In this case, just a description.
			__( 'Display snow effect on front-end module.', 'wp-theme-customizer' ),
		)
	);
	
	add_settings_field(	
		'display_rain_effect',				// ID used to identify the field throughout the theme
		__( 'Display rain effect', 'wp-theme-customizer' ), // The label to the left of the option interface element
		'wptc_display_rain_effect_callback',	// The name of the function responsible for rendering the option interface
		'wptc_effects_options',				// The page on which this option will be displayed
		'effects_settings_section',			// The name of the section to which this field belongs
		array(								// The array of arguments to pass to the callback. In this case, just a description.
			__( 'Display rain effect on front-end module.', 'wp-theme-customizer' ),
		)
	);
	
	register_setting('wptc_effects_options','wptc_effects_general', 'wptc_validate_general_options'); // 1)Settings Group, 2)Setting Name, 3) Sanitize Callback


} // end wptc_initialize_effects_options()

add_action( 'admin_init', 'wptc_initialize_effects_options' );

/* ------------------------------------------------------------------------ *
 * Sections Callbacks
 * ------------------------------------------------------------------------ */ 

function wptc_effects_effects_section_callback() {
	
} // end wptc_backgrounds_general_section_callback() 

 /* ------------------------------------------------------------------------ *
 * Fields Callbacks
 * ------------------------------------------------------------------------ */ 

function wptc_display_snow_effect_callback($args) {
	
	$options = get_option( 'wptc_effects_general' );
	
	$html = '<input type="radio" id="display_snow_effect" name="wptc_effects_general[display_snow_effect]" value="1"' . checked( 1, $options['display_snow_effect'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="display_snow_effect">Yes&nbsp;&nbsp;&nbsp;</label>';
	$html .= '&nbsp;';
	$html .= '<input type="radio" id="hide_snow_effect" name="wptc_effects_general[display_snow_effect]" value="2"' . checked( 2, $options['display_snow_effect'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="hide_snow_effect">No&nbsp;&nbsp;&nbsp;</label>';
	$html .= '<span class="wptc_form_hint">'.$args[0].'</span>';
	
	echo $html;
	
} // end wptc_display_snow_effect_callback()

function wptc_display_rain_effect_callback($args) {
	
	$options = get_option( 'wptc_effects_general' );
	
	$html = '<input type="radio" id="display_rain_effect" name="wptc_effects_general[display_rain_effect]" value="1"' . checked( 1, $options['display_rain_effect'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="display_rain_effect">Yes&nbsp;&nbsp;&nbsp;</label>';
	$html .= '&nbsp;';
	$html .= '<input type="radio" id="hide_rain_effect" name="wptc_effects_general[display_rain_effect]" value="2"' . checked( 2, $options['display_rain_effect'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="hide_rain_effect">No&nbsp;&nbsp;&nbsp;</label>';
	$html .= '<span class="wptc_form_hint">'.$args[0].'</span>';
	
	echo $html;
	
} // end wptc_display_rain_effect_callback()


?>
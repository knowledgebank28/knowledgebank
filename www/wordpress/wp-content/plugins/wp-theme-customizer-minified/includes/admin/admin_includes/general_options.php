<?php
/**
 * @package WP Theme Customizer
 */
/*
Admin General Options
*/

/** ----------------------------------------------------------------------- *
 * 	Provides default values.
 *  ----------------------------------------------------------------------- */
 
function wptc_default_general_options() {
	
	$defaults = array(
		'display_module'			=>	'1',
		'display_colors_tab'		=>	'1',
		'display_backgrounds_tab'	=>	'1',
		'display_effects_tab'		=>	'1',
	);
	
	return apply_filters( 'wptc_default_general_options', $defaults );
	
} // end wptc_default_general_options()


/* ------------------------------------------------------------------------ *
 * Settings Registration
 * ------------------------------------------------------------------------ */ 

function wptc_initialize_general_options() {

	if( false == get_option( 'wptc_general_options' ) ) {	
	
		add_option( 'wptc_general_options', apply_filters( 'wptc_default_general_options', wptc_default_general_options() ) );
		
	} // end if	
	
	if( false == get_option( 'wptc_module_skin' ) ) {	
	
		add_option( 'wptc_module_skin', 'black' );
		
	} // end if

	
/*----------------------------General Settings Section---------------------------------------*/

	add_settings_section(
		'general_settings_section',			// ID used to identify this section and with which to register options
		__( 'General Settings', 'wp-theme-customizer' ),	// Title to be displayed on the administration page
		'wptc_general_general_section_callback',	// Callback used to render the description of the section
		'wptc_general_options'				// Page on which to add this section of options
	);
	
	
	add_settings_field(	
		'display_module',						// ID used to identify the field throughout the theme
		__( 'Display module on front-end', 'wp-theme-customizer' ),							// The label to the left of the option interface element
		'wptc_display_module_callback',	// The name of the function responsible for rendering the option interface
		'wptc_general_options',				// The page on which this option will be displayed
		'general_settings_section',			// The name of the section to which this field belongs
		array(								// The array of arguments to pass to the callback. In this case, just a description.
			__( 'Display options module on front-end.', 'wp-theme-customizer' ),
		)
	);
	
	add_settings_field(	
		'wptc_module_skin',						
		__( 'Select a skin for module', 'wp-theme-customizer' ),				
		'wptc_module_skin_callback',	
		'wptc_general_options',		
		'general_settings_section',			
		array(								
			__( 'Select a skin for front-end module.', 'wp-theme-customizer' ),
		)
	);
	
	
/*----------------------------Tabs Settings Section---------------------------------------*/


	add_settings_section(
		'tabs_settings_section',			// ID used to identify this section and with which to register options
		__( 'Tabs Settings', 'wp-theme-customizer' ),	// Title to be displayed on the administration page
		'wptc_tabs_section_callback',			// Callback used to render the description of the section
		'wptc_general_options'				// Page on which to add this section of options
	);
	
	add_settings_field(	
		'display_colors_tab',						// ID used to identify the field throughout the theme
		__( 'Display colors tab', 'wp-theme-customizer' ),							// The label to the left of the option interface element
		'wptc_display_colors_tab_callback',	// The name of the function responsible for rendering the option interface
		'wptc_general_options',				// The page on which this option will be displayed
		'tabs_settings_section',			// The name of the section to which this field belongs
		array(								// The array of arguments to pass to the callback. In this case, just a description.
			__( 'Display colors tab on front-end module.', 'wp-theme-customizer' ),
		)
	);
	
	add_settings_field(	
		'display_backgrounds_tab',						// ID used to identify the field throughout the theme
		__( 'Display backgrounds tab', 'wp-theme-customizer' ),							// The label to the left of the option interface element
		'wptc_display_backgrounds_tab_callback',	// The name of the function responsible for rendering the option interface
		'wptc_general_options',				// The page on which this option will be displayed
		'tabs_settings_section',			// The name of the section to which this field belongs
		array(								// The array of arguments to pass to the callback. In this case, just a description.
			__( 'Display backgrounds tab on front-end module.', 'wp-theme-customizer' ),
		)
	);
	
	add_settings_field(	
		'display_effects_tab',						// ID used to identify the field throughout the theme
		__( 'Display special effects tab', 'wp-theme-customizer' ),							// The label to the left of the option interface element
		'wptc_display_effects_tab_callback',	// The name of the function responsible for rendering the option interface
		'wptc_general_options',				// The page on which this option will be displayed
		'tabs_settings_section',			// The name of the section to which this field belongs
		array(								// The array of arguments to pass to the callback. In this case, just a description.
			__( 'Display effects tab on front-end module.', 'wp-theme-customizer' ),
		)
	);
	
	
	
	// Finally, we register the fields with WordPress
	register_setting('wptc_general_options','wptc_module_skin', 'wptc_validate_module_skin'); // 1)Settings Group, 2)Setting Name, 3) Sanitize Callback
	
	register_setting('wptc_general_options','wptc_general_options', 'wptc_validate_general_options'); // 1)Settings Group, 2)Setting Name, 3) Sanitize Callback

	
} // end wptc_initialize_general_options
add_action( 'admin_init', 'wptc_initialize_general_options' );

/* ------------------------------------------------------------------------ *
 * Sections Callbacks
 * ------------------------------------------------------------------------ */ 

function wptc_general_general_section_callback() {
	
} // end wptc_general_general_section_callback()

function wptc_tabs_section_callback() {
	echo '<p>' . __( 'Select which tabs you want to display on front-end module.', 'wp-theme-customizer' ) . '</p>';
} // end wptc_tabs_section_callback()

 /* ------------------------------------------------------------------------ *
 * Fields Callbacks
 * ------------------------------------------------------------------------ */ 

function wptc_display_module_callback( $args ) {

	$options = get_option('wptc_general_options');
	
	$html = '<input type="radio" id="display_module" name="wptc_general_options[display_module]" value="1"' . checked( 1, $options['display_module'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="display_module">Yes&nbsp;&nbsp;&nbsp;</label>';
	$html .= '&nbsp;';
	$html .= '<input type="radio" id="hide_module" name="wptc_general_options[display_module]" value="2"' . checked( 2, $options['display_module'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="hide_module">No&nbsp;&nbsp;&nbsp;</label>';
	$html .= '<span class="wptc_form_hint">'.$args[0].'</span>';
	
	echo $html;

} // end wptc_display_module_callback()

function wptc_module_skin_callback( $args ) {

	$options = get_option( 'wptc_module_skin', 'black' );
	
	$html = '<select id="wptc_module_skin" name="wptc_module_skin">';
		$html .= '<option value="black"' . selected( $options, 'black', false) . '>' . __( 'Black', 'wp-theme-customizer' ) . '</option>';
		$html .= '<option value="white"' . selected( $options, 'white', false) . '>' . __( 'White', 'wp-theme-customizer' ) . '</option>';
	$html .= '</select>';
	
	echo $html;

} // end wptc_module_skin_callback

function wptc_display_colors_tab_callback( $args ) {

	$options = get_option('wptc_general_options');
	
	$html = '<input type="radio" id="display_colors_tab" name="wptc_general_options[display_colors_tab]" value="1"' . checked( 1, $options['display_colors_tab'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="display_colors_tab">Yes&nbsp;&nbsp;&nbsp;</label>';
	$html .= '&nbsp;';
	$html .= '<input type="radio" id="hide_colors_tab" name="wptc_general_options[display_colors_tab]" value="2"' . checked( 2, $options['display_colors_tab'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="hide_colors_tab">No&nbsp;&nbsp;&nbsp;</label>';
	$html .= '<span class="wptc_form_hint">'.$args[0].'</span>';
	
	echo $html;

} // end wptc_display_colors_tab_callback()

function wptc_display_backgrounds_tab_callback( $args ) {

	$options = get_option('wptc_general_options');
	
	$html = '<input type="radio" id="display_backgrounds_tab" name="wptc_general_options[display_backgrounds_tab]" value="1"' . checked( 1, $options['display_backgrounds_tab'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="display_backgrounds_tab">Yes&nbsp;&nbsp;&nbsp;</label>';
	$html .= '&nbsp;';
	$html .= '<input type="radio" id="hide_backgrounds_tab" name="wptc_general_options[display_backgrounds_tab]" value="2"' . checked( 2, $options['display_backgrounds_tab'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="hide_backgrounds_tab">No&nbsp;&nbsp;&nbsp;</label>';
	$html .= '<span class="wptc_form_hint">'.$args[0].'</span>';
	
	echo $html;

} // end wptc_display_background_tab_callback()

function wptc_display_effects_tab_callback( $args ) {

	$options = get_option('wptc_general_options');
	
	$html = '<input type="radio" id="display_effects_tab" name="wptc_general_options[display_effects_tab]" value="1"' . checked( 1, $options['display_effects_tab'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="display_effects_tab">Yes&nbsp;&nbsp;&nbsp;</label>';
	$html .= '&nbsp;';
	$html .= '<input type="radio" id="hide_effects_tab" name="wptc_general_options[display_effects_tab]" value="2"' . checked( 2, $options['display_effects_tab'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="hide_effects_tab">No&nbsp;&nbsp;&nbsp;</label>';
	$html .= '<span class="wptc_form_hint">'.$args[0].'</span>';
	
	echo $html;

} // end wptc_display_effects_tab_callback()

?>
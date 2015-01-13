<?php
/**
 * @package WP Theme Customizer
 */
/*
Admin Colors Options
*/

/** ----------------------------------------------------------------------- *
 * 	Provides default values.
 *  ----------------------------------------------------------------------- */
 
function wptc_colors_general_default() {
	
	$defaults = array(
			'change_body_color'			=>	'1',
			'change_headings_color'		=>	'1',
			'change_links_color'		=>	'1',
			'change_buttons_color'		=>	'1',
			'display_button_font_color'	=>	'1'
	);
	
	return apply_filters( 'wptc_colors_general_default', $defaults );
	
} // end wptc_colors_general_default()

/* ------------------------------------------------------------------------ *
 * Settings Registration
 * ------------------------------------------------------------------------ */ 

function wptc_initialize_colors_options() {

	if( false == get_option( 'wptc_colors_general' ) ) {	
	
		add_option( 'wptc_colors_general', apply_filters( 'wptc_colors_general_default', wptc_colors_general_default() ) );
		
	} // end if
	
	$colors_array = array('#65cdd7','#d7c165','#d7657f','#a4791e','#c5b3db');
	
	$inc = 1;
	
	foreach($colors_array as $color){
	
		if( false == get_option( 'wptc_color_palatte_'.$inc ) ) {	
	
			add_option( 'wptc_color_palatte_'.$inc, $color  );
		
		}
		
		$inc++;
	
	}

	/*----------------------------Number of Palattes Section---------------------------------------*/

	add_settings_section(
		'colors_settings_section',			// ID used to identify this section and with which to register options
		__( 'Colors Settings', 'wp-theme-customizer'),// Title to be displayed on the administration page
		'wptc_colors_general_section_callback',									// Callback used to render the description of the section
		'wptc_colors_options'					// Page on which to add this section of options
	);
	
	add_settings_field(	
		'change_the_followings',				// ID used to identify the field throughout the theme
		__( 'Change color of followings.', 'wp-theme-customizer' ), // The label to the left of the option interface element
		'wptc_change_the_followings_callback',	// The name of the function responsible for rendering the option interface
		'wptc_colors_options',				// The page on which this option will be displayed
		'colors_settings_section',			// The name of the section to which this field belongs
		array(								// The array of arguments to pass to the callback. In this case, just a description.
			__( 'The color of selected items will be changed with the selection of color.', 'wp-theme-customizer' ),
		)
	);
	
	add_settings_field(	
		'display_button_font_color',				// ID used to identify the field throughout the theme
		__( 'Display Button\'s Font Color Selection', 'wp-theme-customizer' ), // The label to the left of the option interface element
		'wptc_display_button_font_color_callback',	// The name of the function responsible for rendering the option interface
		'wptc_colors_options',				// The page on which this option will be displayed
		'colors_settings_section',			// The name of the section to which this field belongs
		array(								// The array of arguments to pass to the callback. In this case, just a description.
			__( 'Display Button\'s font color selection on module.', 'wp-theme-customizer' ),
		)
	);
	
	/*----------------------------Color Palattes Section---------------------------------------*/
	
	add_settings_section(
		'colors_palattes_section',			// ID used to identify this section and with which to register options
		__( 'Color Palattes', 'wp-theme-customizer'),// Title to be displayed on the administration page
		'wptc_color_palattes_section_callback',									// Callback used to render the description of the section
		'wptc_colors_options'					// Page on which to add this section of options
	);
	
		
	add_settings_field(	
		'wptc_palatte',				// ID used to identify the field throughout the theme
		__( '', 'wp-theme-customizer' ), // The label to the left of the option interface element
		'wptc_color_palattes_callback',	// The name of the function responsible for rendering the option interface
		'wptc_colors_options',				// The page on which this option will be displayed
		'colors_palattes_section',			// The name of the section to which this field belongs
		array(								// The array of arguments to pass to the callback. In this case, just a description.
			__( 'Color Palattes', 'wp-theme-customizer' ),
		)
	);
	
	
		

	register_setting('wptc_colors_options','wptc_colors_general', 'wptc_validate_general_options'); // 1)Settings Group, 2)Setting Name, 3) Sanitize Callback
	
	for($u = 1; $u <= 15; $u++){
	
		register_setting('wptc_colors_options','wptc_color_palatte_'.$u, 'wptc_validate_color'); // 1)Settings Group, 2)Setting Name, 3) Sanitize Callback
	
	}
	
} // end wptc_initialize_colors_options()

add_action( 'admin_init', 'wptc_initialize_colors_options' );

/* ------------------------------------------------------------------------ *
 * Sections Callbacks
 * ------------------------------------------------------------------------ */ 
 
 
function wptc_colors_general_section_callback() {
	
} // end wptc_colors_general_section_callback()
 
 
function wptc_color_palattes_section_callback() {

} // end wptc_color_palattes_section_callback()


 /* ------------------------------------------------------------------------ *
 * Fields Callbacks
 * ------------------------------------------------------------------------ */ 

function wptc_change_the_followings_callback($args) {

	$options = get_option('wptc_colors_general');
	
	$html = '<input type="checkbox" id="change_body_color" name="wptc_colors_general[change_body_color]" value="1" ' . checked( 1, isset( $options['change_body_color'] ) ? $options['change_body_color'] : 0, false ) . '/>'; 
	$html .= '&nbsp;';
	$html .= '<label for="change_body_color">Body Color &nbsp;&nbsp;&nbsp;</label>';
	
	$html .= '<input type="checkbox" id="change_headings_color" name="wptc_colors_general[change_headings_color]" value="1" ' . checked( 1, isset( $options['change_headings_color'] ) ? $options['change_headings_color'] : 0, false ) . '/>'; 
	$html .= '&nbsp;';
	$html .= '<label for="change_headings_color">Headings Color &nbsp;&nbsp;&nbsp;</label>';
	
	$html .= '<input type="checkbox" id="change_links_color" name="wptc_colors_general[change_links_color]" value="1" ' . checked( 1, isset( $options['change_links_color'] ) ? $options['change_links_color'] : 0, false ) . '/>'; 
	$html .= '&nbsp;';
	$html .= '<label for="change_links_color">Links Color &nbsp;&nbsp;&nbsp;</label>';
	
	$html .= '<input type="checkbox" id="change_buttons_color" name="wptc_colors_general[change_buttons_color]" value="1" ' . checked( 1, isset( $options['change_buttons_color'] ) ? $options['change_buttons_color'] : 0, false ) . '/>'; 
	$html .= '&nbsp;';
	$html .= '<label for="change_buttons_color">Buttons Color &nbsp;&nbsp;&nbsp;</label>';
	
	$html .= '<span class="wptc_form_hint">'.$args[0].'</span>';
	
	echo $html;
	
} // end wptc_change_the_followings_callback()

function wptc_display_button_font_color_callback($args) {
	
	$options = get_option( 'wptc_colors_general' );
	
	$html = '<input type="radio" id="display_button_font_color" name="wptc_colors_general[display_button_font_color]" value="1"' . checked( 1, $options['display_button_font_color'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="display_button_font_color">Yes&nbsp;&nbsp;&nbsp;</label>';
	$html .= '&nbsp;';
	$html .= '<input type="radio" id="hide_button_font_color" name="wptc_colors_general[display_button_font_color]" value="2"' . checked( 2, $options['display_button_font_color'], false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="hide_button_font_color">No&nbsp;&nbsp;&nbsp;</label>';
	$html .= '<span class="wptc_form_hint">'.$args[0].'</span>';
	
	echo $html;
	
} // end wptc_display_button_font_color_callback()

	
function wptc_color_palattes_callback ($args) {
		
		for($u = 1; $u <= 5; $u++){
		
			$options = get_option( 'wptc_color_palatte_'.$u , '#aaaaaa' );
			
			// Render the output
			$html = '<div class="wptc_inc_row">';
			$html .= '<div id="wptc_color_show_'.$u.'" class="wptc_color_show" style=" background-color: ' . $options . ';"></div>';
			$html .= '<div class="wptc_clear"></div>';
			$html .= '</div>';
			echo $html;
		}
}// end wptc_color_palattes_callback

?>
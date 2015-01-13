<?php
/**
 * Story Theme Customizer
 *
 * @package Story
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function story_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	/* Add the logo section. */
	$wp_customize->add_section( 'story_logo_upload', array(
		'title'      => esc_html__( 'Logo', 'story' ),
		'priority'   => 30,
	) );

	/* Add the 'logo' setting. */
	$wp_customize->add_setting( 'logo_upload', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url',
	) );

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize, 'logo_image', array(
				'label'    => esc_html__( 'Upload custom logo.', 'story' ),
				'section'  => 'story_logo_upload',
				'settings' => 'logo_upload',
			)
		)
	);

	// Color Scheme section
	$wp_customize->add_section( 'color_scheme', array(
	 	'title'       => __( 'Color Scheme', 'story' ),
	 	'priority'    => 35,
	) );

	// Add the color scheme layout setting and control.
	$wp_customize->add_setting( 'color_scheme_select', array(
		'default'           => 'turquoise',
		'sanitize_callback' => 'story_sanitize_color_scheme',
	) );

	$wp_customize->add_control( 'color_scheme_select', array(
		'label'   => __( 'Color Scheme', 'story' ),
		'section' => 'color_scheme',
		'type'    => 'select',
		'choices' => array(
			'blue'		=> __( 'Blue', 'story' ),
			'green' 	=> __( 'Green', 'story' ),
			'turquoise'	=> __( 'Turquoise', 'story' ),
			'yellow' 	=> __( 'Yellow', 'story' ),
			'orange' 	=> __( 'Orange', 'story' ),
			'red' 		=> __( 'Red', 'story' ),
			'amethyst'	=> __( 'Amethyst',   'story' ),
		),
	) );

	// Add full screen background option
   $wp_customize->add_setting( 'background-stretch', array(
    	'default' 	=> 10,
    ) );
    // This will be hooked into the default background_image section
    $wp_customize->add_control( 'background-stretch', array(
		'label'    => __( 'Full screen background', 'story' ),
		'section'  => 'background_image',
		'type'     => 'checkbox',
		'priority' => 10
	) );

}
add_action( 'customize_register', 'story_customize_register' );

/**
 * Sanitize the Color Scheme value.
 *
 * @since Story 1.0
 *
 * @param string $color_scheme Color Scheme.
 * @return string Filtered color scheme (amethyst|blue|green|turquoise|yellow|orange|red).
 */
function story_sanitize_color_scheme( $color_scheme ) {
	if ( ! in_array( $color_scheme, array( 'blue', 'green', 'turquoise', 'yellow', 'orange', 'red', 'amethyst' ) ) ) {
		$color_scheme = 'turquoise';
	}

	return $color_scheme;
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function story_customize_preview_js() {
	wp_enqueue_script( 'story_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'story_customize_preview_js' );
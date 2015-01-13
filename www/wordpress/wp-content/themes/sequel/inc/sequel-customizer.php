<?php

function sequel_customize_register( $wp_customize ) {	
	$wp_customize->add_section( 'sequel_home_options' , array(
       'title'      => __('TwentyFourteen Home Options','sequel'),
	   'description' => sprintf( __( 'Use the following settings to set home options. A screen refresh may be required to see some of the changes in the customizer! Top Grid will split the blog feed in to a column of 3/4 latest posts in grid format with the rest of the posts as a standard layout. The grid will first look for Sticky posts and if there are none it will return the latest posts - So if using the grid for top section and have sticky posts then make sure the number of sticky posts matches the number of posts selected for top grid!', 'fourteenxt' )),
       'priority'   => 33,
    ) );
	
	// Add support for Fourteen Extended options - this section is only visible if fourteen Extended is active.
	// Option changes the site header image height on Appearance >> Header and on output at front end.
	// Requires image re-upload for new values to take place - new cropping of image.
	$wp_customize->add_setting(
       'sequel_maximum_header_height',
    array(
        'default' => '240',
		'sanitize_callback' => 'absint'
    ));
	
	$wp_customize->add_control(
       'sequel_maximum_header_height',
    array(
        'label' => __('Set Overall Header max-height (numbers only!) - Default is 240.','sequel'),
        'section' => 'fourteenxt_general_options',
		'priority' => 3,
        'type' => 'text',
    ));
	
	//  Logo Image Upload
    $wp_customize->add_setting('sequel_logo_image', array(
        'default-image'  => ''
    ));
 
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'sequel_logo',
            array(
               'label'    => __( 'Upload a logo', 'sequel' ),
               'section'  => 'title_tagline',
			   'priority' => 11,
               'settings' => 'sequel_logo_image',
            )
        )
    );
	
	$wp_customize->add_setting(
        'sequel_logo_alt_text', array (
		'sanitize_callback' => 'sanitize_text_field',
    ));
	
	$wp_customize->add_control(
    'sequel_logo_alt_text',
    array(
        'type' => 'text',
		'default' => '',
        'label' => __('Enter Logo Alt Text Here', 'sequel'),
        'section' => 'title_tagline',
		'priority' => 12,
        )
    );
	
	// Extend on the Featured Section
	$wp_customize->add_setting( 'featured_content_location', array(
		'default'           => 'default',
		'sanitize_callback' => 'sequel_sanitize_location',
	) );

	$wp_customize->add_control( 'featured_content_location', array(
		'label'   => __( 'Featured Location', 'sequel' ),
		'section' => 'featured_content',
		'priority' => 1,
		'type'    => 'select',
		'choices' => array(
			'default'   => __( 'Default - Above Content/Sidebar',   'sequel' ),
			'fullwidth' => __( 'Below Menu - Fullwidth', 'sequel' ),
		),
	) );
	
	// Top Grid options
	$wp_customize->add_setting(
        'sequel_top_grid_visibility', array (
			'sanitize_callback' => 'sequel_sanitize_checkbox',
		)
    );

    $wp_customize->add_control(
        'sequel_top_grid_visibility',
        array(
            'type'     => 'checkbox',
            'label'    => __('Disable Home Top Grid', 'sequel'),
            'section'  => 'sequel_home_options',
	        'priority' => 1,
        )
    );
	
	$wp_customize->add_setting( 'sequel_grid_number', array( 
	    'default' => 6,
        'sanitize_callback' => 'absint'		
	) );
	
	$wp_customize->add_control( 'sequel_grid_number', array(
        'label' => __( 'Number of posts for top grid', 'sequel'),
        'section' => 'sequel_home_options',
		'priority' => 2,
        'settings' => 'sequel_grid_number',
    ) );
	
	// Blog feed layout
	$wp_customize->add_setting( 'sequel_blog_feed_layout', array(
		'default'           => 'standard',
		'sanitize_callback' => 'sequel_sanitize_home_layout',
	) );

	$wp_customize->add_control( 'sequel_blog_feed_layout', array(
		'label'   => __( 'Blog Feed Layout', 'sequel' ),
		'section' => 'sequel_home_options',
		'priority' => 3,
		'type'    => 'radio',
		'choices' => array(
			'standard'   => __( 'Default Layout',   'sequel' ),
			'home-grid' => __( 'Grid Layout', 'sequel' ),
		),
	) );
	
	$wp_customize->add_setting(
        'sequel_home_grid_columns', array (
			'sanitize_callback' => 'sequel_sanitize_checkbox',
		)
    );

    $wp_customize->add_control(
        'sequel_home_grid_columns',
        array(
            'type'     => 'checkbox',
            'label'    => __('Switch Home Grid Columns to 4?', 'sequel'),
            'section'  => 'sequel_home_options',
	        'priority' => 4,
        )
    );
	
	$wp_customize->add_setting(
        'sequel_home_excerpts', array (
			'sanitize_callback' => 'sequel_sanitize_checkbox',
		)
    );

    $wp_customize->add_control(
        'sequel_home_excerpts',
        array(
            'type'     => 'checkbox',
            'label'    => __('Switch Child theme home feed to excerpts?', 'sequel'),
            'section'  => 'sequel_home_options',
	        'priority' => 5,
        )
    );
	
	$wp_customize->add_setting(
    'sequel_excerpt_length',
    array(
        'default' => 55,
		'sanitize_callback' => 'absint'
    ));
	
	$wp_customize->add_control(
    'sequel_excerpt_length',
    array(
        'label' => __('Enter desired home excerpt length for this child theme (numbers only!). - default is 55.','sequel'),
        'section' => 'sequel_home_options',
		'priority' => 5,
        'type' => 'text',
    ));
		
}
add_action( 'customize_register', 'sequel_customize_register' );

function sequel_sanitize_location( $location ) {
	if ( ! in_array( $location, array( 'default', 'fullwidth' ) ) ) {
		$location = 'default';
	}
	return $location;
}

function sequel_sanitize_home_layout( $home_layout ) {
	if ( ! in_array( $home_layout, array( 'standard', 'home-grid' ) ) ) {
		$home_layout = 'standard';
	}
	return $home_layout;
}

/**
 * Sanitize checkbox
 */
if ( ! function_exists( 'sequel_sanitize_checkbox' ) ) :
	function sequel_sanitize_checkbox( $input ) {
		if ( $input == 1 ) {
			return 1;
		} else {
			return 0;
		}
	}
endif;
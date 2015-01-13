<?php
/**
 * Portfolio theme options
 * @package WordPress
 * @subpackage Elegant WPExplorer Theme
 * @since Elegant 1.0
 */



add_action( 'customize_register', 'wpex_customizer_portfolio' );

function wpex_customizer_portfolio($wp_customize) {

	// Portfolio Section
	$wp_customize->add_section( 'wpex_portfolio' , array(
		'title'      => __( 'Portfolio', 'wpex' ),
		'priority'   => 220,
	) );
	
	// Enable/Disable Portfolio
	$wp_customize->add_setting( 'wpex_portfolio', array(
		'type'		=> 'theme_mod',
		'default'	=> '1'
	) );

	$wp_customize->add_control( 'wpex_portfolio', array(
		'label'		=> __( 'Portfolio Post Type', 'wpex' ),
		'section'	=> 'wpex_portfolio',
		'settings'	=> 'wpex_portfolio',
		'type'		=> 'checkbox',
		'priority'	=> '1',
	) );

	// Enable/Disable Portfolio Comments
	$wp_customize->add_setting( 'wpex_portfolio_comments', array(
		'type'		=> 'theme_mod',
		'default'	=> ''
	) );

	$wp_customize->add_control( 'wpex_portfolio_comments', array(
		'label'		=> __( 'Portfolio Comments', 'wpex' ),
		'section'	=> 'wpex_portfolio',
		'settings'	=> 'wpex_portfolio_comments',
		'type'		=> 'checkbox',
		'priority'	=> '2',
	) );

	// Enable/Disable Portfolio Related
	$wp_customize->add_setting( 'wpex_portfolio_related', array(
		'type'		=> 'theme_mod',
		'default'	=> '1'
	) );

	$wp_customize->add_control( 'wpex_portfolio_related', array(
		'label'		=> __( 'Portfolio Related', 'wpex' ),
		'section'	=> 'wpex_portfolio',
		'settings'	=> 'wpex_portfolio_related',
		'type'		=> 'checkbox',
		'priority'	=> '3',
	) );

	// Homepage Portfolio Category
	$choices = array(
		'all'	=> __( 'All', 'wpex' )
	);
	$cats = get_terms( 'portfolio_category' );
		if ( $cats ) {
		foreach ( $cats as $cat ) {
			$choices[$cat->term_id] = $cat->name;
		}
	}
	$wp_customize->add_setting( 'wpex_home_portfolio_category', array(
		'type'		=> 'theme_mod',
		'default'	=> '',
	) );
	
	$wp_customize->add_control( 'wpex_home_portfolio_category', array(
		'label'		=> __( 'Portfolio Homepage Category','wpex' ),
		'section'	=> 'wpex_portfolio',
		'settings'	=> 'wpex_home_portfolio_category',
		'type'		=> 'select',
		'priority'	=> '4',
		'choices'	=> $choices,
	) );

	// Posts Per Page - Homepage
	$wp_customize->add_setting( 'wpex_home_portfolio_count', array(
		'type'		=> 'theme_mod',
		'default'	=> '8',
	) );
	
	$wp_customize->add_control( 'wpex_home_portfolio_count', array(
		'label'		=> __( 'Portfolio Homepage Posts Per Page', 'wpex' ),
		'section'	=> 'wpex_portfolio',
		'settings'	=> 'wpex_home_portfolio_count',
		'type'		=> 'text',
		'priority'	=> '5',
	) );

	// Posts Per Page - Archive
	$wp_customize->add_setting( 'wpex_portfolio_posts_per_page', array(
		'type'		=> 'theme_mod',
		'default'	=> '12',
	) );
	
	$wp_customize->add_control( 'wpex_portfolio_posts_per_page', array(
		'label'		=> __( 'Archive Posts Per Page', 'wpex' ),
		'section'	=> 'wpex_portfolio',
		'settings'	=> 'wpex_portfolio_posts_per_page',
		'type'		=> 'text',
		'priority'	=> '6',
	) );

}



// Output custom taxonomy array for the homepage portfolio query
if( ! function_exists( 'wpex_home_portfolio_taxonomy' ) ) {
	function wpex_home_portfolio_taxonomy() {
		$cat = get_theme_mod( 'wpex_home_portfolio_category' );
		if( !$cat ) {
			return;
		} elseif( 'all' == $cat ) {
			return;
		} else {
			return array(
				array(
					'taxonomy'	=> 'portfolio_category',
					'field'		=> 'id',
					'terms'		=> $cat,
				),
			);
		}
	}
}
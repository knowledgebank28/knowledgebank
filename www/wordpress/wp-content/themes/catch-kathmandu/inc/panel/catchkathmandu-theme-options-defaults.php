<?php
/**
 * @package Catch Themes
 * @subpackage Catch_Kathmandu
 * @since Catch Kathmandu 1.0
 */

/**
 * Set the default values for all the settings. If no user-defined values
 * is available for any setting, these defaults will be used.
 */
global $catchkathmandu_options_defaults;
$catchkathmandu_options_defaults = array(
	'disable_responsive'					=> '0',
	'enable_menus'							=> '1',
	'fav_icon'								=> get_template_directory_uri().'/images/favicon.ico',
 	'remove_favicon'						=> '1',
	'web_clip'								=> get_template_directory_uri().'/images/apple-touch-icon.png',
 	'remove_web_clip'						=> '1',
	'homepage_headline'						=> 'Catch Kathmandu is a Responsive WordPress Theme',
	'homepage_subheadline'					=> 'It is Simple, Clean and Responsive WordPress Theme which automatically adapts to the screen\'s size.',
	'homepage_headline_button'				=> 'Reviews',
	'homepage_headline_url'					=> esc_url( 'http://wordpress.org/support/view/theme-reviews/catch-kathmandu' ),
	'reset_featured_image'					=> '2',
	'featured_header_image'					=> get_template_directory_uri().'/images/demo/header-image-1280x400.jpg',
	'enable_featured_header_image'			=> 'disable',
	'page_featured_image'					=> 'full',
	'featured_header_image_url'				=> '',
	'featured_header_image_alt'				=> '',
	'featured_header_image_base'			=> '0',
 	'disable_header_right_sidebar'			=> '0',
	'color_scheme'							=> 'light',
	'reset_typography'						=> '2',	
	'custom_css'							=> '',	
	'sidebar_layout'						=> 'right-sidebar',
	'content_layout'						=> 'full',
	'featured_image'						=> 'featured',
	'reset_layout'							=> '2',
	'more_tag_text'							=> 'Continue Reading &rarr;',
	'reset_moretag'							=> '2',
	'excerpt_length'						=> 30,
 	'search_display_text'					=> 'Search &hellip;',
	'feed_url'								=> '',
	'disable_homepage_headline'				=> '0',
	'disable_homepage_subheadline'			=> '0',
	'disable_homepage_button'				=> '0',
	'disable_homepage_featured'				=> '0',
	'homepage_featured_headline'			=> '',
	'homepage_featured_qty'					=> 4,
	'homepage_featured_layout'				=> 'four-columns',
	'homepage_featured_image'				=> array(),
	'homepage_featured_url'					=> array(),
	'homepage_featured_base'				=> array(),
	'homepage_featured_title'				=> array(),
	'homepage_featured_content'				=> array(),
	'enable_posts_home'						=> '0',
	'move_posts_home'						=> '0',
 	'front_page_category'					=> array(),
	'select_slider_type'					=> 'post-slider',
	'enable_slider'							=> 'enable-slider-homepage',
 	'featured_slider'						=> array(),
	'featured_slider_page'					=> array(),	
	'slider_category'						=> array(),
	'featured_image_slider_image'			=> array(),
	'featured_image_slider_link' 			=> array(),
	'featured_image_slider_base'			=> array(),
	'featured_image_slider_title' 			=> array(),
	'featured_image_slider_content' 		=> array(),
	'slider_qty'							=> 4,
 	'transition_effect'						=> 'fade',
 	'transition_delay'						=> 4,
 	'transition_duration'					=> 1,	
	'exclude_slider_post'					=> 0,
 	'social_facebook'						=> '',
 	'social_twitter'						=> '',
 	'social_googleplus'						=> '',
 	'social_pinterest'						=> '',
 	'social_youtube'						=> '',
 	'social_vimeo'							=> '',
 	'social_linkedin'						=> '',
 	'social_slideshare'						=> '',
 	'social_foursquare'						=> '',
 	'social_flickr'							=> '',
 	'social_tumblr'							=> '',
 	'social_deviantart'						=> '',
 	'social_dribbble'						=> '',
 	'social_myspace'						=> '',
 	'social_wordpress'						=> '',
 	'social_rss'							=> '',
 	'social_delicious'						=> '',
 	'social_lastfm'							=> '',
	'social_instagram'						=> '',
	'social_github'							=> '',
	'social_vkontakte'						=> '',
	'social_myworld'						=> '',
	'social_odnoklassniki'					=> '',
	'social_goodreads'						=> '',
	'social_skype'							=> '',
	'social_soundcloud'						=> '',
	'social_email'							=> '',
	'social_contact'						=> '',
	'social_xing'							=> '',
	'social_meetup'							=> '',
 	'analytic_header'						=> '',
 	'analytic_footer'						=> '',
	'footer_code'							=> '<div class="copyright">'. esc_attr__( 'Copyright', 'catchkathmandu' ) . ' &copy; ' . catchkathmandu_the_year() . '&nbsp;' . catchkathmandu_site_link() . '&nbsp;' . esc_attr__( 'All Rights Reserved', 'catchkathmandu' ) . '.</div><div class="powered">'. esc_attr__( 'Catch Kathmandu by', 'catchkathmandu' ) . '&nbsp;' . catchkathmandu_shop_link() . '</div>',
	'reset_footer'							=> '2'
);
global $catchkathmandu_options_settings;
$catchkathmandu_options_settings = catchkathmandu_options_set_defaults( $catchkathmandu_options_defaults );

function catchkathmandu_options_set_defaults( $catchkathmandu_options_defaults ) {
	$catchkathmandu_options_settings = array_merge( $catchkathmandu_options_defaults, (array) get_option( 'catchkathmandu_options', array() ) );
	return $catchkathmandu_options_settings;
}

/**
 * Returns the current year.
 *
 * @uses date() Gets the current year.
 * @return string
 */
function catchkathmandu_the_year() {
	return date( __( 'Y', 'catchkathmandu' ) );
}


/**
 * Returns a link back to the site.
 *
 * @uses get_bloginfo() Gets the site link
 * @return string
 */
function catchkathmandu_site_link() {
	return '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" ><span>' . get_bloginfo( 'name', 'display' ) . '</span></a>';
}


/**
 * Returns a link to Theme Shop.
 *
 * @return string
 */
function catchkathmandu_shop_link() {
	return '<a href="'. esc_url( __( 'http://catchthemes.com', 'catchkathmandu' ) ) . '" target="_blank" title="' . esc_attr__( 'Catch Themes', 'catchkathmandu' ) . '"><span>' . __( 'Catch Themes', 'catchkathmandu' ) . '</span></a>';
}
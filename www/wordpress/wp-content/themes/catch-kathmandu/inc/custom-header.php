<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * You can add an optional custom header image to header.php like so ...

	<?php $header_image = get_header_image();
	if ( ! empty( $header_image ) ) { ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
		</a>
	<?php } // if ( ! empty( $header_image ) ) ?>

 *
 * @package Catch Themes
 * @subpackage Catch Kathmandu
 * @since Catch Kathmandu 1.0
 */

/**
 * Setup the WordPress core custom header feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 * as well as provide backward compatibility for previous versions.
 * Use feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * @todo Rework this function to remove WordPress 3.4 support when WordPress 3.6 is released.
 *
 * @uses catchkathmandu_header_style()
 * @uses catchkathmandu_admin_header_style()
 * @uses catchkathmandu_header_image()
 *
 * @package Catch Kathmandu
 */
function catchkathmandu_custom_header_setup() {
	$args = array(
		// Text color and image (empty to use none).
		'default-text-color'     => '000',
		'default-image'          => '',
		
		// Set height and width, with a maximum value for the width.
		'height'                 => 85,
		'width'                  => 84,
		'max-width'              => 1280,
		
		// Support flexible height and width.
		'flex-height'            => true,
		'flex-width'             => true,
			
		// Random image rotation off by default.
		'random-default'         => false,	
			
		// Callbacks for styling the header and the admin preview.
		'wp-head-callback'       => 'catchkathmandu_header_style',
		'admin-head-callback'    => 'catchkathmandu_admin_header_style',
		'admin-preview-callback' => 'catchkathmandu_header_image',
	);

	$args = apply_filters( 'catchkathmandu_custom_header_args', $args );

	add_theme_support( 'custom-header', $args );
	
	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'defaultlogo' => array(
			'url' => '%s/images/logo.png',
			'thumbnail_url' => '%s/images/logo.png',
			/* translators: header image description */
			'description' => __( 'Default Logo', 'catchkathmandu' )
		),
		'catchkathmandulogo' => array(
			'url' => '%s/images/catch-kathmandu.png',
			'thumbnail_url' => '%s/images/catch-kathmandu.png',
			/* translators: header image description */
			'description' => __( 'Catch Kathmandu Logo', 'catchkathmandu' )
		)
	) );	
 
}
add_action( 'after_setup_theme', 'catchkathmandu_custom_header_setup' );


/**
 * Shiv for get_custom_header().
 *
 * get_custom_header() was introduced to WordPress
 * in version 3.4. To provide backward compatibility
 * with previous versions, we will define our own version
 * of this function.
 *
 * @todo Remove this function when WordPress 3.6 is released.
 * @return stdClass All properties represent attributes of the curent header image.
 *
 * @package Catch Themes
 * @subpackage Catch Kathmandu
 * @since Catch Kathmandu 1.0
 */

if ( ! function_exists( 'get_custom_header' ) ) {
	function get_custom_header() {
		return (object) array(
			'url'           => get_header_image(),
			'thumbnail_url' => get_header_image(),
			'width'         => HEADER_IMAGE_WIDTH,
			'height'        => HEADER_IMAGE_HEIGHT,
		);
	}
}


if ( ! function_exists( 'catchkathmandu_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see catchkathmandu_custom_header_setup().
 *
 * @since Catch Kathmandu 1.0
 */
function catchkathmandu_header_style() {

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
	if ( HEADER_TEXTCOLOR == get_header_textcolor() )
		return;
	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == get_header_textcolor() ) :
	?>
		#hgroup { padding: 0; }
		#site-title,
		#site-description {
			position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		#site-title a,
		#site-description {
			color: #<?php echo get_header_textcolor(); ?> !important;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // catchkathmandu_header_style


if ( ! function_exists( 'catchkathmandu_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see catchkathmandu_custom_header_setup().
 *
 * @since Catch Kathmandu 1.0
 */
function catchkathmandu_admin_header_style() {
	?>
	<style type="text/css">
	<?php if ( HEADER_TEXTCOLOR == get_header_textcolor() ) : ?>
		#site-logo,
		#hgroup {
			display: inline-block;
			float: left;
		}
		#hgroup.logo-enable.logo-left {
			padding-left: 15px;
		}
		#hgroup.logo-enable.logo-right {
			padding-right: 15px;
		}
		#site-title {
			font-size: 22px;
			font-size: 2.2rem;
			font-weight: bold;
			line-height: 1.6;
			margin: 0;
		}
		#site-title a {
			color: #000;
			text-decoration: none;
		}		
		#site-description  {
			color: #333;
			font-size: 14px;
			font-size: 1.4rem;
			font-style: italic;
			line-height: 1.4;
			padding: 0;
			
		}
	<?php endif; ?>
	
		
	<?php
		// Has the text been hidden?
		if ( 'blank' == get_header_textcolor() ) :
	?>
		#hgroup { padding: 0; }
		#site-title,
		#site-description {
			position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		#site-title a,
		#site-description {
			color: #<?php echo get_header_textcolor(); ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // catchkathmandu_admin_header_style


if ( ! function_exists( 'catchkathmandu_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see catchkathmandu_custom_header_setup().
 *
 * @since Catch Kathmandu 1.0
 */
function catchkathmandu_header_image() { 	
	?>
	<div id="header-left">
		<?php 		
		//Checking Logo/Header Image
		$header_image = get_header_image();
		
		if ( ! empty( $header_image ) ) : 
		
			$logoenable = 'logo-enable logo-left';
			
			$catchkathmandu_header_logo = '
			<div id="site-logo">
            	<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '">
            		<img src="' . esc_url( $header_image ) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" />
				</a>
			</div><!-- #site-logo -->';
		else :
			$logoenable = 'logo-disable'; 
			$catchkathmandu_header_logo = '';
		endif; 
		
		// Checking Header Details
		
		$catchkathmandu_header_details = '
		<div id="hgroup" class="' . $logoenable . '">
			<h1 id="site-title">
				<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home">' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '</a>
			</h1>
			<h2 id="site-description"> ' . esc_attr( get_bloginfo( 'description', 'display' ) ) . '</h2>
		</div><!-- #hgroup -->';  		
		
		echo $catchkathmandu_header_logo;
		echo $catchkathmandu_header_details;
		   
		?>
        
	</div><!-- #header-left"> -->
<?php }
endif; // catchkathmandu_header_image
add_action( 'catchkathmandu_hgroup_wrap', 'catchkathmandu_header_image', 10 );
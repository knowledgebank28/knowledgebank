<?php
/**
 * Implement Custom Header functionality for Sequel
 *
 * @package Sequel
 * @since Sequel 1.0
 */

/**
 * Set up the WordPress core custom header settings.
 *
 * @since Sequel 1.0
 *
 * @uses sequel_header_style()
 * @uses sequel_admin_header_style()
 * @uses sequel_admin_header_image()
 */
function sequel_custom_header_setup() {
	/**
	 * Filter Sequel custom-header support arguments.
	 *
	 * @since Sequel 1.0
	 *
	 * @param array $args {
	 *     An array of custom-header support arguments.
	 *
	 *     @type bool   $header_text            Whether to display custom header text. Default false.
	 *     @type int    $width                  Width in pixels of the custom header image. Default 1260.
	 *     @type int    $height                 Height in pixels of the custom header image. Default 240.
	 *     @type bool   $flex_height            Whether to allow flexible-height header images. Default true.
	 *     @type string $admin_head_callback    Callback function used to style the image displayed in
	 *                                          the Appearance > Header screen.
	 *     @type string $admin_preview_callback Callback function used to create the custom header markup in
	 *                                          the Appearance > Header screen.
	 * }
	 */
	/* Add custom header support for Fourteen Extended plugin */
	if (get_theme_mod( 'fourteenxt_maximum_site_width' )) {
	$header_width = get_theme_mod( 'fourteenxt_maximum_site_width' );
	} else {
		$header_width  = 1260;
	}
	/* Add theme specific custom header height in support the Fourteen Extended plugin - see functions.php for more info! */
	if (get_theme_mod( 'sequel_maximum_header_height' )) {
	$header_height = get_theme_mod( 'sequel_maximum_header_height' );
	} else {
		$header_height = 240;
	}
	add_theme_support( 'custom-header', apply_filters( 'sequel_custom_header_args', array(
		'default-text-color'     => 'fff',
		'width'                  => $header_width,
		'height'                 => $header_height,
		'flex-height'            => true,
		'wp-head-callback'       => 'sequel_header_style',
		'admin-head-callback'    => 'sequel_admin_header_style',
		'admin-preview-callback' => 'sequel_admin_header_image',
	) ) );
}
add_action( 'after_setup_theme', 'sequel_custom_header_setup' );

if ( ! function_exists( 'sequel_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see sequel_custom_header_setup().
 *
 */
function sequel_header_style() {
	$text_color = get_header_textcolor();

	// If no custom color for text is set, let's bail.
	if ( display_header_text() && $text_color === get_theme_support( 'custom-header', 'default-text-color' ) )
		return;

	// If we get this far, we have custom styles.
	?>
	<style type="text/css" id="sequel-header-css">
	<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
	?>
		.site-title,
		.site-description {
			clip: rect(1px 1px 1px 1px); /* IE7 */
			clip: rect(1px, 1px, 1px, 1px);
			position: absolute;
		}
	<?php
		// If the user has set a custom color for the text, use that.
		elseif ( $text_color != get_theme_support( 'custom-header', 'default-text-color' ) ) :
	?>
		.site-title a {
			color: #<?php echo esc_attr( $text_color ); ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // sequel_header_style


if ( ! function_exists( 'sequel_admin_header_style' ) ) :
/**
 * Style the header image displayed on the Appearance > Header screen.
 *
 * @see sequel_custom_header_setup()
 *
 * @since Sequel 1.0
 */
function sequel_admin_header_style() {
?>
	<style type="text/css" id="sequel-admin-header-css">
	.appearance_page_custom-header #headimg {
		background-color: #000;
		border: none;
		max-width: 1600px;
		min-height: 48px;
	}
	#headimg h1 {
		font-family: Lato, sans-serif;
		font-size: 18px;
		line-height: 48px;
		margin: 0 0 0 30px;
	}
	#headimg h1 a {
		color: #fff;
		text-decoration: none;
	}
	#headimg img {
		vertical-align: middle;
	}
	</style>
<?php
}
endif; // sequel_admin_header_style

if ( ! function_exists( 'sequel_admin_header_image' ) ) :
/**
 * Create the custom header image markup displayed on the Appearance > Header screen.
 *
 * @see sequel_custom_header_setup()
 *
 * @since Sequel 1.0
 */
function sequel_admin_header_image() {
?>
	<div id="headimg">
		<?php if ( get_header_image() ) : ?>
		<img src="<?php header_image(); ?>" alt="">
		<?php endif; ?>
		<h1 class="displaying-header-text"><a id="name"<?php echo sprintf( ' style="color:#%s;"', get_header_textcolor() ); ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
	</div>
<?php
}
endif; // sequel_admin_header_image

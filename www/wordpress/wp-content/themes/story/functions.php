<?php
/**
 * Story functions and definitions
 *
 * @package Story
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'story_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function story_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Story, use a find and replace
	 * to change 'story' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'story', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 820, 450, true );
	add_filter( 'use_default_gallery_style', '__return_false' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'story' ),
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'image', 'video', 'quote', 'link', 'audio' ) );

	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array( 'comment-list', 'search-form', 'comment-form', ) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'story_custom_background_args', array(
		'default-color' => 'cccccc',
		'default-image' => get_template_directory_uri() . '/images/background.jpg'
	) ) );
}
endif; // story_setup
add_action( 'after_setup_theme', 'story_setup' );

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function story_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'story' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'story_widgets_init' );

function story_widget_content_wrapper($content) {
    
    $content = '<div class="widget-content">'.$content.'</div>';
    return $content;
}
add_filter('widget_text', 'story_widget_content_wrapper');

/**
 * Enqueue scripts and styles.
 */

if (!function_exists('story_google_fonts')) {
	function story_google_fonts() {
	
		wp_enqueue_style( 'story-fonts', '//fonts.googleapis.com/css?family=Bitter:400,700|Source+Sans+Pro:400,600|Yesteryear&subset=latin' );
	
	}
}
add_action( 'wp_enqueue_scripts', 'story_google_fonts' );

function story_scripts() {

	wp_enqueue_style( 'story-style', get_stylesheet_uri() );
	
	wp_enqueue_style( 'story-color', get_stylesheet_directory_uri() . '/css/'. get_theme_mod( 'color_scheme_select', 'turquoise' ) .'.css' );

	wp_enqueue_style( 'story-icofont', get_template_directory_uri() . '/css/storyicofont.css' );

	wp_enqueue_style( 'story-slicknav-css', get_template_directory_uri() . '/css/slicknav.css' );

	wp_enqueue_script( 'jquery' );

	wp_enqueue_script( 'story-fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array('jquery'), '20120206', true );
	
	wp_enqueue_script( 'story-slicknav', get_template_directory_uri() . '/js/jquery.slicknav.min.js' );

	wp_enqueue_script( 'story-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'story_scripts' );

/**
 * Remove Gallery Inline Styling
 */
/* add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Extract video from content for video post format.
 */
function story_featured_video( $content ) {
	$url = trim( current ( explode( "\n", $content ) ) );	
	if ( 0 === strpos( $url, 'http://' ) || preg_match ( '#^<(script|iframe|embed|object)#i', $url )) { 	
 		echo apply_filters( 'the_content', $url ); 	
 	}	 		
}

function story_video_content( $content ) {
	$url = trim( current ( explode( "\n", $content ) ) );	
	if ( 0 === strpos( $url, 'http://' ) || preg_match ( '#^<(script|iframe|embed|object)#i', $url )) { 		
 		$content = trim( str_replace( $url, '', $content ) );  	
 	}
	return $content;
}

if (!function_exists('story_footer_js')) {
	function story_footer_js() {
    ?>
        <script>     
       
        jQuery(document).ready(function($) {   
			
				
			$('#reply-title').addClass('section-title');

			$('#content').css('margin-top', $('#masthead').height() + 50);

			$('#site-navigation .menu>ul').slicknav({prependTo:'#mobile-menu'});

			$('.post').fitVids();

			var shrinkHeader = 300;
			$(window).scroll(function(){
				var scroll = getCurrentScroll();
				if (scroll > shrinkHeader ) {
					$('#masthead').addClass('shrink');
				} else {
					$('#masthead').removeClass('shrink');
				}
			})

			function getCurrentScroll() {
				return window.pageYOffset;
			}
						
        });
        </script>
    <?php
	}
}
add_action( 'wp_footer', 'story_footer_js', 20, 1 );    

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

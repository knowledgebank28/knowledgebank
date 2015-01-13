<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Catch Themes
 * @subpackage Catch Kathmandu
 * @since Catch Kathmandu 1.0
 */


/**
 * Enqueue scripts and styles
 */
function catchkathmandu_scripts() {
	
	//Getting Ready to load data from Theme Options Panel
	global $post, $wp_query, $catchkathmandu_options_settings;
   	$options = $catchkathmandu_options_settings;
	
	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts'); 

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();
	
	/**
	 * Loads up main stylesheet.
	 */
	wp_enqueue_style( 'catchkathmandu-style', get_stylesheet_uri() );
	
	/**
	 *Add Genericons font, used in the main stylesheet.
	 */	
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.0.3' );	
	
	/**
	 * Loads up Color Scheme
	 */
	$color_scheme = $options['color_scheme'];
	if ( 'dark' == $color_scheme ) {
		wp_enqueue_style( 'dark', get_template_directory_uri() . '/css/dark.css', array(), null );	
	}
	
	//Responsive Menu
	wp_register_script('catchkathmandu-menu', get_template_directory_uri() . '/js/catchkathmandu-menu.min.js', array('jquery'), '20140317', true);
	wp_register_script('catchkathmandu-allmenu', get_template_directory_uri() . '/js/catchkathmandu-allmenu.min.js', array('jquery'), '20140317', true);	
	
	/**
	 * Loads up Responsive stylesheet and Menu JS
	 */
	if ( empty ($options[ 'disable_responsive' ] ) ) {	
		wp_enqueue_style( 'catchkathmandu-responsive', get_template_directory_uri() . '/css/responsive.css' );
		
		if ( !empty ($options ['enable_menus'] ) ) :
			wp_enqueue_script( 'catchkathmandu-allmenu' );
		else :
			wp_enqueue_script( 'catchkathmandu-menu' );
		endif;
		
		wp_enqueue_script( 'catchkathmandu-fitvids', get_template_directory_uri() . '/js/catchkathmandu.fitvids.min.js', array( 'jquery' ), '20140317', true );	
	}
	
	/**
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}

	/**
	 * Register JQuery circle all and JQuery set up as dependent on Jquery-cycle
	 */			
	wp_register_script( 'jquery-cycle', get_template_directory_uri() . '/js/jquery.cycle.all.min.js', array( 'jquery' ), '20140317', true );
	
	
	if ( !empty ( $options[ 'social_custom_image' ][ 1 ] ) ) {
		wp_enqueue_script( 'catchkathmandu-grey', get_template_directory_uri() . '/js/catchkathmandu-grey.min.js', array( 'jquery' ), '20130114' );
	}
	
	/**
	 * Loads up catchkathmandu-slider and jquery-cycle set up as dependent on catchkathmandu-slider
	 */	
	$enableslider = $options[ 'enable_slider' ];	
	if ( ( $enableslider == 'enable-slider-allpage' ) || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && $enableslider == 'enable-slider-homepage' ) ) {	
		wp_enqueue_script( 'catchkathmandu-slider', get_template_directory_uri() . '/js/catchkathmandu-slider.js', array( 'jquery-cycle' ), '20140317', true );
	}	
	
	wp_enqueue_script( 'catchkathmandu-scrollup', get_template_directory_uri() . '/js/catchkathmandu-scrollup.min.js', array( 'jquery' ), '20072014', true  );
	
	/**
	 * Browser Specific Enqueue Script
	 */		
	$catchkathmandu_ua = strtolower($_SERVER['HTTP_USER_AGENT']);
	if(preg_match('/(?i)msie [1-8]/',$catchkathmandu_ua)) {
	 	wp_enqueue_script( 'selectivizr', get_template_directory_uri() . '/js/selectivizr.min.js', array( 'jquery' ), '20130114', false );		
		wp_enqueue_style( 'catchkathmandu-iecss', get_template_directory_uri() . '/css/ie.css' );
	}
	
}
add_action( 'wp_enqueue_scripts', 'catchkathmandu_scripts' );


/**
 * Responsive Layout
 *
 * @get the data value of responsive layout from theme options
 * @display responsive meta tag 
 * @action wp_head
 */
function catchkathmandu_responsive() {
	//delete_transient('catchkathmandu_responsive');	
	
	if ( !$catchkathmandu_responsive = get_transient( 'catchkathmandu_responsive' ) ) {
	global $catchkathmandu_options_settings;
   	$options = $catchkathmandu_options_settings;

		if ( $options[ 'disable_responsive' ] == '0' ) {
			$catchkathmandu_responsive = '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
		}
		else {
			$catchkathmandu_responsive = '<!-- Disable Responsive -->';
		}
		set_transient( 'catchkathmandu_responsive', $catchkathmandu_responsive, 86940 );										  
	}
	echo $catchkathmandu_responsive;
} // catchkathmandu_responsive
add_filter( 'wp_head', 'catchkathmandu_responsive', 1 );


/**
 * Get the favicon Image from theme options
 *
 * @uses favicon 
 * @get the data value of image from theme options
 * @display favicon
 *
 * @uses default favicon if favicon field on theme options is empty
 *
 * @uses set_transient and delete_transient 
 */
function catchkathmandu_favicon() {
	//delete_transient( 'catchkathmandu_favicon' );	
	
	if( ( !$catchkathmandu_favicon = get_transient( 'catchkathmandu_favicon' ) ) ) {
		global $catchkathmandu_options_settings;
   		$options = $catchkathmandu_options_settings;
		
		echo '<!-- refreshing cache -->';
		if ( empty( $options[ 'remove_favicon' ] ) ) :
			// if not empty fav_icon on theme options
			if ( !empty( $options[ 'fav_icon' ] ) ) :
				$catchkathmandu_favicon = '<link rel="shortcut icon" href="'.esc_url( $options[ 'fav_icon' ] ).'" type="image/x-icon" />'; 	
			else:
				// if empty fav_icon on theme options, display default fav icon
				$catchkathmandu_favicon = '<link rel="shortcut icon" href="'. get_template_directory_uri() .'/images/favicon.ico" type="image/x-icon" />';
			endif;
		endif;
		
		set_transient( 'catchkathmandu_favicon', $catchkathmandu_favicon, 86940 );	
	}	
	echo $catchkathmandu_favicon ;	
} // catchkathmandu_favicon

//Load Favicon in Header Section
add_action('wp_head', 'catchkathmandu_favicon');

//Load Favicon in Admin Section
add_action( 'admin_head', 'catchkathmandu_favicon' );


if ( ! function_exists( 'catchkathmandu_featured_image' ) ) :
/**
 * Template for Featured Header Image from theme options
 *
 * To override this in a child theme
 * simply create your own catchkathmandu_featured_image(), and that function will be used instead.
 *
 * @since Catch Kathmandu 1.0
 */
function catchkathmandu_featured_image() {
	//delete_transient( 'catchkathmandu_featured_image' );	
	
	// Getting Data from Theme Options Panel
	global $catchkathmandu_options_settings, $catchkathmandu_options_defaults;
   	$options = $catchkathmandu_options_settings;
	$defaults = $catchkathmandu_options_defaults;
	$enableheaderimage = $options[ 'enable_featured_header_image' ];
		
	if ( !empty( $options[ 'featured_header_image' ] ) ) {
		
		$catchkathmandu_featured_image = '<div id="header-image">';
		
		// Header Image Link and Target
		if ( !empty( $options[ 'featured_header_image_url' ] ) ) {
			//support for qtranslate custom link
			if ( function_exists( 'qtrans_convertURL' ) ) {
				$link = qtrans_convertURL($options[ 'featured_header_image_url' ]);
			}
			else {
				$link = esc_url( $options[ 'featured_header_image_url' ] );
			}
			//Checking Link Target
			if ( !empty( $options[ 'featured_header_image_base' ] ) )  {
				$target = '_blank'; 	
			}
			else {
				$target = '_self'; 	
			}
		}
		else {
			$link = '';
			$target = '';
		}
		
		// Header Image Title/Alt
		if ( !empty( $options[ 'featured_header_image_alt' ] ) ) {
			$title = esc_attr( $options[ 'featured_header_image_alt' ] ); 	
		}
		else {
			$title = ''; 	
		}
		
		// Header Image
		if ( !empty( $options[ 'featured_header_image' ] ) ) :
			$feat_image = '<img class="wp-post-image" src="'.esc_url( $options[ 'featured_header_image' ] ).'" />'; 	
		else:
			// if empty featured_header_image on theme options, display default
			$feat_image = '<img class="wp-post-image" src="'.esc_url( $defaults[ 'featured_header_image' ] ).'" />';
		endif;
		
		$catchkathmandu_featured_image = '<div id="header-featured-image">';
			// Header Image Link 
			if ( !empty( $options[ 'featured_header_image_url' ] ) ) :
				$catchkathmandu_featured_image .= '<a title="'.$title.'" href="'.$link.'" target="'.$target.'"><img id="main-feat-img" class="wp-post-image" alt="'.$title.'" src="'.esc_url( $options[ 'featured_header_image' ] ).'" /></a>'; 	
			else:
				// if empty featured_header_image on theme options, display default
				$catchkathmandu_featured_image .= '<img id="main-feat-img" class="wp-post-image" alt="'.$title.'" src="'.esc_url( $options[ 'featured_header_image' ] ).'" />';
			endif;
		$catchkathmandu_featured_image .= '</div><!-- #header-featured-image -->';
	}
	
	echo $catchkathmandu_featured_image;
	
} // catchkathmandu_featured_image
endif;


if ( ! function_exists( 'catchkathmandu_featured_page_post_image' ) ) :
/**
 * Template for Featured Header Image from Post and Page
 *
 * To override this in a child theme
 * simply create your own catchkathmandu_featured_imaage_pagepost(), and that function will be used instead.
 *
 * @since Catch Kathmandu 1.0
 */
function catchkathmandu_featured_page_post_image() {

	global $post, $wp_query, $catchkathmandu_options_settings;
   	$options = $catchkathmandu_options_settings;
	$featured_image = $options['page_featured_image'];
	
	
	if ( has_post_thumbnail() ) {
		
		echo '<div id="header-featured-image">';
			
			if ( !empty( $options[ 'featured_header_image_url' ] ) ) {
				// Header Image Link Target
				if ( !empty( $options[ 'featured_header_image_base' ] ) ) :
					$base = '_blank'; 	
				else:
					$base = '_self'; 	
				endif;
				
				// Header Image Title/Alt
				if ( !empty( $options[ 'featured_header_image_alt' ] ) ) :
					$title = esc_attr( $options[ 'featured_header_image_alt' ] ); 
				else:
					$title = ''; 	
				endif;
				
				$linkopen = '<a title="'.$title.'" href="'.$options[ 'featured_header_image_url' ] .'" target="'.$base.'">';
				$linkclose = '</a>';
			}
			else {
				$linkopen = '';
				$linkclose = '';
			}
		
			echo $linkopen;
				if ( $featured_image == 'featured' ) { 
					echo get_the_post_thumbnail($post->ID, 'featured', array('id' => 'main-feat-img'));
				} 
				elseif ( $featured_image == 'slider' ) {
					echo get_the_post_thumbnail($post->ID, 'slider', array('id' => 'main-feat-img'));
				}
				else { 
					echo get_the_post_thumbnail($post->ID, 'full', array('id' => 'main-feat-img'));
				}
			echo $linkclose;

		echo '</div><!-- #header-featured-image -->';
			
	}
	else {
		catchkathmandu_featured_image();
	}		
	
} // catchkathmandu_featured_page_post_image
endif;


if ( ! function_exists( 'catchkathmandu_featured_overall_image' ) ) :
/**
 * Template for Featured Header Image from theme options
 *
 * To override this in a child theme
 * simply create your own catchkathmandu_featured_pagepost_image(), and that function will be used instead.
 *
 * @since Catch Kathmandu Pro 1.0
 */
function catchkathmandu_featured_overall_image() {

	global $post, $wp_query, $catchkathmandu_options_settings;
   	$options = $catchkathmandu_options_settings;
	$enableheaderimage =  $options[ 'enable_featured_header_image' ];
	
	// Front page displays in Reading Settings
	$page_for_posts = get_option('page_for_posts'); 

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();

	// Check Enable/Disable header image in Page/Post Meta box
	if ( is_page() || is_single() ) {
		//Individual Page/Post Image Setting
		$individual_featured_image = get_post_meta( $post->ID, 'catchkathmandu-header-image', true ); 
		
		if ( $individual_featured_image == 'disable' || ( $individual_featured_image == 'default' && $enableheaderimage == 'disable' ) ) {
			echo '<!-- Page/Post Disable Header Image -->';
			return;
		}
		elseif ( $individual_featured_image == 'enable' && $enableheaderimage == 'disable' ) {
			catchkathmandu_featured_page_post_image();
		}
	}

	// Check Homepage 
	if ( $enableheaderimage == 'homepage' ) {
		if ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) {
			catchkathmandu_featured_image();
		}
	}
	// Check Excluding Homepage 
	if ( $enableheaderimage == 'excludehome' ) {
		if ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) {
			return false;
		}
		else {
			catchkathmandu_featured_image();	
		}
	}
	// Check Entire Site
	elseif ( $enableheaderimage == 'allpage' ) {
		catchkathmandu_featured_image();
	}
	// Check Entire Site (Post/Page)
	elseif ( $enableheaderimage == 'postpage' ) {
		if ( is_page() || is_single() ) {
			catchkathmandu_featured_page_post_image();
		}
		else {
			catchkathmandu_featured_image();
		}
	}	
	// Check Page/Post
	elseif ( $enableheaderimage == 'pagespostes' ) {
		if ( is_page() || is_single() ) {
			catchkathmandu_featured_page_post_image();
		}
	}
	else {
		echo '<!-- Disable Header Image -->';
	}
	
} // catchkathmandu_featured_overall_image
endif;
add_action( 'catchkathmandu_after_hgroup_wrap', 'catchkathmandu_featured_overall_image', 10 );


if ( ! function_exists( 'catchkathmandu_content_image' ) ) :
/**
 * Template for Featured Image in Content
 *
 * To override this in a child theme
 * simply create your own catchkathmandu_content_image(), and that function will be used instead.
 *
 * @since Catch Kathmandu 1.0
 */
function catchkathmandu_content_image() {
	global $post, $wp_query;
	
	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();
	
	if( $post) {
 		if ( is_attachment() ) { 
			$parent = $post->post_parent;
			$individual_featured_image = get_post_meta( $parent,'catchkathmandu-featured-image', true );
		} else {
			$individual_featured_image = get_post_meta( $page_id,'catchkathmandu-featured-image', true ); 
		}
	}

	if( empty( $individual_featured_image ) || ( !is_page() && !is_single() ) ) {
		$individual_featured_image='default';
	}
	
	// Getting data from Theme Options
	global $catchkathmandu_options_settings;
   	$options = $catchkathmandu_options_settings;
	
	$featured_image = $options['featured_image'];
		
	if ( ( $individual_featured_image == 'disable' || '' == get_the_post_thumbnail() || ( $individual_featured_image=='default' && $featured_image == 'disable') ) ) {
		return false;
	}
	else { ?>
		<figure class="featured-image">
            <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'catchkathmandu' ), the_title_attribute( 'echo=0' ) ) ); ?>">
                <?php 
				if ( ( is_front_page() && $featured_image == 'featured' ) ||  $individual_featured_image == 'featured' || ( $individual_featured_image=='default' && $featured_image == 'featured' ) ) {
                     the_post_thumbnail( 'featured' );
                }	
				elseif ( ( is_front_page() && $featured_image == 'slider' ) || $individual_featured_image == 'slider' || ( $individual_featured_image=='default' && $featured_image == 'slider' ) ) {
					the_post_thumbnail( 'slider' );
				}
				else {
					the_post_thumbnail( 'full' );
				} ?>
			</a>
        </figure>
   	<?php
	}
}
endif; //catchkathmandu_content_image


/**
 * Hooks the Custom Inline CSS to head section
 *
 * @since Catch Kathmandu 1.0
 */
function catchkathmandu_inline_css() {
	//delete_transient( 'catchkathmandu_inline_css' );	
	
	if ( ( !$catchkathmandu_inline_css = get_transient( 'catchkathmandu_inline_css' ) ) ) {
		// Getting data from Theme Options
		global $catchkathmandu_options_settings;
   		$options = $catchkathmandu_options_settings;

		echo '<!-- refreshing cache -->' . "\n";
		if( !empty( $options[ 'custom_css' ] ) ) {
			
			$catchkathmandu_inline_css	.= '<!-- '.get_bloginfo('name').' Custom CSS Styles -->' . "\n";
	        $catchkathmandu_inline_css 	.= '<style type="text/css" media="screen">' . "\n";
			$catchkathmandu_inline_css .=  $options['custom_css'] . "\n";
			$catchkathmandu_inline_css 	.= '</style>' . "\n";
			
		}
			
	set_transient( 'catchkathmandu_inline_css', $catchkathmandu_inline_css, 86940 );
	}
	echo $catchkathmandu_inline_css;
}
add_action('wp_head', 'catchkathmandu_inline_css');


if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
	/**
	* Filters wp_title to print a neat <title> tag based on what is being viewed.
	*
	* @param string $title Default title text for current view.
	* @param string $sep Optional separator.
	* @return string The filtered title.
	*/
	function catchkathmandu_wp_title( $title, $sep ) {
		if ( is_feed() ) {
			return $title;
		}
		
		global $page, $paged;
		
		// Add the blog name
		$title .= get_bloginfo( 'name', 'display' );
		
		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}
		
		// Add a page number if necessary:
		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
			$title .= " $sep " . sprintf( __( 'Page %s', '_s' ), max( $paged, $page ) );
		}
		
		return $title;
		
	}
		
	add_filter( 'wp_title', 'catchkathmandu_wp_title', 10, 2 );
	
	/**
	* Title shim for sites older than WordPress 4.1.
	*
	* @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
	* @todo Remove this function when WordPress 4.3 is released.
	*/
	function catchkathmandu_render_title() {
	?>
		<title><?php wp_title( '&#124;', true, 'right' ); ?></title>
	<?php
	}
	add_action( 'wp_head', 'catchkathmandu_render_title' );
endif;


/**
 * Sets the post excerpt length to 30 words.
 *
 * function tied to the excerpt_length filter hook.
 * @uses filter excerpt_length
 */
function catchkathmandu_excerpt_length( $length ) {
	// Getting data from Theme Options
	global $catchkathmandu_options_settings;
   	$options = $catchkathmandu_options_settings;

	return $options[ 'excerpt_length' ];
}
add_filter( 'excerpt_length', 'catchkathmandu_excerpt_length' );


/**
 * Change the defult excerpt length of 30 to whatever passed as value
 * 
 * @use excerpt(10) or excerpt (..)  if excerpt length needs only 10 or whatevere
 * @uses get_permalink, get_the_excerpt
 */
function catchkathmandu_excerpt_desired( $num ) {
    $limit = $num+1;
    $excerpt = explode( ' ', get_the_excerpt(), $limit );
    array_pop( $excerpt );
    $excerpt = implode( " ",$excerpt )."<a href='" .get_permalink() ." '></a>";
    return $excerpt;
}


/**
 * Returns a "Continue Reading" link for excerpts
 */
function catchkathmandu_continue_reading() {
	// Getting data from Theme Options
	global $catchkathmandu_options_settings;
   	$options = $catchkathmandu_options_settings;
    
	$more_tag_text = $options[ 'more_tag_text' ];
	return ' <a class="more-link" href="'. esc_url( get_permalink() ) . '">' .  sprintf( __( '%s', 'catchkathmandu' ) , $more_tag_text ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with catchkathmandu_continue_reading().
 *
 */
function catchkathmandu_excerpt_more( $more ) {
	return catchkathmandu_continue_reading();
}
add_filter( 'excerpt_more', 'catchkathmandu_excerpt_more' );


/**
 * Adds Continue Reading link to post excerpts.
 *
 * function tied to the get_the_excerpt filter hook.
 */
function catchkathmandu_custom_excerpt( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= catchkathmandu_continue_reading();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'catchkathmandu_custom_excerpt' );


/**
 * Replacing Continue Reading link to the_content more.
 *
 * function tied to the the_content_more_link filter hook.
 */
function catchkathmandu_more_link( $more_link, $more_link_text ) {
	// Getting data from Theme Options
	global $catchkathmandu_options_settings;
   	$options = $catchkathmandu_options_settings;
	
	$more_tag_text = $options[ 'more_tag_text' ];
	
	return str_replace( $more_link_text, $more_tag_text, $more_link );
}
add_filter( 'the_content_more_link', 'catchkathmandu_more_link', 10, 2 );


/**
 * Redirect WordPress Feeds To FeedBurner
 */
function catchkathmandu_rss_redirect() {	
	// Getting data from Theme Options
	global $catchkathmandu_options_settings;
   	$options = $catchkathmandu_options_settings;
	
    if ($options['feed_url']) {
		$url = 'Location: '.$options['feed_url'];
		if ( is_feed() && !preg_match('/feedburner|feedvalidator/i', $_SERVER['HTTP_USER_AGENT']))
		{
			header($url);
			header('HTTP/1.1 302 Temporary Redirect');
		}
	}
}
add_action('template_redirect', 'catchkathmandu_rss_redirect');


/**
 * Adds custom classes to the array of body classes.
 *
 * @since Catch Kathmandu 1.0
 */
function catchkathmandu_body_classes( $classes ) {
	global $post, $catchkathmandu_options_settings;
	$options = $catchkathmandu_options_settings;
	
	if ( is_page_template( 'page-blog.php') ) {
		$classes[] = 'page-blog';
	}
	
	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}
	
	if ( $post) {
 		if ( is_attachment() ) { 
			$parent = $post->post_parent;
			$layout = get_post_meta( $parent, 'catchkathmandu-sidebarlayout', true );
		} else {
			$layout = get_post_meta( $post->ID, 'catchkathmandu-sidebarlayout', true ); 
		}
	}

	if ( empty( $layout ) || ( !is_page() && !is_single() ) ) {
		$layout='default';
	}
	
	$themeoption_layout = $options['sidebar_layout'];
	
	if( ( $layout == 'no-sidebar' || ( $layout=='default' && $themeoption_layout == 'no-sidebar') ) ) {
		$classes[] = 'no-sidebar';
	}
	elseif( ( $layout == 'left-sidebar' || ( $layout=='default' && $themeoption_layout == 'left-sidebar') ) ){
		$classes[] = 'left-sidebar';
	}
	elseif( ( $layout == 'right-sidebar' || ( $layout=='default' && $themeoption_layout == 'right-sidebar') ) ){
		$classes[] = 'right-sidebar';
	}	
	
	$current_content_layout = $options['content_layout'];
	if( $current_content_layout == 'full' ) {
		$classes[] = 'content-full';
	}
	elseif ( $current_content_layout == 'excerpt' ) {
		$classes[] = 'content-excerpt';
	}
	
	return $classes;
}
add_filter( 'body_class', 'catchkathmandu_body_classes' );


/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 *
 * @since Catch Kathmandu 1.0
 */
function catchkathmandu_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'catchkathmandu_enhanced_image_navigation', 10, 2 );


/**
 * Shows Header Right Sidebar
 */
function catchkathmandu_header_right() { 

	/* A sidebar in the Header Right 
	*/
	get_sidebar( 'header-right' ); 

}
add_action( 'catchkathmandu_hgroup_wrap', 'catchkathmandu_header_right', 15 );


/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @since Catch Kathmandu 1.0
 */
function catchkathmandu_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'catchkathmandu_page_menu_args' );


/**
 * Removes div from wp_page_menu() and replace with ul.
 *
 * @since Catch Kathmandu 1.0 
 */
function catchkathmandu_wp_page_menu ($page_markup) {
    preg_match('/^<div class=\"([a-z0-9-_]+)\">/i', $page_markup, $matches);
        $divclass = $matches[1];
        $replace = array('<div class="'.$divclass.'">', '</div>');
        $new_markup = str_replace($replace, '', $page_markup);
        $new_markup = preg_replace('/^<ul>/i', '<ul class="'.$divclass.'">', $new_markup);
        return $new_markup; }

add_filter( 'wp_page_menu', 'catchkathmandu_wp_page_menu' );


/**
 * Function to pass the slider effect parameters from php file to js file.
 */
function catchkathmandu_pass_slider_value() {
	global $catchkathmandu_options_settings;
   	$options = $catchkathmandu_options_settings;

	$transition_effect = $options[ 'transition_effect' ];
	$transition_delay = $options[ 'transition_delay' ] * 1000;
	$transition_duration = $options[ 'transition_duration' ] * 1000;
	wp_localize_script( 
		'catchkathmandu-slider',
		'js_value',
		array(
			'transition_effect' => $transition_effect,
			'transition_delay' => $transition_delay,
			'transition_duration' => $transition_duration
		)
	);
}// catchkathmandu_pass_slider_value


if ( ! function_exists( 'catchkathmandu_post_sliders' ) ) :
/**
 * Template for Featued Post Slider
 *
 * To override this in a child theme
 * simply create your own catchkathmandu_post_sliders(), and that function will be used instead.
 *
 * @uses catchkathmandu_header action to add it in the header
 * @since Catch Kathmandu Pro 1.0
 */
function catchkathmandu_post_sliders() { 
	//delete_transient( 'catchkathmandu_post_sliders' );
	
	global $post;
	global $catchkathmandu_options_settings;
   	$options = $catchkathmandu_options_settings;

	
	if( ( !$catchkathmandu_post_sliders = get_transient( 'catchkathmandu_post_sliders' ) ) && !empty( $options[ 'featured_slider' ] ) ) {
		echo '<!-- refreshing cache -->';
		
		$catchkathmandu_post_sliders = '
		<div id="main-slider" class="container">
        	<section class="featured-slider">';
				$get_featured_posts = new WP_Query( array(
					'posts_per_page' => $options[ 'slider_qty' ],
					'post__in'		 => $options[ 'featured_slider' ],
					'orderby' 		 => 'post__in',
					'ignore_sticky_posts' => 1 // ignore sticky posts
				));
				$i=0; while ( $get_featured_posts->have_posts()) : $get_featured_posts->the_post(); $i++;
					$title_attribute = apply_filters( 'the_title', get_the_title( $post->ID ) );
					$excerpt = get_the_excerpt();
					if ( $i == 1 ) { $classes = 'post postid-'.$post->ID.' hentry slides displayblock'; } else { $classes = 'post postid-'.$post->ID.' hentry slides displaynone'; }
					$catchkathmandu_post_sliders .= '
					<article class="'.$classes.'">
						<figure class="slider-image">
							<a title="Permalink to '.the_title('','',false).'" href="' . get_permalink() . '">
								'. get_the_post_thumbnail( $post->ID, 'slider', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ), 'class'	=> 'pngfix' ) ).'
							</a>	
						</figure>
						<div class="entry-container">
							<header class="entry-header">
								<h1 class="entry-title">
									<a title="Permalink to '.the_title('','',false).'" href="' . get_permalink() . '">'.the_title( '<span>','</span>', false ).'</a>
								</h1>
							</header>';
							if( $excerpt !='') {
								$catchkathmandu_post_sliders .= '<div class="entry-content">'. $excerpt.'</div>';
							}
							$catchkathmandu_post_sliders .= '
						</div>
					</article><!-- .slides -->';				
				endwhile; wp_reset_query();
				$catchkathmandu_post_sliders .= '
			</section>
        	<div id="slider-nav">
        		<a class="slide-previous">&lt;</a>
        		<a class="slide-next">&gt;</a>
        	</div>
        	<div id="controllers"></div>
  		</div><!-- #main-slider -->';
			
	set_transient( 'catchkathmandu_post_sliders', $catchkathmandu_post_sliders, 86940 );
	}
	echo $catchkathmandu_post_sliders;	
} // catchkathmandu_post_sliders	
endif;


if ( ! function_exists( 'catchkathmandu_category_sliders' ) ) :
/**
 * Template for Featued Page Slider
 *
 * To override this in a child theme
 * simply create your own catchkathmandu_category_sliders(), and that function will be used instead.
 *
 * @uses catchkathmandu_header action to add it in the header
 * @since Catch Kathmandu Pro 1.0
 */
function catchkathmandu_category_sliders() { 
	//delete_transient( 'catchkathmandu_category_sliders' );
	
	global $post;
	global $catchkathmandu_options_settings;
   	$options = $catchkathmandu_options_settings;

	
	if( ( !$catchkathmandu_category_sliders = get_transient( 'catchkathmandu_category_sliders' ) ) && !empty( $options[ 'slider_category' ] ) ) {
		echo '<!-- refreshing cache -->';
		
		$catchkathmandu_category_sliders = '
		<div id="main-slider" class="container">
        	<section class="featured-slider">';
				$get_featured_posts = new WP_Query( array(
					'posts_per_page'		=> $options[ 'slider_qty' ],
					'category__in'			=> $options[ 'slider_category' ],
					'ignore_sticky_posts' 	=> 1 // ignore sticky posts
				));
				$i=0; while ( $get_featured_posts->have_posts()) : $get_featured_posts->the_post(); $i++;
					$title_attribute = apply_filters( 'the_title', get_the_title( $post->ID ) );
					$excerpt = get_the_excerpt();
					if ( $i == 1 ) { $classes = 'post pageid-'.$post->ID.' hentry slides displayblock'; } else { $classes = 'post pageid-'.$post->ID.' hentry slides displaynone'; }
					$catchkathmandu_category_sliders .= '
					<article class="'.$classes.'">
						<figure class="slider-image">
							<a title="Permalink to '.the_title('','',false).'" href="' . get_permalink() . '">
								'. get_the_post_thumbnail( $post->ID, 'slider', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ), 'class'	=> 'pngfix' ) ).'
							</a>	
						</figure>
						<div class="entry-container">
							<header class="entry-header">
								<h1 class="entry-title">
									<a title="Permalink to '.the_title('','',false).'" href="' . get_permalink() . '">'.the_title( '<span>','</span>', false ).'</a>
								</h1>
							</header>';
							if( $excerpt !='') {
								$catchkathmandu_category_sliders .= '<div class="entry-content">'. $excerpt.'</div>';
							}
							$catchkathmandu_category_sliders .= '
						</div>
					</article><!-- .slides -->';				
				endwhile; wp_reset_query();
				$catchkathmandu_category_sliders .= '
			</section>
        	<div id="slider-nav">
        		<a class="slide-previous">&lt;</a>
        		<a class="slide-next">&gt;</a>
        	</div>
        	<div id="controllers"></div>
  		</div><!-- #main-slider -->';
			
	set_transient( 'catchkathmandu_category_sliders', $catchkathmandu_category_sliders, 86940 );
	}
	echo $catchkathmandu_category_sliders;	
} // catchkathmandu_category_sliders	
endif;


/**
 * Shows Default Slider Demo if there is not iteam in Featured Post Slider
 */
function catchkathmandu_default_sliders() { 
	//delete_transient( 'catchkathmandu_default_sliders' );
	
	if ( !$catchkathmandu_default_sliders = get_transient( 'catchkathmandu_default_sliders' ) ) {
		echo '<!-- refreshing cache -->';	
		$catchkathmandu_default_sliders = '
		<div id="main-slider" class="container">
			<section class="featured-slider">
			
				<article class="post hentry slides demo-image displayblock">
					<figure class="slider-image">
						<a title="Kathmandu Durbar Square" href="#">
							<img src="'. get_template_directory_uri() . '/images/demo/kathmandu-durbar-square-1280x600.jpg" class="wp-post-image" alt="Kathmandu Durbar Square" title="Kathmandu Durbar Square">
						</a>
					</figure>
					<div class="entry-container">
						<header class="entry-header">
							<h1 class="entry-title">
								<a title="Kathmandu Durbar Square" href="#"><span>Kathmandu Durbar Square</span></a>
							</h1>
						</header>
						<div class="entry-content">
							<p>The Kathmandu Durbar Square holds the palaces of the Malla and Shah kings who ruled over the city. Along with these palaces, the square surrounds quadrangles revealing courtyards and temples.</p>
						</div>   
					</div>             
				</article><!-- .slides --> 		
				
				<article class="post hentry slides demo-image displaynone">
					<figure class="slider-image">
						<a title="Seto Ghumba" href="#">
							<img src="'. get_template_directory_uri() . '/images/demo/seto-ghumba-1280x600.jpg" class="wp-post-image" alt="Seto Ghumba" title="Seto Ghumba">
						</a>
					</figure>
					<div class="entry-container">
						<header class="entry-header">
							<h1 class="entry-title">
								<a title="Seto Ghumba" href="#"><span>Seto Ghumba</span></a>
							</h1>
						</header>
						<div class="entry-content">
							<p>Situated western part in the outskirts of the Kathmandu valley, Seto Gumba also known as Druk Amitabh Mountain or White Monastery, is one of the most popular Buddhist monasteries of Nepal.</p>
						</div>   
					</div>             
				</article><!-- .slides --> 		
				
				<article class="post hentry slides demo-image displaynone">
					<figure class="slider-image">
						<a title="Nagarkot Himalayan Range" href="#">
							<img src="'. get_template_directory_uri() . '/images/demo/nagarkot-mountain-view1280x600.jpg" class="wp-post-image" alt="Nagarkot Himalayan Range" title="Nagarkot Himalayan Range">
						</a>
					</figure>
					<div class="entry-container">
						<header class="entry-header">
							<h1 class="entry-title">
								<a title="Nagarkot" href="#"><span>Nagarkot</span></a>
							</h1>
						</header>
						<div class="entry-content">
							<p>Nagarkot is renowned for its sunrise view of the Himalaya including Mount Everest as well as other snow-capped peaks of the Himalayan range of eastern Nepal.</p>
						</div>   
					</div>             
				</article><!-- .slides --> 
				
			</section>
			<div id="slider-nav">
				<a class="slide-previous">&lt;</a>
				<a class="slide-next">&gt;</a>
			</div>
			<div id="controllers"></div>
		</div><!-- #main-slider -->';
			
	set_transient( 'catchkathmandu_default_sliders', $catchkathmandu_default_sliders, 86940 );
	}
	echo $catchkathmandu_default_sliders;	
} // catchkathmandu_default_sliders	


/**
 * Shows Slider
 */
function catchkathmandu_slider_display() {
	global $post, $wp_query, $catchkathmandu_options_settings;;
   	$options = $catchkathmandu_options_settings;

	// get data value from theme options
	$enableslider = $options[ 'enable_slider' ];
	$slidertype = $options[ 'select_slider_type' ];
	
	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts'); 

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();
	
	if ( ( $enableslider == 'enable-slider-allpage' ) || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && $enableslider == 'enable-slider-homepage' ) ) :
		// This function passes the value of slider effect to js file 
		if ( function_exists( 'catchkathmandu_pass_slider_value' ) ) : catchkathmandu_pass_slider_value(); endif;
		// Select Slider
		if (  $slidertype == 'post-slider' && !empty( $options[ 'featured_slider' ] ) && function_exists( 'catchkathmandu_post_sliders' ) ) {
			catchkathmandu_post_sliders();
		}
		elseif (  $slidertype == 'category-slider' && !empty( $options[ 'slider_category' ] ) && function_exists( 'catchkathmandu_category_sliders' ) ) {
			catchkathmandu_category_sliders();
		}	
		else {
			catchkathmandu_default_sliders();
		}
	endif;	
}
add_action( 'catchkathmandu_before_main', 'catchkathmandu_slider_display', 10 );


if ( ! function_exists( 'catchkathmandu_homepage_headline' ) ) :
/**
 * Template for Homepage Headline
 *
 * To override this in a child theme
 * simply create your own catchkathmandu_homepage_headline(), and that function will be used instead.
 *
 * @uses catchkathmandu_before_main action to add it in the header
 * @since Catch Kathmandu Pro 1.0
 */
function catchkathmandu_homepage_headline() { 
	//delete_transient( 'catchkathmandu_homepage_headline' );
	
	global $post, $wp_query, $catchkathmandu_options_settings;
   	$options = $catchkathmandu_options_settings;
	
	// Getting data from Theme Options
	$disable_headline = $options[ 'disable_homepage_headline' ];
	$disable_subheadline = $options[ 'disable_homepage_subheadline' ];
	$disable_button = $options[ 'disable_homepage_button' ];
	$homepage_headline = $options[ 'homepage_headline' ];
	$homepage_subheadline = $options[ 'homepage_subheadline' ];
	$homepage_headline_button = $options[ 'homepage_headline_button' ];
	$homepage_headline_url = $options[ 'homepage_headline_url' ];
	
	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts'); 

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();

	 if ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && ( empty( $disable_headline ) || empty( $disable_subheadline ) || empty( $disable_button ) ) ) { 	
		
		if ( !$catchkathmandu_homepage_headline = get_transient( 'catchkathmandu_homepage_headline' ) ) {
			
			echo '<!-- refreshing cache -->';	
			
			$catchkathmandu_homepage_headline = '<div id="homepage-message" class="container"><div class="left-section">';
			
			if ( $disable_headline == "0" ) {
				$catchkathmandu_homepage_headline .= '<h2>' . sprintf( __( '%s', 'catchkathmandu' ) , $homepage_headline ) . '</h2>';
			}
			if ( $disable_subheadline == "0" ) {
				$catchkathmandu_homepage_headline .= '<p>' . sprintf( __( '%s', 'catchkathmandu' ) , $homepage_subheadline ) . '</p>';
			}			
			
			$catchkathmandu_homepage_headline .= '</div><!-- .left-section -->';  
			
			if ( !empty ( $homepage_headline_url ) && $disable_button == "0" ) {
				$catchkathmandu_homepage_headline .= '<div class="right-section"><a href="' . $homepage_headline_url . '" target="_blank">' . $homepage_headline_button . '</a></div><!-- .right-section -->';
			}
			
			$catchkathmandu_homepage_headline .= '</div><!-- #homepage-message -->';
			
			set_transient( 'catchkathmandu_homepage_headline', $catchkathmandu_homepage_headline, 86940 );
		}
		echo $catchkathmandu_homepage_headline;	
	 }
}
endif; // catchkathmandu_homepage_featured_content

add_action( 'catchkathmandu_before_main', 'catchkathmandu_homepage_headline', 10 );

 
/**
 * Shows Default Featued Content
 *
 * @uses catchkathmandu_before_main action to add it in the header
 */
function catchkathmandu_default_featured_content() { 
	//delete_transient( 'catchkathmandu_default_featured_content' );
	
	// Getting data from Theme Options
	global $catchkathmandu_options_settings;
   	$options = $catchkathmandu_options_settings;
	$disable_homepage_featured = $options[ 'disable_homepage_featured' ];
	$headline = $options [ 'homepage_featured_headline' ];
	$layouts = $options [ 'homepage_featured_layout' ];
	
	if ( $disable_homepage_featured == "0" ) { 
		if ( !$catchkathmandu_default_featured_content = get_transient( 'catchkathmandu_default_featured_content' ) ) {					
			//Checking Layout 
			if ( $layouts == 'four-columns' ) {
				$classes = "layout-four";
			} 
			else { 
				$classes = "layout-three"; 
			}
			
			$catchkathmandu_default_featured_content = '
			<section id="featured-post" class="' . $classes . '">
				<h1 id="feature-heading" class="entry-title">Popular Places</h1>
				<div class="featued-content-wrap">
					<article id="featured-post-1" class="post hentry post-demo">
						<figure class="featured-homepage-image">
							<a href="#" title="Spectacular Dhulikhel">
								<img title="Spectacular Dhulikhel" alt="Spectacular Dhulikhel" class="wp-post-image" src="'.get_template_directory_uri() . '/images/demo/spectacular-dhulikhel-360x240.jpg" />
							</a>
						</figure>
						<div class="entry-container">
							<header class="entry-header">
								<h1 class="entry-title">
									<a title="Spectacular Dhulikhel" href="#">Spectacular Dhulikhel</a>
								</h1>
							</header>
							<div class="entry-content">
								The Mountains - A Tourist Paradise: The spectacular snowfed mountains seen from Dhuklikhel must be one of the finest panoramic views in the world.
							</div>
						</div><!-- .entry-container -->			
					</article>
	
					<article id="featured-post-2" class="post hentry post-demo">
						<figure class="featured-homepage-image">
							<a href="#" title="Swayambhunath">
								<img title="Swayambhunath" alt="Swayambhunath" class="wp-post-image" src="'.get_template_directory_uri() . '/images/demo/swayambhunath-360x240.jpg" />
							</a>
						</figure>
						<div class="entry-container">
							<header class="entry-header">
								<h1 class="entry-title">
									<a title="Swayambhunath" href="#">Swayambhunath</a>
								</h1>
							</header>
							<div class="entry-content">
								Swayambhunath is an ancient religious site up in the hill around Kathmandu Valley. It is also known as the Monkey Temple as there are holy monkeys living in the temple. 
							</div>
						</div><!-- .entry-container -->			
					</article>
					
					<article id="featured-post-3" class="post hentry post-demo">
						<figure class="featured-homepage-image">
							<a href="#" title="Wood Art">
								<img title="Wood Art" alt="Wood Art" class="wp-post-image" src="'.get_template_directory_uri() . '/images/demo/wood-art-360x240.jpg" />
							</a>
						</figure>
						<div class="entry-container">
							<header class="entry-header">
								<h1 class="entry-title">
									<a title="Wood Art" href="#">Wood Art</a>
								</h1>
							</header>
							<div class="entry-content">
								It is the traditional architecture in the Kathmandu valley in temples, palaces, monasteries and houses a perfected Neawri art form generally carved very artistically out of  Wood.
								
							</div>
						</div><!-- .entry-container -->			
					</article>
					
					<article id="featured-post-4" class="post hentry post-demo">
						<figure class="featured-homepage-image">
							<a href="#" title="Nepal Prayer Wheels">
								<img title="Nepal Prayer Wheels" alt="Nepal Prayer Wheels" class="wp-post-image" src="'.get_template_directory_uri() . '/images/demo/nepal-prayer-wheels-360x240.jpg" />
							</a>
						</figure>
						<div class="entry-container">
							<header class="entry-header">
								<h1 class="entry-title">
									<a title="Nepal Prayer Wheels" href="#">Nepal Prayer Wheels</a>
								</h1>
							</header>
							<div class="entry-content">
								A Prayer wheel is a cylindrical wheel on a spindle made from metal, wood, stone, leather or coarse cotton. The practitioner most often spins the wheel clockwise.
							</div>
						</div><!-- .entry-container -->			
					</article>
				</div><!-- .featued-content-wrap -->
			</section><!-- #featured-post -->';
		}
		echo $catchkathmandu_default_featured_content;
	}
}


if ( ! function_exists( 'catchkathmandu_homepage_featured_content' ) ) :
/**
 * Template for Homepage Featured Content
 *
 * To override this in a child theme
 * simply create your own catchkathmandu_homepage_featured_content(), and that function will be used instead.
 *
 * @uses catchkathmandu_before_main action to add it in the header
 * @since Catch Kathmandu Pro 1.0
 */
function catchkathmandu_homepage_featured_content() { 
	//delete_transient( 'catchkathmandu_homepage_featured_content' );
	
	// Getting data from Theme Options
	global $catchkathmandu_options_settings;
   	$options = $catchkathmandu_options_settings;
	$disable_homepage_featured = $options[ 'disable_homepage_featured' ];
	$quantity = $options [ 'homepage_featured_qty' ];
	$headline = $options [ 'homepage_featured_headline' ];
	$layouts = $options [ 'homepage_featured_layout' ];
	
	if ( $disable_homepage_featured == "0" ) { 
		
		if ( !$catchkathmandu_homepage_featured_content = get_transient( 'catchkathmandu_homepage_featured_content' )  && ( !empty( $options[ 'homepage_featured_image' ] ) || !empty( $options[ 'homepage_featured_title' ] ) || !empty( $options[ 'homepage_featured_content' ] ) ) ) {
			
			echo '<!-- refreshing cache -->';	
			
			//Checking Layout 
			if ( $layouts == 'four-columns' ) {
				$classes = "layout-four";
			} 
			else { 
				$classes = "layout-three"; 
			}
			
			$catchkathmandu_homepage_featured_content = '<section id="featured-post" class="' . $classes . '">';
			
			if ( !empty( $headline ) ) {
				$catchkathmandu_homepage_featured_content .= '<h1 id="feature-heading" class="entry-title">' . $headline . '</h1>';
			}
			
			$catchkathmandu_homepage_featured_content .= '<div class="featued-content-wrap">';
			
				for ( $i = 1; $i <= $quantity; $i++ ) {
					
					
					//Checking Link
					if ( !empty ( $options[ 'homepage_featured_url' ][ $i ] ) ) {
						//support qTranslate plugin
						if ( function_exists( 'qtrans_convertURL' ) ) {
							$link = qtrans_convertURL($options[ 'homepage_featured_url' ][ $i ]);
						}
						else {
							$link = $options[ 'homepage_featured_url' ][ $i ];
						}
						if ( !empty ( $options[ 'homepage_featured_base' ][ $i ] ) ) {
							$target = '_blank';
						}
						else {
							$target = '_self';	
						}
					} else {
						$link = '';
						$target = '';
					}
						
					//Checking Title
					if ( !empty ( $options[ 'homepage_featured_title' ][ $i ] ) ) {
						$title = $options[ 'homepage_featured_title' ][ $i ];
					} else {
						$title = '';
					}			
					
					if ( !empty ( $options[ 'homepage_featured_title' ][ $i ] ) || !empty ( $options[ 'homepage_featured_content' ][ $i ] ) || !empty ( $options[ 'homepage_featured_image' ][ $i ] ) ) {
						$catchkathmandu_homepage_featured_content .= '
						<article id="featured-post-'.$i.'" class="post hentry">';
							if ( !empty ( $options[ 'homepage_featured_image' ][ $i ] ) ) {
								$catchkathmandu_homepage_featured_content .= '<figure class="featured-homepage-image">';
									
									if ( !empty ( $link ) ) {
										$catchkathmandu_homepage_featured_content .= '
										<a title="'.$title.'" href="'.$link.'" target="'.$target.'">
											<img src="'.$options[ 'homepage_featured_image' ][ $i ].'" class="wp-post-image" alt="'.$title.'" title="'.$title.'">
										</a>';
									}
									else {
										$catchkathmandu_homepage_featured_content .= '
										<img src="'.$options[ 'homepage_featured_image' ][ $i ].'" class="wp-post-image" alt="'.$title.'" title="'.$title.'">';
									}

								$catchkathmandu_homepage_featured_content .= '</figure>';  
							}
							if ( !empty ( $options[ 'homepage_featured_title' ][ $i ] ) || !empty ( $options[ 'homepage_featured_content' ][ $i ] ) ) {
								$catchkathmandu_homepage_featured_content .= '<div class="entry-container">';
								
									if ( !empty ( $title ) ) { 
										
										$catchkathmandu_homepage_featured_content .= '
										<header class="entry-header">
											<h1 class="entry-title">';
												if ( !empty ( $link ) ) {
													$catchkathmandu_homepage_featured_content .= '<a href="'.$link.'" title="'.$title.'" target="'.$target.'">'.$title.'</a>';
												}
												else {
													$catchkathmandu_homepage_featured_content .= $title;
												}
											$catchkathmandu_homepage_featured_content .= '
											</h1>
										</header>';

									}
									if ( !empty ( $options[ 'homepage_featured_content' ][ $i ] ) ) { 
										
										$catchkathmandu_homepage_featured_content .= '
										<div class="entry-content">
											' . $options[ 'homepage_featured_content' ][ $i ] . '
										</div>';
										
									}
								$catchkathmandu_homepage_featured_content .= '
								</div><!-- .entry-container -->';	
							}
						$catchkathmandu_homepage_featured_content .= '			
						</article><!-- .post -->'; 	
					}
			
				}
				
			$catchkathmandu_homepage_featured_content .= '</div><!-- .featued-content-wrap -->';	
			
			$catchkathmandu_homepage_featured_content .= '</section><!-- #featured-post -->';	
			
		}
		
		echo $catchkathmandu_homepage_featured_content;
		
	}
 
}
endif; // catchkathmandu_homepage_featured_content


/**
 * Homepage Featured Content
 *
 */
function catchkathmandu_homepage_featured_display() { 
	global $post, $wp_query, $catchkathmandu_options_settings;
	
	// Getting data from Theme Options
   	$options = $catchkathmandu_options_settings;
	$disable_homepage_featured = $options[ 'disable_homepage_featured' ];
	
	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts'); 

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();
	
	if ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) {
		if  ( !empty( $options[ 'homepage_featured_image' ] ) || !empty( $options[ 'homepage_featured_title' ] ) || !empty( $options[ 'homepage_featured_content' ] ) ) {
			catchkathmandu_homepage_featured_content();
		} else {
			catchkathmandu_default_featured_content();
		}
	}
	
} // catchkathmandu_homepage_featured_content	


if ( ! function_exists( 'catchkathmandu_homepage_featured_position' ) ) :
/**
 * Homepage Featured Content Position
 *
 */
function catchkathmandu_homepage_featured_position() {
	// Getting data from Theme Options
	global $catchkathmandu_options_settings;
   	$options = $catchkathmandu_options_settings;
	$moveposition = $options[ 'move_posts_home' ];
	
	if ( empty( $moveposition ) ) { 
		add_action( 'catchkathmandu_main', 'catchkathmandu_homepage_featured_display', 10 );
	} else {
		add_action( 'catchkathmandu_after_secondary', 'catchkathmandu_homepage_featured_display', 10 );
	}
	
}
endif; // catchkathmandu_homepage_featured_position
add_action( 'catchkathmandu_before_main', 'catchkathmandu_homepage_featured_position', 10 );


if ( ! function_exists( 'catchkathmandu_content_sidebar_wrap_start' ) ) :
/**
 * Div ID content-sidebar-wrap start
 *
 */
function catchkathmandu_content_sidebar_wrap_start() {
	echo '<div id="content-sidebar-wrap">';
}
endif; // catchkathmandu_content_sidebar_wrap_start

add_action( 'catchkathmandu_content_sidebar_start', 'catchkathmandu_content_sidebar_wrap_start', 10 );


if ( ! function_exists( 'catchkathmandu_content_sidebar_wrap_end' ) ) :
/**
 * Div ID content-sidebar-wrap end
 *
 */
function catchkathmandu_content_sidebar_wrap_end() {
	echo '</div><!-- #content-sidebar-wrap -->';
}
endif; // catchkathmandu_content_sidebar_wrap_end

add_action( 'catchkathmandu_content_sidebar_end', 'catchkathmandu_content_sidebar_wrap_end', 10 );


/**
 * Third Sidebar
 *
 * @Hooked in catchkathmandu_content_sidebar_end
 * @since Catch Evolution 1.1
 */

function catchkathmandu_third_sidebar() {
	get_sidebar( 'third' ); 
}  
add_action( 'catchkathmandu_content_sidebar_end', 'catchkathmandu_third_sidebar', 15 ); 



/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 */
function catchkathmandu_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-2' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-3' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-4' ) )
		$count++;
		
	if ( is_active_sidebar( 'sidebar-5' ) )
		$count++;		

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'one';
			break;
		case '2':
			$class = 'two';
			break;
		case '3':
			$class = 'three';
			break;
		case '4':
			$class = 'four';
			break;			
	}

	if ( $class )
		echo 'class="' . $class . '"';
}


if ( ! function_exists( 'catchkathmandu_footer_content' ) ) :
/**
 * Template for Footer Content
 *
 * To override this in a child theme
 * simply create your own catchkathmandu_footer_content(), and that function will be used instead.
 *
 * @uses catchkathmandu_site_generator action to add it in the footer
 * @since Catch Kathmandu Pro 1.0
 */
function catchkathmandu_footer_content() { 
	//delete_transient( 'catchkathmandu_footer_content' );	
	
	if ( ( !$catchkathmandu_footer_content = get_transient( 'catchkathmandu_footer_content' ) ) ) {
		echo '<!-- refreshing cache -->';
		
		// get the data value from theme options
		global $catchkathmandu_options_settings;
   	 	$options = $catchkathmandu_options_settings;
		
      	$catchkathmandu_footer_content = $options[ 'footer_code' ];
		
    	set_transient( 'catchkathmandu_footer_content', $catchkathmandu_footer_content, 86940 );
    }
	echo do_shortcode( $catchkathmandu_footer_content );
}
endif;
add_action( 'catchkathmandu_site_generator', 'catchkathmandu_footer_content', 10 );


/**
 * Alter the query for the main loop in homepage
 * @uses pre_get_posts hook
 */
function catchkathmandu_alter_home( $query ){
	global $catchkathmandu_options_settings;
   	$options = $catchkathmandu_options_settings;
		
    $cats = $options[ 'front_page_category' ];

    if ( $options[ 'exclude_slider_post'] != "0" && !empty( $options[ 'featured_slider' ] ) ) {
		if( $query->is_main_query() && $query->is_home() ) {
			$query->query_vars['post__not_in'] = $options[ 'featured_slider' ];
		}
	}
	if ( !in_array( '0', $cats ) ) {
		if( $query->is_main_query() && $query->is_home() ) {
			$query->query_vars['category__in'] = $options[ 'front_page_category' ];
		}
	}
}
add_action( 'pre_get_posts','catchkathmandu_alter_home' );


if ( ! function_exists( 'catchkathmandu_social_networks' ) ) :
/**
 * Template for Social Icons
 *
 * To override this in a child theme
 * simply create your own catchkathmandu_social_networks(), and that function will be used instead.
 *
 * @since Catch Kathmandu Pro 1.0
 */
function catchkathmandu_social_networks() {
	//delete_transient( 'catchkathmandu_social_networks' );
	
	// get the data value from theme options
	global $catchkathmandu_options_settings;
   	$options = $catchkathmandu_options_settings;

    $elements = array();

	$elements = array( 	$options[ 'social_facebook' ], 
						$options[ 'social_twitter' ],
						$options[ 'social_googleplus' ],
						$options[ 'social_linkedin' ],
						$options[ 'social_pinterest' ],
						$options[ 'social_youtube' ],
						$options[ 'social_vimeo' ],
						$options[ 'social_slideshare' ],
						$options[ 'social_foursquare' ],
						$options[ 'social_flickr' ],
						$options[ 'social_tumblr' ],
						$options[ 'social_deviantart' ],
						$options[ 'social_dribbble' ],
						$options[ 'social_myspace' ],
						$options[ 'social_wordpress' ],
						$options[ 'social_rss' ],
						$options[ 'social_delicious' ],
						$options[ 'social_lastfm' ],
						$options[ 'social_instagram' ],
						$options[ 'social_github' ],
						$options[ 'social_vkontakte' ],
						$options[ 'social_myworld' ],
						$options[ 'social_odnoklassniki' ],
						$options[ 'social_goodreads' ],
						$options[ 'social_skype' ],
						$options[ 'social_soundcloud' ],
						$options[ 'social_email'],
						$options[ 'social_xing' ],
						$options[ 'social_meetup' ]
					);
	$flag = 0;
	if( !empty( $elements ) ) {
		foreach( $elements as $option) {
			if( !empty( $option ) ) {
				$flag = 1;
			}
			else {
				$flag = 0;
			}
			if( $flag == 1 ) {
				break;
			}
		}
	}	
	
	if ( ( !$catchkathmandu_social_networks = get_transient( 'catchkathmandu_social_networks' ) ) && ( $flag == 1 || !empty ( $options[ 'social_custom_image' ] ) ) )  {
		echo '<!-- refreshing cache -->';
		
		$catchkathmandu_social_networks .='
		<ul class="social-profile">';
	
			//facebook
			if ( !empty( $options[ 'social_facebook' ] ) ) {
				$catchkathmandu_social_networks .=
					'<li class="facebook"><a href="'.esc_url( $options[ 'social_facebook' ] ).'" title="'. esc_attr__( 'Facebook', 'catchkathmandu' ) .'" target="_blank">'. esc_attr__( 'Facebook', 'catchkathmandu' ) .'</a></li>';
			}
			//Twitter
			if ( !empty( $options[ 'social_twitter' ] ) ) {
				$catchkathmandu_social_networks .=
					'<li class="twitter"><a href="'.esc_url( $options[ 'social_twitter' ] ).'" title="'. esc_attr__( 'Twitter', 'catchkathmandu' ) .'" target="_blank">'. esc_attr__( 'Twitter', 'catchkathmandu' ) .'</a></li>';
			}
			//Google+
			if ( !empty( $options[ 'social_googleplus' ] ) ) {
				$catchkathmandu_social_networks .=
					'<li class="google-plus"><a href="'.esc_url( $options[ 'social_googleplus' ] ).'" title="'. esc_attr__( 'Google+', 'catchkathmandu' ) .'" target="_blank">'. esc_attr__( 'Google+', 'catchkathmandu' ) .'</a></li>';
			}
			//Linkedin
			if ( !empty( $options[ 'social_linkedin' ] ) ) {
				$catchkathmandu_social_networks .=
					'<li class="linkedin"><a href="'.esc_url( $options[ 'social_linkedin' ] ).'" title="'. esc_attr__( 'LinkedIn', 'catchkathmandu' ) .'" target="_blank">'. esc_attr__( 'LinkedIn', 'catchkathmandu' ) .'</a></li>';
			}
			//Pinterest
			if ( !empty( $options[ 'social_pinterest' ] ) ) {
				$catchkathmandu_social_networks .=
					'<li class="pinterest"><a href="'.esc_url( $options[ 'social_pinterest' ] ).'" title="'. esc_attr__( 'Pinterest', 'catchkathmandu' ) .'" target="_blank">'. esc_attr__( 'Pinterest', 'catchkathmandu' ) .'</a></li>';
			}				
			//YouTube
			if ( !empty( $options[ 'social_youtube' ] ) ) {
				$catchkathmandu_social_networks .=
					'<li class="you-tube"><a href="'.esc_url( $options[ 'social_youtube' ] ).'" title="'. esc_attr__( 'YouTube', 'catchkathmandu' ) .'" target="_blank">'. esc_attr__( 'YouTube', 'catchkathmandu' ) .'</a></li>';
			}
			//Vimeo
			if ( !empty( $options[ 'social_vimeo' ] ) ) {
				$catchkathmandu_social_networks .=
					'<li class="viemo"><a href="'.esc_url( $options[ 'social_vimeo' ] ).'" title="'. esc_attr__( 'Vimeo', 'catchkathmandu' ) .'" target="_blank">'. esc_attr__( 'Vimeo', 'catchkathmandu' ) .'</a></li>';
			}				
			//Slideshare
			if ( !empty( $options[ 'social_slideshare' ] ) ) {
				$catchkathmandu_social_networks .=
					'<li class="slideshare"><a href="'.esc_url( $options[ 'social_slideshare' ] ).'" title="'. esc_attr__( 'SlideShare', 'catchkathmandu' ) .'" target="_blank">'. esc_attr__( 'SlideShare', 'catchkathmandu' ) .'</a></li>';
			}				
			//FourSquare
			if ( !empty( $options[ 'social_foursquare' ] ) ) {
				$catchkathmandu_social_networks .=
					'<li class="foursquare"><a href="'.esc_url( $options[ 'social_foursquare' ] ).'" title="'. esc_attr__( 'FourSquare', 'catchkathmandu' ) .'" target="_blank">'. esc_attr__( 'FourSquare', 'catchkathmandu' ) .'</a></li>';
			}
			//Flickr
			if ( !empty( $options[ 'social_flickr' ] ) ) {
				$catchkathmandu_social_networks .=
					'<li class="flickr"><a href="'.esc_url( $options[ 'social_flickr' ] ).'" title="'. esc_attr__( 'Flickr', 'catchkathmandu' ) .'" target="_blank">'. esc_attr__( 'Flickr', 'catchkathmandu' ) .'</a></li>';
			}
			//Tumblr
			if ( !empty( $options[ 'social_tumblr' ] ) ) {
				$catchkathmandu_social_networks .=
					'<li class="tumblr"><a href="'.esc_url( $options[ 'social_tumblr' ] ).'" title="'. esc_attr__( 'Tumblr', 'catchkathmandu' ) .'" target="_blank">'. esc_attr__( 'Tumblr', 'catchkathmandu' ) .'</a></li>';
			}
			//deviantART
			if ( !empty( $options[ 'social_deviantart' ] ) ) {
				$catchkathmandu_social_networks .=
					'<li class="deviantart"><a href="'.esc_url( $options[ 'social_deviantart' ] ).'" title="'. esc_attr__( 'deviantART', 'catchkathmandu' ) .'" target="_blank">'. esc_attr__( 'deviantART', 'catchkathmandu' ) .'</a></li>';
			}
			//Dribbble
			if ( !empty( $options[ 'social_dribbble' ] ) ) {
				$catchkathmandu_social_networks .=
					'<li class="dribbble"><a href="'.esc_url( $options[ 'social_dribbble' ] ).'" title="'. esc_attr__( 'Dribbble', 'catchkathmandu' ) .'" target="_blank">'. esc_attr__( 'Dribbble', 'catchkathmandu' ) .'</a></li>';
			}
			//MySpace
			if ( !empty( $options[ 'social_myspace' ] ) ) {
				$catchkathmandu_social_networks .=
					'<li class="myspace"><a href="'.esc_url( $options[ 'social_myspace' ] ).'" title="'. esc_attr__( 'MySpace', 'catchkathmandu' ) .'" target="_blank">'. esc_attr__( 'MySpace', 'catchkathmandu' ) .'</a></li>';
			}
			//WordPress
			if ( !empty( $options[ 'social_wordpress' ] ) ) {
				$catchkathmandu_social_networks .=
					'<li class="wordpress"><a href="'.esc_url( $options[ 'social_wordpress' ] ).'" title="'. esc_attr__( 'WordPress', 'catchkathmandu' ) .'" target="_blank">'. esc_attr__( 'WordPress', 'catchkathmandu' ) .'</a></li>';
			}				
			//RSS
			if ( !empty( $options[ 'social_rss' ] ) ) {
				$catchkathmandu_social_networks .=
					'<li class="rss"><a href="'.esc_url( $options[ 'social_rss' ] ).'" title="'. esc_attr__( 'RSS', 'catchkathmandu' ) .'" target="_blank">'. esc_attr__( 'RSS', 'catchkathmandu' ) .'</a></li>';
			}
			//Delicious
			if ( !empty( $options[ 'social_delicious' ] ) ) {
				$catchkathmandu_social_networks .=
					'<li class="delicious"><a href="'.esc_url( $options[ 'social_delicious' ] ).'" title="'. esc_attr__( 'Delicious', 'catchkathmandu' ) .'" target="_blank">'. esc_attr__( 'Delicious', 'catchkathmandu' ) .'</a></li>';
			}				
			//Last.fm
			if ( !empty( $options[ 'social_lastfm' ] ) ) {
				$catchkathmandu_social_networks .=
					'<li class="lastfm"><a href="'.esc_url( $options[ 'social_lastfm' ] ).'" title="'. esc_attr__( 'Last.fm', 'catchkathmandu' ) .'" target="_blank">'. esc_attr__( 'Last.fm', 'catchkathmandu' ) .'</a></li>';
			}				
			//Instagram
			if ( !empty( $options[ 'social_instagram' ] ) ) {
				$catchkathmandu_social_networks .=
					'<li class="instagram"><a href="'.esc_url( $options[ 'social_instagram' ] ).'" title="'. esc_attr__( 'Instagram', 'catchkathmandu' ) .'" target="_blank">'. esc_attr__( 'Instagram', 'catchkathmandu' ) .'</a></li>';
			}
			//GitHub
			if ( !empty( $options[ 'social_github' ] ) ) {
				$catchkathmandu_social_networks .=
					'<li class="github"><a href="'.esc_url( $options[ 'social_github' ] ).'" title="'. esc_attr__( 'GitHub', 'catchkathmandu' ) .'" target="_blank">'. esc_attr__( 'GitHub', 'catchkathmandu' ) .'</a></li>';
			}	
			//Vkontakte
			if ( !empty( $options[ 'social_vkontakte' ] ) ) {
				$catchkathmandu_social_networks .=
					'<li class="vkontakte"><a href="'.esc_url( $options[ 'social_vkontakte' ] ).'" title="'. esc_attr__( 'Vkontakte', 'catchkathmandu' ) .'" target="_blank">'. esc_attr__( 'Vkontakte', 'catchkathmandu' ) .'</a></li>';
			}				
			//My World
			if ( !empty( $options[ 'social_myworld' ] ) ) {
				$catchkathmandu_social_networks .=
					'<li class="myworld"><a href="'.esc_url( $options[ 'social_myworld' ] ).'" title="'. esc_attr__( 'My World', 'catchkathmandu' ) .'" target="_blank">'. esc_attr__( 'My World', 'catchkathmandu' ) .'</a></li>';
			}				
			//Odnoklassniki
			if ( !empty( $options[ 'social_odnoklassniki' ] ) ) {
				$catchkathmandu_social_networks .=
					'<li class="odnoklassniki"><a href="'.esc_url( $options[ 'social_odnoklassniki' ] ).'" title="'. esc_attr__( 'Odnoklassniki', 'catchkathmandu' ) .'" target="_blank">'. esc_attr__( 'Odnoklassniki', 'catchkathmandu' ) .'</a></li>';
			}
			//Goodreads
			if ( !empty( $options[ 'social_goodreads' ] ) ) {
				$catchkathmandu_social_networks .=
					'<li class="goodreads"><a href="'.esc_url( $options[ 'social_goodreads' ] ).'" title="'. esc_attr__( 'GoodReads', 'catchkathmandu' ) .'" target="_blank">'. esc_attr__( 'GoodReads', 'catchkathmandu' ) .'</a></li>';
			}
			//Skype
			if ( !empty( $options[ 'social_skype' ] ) ) {
				$catchkathmandu_social_networks .=
					'<li class="skype"><a href="'.esc_attr( $options[ 'social_skype' ] ).'" title="'. esc_attr__( 'Skype', 'catchkathmandu' ) .'" target="_blank">'. esc_attr__( 'Skype', 'catchkathmandu' ) .'</a></li>';
			}
			//Soundcloud
			if ( !empty( $options[ 'social_soundcloud' ] ) ) {
				$catchkathmandu_social_networks .=
					'<li class="soundcloud"><a href="'.esc_url( $options[ 'social_soundcloud' ] ).'" title="'. esc_attr__( 'SoundCloud', 'catchkathmandu' ) .'" target="_blank">'. esc_attr__( 'SoundCloud', 'catchkathmandu' ) .'</a></li>';
			}
			//Email
			if ( !empty( $options[ 'social_email' ] ) ) {
				$catchkathmandu_social_networks .=
					'<li class="email"><a href="mailto:'.sanitize_email( $options[ 'social_email' ] ).'" title="'. esc_attr__( 'Email', 'catchkathmandu' ) .'" target="_blank">'. esc_attr__( 'Email', 'catchkathmandu' ) .'</a></li>';
			}	
			//Contact
			if ( !empty( $options[ 'social_contact' ] ) ) {
				$catchkathmandu_social_networks .=
					'<li class="contactus"><a href="'.esc_url( $options[ 'social_contact' ] ).'" title="'. esc_attr__( 'Contact', 'catchkathmandu' ) .'">'. esc_attr__( 'Contact', 'catchkathmandu' ) .'</a></li>';
			}			
			//Xing
			if ( !empty( $options[ 'social_xing' ] ) ) {
				$catchkathmandu_social_networks .=
					'<li class="xing"><a href="'.esc_url( $options[ 'social_xing' ] ).'" title="'. esc_attr__( 'Xing', 'catchkathmandu' ) .'" target="_blank">'. esc_attr__( 'Xing', 'catchkathmandu' ) .'</a></li>';
			}	
			//Meetup
			if ( !empty( $options[ 'social_meetup' ] ) ) {
				$catchkathmandu_social_networks .=
					'<li class="meetup"><a href="'.esc_url( $options[ 'social_meetup' ] ).'" title="'. esc_attr__( 'Meetup', 'catchkathmandu' ) .'" target="_blank">'. esc_attr__( 'Meetup', 'catchkathmandu' ) .'</a></li>';
			}	
			
			$catchkathmandu_social_networks .='
		</ul>';
		
		set_transient( 'catchkathmandu_social_networks', $catchkathmandu_social_networks, 86940 );	 
	}
	echo $catchkathmandu_social_networks;
}
endif; // catchkathmandu_social_networks


/**
 * Site Verification and Header Code from the Theme Option
 *
 * If user sets the code we're going to display meta verification
 * @get the data value from theme options
 * @uses wp_head action to add the code in the header
 * @uses set_transient and delete_transient API for cache
 */
function catchkathmandu_webmaster() {
	//delete_transient( 'catchkathmandu_webmaster' );	
	
	if ( ( !$catchkathmandu_webmaster = get_transient( 'catchkathmandu_webmaster' ) ) ) {

		// get the data value from theme options
		global $catchkathmandu_options_settings;
   		$options = $catchkathmandu_options_settings;
		echo '<!-- refreshing cache -->';	
		
		$catchkathmandu_webmaster = '';
		//google
		if ( !empty( $options['google_verification'] ) ) {
			$catchkathmandu_webmaster .= '<meta name="google-site-verification" content="' .  $options['google_verification'] . '" />' . "\n";
		}
		//bing
		if ( !empty( $options['bing_verification'] ) ) {
			$catchkathmandu_webmaster .= '<meta name="msvalidate.01" content="' .  $options['bing_verification']  . '" />' . "\n";
		}
		//yahoo
		 if ( !empty( $options['yahoo_verification'] ) ) {
			$catchkathmandu_webmaster .= '<meta name="y_key" content="' .  $options['yahoo_verification']  . '" />' . "\n";
		}
		//site stats, analytics header code
		if ( !empty( $options['analytic_header'] ) ) {
			$catchkathmandu_webmaster =  $options[ 'analytic_header' ] ;
		}
			
		set_transient( 'catchkathmandu_webmaster', $catchkathmandu_webmaster, 86940 );
	}
	echo $catchkathmandu_webmaster;
}
add_action('wp_head', 'catchkathmandu_webmaster');


/**
 * This function loads the Footer Code such as Add this code from the Theme Option
 *
 * @get the data value from theme options
 * @load on the footer ONLY
 * @uses wp_footer action to add the code in the footer
 * @uses set_transient and delete_transient
 */
function catchkathmandu_footercode() {
	//delete_transient( 'catchkathmandu_footercode' );	
	
	if ( ( !$catchkathmandu_footercode = get_transient( 'catchkathmandu_footercode' ) ) ) {

		// get the data value from theme options
		global $catchkathmandu_options_settings;
   		$options = $catchkathmandu_options_settings;
		echo '<!-- refreshing cache -->';	
		
		//site stats, analytics header code
		if ( !empty( $options['analytic_footer'] ) ) {
			$catchkathmandu_footercode =  $options[ 'analytic_footer' ] ;
		}
			
		set_transient( 'catchkathmandu_footercode', $catchkathmandu_footercode, 86940 );
	}
	echo $catchkathmandu_footercode;
}
add_action('wp_footer', 'catchkathmandu_footercode');


/**
 * Adds in post and Page ID when viewing lists of posts and pages
 * This will help the admin to add the post ID in featured slider
 * 
 * @param mixed $post_columns
 * @return post columns
 */
function catchkathmandu_post_id_column( $post_columns ) {
	$beginning = array_slice( $post_columns, 0 ,1 );
	$beginning[ 'postid' ] = __( 'ID', 'catchkathmandu'  );
	$ending = array_slice( $post_columns, 1 );
	$post_columns = array_merge( $beginning, $ending );
	return $post_columns;
}
add_filter( 'manage_posts_columns', 'catchkathmandu_post_id_column' );

function catchkathmandu_posts_id_column( $col, $val ) {
	if( $col == 'postid' ) echo $val;
}
add_action( 'manage_posts_custom_column', 'catchkathmandu_posts_id_column', 10, 2 );

function catchkathmandu_posts_id_column_css() {
	echo '<style type="text/css">#postid { width: 40px; }</style>';
}
add_action( 'admin_head-edit.php', 'catchkathmandu_posts_id_column_css' );


if ( ! function_exists( 'catchkathmandu_menu_alter' ) ) :
/**
* Add default navigation menu to nav menu
* Used while viewing on smaller screen
*/
function catchkathmandu_menu_alter( $items, $args ) {
	$items .= '<li class="default-menu"><a href="' . esc_url( home_url( '/' ) ) . '" title="Menu">'.__( 'Menu', 'catchkathmandu' ).'</a></li>';
	return $items;
}
endif; // catchkathmandu_menu_alter
add_filter( 'wp_nav_menu_items', 'catchkathmandu_menu_alter', 10, 2 );


if ( ! function_exists( 'catchkathmandu_pagemenu_alter' ) ) :
/**
 * Add default navigation menu to page menu
 * Used while viewing on smaller screen
 */
function catchkathmandu_pagemenu_alter( $output ) {
	$output .= '<li class="default-menu"><a href="' . esc_url( home_url( '/' ) ) . '" title="Menu">'.__( 'Menu', 'catchkathmandu' ).'</a></li>';
	return $output;
}
endif; // catchkathmandu_pagemenu_alter
add_filter( 'wp_list_pages', 'catchkathmandu_pagemenu_alter' );


if ( ! function_exists( 'catchkathmandu_pagemenu_filter' ) ) :
/**
 * @uses wp_page_menu filter hook
 */
function catchkathmandu_pagemenu_filter( $text ) {
	$replace = array(
		'current_page_item'     => 'current-menu-item'
	);

	$text = str_replace( array_keys( $replace ), $replace, $text );
  	return $text;
	
}
endif; // catchkathmandu_pagemenu_filter
add_filter('wp_page_menu', 'catchkathmandu_pagemenu_filter');


/**
 * Shows Header Top Sidebar
 */
function catchkathmandu_header_top() { 

	/* A sidebar in the Header Top 
	*/
	get_sidebar( 'header-top' ); 

}
add_action( 'catchkathmandu_before_hgroup_wrap', 'catchkathmandu_header_top', 10 );


/**
 * Get the Web Clip Icon Image from theme options
 *
 * @uses web_clip and remove_web_clip 
 * @get the data value of image from theme options
 * @display webclip icons
 *
 * @uses default Web Click Icon if web_clip field on theme options is empty
 *
 * @uses set_transient and delete_transient 
 */
function catchkathmandu_web_clip() {
	//delete_transient( 'catchkathmandu_web_clip' );	
	
	if( ( !$catchkathmandu_web_clip = get_transient( 'catchkathmandu_web_clip' ) ) ) {
		
		// get the data value from theme options
		global $catchkathmandu_options_settings;
   		$options = $catchkathmandu_options_settings;
		
		echo '<!-- refreshing cache -->';
		if ( empty( $options[ 'remove_web_clip' ] ) ) :
			// if not empty web_clip on theme options
			if ( !empty( $options[ 'web_clip' ] ) ) :
				$catchkathmandu_web_clip = '<link rel="apple-touch-icon-precomposed" href="'.esc_url( $options[ 'web_clip' ] ).'" />'; 	
			else:
				// if empty web_clip on theme options, display default webclip icon
				$catchkathmandu_web_clip = '<link rel="apple-touch-icon-precomposed" href="'. get_template_directory_uri() .'/images/apple-touch-icon.png" />';
			endif;
		endif;
		
		set_transient( 'catchkathmandu_web_clip', $catchkathmandu_web_clip, 86940 );	
	}	
	echo $catchkathmandu_web_clip ;	
} // catchkathmandu_web_clip

//Load webclip icon in Header Section
add_action( 'wp_head', 'catchkathmandu_web_clip' );


if ( ! function_exists( 'catchkathmandu_breadcrumb_display' ) ) :
/**
 * Display breadcrumb on header
 */
function catchkathmandu_breadcrumb_display() {
	global $post, $wp_query;
	
	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts'); 

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();

	if ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) {
		return false;
	}
	else {
		if ( function_exists( 'bcn_display_list' ) ) {
			echo 
			'<div class="breadcrumb container">
				<ul>';
					bcn_display_list();
					echo '	
				</ul>
				<div class="row-end"></div>
			</div> <!-- .breadcrumb -->';	
		}
	}
	
} // catchkathmandu_breadcrumb_display
endif;

// Load  breadcrumb in catchkathmandu_after_hgroup_wrap hook
add_action( 'catchkathmandu_after_hgroup_wrap', 'catchkathmandu_breadcrumb_display', 30 );


/**
 * This function loads Scroll Up Navigation
 *
 * @uses catchkathmandu_after_footer action
 */
function catchkathmandu_scrollup() {
	
	echo '<a href="#masthead" id="scrollup"></a>';
	
}
add_action( 'catchkathmandu_after_footer', 'catchkathmandu_scrollup', 10 );
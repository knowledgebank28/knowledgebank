<?php
/* ------------------------------------------------------------------------- *
 *  Custom functions
/* ------------------------------------------------------------------------- */
	
	// Add your custom functions here, or overwrite existing ones. Read more how to use:
	// http://codex.wordpress.org/Child_Themes
	
// Implement Custom Header features.
require get_stylesheet_directory() . '/inc/custom-header.php';

if ( ! function_exists( 'sequel_setup' ) ) :
function sequel_setup() {
    
	load_child_theme_textdomain( 'sequel', get_stylesheet_directory() . '/languages' );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'social'   => __( 'Social Profile menu in left sidebar', 'sequel' ),
	) );
}
endif; // twentyfourteen_setup
add_action( 'after_setup_theme', 'sequel_setup' );

// Custom query for the post feed grid
/**
 * Ignore and exclude grid posts on the home page.
 */
if ( get_theme_mod( 'sequel_top_grid_visibility' ) != 1 ) {
function sequel_pre_get_posts( $query ) {
	if ( ! $query->is_main_query() || is_admin() )
		return;

	if ( $query->is_home() ) { // condition should be (almost) the same as in index.php
		$query->set( 'ignore_sticky_posts', true );

		$exclude_ids = array();
		$grid_posts = sequel_get_grid_posts();

		if ( $grid_posts->have_posts() )
			foreach ( $grid_posts->posts as $post )
				$exclude_ids[] = $post->ID;

		$query->set( 'post__not_in', $exclude_ids );
	}
}
add_action( 'pre_get_posts', 'sequel_pre_get_posts' );
}
/**
 * Returns a new WP_Query with grid posts.
 */
function sequel_get_grid_posts() {
	global $wp_query;

	// Jetpack Featured Content support
	$sticky = apply_filters( 'sequel_get_grid_posts', array() );
	if ( ! empty( $sticky ) )
		$sticky = wp_list_pluck( $sticky, 'ID' );

	if ( empty( $sticky ) )
		$sticky = (array) get_option( 'sticky_posts', array() );

	if ( empty( $sticky ) ) {
		return new WP_Query( array(
			'posts_per_page' => get_theme_mod( 'sequel_grid_number' ),
			'ignore_sticky_posts' => true,
		) );
	}

	$args = array(
		'posts_per_page' => get_theme_mod( 'sequel_grid_number' ),
		'post__in' => $sticky,
		'ignore_sticky_posts' => true,
	);

	return new WP_Query( $args );
}

/**
 * Customizer additions.
 */
require get_stylesheet_directory() . '/inc/sequel-customizer.php';

function sequel_body_classes( $classes ) {
    if ( is_home() && get_theme_mod( 'sequel_home_top_grid' ) !=1 ) {
		$classes[] = 'home-grid';
	}
	
	if ( is_home() && 'home-grid' == get_theme_mod( 'sequel_blog_feed_layout' ) ) {
		$classes[] = 'home-grid';
	}
	return $classes;
}
add_filter( 'body_class', 'sequel_body_classes' );

/**
 * Add filter to the_content.
 *
 * @since Fourteen Extended 1.1.2
 */
if ( get_theme_mod( 'sequel_home_excerpts' ) != 0 ) {
function sequel_excerpts($content = false) {

// If is the home page, an archive, or search results
	if(is_home() ) :
		global $post;
		$content = $post->post_excerpt;

	// If an excerpt is set in the Optional Excerpt box
		if($content) :
		$content = apply_filters('the_excerpt', $content);

	// If no excerpt is set
		else :
			$content = $post->post_content;
			if (get_theme_mod( 'sequel_excerpt_length' )) :
			$excerpt_length = esc_html(get_theme_mod( 'sequel_excerpt_length' ));
			else : 
			$excerpt_length = 30;
			endif;
			$words = explode(' ', $content, $excerpt_length + 1);
			$more = ( sequel_read_more() );
			if(count($words) > $excerpt_length) :
				array_pop($words);
				array_push($words, $more);
				$content = implode(' ', $words);
			endif;
			
			// If post format is video use first video as excerpt
            $postcustom = get_post_custom_keys();
            if ($postcustom){
                $i = 1;
                foreach ($postcustom as $key){
                    if (strpos($key,'oembed')){
                        foreach (get_post_custom_values($key) as $video){
                            if ($i == 1){
                            $content = $video;
                            }
                            $i++;
                        }
                    }  
                }
            }
			$content = $content;
		endif;
	endif;

// Make sure to return the content
	return $content;
}
add_filter('the_content', 'sequel_excerpts');

/**
 * Returns a "Continue Reading" link for excerpts
 */
function sequel_read_more() {
    return '&hellip; <a href="' . get_permalink() . '">' . __('Continue Reading &#8250;&#8250;', 'sequel') . '</a><!-- end of .read-more -->';
}
//End filter to the_content
}

// Lets do a separate excerpt length for the alternative recent post widget
// Lets do a separate excerpt length for the alternative recent post widget
function sequel_grid_excerpt () {
	$theContent = trim(strip_tags(get_the_content()));
		$output = str_replace( '"', '', $theContent);
		$output = str_replace( '\r\n', ' ', $output);
		$output = str_replace( '\n', ' ', $output);
			$limit = '15';
			$content = explode(' ', $output, $limit);
			array_pop($content);
		$content = implode(" ",$content)."  ";
	return strip_tags($content, ' ');
}

if ( ! function_exists( 'sequel_the_author' ) ) :
/**
 * Print a list of all site contributors who published at least one post.
 *
 * @since Sequel 1.0
 *
 * @return void
 */
function sequel_the_author() {
	$contributor_ids = get_users( array(
		'fields'  => 'ID',
		'orderby' => 'post_count',
		'order'   => 'DESC',
		'who'     => 'authors',
	) );

	foreach ( $contributor_ids as $contributor_id ) :
		$post_count = count_user_posts( $contributor_id );

		// Move on if user has not published a post (yet).
		if ( ! $post_count ) {
			continue;
		}
	?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="contributor the-author">
			<div class="contributor-info the-author" style="">
				<div class="contributor-avatar"><?php echo get_avatar( $contributor_id, 132 ); ?></div>
				<div class="contributor-summary">
					<h1 class="archive-title"><?php printf( __( 'All Articles by %s', 'sequel' ), get_the_author() ); ?></h1>
					<p class="author-description">
					    <?php echo get_the_author_meta( 'description', $contributor_id ); ?>
					</p>
					<span class="contributor-posts-link">
						<?php printf( _n( '%d Article', '%d Articles', $post_count, 'sequel' ), $post_count ); ?>
				    </span>
				</div><!-- .contributor-summary -->
			</div><!-- .contributor-info -->
		</div><!-- .contributor -->
	</article><!-- #post-## -->
<?php endforeach;
}
endif;


function sequel_featured_css() {
if ( get_theme_mod( 'featured_content_location' ) == 'fullwidth' && twentyfourteen_has_featured_posts() ) {
// Apply custom settings to appropriate element ?>
    <style>@media screen and (min-width: 1080px){.featured-content{margin-top:0;padding-left:0px;padding-right:0px;z-index:3;}}</style>
<?php }

if ( get_theme_mod( 'sequel_home_grid_columns' ) ) {
	// Apply custom settings to appropriate element ?>
    <style>
	    @media screen and (min-width: 1008px) {
		    .home-grid .grid-content .hentry {
		        width: 24.999999975%;
	        }
	        .home-grid .grid-content .hentry:nth-child( 3n+1 ) {
		        clear: none;
	        }
	        .home-grid .grid-content .hentry:nth-child( 4n+1 ) {
		        clear: both;
	        }
	    }
	</style>
<?php }

}
add_action( 'wp_head', 'sequel_featured_css', 210 );

function sequel_rtl_stylesheet() {

	if ( is_rtl() && is_child_theme() && file_exists( get_template_directory() . '/rtl.css' ) && ! file_exists( get_stylesheet_directory() . '/rtl.css' ) ) {
		wp_enqueue_style( 'parent-theme-rtl', get_template_directory_uri() . '/rtl.css' );
	}
}
add_action('wp_print_styles', 'sequel_rtl_stylesheet');
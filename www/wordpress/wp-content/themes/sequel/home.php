<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Sequel
 * @since Sequel 1.0
 */

get_header(); ?>

<div id="main-content" class="main-content">

<?php
if ( get_theme_mod( 'featured_content_location' ) == 'default' ) {
	if ( is_front_page() && twentyfourteen_has_featured_posts() ) {
		// Include the featured content template.
		get_template_part( 'featured-content' );
	}
}

if ( get_theme_mod( 'sequel_top_grid_visibility' ) != 1 ) {
   if ( is_front_page() || is_home() ) {
		// Include the featured content template.
		get_template_part( 'content', 'top' );
	}
}
 
    if ( get_theme_mod( 'sequel_blog_feed_layout' ) == 'home-grid' ) {
	    get_template_part( 'content', 'grid' );
	} else {
	    get_template_part( 'content', 'home' );	
    } ?>
	
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();

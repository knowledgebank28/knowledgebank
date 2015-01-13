<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Catch Themes
 * @subpackage Catch Kathmandu
 * @since Catch Kathmandu 1.0
 */

if ( ! function_exists( 'catchkathmandu_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 *
 * @since Catch Kathmandu 1.0
 */
function catchkathmandu_content_nav( $nav_id ) {
	global $wp_query, $post;

	/**
	 * Check Jetpack Infinite Scroll
	 * if it's active then disable pagination
	 */
	if ( class_exists( 'Jetpack', false ) ) {
		$jetpack_active_modules = get_option('jetpack_active_modules');
		if ( $jetpack_active_modules && in_array( 'infinite-scroll', $jetpack_active_modules ) ) {
			return false;
		}
	}	
	
	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = 'site-navigation paging-navigation';
	if ( is_single() )
		$nav_class = 'site-navigation post-navigation';

	?>
	<nav role="navigation" id="<?php echo $nav_id; ?>" class="<?php echo $nav_class; ?>">
		<h1 class="assistive-text"><?php _e( 'Post navigation', 'catchkathmandu' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'catchkathmandu' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'catchkathmandu' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( function_exists('wp_pagenavi' ) )  { 
            wp_pagenavi();
        }
        elseif ( function_exists('wp_page_numbers' ) ) { 
            wp_page_numbers();
        }
		else { ?>
			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'catchkathmandu' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
            <div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'catchkathmandu' ) ); ?></div>
            <?php endif; ?>
       	<?php } ?>

	<?php endif; ?>

	</nav><!-- #<?php echo $nav_id; ?> -->
	<?php
}
endif; // catchkathmandu_content_nav


if ( ! function_exists( 'catchkathmandu_content_query_nav' ) ) :
/**
 * Display navigation to next/previous pages for custom query
 *
 * @since Catch Kathmandu 1.0
 */
function catchkathmandu_content_query_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = 'site-navigation paging-navigation';
	if ( is_single() )
		$nav_class = 'site-navigation post-navigation';

	?>
	<nav role="navigation" id="<?php echo $nav_id; ?>" class="<?php echo $nav_class; ?>">
		<h1 class="assistive-text"><?php _e( 'Post navigation', 'catchkathmandu' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'catchkathmandu' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'catchkathmandu' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( function_exists('wp_pagenavi' ) )  { 
            wp_pagenavi();
        }
        elseif ( function_exists('wp_page_numbers' ) ) { 
            wp_page_numbers();
        }
		else { ?>
			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'catchkathmandu' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
            <div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'catchkathmandu' ) ); ?></div>
            <?php endif; ?>
       	<?php } ?>

	<?php endif; ?>

	</nav><!-- #<?php echo $nav_id; ?> -->
	<?php
}
endif; // catchkathmandu_content_query_nav


if ( ! function_exists( 'catchkathmandu_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own catchkathmandu_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Catch Kathmandu Pro 1.0
 */
function catchkathmandu_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'catchkathmandu' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'catchkathmandu' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 44 );
					printf( '<cite class="fn">%1$s %2$s</cite>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'catchkathmandu' ) . '</span>' : ''
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'catchkathmandu' ), get_comment_date(), get_comment_time() )
					);
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'catchkathmandu' ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', 'catchkathmandu' ), '<p class="edit-link">', '</p>' ); ?>
			</section><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'catchkathmandu' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;


if ( ! function_exists( 'catchkathmandu_header_meta' ) ) :
/**
 * Prints HTML with meta information for the normal post header: date and author
 *
 * Create your own catchkathmandu_header_meta() to override in a child theme.
 *
 * @since Catch Kathmandu 1.0
 */
function catchkathmandu_header_meta() {
	
	$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);
	
	$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'catchkathmandu' ), get_the_author() ) ),
		get_the_author()
	);
	
	// Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
		$utility_text = __( '<span class="on-date">Posted on %1$s</span><span class="by-author"> by %2$s</span>', 'catchkathmandu' );

	printf(
		$utility_text,
		$date,
		$author
	);
}
endif;


if ( ! function_exists( 'catchkathmandu_footer_meta' ) ) :
/**
 * Prints HTML with meta information for the normal post footer: date and author
 *
 * Create your own catchkathmandu_footer_meta() to override in a child theme.
 *
 * @since Catch Kathmandu 1.0
 */
function catchkathmandu_footer_meta() {
	
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'catchkathmandu' ) );

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'catchkathmandu' ) );


	// Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
	if ( $tag_list ) {
		$utility_text = __( '<span class="in-category">Posted in %1$s</span><span class="sep"> | </span><span class="in-tag">Tagged %2$s</span>', 'catchkathmandu' );
	} elseif ( $categories_list ) {
		$utility_text = __( '<span class="in-category">Posted in %1$s</span>', 'catchkathmandu' );
	} 
	
	printf(
		$utility_text,
		$categories_list,
		$tag_list
	);
}
endif;


if ( ! function_exists( 'catchkathmandu_post_format_meta' ) ) :
/**
 * Prints HTML with meta information for current post format: categories, tags, permalink, author, and date.
 *
 * Create your own catchkathmandu_post_format_meta() to override in a child theme.
 *
 * @since Catch Kathmandu 1.0
 */
function catchkathmandu_post_format_meta() {
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'catchkathmandu' ) );

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'catchkathmandu' ) );

	$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'catchkathmandu' ), get_the_author() ) ),
		get_the_author()
	);

	// Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
	if ( $tag_list ) {
		$utility_text = __( '<span class="on-date">Posted on %3$s</span><span class="in-category"> under %1$s</span><span class="sep"> | </span><span class="in-tag">Tagged %2$s</span><span class="sep"> | </span><span class="by-author"> By %4$s</span>', 'catchkathmandu' );
	} elseif ( $categories_list ) {
		$utility_text = __( '<span class="on-date">Posted on %3$s</span><span class="in-category"> under in %1$s</span><span class="sep"> | </span><span class="by-author"> By %4$s</span>.', 'catchkathmandu' );
	} else {
		$utility_text = __( '<span class="on-date">Posted on %3$s</span><span class="sep"> | </span><span class="by-author"> By %4$s</span>.', 'catchkathmandu' );
	}

	printf(
		$utility_text,
		$categories_list,
		$tag_list,
		$date,
		$author
	);
}
endif;


/**
 * Returns true if a blog has more than 1 category
 *
 * @since Catch Kathmandu 1.0
 */
function catchkathmandu_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so catchkathmandu_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so catchkathmandu_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in catchkathmandu_categorized_blog
 *
 * @since Catch Kathmandu 1.0
 */
function catchkathmandu_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'catchkathmandu_category_transient_flusher' );
add_action( 'save_post', 'catchkathmandu_category_transient_flusher' );
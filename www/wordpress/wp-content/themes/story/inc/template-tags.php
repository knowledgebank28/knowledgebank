<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Story
 */

if ( ! function_exists( 'story_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @return void
 */
function story_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'story' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav"><i class="icon-left-open"></i></span> Older posts', 'story' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav"><i class="icon-right-open"></i></span>', 'story' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

/**
 * Content pagination
 */
function story_link_pages( $content ) {
    if ( is_single() ) {
        $content .= wp_link_pages( array(
                        'before' => '<div class="page-links">' . __( 'Pages:', 'story' ),
                        'after'  => '</div>',
                        'echo'   => 0
                    ) );
    }
    return $content;
}
add_filter('the_content','story_link_pages', 10);

if ( ! function_exists( 'story_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @return void
 */
function story_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'story' ); ?></h1>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav"><i class="icon-left-open"></i></span> %title', 'Previous post link', 'story' ) );
				next_post_link(     '<div class="nav-next">%link</div>',     _x( '%title <span class="meta-nav"><i class="icon-right-open"></i></span>', 'Next post link',     'story' ) );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'story_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function story_posted_on() {
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	printf( __( '<span class="posted-on">%1$s</span><span class="byline"> by %2$s</span>', 'story' ),
		sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>',
			esc_url( get_permalink() ),
			$time_string
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		)
	);
}
endif;

if ( ! function_exists( 'story_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function story_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="comment-body">
			<?php _e( 'Pingback:', 'story' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'story' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

	<?php else : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
				<div class="comment-author avatar">
					<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
				</div>

				<div class="comment-author vcard">
					<?php printf( sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author -->
					
                <div class="comment-meta">
				
	                <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
	                    <time datetime="<?php comment_time( 'c' ); ?>">
	                        <?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'story' ), get_comment_date(), get_comment_time() ); ?>
	                    </time>
	                </a>

        			<?php
						comment_reply_link( array_merge( $args, array(
							'add_below' => 'div-comment',
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
						) ) );
					?>

	                <?php edit_comment_link( __( 'Edit', 'story' ), '<span class="edit-link">', '</span>' ); ?>

	                <?php if ( '0' == $comment->comment_approved ) : ?>
	                <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'story' ); ?></p>
	                <?php endif; ?>

                </div><!-- .comment-meta -->

                <div class="comment-content">
                    <?php comment_text(); ?>
                </div><!-- .comment-content -->                                                                       

		</article><!-- .comment-body -->

	<?php
	endif;
}
endif; // ends check for story_comment()

if ( ! function_exists( 'story_post_meta' ) ) :
/**
 * Prints HTML with tag & category information for the current post.
 */
function story_post_meta() {
	/* translators: used between list items, there is a space after the comma */
	$category_list = get_the_category_list( __( '  &bull; ', 'story' ) );

	/* translators: used between list items, there is a space after the comma */
	$tag_list = get_the_tag_list( '', __( '  &bull; ', 'story' ) );

	if ( ! story_categorized_blog() ) {
		// This blog only has 1 category so we just need to worry about tags in the meta text
		if ( '' != $tag_list ) {
			$meta_text = __( 'TAGGED: %2$s', 'story' );
	}

	} else {
		// But this blog has loads of categories so we should probably display them here
		if ( '' != $tag_list ) {
			$meta_text = __( 'POSTED IN: %1$s<br />TAGGED: %2$s', 'story' );
		} else {
			$meta_text = __( 'POSTED IN: %1$s', 'story' );
		}

	} // end check for categories on this blog

	printf(
		$meta_text,
		$category_list,
		$tag_list,
		get_permalink()
	);
}
endif;


/**
 * Returns true if a blog has more than 1 category.
 */
function story_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so story_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so story_categorized_blog should return false.
		return false;
	}
}

/**
 * Return post format.
 */
function story_post_format() {
	global $post;
	
	$format = get_post_format( $post -> id );

	if ( $format == 'aside' || $format == 'chat' || $format == 'status' || $format == 'gallery' || !$format) {
		return 'standard';
	} else {
		return $format;
	}
}

// Extract first occurance of text from a string
if( !function_exists ('story_extract_from_string') ) :
function story_extract_from_string($start, $end, $tring) {
	$tring = stristr($tring, $start);
	$trimmed = stristr($tring, $end);
	return substr($tring, strlen($start), -strlen($trimmed));
}
endif;

/**
 * Flush out the transients used in story_categorized_blog.
 */
function story_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'story_category_transient_flusher' );
add_action( 'save_post',     'story_category_transient_flusher' );

<div id="grid-content" class="grid-content">
	<div class="grid-content-inner">
	<?php
	    if ( have_posts() ) :
			// Start the Loop.
			while ( have_posts() ) : the_post();
		/**
		 * Fires before the Sequel front content.
		 *
		 * @since Sequel 1.0
		 */
		do_action( 'sequel_front_posts_before' ); ?>

		
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	    <a class="post-thumbnail" href="<?php the_permalink(); ?>">
	        <?php
		    // Output the home-grid image.
		    if ( has_post_thumbnail() ) :
			    the_post_thumbnail();
		    endif;
	        ?>
	    </a>

	    <header class="entry-header">
		    <?php 
			    the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">','</a></h1>' ); ?>
			    
				<p><?php echo sequel_grid_excerpt(); ?></p>
			
			
	    </header><!-- .entry-header -->
        </article><!-- #post-## -->
		<?php 
		/**
		 * Fires after the Sequel front content.
		 *
		 * @since Sequel 1.0
		 */
		do_action( 'sequel_front_posts_after' );
        endwhile; ?>
			<div class="clearfix"></div>
			<?php // Previous/next post navigation.
			twentyfourteen_paging_nav();

		else :
			// If no content, include the "No posts found" template.
			get_template_part( 'content', 'none' );

		endif;
	    ?>
	</div><!-- .featured-content-inner -->
</div><!-- #featured-content .featured-content -->

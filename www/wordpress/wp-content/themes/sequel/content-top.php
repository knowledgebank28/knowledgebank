<?php $grid_posts = sequel_get_grid_posts(); ?>
<?php if ( $grid_posts->have_posts() ) { // more than one? ?>
<div id="grid-content" class="grid-content">
	<div class="grid-content-inner">
	<?php while ( $grid_posts->have_posts() ) : $grid_posts->the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	    <?php // Output the home-grid image.
		if ( has_post_thumbnail() ) : ?>
		<a class="post-thumbnail" href="<?php the_permalink(); ?>">
	        <?php the_post_thumbnail(); ?>
	    </a>
		<?php endif; ?>

	    <header class="entry-header">
		    <?php 
			    the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">','</a></h1>' ); ?>
			    
				<p><?php echo sequel_grid_excerpt(); ?></p>
			
			
	    </header><!-- .entry-header -->
        </article><!-- #post-## -->
		<?php endwhile; ?>
<?php
// Restore original Post Data
wp_reset_postdata(); ?>
</div><!-- .featured-content-inner -->
</div><!-- #featured-content .featured-content -->
<?php } // have_posts() inner ?>
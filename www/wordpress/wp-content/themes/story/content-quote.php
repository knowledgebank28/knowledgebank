<?php
/**
 * The template for displaying posts in the Quote post format.
 *
 * @package Sugar & Spice
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<div class="entry-wrapper">

		<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
			<?php the_post_thumbnail(); ?>
		<?php endif; ?>

		<header class="entry-header">
	
		<div class="entry-meta">
			<?php story_posted_on(); ?>
		</div><!-- .entry-meta -->
	
		</header>

		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'story' ) ); ?>		
		</div><!-- .entry-content -->

	</div>
		
</article><!-- #post -->

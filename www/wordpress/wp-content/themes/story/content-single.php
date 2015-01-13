<?php
/**
 * @package Story
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>

		<div class="entry-media">
			<?php the_post_thumbnail(); ?>
		</div>

	<?php endif; ?>

	<div class="entry-wrapper">
		
		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>

			<div class="entry-meta">

				<?php story_posted_on(); ?>
			
			</div><!-- .entry-meta -->
	
			<span class="format-separator"><i class="icon-<?php echo story_post_format(); ?>"></i></span>

		</header><!-- .entry-header -->

		<div class="entry-content">
		
			<?php the_content(); ?>
		
		</div><!-- .entry-content -->

		<footer>

			<div class="entry-tags">
			<?php story_post_meta(); ?>
			</div>
			<?php edit_post_link( __( 'Edit', 'story' ), '<span class="edit-link">', '</span>' ); ?>

		</footer><!-- .entry-meta -->
		
	</div><!-- .entry-wrapper -->
</article><!-- #post-## -->

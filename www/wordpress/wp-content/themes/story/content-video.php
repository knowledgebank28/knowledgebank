<?php
/**
 * The template for displaying posts in the Video post format.
 *
 * @package Sugar & Spice
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<div class="entry-media">

		<?php $content = trim( get_the_content() ); ?>
		<?php story_featured_video( $content ); ?>

	</div>

	<div class="entry-wrapper">

		<header class="entry-header">

			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

			<?php if ( 'post' == get_post_type() ) : ?>
			
			<div class="entry-meta">

				<?php story_posted_on(); ?>

			</div><!-- .entry-meta -->
			
			<?php endif; ?>
			
			<span class="format-separator"><i class="icon-<?php echo story_post_format(); ?>"></i></span>
			
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php echo story_video_content( $content ); ?>
		</div><!-- .entry-content -->
	</div>
	
</article><!-- #post -->

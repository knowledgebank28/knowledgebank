<?php
/**
 * @package Story
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<div class="entry-media">

		<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
			<?php the_post_thumbnail(); ?>
		<?php endif; ?>

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

		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		
		<div class="entry-summary">

			<?php the_excerpt(); ?>
		
		</div><!-- .entry-summary -->
		
		<?php else : ?>
		
		<div class="entry-content">
		
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'story' ) ); ?>
		
		</div><!-- .entry-content -->
		
		<?php endif; ?>
	</div><!-- .entry-wrapper -->


</article><!-- #post-## -->

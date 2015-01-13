<?php
/**
 * The template for displaying posts in the Link post format.
 *
 * @package Sugar & Spice
 */
?>
<?php
// Get the text & url from the first link in the content
$story_content = get_the_content();
$story_link_string = story_extract_from_string('<a href=', '/a>', $story_content);
$story_link_bits = explode('"', $story_link_string);
foreach( $story_link_bits as $bit ) {
	if( substr($bit, 0, 1) == '>') $story_link_text = substr($bit, 1, strlen($bit)-2);
	if( substr($bit, 0, 4) == 'http') $story_link_url = $bit;
}?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-media">

		<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
			<?php the_post_thumbnail(); ?>
		<?php endif; ?>

	</div>

	<div class="entry-wrapper">
		<header class="entry-header">
	
		<div class="entry-meta">
			<?php story_posted_on(); ?>
		</div><!-- .entry-meta -->
	
		</header>

		<div class="entry-content">
			
			<div class="the-link">
				<a href="<?php echo $story_link_url;?>" title="<?php _e('External link','story');?>"><i class="icon-link"></i><?php echo $story_link_text;?></a>
			</div>
		
		</div><!-- .entry-content -->
	</div><!-- #entry-wrapper -->
	
	
</article><!-- #post -->

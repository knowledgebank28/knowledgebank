<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Catch Themes
 * @subpackage Catch Kathmandu
 * @since Catch Kathmandu 1.0
 */
?>

<?php 
/** 
 * catchkathmandu_above_secondary hook
 */
do_action( 'catchkathmandu_before_secondary' ); ?>

<?php 
	//Getting Ready to load data from Theme Options Panel
	global $post, $wp_query, $catchkathmandu_options_settings;
   	$options = $catchkathmandu_options_settings;
	$themeoption_layout = $options['sidebar_layout'];
	
	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts'); 

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();	
	
	// Post /Page /General Layout
	if ( $post) {
		if ( is_attachment() ) { 
			$parent = $post->post_parent;
			$layout = get_post_meta( $parent, 'catchkathmandu-sidebarlayout', true );
		} else {
			$layout = get_post_meta( $post->ID, 'catchkathmandu-sidebarlayout', true ); 
		}
	}
			
	if( empty( $layout ) || ( !is_page() && !is_single() ) ) {
		$layout = 'default';
	}
	
	if ( $layout == 'left-sidebar' || $layout == 'right-sidebar' || ( $layout == 'default' && $themeoption_layout == 'left-sidebar' ) || ( $layout == 'default' && $themeoption_layout == 'right-sidebar' ) ) { ?>

		<div id="secondary" class="widget-area" role="complementary">
			<?php 
			/** 
			 * catchkathmandu_before_widget_start hook
			 */
			do_action( 'catchkathmandu_before_widget_start' );
			
			if ( is_active_sidebar( 'sidebar-1' ) ) {
            	dynamic_sidebar( 'sidebar-1' ); 
       		}	
			else { ?>
				<aside id="search" class="widget widget_search">
					<?php get_search_form(); ?>
				</aside>
		
				<aside id="archives" class="widget">
					<h1 class="widget-title"><?php _e( 'Archives', 'catchkathmandu' ); ?></h1>
					<ul>
						<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
					</ul>
				</aside>
			
			<?php 
			} // end sidebar widget area ?>
			
			<?php 
			/** 
			 * catchkathmandu_after_widget_ends hook
			 */
			do_action( 'catchkathmandu_after_widget_ends' ); ?>    
		</div><!-- #secondary .widget-area -->
        
		<?php
	}
	
/** 
 * catchkathmandu_after_secondary hook
 */
do_action( 'catchkathmandu_after_secondary' );
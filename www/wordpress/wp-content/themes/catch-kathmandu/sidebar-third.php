<?php
/**
 * The Footer widget areas.
 *
 * @package Catch Themes
 * @subpackage Catch_Evolution_Pro
 * @since Catch Evolution 1.0
 */
?>

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
			$sidebaroptions = get_post_meta( $parent, 'catchkathmandu-sidebar-options', true );
			
		} else {
			$layout = get_post_meta( $post->ID, 'catchkathmandu-sidebarlayout', true ); 
			$sidebaroptions = get_post_meta( $post->ID, 'catchkathmandu-sidebar-options', true ); 
		}
	}
	else {
		$sidebaroptions = '';
	}

	if ( $layout == 'three-columns' || ( $layout=='default' && $themeoption_layout == 'three-columns' ) || is_page_template( 'page-three-columns.php' ) || $layout == 'three-columns-sidebar' || ( $layout=='default' && $themeoption_layout == 'three-columns-sidebar' ) || is_page_template( 'page-three-columns-sidebar.php' ) ) : ?>
    
        <div id="third" class="widget-area sidebar-three-columns" role="complementary">
			<?php 
			/** 
			 * catchevolution_before_third hook
			 */
			do_action( 'catchkathmandu_before_third' );         
        
			if ( is_active_sidebar( 'catchkathmandu_third' ) ) :
				dynamic_sidebar( 'catchkathmandu_third' ); 
			endif; 
			
			/** 
			 * catchevolution_after_third hook
			 */
			do_action( 'catchkathmandu_after_third' ); ?>  
                        
        </div><!-- #sidebar-third-column .widget-area -->
    	
	<?php endif; ?>			
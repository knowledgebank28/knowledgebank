<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Blog Template
 *
   Template Name: Blog
 *
 * The template for Blog
 *
 * @package Catch Themes
 * @subpackage Catch Kathmandu
 * @since Catch Kathmandu 1.0
 */

get_header(); 

global $more, $catchkathmandu_options_settings; 
$more = 0;

//Getting data from Theme Options Panel and Meta Box  
$options = $catchkathmandu_options_settings;

//Content Layout
$current_content_layout = $options['content_layout'];

//More Tag
$moretag = $options[ 'more_tag_text' ];
?>

		<div id="primary" class="content-area">
			<div id="content" class="site-content" role="main">
            
            	<?php 
				global $wp_query, $paged;
				
				if ( get_query_var( 'paged' ) ) {
					
					$paged = get_query_var( 'paged' );
					
				}
				elseif ( get_query_var( 'page' ) ) {
					
					$paged = get_query_var( 'page' );
					
				}
				else {
					
					$paged = 1;
					
				}
				
				$blog_query = new WP_Query( array( 'post_type' => 'post', 'paged' => $paged ) );
				$temp_query = $wp_query;
				$wp_query = null;
				$wp_query = $blog_query;

				if ( $blog_query->have_posts() ) : ?>
                
                	<header class="page-header">
						<h1 class="page-title"><?php the_title(); ?></h1>
                  	</header><!-- .page-header -->
                    
                    <?php catchkathmandu_content_nav( 'nav-above' ); ?>
                    
					<?php /* Start the Loop */ ?>
					<?php while ( $blog_query->have_posts() ) : $blog_query->the_post(); ?>
                    
						<?php
                            /* Include the Post-Format-specific template for the content.
                             * If you want to overload this in a child theme then include a file
                             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                             */
                            get_template_part( 'content', get_post_format() );
                        ?>

					<?php endwhile; ?>
                        
                    <?php catchkathmandu_content_query_nav( 'nav-below' ); ?>	

				<?php else : ?>   

					<?php get_template_part( 'no-results', 'archive' ); ?>
					
				<?php endif; 
				$wp_query = $temp_query;
				wp_reset_postdata();
				?>

			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
<?php global $asteria;?>
<div class="lay1">
<div class="center">

<?php if ( is_home() ) { ?>
    <div class="homeposts_title">
	<?php if (get_option( 'asteria' )) { ?><?php echo $asteria['posts_title_id']; ?><?php }else{?> 
	<h2 style="text-align: center;"><span style="color: #e2341d;">Check Out Our Portfolio</span></h2>
	<p style="text-align: center;">The Very recent work for our clients</p>
	<?php } ?>
    </div>
<?php }?>

<div class="lay1_wrap">
                   <?php if(have_posts()): ?><?php while(have_posts()): ?><?php the_post(); ?>
                <div <?php post_class(); ?> id="post-<?php the_ID(); ?>">          

                <div class="post_image">
                    <div class="img_hover">
                        <div class="icon_wrap">
                        <div class="icon_round"><a href="<?php the_permalink();?>"><i class="fa-link fa-2x"></i></a></div>
                        </div>
                    </div>
                     <!--CALL POST IMAGE-->
                    <?php if ( has_post_thumbnail() ) : ?>
                    
                    <div class="imgwrap">                      
                    <a href="<?php the_permalink();?>"><?php the_post_thumbnail('asteriathumb'); ?></a></div>
                    
					<?php elseif($photo = asteria_get_images('numberposts=1', true)): ?>
                    <div class="imgwrap">                      
                    <a href="<?php the_permalink();?>"><?php echo wp_get_attachment_image($photo[0]->ID ,'medium'); ?></a></div>
                    
                    <?php else : ?>
                    <div class="imgwrap">
                    <a href="<?php the_permalink();?>"><img src="<?php echo get_template_directory_uri(); ?>/images/blank_img.png" alt="<?php the_title_attribute(); ?>" class="thn_thumbnail"/></a></div>   
                             
                    <?php endif; ?>
                    <!--POST CONTENT-->
                    <div class="post_content">
                    <h2 class="postitle"><a href="<?php the_permalink();?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                	</div>
                    
                </div>
                        </div>
            <?php endwhile ?> 

            <?php endif ?>
</div>



<!--PAGINATION START-->
<div class="ast_pagenav">
	<?php
        global $wp_query;
        $big = 999999999; // need an unlikely integer
            echo paginate_links( array(
                'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format' => '?paged=%#%',
                'current' => max( 1, get_query_var('paged') ),
                'total' => $wp_query->max_num_pages,
                'show_all'     => true,
                'prev_next'    => false
            
            ) );
    ?>
</div>
<!--PAGINATION END-->

<?php wp_reset_query(); ?>
    </div>
    </div>
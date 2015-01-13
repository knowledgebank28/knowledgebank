<?php global $asteria;?>
<div class="lay4">
<div class="center">

<div class="lay4_wrap<?php if ( !is_active_sidebar( 'sidebar' ) ) { ?> no_sidebar<?php } ?>">
<div class="lay4_inner">
<?php if ( is_home() ) { ?>
    <div class="lay1_title">
	<?php echo $asteria['posts_title_id']; ?>
    </div>
<?php }?>
                   <?php if(have_posts()): ?><?php while(have_posts()): ?><?php the_post(); ?>
                <div <?php post_class(); ?> id="post-<?php the_ID(); ?>"> 

                <div class="post_image">
                     <!--CALL TO POST IMAGE-->
                    <?php if ( has_post_thumbnail() ) : ?>
                    <div class="imgwrap">
                    <a href="<?php the_permalink();?>"><?php the_post_thumbnail('medium'); ?></a></div>
                    
                    <?php elseif($photo = asteria_get_images('numberposts=1', true)): ?>
    
                    <div class="imgwrap">
                	<a href="<?php the_permalink();?>"><?php echo wp_get_attachment_image($photo[0]->ID ,'medium'); ?></a></div>
                
                    <?php else : ?>
                    
                    <div class="imgwrap">
                    <a href="<?php the_permalink();?>"><img src="<?php echo get_template_directory_uri(); ?>/images/blank_img.png" alt="<?php the_title_attribute(); ?>" class="asteria_thumbnail"/></a></div>   
                             
                    <?php endif; ?>
                </div>
                
                <div class="post_content">
                    <h2 class="postitle"><a href="<?php the_permalink();?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                    <div class="single_metainfo">
                    <i class="fa-calendar"></i><a class="comm_date"><?php the_time( get_option('date_format') ); ?></a>
                    <i class="fa-user"></i><?php global $authordata; $post_author = "<a class='auth_meta' href=\"".get_author_posts_url( $authordata->ID, $authordata->user_nicename )."\">".get_the_author()."</a>\r\n"; echo $post_author; ?>
                    <i class="fa-comments"></i><?php if (!empty($post->post_password)) { ?>
                <?php } else { ?><div class="meta_comm"><?php comments_popup_link( __('0 Comment', 'asteria'), __('1 Comment', 'asteria'), __('% Comments', 'asteria'), '', __('Off' , 'asteria')); ?></div><?php } ?>
                
                  <i class="fa-th-list"></i><div class="catag_list"><?php the_category(', '); ?></div>
                    </div>
                    <?php the_excerpt(); ?> 
                    
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


            
    <?php if ( is_active_sidebar( 'sidebar' ) ) { ?><?php get_sidebar();?><?php } ?>
    </div>
	</div>

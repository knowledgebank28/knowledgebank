<?php
/*
Template Name: Blog Page Template
*/
?>
<?php global $asteria;?>
<?php get_header(); ?>

<div class="fixed_site">
<!--BIG PAGE HEADER START-->
	<div class="fixed_wrap singlefx">
		<?php if(($asteria['page_type_id']) == '1'){ ?>
            <div class="page_tt">
                <div class="center"><h1 class="postitle"><?php the_title(); ?></h1></div>
            </div> 
        <?php } ?>
<!--BIG PAGE HEADER END-->

<div class="lay4">
<div class="center">

<div class="lay4_wrap<?php if ( !is_active_sidebar( 'sidebar' ) ) { ?> no_sidebar<?php } ?>">
<div class="lay4_inner">
<?php  

	 $args = array(
				   'post_type' => 'post',
				   'cat' => ''.$asteria['blog_cat_id'].'',
				   'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1),
				   'posts_per_page' => '6');
	$the_query = new WP_Query( $args );
 ?>
                <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                <div <?php post_class(); ?> id="post-<?php the_ID(); ?>"> 

                <?php global $wp_query; $postid = $wp_query->post->ID; $astvidthumb = get_post_meta( $postid, 'ast_videolink', true ); ?>
                <?php if ( ! empty ( $astvidthumb ) ) { ?>
                 <div class="imgwrap">
				<!--VIDEO THUMBNAIL--> 
                <?php $astvidthumb =str_replace('https://www.youtube.com/watch?v=', '//www.youtube.com/embed/', $astvidthumb);?>                    
               <div class="ast_vid"><div class="responsive-container"><iframe src="<?php echo $astvidthumb; ?>?rel=0&amp;autohide=1&amp;showinfo=0"></iframe></div></div>

 				</div>              
               <?php } else { ?> 
            
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
                					<?php } ?>
                
                <div class="post_content">
                    <h2 class="postitle"><a href="<?php the_permalink();?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                    <!--POST INFO START-->
                    <div class="single_metainfo">
                    <i class="fa-calendar"></i><a class="comm_date"><?php the_time( get_option('date_format') ); ?></a>
                    <i class="fa-user"></i><a class="meta_auth"><?php the_author(); ?></a>
                    <i class="fa-comments"></i><?php if (!empty($post->post_password)) { ?>
                <?php } else { ?><div class="meta_comm"><?php comments_popup_link( __('0 Comment', 'asteria'), __('1 Comment', 'asteria'), __('% Comments', 'asteria'), '', __('Off' , 'asteria')); ?></div><?php } ?>
                
                  <i class="fa-th-list"></i><div class="catag_list"><?php the_category(', '); ?></div>
                    </div>
                    <!--POST INFO END-->
                    
                    <!--POST CONTENT START-->
                    <?php the_excerpt(); ?> 
                    <!--POST CONTENT END-->
                </div>
                
                        </div>
            <?php endwhile ?> 
 		<?php wp_reset_postdata(); ?>
</div>

<!--PAGINATION START-->
<div class="ast_pagenav">
	<?php
        global $the_query;
        $big = 999999999; // need an unlikely integer
            echo paginate_links( array(
                'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format' => '?paged=%#%',
                'current' => max( 1, get_query_var('paged') ),
                'total' => $the_query->max_num_pages,
                'show_all'     => true,
                'prev_next'    => false
            
            ) );
    ?>
</div>
<!--PAGINATION END-->

</div>
<!--SIDEBAR START-->
  <?php if ( is_active_sidebar( 'sidebar' ) ) { ?><?php get_sidebar();?><?php } ?>
<!--SIDEBAR END-->
    </div>
	</div>
</div>
</div>    
<?php get_footer(); ?>
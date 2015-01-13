<?php get_header(); ?>
<?php
if(isset($_GET['author_name'])) :
$curauth = get_userdatabylogin($author_name);
else :
$curauth = get_userdata(intval($author));
endif;
?>
<!--Content-->
<div class="fixed_site">
	<div class="fixed_wrap">
<div id="content">
<div class="center">

<div class="lay4">
<div class="lay4_wrap<?php if ( !is_active_sidebar( 'sidebar' ) ) { ?> no_sidebar<?php } ?>">

<div class="author_div">
    <div class="author_left"><?php echo get_avatar($curauth->ID, $size = '100'); ?></div>
    <div class="author_right">
    <h2><?php echo $curauth->display_name; ?></h2>
    <?php echo $curauth->user_description; ?>
    </div>
</div>

<h3 class="author_posts"><?php _e('Posts by ', 'asteria');?><?php echo $curauth->display_name; ?></h3>
<div class="lay4_inner">
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
                    <i class="fa-user"></i><a class="meta_auth"><?php the_author(); ?></a>
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
</div>
   
    <!--PAGE END-->


<?php get_sidebar();?>
			</div>
		</div>
	</div>

</div>
</div>
<?php get_footer(); ?>
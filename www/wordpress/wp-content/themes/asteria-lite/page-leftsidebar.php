<?php
/*
Template Name: Page with Left Sidebar
*/
?>
<?php global $asteria;?>
<?php get_header(); ?>

<!--Content-->
<div class="fixed_site">
	<div class="fixed_wrap singlefx">
		<?php if(($asteria['page_type_id']) == '1'){ ?>
            <div class="page_tt">
                <div class="center"><h1 class="postitle"><?php the_title(); ?></h1></div>
            </div> 
        <?php } ?>

<div id="content">
<div class="center">

<div class="single_wrap left_sidebar">
<div class="single_post">
                   <?php if(have_posts()): ?><?php while(have_posts()): ?><?php the_post(); ?>
                <div <?php post_class(); ?> id="post-<?php the_ID(); ?>">  
                
<?php if ( is_user_logged_in() || is_admin() ) { ?><div class="edit_wrap"><a href="<?php echo get_edit_post_link( ); ?>"><i title="<?php _e('Edit This','asteria'); ?>" class="fa-edit"></i></a></div><?php } ?>
        
                <div class="single_post_content">
                    <?php if(($asteria['page_type_id']) == '2'){ ?><h1 class="postitle"><?php the_title(); ?></h1><?php } ?>
                    <div class="thn_post_wrap"><?php the_content(); ?> </div> 
                    <div style="clear:both"></div>
                    <div class="thn_post_wrap"><?php wp_link_pages('<p class="pages"><strong>'.__('Pages:').'</strong> ', '</p>', 'number'); ?></div>
                    
                    
                </div>
                
                
                
                        </div>
            <?php endwhile ?> 
                </div>
                <!--COMMENT START: Calling the Comment Section. If you want to hide comments from your posts, remove the line below-->     
                <?php if (!empty ($asteria['post_comments_id'])) { ?>
                    <div class="comments_template">
                        <?php comments_template('',true); ?>
                    </div>
                <?php }?> 
                <!--COMMENT END-->
            <?php endif ?>

    </div>
   
    <!--PAGE END-->
<?php get_sidebar();?>
    	</div>
    </div>
</div>
</div>
<?php get_footer(); ?>
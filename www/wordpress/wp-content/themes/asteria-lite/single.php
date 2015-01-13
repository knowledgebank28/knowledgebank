<?php global $asteria;?>
<?php get_header(); ?>
<!--Content-->
<div class="fixed_site">
	<div class="fixed_wrap singlefx">
		<div id="content">
			<div class="center">
				<div class="content_wrap">
                    <!--POST END-->
					<div class="single_wrap<?php if ( !is_active_sidebar( 'sidebar' ) ) { ?> no_sidebar<?php } ?>">
				<div class="single_post">

                   <?php if(have_posts()): ?><?php while(have_posts()): ?><?php the_post(); ?>
                    <div <?php post_class(); ?> id="post-<?php the_ID(); ?>"> 
                    <!--EDIT BUTTON START-->
					<?php if ( is_user_logged_in() || is_admin() ) { ?>
                    <div class="edit_wrap"><a href="<?php echo get_edit_post_link(); ?>">
                    <i title="<?php _e('Edit This','asteria'); ?>" class="fa-edit"></i></a>
                    </div>
                    <?php } ?>
    				<!--EDIT BUTTON END-->
                    
                    <!--POST START-->
                    <div class="single_post_content">
                        <h1 class="postitle"><?php the_title(); ?></h1>
                        <!--POST INFO START-->
                        <?php if (!empty ($asteria['post_info_id'])) { ?>
                        <div class="single_metainfo">
                            <i class="fa-calendar"></i><a class="comm_date"><?php the_time( get_option('date_format') ); ?></a>
                            <i class="fa-user"></i><?php global $authordata; $post_author = "<a class='auth_meta' href=\"".get_author_posts_url( $authordata->ID, $authordata->user_nicename )."\">".get_the_author()."</a>\r\n"; echo $post_author; ?>
                            <i class="fa-comments"></i><?php if (!empty($post->post_password)) { ?>
                        <?php } else { ?><div class="meta_comm"><?php comments_popup_link( __('0 Comment', 'asteria'), __('1 Comment', 'asteria'), __('% Comments', 'asteria'), '', __('Off' , 'asteria')); ?></div><?php } ?>
                        
                          <i class="fa-th-list"></i><div class="catag_list"><?php the_category(', '); ?></div>
                        </div>
                        <?php } ?>
                        <!--POST INFO START-->
                        
                        <!--POST CONTENT START-->
                        <div class="thn_post_wrap"><?php the_content(); ?> </div>
                        <div style="clear:both"></div>
                        <div class="thn_post_wrap"><?php wp_link_pages('<p class="pages"><strong>'.__('Pages:').'</strong> ', '</p>', 'number'); ?>
                        <!--POST CONTENT END-->
                        </div>
                        
                        
                        <!--POST FOOTER START-->
                        <div class="post_foot">
                            <div class="post_meta">
         <?php if( has_tag() ) { ?><div class="post_tag"><div class="tag_list"><?php the_tags('<i class="fa-tag"></i>','  '); ?></div></div><?php } ?>
                            </div>
                       </div>
                       <!--POST FOOTER END-->
                        
                    </div>
                    <!--POST END-->
                    </div>
                        
            <?php endwhile ?> 
       
            <?php endif ?>

<!--SOCIAL SHARE POSTS START-->
<?php if (!empty ($asteria['social_single_id']) || !get_option( 'asteria' )) { ?>
	<?php get_template_part('share_this');?>
<?php } ?>
<!--SOCIAL SHARE POSTS END-->
</div>

<!--NEXT AND PREVIOUS POSTS START-->
<?php if (!empty ($asteria['post_nextprev_id']) || !get_option( 'asteria' )) { ?>
<div id="ast_nextprev" class="navigation">
	<?php $prevPost = get_previous_post(true); if($prevPost) {?>
        <div class="nav-box ast-prev">
        <?php $prevthumbnail = get_the_post_thumbnail($prevPost->ID, array(100,100) );?>
        <?php previous_post_link('%link',"$prevthumbnail Previous Post<br><span>%title</span>", TRUE); ?>
        <a class="left_arro" href="#"><i class="fa-angle-left"></i></a>
        </div>
    <?php }?>
    <?php $nextPost = get_next_post(true); if($nextPost) { ?>
        <div class="nav-box ast-next">
        <?php $nextthumbnail = get_the_post_thumbnail($nextPost->ID, array(100,100) ); ?>
        <?php next_post_link('%link',"$nextthumbnail Next Post<br><span>%title</span>", TRUE); ?>
        <a class="right_arro" href="#"><i class="fa-angle-right"></i></a>
        </div>
    <?php }?>
</div>
<?php }?>
<!--NEXT AND PREVIOUS POSTS END-->                


<!--COMMENT START: Calling the Comment Section. If you want to hide comments from your posts, remove the line below-->     
<?php if (!empty ($asteria['post_comments_id']) || !get_option( 'asteria' )) { ?>
    <div class="comments_template">
    	<?php comments_template('',true); ?>
    </div>
<?php }?> 
<!--COMMENT END-->


			</div>
<!--SIDEBAR START--> 
<?php if ( is_active_sidebar( 'sidebar' ) ) { ?><?php get_sidebar();?><?php } ?>
<!--SIDEBAR END--> 

		</div>
	</div>
</div>
</div>
</div>
<?php get_footer(); ?>
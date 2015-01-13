<?php get_header(); ?>
<?php global $asteria;?>

<div class="fixed_site">
	<div class="fixed_wrap">
<div class="center">
			<div class="search_term"><h2 class="postsearch"><?php printf( __( 'Search Results for: %s', 'asteria' ), '<span>' . esc_html( get_search_query() ) . '</span>'); ?></h2>
            <a class="search_count"><?php _e('Total posts found for', 'asteria'); ?> <?php /* Search Count */ $allsearch = &new WP_Query("s=$s&showposts=-1"); $key = esc_html($s, 1); $count = $allsearch->post_count; _e('', 'asteria'); _e('<span class="search-terms">"', 'asteria'); echo $key; _e('"</span>', 'asteria'); _e(' &mdash; ', 'asteria'); echo $count . ''; wp_reset_query(); ?></a>
            <?php get_search_form(); ?>
            </div>
 		</div>       
      
<!--Latest Posts-->
<?php get_template_part('layout1'); ?>
 	</div>
 </div> 
<?php get_footer(); ?>
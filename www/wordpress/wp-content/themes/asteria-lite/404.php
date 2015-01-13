<?php get_header(); ?>

<!--Content-->
<div class="fixed_site">
	<div class="fixed_wrap singlefx">
                    <div class="page_tt"><div class="center"><div class="fourofour"><label><a>404</a></label></div><h2 class="postitle"><?php _e('Page Not Found', 'asteria'); ?></h2></div></div> 
<div id="content">
<div class="center">
<div class="single_wrap no_sidebar">
<div class="single_post">

		<div id="content_wrap" class="error_page">
            <div class="post">
            <div class="error_msg">
            <p><label><?php _e('Server cannot find the file you requested. File has either been moved or deleted, or you entered the wrong URL or document name. Look at the URL. If a word looks misspelled, then correct it and try it again. If that doesnt work You can try our search option to find what you are looking for.', 'asteria'); ?></label></p>
            <?php get_search_form(); ?>
            </div>
        </div>     
                
            </div>
            
            

                </div>
			


    </div>
   
    <!--PAGE END-->

		</div>
	</div>
</div>
</div>
<?php get_footer(); ?>
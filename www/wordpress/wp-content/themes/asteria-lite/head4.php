<?php global $asteria;?>
<div class="header4">
    <div class="center">  
	<!--LOGO START-->        
    <div class="logo">

			<?php if ( is_home() ) { ?>   
            <h1><a href="<?php echo esc_url( home_url( '/' ) );?>"><?php bloginfo('name'); ?></a></h1>
            <?php }else{ ?>
            <h2><a href="<?php echo esc_url( home_url( '/' ) );?>"><?php bloginfo('name'); ?></a></h2>
            <?php } ?>

    </div>
	<!--LOGO END-->  
    
	<!--MENU START--> 
        <!--MOBILE MENU START--><a id="simple-menu" href="#sidr"><i class="fa-align-justify"></i> <?php _e('Menu' , 'asteria'); ?></a><!--MOBILE MENU END--> 
    <div id="topmenu"><?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?></div>
    <!--MENU END-->
    
    </div>
    
</div>

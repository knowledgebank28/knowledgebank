<?php
if ( ! function_exists( 'catchkathmandu_primary_menu' ) ) :
/**
 * Shows the Primary Menu 
 *
 * default load in sidebar-header-right.php
 */
function catchkathmandu_primary_menu() { ?>
	<div id="header-menu">
        <nav id="access" role="navigation">
            <h2 class="assistive-text"><?php _e( 'Primary Menu', 'catchkathmandu' ); ?></h2>
            <div class="assistive-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'catchkathmandu' ); ?>"><?php _e( 'Skip to content', 'catchkathmandu' ); ?></a></div>
            <?php
                if ( has_nav_menu( 'primary' ) ) { 
                    $catchkathamdu_primary_menu_args = array(
                        'theme_location'    => 'primary',
                        'container_class' 	=> 'menu-header-container', 
                        'items_wrap'        => '<ul class="menu">%3$s</ul>' 
                    );
                    wp_nav_menu( $catchkathamdu_primary_menu_args );
                }
                else {
                    echo '<div class="menu-header-container">';
                    wp_page_menu( array( 'menu_class'  => 'menu' ) );
                    echo '</div>';
                }
            ?> 	         
        </nav><!-- .site-navigation .main-navigation -->  
	</div>
<?php
}
endif; // catchkathmandu_primary_menu


if ( ! function_exists( 'catchkathmandu_secondary_menu' ) ) :
/**
 * Shows the Secondary Menu 
 *
 * Hooked to catchkathmandu_after_hgroup_wrap
 */
function catchkathmandu_secondary_menu() { 
	if ( has_nav_menu( 'secondary' ) ) { ?>
	<div id="secondary-menu">
        <nav id="access-secondary" role="navigation">
            <h2 class="assistive-text"><?php _e( 'Secondary Menu', 'catchkathmandu' ); ?></h2>
            <?php     
				$catchkathamdu_secondary_menu_args = array(
					'theme_location'    => 'secondary',
					'container_class' 	=> 'menu-secondary-container', 
					'items_wrap'        => '<ul class="menu">%3$s</ul>' 
				);
				wp_nav_menu( $catchkathamdu_secondary_menu_args );
            ?> 	         
        </nav><!-- .site-navigation .main-navigation -->  
	</div>
	<?php
	}
}
endif; // catchkathmandu_secondary_menu

// Load  breadcrumb in catchkathmandu_after_hgroup_wrap hook
add_action( 'catchkathmandu_after_hgroup_wrap', 'catchkathmandu_secondary_menu', 20 );
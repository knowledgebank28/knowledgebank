<?php
/**
 * @package WP Theme Customizer
 */
/*
Admin Options Page
*/

// Insert WPTC Admin Styles

add_action('admin_print_styles', 'wptc_admin_styles');

function wptc_admin_styles() {

	$pages = array('wptc_theme_customizer','wptc_display_colors_options','wptc_display_backgrounds_options','wptc_display_effects_options');

	if (isset($_GET['page']) && in_array( $_GET['page'], $pages ) ) {

		wp_enqueue_style( 'wptc-admin-styles', plugins_url( 'css/wptc_admin_styles.css', dirname(dirname(__FILE__ )) ) );
	
	}
	
	
}// end wptc_admin_styles()

function wptc_create_menu() {
	
	add_menu_page(
		__( 'WP Theme Customizer', 'wp-theme-customizer' ),		// The value used to populate the browser's title bar when the menu page is active
		__( 'Customizer', 'wp-theme-customizer' ),				// The text of the menu in the administrator's sidebar
		'manage_options',					// What roles are able to access the menu
		'wptc_theme_customizer',					// The ID used to bind submenu items to this menu 
		'wptc_display_options'				// The callback function used to render this menu
	);
	
	add_submenu_page(
		'wptc_theme_customizer',				// The ID of the top-level menu page to which this submenu item belongs
		__( 'Colors Options', 'wp-theme-customizer' ),			// The value used to populate the browser's title bar when the menu page is active
		__( 'Colors Options', 'wp-theme-customizer' ),			// The label of this submenu item displayed in the menu
		'manage_options',				// What roles are able to access this submenu item
		'wptc_display_colors_options',	// The ID used to represent this submenu item
		create_function( null, 'wptc_display_options( "colors_options" );' )		// The callback function used to render the options for this submenu item
	);
	
	add_submenu_page(
		'wptc_theme_customizer',					// The ID of the top-level menu page to which this submenu item belongs
		__( 'Backgrounds Options', 'wp-theme-customizer' ),			// The value used to populate the browser's title bar when the menu page is active
		__( 'Backgrounds Options', 'wp-theme-customizer' ),			// The label of this submenu item displayed in the menu
		'manage_options',					// What roles are able to access this submenu item
		'wptc_display_backgrounds_options',	// The ID used to represent this submenu item
		create_function( null, 'wptc_display_options( "backgrounds_options" );' )	// The callback function used to render the options for this submenu item
	);
	
	add_submenu_page(
		'wptc_theme_customizer',				// The ID of the top-level menu page to which this submenu item belongs
		__( 'Effects Options', 'wp-theme-customizer' ),			// The value used to populate the browser's title bar when the menu page is active
		__( 'Effects', 'wp-theme-customizer' ),			// The label of this submenu item displayed in the menu
		'manage_options',				// What roles are able to access this submenu item
		'wptc_display_effects_options',	// The ID used to represent this submenu item
		create_function( null, 'wptc_display_options( "effects_options" );' )		// The callback function used to render the options for this submenu item
	);
	
	


} // end wptc_create_menu()

add_action( 'admin_menu', 'wptc_create_menu' );

/**
 * Renders a page to display options.
 */
 
function wptc_display_options( $active_tab = '' ) {
	
?>

	<div class="wrap">
		
		<div class="wptc_admin_wrapper">
		
			<div class="wptc_admin_top">
			
				<img class="wptc_logo" src="<?php echo plugins_url( 'assets/logo.png', dirname(dirname(__FILE__)) )  ?>" />
				
				<div class="wptc_intro">
				
					<span>Version: 1.0</span> 
					
				</div>
				
				<div class="wptc_clear"></div>
			
			</div><!-- /.admin-top -->

			
			<?php
			
			if( isset( $_GET[ 'tab' ] ) ) {
			
				$active_tab = $_GET[ 'tab' ];
				
			} else if( $active_tab == 'colors_options' ) {
			
				$active_tab = 'colors_options';
				
			} else if( $active_tab == 'backgrounds_options' ) {
			
				$active_tab = 'backgrounds_options';
				
			} else if( $active_tab == 'effects_options' ) {
			
				$active_tab = 'effects_options';
				
			} else {
			
				$active_tab = 'general_options';
				
			} 
			// end if/else ?>
			
					
			<div class="wptc_admin_left">
			
				<div class="wptc_admin_menu">
				
					<a href="?page=wptc_theme_customizer&tab=general_options" class="<?php echo $active_tab == 'general_options' ? 'active' : ''; ?>">General</a>
					
					<a href="?page=wptc_theme_customizer&tab=colors_options" class="<?php echo $active_tab == 'colors_options' ? 'active' : ''; ?>">Colors</a>
					
					<a href="?page=wptc_theme_customizer&tab=backgrounds_options" class="<?php echo $active_tab == 'backgrounds_options' ? 'active' : ''; ?>">Backgrounds</a>
					
					<a href="?page=wptc_theme_customizer&tab=effects_options" class="wptc_li_last <?php echo $active_tab == 'effects_options' ? 'active' : ''; ?>">Effects</a>
					
				</div>
				
			</div><!-- /.admin-left -->
			
			<div class="wptc_admin_right">
			
				<div class="wptc_admin_message">
				
					<?php settings_errors(); ?>
					
				</div>
				
					<?php
						if( $active_tab == 'general_options' ) {
					?>
							<h2><?php _e( 'General Options', 'wp-theme-customizer' ); ?></h2>
					<?php
						} elseif( $active_tab == 'colors_options' ) {
					?>	
							<h2><?php _e( 'Colors Options', 'wp-theme-customizer' ); ?></h2>
					<?php
						} elseif( $active_tab == 'backgrounds_options' ) {
					?>	
							<h2><?php _e( 'Backgrounds Options', 'wp-theme-customizer' ); ?></h2>
					<?php
						} elseif( $active_tab == 'effects_options' ) {
					?>	
							<h2><?php _e( 'Effects Options', 'wp-theme-customizer' ); ?></h2>
					<?php
						} else {
					?>	
							<h2><?php _e( 'General Options', 'wp-theme-customizer' ); ?></h2>
					<?php
							
						}  // end if/else
					?>	
			
				<form method="post" action="options.php">
				
					<div class="wptc_form_data">
						
						<?php
							if( $active_tab == 'general_options' ) {
					
								settings_fields( 'wptc_general_options' );
								do_settings_sections( 'wptc_general_options' );
								
							} elseif( $active_tab == 'colors_options' ) {
								
								settings_fields( 'wptc_colors_options' );
								do_settings_sections( 'wptc_colors_options' );
								
							} elseif( $active_tab == 'backgrounds_options' ) {
			
								settings_fields( 'wptc_backgrounds_options' );
								do_settings_sections( 'wptc_backgrounds_options' );
								
							} elseif( $active_tab == 'effects_options' ) {
							
								settings_fields( 'wptc_effects_options' );
								do_settings_sections( 'wptc_effects_options' );
								
							} else {
							
								settings_fields( 'wptc_general_options' );
								do_settings_sections( 'wptc_general_options' );
								
							}  // end if/else
						?>			
					</div>
							
							<div class="wptc_admin_bottom">
			
								<input type="submit" value="Save Changes" class="button button-primary button_wptc" id="submit" name="submit">
								
									<a href="http://phpbaba.com" title="phpbaba">
									<img class="phpbaba" title="phpbaba" src="<?php echo plugins_url( 'assets/phpbaba.png', dirname(dirname(__FILE__)) )  ?>" />
									</a>
								
								<div class="wptc_clear"></div>
							
							</div>
					
				</form>
				
			</div><!-- /.admin-right -->

		
		</div><!-- /.admin-wrapper -->
		
	</div><!-- /.wrap -->
<?php

} // end wptc_display_options()

require_once( WPTC_DIR . 'includes/admin/admin_includes/general_options.php' );

require_once( WPTC_DIR . 'includes/admin/admin_includes/colors_options.php' );

require_once( WPTC_DIR . 'includes/admin/admin_includes/backgrounds_options.php' );

require_once( WPTC_DIR . 'includes/admin/admin_includes/effects_options.php' );

require_once( WPTC_DIR . 'includes/admin/admin_includes/sanitize.php' );

?>
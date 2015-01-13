<?php

/**
	ReduxFramework Sample Config File
	For full documentation, please visit http://reduxframework.com/docs/
**/



/*
 *
 * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
 * Simply include this function in the child themes functions.php file.
 *
 * NOTE: the defined constansts for URLs, and directories will NOT be available at this point in a child theme,
 * so you must use get_template_directory_uri() if you want to use any of the built in icons
 *
 */
function add_another_section($sections){
    //$sections = array();
    $sections[] = array(
        'title' => __('A Section added by hook', 'asteria'),
        'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'asteria'),
		'icon' => 'paper-clip',
		'icon_class' => 'icon-large',
        // Leave this as a blank section, no options just some intro text set above.
        'fields' => array()
    );

    return $sections;
}
add_filter('redux-opts-sections-redux-sample', 'add_another_section');


/*
 * 
 * Custom function for filtering the args array given by a theme, good for child themes to override or add to the args array.
 *
 */
function change_framework_args($args){
    //$args['dev_mode'] = false;
    
    return $args;
}
//add_filter('redux-opts-args-redux-sample-file', 'change_framework_args');


/*
 *
 * Most of your editing will be done in this section.
 *
 * Here you can override default values, uncomment args and change their values.
 * No $args are required, but they can be over ridden if needed.
 *
 */
function setup_framework_options(){
    $args = array();


    // For use with a tab below
		$tabs = array();

		ob_start();

		$ct = wp_get_theme();
        $theme_data = $ct;
        $item_name = $theme_data->get('Name'); 
		$tags = $ct->Tags;
		$screenshot = $ct->get_screenshot();
		$class = $screenshot ? 'has-screenshot' : '';

		$customize_title = sprintf( __( 'Customize &#8220;%s&#8221;', 'asteria' ), $ct->display('Name') );

		?>
		<div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
			<?php if ( $screenshot ) : ?>
				<?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
				<a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr( $customize_title ); ?>">
					<img src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview' ); ?>" />
				</a>
				<?php endif; ?>
				<img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview' ); ?>" />
			<?php endif; ?>

			<h4>
				<?php echo $ct->display('Name'); ?>
			</h4>

			<div>
				<ul class="theme-info">
					<li><?php printf( __('By %s', 'asteria'), $ct->display('Author') ); ?></li>
					<li><?php printf( __('Version %s', 'asteria'), $ct->display('Version') ); ?></li>
					<li><?php echo '<strong>'.__('Tags', 'asteria').':</strong> '; ?><?php printf( $ct->display('Tags') ); ?></li>
				</ul>
				<p class="theme-description"><?php echo $ct->display('Description'); ?></p>
				<?php if ( $ct->parent() ) {
					printf( ' <p class="howto">' . __( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.' ) . '</p>',
						__( 'http://codex.wordpress.org/Child_Themes', 'asteria' ),
						$ct->parent()->display( 'Name' ) );
				} ?>
				
			</div>

		</div>

		<?php
		$item_info = ob_get_contents();
		    
		ob_end_clean();
	if( file_exists( dirname(__FILE__).'/documentation/about.html' )) {
		global $wp_filesystem;
		if (empty($wp_filesystem)) {
			require_once(ABSPATH .'/wp-admin/includes/file.php');
			WP_Filesystem();
		}  		
		$about = $wp_filesystem->get_contents(dirname(__FILE__).'/documentation/about.html');
	}

	if( file_exists( dirname(__FILE__).'/documentation/documentation.html' )) {
		global $wp_filesystem;
		if (empty($wp_filesystem)) {
			require_once(ABSPATH .'/wp-admin/includes/file.php');
			WP_Filesystem();
		}  		
		$documentation = $wp_filesystem->get_contents(dirname(__FILE__).'/documentation/documentation.html');
	}
	if( file_exists( dirname(__FILE__).'/documentation/upgrade.html' )) {
		global $wp_filesystem;
		if (empty($wp_filesystem)) {
			require_once(ABSPATH .'/wp-admin/includes/file.php');
			WP_Filesystem();
		}  		
		$upgrade = $wp_filesystem->get_contents(dirname(__FILE__).'/documentation/upgrade.html');
	}


    // Setting dev mode to true allows you to view the class settings/info in the panel.
    // Default: true
    $args['dev_mode'] = false;

	// Set the icon for the dev mode tab.
	// If $args['icon_type'] = 'image', this should be the path to the icon.
	// If $args['icon_type'] = 'iconfont', this should be the icon name.
	// Default: info-sign
	//$args['dev_mode_icon'] = 'info-sign';

	// Set the class for the dev mode tab icon.
	// This is ignored unless $args['icon_type'] = 'iconfont'
	// Default: null
    $args['dev_mode_icon_class'] = 'icon-large';

    // Set a custom option name. Don't forget to replace spaces with underscores!
    $args['opt_name'] = 'asteria';

    // Setting system info to true allows you to view info useful for debugging.
    // Default: false
    //$args['system_info'] = true;

    
	// Set the icon for the system info tab.
	// If $args['icon_type'] = 'image', this should be the path to the icon.
	// If $args['icon_type'] = 'iconfont', this should be the icon name.
	// Default: info-sign
	//$args['system_info_icon'] = 'info-sign';

	// Set the class for the system info tab icon.
	// This is ignored unless $args['icon_type'] = 'iconfont'
	// Default: null
	$args['system_info_icon_class'] = 'icon-large';

	$theme = wp_get_theme();

	$args['display_name'] = $theme->get('Name');
	//$args['database'] = "theme_mods_expanded";
	$args['display_version'] = $theme->get('Version');

    // If you want to use Google Webfonts, you MUST define the api key.
    $args['google_api_key'] = 'AIzaSyAolJnJQL-juru43ESvQ9pf5QUY0ZIdLuQ';

    // Define the starting tab for the option panel.
    // Default: '0';
    //$args['last_tab'] = '0';

    // Define the option panel stylesheet. Options are 'standard', 'custom', and 'none'
    // If only minor tweaks are needed, set to 'custom' and override the necessary styles through the included custom.css stylesheet.
    // If replacing the stylesheet, set to 'none' and don't forget to enqueue another stylesheet!
    // Default: 'standard'
    //$args['admin_stylesheet'] = 'standard';

    // Setup custom links in the footer for share icons
    $args['share_icons']['twitter'] = array(
        'link' => 'https://twitter.com/towfiqi',
        'title' => 'Follow me on Twitter', 
        'img' => ReduxFramework::$_url  . 'assets/img/social/Twitter.png'
    );
    $args['share_icons']['facebook'] = array(
        'link' => 'http://www.facebook.com/pages/Towfiq-I/180981878579536',
        'title' => 'Follow me on Facebook', 
        'img' => ReduxFramework::$_url  . 'assets/img/social/Facebook.png'
    );
    $args['share_icons']['google'] = array(
        'link' => 'https://plus.google.com/114788083723678273482/',
        'title' => 'Follow me on Google Plus', 
        'img' => ReduxFramework::$_url  . 'assets/img/social/Google.png'
    );

    // Enable the import/export feature.
    // Default: true
    //$args['show_import_export'] = false;

	// Set the icon for the import/export tab.
	// If $args['icon_type'] = 'image', this should be the path to the icon.
	// If $args['icon_type'] = 'iconfont', this should be the icon name.
	// Default: refresh
	//$args['import_icon'] = 'refresh';

	// Set the class for the import/export tab icon.
	// This is ignored unless $args['icon_type'] = 'iconfont'
	// Default: null
	$args['import_icon_class'] = 'icon-large';

    // Set a custom menu icon.
    //$args['menu_icon'] = '';

    // Set a custom title for the options page.
    // Default: Options
    $args['menu_title'] = __('Asteria Options', 'asteria');

    // Set a custom page title for the options page.
    // Default: Options
    $args['page_title'] = __('Options', 'asteria');

    // Set a custom page slug for options page (wp-admin/themes.php?page=***).
    // Default: redux_options
    $args['page_slug'] = 'redux_options';

    $args['default_show'] = true;
    $args['default_mark'] = '*';

    // Set a custom page capability.
    // Default: manage_options
    //$args['page_cap'] = 'manage_options';

    // Set the menu type. Set to "menu" for a top level menu, or "submenu" to add below an existing item.
    // Default: menu
    $args['page_type'] = 'submenu';

    // Set the parent menu.
    // Default: themes.php
    // A list of available parent menus is available at http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
    //$args['page_parent'] = 'options_general.php';

    // Set a custom page location. This allows you to place your menu where you want in the menu order.
    // Must be unique or it will override other items!
    // Default: null
    //$args['page_position'] = null;

    // Set a custom page icon class (used to override the page icon next to heading)
    //$args['page_icon'] = 'icon-themes';

	// Set the icon type. Set to "iconfont" for Font Awesome, or "image" for traditional.
	// Redux no longer ships with standard icons!
	// Default: iconfont
	//$args['icon_type'] = 'image';

    // Disable the panel sections showing as submenu items.
    // Default: true
    //$args['allow_sub_menu'] = false;
        
    // Set ANY custom page help tabs, displayed using the new help tab API. Tabs are shown in order of definition.
    $args['help_tabs'][] = array(
        'id' => 'redux-opts-1',
        'title' => __('Theme Information 1', 'asteria'),
        'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'asteria')
    );
    $args['help_tabs'][] = array(
        'id' => 'redux-opts-2',
        'title' => __('Theme Information 2', 'asteria'),
        'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'asteria')
    );

    // Set the help sidebar for the options page.                                        
    $args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'asteria');


    // Add HTML before the form.
    if (!isset($args['global_variable']) || $args['global_variable'] !== false ) {
    	if (!empty($args['global_variable'])) {
    		$v = $args['global_variable'];
    	} else {
    		$v = str_replace("-", "_", $args['opt_name']);
    	}
    	$args['intro_text'] = __('<p><strong>Upgrade to Asteria PRO</strong> to Unlock all features and design your site anyway you want. For Documentation you can either click the Documentation tab or <a target="_blank" href="http://bit.ly/HXxREO">Download This PDF.</a></p>', 'asteria');
    } else {
    	$args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'asteria');
    }

    // Add content after the form.
    $args['footer_text'] = __('', 'asteria');

    // Set footer/credit line.
    //$args['footer_credit'] = __('<p>This text is displayed in the options panel footer across from the WordPress version (where it normally says \'Thank you for creating with WordPress\'). This field accepts all HTML.</p>', 'asteria');


    $sections = array();              

    //Background Patterns Reader
    $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
    $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
    $sample_patterns      = array();

    if ( is_dir( $sample_patterns_path ) ) :
    	
      if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) :
      	$sample_patterns = array();

        while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

          if( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
          	$name = explode(".", $sample_patterns_file);
          	$name = str_replace('.'.end($name), '', $sample_patterns_file);
          	$sample_patterns[] = array( 'alt'=>$name,'img' => $sample_patterns_url . $sample_patterns_file );
          }
        }
      endif;
    endif;


	$sections[] = array(
		'title' => __('Basic', 'asteria'),
		'header' => '',
		'desc' => '',
		'icon_class' => 'icon-large',
        'icon' => 'cogs',
        // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
		'fields' => array(
				
			array(
				'id'=>'site_width_id',
				'type' => 'image_select',
				'compiler'=>true,
				'title' => __('Site Width', 'asteria'), 
				'subtitle' => __('Select between Fixed Width and Full Width', 'asteria'),
				'options' => array(
						'1' => array('alt' => 'Fixed', 'img' => get_template_directory_uri().'/images/fixed.png'),
						'2' => array('alt' => 'Full Width', 'img' => get_template_directory_uri().'/images/fullwidth.png'),
					),
				'default' => '1'
				),	
				
			array(
				'id'=>'head_type_id',
				'type' => 'select',
				'title' => __('Header Type', 'asteria'), 
				'subtitle' => '',
				'desc' => __('Change how the header looks', 'asteria'),
				'options' => array('head4' => 'Header Type 4'),
				'default' => 'head4'
				),	
				
			array(
				'id'=>'page_type_id',
				'type' => 'select',
				'title' => __('Page Header Type', 'asteria'), 
				'subtitle' => '',
				'desc' => __('Change how the Page Title Looks', 'asteria'),
				'options' => array('1' => 'Big Page header','2' => 'Normal Page Header'),
				'default' => '1'
				),	
				
			array(
				'id'=>'ajax_id',
				'type' => 'switch', 
				'title' => __('Ajax Pagination', 'asteria'),
				'subtitle'=> __('Ajax pagination(Go to next page without reloading the page', 'asteria'),
				"default" 		=> 1,
				),
				
			array(
				'id'=>'totop_id',
				'type' => 'switch', 
				'title' => __('To Top Button', 'asteria'),
				'subtitle'=> __('Turn On/Off "To Top Button"(The button that appears on bottom right when you scroll down to pages.', 'asteria'),
				"default" 		=> 1,
				),
				
			array(
				'id'=>'footer_text_id',
				'type' => 'editor',
				'title' => __('Footer Copyright Text', 'asteria'), 
				'default' => '',
				),
			),

		);



	$sections[] = array(
		'type' => 'divide',
	);

	$sections[] = array(
		'icon' => 'home-alt',
		'icon_class' => 'icon-large',
        'title' => __('Front Page ', 'asteria'),
		'fields' => array(
			array(
				'id'=>'block1_text_id',
				'type' => 'text',
				'title' => __('Block 1 Title', 'asteria'),
				'default' => 'Lorem Ipsum'
				),	
				
			array(
				'id'=>'block1_icon',
				'type' => 'select',
				'title' => __('Block 1 Icon', 'asteria'), 
				'data' => 'elusive',//Must provide key => value pairs for select options
				'default' => 'fa-camera'
				),
				
			array(
				'id'=>'block1_link_id',
				'type' => 'text',
				'title' => __('Block 1 Link', 'asteria')
				),
				
			array(
				'id'=>'block1_textarea_id',
				'type' => 'editor',
				'title' => __('Block 1 Content', 'asteria'), 
				'default' => 'Lorem ipsum dolor sit amet, consectetur  dol adipiscing elit. Nam nec rhoncus risus. In ultrices lacinia ipsum, posuere faucibus velit bibe.',
				),

			array(
				'id'=>'block2_text_id',
				'type' => 'text',
				'title' => __('Block 2 Title', 'asteria'),
				'default' => 'Lorem Ipsum'
				),	
				
			array(
				'id'=>'block2_icon',
				'type' => 'select',
				'title' => __('Block 2 Icon', 'asteria'), 
				'data' => 'elusive',//Must provide key => value pairs for select options
				'default' => 'fa-rocket'
				),

			array(
				'id'=>'block2_link_id',
				'type' => 'text',
				'title' => __('Block 2 Link', 'asteria')
				),
				
			array(
				'id'=>'block2_textarea_id',
				'type' => 'editor',
				'title' => __('Block 2 Content', 'asteria'), 
				'default' => 'Lorem ipsum dolor sit amet, consectetur  dol adipiscing elit. Nam nec rhoncus risus. In ultrices lacinia ipsum, posuere faucibus velit bibe.',
				),

			array(
				'id'=>'block3_text_id',
				'type' => 'text',
				'title' => __('Block 3 Title', 'asteria'),
				'default' => 'Lorem Ipsum'
				),	
				
			array(
				'id'=>'block3_icon',
				'type' => 'select',
				'title' => __('Block 3 Icon', 'asteria'), 
				'data' => 'elusive',//Must provide key => value pairs for select options
				'default' => 'fa-signal'
				),
				
			array(
				'id'=>'block3_link_id',
				'type' => 'text',
				'title' => __('Block 3 Link', 'asteria')
				),
				
			array(
				'id'=>'block3_textarea_id',
				'type' => 'editor',
				'title' => __('Block 3 Content', 'asteria'), 
				'default' => 'Lorem ipsum dolor sit amet, consectetur  dol adipiscing elit. Nam nec rhoncus risus. In ultrices lacinia ipsum, posuere faucibus velit bibe.',
				),


				
			array(
				'id'=>'block4_text_id',
				'type' => 'text',
				'title' => __('Block 4 Title', 'asteria'),
				'default' => 'Lorem Ipsum'
				),	
				
			array(
				'id'=>'block4_icon',
				'type' => 'select',
				'title' => __('Block 4 Icon', 'asteria'), 
				'data' => 'elusive',
				'default' => 'fa-cogs'
				),
				
			array(
				'id'=>'block4_link_id',
				'type' => 'text',
				'title' => __('Block 4 Link', 'asteria')
				),
				
			array(
				'id'=>'block4_textarea_id',
				'type' => 'editor',
				'title' => __('Block 4 Content', 'asteria'), 
				'default' => 'Lorem ipsum dolor sit amet, consectetur  dol adipiscing elit. Nam nec rhoncus risus. In ultrices lacinia ipsum, posuere faucibus velit bibe.',
				),
				
			array(
				'id'=>'welcm_textarea_id',
				'type' => 'editor',
				'title' => __('Welcome Text', 'asteria'), 
				'default' => '<h2>Lorem ipsum dolor sit amet, consectetur  dol adipiscing elit. Nam nec rhoncus risus. In ultrices lacinia ipsum, posuere faucibus velit bibe.</h2>',
				),
				
			array(
				'id'=>'welcome_color_id',
				'type' => 'color',
				'title' => __('Background Color ', 'asteria'), 
				'default' => '#333333',
				'validate' => 'color',
				),
			array(
				'id'=>'posts_title_id',
				'type' => 'editor',
				'title' => __('Title &amp; Description', 'asteria'), 
				'default' => '<h2 style="text-align: center;"><span style="color: #e2341d;">Check Out Our Portfolio</span></h2><p style="text-align: center;">The Very recent work for our clients</p>',
				),
				
			array(
				'id'=>'front_layout_id',
				'type' => 'image_select',
				'compiler'=>true,
				'title' => __('Posts layout', 'asteria'), 
				'options' => array(
						'1' => array('alt' => 'Layout 1', 'img' => get_template_directory_uri().'/images/layout1.png'),
					),
				'default' => '1'
				),
				
			array(
				'id'=>'enable_cat',
				'type' => 'switch', 
				'title' => __('Display posts from selected Categories', 'asteria'),
				"default" 		=> 0,
				),
				
			array(
				'id'=>'posts_cat_id',
				'type' => 'select',
				'data' => 'categories',
				'multi' => true,
				'title' => __('Category Names', 'asteria'), 
				),	
			
			array(
				'id'=>'n_posts_field_id',
				'type' => 'text',
				'title' => __('Number of Posts ', 'asteria'),
				'default' => '9',
				),
				
			array(
				'id'=>'map-info',
				'type' => 'info',
				'desc' => __("This feature is only available in Asteria PRO", "asteria"),
				),
				
			array(
				'id'=>'callaction-info',
				'type' => 'info',
				'desc' => __("This feature is only available in Asteria PRO", "asteria"),
				),
				
			array(
				'id'=>'widget-info',
				'type' => 'info',
				'desc' => __("This feature is only available in Asteria PRO", "asteria"),
				),
				
			
			array(
	            'id' => 'home_sort_id',
    	        'type' => 'sortable',
    	        'mode' => 'checkbox', // checkbox or text
        	    'title' => __('Frontpage Elements position', 'asteria'),
				'desc' => __('Drag and Drop each element to reorder their position.', 'asteria'),
	            'options' => array(
    	            'blocks' => 'Blocks',
        	        'welcome-text' => 'Welcome Text',
    	            'posts' => 'Frontpage Posts'
        	    	),
				'default' => array(
    	            'blocks' => 'Blocks',
        	        'welcome-text' => 'Welcome Text',
    	            'posts' => 'Frontpage Posts'
        	    	)
	        	),
				
		)
	);


	$sections[] = array(
		'icon' => 'website',
		'icon_class' => 'icon-large',
		'title' => __('Slider', 'asteria'),
		'fields' => array(
		
			array(
				'id'=>'slider_type_id',
				'type' => 'select',
				'title' => __('Slider Type', 'asteria'), 
				'options' => array('nivo'=>'Nivo Slider','noslider'=>'Disable Slider'),
				'default' => 'nivo',
				),
			array(
				'id'=>'n_slide_time_id',
				'type' => 'text',
				'title' => __('Pause Time Between Each Slide ', 'asteria'),
				'default' => '4000',
				),
				
			array(
				'id'=>'slide_height',
				'type' => 'text',
				'title' => __('Slider Height ', 'asteria'),
				'default' => '500px',
				),

				
			array(
				'id'=>'slidefont_size_id',
				'type' => 'text',
				'title' => __('Slide Font Size', 'asteria'),
				'default' => '60px'
				),
		
			array(
				'id'=>'slides',
				'type' => 'slides'
			),
				
		)
	);				

	$sections[] = array(
		'icon' => 'tint',
		'icon_class' => 'icon-large',
		'title' => __('Style', 'asteria'),
		'fields' => array(
			//Elements Color

			array(
				'id'=>'sec_color_id',
				'type' => 'color',
				'title' => __('Secondary Element background Color', 'asteria'), 
				'default' => '#2dcb73',
				'transparent' => false,
				'validate' => 'color',
				),

			//Text Colors	
			array(
				'id'=>'primtxt_color_id',
				'type' => 'color',
				'title' => __('Site wide Text Color', 'asteria'), 
				'default' => '#888888',
				'transparent' => false,
				'validate' => 'color',
				),
			array(
				'id'=>'sectxt_color_id',
				'type' => 'color',
				'title' => __('Text Color on secondary elements', 'asteria'), 
				'default' => '#FFFFFF',
				'transparent' => false,
				'validate' => 'color',
				),

			array(
				'id'=>'leavreplytxt_color_id',
				'type' => 'color',
				'title' => __('"Leave a Reply" Text Color', 'asteria'), 
				'default' => '#333333',
				'transparent' => false,
				'validate' => 'color',
				),
				

				
				////
			array(
				'id'=>'style_dvd',
				'type' => 'divide'
				),
				
			array(
				'id'=>'rounded_id',
				'type' => 'switch', 
				'title' => __('Rounded Corners', 'asteria'),
				"default" 		=> 0,
				),
			array(
				'id'=>'shadow_id',
				'type' => 'switch', 
				'title' => __('Drop Shadow', 'asteria'),
				"default" 		=> 0,
				),
			array(
				'id'=>'style-info',
				'type' => 'info',
				'desc' => __("More Styling Options are only available in Asteria PRO", "asteria"),
				),

		)
	);
	$sections[] = array(
		'icon' => 'text-height',
		'icon_class' => 'icon-large',
		'title' => __('Typography Settings', 'asteria'),
		'fields' => array(
			array(
				'id'=>'logo_font_id',
				'type' => 'typography',
				'title' => __('Logo Style', 'asteria'),
				'subtitle' => __('Specify the body font properties.', 'asteria'),
				'google'=>true,
				'font-backup'=>false,
				'line-height'=>false,
				'default' => array(
					'color'=>'#ffffff',
					'font-size'=>'50px',
					'font-family'=>'Cinzel Decorative',
					'font-weight'=>'Normal',
					),
				),	
			array(
				'id'=>'typo-info',
				'type' => 'info',
				'desc' => __("More Typography Options are only available in Asteria PRO", "asteria"),
				),
				
	
		)
	);
		
	$sections[] = array(
		'icon' => 'twitter',
		'icon_class' => 'icon-large',
		'title' => __('Social', 'asteria'),
		'fields' => array(
			array(
				'id'=>'social_single_id',
				'type' => 'switch', 
				'title' => __('Social Share Icons under Posts ', 'asteria'),
				"default" 		=> 1,
				),
			array(
				'id'=>'social_color_id',
				'type' => 'color',
				'title' => __('Social Share Icons Color ', 'asteria'), 
				'default' => '#CCCCCC',
				'transparent' => false,
				'validate' => 'color',
				),
				
			array(
				'id'=>'social_dvd',
				'type' => 'divide'
				),
				
			array(
				'id'=>'facebook_field_id',
				'type' => 'text',
				'title' => __('Facebook URL ','asteria'),
				'validate' => 'url',
				),
			array(
				'id'=>'twitter_field_id',
				'type' => 'text',
				'title' => __('Twitter URL ','asteria'),
				'validate' => 'url',
				),
			array(
				'id'=>'gplus_field_id',
				'type' => 'text',
				'title' => __('Google Plus URL ','asteria'),
				'validate' => 'url',
				),
			array(
				'id'=>'youtube_field_id',
				'type' => 'text',
				'title' => __('Youtube URL ','asteria'),
				'validate' => 'url',
				),
				
			array(
				'id'=>'flickr_field_id',
				'type' => 'text',
				'title' => __('Flickr URL ','asteria'),
				'validate' => 'url',
				),
			array(
				'id'=>'linkedin_field_id',
				'type' => 'text',
				'title' => __('Linkedin URL ','asteria'),
				'validate' => 'url',
				),
			array(
				'id'=>'pinterest_field_id',
				'type' => 'text',
				'title' => __('Pinterest URL ','asteria'),
				'validate' => 'url',
				),
			array(
				'id'=>'tumblr_field_id',
				'type' => 'text',
				'title' => __('Tumblr URL ','asteria'),
				'validate' => 'url',
				),
			array(
				'id'=>'instagram_field_id',
				'type' => 'text',
				'title' => __('Instagram URL ','asteria'),
				'validate' => 'url',
				),
			array(
				'id'=>'rss_field_id',
				'type' => 'text',
				'title' => __('RSS URL ','asteria'),
				'validate' => 'url',
				),
				
		)
	);	
	
	$sections[] = array(
		'icon' => 'tasks',
		'icon_class' => 'icon-large',
		'title' => __('Miscellaneous Settings', 'asteria'),
		'fields' => array(
			array(
				'id'=>'cat_layout_id',
				'type' => 'image_select',
				'compiler'=>true,
				'title' => __('Category, Archive Page posts layout', 'asteria'), 
				'options' => array(
						'1' => array('alt' => 'Layout 1', 'img' => get_template_directory_uri().'/images/layout1.png')
					),
				'default' => '1'
				),
			array(
				'id'=>'post_info_id',
				'type' => 'switch', 
				'title' => __('Show Post Info - Date, Author Name, Categories etc..', 'asteria'),
				"default" 		=> 1,
				),
			array(
				'id'=>'post_nextprev_id',
				'type' => 'switch', 
				'title' => __('Show Next and Previous Posts', 'asteria'),
				"default" 		=> 1,
				),
			array(
				'id'=>'post_comments_id',
				'type' => 'switch', 
				'title' => __('Show Comments', 'asteria'),
				"default" 		=> 1,
				),
			array(
				'id'=>'post_lightbox_id',
				'type' => 'switch', 
				'title' => __('Lightbox Feature', 'asteria'),
				"default" 		=> 1,
				),
				
			array(
				'id'=>'post_gallery_id',
				'type' => 'switch', 
				'title' => __('Beautify My Galleries', 'asteria'),
				"default" 		=> 1,
				),
				
			array(
				'id'=>'blog_cat_id',
				'type' => 'select',
				'data' => 'categories',
				'title' => __('Display Blog Posts from a selected Category', 'asteria'), 
				'desc' => __('If you have setup a Blog page with Blog Page Template, choose a category to get the posts from', 'asteria'),
				),
				
		)
	);	
	$sections[] = array(
		'icon' => 'phone',
		'icon_class' => 'icon-large',
		'title' => __('Mobile Layout', 'asteria'),
		'desc' => __('Checking each of these below option will only hide these elements from the Mobile layout.', 'asteria'),
		'fields' => array(
			array(
				'id'=>'hide_mob_slide',
				'type' => 'checkbox',
				'title' => __('Hide Slider', 'asteria'), 
				'desc' => '',
				'default' => '0'
				),
			array(
				'id'=>'hide_mob_blocks',
				'type' => 'checkbox',
				'title' => __('Hide Front Page Blocks', 'asteria'), 
				'desc' => '',
				'default' => '0'
				),
			array(
				'id'=>'hide_mob_welcm',
				'type' => 'checkbox',
				'title' => __('Hide Front Page Welcome Text', 'asteria'), 
				'desc' => '',
				'default' => '0'
				),
			array(
				'id'=>'hide_mob_frontposts',
				'type' => 'checkbox',
				'title' => __('Hide Front Page Posts', 'asteria'), 
				'desc' => '',
				'default' => '0'
				),
			array(
				'id'=>'hide_mob_footwdgt',
				'type' => 'checkbox',
				'title' => __('Hide Footer Widgets', 'asteria'), 
				'desc' => '',
				'default' => '0'
				),
			array(
				'id'=>'hide_mob_rightsdbr',
				'type' => 'checkbox',
				'title' => __('Hide Right Sidebar', 'asteria'), 
				'desc' => '',
				'default' => '0'
				),
				
		)
	);

	$sections[] = array(
		'icon' => 'css',
		'icon_class' => 'icon-large',
		'title' => __('Custom CSS', 'asteria'),
		'desc' => __('Write your custom css here', 'asteria'),
		'fields' => array(
			array(
				'id'=>'custom-css',
				'type' => 'textarea',
				'validate' => 'css',
				),
				
		)
	);	
	
	$sections[] = array(
		'icon' => 'wrench-alt',
		'icon_class' => 'icon-large',
		'title' => __('Maintenance Mode', 'asteria'),
		'fields' => array(
			array(
				'id'=>'offline_id',
				'type' => 'switch', 
				'title' => __('Maintenance Mode', 'asteria'),
				"default" 		=> 0,
				),
			array(
				'id'=>'offline_date_id',
				'type' => 'date',
				'title' => __('Date ', 'asteria'), 
				'subtitle' => __('Site will be online on', 'asteria')
				),
				
			array(
				'id'=>'offline_time_id',
				'type' => 'text',
				'title' => ''
				),
				
			array(
				'id'=>'offline_text_id',
				'type' => 'text',
				'title' => __('Title ', 'asteria'),
				'default' => 'Maintenance Mode'
				),
			array(
				'id'=>'offline_msg_id',
				'type' => 'editor',
				'title' => __('Message ', 'asteria'), 
				'default' => 'We are currently undergoing  maintenance. Please try back after',
				),
				
		)
	);
	
	$sections[] = array(
		'type' => 'divide',
	);
	
	$sections[] = array(
		'icon' => 'exclamation-sign',
		'icon_class' => 'icon-large',
		'title' => __('About The Theme', 'asteria'),
		'fields' => array(
			array(
			'id'=>'about_id',
			'type' => 'info',
			'required' => array('18','equals',array('1','2')),
			'raw_html'=>true,
			'desc' => $about,
			),		
		)
	);	
	
	$sections[] = array(
		'icon' => 'upload',
		'icon_class' => 'icon-large',
		'title' => __('Upgrade to PRO', 'asteria'),
		'fields' => array(
			array(
			'id'=>'upgrade_id',
			'type' => 'info',
			'required' => array('18','equals',array('1','2')),
			'raw_html'=>true,
			'desc' => $upgrade,
			),		
		)
	);	
	
	$sections[] = array(
		'icon' => 'book',
		'icon_class' => 'icon-large',
		'title' => __('Documentation', 'asteria'),
		'fields' => array(
		array(
			'id'=>'docu_id',
			'type' => 'info',
			'required' => array('18','equals',array('1','2')),
			'raw_html'=>true,
			'desc' => $documentation,
			),	
		)
	);		
	

    global $ReduxFramework;
    $ReduxFramework = new ReduxFramework($sections, $args, $tabs);

}
add_action('init', 'setup_framework_options', 0);


/*
 * 
 * Custom function for the callback referenced above
 *
 */
function my_custom_field($field, $value) {
    print_r($field);
    print_r($value);
}

/*
 * 
 * Custom function for the callback validation referenced above
 *
 */
function validate_callback_function($field, $value, $existing_value) {
    $error = false;
    $value =  'just testing';
    /*
    do your validation
    
    if(something) {
        $value = $value;
    } elseif(somthing else) {
        $error = true;
        $value = $existing_value;
        $field['msg'] = 'your custom error message';
    }
    */
    
    $return['value'] = $value;
    if($error == true) {
        $return['error'] = $field;
    }
    return $return;
}

/*
	This is a test function that will let you see when the compiler hook occurs. 
	It only runs if a field	set with compiler=>true is changed.
*/
function testCompiler() {
	//echo "Compiler hook!";
}
add_action('redux-compiler-redux-sample-file', 'testCompiler');



/**
	Use this function to hide the activation notice telling users about a sample panel.
**/
function removeReduxAdminNotice() {
	delete_option('REDUX_FRAMEWORK_PLUGIN_ACTIVATED_NOTICES');
}
add_action('redux_framework_plugin_admin_notice', 'removeReduxAdminNotice');

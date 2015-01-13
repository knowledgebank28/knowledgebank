<?php
/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since Catch Kathmandu 1.0
 */
function catchkathmandu_widgets_init() {

	// Register Custom Widgets
	register_widget( 'catchkathmandu_social_widget' );
	
	//Main Sidebar
	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'catchkathmandu' ),
		'id' => 'sidebar-1',
		'description'   	=> __( 'Shows the Widgets at the side of Content', 'catchkathmandu' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );	
	
	//Header Right Sidebar
	register_sidebar( array(
		'name' => __( 'Header Right Sidebar', 'catchkathmandu' ),
		'id' => 'sidebar-header-right',
		'description'   	=> __( 'Shows the Widgets at the Top Right Side of Header', 'catchkathmandu' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );	
	
	//Footer One Sidebar
	register_sidebar( array(
		'name' => __( 'Footer Area One', 'catchkathmandu' ),
		'id' => 'sidebar-2',
		'description' => __( 'An optional widget area for your site footer', 'catchkathmandu' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	//Footer Two Sidebar
	register_sidebar( array(
		'name' => __( 'Footer Area Two', 'catchkathmandu' ),
		'id' => 'sidebar-3',
		'description' => __( 'An optional widget area for your site footer', 'catchkathmandu' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	//Footer Three Sidebar
	register_sidebar( array(
		'name' => __( 'Footer Area Three', 'catchkathmandu' ),
		'id' => 'sidebar-4',
		'description' => __( 'An optional widget area for your site footer', 'catchkathmandu' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );	
	
	//Footer Four Sidebar
	register_sidebar( array(
		'name' => __( 'Footer Area Four', 'catchkathmandu' ),
		'id' => 'sidebar-5',
		'description' => __( 'An optional widget area for your site footer', 'catchkathmandu' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );			
	
}
add_action( 'widgets_init', 'catchkathmandu_widgets_init' );


/**
 * Makes a custom Widget for Displaying Social Icons
 *
 * Learn more: http://codex.wordpress.org/Widgets_API#Developing_Widgets
 *
 * @package Catch Themes
 * @subpackage Catch_Kathmandu
 * @since Catch Kathmandu 1.0
 */
class catchkathmandu_social_widget extends WP_Widget {
	
	/**
	 * Constructor
	 *
	 * @return void
	 **/
	function catchkathmandu_social_widget() {
		$widget_ops = array( 'classname' => 'widget_catchkathmandu_social_widget', 'description' => __( 'Use this widget to add Social Icons from Social Icons Settings as a widget. ', 'catchkathmandu' ) );
		$this->WP_Widget( 'widget_catchkathmandu_social_widget', __( '1. Catch Kathmandu: Social', 'catchkathmandu' ), $widget_ops );
		$this->alt_option_name = 'widget_catchkathmandu_social_widget';
	}

	/**
	 * Creates the form for the widget in the back-end which includes the Title , adcode, image, alt
	 * $instance Current settings
	 */
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = esc_attr( $instance[ 'title' ] );
		?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title (optional):','catchkathmandu'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
        </p>
        <?php
	}
	
	/**
	 * update the particular instant  
	 * 
	 * This function should check that $new_instance is set correctly.
	 * The newly calculated value of $instance should be returned.
	 * If "false" is returned, the instance won't be saved/updated.
	 *
	 * $new_instance New settings for this instance as input by the user via form()
	 * $old_instance Old settings for this instance
	 * Settings to save or bool false to cancel saving
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		
		return $instance;
	}	
	
	/**
	 * Displays the Widget in the front-end.
	 * 
	 * $args Display arguments including before_title, after_title, before_widget, and after_widget.
	 * $instance The settings for the particular instance of the widget
	 */
	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );
		$title = !empty( $instance['title'] ) ? $instance[ 'title' ] : '';
			
		echo $before_widget;
		if ( $title != '' ) {
			echo $before_title . apply_filters( 'widget_title', $title, $instance, $this->id_base ) . $after_title;
		} 

		catchkathmandu_social_networks();
		
		echo $after_widget;
	}

}
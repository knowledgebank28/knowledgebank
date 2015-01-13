<?php
/**
 * FullScreen Slider
 *
 * @package   FS_Slider
 * @author    Alex Ilie <contact@wptoolbox.co>
 * @license   GPL-2.0+
 * @link      http://wptoolbox.co
 * @copyright 2013 wptoolbox.co
 */

/**
 * Plugin class.
 *
 * @package FS_Slider
 * @author  Alex Ilie <contact@wptoolbox.co>
 */
class FS_Slider {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	protected $version = '1.0.0';

	/**
	 * Unique identifier for your plugin.
	 *
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'fs-slider';


	/**
	 * Containes the slides
	 *
	 * @since  1.0.0
	 * @var    array
	 */
	private $slides = array();

	/**
	 * Containes the settings
	 *
	 * @since  1.0.0
	 * @var    array
	 */
	private $settings = array();

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		$default_settings = array(
			'speed'     => 5,
			'animation' => 'fade',
			'htmlfix' => 0,
			);
		$this->settings = get_option( 'fs_slider', $default_settings );

		$this->slides = get_option( 'fs_images', array() );

		// Add the plugin settings
		add_action( 'admin_init', array( $this, 'add_plugin_settings' ) );

		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Load public-facing style sheet and JavaScript.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		// Load the slider into footer
		add_action( 'wp_footer', array( $this, 'display_slider' ), 60 );

	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}
	/**
	 * Register and enqueue admin-specific style sheet.	 *
	 * @since     1.0.0
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $screen->id == $this->plugin_screen_hook_suffix ) {
			wp_enqueue_style( $this->plugin_slug . '-jquery-ui', plugins_url( 'css/jquery-ui-1.10.3.custom.css', __FILE__ ), array(), $this->version );
			wp_enqueue_style( $this->plugin_slug .'-admin-styles', plugins_url( 'css/admin.css', __FILE__ ), array(), $this->version );
		}

	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $screen->id == $this->plugin_screen_hook_suffix ) {
			wp_enqueue_media();
			wp_enqueue_script('media-upload');
			wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'js/admin.js', __FILE__ ), array( 'jquery', 'jquery-ui-core', 'jquery-ui-draggable', 'jquery-ui-sortable' ), $this->version, true );
		}

	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'css/fs_slider.css', __FILE__ ), array(), $this->version );
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( 'jquery-easing', plugins_url( 'js/jquery.easing.1.3.js', __FILE__ ), array( 'jquery' ), '1.3', true );
		wp_enqueue_script( 'jquery-animate-enhanced', plugins_url( 'js/jquery.animate-enhanced.min.js', __FILE__ ), array( 'jquery' ), '1.0.2', true );
		wp_enqueue_script( 'jquery-superslides', plugins_url( 'js/jquery.superslides.min.js', __FILE__ ), array( 'jquery' ), '0.6.2', true );

	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		$this->plugin_screen_hook_suffix = add_theme_page(
			'Fullscreen Slider',
			'Fullscreen Slider',
			'read',
			$this->plugin_slug,
			array( $this, 'display_plugin_admin_page' )
		);

	}

	/**
	 * Register the plugin settings
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_settings() {
		register_setting( 'fs_slider_settings', 'fs_slider', array( $this, 'validate_settings' ) );
		register_setting( 'fs_slider_settings', 'fs_images' );
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {
		include_once( 'views/admin.php' );
	}

	/**
	 * Validate the slider settings
	 * @param  array $settings
	 * @return array $settings          the validated settings
	 */
	public function validate_settings( $options ){

		// validate the htmlfix checkbox
		$validated['htmlfix'] = ( isset( $options['htmlfix'] ) ) ? 1 : 0;

		// validate the animation type
		$validated['animation'] = sanitize_text_field( $options['animation'] );

		// validate the animation speed
		$validated['speed'] = floatval( $options['speed'] );

		return $validated;

	}

	public function display_slider() {

		// if no slides are present than exit
		if ( empty( $this->slides ) || is_admin() ) {
			return;
		}

		// output the html markup
		$slides = $this->slides;
		ob_start();
		?>
		<div id="fs-slider-container">
			<div id="slides">
			  <div class="slides-container">
			    <?php foreach ($slides as $index => $slide) { ?>
			    	<img src="<?php echo $slide['url']; ?>" alt="">
			    <?php } ?>
			  </div>
			</div>
		</div>
		<?php
		$output = ob_get_clean();

		// output the js for the slider
		$options = $this->settings;
		ob_start();
		?>
		<script>
			jQuery('#slides').superslides({
		    slide_easing: 'easeInOutCubic',
		    play: <?php echo  intval($options['speed']) * 1000; ?>,
		    animation:  '<?php echo $options['animation']; ?>',
		    pagination: false,
		    scrollable: false
		  });
		  <?php if ( $options['htmlfix'] ) : ?>
		  jQuery('html').css( 'overflow-y', 'visible' );
		  <?php endif; ?>
		</script>
		<?php
		$output .= ob_get_clean();

		echo $output;
	}

}
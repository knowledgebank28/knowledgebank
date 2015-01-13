<?php
//Content Width
if ( ! isset( $content_width ) ) $content_width = 690;
//Front page query
function asteria_home_query($query) {
    if ( $query->is_home()) {
		global $asteria;
		set_query_var( 'post_type', 'post' );
		set_query_var( 'paged', ( get_query_var('paged') ? get_query_var('paged') : 1) );
		if(!empty($asteria['enable_cat'])){
		$postcount = $asteria['n_posts_field_id'];
		$postcat = $asteria['posts_cat_id'];
		set_query_var( 'posts_per_page', ''.$postcount.'' );
		if(!empty($asteria['posts_cat_id'])){set_query_var( 'cat', ''.implode(',', $postcat).'' );}
		}
    }
	
}
add_action( 'pre_get_posts', 'asteria_home_query' );

//Asteria Site title
function asteria_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'asteria' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'asteria_wp_title', 10, 2 );

//Load Other CSS files
function asteria_other_css() { 
if ( !is_admin() ) {
wp_enqueue_style( 'asteria-style', get_stylesheet_uri());
global $asteria; if ( ! empty ( $asteria['post_lightbox_id'] ) ) {wp_enqueue_style('fancybox',get_template_directory_uri().'/css/fancybox.css'); }
wp_enqueue_style('customfont',get_template_directory_uri().'/fonts/yanone_kaffeesatz.css', 'yanone_kaffeesatz' ); 
wp_enqueue_style('customfont2',get_template_directory_uri().'/fonts/opensans-light.css', 'open_sans' );
wp_enqueue_style('icons',get_template_directory_uri().'/fonts/font-awesome.css', 'font_awesome' );
	}
}
add_action('wp_enqueue_scripts', 'asteria_other_css');	

//Load Default Logo Fonts
function asteria_google_fonts() {
		//Site Title Font
		wp_register_style('SiteTitleFont','http://fonts.googleapis.com/css?family=Cinzel+Decorative');
			global $asteria;
            if ( !get_option( 'asteria' )) {
				wp_enqueue_style( 'SiteTitleFont'); }

}
add_action('wp_print_styles', 'asteria_google_fonts');

//Load Java Scripts to header
function asteria_head_js() { 
if ( !is_admin() ) {
wp_enqueue_script('jquery');
wp_enqueue_script('asteria_js',get_template_directory_uri().'/asteria.js');
wp_enqueue_script('asteria_otherjs',get_template_directory_uri().'/js/other.js');
global $asteria; if ( ! empty ( $asteria['post_gallery_id'] ) ) {wp_enqueue_script('asteria_gallery',get_template_directory_uri().'/js/gallery.js');}
global $asteria; if ( ! empty ( $asteria['post_lightbox_id'] ) ) {wp_enqueue_script('asteria_fancybox',get_template_directory_uri().'/js/fancybox.js');}
wp_enqueue_script('asteria_nivo',get_template_directory_uri().'/js/jquery.nivo.js');
if ( is_singular() ) wp_enqueue_script( 'comment-reply' );

	}	
}
	
add_action('wp_enqueue_scripts', 'asteria_head_js');


//Load RAW Java Scripts 
add_action('wp_footer', 'znn_load_js');
 
function znn_load_js() { 
include(get_template_directory() . '/javascript.php');
} 
	
//SIDEBAR
function asteria_widgets_init(){
	
	register_sidebar(array(
	'name'          => __('Right Sidebar', 'asteria'),
	'id'            => 'sidebar',
	'description'   => __('Right Sidebar', 'asteria'),
	'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget_wrap">',
	'after_widget'  => '<span class="widget_corner"></span></div></div>',
	'before_title'  => '<h3 class="widgettitle">',
	'after_title'   => '</h3>'
	));
	
	register_sidebar(array(
	'name'          => __('Footer Widgets', 'asteria'),
	'id'            => 'foot_sidebar',
	'description'   => __('Widget Area for the Footer', 'asteria'),
	'before_widget' => '<li id="%1$s" class="widget %2$s"><div class="widget_wrap">',
	'after_widget'  => '</div>',
	'before_title'  => '<h3 class="widgettitle">',
	'after_title'   => '</h3>'
	));
	
	
}

add_action( 'widgets_init', 'asteria_widgets_init' );

//asteria get the first image of the post Function
function asteria_get_images($overrides = '', $exclude_thumbnail = false)
{
    return get_posts(wp_parse_args($overrides, array(
        'numberposts' => -1,
        'post_parent' => get_the_ID(),
        'post_type' => 'attachment',
        'post_mime_type' => 'image',
        'order' => 'ASC',
        'exclude' => $exclude_thumbnail ? array(get_post_thumbnail_id()) : array(),
        'orderby' => 'menu_order ID'
    )));
}


//Custom Excerpt Length
function asteria_excerptlength_teaser($length) {
    return 20;
}
function asteria_excerptlength_index($length) {
    return 12;
}
function asteria_excerptmore($more) {
    return '...';
}

function asteria_excerpt($length_callback='', $more_callback='') {
    global $post;
    if(function_exists($length_callback)){
        add_filter('excerpt_length', $length_callback);
    }
    if(function_exists($more_callback)){
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>'.$output.'</p>';
    echo $output;
}

//Asteria CUSTOM Search Form
function asteria_search_form( $form ) {
    $form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
    <div>
    <input placeholder="' . __( 'Search....', 'asteria' ) . '" type="text" value="' . get_search_query() . '" name="s" id="s" />
    <input type="submit" id="searchsubmit" value="'. esc_attr__( 'Search', 'asteria' ) .'" />
    </div>
    </form>';

    return $form;
}

add_filter( 'get_search_form', 'asteria_search_form' );


//**************TASTERIA COMMENTS******************//
function asteria_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">

     <div id="comment-<?php comment_ID(); ?>" class="comment-body">
      <div class="comment-author vcard">
      <div class="avatar"><?php echo get_avatar($comment,$size='75' ); ?></div>
      </div>
      <div class="comment-meta commentmetadata">
      <?php printf(__('%s', 'asteria'), get_comment_author_link()) ?> <span><?php _e('says:', 'asteria') ?></span>
        </div>
      <?php if ($comment->comment_approved == '0') : ?>
         <em><?php _e('Your comment is awaiting moderation.', 'asteria') ?></em>
         <br />
      <?php endif; ?>

      <div class="org_comment"><?php comment_text() ?>
      	
      	<div class="comm_meta_reply">
        <a class="comm_date"><i class="icon-time"></i><?php printf(get_comment_date()) ?></a>
        <div class="comm_reply"><i class="fa-reply"></i><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></div>
        <?php edit_comment_link(__('Edit', 'asteria'),'<i class="fa-pencil"></i>','') ?></div>
     </div>
     
     </div>
<?php
        }
		
//**************TRACKBACKS & PINGS******************//
function asteria_ping($comment, $args, $depth) {
 
$GLOBALS['comment'] = $comment; ?>
	
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
   
     <div id="comment-<?php comment_ID(); ?>" class="comment-body">
      <?php if ($comment->comment_approved == '0') : ?>
         <em><?php _e('Your comment is awaiting moderation.', 'asteria') ?></em>
         <br />
      <?php endif; ?>

      <div class="org_ping">
      	<?php printf(__('<cite class="citeping">%s</cite> <span class="says">:</span>'), get_comment_author_link()) ?>
	  	<?php comment_text() ?>
            <div class="comm_meta_reply">
            <a class="comm_date"><?php printf(get_comment_date()) ?></a>
            <?php edit_comment_link(__('Edit', 'asteria'),'  ','') ?></div>
     </div>
     </div>
     
     
<?php }


//**************COMMENT FORM******************//
function asteria_comment_form ( $arg ) {
	$commenter = wp_get_current_commenter();
$req = get_option( 'require_name_email' );
$aria_req = ( $req ? " aria-required='true'" : '' );
    $defaults = array( 'title_reply'=>''. __( 'Leave a Reply', 'asteria' ) . '',

'fields' => apply_filters( 'comment_form_default_fields', array(

  'author' => '<div class="comm_wrap"><p class="comment-form-author"><input placeholder="' . __( 'Name', 'asteria' ) . '" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .'" size="30"' . $aria_req . ' /></p>',

  'email' => '<p class="comment-form-email"><input placeholder="' . __( 'Email', 'asteria' ) . '" id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .'" size="30"' . $aria_req . ' /></p>',

  'url' => '<p class="comment-form-url"><input placeholder="' . __( 'Website', 'asteria' ) . '" id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .'" size="30" /></p></div>')
  
 ));
    return $arg;
    }

    add_filter( 'comments_form_defaults', 'asteria_comment_form' );


//WOOCOMMERCE SUPPORT
if (class_exists('Woocommerce')) {
	
	add_action('woocommerce_before_main_content', 'asteria_wrapper_start', 10);
	add_action('woocommerce_after_main_content', 'asteria_wrapper_end', 10);
	
	function asteria_wrapper_start() {
	  echo '<div class="fixed_site"><div class="fixed_wrap"><div class="center">';
	}
	
	function asteria_wrapper_end() {
	  echo '</div></div></div>';
	}
	//Remove Sidebars from all woocommerce pages
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);	
}

//**************ASTERIA SETUP******************//
function asteria_setup() {
//Custom Thumbnail Size	
if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'asteriathumb', 387, 260, true ); //(cropped)
}

//Woocommerce Support
add_theme_support( 'woocommerce' );
 
//Custom Background
add_theme_support( 'custom-background', array(
	'default-color' => 'f7f7f7'
) );

add_theme_support('automatic-feed-links');

//Post Thumbnail	
   add_theme_support( 'post-thumbnails' );

// Make theme available for translation
 load_theme_textdomain('asteria', get_template_directory() . '/languages');  
   
//Register Menus
	register_nav_menus( array(
		'primary' => __( 'Header Navigation', 'asteria' )
	) );


}
add_action( 'after_setup_theme', 'asteria_setup' );


/*Mobile Detection*/
function asteria_is_mobile() {
    static $is_mobile;

    if ( isset($is_mobile) )
        return $is_mobile;

    if ( empty($_SERVER['HTTP_USER_AGENT']) ) {
        $is_mobile = false;
    } elseif (
        strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false ) {
            $is_mobile = true;
    } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false && strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') == false) {
            $is_mobile = true;
    } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== false) {
        $is_mobile = false;
    } else {
        $is_mobile = false;
    }

    return $is_mobile;
}


/* -----------------------------------------------------------------------------
    Underconstruction / Maintenance Mode
----------------------------------------------------------------------------- */
		function asteria_under_contruction(){
		global $asteria;
		if(!empty($asteria['offline_id'])){		
			// if user is logged in, don't show the construction page
			if ( is_user_logged_in() ) {
				return;
			}
			// You could check the remote ip
			// $ips = array( '127.0.0.1', '192.168.0.1', '208.117.46.9' );
			// if ( in_array( $_SERVER['REMOTE_ADDR'], $ips ) ) {
			//     return;
			// }
			$protocol = $_SERVER["SERVER_PROTOCOL"];
			if ( 'HTTP/1.1' != $protocol && 'HTTP/1.0' != $protocol )
				$protocol = 'HTTP/1.0';
			// 503 is recommended :  http://bit.ly/YdGkXl
			header( "$protocol 503 Service Unavailable", true, 503 );
			// or header( "$protocol 200 Ok", true, 200 );
			header( 'Content-Type: text/html; charset=utf-8' );
			// adjust the Retry-After value (in seconds)
			header( 'Retry-After: 3600' );
		?>
		<?php get_template_part('maintanance'); ?>
		<?php
		
			die();
		
		}
}
add_action( 'template_redirect', 'asteria_under_contruction' );



/* -----------------------------------------------------------------------------
    LIVE CUSTOMIZER
----------------------------------------------------------------------------- */
function asteria_customizer( $wp_customize ) {
//register the javascript	
if ( $wp_customize->is_preview() && ! is_admin() )
    add_action( 'wp_footer', 'asteria_customize_preview', 21);

    $wp_customize->add_section(
        'asteria_section_one',
        array(
            'title' => 'Asteria Element Colors',
            'description' => 'Change the color of each element',
            'priority' => 35,
        )
    );
	
    $wp_customize->add_section(
        'asteria_section_two',
        array(
            'title' => 'Asteria Text Colors',
            'description' => 'Change the color of each element',
            'priority' => 35,
        )
    );
	
	$wp_customize->add_setting('asteria[sec_color_id]',array('type' => 'option','transport'   => 'postMessage'));


	$wp_customize->add_setting('asteria[primtxt_color_id]',array('type' => 'option','transport'   => 'postMessage'));
	$wp_customize->add_setting('asteria[sectxt_color_id]',array('type' => 'option','transport'   => 'postMessage'));
	$wp_customize->add_setting('asteria[menutxt_color_id]',array('type' => 'option','transport'   => 'postMessage'));
	$wp_customize->add_setting('asteria[leavreplytxt_color_id]',array('type' => 'option','transport'   => 'postMessage'));	
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'live_sec_elm', array(
		'label'   => __( 'Secondary Element background Color', 'asteria' ),
		'section' => 'asteria_section_one',
		'settings'   => 'asteria[sec_color_id]',
	) ) );

	
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'live_prim_txt', array(
		'label'   => __( 'Site wide Text Color', 'asteria' ),
		'section' => 'asteria_section_two',
		'settings'   => 'asteria[primtxt_color_id]',
	) ) );
	
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'live_sec_txt', array(
		'label'   => __( 'Text Color on secondary elements', 'asteria' ),
		'section' => 'asteria_section_two',
		'settings'   => 'asteria[sectxt_color_id]',
	) ) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'live_leavreply_txt', array(
		'label'   => __( '"Leave a Reply" Text Color', 'asteria' ),
		'section' => 'asteria_section_two',
		'settings'   => 'asteria[leavreplytxt_color_id]',
	) ) );	
}

add_action( 'customize_register', 'asteria_customizer' );


function asteria_customizer_live_preview() {
 
	wp_enqueue_script(
		'live_fontselect',
		get_template_directory_uri() . '/admin/js/jquery.fontselect.min.js',
		array( 'jquery', 'customize-preview' ),
		'',
		true
	);
 
} // end asteria_customizer_live_preview
add_action( 'customize_preview_init', 'asteria_customizer_live_preview' );

function asteria_customize_preview() {

    ?>
    <script type="text/javascript">
    ( function( $ ){
	//Primary Color change
    wp.customize('asteria[prim_color_id]',function( value ) {value.bind(function(newval) {$('.fixed_wrap, #ast_nextprev, #ast_related ul li.active, .single_post .tabs li.active, .single_post .tabs li, .trigger_wrap, .single_post, .comment-body, #ast_related, #ast_related ul, .comm_wrap input, .comment-form-comment textarea, .lay4 .hentry, .lay2 .hentry, .lay3 .hentry, .search_term, .author_div').attr('style', 'background:'+ newval + '!important');});});
	//Secondary Color change
    wp.customize('asteria[sec_color_id]',function( value ) {value.bind(function(newval) {$('#topmenu ul li ul li a:hover, .nivo-caption .sldcontent1 h3 a, .nivo-controlNav a.active, .banner .sldcontent1 h3 a, .acc-sldcontent1 h3 a, .tab.active, .thn_post_wrap .more-link:hover, .moretag:hover, #submit, .page_tt, #searchsubmit, .contact_submit input, .pad_menutitle, .to_top:hover, .page-numbers:hover, .ast_pagenav .current, .progrssn').attr('style', 'background:'+ newval + '!important');});});	
    wp.customize('asteria[sec_color_id]',function( value ) {value.bind(function(newval) {$('#sidebar .widget .widgettitle, #home_widgets .widget .widgettitle, .single_post .postitle, .nivo-caption p a, .banner .sldcontent1 p a, .banner .sldcontent2 p a, .banner .wrap-sld_layout3 p a, .acord_text p a, .lay2 h2 a, .lay3 h2 a, .lay4 h2 a, .lay5 .postitle a, #ast_nextprev .ast-prev:hover .left_arro i, #ast_nextprev .ast-next:hover .right_arro i, .rel_content a, #reply-title small a, .logged-in-as a, .thn_post_wrap a:link, .thn_post_wrap a:visited, .single_metainfo a i:hover, .edit_wrap i:hover, .single_post .postitle, #sidebar .widget .widgettitle, #sidebar .widget .widgettitle a, #home_widgets .widget a:link, #home_widgets .widget a:visited, #home_widgets .widget .thn_wgt_tt, #sidebar .widget .thn_wgt_tt, #footer .widget .thn_wgt_tt, .widget_calendar td a, .astwt_iframe a, .ast_countdown li, .ast_biotxt a, .ast_bio .ast_biotxt h3, .search_term h2, .author_right h2, .author_right a, #contact_block .widgettitle, #contact_block a:link, #contact_block a:visited, .copytext a, .ast_maintanace .logo h1 a, #ast_nextprev .ast-prev:hover .left_arro i, #ast_nextprev .ast-next:hover .right_arro i').attr('style', 'background:'+ newval + '!important');});});	

	//TEXT COLORS=======================
	wp.customize('asteria[primtxt_color_id]',function( value ) {value.bind(function(newval) {$('body, .single_metainfo, .single_post .single_metainfo a, .midrow_block h3').attr('style', 'color:'+ newval + '!important');});});	
	wp.customize('asteria[sectxt_color_id]',function( value ) {value.bind(function(newval) {$('#topmenu ul li ul li a:hover, .tab a.active, #ast_nextprev .ast-prev:hover .left_arro, #ast_nextprev .ast-next:hover .right_arro, .page-numbers:hover').attr('style', 'color:'+ newval + '!important');});});
	wp.customize('asteria[leavreplytxt_color_id]',function( value ) {value.bind(function(newval) {$('.comments_template #comments, #comments_ping, #reply-title, .related_h3').attr('style', 'color:'+ newval + '!important');});});
	
    } )( jQuery )
    </script>
    <?php 
} 

/**
 * Options Framework
 */

require_once('redux/framework.php');
require_once('asteria-config.php');
function asteria_admin() {
    wp_register_style(
        'redux-custom-css',
        get_template_directory_uri() . '/css/admin.css',
        array( 'redux-css' ), // Be sure to include redux-css so it's appended after the core css is applied
        time(),
        'all'
    );  
	wp_register_style(
		'redux-fontawesome',
		get_template_directory_uri() . '/fonts/font-awesome.css',
		array(),
		time(),
		'all'
	);
	wp_enqueue_style( 'redux-custom-css' );
	wp_enqueue_style( 'redux-fontawesome' );
	wp_enqueue_script( 'admin-js', get_template_directory_uri() . '/js/admin.js', false, '1.0', true );
	
}
add_action('redux-enqueue-asteria', 'asteria_admin');
?>
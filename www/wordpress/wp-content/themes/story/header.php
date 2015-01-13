<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Story
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.js"></script>
<![endif]-->
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="page" class="hfeed site">

	<header id="masthead" class="site-header" role="banner">
		<div id="header-inner">

			<?php
			if ( get_theme_mod( 'logo_upload') ) {
				$story_logo = "<img class='logo' src='".esc_url(get_theme_mod( 'logo_upload'))."' alt='".esc_attr( get_bloginfo( 'name' ) )."' />";
				$story_class = "img";
			} else {
				$story_logo = get_bloginfo('name');
				$story_class = "text";
			}
			?>
			<div class="site-branding">
				<h1 class="site-title <?php echo $story_class; ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo $story_logo; ?></a></h1>
			</div>

			<nav id="site-navigation" class="main-navigation" role="navigation">

				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'menu' ) ); ?>

			</nav><!-- #site-navigation -->
			<div id="mobile-menu"></div>
		</div><!-- #header-inner -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
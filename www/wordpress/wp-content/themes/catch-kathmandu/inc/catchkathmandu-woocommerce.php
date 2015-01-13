<?php
/**
 * Adding support for WooCommerce Plugin
 * 
 * uses remove_action to remove the WooCommerce Wrapper and add_action to add Simple Catch Wrapper
 *
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

if ( ! function_exists( 'catcheverest_woocommerce_start' ) ) :
function catcheverest_woocommerce_start() {
	echo '<div id="primary" class="content-area"><div id="content" class="site-content woocommerce" role="main">';
}
endif; //catcheverest_woocommerce_start
add_action('woocommerce_before_main_content', 'catcheverest_woocommerce_start', 15);

if ( ! function_exists( 'catcheverest_woocommerce_end' ) ) :
function catcheverest_woocommerce_end() {
	echo '</div></div>';
}
endif; //catcheverest_woocommerce_end
add_action('woocommerce_after_main_content', 'catcheverest_woocommerce_end', 15);
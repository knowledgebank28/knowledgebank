/**!
 * WP Theme Customizer
 */
/*
WPTC Scripts
*/
jQuery(document).ready(function(){

	jQuery('#wptc_module_show').click(function(){
		jQuery('#wptc_module').fadeIn(100);
		jQuery(this).fadeOut(100);
	});
	jQuery('#wptc_module_hide').click(function(){
		jQuery('#wptc_module').fadeOut(100);
		jQuery('#wptc_module_show').fadeIn(100);
	});
	
	jQuery('.wptc-li-colors').click(function(){

		jQuery('.wptc_backgrounds_switcher, .wptc_effects_switcher, .wptc_backgrounds_slogan, .wptc_effects_slogan').stop().hide(1);
		jQuery('.wptc_colors_switcher, .wptc_colors_slogan').delay(1).fadeIn(500);
		
		jQuery('.wptc-nav-li').removeClass('active');
		jQuery(this).addClass('active');
		
	});
	
	jQuery('.wptc-li-backgrounds').click(function(){

		jQuery('.wptc_colors_switcher, .wptc_effects_switcher, .wptc_colors_slogan, .wptc_effects_slogan').stop().hide(1);
		jQuery('.wptc_backgrounds_switcher, .wptc_backgrounds_slogan').delay(1).fadeIn(500);
		
		jQuery('.wptc-nav-li').removeClass('active');
		jQuery(this).addClass('active');
		
	});
	
	jQuery('.wptc-li-effects').click(function(){

		jQuery('.wptc_colors_switcher, .wptc_backgrounds_switcher, .wptc_colors_slogan, .wptc_backgrounds_slogan').stop().hide(1);
		jQuery('.wptc_effects_switcher, .wptc_effects_slogan').delay(1).fadeIn(500);
		
		jQuery('.wptc-nav-li').removeClass('active');
		jQuery(this).addClass('active');
		
	});

});
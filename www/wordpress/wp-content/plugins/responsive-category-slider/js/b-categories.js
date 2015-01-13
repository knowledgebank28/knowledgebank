/**
 * @package   Responsive Category Slider
 * @author     ThemeLead Team <support@themelead.com>
 * @copyright  Copyright 2014 themelead.com. All Rights Reserved.
 * @license    GPLv2 or later - http://www.gnu.org/licenses/gpl-2.0.html
 * Websites: http://www.themelead.com
 * Technical Support:  Free Forum Support - http://support.themelead.com
 */
var $ = jQuery;
$(window).load(function() {
	$('.b-plugins-category .b-flexslider').each(function(){
		var autoslide = $(this).attr("data-autoslide");
		var control_show = $(this).attr("data-control-nav");
		var slideSpeed = $(this).attr("data-slideshowspeed");
		if(autoslide === 'true'){ autoshow = true; }else { autoshow = false; }
		if(control_show === 'on'){ control_nav = true; }else{ control_nav = false;}
		
		$(this).flexslider({
			slideshow: autoshow,
			animation: "slide",
			controlNav: control_nav,
			slideshowSpeed: slideSpeed,
			prevText: "",
			nextText: ""
		});
	});
	$('.b-flexslider-mb').each(function(){
		$(this).flexslider({
			animation: "slide",
			itemWidth: 167,
			slideshow: false,
			controlNav: false,
			prevText: "",
			nextText: ""
		});
	});
	$('.b-plugins-category.b-vertical').each(function(){
		var this_select = $(this);
		var width_gallery = $(this).width();
		var width_menu = $('.b-menu-categories', this_select).width();
		var width_plugin_view = width_gallery - width_menu;
		if(width_plugin_view < 250){
			$('.b-gallery-style .b-slider-thumbnail .b-face-post', this_select).addClass("b-small-width");
		}
		else if(width_plugin_view < 350){
			$('.b-gallery-style .b-slider-thumbnail .b-face-post', this_select).addClass("b-lager-width");
		}
	});
	$('.b-plugins-category.b-no-vertical').each(function(){
		var this_select_hori = $(this);
		var width_gallery_hori = $(this).width();
		if(width_gallery_hori < 250){
			$('.b-gallery-style .b-slider-thumbnail .b-face-post', this_select_hori).addClass("b-small-width");
		}
		else if(width_gallery_hori < 350){
			$('.b-gallery-style .b-slider-thumbnail .b-face-post', this_select_hori).addClass("b-lager-width");
		}
	});
});
$(document).ready(function(){
	/*Call function PrettyPhoto*/
	$("a[rel^='prettyPhoto']").prettyPhoto();
	
	//Click menu to slideDown and slideUp flexslider on mobile
	$('ul.b-menu-category li:first-child a.b-vertical').addClass("b-toggle");
	$('ul.b-menu-category li:first-child .b-flexslider-mobie').addClass('b-toggle-mobile');
	$('ul.b-menu-category li a.b-vertical').click(function(){
		if($(window).width() <= 480){
			if(!$(this).hasClass("b-toggle")){
				$(this).parent("li").children(".b-flexslider-mobie").addClass("b-toggle-mobile");
				$(this).addClass("b-toggle");
				return false;
			} else {
				$(this).parent("li").children(".b-flexslider-mobie").removeClass("b-toggle-mobile");
				$(this).removeClass("b-toggle");
				return false;
			}
		}
	});
	b_check_show_hide_parent_menu();
	$( window ).resize(function() {
	  b_check_show_hide_parent_menu();
	});
});


$(function(){
	$more = $('.b-menu-horizontal .b-menu-category li a, a.b-vertical');
	
	$more.click(function(){
		if($(window).width() > 480){
			var plugin_id = $(this).attr("name");
			var parent = $("#b-plugins-category-"+plugin_id);
	
			$type = $("#b-data-ajax #cat_type", parent).attr("alt");
			$tax_name = $("#b-data-ajax #tax_name", parent).attr("alt");
			$custom_post = $("#b-data-ajax #custom_post", parent).attr("alt");
			$per_page = $("#b-data-ajax #per_page", parent).attr("alt");
			$columns = $("#b-data-ajax #columns", parent).attr("alt");
			$style = $("#b-data-ajax #style", parent).attr("alt");
			$order = $("#b-data-ajax #order", parent).attr("alt");
			$order_by = $("#b-data-ajax #order_by", parent).attr("alt");
			$auto_slide = $("#b-data-ajax #auto_slide", parent).attr("alt");
			$control_nav = $("#b-data-ajax #control_nav", parent).attr("alt");
			$image_size = $("#b-data-ajax #image_size", parent).attr("alt");
			$linkable = $("#b-data-ajax #linkable", parent).attr("alt");
			$b_device = $("#b-data-ajax #b_device", parent).attr("alt");
			$cat_id = $(this).attr("alt");
			
			
			$('.b-menu-horizontal .b-menu-category li a, a.b-vertical', parent).removeClass('b-menu-active');
			$('.b-menu-horizontal .b-menu-category li', parent).removeClass('b-hori-menu-active');
			if(!$(this).hasClass('b-clicked')){
				$(this).addClass('b-clicked');
				$(this).addClass('b-menu-active');
				$(this).parent("li").addClass('b-hori-menu-active');
				$("#b-ajax-results-html", parent).css("opacity", "0.3");
				$('#b-ajax-loaded-posts', parent).show();

				$.ajax({
				  type: "POST",
				  url: b_res_cat_slider_ajax_object.ajaxurl,
				  dataType: 'html',
				  data: ({ action: 'b_ajax_load_posts', image_size: $image_size, b_device: $b_device, linkable: $linkable, order: $order, order_by: $order_by, auto_slide: $auto_slide, control_nav: $control_nav, type: $type, tax_name: $tax_name, custom_post: $custom_post, per_page: $per_page, columns: $columns, style: $style, cat_id: $cat_id, plugin_id: plugin_id}),
				  success: function(data){
					$('#b-ajax-results-html', parent).html(data);
					$('#b-ajax-results-html', parent).css("opacity", "1");
					$('#b-ajax-loaded-posts', parent).hide();
					$more.removeClass('b-clicked');
				  }   
				});
			}
			return false;
		}
	});
});

$(function () {
	var e = window, a = 'inner';
	if (!('innerWidth' in window )) {
		a = 'client';
		e = document.documentElement || document.body;
	}
	var width_window = e[ a+'Width' ];
	if(width_window > 992){
		$('.b-box').hoverDirection();
		$('.b-box .b-inner').on('animationend', function (event) {
			var $box = $(this).parent();
			$box.filter('[class*="-leave-"]').hoverDirection('removeClass');
		});
	}
});
function b_check_show_hide_parent_menu(){
	var e = window, a = 'inner';
	if (!('innerWidth' in window )) {
		a = 'client';
		e = document.documentElement || document.body;
	}
	var width_window = e[ a+'Width' ];
	if(width_window < 481){
		$('.b-plugins-category.b-not-show-parent').each(function(){
			var hide_menu = $(this);
			$("ul.b-menu-category >li:nth-child(2) a.b-vertical", hide_menu).addClass("b-toggle");
			$("ul.b-menu-category >li:nth-child(2) div.b-flexslider-mobie", hide_menu).addClass("b-toggle-mobile");
		});
	}
}
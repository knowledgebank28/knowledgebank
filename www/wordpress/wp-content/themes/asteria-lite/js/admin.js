// JavaScript Document
jQuery(window).ready(function() {
	
	jQuery('.redux-group-tab .form-table tr').each( function(){ 
	var classtr = jQuery(this).find('fieldset').attr('id');
	jQuery(this).addClass('tr_' + classtr);
	});
	
	//Frontpage Settings Submenu
	jQuery('#2_section_group').prepend('<ul class="front_sub"><li class="active block_trigger">Blocks</li><li class="welcome_trigger">Welcome Text</li><li class="posts_trigger">Frontpage Posts</li><li class="map_trigger">Location Map</li><li class="callaction_trigger">Call to Action</li><li class="frontwdgt_trigger">Frontpage Widgets</li></ul>')
	jQuery('.tr_asteria-block1_text_id, .tr_asteria-block1_icon, .tr_asteria-block1_textarea_id, .tr_asteria-block1_link_id, .tr_asteria-block2_text_id, .tr_asteria-block2_icon, .tr_asteria-block2_textarea_id, .tr_asteria-block2_link_id, .tr_asteria-block3_text_id, .tr_asteria-block3_icon, .tr_asteria-block3_textarea_id, .tr_asteria-block3_link_id, .tr_asteria-block4_text_id, .tr_asteria-block4_icon, .tr_asteria-block4_textarea_id, .tr_asteria-block4_link_id').addClass('ast_blocks');
	jQuery('.tr_asteria-welcm_textarea_id, .tr_asteria-welcome_color_id').addClass('ast_welcome');
	jQuery('.tr_asteria-posts_title_id, .tr_asteria-front_layout_id, .tr_asteria-enable_cat, .tr_asteria-posts_cat_id, .tr_asteria-n_posts_field_id').addClass('ast_posts');	
	jQuery('#map-info').addClass('ast_map');
	jQuery('#callaction-info').addClass('ast_callaction');
	jQuery('#2_section_group #widget-info').addClass('ast_frntwdgt');
		
	jQuery(".ast_frntwdgt, .ast_posts, .ast_map, .ast_callaction, .ast_welcome, .tr_asteria-map-info:parent, .tr_asteria-callaction-info:parent, .tr_asteria-widget-info:parent").hide();
	jQuery(".tr_asteria-map-info, .tr_asteria-callaction-info, .tr_asteria-widget-info").prev().hide();

	
	jQuery('.front_sub li').click(function(){
    	jQuery('.front_sub li').removeClass("active");
		jQuery(".ast_blocks, .ast_frntwdgt, .ast_posts, .ast_map, .ast_callaction, .ast_welcome, #2_section_group #widget-inf").hide();
    	jQuery(this).addClass("active");
	});
		jQuery('.block_trigger').click(function(){ jQuery('.ast_blocks').fadeIn(300); });
		jQuery('.welcome_trigger').click(function(){ jQuery('.ast_welcome').fadeIn(300); });
		jQuery('.posts_trigger').click(function(){ jQuery('.ast_posts').fadeIn(300); });
		jQuery('.map_trigger').click(function(){ jQuery('.ast_map').fadeIn(300); });
		jQuery('.callaction_trigger').click(function(){ jQuery('.ast_callaction').fadeIn(300); });
		jQuery('.frontwdgt_trigger').click(function(){ jQuery('.ast_frntwdgt').fadeIn(300); });
		
//Documentation
jQuery(".docu_front").click(function() {jQuery('#ast_docu').fadeOut();jQuery("#docu_front").delay(300).fadeIn();});
jQuery(".docu_img").click(function() {jQuery('#ast_docu').fadeOut();jQuery("#docu_img").delay(300).fadeIn();});
jQuery(".docu_vid").click(function() {jQuery('#ast_docu').fadeOut();jQuery("#docu_vid").delay(300).fadeIn();});
jQuery(".docu_blog").click(function() {jQuery('#ast_docu').fadeOut();jQuery("#docu_blog").delay(300).fadeIn();});
jQuery(".docu_contct").click(function() {jQuery('#ast_docu').fadeOut();jQuery("#docu_contct").delay(300).fadeIn();});
jQuery(".docu_bg").click(function() {jQuery('#ast_docu').fadeOut();jQuery("#docu_bg").delay(300).fadeIn();});
jQuery(".docu_headr").click(function() {jQuery('#ast_docu').fadeOut();jQuery("#docu_headr").delay(300).fadeIn();});
jQuery(".docu_menu").click(function() {jQuery('#ast_docu').fadeOut();jQuery("#docu_menu").delay(300).fadeIn();});
jQuery(".docu_styling").click(function() {jQuery('#ast_docu').fadeOut();jQuery("#docu_styling").delay(300).fadeIn();});
jQuery(".docu_wdgts").click(function() {jQuery('#ast_docu').fadeOut();jQuery("#docu_wdgts").delay(300).fadeIn();});
jQuery(".docu_shorts").click(function() {jQuery('#ast_docu').fadeOut();jQuery("#docu_shorts").delay(300).fadeIn();});
jQuery(".docu_supp").click(function() {jQuery('#ast_docu').fadeOut();jQuery("#docu_supp").delay(300).fadeIn();});
jQuery(".docu_gallery").click(function() {jQuery('#ast_docu').fadeOut();jQuery("#docu_gallery").delay(300).fadeIn();});

jQuery(".docuback").click(function() {jQuery('#docu_gallery, #docu_front, #docu_img, #docu_vid, #docu_blog, #docu_contct, #docu_bg, #docu_headr, #docu_menu, #docu_styling, #docu_wdgts, #docu_shorts, #docu_supp').fadeOut();jQuery("#ast_docu").delay(300).fadeIn();});

//UPGRADE
	jQuery("#sub_ex, #sub_compare").hide();
	jQuery('.up_ul li').click(function(){
    	jQuery('.up_ul li').removeClass("active");
    	jQuery(this).addClass("active");
	});
	
		jQuery('.ast_why_pro').click(function(){ 
			jQuery(".sub_ex, .sub_compare").hide();
			jQuery(".sub_feat").fadeIn(300); 
		});
		jQuery('.ast_example').click(function(){ 
			jQuery(".sub_feat, .sub_compare").hide();
			jQuery(".sub_ex").fadeIn(300); 
		});
		jQuery('.ast_compare').click(function(){ 
			jQuery(".sub_ex, .sub_feat").hide();
			jQuery(".sub_compare").fadeIn(300); 
		});


	
//Manipulate Slider content Type
jQuery(".ast_trigger .sldcont1").click(function(){jQuery(this).addClass('ast_active');jQuery(this).closest('li').find('.sldcont2, .sldcont3').removeClass('ast_active');jQuery(this).closest('li').find(".ast_content").val("layout1");});
jQuery(".ast_trigger .sldcont2").click(function(){jQuery(this).addClass('ast_active');jQuery(this).closest('li').find('.sldcont1, .sldcont3').removeClass('ast_active');jQuery(this).closest('li').find(".ast_content").val("layout2");});
jQuery(".ast_trigger .sldcont3").click(function(){jQuery(this).addClass('ast_active');jQuery(this).closest('li').find('.sldcont1, .sldcont2').removeClass('ast_active');jQuery(this).closest('li').find(".ast_content").val("layout3");});

jQuery(".redux-slides-accordion-group").each( function(){ 
if(jQuery(this).find('a.sldcont1').text() ==  jQuery(this).find('.ast_content').val()){jQuery(this).find('a.sldcont1').addClass('ast_active');}
if(jQuery(this).find('a.sldcont2').text() ==  jQuery(this).find('.ast_content').val()){jQuery(this).find('a.sldcont2').addClass('ast_active');}
if(jQuery(this).find('a.sldcont3').text() ==  jQuery(this).find('.ast_content').val()){jQuery(this).find('a.sldcont3').addClass('ast_active');}
});



(function($){$.fn.alterClass=function(removals,additions){var self=this;if(removals.indexOf("*")===-1){self.removeClass(removals);return!additions?self:self.addClass(additions)}var patt=new RegExp("\\s"+removals.replace(/\*/g,"[A-Za-z0-9-_]+").split(" ").join("\\s|\\s")+"\\s","g");self.each(function(i,it){var cn=" "+it.className+" ";while(patt.test(cn))cn=cn.replace(patt," ");it.className=$.trim(cn)});return!additions?self:self.addClass(additions)}})(jQuery);

//jQuery Timepicker
!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):a(jQuery)}(function(a){function b(a){if(a.minTime&&(a.minTime=r(a.minTime)),a.maxTime&&(a.maxTime=r(a.maxTime)),a.durationTime&&"function"!=typeof a.durationTime&&(a.durationTime=r(a.durationTime)),a.disableTimeRanges.length>0){for(var b in a.disableTimeRanges)a.disableTimeRanges[b]=[r(a.disableTimeRanges[b][0]),r(a.disableTimeRanges[b][1])];a.disableTimeRanges=a.disableTimeRanges.sort(function(a,b){return a[0]-b[0]});for(var b=a.disableTimeRanges.length-1;b>0;b--)a.disableTimeRanges[b][0]<=a.disableTimeRanges[b-1][1]&&(a.disableTimeRanges[b-1]=[Math.min(a.disableTimeRanges[b][0],a.disableTimeRanges[b-1][0]),Math.max(a.disableTimeRanges[b][1],a.disableTimeRanges[b-1][1])],a.disableTimeRanges.splice(b,1))}return a}function c(b){var c=b.data("timepicker-settings"),d=b.data("timepicker-list");d&&d.length&&(d.remove(),b.data("timepicker-list",!1)),d=a("<ul />",{"class":"ui-timepicker-list"});var e=a("<div />",{"class":"ui-timepicker-wrapper",tabindex:-1});e.css({display:"none",position:"absolute"}).append(d),c.className&&e.addClass(c.className),null===c.minTime&&null===c.durationTime||!c.showDuration||e.addClass("ui-timepicker-with-duration");var g=c.minTime;"function"==typeof c.durationTime?g=r(c.durationTime()):null!==c.durationTime&&(g=c.durationTime);var i=null!==c.minTime?c.minTime:0,j=null!==c.maxTime?c.maxTime:i+u-1;i>=j&&(j+=u),j===u-1&&-1!==c.timeFormat.indexOf("H")&&(j=u);for(var k=c.disableTimeRanges,l=0,m=k.length,n=i;j>=n;n+=60*c.step){var s=n,t=a("<li />");if(t.data("time",s),t.text(q(s,c.timeFormat)),(null!==c.minTime||null!==c.durationTime)&&c.showDuration){var v=a("<span />");v.addClass("ui-timepicker-duration"),v.text(" ("+p(n-g)+")"),t.append(v)}m>l&&(s>=k[l][1]&&(l+=1),k[l]&&s>=k[l][0]&&s<k[l][1]&&t.addClass("ui-timepicker-disabled")),d.append(t)}e.data("timepicker-input",b),b.data("timepicker-list",e);var w=c.appendTo;"string"==typeof w?w=a(w):"function"==typeof w&&(w=w(b)),w.append(e),h(b,d),d.on("click","li",function(){b.off("focus.timepicker"),b.on("focus.timepicker-ie-hack",function(){b.off("focus.timepicker-ie-hack"),b.on("focus.timepicker",x.show)}),f(b)||b[0].focus(),d.find("li").removeClass("ui-timepicker-selected"),a(this).addClass("ui-timepicker-selected"),o(b)&&(b.trigger("hideTimepicker"),e.hide())})}function d(){return new Date(1970,1,1,0,0,0)}function e(b){var c=a(b.target),d=c.closest(".ui-timepicker-input");0===d.length&&0===c.closest(".ui-timepicker-wrapper").length&&(x.hide(),a("body").unbind(".ui-timepicker"),a(window).unbind(".ui-timepicker"))}function f(a){var b=a.data("timepicker-settings");return(window.navigator.msMaxTouchPoints||"ontouchstart"in document)&&b.disableTouchKeyboard}function g(b,c,d){if(!d&&0!==d)return!1;var e=b.data("timepicker-settings"),f=!1,g=30*e.step;return c.find("li").each(function(b,c){var e=a(c),h=e.data("time")-d;return Math.abs(h)<g||h==g?(f=e,!1):void 0}),f}function h(a,b){b.find("li").removeClass("ui-timepicker-selected");var c=r(j(a));if(null!==c){var d=g(a,b,c);if(d){var e=d.offset().top-b.offset().top;(e+d.outerHeight()>b.outerHeight()||0>e)&&b.scrollTop(b.scrollTop()+d.position().top-d.outerHeight()),d.addClass("ui-timepicker-selected")}}}function i(){if(""!==this.value){var b=a(this),c=b.data("timepicker-list");if(!c||!c.is(":visible")){var d=r(this.value);if(null===d)return b.trigger("timeFormatError"),void 0;var e=b.data("timepicker-settings"),f=!1;if(null!==e.minTime&&d<e.minTime?f=!0:null!==e.maxTime&&d>e.maxTime&&(f=!0),a.each(e.disableTimeRanges,function(){return d>=this[0]&&d<this[1]?(f=!0,!1):void 0}),e.forceRoundTime){var g=d%(60*e.step);g>=30*e.step?d+=60*e.step-g:d-=g}var h=q(d,e.timeFormat);f?k(b,h,"error")&&b.trigger("timeRangeError"):k(b,h)}}}function j(a){return a.is("input")?a.val():a.data("ui-timepicker-value")}function k(a,b,c){return a.is("input")&&a.val(b),a.data("ui-timepicker-value")!=b?(a.data("ui-timepicker-value",b),"select"==c?a.trigger("selectTime").trigger("changeTime").trigger("change"):"error"!=c&&a.trigger("changeTime"),!0):(a.trigger("selectTime"),!1)}function l(b){var c=a(this),d=c.data("timepicker-list");if(!d||!d.is(":visible")){if(40!=b.keyCode)return m(b,c);f(c)||c.focus()}switch(b.keyCode){case 13:return o(c)&&x.hide.apply(this),b.preventDefault(),!1;case 38:var e=d.find(".ui-timepicker-selected");return e.length?e.is(":first-child")||(e.removeClass("ui-timepicker-selected"),e.prev().addClass("ui-timepicker-selected"),e.prev().position().top<e.outerHeight()&&d.scrollTop(d.scrollTop()-e.outerHeight())):(d.find("li").each(function(b,c){return a(c).position().top>0?(e=a(c),!1):void 0}),e.addClass("ui-timepicker-selected")),!1;case 40:return e=d.find(".ui-timepicker-selected"),0===e.length?(d.find("li").each(function(b,c){return a(c).position().top>0?(e=a(c),!1):void 0}),e.addClass("ui-timepicker-selected")):e.is(":last-child")||(e.removeClass("ui-timepicker-selected"),e.next().addClass("ui-timepicker-selected"),e.next().position().top+2*e.outerHeight()>d.outerHeight()&&d.scrollTop(d.scrollTop()+e.outerHeight())),!1;case 27:d.find("li").removeClass("ui-timepicker-selected"),x.hide();break;case 9:x.hide();break;default:return m(b,c)}}function m(a,b){return!b.data("timepicker-settings").disableTextInput||a.ctrlKey||a.altKey||a.metaKey||2!=a.keyCode&&8!=a.keyCode&&a.keyCode<46}function n(b){var c=a(this),d=c.data("timepicker-list");if(!d||!d.is(":visible"))return!0;switch(b.keyCode){case 96:case 97:case 98:case 99:case 100:case 101:case 102:case 103:case 104:case 105:case 48:case 49:case 50:case 51:case 52:case 53:case 54:case 55:case 56:case 57:case 65:case 77:case 80:case 186:case 8:case 46:h(c,d);break;default:return}}function o(a){var b=a.data("timepicker-settings"),c=a.data("timepicker-list"),d=null,e=c.find(".ui-timepicker-selected");if(e.hasClass("ui-timepicker-disabled"))return!1;if(e.length?d=e.data("time"):j(a)&&(d=r(j(a)),h(a,c)),null!==d){var f=q(d,b.timeFormat);k(a,f,"select")}return!0}function p(a){var b,c=Math.round(a/60);if(Math.abs(c)<60)b=[c,w.mins];else if(60==c)b=["1",w.hr];else{var d=(c/60).toFixed(1);"."!=w.decimal&&(d=d.replace(".",w.decimal)),b=[d,w.hrs]}return b.join(" ")}function q(a,b){if(null!==a){for(var c,d,e=new Date(t.valueOf()+1e3*a),f="",g=0;g<b.length;g++)switch(d=b.charAt(g)){case"a":f+=e.getHours()>11?"pm":"am";break;case"A":f+=e.getHours()>11?"PM":"AM";break;case"g":c=e.getHours()%12,f+=0===c?"12":c;break;case"G":f+=e.getHours();break;case"h":c=e.getHours()%12,0!==c&&10>c&&(c="0"+c),f+=0===c?"12":c;break;case"H":c=e.getHours(),a===u&&(c=24),f+=c>9?c:"0"+c;break;case"i":var h=e.getMinutes();f+=h>9?h:"0"+h;break;case"s":a=e.getSeconds(),f+=a>9?a:"0"+a;break;default:f+=d}return f}}function r(a){if(""===a)return null;if(!a||a+0==a)return a;"object"==typeof a&&(a=a.getHours()+":"+s(a.getMinutes())+":"+s(a.getSeconds())),a=a.toLowerCase(),new Date(0);var b;if(-1===a.indexOf(":")?(b=a.match(/^([0-9]):?([0-5][0-9])?:?([0-5][0-9])?\s*([pa]?)m?$/),b||(b=a.match(/^([0-2][0-9]):?([0-5][0-9])?:?([0-5][0-9])?\s*([pa]?)m?$/))):b=a.match(/^(\d{1,2})(?::([0-5][0-9]))?(?::([0-5][0-9]))?\s*([pa]?)m?$/),!b)return null;var c,d=parseInt(1*b[1],10);c=b[4]?12==d?"p"==b[4]?12:0:d+("p"==b[4]?12:0):d;var e=1*b[2]||0,f=1*b[3]||0;return 3600*c+60*e+f}function s(a){return("0"+a).slice(-2)}var t=d(),u=86400,v={className:null,minTime:null,maxTime:null,durationTime:null,step:30,showDuration:!1,timeFormat:"g:ia",scrollDefaultNow:!1,scrollDefaultTime:!1,selectOnBlur:!1,disableTouchKeyboard:!0,forceRoundTime:!1,appendTo:"body",disableTimeRanges:[],closeOnWindowScroll:!1,disableTextInput:!1},w={decimal:".",mins:"mins",hr:"hr",hrs:"hrs"},x={init:function(c){return this.each(function(){var d=a(this);if("SELECT"==d[0].tagName){for(var e={type:"text",value:d.val()},f=d[0].attributes,g=0;g<f.length;g++)e[f[g].nodeName]=f[g].nodeValue;var h=a("<input />",e);d.replaceWith(h),d=h}var j=a.extend({},v);c&&(j=a.extend(j,c)),j.lang&&(w=a.extend(w,j.lang)),j=b(j),d.data("timepicker-settings",j),d.prop("autocomplete","off"),d.on("click.timepicker focus.timepicker",x.show),d.on("change.timepicker",i),d.on("keydown.timepicker",l),d.on("keyup.timepicker",n),d.addClass("ui-timepicker-input"),i.call(d.get(0))})},show:function(){var b=a(this),d=b.data("timepicker-settings");f(b)&&b.blur();var h=b.data("timepicker-list");if(!b.prop("readonly")&&(h&&0!==h.length&&"function"!=typeof d.durationTime||(c(b),h=b.data("timepicker-list")),!h.is(":visible"))){x.hide(),h.show(),b.offset().top+b.outerHeight(!0)+h.outerHeight()>a(window).height()+a(window).scrollTop()?h.offset({left:b.offset().left+parseInt(h.css("marginLeft").replace("px",""),10),top:b.offset().top-h.outerHeight()+parseInt(h.css("marginTop").replace("px",""),10)}):h.offset({left:b.offset().left+parseInt(h.css("marginLeft").replace("px",""),10),top:b.offset().top+b.outerHeight()+parseInt(h.css("marginTop").replace("px",""),10)});var i=h.find(".ui-timepicker-selected");if(i.length||(j(b)?i=g(b,h,r(j(b))):d.scrollDefaultNow?i=g(b,h,r(new Date)):d.scrollDefaultTime!==!1&&(i=g(b,h,r(d.scrollDefaultTime)))),i&&i.length){var k=h.scrollTop()+i.position().top-i.outerHeight();h.scrollTop(k)}else h.scrollTop(0);a("body").on("touchstart.ui-timepicker mousedown.ui-timepicker",e),d.closeOnWindowScroll&&a(window).on("scroll.ui-timepicker",e),b.trigger("showTimepicker")}},hide:function(){a(".ui-timepicker-wrapper:visible").each(function(){var b=a(this),c=b.data("timepicker-input"),d=c.data("timepicker-settings");d&&d.selectOnBlur&&o(c),b.hide(),c.trigger("hideTimepicker")})},option:function(c,d){var e=this,f=e.data("timepicker-settings"),g=e.data("timepicker-list");if("object"==typeof c)f=a.extend(f,c);else if("string"==typeof c&&"undefined"!=typeof d)f[c]=d;else if("string"==typeof c)return f[c];return f=b(f),e.data("timepicker-settings",f),g&&(g.remove(),e.data("timepicker-list",!1)),e},getSecondsFromMidnight:function(){return r(j(this))},getTime:function(a){var b=this;return a||(a=new Date),a.setHours(0,0,0,0),new Date(a.valueOf()+1e3*r(j(b)))},setTime:function(a){var b=this,c=q(r(a),b.data("timepicker-settings").timeFormat);k(b,c),b.data("timepicker-list")&&h(b,b.data("timepicker-list"))},remove:function(){var a=this;a.hasClass("ui-timepicker-input")&&(a.removeAttr("autocomplete","off"),a.removeClass("ui-timepicker-input"),a.removeData("timepicker-settings"),a.off(".timepicker"),a.data("timepicker-list")&&a.data("timepicker-list").remove(),a.removeData("timepicker-list"))}};a.fn.timepicker=function(b){return x[b]?x[b].apply(this,Array.prototype.slice.call(arguments,1)):"object"!=typeof b&&b?(a.error("Method "+b+" does not exist on jQuery.timepicker"),void 0):x.init.apply(this,arguments)}});



//jQuery Timepicker
jQuery('#offline_time_id-text').timepicker({ 'timeFormat': 'H:i' });
jQuery('#offline_date_id-date').attr("placeholder", "Date");
jQuery('#offline_time_id-text').attr("placeholder", "Time");
});
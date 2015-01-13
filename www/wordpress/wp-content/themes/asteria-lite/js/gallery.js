// Gallery plugin written by Towfiq I.
jQuery(window).ready(function() {
//======================Gallery=================================//
	
//remove any <br> inside the gallery markup
jQuery(".gallery br").remove();
//wrap all .gallery-item with .gall_dash /  For making the thumbnail navigation area
jQuery(".gallery").each(function (){jQuery(this).find(".gallery-item").wrapAll('<div class="gall_dash" />');});
jQuery('.gall_dash .hasimg').removeClass('hasimg');

//Prepend the big image area. and load the src image of the first thumbnail. The.ast_full is for fancybox integration.
jQuery(".thn_post_wrap .gallery").prepend("<div class='ast_gall'><img class='gall_loader' src='"+galleryloadergif+"' /></div>");


//add .gall_active to first gallery-item for styling purpose
jQuery('.gallery-item:eq(0) img').addClass('gall_active');



//here goes our main click function to load the large images from the thumbnail images
jQuery(".gallery-item a").click(function(event) {
	event.preventDefault();
	
	jQuery(".gall_active").removeClass("gall_active");
	jQuery(this).find("img").addClass("gall_active");

	//change the main image
	var clickedgall = jQuery(this).attr('class');
	jQuery('.gib').fadeOut('fast');
	jQuery(".gib").not(".gall_img_block"+clickedgall+"").removeClass('active_full');
	jQuery(".gall_img_block"+clickedgall+"").addClass('active_full').delay(200).fadeIn('fast');
	var gallnewheight = jQuery(".gall_img_block"+clickedgall+"").height();
	jQuery(".ast_gall").height(gallnewheight);
	
	//change the link of .ast_full to current large image link
	jQuery(".fancygall"+clickedgall+"").delay(200).fadeIn('fast');
});



//==============REMAP AND APPEND THE MAIN IMAGES================
var tn_array = jQuery(".gall_dash .gallery-item a").map(function() {
  return jQuery(this).attr("href");
});

var pageLimit= jQuery(".gall_dash img").size() - 1;
for (var i = 0; i <= pageLimit; i++) {
	var article = jQuery(".gallery-item a");
		jQuery(article[i]).addClass("" + i + "");
		jQuery(article[i]).attr('id' , "vis" + i + "");
        jQuery('.ast_gall').append("<div class='gib gall_img_block" + i + "' data-thummbid='vis" + parseInt(1+i) + "' style='z-index:" + parseInt(10-i) + "'><a class='ast_full fancygall" + i + "' href='"+tn_array[i]+"' rel='gall1' title='See larger version of this image'></a><img id='mainImage" + i + "' src='"+tn_array[i]+"' class='gallery_full'/><a data-prev='" + parseInt(i-1) + "' class='ast_gall_prev'><i class='fa fa-chevron-left'></i></a><a data-next='" + parseInt(i+1) + "' class='ast_gall_next'><i class='fa fa-chevron-right'></i></a><p class='capcap'></p></div>");
    }

//APPEND CAPTION	
for (var i = 0; i <= pageLimit; i++) {	
	jQuery('#vis'+ i +'').parent().parent().find('.wp-caption-text').appendTo('.gall_img_block' + i + ' .capcap');
    }
	
	
jQuery("#mainImage0").addClass("active_full");
jQuery( "p.capcap:empty" ).css( "display", "none" );


//Hide the First Next/Previous Link
jQuery(".gib:eq(0) .ast_gall_prev, div.gib:last-child a.ast_gall_next").css({"display":"none"});
jQuery(".gib:eq(0) .ast_gall_next").css({"display":"block"});


//==============NEXT & PREVIOUS BUTTONS=================
//---NEXT BUTTON---
jQuery(".ast_gall_next").click(function(event) {
	jQuery(".gall_active").removeClass("gall_active");
	jQuery(this).find("img").addClass("gall_active");
	
	//SHOW THE NEXT DIV
	jQuery(this).parent().fadeOut('fast');
	jQuery(this).parent().next('.gib').fadeIn('fast');
	
	var gallnewheight = jQuery(this).parent().next('.gib').height();
	jQuery(".ast_gall").height(gallnewheight);
	
	//Highlight the Thumb on clicking next button
	var thumbnext = jQuery(this).parent().attr('data-thummbid');
	jQuery('.gall_dash img').removeClass("gall_active");
	jQuery('#'+thumbnext+' img').addClass("gall_active");
	
});
//---PREVIOUS BUTTON---
jQuery(".ast_gall_prev").click(function(event) {
	jQuery(".gall_active").removeClass("gall_active");
	jQuery(this).find("img").addClass("gall_active");
	
	//SHOW THE NEXT DIV
	jQuery(this).parent().fadeOut('fast');
	jQuery(this).parent().prev('.gib').fadeIn('fast');
	
	var gallnewheight = jQuery(this).parent().prev('.gib').height();
	jQuery(".ast_gall").height(gallnewheight);
	
	//Highlight the Thumb on clicking prev button
	var thumbprev = jQuery(this).parent().prev().prev().attr('data-thummbid');
	jQuery('.gall_dash img').removeClass("gall_active");
	jQuery('#'+thumbprev+' img').addClass("gall_active");
});



//Add Lazyload
jQuery('.ast_gall').fadeOut();

jQuery('.ast_gall').waitForImages(function() {
	jQuery('.gall_loader').fadeOut(300);
	jQuery(".gib").each(function (){
		var gibheight = jQuery(this).find(".gallery_full").height();
		jQuery(this).height(gibheight);
	});
	jQuery('.ast_gall').height(jQuery('.gall_img_block0').height());
	
	jQuery('.ast_gall').fadeIn();
});



});
<?php global $asteria;?>
<?php if(($asteria['slider_type_id'] == "nivo") || !get_option( 'asteria' ) ){ ?>
<script type="text/javascript">
    jQuery(window).ready(function() {

		// nivoslider init
		jQuery('#zn_nivo').nivoSlider({
				effect: 'random',
				animSpeed:700,
				pauseTime:<?php if(get_option( 'asteria' ) ){ ?><?php echo $asteria['n_slide_time_id']; ?><?php }else{ ?>4000<?php } ?>,
				startSlide:0,
				slices:10,
				directionNav:true,
				directionNavHide:true,
				controlNav:true,
				controlNavThumbs:false,
				keyboardNav:true,
				manualAdvance: false,
				pauseOnHover:true,
				captionOpacity:0.8,
				afterLoad: function(){
						if (jQuery(window).width() < 480) {
					jQuery(".nivo-caption").animate({"opacity": "1", "right":"0"}, {easing:"easeOutBack", duration: 500});
						}else{
					jQuery(".nivo-caption").animate({"opacity": "1", "right":"11%"}, {easing:"easeOutBack", duration: 500});	
					jQuery(".nivo-caption").has('.sld_layout3').addClass('sld3wrap');
							}
				},
				beforeChange: function(){
					jQuery(".nivo-caption").animate({right:"-500px"}, {easing:"easeInBack", duration: 500});
					//jQuery(".nivo-caption").delay(400).removeClass('sld3wrap');
					jQuery('.nivo-caption').animate({"opacity": "0"}, 100);
					jQuery('.nivo-caption').delay(500).queue(function(next){
						jQuery(this).removeClass("sld3wrap");next();});

				},
				afterChange: function(){
						if (jQuery(window).width() < 480) {
					jQuery(".nivo-caption").animate({"opacity": "1", "right":"0"}, {easing:"easeOutBack", duration: 500});
						}else{
					jQuery(".nivo-caption").animate({"opacity": "1", "right":"11%"}, {easing:"easeOutBack", duration: 500});	
					jQuery(".nivo-caption").has('.sld_layout3').addClass('sld3wrap');	
							}
				}
			});

	});
</script>
<?php } ?>

<?php /*?><!------------------------------------------------------------Other Javascripts--------------------------------------------------------><?php */?>
<script type="text/javascript">
//Sidebar List style type
<?php if(($asteria['site_width_id'] == "1") || (!get_option( 'asteria' )) ) {?>
jQuery('#sidebar .widgets .widget li').prepend('<i class="fa-angle-double-right"></i> ');
<?php } ?>

//Header4 Fix
jQuery(window).bind("load", function() {
var headheight = (jQuery(".logo").outerHeight());
var logowidth = (jQuery(".logo").outerWidth());
var menuwidth = (jQuery("#topmenu").outerWidth());
if (logowidth + menuwidth <1100 ){
//var headheight = (jQuery(".header4").outerHeight());

jQuery(".header4 #topmenu").css({"minHeight":headheight});
jQuery(".header4 #topmenu ul li ul, .header4 .head_soc").css({"top": headheight + 'px'});
jQuery(".header4 #topmenu ul li").css({"paddingTop": "0px", "paddingBottom": "0px","height":headheight - 3 + 'px', "line-height" :headheight - 3 + 'px'});
jQuery(".header4 #topmenu ul li ul li ul").css({"marginTop": '-' + headheight + 'px'});
}else{
	jQuery(".header4 #topmenu").addClass('bigmenu');
	}
});


//Hide Slider until its loaded
jQuery('#zn_nivo, .nivo-controlNav').css({"display":"none"});	
var galleryloadergif = "<?php echo get_template_directory_uri(); ?>/images/newloader.gif";
<?php if(get_option( 'asteria' )){?>
//The Colors-------------------------------------------
	var primarytext = "<?php echo $asteria['primtxt_color_id']; ?>";
	var sechovertext = "<?php echo $asteria['sectxt_color_id']; ?>";	
	var menutext = "#FFFFFF";
	var footwidget ="#999999";
	var footwidgethover ="#ffffff";	
			
	var primarycolor = "<?php echo $asteria['sec_color_id']; ?>";
	var primardefault = "#ffffff";
	var sechover = "<?php echo $asteria['sec_color_id']; ?>";
	var socialbuttons ="#cccccc";
<?php }else{ ?>
	var primarytext = "#888888";
	var sechovertext = "#FFFFFF";	
	var menutext = "#FFFFFF";
	var footwidget ="#999999";
	var footwidgethover ="#ffffff";			
	var primarycolor = "#2dcb73";
	var primardefault = "#ffffff";
	var sechover = "#2dcb73";
	var socialbuttons ="#cccccc";

<?php } ?>

	//Midrow Blocks Equal Width
	if(jQuery('.midrow_block').length == 4){ jQuery('.midrow_blocks').addClass('fourblocks'); }
	if(jQuery('.midrow_block').length == 3){ jQuery('.midrow_blocks').addClass('threeblocks'); }
	if(jQuery('.midrow_block').length == 2){ jQuery('.midrow_blocks').addClass('twoblocks'); }
	if(jQuery('.midrow_block').length == 1){ jQuery('.midrow_blocks').addClass('oneblock'); }


<?php if((!empty($asteria['offline_id']))){ ?>
jQuery(window).ready(function() {jQuery("#countdown_mntnc").countdown({
	date: "<?php echo $asteria['offline_date_id']; ?> <?php echo $asteria['offline_time_id'];?>:00",
	format: "on"});
});
<?php } ?>

<?php if (!empty ($asteria['ajax_id'])) { ?>
//AJAX PAGINATION
jQuery(document).ready(function(){

jQuery('.ast_pagenav span').replaceWith(function() {
		var pathname = window.location.pathname;
    var url = (jQuery(this).text());
	 <?php global $wp; $current_url = add_query_arg( $wp->query_string, '', home_url('/', $wp->request ) ); ?>
	 if (jQuery("span.page-numbers").prev().length === 0) {
    return '<a class="page-numbers current" href="<?php echo $current_url ?><?php if(is_category() || is_search() || is_author()) { ?>&paged=1<?php }else{ ?>?paged=1<?php } ?>" target="_blank">' + url + '</a>';
	 }else{
		    return '<a class="page-numbers current" href="<?php echo $current_url ?>" target="_blank">' + url + '</a>'; 
	 }
});

jQuery('.ast_pagenav span.page-numbers').each(function () {
	var pathname = window.location.pathname;
	
    var href = jQuery(this).attr('href');
	<?php if(is_category() || is_search() || is_author()) {  ?>
	jQuery(this).attr('href', href + '&paged=1');
	<?php }else{ ?>
    jQuery(this).attr('href', href + '?paged=1');
	<?php } ?>	
});

jQuery('.ast_pagenav a').each(function(){
        
	<?php if(is_category() || is_search() || is_author()) {  ?>
	this.href = this.href.replace('/page/', '&paged=');
	<?php }else{ ?>
    this.href = this.href.replace('/page/', '?paged=');
	<?php } ?>
});
    jQuery('.ast_pagenav a').on('click', function(e)  {
	jQuery('.ast_pagenav a, span.page-numbers').removeClass('current'); // remove if already existant
    jQuery(this).addClass('current');


	e.preventDefault();

	
	<?php wp_reset_query();
	$template = get_post_meta( get_the_ID(), '_wp_page_template', true );
	
	if( is_author() || ($template == 'page-blog.php' ) ){  ?>
	//Layout 4 Ajax
	var link = jQuery(this).attr('href');
	jQuery('.lay4_inner').html('<div class="ast_ajaxwrap"><div class="ast_ajax"></div></div>').load(link + '.lay4_inner .hentry', function(){
    jQuery('.lay4_inner').fadeIn(500); 
	jQuery(".hentry").hide().each(function() {
  	jQuery(this).fadeIn(500, "easeInSine");
	});
	//Layout 4 Ajax END
	<?php }else{ ?>
	
	
<?php if(($asteria['cat_layout_id'] == "1") && (!is_home())){ ?>
	//Layout 1 Ajax
			var link = jQuery(this).attr('href');
	jQuery('.lay1_wrap').html('<div class="ast_ajaxwrap"><div class="ast_ajax"></div></div>').load(link + '.lay1_wrap .hentry', function(){
		
	if (jQuery(window).width() < 360) {
		var divs = jQuery(".lay1 .hentry");
		for(var i = 0; i < divs.length; i+=1) {
		  divs.slice(i, i+1).wrapAll("<div class='ast_row'></div>");
		}		
			}else if (jQuery(window).width() < 480) {
		var divs = jQuery(".lay1 .hentry");
		for(var i = 0; i < divs.length; i+=2) {
		  divs.slice(i, i+2).wrapAll("<div class='ast_row'></div>");
		}
			}else{
		var divs = jQuery(".lay1 .hentry");
		for(var i = 0; i < divs.length; i+=3) {
		  divs.slice(i, i+3).wrapAll("<div class='ast_row'></div>");
		}
	}
			  
	if (jQuery(window).width() > 360) {			  
		jQuery('.lay1_wrap').fadeIn(500); 
		jQuery(".hentry").hide().each(function() {
		jQuery(this).fadeIn(500, "easeInSine");
		});
	}
	//Layout 1 Ajax END
<?php }elseif(($asteria['front_layout_id'] == "1") && (is_home())){ ?>
	//Layout 1 Ajax
			var link = jQuery(this).attr('href');
	jQuery('.lay1_wrap').html('<div class="ast_ajaxwrap"><div class="ast_ajax"></div></div>').load(link + '.lay1_wrap .hentry', function(){
		
	if (jQuery(window).width() < 360) {
		var divs = jQuery(".lay1 .hentry");
		for(var i = 0; i < divs.length; i+=1) {
		  divs.slice(i, i+1).wrapAll("<div class='ast_row'></div>");
		}		
			}else if (jQuery(window).width() < 480) {
		var divs = jQuery(".lay1 .hentry");
		for(var i = 0; i < divs.length; i+=2) {
		  divs.slice(i, i+2).wrapAll("<div class='ast_row'></div>");
		}
			}else{
		var divs = jQuery(".lay1 .hentry");
		for(var i = 0; i < divs.length; i+=3) {
		  divs.slice(i, i+3).wrapAll("<div class='ast_row'></div>");
		}
	}
			  
	if (jQuery(window).width() > 360) {			  
		jQuery('.lay1_wrap').fadeIn(500); 
		jQuery(".hentry").hide().each(function() {
		jQuery(this).fadeIn(500, "easeInSine");
		});
			var divheight = jQuery('.lay1 .ast_row .hentry:eq(0)').outerHeight();
		//jQuery(".ast_row").height(divheight);
		jQuery(window).resize(function() {
		var divheight = jQuery('.lay1 .ast_row .hentry:eq(0)').outerHeight();
		jQuery(".ast_row").height(divheight);
		});
	}
	//Layout 1 Ajax END
<?php } ?>

	
<?php if(($asteria['cat_layout_id'] == "4") && (!is_home())){ ?>
	//Layout 4 Ajax
	var link = jQuery(this).attr('href');
	jQuery('.lay4_inner').html('<div class="ast_ajaxwrap"><div class="ast_ajax"></div></div>').load(link + '.lay4_inner .hentry', function(){
    jQuery('.lay4_inner').fadeIn(500); 
	jQuery(".hentry").hide().each(function() {
  	jQuery(this).fadeIn(500, "easeInSine");
	});
	//Layout 4 Ajax END
<?php }elseif(($asteria['front_layout_id'] == "4") && (is_home())){ ?>
	//Layout 4 Ajax
	var link = jQuery(this).attr('href');
	jQuery('.lay4_inner').html('<div class="ast_ajaxwrap"><div class="ast_ajax"></div></div>').load(link + '.lay4_inner .hentry', function(){
    jQuery('.lay4_inner').fadeIn(500); 
	jQuery(".hentry").hide().each(function() {
  	jQuery(this).fadeIn(500, "easeInSine");
	});
	//Layout 4 Ajax END
<?php } ?>

<?php } ?>	
	
	});

    });

});  // end ready function
<?php } ?>
</script> 
<?php global $asteria;?>
<style type="text/css">
<?php if ( !get_option( 'asteria' )) {?>
/*load font when theme options dont exist*/
body .header4 .logo h1, body .header4 .logo h2{font-family:'Cinzel Decorative'!important; font-weight:normal;}
.nivo-caption h3{font-family:'Cinzel Decorative'!important; font-weight:normal; font-size:60px!important;}
<?php } ?>
/*USER'S CUSTOM CSS---------------------------------------------------------*/
<?php if ( ! empty ( $asteria['custom-css'] ) ) { ?><?php echo $asteria['custom-css']; ?><?php } ?>
/*---------------------------------------------------------*/

<?php if(($asteria['site_width_id'] == "1") || (!get_option( 'asteria' )) ) {?>
body .fixed_site .header .center{width:100%!important;}
.single #content{ margin-top:10px;}
.header , .header2, .header3, .header4{ margin-top:30px;}
.widget_corner{ display:none;}
.page #content{ margin-top:20px;}
.edit_wrap{border-color: transparent;}
.comments_template{ margin-bottom:40px;}

#sidebar { border-left:1px solid rgba(0, 0, 0, 0.05);}
#sidebar .widget{ padding-bottom:0px!important}
.page-template-page-leftsidebar-php #sidebar{border-right:1px solid rgba(0, 0, 0, 0.05);border-left:none;}
.page-template-page-leftsidebar-php #sidebar .widget_wrap{ padding-left:0!important;;}
#sidebar .widget .widgettitle, #home_widgets .widget .widgettitle{text-align: right;padding-bottom: 30px;border-bottom: 1px solid; border-color:rgba(0, 0, 0, 0.05);}
#sidebar .widget{ background:none!important; padding-bottom:0;}
#sidebar .widget_wrap{width:88%!important; padding:0!important; padding-left:12%!important;}
#sidebar #searchform div{border:1px solid rgba(0, 0, 0, 0.05)}

.fixed_site{width: 80%;margin: 0 auto;}
body .fixed_site .center, body .fixed_site .midrow_wrap, body .fixed_site .header3 .top_head .center{ width:95%!important;}
.fixed_wrap{width: 100%;float: left;background: #fff;}
.fixed_site #footer{ margin-top:0;}
.footefixed{ margin-bottom:40px;}

.single_post{ background:none;}
.lay3 .hentry{ margin-bottom:15px;}
.lay4 .hentry, .lay5 .single_post{border-bottom:1px solid rgba(0, 0, 0, 0.07); background:none;}
.lay4 .hentry:last-child, .lay5 .single_post:last-child{border:none;}
.author_posts{ background:none;border-bottom: 1px solid rgba(0, 0, 0, 0.07);border-top: 1px solid rgba(0, 0, 0, 0.07);}
.lay5 .single_post{ margin-bottom:0;}
.more-link, .moretag{background: rgba(0, 0, 0, 0.07);}
.lay2 .hentry, .lay3 .hentry{background: rgba(0, 0, 0, 0.03);}
.author #content{ margin-top:0!important;}

#ast_nextprev{ margin-top:0;border-bottom: 1px solid rgba(0, 0, 0, 0.07);}
.share_this, #ast_related{border-bottom: 1px solid rgba(0, 0, 0, 0.07);border-top: 1px solid rgba(0, 0, 0, 0.07); background:none;}
.comments_template #comments, #comments_ping, #reply-title{border-bottom: 1px solid rgba(0, 0, 0, 0.07); padding-bottom:20px; border-top:none;}

.comment-body{border-bottom: 1px solid rgba(0, 0, 0, 0.07);}
.comment-form-comment textarea, .comm_wrap input{background: rgba(0, 0, 0, 0.03);border: 1px solid rgba(0, 0, 0, 0.07);-webkit-box-shadow: 0 0 5px rgba(0, 0, 0, 0.03) inset;-moz-box-shadow: 0 0 5px rgba(0, 0, 0, 0.03) inset;box-shadow: 0 0 5px rgba(0, 0, 0, 0.03) inset;}

.ast_pagenav .current{color: #fff;background: <?php echo $asteria['sec_color_id']; ?>;}
.ast_pagenav .pagi_border dt{ background:rgba(0, 0, 0, 0.1);}
.home_tabs{ background:none;}

#sidebar .widget .widgettitle{ margin-right:10%;}
#accordion img{ max-width:940px!important;}
body .fixed_site .header3 .center{width:100%!important;}

.comment-form-comment textarea, .comm_wrap input{border-top: 1px solid rgba(0, 0, 0, 0.1)!important;border-left: 1px solid rgba(0, 0, 0, 0.1)!important;border-right: 1px solid rgba(0, 0, 0, 0.1)!important;}
#sidebar .widget{ margin-top:20px;}

.edit_wrap{ border-color:transparent;}
.share_this{ background-color:transparent!important;}
.author_posts{ background:none!important;}
.ast_map{ margin-bottom:0!important;}
<?php } ?>

/*--------------SLIDER HEIGHT---------------*/
#zn_nivo, .slider-wrapper, .slide_wrap, .banner ul li, #accordion, .kwicks li, #accordion{height:<?php echo $asteria['slide_height']; ?>!important;}
#accordion, .kwicks.horizontal li{min-height:<?php echo $asteria['slide_height']; ?>!important;}

/*------------------------------------SITE TITLE------------------------------------------*/
<?php $logofont = $asteria['logo_font_id']; ?>
.logo h1, .logo h2{font-size:<?php echo $logofont['font-size']; ?>!important;}
.logo h1 a, .logo h2 a, .ast_maintanace .logo h1 a{font-family:'<?php echo $logofont['font-family']; ?>'!important;color:<?php echo $logofont['color']; ?>; font-weight:<?php echo $logofont['font-weight']; ?>!important;}

.nivo-caption h3, #accordion h3, .banner .sld_layout2 h3, .banner .sld_layout3 h3{font-family:'<?php echo $logofont['font-family']; ?>'!important;}
.sld_layout2 h3, .sld_layout3 h3, .acc-sld_layout2 h3, .acc-sld_layout3 h3, .wrap-sld_layout2 h3, .wrap-sld_layout3 h3{font-size:<?php echo $asteria['slidefont_size_id']; ?>!important; line-height:1.3em;}



/*------------------------------------ROUNDED CORNERS------------------------------------------*/
<?php if (!empty ($asteria['rounded_id'])) { ?>
.midrow_block, .lay1 .hentry img, .lay1 .imgwrap, .lay1 .img_hover, .lay1 .post_image, .lay1 .hentry, .home_action, .home_action_button, .page .single_post, .single_post, #sidebar .widget, #sidebar #searchform div, #sidebar #searchsubmit, #footer #searchsubmit, #submit, .comment-form-comment textarea, #ast_nextprev, #ast_nextprev .ast-next img, .related_img img, #ast_related, .avatar img, .related_img, .comment-body, .comm_wrap input, .ast_bioimg, .tabs-container, .lgn_toggle, .trigger_wrap, .lgn_scs, .lgn_info, .lgn_wng, .lgn_err, .ast_table, .single_post .scl_button a, .ast_shrt_action, .act_right a, .ast_slide_wrap .ast_slider, .ast_slider .nivo-caption, .lay4 .hentry, .lay4 .post_image, .lay4 .hentry img, .entry-content .cont_inpt, .entry-content textarea, .contact_submit input, .entry-content .contact_verify input, .lay2 .hentry, .lay2 .imgwrap, .lay3 .imgwrap, .lay3 .hentry, .lay3 .hentry img, .lay5 .single_post, .nivo-caption .sld_layout1 h3 a, .nivo-caption .sld_layout1 p, .banner .sld_layout1 p, .banner .sld_layout1 h3 a, .acc-sld_layout1 h3 a, .acc-sld_layout1 p, .share_this, .under-construction-inner, .ast_countdown li, #home_widgets .widget, .search_term{-webkit-border-radius:5px; -moz-border-radius:5px; border-radius:5px;}


#sidebar .widget, #ast_related{ overflow:hidden;}

.ast-prev, .left_arro, .search_term #searchform #s, .error_msg #searchform #s{-webkit-border-radius: 5px 0 0 5px;-moz-border-radius: 5px 0 0 5px;border-radius: 5px 0 0 5px;}
.ast-next, .right_arro, .search_term #searchsubmit, .error_msg #searchsubmit{-webkit-border-radius: 0 5px 5px 0;-moz-border-radius: 0 5px 5px 0;border-radius: 0 5px 5px 0;}

.lgn_toggle_content, .footefixed, .author_posts{-webkit-border-radius: 0 0 5px 5px;-moz-border-radius: 0 0 5px 5px;border-radius: 0 0 5px 5px;}

.tabs-container .tabs, .author_div{-webkit-border-radius: 5px 5px 0 0;-moz-border-radius: 5px 5px 0 0;border-radius: 5px 5px 0 0;}
.more-link, .moretag{-webkit-border-radius: 5px 0 0 0;-moz-border-radius: 5px 0 0 0;border-radius: 5px 0 0 0;}

<?php if(($asteria['site_width_id'] == "1")) {?>
.header5 #topmenu, .fixindex{-webkit-border-radius: 5px 5px 0 0;-moz-border-radius: 5px 5px 0 0;border-radius: 5px 5px 0 0;}
#slidera{width:100.05%;}
<?php } ?>
<?php if(($asteria['site_width_id'] == "2")) {?>
body .single_post{-webkit-border-radius:5px; -moz-border-radius:5px; border-radius:5px;}
<?php } ?>
<?php if (!empty ($asteria['social_single_id'])  && ($asteria['site_width_id'] == "1")) { ?>
body .single_post{-webkit-border-radius:5px 5px 0 0 ; -moz-border-radius:5px 5px 0 0 ; border-radius:5px 5px 0 0 ;}
<?php } ?>
<?php if(($asteria['head_type_id'] == "head1")) {?>
.head_soc a:last-child{-webkit-border-radius: 0 5px 0 0;-moz-border-radius: 0 5px 0 0;border-radius: 0 5px 0 0;}
.head_soc {-webkit-border-radius: 0 5px 0 5px;-moz-border-radius: 0 5px 0 5px;border-radius: 0 5px 0 5px;}

	<?php if(($asteria['site_width_id'] == "1")) {?>
	#zn_nivo, .slider-wrapper, .slide_wrap, .page_tt, .singlefx, #slide_acord{-webkit-border-radius: 5px 5px 0 0;-moz-border-radius: 5px 5px 0 0;border-radius: 5px 5px 0 0;}
	<?php } ?>
<?php } ?>

.header2, .header3, .header3 .top_head, .header4{-webkit-border-radius: 5px 5px 0 0;-moz-border-radius: 5px 5px 0 0;border-radius: 5px 5px 0 0;}
.header2 .head_soc a, .header3 .head_soc a{ -webkit-border-radius:5px; -moz-border-radius:5px; border-radius:5px;}
<?php } ?>
/*------------------------------------DROP SHADOW------------------------------------------*/
<?php if (!empty ($asteria['shadow_id'])) { ?>
<?php if(($asteria['site_width_id'] == "1")) {?>
.fixindex, .footefixed, .singlefx{-webkit-box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);-moz-box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);}
<?php } ?>

<?php if(($asteria['site_width_id'] == "2")) {?>
.lay1 .post_image, .home_action, .home_action_button, .page .single_post, .single_post, #sidebar .widget, #sidebar #searchsubmit, #footer #searchsubmit, #submit, .comment-form-comment textarea, #ast_nextprev, #ast_nextprev .ast-next img, .related_img img, #ast_related, .avatar img, .related_img, .comment-body, .comm_wrap input, .ast_bioimg, .tabs-container, .lgn_toggle, .trigger_wrap, .lgn_scs, .lgn_info, .lgn_wng, .lgn_err, .ast_table, .single_post .scl_button a, .ast_shrt_action, .act_right a, .ast_slide_wrap .ast_slider, .ast_slider .nivo-caption, .lay4 .post_image, .lay2 .imgwrap, .lay3 .hentry, .lay5 .single_post, .nivo-caption .sld_layout1 h3 a, .nivo-caption .sld_layout1 p, .banner .sld_layout1 p, .banner .sld_layout1 h3 a, .acc-sld_layout1 h3 a, .acc-sld_layout1 p, .under-construction-inner, .ast_countdown li, #home_widgets .widget, .search_term, .page-numbers, .header4, .header2, .lay4 .hentry{-webkit-box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);-moz-box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);}

.entry-content .cont_inpt, .entry-content textarea, .contact_submit input, .entry-content .contact_verify input, #sidebar #searchform div, .comm_wrap input, .comment-form-comment textarea{-webkit-box-shadow: 0 0 3px rgba(0, 0, 0, 0.2) inset ;-moz-box-shadow: 0 0 3px rgba(0, 0, 0, 0.2) inset;box-shadow: 0 0 3px rgba(0, 0, 0, 0.2) inset;}
.page_tt{-webkit-box-shadow: 0 0 15px rgba(0, 0, 0, 0.2) inset;-moz-box-shadow: 0 0 15px rgba(0, 0, 0, 0.2) inset;box-shadow: 0 0 15px rgba(0, 0, 0, 0.2) inset;}
<?php } ?>
<?php } ?>
/*------------------------------------ELEMENTS COLORS------------------------------------------*/
<?php if ( get_option( 'asteria' )) {?>
/*SOCIAL SHARE BUTTONS COLOR*/
body .social_buttons div i, body .social_buttons div a{color:<?php echo $asteria['social_color_id']; ?>!important;}

/*SECONDARY ELEMENT*/
.header4 #topmenu ul li:hover, .nivo-caption .sld_layout1 p, .banner .sld_layout1 p, .acc-sld_layout2 p, .header4 #topmenu .sub-menu, .acc-sld_layout1 p{ border-color:<?php echo $asteria['sec_color_id']; ?>!important;}
#topmenu ul li ul li a:hover, .nivo-caption .sld_layout1 h3 a, .nivo-controlNav a.active, .banner .sld_layout1 h3 a, .acc-sld_layout1 h3 a, .tab.active, .thn_post_wrap .more-link:hover, .moretag:hover, #submit, .page_tt, #searchsubmit, .contact_submit input, .pad_menutitle, .to_top:hover, .page-numbers:hover, .ast_pagenav .current, .progrssn, #simple-menu, .wpcf7-submit{background-color:<?php echo $asteria['sec_color_id']; ?>!important;}

.nivo-caption p a, .banner .sld_layout1 p a, .banner .sld_layout2 p a, .banner .wrap-sld_layout3 p a, .acord_text p a, .lay2 h2 a, .lay3 h2 a, .lay4 h2 a, .lay5 .postitle a, #ast_nextprev .ast-prev:hover .left_arro i, #ast_nextprev .ast-next:hover .right_arro i, .rel_content a, #reply-title small a, .logged-in-as a, .thn_post_wrap a:link, .thn_post_wrap a:visited, .single_metainfo a i:hover, .edit_wrap i:hover, .single_post .postitle, #sidebar .widget .widgettitle, #sidebar .widget .widgettitle a, #home_widgets .widget a:link, #home_widgets .widget a:visited, #home_widgets .widget .thn_wgt_tt, #sidebar .widget .thn_wgt_tt, #footer .widget .thn_wgt_tt, .widget_calendar td a, .astwt_iframe a, .ast_countdown li, .ast_biotxt a, .ast_bio .ast_biotxt h3, .search_term h2, .author_right h2, .author_right a, #contact_block .widgettitle, #contact_block a:link, #contact_block a:visited, .copytext a, .ast_maintanace .logo h1 a, #ast_nextprev .ast-prev:hover .left_arro i, #ast_nextprev .ast-next:hover .right_arro i, .single_metainfo a:hover, .post_meta a:hover, .social_buttons div a:hover i, .social_buttons div a:hover, .widgets p a, .tagcloud a, .text_block a:link, .text_block a:visited{color:<?php echo $asteria['sec_color_id']; ?>!important;}

.rel_content .rel_more:hover{border-color: transparent transparent <?php echo $asteria['sec_color_id']; ?> transparent!important;}
.tab.active .tab_arrow{border-color: <?php echo $asteria['sec_color_id']; ?> transparent transparent transparent!important;}

.mid_block_content a, .single_post_content a{ color:<?php echo $asteria['sec_color_id']; ?>!important;}

.midrow_block:hover .mid_block_content a, .midrow_block:hover h3{color:<?php echo $asteria['sectxt_color_id']; ?>!important;}
.midrow_block:hover .block_img{border-color:<?php echo $asteria['sectxt_color_id']; ?>!important;}


/*Post Icons Color*/
.rel_content .rel_more i, .single_metainfo i, .comm_meta_reply i{}

/*Leave a Reply Text Color*/
.comments_template #comments, #comments_ping, #reply-title, .related_h3{ color:<?php echo $asteria['leavreplytxt_color_id']; ?>!important;}

/*Footer Social Color*/
.head_soc a{color:<?php echo $asteria['social_color_id']; ?>!important;}

/*------------------------------------TEXT COLORS------------------------------------------*/
/*Body Text Color*/
body, .single_metainfo, .single_post .single_metainfo a, .post_meta a, .midrow_blocks a{color:<?php echo $asteria['primtxt_color_id']; ?>!important;}

/*Text Color on Secondary Element*/
#submit, #searchsubmit, .page_tt, body #topmenu ul li ul li a:hover, .tab a.active, #ast_nextprev .ast-prev:hover .left_arro, #ast_nextprev .ast-next:hover .right_arro, .page-numbers:hover, .more-link, .moretag, #simple-menu, #simple-menu i{color:<?php echo $asteria['sectxt_color_id']; ?>!important;}
.nivo-caption .sld_layout1 h3 a, .nivo-controlNav a.active, .banner .sld_layout1 h3 a, .acc-sld_layout1 h3 a, .tab.active, .thn_post_wrap .more-link:hover, .moretag:hover, #submit, .page_tt, #searchsubmit, .contact_submit input, .pad_menutitle, .to_top:hover, .page-numbers:hover, .ast_pagenav .current, .progrssn, #simple-menu{color:<?php echo $asteria['sectxt_color_id']; ?>!important;}

/*Woocommerce*/
.woocommerce div.product .product_title, .woocommerce-page div.product .product_title, .woocommerce #content div.product .product_title, .woocommerce-page #content div.product .product_title, .product_meta a, .woocommerce ul.products li.product h3, .woocommerce-page ul.products li.product h3{color:<?php echo $asteria['sec_color_id']; ?>!important;}
<?php } ?>

<?php if(($asteria['site_width_id'] == "1")) {?>
@media screen and (max-width: 1200px){
body .fixed_site{ width:95%!important; margin: 0 auto;}
}
<?php } ?>

/*Others*/
/*Welcome Text Background*/
.text_block{ background-color:<?php echo $asteria['welcome_color_id']; ?>!important;}
<?php if(($asteria['post_gallery_id'] == "1")) {?>
/*Gallery*/
.gallery{ float:left; margin:20px auto!important; width:100%;}
body .gallery-item{text-align: center;width: 50px!important; height:45px;display: inline-block;margin: 10px 5px; float:none!important;}

<?php } ?>
</style>
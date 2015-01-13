<?php
/**
 * @package WP Theme Customizer
 */
/*
Front-end Module
*/
	
	$wptc_op_g = get_option('wptc_general_options');

	$wptc_op_cg = get_option('wptc_colors_general');

	$wptc_op_bg = get_option('wptc_backgrounds_general');

	$wptc_op_eg = get_option('wptc_effects_general');

	$wptc_module_skin = get_option( 'wptc_module_skin', 'modern-black' );
		
	if( $wptc_op_g['display_module'] == 1 ){
			
			$wptc_sending = 'update.php';
			
	}
	
	function wptc_get_thumb($image){
	
		$image = esc_url( $image );
		
		if($image != '' && !empty($image)){
		
			$image_inf = getimagesize($image);
			
			$mime = $image_inf['mime'];
			
			$thumbs_array = array('image/jpeg','image/png','image/gif');
			
			if( in_array( $mime, $thumbs_array ) ){
		
				if ( !function_exists ('imagecreatetruecolor') ){
					
					$thumb = $image;
				
				}else{
				
					$thumb = plugins_url( 'thumb.php' , __FILE__);
					
					$thumb .= '?thumb='.$image;
				
				}
			}else{
			
				$thumb = $image;
				
			}
			
			return $thumb;
		
		}
	
	}

	/*
	Registering Styles and Scripts for Module
	*/
		
	add_action('init','register_wptc_ss', 1);

	function register_wptc_ss /*Styles and Scripts*/ () {
	
		global $wptc_op_g, $wptc_op_cg, $wptc_op_bg, $wptc_op_eg, $wptc_module_skin;
		
		wp_register_script( 'wptc-snow-effects', plugins_url( 'js/fall.js', dirname(dirname(__File__))), array('jquery') );
	
		if( !is_admin() ) {
			
			$effect = wptc_retrieve_effect();
			
			if($effect != 'normal_effect'){
			
				wp_enqueue_script( 'wptc-snow-effects', array('jquery') );
				
			}
		
			$wptc_show_module = 2;
			
			if( $wptc_op_g['display_module'] == 1 ){
			
				if( is_user_logged_in() && current_user_can('manage_options') ){
				
					$wptc_show_module = 1;
					
				}else{
				
					$wptc_show_module = 2;
					
				}
			
			}else{
			
				$wptc_show_module = 2;
				
			}
			
			if ( $wptc_show_module === 1 ){
			
				wp_enqueue_style( 'wptc-module-style', plugins_url( 'css/wptc_module.css', dirname(dirname(__File__))) );
					
				wp_enqueue_style( 'wptc-registered-module-skin', plugins_url( 'css/wptc_'.$wptc_module_skin.'.css', dirname(dirname(__File__))) );
				
				$array = array();
				
				$array[] = 'jquery';
				
				if( $wptc_op_g['display_effects_tab'] == 1 ){
					
					$array[] = 'wptc-snow-effects';
				
				}
				
				wp_enqueue_script( 'wptc-module-script', plugins_url( 'js/wptc_module.js', dirname(dirname(__File__))), $array );
			
			}
			
			
		}
			
	}
		
		
		add_action('wp_footer','display_wptc_module', 20);

		function display_wptc_module (){
		
			global $wptc_op_g, $wptc_op_cg, $wptc_op_bg, $wptc_op_eg, $wptc_module_skin;
			
			$wptc_show_module = 2;
			
			if( $wptc_op_g['display_module'] == 1 ){
			
				if( is_user_logged_in() && current_user_can('manage_options') ){
				
					$wptc_show_module = 1;
					
				}else{
				
					$wptc_show_module = 2;
					
				}
			
			}else{
			
				$wptc_show_module = 2;
				
			}
			
			if( $wptc_show_module == 1 ) :
		
		?>
			<div id="wptc_module_show"></div>
			
			<div id="wptc_module" class="wptc_bradius wptc_bshadow">
			
				<div id="wptc_module_inner" class="wptc_bradius">
				
					<div id="wptc_module_left" class="">
					
						<ul class="wptc_module_menu">
						
							<?php
							
								$tabs = array('colors','backgrounds','effects');
								
								if( $wptc_op_g['display_effects_tab'] == 1 ){
										$active =  'effects';
								}
								
								if( $wptc_op_g['display_backgrounds_tab'] == 1 ){
										$active = 'backgrounds';
								}
								
								if( $wptc_op_g['display_colors_tab'] == 1 ){
										$active = 'colors';
								}
								
								foreach($tabs as $tab){
								
									if( $wptc_op_g['display_'.$tab.'_tab'] == 1 ){
									
									$active = ($active == $tab) ? 'active' : '';

										echo '<li class="wptc-nav-li wptc-li-'.$tab.' '.$active.'" wptc_name="wptc_'.$tab.'_switcher"></li>';
										
									}
									
								}
							
							?>
							
						</ul>
						
					</div><!-- end module left-->
				
					<div id="wptc_module_right" class="">
					
						<div class="wptc_module_head">
							
							<span class="wptc_module_heading">Style Switcher</span>
							
							<?php
						
							$display_none = ( $wptc_op_g['display_colors_tab'] != 1 ) ? 'style="display:none;"' : '';
							
							?>
							
							<span class="wptc_module_slogan wptc_colors_slogan" <?php echo $display_none; ?>>Color Switcher</span>
							
							<?php
						
							$display_none = ( $wptc_op_g['display_colors_tab'] != 1 ) ? '' : 'style="display:none;"';
							
							?>
							
							<span class="wptc_module_slogan wptc_backgrounds_slogan" <?php echo $display_none; ?>>Background Switcher</span>
							<?php
						
							$display_none = ( $wptc_op_g['display_colors_tab'] != 1 && $wptc_op_g['display_backgrounds_tab'] != 1 ) ? '' : 'style="display:none;"';
							
							?>
							
							<span class="wptc_module_slogan wptc_effects_slogan" <?php echo $display_none; ?>>Special Effects</span>
								
						</div>
						
						<div class="wptc_module_body">

						<?php
						
						if( $wptc_op_g['display_colors_tab'] == 1 ){
						
						?>					
					
							<div class="wptc_colors_switcher wptc_switcher">
						
							
							<?php
							
								$wptc_option = get_option('wptc_color');
		
								if( isset ( $_COOKIE['wptc_color']  ) ){
								
									$color_selected = $_COOKIE['wptc_color'];
									
								}else if( isset( $wptc_option ) && $wptc_option != ''  ){
								
									$color_selected = $wptc_option;
									
								}else{
								
									$color_selected = '#123456';
									
								}
							
							?>
							
								<?php
								
								function wptc_pick_palatte(){
								
									global $wptc_op_cg, $wptc_sending;
									
								?>
									
									jQuery('.wptc_color_box_div').click(function(){
									
										jQuery('div.wptc_color_box_div').removeClass('wptc_selected_color_palatte');
										
										jQuery(this).addClass('wptc_selected_color_palatte');
									
										color = jQuery(this).attr('name');
										
										jQuery('.wptc_save').stop().show(1).text('Saving...');
										
										<?php  if( isset( $wptc_op_cg['change_body_color'] ) && $wptc_op_cg['change_body_color'] == 1 ){ ?>
										
										jQuery('body').css({'background-color':color});
										
										<?php } ?>
										
										<?php  if( isset( $wptc_op_cg['change_buttons_color'] ) && $wptc_op_cg['change_buttons_color'] == 1 ){ ?>
										
										jQuery('button, input[type="submit"], input[type="button"], input[type="reset"]').css({'background-color':color});
										
										jQuery('button, input[type="submit"], input[type="button"], input[type="reset"]').css({'background-image':'url(<?php echo plugins_url( 'assets/button.png' , dirname(dirname(__FILE__ )) ) ?>)', 'border': '1px solid #aaa'});
										
										<?php } ?>
										
										<?php  if( isset( $wptc_op_cg['change_links_color'] ) && $wptc_op_cg['change_links_color'] == 1 ){ ?>
										
										jQuery('.type-post a, .type-page a').css({'color':color});
										
										<?php } ?>
										
										<?php  if( isset( $wptc_op_cg['change_headings_color'] ) && $wptc_op_cg['change_headings_color'] == 1 ){ ?>
										
										jQuery('.type-post :header, .type-page :header').css({'color':color});
										
										<?php } ?>
										
										jQuery('.wptc_this_color').css({'color':color});
										
										jQuery('.wptc_this_bg').css({'background-color':color});
										
										jQuery.post('<?php echo plugins_url( $wptc_sending , __FILE__ ) ?>', { wptc_color: color }, function(data){
											
											jQuery('.wptc_save').text(data).fadeOut(1000);
											
										});
										
									});
											
										
										
								<?php
								
								}
								
								add_action('wptc_load_scripts', 'wptc_pick_palatte');
								
								?>
							
								<span class="wptc_module_heading">Color Palates</span>
								
								<div class="wptc_clear"></div>
								
								<div class="wptc_module_content">
								
									<?php 
									
										for($u = 1; $u <= 5; $u++){
											
											$options = get_option( 'wptc_color_palatte_'.$u , '#aaaaaa' );
											
											$wptc_selected_color_palatte = ($color_selected == $options) ? 'wptc_selected_color_palatte' : '';
											
											echo '<div class="wptc_color_box_div wptc_color_box_'.$u.' wptc_bradius '. $wptc_selected_color_palatte .'" name="'.$options.'" style="background-color: '.$options.'" ></div>';
											
										}
									?>
									
								</div>
								
							<?php
							
							if($wptc_op_cg['display_button_font_color'] == 1){
							
							?>
							
								<span class="wptc_module_heading">Choose Button's Font Color</span>
								
								
								<div class="wptc_clear"></div>
								
								<div class="wptc_module_content">
								
									<div style="margin: auto; width: 160px;" >
									
										<button class="wptc_button_font_preview wptc_bradius" name="#fefefe" style="color: #fefefe !important;">Button</button>
										<button class="wptc_button_font_preview wptc_bradius" name="#010101" style="color: #010101 !important;">Button</button>
									
									</div>
									
								</div>
								
								<?php
								
								function wptc_pick_button_color(){
									
									global $wptc_sending;
										
								?>
									jQuery('.wptc_button_font_preview').click(function(){
									
										color = jQuery(this).css('color');
										
										colorsend = jQuery(this).attr('name');
										
										jQuery('.wptc_save').stop().show(1).text('Saving...');
										
										jQuery('button, input[type="submit"], input[type="button"], input[type="reset"]').not('.wptc_button_font_preview').css({'color':color});
										
										jQuery.post( '<?php echo plugins_url( $wptc_sending , __FILE__ ) ?>', { wptc_button_color: colorsend }, function(data){
										
										jQuery('.wptc_save').text(data).fadeOut(1000);
										
										});
									});	
								<?php
								
								}
									
								add_action('wptc_load_scripts', 'wptc_pick_button_color');
								
								?>
								
							<?php
							
							}
							
							?>
						
						</div><!--end colors switcher -->
						
						<?php
						
						}//end if color switcher
						
						?>
						
						
						<?php
						
						if( $wptc_op_g['display_backgrounds_tab'] == 1 ){
						
							$wptc_option = get_option('wptc_body_bg');
		
								if( isset ( $_COOKIE['wptc_body_bg']  ) ){
								
									$bg_selected = $_COOKIE['wptc_body_bg'];
									
								}else if( isset( $wptc_option )  ){
								
									$bg_selected = $wptc_option;
									
								}else{
								
									$bg_selected = '';
									
								}
						
						?>	
							
							<?php
								
							function wptc_pick_bg_image(){
							
								global $wptc_op_bg, $wptc_sending;
								
								$bg_repeat = $wptc_op_bg['background_repeat'];
								
								$bg_attachment = $wptc_op_bg['background_attachment'];
								
								$bg_pos = $wptc_op_bg['background_position'];
								
								if( isset ( $bg_repeat )  ){
		
									if($bg_repeat == 1){
									
										$repeat = 'no-repeat';
									
									}else if($bg_repeat == 2){
									
										$repeat = 'repeat';
									
									}else if($bg_repeat == 3){
									
										$repeat = 'repeat-x';
									
									}else if($bg_repeat == 4){
									
										$repeat = 'repeat-y';
									
									}else{
									
										$repeat = 'repeat';
									
									}
									
								}else{
									
									$repeat = 'repeat';
									
								}
								
								if( isset( $bg_attachment ) ){ 
								
									if($bg_attachment == 1){
									
										$attachment = 'fixed';
										
									}else{
										
										$attachment = 'scroll';
										
									}
				
								}else{
								
									$attachment = 'scroll';
									
								}
								
								if( isset( $bg_pos ) ){ 
								
									if($bg_pos == 2){
									
										$pos = 'top center';
									
									}else if($bg_pos == 3){
									
										$pos = 'top right';
									
									}else{
									
										$pos = 'top left';
									
									}
				
								}else{
								
									$pos = 'top left';
									
								}
								
								?>
									
								jQuery('.wptc_bg_img_div').click(function (){
								
									bgimage = jQuery(this).attr('wptc_src');
									
									bgtype = jQuery(this).attr('type');
									
									jQuery('.wptc_bg_img_div').removeClass('wptc_selected_bg_image');
									
									jQuery(this).addClass('wptc_selected_bg_image');
									
									jQuery('.wptc_save').stop().show(1).text('Saving...');
									
									jQuery('body').css( 'background-image', 'url('+bgimage+')' );
									
									if(bgtype == 'pattern'){
										jQuery('body').css( 'background-repeat', 'repeat' );
									}else{
										jQuery('body').css( 'background-repeat', '<?php echo $repeat; ?>' );
									}
									
									jQuery('body').css( 'background-attachment', '<?php echo $attachment; ?>' );
									
									jQuery('body').css( 'background-position', '<?php echo $pos; ?>' );
									
									jQuery.post('<?php echo plugins_url( $wptc_sending , __FILE__ ) ?>', { wptc_body_bg: bgimage, wptc_bg_type: bgtype }, function(data){
										jQuery('.wptc_save').text(data).fadeOut(1000);
										
									});
									
								});
					
									
							<?php
							
							}
								
							add_action('wptc_load_scripts', 'wptc_pick_bg_image');
								
							?>
							
							<?php
							
							$display_none = ( $wptc_op_g['display_colors_tab'] == 1 ) ? 'style="display:none;"' : '';
							
							?>
							
							<div class="wptc_backgrounds_switcher wptc_switcher" <?php echo $display_none;?>>
								
								<?php
								
								if( $wptc_op_bg['display_images_section'] == 1 ){
								
								?>
								
									<span class="wptc_module_heading">Images</span>
									
									<div class="wptc_clear"></div>
									
									<div class="wptc_module_content">
									
									
										<?php
										
											for( $u = 1; $u <= 5; $u++){
												
												$options = get_option( 'wptc_bg_image_'.$u , '' );
												
												$wptc_selected_bg_image = ($bg_selected == $options) ? 'wptc_selected_bg_image' : '';
											
												echo '<img class="wptc_bg_img_div wptc_bg_img_div_'.$u.' '.$wptc_selected_bg_image.'" type="image" wptc_src="'.$options.'" src="'.wptc_get_thumb($options).'" />';
											
											}
											
										?>
											
										
										
									</div>
							
								<?php 
								
								}
									
									
								if( $wptc_op_bg['display_patterns_section'] == 1 ){
								
								?>
								
									<span class="wptc_module_heading">Patterns</span>
								
									<div class="wptc_clear"></div>
								
									<div class="wptc_module_content">
									
										<?php
										
											for($u = 1; $u <= 5; $u++){
												
												$options = get_option( 'wptc_bg_pattern_'.$u , '' );
												
												$wptc_selected_bg_image = ($bg_selected == $options) ? 'wptc_selected_bg_image' : '';
											
												echo '<img class="wptc_bg_img_div wptc_bg_pattern_'.$u.' '.$wptc_selected_bg_image.'" type="pattern" wptc_src="'.$options.'" src="'.wptc_get_thumb($options).'" />';
											
											}
										
										?>
										
									</div>
								
								<?php
								
								}
								
								?>
									
							</div><!--end backgrounds switcher -->
							
						<?php
						}
						?>
						
						<?php
						
						if( $wptc_op_g['display_effects_tab'] == 1 ){
						
							$display_none = ( $wptc_op_g['display_colors_tab'] != 1 && $wptc_op_g['display_backgrounds_tab'] != 1 ) ? '' : 'style="display:none;"';
							
							?>
						
							<div class="wptc_effects_switcher wptc_switcher" <?php echo $display_none;?>>
								
									<span class="wptc_module_heading">Choose an effect</span>
									
									<div class="wptc_clear"></div>
									
									<div class="wptc_module_content">
									
										<?php
									
										$wptc_option = get_option('wptc_effect');
		
										if( isset ( $_COOKIE['wptc_effect']  ) ){
										
											$effect_selected = $_COOKIE['wptc_effect'];
											
										}else if( isset( $wptc_option )  ){
										
											$effect_selected = $wptc_option;
											
										}else{
										
											$effect_selected = 'normal_effect';
											
										}
										
										?>
										
											<?php  $activated = ( $effect_selected == 'normal_effect' ) ? 'wptc_activated_effect' : ''; ?>
										
											<img class="wptc_effect wptc_effect_normal <?php echo $activated; ?>" name="normal_effect" src="<?php echo plugins_url('/assets/effect-normal.png',dirname(dirname(__File__))); ?>" />
											
										<?php
								
										if ( $wptc_op_eg['display_snow_effect'] == 1 ){
										
										?>
										
											<?php  $activated = ( $effect_selected == 'snow_effect' ) ? 'wptc_activated_effect' : ''; ?>
											
											<img class="wptc_effect wptc_effect_snow <?php echo $activated; ?>" name="snow_effect" src="<?php echo plugins_url('/assets/effect-snow.png',dirname(dirname(__File__))); ?>" />
											
										<?php
								
										}
										
										?>
										
										<?php
								
										if ( $wptc_op_eg['display_rain_effect'] == 1 ){
										
										?>
										
											<?php  $activated = ( $effect_selected == 'rain_effect' ) ? 'wptc_activated_effect' : ''; ?>
											
											<img class="wptc_effect wptc_effect_rain <?php echo $activated; ?>" name="rain_effect" src="<?php echo plugins_url('/assets/effect-rain.png',dirname(dirname(__File__))); ?>" />
									
										<?php
								
										}
										
										?>
									
									</div>
									
									<?php
							
									function wptc_set_effect(){
										
										global $wptc_sending;
											
									?>
										jQuery('.wptc_effect').click(function(){
											
											effect = jQuery(this).attr('name');
											
											jQuery('.wptc_effect').removeClass('wptc_activated_effect');
											
											jQuery(this).addClass('wptc_activated_effect');
											
											jQuery('.wptc_save').stop().show(1).text('Saving...');
											
											jQuery(document).snowfall('clear');
											
											if(effect == 'snow_effect'){
												
												jQuery(document).snowfall({
													flakeCount : 150,
													flakeColor : '#fefefe',
													flakeIndex: 999999,
													minSize : 3,
													maxSize : 5,
													minSpeed : 3,
													maxSpeed : 4,
													round : true,
													shadow : false
												});
											
											}else if(effect == 'rain_effect'){
												
												jQuery(document).snowfall({
													flakeCount : 400,
													flakeColor : '#186c81',
													flakeIndex: 999999,
													minSize : 2,
													maxSize : 2.5,
													minSpeed : 18,
													maxSpeed : 20,
													round : true,
													shadow : false
												});
												
											}
											
											jQuery.post( '<?php echo plugins_url( $wptc_sending , __FILE__ ) ?>', { wptc_effect: effect }, function(data){
												
												jQuery('.wptc_save').text(data).fadeOut(1000);

											});
											
										});
										
									<?php
									
									}
										
									add_action('wptc_load_scripts', 'wptc_set_effect');
									
									?>

							
							</div><!--end effects switcher -->
						
							<?php
							
							}
							
							?>
							
						</div><!--end module body -->
						
						
						
					</div><!--end module right -->
					
				</div> <!--end module inner -->
				
				<div id="wptc_module_hide"></div>
				
				<span class="wptc_save"></span>
				
			</div><!--end module -->
			
			
					<div class="wptc_blank_div wptc_this_color wptc_this_bg wptc_colors_switcher wptc_backgrounds_switcher wptc_effects_switcher wptc_colors_slogan wptc_backgrounds_slogan wptc_effects_slogan wptc-li-colors wptc-li-backgrounds wptc-li-effects wptc-nav-li post"></div>
			
			
			<script type="text/javascript">
			
			 jQuery(document).ready(function(){
			 
				<?php do_action('wptc_load_scripts'); ?>
				
			 });
			 
			</script>
			
		<?php
		
			endif;
			
		} //end display_wptc_module()

?>
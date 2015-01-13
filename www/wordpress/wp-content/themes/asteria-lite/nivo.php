<?php global $asteria;?>

<?php if($asteria['slider_type_id'] == "noslider" ) { ?>
<?php } else { ?>
<?php if (!empty ($asteria['slides'])) { ?>
<div class="slide_wrap">
<div class="slider-wrapper theme-default">
<div class="pbar_wrap"><div class="prog_wrap"><div class="progrssn" style="width:10%;"></div></div><div class="pbar" id='astbar'>0%</div></div>
<div id="zn_nivo" class="zn_nivo">
			<?php foreach ((array)$asteria['slides'] as $arr){ ?>
            
				<?php if (!empty ($arr['slide_url'])) { ?>
					<a href="<?php echo $arr['slide_url']; ?>" title="<?php echo $arr['slide_title']; ?>">
					<img src="<?php echo $arr['slide_image_url']; ?>" alt="<?php echo $arr['slide_title']; ?>" title="#nv_<?php echo $arr['slide_image_id']; ?>"/>
					</a>
				<?php } else { ?>
					<img src="<?php echo $arr['slide_image_url']; ?>" alt="<?php echo $arr['slide_title']; ?>" title="#nv_<?php echo $arr['slide_image_id']; ?>"/>						
				<?php } ?>


			<?php } ?>

	</div>	
  			<?php foreach ((array)$asteria['slides'] as $arr){ ?>    

					<div id="nv_<?php echo $arr['slide_image_id']; ?>" class="nivo-html-caption sld_<?php echo $arr['slide_content_id']; ?>">
                    <div class="nivoinner sld_<?php echo $arr['slide_content_id']; ?>">
					<h3 class="entry-title"><a <?php if (!empty ($arr['slide_url'])) { ?>href="<?php echo $arr['slide_url']; ?>"<?php } ?>><?php echo $arr['slide_title']; ?></a></h3>
							<p><?php echo $arr['slide_description']; ?></p>
                     </div>
					</div>

          	<?php } ?>
		

	
</div>
</div>
	<?php }else{ ?>
    
		<?php get_template_part('dummy/dummy','nivo'); ?>
    
	<?php } ?>
	
<?php } ?>
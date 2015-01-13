<?php global $asteria;?>
<?php $blocks = $asteria['home_sort_id']; if(!empty($blocks['blocks'])){ ?>
<?php if ( asteria_is_mobile() && (!empty($asteria['hide_mob_blocks'])) ) { ?>
<?php }else{ ?>
<!--Blocks-->
<div class="midrow">

 <div class="midrow_wrap">       
        <div class="midrow_blocks">   
        <div class="midrow_blocks_wrap">
        
        <!--BLOCK1 START-->
		<?php if ((!empty ($asteria['block1_text_id'])) || (!empty ($asteria['block1_textarea_id']))  ) { ?>
        
		<?php if (!empty ($asteria['block1_link_id'])){ ?> <a href="<?php echo $asteria['block1_link_id']; ?>"><?php } ?>
        <div class="midrow_block">
            <div class="mid_block_content">
            <?php if( ($asteria['block1_icon'] == "no-icon") || (empty($asteria['block1_icon'])) ){ ?>
            <?php }else{ ?>
            <div class="block_img"><div class="icon_wrap"><i class="<?php echo $asteria['block1_icon']; ?> fa-2x"></i></div></div>
            <?php } ?>
            <h3><?php echo $asteria['block1_text_id']; ?></h3>
            <p><?php echo do_shortcode($asteria['block1_textarea_id']); ?></p>
    
            </div>
        </div>
        <?php if (!empty ($asteria['block1_link_id'])){ ?> </a><?php } ?>
        
        <?php } ?>
        <!--BLOCK1 END-->
        
        <!--BLOCK2 START-->
		<?php if ((!empty ($asteria['block2_text_id'])) || (!empty ($asteria['block2_textarea_id']))  ) { ?>
        
        <?php if (!empty ($asteria['block2_link_id'])){ ?> <a href="<?php echo $asteria['block2_link_id']; ?>"><?php } ?>
        <div class="midrow_block">
            <div class="mid_block_content">
            <?php if( ($asteria['block2_icon'] == "no-icon") || (empty($asteria['block2_icon'])) ){ ?>
            <?php }else{ ?>
            <div class="block_img"><div class="icon_wrap"><i class="<?php echo $asteria['block2_icon']; ?> fa-2x"></i></div></div>
            <?php } ?>
            <h3><?php echo $asteria['block2_text_id']; ?></h3>
            <p><?php echo do_shortcode($asteria['block2_textarea_id']); ?></p>
    
            </div>
        </div>
        <?php if (!empty ($asteria['block2_link_id'])){ ?> </a><?php } ?>
		<?php } ?>
        <!--BLOCK2 END-->
        
        <!--BLOCK3 START-->
        <?php if ((!empty ($asteria['block3_text_id'])) || (!empty ($asteria['block3_textarea_id']))  ) { ?>
        
       <?php if (!empty ($asteria['block3_link_id'])){ ?> <a href="<?php echo $asteria['block3_link_id']; ?>"><?php } ?> 
        <div class="midrow_block">
            <div class="mid_block_content">
            <?php if( ($asteria['block3_icon'] == "no-icon") || (empty($asteria['block3_icon'])) ){ ?>
            <?php }else{ ?>
            <div class="block_img"><div class="icon_wrap"><i class="<?php echo $asteria['block3_icon']; ?> fa-2x"></i></div></div>
            <?php } ?>
            <h3><?php echo $asteria['block3_text_id']; ?></h3>
            <p><?php echo do_shortcode($asteria['block3_textarea_id']); ?></p>
    
            </div>
        </div>
        <?php if (!empty ($asteria['block3_link_id'])){ ?> </a><?php } ?>
		<?php } ?>
        <!--BLOCK3 END-->
        
        <!--BLOCK4 START-->
        <?php if ((!empty ($asteria['block4_text_id'])) || (!empty ($asteria['block4_textarea_id']))  ) { ?>
        
        <?php if (!empty ($asteria['block4_link_id'])){ ?> <a href="<?php echo $asteria['block4_link_id']; ?>"><?php } ?>
        <div class="midrow_block">
            <div class="mid_block_content">
            <?php if( ($asteria['block4_icon'] == "no-icon") || (empty($asteria['block4_icon'])) ){ ?>
            <?php }else{ ?>
            <div class="block_img"><div class="icon_wrap"><i class="<?php echo $asteria['block4_icon']; ?> fa-2x"></i></div></div>
            <?php } ?>
            <h3><?php echo $asteria['block4_text_id']; ?></h3>
            <p><?php echo do_shortcode($asteria['block4_textarea_id']); ?></p>
       
            </div>
        </div>
        <?php if (!empty ($asteria['block4_link_id'])){ ?> </a><?php } ?>
		<?php } ?>
        <!--BLOCK4 END-->
</div>
        </div>
                
        
    </div>

</div>


<!--Blocks END-->
<?php } ?>
<?php } ?>

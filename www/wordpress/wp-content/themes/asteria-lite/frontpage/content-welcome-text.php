<?php global $asteria;?>
<?php $welcome = $asteria['home_sort_id']; if(!empty($welcome['welcome-text'])){ ?>
<!--Text Block START-->
	<?php if ( asteria_is_mobile() && (!empty($asteria['hide_mob_welcm'])) ) { ?>
    <?php }else{ ?>
    <div class="text_block">
    <div class="text_block_wrap"><div class="center"><?php echo do_shortcode($asteria['welcm_textarea_id']); ?></div></div>
    </div>
    <?php } ?>
<!--Text Block END-->
<?php } ?>
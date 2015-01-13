<?php global $asteria;?>
<?php $homeposts = $asteria['home_sort_id']; if(!empty($homeposts['posts'])){ ?>
<!--Latest Posts-->
	<?php if ( asteria_is_mobile() && (!empty($asteria['hide_mob_frontposts'])) ) { ?>
    <?php }else{ ?>
	<?php get_template_part('layout'.$asteria['front_layout_id'].''); ?>
    <?php } ?>
<!--Latest Posts END-->
<?php } ?>
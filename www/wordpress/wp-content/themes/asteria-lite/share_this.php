<div class="share_this">   
            <div class="social_buttons">
                <div class="lgn_fb">
                <a href="http://facebook.com/share.php?u=<?php the_permalink() ?>&amp;amp;t=<?php echo urlencode(the_title('','', false)); ?>" title="Share <?php _e('this post on Facebook', 'asteria');?>"><i class="fa-facebook"></i></a>
                </div>
                <div class="lgn_twt">
                <a href="http://twitter.com/home?status=Reading:%20<?php $escapett = get_the_title(); $twtt = rawurlencode($escapett); echo $twtt;?>%20<?php the_permalink();?>" title="Tweet <?php _e('this post', 'asteria'); ?>"><i class="fa-twitter"></i></a>
                </div>
                <div class="lgn_del">
				<a title="<?php _e('Submit to', 'asteria'); ?> Delicious" href="http://del.icio.us/post?url=<?php the_permalink() ?>&amp;title=<?php echo urlencode(the_title('','', false)) ?>"><i class="zicon-delicious"></i></a>
                </div>
                <div class="lgn_digg">
                <a href="http://digg.com/submit?phase=2&amp;amp;url=<?php the_permalink() ?>&amp;amp;title=<?php echo urlencode(the_title('','', false)) ?>" title="Digg <?php _e('this post', 'asteria'); ?>"><i class="zicon-digg"></i></a>
                </div>
                <div class="lgn_stmbl">
                <a title="Stumble <?php _e('This', 'asteria'); ?>" href="http://www.stumbleupon.com/submit?url=<?php the_permalink(); ?>&amp;title=<?php echo urlencode(the_title('','', false)) ?>"><i class="zicon-stumbleupon"></i></a>
                </div>
                
                <div class="lgn_gplus">
                <a title="Plus One <?php _e('This', 'asteria'); ?>" href="https://plusone.google.com/_/+1/confirm?hl=en&amp;url=<?php echo the_permalink(); ?>">
                <i class="fa-google-plus"></i></a>
                </div>
                
                <div class="lgn_pin">
                <a title="Pin <?php _e('This', 'asteria'); ?>" href='javascript:void((function()%7Bvar%20e=document.createElement(&apos;script&apos;);e.setAttribute(&apos;type&apos;,&apos;text/javascript&apos;);e.setAttribute(&apos;charset&apos;,&apos;UTF-8&apos;);e.setAttribute(&apos;src&apos;,&apos;http://assets.pinterest.com/js/pinmarklet.js?r=&apos;+Math.random()*99999999);document.body.appendChild(e)%7D)());'><i class="zicon-pinterest"></i></a>
                </div>
                
            </div>
            
</div>
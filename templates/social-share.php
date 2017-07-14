<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 6/11/2017
 * Time: 4:57 PM
 */
?>
<div class="need-clear"></div>
<div class="social-share">
    <div class="social-share-buttons">
			<span class="twitter share-button">
				<a href="https://twitter.com/intent/tweet?text=<?php echo rawurlencode(get_the_title()); ?>&amp;url=<?php echo esc_url(get_permalink()); ?>"
				   target="_blank">
					<i class="fa fa-twitter" aria-hidden="true"></i>
				</a>
			</span>
			<span class="facebook share-button">
				<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url(get_permalink()); ?>"
				   target="_blank">
					<i class="fa fa-facebook" aria-hidden="true"></i>
				</a>
			</span>
			<span class="google share-button">
				<a href="https://plus.google.com/share?url=<?php echo esc_url(get_permalink()); ?>"
				   target="_blank">
					<i class="fa fa-google-plus" aria-hidden="true"></i>
				</a>
			</span>
			<span class="pinterest share-button">
				<a href="https://pinterest.com/pin/create/button/?url=<?php echo esc_url(get_permalink()); ?>&amp;media=<?php echo wp_get_attachment_url(get_post_thumbnail_id()); ?>&amp;description=<?php echo rawurlencode(get_the_title()); ?>"
				   target="_blank">
					<i class="fa fa-pinterest" aria-hidden="true"></i>
				</a>
			</span>
			<span class="mail">
				<a href="mailto:?subject=<?php echo rawurlencode(get_the_title()); ?>&amp;body=<?php echo rawurlencode(get_the_title()); ?>%0A%0D<?php echo esc_url(get_permalink()); ?>">
					<i class="fa fa-envelope-o" aria-hidden="true"></i>
				</a>
			</span>
			<span class="post-views-wrap">
				<span class="post-views"><?php echo function_exists('mallow_get_post_views') ?  mallow_get_post_views(get_the_ID()) : ''; ?></span>
			</span>

    </div>
</div>

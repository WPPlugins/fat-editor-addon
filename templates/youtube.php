<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 6/8/2017
 * Time: 11:18 AM
 */
?>
<div class="video-time"></div>
<img class="fat-youtube-screenshot" src="https://i.ytimg.com/vi/<?php echo esc_attr($atts['video_id']);?>/maxresdefault.jpg">
<div class="fat-youtube-player" id="<?php echo esc_attr($iframe_id);?>" data-id="<?php echo esc_attr($atts['video_id']);?>"></div>

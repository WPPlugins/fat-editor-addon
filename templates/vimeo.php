<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 6/8/2017
 * Time: 11:18 AM
 */
$allowFullScreen = isset($atts['allow_full_screen']) && $atts['allow_full_screen'] =='1' ? 'webkitAllowFullScreen mozallowfullscreen allowFullScreen' : '';
$autoplay = isset($atts['autoplay']) &&  $atts['autoplay'] =='1' ? 'true' : 'false';
$background = isset($atts['showcontrol']) && $atts['showcontrol'] == '1' ? 0 : 1;
$video_src = sprintf('http://player.vimeo.com/video/%s?background=%s&autoplay=%s', $atts['video_id'], $background, $autoplay);
?>
<iframe id="<?php echo esc_attr($iframe_id); ?>" src="<?php echo esc_url($video_src); ?>" frameborder="0" <?php echo esc_attr($allowFullScreen); ?> ></iframe>

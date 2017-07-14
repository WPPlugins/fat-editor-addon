<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 6/7/2017
 * Time: 10:10 PM
 */
$width = '100%';
if (isset($atts['dimension']) && isset($atts['dimension_value']) && $atts['dimension_value'] !== '') {
    if ($atts['dimension'] == 'width') {
        $width = $atts['dimension_value'] . 'px';
    } else {
        $width = floor(1.777777777777778 * $atts['dimension_value']) . 'px';
    }
}
$style = sprintf("width:%s", $width);
$class = "fat-sc-video-container " . $atts['video_position'];
$class .= isset($atts['autoplay']) && $atts['autoplay'] == '1' ? ' autoplay' : '';
$iframe_id = uniqid();
?>
<div class="<?php echo esc_attr($class); ?>">
    <div class="fat-sc-video" style="<?php echo esc_attr($style); ?>"
         data-type="<?php echo esc_attr($atts['video_type']); ?>"
         data-video-id="<?php echo esc_attr($atts['video_id']); ?>"
         data-autoplay="<?php echo esc_attr($atts['autoplay']); ?>"
         data-allow-full-screen="<?php echo esc_attr($atts['allow_full_screen']); ?>"
         data-show-info="<?php echo esc_attr($atts['showinfo']); ?>"
         data-show-control="<?php echo esc_attr($atts['showcontrol']); ?>"
         data-iframe-id= <?php echo esc_attr($iframe_id); ?>
    >
        <?php if (isset($atts['enable_video_icon']) && $atts['enable_video_icon'] == '1'): ?>
            <div class="fat-sc-video-icon-wrap">
                <a class="fat-sc-video-icon icon-play" href="javascript:;">
                    <i class="fa fa-play"></i>
                </a>
                <a class="fat-sc-video-icon icon-loading">
                    <i class="fa fa-spinner fa-spin"></i>
                </a>
                <a class="fat-sc-video-icon icon-pause" href="javascript:;">
                    <span></span>
                    <span></span>
                </a>
            </div>
        <?php endif; ?>
        <div class="responsive-video">
            <?php
            $video_template = FAT_EDITOR_ADDON_DIR_PATH . 'templates/' . $atts['video_type'] . '.php';
            if (file_exists($video_template)) {
                include $video_template;
            }
            ?>
        </div>
    </div>
</div>
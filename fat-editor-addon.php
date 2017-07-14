<?php
/*
Plugin Name: FAT Editor AddOn
Plugin URI:  http://plugins.roninwp.com/portfolio
Description: FAT Editor AddOn is a  WordPress plugin which allows you create highlight text, text with twitter share, video embed (youtube and vimeo)
Version:     1.0
Author:      Roninwp
Author URI:  https://codecanyon.net/user/roninwp?ref=roninwp
Domain Path: /languages
Text Domain: fat-editor-addon
*/

if (!defined('ABSPATH')) die('-1');

defined('FAT_EDITOR_ADDON_PLUGIN_URL') or define('FAT_EDITOR_ADDON_PLUGIN_URL', plugins_url());
defined('FAT_EDITOR_ADDON_ASSET_JS_URL') or define('FAT_EDITOR_ADDON_ASSET_JS_URL', plugins_url() . '/fat-editor-addon/assets/js/');
defined('FAT_EDITOR_ADDON_ASSET_CSS_URL') or define('FAT_EDITOR_ADDON_ASSET_CSS_URL', plugins_url() . '/fat-editor-addon/assets/css/');
defined('FAT_EDITOR_ADDON_DIR_PATH') or define('FAT_EDITOR_ADDON_DIR_PATH', plugin_dir_path(__FILE__));

if (!class_exists('Fat_Editor_AddOn')) {
    class Fat_Editor_AddOn
    {
        function __construct()
        {
            add_action('init', array($this, 'shortcode_button_init'));
            add_shortcode('fat_video_embed', array($this, 'fat_video_embed_shortcode'));
            add_shortcode('fat_twitter', array($this, 'fat_twitter_shortcode'));
            add_shortcode('fat_highlight', array($this, 'fat_highlight_shortcode'));
            add_shortcode('fat_image', array($this, 'fat_image_shortcode'));
            add_action('wp_footer', array($this, 'generate_css'));

            add_filter('wp_link_pages', array($this, 'add_social_share_after_post_content'), 10, 2);

            if (is_admin()) {
                add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'), 0);
                add_action('edit_form_after_editor', array($this, 'include_template'));
                add_action("wp_ajax_get_attachment_info", array($this, 'get_attachment_info'));
            }


        }

        function include_template()
        {
            $field_tpml = FAT_EDITOR_ADDON_DIR_PATH . 'templates/field-tpml.php';
            if (file_exists($field_tpml)) {
                include_once $field_tpml;
            }
        }

        function shortcode_button_init()
        {
            if (!current_user_can('edit_posts') && !current_user_can('edit_pages') && get_user_option('rich_editing') == 'true')
                return;

            //Add a callback to regiser our tinymce plugin
            add_filter('mce_external_plugins', array($this, 'register_tinymce_plugin'));

            // Add a callback to add our button to the TinyMCE toolbar
            add_filter('mce_buttons', array($this, 'add_tinymce_button'));
        }

        function register_tinymce_plugin($plugin_array)
        {
            $plugin_array['fat_sc_video_button'] = plugins_url('/assets/js/sc_button.min.js', __FILE__);
            $plugin_array['fat_sc_twitter_button'] = plugins_url('/assets/js/sc_button.min.js', __FILE__);
            $plugin_array['fat_sc_highlight_button'] = plugins_url('/assets/js/sc_button.min.js', __FILE__);
            $plugin_array['fat_sc_image_button'] = plugins_url('/assets/js/sc_button.min.js', __FILE__);
            return $plugin_array;
        }

        //This callback adds our button to the toolbar
        function add_tinymce_button($buttons)
        {
            //Add the button ID to the $button array
            $buttons[] = "fat_sc_video_button";
            $buttons[] = "fat_sc_twitter_button";
            $buttons[] = "fat_sc_highlight_button";
            $buttons[] = "fat_sc_image_button";
            return $buttons;
        }

        function admin_enqueue_scripts()
        {
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_script('wp-color-picker');
            wp_enqueue_script('wp-color-picker-alpha', plugins_url('/assets/js/color-picker/wp-color-picker-alpha.js', __FILE__), array('wp-color-picker'), '1.0', true);

            wp_enqueue_style('fat-sc-fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), '4.7.0');

            wp_enqueue_style('fat-sc-button', plugins_url('/assets/css/sc.css', __FILE__), false);

            wp_register_script('fat-sc-utils', plugins_url('/assets/js/sc_utils.js', __FILE__), array('jquery'), false, true);
            wp_localize_script('fat-sc-utils', 'ajax', array('url' => admin_url('admin-ajax.php')));
            wp_enqueue_script('fat-sc-utils');
        }

        function fat_video_embed_shortcode($atts)
        {
            $atts = shortcode_atts(array(
                'video_type'        => 'youtube',
                'video_id'          => '',
                'dimension'         => 'width',
                'dimension_value'   => '',
                'video_position'    => 'text-center',
                'enable_video_icon' => '0',
                'autoplay'          => '0',
                'allow_full_screen' => '0',
                'showinfo'          => '0',
                'showcontrol'       => '1'
            ), $atts, 'fat_video_embed');

            wp_enqueue_style('fat-sc-button', plugins_url('/assets/css/sc-video.css', __FILE__), false);
            wp_enqueue_script('vimeo-player', plugins_url('/assets/js/vimeo-player.min.js', __FILE__), array('jquery'), false, true);
            wp_enqueue_script('youtube-player', 'https://www.youtube.com/iframe_api', array('jquery'), false, true);
            wp_enqueue_script('fat-sc-video', plugins_url('/assets/js/sc_video.js', __FILE__), array('jquery'), false, true);

            ob_start();
            $template = FAT_EDITOR_ADDON_DIR_PATH . 'templates/video-embed.php';
            if (file_exists($template)) {
                include $template;
            }
            $ret = ob_get_contents();
            ob_end_clean();
            return $ret;

        }

        function fat_twitter_shortcode($atts)
        {
            $atts = shortcode_atts(array(
                'content'               => '',
                'link'                  => '',
                'icon_font_size'        => '14',
                'text_color'            => '',
                'text_hover_color'      => '',
                'underline_hover_color' => '',
                'underline_hover_width' => ''
            ), $atts, 'fat_twitter');
            $content = isset($atts['content']) && $atts['content'] !== '' ? $atts['content'] : get_the_title();
            $link = isset($atts['link']) && $atts['link'] !== '' ? $atts['link'] : get_permalink();
            $icon_font_size = isset($atts['icon_font_size']) ? $atts['icon_font_size'] : 14;
            $text_color = isset($atts['text_color']) && $atts['text_color'] !== '' ? $atts['text_color'] : '';
            $text_hover_color = isset($atts['text_hover_color']) && $atts['text_hover_color'] !== '' ? $atts['text_hover_color'] : '';
            $underline_hover_width = isset($atts['underline_hover_width']) && $atts['underline_hover_width'] !== '' ? $atts['underline_hover_width'] : '';
            $underline_hover_color = isset($atts['underline_hover_color']) && $atts['underline_hover_color'] !== '' ? $atts['underline_hover_color'] : '';

            wp_enqueue_style('fat-sc-twitter-highlight', plugins_url('/assets/css/sc-twitter-highlight.css', __FILE__), false);
            wp_enqueue_style('fat-font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', false);
            wp_enqueue_script('fat-sc-twitter', plugins_url('/assets/js/sc_twitter.js', __FILE__), array('jquery'), false, true);

            global $fat_video_css;

            do {
                $id = uniqid();
            } while ($fat_video_css != null && array_key_exists($id, $fat_video_css));

            $fat_video_css[$id] = array(
                'text_color'            => $text_color,
                'text_hover_color'      => $text_hover_color,
                'underline_width'       => $underline_hover_width,
                'underline_hover_color' => $underline_hover_color
            );
            ob_start();
            $ret = sprintf('<a class="fat-twitter" id="fat_hightligh_%s" href="javascript:void(0);" data-content="%s" data-link="%s" >%s <span style="font-size:%spx"><i class="fa fa-twitter"></i></span></a>', $id, $content, $link, $content, $icon_font_size);
            ob_end_clean();
            return $ret;
        }

        function fat_image_shortcode($atts)
        {
            $atts = shortcode_atts(array(
                'title'        => '',
                'link'         => '',
                'img_size'     => 'full',
                'img_id'       => '',
                'img_position' => 'text-left',
            ), $atts, 'fat_image');

            if (isset($atts['img_id']) && $atts['img_id'] !== '') {
                wp_enqueue_style('fat-sc-twitter-highlight', plugins_url('/assets/css/sc-twitter-highlight.css', __FILE__), false);
                wp_enqueue_style('fat-font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', false);
                wp_enqueue_script('fat-sc-twitter', plugins_url('/assets/js/sc_twitter.js', __FILE__), array('jquery'), false, true);

                $title = isset($atts['title']) && $atts['title'] !== '' ? $atts['title'] : get_the_title();
                $link = isset($atts['link']) && $atts['link'] !== '' ? $atts['link'] : get_permalink();
                $img = wp_get_attachment_image_url($atts['img_id'], $atts['img_size']);
                $img_full = wp_get_attachment_image_url($atts['img_id'], 'full');
                ob_start();
                $ret = sprintf('<div class="fat-image %s"><div class="fat-image-inner"><img src="%s" /><a class="fat-pinterest" data-title="%s" data-link="%s" data-img="%s" href="javascript:void(0);"><i class="fa fa-pinterest"></i></a></div></div>', $atts['img_position'], $img, $title, $link, $img_full);
                ob_end_clean();
                return $ret;
            }
        }

        function fat_highlight_shortcode($atts)
        {
            $atts = shortcode_atts(array(
                'content'                => '',
                'link'                   => '',
                'open_type'              => '',
                'font_style'             => 'normal',
                'text_color'             => '',
                'underline_color'        => '',
                'underline_width'        => '2',
                'background_color'       => '',
                'font_style_hover'       => 'normal',
                'text_hover_color'       => '',
                'underline_hover_color'  => '',
                'background_hover_color' => '',
            ), $atts, 'fat_highlight');

            wp_enqueue_style('fat-sc-twitter-highlight', plugins_url('/assets/css/sc-twitter-highlight.css', __FILE__), false);

            $content = isset($atts['content']) ? $atts['content'] : '';
            $link = isset($atts['link']) && $atts['link'] !== '' ? $atts['link'] : 'javascript:void(0);';
            $open_type = isset($atts['open_type']) && $atts['open_type'] !== '' ? $atts['open_type'] : '_self';
            $font_style = isset($atts['font_style']) && $atts['font_style'] !== '' ? $atts['font_style'] : 'normal';
            $text_color = isset($atts['text_color']) && $atts['text_color'] !== '' ? $atts['text_color'] : '';
            $underline_color = isset($atts['underline_color']) && $atts['underline_color'] !== '' ? $atts['underline_color'] : '';
            $underline_width = isset($atts['underline_width']) && $atts['underline_width'] !== '' ? $atts['underline_width'] : '2';
            $background_color = isset($atts['background_color']) && $atts['background_color'] !== '' ? $atts['background_color'] : '';
            $font_style_hover = isset($atts['font_style_hover']) && $atts['font_style_hover'] !== '' ? $atts['font_style_hover'] : 'normal';
            $text_hover_color = isset($atts['text_hover_color']) && $atts['text_hover_color'] !== '' ? $atts['text_hover_color'] : '';
            $underline_hover_color = isset($atts['underline_hover_color']) && $atts['underline_hover_color'] !== '' ? $atts['underline_hover_color'] : '';
            $background_hover_color = isset($atts['background_hover_color']) && $atts['background_hover_color'] !== '' ? $atts['background_hover_color'] : '';

            global $fat_video_css;
            do {
                $id = uniqid();
            } while ($fat_video_css != null && array_key_exists($id, $fat_video_css));

            $fat_video_css[$id] = array(
                'font_style'             => $font_style,
                'text_color'             => $text_color,
                'underline_color'        => $underline_color,
                'underline_width'        => $underline_width,
                'background_color'       => $background_color,
                'font_style_hover'       => $font_style_hover,
                'text_hover_color'       => $text_hover_color,
                'underline_hover_color'  => $underline_hover_color,
                'background_hover_color' => $background_hover_color
            );
            ob_start();
            $ret = sprintf('<a class="fat-highlight" id="fat_hightligh_%s" href="%s" target="%s">%s</a>', $id, $link, $open_type, $content);
            ob_end_clean();
            return $ret;
        }

        function generate_css()
        {
            global $fat_video_css;
            if(!isset($fat_video_css) || !is_array($fat_video_css)){
                return;
            }
            $output_css = '<style type="text/css">';
            foreach ($fat_video_css as $id => $css) {
                $underline_color = $underline_width = '';
                $output_css .= 'a#fat_hightligh_' . $id . '{';
                foreach ($css as $css_key => $css_value) {
                    if ($css_key === 'font_style' && $css_value !== '') {
                        $output_css .= 'font-style:' . $css_value . ';';
                    }
                    if ($css_key === 'text_color' && $css_value !== '') {
                        $output_css .= 'color:' . $css_value . ' !important;';
                    }
                    if ($css_key === 'underline_color' && $css_value !== '') {
                        $underline_color = $css_value;
                    }
                    if ($css_key === 'underline_width' && $css_value !== '') {
                        $underline_width = $css_value;
                    }
                    if ($css_key === 'background_color' && $css_value !== '') {
                        $output_css .= 'background-color: ' . $css_value . ' !important;';
                    }
                }

                if ($underline_color !== '' && $underline_width !== '') {
                    $output_css .= 'box-shadow: inset 0 -' . $underline_width . 'px 0 ' . $underline_color . ' !important;';
                }
                $output_css .= '}';

                $output_css .= 'a#fat_hightligh_' . $id . ':hover{';
                $underline_color = $underline_width = '';
                foreach ($css as $css_key => $css_value) {
                    if ($css_key === 'font_style_hover' && $css_value !== '') {
                        $output_css .= 'font-style:' . $css_value . ';';
                    }
                    if ($css_key === 'text_hover_color' && $css_value !== '') {
                        $output_css .= 'color:' . $css_value . ' !important;';
                    }
                    if ($css_key === 'underline_hover_color' && $css_value !== '') {
                        $underline_color = $css_value;
                    }
                    if ($css_key === 'underline_width' && $css_value !== '') {
                        $underline_width = $css_value;
                    }
                    if ($css_key === 'background_hover_color' && $css_value !== '') {
                        $output_css .= 'background-color: ' . $css_value . ' !important;';
                    }

                }
                if ($underline_color !== '' && $underline_width !== '') {
                    $output_css .= 'box-shadow: inset 0 -' . $underline_width . 'px 0 ' . $underline_color . ' !important;';
                }
                $output_css .= '}';
            }
            $output_css .= '</style>';
            echo sprintf('%s', $output_css);
        }

        function add_social_share_after_post_content($output, $args)
        {
            if (is_singular('post')) {
                ob_start();
                $social_share = FAT_EDITOR_ADDON_DIR_PATH . 'templates/social-share.php';
                if (file_exists($social_share)) {
                    include $social_share;
                }
                $output = ob_get_contents() . $output;
                ob_end_clean();
                return $output;
            }
        }

        function get_attachment_info()
        {
            $ids = $_POST['ids'];
            $args = array(
                'post_type'      => 'attachment',
                'post__in'       => explode(',', $ids),
                'orderby'        => 'post__in',
                'posts_per_page' => '-1',
                'post_status'    => 'inherit'
            );
            $attachments = new WP_Query($args);
            $attach_info = array();
            $url = '';
            global $post;
            while ($attachments->have_posts()) : $attachments->the_post();
                $url = wp_get_attachment_image_url($post->ID, 'thumbnail');
                $attach_info[] = array(
                    'id'  => $post->ID,
                    'url' => $url
                );
            endwhile;
            wp_reset_postdata();
            echo json_encode($attach_info);
            wp_die();
        }
    }

    new Fat_Editor_AddOn();
}

<?php
/**
 * Plugin Name: Custom Video.js Player
 * Plugin URI: https://github.com/Shubham2D/Custom-Video.js-Player-WP
 * Description: A simple WordPress plugin to embed a Video.js player with a shor
tcode.
 * Version: 1.0.0
 * Author: Shubham Sawarkar
 * Author URI: https://github.com/Shubham2D
 * License: GPL-2.0-or-later
 */

// Prevent direct access
if (!defined('ABSPATH')) exit;

// Enqueue Video.js assets
function cvjp_enqueue_scripts() {
    wp_enqueue_style('videojs-css', 'https://vjs.zencdn.net/8.21.1/video-js.css')
;
    wp_enqueue_script('videojs-js', 'https://vjs.zencdn.net/8.21.1/video.min.js',
 array(), null, true);
}
add_action('wp_enqueue_scripts', 'cvjp_enqueue_scripts');

// Shortcode to display Video.js player
function cvjp_video_shortcode($atts) {
    $atts = shortcode_atts([
        'mp4' => '',
        'webm' => '',
        'width' => 'auto',
        'height' => 'auto'
    ], $atts, 'custom_videojs_player');

    if (empty($atts['mp4']) && empty($atts['webm'])) {
        return '<p style="color: red;">Error: No video source provided.</p>';
    }

    ob_start();
    ?>
    <div class="video-container" style="max-width: <?php echo esc_attr($atts['wi
dth']); ?>px; margin: auto;">
        <video class="video-js vjs-default-skin" controls preload="auto" data-se
tup='{"fluid": true, "controlBar": { "pictureInPictureToggle": true }}'>
            <?php if (!empty($atts['mp4'])): ?>
                <source src="<?php echo esc_url($atts['mp4']); ?>" type="video/m
p4">
            <?php endif; ?>
            <?php if (!empty($atts['webm'])): ?>
                <source src="<?php echo esc_url($atts['webm']); ?>" type="video/
webm">
            <?php endif; ?>
            Your browser does not support the video tag.
        </video>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('custom_videojs_player', 'cvjp_video_shortcode');

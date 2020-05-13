<?php
/**
 * Template Name: video
 */
?>
<?php get_header('else'); ?>
    <div class="alex-video-wrapper">
        <h2 class="present_vid_header">Немного О Себе ...</h2>
        <div id="move_to_popup" >
            <?php
                echo wp_video_shortcode([
                    'src' => wp_get_attachment_url( (int) get_theme_mod('custom_video')),
                    'poster' => '',
                    'autoplay' => 'on',
                    'preload'  => 'metadata',
                    //'height'   => 490,
                    //'width'    => 890,
                ]);
            ?>
        </div>
    </div>
<?php get_footer();
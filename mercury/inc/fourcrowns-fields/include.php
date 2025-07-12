<?php
add_action( 'wp_enqueue_scripts', 'four_crowns_enqueue_styles', 20 );

function four_crowns_enqueue_styles()
{
    // Swipper slider
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), null, true);

    // Custom css + js
    wp_enqueue_style('custom_theme_css', get_theme_file_uri(FOUR_CROWNS_ASSETS . '/css/custom-style.css'), [], '2025-07-12-2');
    wp_enqueue_script('custom_scripts_js', get_theme_file_uri(FOUR_CROWNS_ASSETS . '/js/custom-scripts.js'), [], '2025-06-27', true);

    // Honeypot
    wp_enqueue_script('honeypot-js', get_theme_file_uri(FOUR_CROWNS_ASSETS . '/js/honey.js'), [], '2025-05-06', true);
}
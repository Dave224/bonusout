<?php
class Fourcrowns_Core {
    public static function init() {
        add_action('admin_enqueue_scripts', [__CLASS__, 'load_assets']);
        Fourcrowns_Fields::init();
    }

    public static function load_assets() {
        wp_enqueue_style('fourcrowns-fields', get_template_directory_uri() . '/inc/fourcrowns-fields/assets/admin/admin.css', []);
        wp_enqueue_script('fourcrowns-admin-js', get_template_directory_uri() . '/inc/fourcrowns-fields/assets/admin/admin.js', ['jquery'], null, true);

        wp_enqueue_script('fourcrowns-sortable', 'https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js', [], null, true);

        wp_enqueue_style('fontawesome-css', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css');

        wp_enqueue_style('choices-css', 'https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css');
        wp_enqueue_script('choices-js', 'https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js', [], null, true);

        wp_enqueue_style('trumbowyg-css', 'https://cdn.jsdelivr.net/npm/trumbowyg@2.28.0/dist/ui/trumbowyg.min.css');
        wp_enqueue_script('trumbowyg-js', 'https://cdn.jsdelivr.net/npm/trumbowyg@2.28.0/dist/trumbowyg.min.js', ['jquery'], null, true);

        wp_enqueue_style('flatpickr-css', 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css');
        wp_enqueue_script('flatpickr-js', 'https://cdn.jsdelivr.net/npm/flatpickr', [], null, true);

        wp_enqueue_media();
    }
}

<?php
class Fourcrowns_Storage {
    public static function get($context, $object_id, $key) {
        switch ($context) {
            case 'post':
                return get_post_meta($object_id, $key, true);
            case 'term':
                return get_term_meta($object_id, $key, true);
            case 'option':
                return get_option($key, '');
            default:
                return '';
        }
    }

    public static function update($context, $object_id, $key, $value) {
        switch ($context) {
            case 'post':
                update_post_meta($object_id, $key, $value);
                break;
            case 'term':
                update_term_meta($object_id, $key, $value);
                break;
            case 'option':
                update_option($key, $value);
                break;
        }
    }
}

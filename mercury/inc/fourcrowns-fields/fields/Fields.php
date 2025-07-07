<?php
class Fourcrowns_Fields {
    private static $boxes = [];
    public static function init() {
        add_action('add_meta_boxes', [__CLASS__, 'register_post_metaboxes']);
        add_action('save_post', [__CLASS__, 'save_post_data']);
        add_action('edit_term', [__CLASS__, 'save_term_data'], 10, 3);
        add_action('admin_init', [__CLASS__, 'option_save_handler']);
    }

    public static function add_metabox($id, $args) {
        self::$boxes[$id] = $args;
    }

    public static function register_post_metaboxes() {
        foreach (self::$boxes as $id => $args) {
            if ($args['context'] !== 'post') continue;
            add_meta_box(
                $id,
                $args['title'],
                function($post) use ($id, $args) {
                    echo '<div class="fourcrowns-field-wrapper">';
                    wp_nonce_field('fourcrowns_save_' . $id, '_fourcrowns_nonce_' . $id);
                    foreach ($args['fields'] as $field) {
                        $value = Fourcrowns_Storage::get('post', $post->ID, $field['name']);
                        $obj = Fourcrowns_FieldFactory::create($field, $value);
                        if ($obj) $obj->render();
                    }
                    echo '</div>';
                },
                $args['post_type'],
                'normal',
                'default'
            );
        }
    }

    public static function save_post_data($post_id) {
        foreach (self::$boxes as $id => $args) {
            if ($args['context'] !== 'post') continue;
            if (!isset($_POST['_fourcrowns_nonce_' . $id]) || !wp_verify_nonce($_POST['_fourcrowns_nonce_' . $id], 'fourcrowns_save_' . $id)) continue;
            foreach ($args['fields'] as $field) {
                $name = $field['name'];
                $val = $_POST[$name] ?? null;
                $obj = Fourcrowns_FieldFactory::create($field, $val);
                if ($obj) {
                    $sanitized = $obj->sanitize($val);
                    Fourcrowns_Storage::update('post', $post_id, $name, $sanitized);
                }
            }
        }
    }

    public static function save_term_data($term_id, $tt_id, $taxonomy) {
        foreach (self::$boxes as $id => $args) {
            if ($args['context'] !== 'term') continue;
            foreach ($args['fields'] as $field) {
                $name = $field['name'];
                $val = $_POST[$name] ?? null;
                $obj = Fourcrowns_FieldFactory::create($field, $val);
                if ($obj) {
                    $sanitized = $obj->sanitize($val);
                    Fourcrowns_Storage::update('term', $term_id, $name, $sanitized);
                }
            }
        }
    }

    public static function option_save_handler() {
        if (!isset($_POST['_fourcrowns_options_save'])) return;

        foreach (self::$boxes as $id => $args) {
            if ($args['context'] !== 'option') continue;
            foreach ($args['fields'] as $field) {
                $name = $field['name'];
                $val = $_POST[$name] ?? null;
                $obj = Fourcrowns_FieldFactory::create($field, $val);
                var_dump($name);
                var_dump($val);
                if ($obj) {
                    if ($field['type'] == 'textarea') {
                        Fourcrowns_Storage::update('option', null, $name, stripslashes($val));
                    } else {
                        $sanitized = $obj->sanitize($val);
                        Fourcrowns_Storage::update('option', null, $name, $sanitized);
                    }

                }
            }
        }
    }
}

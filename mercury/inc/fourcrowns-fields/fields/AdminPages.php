<?php
class Fourcrowns_AdminPages {
    public static function render_option_page($slug, $title = '', $submit_label = 'Uložit') {
        echo '<div class="wrap">';
        if ($title) echo "<h1>{$title}</h1>";

        echo '<form method="post" class="fourcrowns-form">';
        echo '<input type="hidden" name="_fourcrowns_options_save" value="1">';

        $reflection = new ReflectionClass('Fourcrowns_Fields');
        $property = $reflection->getProperty('boxes');
        $property->setAccessible(true);
        $boxes = $property->getValue();

        foreach ($boxes as $id => $args) {
            if ($args['context'] === 'option' && $id === $slug) {
                echo '<div class="fourcrowns-field-wrapper">';
                foreach ($args['fields'] as $field) {
                    $value = Fourcrowns_Storage::get('option', null, $field['name']);
                    $obj = Fourcrowns_FieldFactory::create($field, $value);
                    if ($obj) $obj->render();
                }
                echo '</div>';
            }
        }

        submit_button($submit_label);
        echo '</form></div>';
    }

    public static function render_term_fields($taxonomy) {
        add_action("{$taxonomy}_edit_form_fields", function($term) use ($taxonomy) {
            $reflection = new ReflectionClass('Fourcrowns_Fields');
            $property = $reflection->getProperty('boxes');
            $property->setAccessible(true);
            $boxes = $property->getValue();

            foreach ($boxes as $id => $args) {
                if ($args['context'] === 'term') {
                    echo '<tr class="form-field">';
                    echo '<td colspan="2">';
                    if ($args['title']) echo "<h2>{$args['title']}</h2>";
                    echo '<div class="fourcrowns-field-wrapper">';
                    foreach ($args['fields'] as $field) {
                        $value = Fourcrowns_Storage::get('term', $term->term_id, $field['name']);
                        $obj = Fourcrowns_FieldFactory::create($field, $value);
                        if ($obj) $obj->render();
                    }
                    echo '</div>';
                    echo '</td></tr>';
                }
            }
        }, 10, 1);
    }
}

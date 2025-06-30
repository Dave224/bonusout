<?php
class Fourcrowns_Field_WPEditor extends Fourcrowns_Field_Base {
    public function render() {
        $name = $this->field['name'];
        $label = $this->field['label'] ?? '';
        echo "<label for='{$name}'>{$label}</label>";
        wp_editor($this->value, $name, ['textarea_name' => $name]);
    }

    public function sanitize($value) {
        return wp_kses_post($value);
    }
}

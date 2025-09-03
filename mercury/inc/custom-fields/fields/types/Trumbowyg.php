<?php
class Fourcrowns_Field_Trumbowyg extends Fourcrowns_Field_Base {
    public function render() {
        $name = $this->field['name'];
        $label = $this->field['label'] ?? '';
        $value = $this->value ?? '';

        echo "<label for='{$name}'>{$label}</label><br>";
        echo "<textarea name='{$name}' class='fourcrowns-trumbowyg' style='width:100%; max-width:700px; min-height:150px;'>"
            . esc_textarea($value) . "</textarea>";
    }

    public function sanitize($value) {
        return wp_kses_post($value); // nebo strip_tags($value) pokud chceš čistý text
    }
}

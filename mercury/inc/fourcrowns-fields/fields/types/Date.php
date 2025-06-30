<?php
class Fourcrowns_Field_Date extends Fourcrowns_Field_Base {
    public function render() {
        $name = $this->field['name'];
        $label = $this->field['label'] ?: '';
        $value = $this->value ?: '';

        echo "<div class='date-wrapper'>";
        echo "<label for='{$name}'>{$label}</label>";
        echo "<input type='text' name='{$name}' value='" . esc_attr($value) . "' class='fourcrowns-date' style='max-width: 300px;'>";
        echo "</div>";
    }

    public function sanitize($value) {
        return sanitize_text_field($value);
    }
}
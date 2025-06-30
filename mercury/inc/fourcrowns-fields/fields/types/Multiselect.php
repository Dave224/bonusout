<?php
class Fourcrowns_Field_Multiselect extends Fourcrowns_Field_Base {
    public function render() {
        $name = $this->field['name'];
        $label = $this->field['label'] ?? '';
        $options = $this->field['options'] ?? [];
        $selected = is_array($this->value) ? $this->value : [];

        echo "<div>";
        echo "<label for='{$name}'>{$label}</label>";
        echo "<select name='{$name}[]' id='{$name}' multiple class='fourcrowns-multiselect' style='width: 100%; max-width: 400px;'>";
        foreach ($options as $key => $option_label) {
            $isSelected = in_array($key, $selected) ? 'selected' : '';
            echo "<option value='" . esc_attr($key) . "' {$isSelected}>" . esc_html($option_label) . "</option>";
        }
        echo "</select>";
        echo "</div>";
    }

    public function sanitize($value) {
        return is_array($value) ? array_map('sanitize_text_field', $value) : [];
    }
}

<?php
class Fourcrowns_Field_Number extends Fourcrowns_Field_Base {
    public function render() {
        $name = $this->field['name'];
        $label = $this->field['label'] ?: '';
        $value = $this->value ?: '';
        $min = isset($this->field['min']) ? "min='" . esc_attr($this->field['min']) . "'" : '';
        $max = isset($this->field['max']) ? "max='" . esc_attr($this->field['max']) . "'" : '';
        $step = isset($this->field['step']) ? "step='" . esc_attr($this->field['step']) . "'" : '';

        echo "<div class='number-wrapper'>";
        echo "<label for='{$name}'>{$label}</label>";
        echo "<input type='number' name='{$name}' value='" . esc_attr($value) . "' {$min} {$max} {$step} style='max-width: 150px;'>";
        echo "</div>";
    }

    public function sanitize($value) {
        return is_numeric($value) ? $value : null;
    }
}
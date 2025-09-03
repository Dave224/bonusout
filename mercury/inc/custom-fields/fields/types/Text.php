<?php
class Fourcrowns_Field_Text extends Fourcrowns_Field_Base {
    public function render() {
        $name = $this->field['name'];
        $label = $this->field['label'] ?? '';
        echo "<label for='{$name}'>{$label}</label>";
        echo "<input type='text' name='{$name}' value='" . esc_attr($this->value) . "'>";
    }
}

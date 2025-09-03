<?php
class Fourcrowns_Field_Textarea extends Fourcrowns_Field_Base {
    public function render() {
        $name = $this->field['name'];
        $label = $this->field['label'] ?? '';
        echo "<label for='{$name}'>{$label}</label>";
        echo "<textarea rows='20' name='{$name}'>" . esc_textarea($this->value) . "</textarea>";
    }
}

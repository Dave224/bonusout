<?php
class Fourcrowns_Field_Select extends Fourcrowns_Field_Base {
    public function render() {
        $name = $this->field['name'];
        $label = $this->field['label'] ?? '';
        $options = $this->field['options'] ?? [];

        echo "<label for='{$name}'>{$label}</label>";
        echo "<select name='{$name}'>";
        foreach ($options as $key => $option) {
            $selected = ($this->value == $key) ? 'selected' : '';
            echo "<option value='{$key}' {$selected}>{$option}</option>";
        }
        echo "</select>";
    }
}

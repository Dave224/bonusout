<?php
class Fourcrowns_Field_Checkbox extends Fourcrowns_Field_Base {
    public function render() {
        $name = $this->field['name'];
        $label = $this->field['label'] ?? '';
        $checked = $this->value !== 'disabled' ? 'checked' : '';

        echo "<div class='fourcrowns-toggle-wrapper'>";
        if ($label) {
            echo "<span class='fourcrowns-toggle-description'>{$label}</span>";
        }
        echo "<label class='fourcrowns-toggle-label'>";

        echo "<input type='checkbox' name='{$name}' value='1' {$checked} class='fourcrowns-toggle'>";
        echo "<span class='fourcrowns-toggle-slider'><span class='toggle-text'></span></span>";
        echo "</label>";
        echo "</div>";
    }

    public function sanitize($value) {
        return $value === '1' ? 1 : 'disabled';
    }
}

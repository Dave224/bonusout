<?php
abstract class Fourcrowns_Field_Base {
    protected $field;
    protected $value;

    public function __construct($field, $value) {
        $this->field = $field;
        $this->value = $value;
    }

    abstract public function render();
    public function sanitize($value) {
        return sanitize_text_field($value);
    }
}

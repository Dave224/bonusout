<?php
class Fourcrowns_FieldFactory {
    public static function create($field, $value) {
        $type = ucfirst($field['type']);
        $class = 'Fourcrowns_Field_' . $type;
        if (class_exists($class)) {
            return new $class($field, $value);
        }
        return null;
    }
}

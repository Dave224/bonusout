<?php
class Fourcrowns_Field_Repeater extends Fourcrowns_Field_Base {
    public function render() {
        $name = $this->field['name'];
        $label = $this->field['label'] ?? '';
        $fields = $this->field['fields'] ?? [];
        $max = isset($this->field['max']) ? (int) $this->field['max'] : 0;

        $items = is_array($this->value) && !empty($this->value) ? $this->value : [ [] ];

        echo "<label>{$label}</label>";
        echo "<div class='fourcrowns-repeater' data-name='{$name}'" . ($max ? " data-max='{$max}'" : "") . ">";

        foreach ($items as $i => $item) {
            echo "<div class='fourcrowns-repeater-item' style='border: 1px solid #ccc; padding: 12px 12px 60px 12px; margin-bottom: 10px; background: #f9f9f9; position: relative;'>";
            echo "<div class='fourcrowns-drag-handle' style='cursor: move; position: absolute; top: 10px; right: 10px; font-size: 18px;'>☰</div>";
            foreach ($fields as $subfield) {
                $sub_name = "{$name}[{$i}][" . $subfield['name'] . "]";
                $sub_val = $item[$subfield['name']] ?? '';
                $obj = Fourcrowns_FieldFactory::create(array_merge($subfield, ['name' => $sub_name]), $sub_val);
                if ($obj) $obj->render();
            }
            echo "<button type='button' class='fourcrowns-repeater-remove'>Odebrat  <i class='fa fa-minus'></i></button>";
            echo "</div>";
        }

        echo "<button type='button' class='fourcrowns-repeater-add'><i class='fa-solid fa-plus'></i>  Přidat</button>";
        echo "</div>";

    }

    public function sanitize($value) {
        if (!is_array($value)) return [];

        $fields = $this->field['fields'] ?? [];

        return array_map(function($row) use ($fields) {
            $sanitized_row = [];

            foreach ($fields as $field) {
                $name = $field['name'];
                $val = $row[$name] ?? null;
                $field_obj = Fourcrowns_FieldFactory::create($field, $val);

                if ($field_obj) {
                    $sanitized_row[$name] = $field_obj->sanitize($val);
                }
            }

            return $sanitized_row;
        }, $value);
    }
}

<?php
class Fourcrowns_Field_Gallery extends Fourcrowns_Field_Base {
    public function render() {
        $name = $this->field['name'];
        $label = $this->field['label'] ?? '';
        $ids = is_array($this->value) ? $this->value : explode(',', $this->value);

        echo "<label>{$label}</label>";
        echo "<div class='fourcrowns-gallery-wrapper'>";
        echo "<input type='hidden' name='{$name}' value='" . esc_attr(implode(',', $ids)) . "' class='fourcrowns-gallery-field'>";
        echo "<div class='fourcrowns-gallery-preview' style='margin: 8px 0; display: flex; gap: 8px; flex-wrap: wrap;'>";
        foreach ($ids as $id) {
            if ($id && is_numeric($id)) {
                $thumb = wp_get_attachment_image($id, 'thumbnail');
                echo "<span>{$thumb}</span>";
            }
        }
        echo "</div>";
        echo "<button type='button' class='button fourcrowns-gallery-button' data-target='{$name}'>Vybrat obrázky</button>";
        echo "</div>";
    }

    public function sanitize($value) {
        $ids = is_array($value) ? $value : explode(',', $value);
        return array_filter(array_map('intval', $ids));
    }
}

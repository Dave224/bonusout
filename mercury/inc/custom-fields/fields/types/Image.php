<?php
class Fourcrowns_Field_Image extends Fourcrowns_Field_Base {
    public function render() {
        $name = $this->field['name'];
        $label = $this->field['label'] ?? '';
        $value = $this->value;

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $value = $decoded;
            } else {
                // fallback – může to být legacy URL string
                $value = ['url' => $value];
            }
        }

        $id = $value['id'] ?? '';
        $url = $value['url'] ?? '';

        if (!$url && $id) {
            $url = wp_get_attachment_url($id);
        }

        echo "<label>{$label}</label>";
        echo "<div class='fourcrowns-image-wrapper'>";
        echo "<input type='hidden' name='{$name}' value='" . esc_attr(json_encode(['id' => $id, 'url' => $url])) . "' class='fourcrowns-image-field' data-target='{$name}'>";
        echo "<div class='fourcrowns-image-preview'>";
        if ($url) {
            echo "<img src='" . esc_attr($url) . "' style='max-height: 60px; display:block; margin-top:5px;' class='preview-img' />";
        }
        echo "</div>";
        echo "<button type='button' class='button fourcrowns-upload-button' data-target='{$name}'>Vybrat obrázek</button>";
        // Nový textový input pro URL
        echo "<input type='text' class='fourcrowns-image-url-input' placeholder='Zadejte URL obrázku' value='" . esc_attr($url) . "' style='margin-top:10px; width: 100%;' data-target='{$name}'>";

        echo "</div>";
    }


    public function sanitize($value) {
        $value = stripslashes($value);
        $decoded = json_decode($value, true);

        if (is_array($decoded) && isset($decoded['id']) && isset($decoded['url'])) {
            return [
                'id' => (int)$decoded['id'],
                'url' => esc_url_raw($decoded['url'])
            ];
        }

        // fallback pro starší data (prostý string s URL)
        if (is_string($value)) {
            return [
                'id' => 0,
                'url' => esc_url_raw($value)
            ];
        }

        return null;
    }
}

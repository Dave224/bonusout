<?php

// Přidání vlastních polí na stránku pro úpravu kategorie
add_action('edit_category_form_fields', 'custom_category_edit_fields');
function custom_category_edit_fields($term) {
// Získání hodnot pro obrázky
    $image_ids = [];
    for ($i = 1; $i <= 6; $i++) {
        $image_ids[$i] = get_term_meta($term->term_id, '_category_image_' . $i, true);
    }

    // Získání hodnot pro textová pole
    $text_values = [];
    for ($i = 1; $i <= 6; $i++) {
        $text_values[$i] = get_term_meta($term->term_id, '_category_text_' . $i, true);
    }

    // Získání hodnot pro textová pole
    $url_values = [];
    for ($i = 1; $i <= 6; $i++) {
        $url_values[$i] = get_term_meta($term->term_id, '_category_url_' . $i, true);
    }
    ?>
    <?php
    // Vykreslení polí pro obrázky a textové inputy
    for ($i = 1; $i <= 6; $i++) {
        $image_url = $image_ids[$i] ? wp_get_attachment_url($image_ids[$i]) : '';
        $text_value = esc_attr($text_values[$i]);
        $url_value = esc_attr($url_values[$i]); ?>
        <tr class="form-field term-group">
            <td>
                <h2><?php echo sprintf(__('Top brand %d', 'SLOTH'), $i); ?></h2>
            </td>
        </tr>
        <tr class="form-field term-group">
            <th scope="row">
                <label for="category_image_<?php echo $i; ?>"><?php echo sprintf(__('%d . obrázek', 'SLOTH'), $i); ?></label>
            </th>
            <td>
                <input type="text" name="category_image_<?php echo $i; ?>" id="category_image_<?php echo $i; ?>" value="<?php echo $image_url; ?>" style="width: 80%;" />
                <button type="button" class="button" id="upload_category_image_button_<?php echo $i; ?>"><?php _e('Vybrat obrázek', 'SLOTH'); ?></button>
                <div id="category_image_preview_<?php echo $i; ?>" style="margin-top: 10px;">
                    <?php if ($image_url) : ?>
                        <img src="<?php echo esc_url($image_url); ?>" style="max-width: 100px; max-height: 100px; display: block;" />
                    <?php endif; ?>
                </div>
            </td>
        </tr>

        <tr class="form-field term-group">
            <th scope="row">
                <label for="category_text_<?php echo $i; ?>"><?php echo sprintf(__('%d . titulek', 'SLOTH'), $i); ?></label>
            </th>
            <td>
                <input type="text" name="category_text_<?php echo $i; ?>" id="category_text_<?php echo $i; ?>" value="<?php echo $text_value; ?>" style="width: 80%;" />
            </td>
        </tr>

        <tr class="form-field term-group">
            <th scope="row">
                <label for="category_url_<?php echo $i; ?>"><?php echo sprintf(__('%d . URL', 'SLOTH'), $i); ?></label>
            </th>
            <td>
                <input type="text" name="category_url_<?php echo $i; ?>" id="category_url_<?php echo $i; ?>" value="<?php echo $url_value; ?>" style="width: 80%;" />
            </td>
        </tr>
    <?php }
}

// Uložení hodnoty vlastního pole
add_action('edited_category', 'save_custom_category_field');

function save_custom_category_field($term_id) {
    // Uložení obrázků pro každý input
    for ($i = 1; $i <= 6; $i++) {
        if (isset($_POST['category_image_' . $i])) {
            $image_url = esc_url_raw($_POST['category_image_' . $i]);
            if ($image_url) {
                // Získáme ID obrázku pomocí URL
                $image_id = attachment_url_to_postid($image_url);
                update_term_meta($term_id, '_category_image_' . $i, $image_id);
            } else {
                // Pokud obrázek není vybrán, odstraníme term meta
                delete_term_meta($term_id, '_category_image_' . $i);
            }
        }
    }

    // Uložení textových polí pro každý input
    for ($i = 1; $i <= 6; $i++) {
        if (isset($_POST['category_text_' . $i])) {
            $text_value = sanitize_text_field($_POST['category_text_' . $i]);
            update_term_meta($term_id, '_category_text_' . $i, $text_value);
        }
    }

    // Uložení textových polí pro každý input
    for ($i = 1; $i <= 6; $i++) {
        if (isset($_POST['category_url_' . $i])) {
            $text_value = sanitize_text_field($_POST['category_url_' . $i]);
            update_term_meta($term_id, '_category_url_' . $i, $text_value);
        }
    }
}

// Allow upload files without wp-editor on page

function custom_category_image_uploader_script($hook) {
    // Pouze na stránce pro úpravu kategorie
    if ('edit-tags.php' != $hook && 'term.php' != $hook) {
        return;
    }
    wp_enqueue_script( 'category_upload_image', get_theme_file_uri('/js/category-media-uploader.js'), null, '4', true );

}
add_action('admin_enqueue_scripts', 'custom_category_image_uploader_script');
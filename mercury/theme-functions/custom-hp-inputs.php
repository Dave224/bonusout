<?php

add_action( 'add_meta_boxes', 'custom_frontpage_metabox' );

function custom_frontpage_metabox() {
    // Získáme ID stránky pro úvodní stránku
    $front_page_id = get_option( 'page_on_front' );

    // Pokud máme úvodní stránku nastavenou, přidáme metabox pouze pro tuto stránku
    if ( $front_page_id ) {
        add_meta_box(
            'custom_frontpage_metabox', // ID metaboxu
            'Nastavení top brandů', // Název metaboxu
            'custom_frontpage_metabox_callback', // Callback funkce pro obsah metaboxu
            'page', // Typ příspěvku (stránka)
            'normal', // Umístění metaboxu (normální sekce)
            'high', // Priorita (vysoká)
            array( 'front_page_id' => $front_page_id ) // Předáme ID úvodní stránky
        );
    }
}

function custom_frontpage_metabox_callback( $post, $args ) {
    // Získáme ID úvodní stránky z argumentů
    $front_page_id = (int) $args['args']['front_page_id'];
    // Pokud aktuální stránka je úvodní stránka, zobrazíme metabox
    if ( $post->ID === $front_page_id ) {
        // Získáme hodnoty z postmeta, pokud existují
        $image_ids = [];
        for ($i = 1; $i <= 6; $i++) {
            $image_ids[$i] = get_post_meta($post->ID, '_custom_image_' . $i, true);
        }

        // Získání hodnot pro textová pole
        $text_values = [];
        for ($i = 1; $i <= 6; $i++) {
            $text_values[$i] = get_post_meta($post->ID, '_hp_text_' . $i, true);
        }

        // Získání hodnot pro textová pole
        $url_values = [];
        for ($i = 1; $i <= 6; $i++) {
            $url_values[$i] = get_post_meta($post->ID, '_hp_url_' . $i, true);
        }

        // Vykreslíme HTML pro inputy
        ?>
        <?php
        // Vykreslení polí pro obrázky a textové inputy
        for ($i = 1; $i <= 6; $i++) {
            $image_url = $image_ids[$i] ? wp_get_attachment_url($image_ids[$i]) : '';
            $text_value = esc_attr($text_values[$i]);
            $url_value = esc_attr($url_values[$i]);
            wp_nonce_field( 'custom_frontpage_metabox_nonce_action', 'custom_frontpage_metabox_nonce' );
            ?>
            <p style="margin-top: 20px;">
                <label for="custom_image_<?php echo $i; ?>"><strong><?php echo sprintf(__('%d . obrázek: ', 'SLOTH'), $i); ?></strong></label>
                <input type="text" name="custom_image_url_<?php echo $i; ?>" id="custom_image_url_<?php echo $i; ?>" value="<?php echo $image_url; ?>" style="width: 80%;" />
                <input type="hidden" name="custom_image_<?php echo $i; ?>" id="custom_image_<?php echo $i; ?>" value="<?php echo esc_attr( $image_ids[$i] ); ?>" />
                <img id="custom_image_preview_<?php echo $i; ?>" src="<?php echo esc_url( wp_get_attachment_url( $image_ids[$i] ) ); ?>" style="width: 50px; height: auto; <?php echo $image_ids[$i] ? '' : 'display: none;' ?>" />
                <button type="button" class="button" id="upload_image_button_<?php echo $i; ?>" style="margin-left: 10px;"><?php _e('Vybrat obrázek', 'SLOTH'); ?></button>
                <button type="button" class="button" id="remove_image_button_<?php echo $i; ?>" style="margin-left: 10px; display: <?php echo $image_ids[$i] ? 'inline-block' : 'none'; ?>;">Odebrat obrázek</button>
            </p>

            <p style="margin-top: 20px;">
                <label for="hp_text_<?php echo $i; ?>"><strong><?php echo sprintf(__('%d . titulek: ', 'SLOTH'), $i); ?></strong></label>
                <input type="text" name="hp_text_<?php echo $i; ?>" id="hp_text_<?php echo $i; ?>" value="<?php echo $text_value; ?>" style="width: 80%;" />
            </p>

            <p style="margin-top: 20px;">
                <label for="hp_url_<?php echo $i; ?>"><strong><?php echo sprintf(__('%d . URL: ', 'SLOTH'), $i); ?></strong></label>
                <input type="text" name="hp_url_<?php echo $i; ?>" id="hp_url_<?php echo $i; ?>" value="<?php echo $url_value; ?>" style="width: 80%;" />
            </p>
        <?php } ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                // Funkce pro každý input
                function createUploader(buttonId, inputId, previewId, removeButtonId, inputUrlId) {
                    var mediaUploader;

                    $(buttonId).click(function(e) {
                        e.preventDefault();

                        if (mediaUploader) {
                            mediaUploader.open();
                            return;
                        }

                        mediaUploader = wp.media.frames.file_frame = wp.media({
                            title: 'Vyberte obrázek',
                            button: {
                                text: 'Vybrat obrázek'
                            },
                            multiple: false
                        });

                        mediaUploader.on('select', function() {
                            var attachment = mediaUploader.state().get('selection').first().toJSON();
                            $(inputId).val(attachment.id);
                            $(inputUrlId).val(attachment.url);
                            $(previewId).attr('src', attachment.url).show();
                            $(removeButtonId).show();
                        });

                        mediaUploader.open();
                    });

                    $(removeButtonId).click(function() {
                        $(inputId).val('');
                        $(inputUrlId).val('');
                        $(previewId).hide();
                        $(removeButtonId).hide();
                    });
                }

                // Aplikace pro každý obrázek
                createUploader('#upload_image_button_1', '#custom_image_1', '#custom_image_preview_1', '#remove_image_button_1' ,'#custom_image_url_1');
                createUploader('#upload_image_button_2', '#custom_image_2', '#custom_image_preview_2', '#remove_image_button_2' ,'#custom_image_url_2');
                createUploader('#upload_image_button_3', '#custom_image_3', '#custom_image_preview_3', '#remove_image_button_3' ,'#custom_image_url_3');
                createUploader('#upload_image_button_4', '#custom_image_4', '#custom_image_preview_4', '#remove_image_button_4' ,'#custom_image_url_4');
                createUploader('#upload_image_button_5', '#custom_image_5', '#custom_image_preview_5', '#remove_image_button_5' ,'#custom_image_url_5');
                createUploader('#upload_image_button_6', '#custom_image_6', '#custom_image_preview_6', '#remove_image_button_6' ,'#custom_image_url_6');
            });
        </script>
<?php    }
}
add_action( 'save_post', 'save_custom_frontpage_metabox_data' );

function save_custom_frontpage_metabox_data( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }

    if ( isset( $_POST['custom_frontpage_metabox_nonce'] ) && wp_verify_nonce( $_POST['custom_frontpage_metabox_nonce'], 'custom_frontpage_metabox_nonce_action' ) ) {
        // Získáme ID úvodní stránky
        $front_page_id = (int)get_option( 'page_on_front' );

        // Zkontrolujeme, jestli je to stránka (a ne jiný typ příspěvku)
        if ( 'page' !== get_post_type( $post_id ) ) {
            return $post_id;;
        }

        // Ujistíme se, že uložená stránka je skutečně úvodní stránka
        if ( $post_id === $front_page_id ) {
            // Uložení obrázků pro každý input
            for ($i = 1; $i <= 6; $i++) {
                if ( isset( $_POST['custom_image_' . $i] ) ) {
                    $image_id = sanitize_text_field( $_POST['custom_image_' . $i] );
                    update_post_meta( $post_id, '_custom_image_' . $i, $image_id );
                }
            }

            // Uložení textových polí pro každý input
            for ($i = 1; $i <= 6; $i++) {
                if (isset($_POST['hp_text_' . $i])) {
                    $text_value = sanitize_text_field($_POST['hp_text_' . $i]);
                    update_post_meta($post_id, '_hp_text_' . $i, $text_value);
                }
            }

            // Uložení textových polí pro každý input
            for ($i = 1; $i <= 6; $i++) {
                if (isset($_POST['hp_url_' . $i])) {
                    $text_value = sanitize_text_field($_POST['hp_url_' . $i]);
                    update_post_meta($post_id, '_hp_url_' . $i, $text_value);
                }
            }

            // Uložení textových polí pro každý input
            for ($i = 1; $i <= 6; $i++) {
                if (isset($_POST['custom_image_url_' . $i])) {
                    $image_url = esc_url_raw($_POST['custom_image_url_' . $i]);
                    if ($image_url) {
                        // Získáme ID obrázku pomocí URL
                        $image_id = attachment_url_to_postid($image_url);
                        update_post_meta($post_id, '_custom_image_' . $i, $image_id);
                    } else {
                        // Pokud obrázek není vybrán, odstraníme term meta
                        delete_post_meta($post_id, '_custom_image_' . $i);
                    }
                    $text_value = sanitize_text_field($_POST['custom_image_url_' . $i]);
                    update_post_meta($post_id, 'custom_image_url_' . $i, $text_value);
                }
            }
        }
    }
}

// Shortcode to output custom PHP in Elementor
function wpc_elementor_shortcode( $atts ) {
    $topBrandData = [];
    $image_ids = [];
    for ( $i = 1; $i <= 6; $i++ ) {
        $image_id = get_post_meta( get_the_ID(), '_custom_image_' . $i, true );
        if ( $image_id ) {
            $image_url = wp_get_attachment_url( $image_id );
            $image_ids[$i] = $image_url;
            $topBrandData[$i]['image'] = $image_ids[$i];
        }
    }

    // Získání hodnot pro textová pole
    $text_values = [];
    for ($i = 1; $i <= 6; $i++) {
        $text_values[$i] = get_post_meta(get_the_ID(), '_hp_text_' . $i, true);
        $topBrandData[$i]['title'] = $text_values[$i];
    }

    // Získání hodnot pro textová pole
    $url_values = [];
    for ($i = 1; $i <= 6; $i++) {
        $url_values[$i] = get_post_meta(get_the_ID(), '_hp_url_' . $i, true);
        $topBrandData[$i]['url'] = $url_values[$i];
    }
    if (!empty($image_ids[1]) || !empty($url_values[1]) || !empty($text_values[1])) {
    echo '<div class="custom-wrapper relative">';
        echo '<div class="custom-container custom-hp-container space-page-wrapper relative">';
            foreach ($topBrandData as $key => $item) {
                if ($item['title']) {
                    echo '<a class="custom-column" target="_blank" href="' . $item['url'] . '" rel="noopener">';
                        echo '<div class="star-rating"><i class="fas fa-star"></i>' . $key . '</div>';
                        echo '<img src="' . $item['image'] . '" alt="' . $item['title'] . '">';
                        echo '<h3>' . $item['title'] . '</h3>';
                    echo ' </a>';
                }
            }
        echo '</div>';
    echo '</div>';
    }
}
add_shortcode( 'my_elementor_php_output', 'wpc_elementor_shortcode');
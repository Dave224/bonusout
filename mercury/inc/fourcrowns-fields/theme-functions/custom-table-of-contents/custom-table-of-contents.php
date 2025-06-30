<?php
// 1️⃣ Přidání checkboxu do editoru příspěvku
function pridat_osnova_checkbox() {
    add_meta_box(
        'osnova_meta_box',
        'Osnova článku',
        'zobrazit_osnova_meta_box',
        'post',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'pridat_osnova_checkbox');

function zobrazit_osnova_meta_box($post) {
    $hodnota = get_post_meta($post->ID, '_osnova_povolena', true);
    wp_nonce_field(basename(__FILE__), 'osnova_nonce');
    ?>
    <p>
        <input type="checkbox" name="osnova_povolena" id="osnova_povolena" value="1" <?php checked($hodnota, '1'); ?> />
        <label for="osnova_povolena">Skrýt automatickou osnovu</label>
    </p>
    <p>Osnovu je pak možné vložit kamkoliv do obsahu článku přes shortcode <strong>[osnova]</strong></p>
    <?php
}

// 2️⃣ Uložení hodnoty checkboxu
function ulozit_osnova_checkbox($post_id) {
    if (!isset($_POST['osnova_nonce']) || !wp_verify_nonce($_POST['osnova_nonce'], basename(__FILE__))) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $hodnota = isset($_POST['osnova_povolena']) ? '1' : '';
    update_post_meta($post_id, '_osnova_povolena', $hodnota);
}
add_action('save_post', 'ulozit_osnova_checkbox');

// 3️⃣ Automatická osnova za 2. odstavec, pokud je povolena
function vygenerovat_osnovu_auto($content) {
    if (!is_single()) {
        return $content;
    }

    $osnova_povolena = get_post_meta(get_the_ID(), '_osnova_povolena', true);

    if ($osnova_povolena) {
        return $content;
    }

    preg_match_all('/<h2[^>]*>(.*?)<\/h2>/', $content, $matches);

    if (empty($matches[1])) {
        return $content;
    }

    // Struktura osnovy s tlačítkem a skrytým seznamem
    $osnova = '<div class="osnova-box">
        <div class="osnova-header">
            <h3 class="osnova-title">Osnova článku</h3>
            <button class="osnova-toggle">
                <span class="osnova-arrow">▼</span>
            </button>
        </div>
        <ul class="osnova-list" style="display: none;">';

    foreach ($matches[1] as $nadpis) {
        $id = sanitize_title($nadpis);
        if ($id) {
            $osnova .= "<li><a href='#$id'>$nadpis</a></li>";
        }
    }

    $osnova .= '</ul></div>';

    // Vložení osnovy po druhém odstavci
    $odstavce = explode("</p>", $content);

    if (count($odstavce) > 2) {
        $odstavce[1] .= $osnova;
    } else {
        array_unshift($odstavce, $osnova);
    }

    return implode("</p>", $odstavce);
}
add_filter('the_content', 'vygenerovat_osnovu_auto');

// Vygenerování id k nadpisům v obsahu článku
function vygenerovat_id_k_nadpisum($content) {
    if (!is_single()) {
        return $content;
    }

    preg_match_all('/<h2[^>]*>(.*?)<\/h2>/', $content, $matches);

    if (empty($matches[1])) {
        return $content;
    }

    foreach ($matches[1] as $nadpis) {
        $id = sanitize_title($nadpis);
        if ($id) {
            $content = str_replace($nadpis, "<span id='$id'></span>" . $nadpis, $content);
        }
    }

    return $content;
}

add_filter('the_content', 'vygenerovat_id_k_nadpisum');

// 4️⃣ Shortcode pro ruční vložení osnovy
function vygenerovat_osnovu_shortcode() {
    global $post;

    if (!$post || !is_single()) {
        return '';
    }

    preg_match_all('/<h2[^>]*>(.*?)<\/h2>/', $post->post_content, $matches);

    if (empty($matches[1])) {
        return '';
    }

    $osnova = '<div class="osnova-box">
        <div class="osnova-header">
            <h3 class="osnova-title">Osnova článku</h3>
            <button class="osnova-toggle">
                <span class="osnova-arrow">▼</span>
            </button>
        </div>
        <ul class="osnova-list" style="display: none;">';

    foreach ($matches[1] as $nadpis) {
        $id = sanitize_title($nadpis);
        if ($id) {
            $osnova .= "<li><a href='#$id'>$nadpis</a></li>";
        }
    }

    $osnova .= '</ul></div>';

    return $osnova;
}
add_shortcode('osnova', 'vygenerovat_osnovu_shortcode');


wp_enqueue_script('custom-table-of-contents-js', get_theme_file_uri('theme-functions/custom-table-of-contents/custom-table-of-content.js'), array(), null, true);
wp_enqueue_style('custom-table-of-contents-css', get_theme_file_uri('theme-functions/custom-table-of-contents/custom-table-of-content.css?v=3'));
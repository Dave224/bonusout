<?php

// Nahradí ## za odsazení řádku <br>
function renderBreakTagInString($string)
{
    $wordToFind  = "##";
    $replace = "<br>";
    return str_replace($wordToFind, $replace, $string);
}

// Nalezne všechny meta hodnoty daného klíče
function get_meta_values( $meta_key = '', $post_type = 'post', $post_status = 'publish', $post_status_2 = 'draft' ) {

    global $wpdb;

    if( empty( $meta_key ) )
        return;

    $meta_values = $wpdb->get_col( $wpdb->prepare( "
        SELECT pm.meta_value FROM {$wpdb->postmeta} pm
        LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
        WHERE pm.meta_key = %s 
        AND p.post_type = %s 
        AND p.post_status = %s OR p.post_status = %s
    ", $meta_key, $post_type, $post_status, $post_status_2) );

    return $meta_values;
}

function get_user_by_meta_data( $meta_key, $meta_value ) {

    // Query for users based on the meta data
    $user_query = new WP_User_Query(
        array(
            'meta_key'	  =>	$meta_key,
            'meta_value'	=>	$meta_value
        )
    );

    // Get the results from the query, returning the first user
    $users = $user_query->get_results();

    return $users[0];

} // end get_user_by_meta_data

// Znížení rozestupu mezi formuláři
add_filter('comment_flood_delay', 'reduce_comment_flood_time');

function reduce_comment_flood_time() {
    return 5; // sekundy mezi komentáři
}

// Nahrání obrázku z appky do WP
function replace_images_with_sideloaded_versions($html, $app_post_id, $post_id = 0) {
    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';

    preg_match_all('/<img[^>]+>/i', $html, $matches);
    $img_tags = $matches[0];

    foreach ($img_tags as $img_tag) {
        preg_match('/src=["\']([^"\']+)["\']/', $img_tag, $src_match);
        preg_match('/alt=["\']([^"\']*)["\']/', $img_tag, $alt_match);

        $src = $src_match[1] ?? null;
        $alt = $alt_match[1] ?? '';

        if (!$src) continue;

        $filename = basename(parse_url($src, PHP_URL_PATH));
        $filename = rawurldecode($filename);
        $filename = $app_post_id . '-' . $filename;
        $filenameArray = explode('.', $filename);

        // 🔍 1. Zkus najít existující médium se stejným názvem
        $existing = get_posts([
            'post_type' => 'attachment',
            'post_status' => 'inherit',
            'posts_per_page' => 1,
            'meta_query' => [],
            's' => $filenameArray[0],
        ]);

        if (!empty($existing)) {
            $existing_url = wp_get_attachment_url($existing[0]->ID);
            if ($existing_url) {
                $new_tag = str_replace($src, $existing_url, $img_tag);
                $html = str_replace($img_tag, $new_tag, $html);
                continue;
            }
        }

        // 🆕 2. Pokud neexistuje, stáhni obrázek a nahraj
        $media = media_sideload_image($src, $post_id, $alt, 'id');

        if ( ! is_wp_error( $media ) ) {
            $attachment_id = $media;

            // 2. Získej aktuální cestu k souboru
            $file = get_attached_file( $attachment_id );
            $pathinfo = pathinfo( $file );

            // 3. Vytvoř nový název souboru
            $new_filename = $app_post_id . '-' . $pathinfo['basename'];
            $new_path = $pathinfo['dirname'] . '/' . $new_filename;

            // 4. Přejmenuj soubor na disku
            rename( $file, $new_path );

            // 5. Aktualizuj attachment meta
            update_attached_file( $attachment_id, $new_path );

            // 6. (Volitelné) změň post_name (slug) přílohy v DB
            wp_update_post( [
                'ID' => $attachment_id,
                'post_title' => $app_post_id . '-' . str_replace('20', ' ', $pathinfo['filename']),
                'post_name' =>  $app_post_id . '-' . $pathinfo['filename'],
            ] );
        }

        $media_url = wp_get_attachment_url($attachment_id);

        if (is_wp_error($media_url)) {
            my_debug_log("❌ Nepodařilo se nahrát obrázek $src – " . $media_url->get_error_message());
            continue;
        }

        $new_tag = str_replace($src, $media_url, $img_tag);
        $html = str_replace($img_tag, $new_tag, $html);
    }

    return $html;
}

function prepareImageFroPost ($src, $appPostId, $post_id, $image_alt) {
    $filename = basename(parse_url($src, PHP_URL_PATH));
    $filename = rawurldecode($filename);
    $filename = $appPostId . '-' . $filename;
    $filenameArray = explode('.', $filename);

    // 🔍 1. Zkus najít existující médium se stejným názvem
    $existing = get_posts([
        'post_type' => 'attachment',
        'post_status' => 'inherit',
        'posts_per_page' => 1,
        'meta_query' => [],
        's' => $filenameArray[0],
    ]);

    if (empty($existing)) {
        $attach_meta_id = media_sideload_image($src, $post_id, $image_alt, 'id');
        // 2. Získej aktuální cestu k souboru
        $file = get_attached_file( $attach_meta_id );
        $pathinfo = pathinfo( $file );

        // 3. Vytvoř nový název souboru
        $new_filename = $appPostId . '-' . $pathinfo['basename'];
        $new_path = $pathinfo['dirname'] . '/' . $new_filename;

        // 4. Přejmenuj soubor na disku
        rename( $file, $new_path );

        // 5. Aktualizuj attachment meta
        update_attached_file( $attach_meta_id, $new_path );

        // 6. (Volitelné) změň post_name (slug) přílohy v DB
        wp_update_post( [
            'ID' => $attach_meta_id,
            'post_title' => $appPostId . '-' . str_replace('20', ' ', $pathinfo['filename']),
            'post_name' =>  $appPostId . '-' . $pathinfo['filename'],
        ] );

        $attachment_data = wp_generate_attachment_metadata( $attach_meta_id, $image_alt );
        wp_update_attachment_metadata( $attach_meta_id,  $attachment_data );
        update_post_meta($post_id, '_yoast_wpseo_opengraph-image-id', $attach_meta_id);
        $attach_meta_url = wp_get_attachment_url($attach_meta_id);
        update_post_meta($post_id, '_yoast_wpseo_opengraph-image', $attach_meta_url);
        set_post_thumbnail($post_id, $attach_meta_id);
    } else {
        set_post_thumbnail($post_id, $existing[0]->ID);
    }
}

// V kategoriích vynech sticky z hlavního loopu (ukážeme je zvlášť nahoře)
add_action('pre_get_posts', function ($query) {
    if (!is_admin() && $query->is_main_query() && $query->is_category()) {
        $sticky = get_option('sticky_posts');
        if (!empty($sticky)) {
            $query->set('ignore_sticky_posts', 1);
            // nezobrazovat sticky znovu v hlavním výpisu
            $query->set('post__not_in', $sticky);
        }
    }
});

if ( ! function_exists( 'my_debug_log' ) ) {
    function my_debug_log( $message, $file = 'my_debug.log' ) {
        // Cesta do wp-content
        $upload_dir = wp_upload_dir();
        $log_dir    = trailingslashit( $upload_dir['basedir'] ) . 'logs';

        // Pokud složka neexistuje, vytvoříme ji
        if ( ! file_exists( $log_dir ) ) {
            wp_mkdir_p( $log_dir );
        }

        $log_file = trailingslashit( $log_dir ) . $file;

        // Připravíme zprávu
        if ( is_array( $message ) || is_object( $message ) ) {
            $message = print_r( $message, true );
        }

        $timestamp = date( 'Y-m-d H:i:s' );
        $line      = "[{$timestamp}] " . $message . PHP_EOL;

        // Zápis do souboru
        file_put_contents( $log_file, $line, FILE_APPEND | LOCK_EX );
    }
}
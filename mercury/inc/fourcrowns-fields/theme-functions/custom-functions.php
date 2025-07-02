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
function replace_images_with_sideloaded_versions($html, $post_id = 0) {
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

        // 🔍 1. Zkus najít existující médium se stejným názvem
        $existing = get_posts([
            'post_type' => 'attachment',
            'post_status' => 'inherit',
            'posts_per_page' => 1,
            'meta_query' => [],
            'title' => sanitize_title($filename),
            's' => $filename,
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
        $media_url = media_sideload_image($src, $post_id, $alt, 'src');

        if (is_wp_error($media_url)) {
            error_log("❌ Nepodařilo se nahrát obrázek $src – " . $media_url->get_error_message());
            continue;
        }

        $new_tag = str_replace($src, $media_url, $img_tag);
        $html = str_replace($img_tag, $new_tag, $html);
    }

    return $html;
}

$filename = basename(parse_url('https://app.simplesio.com/api/media/file/Weiss%20casino%20homepage.jpg', PHP_URL_PATH));
var_dump(rawurldecode($filename));
// 🔍 1. Zkus najít existující médium se stejným názvem
$existing = get_posts([
    'post_type' => 'attachment',
    'post_status' => 'inherit',
    'posts_per_page' => 1,
    'meta_query' => [],
    'title' => $filename,
    's' => $filename,
]);

var_dump($existing);

$all = get_posts([
    'post_type' => 'attachment',
    'post_status' => 'inherit',
    'posts_per_page' => -1,
    'meta_query' => [],
]);

var_dump($all);

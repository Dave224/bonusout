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
function upload_images_and_replace_urls($html, $post_id) {
    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $dom->loadHTML('<?xml encoding="utf-8" ?><body>' . mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8') . '</body>');
    $images = $dom->getElementsByTagName('img');

    foreach ($images as $img) {
        $src = $img->getAttribute('src');
        $alt = $img->getAttribute('alt');
        $filename = basename(parse_url($src, PHP_URL_PATH));

        $attach_meta_id = media_sideload_image($src, $post_id, $alt, 'id');
        $attachment_data = wp_generate_attachment_metadata( $attach_meta_id, $alt['alt'] );
        wp_update_attachment_metadata( $attach_meta_id,  $attachment_data );

            $img->setAttribute('src', wp_get_attachment_image_url($attach_meta_id));
    }

    return preg_replace('~^<!DOCTYPE.+?>~', '', $dom->saveHTML($dom->getElementsByTagName('body')->item(0)));
}
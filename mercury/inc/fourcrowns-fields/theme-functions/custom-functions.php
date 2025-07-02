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
function upload_images_and_replace_urls($html, $wp_url, $username, $application_password) {
    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
    $images = $dom->getElementsByTagName('img');

    $client = curl_init();
    $auth = base64_encode("$username:$application_password");

    foreach ($images as $img) {
        $src = $img->getAttribute('src');
        $alt = $img->getAttribute('alt');
        $filename = basename(parse_url($src, PHP_URL_PATH));

        // 1. Zkontroluj, zda už existuje
        $check_url = rtrim($wp_url, '/') . '/wp-json/wp/v2/media?search=' . urlencode($filename);

        curl_setopt_array($client, [
            CURLOPT_URL => $check_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Basic ' . $auth
            ],
            CURLOPT_HTTPGET => true,
        ]);

        $check_response = curl_exec($client);
        $check_code = curl_getinfo($client, CURLINFO_HTTP_CODE);

        if ($check_code === 200) {
            $media_list = json_decode($check_response, true);
            foreach ($media_list as $media_item) {
                if ($media_item['title']['rendered'] === $filename || strpos($media_item['source_url'], $filename) !== false) {
                    // Obrázek už existuje – použij jeho URL
                    $img->setAttribute('src', $media_item['source_url']);
                    continue 2; // přejdi na další obrázek
                }
            }
        }

        // 2. Nahrát, pokud neexistuje
        $image_data = file_get_contents($src);
        if ($image_data === false) continue;

        $tmp_file = tempnam(sys_get_temp_dir(), 'img_');
        file_put_contents($tmp_file, $image_data);

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $tmp_file);
        finfo_close($finfo);

        $upload_url = rtrim($wp_url, '/') . '/wp-json/wp/v2/media';
        $file_data = file_get_contents($tmp_file);

        curl_setopt_array($client, [
            CURLOPT_URL => $upload_url,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Basic ' . $auth,
                'Content-Disposition: attachment; filename="' . $filename . '"',
                'Content-Type: ' . $mime_type
            ],
            CURLOPT_POSTFIELDS => $file_data
        ]);

        $response = curl_exec($client);
        $http_code = curl_getinfo($client, CURLINFO_HTTP_CODE);

        if ($http_code === 201) {
            $response_data = json_decode($response, true);
            $new_url = $response_data['source_url'];
            $media_id = $response_data['id'];

            // Nastav ALT text
            if (!empty($alt)) {
                $patch_url = $upload_url . '/' . $media_id;
                curl_setopt_array($client, [
                    CURLOPT_URL => $patch_url,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPHEADER => [
                        'Authorization: Basic ' . $auth,
                        'Content-Type: application/json'
                    ],
                    CURLOPT_POSTFIELDS => json_encode([
                        'alt_text' => $alt
                    ])
                ]);
                curl_exec($client);
            }

            $img->setAttribute('src', $new_url);
        }

        unlink($tmp_file);
    }

    curl_close($client);
    return preg_replace('~^<!DOCTYPE.+?>~', '', $dom->saveHTML());
}
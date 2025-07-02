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
function upload_images_and_replace_urls_regex($html, $wp_url, $username, $application_password) {
    $auth = base64_encode("$username:$application_password");
    $client = curl_init();

    // 1. Najdi všechny <img> tagy
    preg_match_all('/<img[^>]+>/i', $html, $matches);
    $img_tags = $matches[0];

    foreach ($img_tags as $img_tag) {
        log_debug($img_tag);

        // Získání src a alt atributu
        preg_match('/src=["\']([^"\']+)["\']/', $img_tag, $src_match);
        preg_match('/alt=["\']([^"\']*)["\']/', $img_tag, $alt_match);

        $src = $src_match[1] ?? null;
        $alt = $alt_match[1] ?? '';

        if (!$src) continue;

        $filename = basename(parse_url($src, PHP_URL_PATH));

        // 2. Hledání v médiích podle názvu
        $search_url = rtrim($wp_url, '/') . '/wp-json/wp/v2/media?search=' . urlencode($filename);

        curl_setopt_array($client, [
            CURLOPT_URL => $search_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Authorization: Basic ' . $auth],
        ]);

        $search_response = curl_exec($client);
        $media_list = json_decode($search_response, true);

        $found_url = null;
        if (is_array($media_list)) {
            foreach ($media_list as $media) {
                if (strpos($media['source_url'], $filename) !== false) {
                    $found_url = $media['source_url'];
                    break;
                }
            }
        }

        if ($found_url) {
            // Nahraď src v HTML
            $new_tag = str_replace($src, $found_url, $img_tag);
            $html = str_replace($img_tag, $new_tag, $html);
            continue;
        }

        // 3. Nahrání nového obrázku
        $image_data = @file_get_contents($src);
        if (!$image_data) {
            continue;
        }

        $tmp_file = tempnam(sys_get_temp_dir(), 'img_');
        file_put_contents($tmp_file, $image_data);

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $tmp_file);
        finfo_close($finfo);

        $upload_url = rtrim($wp_url, '/') . '/wp-json/wp/v2/media';

        curl_setopt_array($client, [
            CURLOPT_URL => $upload_url,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Basic ' . $auth,
                'Content-Disposition: attachment; filename="' . $filename . '"',
                'Content-Type: ' . $mime_type,
            ],
            CURLOPT_POSTFIELDS => $image_data,
        ]);

        $upload_response = curl_exec($client);
        $http_code = curl_getinfo($client, CURLINFO_HTTP_CODE);
        $upload_data = json_decode($upload_response, true);

        if ($http_code === 201 && !empty($upload_data['source_url'])) {
            $new_url = $upload_data['source_url'];
            $media_id = $upload_data['id'];

            // Update alt text (volitelně)
            if ($alt) {
                $patch_url = $upload_url . '/' . $media_id;
                curl_setopt_array($client, [
                    CURLOPT_URL => $patch_url,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPHEADER => [
                        'Authorization: Basic ' . $auth,
                        'Content-Type: application/json',
                    ],
                    CURLOPT_POSTFIELDS => json_encode(['alt_text' => $alt]),
                ]);
                curl_exec($client);
            }

            // Nahraď src v HTML
            $new_tag = str_replace($src, $new_url, $img_tag);
            $html = str_replace($img_tag, $new_tag, $html);

        }

        unlink($tmp_file);
    }

    curl_close($client);
    return $html;
}


function log_debug($message) {
    $log_file = ABSPATH . '/image_upload_log.txt'; // cesta k logu vedle skriptu
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($log_file, "[$timestamp] $message\n", FILE_APPEND);
}


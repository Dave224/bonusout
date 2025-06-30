<?php
add_action( 'rest_api_init', function () {
    register_rest_route('bonusout', '/create-post', [
        'methods' => ['GET', 'POST'],
        'callback' => 'createPostFromApp',
    ]);
} );

function createPostFromApp ($data)
{
    $appIds = get_meta_values('app_id');
    $postData = $data->get_params()['data'];

    if ($postData) {
        $postContentData = $postData['Obsah'];
        $postConfigData = $postData['Konfigurace'];
        $postAdminData = $postData['Administrace'];
        $postMetaData = $postData['meta'];
    } else {
        return false;
    }

    $appPostId = $postAdminData['wordpressId'];

    $author_id = 1;
    $user = null;
    if ($postConfigData['author']) {
        $user = get_user_by_meta_data('app-id', $postConfigData['author']['id']);
    }

    if ($postConfigData['visibleAuthor']) {
        $user = get_user_by_meta_data('app-id', $postConfigData['visibleAuthor']['id']);
    }

    if ($user) {
        $author_id = $user->ID;
    }

    $my_post = [
        'post_title'    => $postContentData['title'],
        'post_content'  => $postContentData['contentHTML'],
        'post_excerpt'  => $postContentData['description'],
        'post_status'   => 'draft',
        'post_author'   => $author_id,
        'post_name'     => $postMetaData['article_slug'],
    ];

    foreach ($postConfigData['category'] as $cat) {
        $category = get_cat_ID($cat['category_name']);

        if (!$category) {
            $term = wp_insert_term($cat['category_name'], 'category');
            $category = $term['term_id'];
        }
        $translated_cat_ids[] = $category;

    }

    if (is_array($appIds) && in_array($appPostId, $appIds)) {
        // Update post if exists
        $args = array(
            'meta_key' => 'app_id',
            'meta_value' => $appPostId,
            'post_type' => 'post',
            'post_status' => ['publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash'],
            'posts_per_page' => 1,
        );
        $posts = get_posts($args);

        $my_post = [
            'ID'            => $posts[0]->ID,
            'post_title'    => $postContentData['title'],
            'post_content'  =>  $postContentData['contentHTML'],
            'post_excerpt'  => $postContentData['description'],
            'post_status'   => get_post_status($posts[0]->ID),
            'post_author'   => $author_id,
            'post_name'     => $postMetaData['article_slug'],
        ];
        wp_update_post($my_post);

        $attach_meta_id = 0;
        if ($postMetaData['image']) {
            $attach_meta_id = media_sideload_image($data->get_params()['origin'] . '/' . $postMetaData['image']['url'], $posts[0]->ID, $postMetaData['image']['alt'], 'id');
            $attachment_data = wp_generate_attachment_metadata( $attach_meta_id, $postMetaData['image']['alt'] );
            wp_update_attachment_metadata( $attach_meta_id,  $attachment_data );
            update_post_meta($posts[0]->ID, '_yoast_wpseo_opengraph-image-id', $attach_meta_id);
            $attach_meta_url = wp_get_attachment_url($attach_meta_id);
            update_post_meta($posts[0]->ID, '_yoast_wpseo_opengraph-image', $attach_meta_url);
        }
        set_post_thumbnail($posts[0]->ID, $attach_meta_id);

        update_post_meta($posts[0]->ID, '_yoast_wpseo_title', $postMetaData['title']);
        update_post_meta($posts[0]->ID, '_yoast_wpseo_metadesc', $postMetaData['description']);
        update_post_meta($posts[0]->ID, 'meta', $postMetaData);

        wp_set_post_terms($posts[0]->ID, $translated_cat_ids, 'category');

    } else {
        // Create post in specific language (en is default)
        $post_id = wp_insert_post($my_post);
        add_post_meta($post_id, 'app_id', $appPostId);
        $attach_meta_id = 0;

        if ($postMetaData['image']) {
            $attach_meta_id = media_sideload_image($data->get_params()['origin'] . '/' . $postMetaData['image']['url'], $post_id, $postMetaData['image']['alt'], 'id');
            $attachment_data = wp_generate_attachment_metadata( $attach_meta_id, $postMetaData['image']['alt'] );
            wp_update_attachment_metadata( $attach_meta_id,  $attachment_data );
            update_post_meta($post_id, '_yoast_wpseo_opengraph-image-id', $attach_meta_id);
            $attach_meta_url = wp_get_attachment_url($attach_meta_id);
            update_post_meta($post_id, '_yoast_wpseo_opengraph-image', $attach_meta_url);
        }
        set_post_thumbnail($post_id, $attach_meta_id);

        add_post_meta($post_id, '_yoast_wpseo_title', $postMetaData['title']);
        add_post_meta($post_id, '_yoast_wpseo_metadesc', $postMetaData['description']);
        add_post_meta($post_id, 'meta', $postMetaData);

        wp_set_post_terms($post_id, $translated_cat_ids, 'category');
    }

    return true;
}
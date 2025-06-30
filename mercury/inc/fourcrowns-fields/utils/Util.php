<?php

namespace utils;

class Util
{
    public static function issetAndNotEmpty($value)
    {
        return isset($value) && !empty($value);
    }

    public static function arrayIssetAndNotEmpty($array = null)
    {
        return isset($array) && is_array($array) && count($array) > 0;
    }

    public static function getPostsForOptions() {
        $posts = get_posts([
            'post_type' => 'post',
            'post_status' => 'publish',
            'numberposts' => 100,
            'orderby' => 'date',
            'order' => 'DESC',
        ]);

        $options = [];
        foreach ($posts as $post) {
            $options[$post->ID] = get_the_title($post->ID);
        }

        return $options;
    }

    public static function getPostTermsForOptions() {
        $categories = get_categories([
            'hide_empty' => false,
            'orderby'    => 'name',
            'order'      => 'ASC',
        ]);

        $options = [];
        foreach ($categories as $category) {
            $options[$category->term_id] = $category->name;
        }

        return $options;
    }
}
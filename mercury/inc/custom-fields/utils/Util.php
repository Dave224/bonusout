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

    public static function getPageForOptions() {
        $posts = get_posts([
            'post_type' => 'page',
            'post_status' => 'publish',
            'numberposts' => 100,
            'orderby' => 'title',
            'order' => 'ASC',
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

    public static function isBot($userAgent) {
        $bots = [
            // vyhledávače
            'googlebot', 'bingbot', 'slurp', 'duckduckbot', 'baiduspider',
            'yandexbot', 'sogou', 'exabot', 'seznam',
            // sociální sítě
            'facebot', 'facebookexternalhit', 'twitterbot', 'linkedinbot',
            'whatsapp', 'discordbot', 'skypeuripreview',
            // SEO a analyzátory
            'ahrefs', 'semrush', 'majestic', 'mj12bot', 'moz', 'rogerbot',
            // monitoring
            'uptimebot', 'pingdom', 'gtmetrix'
        ];
        $userAgent = strtolower($userAgent);
        foreach ($bots as $bot) {
            if (strpos($userAgent, $bot) !== false) {
                return true;
            }
        }
        return false;
    }
}
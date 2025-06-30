<?php
add_filter('comment_post', 'honeypot_control');

function honeypot_control()
{
    if (is_admin()) {
        return;
    }
    $honey = $_POST["kt-honey-comment"];
    $now = date("Y/m/d");
    if ($honey !== "abcd1234-{$now}") {
        wp_die(__("You filled out unauthorized control element...", "KT_CORE_DOMAIN"));
        exit;
    }
}

add_filter('pre_comment_approved', 'my_insert_comment');
function my_insert_comment($commentdata)
{
    if (is_admin()) {
        return;
    }
    $honey = $_POST["kt-honey-comment"];
    $now = date("Y/m/d");
    if ($honey !== "abcd1234-{$now}") {
        wp_die(__("You filled out unauthorized control element...", "KT_CORE_DOMAIN"));
        exit;
    }
    /* Some stuff */
}

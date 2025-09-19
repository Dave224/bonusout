<?php
/*
Template Name: Nenalezený brand
*/
global $post;
?>
<?php get_header(); ?>

    <div class="custom-wrapper relative">
        <div class="space-page-wrapper relative space-page-content hp-top-text">
            <h1 class="main-title"><?= get_the_title($post->ID); ?></h1>
            <?= apply_filters('the_content', $post->post_content); ?>
        </div>
    </div>

<?php get_template_part( FOUR_CROWNS_THEME_PARTS . '/listing' ); ?>

<?php get_footer(); ?>
<?php
/*
Template Name: Homepage
*/
use utils\Util;

$banners = Fourcrowns_Storage::get('post', get_queried_object_id(), BANNER);
$favourite_tags = Fourcrowns_Storage::get('post', get_queried_object_id(), FAVOURITE_TAGS);
$fav_iterator = 0;
?>
<?php get_header(); ?>

<?php get_template_part( FOUR_CROWNS_THEME_PARTS . '/top-brands-hp' ); ?>

<?php get_template_part( FOUR_CROWNS_THEME_PARTS . '/listing' ); ?>

<?php if (Util::arrayIssetAndNotEmpty($banners) && Util::issetAndNotEmpty($banners[0][BANNER . '_title'])) {
    get_template_part(FOUR_CROWNS_THEME_PARTS . '/banner', null, $args = [
        'banner' => $banners[0],
    ]);
} ?>

<?php get_template_part( FOUR_CROWNS_THEME_PARTS . '/tabs' ); ?>

<?php if (Util::arrayIssetAndNotEmpty($favourite_tags) && Util::issetAndNotEmpty($favourite_tags[0][FAVOURITE_TAGS . '_title'])) {
    foreach ($favourite_tags as $favourite_tag) {
        get_template_part(FOUR_CROWNS_THEME_PARTS . '/favourite-tags', null, $args = [
            'tags' => $favourite_tag,
        ]);
        $fav_iterator++;
    }
} ?>


<?php get_template_part( FOUR_CROWNS_THEME_PARTS . '/slider' ); ?>

<?php if (Util::arrayIssetAndNotEmpty($banners) && Util::issetAndNotEmpty($banners[1][BANNER . '_title'])) {
    get_template_part(FOUR_CROWNS_THEME_PARTS . '/banner', null, $args = [
        'banner' => $banners[1],
    ]);
} ?>


<?php if (Util::arrayIssetAndNotEmpty($banners) && Util::issetAndNotEmpty($banners[2][BANNER . '_title'])) {
    get_template_part(FOUR_CROWNS_THEME_PARTS . '/banner', null, $args = [
        'banner' => $banners[2],
    ]);
} ?>

<?php get_template_part( FOUR_CROWNS_THEME_PARTS . '/counter' ); ?>


<?php get_footer(); ?>
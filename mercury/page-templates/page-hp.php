<?php
/*
Template Name: Homepage
*/
use utils\Util;

$banners = Fourcrowns_Storage::get('post', get_queried_object_id(), BANNER);
?>
<?php get_header(); ?>

<!-- Title Box Start -->

<div class="space-archive-title-box box-100 relative">
	<div class="space-archive-title-box-ins space-page-wrapper relative">
		<div class="space-archive-title-box-h1 relative">
			<h1><?php the_title(); ?></h1>
		</div>
	</div>
</div>

<?php get_template_part( FOUR_CROWNS_THEME_PARTS . '/top-brands-hp' ); ?>
<?php if (Util::arrayIssetAndNotEmpty($banners) && Util::issetAndNotEmpty($banners[0][BANNER . '_title'])) {
    get_template_part(FOUR_CROWNS_THEME_PARTS . '/banner', null, $args = [
            'banner' => $banners[0],
    ]);
} ?>

<?php get_template_part( FOUR_CROWNS_THEME_PARTS . '/slider' ); ?>

<?php if (Util::arrayIssetAndNotEmpty($banners) && Util::issetAndNotEmpty($banners[1][BANNER . '_title'])) {
    get_template_part(FOUR_CROWNS_THEME_PARTS . '/banner', null, $args = [
        'banner' => $banners[1],
    ]);
} ?>

<?php get_template_part( FOUR_CROWNS_THEME_PARTS . '/tabs' ); ?>

<?php if (Util::arrayIssetAndNotEmpty($banners) && Util::issetAndNotEmpty($banners[2][BANNER . '_title'])) {
    get_template_part(FOUR_CROWNS_THEME_PARTS . '/banner', null, $args = [
        'banner' => $banners[2],
    ]);
} ?>

<?php get_template_part( FOUR_CROWNS_THEME_PARTS . '/listing' ); ?>


<?php get_footer(); ?>
<?php ?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" id="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, minimum-scale=1.0, user-scalable=yes" />
	<?php wp_head(); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<?= Fourcrowns_Storage::get('option', null, 'custom-settings-header-code'); ?>
    <?php if (is_single()) {
        require_once(FOUR_CROWNS_THEME_FUNCTIONS . 'SchemaGenerator.php'); ?>
    <?php } ?>
</head>
<body ontouchstart <?php body_class(); ?>>
<?= Fourcrowns_Storage::get('option', null, 'custom-settings-body-start-code'); ?>
<?php wp_body_open(); ?>
<div class="space-box relative<?php if( get_theme_mod('mercury_boxed_layout') ) { ?> enabled<?php } ?>">

<!-- Header Start -->

<?php
	$header_style = get_theme_mod('mercury_header_style');

	if ($header_style == 2) {
		get_template_part( '/theme-parts/header/style-2' );
	} else {
		get_template_part( '/theme-parts/header/style-1' );
	}
?>

<div class="space-header-search-block fixed">
	<div class="space-header-search-block-ins absolute">
		<?php get_search_form(); ?>
	</div>
	<div class="space-close-icon desktop-search-close-button absolute">
		<div class="to-right absolute"></div>
		<div class="to-left absolute"></div>
	</div>
</div>

<!-- Header End -->
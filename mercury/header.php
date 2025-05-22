<?php ?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" id="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, minimum-scale=1.0, user-scalable=yes" />
	<?php wp_head(); ?>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-PP27NYFDE6"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-PP27NYFDE6');
</script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body ontouchstart <?php body_class(); ?>>
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
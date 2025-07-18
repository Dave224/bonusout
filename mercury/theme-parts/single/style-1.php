<?php
use utils\Util;
?>
<!-- Title Box Start -->

<div class="space-title-box box-100 relative">
	<div class="space-title-box-ins space-page-wrapper relative">
		<div class="space-title-box-h1 relative">
			<h1><?php the_title(); ?></h1>
			<?php if(has_excerpt()){ ?>
				<div class="space-page-content-excerpt box-100 relative">
					<?php the_excerpt(); ?>
				</div>
			<?php } ?>

			<!-- Breadcrumbs Start -->

			<?php get_template_part( '/theme-parts/breadcrumbs' ); ?>

			<!-- Breadcrumbs End -->
		
		</div>
	</div>
</div>
<div class="space-title-box-category-wrap relative">
	<div class="space-title-box-category relative">
		<?php the_category(' '); ?>
	</div>
</div>

<!-- Title Box End -->

<!-- Page Section Start -->

<div class="space-page-section box-100 relative">
	<div class="space-page-section-ins space-page-wrapper relative">
		<div class="space-content-section box-75 left relative">
			<div class="space-page-content-wrap relative">

				<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
				<?php if(function_exists('spacethemes_set_post_views')) { spacethemes_set_post_views(get_the_ID()); } ?>

				<!-- Author Info Start -->

				<?php
					if(!get_theme_mod('mercury_author_info_block')) {
						get_template_part('/theme-parts/author-info');
					}
				?>

				<!-- Author Info End -->

				<div class="space-page-content-box-wrap relative">
					<div class="space-page-content box-100 relative">
						<?php
							the_content();
							wp_link_pages( array(
								'before'      => '<div class="clear"></div><nav class="navigation pagination-post">' . esc_html__( 'Pages:', 'mercury' ),
								'after'       => '</nav>',
								'link_before' => '<span class="page-number">',
								'link_after'  => '</span>',
							) );
						?>
					</div>
				</div>

				<?php endwhile; ?>
				<?php endif; ?>

				<?php
					the_tags('<div class="space-page-content-tags box-100 relative"><span><i class="fa fa-tags" aria-hidden="true"></i> </span>', ', ', '</div>');
				?>

			</div>

			<?php if( get_theme_mod('mercury_related_posts') ) { ?>

			<!-- Read More Start -->
			<?php get_template_part( '/theme-parts/related-posts' ); ?>

			<!-- Read More End -->

			<?php } ?>

            <?php get_template_part(FOUR_CROWNS_THEME_PARTS . '/recommended'); ?>

            <?php if ( comments_open() || get_comments_number() ) :?>

			<!-- Comments Start -->

			<?php comments_template(); ?>

			<!-- Comments End -->

			<?php endif; ?>

		</div>
		<div class="space-sidebar-section box-25 right relative">

			<?php get_sidebar(); ?>

		</div>
	</div>
</div>

<?php
$bottomBar = get_post_meta(get_the_ID(), POST_BOTTOM_BAR . '_bottom_bar', true);
$postTerms = wp_get_post_terms(get_the_ID(), 'category');
$removeBottomBar = false;
$categoryId = null;
foreach($postTerms as $postTerm) {
    $useSettings = get_term_meta($postTerm->term_id, CATEGORY_BOTTOM_BAR . '_bottom_bar', true);
    if (Util::issetAndNotEmpty($useSettings) && $useSettings !== 'disabled') {
        $removeBottomBar = true;
        break;
    }
}

if ($bottomBar === 'disabled' && !$removeBottomBar) {
    get_template_part(FOUR_CROWNS_THEME_PARTS . '/bottom-bar');
}
?>

<!-- Page Section End -->
<?php get_header(); ?>

<!-- Title Box Start -->

<div class="space-archive-title-box box-100 relative">
	<div class="space-archive-title-box-ins space-page-wrapper relative">
		<div class="space-archive-title-box-h1 relative">
			<h1><?php single_cat_title(''); ?></h1>
			
			<!-- Breadcrumbs Start -->

			<?php get_template_part( '/theme-parts/breadcrumbs' ); ?>

			<!-- Breadcrumbs End -->
		</div>
	</div>
</div>

<!-- Title Box End -->

<?php get_template_part( FOUR_CROWNS_THEME_PARTS . '/top-brands' ); ?>

<!-- Archive Section Start -->

<div class="space-archive-section box-100 relative">
	<div class="space-archive-section-ins space-page-wrapper relative">
		<div class="space-content-section box-75 left relative">

			<div class="space-archive-loop box-100 relative">

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( '/theme-parts/archive/loop' ); ?>

				<?php endwhile; ?>

				<!-- Archive Navigation Start -->

				<?php
					the_posts_pagination( array(
						'end_size' => 2,
						'prev_text'    => esc_html__('&laquo;', 'mercury'),
						'next_text'    => esc_html__('&raquo;', 'mercury'),
					));
				?>

				<!-- Archive Navigation End -->

				<?php else : ?>

				<!-- Posts not found Start -->

				<div class="space-page-content-wrap relative">
					<div class="space-page-content page-template box-100 relative">
						<h2><?php esc_html_e( 'No posts has been found.', 'mercury' ); ?></h2>
						<p>
							<?php esc_html_e( 'No posts has been found. Please return to the homepage.', 'mercury' ); ?>
						</p>
					</div>
				</div>

				<!-- Posts not found End -->

				<?php endif; ?>

				<!-- Category Description Start -->

				<?php if( !is_paged() ) {
					if (category_description()) { ?>

				<div class="space-taxonomy-description box-100 relative" style="margin-top: 45px;">
					<div class="space-page-content case-15 relative">
						<?php echo wp_kses_post(category_description()); ?>
					</div>
				</div>

				<?php }
				} ?>

				<!-- Category Description End -->

			</div>
		</div>
		<div class="space-sidebar-section box-25 left relative">

			<?php get_sidebar(); ?>

		</div>
	</div>
</div>

<!-- Archive Section End -->

<?php get_footer(); ?>
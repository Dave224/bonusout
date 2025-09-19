<?php
$firstLinkTitle = Fourcrowns_Storage::get('option', null, CUSTOM_SETTINGS_POST_DETAIL . '_trustworthy_title');
$firstLinkPage = Fourcrowns_Storage::get('option', null, CUSTOM_SETTINGS_POST_DETAIL . '_trustworthy_page');
$secondLinkTitle = Fourcrowns_Storage::get('option', null, CUSTOM_SETTINGS_POST_DETAIL . '_rating_title');
$secondLinkPage = Fourcrowns_Storage::get('option', null, CUSTOM_SETTINGS_POST_DETAIL . '_rating_page');
$firstLinkPageUrl = get_permalink($firstLinkPage);
$secondLinkPageUrl = get_permalink($secondLinkPage);
?>

<div class="space-page-content-meta box-100 relative">
	<div class="space-page-content-meta-avatar absolute">
		<?php echo get_avatar( get_the_author_meta('user_email'), 50 ); ?>
	</div>
	<div class="space-page-content-meta-ins relative">
		<div class="space-page-content-meta-author relative">
			<?php the_author_posts_link(); ?>
		</div>
		<div class="space-page-content-meta-data relative">
			<div class="space-page-content-meta-data-ins relative">

				<?php if( !get_theme_mod('mercury_date_display') ) { ?>
										<span class="date"><i class="far fa-clock"></i> <?= get_the_date("d. m. Y"); ?></span>

					 <?php if (get_the_date() != get_the_modified_date()) { ?>
                        <span class="date"><i class="fa fa-refresh"></i> <?= __("Aktualizováno:", "BO"); ?> <?= get_the_modified_date("d. m. Y"); ?></span>
                    <?php } ?>
				<?php } ?>

				<?php if ( comments_open() ) { ?>
					<span><i class="far fa-comment"></i> <?php comments_number( '0', '1', '%' ); ?></span>
				<?php } ?>

				<?php if(function_exists('spacethemes_set_post_views')) { ?>
					<span><i class="fas fa-eye"></i> <?php echo esc_html(spacethemes_get_post_views(get_the_ID())); ?></span>
				<?php } ?>

			</div>
		</div>
		<div class="space-page-content-meta-data relative" style="margin-top: 10px;">
            <div class="space-page-content-meta-data-ins relative">
                <span><i class="far fa-check-circle"></i><a class="author-info-link" href="<?= $firstLinkPageUrl; ?>"><?= $firstLinkTitle; ?></a></span>
                <span><i class="fas fa-search"></i><a class="author-info-link" href="<?= $secondLinkPageUrl; ?>"><?= $secondLinkTitle; ?></a></span>
            </div>
        </div>
	</div>
</div>
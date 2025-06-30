<?php
use utils\Util;

$background = Fourcrowns_Storage::get('post', get_queried_object_id(), TABS . '_background');
$tabs = Fourcrowns_Storage::get('post', get_queried_object_id(), TABS);
?>

<div class="custom-wrapper relative <?= $background; ?>">
    <div class="space-page-wrapper">
        <div class="custom-tabs-wrapper">
            <?php if (Util::arrayIssetAndNotEmpty($tabs) && $tabs != []) { ?>
                <!-- Záložky -->
                <ul class="custom-tabs-nav">
                    <?php foreach ($tabs as $key => $tab) { ?>
                        <li <?php if ($key == 0) { ?>class="active"<?php } ?> data-tab="<?= sanitize_title($tab[TABS . '_title']); ?>"><?= $tab[TABS . '_title']; ?></li>
                    <?php } ?>
                </ul>

                <!-- Obsah jednotlivých tabů -->
                <div class="custom-tabs-content">
                    <?php foreach ($tabs as $key => $tab) { ?>
                        <div class="custom-tab-panel <?php if ($key == 0) { ?>active<?php } ?>" data-tab="<?= sanitize_title($tab[TABS . '_title']); ?>">
                            <?php if (Util::issetAndNotEmpty($tab[TABS . '_title']) || Util::issetAndNotEmpty($tab[TABS . '_description'])) { ?>
                                <div class="section-heading">
                                    <?php if (Util::issetAndNotEmpty($tab[TABS . '_title'])) { ?>
                                        <h2 class="section-title"><?= $tab[TABS . '_title']; ?></h2>
                                    <?php } ?>
                                    <?php if (Util::issetAndNotEmpty($tab[TABS . '_description'])) { ?>
                                        <p class="section-description"><?= $tab[TABS . '_description']; ?></p>
                                    <?php } ?>
                                </div>
                            <?php } ?>

                            <?php get_template_part(FOUR_CROWNS_THEME_PARTS . '/tab-slider', null, ['category' => $tab[TABS . '_category']]); ?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
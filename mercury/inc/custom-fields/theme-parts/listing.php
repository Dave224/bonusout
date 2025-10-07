<?php
use utils\Util;
use utils\Image;

$id = get_queried_object_id();

if (!is_front_page()) {
    $id = get_option('page_on_front');
}

$background = Fourcrowns_Storage::get('post', $id, LISTING . '_background');
$title = Fourcrowns_Storage::get('post', $id, LISTING . '_section_title');
$description = Fourcrowns_Storage::get('post', $id, LISTING . '_section_description');

$firstTitle = Fourcrowns_Storage::get('post', $id, LISTING . '_title_first');
$firstItems = Fourcrowns_Storage::get('post', $id, LISTING . '_first');
$firstButtonUrl = Fourcrowns_Storage::get('post', $id, LISTING . '_button_url_first');
$firstButtonTitle = Fourcrowns_Storage::get('post', $id, LISTING . '_button_title_first');

$secondTitle = Fourcrowns_Storage::get('post', $id, LISTING . '_title_second');
$secondItems = Fourcrowns_Storage::get('post', $id, LISTING . '_second');
$secondButtonUrl = Fourcrowns_Storage::get('post', $id, LISTING . '_button_url_second');
$secondButtonTitle = Fourcrowns_Storage::get('post', $id, LISTING . '_button_title_second');

$thirdTitle = Fourcrowns_Storage::get('post', $id, LISTING . '_title_third');
$thirdItems = Fourcrowns_Storage::get('post', $id, LISTING . '_third');
$thirdButtonUrl = Fourcrowns_Storage::get('post', $id, LISTING . '_button_url_third');
$thirdButtonTitle = Fourcrowns_Storage::get('post', $id, LISTING . '_button_title_third');

$firstRank = 1;
$secondRank = 1;
$thirdRank = 1;
?>

<div class="custom-wrapper relative <?= $background; ?>">
    <?php if (Util::issetAndNotEmpty($title) || Util::issetAndNotEmpty($description)) { ?>
        <!-- Záhlaví sekce -->
        <div class="section-heading">
            <?php if (Util::issetAndNotEmpty($title)) { ?>
                <h2 class="section-title"><?= $title; ?></h2>
            <?php } ?>
            <?php if (Util::issetAndNotEmpty($description)) { ?>
                <p class="section-description"><?= $description; ?></p>
            <?php } ?>
        </div>
    <?php } ?>

    <div class="space-page-wrapper listing-custom-wrapper">
        <div class="listing-columns-wrapper">
            <div class="listing-column">
                <?php if (Util::issetAndNotEmpty($firstTitle)) { ?>
                    <h2><?= $firstTitle; ?></h2>
                <?php } ?>
                <div class="listing-grid">
                    <?php if ($firstItems && $firstItems != []) { ?>
                        <?php foreach ($firstItems as $firstItem) { ?>
                            <div class="listing-card">
                                <div class="listing-link">
                                    <div class="listing-logo-wrap">
                                        <?php if (Util::issetAndNotEmpty($firstItem[LISTING . '_item_image_first'])) {
                                            $image = $firstItem[LISTING . '_item_image_first'];
                                            if (is_string($image)) {
                                                $decoded = json_decode($image, true);
                                                if (json_last_error() === JSON_ERROR_NONE) {
                                                    $image = $decoded;
                                                } else {
                                                    // fallback – může to být legacy URL string
                                                    $image = ['url' => $image];
                                                }
                                            }
                                            $imageUrl = $image['url'];
                                            ?>
                                            <a class="listing-logo" href="<?= $firstItem[LISTING . '_item_url_first']; ?>" target="_blank">
                                                <img src="<?= $imageUrl; ?>" alt="<?= $firstItem[LISTING . '_item_title_first']; ?>">
                                            </a>
                                        <?php } ?>
                                        <span class="listing-rank rank-over-img"><?= $firstRank; ?></span>
                                    </div>
                                    <div class="listing-content">
                                        <?php if (Util::issetAndNotEmpty($firstItem[LISTING . '_item_title_first'])) { ?>
                                            <a href="<?= $firstItem[LISTING . '_item_button_url_first']; ?>"><h3><?= $firstItem[LISTING . '_item_title_first']; ?></h3></a>
                                        <?php } ?>

                                        <div class="listing-btn-group">
                                            <?php if (Util::issetAndNotEmpty($firstItem[LISTING . '_item_button_url_first']) && Util::issetAndNotEmpty($firstItem[LISTING . '_item_third_button_title_first'])) { ?>
                                                <a href="<?= $firstItem[LISTING . '_item_button_url_first']; ?>" class="visit-btn secondary-btn btn"><?= $firstItem[LISTING . '_item_third_button_title_first']; ?></a>
                                            <?php } ?>
                                            <?php if (Util::issetAndNotEmpty($firstItem[LISTING . '_item_url_first']) && Util::issetAndNotEmpty($firstItem[LISTING . '_item_first_button_title_first'])) { ?>
                                                <a href="<?= $firstItem[LISTING . '_item_url_first']; ?>" class="visit-btn btn" target="_blank"><?= $firstItem[LISTING . '_item_first_button_title_first']; ?></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php $firstRank++; ?>
                        <?php } ?>
                    <?php } ?>
                    <?php if (Util::issetAndNotEmpty($firstButtonTitle) && Util::issetAndNotEmpty($firstButtonUrl)) { ?>
                        <a href="<?= $firstButtonUrl; ?>" class="listing-grid-cta btn-wide">
                            <?= $firstButtonTitle; ?>
                        </a>
                    <?php } ?>
                </div>
            </div>

            <div class="listing-column">
                <?php if (Util::issetAndNotEmpty($secondTitle)) { ?>
                    <h2><?= $secondTitle; ?></h2>
                <?php } ?>
                <div class="listing-grid">
                    <?php if ($secondItems && $secondItems != []) { ?>
                        <?php foreach ($secondItems as $secondItem) { ?>
                            <?php if (Util::issetAndNotEmpty($secondItem[LISTING . '_item_title_second'])) { ?>
                                <div class="listing-card">
                                    <div class="listing-link">
                                        <div class="listing-logo-wrap">
                                            <?php if (Util::issetAndNotEmpty($secondItem[LISTING . '_item_image_second'])) {
                                                $image = $secondItem[LISTING . '_item_image_second'];
                                                if (is_string($image)) {
                                                    $decoded = json_decode($image, true);
                                                    if (json_last_error() === JSON_ERROR_NONE) {
                                                        $image = $decoded;
                                                    } else {
                                                        // fallback – může to být legacy URL string
                                                        $image = ['url' => $image];
                                                    }
                                                }
                                                $imageUrl = $image['url'];
                                                ?>
                                                <a class="listing-logo" href="<?= $secondItem[LISTING . '_item_url_second']; ?>" target="_blank">
                                                    <img src="<?= $imageUrl; ?>" alt="<?= $secondItem[LISTING . '_item_title_second']; ?>">
                                                </a>
                                            <?php } ?>
                                            <span class="listing-rank rank-over-img"><?= $secondRank; ?></span>
                                        </div>
                                        <div class="listing-content">
                                            <?php if (Util::issetAndNotEmpty($secondItem[LISTING . '_item_title_second'])) { ?>
                                                <a href="<?= $secondItem[LISTING . '_item_button_url_second']; ?>"><h3><?= $secondItem[LISTING . '_item_title_second']; ?></h3></a>
                                            <?php } ?>

                                            <div class="listing-btn-group">
                                                <?php if (Util::issetAndNotEmpty($secondItem[LISTING . '_item_button_url_second']) && Util::issetAndNotEmpty($secondItem[LISTING . '_item_third_button_title_second'])) { ?>
                                                    <a href="<?= $secondItem[LISTING . '_item_button_url_second']; ?>" class="visit-btn secondary-btn btn"><?= $secondItem[LISTING . '_item_third_button_title_second']; ?></a>
                                                <?php } ?>
                                                <?php if (Util::issetAndNotEmpty($secondItem[LISTING . '_item_url_second']) && Util::issetAndNotEmpty($secondItem[LISTING . '_item_first_button_title_second'])) { ?>
                                                    <a href="<?= $secondItem[LISTING . '_item_url_second']; ?>" class="visit-btn btn" target="_blank"><?= $secondItem[LISTING . '_item_first_button_title_second']; ?></a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $secondRank++; ?>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                    <?php if (Util::issetAndNotEmpty($secondButtonTitle) && Util::issetAndNotEmpty($secondButtonUrl)) { ?>
                        <a href="<?= $secondButtonUrl; ?>" class="listing-grid-cta btn-wide">
                            <?= $secondButtonTitle; ?>
                        </a>
                    <?php } ?>
                </div>
            </div>

            <div class="listing-column">
                <?php if (Util::issetAndNotEmpty($thirdTitle)) { ?>
                    <h2><?= $thirdTitle; ?></h2>
                <?php } ?>
                <div class="listing-grid">
                    <?php if ($thirdItems && $thirdItems != []) { ?>
                        <?php foreach ($thirdItems as $thirdItem) { ?>
                            <?php if (Util::issetAndNotEmpty($thirdItem[LISTING . '_item_title_third'])) { ?>
                                <div class="listing-card">
                                    <div class="listing-link">
                                        <div class="listing-logo-wrap">
                                            <?php if (Util::issetAndNotEmpty($thirdItem[LISTING . '_item_image_third'])) {
                                                $image = $thirdItem[LISTING . '_item_image_third'];
                                                if (is_string($image)) {
                                                    $decoded = json_decode($image, true);
                                                    if (json_last_error() === JSON_ERROR_NONE) {
                                                        $image = $decoded;
                                                    } else {
                                                        // fallback – může to být legacy URL string
                                                        $image = ['url' => $image];
                                                    }
                                                }
                                                $imageUrl = $image['url'];
                                                ?>
                                                <a class="listing-logo" href="<?= $thirdItem[LISTING . '_item_url_third']; ?>" target="_blank">
                                                    <img src="<?= $imageUrl; ?>" alt="<?= $thirdItem[LISTING . '_item_title_third']; ?>">
                                                </a>
                                            <?php } ?>
                                            <span class="listing-rank rank-over-img"><?= $thirdRank; ?></span>
                                        </div>
                                        <div class="listing-content">
                                            <?php if (Util::issetAndNotEmpty($thirdItem[LISTING . '_item_title_third'])) { ?>
                                                <a href="<?= $thirdItem[LISTING . '_item_button_url_third']; ?>"><h3><?= $thirdItem[LISTING . '_item_title_third']; ?></h3></a>
                                            <?php } ?>

                                            <div class="listing-btn-group">
                                                <?php if (Util::issetAndNotEmpty($thirdItem[LISTING . '_item_button_url_third']) && Util::issetAndNotEmpty($thirdItem[LISTING . '_item_third_button_title_third'])) { ?>
                                                    <a href="<?= $thirdItem[LISTING . '_item_button_url_third']; ?>" class="visit-btn secondary-btn btn"><?= $thirdItem[LISTING . '_item_third_button_title_third']; ?></a>
                                                <?php } ?>
                                                <?php if (Util::issetAndNotEmpty($thirdItem[LISTING . '_item_url_third']) && Util::issetAndNotEmpty($thirdItem[LISTING . '_item_first_button_title_third'])) { ?>
                                                    <a href="<?= $thirdItem[LISTING . '_item_url_third']; ?>" class="visit-btn btn" target="_blank"><?= $thirdItem[LISTING . '_item_first_button_title_third']; ?></a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $thirdRank++; ?>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>

                    <?php if (Util::issetAndNotEmpty($thirdButtonTitle) && Util::issetAndNotEmpty($thirdButtonUrl)) { ?>
                        <a href="<?= $thirdButtonUrl; ?>" class="listing-grid-cta btn-wide">
                            <?= $thirdButtonTitle; ?>
                        </a>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>
</div>
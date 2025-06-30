<?php
use utils\Util;
use utils\Image;

$background = Fourcrowns_Storage::get('post', get_queried_object_id(), LISTING . '_background');
$title = Fourcrowns_Storage::get('post', get_queried_object_id(), LISTING . '_section_title');
$description = Fourcrowns_Storage::get('post', get_queried_object_id(), LISTING . '_section_description');

$firstTitle = Fourcrowns_Storage::get('post', get_queried_object_id(), LISTING . '_title_first');
$firstItems = Fourcrowns_Storage::get('post', get_queried_object_id(), LISTING . '_first');
$secondTitle = Fourcrowns_Storage::get('post', get_queried_object_id(), LISTING . '_title_second');
$secondItems = Fourcrowns_Storage::get('post', get_queried_object_id(), LISTING . '_second');
$thirdTitle = Fourcrowns_Storage::get('post', get_queried_object_id(), LISTING . '_title_third');
$thirdItems = Fourcrowns_Storage::get('post', get_queried_object_id(), LISTING . '_third');
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

    <div class="space-page-wrapper">
        <div class="listing-columns-wrapper">
            <div class="listing-column">
                <?php if (Util::issetAndNotEmpty($firstTitle)) { ?>
                    <h2><?= $firstTitle; ?></h2>
                <?php } ?>
                <div class="listing-grid">
                    <?php if ($firstItems && $firstItems != []) { ?>
                        <?php foreach ($firstItems as $firstItem) { ?>
                            <div class="listing-card">
                                <div class="listing-link" onclick="window.open('<?= $firstItem[LISTING . '_item_url_first']; ?>', '_blank');">
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
                                        $imageUrl = Image::getCloudImage($image['id'], 60, 60);
                                        ?>
                                        <div class="listing-logo">
                                            <img src="<?= $imageUrl; ?>" alt="<?= $firstItem[LISTING . '_item_title_first']; ?>">
                                        </div>
                                    <?php } ?>
                                    <div class="listing-content">
                                        <?php if (Util::issetAndNotEmpty($firstItem[LISTING . '_item_title_first'])) { ?>
                                            <h3><?= $firstItem[LISTING . '_item_title_first']; ?></h3>
                                        <?php } ?>
                                        <?php if (Util::issetAndNotEmpty($firstItem[LISTING . '_item_interest_title_first'])) { ?>
                                            <p class="listing-bonus"><?= $firstItem[LISTING . '_item_interest_title_first']; ?>: <?= $firstItem[LISTING . '_item_interest_value_first']; ?></p>
                                        <?php } ?>
                                        <?php if (Util::issetAndNotEmpty($firstItem[LISTING . '_item_button_title_first']) && Util::issetAndNotEmpty($firstItem[LISTING . '_item_button_url_first'])) { ?>
                                            <a href="<?= $firstItem[LISTING . '_item_button_url_first']; ?>" class="visit-btn btn" onclick="event.stopPropagation();"><?= $firstItem[LISTING . '_item_button_title_first']; ?></a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
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
                                    <div class="listing-link" onclick="window.open('<?= $secondItem[LISTING . '_item_url_second']; ?>', '_blank');">
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
                                            $imageUrl = Image::getCloudImage($image['id'], 60, 60);
                                            ?>
                                            <div class="listing-logo">
                                                <img src="<?= $imageUrl; ?>" alt="<?= $secondItem[LISTING . '_item_title_second']; ?>">
                                            </div>
                                        <?php } ?>
                                        <div class="listing-content">
                                            <?php if (Util::issetAndNotEmpty($secondItem[LISTING . '_item_title_second'])) { ?>
                                                <h3><?= $secondItem[LISTING . '_item_title_second']; ?></h3>
                                            <?php } ?>
                                            <?php if (Util::issetAndNotEmpty($secondItem[LISTING . '_item_interest_title_second'])) { ?>
                                                <p class="listing-bonus"><?= $secondItem[LISTING . '_item_interest_title_second']; ?>: <?= $secondItem[LISTING . '_item_interest_value_second']; ?></p>
                                            <?php } ?>
                                            <?php if (Util::issetAndNotEmpty($secondItem[LISTING . '_item_button_title_second']) && Util::issetAndNotEmpty($secondItem[LISTING . '_item_button_url_second'])) { ?>
                                                <a href="<?= $secondItem[LISTING . '_item_button_url_second']; ?>" class="visit-btn btn" onclick="event.stopPropagation();"><?= $secondItem[LISTING . '_item_button_title_second']; ?></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
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
                                    <div class="listing-link" onclick="window.open('<?= $thirdItem[LISTING . '_item_url_third']; ?>', '_blank');">
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
                                            $imageUrl = Image::getCloudImage($image['id'], 60, 60);
                                            ?>
                                            <div class="listing-logo">
                                                <img src="<?= $imageUrl; ?>" alt="<?= $thirdItem[LISTING . '_item_title_third']; ?>">
                                            </div>
                                        <?php } ?>
                                        <div class="listing-content">
                                            <?php if (Util::issetAndNotEmpty($thirdItem[LISTING . '_item_title_third'])) { ?>
                                                <h3><?= $thirdItem[LISTING . '_item_title_third']; ?></h3>
                                            <?php } ?>
                                            <?php if (Util::issetAndNotEmpty($thirdItem[LISTING . '_item_interest_title_third'])) { ?>
                                                <p class="listing-bonus"><?= $thirdItem[LISTING . '_item_interest_title_third']; ?>: <?= $thirdItem[LISTING . '_item_interest_value_third']; ?></p>
                                            <?php } ?>
                                            <?php if (Util::issetAndNotEmpty($thirdItem[LISTING . '_item_button_title_third']) && Util::issetAndNotEmpty($thirdItem[LISTING . '_item_button_url_third'])) { ?>
                                                <a href="<?= $thirdItem[LISTING . '_item_button_url_third']; ?>" class="visit-btn btn" onclick="event.stopPropagation();"><?= $thirdItem[LISTING . '_item_button_title_third']; ?></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>
</div>
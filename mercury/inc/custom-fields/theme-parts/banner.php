<?php
use utils\Util;
use utils\Image;

$banner = $args[BANNER];

if (Util::issetAndNotEmpty($banner[BANNER . '_image'])) {
    $image = $banner[BANNER . '_image'];
    if (is_string($image)) {
        $decoded = json_decode($image, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $image = $decoded;
        } else {
            // fallback – může to být legacy URL string
            $image = ['url' => $image];
        }
    }
    if ($banner[BANNER . '_variant'] == 'with-background') {
        $imageUrl = Image::getCloudImage($image['id'], 1200, null);
    } else {
        $imageUrl = Image::getCloudImage($image['id'], 100, 100);
    }
}
?>

<div class="custom-wrapper relative <?= $banner[BANNER . '_background']; ?>">
    <section class="custom-banner space-page-wrapper <?= $banner[BANNER . '_variant']; ?>"
        <?php if (Util::issetAndNotEmpty($imageUrl) && $banner[BANNER . '_variant'] == 'with-background') { ?>
            style="background-image: url(<?= $imageUrl; ?>);
                   background-size: cover;
                   background-position: center;"
        <?php } ?>>
        <div class="banner-wrapper">

            <?php if (Util::issetAndNotEmpty($imageUrl) && $banner[BANNER . '_variant'] == 'with-logo') { ?>
                <!-- Logo varianta -->
                <div class="banner-image">
                    <img src="<?= $imageUrl; ?>" alt="<?= $banner[BANNER . '_title']; ?>">
                </div>
            <?php } ?>

            <?php if (Util::issetAndNotEmpty($banner[BANNER . '_title']) || Util::issetAndNotEmpty($banner[BANNER . '_description'])) { ?>
                <div class="banner-text">
                    <?php if (Util::issetAndNotEmpty($banner[BANNER . '_title'])) { ?>
                        <h2><?= $banner[BANNER . '_title']; ?></h2>
                    <?php } ?>
                    <?php if (Util::issetAndNotEmpty($banner[BANNER . '_description'])) { ?>
                        <p><?= $banner[BANNER . '_description']; ?></p>
                    <?php } ?>
                </div>
            <?php } ?>

            <?php if (Util::issetAndNotEmpty($banner[BANNER . '_url'])) { ?>
                <div class="banner-cta">
                    <a href="<?= $banner[BANNER . '_url']; ?>" class="banner-button btn">
                        <?= $banner[BANNER . '_button_text']; ?>
                    </a>
                </div>
            <?php } ?>

        </div>
    </section>
</div>

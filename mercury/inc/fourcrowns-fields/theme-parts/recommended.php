<?php
use utils\Util;
use utils\Image;

$background = Fourcrowns_Storage::get('post', get_queried_object_id(), RECOMMENDED . '_background');
$title = Fourcrowns_Storage::get('post', get_queried_object_id(), RECOMMENDED . '_section_title');
$description = Fourcrowns_Storage::get('post', get_queried_object_id(), RECOMMENDED . '_section_description');

$recommendedItems = Fourcrowns_Storage::get('post', get_queried_object_id(), RECOMMENDED);
?>

<?php if ($recommendedItems && Util::issetAndNotEmpty($title)) { ?>
    <div class="expert-slider-section custom-wrapper relative <?= $background; ?>">
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


        <div class="swiper expert-slider">
            <div class="swiper-wrapper">
                <?php foreach ($recommendedItems as $item) { ?>
                    <?php if ($item[RECOMMENDED . '_item_title']) {
                        $image = $item[RECOMMENDED . '_item_image'];
                        if (is_string($image)) {
                            $decoded = json_decode($image, true);
                            if (json_last_error() === JSON_ERROR_NONE) {
                                $image = $decoded;
                            } else {
                                // fallback – může to být legacy URL string
                                $image = ['url' => $image];
                            }
                        }
                        $imageUrl = Image::getCloudImage($image['id'], 80, 80);
                        ?>
                        <div class="swiper-slide">
                            <div class="casino-card">
                                <img src="<?= $imageUrl; ?>" alt="<?= $item[RECOMMENDED . '_item_title']; ?>">
                                <h3><?= $item[RECOMMENDED . '_item_title']; ?></h3>
                                <?php if ($item[RECOMMENDED . '_item_button_text'] && $item[RECOMMENDED . '_item_button_url']) { ?>
                                    <a href="<?= $item[RECOMMENDED . '_item_button_url']; ?>" class="play-button btn"><?= $item[RECOMMENDED . '_item_button_text']; ?></a>
                                <?php } ?>
                                <?php if ($item[RECOMMENDED . '_item_description']) { ?>
                                    <span class="tnc-text"><?= $item[RECOMMENDED . '_item_description']; ?></span>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
            <!-- Šipky -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
<?php } ?>
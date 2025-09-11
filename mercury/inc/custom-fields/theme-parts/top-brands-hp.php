<?php
use utils\Image;
use utils\Util;

$mainTitle = Fourcrowns_Storage::get('post', get_queried_object_id(), MAIN_INFO . '_title');
$mainDescription = Fourcrowns_Storage::get('post', get_queried_object_id(), MAIN_INFO . '_description');

$topBrands = Fourcrowns_Storage::get('post', get_queried_object_id(), TOP_BRANDS);
$background = Fourcrowns_Storage::get('post', get_queried_object_id(), TOP_BRANDS . '_background');
$title = Fourcrowns_Storage::get('post', get_queried_object_id(), TOP_BRANDS . '_section_title');
$description = Fourcrowns_Storage::get('post', get_queried_object_id(), TOP_BRANDS . '_section_description');
$under_description = Fourcrowns_Storage::get('post', get_queried_object_id(), TOP_BRANDS . '_under_section_description');

$key = 1;
?>

<?php if ($mainTitle || $mainDescription) { ?>
    <div class="custom-wrapper relative">
        <div class="space-page-wrapper relative space-page-content hp-top-text">
            <h1 class="main-title"><?= $mainTitle; ?></h1>
            <?= $mainDescription; ?>
        </div>
    </div>
<?php } ?>

<?php if ($topBrands && $topBrands != []) { ?>
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

        <div class="custom-container custom-hp-container space-page-wrapper relative">
            <?php foreach ($topBrands as $topBrand) { ?>
                <?php if ($topBrand['top_brands_title']) {
                    $image = $topBrand['top_brands_image'];
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
                    <a class="custom-column dynamic-typewriter" target="_blank" href="<?= $topBrand['top_brands_url']; ?>" rel="noopener">
                        <div class="star-rating"><i class="fas fa-star"></i><?= $key; ?></div>
                        <img src="<?= $imageUrl; ?>" alt="<?= $topBrand['top_brands_title']; ?>">
                        <h3><?= $topBrand['top_brands_title']; ?></h3>
                    </a>
                <?php } ?>
                <?php $key++;
            } ?>
        </div>
    </div>
<?php } ?>

<?php if ($under_description) { ?>
    <div class="custom-wrapper relative">
        <div class="space-page-wrapper relative space-page-content box-100">
            <?= $under_description; ?>
        </div>
    </div>
<?php } ?>

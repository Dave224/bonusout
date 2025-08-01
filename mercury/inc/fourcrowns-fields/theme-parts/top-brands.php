<?php
use utils\Image;

$term_id = get_queried_object()->term_id;
$mainSettings = Fourcrowns_Storage::get('option', null, CUSTOM_SETTINGS_TOP_BRANDS . '_use_settings');

if ($mainSettings && $mainSettings != 'disabled') {
    $topBrands = Fourcrowns_Storage::get('option', null, CUSTOM_SETTINGS_TOP_BRANDS);
    $titleKey = CUSTOM_SETTINGS_TOP_BRANDS . '_title';
    $imageKey = CUSTOM_SETTINGS_TOP_BRANDS . '_image';
    $urlKey = CUSTOM_SETTINGS_TOP_BRANDS . '_url';
} else {
    $topBrands = Fourcrowns_Storage::get('term', $term_id, CATEGORY_TOP_BRANDS);
    $titleKey = CATEGORY_TOP_BRANDS . '_title';
    $imageKey = CATEGORY_TOP_BRANDS . '_image';
    $urlKey = CATEGORY_TOP_BRANDS . '_url';
}
;
$key = 1;
?>
<?php if ($topBrands && $topBrands != []) { ?>
    <div class="custom-wrapper custom-category-brands-wrapper relative">
        <div class="custom-container space-page-wrapper relative">
            <?php foreach ($topBrands as $topBrand) { ?>
                <?php if ($topBrand[$titleKey]) {
                    $image = $topBrand[$imageKey];
                    if (is_string($image)) {
                        $decoded = json_decode($image, true);
                        if (json_last_error() === JSON_ERROR_NONE) {
                            $image = $decoded;
                        } else {
                            // fallback – může to být legacy URL string
                            $image = ['url' => $image];
                        }
                    }
                    $imageUrl = Image::getCloudImage($image['id'], 270, 270);
                    ?>
                    <a class="custom-column dynamic-typewriter" target="_blank" href="<?= $topBrand[$urlKey]; ?>" rel="noopener">
                        <div class="star-rating"><i class="fas fa-star"></i><?= $key; ?></div>
                        <?php if ($imageUrl) { ?>
                            <img src="<?= $imageUrl; ?>" alt="<?= $topBrand[$titleKey]; ?>">
                        <?php } ?>
                        <h3><?= $topBrand[$titleKey]; ?></h3>
                    </a>
                <?php } ?>
            <?php $key++;
            } ?>
        </div>
    </div>
<?php } ?>
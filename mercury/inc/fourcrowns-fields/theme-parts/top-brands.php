<?php
use utils\Image;

$term_id = get_queried_object()->term_id;
$topBrands = Fourcrowns_Storage::get('term', $term_id, CATEGORY_TOP_BRANDS);
$key = 1;
?>
<?php if ($topBrands && $topBrands != []) { ?>
    <div class="custom-wrapper custom-category-brands-wrapper relative">
        <div class="custom-container space-page-wrapper relative">
            <?php foreach ($topBrands as $topBrand) { ?>
                <?php if ($topBrand[CATEGORY_TOP_BRANDS . '_title']) {
                    $image = $topBrand[CATEGORY_TOP_BRANDS . '_image'];
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
                    <a class="custom-column dynamic-typewriter" target="_blank" href="<?= $topBrand[CATEGORY_TOP_BRANDS . '_url']; ?>" rel="noopener">
                        <div class="star-rating"><i class="fas fa-star"></i><?= $key; ?></div>
                        <?php if ($imageUrl) { ?>
                            <img src="<?= $imageUrl; ?>" alt="<?= $topBrand[CATEGORY_TOP_BRANDS . '_title']; ?>">
                        <?php } ?>
                        <h3><?= $topBrand[CATEGORY_TOP_BRANDS . '_title']; ?></h3>
                        <span class="hidden-text" style="display:none"><?= __('Navštívit', 'SLOTH'); ?></span>
                    </a>
                <?php } ?>
            <?php $key++;
            } ?>
        </div>
    </div>
<?php } ?>
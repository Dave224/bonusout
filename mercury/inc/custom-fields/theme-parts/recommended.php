<?php
use utils\Util;
use utils\Image;

$postTerms = wp_get_post_terms(get_the_ID(), 'category');
$postId = get_the_ID();

$useCategorySettings = false;
$categoryId = null;
foreach($postTerms as $postTerm) {
    $useSettings = get_term_meta($postTerm->term_id, CATEGORY_RECOMMENDED . '_show', true);
    if (Util::issetAndNotEmpty($useSettings) && $useSettings !== 'disabled') {
        $useCategorySettings = true;
        $categoryId = $postTerm->term_id;
        break;
    }
}

$recommendedItems = [];

$mainRecommended = get_option(CUSTOM_SETTINGS_RECOMMENDED . '_show');
if (get_post_meta($postId, RECOMMENDED . '_section_title', true)) {
    $background = Fourcrowns_Storage::get('post', get_queried_object_id(), RECOMMENDED . '_background');
    $title = Fourcrowns_Storage::get('post', get_queried_object_id(), RECOMMENDED . '_section_title');
    $description = Fourcrowns_Storage::get('post', get_queried_object_id(), RECOMMENDED . '_section_description');
    $recommendedItems = Fourcrowns_Storage::get('post', get_queried_object_id(), RECOMMENDED);
    $prefix = RECOMMENDED;
} else if ($useCategorySettings) {
    $background = get_term_meta($categoryId, CATEGORY_RECOMMENDED . '_background', true);
    $title = get_term_meta($categoryId, CATEGORY_RECOMMENDED . '_section_title', true);
    $description = get_term_meta($categoryId, CATEGORY_RECOMMENDED . '_section_description', true);
    $recommendedItems = get_term_meta($categoryId, CATEGORY_RECOMMENDED, true);
    $prefix = CATEGORY_RECOMMENDED;
} else if ($mainRecommended && $mainRecommended != "disabled") {
    $background = get_option(CUSTOM_SETTINGS_RECOMMENDED . '_background');
    $title = get_option(CUSTOM_SETTINGS_RECOMMENDED . '_section_title');
    $description = get_option(CUSTOM_SETTINGS_RECOMMENDED . '_section_description');
    $recommendedItems = get_option(CUSTOM_SETTINGS_RECOMMENDED);
    $prefix = CUSTOM_SETTINGS_RECOMMENDED;
}

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
                    <?php if ($item[$prefix . '_item_title']) {
                        $image = $item[$prefix . '_item_image'];
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
                        <div class="swiper-slide">
                            <div class="casino-card">
                                <a href="<?= $item[$prefix . '_item_button_url']; ?>" target="_blank" rel="noopener nofollow"><img src="<?= $imageUrl; ?>" alt="<?= $item[$prefix . '_item_title']; ?>"></a>
                                <a class="recommended-title-link" href="<?= $item[$prefix . '_item_external_url']; ?>"><h3><?= $item[$prefix . '_item_title']; ?></h3></a>
                                <?php if ($item[$prefix . '_item_button_text'] && $item[$prefix . '_item_button_url']) { ?>
                                    <a href="<?= $item[$prefix . '_item_button_url']; ?>" class="play-button btn"><?= $item[$prefix . '_item_button_text']; ?></a>
                                <?php } ?>
                                <?php if ($item[$prefix . '_item_description']) { ?>
                                    <span class="tnc-text"><?= $item[$prefix . '_item_description']; ?></span>
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
<?php
$term_id = get_queried_object()->term_id;
// Zobrazení obrázků a textových polí
$termData = [];
$image_ids = [];
for ($i = 1; $i <= 6; $i++) {
    $image_ids[$i] = get_term_meta($term_id, '_category_image_' . $i, true);
    $termData[$i]['image'] = $image_ids[$i];
}

// Získání hodnot pro textová pole
$text_values = [];
for ($i = 1; $i <= 6; $i++) {
    $text_values[$i] = get_term_meta($term_id, '_category_text_' . $i, true);
    $termData[$i]['title'] = $text_values[$i];
}

// Získání hodnot pro textová pole
$url_values = [];
for ($i = 1; $i <= 6; $i++) {
    $url_values[$i] = get_term_meta($term_id, '_category_url_' . $i, true);
    $termData[$i]['url'] = $url_values[$i];
}
?>
<?php if (!empty($image_ids[1]) || !empty($url_values[1]) || !empty($text_values[1])) { ?>
    <div class="custom-wrapper relative">
        <div class="custom-container space-page-wrapper relative">
            <?php foreach ($termData as $key => $termItem) {
                if ($termItem['image']) {
                    $image_url = wp_get_attachment_url($termItem['image']);
                } ?>
                <?php if ($termItem['title']) { ?>
                    <a class="custom-column" target="_blank" href="<?= $termItem['url']; ?>" rel="noopener">
                        <div class="star-rating"><i class="fas fa-star"></i><?= $key; ?></div>
                        <img src="<?= $image_url; ?>" alt="<?= $termItem['title']; ?>">
                        <h3><?= $termItem['title']; ?></h3>
                    </a>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
<?php } ?>
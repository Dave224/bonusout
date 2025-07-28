<?php
use utils\Util;

$background = Fourcrowns_Storage::get('post', get_queried_object_id(), COUNTER . '_background');
$title = Fourcrowns_Storage::get('post', get_queried_object_id(), COUNTER . '_section_title');
$description = Fourcrowns_Storage::get('post', get_queried_object_id(), COUNTER . '_section_description');
$under_description = Fourcrowns_Storage::get('post', get_queried_object_id(), COUNTER . '_under_section_description');
$numbers = Fourcrowns_Storage::get('post', get_queried_object_id(), COUNTER);
?>

<?php if (is_array($numbers) || Util::issetAndNotEmpty($title) || Util::issetAndNotEmpty($description)) { ?>
    <div class="custom-wrapper relative <?= $background; ?>">
        <?php if (Util::issetAndNotEmpty($title) || Util::issetAndNotEmpty($description)) { ?>
            <div class="space-page-wrapper relative space-page-content box-100">
                <h2><?= $title; ?></h2>
                <?= $description; ?>
            </div>
        <?php } ?>

         <?php if (is_array($numbers) && Util::issetAndNotEmpty($numbers[0][COUNTER . '_number'])) { ?>
             <div class="space-page-wrapper relative">
                 <div class="counter-grid">
                     <?php foreach ( $numbers as $counter ) : ?>
                         <div class="counter-item">
                             <span class="counter-number" data-target="<?= $counter[COUNTER . '_number']; ?>">0</span>
                             <span class="counter-label"><?= $counter[COUNTER . '_title']; ?></span>
                         </div>
                     <?php endforeach; ?>
                 </div>
             </div>
         <?php } ?>

        <?php if ($under_description) { ?>
            <div class="space-page-wrapper relative space-page-content box-100">
                <?= $under_description; ?>
            </div>
        <?php } ?>
    </div>
<?php } ?>
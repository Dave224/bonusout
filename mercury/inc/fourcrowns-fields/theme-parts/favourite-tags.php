<?php
use utils\Util;

$tags = $args['tags'];
?>

<div class="custom-wrapper relative <?= $tags[FAVOURITE_TAGS . '_background']; ?>">
    <?php if (Util::issetAndNotEmpty($tags[FAVOURITE_TAGS . '_title']) || Util::issetAndNotEmpty($tags[FAVOURITE_TAGS . '_description'])) { ?>
        <!-- Záhlaví sekce -->
        <div class="section-heading">
            <?php if (Util::issetAndNotEmpty($tags[FAVOURITE_TAGS . '_title'])) { ?>
                <h2 class="section-title"><?= $tags[FAVOURITE_TAGS . '_title']; ?></h2>
            <?php } ?>
            <?php if (Util::issetAndNotEmpty($tags[FAVOURITE_TAGS . '_description'])) { ?>
                <p class="section-description"><?= $tags[FAVOURITE_TAGS . '_description']; ?></p>
            <?php } ?>
        </div>
    <?php } ?>

     <?php if (Util::issetAndNotEmpty($tags[FAVOURITE_TAGS . '_content'])) { ?>
        <div class="space-page-wrapper relative">
             <?= $tags[FAVOURITE_TAGS . '_content']; ?>
        </div>
     <?php } ?>
</div>
<?php
use utils\Util;
use utils\Image;

$background = Fourcrowns_Storage::get('post', get_queried_object_id(), SLIDER . '_background');
$title = Fourcrowns_Storage::get('post', get_queried_object_id(), SLIDER . '_section_title');
$description = Fourcrowns_Storage::get('post', get_queried_object_id(), SLIDER . '_section_description');
$posts = Fourcrowns_Storage::get('post', get_queried_object_id(), SLIDER . '_posts');
$buttonText = Fourcrowns_Storage::get('post', get_queried_object_id(), SLIDER . '_button_text');
$buttonUrl = Fourcrowns_Storage::get('post', get_queried_object_id(), SLIDER . '_button_url');
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
    <div class="swiper article-swiper space-page-wrapper">
        <div class="swiper-wrapper">

            <?php
            $query = new WP_Query([
                'post_type' => 'post',
                'post__in' => $posts,
                'posts_per_page' => 100,
            ]);

            while ($query->have_posts()) : $query->the_post();
                ?>
                <div class="swiper-slide">
                    <a href="<?php the_permalink(); ?>" class="article-card">
                        <?php if (get_post_thumbnail_id(get_the_ID())) { ?>
                            <div class="article-thumb">
                                <img src="<?= Image::getCloudImage(get_post_thumbnail_id(get_the_ID()), 272, 181); ?>" alt="<?php the_title(); ?>">
                            </div>
                        <?php } ?>
                        <div class="article-content">
                            <h3 class="article-title"><?php the_title(); ?></h3>
                            <p class="article-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 10); ?></p>
                        </div>
                    </a>
                </div>
            <?php endwhile; wp_reset_postdata(); ?>

        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>


    <?php if (Util::issetAndNotEmpty($buttonText) && Util::issetAndNotEmpty($buttonUrl)) { ?>
        <!-- Tlačítko pod sliderem -->
        <div class="slider-button-wrapper">
            <a href="<?= $buttonUrl; ?>" class="slider-cta-button btn"><?= $buttonText; ?></a>
        </div>
    <?php } ?>
</div>
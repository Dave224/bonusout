<?php
use utils\Image;

$category = $args['category'] ?? '';
$query = new WP_Query([
    'post_type' => 'post',
    'posts_per_page' => 10,
    'cat' => $category
]);
?>

<?php if ($query->have_posts()) : ?>
    <div class="swiper article-swiper">
        <div class="swiper-wrapper">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <div class="swiper-slide">
                    <a href="<?php the_permalink(); ?>" class="article-card">
                        <?php if (get_post_thumbnail_id(get_the_ID())) { ?>
                            <div class="article-thumb">
                                <img src="<?= Image::getCloudImage(get_post_thumbnail_id(get_the_ID()), 245, 163); ?>" alt="<?php the_title(); ?>">
                            </div>
                        <?php } ?>
                        <div class="article-content tab-article-content">
                            <h3 class="article-title"><?php the_title(); ?></h3>
                            <p class="article-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 10); ?></p>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
<?php endif; wp_reset_postdata(); ?>

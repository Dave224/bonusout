<?php
use utils\Util;
$postId = get_the_ID();
$postTerms = wp_get_post_terms($postId, 'category');
$useCategorySettings = false;
$categoryId = null;
foreach($postTerms as $postTerm) {
    $useSettings = get_term_meta($postTerm->term_id, CATEGORY_BOTTOM_BAR . '_category_bottom_bar', true);
    if (Util::issetAndNotEmpty($useSettings) && $useSettings !== 'disabled') {
        $useCategorySettings = true;
        $categoryId = $postTerm->term_id;
        break;
    }
}
$bottomBarMain = get_option(CUSTOM_SETTINGS_BOTTOM_BAR . '-use-settings');
if (get_post_meta($postId, POST_BOTTOM_BAR . '_title', true)) {
    $titleExtra = get_post_meta($postId, POST_BOTTOM_BAR . '_title', true);
    $tagExtra = get_post_meta($postId, POST_BOTTOM_BAR . '_tag', true);
    $image = get_post_meta($postId, POST_BOTTOM_BAR . '_image', true);
    $buttonUrl = get_post_meta($postId, POST_BOTTOM_BAR . '_button_url', true);
    $buttonTitle = get_post_meta($postId, POST_BOTTOM_BAR . '_button_text', true);
} else if ($useCategorySettings) {
    $titleExtra = get_term_meta($categoryId, CATEGORY_BOTTOM_BAR . '_title', true);
    $tagExtra = get_term_meta($categoryId, CATEGORY_BOTTOM_BAR . '_tag', true);
    $image = get_term_meta($categoryId, CATEGORY_BOTTOM_BAR . '_image', true);
    $buttonUrl = get_term_meta($categoryId, CATEGORY_BOTTOM_BAR . '_button_url', true);
    $buttonTitle = get_term_meta($categoryId, CATEGORY_BOTTOM_BAR . '_button_text', true);
} else if ($bottomBarMain && $bottomBarMain != "disabled") {
    $titleExtra = get_option(CUSTOM_SETTINGS_BOTTOM_BAR . '-title');
    $buttonTitle = get_option(CUSTOM_SETTINGS_BOTTOM_BAR . '-button-text');
    $buttonUrl = get_option(CUSTOM_SETTINGS_BOTTOM_BAR . '-button-url');
    $image = get_option(CUSTOM_SETTINGS_BOTTOM_BAR . '-image');
    $tagExtra = get_option(CUSTOM_SETTINGS_BOTTOM_BAR . '-tag');
}

$content = get_the_content();
// Najdi první <a class="btn...> a vytáhni href
$link = '';
if (preg_match('/<a[^>]*class=["\'][^"\']*btn[^"\']*["\'][^>]*href=["\']([^"\']+)["\']/i', $content, $matches)) {
    $link = $matches[1];
    // Získání ID z odkazu jako /?p=2345
    if (preg_match('/[?&]p=(\d+)/', $link, $id_match)) {
        $post_id = intval($id_match[1]);

        // Získání ID článku v aktuálním jazyce
        $current_lang_post_id = apply_filters( 'wpml_object_id', $post_id, 'post', true );

        // Získání přeloženého permalinku
        $link = get_permalink($current_lang_post_id);
    }
}

$title = $titleExtra ?: get_the_title();
$button_title = $buttonTitle ?: __('Hrát', 'SLOTH');
$button_url = $buttonUrl ?: $link;
$thumbnail_id = $image ? $image['id'] : get_post_thumbnail_id();
$tag = $tagExtra ?: '';
?>
<!-- Organization Float Bar Start -->

<script type="text/javascript">
    jQuery(document).ready(function($) {
        'use strict';

        var stickyOffset = $('.space-organization-float-bar-bg').offset().top;

        $(window).scroll(function(){
            'use strict';
            var sticky = $('.space-organization-float-bar-bg'),
                scroll = $(window).scrollTop();

            if (scroll >= 400) sticky.addClass('show');
            else sticky.removeClass('show');
        });

    });
</script>

<style type="text/css">
    .single-organization .space-footer {
        padding-bottom: 110px;
    }
    @media screen and (max-width: 479px) {
        .single-organization .space-footer {
            padding-bottom: 100px;
        }
        .single-organization #scrolltop.show {
            opacity: 1;
            visibility: visible;
            bottom: 120px;
        }
    }
    .tag-over-title {
        font-size: 15px;
        color: #b3732e;
    }
    .space-footer {
        margin-bottom: 100px;
    }
    .cky-revisit-bottom-right {
        bottom: 142px;
    }
</style>

<script type="text/javascript">
    var Tawk_API = Tawk_API || {};

    Tawk_API.customStyle = {
        visibility : {
            desktop : {
                position : 'br',
                xOffset : 0,
                yOffset : '152px',
            },
            mobile : {
                position : 'br',
                xOffset : 0,
                yOffset : '142px',
            },
            bubble : {
                rotate : '0deg',
                xOffset : 0,
                yOffset : 0
            }
        }
    };
</script>

<div class="space-organization-float-bar-bg box-100 float-bar-full">
    <div class="space-organization-float-bar-bg-ins space-page-wrapper relative">
        <div class="space-organization-float-bar relative">
            <!-- Zavírací křížek -->
            <div id="float-bar-close"><i class="fa fa-angle-down"></i></div>
            <div class="space-organization-float-bar-data box-75 relative">
                <div class="space-organization-float-bar-data-ins relative">
                    <div class="space-organization-float-bar-logo relative">
                        <a class="space-organization-float-bar-logo-img relative" href="<?= $button_url; ?>" target="_blank" rel="noopener noreferrer">
                            <?php
                            $post_title_attr = the_title_attribute( 'echo=0' );
                            if ( wp_get_attachment_image($thumbnail_id) ) {
                                echo wp_get_attachment_image( $thumbnail_id, 'mercury-100-100', "", array( "alt" => $post_title_attr ) );
                            } ?>
                        </a>
                    </div>
                    <div class="space-organization-float-bar-title box-50 relative">
                        <div class="space-organization-float-bar-title-wrap box-100 relative">
                            <?php if ($tag) { ?>
                                <span class="tag-over-title"><?= $tag; ?></span><br />
                            <?php } ?>
                            <a href="<?= $button_url; ?>" target="_blank" rel="noopener noreferrer"><?= $title; ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="space-organization-float-bar-button box-25 relative">
                <div class="space-organization-float-bar-button-all text-center relative">
                    <div class="space-organization-float-bar-button-ins relative">
                        <div class="relative">
                            <a href="<?= $button_url; ?>" class="btn bottom-bar-btn" title="<?= $button_title; ?>" target="_blank" rel="noopener noreferrer">
                                <?= $button_title; ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Sbalená lišta (skrytá na začátku) -->
<div class="float-bar-collapsed">
    <div class="collapsed-content">
        <div class="space-organization-float-bar-title-wrap small-bar-title">
            <a href="<?= $button_url; ?>" target="_blank" rel="noopener noreferrer"><?= $title; ?></a>
            <a href="<?= $button_url; ?>" class="bottom-bar-link" title="<?= $button_title; ?>" target="_blank" rel="noopener noreferrer">
                <?= $button_title; ?>
            </a>
        </div>

        <button id="expand-bar"><i class="fa fa-angle-up"></i></button>
    </div>
</div>

<!-- Organization Float Bar End -->
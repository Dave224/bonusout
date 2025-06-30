<?php
use utils\Util;

const TOP_BRANDS = 'top_brands';
const BANNER = 'banner';
const SLIDER = 'slider';
const TABS = 'tabs';
const LISTING = 'listing';
const BACKGROUND = [
    'no-background' => 'Bílé pozadí',
    'black-background' => 'Černé pozadí',
    'color-background' => 'Pozadí v barvě webu'
];

$post_id = 0;

if (isset($_GET['post'])) {
    $post_id = (int) $_GET['post'];
} elseif (isset($_POST['post_ID'])) {
    $post_id = (int) $_POST['post_ID'];
}

$template = $post_id ? get_page_template_slug($post_id) : '';

if ($template == 'page-templates/page-hp.php') {
    Fourcrowns_Fields::add_metabox(TOP_BRANDS . '_metabox', [
        'title' => 'Nastavení top brandů',
        'context' => 'post',
        'post_type' => ['page'],
        'fields' => [
            ['type' => 'select', 'name' => TOP_BRANDS . '_background', 'label' => 'Pozadí sekce:', 'options' => BACKGROUND],
            ['type' => 'text', 'name' => TOP_BRANDS . '_section_title', 'label' => 'Titulek sekce:'],
            ['type' => 'text', 'name' => TOP_BRANDS . '_section_description', 'label' => 'Popisek sekce:'],
            ['type' => 'repeater', 'name' => TOP_BRANDS, 'label' => 'Top brandy', 'max' => 6, 'fields' => [
                ['type' => 'text', 'name' => TOP_BRANDS . '_title', 'label' => 'Titulek:'],
                ['type' => 'image', 'name' => TOP_BRANDS . '_image', 'label' => 'Obrázek:'],
                ['type' => 'text', 'name' => TOP_BRANDS . '_url', 'label' => 'URL:'],
            ]],
        ],
    ]);

    Fourcrowns_Fields::add_metabox(BANNER . 's_metabox', [
        'title' => 'Bannery',
        'context' => 'post',
        'post_type' => ['page'],
        'fields' => [
            ['type' => 'repeater', 'name' => BANNER, 'label' => 'Banner', 'max' => 3, 'fields' => [
                ['type' => 'text', 'name' => BANNER . '_title', 'label' => 'Titulek:'],
                ['type' => 'text', 'name' => BANNER . '_description', 'label' => 'Popisek:'],
                ['type' => 'image', 'name' => BANNER . '_image', 'label' => 'Obrázek:'],
                ['type' => 'select', 'name' => BANNER . '_variant', 'label' => 'Varianta banneru:', 'options' => [
                    'with-logo' => 'Obrázek jako logo vedle textu',
                    'with-background' => 'Obrázek jako pozadí'
                ]],
                ['type' => 'select', 'name' => BANNER . '_background', 'label' => 'Pozadí sekce:', 'options' => BACKGROUND],
                ['type' => 'text', 'name' => BANNER . '_button_text', 'label' => 'Text tlačítka:'],
                ['type' => 'text', 'name' => BANNER . '_url', 'label' => 'URL:'],
                ['type' => 'checkbox', 'name' => BANNER . '_open_new_tab', 'label' => 'Otevřít odkaz na nové kartě:'],
            ]],
        ],
    ]);

    Fourcrowns_Fields::add_metabox(SLIDER . '_metabox', [
        'title' => 'Top casina',
        'context' => 'post',
        'post_type' => ['page'],
        'fields' => [
            ['type' => 'select', 'name' => SLIDER . '_background', 'label' => 'Pozadí sekce:', 'options' => BACKGROUND],
            ['type' => 'text', 'name' => SLIDER . '_section_title', 'label' => 'Titulek sekce:'],
            ['type' => 'text', 'name' => SLIDER . '_section_description', 'label' => 'Popisek sekce:'],
            ['type' => 'multiselect', 'name' => SLIDER . '_posts', 'label' => 'Příspěvky:', 'options' => Util::getPostsForOptions()],
            ['type' => 'text', 'name' => SLIDER . '_button_text', 'label' => 'Text tlačítka:'],
            ['type' => 'text', 'name' => SLIDER . '_button_url', 'label' => 'URL tlačítka:'],
        ],
    ]);

    Fourcrowns_Fields::add_metabox(TABS . '_metabox', [
        'title' => 'Nejnovější příspěvky',
        'context' => 'post',
        'post_type' => ['page'],
        'fields' => [
            ['type' => 'select', 'name' => TABS . '_background', 'label' => 'Pozadí sekce:', 'options' => BACKGROUND],
            ['type' => 'repeater', 'name' => TABS, 'label' => 'Jednotlivé taby', 'max' => 20, 'fields' => [
                ['type' => 'text', 'name' => TABS . '_title', 'label' => 'Titulek:'],
                ['type' => 'text', 'name' => TABS . '_description', 'label' => 'Popisek:'],
                ['type' => 'select', 'name' => TABS . '_category', 'label' => 'Kategorie:', 'options' => Util::getPostTermsForOptions()],
            ]],
        ],
    ]);

    Fourcrowns_Fields::add_metabox(LISTING . '_metabox', [
        'title' => 'Seznam položek',
        'context' => 'post',
        'post_type' => ['page'],
        'fields' => [
            ['type' => 'select', 'name' => LISTING . '_background', 'label' => 'Pozadí sekce:', 'options' => BACKGROUND],
            ['type' => 'text', 'name' => LISTING . '_section_title', 'label' => 'Titulek sekce:'],
            ['type' => 'text', 'name' => LISTING . '_section_description', 'label' => 'Popisek sekce:'],
            ['type' => 'text', 'name' => LISTING . '_title_first', 'label' => 'Titulek pro první seznam:'],
            ['type' => 'repeater', 'name' => LISTING . '_first', 'label' => 'Položky pro první seznam', 'max' => 20, 'fields' => [
                ['type' => 'text', 'name' => LISTING . '_item_title_first', 'label' => 'Titulek:'],
                ['type' => 'image', 'name' => LISTING . '_item_image_first', 'label' => 'Logo:'],
                ['type' => 'text', 'name' => LISTING . '_item_url_first', 'label' => 'URL externí:'],
                ['type' => 'text', 'name' => LISTING . '_item_button_title_first', 'label' => 'Titulek tlačítka:'],
                ['type' => 'text', 'name' => LISTING . '_item_button_url_first', 'label' => 'URL tlačítka:'],
                ['type' => 'text', 'name' => LISTING . '_item_interest_title_first', 'label' => 'Titulek pro zajímavou hodnotu:'],
                ['type' => 'text', 'name' => LISTING . '_item_interest_value_first', 'label' => 'Zajímavá hodnota:'],
            ]],

            ['type' => 'text', 'name' => LISTING . '_title_second', 'label' => 'Titulek pro druhý seznam:'],
            ['type' => 'repeater', 'name' => LISTING . '_second', 'label' => 'Položky pro druhý seznam', 'max' => 20, 'fields' => [
                ['type' => 'text', 'name' => LISTING . '_item_title_second', 'label' => 'Titulek:'],
                ['type' => 'image', 'name' => LISTING . '_item_image_second', 'label' => 'Logo:'],
                ['type' => 'text', 'name' => LISTING . '_item_url_second', 'label' => 'URL externí:'],
                ['type' => 'text', 'name' => LISTING . '_item_button_title_second', 'label' => 'Titulek tlačítka:'],
                ['type' => 'text', 'name' => LISTING . '_item_button_url_second', 'label' => 'URL tlačítka:'],
                ['type' => 'text', 'name' => LISTING . '_item_interest_title_second', 'label' => 'Titulek pro zajímavou hodnotu:'],
                ['type' => 'text', 'name' => LISTING . '_item_interest_value_second', 'label' => 'Zajímavá hodnota:'],
            ]],

            ['type' => 'text', 'name' => LISTING . '_title_third', 'label' => 'Titulek pro třetí seznam:'],
            ['type' => 'repeater', 'name' => LISTING . '_third', 'label' => 'Položky pro třetí seznam', 'max' => 20, 'fields' => [
                ['type' => 'text', 'name' => LISTING . '_item_title_third', 'label' => 'Titulek:'],
                ['type' => 'image', 'name' => LISTING . '_item_image_third', 'label' => 'Logo:'],
                ['type' => 'text', 'name' => LISTING . '_item_url_third', 'label' => 'URL externí:'],
                ['type' => 'text', 'name' => LISTING . '_item_button_title_third', 'label' => 'Titulek tlačítka:'],
                ['type' => 'text', 'name' => LISTING . '_item_button_url_third', 'label' => 'URL tlačítka:'],
                ['type' => 'text', 'name' => LISTING . '_item_interest_title_third', 'label' => 'Titulek pro zajímavou hodnotu:'],
                ['type' => 'text', 'name' => LISTING . '_item_interest_value_third', 'label' => 'Zajímavá hodnota:'],
            ]],
        ],
    ]);
}
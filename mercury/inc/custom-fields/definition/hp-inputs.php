<?php
use utils\Util;

const MAIN_INFO = 'main_info';
const TOP_BRANDS = 'top_brands';
const BANNER = 'banner';
const SLIDER = 'slider';
const TABS = 'tabs';
const LISTING = 'listing';
const FAVOURITE_TAGS = 'favourite_tags';
const COUNTER = 'counter';

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
    Fourcrowns_Fields::add_metabox(MAIN_INFO . '_metabox', [
        'title' => 'Základní info',
        'context' => 'post',
        'post_type' => ['page'],
        'fields' => [
            ['type' => 'text', 'name' => MAIN_INFO . '_title', 'label' => 'Titulek:'],
            ['type' => 'trumbowyg', 'name' => MAIN_INFO . '_description', 'label' => 'Popisek:'],
        ],
    ]);

    Fourcrowns_Fields::add_metabox(TOP_BRANDS . '_metabox', [
        'title' => 'Nastavení top brandů',
        'context' => 'post',
        'post_type' => ['page'],
        'fields' => [
            ['type' => 'select', 'name' => TOP_BRANDS . '_background', 'label' => 'Pozadí sekce:', 'options' => BACKGROUND],
            ['type' => 'text', 'name' => TOP_BRANDS . '_section_title', 'label' => 'Titulek sekce:'],
            ['type' => 'text', 'name' => TOP_BRANDS . '_section_description', 'label' => 'Popisek sekce:'],
            ['type' => 'trumbowyg', 'name' => TOP_BRANDS . '_under_section_description', 'label' => 'Popisek pod sekcí:'],
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
            ['type' => 'text', 'name' => LISTING . '_button_title_first', 'label' => 'Titulek tlačítka pro první seznam:'],
            ['type' => 'text', 'name' => LISTING . '_button_url_first', 'label' => 'URL tlačítka pro první seznam:'],
            ['type' => 'repeater', 'name' => LISTING . '_first', 'label' => 'Položky pro první seznam', 'max' => 20, 'fields' => [
                ['type' => 'text', 'name' => LISTING . '_item_title_first', 'label' => 'Titulek:'],
                ['type' => 'image', 'name' => LISTING . '_item_image_first', 'label' => 'Logo:'],
                ['type' => 'text', 'name' => LISTING . '_item_url_first', 'label' => 'URL externí:'],
                ['type' => 'text', 'name' => LISTING . '_item_button_url_first', 'label' => 'URL interní:'],
                ['type' => 'text', 'name' => LISTING . '_item_first_button_title_first', 'label' => 'Titulek tlačítka pro externí link:'],
                ['type' => 'text', 'name' => LISTING . '_item_third_button_title_first', 'label' => 'Titulek tlačítka pro interní link:'],
            ]],

            ['type' => 'text', 'name' => LISTING . '_title_second', 'label' => 'Titulek pro druhý seznam:'],
            ['type' => 'text', 'name' => LISTING . '_button_title_second', 'label' => 'Titulek tlačítka pro druhý seznam:'],
            ['type' => 'text', 'name' => LISTING . '_button_url_second', 'label' => 'URL tlačítka pro druhý seznam:'],
            ['type' => 'repeater', 'name' => LISTING . '_second', 'label' => 'Položky pro druhý seznam', 'max' => 20, 'fields' => [
                ['type' => 'text', 'name' => LISTING . '_item_title_second', 'label' => 'Titulek:'],
                ['type' => 'image', 'name' => LISTING . '_item_image_second', 'label' => 'Logo:'],
                ['type' => 'text', 'name' => LISTING . '_item_url_second', 'label' => 'URL externí:'],
                ['type' => 'text', 'name' => LISTING . '_item_button_url_second', 'label' => 'URL interní:'],
                ['type' => 'text', 'name' => LISTING . '_item_first_button_title_second', 'label' => 'Titulek tlačítka pro externí link:'],
                ['type' => 'text', 'name' => LISTING . '_item_third_button_title_second', 'label' => 'Titulek tlačítka pro interní link:'],
            ]],

            ['type' => 'text', 'name' => LISTING . '_title_third', 'label' => 'Titulek pro třetí seznam:'],
            ['type' => 'text', 'name' => LISTING . '_button_title_third', 'label' => 'Titulek tlačítka pro třetí seznam:'],
            ['type' => 'text', 'name' => LISTING . '_button_url_third', 'label' => 'URL tlačítka pro třetí seznam:'],
            ['type' => 'repeater', 'name' => LISTING . '_third', 'label' => 'Položky pro třetí seznam', 'max' => 20, 'fields' => [
                ['type' => 'text', 'name' => LISTING . '_item_title_third', 'label' => 'Titulek:'],
                ['type' => 'image', 'name' => LISTING . '_item_image_third', 'label' => 'Logo:'],
                ['type' => 'text', 'name' => LISTING . '_item_url_third', 'label' => 'URL externí:'],
                ['type' => 'text', 'name' => LISTING . '_item_button_url_third', 'label' => 'URL interní:'],
                ['type' => 'text', 'name' => LISTING . '_item_first_button_title_third', 'label' => 'Titulek tlačítka pro externí link:'],
                ['type' => 'text', 'name' => LISTING . '_item_third_button_title_third', 'label' => 'Titulek tlačítka pro interní link:'],
            ]],
        ],
    ]);

    Fourcrowns_Fields::add_metabox(FAVOURITE_TAGS . '_metabox', [
        'title' => 'Oblíbené položky',
        'context' => 'post',
        'post_type' => ['page'],
        'fields' => [
            ['type' => 'repeater', 'name' => FAVOURITE_TAGS, 'label' => 'Oblíbené položky', 'max' => 10, 'fields' => [
                ['type' => 'text', 'name' => FAVOURITE_TAGS . '_title', 'label' => 'Titulek:'],
                ['type' => 'text', 'name' => FAVOURITE_TAGS . '_description', 'label' => 'Popisek:'],
                ['type' => 'select', 'name' => FAVOURITE_TAGS . '_background', 'label' => 'Pozadí sekce:', 'options' => BACKGROUND],
                ['type' => 'trumbowyg', 'name' => FAVOURITE_TAGS . '_content', 'label' => 'Oblíbené tagy:'],
            ]],
        ],
    ]);

    Fourcrowns_Fields::add_metabox(COUNTER . '_metabox', [
        'title' => 'Dynamická čísla',
        'context' => 'post',
        'post_type' => ['page'],
        'fields' => [
            ['type' => 'select', 'name' => COUNTER . '_background', 'label' => 'Pozadí sekce:', 'options' => BACKGROUND],
            ['type' => 'text', 'name' => COUNTER . '_section_title', 'label' => 'Titulek:'],
            ['type' => 'trumbowyg', 'name' => COUNTER . '_section_description', 'label' => 'Popisek:'],
            ['type' => 'trumbowyg', 'name' => COUNTER . '_under_section_description', 'label' => 'Popisek pod čísly:'],
            ['type' => 'repeater', 'name' => COUNTER, 'label' => 'Dynamická čísla', 'max' => 6, 'fields' => [
                ['type' => 'number', 'name' => COUNTER . '_number', 'label' => 'Číslo:'],
                ['type' => 'text', 'name' => COUNTER . '_title', 'label' => 'Titulek:'],
            ]],
        ],
    ]);
}
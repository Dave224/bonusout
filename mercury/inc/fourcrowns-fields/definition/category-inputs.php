<?php
const CATEGORY_TOP_BRANDS = 'category_top_brands';
const CATEGORY_BOTTOM_BAR = 'category_bottom_bar';

Fourcrowns_Fields::add_metabox(CATEGORY_TOP_BRANDS . '_metabox', [
    'title' => 'Nastavení top brandů',
    'context' => 'term',
    'taxonomy' => ['category'],
    'fields' => [
        ['type' => 'repeater', 'name' => CATEGORY_TOP_BRANDS, 'label' => 'Top brandy', 'max' => 6, 'fields' => [
            ['type' => 'text', 'name' => CATEGORY_TOP_BRANDS . '_title', 'label' => 'Titulek:'],
            ['type' => 'image', 'name' => CATEGORY_TOP_BRANDS . '_image', 'label' => 'Obrázek:'],
            ['type' => 'text', 'name' => CATEGORY_TOP_BRANDS . '_url', 'label' => 'URL:'],
        ]],
    ],
]);

Fourcrowns_Fields::add_metabox(CATEGORY_BOTTOM_BAR . '_metabox', [
    'title' => 'Nastavení spodní lišty u příspěvků',
    'context' => 'term',
    'taxonomy' => ['category'],
    'fields' => [
        ['type' => 'checkbox', 'name' => CATEGORY_BOTTOM_BAR . '_bottom_bar', 'label' => 'Skrýt spodní lištu u všech příspěvků v kategorii'],
        ['type' => 'checkbox', 'name' => CATEGORY_BOTTOM_BAR . '_category_bottom_bar', 'label' => 'Použít toto nastavení u všech příspěvku v kategorii'],
        ['type' => 'text', 'name' => CATEGORY_BOTTOM_BAR . '_title', 'label' => 'Titulek:'],
        ['type' => 'text', 'name' => CATEGORY_BOTTOM_BAR . '_tag', 'label' => 'Tag nad titulkem:'],
        ['type' => 'text', 'name' => CATEGORY_BOTTOM_BAR . '_button_text', 'label' => 'Text tlačítka:'],
        ['type' => 'text', 'name' => CATEGORY_BOTTOM_BAR . '_button_url', 'label' => 'URL tlačítka:'],
        ['type' => 'image', 'name' => CATEGORY_BOTTOM_BAR . '_image', 'label' => 'Obrázek:'],
    ],
]);

Fourcrowns_AdminPages::render_term_fields('category');

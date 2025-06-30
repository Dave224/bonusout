<?php
const POST_BOTTOM_BAR = 'post_bottom_bar';
const RECOMMENDED = 'post_recommended';

Fourcrowns_Fields::add_metabox(POST_BOTTOM_BAR . '_metabox', [
    'title' => 'Nastavení spodní lišty',
    'context' => 'post',
    'post_type' => ['post'],
    'fields' => [
        ['type' => 'checkbox', 'name' => POST_BOTTOM_BAR . '_bottom_bar', 'label' => 'Skrýt spodní lištu'],
        ['type' => 'text', 'name' => POST_BOTTOM_BAR . '_title', 'label' => 'Titulek:'],
        ['type' => 'text', 'name' => POST_BOTTOM_BAR . '_tag', 'label' => 'Tag nad titulkem:'],
        ['type' => 'text', 'name' => POST_BOTTOM_BAR . '_button_text', 'label' => 'Text tlačítka:'],
        ['type' => 'text', 'name' => POST_BOTTOM_BAR . '_button_url', 'label' => 'URL tlačítka:'],
        ['type' => 'image', 'name' => POST_BOTTOM_BAR . '_image', 'label' => 'Obrázek:'],
    ],
]);

Fourcrowns_Fields::add_metabox(RECOMMENDED . '_metabox', [
    'title' => 'Doporučená casina',
    'context' => 'post',
    'post_type' => ['post'],
    'fields' => [
        ['type' => 'select', 'name' => RECOMMENDED . '_background', 'label' => 'Pozadí sekce:', 'options' => BACKGROUND],
        ['type' => 'text', 'name' => RECOMMENDED . '_section_title', 'label' => 'Titulek sekce:'],
        ['type' => 'text', 'name' => RECOMMENDED . '_section_description', 'label' => 'Popisek sekce:'],
        ['type' => 'repeater', 'name' => RECOMMENDED, 'label' => 'Položky', 'fields' => [
            ['type' => 'text', 'name' => RECOMMENDED . '_item_title', 'label' => 'Titulek:'],
            ['type' => 'image', 'name' => RECOMMENDED . '_item_image', 'label' => 'Obrázek:'],
            ['type' => 'text', 'name' => RECOMMENDED . '_item_description', 'label' => 'Popisek pod tlačítkem:'],
            ['type' => 'text', 'name' => RECOMMENDED . '_item_button_text', 'label' => 'Text tlačítka:'],
            ['type' => 'text', 'name' => RECOMMENDED . '_item_button_url', 'label' => 'URL tlačítka:'],
            ['type' => 'checkbox', 'name' => RECOMMENDED . '_item_button_url_open_new_tab', 'label' => 'Otevřít odkaz na nové kartě:'],
        ]],
    ],
]);
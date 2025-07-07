<?php
const CUSTOM_SETTINGS = 'custom-settings';
const CUSTOM_SETTINGS_BOTTOM_BAR = 'custom-settings-bottom-bar';
const CUSTOM_SETTINGS_TOP_BRANDS = 'custom-settings-top-brands';

// REGISTRACE polí bez hooku (rovnou při načtení)
Fourcrowns_Fields::add_metabox(CUSTOM_SETTINGS, [
    'title' => 'Nastavení šablony',
    'context' => 'option',
    'fields' => [
        [
            'type' => 'textarea',
            'name' => CUSTOM_SETTINGS . '-header-code',
            'label' => 'Kód v head části webu'
        ],
        [
            'type' => 'textarea',
            'name' => CUSTOM_SETTINGS . '-body-start-code',
            'label' => 'Kód na začátku body části webu'
        ],
        [
            'type' => 'textarea',
            'name' => CUSTOM_SETTINGS . '-footer-code',
            'label' => 'Kód ve footer části webu'
        ],
    ]
]);

Fourcrowns_Fields::add_metabox(CUSTOM_SETTINGS_BOTTOM_BAR, [
    'title' => 'Nastavení dolní lišty',
    'context' => 'option',
    'fields' => [
        [
            'type' => 'text',
            'name' => CUSTOM_SETTINGS_BOTTOM_BAR . '-title',
            'label' => 'Titulek:'
        ],
        [
            'type' => 'text',
            'name' => CUSTOM_SETTINGS_BOTTOM_BAR . '-tag',
            'label' => 'Tag nad titulkem:'
        ],
        [
            'type' => 'text',
            'name' => CUSTOM_SETTINGS_BOTTOM_BAR . '-button-text',
            'label' => 'Text tlačítka:'
        ],
        [
            'type' => 'text',
            'name' => CUSTOM_SETTINGS_BOTTOM_BAR . '-button-url',
            'label' => 'URL tlačítka:'
        ],
        [
            'type' => 'image',
            'name' => CUSTOM_SETTINGS_BOTTOM_BAR . '-image',
            'label' => 'Obrázek'
        ],
        [
            'type' => 'checkbox',
            'name' => CUSTOM_SETTINGS_BOTTOM_BAR . '-use-settings',
            'label' => 'Použít toto nastavení na celém webu'
        ],
    ]
]);

Fourcrowns_Fields::add_metabox(CUSTOM_SETTINGS_TOP_BRANDS . '_metabox', [
    'title' => 'Nastavení top brandů',
    'context' => 'option',
    'fields' => [
        ['type' => 'repeater', 'name' => CUSTOM_SETTINGS_TOP_BRANDS, 'label' => 'Top brandy', 'max' => 6, 'fields' => [
            ['type' => 'text', 'name' => CUSTOM_SETTINGS_TOP_BRANDS . '_title', 'label' => 'Titulek:'],
            ['type' => 'image', 'name' => CUSTOM_SETTINGS_TOP_BRANDS . '_image', 'label' => 'Obrázek:'],
            ['type' => 'text', 'name' => CUSTOM_SETTINGS_TOP_BRANDS . '_url', 'label' => 'URL:'],
        ]],
        ['type' => 'checkbox', 'name' => CUSTOM_SETTINGS_TOP_BRANDS . '_use_settings', 'label' => 'Použít toto nastavení pro všechny kategorie'],

    ],
]);

function custom_admin_menu() {
    // Hlavní stránka v sekci "Nastavení"
    add_menu_page(
        'Nastavení šablony', // Titulek stránky
        'Nastavení šablony', // Název v menu
        'manage_options', // Oprávnění
        CUSTOM_SETTINGS, // Slug stránky
        'custom_settings_page', // Callback funkce
        'dashicons-admin-generic',
        20
    );

    // Podmenu (první se zobrazí stejně jako hlavní)
    add_submenu_page(
        CUSTOM_SETTINGS,
        'Obecné',
        'Obecné',
        'manage_options',
        CUSTOM_SETTINGS,
        'custom_settings_page'
    );

    add_submenu_page(
        CUSTOM_SETTINGS,     // Parent
        'Nastavení dolní lišty',        // Název
        'Nastavení dolní lišty',        // Název v menu
        'manage_options',      // Potřebná oprávnění
        CUSTOM_SETTINGS_BOTTOM_BAR,         // Slug
        'custom_bottom_bar_menu_page'    // Callback funkce
    );

    add_submenu_page(
        CUSTOM_SETTINGS,     // Parent
        'Nastavení top brandů',        // Název
        'Nastavení top brandů',        // Název v menu
        'manage_options',      // Potřebná oprávnění
        CUSTOM_SETTINGS_TOP_BRANDS,         // Slug
        'custom_brand_menu_page'    // Callback funkce
    );
}
add_action('admin_menu', 'custom_admin_menu');

function custom_settings_page() {
    Fourcrowns_AdminPages::render_option_page(CUSTOM_SETTINGS, 'Nastavení šablony');
}

function custom_bottom_bar_menu_page() {
    Fourcrowns_AdminPages::render_option_page(CUSTOM_SETTINGS_BOTTOM_BAR, 'Nastavení dolní lišty');
}

function custom_brand_menu_page() {
    Fourcrowns_AdminPages::render_option_page(CUSTOM_SETTINGS_TOP_BRANDS, 'Nastavení top brandů');
}
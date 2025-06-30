# Fourcrowns Fields Framework

Kompletní framework pro přidávání a správu vlastních polí v administraci WordPressu.

---

## ✅ Podporované typy polí
- `text`, `textarea`, `select`, `checkbox`, `image`
- `wp_editor`, `multiselect`, `gallery`
- `repeater` (drag & drop, dynamický)

## 🧠 Kontexty použití
Můžeš používat v:
- `post` (post_meta)
- `term` (term_meta)
- `option` (globální nastavení)

---

## 🔧 Použití

### 1. 📄 Post metabox (např. pro `page`)
```php
Fourcrowns_Fields::add_metabox('team_metabox', [
    'title' => 'Tým',
    'context' => 'post',
    'post_type' => ['page'],
    'fields' => [
        ['type' => 'text', 'name' => 'headline', 'label' => 'Titulek'],
        ['type' => 'repeater', 'name' => 'members', 'label' => 'Členové týmu', 'fields' => [
            ['type' => 'text', 'name' => 'name', 'label' => 'Jméno'],
            ['type' => 'image', 'name' => 'photo', 'label' => 'Fotka']
        ]]
    ]
]);
```

### 2. 🏷️ Term metabox (např. pro `category`)
```php
Fourcrowns_Fields::add_metabox('category_extra', [
    'title' => 'Dodatečné info',
    'context' => 'term',
    'fields' => [
        ['type' => 'textarea', 'name' => 'category_note', 'label' => 'Poznámka ke kategorii']
    ]
]);
```

### 3. ⚙️ Nastavení šablony (option page)
```php
Fourcrowns_Fields::add_metabox('theme_settings', [
    'title' => 'Nastavení šablony',
    'context' => 'option',
    'fields' => [
        ['type' => 'select', 'name' => 'color_scheme', 'label' => 'Barevné schéma', 'options' => [
            'light' => 'Světla',
            'dark' => 'Tmavá'
        ]],
        ['type' => 'gallery', 'name' => 'home_slider', 'label' => 'Obrázky slideru']
    ]
]);
```

> ⚠️ U `option` je potřeba mít na stránce tlačítko typu:
```html
<input type="hidden" name="_fourcrowns_options_save" value="1">
<input type="submit" class="button button-primary" value="Uložit">
```

---

## 🎨 Stylování
Vlastní UI je v `/assets/style.css` a lze jej upravovat.

---


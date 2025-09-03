<?php
spl_autoload_register(function ($class) {
    require_once __DIR__ . '/projectContants.php';

    if (strpos($class, 'Fourcrowns_Field_') === 0) {
        $field = str_replace('Fourcrowns_Field_', '', $class);
        $path = __DIR__ . '/fields/types/' . $field . '.php';
        if (file_exists($path)) {
            require_once $path;
        }
    } elseif (strpos($class, 'Fourcrowns_') === 0) {
        $file = str_replace('Fourcrowns_', '', $class);
        $path = __DIR__ . '/fields/' . $file . '.php';
        if (file_exists($path)) {
            require_once $path;
        }
    }

    $directories = [
        __DIR__ . '/utils',
        __DIR__ . '/definition',
        __DIR__ . '/theme-functions'
    ];

    foreach ($directories as $directory) {
        foreach (glob($directory . '/*.php') as $file) {
            require_once $file;
        }
    }

    require_once __DIR__ . '/fly-dynamic-image-resizer/fly-dynamic-image-resizer.php';
    require_once __DIR__ . '/include.php';
});


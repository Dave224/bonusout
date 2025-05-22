<?php
function isBot($userAgent) {
    $bots = ['googlebot', 'bingbot', 'slurp', 'duckduckbot', 'baiduspider', 'yandexbot', 'sogou', 'exabot', 'facebot', 'ia_archiver', 'seznam', 'ahrefs'];
    $userAgent = strtolower($userAgent);
    foreach ($bots as $bot) {
        if (strpos($userAgent, $bot) !== false) {
            return true;
        }
    }
    return false;
}

function getCountryCodeFromIP($ip) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://ipwho.is/{$ip}");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);
    if ($data && isset($data['success']) && $data['success'] && isset($data['country_code'])) {
        return $data['country_code'];
    }

    return null;
}

// Vypnout přesměrování přes URL parametr ?no_redirect=1
if (is_user_logged_in() || ((isset($_GET['no_redirect'])) && $_GET['no_redirect'] == '1')) {
    return;
}

// Mapa zemí na domény
$redirectMap = [
    'CZ' => 'https://www.bonusout.com/clanky',
    'US' => 'https://www.bonusout-en.com',
    'GB' => 'https://www.bonusout-en.com',
    // přidej další...
];

$currentHost = $_SERVER['HTTP_HOST'];

// Neprovádět nic pro bota
if (isBot($_SERVER['HTTP_USER_AGENT'])) {
    return;
}

// Pokud už je nastavena cookie s cílovou doménou
if (isset($_COOKIE['geo_redirect_done'])) {
    $targetDomain = $_COOKIE['geo_redirect_done'];

    // Pokud nejsme na cílové doméně, přesměrovat
    if (strpos($currentHost, parse_url($targetDomain, PHP_URL_HOST)) === false) {
        header("Location: $targetDomain");
        exit;
    }
} else {
    // První návštěva – získat IP a přesměrovat
    $ip = $_SERVER['REMOTE_ADDR'];
    $countryCode = getCountryCodeFromIP($ip);

    if ($countryCode && isset($redirectMap[$countryCode])) {
        $targetDomain = $redirectMap[$countryCode];

        // Pokud nejsme na cílové doméně, přesměrovat a uložit cookie
        if (strpos($currentHost, parse_url($targetDomain, PHP_URL_HOST)) === false) {
            // Uložit cílovou URL do cookie (na 30 dní)
            setcookie('geo_redirect_done', $targetDomain, time() + (86400 * 30), "/");
            header("Location: $targetDomain");
            exit;
        }
    }
}
?>

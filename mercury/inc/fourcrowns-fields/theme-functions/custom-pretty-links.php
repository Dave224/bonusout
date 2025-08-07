<?php
$current_url = home_url($_SERVER['REQUEST_URI']);

if (str_contains($current_url, '/go/')) {
    // URL k API
    $loginUrl = 'https://app.simplesio.com/api/users/login';

    // Login údaje
    $data = [
        'username' => 'davidjindrle',
        'password' => '123456789'
    ];

    // Inicializace cURL
    $ch = curl_init($loginUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    // Parsování tokenu
    $responseData = json_decode($response, true);

    if (isset($responseData['token'])) {
        $url_array_for_match = explode('/go', $current_url);

        $token = $responseData['token'];
        $collectionUrl = 'https://app.simplesio.com/api/brand-deals';

        // Vytvoření parametrů pro Payload query
        $params = [
            'where[pretty_link][=]' => '/go' . $url_array_for_match[1], // filtr podle pretty linku
            'limit' => 1,
        ];

        // Sestavení query stringu
        $queryString = http_build_query($params);

        $requestUrl = $collectionUrl . '?' . $queryString;

        $ch = curl_init($requestUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        // Výpis nebo další zpracování dat
        $data = json_decode($response, true);
        var_dump($data['docs']['pretty_link']);die;
        foreach ($data['docs'] as $brand) {
            foreach ($brand['deals'] as $deal) {
                if ($deal['pretty_link'] == '/go' . $url_array_for_match[1]) {
                   wp_redirect($deal['link']);
                   die;
                }
            }
        }

        wp_die("Affiliate brand nebyl nalezen!");
    } else {
        wp_die("Chyba při přihlášení: " . $response);
    }
}


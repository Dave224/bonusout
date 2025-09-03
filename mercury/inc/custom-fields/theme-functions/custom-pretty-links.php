<?php
$current_url = home_url($_SERVER['REQUEST_URI']);
// Získání URL webu
$url = get_site_url();
// Převedení na objekt URL
$parsed = parse_url($url);
// Doména (host část)
$host = $parsed['host'];
// Odstranění "www."
$currentDomain = preg_replace('/^www\./', '', $host);

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
            'where[pretty_link][equals]' => '/go' . $url_array_for_match[1],
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
        if (count($data['docs']) == 1) {
            $link = $data['docs'][0]["link"];
        } else {
            foreach ($data['docs'] as $item) {
                $domain = $item["affiliate_partner_domain"][0]['domain'];
                if ($domain == $currentDomain) {
                    $link = $item["link"];
                    break;
                } else {
                    $link = $data['docs'][0]["link"];
                }
            }
        }

        if ($data && $link) {
            wp_redirect($link);
            die;
        } else {
            $url_array = explode('-', $url_array_for_match[1]);
            array_shift($url_array);
            $urlToMatch = implode('-', $url_array);
            $params = [
                'where[pretty_link][like]' => $urlToMatch,
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
            $data = json_decode($response, true);

            if (count($data['docs']) == 1) {
                $link = $data['docs'][0]["link"];
            } else {
                foreach ($data['docs'] as $item) {
                    $domain = $item["affiliate_partner_domain"][0]['domain'];
                    if ($domain == $currentDomain) {
                        $link = $item["link"];
                        break;
                    } else {
                        $link = $data['docs'][0]["link"];
                    }
                }
            }

            if ($data && $link) {
                wp_redirect($link);
                die;
            }
        }

        $collectionUrl = 'https://app.simplesio.com/api/redirections';

        // Vytvoření parametrů pro Payload query
        $params = [
            'where[from][equals]' => '/go' . $url_array_for_match[1],
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
        $link = $data['docs'][0]["to"];

        if ($data && $link) {
            wp_redirect($link);
            die;
        }

        // Přesměrování na WP stránku v případě že ani jedno z výše uvedených pravidel v aplikaci není platné
        $template = 'page-templates/page-ooops.php'; // relativně k rootu šablony
        $pages = get_pages([
            'post_type'      => 'page',
            'post_status'    => 'publish',
            'meta_key'       => '_wp_page_template',
            'meta_value'     => $template,
            'number'         => 1,  // vezmeme jen první
            'hierarchical'   => 0,
        ]);



        if (!empty($pages)) {
            $page_id = $pages[0]->ID;
            $url = get_permalink($page_id);
            wp_redirect($url);die;
        }

        wp_die("Affiliate brand nebyl nalezen!");
    } else {
        $template = 'page-templates/page-ooops.php'; // relativně k rootu šablony
        $pages = get_pages([
            'post_type'      => 'page',
            'post_status'    => 'publish',
            'meta_key'       => '_wp_page_template',
            'meta_value'     => $template,
            'number'         => 1,  // vezmeme jen první
            'hierarchical'   => 0,
        ]);



        if (!empty($pages)) {
            $page_id = $pages[0]->ID;
            $url = get_permalink($page_id);
            wp_redirect($url);die;
        }

        wp_die("Chyba při přihlášení: " . $response);
    }
}


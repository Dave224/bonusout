<?php
$post = get_post(get_the_ID());

    preg_match_all( '@<h2.*?>(.*?)<\/h2>@', get_the_content(), $matches );
    $tags = $matches[1];

    $items = [];
    foreach ($tags as $tag) {
        $items[] = [
            "@type" => "ListItem",
            "name" => $tag,
            "url" => get_permalink(get_the_ID()) . "#" . sanitize_title($tag),
        ];
    }

    echo '<script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "ItemList",
                "itemListElement": ' . json_encode($items, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) . '
            }
        </script>';

if (str_contains(get_the_content(), "su_accordion")) {
    $array = explode('su_spoiler title=', get_the_content());
    array_shift($array);
    $new_array = [];
    foreach ($array as $item) {
        if (str_contains($item, "[/su_accordion]")) {
            $item = explode("[/su_accordion]", $item);
            array_pop($item);
            $item = $item[0];
        }
        $item = str_replace('"', '', $item);
        $item = str_replace('style=fancy]', '', $item);
        $item = str_replace('open=yes', '', $item);
        $item = str_replace('[/su_accordion', '', $item);
        $item = str_replace('[/su_spoiler]', '', $item);
        $item = str_replace('["]', '', $item);
        $item = str_replace('[', '', $item);
        $item = str_replace(']', '', $item);
        $item = trim(preg_replace('/\s\s+/', ' ', $item));
        $item = strip_tags($item);
        $new_array[] = $item;
    }

    $FaqArray = [];
    foreach ($new_array as $item) {
        $FaqArray[] = explode('?', $item);
    }

    $Faqs = [];
    foreach ($FaqArray as $tag) {
        $Faqs[] = [
            "@type" => "Question",
            "name" => preg_replace('/^\s+|\s+$/u', '', $tag[0]) . '?',
            "acceptedAnswer" => [
                "@type" => "Answer",
                "text" => preg_replace('/^\s+|\s+$/u', '', $tag[1]),
            ],
        ];
    }

    echo '<script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "FAQPage",
                "mainEntity": ' . json_encode($Faqs, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) . '
            }
        </script>';
}

if (str_contains(get_the_content(), "aces-pros")) {
    $array = explode('aces-pros-1 title=', get_the_content());
    array_shift($array);
    $NewArray = [];

    foreach ($array as $item) {
        $item = str_replace('<li>', '<span>', $item);
        $item = str_replace('</li>', '</span>', $item);
        if (explode('</span>', $item)) {
            $PreArray[] = explode('[/aces-cons-1]', $item);
        }
    }
    array_pop($PreArray[0]);
    $NewArray[] = explode('</span>', $PreArray[0][0]);
    $PositiveNotes = [];
    $NegativeNotes = [];
    $Iterator = 1;
    $IteratorNegative = 1;

   // array_shift($NewArray[0]);
    $new_array = [];
    foreach ($NewArray[0] as $item) {
        $item = str_replace('"Výhody"]', '', $item);
       // $item = str_replace('[/aces-pros-1]', '', $item);
        $item = str_replace('[aces-cons-1 title="Nevýhody"]', '', $item);
        $item = strip_tags($item);
        $item = trim($item);
        $new_array[] = $item;
    }

    $offset = array_search("[/aces-pros-1]", $new_array);
    if (!$offset) {
        $test = preg_grep('[/aces-pros-1]', $new_array);
        foreach ($test as $key => $value) {
            $offset = $key;
        }
    }

    // array(4,5)
    $last_batch = array_slice($new_array, ($offset + 1));
    $last_batch = array_filter($last_batch, 'strlen');

    // array_shift($last_batch);
   // array_pop($last_batch);
   // array_pop($last_batch);
    foreach ($last_batch as $item) {
        $NegativeNotes[] = [
            "@type" => "ListItem",
            "position" => $IteratorNegative,
            "name" => $item,
        ];
        $IteratorNegative ++;
    }

    // array(1,2,3)
    $first_batch = array_slice($new_array, 0, $offset);
    $first_batch = array_filter($first_batch, 'strlen');

    foreach ($first_batch as $item) {
        $PositiveNotes[] = [
            "@type" => "ListItem",
            "position" => $Iterator,
            "name" => $item,
        ];
        $Iterator++;
    }

    $agregateRate = get_post_meta(get_the_ID(), '_kksr_avg', true);
    if (!$agregateRate) {
        $agregateRate = 0;
    }
    $reviewCount = get_post_meta(get_the_ID(), '_kksr_casts', true);
    if (!$reviewCount) {
        $reviewCount = 0;
    }

    echo '<script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "Review",     
                "name": "' . get_the_title() . '",
                "author": "' . get_the_author() . '",
                "itemReviewed": {
                    "@type": "Product",
                    "name": "' . get_the_title() . '",
                    "aggregateRating": {
                        "@type": "AggregateRating",
                        "ratingValue": ' . $agregateRate .',
                        "reviewCount": ' . $reviewCount . '
                    }
                },
                "description": "' . get_the_excerpt() . '",
                "positiveNotes": {
                    "@type": "ItemList",
                    "itemListElement":  ' . json_encode($PositiveNotes, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) . '
                },   
                "negativeNotes": {
                    "@type": "ItemList",
                    "itemListElement":  ' . json_encode($NegativeNotes, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) . '
                }
            }
        </script>';
}
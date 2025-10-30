<?php
use utils\Util;

// Vložení ID k <h2> a <h3> nadpisům pro kotvy
function fc_add_heading_ids($content) {
    if (is_single()) {
        // Zpracuj <h2> a <h3> nadpisy
        preg_match_all('/<(h[2-3])>(.*?)<\/\1>/', $content, $matches, PREG_SET_ORDER);
        foreach ($matches as $match) {
            $tag = $match[1]; // h2 nebo h3
            $heading = $match[2];
            $slug = sanitize_title($heading);
            $replacement = '<' . $tag . ' id="' . $slug . '">' . $heading . '</' . $tag . '>';
            // Nahraď jen první výskyt daného nadpisu
            $pattern = '/<' . $tag . '>' . preg_quote($heading, '/') . '<\/' . $tag . '>/';
            $content = preg_replace($pattern, $replacement, $content, 1);
        }
    }
    return $content;
}
add_filter('the_content', 'fc_add_heading_ids');

// Widget pro osnovu článku
// Widget pro osnovu článku s podporou H2 i H3
class FC_Outline_Widget extends WP_Widget {
    function __construct() {
        parent::__construct('fc_outline_widget', 'Osnova článku');
    }

    public function widget($args, $instance) {
        if (is_single()) {
            global $post;

            // Vygeneruj obsah s přidanými ID přes filtr the_content
            $content = apply_filters('the_content', $post->post_content);

            // Najdi <h2> a <h3> s ID
            preg_match_all('/<(h[2-3])[^>]*id="([^"]+)"[^>]*>(.*?)<\/\1>/', $content, $matches, PREG_SET_ORDER);

            if (!empty($matches)) {
                echo $args['before_widget'];
                echo $args['before_title'] . 'Osnova článku' . $args['after_title'];
                echo '<ul class="fc-outline">';

                $open_sublist = false;
                foreach ($matches as $match) {
                    $tag = $match[1];      // h2 nebo h3
                    $id = $match[2];
                    $title = $match[3];
                    $clean_title = wp_strip_all_tags($title);

                    if ($tag === 'h2') {
                        if ($open_sublist) {
                            echo '</ul></li>'; // Uzavřít otevřený <ul> z předchozí h3
                            $open_sublist = false;
                        }
                        echo '<li><a href="#' . esc_attr($id) . '">' . $clean_title . '</a>';
                    } elseif ($tag === 'h3') {
                        if (!$open_sublist) {
                            echo '<ul class="fc-outline-sub">';
                            $open_sublist = true;
                        }
                        echo '<li><a href="#' . esc_attr($id) . '">' . $clean_title . '</a></li>';
                    }
                }

                if ($open_sublist) {
                    echo '</ul></li>'; // Uzavřít poslední otevřený blok
                }

                echo '</ul>';
                echo $args['after_widget'];
            }
        }
    }
}

function fc_register_outline_widget() {
    register_widget('FC_Outline_Widget');
}
add_action('widgets_init', 'fc_register_outline_widget');

function fc_insert_outline_before_first_div($content) {
    if (!is_single()) {
        return $content;
    }

    if (has_shortcode(get_the_content(), "ez-toc")) {
        return $content;
    }

    // Vytvoř osnovu
    $outline = createTableOfContents($content);

    // Najdi první <h2>
    $posH2 = false;
    if (preg_match('/<h2[^>]*>/i', $content, $match, PREG_OFFSET_CAPTURE)) {
        $posH2 = $match[0][1]; // pozice ZAČÁTKU prvního <h2>
    }

    // Najdi první <div>
    $posDiv = false;
    if (preg_match('/</table[^>]*>/i', $content, $match, PREG_OFFSET_CAPTURE)) {
        $posDiv = $match[0][1]; // pozice ZAČÁTKU prvního <div>
    }

    // Urči, co je první
    if ($posDiv !== false && $posH2 !== false) {
        $pos = min($posDiv, $posH2);
    } elseif ($posDiv !== false) {
        $pos = $posDiv;
    } elseif ($posH2 !== false) {
        $pos = $posH2;
    } else {
        $pos = false;
    }

    // Vlož osnovu
    if ($pos !== false) {
        $content = substr_replace($content, $outline, $pos, 0);
    }

    return $content;
}
add_filter('the_content', 'fc_insert_outline_before_first_div', 20);

// Funkce, která vrací výstup shortcodu
function custom_table_for_content_shortcode() {
    global $post;
    // dočasně odebrat vlastní shortcode, aby se nespustil uvnitř apply_filters a nevznikla nekonečná smyčkaa
    remove_shortcode('ez-toc');

    $content = apply_filters( 'the_content', $post->post_content );

    // znovu zaregistrovat shortcode
    add_shortcode('ez-toc', 'custom_table_for_content_shortcode');

    return createTableOfContents($content);
}

// Registrace shortcodu pro osnovu
add_shortcode('ez-toc', 'custom_table_for_content_shortcode');

function createTableOfContents($content) {
    $contentTitle = Fourcrowns_Storage::get('option', null, CUSTOM_SETTINGS_POST_DETAIL . '_contents_title');

    // Najdi <h2> a <h3> s ID
    preg_match_all('/<(h[2-3])[^>]*id="([^"]+)"[^>]*>(.*?)<\/\1>/', $content, $matches, PREG_SET_ORDER);
    // Vytvoř osnovu
    $outline = '<div class="fc-outline-container">';
    $outline .= '<button class="fc-outline-toggle collapsed" aria-expanded="false">';
    if (Util::issetAndNotEmpty($contentTitle)) {
        $outline .= '<h2 class="fc-outline-headline"> ' . $contentTitle . ' </h2>';
    }
    $outline .= '<span class="fc-toggle-icon"><i class="fa fa-chevron-down open-content"></i></span>';
    $outline .= '</button>';
    $outline .= '<div class="fc-outline-content">';
    $outline .= '<ul class="fc-outline">';

    $open_sublist = false;

    foreach ($matches as $match) {
        $tag = $match[1];
        $id = $match[2];
        $title = $match[3];
        $clean_title = wp_strip_all_tags($title);

        if ($tag === 'h2') {
            if ($open_sublist) {
                $outline .= '</ul></li>';
                $open_sublist = false;
            }
            $outline .= '<li><a href="#' . esc_attr($id) . '">' . esc_html($clean_title) . '</a>';
        } elseif ($tag === 'h3') {
            if (!$open_sublist) {
                $outline .= '<ul class="fc-outline-sub">';
                $open_sublist = true;
            }
            $outline .= '<li><a href="#' . esc_attr($id) . '">' . esc_html($clean_title) . '</a></li>';
        }
    }

    if ($open_sublist) {
        $outline .= '</ul></li>';
    }

    $outline .= '</ul></div></div>';

    return $outline;
}

<?php

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

                    if ($tag === 'h2') {
                        if ($open_sublist) {
                            echo '</ul></li>'; // Uzavřít otevřený <ul> z předchozí h3
                            $open_sublist = false;
                        }
                        echo '<li><a href="#' . esc_attr($id) . '">' . $title . '</a>';
                    } elseif ($tag === 'h3') {
                        if (!$open_sublist) {
                            echo '<ul class="fc-outline-sub">';
                            $open_sublist = true;
                        }
                        echo '<li><a href="#' . esc_attr($id) . '">' . $title . '</a></li>';
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

function fc_insert_outline_into_content($content) {
    if (!is_single()) {
        return $content;
    }

    // Vygeneruj osnovu z <h2> a <h3>
    preg_match_all('/<(h[2-3])[^>]*id="([^"]+)"[^>]*>(.*?)<\/\1>/', $content, $matches, PREG_SET_ORDER);

    if (empty($matches)) {
        return $content;
    }

    // Vytvoření HTML osnovy
    $outline = '<div class="fc-inline-outline">';
    $outline .= '<ul class="fc-outline">';
    $open_sublist = false;

    foreach ($matches as $match) {
        $tag = $match[1];
        $id = $match[2];
        $title = $match[3];

        if ($tag === 'h2') {
            if ($open_sublist) {
                $outline .= '</ul></li>';
                $open_sublist = false;
            }
            $outline .= '<li><a href="#' . esc_attr($id) . '">' . esc_html($title) . '</a>';
        } elseif ($tag === 'h3') {
            if (!$open_sublist) {
                $outline .= '<ul class="fc-outline-sub">';
                $open_sublist = true;
            }
            $outline .= '<li><a href="#' . esc_attr($id) . '">' . esc_html($title) . '</a></li>';
        }
    }

    if ($open_sublist) {
        $outline .= '</ul></li>';
    }

    $outline .= '</ul></div>';

    // Najdi kontejner s class "space-page-content" (může mít i další třídy)
    if (preg_match('/(<div[^>]*class="[^"]*\bspace-page-content\b[^"]*"[^>]*>)(.*?)(<\/div>)/is', $content, $container_matches)) {
        $container_open = $container_matches[1];
        $container_inner = $container_matches[2];
        $container_close = $container_matches[3];

        // Vlož osnovu před první <div> uvnitř
        $modified_inner = preg_replace('/(<div[^>]*>)/i', $outline . '$1', $container_inner, 1);

        $new_container = $container_open . $modified_inner . $container_close;
        $content = str_replace($container_matches[0], $new_container, $content);
    } else {
        return $content . '<!-- Osnova: kontejner space-page-content nenalezen -->';
    }

    return $content;
}
add_filter('the_content', 'fc_insert_outline_into_content', 999); // Použij vyšší prioritu pro jistotu

<?php
add_filter('the_content', 'rai_inject_random_ad');
add_shortcode('losowe_ogloszenie', 'rai_shortcode_handler');

function rai_shortcode_handler() {
    return rai_inject_random_ad('', true);
}

function rai_inject_random_ad($content, $is_shortcode = false) {
    if (!is_single() && !$is_shortcode) return $content;

    $ads_raw = get_option('rai_ads_content', '');
    if (empty($ads_raw)) return $content;

    $ads_array = explode('---', $ads_raw);
    if (empty($ads_array)) return $content;

    $ad_id = array_rand($ads_array);
    $random_ad = $ads_array[$ad_id];

    if (function_exists('rai_increment_views')) {
        rai_increment_views($ad_id);
    }

    define('RAI_AD_DISPLAYED', true);
    
    $ad_html = '<div class="rai-ad-container" data-ad-id="'.$ad_id.'" style="cursor: pointer;">' . $random_ad . '</div>';

    return $is_shortcode ? $ad_html : $ad_html . $content;
}
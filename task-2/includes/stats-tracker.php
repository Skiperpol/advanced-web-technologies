<?php
function rai_increment_views($ad_id) {
    $stats = get_option('rai_ads_stats', []);
    if (!isset($stats[$ad_id])) $stats[$ad_id] = ['views' => 0, 'clicks' => 0];
    $stats[$ad_id]['views']++;
    update_option('rai_ads_stats', $stats);
}

add_action('wp_footer', 'rai_click_tracker_script');
function rai_click_tracker_script() {
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.rai-ad-container').forEach(function(ad) {
            ad.addEventListener('click', function() {
                const adId = this.getAttribute('data-ad-id');
                fetch('<?php echo admin_url('admin-ajax.php'); ?>?action=rai_track_click&ad_id=' + adId);
            });
        });
    });
    </script>
    <?php
}

add_action('wp_ajax_rai_track_click', 'rai_track_click_handler');
add_action('wp_ajax_nopriv_rai_track_click', 'rai_track_click_handler');

function rai_track_click_handler() {
    if (isset($_GET['ad_id'])) {
        $ad_id = intval($_GET['ad_id']);
        $stats = get_option('rai_ads_stats', []);
        if (isset($stats[$ad_id])) {
            $stats[$ad_id]['clicks']++;
            update_option('rai_ads_stats', $stats);
        }
    }
    wp_die();
}
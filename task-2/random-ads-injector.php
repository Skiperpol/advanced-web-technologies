<?php
/**
 * Plugin Name: Random Ads Injector
 * Description: Wtyczka do wstawiania losowych ogłoszeń na stronie ze statystykami i shortcode.
 * Version: 1.0
 * Author: Michał Banaszkiewicz and Dawid Błaszczyk
 */

define('RAI_PATH', plugin_dir_path(__FILE__));

require_once RAI_PATH . 'includes/admin-panel.php';
require_once RAI_PATH . 'includes/core-logic.php';
require_once RAI_PATH . 'includes/stats-tracker.php';

add_action('admin_menu', 'rai_register_menu');
function rai_register_menu() {
    add_options_page("Ustawienia Ogłoszeń", "Ogłoszenia (Statystyki)", "manage_options", "rai-settings", "rai_admin_page");
}
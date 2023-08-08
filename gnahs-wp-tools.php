<?php
/**
 * Plugin Name: GNA Hotel Solutions WordPress Tools
 * Plugin URI: https://www.gnahs.com
 * Description: WordPress Hotel Tools developed by GNAHS
 * Version: 1.0.4
 * Author: GNA Hotel Solutions
 * Author URI: https://www.gnahs.com
 * License: GPLv2 o posterior
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

if (!defined('ABSPATH')) {
    wp_die(__('Do not open this file directly.', 'wp-htaccess-editor'));
}

// Cargar el dominio del plugin para la internacionalización
load_plugin_textdomain('gnahs-wp-tools', false, dirname(plugin_basename(__FILE__)) . '/languages/');

require_once plugin_dir_path(__FILE__) . 'includes/admin-page.php';
require_once plugin_dir_path(__FILE__) . 'includes/admin-notices.php';
require_once plugin_dir_path(__FILE__) . 'includes/booking-functions.php';

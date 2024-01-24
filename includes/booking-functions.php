<?php

// Añade el script externo a todo el sitio web con el método onload
function gnahs_add_metasearch_cookies_script()
{
    // Verificar si el script ya ha sido agregado
    if (!wp_script_is('gnahs-metasearch-cookies', 'enqueued')) {
        echo '<script src="https://assets.gnahs.com/scripts/rho-initialization/gnahs-metasearch-cookies-v2.js" onload="(new GNAHSMetasearchCookies())"></script>';
    }
}
add_action('wp_head', 'gnahs_add_metasearch_cookies_script');

// Shortcode para el motor de reservas
function gnahs_booking_engine_shortcode($atts)
{
    $atts = shortcode_atts(
        array(
            'uuid'            => get_option('gnahsengine_uuid', ''),
            'establishmentId' => get_option('gnahsengine_establishment_id', ''),
            'api'             => get_option('gnahsengine_api_url', ''),
        ),
        $atts
    );

    ob_start();
    include(plugin_dir_path(__FILE__) . '../views/engine.php');
    return ob_get_clean();
}
add_shortcode('gnahs-engine', 'gnahs_booking_engine_shortcode');

// Shortcode para cargar la página "mi reserva"
function gnahs_my_booking_shortcode($atts)
{
    $atts = shortcode_atts(
        array(
            'api'     => get_option('gnahsengine_api_url', ''),
            'slug'    => get_option('gnahsengine_slug', ''),
        ),
        $atts
    );

    ob_start();
    include(plugin_dir_path(__FILE__) . '../views/my-booking.php');
    return ob_get_clean();
}
add_shortcode('gnahs-my-booking', 'gnahs_my_booking_shortcode');

// Registra la página "booking"
function gnahs_create_booking_page()
{
    $booking_page = get_page_by_path('booking');
    if (!isset($booking_page)) {
        // Crea la página "booking"
        $booking_page_id = wp_insert_post(
            array(
                'post_title'   => 'Reservar',
                'post_content' => '[gnahs-engine]',
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_name'    => 'booking',
            )
        );

        // Establece el slug de la página "booking" como "booking"
        update_post_meta($booking_page_id, '_wp_page_template', 'default');
        add_action('admin_notices', 'gnahs_page_success_created_notice');
    } else {
        // La página ya existe, muestra un mensaje informativo en la administración
        add_action('admin_notices', 'gnahs_page_already_exists_notice');
    }
}

// Registra la página "mi reserva"
function gnahs_create_my_booking_page()
{
    $my_booking_page = get_page_by_path('my-booking');
    if (!isset($my_booking_page)) {
        // Crea la página "mi reserva"
        $my_booking_page_id = wp_insert_post(
            array(
                'post_title'   => 'Mi reserva',
                'post_content' => '[gnahs-my-booking]',
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_name'    => 'my-booking',
            )
        );

        // Establece el slug de la página "mi reserva" como "my-booking"
        update_post_meta($my_booking_page_id, '_wp_page_template', 'default');
        add_action('admin_notices', 'gnahs_page_success_created_notice');
    } else {
        // La página ya existe, muestra un mensaje informativo en la administración
        add_action('admin_notices', 'gnahs_page_already_exists_notice');
    }
}

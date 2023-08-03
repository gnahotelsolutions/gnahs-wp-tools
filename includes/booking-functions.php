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
    include(plugin_dir_path(__FILE__) . '../views/gnahsengine.php');
    return ob_get_clean();
}
add_shortcode('gnahsengine', 'gnahs_booking_engine_shortcode');

// Shortcode para cargar el booking-details
function gnahs_booking_details_shortcode($atts)
{
    $atts = shortcode_atts(
        array(
            'secretKey'     => get_option('gnahsengine_secret_key', ''),
            'rhoApi'        => get_option('gnahsengine_rho_api', ''),
        ),
        $atts
    );

    ob_start();
    include(plugin_dir_path(__FILE__) . '../views/booking-details.php');
    return ob_get_clean();
}
add_shortcode('booking-details', 'gnahs_booking_details_shortcode');

// Registra la página "booking"
function gnahs_create_booking_page()
{
    $booking_page = get_page_by_path('booking');
    if (!isset($booking_page)) {
        // Crea la página "booking"
        $booking_page_id = wp_insert_post(
            array(
                'post_title'   => 'Reservar',
                'post_content' => '[gnahsengine]',
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

// Registra la página "booking-details"
function gnahs_create_booking_details_page()
{
    $booking_details_page = get_page_by_path('booking-details');
    if (!isset($booking_details_page)) {
        // Crea la página "booking-details"
        $booking_details_page_id = wp_insert_post(
            array(
                'post_title'   => 'Confirmación de la reserva',
                'post_content' => '[booking-details]',
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_name'    => 'booking-details',
            )
        );

        // Establece el slug de la página "booking-details" como "booking-details"
        update_post_meta($booking_details_page_id, '_wp_page_template', 'default');
        add_action('admin_notices', 'gnahs_page_success_created_notice');
    } else {
        // La página ya existe, muestra un mensaje informativo en la administración
        add_action('admin_notices', 'gnahs_page_already_exists_notice');
    }
}

// Función para insertar la regla de redirección en el archivo .htaccess
function gnahs_insert_htaccess_rule()
{
    $htaccess_file = get_home_path() . '.htaccess';

    // Comprueba si el archivo .htaccess existe
    if (file_exists($htaccess_file)) {
        // Comprueba si el archivo .htaccess es modificable
        if (is_writable($htaccess_file)) {
            $marker = 'GNAHS WP Tools Rewrite Rules';
            $new_rules = "<IfModule mod_rewrite.c>\n";
            $new_rules .= "RewriteEngine On\n";
            $new_rules .= "RewriteBase /\n";
            $new_rules .= "RewriteRule ^booking-details/([^?].*)$ booking-details?uuid=$1 [NC,R=301,L]\n";
            $new_rules .= "</IfModule>\n";

            // Comprueba si la regla de redirección ya existe en el archivo .htaccess
            $existing_rules = implode('', file($htaccess_file));
            $existing_rules = trim($existing_rules); // Elimina los espacios en blanco al inicio y al final
            $htaccess_content = '';

            if (strpos($existing_rules, $new_rules) === false) {
                // Verifica si existe la línea "# BEGIN WordPress" en el archivo .htaccess
                if (strpos($existing_rules, '# BEGIN WordPress') !== false) {
                    // Divide el contenido en dos partes: antes y después de "# BEGIN WordPress"
                    $htaccess_parts = explode('# BEGIN WordPress', $existing_rules);

                    // Verifica si hay una parte antes de "# BEGIN WordPress"
                    if (empty($htaccess_parts[0])) {
                        // Agrega las nuevas reglas antes de "# BEGIN WordPress"
                        $htaccess_content .= $new_rules;
                    }
                    $htaccess_content .= '# BEGIN WordPress' . $htaccess_parts[1]; // Conserva la parte después de "# BEGIN WordPress"
                } else {
                    // La línea "# BEGIN WordPress" no existe, inserta las nuevas reglas al final del archivo
                    $htaccess_content .= $existing_rules;
                    $htaccess_content .= $new_rules;
                }

                // Guarda el contenido modificado en el archivo .htaccess
                file_put_contents($htaccess_file, $htaccess_content);
            } else {
                // La regla ya existe, muestra un mensaje informativo en la administración
                add_action('admin_notices', 'gnahs_htaccess_rule_exists_notice');
            }
        } else {
            // El archivo .htaccess no es modificable, muestra un mensaje de error en la administración
            add_action('admin_notices', 'gnahs_htaccess_not_writable_notice');
        }
    } else {
        // El archivo .htaccess no existe, intenta generarlo
        if (is_writable(dirname($htaccess_file))) {
            $marker = 'GNAHS WP Tools Rewrite Rules';
            $htaccess_content = "<IfModule mod_rewrite.c>\n";
            $htaccess_content .= "RewriteEngine On\n";
            $htaccess_content .= "RewriteBase /\n";
            $htaccess_content .= "RewriteRule ^booking-details/([^?].*)$ booking-details?uuid=$1 [NC,R=301,L]\n";
            $htaccess_content .= "</IfModule>\n";

            insert_with_markers($htaccess_file, $marker, $htaccess_content);

            $marker = 'WordPress';
            $htaccess_content = "<IfModule mod_rewrite.c>\n";
            $htaccess_content .= "RewriteEngine On\n";
            $htaccess_content .= "RewriteBase /\n";
            $htaccess_content .= "RewriteRule ^index\.php$ - [L]\n";
            $htaccess_content .= "RewriteCond %{REQUEST_FILENAME} !-f\n";
            $htaccess_content .= "RewriteCond %{REQUEST_FILENAME} !-d\n";
            $htaccess_content .= "RewriteRule . /index.php [L]\n";
            $htaccess_content .= "</IfModule>\n";

            insert_with_markers($htaccess_file, $marker, $htaccess_content);
        } else {
            // No se puede generar el archivo .htaccess, muestra un mensaje de error en la administración
            add_action('admin_notices', 'gnahs_htaccess_not_writable_notice');
        }
    }
}

// Registra la función para ejecutarse en el momento adecuado
register_activation_hook(__FILE__, 'gnahs_insert_htaccess_rule');

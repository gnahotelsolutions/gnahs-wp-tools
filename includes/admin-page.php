<?php
function gnahs_wp_tools_settings_page()
{
    ?>
    <div class="wrap">
        <h1><?= __('GNA Hotel Solutions WordPress Tools Configuration', 'gnahs-wp-tools') ?></h1>
        <form method="post" action="options.php">
            <?php
                settings_fields('gnahs_wp_tools_settings');
                do_settings_sections('gnahs_wp_tools_settings');
                submit_button();
            ?>
        </form>
        <form method="post" action="">
            <?php
                gnahs_wp_tools_execute_booking_engine_pages_insert_button();
            ?>
        </form>
    </div>
    <?php
}

function gnahs_wp_tools_settings_init()
{
    add_settings_section(
        'gnahs_wp_tools_section',
        __('Parameters for the GNAHS booking engine', 'gnahs-wp-tools'),
        '',
        'gnahs_wp_tools_settings'
    );

    add_settings_field(
        'gnahsengine_uuid',
        __('Client UUID', 'gnahs-wp-tools'),
        'gnahs_wp_tools_uuid_option_callback',
        'gnahs_wp_tools_settings',
        'gnahs_wp_tools_section'
    );

    add_settings_field(
        'gnahsengine_slug',
        __('Client slug', 'gnahs-wp-tools'),
        'gnahs_wp_tools_slug_option_callback',
        'gnahs_wp_tools_settings',
        'gnahs_wp_tools_section'
    );

    add_settings_field(
        'gnahsengine_establishment_id',
        __('Optional Establishment Code', 'gnahs-wp-tools'),
        'gnahs_wp_tools_establishment_id_option_callback',
        'gnahs_wp_tools_settings',
        'gnahs_wp_tools_section'
    );

    add_settings_field(
        'gnahsengine_api_url',
        __('API URL Alias (https://alias.gnahs.app)', 'gnahs-wp-tools'),
        'gnahs_wp_tools_api_url_option_callback',
        'gnahs_wp_tools_settings',
        'gnahs_wp_tools_section'
    );

    register_setting('gnahs_wp_tools_settings', 'gnahsengine_uuid');
    register_setting('gnahs_wp_tools_settings', 'gnahsengine_slug');
    register_setting('gnahs_wp_tools_settings', 'gnahsengine_establishment_id');
    register_setting('gnahs_wp_tools_settings', 'gnahsengine_api_url');
}

function gnahs_wp_tools_uuid_option_callback()
{
    echo '<input type="text" name="gnahsengine_uuid" value="' . esc_attr(get_option('gnahsengine_uuid')) . '" />';
}

function gnahs_wp_tools_slug_option_callback()
{
    echo '<input type="text" name="gnahsengine_slug" value="' . esc_attr(get_option('gnahsengine_slug')) . '" />';
}

function gnahs_wp_tools_establishment_id_option_callback()
{
    echo '<input type="text" name="gnahsengine_establishment_id" value="' . esc_attr(get_option('gnahsengine_establishment_id')) . '" />';
}

function gnahs_wp_tools_api_url_option_callback()
{
    echo '<input type="text" name="gnahsengine_api_url" value="' . esc_attr(get_option('gnahsengine_api_url')) . '" />';
}

function gnahs_wp_tools_secret_key_option_callback()
{
    echo '<input type="text" name="gnahsengine_secret_key" value="' . esc_attr(get_option('gnahsengine_secret_key')) . '" />';
}

function gnahs_wp_tools_rho_api_option_callback()
{
    echo '<input type="text" name="gnahsengine_rho_api" value="' . esc_attr(get_option('gnahsengine_rho_api')) . '" />';
}

function gnahs_wp_tools_execute_booking_engine_pages_insert_button()
{
    ?>
    <p><?= sprintf(__('If you already have a booking page, you can replace its content with the following shortcode: %s for the integration of the booking engine. If the page does not exist, you can generate a default booking page using the button ', 'gnahs-wp-tools'), '<b>[gnahs-engine]</b>') ?><b><?= __('Create Booking Page', 'gnahs-wp-tools') ?></b>.
    <br><?= sprintf(__('Similarly, if you already have a booking confirmation page, you can replace its content with the following shortcode: %s for the integration of the booking confirmation. If the page does not exist, you can generate a default confirmation page using the button ', 'gnahs-wp-tools'), '<b>[gnahs-my-booking]</b>') ?><b><?= __('Create Confirmation Page', 'gnahs-wp-tools') ?></b>.</p>
    <input type="submit" name="execute_booking_page_insert" class="button-primary" value="<?= __('Create Booking Page', 'gnahs-wp-tools') ?>" />
    <input type="submit" name="execute_booking_details_page_insert" class="button-primary" value="<?= __('Create Confirmation Page', 'gnahs-wp-tools') ?>" />
    <?php
}

function gnahs_wp_tools_execute_booking_page_insert()
{
    if (isset($_POST['execute_booking_page_insert'])) {
        gnahs_create_booking_page();
    }
}

function gnahs_wp_tools_execute_booking_details_page_insert()
{
    if (isset($_POST['execute_booking_details_page_insert'])) {
        gnahs_create_my_booking_page();
    }
}

add_action('admin_init', 'gnahs_wp_tools_execute_booking_page_insert');
add_action('admin_init', 'gnahs_wp_tools_execute_booking_details_page_insert');
add_action('admin_menu', 'gnahs_wp_tools_add_settings_page');
add_action('admin_init', 'gnahs_wp_tools_settings_init');

function gnahs_wp_tools_add_settings_page()
{
    add_options_page(
        'GNAHS WP Tools Settings',
        'GNAHS WP Tools',
        'manage_options',
        'gnahs_wp_tools_settings',
        'gnahs_wp_tools_settings_page'
    );
}

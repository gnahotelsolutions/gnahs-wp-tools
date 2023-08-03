<?php

// Función para mostrar un mensaje de error en la administración
function gnahs_htaccess_not_writable_notice()
{
    ?>
    <div class="notice notice-error is-dismissible">
        <p><?php __('The .htaccess file is not editable. Make sure you have the appropriate permissions.', 'gnahs-wp-tools'); ?></p>
    </div>
    <?php
}

// Función para mostrar un mensaje informativo si la regla ya existe en la administración
function gnahs_htaccess_rule_exists_notice()
{
    ?>
    <div class="notice notice-info is-dismissible">
        <p><?php __('The redirection rule already exists in the .htaccess file.', 'gnahs-wp-tools'); ?></p>
    </div>
    <?php
}

// Función para mostrar un mensaje informativo si la página ya existe en la administración
function gnahs_page_already_exists_notice()
{
    ?>
    <div class="notice notice-info is-dismissible">
        <p><?php __('The page you are trying to create already exists.', 'gnahs-wp-tools'); ?></p>
    </div>
    <?php
}

// Función para mostrar un mensaje informativo si la página ha sido creada correctamente en la administración
function gnahs_page_success_created_notice()
{
    ?>
    <div class="notice notice-success is-dismissible">
        <p><?php __('The page has been created successfully.', 'gnahs-wp-tools'); ?></p>
    </div>
    <?php
}

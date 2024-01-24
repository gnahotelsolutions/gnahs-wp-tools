<?php

// Función para mostrar un mensaje informativo si la página ya existe en la administración
function gnahs_page_already_exists_notice()
{
    ?>
    <div class="notice notice-info is-dismissible">
        <p><?php echo __('The page you are trying to create already exists.', 'gnahs-wp-tools'); ?></p>
    </div>
    <?php
}

// Función para mostrar un mensaje informativo si la página ha sido creada correctamente en la administración
function gnahs_page_success_created_notice()
{
    ?>
    <div class="notice notice-success is-dismissible">
        <p><?php echo __('The page has been created successfully.', 'gnahs-wp-tools'); ?></p>
    </div>
    <?php
}

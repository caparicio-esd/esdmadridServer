<?php

function register_esd_notifications()
{
    wp_enqueue_script(
        'esd_notifications',
        get_template_directory_uri() . '/admin/reusable_blocks/dist/notifications/notifications.js',
        array('wp-blocks', 'wp-i18n', 'wp-editor', 'wp-block-editor', 'wp-components'),
        false,
        true
    );
    wp_enqueue_style(
        'esd_notifications',
        get_template_directory_uri() . '/admin/reusable_blocks/dist/notifications/notifications.js.css',
        array()
    );
    register_block_type('esd/notifications', array(
        'editor_script' => get_template_directory_uri() . '/admin/reusable_blocks/notifications/notifications.js'
    ));
}

add_action('init', 'register_esd_notifications');

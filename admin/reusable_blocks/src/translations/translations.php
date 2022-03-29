<?php

function register_translations()
{
    wp_enqueue_script(
        'esd_translations',
        get_template_directory_uri() . '/admin/reusable_blocks/dist/translations/translations.js',
        array('wp-blocks', 'wp-i18n', 'wp-editor', 'wp-block-editor'),
        false,
        true
    );
    wp_enqueue_style(
        'esd_translations',
        get_template_directory_uri() . '/admin/reusable_blocks/dist/translations/translations.js.css',
        array( 'wp-editor' )
    );
    register_block_type('esd/translations', array(
        'editor_script' => get_template_directory_uri() . '/admin/reusable_blocks/translations/translations.js'
    ));
}

add_action('init', 'register_translations');

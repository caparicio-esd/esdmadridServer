<?php

function register_single_anchor()
{
    wp_enqueue_script(
        'esd_single_link',
        get_template_directory_uri() . '/admin/reusable_blocks/dist/single_link/single_link.js',
        array('wp-blocks', 'wp-i18n', 'wp-editor'),
        false,
        true
    );
    wp_enqueue_style(
        'esd_single_link',
        get_template_directory_uri() . '/admin/reusable_blocks/dist/single_link/single_link.js.css',
        array( 'wp-editor' )
    );
    register_block_type('esd/single_link', array(
        'editor_script' => get_template_directory_uri() . '/admin/reusable_blocks/single_link/single_link.js'
    ));
}

add_action('init', 'register_single_anchor');

<?php

function inject_preview_js()
{
    wp_enqueue_script(
        'preview-script',
        get_template_directory_uri() . '/admin/preview_url/preview_url.js',
        [],
        '1.0',
        false
    );
}
add_action('admin_enqueue_scripts', 'inject_preview_js');

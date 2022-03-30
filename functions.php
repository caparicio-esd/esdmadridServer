<?php
require dirname(__FILE__) . '/.env.php';


// hooks
function register_hooks()
{
    register_nav_menu('menu-1', __('Menú 1'));
    add_theme_support('post-thumbnails');
    add_post_type_support('page', 'excerpt');
    add_post_type_support('post', 'excerpt');
    add_post_type_support('page', 'custom-fields');
    add_post_type_support('post', 'custom-fields');
}
add_action('init', 'register_hooks');





// register taxonomy portfolio
require dirname(__FILE__) . '/admin/taxonomy_portfolio.php';
require dirname(__FILE__) . '/admin/preview_url/preview_url.php';



/**
 * 
 * Classes
 */
require dirname(__FILE__) . '/lib/ftp_uploader.php';
require dirname(__FILE__) . '/lib/netlify_hook.php';
require dirname(__FILE__) . '/lib/root.php';


/**
 * 
 * API
 */
require dirname(__FILE__) . '/api/Post/Posts_Home.php';
require dirname(__FILE__) . '/api/Post/Post_Home.php';

require dirname(__FILE__) . '/api/Pages/Page.php';
require dirname(__FILE__) . '/api/Pages/Plan_Estudios.php';
require dirname(__FILE__) . '/api/Pages/La_Escuela_Crece.php';

require dirname(__FILE__) . '/api/Portfolio/Portfolio_List.php';
require dirname(__FILE__) . '/api/Portfolio/Portfolio_Single.php';

require dirname(__FILE__) . '/api/Profesores/Profesores.php';
require dirname(__FILE__) . '/api/Companies/Company_List.php';
require dirname(__FILE__) . '/api/Convenios/Convenios_List.php';

require dirname(__FILE__) . '/api/Search/Search.php';
require dirname(__FILE__) . '/api/Menu/Menu.php';

require dirname(__FILE__) . '/api/Blog/Blog.php';
require dirname(__FILE__) . '/api/Preview/PreviewURL.php';


/**
 * REUSABLE BLOCKS
 */
require dirname(__FILE__) . '/admin/custom_gutenberg.php';
require dirname(__FILE__) . '/admin/reusable_blocks/src/single_link/single_link.php';
require dirname(__FILE__) . '/admin/reusable_blocks/src/notifications/notifications.php';
require dirname(__FILE__) . '/admin/reusable_blocks/src/translations/translations.php';



function console_log($data)
{
    echo '<script>';
    echo 'console.log(' . json_encode($data) . ')';
    echo '</script>';
}

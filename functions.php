<?php



// hooks
function register_hooks()
{
    register_nav_menu('menu-1', __('Menú 1'));
    add_theme_support('post-thumbnails');
    add_post_type_support('page', 'excerpt');
    add_post_type_support('post', 'excerpt');
}
add_action('init', 'register_hooks');


// register taxonomy portfolio
require dirname(__FILE__) . '/admin/taxonomy_portfolio.php';



/**
 * 
 * Classes
 */
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


/**
 * REUSABLE BLOCKS
 */
require dirname(__FILE__) . '/admin/custom_gutenberg.php';
require dirname(__FILE__) . '/admin/reusable_blocks/src/single_link/single_link.php';
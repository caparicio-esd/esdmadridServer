<?php

/**
 * Endpoint-----
 * 
 * Get post for single home
 * 
 * @url: https://esd-api/wp-json/esd/v1/posts/18695
 * 
 */


function get_rest_menu($request)
{
    $menu =  wp_get_nav_menu_items('Menú 1');
    $menuOut = [];

    foreach ($menu as $menu_item) {
        if ($menu_item->menu_item_parent == "0") {
            array_push(
                $menuOut,
                just_needed_stuff_menu($menu_item)
            );
        }
    }

    foreach ($menu as $menu_item) {
        if ($menu_item->menu_item_parent != "0") {
            $parent = $menu_item->menu_item_parent;
            $parentMenuBlock = 0;

            foreach ($menuOut as $index => $menuOut_item) {
                if ($menuOut_item->menu_id == $parent) {
                    $parentMenuBlock = $index;
                }
            }

            array_push(
                $menuOut[$parentMenuBlock]->children,
                just_needed_stuff_menu($menu_item)
            );
        }
    }


    return $menuOut;
}

add_action('rest_api_init', function () {
    register_rest_route(
        'esd/v1',
        'menu',
        array(
            'methods' => 'GET',
            'callback' => 'get_rest_menu'
        )
    );
});



/**
 * 
 * @function get_menu_template
 * @param {Object} $menu_item
 * @return {String} returns flag type
 * 
 * Get menu template from ui_field
 * 
 */
function get_menu_template($menu_item)
{
    // if simple post 
    if ($menu_item->object == 'post') {
        $template_flag = esd_BE__BasicData::$flag_options[1];
    }

    // if simple page 
    if ($menu_item->object == 'page') {
        $template_flag = esd_BE__BasicData::$flag_options[0];
    }

    // if custom navigation
    if ($menu_item->object == 'custom') {
        $template_flag = '';
    }

    // if rest options
    foreach (esd_BE__BasicData::$template_collection as $tc_item) {
        if ($menu_item->object_id == $tc_item->id) {
            $template_flag = $tc_item->template;
            break;
        }
    }

    return $template_flag;
}

/**
 * 
 * @function just_needed_stuff_menu
 * @param {Object} $menu_item
 * @return {StdClass} returns menu class
 * 
 * Creates menu API object
 * 
 */
function just_needed_stuff_menu($menu_item)
{

    $menu = new stdClass();

    // check if custom link: 
    $menu_url = $menu_item->type == 'custom' ? '#' : $menu_item->url;

    // create template flags
    $template = get_menu_template($menu_item);

    $menu->menu_id = $menu_item->ID;
    $menu->menu_title = $menu_item->title;
    $menu->menu_url = str_replace(esd_BE__BasicData::$root, "", $menu_url);
    $menu->menu_slug = str_replace('/', '', $menu->menu_url);
    $menu->menu_template = $template;
    $menu->children = [];

    return $menu;
}

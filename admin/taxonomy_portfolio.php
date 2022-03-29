<?php



function post_type_portfolio()
{
    $labels = array(
        'name'               => __('Portfolio', 'read'),
        'singular_name'      => __('Portfolio Item', 'read'),
        'add_new'            => __('Add New', 'read'),
        'add_new_item'       => __('Add New', 'read'),
        'edit_item'          => __('Edit', 'read'),
        'new_item'           => __('New', 'read'),
        'all_items'          => __('All', 'read'),
        'view_item'          => __('View', 'read'),
        'search_items'       => __('Search', 'read'),
        'not_found'          => __('No Items found', 'read'),
        'not_found_in_trash' => __('No Items found in Trash', 'read'),
        'parent_item_colon'  => '',
        'menu_name'          => 'Portfolio'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'query_var'           => true,
        'show_in_nav_menus'   => true,
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'menu_position'       => 5,
        'supports'            => array('title', 'editor', 'thumbnail', 'comments', 'revisions', 'custom-fields', 'meta'),
        'rewrite'             => array('slug' => 'portfolio', 'with_front' => false), 
        'show_in_rest'        => true
    );

    register_post_type('portfolio', $args);
}

add_action('init', 'post_type_portfolio');

function taxonomy_portfolio()
{
    $labels_cat = array(
        'name'              => __('Departments', 'read'),
        'singular_name'     => __('Department', 'read'),
        'search_items'      => __('Search', 'read'),
        'all_items'         => __('All', 'read'),
        'parent_item'       => __('Parent', 'read'),
        'parent_item_colon' => __('Parent:', 'read'),
        'edit_item'         => __('Edit', 'read'),
        'update_item'       => __('Update', 'read'),
        'add_new_item'      => __('Add New', 'read'),
        'new_item_name'     => __('New Name', 'read'),
        'menu_name'         => __('Departments', 'read')
    );

    register_taxonomy(
        'department',
        array('portfolio'),
        array(
            'hierarchical' => true,
            'labels'       => $labels_cat,
            'show_ui'      => true,
            'public'       => true,
            'query_var'    => true,
            'rewrite'      => array('slug' => 'department')
        )
    );

    $labels_tag = array(
        'name'              => __('Portfolio Tags', 'read'),
        'singular_name'     => __('Portfolio Tag',  'read'),
        'search_items'      => __('Search', 'read'),
        'all_items'         => __('All', 'read'),
        'parent_item'       => __('Parent Tag', 'read'),
        'parent_item_colon' => __('Parent Tag:', 'read'),
        'edit_item'         => __('Edit', 'read'),
        'update_item'       => __('Update', 'read'),
        'add_new_item'      => __('Add New', 'read'),
        'new_item_name'     => __('New Tag Name', 'read'),
        'menu_name'         => __('Portfolio Tags', 'read')
    );

    register_taxonomy(
        'portfolio_tag',
        array('portfolio'),
        array(
            'hierarchical' => false,
            'labels'       => $labels_tag,
            'show_ui'      => true,
            'public'       => true,
            'query_var'    => true,
            'rewrite'      => array(
                'slug' =>   'portfolio_tag'
            )
        )
    );
}

add_action('init', 'taxonomy_portfolio');

<?php

/**
 * Endpoint-----
 * 
 * Get all posts for home
 * 
 * @url: https://esd-api/wp-json/esd/v1/posts
 * 
 * @param page: default: 1
 * @param posts_per_page: default: 10
 */


function get_rest_posts_home()
{
    // fetch params
    $page         = isset($_GET['page']) ? $_GET['page'] : 1;
    $post_per_age = isset($_GET['posts_per_page']) ? $_GET['posts_per_page'] : 10;
    $category = isset($_GET['category']) ? $_GET['category'] : '';


    // fetch db
    $results = get_posts(array(
        'post_type' => 'post',
        'posts_per_page' => $post_per_age,
        'paged' => $page, 
        'tax_query' => array(
            'relation' => 'OR',
            array(
                'taxonomy' => 'category',
                'field'    => 'slug',
                'terms'    => array( $category ),
            ),
            array(
                'taxonomy' => 'post_tag',
                'field'    => 'slug',
                'terms'    => array( $category ),
            ),
        ),
    ));

    // construct response
    $response = [];
    foreach ($results as $index => $post) {
        array_push($response, new esd_BE_Post_Home_ListItem($post));
    }

    return $response;
}

add_action('rest_api_init', function () {
    register_rest_route(
        'esd/v1',
        'posts',
        array(
            'methods' => 'GET',
            'callback' => 'get_rest_posts_home'
        )
    );
});

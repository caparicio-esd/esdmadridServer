<?php


/**
 * Endpoint-----
 * 
 * Get post for single home
 * 
 * @url: https://esd-api/wp-json/esd/v1/page
 * 
 * 
 */


function redirect_rest_pages()
{
    wp_redirect(esd_BE__BasicData::$api_root . 'posts');
    exit;
}


function get_rest_pages($request)
{
    // fetch params
    $pid = $request['page_id'];

    // fetch db
    $results = new WP_Query(array(
        'page_id' => $pid,
    ));

    // construct response
    $response = new esd_BE_Page($results->posts[0]);

    return $response;
}



add_action('rest_api_init', function () {
    register_rest_route(
        'esd/v1',
        'page/(?P<page_id>\d+)',
        array(
            'methods' => 'GET',
            'callback' => 'get_rest_pages'
        )
    );
});

add_action('rest_api_init', function () {
    register_rest_route(
        'esd/v1',
        'page',
        array(
            'methods' => 'GET',
            'callback' => 'redirect_rest_pages'
        )
    );
});

add_action('rest_api_init', function () {
    register_rest_route(
        'esd/v1',
        'page/special',
        array(
            'methods' => 'GET',
            'callback' => 'redirect_rest_pages'
        )
    );
});

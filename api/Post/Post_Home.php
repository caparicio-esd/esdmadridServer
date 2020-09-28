<?php

/**
 * Endpoint-----
 * 
 * Get post for single home
 * 
 * @url: https://esd-api/wp-json/esd/v1/posts/18695
 * 
 */


function get_rest_post_home($request)
{
    // fetch params
    $pslug = $request['slug'];

    // fetch db
    $results = get_posts(array(
        'post_name' => $pslug, 
        'post_type' => 'any'
    ));

    // construct response
    if ($results[0]->post_type !== 'page') {
        $response = new esd_BE_Post_Home_Single($results[0]);
    } else {
        wp_redirect(esd_BE__BasicData::$api_root . 'page/' . $pslug);
        exit;
    }

    return $response;
}

add_action('rest_api_init', function () {
    register_rest_route(
        'esd/v1',
        'posts/(?P<slug>[-\w]+)',
        array(
            'methods' => 'GET',
            'callback' => 'get_rest_post_home'
        )
    );
});

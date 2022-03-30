<?php

namespace ESD_BE\Api;

use ESD_BE\PortfolioItem;

/**
 * Endpoint-----
 * 
 * Get post for single home
 * 
 * @url: https://esd-api/wp-json/esd/v1/portfolio/:slug
 * 
 */


function get_rest_portfolio_item($request)
{

    // fetch params
    $pslug = $request['slug'];

    // fetch db
    $posts = get_posts(array(
        'name' => $pslug, 
        'post_type' => 'portfolio'
    ));

    // response
    $response = new PortfolioItem($posts[0]);


    return $response;
}



add_action('rest_api_init', function () {
    register_rest_route(
        'esd/v1',
        'portfolio/(?P<slug>[-\w]+)',
        array(
            'methods' => 'GET',
            'callback' => 'get_rest_portfolio_item'
        )
    );
});

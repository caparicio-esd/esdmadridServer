<?php

namespace ESD_BE\Api;

use ESD_BE\PortfolioItem;

/**
 * Endpoint-----
 * 
 * Get post for single home
 * 
 * @url: https://esd-api/wp-json/esd/v1/portfolio
 * 
 * @param year : default ''
 * @param department : default ''
 */


function get_rest_portfolio_items()
{

    // fetch params
    $year = isset($_GET['year']) && !empty($_GET['year']) ? $_GET['year'] : '';
    $department = isset($_GET['department']) && !empty($_GET['department']) ? $_GET['department'] : '';

    // fetch db
    $posts = get_posts(array(
        'post_type' => 'portfolio',
        'posts_per_page' => -1
    ));

    // response
    $response = [];
    foreach ($posts as $post) {
        array_push($response, new PortfolioItem($post));
    }

    // filter year
    if (!empty($year)) {
        $postsFilteredOut = [];
        foreach ($response as $postOut) {
            if (array_search($year, $postOut->categories) !== false) {
                array_push($postsFilteredOut, $postOut);
            }
        }
        $response = $postsFilteredOut;
    }

    /**
     * Filtering year
     */
    if (!empty($department)) {
        $postsFilteredOut = [];
        foreach ($response as $postOut) {
            if (array_search($department, $postOut->categories) !== false) {
                array_push($postsFilteredOut, $postOut);
            }
        }
        $response = $postsFilteredOut;
    }


    return $response;
}



add_action('rest_api_init', function () {
    register_rest_route(
        'esd/v1',
        'portfolio',
        array(
            'methods' => 'GET',
            'callback' => 'get_rest_portfolio_items'
        )
    );
});

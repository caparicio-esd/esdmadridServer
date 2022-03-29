<?php

/**
 * Endpoint-----
 * 
 * Get post for single home
 * 
 * @url: http://esd-api/wp-json/esd/v1/search/
 * 
 * @param s: default: ''
 * @param page: default: 1
 * @param posts_per_page: default: 10
 * @param category: default: ''
 * 
 */



function get_rest_search($request)
{
    // fetch params
    $s = isset($_GET['s']) && !empty($_GET['s']) ? $_GET['s'] : '';
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $posts_per_page = isset($_GET['posts_per_page']) ? $_GET['posts_per_page'] : 10;
    $category = isset($_GET['category']) && !empty($_GET['category']) ? $_GET['category'] : '';


    // fetch db
    if (isset($_GET['s']) && $s != '') {
        $posts = new WP_Query(array(
            's' => $s,
            'paged' => $page,
            'posts_per_page' => $posts_per_page, 
            'post_type' => 'post'
        ));


        // construct response
        $searchData = new stdClass();
        $searchData->searchTerm = $posts->query['s'];
        $searchData->totalAmount = (int) $posts->found_posts;
        $searchData->page = $posts->query['paged'];
        $searchData->postsPerPage = $posts->query['posts_per_page'];
        $searchData->totalPages = $posts->max_num_pages;
        $searchData->postsOut = [];

        foreach ($posts->posts as $post) {
            array_push($searchData->postsOut, new esd_BE_Post_Search($post));
        }

        return $searchData;
    }

    // fetch db
    else if (isset($_GET['category']) && $category != '') {
        $posts = new WP_Query(array(
            'tax_query' => array(
                'relation' => 'OR',
                array(
                    'taxonomy' => 'post_tag',
                    'field' => 'slug',
                    'terms' => $category,
                ),
                array(
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => $category,
                ),
            ),
            'paged' => $page,
            'posts_per_page' => $posts_per_page,
            'post_type' => 'post'
        ));

        // construct response
        $searchData = new stdClass();
        $searchData->searchTerm = $posts->query['s'];
        $searchData->totalAmount = (int) $posts->found_posts;
        $searchData->page = $posts->query['paged'];
        $searchData->postsPerPage = $posts->query['posts_per_page'];
        $searchData->totalPages = $posts->max_num_pages;
        $searchData->postsOut = [];

        foreach ($posts->posts as $post) {
            array_push($searchData->postsOut, new esd_BE_Post_Search($post));
        }

        return $searchData;
    }

    // error
    else {
        return new WP_Error(
            'empty search query',
            'set a "s" variable in the URL to use the seach engine or set a "category" variable in the URL to use the seach engine filtering by category',
            array('status' => 404)
        );
    }
}



add_action('rest_api_init', function () {
    register_rest_route(
        'esd/v1',
        'search',
        array(
            'methods' => 'GET',
            'callback' => 'get_rest_search'
        )
    );
});

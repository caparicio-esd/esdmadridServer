<?php


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


function get_rest_company_items()
{

    $response = [];


    return $response;
}



add_action('rest_api_init', function () {
    register_rest_route(
        'esd/v1',
        'companies',
        array(
            'methods' => 'GET',
            'callback' => 'get_rest_company_items'
        )
    );
});

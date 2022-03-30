<?php

namespace ESD_BE\Api;

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


function get_rest_agreements_items()
{
    // fetch file
    $uri = get_template_directory() . '/microservices/extract_convenios/data/clean/convenios.json';
    $json = file_get_contents($uri);
    $data = json_decode($json, TRUE);

    // construct response
    $response = $data;
    
    return $response;
}



add_action('rest_api_init', function () {
    register_rest_route(
        'esd/v1',
        'agreements',
        array(
            'methods' => 'GET',
            'callback' => 'get_rest_agreements_items'
        )
    );
});

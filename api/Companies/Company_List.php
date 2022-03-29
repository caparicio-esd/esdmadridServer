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
    // fetch param
    $especialidad = isset($_GET['especialidad']) ? $_GET['especialidad'] : 'companies';

    // fetch file
    $uri = get_template_directory() . '/microservices/extract_companies/data/clean/' . $especialidad . '.json';
    $json = file_get_contents($uri);
    $data = json_decode($json, TRUE);

    // construct response
    $response = $data;
    
    
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

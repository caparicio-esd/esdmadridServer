<?php 


/**
 * Endpoint-----
 * 
 * Get post for single home
 * 
 * @url: https://esd-api/wp-json/esd/v1/profesores
 * 
 * 
 */


function get_profesores()
{   

    // fetch db
    // $results = new WP_Query(array(
    //     'pagename' => 'la-escuela-crece' 
    // ));

    // fetch file
    $uri = get_template_directory() . '/microservices/profesores_scraper/data/clean/profesores.json';
    $json = file_get_contents($uri);
    $data = json_decode($json, TRUE);

    // construct response
    // $response = new esd_BE_Profesores($results->posts[0]);
    // $response->content = $data;
    
    return $data;
}


add_action('rest_api_init', function () {
    register_rest_route(
        'esd/v1',
        'profesores',
        array(
            'methods' => 'GET',
            'callback' => 'get_profesores'
        )
    );
});

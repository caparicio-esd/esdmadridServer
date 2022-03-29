<?php 


/**
 * Endpoint-----
 * 
 * Get post for single home
 * 
 * @url: https://esd-api/wp-json/esd/v1/post_data/laescuelacrece
 * 
 * 
 */


function get_la_escuela_crece()
{   

    // fetch db
    $results = new WP_Query(array(
        'pagename' => 'la-escuela-crece' 
    ));

    // fetch file
    $uri = get_template_directory() . '/microservices/laescuelacrece_scraper/output/output.json';
    $json = file_get_contents($uri);
    $data = json_decode($json, TRUE);

    // construct response
    $response = new esd_BE_EscuelaCrece($results->posts[0]);
    $response->content = $data;
    
    return $response;
}


add_action('rest_api_init', function () {
    register_rest_route(
        'esd/v1',
        'page/special/la-escuela-crece',
        array(
            'methods' => 'GET',
            'callback' => 'get_la_escuela_crece'
        )
    );
});

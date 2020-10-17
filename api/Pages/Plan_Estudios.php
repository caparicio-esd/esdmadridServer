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


function get_rest_plan_estudios()
{       
    // glob
    $plan_estudios_URL = array(
        'grafico' => 'plan-de-estudios-diseno-grafico',
        'producto' => 'plan-de-estudios-diseno-de-producto',
        'interiores' => 'plan-de-estudios-diseno-de-interiores',
        'moda' => 'plan-de-estudios-diseno-de-moda'
    );

    // fetch param
    $especialidad = isset($_GET['especialidad']) ? $_GET['especialidad'] : 'grafico';

    // fetch db
    $results = new WP_Query(array(
        'pagename' => $plan_estudios_URL[$especialidad]
    ));

    // fetch file
    $uri = get_template_directory() . '/microservices/asignaturas_scraper/data/clean/' . $especialidad . '.json';
    $json = file_get_contents($uri);
    $data = json_decode($json, TRUE);

    // construct response
    $response = new esd_BE_PlanEstudios($results->posts[0]);
    $response->content = $data;
    
    return $response;
}


add_action('rest_api_init', function () {
    register_rest_route(
        'esd/v1',
        'page/special/plan-estudios',
        array(
            'methods' => 'GET',
            'callback' => 'get_rest_plan_estudios'
        )
    );
});

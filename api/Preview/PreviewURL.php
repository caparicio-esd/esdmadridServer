<?php

namespace ESD_BE\Api;

/**
 * Endpoint-----
 * 
 * Get post for single home
 * 
 * @url: https://esd-api/wp-json/esd/v1/preview/18695
 * 
 */

function get_preview_url($request)
{
    $query = new \WP_Query(array(
        "p" => $request["id"],
        "post_type" => "any",
    ));
    $result = $query->posts[0];
    return array(
        "requested_id" => $request["id"],
        "id" => $result->ID,
        "slug" => $result->post_name,
        "type" => $result->post_type,
    );
}

add_action('rest_api_init', function () {
    register_rest_route(
        'esd/v1',
        'preview/(?P<id>[-\w]+)',
        array(
            'methods' => 'GET',
            'callback' => 'get_preview_url'
        )
    );
});

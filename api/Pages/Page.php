<?php

namespace ESD_BE\Api;

use ESD_BE\BasicData;
use ESD_BE\Page;

/**
 * Endpoint-----
 * 
 * Get post for single home
 * 
 * @url: https://esd-api/wp-json/esd/v1/page
 * 
 * 
 */


function redirect_rest_pages()
{
    wp_redirect(BasicData::$api_root . 'posts');
    exit;
}


function get_rest_pages($request)
{
    $pslug = $request['slug'];
    $isPreview = isset($_GET['isPreview']) && ($_GET['isPreview'] == "true");
    $isNewPost = isset($_GET['newPost']) && ($_GET['newPost'] == "true");
    $status =  array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash');
    
    // 
    if ($isNewPost) {
        $results = new \WP_Query(array('p' => intval($pslug), 'post_type' => 'any', 'post_status' => $status));
    } else {
        $results = new \WP_Query(array('pagename' => $pslug, 'post_type' => 'any', 'post_status' => $status));
    }

    if ($isPreview && !$isNewPost) {
        $autosave = wp_get_post_autosave($results->posts[0]->ID);
        if ($autosave) {
            $response = new Page($autosave);
            return $response;
        } else {
            $response = new Page($results->posts[0]);
            return $response;
        }
    } else {
        $response = new Page($results->posts[0]);
        return $response;
    }
}



add_action('rest_api_init', function () {
    register_rest_route(
        'esd/v1',
        'page/(?P<slug>[-\w]+)',
        array(
            'methods' => 'GET',
            'callback' => 'get_rest_pages'
        )
    );
});

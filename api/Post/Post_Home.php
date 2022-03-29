<?php

/**
 * Endpoint-----
 *
 * Get post for single home
 *
 * @url: https://esd-api/wp-json/esd/v1/posts/18695
 *
 */

function get_rest_post_home($request)
{
    $pslug = $request['slug'];
    $isPreview = isset($_GET['isPreview']) && $_GET['isPreview'] == 'true';
    $isNewPost = isset($_GET['newPost']) && $_GET['newPost'] == 'true';
    $status = [
        'publish',
        'pending',
        'draft',
        'auto-draft',
        'future',
        'private',
        'inherit',
        'trash',
    ];

    //
    if ($isNewPost) {
        $results = new WP_Query([
            'p' => intval($pslug),
            'post_type' => 'any',
            'post_status' => $status,
        ]);
    } else {
        $results = new WP_Query([
            'name' => $pslug,
            'post_type' => 'any',
            'post_status' => $status,
        ]);
    }

    //
    if ($results->posts[0]->post_type !== 'page') {
        if ($isPreview && !$isNewPost) {
            $autosave = wp_get_post_autosave($results->posts[0]->ID);
            if ($autosave) {
                $response = new esd_BE_Post_Home_Single($autosave);
                return $response;
            } else {
                $response = new esd_BE_Post_Home_Single($results->posts[0]);
                return $response;
            }
        } else {
            $response = new esd_BE_Post_Home_Single($results->posts[0]);
            return $response;
        }
    } else {
        wp_redirect(esd_BE__BasicData::$api_root . 'page/' . $pslug);
        exit();
    }
}

add_action('rest_api_init', function () {
    register_rest_route('esd/v1', 'posts/(?P<slug>[-\w]+)', [
        'methods' => 'GET',
        'callback' => 'get_rest_post_home',
    ]);
});

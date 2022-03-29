<?php


function netlify_build($post_id)
{
    if (
        wp_is_post_revision($post_id) ||
        esd_BE__BasicData::$is_local
    ) {
        return;
    }

    $post_status = get_post_status($post_id);

    if (
        $post_status == "publish" ||
        $post_status == "draft"
    ) {
        $api_key = "5f69f14b5471a95792e191f0";
        $netlify_hook = "https://api.netlify.com/build_hooks/$api_key";

        $response = wp_safe_remote_post(
            $netlify_hook,
            array(
                'headers' => array('Content-Type: application/x-www-form-urlencoded'),
                'body'    => '{}',
            )
        );

        if (is_wp_error($response)) {
            $error_message = $response->get_error_message();
        }
    }
}


add_action('save_post', 'netlify_build');

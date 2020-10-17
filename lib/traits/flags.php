<?php

trait Flags {


    public function get_post_template_field($pid = 0, $flag_name = '')
    {
        global $wpdb;

        $results = $wpdb->get_results("
            SELECT post_id as id, meta_value as template FROM {$wpdb->prefix}postmeta
            WHERE post_id IN (
                SELECT meta_value FROM {$wpdb->prefix}postmeta
                WHERE post_id IN (
                    SELECT ID FROM {$wpdb->prefix}posts
                    WHERE post_type = 'nav_menu_item'
                )
                AND meta_key = '_menu_item_object_id'
                AND meta_value != 0
            )
            AND meta_key = '{$flag_name}'
        ");


        if ($pid > 0) {
            $result_out = null;
            foreach ($results as $result) {
                if ($result->id == $pid) {
                    $result_out = $result;
                break;
                } else {
                    $result_out = null;
                }
            }
            return $result_out;
        } else {
            return $results;
        }
    }


    public function get_post_template_field_by_id($pid) 
    {
        $result_out = new stdClass();
        
        foreach (esd_BE__BasicData::$template_collection as $result) {
            if ($result->id == $pid) {
                $result_out = $result;
            break;
            } else {
                $template = '';
                if ($this->utils_get_post_type($pid) == 'post') {
                    $template = esd_BE__BasicData::$flag_options[1];
                } else if ($this->utils_get_post_type($pid) == 'page') {
                    $template = esd_BE__BasicData::$flag_options[0];
                } else {
                    $template = esd_BE__BasicData::$flag_options[1];
                }

                $result_out->id = 0;
                $result_out->template = $template;
            }
        }

        return $result_out;
    }
}

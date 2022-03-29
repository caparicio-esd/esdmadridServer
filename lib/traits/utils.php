<?php

trait Utils
{

    /**                     
     * @function utils_clean_content
     * 
     * @param {text} $content -> Content
     * @return {text} $clean_content
     * 
     * Attempts to clean content, stripping out HTML tags and \n and &nsbp
     * Done to normalize old esd posts based on using html rendering plugins.
     * With new posts, won't affect anything....
     */
    public function utils_clean_content($content)
    {
        $clean_content = strip_tags($content, '<a>');
        $clean_content = str_replace("\n\n", "\r\n<", $clean_content);
        $clean_content = str_replace("&nbsp;", " ", $clean_content);
        $clean_content = trim($clean_content);
        $clean_content = nl2br($clean_content);
        $clean_content = str_replace("\r\n", "", $clean_content);
        $clean_content = str_replace("<br /><br />", "<br />", $clean_content);
        $clean_content = str_replace("<br /> <br />", "<br />", $clean_content);
        return $clean_content;
    }



    /**
     * @function utils_slugify
     * 
     * @param {String} $strIn -> String with accents and stuff
     * @return {String} $strOut -> String without accents and lowercased
     * 
     * Returns String without accents and lowercased
     * Done to create slugs from normal texts
     */
    public function utils_slugify($strIn)
    {
        $unwanted_array = array(
            'Š' => 'S', 'š' => 's', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y'
        );
        $strOut = strtr($strIn, $unwanted_array);
        $strOut = strtolower($strOut);
        return $strOut;
    }


    /**
     * @function utils_static_assets_url
     * 
     * @param {String} $url_in
     * @return {String} $url_out
     * 
     * Replace url from there to here 
     */
    public function utils_static_assets_url($url_in)
    {
        if (esd_BE__BasicData::$is_local) {
            $url_out = str_replace(
                esd_BE__BasicData::$api_static_assets,
                esd_BE__BasicData::$final_static_assets,
                $url_in
            );
        } else {
            $url_out = $url_in;
        }

        return $url_out;
    }


    /**
     * @function sanitize_meta_fields
     * 
     * @param {Object} $field_object
     * @return {Object} $field_object_out
     * 
     * Sanitize meta fields based on FE demands 
     */
    public function sanitize_meta_fields($field_object)
    {
        switch ($field_object->field_type) {
            case 'link':
                if (isset($field_object->field_value['url'])) {
                    $field_object->field_value['url'] = str_replace(esd_BE__BasicData::$root, '', $field_object->field_value['url']);
                }
                break;
            case 'date_picker':
                $d = DateTime::createFromFormat('d/m/Y', $field_object->field_value);
                $field_object->field_value = $d;
                break;
            case 'number':
                $field_object->field_value = intval($field_object->field_value);
                break;
        }

        return $field_object;
    }


    /**
     * @deprecated 
     * @function utils_inner_anchors
     * 
     * @param {Number} $pId -> Post ID Number
     * @return {String} $post_type
     * 
     * Returns the post_type from a postID
     */
    public function utils_inner_anchors($content)
    {
        return str_replace(esd_BE__BasicData::$root, '', $content);
    }


    /**
     * @deprecated 
     * @function utils_replace_strange_strings
     * 
     * @param {String} $strIn -> String in
     * @return {String} $strOut -> String out
     * 
     * Replace errored strings due to external URL strings
     * In some cases, we noticed that certain posts were broken because this url
     */
    public function utils_replace_strange_strings($strIn)
    {
        $arr_replace = array('&__tn__=-R');
        $strOut = str_replace($arr_replace, '', $strIn);
        return htmlspecialchars($strOut);
    }


    /**
     * @deprecated
     * @function utils_change_url_protocol
     * 
     * @param {String} $strIn -> URL string in to be corrected
     * 
     * Normalizes url protocol to ssl
     */
    public function utils_change_url_protocol($strIn)
    {
        if (strrpos($strIn, '/wp-content/uploads/') !== false) {
            $strIn = str_replace('http://', 'https://', $strIn);
            return $strIn;
        } else {
            return $strIn;
        }
    }
}

<?php

/**
 * 
 * Abstract Page 
 * 
 */
class esd_BE_Page extends esd_BE_Entity
{
    public $accordion_ids;
    public $accordion;
    public $links;
    public $to_unset_props = ['accordion_ids'];

    public function __construct($post)
    {
        parent::__construct($post);
        $this->accordion_ids = $this->get_accordion_ids();
        $this->accordion = $this->extract_siteorigin_accordion($post);
        $this->unset_props();
    }


    /**
     * 
     */
    function get_accordion_ids()
    {
        global $wpdb;
        $out = [];

        $results = $wpdb->get_results("
            SELECT ID FROM wp_posts
            WHERE post_content LIKE '%siteorigin%'
            OR post_content LIKE '%iw-so-accordion%'
            AND post_status = 'publish'
        ");

        foreach ($results as $result) {
            array_push($out, $result->ID);
        }

        return $out;
    }

    /**
     * 
     */
    public function extract_siteorigin_accordion($post)
    {
        $is_accordion = array_search($post->ID, $this->accordion_ids);
        $acc_out = [];
        $acc_out_titles = [];
        $acc_out_content = [];

        // is accordion
        if ($is_accordion !== false) {

            // set string as DOM
            $domDocument = new DOMDocument();
            @$domDocument->loadHTML(
                mb_convert_encoding(
                    "<div class=\"clean_content\">$post->post_content</div>",
                    'HTML-ENTITIES'
                ),
                LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
            );

            $tagNames = array('div', 'a');

            // extract
            foreach ($tagNames as $tagn) {
                $tags = $domDocument->getElementsByTagName($tagn);

                foreach ($tags as $tag) {
                    $attrs = $tag->attributes;
                    $acc_item = new stdClass();

                    foreach ($attrs as $attr) {
                        if ($attr->name == 'class' && strpos($attr->value, 'iw-so-acc-title') !== false) {
                            array_push($acc_out_titles, trim($tag->nodeValue));
                        }
                    }

                    foreach ($attrs as $attr) {
                        if ($attr->name == 'class' && strpos($attr->value, 'iw-so-acc-content') !== false) {
                            $html_string = $domDocument->saveXML($tag);
                            $html_string = $this->utils_replace_strange_strings($html_string);
                            // $html_string = $this->utils_change_url_protocol($html_string);
                            array_push($acc_out_content, $html_string);
                        }
                    }
                }
            }

            // compound data structure
            for ($i = 0; $i < sizeof($acc_out_titles); $i++) {
                $a = new stdClass();
                $a->title = $acc_out_titles[$i];
                $a->content = $acc_out_content[$i];

                array_push($acc_out, $a);
            }
        }

        return $acc_out;
    }
}


/**
 * 
 */
class esd_BE_EscuelaCrece extends esd_BE_Entity
{
    public $to_unset_props = [
        'content',
        'content_text',
        'recent_posts',
        'thumbnail',
        'prev_post',
        'next_post',
        'categories',
        'accordion',
        'links'
    ];

    public function __construct($post)
    {
        parent::__construct($post);
        $this->unset_props();
    }
}

<?php

/**
 * Entity es una clase abstracta 
 * de la que heredan todo tipo de posts, páginas, etc...
 */


abstract class esd_BE_Entity
{
    use Utils, Flags, Dom_Extractor;

    public $ID;
    public $slug;
    public $url;
    public $guid;

    public $date_creation;
    public $date_modification;
    public $author;
    public $author_link;
    public $author_picture;

    public $title;
    public $content_raw;
    public $content_text;
    public $summary;

    public $template;
    public $thumbnail;



    function __construct($post)
    {
        $this->ID = $post->ID;
        $this->slug = $post->post_name;
        $this->url = esd_BE__BasicData::$root . '/' . $this->slug;
        $this->guid = $post->guid;

        $this->date_creation = $post->post_date;
        $this->date_modification = $post->post_modified;
        $this->author = $this->get_author_name($post->post_author);
        $this->author_link = $this->get_author_url($post->post_author);
        $this->author_picture = $this->get_author_picture($post->post_author);

        $this->title = $post->post_title;
        $this->content_raw = $this->utils_normalize_content($post->post_content);
        $this->content_text = $this->utils_clean_content($post->post_content);
        $this->summary = $post->post_excerpt;        

        $this->template = $this->get_post_template_field_by_id($post->ID)->template;
        $this->thumbnail = $this->get_post_thumbnails();
    }


    /**
     * get author info
     */
    public function get_author_name($author_id)
    {
        return get_the_author_meta('display_name', $author_id);
    }

    public function get_author_url($author_id)
    {
        $nice_name = get_the_author_meta('display_name', $author_id);
        return get_author_posts_url($author_id, $nice_name);
    }

    public function get_author_picture($author_id)
    {
        return get_avatar_url($author_id, array());
    }


    /**
     * get thumbnails
     */
    public function get_post_thumbnails()
    {
        $thumbnails = [];
        $sizes = get_intermediate_image_sizes();

        foreach ($sizes as $size) {
            $gtp = get_the_post_thumbnail_url($this->ID, $size);
            $thumbnails[$size] = $gtp;
        }
        return $thumbnails;
    }


    /**
     * unset props from $this->to_unset_props array
     * 
     * for view purposes
     */
    public function unset_props()
    {
        if (isset($this->to_unset_props)) {
            foreach ($this->to_unset_props as $to_unset_prop) {
                unset($this->{$to_unset_prop});
            }
            unset($this->{'to_unset_props'});
        }
    }

    /**
     * unset all props from $this->to_unset_props array
     * except those in array
     * 
     * for view purposes
     */
    public function show_props()
    {
        if (isset($this->to_show_props)) {
            foreach (get_object_vars($this) as $key => $value) {
                if (array_search($key, $this->to_show_props) === false && $key !== 'to_show_props') {
                    unset($this->{$key});
                }
            }
            unset($this->{'to_show_props'});
        }
    }

    public function order_props()
    {
        $sortorder = [
            'ID', 'slug', 'url', 'guid',
            'title', 'content', 'content_text', 'summary',
            'template', 'date_creation', 'date_modification',
            'prev_post', 'next_post',
            'thumbnail', 'categories', 'recent_posts',
            'accordion', 'links'
        ];
    }
}

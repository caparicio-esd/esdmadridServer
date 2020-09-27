<?php


/**
 * 
 * Abstract Post 
 * 
 */
class esd_BE_Post extends esd_BE_Entity
{
    public $categories;
    public $prev;
    public $next;
    protected $category_types = array('category', 'post_tag', 'department');

    function __construct($post)
    {
        parent::__construct($post);
        $this->categories = $this->get_categories();
        $this->prev = get_previous_post($this->id);
        $this->next = get_next_post($this->id);
    }

    /**
     * get term infos...
     */
    function get_categories()
    {
        $categories_raw = wp_get_post_terms($this->id, $this->category_types);
        $categories_out = [];

        foreach ($categories_raw as $index => $category_raw) {
            $category_out = new stdClass();
            $category_out->ID = $category_raw->term_id;
            $category_out->name = $category_raw->name;
            $category_out->slug = $category_raw->slug;
            $category_out->url = get_category_link($category_raw->term_id);

            array_push($categories_out, $category_out);
        }

        return $categories_out;
    }
}


/**
 * 
 * Post in Home
 * 
 */
class esd_BE_Post_Home_ListItem extends esd_BE_Post
{
    public $to_show_props = [
        'id', 'slug', 'url', 'guid',
        'title', 'content_text',
        'thumbnails',
        'template',
        'categories'
    ];

    function __construct($post)
    {
        parent::__construct($post);
        $this->show_props();
    }
}


/**
 * 
 * Single Post in Home
 * 
 */
class esd_BE_Post_Home_Single extends esd_BE_Post
{
    public $recent;

    function __construct($post)
    {
        parent::__construct($post);
        $this->recent = $this->get_recent_posts();
    }

    function get_recent_posts()
    {
        $posts_out = [];
        $posts = get_posts(array(
            'post__not_in'   => array($this->id),
            'post_type'      => 'post',
            'posts_per_page' => 5,
            'orderby'        => 'post_date_created'
        ));

        foreach ($posts as $post) {
            array_push($posts_out, new esd_BE_Post_SuperSimplified($post));
        }

        return $posts_out;
    }
}


/**
 * 
 * Supersimplified Post in Single
 * 
 */
class esd_BE_Post_SuperSimplified extends esd_BE_Post
{
    public $to_show_props = [
        'id', 'slug', 'url',
        'title',
        'template',
    ];

    function __construct($post)
    {
        parent::__construct($post);
        $this->show_props();
    }
}


/**
 * 
 * Supersimplified Post in Search
 * 
 */
class esd_BE_Post_Search extends esd_BE_Post
{
    public $to_show_props = [
        'id', 'slug', 'url',
        'title', 'content_text',
        'template',
        'thumbnails',
        'categories'
    ];

    function __construct($post)
    {
        parent::__construct($post);
        $this->show_props();
    }
}

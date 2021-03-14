<?php


/**
 * 
 * Abstract Post 
 * 
 */
class esd_BE_Post extends esd_BE_Entity
{
    public $categories;
    public $prev_post;
    public $next_post;
    protected $category_types = array('category', 'post_tag', 'department');

    function __construct($post)
    {
        parent::__construct($post);
        $this->categories = $this->get_categories();
        $this->prev_post = get_previous_post($this->ID);
        $this->next_post = get_next_post($this->ID);
        $this->summary = $this->get_summary();
    }

    /**
     * get term infos...
     */
    function get_categories()
    {
        $terms = wp_get_post_terms($this->ID, $this->category_types);
        $categories_out = [];

        foreach ($terms as $index => $term) {
            array_push($categories_out, new Term($term));
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
        'ID', 'slug', 'url', 'guid',
        'title', 'content_text',
        'thumbnail',
        'template',
        'categories',
        'summary', 
        'cover'
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
    public $recent_posts;

    function __construct($post)
    {
        parent::__construct($post);
        $this->recent_posts = $this->get_recent_posts();
    }

    function get_recent_posts()
    {
        $posts_out = [];
        $posts = get_posts(array(
            'post__not_in'   => array($this->ID),
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
        'ID', 'slug', 'url',
        'title',
        'template',
        'summary'
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
        'ID', 'slug', 'url',
        'title', 'content_text',
        'template',
        'thumbnail',
        'categories',
        'summary'
    ];

    function __construct($post)
    {
        parent::__construct($post);
        $this->show_props();
    }
}

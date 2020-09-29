<?php


/**
 * 
 * Portfolio
 * 
 */
class esd_BE_Post_Portfolio_ListItem extends esd_BE_Post
{
    public $categories = [];
    public $categories_name = [];
    public $to_unset_props = [
        'recent_posts',
        'prev_post',
        'next_post',
    ];

    public function __construct($post)
    {
        parent::__construct($post);
        $this->unset_props();
        $this->template = 'porfolio_single';
        $this->categories = $this->get_portfolio_categories($post);
        $this->categories_name = $this->get_portfolio_categories($post, $slugged = false);
    }

    public function get_portfolio_categories($post, $slugged = true)
    {
        $posttags = wp_get_post_terms($post->ID, array('department'));
        $cats = [];

        foreach ($posttags as $posttag) {
            $tags = explode(" ", $posttag->name);
            foreach ($tags as $tag) {
                if ($slugged) {
                    $tag = $this->utils_slugify($tag);
                    array_push($cats, $tag);
                } else {
                    array_push($cats, $tag);
                }
            }
        }

        return $cats;
    }
}

/**
 * 
 * Portfolio
 * 
 */
class esd_BE_Post_Portfolio_Single extends esd_BE_Post
{
}

<?php

/**
 * 
 * Abstract Page 
 * 
 */
class esd_BE_Page extends esd_BE_Entity
{
    public $accordion;
    public $links;
    public $to_unset_props = ['accordion_ids'];

    public function __construct($post)
    {
        parent::__construct($post);
        $this->accordion = $this->get_accordion($post);
        $this->links = $this->get_links();
        $this->unset_props();
        $this->template = sizeof($this->accordion) !== 0 && $this->template == 'single_no_sidebar'  ? 'single_accordion' : $this->template;
    }

    /**
     * 
     */
    function get_links() 
    {
        $links = $this->extract_links($this->content_raw);
        return $links;
    }

    /**
     * 
     */
    public function get_accordion() 
    {        
        $links = $this->extract_accordion($this->content_raw);
        return $links;
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


/**
 * 
 */
class esd_BE_PlanEstudios extends esd_BE_EscuelaCrece
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
        'links', 
        'content_raw', 
        'summary', 
    ];

    public function __construct($post)
    {
        parent::__construct($post);
        $this->unset_props();
        $this->template = 'single_plan_estudios';
    }
}


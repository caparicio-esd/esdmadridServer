<?php

class Term {
    public $ID;
    public $name;
    public $slug; 
    public $url;

    public function __construct($term)
    {
        $this->ID = $term->term_id;
        $this->name = $term->name;
        $this->slug = $term->slug;
        $this->url = get_category_link($term->term_id);
    }
}


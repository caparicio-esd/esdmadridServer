<?php

namespace ESD_BE;
/**
 *
 * View for Term Data
 * It gets a WP_Term object as parameter and returns a
 * suitable view for JSON REST-API
 */
class Term
{
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

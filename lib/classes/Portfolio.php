<?php

namespace ESD_BE;

/**
 *
 * View for a special Post view in Portfolio
 * It gets a WP_Post object as parameter and returns a
 * suitable view for JSON REST-API
 */
class PortfolioItem extends Post
{
  public $categories = [];
  public $categories_name = [];
  public $to_unset_props = ['recent_posts', 'prev_post', 'next_post'];

  public function __construct($post)
  {
    parent::__construct($post);
    $this->unset_props();
    $this->template = 'porfolio_single';
    $this->categories = $this->get_portfolio_categories($post);
    $this->categories_name = $this->get_portfolio_categories($post, $slugged = false);
  }

  /**
   * Get portfolio categories from taxonomy based in post
   * It returns an array of categories, based on name o slug
   */
  public function get_portfolio_categories($post, $slugged = true)
  {
    $posttags = wp_get_post_terms($post->ID, ['department']);
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

<?php

namespace ESD_BE;

/**
 *
 * View for a normal Post
 * It gets a WP_Post object as parameter and returns a
 * suitable view for JSON REST-API
 */
class Post extends Entity
{
  public $categories;
  public $prev_post;
  public $next_post;
  protected $category_types = ['category', 'post_tag', 'department'];

  function __construct($post)
  {
    parent::__construct($post);
    $this->categories = $this->get_categories();
    $this->prev_post = get_previous_post($this->ID);
    $this->next_post = get_next_post($this->ID);
    $this->summary = $this->get_summary();
  }

  /**
   * Populates a normal post with categories
   */
  protected function get_categories()
  {
    $terms = wp_get_post_terms($this->ID, $this->category_types);
    $categories_out = [];
    foreach ($terms as $index => $term) {
      array_push($categories_out, new Term($term));
    }
    return $categories_out;
  }
}

namespace ESD_BE\Post;

/**
 *
 * View for a sumed up Post applied in home list
 * It gets a WP_Post object as parameter and returns a
 * suitable view for JSON REST-API
 */
class Home extends \ESD_BE\Post
{
  public $to_show_props = [
    'ID',
    'slug',
    'url',
    'guid',
    'title',
    'content_text',
    'thumbnail',
    'template',
    'categories',
    'summary',
    'cover',
    'event',
  ];
  function __construct($post)
  {
    parent::__construct($post);
    $this->show_props();
  }
}

/**
 *
 * View for a single Post applied
 * It gets a WP_Post object as parameter and returns a
 * suitable view for JSON REST-API
 */
class HomeSingle extends \ESD_BE\Post
{
  public $recent_posts;

  function __construct($post)
  {
    parent::__construct($post);
    $this->recent_posts = $this->get_recent_posts();
  }

  /**
   * Populates an array field with last posts
   */
  private function get_recent_posts()
  {
    $posts_out = [];
    $posts = get_posts([
      'post__not_in' => [$this->ID],
      'post_type' => 'post',
      'posts_per_page' => 5,
      'orderby' => 'post_date_created',
    ]);
    foreach ($posts as $post) {
      array_push($posts_out, new SimplePost($post));
    }
    return $posts_out;
  }
}

/**
 *
 * View for a card simplified Post applied in recent posts
 * It gets a WP_Post object as parameter and returns a
 * suitable view for JSON REST-API
 */
class SimplePost extends \ESD_BE\Post
{
  public $to_show_props = ['ID', 'slug', 'url', 'title', 'template', 'summary'];

  function __construct($post)
  {
    parent::__construct($post);
    $this->show_props();
  }
}

/**
 *
 * View for a card simplified Post as search results
 * It gets a WP_Post object as parameter and returns a
 * suitable view for JSON REST-API
 */
class Search extends \ESD_BE\Post
{
  public $to_show_props = ['ID', 'slug', 'url', 'title', 'content_text', 'template', 'thumbnail', 'categories', 'summary'];

  function __construct($post)
  {
    parent::__construct($post);
    $this->show_props();
  }
}

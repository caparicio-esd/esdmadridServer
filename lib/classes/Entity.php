<?php

namespace ESD_BE;

/**
 *
 * Abstract View for Pages, Posts, ect...
 * It gets a WP_Post object as parameter and returns a
 * suitable view for JSON REST-API
 * It constructs the most of the JSON fields,
 * other fields come based on view application
 */
abstract class Entity
{
  use Flags, DomExtractor, Utils {
    DomExtractor::utils_clean_content insteadof Utils;
    DomExtractor::utils_slugify insteadof Utils;
    DomExtractor::utils_static_assets_url insteadof Utils;
    DomExtractor::sanitize_meta_fields insteadof Utils;
    DomExtractor::utils_inner_anchors insteadof Utils;
    DomExtractor::utils_replace_strange_strings insteadof Utils;
    DomExtractor::utils_change_url_protocol insteadof Utils;
  }

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
  public $cover;
  public $event;

  function __construct($post)
  {
    $this->ID = $post->ID;
    $this->slug = $post->post_name;
    $this->url = BasicData::$root . '/' . $this->slug;
    $this->guid = $post->guid;

    $this->date_creation = $post->post_date;
    $this->date_modification = $post->post_modified;
    $this->author = $this->get_author_name($post->post_author);
    $this->author_link = $this->get_author_url($post->post_author);
    $this->author_picture = $this->get_author_picture($post->post_author);

    $this->title = $post->post_title;
    $this->content_raw = $this->utils_normalize_content($post->post_content);
    $this->content_text = $this->utils_normalize_content($this->utils_clean_content($post->post_content));
    $this->summary = $post->post_excerpt != '' ? $post->post_excerpt : $this->get_summary();

    $this->template = $this->get_post_template_field_by_id($post->ID)->template;
    $this->thumbnail = $this->get_post_thumbnails();
    $this->cover = $this->thumbnail["large"];
    $this->event = $this->get_event();
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
    return get_avatar_url($author_id, []);
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
      $gtp = $this->utils_static_assets_url($gtp);
      $thumbnails[$size] = $gtp;
    }
    return $thumbnails;
  }

  /**
   * get summary
   */
  public function get_summary($length = 30)
  {
    $summary = $this->extract_summary($this->content_raw);

    if ($summary != "") {
      $summary_array = explode(' ', $summary);
      if (sizeof($summary_array) > $length) {
        return implode(' ', array_slice($summary_array, 0, $length)) . '...';
      } else {
        return $summary;
      }
    } else {
      return "";
    }
  }

  /**
   * get event
   */
  public function get_event()
  {
    $event = new \stdClass();
    $event->place = get_post_meta($this->ID, "lugar_evento", true);
    $event->date = get_post_meta($this->ID, "fecha_evento", true);
    $event->dateEnd = get_post_meta($this->ID, "fecha_evento_end", true);

    return $event;
  }

  /**
   * get meta
   */
  public function get_meta()
  {
    $meta = [];
    if (isset($this->meta_fields)) {
      foreach ($this->meta_fields as $meta_field) {
        if (function_exists("get_field_object")) {
          $meta_field_raw = get_field_object($meta_field, $this->ID);
          if ($meta_field_raw['label'] != null) {
            $meta_field_out = new \stdClass();
            $meta_field_out->field_label = $meta_field_raw['label'];
            $meta_field_out->field_name = $meta_field_raw['name'];
            $meta_field_out->field_type = $meta_field_raw['type'];
            $meta_field_out->field_value = $meta_field_raw['value'];

            $meta_field_out = $this->sanitize_meta_fields($meta_field_out);
            array_push($meta, $meta_field_out);
          }
        } else {
          $meta = "No se encuentra función. Hay que instalar ACF Plugin.";
        }
      }
    }
    $this->meta = $meta;
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

  /**
   * order all props based in sortorder
   * TODO still to be done
   */
  public function order_props()
  {
    $sortorder = [
      'ID',
      'slug',
      'url',
      'guid',
      'title',
      'content',
      'content_text',
      'summary',
      'template',
      'date_creation',
      'date_modification',
      'prev_post',
      'next_post',
      'thumbnail',
      'categories',
      'recent_posts',
      'accordion',
      'links',
    ];
  }
}

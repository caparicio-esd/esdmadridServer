<?php

/**
 * Endpoint-----
 *
 * Get all posts for blog
 *
 * @url: https://esd-api/wp-json/esd/v1/blog
 *
 * @param page: default: 1
 * @param posts_per_page: default: 10
 */

function get_blog()
{
    $results = get_blog_posts();
    $posts = [];
    foreach ($results['results']['posts'] as $post) {
        array_push($posts, new esd_BE_Post_Home_ListItem($post));
    }

    $response = [
        'search_info' => $results['searchInfo'],
        'posts' => $posts,
        'blog_dates' => get_blog_dates(
            $results['searchInfo']['year'],
            $results['searchInfo']['month']
        ),
        'blog_categories' => get_blog_categories($results['searchInfo']['categories']),
    ];

    return $response;
}

add_action('rest_api_init', function () {
    register_rest_route('esd/v1', 'blog', [
        'methods' => 'GET',
        'callback' => 'get_blog',
    ]);
});

/**
 *
 */
function get_blog_posts()
{
    $categories = isset($_GET['categories']) ? explode(',', $_GET['categories']) : [];
    $year = isset($_GET['year']) ? $_GET['year'] : '';
    $month = isset($_GET['month']) ? $_GET['month'] : '';
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $postsPerPage = isset($_GET['posts_per_page']) ? $_GET['posts_per_page'] : 10;



    $query = new WP_Query([
        'post_type' => 'post',
        'posts_per_page' => $postsPerPage,
        'paged' => $page,
        'year' => $year,
        'monthnum' => $month,
        'tax_query' =>
            sizeof($categories) > 0
                ? [
                    'relation' => 'OR',
                    [
                        'taxonomy' => 'category',
                        'field' => 'slug',
                        'terms' => $categories,
                    ],
                    [
                        'taxonomy' => 'post_tag',
                        'field' => 'slug',
                        'terms' => $categories,
                    ],
                ]
                : '',
    ]);

    $blog_info = [
        'categories' => $categories,
        'year' => $year,
        'month' => $month,
        'page' => $page,
        'postsPerPage' => $postsPerPage,
        'totalPages' => $query->max_num_pages,
        'totalPosts' => $query->found_posts
    ];
    $blog_results = [
        'posts' => $query->posts,
        'count' => $query->found_posts,
        'totalPages' => $query->max_num_pages,
    ];

    return [
        'searchInfo' => $blog_info,
        'results' => $blog_results,
    ];
}

/**
 *
 */
function get_blog_categories($selectedCategories)
{
    global $wpdb;

    $inStatement = "'" . join("','", $selectedCategories) . "'";

    $results = $wpdb->get_results(
        "
            SELECT *, if (category_slug IN ({$inStatement}) = 0, 'false', 'true') as selected
            FROM (
                SELECT name AS category_name, slug AS category_slug, COUNT(*) AS amount
                FROM {$wpdb->prefix}terms
                LEFT JOIN {$wpdb->prefix}term_relationships ON {$wpdb->prefix}terms.term_id = {$wpdb->prefix}term_relationships.term_taxonomy_id
                JOIN {$wpdb->prefix}term_taxonomy ON {$wpdb->prefix}term_taxonomy.term_id = {$wpdb->prefix}terms.term_id
                WHERE taxonomy IN('category', 'post_tag')
                GROUP BY name, slug
                ORDER BY amount DESC) AS q
            WHERE category_slug NOT IN('sin-categoria', 'm2sonido', 'sliderhall', 'sliderhome')
            ORDER BY selected DESC
        "
    );

    return $results;
}

/**
 *
 */
function get_blog_dates($year, $month)
{
    global $wpdb;
    $results = $wpdb->get_results(
        "
            SELECT 
                *, 
                if (year = '{$year}', 'true', 'false') as selected_year, 
                if (year = '{$year}' and month = '{$month}', 'true', 'false') as selected_month
            FROM (
                SELECT YEAR(post_date) AS year, MONTH(post_date) AS month, COUNT(*) AS amount
                FROM {$wpdb->prefix}posts
                WHERE post_type IN ('post')
                AND post_status IN ('published')
                GROUP BY YEAR(post_date), MONTH(post_date)
                ORDER BY YEAR(post_date) DESC, MONTH(post_date) DESC
            ) AS q
            ORDER BY selected_year DESC, selected_month DESC
        "
    );

    return $results;
}

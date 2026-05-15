<?php
if (! defined('ABSPATH')) {
	exit;
}

$term = get_queried_object();

if (! $term instanceof WP_Term) {
	include get_query_template('404');
	return;
}

$category = ttshopgear_get_category($term->slug);
if (! $category) {
	$category = ttshopgear_map_wc_term_to_category($term);
}

ttshopgear_set_virtual_route_context(
	array(
		'type' => 'category',
		'category' => $category,
		'products' => ttshopgear_get_products_by_category($term->slug),
		'title' => $category['name'],
	)
);

require get_template_directory() . '/templates/route-page.php';


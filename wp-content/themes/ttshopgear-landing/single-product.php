<?php
if (! defined('ABSPATH')) {
	exit;
}

$post_id = get_the_ID();
$product = $post_id ? ttshopgear_get_product_by_slug(get_post_field('post_name', $post_id)) : null;

if (! $product && $post_id && function_exists('wc_get_product')) {
	$wc_product = wc_get_product($post_id);
	if ($wc_product) {
		$product = ttshopgear_map_wc_product($wc_product);
	}
}

if (! $product) {
	include get_query_template('404');
	return;
}

ttshopgear_set_virtual_route_context(
	array(
		'type' => 'product',
		'product' => $product,
		'title' => $product['name'],
	)
);

require get_template_directory() . '/templates/product-single.php';


<?php
if (! defined('ABSPATH')) {
	exit;
}

function ttshopgear_set_virtual_route_context($context) {
	$GLOBALS['ttshopgear_virtual_route_context'] = $context;
}

function ttshopgear_get_virtual_route_context() {
	return isset($GLOBALS['ttshopgear_virtual_route_context']) ? $GLOBALS['ttshopgear_virtual_route_context'] : null;
}

function ttshopgear_get_request_path() {
	global $wp;

	if (isset($wp->request)) {
		return trim((string) $wp->request, '/');
	}

	$request_uri = isset($_SERVER['REQUEST_URI']) ? wp_unslash($_SERVER['REQUEST_URI']) : '';
	$path        = wp_parse_url($request_uri, PHP_URL_PATH);
	$site_path   = wp_parse_url(home_url('/'), PHP_URL_PATH);

	if ($site_path && 0 === strpos((string) $path, (string) $site_path)) {
		$path = substr($path, strlen($site_path));
	}

	return trim((string) $path, '/');
}

function ttshopgear_match_virtual_route($path) {
	$path = trim((string) $path, '/');

	if ('' === $path) {
		return null;
	}

	$segments = array_values(array_filter(explode('/', $path)));
	if (empty($segments)) {
		return null;
	}

	if ('products' === $segments[0]) {
		if (1 === count($segments)) {
			return array(
				'type'  => 'shop',
				'title' => 'Tất cả sản phẩm',
			);
		}

		$product = ttshopgear_get_product_by_slug($segments[1]);
		if ($product) {
			return array(
				'type'    => 'product',
				'product' => $product,
				'title'   => $product['name'],
			);
		}

		return null;
	}

	$category = ttshopgear_get_category($segments[0]);
	if ($category) {
		if (1 === count($segments)) {
			return array(
				'type'     => 'category',
				'category' => $category,
				'products' => ttshopgear_get_products_by_category($category['slug']),
				'title'    => $category['name'],
			);
		}

		$filter_label = ttshopgear_get_filter_label($category['slug'], $segments[1]);
		$filter_items = ttshopgear_get_category_filter_items($category['slug']);
		foreach ($filter_items as $filter_item) {
			if ($filter_item['slug'] !== $segments[1]) {
				continue;
			}

			return array(
				'type'         => 'category',
				'category'     => $category,
				'filter_slug'  => $segments[1],
				'filter_label' => $filter_label,
				'products'     => ttshopgear_get_products_by_category_filter($category['slug'], $segments[1]),
				'title'        => $category['name'] . ' - ' . $filter_label,
			);
		}

		$product = ttshopgear_get_product_by_route($category['slug'], $segments[1]);
		if ($product) {
			return array(
				'type'    => 'product',
				'product' => $product,
				'title'   => $product['name'],
			);
		}

		return array(
			'type'         => 'category',
			'category'     => $category,
			'filter_slug'  => $segments[1],
			'filter_label' => $filter_label,
			'products'     => ttshopgear_get_products_by_category_filter($category['slug'], $segments[1]),
			'title'        => $category['name'] . ' - ' . $filter_label,
		);
	}

	$page = ttshopgear_get_static_page($segments[0]);
	if ($page && 1 === count($segments)) {
		return array(
			'type'  => 'page',
			'page'  => $page,
			'slug'  => $segments[0],
			'title' => $page['title'],
		);
	}

	return null;
}

function ttshopgear_virtual_template_include($template) {
	if (! is_404()) {
		return $template;
	}

	$context = ttshopgear_match_virtual_route(ttshopgear_get_request_path());
	if (! $context) {
		return $template;
	}

	global $wp_query;

	status_header(200);
	$wp_query->is_404          = false;
	$wp_query->query_vars['error'] = '';

	ttshopgear_set_virtual_route_context($context);

	if ('product' === $context['type']) {
		return get_template_directory() . '/templates/product-single.php';
	}

	if ('shop' === $context['type']) {
		return get_template_directory() . '/templates/shop-archive.php';
	}

	return get_template_directory() . '/templates/route-page.php';
}
add_filter('template_include', 'ttshopgear_virtual_template_include');

function ttshopgear_virtual_route_redirect_canonical($redirect_url, $requested_url) {
	$context = ttshopgear_match_virtual_route(ttshopgear_get_request_path());

	if ($context) {
		return false;
	}

	return $redirect_url;
}
add_filter('redirect_canonical', 'ttshopgear_virtual_route_redirect_canonical', 10, 2);

function ttshopgear_virtual_title($parts) {
	$context = ttshopgear_get_virtual_route_context();
	if (! $context || empty($context['title'])) {
		return $parts;
	}

	$parts['title'] = $context['title'];

	return $parts;
}
add_filter('document_title_parts', 'ttshopgear_virtual_title');

function ttshopgear_virtual_body_class($classes) {
	$context = ttshopgear_get_virtual_route_context();
	if (! $context) {
		return $classes;
	}

	$classes[] = 'tt-route-active';
	$classes[] = 'tt-route-' . sanitize_html_class($context['type']);

	if (! empty($context['category']['slug'])) {
		$classes[] = 'tt-route-category-' . sanitize_html_class($context['category']['slug']);
	}

	if (! empty($context['slug'])) {
		$classes[] = 'tt-route-page-' . sanitize_html_class($context['slug']);
	}

	return $classes;
}
add_filter('body_class', 'ttshopgear_virtual_body_class');

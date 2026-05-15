<?php
if (! defined('ABSPATH')) {
	exit;
}

require_once get_template_directory() . '/inc/theme-data.php';
require_once get_template_directory() . '/inc/theme-routes.php';
if (class_exists('WooCommerce')) {
	require_once get_template_directory() . '/inc/class-ttshopgear-gateway-momo-qr.php';
}

function ttshopgear_theme_setup() {
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('woocommerce');
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
}
add_action('after_setup_theme', 'ttshopgear_theme_setup');

function ttshopgear_enqueue_assets() {
	$theme = wp_get_theme();
	$css_path = get_template_directory() . '/assets/css/theme.css';
	$js_path = get_template_directory() . '/assets/js/theme.js';
	$css_version = file_exists($css_path) ? (string) filemtime($css_path) : $theme->get('Version');
	$js_version = file_exists($js_path) ? (string) filemtime($js_path) : $theme->get('Version');

	wp_enqueue_style(
		'ttshopgear-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Oswald:wght@400;500;600;700&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'ttshopgear-theme',
		get_template_directory_uri() . '/assets/css/theme.css',
		array(),
		$css_version
	);

	wp_enqueue_script(
		'ttshopgear-theme',
		get_template_directory_uri() . '/assets/js/theme.js',
		array(),
		$js_version,
		true
	);

	wp_localize_script(
		'ttshopgear-theme',
		'ttshopgearTheme',
		array(
			'ajaxUrl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('ttshopgear-actions'),
			'vnUnitsUrl' => get_template_directory_uri() . '/assets/data/vn-admin-units.json',
			'labels' => array(
				'searchLoading' => 'Đang tìm sản phẩm...',
				'searchEmpty' => 'Không tìm thấy sản phẩm phù hợp.',
				'addToCart' => 'Thêm vào giỏ hàng',
				'addingToCart' => 'Đang thêm...',
				'addedToCart' => 'Đã thêm vào giỏ hàng',
				'addToCartError' => 'Không thể thêm sản phẩm vào giỏ hàng.',
				'logoutConfirm' => 'Bạn có chắc muốn đăng xuất không?',
			),
		)
	);

	wp_add_inline_script(
		'ttshopgear-theme',
		'window.ttshopgearTheme = window.ttshopgearTheme || {}; window.ttshopgearTheme.vnUnitsUrl = ' . wp_json_encode(get_template_directory_uri() . '/assets/data/vn-admin-units.json') . '; window.ttshopgearTheme.labels = Object.assign({}, window.ttshopgearTheme.labels || {}, ' . wp_json_encode(
			array(
				'chooseProvince' => 'Chọn tỉnh / thành phố',
				'chooseWard' => 'Chọn phường / xã',
				'chooseWardFirst' => 'Chọn tỉnh / thành phố trước',
			)
		) . ');',
		'after'
	);
}
add_action('wp_enqueue_scripts', 'ttshopgear_enqueue_assets');

add_filter('woocommerce_enqueue_styles', '__return_empty_array');

function ttshopgear_filter_account_menu_items($items) {
	$allowed_items = array(
		'edit-account' => 'Thông tin tài khoản',
		'orders' => 'Đơn hàng',
		'payment-methods' => 'Phương thức thanh toán',
		'customer-logout' => 'Đăng xuất',
	);

	$filtered_items = array();

	foreach ($allowed_items as $endpoint => $label) {
		if (isset($items[ $endpoint ])) {
			$filtered_items[ $endpoint ] = $label;
		}
	}

	return $filtered_items;
}
add_filter('woocommerce_account_menu_items', 'ttshopgear_filter_account_menu_items');

function ttshopgear_redirect_account_dashboard() {
	if (! function_exists('is_account_page') || ! is_account_page() || ! is_user_logged_in()) {
		return;
	}

	if (is_wc_endpoint_url()) {
		return;
	}

	wp_safe_redirect(wc_get_account_endpoint_url('edit-account'));
	exit;
}
add_action('template_redirect', 'ttshopgear_redirect_account_dashboard');

function ttshopgear_filter_order_button_text() {
	return 'Đặt hàng';
}
add_filter('woocommerce_order_button_text', 'ttshopgear_filter_order_button_text');

function ttshopgear_render_head_icons() {
	$base = esc_url(get_template_directory_uri() . '/assets/images');
	?>
	<link rel="icon" media="(prefers-color-scheme: light)" href="<?php echo $base; ?>/icon-light-32x32.png">
	<link rel="icon" media="(prefers-color-scheme: dark)" href="<?php echo $base; ?>/icon-dark-32x32.png">
	<link rel="icon" type="image/svg+xml" href="<?php echo $base; ?>/icon.svg">
	<link rel="apple-touch-icon" href="<?php echo $base; ?>/apple-icon.png">
	<?php
}
add_action('wp_head', 'ttshopgear_render_head_icons');

function ttshopgear_icon($name, $class = '') {
	$class_attr = $class ? ' class="' . esc_attr($class) . '"' : '';

	$icons = array(
		'download' => '<svg viewBox="0 0 24 24"' . $class_attr . ' fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><path d="m7 10 5 5 5-5"></path><path d="M12 15V3"></path></svg>',
		'search' => '<svg viewBox="0 0 24 24"' . $class_attr . ' fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>',
		'user' => '<svg viewBox="0 0 24 24"' . $class_attr . ' fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21a7 7 0 0 0-14 0"></path><circle cx="12" cy="8" r="4"></circle></svg>',
		'eye' => '<svg viewBox="0 0 24 24"' . $class_attr . ' fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle></svg>',
		'eye-off' => '<svg viewBox="0 0 24 24"' . $class_attr . ' fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 3 18 18"></path><path d="M10.6 10.53A3 3 0 0 0 12 15a3 3 0 0 0 2.47-1.4"></path><path d="M9.88 5.09A10.94 10.94 0 0 1 12 5c6.5 0 10 7 10 7a13.16 13.16 0 0 1-2.17 3.19"></path><path d="M6.61 6.62C4.62 8 3.3 10.15 2 12c0 0 3.5 7 10 7a9.77 9.77 0 0 0 4.24-.92"></path></svg>',
		'cart' => '<svg viewBox="0 0 24 24"' . $class_attr . ' fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57L22 6H6"></path></svg>',
		'menu' => '<svg viewBox="0 0 24 24"' . $class_attr . ' fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 12h16"></path><path d="M4 6h16"></path><path d="M4 18h16"></path></svg>',
		'close' => '<svg viewBox="0 0 24 24"' . $class_attr . ' fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>',
		'check' => '<svg viewBox="0 0 24 24"' . $class_attr . ' fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m5 13 4 4L19 7"></path></svg>',
		'chevron-down' => '<svg viewBox="0 0 24 24"' . $class_attr . ' fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"></path></svg>',
		'chevron-left' => '<svg viewBox="0 0 24 24"' . $class_attr . ' fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"></path></svg>',
		'chevron-right' => '<svg viewBox="0 0 24 24"' . $class_attr . ' fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"></path></svg>',
		'zap' => '<svg viewBox="0 0 24 24"' . $class_attr . ' fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2 3 14h7l-1 8 10-12h-7z"></path></svg>',
		'shield' => '<svg viewBox="0 0 24 24"' . $class_attr . ' fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"></path></svg>',
		'truck' => '<svg viewBox="0 0 24 24"' . $class_attr . ' fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 17h4V5H2v12h3"></path><path d="M14 9h4l4 4v4h-3"></path><circle cx="7.5" cy="17.5" r="2.5"></circle><circle cx="17.5" cy="17.5" r="2.5"></circle></svg>',
		'headphones' => '<svg viewBox="0 0 24 24"' . $class_attr . ' fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 14a9 9 0 1 1 18 0"></path><path d="M21 15a2 2 0 0 1-2 2h-1v-6h1a2 2 0 0 1 2 2z"></path><path d="M3 15a2 2 0 0 0 2 2h1v-6H5a2 2 0 0 0-2 2z"></path></svg>',
		'refresh' => '<svg viewBox="0 0 24 24"' . $class_attr . ' fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 2v6h-6"></path><path d="M3 12a9 9 0 0 1 15.55-6.36L21 8"></path><path d="M3 22v-6h6"></path><path d="M21 12a9 9 0 0 1-15.55 6.36L3 16"></path></svg>',
		'award' => '<svg viewBox="0 0 24 24"' . $class_attr . ' fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"></circle><path d="m8.21 13.89-1.42 8.06L12 19l5.21 2.95-1.42-8.06"></path></svg>',
		'keyboard' => '<svg viewBox="0 0 24 24"' . $class_attr . ' fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="20" height="12" rx="2"></rect><path d="M6 10h.01"></path><path d="M10 10h.01"></path><path d="M14 10h.01"></path><path d="M18 10h.01"></path><path d="M6 14h8"></path><path d="M16 14h2"></path></svg>',
		'mouse' => '<svg viewBox="0 0 24 24"' . $class_attr . ' fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="7" y="2" width="10" height="20" rx="5"></rect><path d="M12 6v4"></path></svg>',
		'monitor' => '<svg viewBox="0 0 24 24"' . $class_attr . ' fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"></rect><path d="M8 21h8"></path><path d="M12 17v4"></path></svg>',
		'cpu' => '<svg viewBox="0 0 24 24"' . $class_attr . ' fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="7" y="7" width="10" height="10" rx="1"></rect><path d="M4 10h3"></path><path d="M4 14h3"></path><path d="M17 10h3"></path><path d="M17 14h3"></path><path d="M10 4v3"></path><path d="M14 4v3"></path><path d="M10 17v3"></path><path d="M14 17v3"></path></svg>',
		'gamepad' => '<svg viewBox="0 0 24 24"' . $class_attr . ' fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 12h4"></path><path d="M8 10v4"></path><path d="M15 13h.01"></path><path d="M18 11h.01"></path><path d="M6.75 6h10.5a3.75 3.75 0 0 1 3.64 4.67l-1.16 4.62a2.5 2.5 0 0 1-3.99 1.41L13.5 15h-3l-2.24 1.7a2.5 2.5 0 0 1-3.99-1.41L3.11 10.67A3.75 3.75 0 0 1 6.75 6z"></path></svg>',
		'star' => '<svg viewBox="0 0 24 24"' . $class_attr . ' fill="currentColor" stroke="none"><path d="m12 2.4 2.97 6.01 6.63.96-4.8 4.68 1.13 6.6L12 17.53l-5.93 3.12 1.13-6.6-4.8-4.68 6.63-.96L12 2.4z"></path></svg>',
		'quote' => '<svg viewBox="0 0 24 24"' . $class_attr . ' fill="currentColor"><path d="M10 11H6.5a2.5 2.5 0 0 1 2.5-2.5V5A6 6 0 0 0 3 11v8h7zm11 0h-3.5A2.5 2.5 0 0 1 20 8.5V5a6 6 0 0 0-6 6v8h7z"></path></svg>',
		'send' => '<svg viewBox="0 0 24 24"' . $class_attr . ' fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4Z"></path><path d="M22 2 11 13"></path></svg>',
		'facebook' => '<svg viewBox="0 0 24 24"' . $class_attr . ' fill="currentColor"><path d="M13.5 22v-8h2.7l.4-3h-3.1V9.1c0-.9.3-1.6 1.6-1.6H17V4.8c-.3 0-1.3-.1-2.5-.1-2.5 0-4.2 1.5-4.2 4.4V11H7.5v3h2.8v8z"></path></svg>',
		'twitter' => '<svg viewBox="0 0 24 24"' . $class_attr . ' fill="currentColor"><path d="M18.9 2H22l-6.8 7.8L23 22h-6.1l-4.8-6.3L6.6 22H3.5l7.3-8.4L1.4 2h6.2l4.3 5.7z"></path></svg>',
		'instagram' => '<svg viewBox="0 0 24 24"' . $class_attr . ' fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="5"></rect><circle cx="12" cy="12" r="4"></circle><circle cx="17.5" cy="6.5" r="1"></circle></svg>',
		'youtube' => '<svg viewBox="0 0 24 24"' . $class_attr . ' fill="currentColor"><path d="M21.6 7.2a2.99 2.99 0 0 0-2.1-2.1C17.7 4.5 12 4.5 12 4.5s-5.7 0-7.5.6a2.99 2.99 0 0 0-2.1 2.1 31.2 31.2 0 0 0-.6 4.8 31.2 31.2 0 0 0 .6 4.8 2.99 2.99 0 0 0 2.1 2.1c1.8.6 7.5.6 7.5.6s5.7 0 7.5-.6a2.99 2.99 0 0 0 2.1-2.1 31.2 31.2 0 0 0 .6-4.8 31.2 31.2 0 0 0-.6-4.8ZM10 15.5v-7l6 3.5z"></path></svg>',
		'twitch' => '<svg viewBox="0 0 24 24"' . $class_attr . ' fill="currentColor"><path d="M4 3 2 8v11h4v3h3l3-3h4l6-6V3Zm14 9-3 3h-4l-3 3v-3H5V5h13ZM15 7h2v5h-2Zm-5 0h2v5h-2Z"></path></svg>',
	);

	return isset($icons[ $name ]) ? $icons[ $name ] : '';
}

function ttshopgear_format_catalog_price($raw_price) {
	$price = (float) $raw_price;

	if ($price <= 0) {
		return 'Liên hệ';
	}

	if (function_exists('wc_price')) {
		return html_entity_decode(
			wp_strip_all_tags(
			wc_price(
				$price,
				array(
					'decimals' => 0,
				)
			)
			),
			ENT_QUOTES,
			get_bloginfo('charset')
		);
	}

	return number_format_i18n((int) round($price), 0) . ' đ';
}

function ttshopgear_get_live_search_results() {
	check_ajax_referer('ttshopgear-actions', 'nonce');

	$query = isset($_POST['query']) ? sanitize_text_field(wp_unslash($_POST['query'])) : '';

	$query_length = function_exists('mb_strlen') ? mb_strlen($query) : strlen($query);

	if ($query_length < 2) {
		wp_send_json_success(array('products' => array()));
	}

	$search_query = new WP_Query(
		array(
			'post_type' => 'product',
			'post_status' => 'publish',
			'posts_per_page' => 6,
			's' => $query,
			'fields' => 'ids',
			'no_found_rows' => true,
		)
	);

	$products = array();

	foreach ($search_query->posts as $product_id) {
		$wc_product = wc_get_product($product_id);

		if (! $wc_product || ! $wc_product->is_visible()) {
			continue;
		}

		$product = ttshopgear_map_wc_product($wc_product);

		$products[] = array(
			'id' => $product['id'],
			'name' => $product['name'],
			'url' => ttshopgear_get_product_url($product),
			'imageUrl' => $product['image_url'],
			'category' => $product['category'],
			'price' => ttshopgear_format_catalog_price($product['price']),
		);
	}

	wp_send_json_success(array('products' => $products));
}
add_action('wp_ajax_ttshopgear_live_search', 'ttshopgear_get_live_search_results');
add_action('wp_ajax_nopriv_ttshopgear_live_search', 'ttshopgear_get_live_search_results');

function ttshopgear_ajax_add_to_cart() {
	check_ajax_referer('ttshopgear-actions', 'nonce');

	if (! function_exists('WC')) {
		wp_send_json_error(array('message' => 'WooCommerce chưa sẵn sàng.'), 500);
	}

	if (null === WC()->cart) {
		wc_load_cart();
	}

	$product_id = isset($_POST['productId']) ? absint($_POST['productId']) : 0;
	$wc_product = $product_id ? wc_get_product($product_id) : false;

	if (! $wc_product || ! $wc_product->is_purchasable() || ! $wc_product->is_in_stock()) {
		wp_send_json_error(array('message' => 'Sản phẩm hiện không thể thêm vào giỏ hàng.'), 400);
	}

	$added = WC()->cart->add_to_cart($product_id);

	if (! $added) {
		wp_send_json_error(array('message' => 'Không thể thêm sản phẩm vào giỏ hàng.'), 400);
	}

	wp_send_json_success(
		array(
			'cartCount' => WC()->cart->get_cart_contents_count(),
			'cartUrl' => wc_get_cart_url(),
		)
	);
}
add_action('wp_ajax_ttshopgear_add_to_cart', 'ttshopgear_ajax_add_to_cart');
add_action('wp_ajax_nopriv_ttshopgear_add_to_cart', 'ttshopgear_ajax_add_to_cart');

function ttshopgear_get_default_momo_qr_url() {
	$candidates = array();

	if (function_exists('wp_upload_dir')) {
		$uploads = wp_upload_dir();

		if (! empty($uploads['basedir']) && ! empty($uploads['baseurl'])) {
			$uploads_dir = untrailingslashit((string) $uploads['basedir']);
			$uploads_url = untrailingslashit((string) $uploads['baseurl']);

			$candidates = array_merge(
				$candidates,
				array(
					array(
						'path' => $uploads_dir . '/ttshopgear-momo-qr.png',
						'url' => $uploads_url . '/ttshopgear-momo-qr.png',
					),
					array(
						'path' => $uploads_dir . '/momo-qr.png',
						'url' => $uploads_url . '/momo-qr.png',
					),
					array(
						'path' => $uploads_dir . '/ttshopgear-momo-qr.jpg',
						'url' => $uploads_url . '/ttshopgear-momo-qr.jpg',
					),
					array(
						'path' => $uploads_dir . '/momo-qr.jpg',
						'url' => $uploads_url . '/momo-qr.jpg',
					),
				)
			);
		}
	}

	$theme_dir = untrailingslashit(get_template_directory());
	$theme_url = untrailingslashit(get_template_directory_uri());

	$candidates = array_merge(
		$candidates,
		array(
			array(
				'path' => $theme_dir . '/assets/images/momo-qr.png',
				'url' => $theme_url . '/assets/images/momo-qr.png',
			),
			array(
				'path' => $theme_dir . '/assets/images/momo-qr.jpg',
				'url' => $theme_url . '/assets/images/momo-qr.jpg',
			),
		)
	);

	foreach ($candidates as $candidate) {
		if (! empty($candidate['path']) && file_exists($candidate['path'])) {
			return (string) $candidate['url'];
		}
	}

	return '';
}

function ttshopgear_configure_store_defaults() {
	if (! function_exists('WC')) {
		return;
	}

	if ('VND' !== get_option('woocommerce_currency')) {
		update_option('woocommerce_currency', 'VND');
	}

	if ('0' !== get_option('woocommerce_price_num_decimals')) {
		update_option('woocommerce_price_num_decimals', '0');
	}

	if ('.' !== get_option('woocommerce_price_thousand_sep')) {
		update_option('woocommerce_price_thousand_sep', '.');
	}

	if (',' !== get_option('woocommerce_price_decimal_sep')) {
		update_option('woocommerce_price_decimal_sep', ',');
	}

	if ('no' !== get_option('woocommerce_coming_soon')) {
		update_option('woocommerce_coming_soon', 'no');
	}

	$cod_settings = get_option('woocommerce_cod_settings', array());
	$cod_settings = wp_parse_args(
		$cod_settings,
		array(
			'enabled' => 'yes',
			'title' => 'Thanh toán khi nhận hàng',
			'description' => 'Thanh toán trực tiếp khi nhận hàng. Nhân viên sẽ xác nhận đơn trước khi giao.',
		)
	);

	$cod_settings['enabled'] = 'yes';
	$cod_settings['title'] = 'Thanh toán khi nhận hàng';
	$cod_settings['description'] = 'Thanh toán trực tiếp khi nhận hàng. Nhân viên sẽ xác nhận đơn trước khi giao.';
	update_option('woocommerce_cod_settings', $cod_settings);

	$momo_settings = get_option('woocommerce_ttshopgear_momo_qr_settings', array());
	$momo_settings = wp_parse_args(
		$momo_settings,
		array(
			'enabled' => 'yes',
			'title' => 'Thanh toán QR MoMo',
			'description' => 'Chuyển tiền bằng MoMo tới số 0355379198 và ghi mã đơn hàng trong nội dung.',
			'phone_number' => '0355379198',
			'account_name' => 'Lâm Chí Thành',
			'qr_image_url' => '',
			'instructions' => 'Vui lòng chuyển khoản MoMo tới số 0355379198, ghi kèm mã đơn hàng để hệ thống đối soát nhanh hơn.',
		)
	);

	$momo_settings['enabled'] = 'yes';
	$momo_settings['title'] = 'Thanh toán QR MoMo';
	$momo_settings['description'] = 'Chuyển tiền bằng MoMo tới số 0355379198 và ghi mã đơn hàng trong nội dung.';
	$momo_settings['phone_number'] = '0355379198';
	$momo_settings['account_name'] = 'Lâm Chí Thành';

	$default_qr_url = ttshopgear_get_default_momo_qr_url();
	if (! empty($default_qr_url) && empty($momo_settings['qr_image_url'])) {
		$momo_settings['qr_image_url'] = $default_qr_url;
	}
	update_option('woocommerce_ttshopgear_momo_qr_settings', $momo_settings);
}
add_action('init', 'ttshopgear_configure_store_defaults', 20);

function ttshopgear_register_momo_gateway($gateways) {
	$gateways[] = 'TTShopGear_Gateway_Momo_QR';

	return $gateways;
}
add_filter('woocommerce_payment_gateways', 'ttshopgear_register_momo_gateway');

function ttshopgear_translate_checkout_privacy($text) {
	$translations = array(
		'Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our'
			=> 'Dữ liệu cá nhân của bạn sẽ được dùng để xử lý đơn hàng, hỗ trợ trải nghiệm trên website, và cho các mục đích khác được mô tả trong',
		'privacy policy'
			=> 'chính sách bảo mật',
	);

	foreach ($translations as $en => $vi) {
		$text = str_replace($en, $vi, $text);
	}

	return $text;
}
add_filter('woocommerce_get_privacy_policy_text', 'ttshopgear_translate_checkout_privacy', 20);
add_filter('woocommerce_checkout_privacy_policy_text', 'ttshopgear_translate_checkout_privacy', 20);

function ttshopgear_translate_woocommerce_text($translated, $text, $domain) {
	if ('woocommerce' !== $domain) {
		return $translated;
	}

	$translations = array(
		'You must be logged in to checkout.' => 'Bạn cần đăng nhập để thanh toán.',
		'Have a coupon? Click here to enter your code' => 'Có mã ưu đãi? Bấm vào đây để nhập mã',
		'Proceed to checkout' => 'Tiến hành thanh toán',
		'First name' => 'Tên',
		'Last name' => 'Họ',
		'Company name (optional)' => 'Tên công ty (tùy chọn)',
		'Country / Region' => 'Quốc gia / Khu vực',
		'Street address' => 'Địa chỉ',
		'Town / City' => 'Tỉnh / Thành phố',
		'State / County' => 'Quận / Huyện',
		'Postcode / ZIP' => 'Mã bưu điện',
		'Phone' => 'Số điện thoại',
		'Email address' => 'Địa chỉ email',
		'Order notes (optional)' => 'Ghi chú đơn hàng (tùy chọn)',
		'Notes about your order, e.g. special notes for delivery.' => 'Ghi chú thêm cho đơn hàng, ví dụ thời gian nhận hoặc lưu ý giao hàng.',
		'Sorry, it seems that there are no available payment methods. Please contact us if you require assistance or wish to make alternate arrangements.' => 'Hiện chưa có phương thức thanh toán khả dụng. Vui lòng liên hệ nếu bạn cần hỗ trợ thêm.',
		'Please fill in your details above to see available payment methods.' => 'Vui lòng điền đầy đủ thông tin bên trên để xem các phương thức thanh toán khả dụng.',
		'Vietnam' => 'Việt Nam',
		'Save changes' => 'Lưu thay đổi',
		'Account details' => 'Thông tin tài khoản',
		'Addresses' => 'Địa chỉ',
		'Billing address' => 'Địa chỉ thanh toán',
		'Shipping address' => 'Địa chỉ giao hàng',
		'Password change' => 'Đổi mật khẩu',
		'Current password (leave blank to leave unchanged)' => 'Mật khẩu hiện tại (để trống nếu không đổi)',
		'New password (leave blank to leave unchanged)' => 'Mật khẩu mới (để trống nếu không đổi)',
		'Confirm new password' => 'Xác nhận mật khẩu mới',
	);

	return isset($translations[ $text ]) ? $translations[ $text ] : $translated;
}
add_filter('gettext', 'ttshopgear_translate_woocommerce_text', 20, 3);

function ttshopgear_translate_checkout_runtime_text($translated, $text, $domain) {
	if ('woocommerce' !== $domain) {
		return $translated;
	}

	$translations = array(
		'Have a coupon? Click here to enter your code' => 'Có mã ưu đãi? Bấm vào đây để nhập mã',
		'Have a coupon?' => 'Có mã ưu đãi?',
		'Click here to enter your code' => 'Bấm vào đây để nhập mã',
		'optional' => 'tùy chọn',
		'required' => 'bắt buộc',
		'%s is a required field.' => '%s là trường bắt buộc.',
		'Billing %s' => '%s',
		'Shipping %s' => '%s',
	);

	return isset($translations[ $text ]) ? $translations[ $text ] : $translated;
}
add_filter('gettext', 'ttshopgear_translate_checkout_runtime_text', 30, 3);

function ttshopgear_normalize_checkout_error_message($message) {
	if (! is_string($message) || '' === $message) {
		return $message;
	}

	$message = preg_replace('/<strong>\s*Billing\s+/i', '<strong>', $message);
	$message = preg_replace('/<strong>\s*Shipping\s+/i', '<strong>', $message);

	return $message;
}
add_filter('woocommerce_add_error', 'ttshopgear_normalize_checkout_error_message', 20);

function ttshopgear_translate_countries($countries) {
	if (isset($countries['VN'])) {
		$countries['VN'] = 'Việt Nam';
	}

	return $countries;
}
add_filter('woocommerce_countries', 'ttshopgear_translate_countries');

function ttshopgear_customize_vietnam_locale($locale) {
	if (empty($locale['VN'])) {
		$locale['VN'] = array();
	}

	$locale['VN']['city'] = array_merge(
		isset($locale['VN']['city']) ? $locale['VN']['city'] : array(),
		array(
			'label' => 'Tỉnh / Thành phố',
			'required' => true,
			'hidden' => false,
		)
	);

	$locale['VN']['state'] = array_merge(
		isset($locale['VN']['state']) ? $locale['VN']['state'] : array(),
		array(
			'label' => 'Phường / Xã',
			'required' => true,
			'hidden' => false,
		)
	);

	$locale['VN']['postcode'] = array_merge(
		isset($locale['VN']['postcode']) ? $locale['VN']['postcode'] : array(),
		array(
			'required' => false,
			'hidden' => true,
		)
	);

	return $locale;
}
add_filter('woocommerce_get_country_locale', 'ttshopgear_customize_vietnam_locale', 20);

function ttshopgear_customize_checkout_fields($fields) {
	$field_map = array(
		'billing' => array(
			'billing_first_name' => array('label' => 'Tên', 'placeholder' => 'Nhập tên người nhận'),
			'billing_last_name' => array('label' => 'Họ', 'placeholder' => 'Nhập họ người nhận'),
			'billing_country' => array('label' => 'Quốc gia / Khu vực'),
			'billing_address_1' => array('label' => 'Địa chỉ', 'placeholder' => 'Số nhà, tên đường, phường / xã'),
			'billing_address_2' => array('label' => 'Thông tin bổ sung', 'placeholder' => 'Căn hộ, tòa nhà, số tầng... (tùy chọn)'),
			'billing_city' => array('label' => 'Tỉnh / Thành phố', 'placeholder' => 'Chọn hoặc nhập tỉnh / thành phố'),
			'billing_state' => array('label' => 'Quận / Huyện', 'placeholder' => 'Chọn hoặc nhập quận / huyện'),
			'billing_postcode' => array('label' => 'Mã bưu điện', 'placeholder' => 'Nếu có'),
			'billing_phone' => array('label' => 'Số điện thoại', 'placeholder' => 'Nhập số điện thoại nhận hàng'),
			'billing_email' => array('label' => 'Địa chỉ email', 'placeholder' => 'example@email.com'),
		),
		'shipping' => array(
			'shipping_first_name' => array('label' => 'Tên', 'placeholder' => 'Nhập tên người nhận'),
			'shipping_last_name' => array('label' => 'Họ', 'placeholder' => 'Nhập họ người nhận'),
			'shipping_country' => array('label' => 'Quốc gia / Khu vực'),
			'shipping_address_1' => array('label' => 'Địa chỉ', 'placeholder' => 'Số nhà, tên đường, phường / xã'),
			'shipping_address_2' => array('label' => 'Thông tin bổ sung', 'placeholder' => 'Căn hộ, tòa nhà, số tầng... (tùy chọn)'),
			'shipping_city' => array('label' => 'Tỉnh / Thành phố', 'placeholder' => 'Chọn hoặc nhập tỉnh / thành phố'),
			'shipping_state' => array('label' => 'Quận / Huyện', 'placeholder' => 'Chọn hoặc nhập quận / huyện'),
			'shipping_postcode' => array('label' => 'Mã bưu điện', 'placeholder' => 'Nếu có'),
		),
		'order' => array(
			'order_comments' => array(
				'label' => 'Ghi chú đơn hàng (tùy chọn)',
				'placeholder' => 'Ví dụ: giao giờ hành chính, gọi trước khi giao, hoặc lưu ý cho shipper.',
			),
		),
		'account' => array(
			'account_password' => array('label' => 'Mật khẩu tài khoản', 'placeholder' => 'Tạo mật khẩu để theo dõi đơn hàng'),
		),
	);

	foreach ($field_map as $group => $group_fields) {
		if (empty($fields[ $group ])) {
			continue;
		}

		foreach ($group_fields as $field_key => $settings) {
			if (empty($fields[ $group ][ $field_key ])) {
				continue;
			}

			$fields[ $group ][ $field_key ] = array_merge($fields[ $group ][ $field_key ], $settings);
		}
	}

	unset(
		$fields['billing']['billing_last_name'],
		$fields['billing']['billing_company'],
		$fields['billing']['billing_address_2'],
		$fields['shipping']['shipping_last_name'],
		$fields['shipping']['shipping_company'],
		$fields['shipping']['shipping_address_2']
	);

	if (isset($fields['billing']['billing_first_name'])) {
		$fields['billing']['billing_first_name']['label'] = 'Họ và tên';
		$fields['billing']['billing_first_name']['placeholder'] = 'Nhập họ và tên';
		$fields['billing']['billing_first_name']['class'] = array('form-row-wide', 'tt-checkout-col-4');
	}

	if (isset($fields['billing']['billing_phone'])) {
		$fields['billing']['billing_phone']['class'] = array('form-row-wide', 'tt-checkout-col-4');
	}

	if (isset($fields['billing']['billing_email'])) {
		$fields['billing']['billing_email']['class'] = array('form-row-wide', 'tt-checkout-col-4');
		$fields['billing']['billing_email']['required'] = false;
	}

	if (isset($fields['billing']['billing_address_1'])) {
		$fields['billing']['billing_address_1']['class'] = array('form-row-wide', 'tt-checkout-col-full');
	}

	if (isset($fields['billing']['billing_city'])) {
		$fields['billing']['billing_city']['class'] = array('form-row-wide', 'tt-checkout-col-4');
	}

	if (isset($fields['billing']['billing_state'])) {
		$fields['billing']['billing_state']['class'] = array('form-row-wide', 'tt-checkout-col-4');
	}

	if (isset($fields['billing']['billing_postcode'])) {
		$fields['billing']['billing_postcode']['label'] = 'Phường / Xã';
		$fields['billing']['billing_postcode']['placeholder'] = 'Chọn phường / xã';
		$fields['billing']['billing_postcode']['class'] = array('form-row-wide', 'tt-checkout-col-4');
	}

	if (isset($fields['billing']['billing_country'])) {
		$fields['billing']['billing_country']['type'] = 'hidden';
		$fields['billing']['billing_country']['default'] = 'VN';
	}

	if (isset($fields['shipping']['shipping_country'])) {
		$fields['shipping']['shipping_country']['type'] = 'hidden';
		$fields['shipping']['shipping_country']['default'] = 'VN';
	}

	if (isset($fields['order']['order_comments'])) {
		$fields['order']['order_comments']['class'] = array('form-row-wide', 'tt-checkout-col-full');
	}

	return $fields;
}
add_filter('woocommerce_checkout_fields', 'ttshopgear_customize_checkout_fields', 20);

function ttshopgear_refine_checkout_fields($fields) {
	unset(
		$fields['billing']['billing_postcode'],
		$fields['shipping']['shipping_postcode']
	);

	if (isset($fields['billing']['billing_first_name'])) {
		$fields['billing']['billing_first_name']['label'] = 'Họ và tên';
		$fields['billing']['billing_first_name']['placeholder'] = 'Nhập họ và tên';
		$fields['billing']['billing_first_name']['class'] = array('form-row-wide', 'tt-checkout-col-4');
		$fields['billing']['billing_first_name']['priority'] = 10;
	}

	if (isset($fields['billing']['billing_phone'])) {
		$fields['billing']['billing_phone']['label'] = 'Số điện thoại';
		$fields['billing']['billing_phone']['placeholder'] = 'Nhập số điện thoại nhận hàng';
		$fields['billing']['billing_phone']['class'] = array('form-row-wide', 'tt-checkout-col-4');
		$fields['billing']['billing_phone']['priority'] = 20;
	}

	if (isset($fields['billing']['billing_email'])) {
		$fields['billing']['billing_email']['label'] = 'Địa chỉ email';
		$fields['billing']['billing_email']['placeholder'] = 'Nhập email của bạn';
		$fields['billing']['billing_email']['class'] = array('form-row-wide', 'tt-checkout-col-4');
		$fields['billing']['billing_email']['required'] = false;
		$fields['billing']['billing_email']['priority'] = 30;
	}

	if (isset($fields['billing']['billing_address_1'])) {
		$fields['billing']['billing_address_1']['label'] = 'Địa chỉ';
		$fields['billing']['billing_address_1']['placeholder'] = 'Số nhà, tên đường, tòa nhà...';
		$fields['billing']['billing_address_1']['class'] = array('form-row-wide', 'tt-checkout-col-full');
		$fields['billing']['billing_address_1']['priority'] = 40;
	}

	if (isset($fields['billing']['billing_city'])) {
		$fields['billing']['billing_city']['type'] = 'select';
		$fields['billing']['billing_city']['label'] = 'Tỉnh / Thành phố';
		$fields['billing']['billing_city']['placeholder'] = 'Chọn tỉnh / thành phố';
		$fields['billing']['billing_city']['options'] = array('' => 'Chọn tỉnh / thành phố');
		$fields['billing']['billing_city']['class'] = array('form-row-wide', 'tt-checkout-col-6');
		$fields['billing']['billing_city']['input_class'] = array('tt-checkout-select');
		$fields['billing']['billing_city']['custom_attributes'] = array('data-admin-level' => 'province');
		$fields['billing']['billing_city']['priority'] = 50;
	}

	if (isset($fields['billing']['billing_state'])) {
		$fields['billing']['billing_state']['type'] = 'select';
		$fields['billing']['billing_state']['label'] = 'Phường / Xã';
		$fields['billing']['billing_state']['placeholder'] = 'Chọn phường / xã';
		$fields['billing']['billing_state']['options'] = array('' => 'Chọn tỉnh / thành phố trước');
		$fields['billing']['billing_state']['class'] = array('form-row-wide', 'tt-checkout-col-6');
		$fields['billing']['billing_state']['input_class'] = array('tt-checkout-select');
		$fields['billing']['billing_state']['custom_attributes'] = array('data-admin-level' => 'ward');
		$fields['billing']['billing_state']['priority'] = 60;
	}

	if (isset($fields['billing']['billing_country'])) {
		$fields['billing']['billing_country']['type'] = 'hidden';
		$fields['billing']['billing_country']['default'] = 'VN';
	}

	if (isset($fields['order']['order_comments'])) {
		$fields['order']['order_comments']['label'] = 'Ghi chú đơn hàng';
		$fields['order']['order_comments']['type'] = 'text';
		$fields['order']['order_comments']['placeholder'] = 'Ví dụ: giao giờ hành chính, gọi trước khi giao, hoặc lưu ý cho shipper.';
		$fields['order']['order_comments']['class'] = array('form-row-wide', 'tt-checkout-col-full');
	}

	return $fields;
}
add_filter('woocommerce_checkout_fields', 'ttshopgear_refine_checkout_fields', 30);

function ttshopgear_customize_checkout_review_hooks() {
	if (! class_exists('WooCommerce')) {
		return;
	}

	remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);
}
add_action('wp', 'ttshopgear_customize_checkout_review_hooks');

function ttshopgear_get_shipping_method_eta($method_label, $method_id) {
	$label = strtolower(wp_strip_all_tags((string) $method_label));
	$method_id = strtolower((string) $method_id);

	if (false !== strpos($label, 'nhanh') || false !== strpos($label, 'express') || false !== strpos($label, 'hỏa tốc')) {
		return '1 - 2 ngày';
	}

	if (false !== strpos($method_id, 'local_pickup')) {
		return 'Nhận trong ngày';
	}

	return '2 - 4 ngày';
}

function ttshopgear_get_shipping_rate_total($rate) {
	if (! $rate instanceof WC_Shipping_Rate) {
		return '';
	}

	$cost  = (float) $rate->get_cost();
	$taxes = array_filter((array) $rate->get_taxes());

	if ($taxes) {
		$cost += array_sum(array_map('floatval', $taxes));
	}

	if ($cost <= 0) {
		return 'Miễn phí';
	}

	return ttshopgear_format_catalog_price($cost);
}

function ttshopgear_get_selected_checkout_gateway() {
	if (! function_exists('WC') || ! WC()->payment_gateways()) {
		return null;
	}

	$available_gateways = WC()->payment_gateways()->get_available_payment_gateways();

	if (empty($available_gateways)) {
		return null;
	}

	$chosen_gateway_id = WC()->session ? WC()->session->get('chosen_payment_method') : '';

	if ($chosen_gateway_id && isset($available_gateways[ $chosen_gateway_id ])) {
		return $available_gateways[ $chosen_gateway_id ];
	}

	return reset($available_gateways);
}

function ttshopgear_render_checkout_payment_preview() {
	$gateway = ttshopgear_get_selected_checkout_gateway();

	if (! $gateway instanceof WC_Payment_Gateway) {
		return;
	}

	$total_amount = function_exists('WC') && WC()->cart ? (float) WC()->cart->get_total('edit') : 0;
	$title = $gateway->get_title();
	$description = wp_strip_all_tags((string) $gateway->get_description());

	?>
	<div class="tt-payment-preview-card">
		<div class="tt-payment-preview-head">
			<h3><?php echo esc_html($title); ?></h3>
			<?php if ($description) : ?>
				<p><?php echo esc_html($description); ?></p>
			<?php endif; ?>
		</div>

		<?php if ('ttshopgear_momo_qr' === $gateway->id) : ?>
			<?php
			$qr_image_url = (string) $gateway->get_option('qr_image_url', '');
			$phone_number = (string) $gateway->get_option('phone_number', '0355379198');
			$title = 'Thanh toán với MoMo';
			$description = 'Quét mã QR bằng ứng dụng MoMo để thanh toán';
			?>
			<?php if ($qr_image_url) : ?>
				<div class="tt-payment-preview-qr">
					<img src="<?php echo esc_url($qr_image_url); ?>" alt="QR MoMo">
				</div>
			<?php endif; ?>
			<div class="tt-payment-preview-total">
				<span>Số tiền thanh toán</span>
				<strong><?php echo esc_html(ttshopgear_format_catalog_price($total_amount)); ?></strong>
			</div>
			<p class="tt-payment-preview-note">Quét mã QR trong ứng dụng MoMo và chuyển đúng số tiền để hệ thống xác nhận nhanh hơn.</p>
			<p class="tt-payment-preview-meta">
				<span>Tài khoản nhận</span>
				<strong><?php echo esc_html($phone_number); ?></strong>
			</p>
		<?php else : ?>
			<div class="tt-payment-preview-generic">
				<div class="tt-payment-preview-generic-icon">
					<?php
					$icon_name = 'cod' === $gateway->id ? 'award' : 'shield';
					echo ttshopgear_icon($icon_name, 'tt-icon'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>
				</div>
				<div>
					<p class="tt-payment-preview-note"><?php echo esc_html($description ? $description : 'Phương thức thanh toán này sẽ được áp dụng cho đơn hàng của bạn.'); ?></p>
					<div class="tt-payment-preview-total">
						<span>Tổng thanh toán</span>
						<strong><?php echo esc_html(ttshopgear_format_catalog_price($total_amount)); ?></strong>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
	<p class="tt-payment-preview-security">
		<?php echo ttshopgear_icon('shield', 'tt-icon tt-icon-xs'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		Thông tin thanh toán được bảo mật tuyệt đối
	</p>
	<?php
}

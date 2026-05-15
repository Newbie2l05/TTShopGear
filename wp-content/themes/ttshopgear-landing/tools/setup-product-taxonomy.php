<?php
declare(strict_types=1);

if ('cli' !== PHP_SAPI) {
	exit("CLI only.\n");
}

$_SERVER['HTTP_HOST'] = 'ttshopgear.test';
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_SCHEME'] = 'http';
$_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';

require dirname(__DIR__, 4) . '/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

if (! class_exists('WooCommerce')) {
	exit("WooCommerce chưa được kích hoạt.\n");
}

const TTSHOPGEAR_FILTERS = array(
	'keyboards' => array(
		'mechanical' => array('term_slug' => 'keyboards-mechanical', 'label' => 'Cơ'),
		'optical' => array('term_slug' => 'keyboards-optical', 'label' => 'Quang học'),
		'wireless' => array('term_slug' => 'keyboards-wireless', 'label' => 'Không dây'),
		'65' => array('term_slug' => 'keyboards-65', 'label' => '65%'),
		'tkl' => array('term_slug' => 'keyboards-tkl', 'label' => 'TKL'),
		'full-size' => array('term_slug' => 'keyboards-full-size', 'label' => 'Full Size'),
	),
	'mice' => array(
		'wireless' => array('term_slug' => 'mice-wireless', 'label' => 'Không dây'),
		'wired' => array('term_slug' => 'mice-wired', 'label' => 'Có dây'),
		'ergonomic' => array('term_slug' => 'mice-ergonomic', 'label' => 'Công thái học'),
		'lightweight' => array('term_slug' => 'mice-lightweight', 'label' => 'Siêu nhẹ'),
		'mmo' => array('term_slug' => 'mice-mmo', 'label' => 'MMO'),
	),
	'headsets' => array(
		'wireless' => array('term_slug' => 'headsets-wireless', 'label' => 'Không dây'),
		'wired' => array('term_slug' => 'headsets-wired', 'label' => 'Có dây'),
		'surround-7-1' => array('term_slug' => 'headsets-surround-7-1', 'label' => 'Âm thanh 7.1'),
		'rgb' => array('term_slug' => 'headsets-rgb', 'label' => 'RGB'),
	),
	'streaming' => array(
		'webcam' => array('term_slug' => 'streaming-webcam', 'label' => 'Webcam'),
		'capture-card' => array('term_slug' => 'streaming-capture-card', 'label' => 'Capture Card'),
		'microphone' => array('term_slug' => 'streaming-microphone', 'label' => 'Microphone'),
		'lighting' => array('term_slug' => 'streaming-lighting', 'label' => 'Đèn'),
	),
	'components' => array(
		'ram' => array('term_slug' => 'components-ram', 'label' => 'RAM'),
		'psu' => array('term_slug' => 'components-psu', 'label' => 'Nguồn'),
		'case' => array('term_slug' => 'components-case', 'label' => 'Case'),
		'cooling' => array('term_slug' => 'components-cooling', 'label' => 'Tản nhiệt'),
		'storage' => array('term_slug' => 'components-storage', 'label' => 'Lưu trữ'),
	),
);

const TTSHOPGEAR_EXTRA_PRODUCTS = array(
	array(
		'parent' => 'streaming',
		'child' => 'capture-card',
		'name' => 'Elgato HD60 X',
		'slug' => 'elgato-hd60-x',
		'brand' => 'Elgato',
		'price' => '4680000',
		'regular_price' => '4680000',
		'source_url' => 'https://www.elgato.com/us/en/p/game-capture-hd60-x',
		'image_url' => 'https://res.cloudinary.com/elgato-pwa/image/upload/q_auto,f_auto/f_auto/q_auto/v1773402952/Products/10GBE9901/above-the-fold/Final/HD60_X_ATF_01.jpg',
		'excerpt' => 'Capture card ngoài cho stream và ghi hình với 4K60 HDR passthrough và 1080p60 HDR recording.',
		'description' => 'Elgato HD60 X là capture card ngoài dành cho console và PC, hỗ trợ passthrough 4K60 HDR10, VRR và ghi hình độ trễ thấp cho stream chuyên nghiệp.',
	),
	array(
		'parent' => 'streaming',
		'child' => 'capture-card',
		'name' => 'Elgato 4K X',
		'slug' => 'elgato-4k-x',
		'brand' => 'Elgato',
		'price' => '6500000',
		'regular_price' => '6500000',
		'source_url' => 'https://www.elgato.com/us/en/p/game-capture-4k-x',
		'image_url' => 'https://res.cloudinary.com/elgato-pwa/image/upload/q_auto,f_auto/v1705401741/Products/10GBH9901/ATF/4k-x-01_desktop.jpg',
		'excerpt' => 'Capture card HDMI 2.1 cho phép ghi hình tới 4K HDR10 144 FPS với VRR passthrough độ trễ thấp.',
		'description' => 'Elgato 4K X là dòng capture USB cao cấp cho hệ console và PC đời mới, hỗ trợ 4K HDR10, HDMI 2.1 và workflow stream chất lượng cao.',
	),
	array(
		'parent' => 'streaming',
		'child' => 'capture-card',
		'name' => 'Elgato Cam Link 4K',
		'slug' => 'elgato-cam-link-4k',
		'brand' => 'Elgato',
		'price' => '2600000',
		'regular_price' => '2600000',
		'source_url' => 'https://www.elgato.com/us/en/p/cam-link-4k',
		'image_url' => 'https://res.cloudinary.com/elgato-pwa/image/upload/q_auto,f_auto/f_auto/q_auto/v1770647638/Products/10GAM9901/ATF%20(new)/2026/Cam_Link_4K_ATF_01.jpg',
		'excerpt' => 'Thiết bị capture HDMI giúp biến máy ảnh DSLR hoặc mirrorless thành webcam 4K cho livestream.',
		'description' => 'Cam Link 4K kết nối máy ảnh chất lượng cao trực tiếp với PC hoặc Mac qua USB 3.0 để họp, stream và ghi hình với độ trễ thấp.',
	),
	array(
		'parent' => 'components',
		'child' => 'cooling',
		'name' => 'CORSAIR iCUE LINK TITAN 360 RX RGB AIO Liquid CPU Cooler',
		'slug' => 'corsair-icue-link-titan-360-rx-rgb-aio-liquid-cpu-cooler',
		'brand' => 'CORSAIR',
		'price' => '4160000',
		'regular_price' => '5200000',
		'source_url' => 'https://www.corsair.com/us/en/p/cpu-coolers/cw-9061018-ww/icue-link-titan-360-rx-rgb-aio-liquid-cpu-cooler-cw-9061018-ww',
		'image_url' => 'https://assets.corsair.com/image/upload/c_pad,q_85,h_1100,w_1100,f_auto/products/Liquid-Cooling/titan-rx-rgb/Gallery/CW-9061018-WW/CW-9061018-WW_01.webp',
		'excerpt' => 'Tản nhiệt nước AIO 360mm với quạt RGB, hiệu năng cao và hệ sinh thái iCUE LINK gọn dây.',
		'description' => 'TITAN 360 RX RGB là tản nhiệt nước AIO cao cấp của CORSAIR cho các hệ thống cần nhiệt độ ổn định, độ ồn thấp và hiệu ứng RGB đồng bộ.',
	),
	array(
		'parent' => 'components',
		'child' => 'cooling',
		'name' => 'CORSAIR NAUTILUS 240 RS ARGB Liquid CPU Cooler - White',
		'slug' => 'corsair-nautilus-240-rs-argb-liquid-cpu-cooler-white',
		'brand' => 'CORSAIR',
		'price' => '2600000',
		'regular_price' => '2600000',
		'source_url' => 'https://www.corsair.com/us/en/p/cpu-coolers/cw-9060094-ww/nautilus-240-rs-argb-liquid-cpu-cooler-white-cw-9060094-ww',
		'image_url' => 'https://assets.corsair.com/image/upload/c_pad,q_85,h_1100,w_1100,f_auto/products/Liquid-Cooling/nautilus/Gallery/CW-9060094-WW/CW-9060094-WW_01.webp',
		'excerpt' => 'Tản nhiệt nước AIO 240mm ARGB với airflow tốt, độ ồn thấp và lắp đặt gọn.',
		'description' => 'NAUTILUS 240 RS ARGB là AIO 240mm hướng tới hiệu năng làm mát ổn định, đi dây đơn giản và tương thích tốt với nhiều hệ socket Intel và AMD.',
	),
	array(
		'parent' => 'components',
		'child' => 'storage',
		'name' => 'CORSAIR MP700 PRO 4TB PCIe Gen5 x4 NVMe 2.0 M.2 SSD',
		'slug' => 'corsair-mp700-pro-4tb-pcie-gen5-x4-nvme-2-0-m-2-ssd',
		'brand' => 'CORSAIR',
		'price' => '19760000',
		'regular_price' => '19760000',
		'source_url' => 'https://www.corsair.com/us/en/p/data-storage/cssd-f4000gbmp700pnh/mp700-pro-4tb-pcie-gen5-x4-nvme-2-0-m-2-ssd-cssd-f4000gbmp700pnh',
		'image_url' => 'https://assets.corsair.com/image/upload/c_pad,q_85,h_1100,w_1100,f_auto/products/Storage/mp700-pro/Gallery/MP700_PRO_01.webp',
		'excerpt' => 'SSD M.2 PCIe Gen5 tốc độ rất cao, phù hợp workstation và gaming build cao cấp.',
		'description' => 'MP700 PRO 4TB mang lại tốc độ đọc ghi rất cao trên PCIe Gen5 x4, phục vụ nhu cầu tải game nhanh và xử lý dữ liệu nặng trong workstation hiện đại.',
	),
	array(
		'parent' => 'components',
		'child' => 'storage',
		'name' => 'CORSAIR MP600 PRO LPX 1TB PCIe Gen4 x4 NVMe M.2 SSD',
		'slug' => 'corsair-mp600-pro-lpx-1tb-pcie-gen4-x4-nvme-m-2-ssd',
		'brand' => 'CORSAIR',
		'price' => '8450000',
		'regular_price' => '8450000',
		'source_url' => 'https://www.corsair.com/us/en/p/data-storage/cssd-f1000gbmp600plp/mp600-pro-lpx-1tb-pcie-gen4-x4-nvme-m-2-ssd-ps5-compatible-cssd-f1000gbmp600plp',
		'image_url' => 'https://assets.corsair.com/image/upload/c_pad,q_85,h_1100,w_1100,f_auto/products/Storage/base-mp600-pro-lpx-config/Gallery/MP600_PRO_LPX_16.webp',
		'excerpt' => 'SSD M.2 PCIe Gen4 với heatsink low-profile, phù hợp PC gaming và mở rộng lưu trữ cho PS5.',
		'description' => 'MP600 PRO LPX cung cấp tốc độ Gen4 ổn định, heatsink nhôm sẵn và độ bền cao cho game library lớn hoặc hệ PC cần lưu trữ nhanh.',
	),
	array(
		'parent' => 'components',
		'child' => 'case',
		'name' => 'CORSAIR 4000D AIRFLOW Tempered Glass Mid-Tower ATX Case — Black',
		'slug' => 'corsair-4000d-airflow-tempered-glass-mid-tower-atx-case-black',
		'brand' => 'CORSAIR',
		'price' => '2730000',
		'regular_price' => '2730000',
		'source_url' => 'https://www.corsair.com/us/en/p/pc-cases/cc-9011200-ww/4000d-airflow-tempered-glass-mid-tower-atx-case-black-cc-9011200-ww',
		'image_url' => 'https://assets.corsair.com/image/upload/c_pad,q_85,h_1100,w_1100,f_auto/products/Cases/base-4000d-airflow-config/Gallery/4000D_AF_BLACK_01.webp',
		'excerpt' => 'Mid-tower airflow case với kính cường lực, layout gọn và khả năng đi dây tốt cho gaming build hiện đại.',
		'description' => 'CORSAIR 4000D AIRFLOW là thùng máy mid-tower nổi bật với mặt trước tối ưu lưu thông khí, hỗ trợ radiator lớn và quản lý cáp RapidRoute cho hệ PC gọn đẹp.',
	),
	array(
		'parent' => 'components',
		'child' => 'case',
		'name' => 'CORSAIR 5000D AIRFLOW Tempered Glass Mid-Tower ATX PC Case — Black',
		'slug' => 'corsair-5000d-airflow-tempered-glass-mid-tower-atx-pc-case-black',
		'brand' => 'CORSAIR',
		'price' => '3380000',
		'regular_price' => '4550000',
		'source_url' => 'https://www.corsair.com/us/en/p/pc-cases/cc-9011210-ww/5000d-airflow-tempered-glass-mid-tower-atx-pc-case-black-cc-9011210-ww',
		'image_url' => 'https://assets.corsair.com/image/upload/c_pad,q_85,h_1100,w_1100,f_auto/products/Cases/base-5000d-airflow/Gallery/5000D_AF_BLACK_001.webp',
		'excerpt' => 'Mid-tower case cao cấp với không gian rộng, airflow mạnh và hỗ trợ nhiều radiator cho hệ thống hiệu năng cao.',
		'description' => 'CORSAIR 5000D AIRFLOW hướng tới cấu hình gaming hoặc workstation cao cấp với không gian mở rộng tốt, đi dây gọn và khả năng làm mát rất linh hoạt.',
	),
);

function tt_log(string $message): void {
	echo '[' . gmdate('H:i:s') . '] ' . $message . PHP_EOL;
}

function tt_string_contains(string $haystack, array $needles): bool {
	foreach ($needles as $needle) {
		if (false !== strpos($haystack, $needle)) {
			return true;
		}
	}

	return false;
}

function tt_ensure_term(string $name, string $slug, int $parent = 0): WP_Term {
	$existing = get_term_by('slug', $slug, 'product_cat');
	if ($existing instanceof WP_Term) {
		if ((int) $existing->parent !== $parent || $existing->name !== $name) {
			wp_update_term(
				$existing->term_id,
				'product_cat',
				array(
					'name' => $name,
					'parent' => $parent,
				)
			);
			$existing = get_term((int) $existing->term_id, 'product_cat');
		}

		return $existing;
	}

	$result = wp_insert_term(
		$name,
		'product_cat',
		array(
			'slug' => $slug,
			'parent' => $parent,
		)
	);

	if (is_wp_error($result)) {
		throw new RuntimeException($result->get_error_message());
	}

	$term = get_term((int) $result['term_id'], 'product_cat');
	if (! $term instanceof WP_Term) {
		throw new RuntimeException('Không thể tạo term ' . $slug);
	}

	return $term;
}

function tt_pick_top_level_terms(int $productId): array {
	$terms = wp_get_post_terms($productId, 'product_cat');
	if (is_wp_error($terms)) {
		return array();
	}

	$slugs = array();
	foreach ($terms as $term) {
		if (0 === (int) $term->parent && isset(TTSHOPGEAR_FILTERS[ $term->slug ])) {
			$slugs[] = $term->slug;
		}
	}

	return array_values(array_unique($slugs));
}

function tt_match_keyboard_filters(string $name, string $slug): array {
	if (tt_string_contains($name, array('controller'))) {
		return array();
	}

	$matches = array('mechanical');

	if (tt_string_contains($name, array('optical', 'opx'))) {
		$matches[] = 'optical';
	}

	if (tt_string_contains($name, array('wireless', 'bluetooth', '2.4g', '2.4 g', 'lightspeed'))) {
		$matches[] = 'wireless';
	}

	if (tt_string_contains($name, array('65%', 'k65', 'mini'))) {
		$matches[] = '65';
	} elseif (tt_string_contains($name, array('tkl', 'tenkeyless', 'cstm80'))) {
		$matches[] = 'tkl';
	} else {
		$matches[] = 'full-size';
	}

	if (tt_string_contains($slug, array('novablade'))) {
		$matches[] = 'tkl';
	}

	return array_values(array_unique($matches));
}

function tt_match_mouse_filters(string $name): array {
	$matches = array();
	$wirelessModels = array(
		'g305',
		'g309',
		'g502 lightspeed',
		'g502 x lightspeed',
		'g502 x plus',
		'g705',
		'g903',
		'pro 2 lightspeed',
		'pro x superlight',
		'pro x2 superstrike',
	);

	if (tt_string_contains($name, array('wireless', 'lightspeed', 'bluetooth', '2.4g')) || tt_string_contains($name, $wirelessModels)) {
		$matches[] = 'wireless';
	} else {
		$matches[] = 'wired';
	}

	if (tt_string_contains($name, array('mmo', 'scimitar'))) {
		$matches[] = 'mmo';
	}

	if (tt_string_contains($name, array('ultralight', 'superlight', 'lightweight', 'dex'))) {
		$matches[] = 'lightweight';
	}

	if (tt_string_contains($name, array('ironclaw', 'nightsword', 'ergo', 'ergonomic'))) {
		$matches[] = 'ergonomic';
	}

	return array_values(array_unique($matches));
}

function tt_match_headset_filters(string $name): array {
	$matches = array();

	if (tt_string_contains($name, array('wireless'))) {
		$matches[] = 'wireless';
	} else {
		$matches[] = 'wired';
	}

	if (tt_string_contains($name, array('7.1', 'surround', 'spatial audio'))) {
		$matches[] = 'surround-7-1';
	}

	if (tt_string_contains($name, array('rgb'))) {
		$matches[] = 'rgb';
	}

	return array_values(array_unique($matches));
}

function tt_match_streaming_filters(string $name): array {
	$matches = array();

	if (tt_string_contains($name, array('webcam', 'streamcam', 'brio', 'mevo', 'reach', 'c270', 'c920', 'c922'))) {
		$matches[] = 'webcam';
	}

	if (tt_string_contains($name, array('capture', 'cam link', 'hd60', '4k x'))) {
		$matches[] = 'capture-card';
	}

	if (tt_string_contains($name, array('mic', 'microphone', 'yeti', 'wave', 'compass', 'radar'))) {
		$matches[] = 'microphone';
	}

	if (tt_string_contains($name, array('litra', 'light', 'glow', 'beam'))) {
		$matches[] = 'lighting';
	}

	return array_values(array_unique($matches));
}

function tt_match_component_filters(string $name): array {
	$matches = array();

	if (tt_string_contains($name, array('ddr', 'memory', 'vengeance'))) {
		$matches[] = 'ram';
	}

	if (tt_string_contains($name, array('psu', 'power supply', 'rm', 'hx', 'sf', 'cx', 'rme', 'rmx', 'ws3000'))) {
		$matches[] = 'psu';
	}

	if (tt_string_contains($name, array('case', 'chassis', 'frame'))) {
		$matches[] = 'case';
	}

	if (tt_string_contains($name, array('cooler', 'cooling', 'aio', 'nautilus', 'titan', 'hydro'))) {
		$matches[] = 'cooling';
	}

	if (tt_string_contains($name, array('ssd', 'storage', 'mp600', 'mp700', 'nvme'))) {
		$matches[] = 'storage';
	}

	return array_values(array_unique($matches));
}

function tt_match_child_terms(string $parentSlug, string $name, string $slug): array {
	$name = strtolower($name);
	$slug = strtolower($slug);

	switch ($parentSlug) {
		case 'keyboards':
			return tt_match_keyboard_filters($name, $slug);
		case 'mice':
			return tt_match_mouse_filters($name);
		case 'headsets':
			return tt_match_headset_filters($name);
		case 'streaming':
			return tt_match_streaming_filters($name);
		case 'components':
			return tt_match_component_filters($name);
		default:
			return array();
	}
}

function tt_download_binary(string $url): string {
	$response = wp_remote_get(
		$url,
		array(
			'timeout' => 45,
			'redirection' => 5,
			'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0 Safari/537.36',
		)
	);

	if (is_wp_error($response)) {
		throw new RuntimeException($response->get_error_message());
	}

	$status = (int) wp_remote_retrieve_response_code($response);
	if ($status < 200 || $status >= 300) {
		throw new RuntimeException('HTTP ' . $status . ' for ' . $url);
	}

	return (string) wp_remote_retrieve_body($response);
}

function tt_prepare_image(string $url, string $folderSlug, string $fileSlug): string {
	$uploads = wp_upload_dir();
	if (! empty($uploads['error'])) {
		throw new RuntimeException((string) $uploads['error']);
	}

	$dir = trailingslashit($uploads['basedir']) . 'ttshopgear-real-catalog/' . $folderSlug;
	wp_mkdir_p($dir);

	$path = parse_url($url, PHP_URL_PATH);
	$extension = pathinfo((string) $path, PATHINFO_EXTENSION);
	$extension = $extension ? strtolower($extension) : 'jpg';
	$filePath = $dir . '/' . $fileSlug . '.' . $extension;

	if (! file_exists($filePath)) {
		file_put_contents($filePath, tt_download_binary($url));
	}

	return $filePath;
}

function tt_ensure_attachment(string $filePath, string $title): int {
	$uploads = wp_upload_dir();
	$relative = ltrim(str_replace(wp_normalize_path($uploads['basedir']), '', wp_normalize_path($filePath)), '/');

	$existing = get_posts(
		array(
			'post_type' => 'attachment',
			'post_status' => 'inherit',
			'posts_per_page' => 1,
			'meta_key' => '_wp_attached_file',
			'meta_value' => $relative,
			'fields' => 'ids',
		)
	);

	if (! empty($existing[0])) {
		return (int) $existing[0];
	}

	$fileType = wp_check_filetype($filePath);
	$attachmentId = wp_insert_attachment(
		array(
			'post_mime_type' => $fileType['type'],
			'post_title' => $title,
			'post_status' => 'inherit',
		),
		$filePath
	);

	if (is_wp_error($attachmentId) || ! $attachmentId) {
		throw new RuntimeException('Không thể tạo attachment cho ' . $title);
	}

	update_attached_file($attachmentId, $filePath);
	$metadata = wp_generate_attachment_metadata($attachmentId, $filePath);
	if (is_array($metadata)) {
		wp_update_attachment_metadata($attachmentId, $metadata);
	}
	update_post_meta($attachmentId, '_wp_attached_file', $relative);

	return (int) $attachmentId;
}

function tt_upsert_extra_product(array $item, array $termMap): void {
	$post = get_page_by_path($item['slug'], OBJECT, 'product');
	$product = $post instanceof WP_Post ? wc_get_product($post->ID) : new WC_Product_Simple();
	if (! $product instanceof WC_Product_Simple) {
		$product = new WC_Product_Simple($post ? $post->ID : 0);
	}

	$product->set_name($item['name']);
	$product->set_slug($item['slug']);
	$product->set_status('publish');
	$product->set_catalog_visibility('visible');
	$product->set_regular_price($item['regular_price']);
	$product->set_price($item['price']);
	$product->set_short_description($item['excerpt']);
	$product->set_description($item['description']);
	$product->save();

	$productId = $product->get_id();
	wp_set_object_terms(
		$productId,
		array(
			$termMap[ $item['parent'] ]['parent']->term_id,
			$termMap[ $item['parent'] ]['children'][ $item['child'] ]->term_id,
		),
		'product_cat',
		false
	);

	$filePath = tt_prepare_image($item['image_url'], $item['parent'] . '/' . $item['child'], $item['slug']);
	$attachmentId = tt_ensure_attachment($filePath, $item['name']);
	set_post_thumbnail($productId, $attachmentId);

	update_post_meta($productId, '_ttshopgear_source_url', $item['source_url']);
	update_post_meta($productId, '_ttshopgear_source_image_url', $item['image_url']);
	update_post_meta($productId, '_ttshopgear_brand', $item['brand']);
}

function tt_assign_child_terms(array $termMap): void {
	$managedChildIds = array();
	foreach ($termMap as $parentData) {
		foreach ($parentData['children'] as $childTerm) {
			$managedChildIds[] = (int) $childTerm->term_id;
		}
	}

	foreach (TTSHOPGEAR_FILTERS as $children) {
		foreach ($children as $routeSlug => $config) {
			$legacyTerm = get_term_by('slug', (string) $routeSlug, 'product_cat');
			if ($legacyTerm instanceof WP_Term && 0 !== (int) $legacyTerm->parent) {
				$managedChildIds[] = (int) $legacyTerm->term_id;
			}
		}
	}

	$managedChildIds = array_values(array_unique($managedChildIds));

	$query = new WP_Query(
		array(
			'post_type' => 'product',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'no_found_rows' => true,
		)
	);

	foreach ($query->posts as $post) {
		$topLevelSlugs = tt_pick_top_level_terms($post->ID);
		if (empty($topLevelSlugs)) {
			continue;
		}

		$currentTerms = wp_get_post_terms($post->ID, 'product_cat');
		$keepIds = array();
		foreach ($currentTerms as $term) {
			if (! in_array((int) $term->term_id, $managedChildIds, true)) {
				$keepIds[] = (int) $term->term_id;
			}
		}

		$newIds = array();
		foreach ($topLevelSlugs as $parentSlug) {
			$newIds[] = (int) $termMap[ $parentSlug ]['parent']->term_id;
			$matches = tt_match_child_terms($parentSlug, $post->post_title, $post->post_name);
			foreach ($matches as $childSlug) {
				if (isset($termMap[ $parentSlug ]['children'][ $childSlug ])) {
					$newIds[] = (int) $termMap[ $parentSlug ]['children'][ $childSlug ]->term_id;
				}
			}
		}

		$termIds = array_values(array_unique(array_merge($keepIds, $newIds)));
		wp_set_object_terms($post->ID, $termIds, 'product_cat', false);
	}

	wp_reset_postdata();
	wp_update_term_count_now($managedChildIds, 'product_cat');
}

$termMap = array();
foreach (TTSHOPGEAR_FILTERS as $parentSlug => $children) {
	$parentTerm = get_term_by('slug', $parentSlug, 'product_cat');
	if (! $parentTerm instanceof WP_Term) {
		tt_log('Bỏ qua parent term thiếu: ' . $parentSlug);
		continue;
	}

	$termMap[ $parentSlug ] = array(
		'parent' => $parentTerm,
		'children' => array(),
	);

	foreach ($children as $routeSlug => $config) {
		$routeSlug = (string) $routeSlug;
		$termMap[ $parentSlug ]['children'][ $routeSlug ] = tt_ensure_term($config['label'], $config['term_slug'], (int) $parentTerm->term_id);
	}
}

foreach (TTSHOPGEAR_EXTRA_PRODUCTS as $item) {
	if (! isset($termMap[ $item['parent'] ]['children'][ $item['child'] ])) {
		continue;
	}

	tt_upsert_extra_product($item, $termMap);
}

tt_assign_child_terms($termMap);

foreach ($termMap as $parentSlug => $parentData) {
	foreach ($parentData['children'] as $childSlug => $childTerm) {
		tt_log($parentSlug . '/' . $childSlug . ' = ' . $childTerm->count);
	}
}

tt_log('Hoàn tất đồng bộ taxonomy sản phẩm.');

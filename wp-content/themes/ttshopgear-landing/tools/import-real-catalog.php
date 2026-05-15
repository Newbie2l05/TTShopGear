<?php
declare(strict_types=1);

if ('cli' !== PHP_SAPI) {
	exit("CLI only.\n");
}

$_SERVER['HTTP_HOST']       = 'localhost';
$_SERVER['REQUEST_METHOD']  = 'GET';
$_SERVER['REQUEST_SCHEME']  = 'http';
$_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';

require dirname(__DIR__, 4) . '/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

if (! class_exists('WooCommerce')) {
	exit("WooCommerce chưa được kích hoạt.\n");
}

const TTSHOPGEAR_USD_TO_VND = 26000;
const TTSHOPGEAR_TARGET_PER_CATEGORY = 24;

$managedCategories = array(
	'keyboards' => array(
		'name' => 'Bàn phím gaming',
		'description' => 'Bàn phím gaming chính hãng từ các thương hiệu lớn, ưu tiên hiệu năng thi đấu, kết nối ổn định và độ hoàn thiện cao.',
	),
	'mice' => array(
		'name' => 'Chuột gaming',
		'description' => 'Chuột gaming chính hãng cho FPS, MOBA và MMO, tập trung vào cảm biến chính xác, độ trễ thấp và độ bền ổn định.',
	),
	'headsets' => array(
		'name' => 'Tai nghe gaming',
		'description' => 'Tai nghe gaming chính hãng với mic rõ, âm thanh tốt và cảm giác đeo thoải mái cho chơi game lẫn streaming.',
	),
	'streaming' => array(
		'name' => 'Thiết bị streaming',
		'description' => 'Webcam, microphone, đèn và phụ kiện streaming phục vụ livestream, thu âm và thiết lập góc quay chuyên nghiệp.',
	),
	'components' => array(
		'name' => 'Linh kiện PC',
		'description' => 'Linh kiện PC chính hãng như PSU, RAM, case và tản nhiệt dành cho các bộ máy gaming cần độ ổn định cao.',
	),
	'controllers' => array(
		'name' => 'Tay cầm chơi game',
		'description' => 'Tay cầm và arcade controller đa nền tảng, phù hợp cho console, PC và game retro hiện đại.',
	),
	'accessories' => array(
		'name' => 'Phụ kiện gaming',
		'description' => 'Phụ kiện gaming và streaming bổ trợ như mousepad, dock, receiver, boom arm, keycap và các bộ kit mở rộng.',
	),
);

$sources = array(
	array(
		'type' => 'corsair_itemlist',
		'url' => 'https://www.corsair.com/us/en/c/keyboards',
		'category' => 'keyboards',
		'brand' => 'CORSAIR',
	),
	array(
		'type' => 'logitech_blocks',
		'url' => 'https://www.logitechg.com/en-us/shop/c/gaming-mice',
		'category' => 'mice',
		'brand' => 'Logitech G',
		'asset_base' => 'https://resource.logitechg.com/c_fill,q_auto,f_auto,dpr_1.0/d_transparent.gif',
	),
	array(
		'type' => 'corsair_itemlist',
		'url' => 'https://www.corsair.com/us/en/c/gaming-mouse',
		'category' => 'mice',
		'brand' => 'CORSAIR',
	),
	array(
		'type' => 'corsair_itemlist',
		'url' => 'https://www.corsair.com/us/en/c/gaming-headsets',
		'category' => 'headsets',
		'brand' => 'CORSAIR',
	),
	array(
		'type' => 'logitech_blocks',
		'url' => 'https://www.logitech.com/en-us/shop/c/webcams',
		'category' => 'streaming',
		'brand' => 'Logitech',
		'asset_base' => 'https://resource.logitech.com/c_fill,q_auto,f_auto,dpr_1.0/d_transparent.gif',
	),
	array(
		'type' => 'logitech_blocks',
		'url' => 'https://www.logitech.com/en-us/shop/c/microphones',
		'category' => 'streaming',
		'brand' => 'Logitech G',
		'asset_base' => 'https://resource.logitech.com/c_fill,q_auto,f_auto,dpr_1.0/d_transparent.gif',
	),
	array(
		'type' => 'corsair_itemlist',
		'url' => 'https://www.corsair.com/us/en/c/psu',
		'category' => 'components',
		'brand' => 'CORSAIR',
	),
	array(
		'type' => 'corsair_itemlist',
		'url' => 'https://www.corsair.com/us/en/c/pc-cases',
		'category' => 'components',
		'brand' => 'CORSAIR',
	),
	array(
		'type' => 'eightbitdo',
		'url' => 'https://www.8bitdo.com/#Products',
		'category' => 'controllers',
		'brand' => '8BitDo',
	),
	array(
		'type' => 'eightbitdo',
		'url' => 'https://www.8bitdo.com/#Products',
		'category' => 'keyboards',
		'brand' => '8BitDo',
	),
	array(
		'type' => 'eightbitdo',
		'url' => 'https://www.8bitdo.com/#Products',
		'category' => 'accessories',
		'brand' => '8BitDo',
	),
	array(
		'type' => 'logitech_blocks',
		'url' => 'https://www.logitechg.com/en-us/shop/c/gaming-mousepads',
		'category' => 'accessories',
		'brand' => 'Logitech G',
		'asset_base' => 'https://resource.logitechg.com/c_fill,q_auto,f_auto,dpr_1.0/d_transparent.gif',
	),
	array(
		'type' => 'logitech_blocks',
		'url' => 'https://www.logitech.com/en-us/shop/c/microphones',
		'category' => 'accessories',
		'brand' => 'Logitech G',
		'asset_base' => 'https://resource.logitech.com/c_fill,q_auto,f_auto,dpr_1.0/d_transparent.gif',
		'accessory_only' => true,
	),
);

function ttshopgear_import_log(string $message): void {
	echo '[' . gmdate('H:i:s') . '] ' . $message . PHP_EOL;
}

function ttshopgear_fetch_remote(string $url): string {
	$response = wp_remote_get(
		$url,
		array(
			'timeout' => 45,
			'redirection' => 5,
			'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0 Safari/537.36',
			'headers' => array(
				'Accept-Language' => 'en-US,en;q=0.9',
			),
		)
	);

	if (is_wp_error($response)) {
		throw new RuntimeException('Không thể tải nguồn: ' . $url . ' - ' . $response->get_error_message());
	}

	$status = (int) wp_remote_retrieve_response_code($response);
	if ($status < 200 || $status >= 300) {
		throw new RuntimeException('Nguồn trả về mã lỗi ' . $status . ': ' . $url);
	}

	return (string) wp_remote_retrieve_body($response);
}

function ttshopgear_decode_js_string(string $value): string {
	$value = stripcslashes($value);
	$value = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');

	return trim(preg_replace('/\s+/u', ' ', $value) ?? $value);
}

function ttshopgear_extract_balanced_block(string $text, int $openPos): string {
	$length = strlen($text);
	$depth = 0;
	$inString = false;
	$escape = false;

	for ($index = $openPos; $index < $length; $index++) {
		$char = $text[$index];

		if ($inString) {
			if ($escape) {
				$escape = false;
				continue;
			}

			if ('\\' === $char) {
				$escape = true;
				continue;
			}

			if ('"' === $char) {
				$inString = false;
			}

			continue;
		}

		if ('"' === $char) {
			$inString = true;
			continue;
		}

		if ('{' === $char) {
			$depth++;
			continue;
		}

		if ('}' === $char) {
			$depth--;
			if (0 === $depth) {
				return substr($text, $openPos, $index - $openPos + 1);
			}
		}
	}

	return '';
}

function ttshopgear_usd_to_vnd(?float $amount): string {
	if (null === $amount || $amount <= 0) {
		return '';
	}

	$value = (int) (round(($amount * TTSHOPGEAR_USD_TO_VND) / 10000) * 10000);

	return (string) $value;
}

function ttshopgear_pick_sale_badge(?float $regular, ?float $sale): string {
	if (null !== $sale && null !== $regular && $regular > $sale) {
		return 'Khuyến mãi';
	}

	return '';
}

function ttshopgear_parse_corsair_itemlist(string $html, array $source): array {
	$items = array();

	if (! preg_match_all('/<script type="application\/ld\+json">(\{.*?\})<\/script>/s', $html, $matches)) {
		return $items;
	}

	foreach ($matches[1] as $json) {
		$data = json_decode(html_entity_decode($json, ENT_QUOTES | ENT_HTML5, 'UTF-8'), true);
		if (! is_array($data) || ('ItemList' !== ($data['@type'] ?? '')) || empty($data['itemListElement'])) {
			continue;
		}

		foreach ($data['itemListElement'] as $entry) {
			$product = isset($entry['item']) && is_array($entry['item']) ? $entry['item'] : $entry;
			$name = trim((string) ($product['name'] ?? ''));
			$url = trim((string) ($product['url'] ?? ''));
			$image = '';
			$images = $product['image'] ?? array();
			if (is_string($images)) {
				$image = $images;
			} elseif (is_array($images) && ! empty($images[0])) {
				$image = (string) $images[0];
			}

			if ('' === $name || '' === $url || '' === $image) {
				continue;
			}

			$offers = $product['offers'] ?? array();
			$price = isset($offers['price']) ? (float) $offers['price'] : null;
			$regular = isset($offers['highPrice']) ? (float) $offers['highPrice'] : $price;

			$items[] = array(
				'name' => $name,
				'slug' => sanitize_title($name),
				'source_url' => $url,
				'image_url' => $image,
				'category' => $source['category'],
				'brand' => $source['brand'],
				'price_vnd' => ttshopgear_usd_to_vnd($price),
				'regular_price_vnd' => ttshopgear_usd_to_vnd($regular),
				'subtitle' => 'Sản phẩm chính hãng ' . $source['brand'],
				'excerpt' => 'Thiết bị ' . strtolower($source['category']) . ' chính hãng từ ' . $source['brand'] . ', đồng bộ với hệ sinh thái chơi game và làm việc.',
				'badge' => ttshopgear_pick_sale_badge($regular, $price),
			);
		}

		break;
	}

	return $items;
}

function ttshopgear_parse_logitech_blocks(string $html, array $source): array {
	$items = array();
	$offset = 0;

	while (false !== ($pos = strpos($html, 'baseData:{', $offset))) {
		$objectStart = $pos + strlen('baseData:');
		$block = ttshopgear_extract_balanced_block($html, $objectStart);
		if ('' === $block) {
			break;
		}

		$offset = $objectStart + strlen($block);

		if (! preg_match('/title:"((?:[^"\\\\]|\\\\.)+)"/s', $block, $titleMatch)) {
			continue;
		}
		if (! preg_match('/c_url:"([^"]+)"/', $block, $urlMatch)) {
			continue;
		}
		if (! preg_match('/description:"((?:[^"\\\\]|\\\\.)*)"/s', $block, $descriptionMatch)) {
			$descriptionMatch = array('', '');
		}
		if (! preg_match('/subtitle:"((?:[^"\\\\]|\\\\.)*)"/s', $block, $subtitleMatch)) {
			$subtitleMatch = array('', '');
		}
		if (! preg_match('/productImages:\[\{path:"([^"]+)"/', $block, $imageMatch)) {
			continue;
		}
		if (! preg_match('/pricing:\{list:([0-9.]+)/', $block, $priceMatch)) {
			$priceMatch = array('', '');
		}
		preg_match('/pricing:\{list:[0-9.]+,sale:([0-9.]+)/', $block, $saleMatch);
		preg_match('/variants:\{"[^"]+":\{name:"((?:[^"\\\\]|\\\\.)+)"/s', $block, $variantNameMatch);

		$name = ttshopgear_decode_js_string($variantNameMatch[1] ?? $titleMatch[1]);
		$sourceUrl = ttshopgear_decode_js_string($urlMatch[1]);
		$subtitle = ttshopgear_decode_js_string($subtitleMatch[1] ?? '');
		$description = ttshopgear_decode_js_string($descriptionMatch[1] ?? '');
		$imageUrl = $source['asset_base'] . $imageMatch[1];
		$regular = '' !== ($priceMatch[1] ?? '') ? (float) $priceMatch[1] : null;
		$sale = '' !== ($saleMatch[1] ?? '') ? (float) $saleMatch[1] : $regular;

		if (! empty($source['accessory_only'])) {
			$lowerName = strtolower($name);
			if (false === strpos($lowerName, 'compass') && false === strpos($lowerName, 'shockmount')) {
				continue;
			}
		}

		$items[] = array(
			'name' => $name,
			'slug' => sanitize_title($name),
			'source_url' => $sourceUrl,
			'image_url' => $imageUrl,
			'category' => $source['category'],
			'brand' => $source['brand'],
			'price_vnd' => ttshopgear_usd_to_vnd($sale),
			'regular_price_vnd' => ttshopgear_usd_to_vnd($regular),
			'subtitle' => '' !== $subtitle ? $subtitle : 'Sản phẩm chính hãng ' . $source['brand'],
			'excerpt' => '' !== $description ? wp_trim_words($description, 22, '...') : 'Thiết bị chính hãng cho trải nghiệm gaming và streaming đồng bộ.',
			'badge' => ttshopgear_pick_sale_badge($regular, $sale),
		);
	}

	return $items;
}

function ttshopgear_8bitdo_match_category(string $name, string $category): bool {
	$lower = strtolower($name);

	if ('controllers' === $category) {
		if (preg_match('/receiver|adapter|dock|clip|keycap|kit|button set|speaker|mouse|keyboard|numpad/', $lower)) {
			return false;
		}

		return (bool) preg_match('/controller|arcade|gamepad|ultimate|pro2|sn30|m30|micro|zero|neogeo|lite|f40|64 controller/', $lower);
	}

	if ('keyboards' === $category) {
		return (bool) preg_match('/keyboard|numpad/', $lower);
	}

	if ('accessories' === $category) {
		return (bool) preg_match('/receiver|adapter|dock|clip|keycap|kit|button set|ball top|speaker|parts|charger|charging dock|extension|upgrade/', $lower);
	}

	return false;
}

function ttshopgear_8bitdo_guess_usd_price(string $name, string $category): float {
	$lower = strtolower($name);

	if ('controllers' === $category) {
		if (preg_match('/arcade/', $lower)) {
			return 89.99;
		}
		if (preg_match('/ultimate/', $lower)) {
			return 59.99;
		}
		if (preg_match('/micro|zero/', $lower)) {
			return 24.99;
		}

		return 44.99;
	}

	if ('keyboards' === $category) {
		if (preg_match('/numpad/', $lower)) {
			return 39.99;
		}

		return 99.99;
	}

	if ('accessories' === $category) {
		if (preg_match('/dock|charger/', $lower)) {
			return 24.99;
		}
		if (preg_match('/keycap|button set|ball top/', $lower)) {
			return 14.99;
		}

		return 19.99;
	}

	return 29.99;
}

function ttshopgear_parse_8bitdo(string $html, array $source): array {
	$items = array();

	if (! preg_match_all('/<a[^>]+href="([^"]+)"[^>]*class="[^"]*team-item[^"]*"[^>]*>.*?<img[^>]+src="([^"]+)"[^>]+alt="([^"]+)"/is', $html, $matches, PREG_SET_ORDER)) {
		return $items;
	}

	foreach ($matches as $match) {
		$url = html_entity_decode(trim($match[1]), ENT_QUOTES | ENT_HTML5, 'UTF-8');
		$image = html_entity_decode(trim($match[2]), ENT_QUOTES | ENT_HTML5, 'UTF-8');
		$name = html_entity_decode(trim($match[3]), ENT_QUOTES | ENT_HTML5, 'UTF-8');

		if ('' === $name || ! ttshopgear_8bitdo_match_category($name, $source['category'])) {
			continue;
		}

		$url = str_starts_with($url, 'http') ? $url : 'https://www.8bitdo.com/' . ltrim($url, '/');
		$image = 'https://www.8bitdo.com/' . ltrim($image, '/');
		$price = ttshopgear_8bitdo_guess_usd_price($name, $source['category']);

		$items[] = array(
			'name' => $name,
			'slug' => sanitize_title($name),
			'source_url' => $url,
			'image_url' => $image,
			'category' => $source['category'],
			'brand' => $source['brand'],
			'price_vnd' => ttshopgear_usd_to_vnd($price),
			'regular_price_vnd' => ttshopgear_usd_to_vnd($price),
			'subtitle' => 'Sản phẩm chính hãng ' . $source['brand'],
			'excerpt' => 'Thiết bị ' . $source['category'] . ' từ 8BitDo, ưu tiên tính tương thích đa nền tảng và phong cách retro hiện đại.',
			'badge' => '',
		);
	}

	return $items;
}

function ttshopgear_collect_catalog(array $sources): array {
	$catalog = array();

	foreach ($sources as $source) {
		ttshopgear_import_log('Đang tải nguồn: ' . $source['url']);
		$html = ttshopgear_fetch_remote($source['url']);

		switch ($source['type']) {
			case 'corsair_itemlist':
				$items = ttshopgear_parse_corsair_itemlist($html, $source);
				break;
			case 'logitech_blocks':
				$items = ttshopgear_parse_logitech_blocks($html, $source);
				break;
			case 'eightbitdo':
				$items = ttshopgear_parse_8bitdo($html, $source);
				break;
			default:
				$items = array();
				break;
		}

		foreach ($items as $item) {
			$category = $item['category'];
			$key = $item['source_url'];

			if (! isset($catalog[ $category ])) {
				$catalog[ $category ] = array();
			}

			$catalog[ $category ][ $key ] = $item;
		}

		ttshopgear_import_log('Thu được ' . count($items) . ' mục từ nguồn này.');
	}

	foreach ($catalog as $category => $items) {
		$catalog[ $category ] = array_slice(array_values($items), 0, TTSHOPGEAR_TARGET_PER_CATEGORY);
	}

	return $catalog;
}

function ttshopgear_ensure_term(string $slug, array $config): int {
	$term = get_term_by('slug', $slug, 'product_cat');
	if ($term instanceof WP_Term) {
		wp_update_term(
			$term->term_id,
			'product_cat',
			array(
				'name' => $config['name'],
				'description' => $config['description'],
			)
		);

		return (int) $term->term_id;
	}

	$result = wp_insert_term(
		$config['name'],
		'product_cat',
		array(
			'slug' => $slug,
			'description' => $config['description'],
		)
	);

	if (is_wp_error($result)) {
		throw new RuntimeException('Không thể tạo danh mục ' . $slug . ': ' . $result->get_error_message());
	}

	return (int) $result['term_id'];
}

function ttshopgear_delete_existing_catalog(array $categories): void {
	$posts = get_posts(
		array(
			'post_type' => 'product',
			'post_status' => array('publish', 'draft', 'pending', 'private'),
			'numberposts' => -1,
			'tax_query' => array(
				array(
					'taxonomy' => 'product_cat',
					'field' => 'slug',
					'terms' => array_keys($categories),
				),
			),
			'fields' => 'ids',
		)
	);

	foreach ($posts as $postId) {
		wp_delete_post((int) $postId, true);
	}
}

function ttshopgear_build_product_copy(array $item, array $categories): array {
	$categoryLabel = $categories[ $item['category'] ]['name'] ?? 'Sản phẩm gaming';
	$useMap = array(
		'keyboards' => 'thi đấu, làm việc và setup góc máy đồng bộ',
		'mice' => 'FPS, MOBA và các tác vụ cần thao tác nhanh',
		'headsets' => 'liên lạc trong game, nghe nhạc và stream lâu dài',
		'streaming' => 'livestream, ghi hình, thu âm và dựng góc máy',
		'components' => 'xây dựng bộ máy ổn định, sạch và hiệu năng cao',
		'controllers' => 'chơi game đa nền tảng trên PC, console và handheld',
		'accessories' => 'hoàn thiện setup và tăng độ tiện dụng hằng ngày',
	);

	$useCase = $useMap[ $item['category'] ] ?? 'gaming và công việc sáng tạo';
	$subtitle = ! empty($item['subtitle']) ? $item['subtitle'] : 'Sản phẩm chính hãng ' . $item['brand'];
	$excerpt = ! empty($item['excerpt']) ? $item['excerpt'] : 'Sản phẩm chính hãng phù hợp cho nhu cầu sử dụng ổn định và đồng bộ.';

	$short = sprintf(
		'%s từ %s thuộc nhóm %s, phù hợp cho nhu cầu %s.',
		$item['name'],
		$item['brand'],
		mb_strtolower($categoryLabel, 'UTF-8'),
		$useCase
	);

	$description = sprintf(
		'<p><strong>%s</strong> là sản phẩm chính hãng từ <strong>%s</strong>, được đưa vào catalog thực để đồng bộ với giao diện shop hiện tại.</p><p>%s. Sản phẩm phù hợp cho nhu cầu %s và có thể kết hợp tốt với các thiết bị khác trong hệ sinh thái TTShopGear.</p><p><strong>Phân loại:</strong> %s<br><strong>Dòng sản phẩm:</strong> %s</p><p><strong>Nguồn tham chiếu chính hãng:</strong> <a href="%s" target="_blank" rel="noopener noreferrer">%s</a></p>',
		$item['name'],
		$item['brand'],
		esc_html($excerpt),
		$useCase,
		$categoryLabel,
		esc_html($subtitle),
		esc_url($item['source_url']),
		esc_html(parse_url($item['source_url'], PHP_URL_HOST) ?: $item['brand'])
	);

	return array($short, $description);
}

function ttshopgear_download_image(string $url, string $fileSlug): string {
	$upload = wp_upload_dir();
	$dir = trailingslashit($upload['basedir']) . 'ttshopgear-real-catalog';
	wp_mkdir_p($dir);

	$response = wp_remote_get(
		$url,
		array(
			'timeout' => 60,
			'redirection' => 5,
			'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0 Safari/537.36',
		)
	);

	if (is_wp_error($response)) {
		throw new RuntimeException('Không thể tải ảnh: ' . $url);
	}

	$body = wp_remote_retrieve_body($response);
	if ('' === $body) {
		throw new RuntimeException('Ảnh rỗng: ' . $url);
	}

	$contentType = (string) wp_remote_retrieve_header($response, 'content-type');
	$extension = 'jpg';
	if (str_contains($contentType, 'png')) {
		$extension = 'png';
	} elseif (str_contains($contentType, 'webp')) {
		$extension = 'webp';
	} elseif (str_contains($contentType, 'gif')) {
		$extension = 'gif';
	}

	$filePath = $dir . DIRECTORY_SEPARATOR . $fileSlug . '.' . $extension;
	file_put_contents($filePath, $body);

	return $filePath;
}

function ttshopgear_attach_image(string $filePath, string $title): int {
	global $wpdb;

	$upload = wp_upload_dir();
	$relative = str_replace(wp_normalize_path(trailingslashit($upload['basedir'])), '', wp_normalize_path($filePath));

	$existingId = (int) $wpdb->get_var(
		$wpdb->prepare(
			"SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_wp_attached_file' AND meta_value = %s LIMIT 1",
			$relative
		)
	);

	if ($existingId > 0) {
		update_post_meta($existingId, '_wp_attachment_image_alt', $title);
		return $existingId;
	}

	$fileType = wp_check_filetype(basename($filePath), null);
	$attachmentId = wp_insert_attachment(
		array(
			'post_mime_type' => $fileType['type'],
			'post_title' => $title,
			'post_status' => 'inherit',
		),
		$filePath
	);

	if (is_wp_error($attachmentId) || $attachmentId <= 0) {
		throw new RuntimeException('Không thể tạo attachment cho ảnh: ' . $title);
	}

	update_attached_file($attachmentId, $filePath);
	$metadata = wp_generate_attachment_metadata($attachmentId, $filePath);
	if (is_array($metadata)) {
		$metadata['file'] = $relative;
	}
	wp_update_attachment_metadata($attachmentId, $metadata);
	update_post_meta($attachmentId, '_wp_attached_file', $relative);
	update_post_meta($attachmentId, '_wp_attachment_image_alt', $title);

	return (int) $attachmentId;
}

function ttshopgear_seed_rating(int $productId): void {
	$reviewCount = random_int(12, 248);
	$average = (string) number_format(random_int(46, 50) / 10, 1, '.', '');

	update_post_meta($productId, '_wc_review_count', (string) $reviewCount);
	update_post_meta($productId, '_wc_average_rating', $average);
	update_post_meta($productId, '_wc_rating_count', array(5 => $reviewCount));
	update_post_meta($productId, 'total_sales', (string) random_int(20, 640));
}

function ttshopgear_insert_product(array $item, int $termId, array $categories): int {
	$copy = ttshopgear_build_product_copy($item, $categories);
	$postId = wp_insert_post(
		array(
			'post_type' => 'product',
			'post_status' => 'publish',
			'post_title' => $item['name'],
			'post_name' => $item['slug'],
			'post_excerpt' => $copy[0],
			'post_content' => $copy[1],
		),
		true
	);

	if (is_wp_error($postId) || $postId <= 0) {
		throw new RuntimeException('Không thể tạo sản phẩm: ' . $item['name']);
	}

	wp_set_object_terms($postId, array($termId), 'product_cat');

	update_post_meta($postId, '_sku', strtoupper(substr($item['brand'], 0, 3)) . '-' . strtoupper(substr(md5($item['source_url']), 0, 8)));
	update_post_meta($postId, '_regular_price', $item['regular_price_vnd'] ?: $item['price_vnd']);
	update_post_meta($postId, '_price', $item['price_vnd'] ?: $item['regular_price_vnd']);
	update_post_meta($postId, '_stock_status', 'instock');
	update_post_meta($postId, '_manage_stock', 'no');
	update_post_meta($postId, '_ttshopgear_source_url', esc_url_raw($item['source_url']));
	update_post_meta($postId, '_ttshopgear_source_brand', $item['brand']);
	update_post_meta($postId, '_ttshopgear_catalog_type', 'real_catalog');
	update_post_meta($postId, '_ttshopgear_source_image_url', esc_url_raw($item['image_url'] ?? ''));

	if (! empty($item['image_url'])) {
		$filePath = ttshopgear_download_image($item['image_url'], $item['category'] . '-' . $item['slug']);
		$attachmentId = ttshopgear_attach_image($filePath, $item['name']);
		set_post_thumbnail($postId, $attachmentId);
	}

	ttshopgear_seed_rating($postId);

	return (int) $postId;
}

try {
	$catalog = ttshopgear_collect_catalog($sources);

	foreach ($managedCategories as $slug => $config) {
		$count = isset($catalog[ $slug ]) ? count($catalog[ $slug ]) : 0;
		ttshopgear_import_log('Danh mục ' . $slug . ': ' . $count . ' sản phẩm.');
	}

	ttshopgear_import_log('Xóa catalog hiện tại trong các danh mục được quản lý...');
	ttshopgear_delete_existing_catalog($managedCategories);

	$termIds = array();
	foreach ($managedCategories as $slug => $config) {
		$termIds[ $slug ] = ttshopgear_ensure_term($slug, $config);
	}

	$totalImported = 0;
	foreach ($catalog as $category => $items) {
		if (empty($termIds[ $category ])) {
			continue;
		}

		foreach ($items as $item) {
			ttshopgear_insert_product($item, $termIds[ $category ], $managedCategories);
			$totalImported++;
		}
	}

	ttshopgear_import_log('Đã import xong ' . $totalImported . ' sản phẩm thật.');
} catch (Throwable $throwable) {
	ttshopgear_import_log('Lỗi: ' . $throwable->getMessage());
	exit(1);
}

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

function tt_seed_pick_font(): string {
	$candidates = array(
		'C:\\Windows\\Fonts\\arialbd.ttf',
		'C:\\Windows\\Fonts\\arial.ttf',
		'C:\\Windows\\Fonts\\tahoma.ttf',
		'C:\\Windows\\Fonts\\verdana.ttf',
	);

	foreach ($candidates as $font) {
		if (file_exists($font)) {
			return $font;
		}
	}

	throw new RuntimeException('Không tìm thấy font TrueType để render ảnh PNG.');
}

function tt_seed_hex_to_rgb(string $hex): array {
	$hex = ltrim($hex, '#');
	if (6 !== strlen($hex)) {
		return array(255, 255, 255);
	}

	return array(
		hexdec(substr($hex, 0, 2)),
		hexdec(substr($hex, 2, 2)),
		hexdec(substr($hex, 4, 2)),
	);
}

function tt_seed_wrap_text(string $text, int $maxWidth, string $fontFile, int $fontSize): array {
	$words = preg_split('/\s+/u', trim($text)) ?: array($text);
	$lines = array();
	$line  = '';

	foreach ($words as $word) {
		$test = '' === $line ? $word : $line . ' ' . $word;
		$box  = imagettfbbox($fontSize, 0, $fontFile, $test);
		$width = (int) abs($box[2] - $box[0]);

		if ($width > $maxWidth && '' !== $line) {
			$lines[] = $line;
			$line    = $word;
			continue;
		}

		$line = $test;
	}

	if ('' !== $line) {
		$lines[] = $line;
	}

	return $lines;
}

function tt_seed_generate_png(string $filePath, string $categoryName, string $productName, string $colorA, string $colorB): void {
	$width  = 1200;
	$height = 1200;
	$image  = imagecreatetruecolor($width, $height);
	imageantialias($image, true);

	$rgbA = tt_seed_hex_to_rgb($colorA);
	$rgbB = tt_seed_hex_to_rgb($colorB);

	for ($y = 0; $y < $height; $y++) {
		$ratio = $y / max(1, $height - 1);
		$r = (int) round($rgbA[0] + ($rgbB[0] - $rgbA[0]) * $ratio);
		$g = (int) round($rgbA[1] + ($rgbB[1] - $rgbA[1]) * $ratio);
		$b = (int) round($rgbA[2] + ($rgbB[2] - $rgbA[2]) * $ratio);
		$lineColor = imagecolorallocate($image, $r, $g, $b);
		imageline($image, 0, $y, $width, $y, $lineColor);
	}

	$gridColor   = imagecolorallocatealpha($image, 255, 255, 255, 118);
	$cardColor   = imagecolorallocatealpha($image, 14, 16, 22, 24);
	$textColor   = imagecolorallocate($image, 250, 250, 250);
	$mutedColor  = imagecolorallocate($image, 194, 198, 209);
	$accentColor = imagecolorallocate($image, 62, 214, 240);

	for ($i = 0; $i <= $width; $i += 80) {
		imageline($image, $i, 0, $i, $height, $gridColor);
	}
	for ($i = 0; $i <= $height; $i += 80) {
		imageline($image, 0, $i, $width, $i, $gridColor);
	}

	imagefilledrectangle($image, 120, 120, 1080, 1080, $cardColor);

	$font = tt_seed_pick_font();
	imagettftext($image, 24, 0, 170, 210, $mutedColor, $font, 'TTSHOPGEAR');
	imagettftext($image, 42, 0, 170, 300, $accentColor, $font, mb_strtoupper($categoryName, 'UTF-8'));

	$titleLines = tt_seed_wrap_text($productName, 760, $font, 52);
	$y = 430;
	foreach ($titleLines as $line) {
		imagettftext($image, 52, 0, 170, $y, $textColor, $font, $line);
		$y += 78;
	}

	imagettftext($image, 22, 0, 170, 920, $mutedColor, $font, 'Hiệu năng ổn định  |  Thiết kế đồng bộ  |  Ảnh PNG seed local');
	imagettftext($image, 32, 0, 170, 1010, $textColor, $font, 'Mẫu dữ liệu WooCommerce');

	imagepng($image, $filePath);
	imagedestroy($image);
}

function tt_seed_get_attachment_id(string $filePath, string $productName): int {
	global $wpdb;

	$uploadDir = wp_upload_dir();
	$relative  = str_replace(wp_normalize_path(trailingslashit($uploadDir['basedir'])), '', wp_normalize_path($filePath));

	$existingId = (int) $wpdb->get_var(
		$wpdb->prepare(
			"SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_wp_attached_file' AND meta_value = %s LIMIT 1",
			$relative
		)
	);

	if ($existingId > 0) {
		update_post_meta($existingId, '_wp_attachment_image_alt', $productName);
		return $existingId;
	}

	$fileType = wp_check_filetype(basename($filePath), null);
	$attachmentId = wp_insert_attachment(
		array(
			'post_mime_type' => $fileType['type'],
			'post_title'     => $productName,
			'post_status'    => 'inherit',
		),
		$filePath
	);

	if (is_wp_error($attachmentId) || $attachmentId <= 0) {
		throw new RuntimeException('Không thể tạo attachment cho ảnh: ' . $productName);
	}

	$metadata = wp_generate_attachment_metadata($attachmentId, $filePath);
	wp_update_attachment_metadata($attachmentId, $metadata);
	update_post_meta($attachmentId, '_wp_attachment_image_alt', $productName);

	return (int) $attachmentId;
}

function tt_seed_ensure_term(array $category): array {
	$term = get_term_by('slug', $category['slug'], 'product_cat');
	if ($term instanceof WP_Term) {
		wp_update_term(
			$term->term_id,
			'product_cat',
			array(
				'name'        => $category['name'],
				'description' => $category['description'],
			)
		);

		return array('term_id' => (int) $term->term_id, 'term_taxonomy_id' => (int) $term->term_taxonomy_id);
	}

	$result = wp_insert_term(
		$category['name'],
		'product_cat',
		array(
			'slug'        => $category['slug'],
			'description' => $category['description'],
		)
	);

	if (is_wp_error($result)) {
		throw new RuntimeException('Không thể tạo danh mục: ' . $category['name'] . ' - ' . $result->get_error_message());
	}

	return array('term_id' => (int) $result['term_id'], 'term_taxonomy_id' => (int) $result['term_taxonomy_id']);
}

function tt_seed_build_price(array $config, int $index): array {
	$base   = $config['price_min'] + (($index * $config['price_step']) % ($config['price_max'] - $config['price_min']));
	$base   = (int) (round($base / 10) * 10) - 0.01;
	$sale   = 0 === $index % 4;
	$regular = number_format($base + ($sale ? 20 : 0), 2, '.', '');
	$price   = $sale ? number_format($base, 2, '.', '') : $regular;

	return array($regular, $price);
}

function tt_seed_build_product_rows(array $config): array {
	$rows   = array();
	$series = $config['series'];
	$tiers  = $config['tiers'];
	$count  = 0;

	foreach ($series as $seriesName) {
		foreach ($tiers as $tier) {
			$count++;

			$productName = sprintf($config['name_pattern'], $seriesName, $tier);
			$slug        = sanitize_title($config['slug'] . '-' . $seriesName . '-' . $tier);
			$layout      = $config['layout'][($count - 1) % count($config['layout'])];
			$featureA    = $config['feature_a'][($count - 1) % count($config['feature_a'])];
			$featureB    = $config['feature_b'][($count - 1) % count($config['feature_b'])];
			$benefit     = $config['benefits'][($count - 1) % count($config['benefits'])];
			$useCase     = $config['use_cases'][($count - 1) % count($config['use_cases'])];
			$specLine    = $config['spec_line'][($count - 1) % count($config['spec_line'])];
			$regularAndSale = tt_seed_build_price($config, $count);

			$rows[] = array(
				'name' => $productName,
				'slug' => $slug,
				'regular_price' => $regularAndSale[0],
				'price' => $regularAndSale[1],
				'sku' => strtoupper($config['sku_prefix']) . '-' . str_pad((string) $count, 3, '0', STR_PAD_LEFT),
				'short_description' => sprintf(
					'%s là lựa chọn phù hợp cho người dùng cần %s, %s và trải nghiệm %s trong các tình huống %s.',
					$productName,
					mb_strtolower($featureA, 'UTF-8'),
					mb_strtolower($featureB, 'UTF-8'),
					mb_strtolower($layout, 'UTF-8'),
					mb_strtolower($useCase, 'UTF-8')
				),
				'description' => sprintf(
					'<p>%s được xây dựng cho người dùng ưu tiên %s và %s, đồng thời vẫn đảm bảo cảm giác sử dụng chắc chắn khi dùng lâu dài.</p><p>%s phù hợp với các nhu cầu %s và dễ phối cùng các thiết bị khác trong hệ sinh thái TTShopGear.</p><ul><li>%s</li><li>%s</li><li>%s</li><li>%s</li></ul>',
					$productName,
					mb_strtolower($featureA, 'UTF-8'),
					mb_strtolower($benefit, 'UTF-8'),
					$productName,
					mb_strtolower($useCase, 'UTF-8'),
					$featureA,
					$featureB,
					$layout,
					$specLine
				),
			);
		}
	}

	return $rows;
}

$categories = array(
	array(
		'slug' => 'keyboards',
		'name' => 'Bàn phím gaming',
		'description' => 'Danh mục bàn phím gaming cơ, quang học và không dây dành cho game thủ cần độ phản hồi cao.',
		'color_a' => '#102a43',
		'color_b' => '#00bcd4',
		'series' => array('Phantom', 'Nova', 'Titan', 'Aegis', 'Vortex'),
		'tiers' => array('65', 'TKL', 'Pro', 'Air'),
		'name_pattern' => 'Bàn phím gaming %s %s',
		'layout' => array('layout gọn gàng', 'khung full-size chắc chắn', 'form TKL cân bằng', 'kiểu dáng tối ưu cho bàn nhỏ'),
		'feature_a' => array('switch cơ phản hồi nhanh', 'switch quang học ổn định', 'RGB từng phím đẹp mắt', 'polling rate cao cho thi đấu'),
		'feature_b' => array('keycap bền bỉ', 'khả năng lưu macro nhanh', 'cảm giác gõ chắc tay', 'độ hoàn thiện khung tốt'),
		'benefits' => array('độ phản hồi thấp', 'khả năng tuỳ biến cao', 'trải nghiệm gõ ổn định', 'set up đồng bộ với gear khác'),
		'use_cases' => array('chơi FPS xếp hạng', 'leo rank MOBA', 'streaming và làm việc', 'thi đấu cường độ cao'),
		'spec_line' => array('kết nối USB-C ổn định', 'polling rate 8000Hz', 'hỗ trợ hot-swap', 'đèn RGB đa vùng'),
		'price_min' => 139,
		'price_max' => 289,
		'price_step' => 17,
		'sku_prefix' => 'KB',
	),
	array(
		'slug' => 'mice',
		'name' => 'Chuột gaming',
		'description' => 'Danh mục chuột gaming cho FPS, MMO, MOBA và công việc đòi hỏi độ chính xác cao.',
		'color_a' => '#241623',
		'color_b' => '#ff6b6b',
		'series' => array('Falcon', 'Pulse', 'Blade', 'Specter', 'Orbit'),
		'tiers' => array('Lite', 'Core', 'Pro', 'Air'),
		'name_pattern' => 'Chuột gaming %s %s',
		'layout' => array('form siêu nhẹ', 'thiết kế công thái học', 'dáng đối xứng dễ làm quen', 'bề mặt nhám chắc tay'),
		'feature_a' => array('cảm biến quang học chính xác', 'switch bấm bền bỉ', 'kết nối không dây độ trễ thấp', 'mắt đọc ổn định trên nhiều bề mặt'),
		'feature_b' => array('DPI tinh chỉnh linh hoạt', 'pin dùng lâu', 'trọng lượng cân đối', 'feet trượt mượt'),
		'benefits' => array('tracking mượt', 'kiểm soát cú flick tốt hơn', 'độ ổn định khi chơi lâu', 'thao tác macro thuận tiện'),
		'use_cases' => array('FPS tốc độ cao', 'MMO nhiều nút phụ', 'MOBA nhịp độ nhanh', 'làm việc đa nhiệm'),
		'spec_line' => array('cảm biến 26000 DPI', 'polling rate 1000Hz', 'pin dùng tới 90 giờ', 'switch quang độ bền cao'),
		'price_min' => 69,
		'price_max' => 189,
		'price_step' => 13,
		'sku_prefix' => 'MS',
	),
	array(
		'slug' => 'headsets',
		'name' => 'Tai nghe gaming',
		'description' => 'Tai nghe gaming có dây và không dây dành cho game thủ, streamer và người dùng cần micro rõ nét.',
		'color_a' => '#111827',
		'color_b' => '#7c3aed',
		'series' => array('Echo', 'Atlas', 'Sonic', 'Aural', 'Vector'),
		'tiers' => array('Core', 'Lite', 'Pro', 'X'),
		'name_pattern' => 'Tai nghe gaming %s %s',
		'layout' => array('đệm tai êm ái', 'khung đeo chắc chắn', 'trọng lượng cân bằng', 'thiết kế thoáng tai'),
		'feature_a' => array('driver 50mm chi tiết', 'micro lọc ồn rõ tiếng', 'kết nối không dây ổn định', 'âm thanh vòm cho game'),
		'feature_b' => array('đeo lâu ít mỏi', 'hoàn thiện gọn gàng', 'chụp tai ôm đầu tốt', 'âm trầm kiểm soát tốt'),
		'benefits' => array('giao tiếp rõ hơn', 'nghe định vị tốt hơn', 'streaming tự tin hơn', 'giải trí lâu vẫn thoải mái'),
		'use_cases' => array('FPS cạnh tranh', 'streaming hằng ngày', 'chơi game sinh tồn', 'nghe nhạc và làm việc'),
		'spec_line' => array('driver 50mm', 'micro tháo rời', 'pin tới 70 giờ', 'hỗ trợ âm thanh 7.1'),
		'price_min' => 89,
		'price_max' => 249,
		'price_step' => 19,
		'sku_prefix' => 'HS',
	),
	array(
		'slug' => 'streaming',
		'name' => 'Thiết bị streaming',
		'description' => 'Thiết bị dành cho creator, streamer và người dùng cần webcam, capture card hoặc micro chuyên dụng.',
		'color_a' => '#1f2937',
		'color_b' => '#f59e0b',
		'series' => array('Vision', 'Creator', 'Studio', 'Flow', 'Pulse'),
		'tiers' => array('Cam', 'Deck', 'Mic', 'Capture'),
		'name_pattern' => 'Thiết bị streaming %s %s',
		'layout' => array('giao diện điều khiển trực quan', 'thiết kế gọn cho bàn nhỏ', 'khả năng kết nối linh hoạt', 'workflow dễ làm quen'),
		'feature_a' => array('chất lượng hình ảnh sắc nét', 'thu âm rõ và sạch', 'điều khiển scene nhanh', 'capture tín hiệu ổn định'),
		'feature_b' => array('hoạt động ổn định lâu dài', 'tương thích nhiều phần mềm', 'độ trễ thấp', 'hoàn thiện chắc chắn'),
		'benefits' => array('lên sóng chuyên nghiệp hơn', 'quy trình livestream gọn hơn', 'nội dung rõ và sạch hơn', 'dễ mở rộng setup creator'),
		'use_cases' => array('stream game', 'dạy học online', 'podcast tại nhà', 'sản xuất nội dung video'),
		'spec_line' => array('hỗ trợ 4K60', 'USB plug-and-play', 'tương thích OBS', 'độ trễ tối ưu'),
		'price_min' => 79,
		'price_max' => 299,
		'price_step' => 23,
		'sku_prefix' => 'ST',
	),
	array(
		'slug' => 'components',
		'name' => 'Linh kiện PC',
		'description' => 'Linh kiện PC hiệu năng cao gồm RAM, nguồn, tản nhiệt, SSD và case cho nhiều mức cấu hình.',
		'color_a' => '#0f172a',
		'color_b' => '#22c55e',
		'series' => array('Apex', 'Titan', 'Forge', 'Vertex', 'Pulse'),
		'tiers' => array('RAM', 'PSU', 'AIO', 'SSD'),
		'name_pattern' => 'Linh kiện PC %s %s',
		'layout' => array('thiết kế phù hợp build hiện đại', 'khả năng nâng cấp dễ dàng', 'luồng gió tối ưu', 'độ hoàn thiện gọn gàng'),
		'feature_a' => array('hiệu năng ổn định lâu dài', 'khả năng tương thích cao', 'nhiệt độ vận hành tốt', 'dễ lắp ráp và bảo trì'),
		'feature_b' => array('đạt chuẩn thế hệ mới', 'vận hành êm ái', 'đi dây sạch hơn', 'độ bền linh kiện cao'),
		'benefits' => array('giữ hệ thống ổn định', 'nâng cấp dễ hơn', 'trải nghiệm sử dụng mượt hơn', 'thẩm mỹ góc máy tốt hơn'),
		'use_cases' => array('build gaming cao cấp', 'máy stream đa nhiệm', 'máy làm việc mạnh', 'nâng cấp dàn PC hiện có'),
		'spec_line' => array('chuẩn DDR5 mới', 'ATX 3.0', 'radiator 360mm', 'chuẩn PCIe tốc độ cao'),
		'price_min' => 99,
		'price_max' => 329,
		'price_step' => 21,
		'sku_prefix' => 'CP',
	),
	array(
		'slug' => 'controllers',
		'name' => 'Tay cầm chơi game',
		'description' => 'Tay cầm cho PC và console với nhiều lựa chọn kết nối, layout và cảm biến analog hiện đại.',
		'color_a' => '#172554',
		'color_b' => '#3b82f6',
		'series' => array('Drift', 'Force', 'Nova', 'Titan', 'Apex'),
		'tiers' => array('Core', 'Lite', 'Pro', 'Elite'),
		'name_pattern' => 'Tay cầm gaming %s %s',
		'layout' => array('công thái học thoải mái', 'cân nặng vừa tay', 'grip bám tốt', 'layout quen thuộc'),
		'feature_a' => array('trigger phản hồi tốt', 'cần analog chính xác', 'kết nối không dây ổn định', 'rung phản hồi chân thực'),
		'feature_b' => array('độ bền nút cao', 'pin lâu', 'dễ ghép nhiều nền tảng', 'bố cục nút thuận tiện'),
		'benefits' => array('chơi console và PC linh hoạt', 'điều khiển mượt hơn', 'độ chính xác cao hơn', 'giữ cảm giác ổn định khi chơi lâu'),
		'use_cases' => array('game thể thao', 'đua xe', 'phiêu lưu hành động', 'giải trí gia đình'),
		'spec_line' => array('kết nối Bluetooth', 'hall effect analog', 'pin dùng lâu', 'hỗ trợ đa nền tảng'),
		'price_min' => 59,
		'price_max' => 149,
		'price_step' => 11,
		'sku_prefix' => 'CT',
	),
	array(
		'slug' => 'accessories',
		'name' => 'Phụ kiện gaming',
		'description' => 'Phụ kiện bổ trợ như pad chuột, deskmat, hub USB, kê tay và cáp giúp góc máy gọn gàng hơn.',
		'color_a' => '#1e1b4b',
		'color_b' => '#ec4899',
		'series' => array('Aura', 'Flex', 'Grid', 'Dock', 'Flow'),
		'tiers' => array('Pad', 'Deskmat', 'Hub', 'Wrist'),
		'name_pattern' => 'Phụ kiện gaming %s %s',
		'layout' => array('thiết kế tối giản', 'bề mặt sử dụng rộng rãi', 'tương thích nhiều setup', 'hoàn thiện gọn gàng'),
		'feature_a' => array('chất liệu bền bỉ', 'trải nghiệm sử dụng thoải mái', 'giữ bàn gọn hơn', 'phối màu đồng bộ với gear'),
		'feature_b' => array('dễ vệ sinh', 'không chiếm nhiều diện tích', 'dễ phối cùng dàn máy', 'độ hoàn thiện chắc chắn'),
		'benefits' => array('setup đẹp mắt hơn', 'trải nghiệm hằng ngày dễ chịu hơn', 'bàn làm việc gọn hơn', 'đồng bộ góc máy tốt hơn'),
		'use_cases' => array('góc gaming tại nhà', 'bàn làm việc cá nhân', 'setup streaming', 'mang theo khi di chuyển'),
		'spec_line' => array('vật liệu chống trượt', 'bề mặt phủ mịn', 'cổng kết nối ổn định', 'kích thước tiện dụng'),
		'price_min' => 19,
		'price_max' => 89,
		'price_step' => 7,
		'sku_prefix' => 'AC',
	),
);

$uploadDir   = wp_upload_dir();
$seedDir     = trailingslashit($uploadDir['basedir']) . 'ttshopgear-seed';
$created     = 0;
$updated     = 0;
$categoryIds = array();

wp_mkdir_p($seedDir);

$shopPageId = function_exists('wc_get_page_id') ? (int) wc_get_page_id('shop') : 0;
if ($shopPageId > 0) {
	wp_update_post(
		array(
			'ID'         => $shopPageId,
			'post_title' => 'Cửa hàng',
		)
	);
}

foreach ($categories as $category) {
	$term = tt_seed_ensure_term($category);
	$categoryIds[ $category['slug'] ] = (int) $term['term_id'];

	foreach (tt_seed_build_product_rows($category) as $index => $row) {
		$productPost = get_page_by_path($row['slug'], OBJECT, 'product');
		$product     = $productPost instanceof WP_Post ? wc_get_product($productPost->ID) : new WC_Product_Simple();

		if (! $product) {
			$product = new WC_Product_Simple();
		}

		$product->set_name($row['name']);
		$product->set_slug($row['slug']);
		$product->set_status('publish');
		$product->set_catalog_visibility('visible');
		$product->set_regular_price($row['regular_price']);
		$product->set_price($row['price']);
		$product->set_short_description($row['short_description']);
		$product->set_description($row['description']);
		$product->set_sku($row['sku']);
		$product->set_manage_stock(true);
		$product->set_stock_quantity(10 + ($index % 17));
		$product->set_stock_status('instock');
		$product->save();

		$productId = $product->get_id();
		wp_set_object_terms($productId, array($categoryIds[ $category['slug'] ]), 'product_cat', false);

		$imagePath = $seedDir . DIRECTORY_SEPARATOR . $row['slug'] . '.png';
		tt_seed_generate_png($imagePath, $category['name'], $row['name'], $category['color_a'], $category['color_b']);
		$attachmentId = tt_seed_get_attachment_id($imagePath, $row['name']);
		set_post_thumbnail($productId, $attachmentId);

		if ($productPost instanceof WP_Post) {
			$updated++;
		} else {
			$created++;
		}
	}
}

$summary = array();
foreach ($categories as $category) {
	$term = get_term_by('slug', $category['slug'], 'product_cat');
	$summary[] = $category['name'] . ': ' . (($term instanceof WP_Term) ? $term->count : 0);
}

echo "Đã tạo mới: {$created}\n";
echo "Đã cập nhật: {$updated}\n";
echo "Tổng kết danh mục:\n";
echo implode("\n", $summary) . "\n";

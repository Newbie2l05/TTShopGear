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

$upload = wp_upload_dir();
$baseDir = wp_normalize_path((string) $upload['basedir']);
$prefix = 'ttshopgear-real-catalog';

$attachments = get_posts(
	array(
		'post_type' => 'attachment',
		'post_status' => 'inherit',
		'numberposts' => -1,
		'meta_query' => array(
			array(
				'key' => '_wp_attached_file',
				'value' => $prefix,
				'compare' => 'LIKE',
			),
		),
		'fields' => 'ids',
	)
);

$fixed = 0;

foreach ($attachments as $attachmentId) {
	$current = (string) get_post_meta((int) $attachmentId, '_wp_attached_file', true);
	if ('' === $current) {
		continue;
	}

	$normalized = str_replace('\\', '/', $current);
	if (0 !== strpos($normalized, $prefix)) {
		continue;
	}

	if (0 === strpos($normalized, $prefix . '/')) {
		continue;
	}

	$relative = preg_replace('/^' . preg_quote($prefix, '/') . '(?!\/)/', $prefix . '/', $normalized, 1);
	if (! is_string($relative) || '' === $relative) {
		continue;
	}

	$absolute = $baseDir . '/' . ltrim($relative, '/');
	if (! file_exists($absolute)) {
		continue;
	}

	update_post_meta((int) $attachmentId, '_wp_attached_file', $relative);

	$metadata = wp_get_attachment_metadata((int) $attachmentId);
	if (is_array($metadata)) {
		$metadata['file'] = $relative;
		wp_update_attachment_metadata((int) $attachmentId, $metadata);
	}

	$fixed++;
}

echo 'fixed=' . $fixed . PHP_EOL;

<?php
if (! defined('ABSPATH')) {
	exit;
}

ttshopgear_set_virtual_route_context(
	array(
		'type' => 'shop',
		'title' => post_type_archive_title('', false) ? post_type_archive_title('', false) : 'Cửa hàng',
	)
);

require get_template_directory() . '/templates/shop-archive.php';

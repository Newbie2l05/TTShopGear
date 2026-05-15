<?php
if (! defined('ABSPATH')) {
	exit;
}

$nav_items   = ttshopgear_get_header_nav_items();
$account_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : wp_login_url();
$cart_url    = function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart/');
$cart_count  = (function_exists('WC') && WC()->cart) ? (int) WC()->cart->get_cart_contents_count() : 0;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class('ttshopgear-body'); ?>>
<?php wp_body_open(); ?>
<div class="tt-site-shell">
	<header class="tt-header">
		<div class="tt-topbar">
			<div class="tt-container tt-topbar-inner">
				<div class="tt-topbar-left">
					<span>Miễn phí vận chuyển cho đơn từ 2.500.000đ</span>
					<span class="tt-divider">|</span>
					<span>Hỗ trợ khách hàng 24/7</span>
				</div>
				<div class="tt-topbar-right">
					<a href="<?php echo esc_url(ttshopgear_get_page_slug_url('support')); ?>">Hỗ trợ</a>
					<a href="<?php echo esc_url(ttshopgear_get_page_slug_url('warranty')); ?>">Bảo hành</a>
					<a href="<?php echo esc_url(ttshopgear_get_page_slug_url('downloads')); ?>">Tải xuống</a>
				</div>
			</div>
		</div>

		<div class="tt-main-header">
			<div class="tt-container tt-main-header-inner">
				<a class="tt-logo" href="<?php echo esc_url(home_url('/')); ?>">
					<span class="tt-logo-mark">TT</span>
					<span class="tt-logo-text">TTSHOPGEAR</span>
				</a>

				<nav class="tt-desktop-nav" aria-label="Điều hướng chính">
					<?php foreach ($nav_items as $item) : ?>
						<div class="tt-nav-item">
							<a href="<?php echo esc_url(ttshopgear_get_category_url($item['slug'])); ?>" class="tt-nav-link">
								<span><?php echo esc_html($item['label']); ?></span>
								<?php echo ttshopgear_icon('chevron-down', 'tt-icon tt-icon-xs'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</a>
							<div class="tt-submenu">
								<?php foreach (ttshopgear_get_category_filter_items($item['slug']) as $sub_item) : ?>
									<a href="<?php echo esc_url(ttshopgear_get_category_url($item['slug'], $sub_item['slug'])); ?>" class="tt-submenu-link">
										<?php echo esc_html($sub_item['label']); ?>
									</a>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</nav>

				<div class="tt-header-actions">
					<button type="button" class="tt-icon-button" data-search-open aria-label="Tìm kiếm">
						<?php echo ttshopgear_icon('search', 'tt-icon'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</button>
					<a href="<?php echo esc_url($account_url); ?>" class="tt-icon-button" aria-label="Tài khoản">
						<?php echo ttshopgear_icon('user', 'tt-icon'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>
					<a href="<?php echo esc_url($cart_url); ?>" class="tt-icon-button tt-cart-button" aria-label="Giỏ hàng">
						<?php echo ttshopgear_icon('cart', 'tt-icon'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<span class="tt-cart-count"><?php echo esc_html((string) $cart_count); ?></span>
					</a>
					<button type="button" class="tt-icon-button tt-mobile-toggle" data-mobile-toggle aria-expanded="false" aria-controls="tt-mobile-menu" aria-label="Mở menu">
						<span class="tt-mobile-toggle-open">
							<?php echo ttshopgear_icon('menu', 'tt-icon tt-icon-lg'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</span>
						<span class="tt-mobile-toggle-close">
							<?php echo ttshopgear_icon('close', 'tt-icon tt-icon-lg'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</span>
					</button>
				</div>
			</div>

			<div id="tt-mobile-menu" class="tt-mobile-menu" data-mobile-menu>
				<nav class="tt-container tt-mobile-nav" aria-label="Điều hướng di động">
					<?php foreach ($nav_items as $item) : ?>
						<a href="<?php echo esc_url(ttshopgear_get_category_url($item['slug'])); ?>" class="tt-mobile-link">
							<?php echo esc_html($item['label']); ?>
						</a>
					<?php endforeach; ?>
				</nav>
			</div>
		</div>
	</header>
	<div class="tt-search-overlay" data-search-overlay hidden>
		<div class="tt-search-backdrop" data-search-close></div>
		<div class="tt-search-panel" role="dialog" aria-modal="true" aria-label="Tìm kiếm sản phẩm">
			<div class="tt-search-panel-head">
				<h2>Tìm kiếm sản phẩm</h2>
				<button type="button" class="tt-icon-button" data-search-close aria-label="Đóng tìm kiếm">
					<?php echo ttshopgear_icon('close', 'tt-icon'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</button>
			</div>
			<form method="get" action="<?php echo esc_url(home_url('/')); ?>" class="tt-search-form" data-live-search-form>
				<input type="hidden" name="post_type" value="product">
				<input type="search" name="s" class="tt-search-input" placeholder="Nhập tên sản phẩm, thương hiệu hoặc danh mục..." autocomplete="off" data-live-search-input required>
				<button type="submit" class="tt-button tt-button-primary">Tìm ngay</button>
			</form>
			<div class="tt-live-search-results" data-live-search-results aria-live="polite" hidden></div>
			<div class="tt-search-quick-links">
				<a href="<?php echo esc_url(ttshopgear_get_category_url('keyboards')); ?>" class="tt-chip">Bàn phím</a>
				<a href="<?php echo esc_url(ttshopgear_get_category_url('mice')); ?>" class="tt-chip">Chuột</a>
				<a href="<?php echo esc_url(ttshopgear_get_category_url('headsets')); ?>" class="tt-chip">Tai nghe</a>
				<a href="<?php echo esc_url(ttshopgear_get_category_url('streaming')); ?>" class="tt-chip">Streaming</a>
			</div>
		</div>
	</div>
	<div class="tt-toast-region" aria-live="polite" aria-atomic="true">
		<div class="tt-toast" data-toast hidden></div>
	</div>

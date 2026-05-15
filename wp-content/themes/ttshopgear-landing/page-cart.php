<?php
if (! defined('ABSPATH')) {
	exit;
}

get_header();
?>
<main class="tt-main">
	<section class="tt-route-hero">
		<div class="tt-route-hero-bg"></div>
		<div class="tt-container tt-route-hero-inner">
			<div class="tt-route-copy">
				<div class="tt-breadcrumbs">
					<a href="<?php echo esc_url(home_url('/')); ?>">Trang chủ</a>
					<span>/</span>
					<span>Giỏ hàng</span>
				</div>
				<span class="tt-route-badge">MUA SẮM</span>
				<h1>Giỏ hàng của bạn</h1>
				<p>Kiểm tra sản phẩm đã chọn, cập nhật số lượng và tiếp tục sang bước thanh toán với giao diện đồng bộ trên toàn bộ website.</p>
			</div>
			<div class="tt-route-panel">
				<div class="tt-kpi-grid">
					<div class="tt-kpi-card"><strong><?php echo esc_html((string) ((function_exists('WC') && WC()->cart) ? WC()->cart->get_cart_contents_count() : 0)); ?></strong><span>Sản phẩm trong giỏ</span></div>
					<div class="tt-kpi-card"><strong>VND</strong><span>Đơn vị thanh toán</span></div>
					<div class="tt-kpi-card"><strong>2</strong><span>Phương thức thanh toán</span></div>
				</div>
			</div>
		</div>
	</section>

	<section class="tt-section">
		<div class="tt-container">
			<div class="tt-woo-box">
				<?php echo do_shortcode('[woocommerce_cart]'); ?>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();

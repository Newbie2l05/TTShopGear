<?php
if (! defined('ABSPATH')) {
	exit;
}

get_header();
?>
<main class="tt-main">
	<section class="tt-route-hero tt-route-hero--compact">
		<div class="tt-route-hero-bg"></div>
		<div class="tt-container tt-route-hero-inner">
			<div class="tt-route-copy">
				<h1>Thanh toán</h1>
				<p>Điền thông tin giao hàng, chọn phương thức phù hợp và xác nhận đơn hàng trong một giao diện rõ ràng, đồng bộ với toàn bộ TTShopGear.</p>
			</div>
		</div>
	</section>

	<section class="tt-section">
		<div class="tt-container">
			<div class="tt-woo-box">
				<?php echo do_shortcode('[woocommerce_checkout]'); ?>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();

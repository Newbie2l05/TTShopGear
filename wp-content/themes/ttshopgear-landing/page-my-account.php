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
					<span>Tài khoản</span>
				</div>
				<span class="tt-route-badge">TÀI KHOẢN</span>
				<h1>Tài khoản khách hàng</h1>
				<p>Đăng nhập để theo dõi đơn hàng, quản lý phương thức thanh toán và cập nhật thông tin tài khoản trong cùng hệ giao diện.</p>
			</div>
		</div>
	</section>

	<section class="tt-section">
		<div class="tt-container">
			<div class="tt-woo-box">
				<?php echo do_shortcode('[woocommerce_my_account]'); ?>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();

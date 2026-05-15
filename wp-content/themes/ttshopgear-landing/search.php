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
					<span>Tìm kiếm</span>
				</div>
				<span class="tt-route-badge">TÌM KIẾM</span>
				<h1>Kết quả cho: <?php echo esc_html(get_search_query()); ?></h1>
				<p>Tìm kiếm sản phẩm theo tên model, thương hiệu hoặc danh mục, hiển thị trực tiếp trên storefront đồng bộ cùng theme chính.</p>
			</div>
			<div class="tt-route-panel">
				<form method="get" action="<?php echo esc_url(home_url('/')); ?>" class="tt-search-form tt-search-form-inline">
					<input type="hidden" name="post_type" value="product">
					<input type="search" name="s" class="tt-search-input" value="<?php echo esc_attr(get_search_query()); ?>" placeholder="Nhập từ khóa mới..." required>
					<button type="submit" class="tt-button tt-button-primary">Tìm lại</button>
				</form>
			</div>
		</div>
	</section>

	<section class="tt-section">
		<div class="tt-container">
			<?php if (have_posts()) : ?>
				<div class="tt-products-grid">
					<?php while (have_posts()) : the_post(); ?>
						<?php
						$wc_product = wc_get_product(get_the_ID());
						$product = $wc_product ? ttshopgear_map_wc_product($wc_product) : null;
						if (! $product) {
							continue;
						}
						?>
						<article class="tt-product-card">
							<a href="<?php echo esc_url(get_permalink()); ?>" class="tt-product-link" aria-label="<?php echo esc_attr($product['name']); ?>">
							<div class="tt-product-media">
								<div class="tt-product-media-inner">
									<?php if (! empty($product['image_url'])) : ?>
										<img src="<?php echo esc_url($product['image_url']); ?>" alt="<?php echo esc_attr($product['name']); ?>" class="tt-product-image">
									<?php else : ?>
										<div class="tt-product-number"><?php echo esc_html(str_pad((string) $product['id'], 2, '0', STR_PAD_LEFT)); ?></div>
									<?php endif; ?>
								</div>
							</div>
							</a>
							<div class="tt-product-content">
								<span class="tt-product-category"><?php echo esc_html($product['category']); ?></span>
								<h3><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html($product['name']); ?></a></h3>
								<p class="tt-card-copy"><?php echo esc_html($product['excerpt']); ?></p>
								<div class="tt-price-row">
									<span class="tt-price"><?php echo esc_html(ttshopgear_format_catalog_price($product['price'])); ?></span>
									<button type="button" class="tt-cart-mini" data-add-to-cart data-product-id="<?php echo esc_attr((string) $product['id']); ?>" aria-label="<?php echo esc_attr(sprintf('Thêm %s vào giỏ hàng', $product['name'])); ?>">
										<?php echo ttshopgear_icon('cart', 'tt-icon tt-icon-sm'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									</button>
								</div>
							</div>
						</article>
					<?php endwhile; ?>
				</div>
			<?php else : ?>
				<div class="tt-woo-box">
					<h2>Không tìm thấy sản phẩm phù hợp</h2>
					<p>Thử lại với tên model ngắn hơn, thương hiệu hoặc danh mục như Logitech, Corsair, 8BitDo, bàn phím, chuột hoặc tai nghe.</p>
				</div>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php
get_footer();

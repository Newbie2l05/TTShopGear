<?php
if (! defined('ABSPATH')) {
	exit;
}

$context    = ttshopgear_get_virtual_route_context();
$categories = ttshopgear_get_catalog_categories();
$products   = ttshopgear_get_products();

get_header();
?>
<main class="tt-main">
	<section class="tt-route-hero">
		<div class="tt-route-hero-bg"></div>
		<div class="tt-container tt-route-hero-inner">
			<div class="tt-route-copy">
				<div class="tt-breadcrumbs">
					<a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
					<span>/</span>
					<span>Sản phẩm</span>
				</div>
				<span class="tt-route-badge">CỬA HÀNG</span>
				<h1><?php echo esc_html(! empty($context['title']) ? $context['title'] : 'Tất cả sản phẩm'); ?></h1>
				<p>Khám phá toàn bộ danh mục sản phẩm với giao diện đồng bộ cùng landing page và sẵn sàng dùng dữ liệu WooCommerce thật.</p>
				<div class="tt-route-actions">
					<a href="<?php echo esc_url(home_url('/')); ?>" class="tt-button tt-button-primary">Về trang chủ</a>
					<a href="<?php echo esc_url(ttshopgear_get_page_slug_url('support')); ?>" class="tt-button tt-button-outline">Cần hỗ trợ</a>
				</div>
			</div>
			<div class="tt-route-panel">
				<div class="tt-kpi-grid">
					<div class="tt-kpi-card"><strong><?php echo esc_html((string) count($products)); ?></strong><span>Sản phẩm hiển thị</span></div>
					<div class="tt-kpi-card"><strong><?php echo esc_html((string) count($categories)); ?></strong><span>Danh mục chính</span></div>
					<div class="tt-kpi-card"><strong>24/7</strong><span>Hỗ trợ khách hàng</span></div>
				</div>
			</div>
		</div>
	</section>

	<section class="tt-section">
		<div class="tt-container">
			<div class="tt-chip-row">
				<?php foreach ($categories as $category) : ?>
					<a href="<?php echo esc_url(ttshopgear_get_category_url($category['slug'])); ?>" class="tt-chip"><?php echo esc_html($category['name']); ?></a>
				<?php endforeach; ?>
			</div>

			<div class="tt-products-grid">
				<?php foreach ($products as $product) : ?>
					<article class="tt-product-card">
						<a href="<?php echo esc_url(ttshopgear_get_product_url($product)); ?>" class="tt-product-link" aria-label="<?php echo esc_attr($product['name']); ?>">
						<div class="tt-product-media">
							<?php if (! empty($product['badge'])) : ?>
								<span class="tt-product-badge <?php echo esc_attr($product['badge_class']); ?>"><?php echo esc_html($product['badge']); ?></span>
							<?php endif; ?>
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
							<h3><a href="<?php echo esc_url(ttshopgear_get_product_url($product)); ?>"><?php echo esc_html($product['name']); ?></a></h3>
							<p class="tt-card-copy"><?php echo esc_html($product['excerpt']); ?></p>
							<div class="tt-rating-row">
								<div class="tt-stars">
									<?php for ($i = 0; $i < 5; $i++) : ?>
										<?php echo ttshopgear_icon('star', 'tt-star' . ($i < (int) floor((float) $product['rating']) ? ' is-filled' : '')); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									<?php endfor; ?>
								</div>
								<span>(<?php echo esc_html($product['reviews']); ?>)</span>
							</div>
							<div class="tt-price-row">
								<div class="tt-price-wrap">
									<span class="tt-price"><?php echo esc_html(ttshopgear_format_catalog_price($product['price'])); ?></span>
									<?php if (! empty($product['original_price'])) : ?>
										<span class="tt-price-old"><?php echo esc_html(ttshopgear_format_catalog_price($product['original_price'])); ?></span>
									<?php endif; ?>
								</div>
								<button type="button" class="tt-cart-mini" data-add-to-cart data-product-id="<?php echo esc_attr((string) $product['id']); ?>" aria-label="<?php echo esc_attr(sprintf('Thêm %s vào giỏ hàng', $product['name'])); ?>">
									<?php echo ttshopgear_icon('cart', 'tt-icon tt-icon-sm'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</button>
							</div>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();

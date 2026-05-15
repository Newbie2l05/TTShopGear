<?php
if (! defined('ABSPATH')) {
	exit;
}

$context = ttshopgear_get_virtual_route_context();
$product_data = ! empty($context['product']) ? ttshopgear_normalize_product_data($context['product']) : null;

if ($product_data instanceof WC_Product) {
	$fallback = ttshopgear_get_mock_product_by_slug($product_data->get_slug());
	$product_data = ttshopgear_map_wc_product($product_data, $fallback ? $fallback : array());
}

if (! is_array($product_data)) {
	include get_query_template('404');
	return;
}

$product_slug = ! empty($product_data['slug']) ? (string) $product_data['slug'] : '';
$category_slug = ! empty($product_data['category_slug']) ? (string) $product_data['category_slug'] : '';

if ('' === $product_slug || '' === $category_slug) {
	include get_query_template('404');
	return;
}

$category = ttshopgear_get_category($category_slug);
$related  = array();

foreach (ttshopgear_get_products_by_category($category_slug) as $item) {
	$normalized_item = ttshopgear_normalize_product_data($item);

	if (! is_array($normalized_item) || empty($normalized_item['slug'])) {
		continue;
	}

	if ((string) $normalized_item['slug'] === $product_slug) {
		continue;
	}

	$related[] = $normalized_item;
}

$related = array_slice($related, 0, 4);

get_header();
?>
<main class="tt-main">
	<section class="tt-route-hero tt-product-hero">
		<div class="tt-route-hero-bg"></div>
		<div class="tt-container tt-route-hero-inner tt-product-hero-inner">
			<div class="tt-route-copy">
				<div class="tt-breadcrumbs">
					<a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
					<span>/</span>
					<a href="<?php echo esc_url(ttshopgear_get_shop_url()); ?>">Sản phẩm</a>
					<span>/</span>
					<a href="<?php echo esc_url(ttshopgear_get_category_url($category_slug)); ?>"><?php echo esc_html($category ? $category['name'] : $product_data['category']); ?></a>
					<span>/</span>
					<span><?php echo esc_html($product_data['name']); ?></span>
				</div>
				<?php if (! empty($product_data['badge'])) : ?>
					<span class="tt-route-badge"><?php echo esc_html($product_data['badge']); ?></span>
				<?php endif; ?>
				<h1><?php echo esc_html($product_data['name']); ?></h1>
				<p><?php echo esc_html($product_data['description']); ?></p>
				<div class="tt-rating-row">
					<div class="tt-stars">
						<?php for ($i = 0; $i < 5; $i++) : ?>
							<?php echo ttshopgear_icon('star', 'tt-star' . ($i < (int) floor((float) $product_data['rating']) ? ' is-filled' : '')); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php endfor; ?>
					</div>
					<span><?php echo esc_html($product_data['rating']); ?>/5 từ <?php echo esc_html($product_data['reviews']); ?> đánh giá</span>
				</div>
				<div class="tt-product-price-hero">
					<span class="tt-price tt-price-large"><?php echo esc_html(ttshopgear_format_catalog_price($product_data['price'])); ?></span>
					<?php if (! empty($product_data['original_price'])) : ?>
						<span class="tt-price-old"><?php echo esc_html(ttshopgear_format_catalog_price($product_data['original_price'])); ?></span>
					<?php endif; ?>
				</div>
				<div class="tt-route-actions">
					<a href="<?php echo esc_url(ttshopgear_get_category_url($category_slug)); ?>" class="tt-button tt-button-primary">Xem danh mục</a>
					<?php if (! empty($product_data['cart_url']) && ! empty($product_data['cart_text'])) : ?>
						<a href="<?php echo esc_url($product_data['cart_url']); ?>" class="tt-button tt-button-accent"><?php echo esc_html($product_data['cart_text']); ?></a>
					<?php endif; ?>
					<a href="<?php echo esc_url(ttshopgear_get_page_slug_url('support')); ?>" class="tt-button tt-button-outline">Liên hệ hỗ trợ</a>
				</div>
			</div>
			<div class="tt-route-panel">
				<div class="tt-product-showcase">
					<?php if (! empty($product_data['image_url'])) : ?>
						<img src="<?php echo esc_url($product_data['image_url']); ?>" alt="<?php echo esc_attr($product_data['name']); ?>" class="tt-product-showcase-image">
					<?php else : ?>
						<div class="tt-product-number-large"><?php echo esc_html(str_pad((string) $product_data['id'], 2, '0', STR_PAD_LEFT)); ?></div>
					<?php endif; ?>
					<p><?php echo esc_html($product_data['subtitle']); ?></p>
				</div>
			</div>
		</div>
	</section>

	<section class="tt-section">
		<div class="tt-container">
			<div class="tt-product-layout">
				<div class="tt-product-panel">
					<span>Điểm nổi bật</span>
					<h2><?php echo esc_html($product_data['subtitle']); ?></h2>
					<p class="tt-card-copy"><?php echo esc_html($product_data['excerpt']); ?></p>
					<div class="tt-point-list">
						<?php foreach ($product_data['features'] as $feature) : ?>
							<div class="tt-point-item">
								<?php echo ttshopgear_icon('award', 'tt-icon tt-icon-sm'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<span><?php echo esc_html($feature); ?></span>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="tt-product-panel">
					<span>Thông số</span>
					<h2>Tối ưu cho hiệu năng ổn định hằng ngày</h2>
					<div class="tt-spec-grid">
						<?php foreach ($product_data['specs'] as $label => $value) : ?>
							<div class="tt-spec-card">
								<small><?php echo esc_html($label); ?></small>
								<strong><?php echo esc_html($value); ?></strong>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php if ($related) : ?>
		<section class="tt-section tt-section-card">
			<div class="tt-container">
				<div class="tt-section-heading tt-heading-split">
					<div>
						<span>LIÊN QUAN</span>
						<h2>Thêm sản phẩm trong <?php echo esc_html($category ? $category['name'] : $product_data['category']); ?></h2>
					</div>
					<a href="<?php echo esc_url(ttshopgear_get_category_url($category_slug)); ?>" class="tt-inline-link">
						Xem danh mục
						<span>&rarr;</span>
					</a>
				</div>
				<div class="tt-products-grid">
					<?php foreach ($related as $item) : ?>
						<article class="tt-product-card">
							<a href="<?php echo esc_url(ttshopgear_get_product_url($item)); ?>" class="tt-product-link" aria-label="<?php echo esc_attr($item['name']); ?>">
							<div class="tt-product-media">
								<div class="tt-product-media-inner">
									<?php if (! empty($item['image_url'])) : ?>
										<img src="<?php echo esc_url($item['image_url']); ?>" alt="<?php echo esc_attr($item['name']); ?>" class="tt-product-image">
									<?php else : ?>
										<div class="tt-product-number"><?php echo esc_html(str_pad((string) $item['id'], 2, '0', STR_PAD_LEFT)); ?></div>
									<?php endif; ?>
								</div>
							</div>
							</a>
							<div class="tt-product-content">
								<span class="tt-product-category"><?php echo esc_html($item['category']); ?></span>
								<h3><a href="<?php echo esc_url(ttshopgear_get_product_url($item)); ?>"><?php echo esc_html($item['name']); ?></a></h3>
								<p class="tt-card-copy"><?php echo esc_html($item['excerpt']); ?></p>
								<div class="tt-price-row">
									<span class="tt-price"><?php echo esc_html(ttshopgear_format_catalog_price($item['price'])); ?></span>
									<button type="button" class="tt-cart-mini" data-add-to-cart data-product-id="<?php echo esc_attr((string) $item['id']); ?>" aria-label="<?php echo esc_attr(sprintf('Thêm %s vào giỏ hàng', $item['name'])); ?>">
										<?php echo ttshopgear_icon('cart', 'tt-icon tt-icon-sm'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									</button>
								</div>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>
</main>
<?php
get_footer();

<?php
if (! defined('ABSPATH')) {
	exit;
}

$context = ttshopgear_get_virtual_route_context();

if (! $context) {
	include get_query_template('404');
	return;
}

$is_category = 'category' === $context['type'];
$category    = $is_category ? $context['category'] : null;
$page        = 'page' === $context['type'] ? $context['page'] : null;
$products    = ! empty($context['products']) ? $context['products'] : array();

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
					<span><?php echo esc_html($is_category ? $category['name'] : $page['group']); ?></span>
				</div>
				<span class="tt-route-badge"><?php echo esc_html($is_category ? $category['badge'] : $page['badge']); ?></span>
				<h1><?php echo esc_html($is_category ? $category['hero_title'] : $page['title']); ?></h1>
				<p><?php echo esc_html($is_category ? $category['hero_description'] : $page['description']); ?></p>
				<div class="tt-route-actions">
					<a href="<?php echo esc_url(ttshopgear_get_shop_url()); ?>" class="tt-button tt-button-primary">
						<?php echo esc_html($is_category ? 'Xem sản phẩm' : 'Khám phá cửa hàng'); ?>
					</a>
					<a href="<?php echo esc_url(ttshopgear_get_page_slug_url('support')); ?>" class="tt-button tt-button-outline">
						Trung tâm hỗ trợ
					</a>
				</div>
			</div>
			<div class="tt-route-panel">
				<?php if ($is_category) : ?>
					<div class="tt-kpi-grid">
						<?php foreach ($category['stats'] as $stat) : ?>
							<div class="tt-kpi-card">
								<strong><?php echo esc_html($stat['value']); ?></strong>
								<span><?php echo esc_html($stat['label']); ?></span>
							</div>
						<?php endforeach; ?>
					</div>
				<?php else : ?>
					<div class="tt-page-points">
						<?php foreach ($page['points'] as $point) : ?>
							<div class="tt-point-item">
								<?php echo ttshopgear_icon('award', 'tt-icon tt-icon-sm'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<span><?php echo esc_html($point); ?></span>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<?php if ($is_category) : ?>
		<section class="tt-section">
			<div class="tt-container">
				<div class="tt-chip-row">
					<a href="<?php echo esc_url(ttshopgear_get_category_url($category['slug'])); ?>" class="tt-chip<?php echo empty($context['filter_slug']) ? ' is-active' : ''; ?>">Tất cả</a>
					<?php foreach (ttshopgear_get_category_filter_items($category['slug']) as $filter) : ?>
						<a href="<?php echo esc_url(ttshopgear_get_category_url($category['slug'], $filter['slug'])); ?>" class="tt-chip<?php echo (! empty($context['filter_slug']) && $context['filter_slug'] === $filter['slug']) ? ' is-active' : ''; ?>">
							<?php echo esc_html($filter['label']); ?>
						</a>
					<?php endforeach; ?>
				</div>

				<div class="tt-section-heading tt-heading-split">
					<div>
						<span><?php echo esc_html($category['menu_label']); ?></span>
						<h2><?php echo ! empty($context['filter_label']) ? esc_html($context['filter_label']) : esc_html($category['name']); ?></h2>
					</div>
					<a href="<?php echo esc_url(ttshopgear_get_shop_url()); ?>" class="tt-inline-link">
						Xem tất cả sản phẩm
						<span>&rarr;</span>
					</a>
				</div>

				<?php if ($products) : ?>
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
				<?php else : ?>
					<div class="tt-empty-state">
						<h3>Chưa có sản phẩm</h3>
						<p>Danh mục này đã sẵn sàng để nhận dữ liệu WooCommerce hoặc sản phẩm bạn thêm sau.</p>
					</div>
				<?php endif; ?>
			</div>
		</section>
	<?php else : ?>
		<section class="tt-section">
			<div class="tt-container">
				<div class="tt-page-grid">
					<?php foreach ($page['cards'] as $card) : ?>
						<div class="tt-page-card">
							<div class="tt-page-card-icon">
								<?php echo ttshopgear_icon($card['icon'], 'tt-icon'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</div>
							<h3><?php echo esc_html($card['title']); ?></h3>
							<p><?php echo esc_html($card['description']); ?></p>
							<a href="<?php echo esc_url(ttshopgear_get_page_slug_url($card['link'])); ?>" class="tt-inline-link">
								<?php echo esc_html($card['link_label']); ?>
								<span>&rarr;</span>
							</a>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<?php if (! empty($page['sections'])) : ?>
			<section class="tt-section">
				<div class="tt-container">
					<div class="tt-section-heading">
						<span>Nội dung chi tiết</span>
						<h2><?php echo esc_html($page['title']); ?></h2>
					</div>
					<div class="tt-article-grid">
						<?php foreach ($page['sections'] as $section) : ?>
							<article class="tt-article-card">
								<?php if (! empty($section['eyebrow'])) : ?>
									<span class="tt-route-badge tt-route-badge--inline"><?php echo esc_html($section['eyebrow']); ?></span>
								<?php endif; ?>
								<h3><?php echo esc_html($section['title']); ?></h3>
								<?php if (! empty($section['paragraphs'])) : ?>
									<div class="tt-article-copy">
										<?php foreach ($section['paragraphs'] as $paragraph) : ?>
											<p><?php echo esc_html($paragraph); ?></p>
										<?php endforeach; ?>
									</div>
								<?php endif; ?>
								<?php if (! empty($section['items'])) : ?>
									<ul class="tt-article-list">
										<?php foreach ($section['items'] as $item) : ?>
											<li><?php echo esc_html($item); ?></li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
							</article>
						<?php endforeach; ?>
					</div>
				</div>
			</section>
		<?php endif; ?>
	<?php endif; ?>
</main>
<?php
get_footer();

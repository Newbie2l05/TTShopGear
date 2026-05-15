<?php
if (! defined('ABSPATH')) {
	exit;
}

$homepage_data = ttshopgear_get_homepage_data();
$slides        = $homepage_data['slides'];
$features      = $homepage_data['features'];
$categories    = $homepage_data['categories'];
$products      = $homepage_data['products'];
$testimonials  = $homepage_data['testimonials'];
$partners      = $homepage_data['partners'];

get_header();
?>
<main class="tt-main">
	<section class="tt-hero" data-hero>
		<div class="tt-hero-background" data-hero-bg></div>
		<div class="tt-hero-grid"></div>
		<div class="tt-container tt-hero-inner">
			<div class="tt-hero-copy">
				<?php foreach ($slides as $index => $slide) : ?>
					<div class="tt-hero-slide<?php echo 0 === $index ? ' is-active' : ''; ?>" data-slide data-gradient="<?php echo esc_attr($slide['gradient']); ?>" data-accent="<?php echo esc_attr($slide['accent']); ?>">
						<span class="tt-hero-badge"><?php echo esc_html($slide['badge']); ?></span>
						<div class="tt-hero-heading">
							<p><?php echo esc_html($slide['subtitle']); ?></p>
							<h1><?php echo esc_html($slide['title']); ?></h1>
						</div>
						<p class="tt-hero-description"><?php echo esc_html($slide['description']); ?></p>
						<div class="tt-hero-actions">
							<a href="<?php echo esc_url(! empty($slide['product_url']) ? $slide['product_url'] : home_url($slide['href'])); ?>" class="tt-button tt-button-primary">
								<?php echo esc_html($slide['cta']); ?>
							</a>
							<a href="<?php echo esc_url(ttshopgear_get_shop_url()); ?>" class="tt-button tt-button-outline">
								Xem tất cả sản phẩm
							</a>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

			<div class="tt-hero-visual">
				<div class="tt-hero-visual-wrap">
					<div class="tt-hero-glow" data-hero-glow></div>
					<div class="tt-hero-product">
						<?php foreach ($slides as $index => $slide) : ?>
							<div class="tt-hero-product-slide<?php echo 0 === $index ? ' is-active' : ''; ?>" data-product-slide data-accent="<?php echo esc_attr($slide['accent']); ?>">
								<?php if (! empty($slide['image_url'])) : ?>
									<img src="<?php echo esc_url($slide['image_url']); ?>" alt="<?php echo esc_attr($slide['title']); ?>" class="tt-hero-product-image">
								<?php else : ?>
									<div class="tt-hero-product-number"><?php echo esc_html(str_pad((string) $slide['id'], 2, '0', STR_PAD_LEFT)); ?></div>
									<p>Hình minh họa sản phẩm</p>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>

		<div class="tt-hero-nav">
			<button type="button" class="tt-icon-button tt-hero-arrow" data-hero-prev aria-label="Previous slide">
				<?php echo ttshopgear_icon('chevron-left', 'tt-icon'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</button>
			<div class="tt-hero-dots">
				<?php foreach ($slides as $index => $slide) : ?>
					<button type="button" class="tt-hero-dot<?php echo 0 === $index ? ' is-active' : ''; ?>" data-hero-dot="<?php echo esc_attr((string) $index); ?>" aria-label="<?php echo esc_attr(sprintf('Đi tới slide %d', $index + 1)); ?>"></button>
				<?php endforeach; ?>
			</div>
			<button type="button" class="tt-icon-button tt-hero-arrow" data-hero-next aria-label="Next slide">
				<?php echo ttshopgear_icon('chevron-right', 'tt-icon'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</button>
		</div>
	</section>

	<section class="tt-features">
		<div class="tt-container">
			<div class="tt-features-grid">
				<?php foreach ($features as $feature) : ?>
					<div class="tt-feature-card">
						<div class="tt-feature-icon">
							<?php echo ttshopgear_icon($feature['icon'], 'tt-icon'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
						<h3><?php echo esc_html($feature['title']); ?></h3>
						<p><?php echo esc_html($feature['description']); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="tt-section">
		<div class="tt-container">
			<div class="tt-section-heading tt-center">
				<span>MUA THEO DANH MỤC</span>
				<h2>Find Your Gear</h2>
			</div>
			<div class="tt-categories-grid">
				<?php foreach ($categories as $category) : ?>
					<a href="<?php echo esc_url(ttshopgear_get_category_url($category['slug'])); ?>" class="tt-category-card">
						<div class="tt-category-icon">
							<?php echo ttshopgear_icon($category['icon'], 'tt-icon tt-icon-lg'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
						<div>
							<h3><?php echo esc_html($category['name']); ?></h3>
							<p><?php echo esc_html($category['description']); ?></p>
						</div>
						<span><?php echo esc_html($category['count']); ?></span>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="tt-section tt-section-card">
		<div class="tt-container">
			<div class="tt-section-heading tt-heading-split">
				<div>
					<span>FEATURED</span>
					<h2>Sản Phẩm Nổi Bật</h2>
				</div>
				<a href="<?php echo esc_url(ttshopgear_get_shop_url()); ?>" class="tt-inline-link">
					Xem tất cả sản phẩm
					<span>&rarr;</span>
				</a>
			</div>
			<div class="tt-products-grid">
				<?php foreach ($products as $product) : ?>
					<article class="tt-product-card">
						<a href="<?php echo esc_url(ttshopgear_get_product_url($product)); ?>" class="tt-product-link" aria-label="<?php echo esc_attr($product['name']); ?>">
						<div class="tt-product-media">
							<?php if (! empty($product['badge'])) : ?>
								<span class="tt-product-badge <?php echo esc_attr($product['badge_class']); ?>">
									<?php echo esc_html($product['badge']); ?>
								</span>
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
							<div class="tt-rating-row">
								<div class="tt-stars">
									<?php for ($i = 0; $i < 5; $i++) : ?>
										<?php $filled = $i < (int) floor((float) $product['rating']); ?>
										<?php echo ttshopgear_icon('star', 'tt-star' . ($filled ? ' is-filled' : '')); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
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

	<section class="tt-section">
		<div class="tt-container">
			<div class="tt-promo-grid">
				<div class="tt-promo-card tt-promo-large tt-promo-primary">
					<div>
						<span>KEYBOARDS</span>
						<h3>Mechanical Excellence</h3>
						<p>Experience lightning-fast response with our optical-mechanical switches</p>
					</div>
					<div class="tt-promo-action">
						<a href="<?php echo esc_url(ttshopgear_get_category_url('keyboards')); ?>" class="tt-button tt-button-primary">Mua bàn phím</a>
					</div>
				</div>
				<div class="tt-promo-stack">
					<div class="tt-promo-card tt-promo-accent">
						<div>
							<span>GAMING MICE</span>
							<h3>Precision Control</h3>
							<p>26,000 DPI sensors for ultimate accuracy</p>
						</div>
						<div class="tt-promo-action">
							<a href="<?php echo esc_url(ttshopgear_get_category_url('mice')); ?>" class="tt-inline-link tt-inline-link-accent">
								Mua chuột
								<span>&rarr;</span>
							</a>
						</div>
					</div>
					<div class="tt-promo-card tt-promo-secondary">
						<div>
							<span>HEADSETS</span>
							<h3>Immersive Audio</h3>
							<p>Spatial audio with 50mm custom drivers</p>
						</div>
						<div class="tt-promo-action">
							<a href="<?php echo esc_url(ttshopgear_get_category_url('headsets')); ?>" class="tt-inline-link">
								Mua tai nghe
								<span>&rarr;</span>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="tt-section">
		<div class="tt-container">
			<div class="tt-section-heading tt-center">
				<span>TESTIMONIALS</span>
				<h2>Được Tin Dùng Bởi Tuyển Thủ</h2>
			</div>
			<div class="tt-testimonials-grid">
				<?php foreach ($testimonials as $testimonial) : ?>
					<div class="tt-testimonial-card">
						<div class="tt-quote-icon">
							<?php echo ttshopgear_icon('quote', 'tt-icon tt-icon-lg'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
						<p class="tt-testimonial-text">&ldquo;<?php echo esc_html($testimonial['text']); ?>&rdquo;</p>
						<div class="tt-stars">
							<?php for ($i = 0; $i < (int) $testimonial['rating']; $i++) : ?>
								<?php echo ttshopgear_icon('star', 'tt-star is-filled'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<?php endfor; ?>
						</div>
						<div class="tt-testimonial-user">
							<div class="tt-avatar"><?php echo esc_html($testimonial['avatar']); ?></div>
							<div>
								<p class="tt-user-name"><?php echo esc_html($testimonial['name']); ?></p>
								<p class="tt-user-role"><?php echo esc_html($testimonial['role']); ?></p>
							</div>
						</div>
						<a href="#" class="tt-used-link">Used: <?php echo esc_html($testimonial['product']); ?></a>
					</div>
				<?php endforeach; ?>
			</div>

			<div class="tt-partners">
				<p>Được các đội tuyển Esports chuyên nghiệp tin dùng</p>
				<div class="tt-partners-list">
					<?php foreach ($partners as $partner) : ?>
						<div class="tt-partner-badge" title="<?php echo esc_attr($partner['name']); ?>">
							<?php echo esc_html($partner['abbr']); ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>

	<section class="tt-section tt-newsletter">
		<div class="tt-container">
			<div class="tt-newsletter-inner">
				<span>NEWSLETTER</span>
				<h2>Luôn Dẫn Trước Cuộc Chơi</h2>
				<p>Đăng ký để nhận ưu đãi độc quyền, cập nhật sản phẩm mới sớm và mẹo gaming từ các tuyển thủ.</p>
				<form class="tt-newsletter-form" data-newsletter-form>
					<input type="email" name="email" placeholder="Nhập email của bạn" required>
					<button type="submit" class="tt-button tt-button-primary">
						<?php echo ttshopgear_icon('send', 'tt-icon tt-icon-sm'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<span>Đăng ký</span>
					</button>
				</form>
				<div class="tt-newsletter-success" data-newsletter-success hidden>
					<p>Cảm ơn bạn đã đăng ký. Hãy kiểm tra hộp thư trong ít phút nữa.</p>
				</div>
				<p class="tt-newsletter-note">Khi đăng ký, bạn đồng ý với chính sách bảo mật và cho phép chúng tôi gửi cập nhật mới nhất.</p>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();

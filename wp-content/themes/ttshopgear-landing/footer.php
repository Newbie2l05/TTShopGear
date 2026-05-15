<?php
if (! defined('ABSPATH')) {
	exit;
}

$footer_links = ttshopgear_get_footer_link_groups();

$social_links = array(
	array('label' => 'Facebook', 'href' => '#', 'icon' => 'facebook'),
	array('label' => 'Twitter', 'href' => '#', 'icon' => 'twitter'),
	array('label' => 'Instagram', 'href' => '#', 'icon' => 'instagram'),
	array('label' => 'YouTube', 'href' => '#', 'icon' => 'youtube'),
	array('label' => 'Twitch', 'href' => '#', 'icon' => 'twitch'),
);
?>
	<footer class="tt-footer">
		<div class="tt-container tt-footer-main">
			<div class="tt-footer-grid">
				<div class="tt-footer-brand">
					<a class="tt-logo" href="<?php echo esc_url(home_url('/')); ?>">
						<span class="tt-logo-mark">TT</span>
						<span class="tt-logo-text">TTSHOPGEAR</span>
					</a>
					<p class="tt-footer-copy">
						Thiết bị gaming cao cấp và linh kiện PC dành cho game thủ thi đấu lẫn người dùng đam mê hiệu năng.
					</p>
					<div class="tt-social-list">
						<?php foreach ($social_links as $social) : ?>
							<a href="<?php echo esc_url($social['href']); ?>" class="tt-social-link" aria-label="<?php echo esc_attr($social['label']); ?>">
								<?php echo ttshopgear_icon($social['icon'], 'tt-icon'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</a>
						<?php endforeach; ?>
					</div>
				</div>

				<?php foreach ($footer_links as $title => $links) : ?>
					<div class="tt-footer-column">
						<h3><?php echo esc_html($title); ?></h3>
						<ul>
							<?php foreach ($links as $link) : ?>
								<li>
									<a href="<?php echo esc_url(ttshopgear_get_page_slug_url($link['slug'])); ?>">
										<?php echo esc_html($link['label']); ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<div class="tt-footer-bottom">
			<div class="tt-container tt-footer-bottom-inner">
				<p>&copy; <?php echo esc_html(wp_date('Y')); ?> TTShopGear. Bảo lưu mọi quyền.</p>
				<div class="tt-payment-wrap">
					<span>Phương thức thanh toán:</span>
					<div class="tt-payment-list">
						<span>Visa</span>
						<span>MC</span>
						<span>Amex</span>
						<span>PayPal</span>
					</div>
				</div>
			</div>
		</div>
	</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>

<?php
defined('ABSPATH') || exit;
?>
<?php if (WC()->cart && WC()->cart->needs_shipping()) : ?>
	<?php
	$packages = WC()->shipping()->get_packages();
	$chosen_shipping_methods = WC()->session ? (array) WC()->session->get('chosen_shipping_methods', array()) : array();
	?>
	<div class="woocommerce-shipping-methods-card tt-panel-card tt-checkout-billing-card">
		<div class="tt-panel-head">
			<div class="tt-panel-head-icon">
				<?php echo ttshopgear_icon('truck', 'tt-icon tt-icon-sm'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
			<div>
				<span class="tt-route-badge">GIAO HÀNG</span>
				<h2>Phương thức giao hàng</h2>
			</div>
		</div>

		<div class="tt-shipping-method-cards">
			<?php foreach ($packages as $package_index => $package) : ?>
				<?php if (empty($package['rates'])) : ?>
					<div class="tt-shipping-method-empty">Chưa có phương thức giao hàng khả dụng cho địa chỉ hiện tại.</div>
					<?php continue; ?>
				<?php endif; ?>
				<?php foreach ($package['rates'] as $rate_id => $rate) : ?>
					<?php
					$is_chosen = isset($chosen_shipping_methods[ $package_index ]) && $chosen_shipping_methods[ $package_index ] === $rate_id;
					$method_label = $rate->get_label();
					$method_eta = ttshopgear_get_shipping_method_eta($method_label, $rate->get_method_id());
					?>
					<label class="tt-shipping-method-card<?php echo $is_chosen ? ' is-active' : ''; ?>">
						<input type="radio" name="shipping_method[<?php echo esc_attr((string) $package_index); ?>]" data-index="<?php echo esc_attr((string) $package_index); ?>" value="<?php echo esc_attr($rate_id); ?>" class="shipping_method" <?php checked($is_chosen, true); ?> />
						<span class="tt-shipping-method-icon">
							<?php echo ttshopgear_icon('truck', 'tt-icon tt-icon-sm'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</span>
						<span class="tt-shipping-method-copy">
							<strong><?php echo esc_html($method_label); ?></strong>
							<small><?php echo esc_html($method_eta); ?></small>
						</span>
						<span class="tt-shipping-method-price"><?php echo esc_html(ttshopgear_get_shipping_rate_total($rate)); ?></span>
						<span class="tt-shipping-method-check">
							<?php echo ttshopgear_icon('check', 'tt-icon tt-icon-xs'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</span>
					</label>
				<?php endforeach; ?>
			<?php endforeach; ?>
		</div>
	</div>
<?php endif; ?>

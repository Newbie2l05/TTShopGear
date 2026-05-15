<?php
defined('ABSPATH') || exit;
?>
<div class="cart_totals tt-panel-card <?php echo WC()->customer->has_calculated_shipping() ? 'calculated_shipping' : ''; ?>">
	<?php do_action('woocommerce_before_cart_totals'); ?>
	<div class="tt-panel-head">
		<div class="tt-panel-head-icon">
			<?php echo ttshopgear_icon('shield', 'tt-icon tt-icon-sm'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
		<div>
			<span class="tt-route-badge">TỔNG KẾT</span>
			<h2>Tổng đơn hàng</h2>
		</div>
	</div>

	<table cellspacing="0" class="shop_table shop_table_responsive">
		<tr class="cart-subtotal">
			<th>Tạm tính</th>
			<td data-title="Tạm tính"><?php wc_cart_totals_subtotal_html(); ?></td>
		</tr>
		<?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr(sanitize_title($code)); ?>">
				<th><?php wc_cart_totals_coupon_label($coupon); ?></th>
				<td data-title="<?php echo esc_attr(wc_cart_totals_coupon_label($coupon, false)); ?>"><?php wc_cart_totals_coupon_html($coupon); ?></td>
			</tr>
		<?php endforeach; ?>
		<?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
			<?php do_action('woocommerce_cart_totals_before_shipping'); ?>
			<?php wc_cart_totals_shipping_html(); ?>
			<?php do_action('woocommerce_cart_totals_after_shipping'); ?>
		<?php elseif (WC()->cart->needs_shipping() && 'yes' === get_option('woocommerce_enable_shipping_calc')) : ?>
			<tr class="shipping">
				<th>Vận chuyển</th>
				<td data-title="Vận chuyển"><?php woocommerce_shipping_calculator(); ?></td>
			</tr>
		<?php endif; ?>
		<?php foreach (WC()->cart->get_fees() as $fee) : ?>
			<tr class="fee">
				<th><?php echo esc_html($fee->name); ?></th>
				<td data-title="<?php echo esc_attr($fee->name); ?>"><?php wc_cart_totals_fee_html($fee); ?></td>
			</tr>
		<?php endforeach; ?>
		<?php if (wc_tax_enabled() && ! WC()->cart->display_prices_including_tax()) : ?>
			<?php if ('itemized' === get_option('woocommerce_tax_total_display')) : ?>
				<?php foreach (WC()->cart->get_tax_totals() as $code => $tax) : ?>
					<tr class="tax-rate tax-rate-<?php echo esc_attr(sanitize_title($code)); ?>">
						<th><?php echo esc_html($tax->label); ?></th>
						<td><?php echo wp_kses_post($tax->formatted_amount); ?></td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr class="tax-total">
					<th><?php echo esc_html(WC()->countries->tax_or_vat()); ?></th>
					<td><?php wc_cart_totals_taxes_total_html(); ?></td>
				</tr>
			<?php endif; ?>
		<?php endif; ?>
		<?php do_action('woocommerce_cart_totals_before_order_total'); ?>
		<tr class="order-total">
			<th>Tổng cộng</th>
			<td data-title="Tổng cộng"><?php wc_cart_totals_order_total_html(); ?></td>
		</tr>
		<?php do_action('woocommerce_cart_totals_after_order_total'); ?>
	</table>

	<div class="wc-proceed-to-checkout">
		<?php do_action('woocommerce_proceed_to_checkout'); ?>
	</div>
	<?php do_action('woocommerce_after_cart_totals'); ?>
</div>

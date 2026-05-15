<?php
defined('ABSPATH') || exit;

if (! wp_doing_ajax()) {
	do_action('woocommerce_review_order_before_payment');
}
?>

<div id="payment" class="woocommerce-checkout-payment tt-payment-shell">

	<?php if (WC()->cart && WC()->cart->needs_payment()) : ?>
		<div class="tt-panel-head">
			<div class="tt-panel-head-icon">
				<?php echo ttshopgear_icon('zap', 'tt-icon tt-icon-sm'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
			<div>
				<span class="tt-route-badge">THANH TOÁN</span>
				<h3>Phương thức thanh toán</h3>
			</div>
		</div>
		<p class="tt-payment-intro">Chọn hình thức thanh toán phù hợp. Bạn có thể thanh toán bằng MoMo, chuyển khoản hoặc trả tiền khi nhận hàng.</p>

		<ul class="wc_payment_methods payment_methods methods tt-payment-methods-list">
			<?php if (! empty($available_gateways)) : ?>
				<?php foreach ($available_gateways as $gateway) : ?>
					<?php wc_get_template('checkout/payment-method.php', array('gateway' => $gateway)); ?>
				<?php endforeach; ?>
			<?php else : ?>
				<li>
					<?php wc_print_notice(apply_filters('woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__('Sorry, it seems that there are no available payment methods. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce') : esc_html__('Please fill in your details above to see available payment methods.', 'woocommerce')), 'notice'); ?>
				</li>
			<?php endif; ?>
		</ul>

	<?php endif; ?>

	<div class="form-row place-order tt-place-order">
		<?php wc_get_template('checkout/terms.php'); ?>
		<?php do_action('woocommerce_review_order_before_submit'); ?>
		<?php echo apply_filters('woocommerce_order_button_html', '<button type="submit" class="button alt tt-button tt-button-primary tt-button-full tt-place-order-btn' . esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : '') . '" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr($order_button_text) . '" data-value="' . esc_attr($order_button_text) . '">' . esc_html($order_button_text) . '</button>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<?php do_action('woocommerce_review_order_after_submit'); ?>
		<?php wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce'); ?>
		<p class="tt-order-note">
			<?php echo ttshopgear_icon('shield', 'tt-icon tt-icon-xs'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			Thông tin đơn hàng được bảo mật theo tiêu chuẩn WooCommerce
		</p>
	</div>

</div>

<?php
if (! wp_doing_ajax()) {
	do_action('woocommerce_review_order_after_payment');
}

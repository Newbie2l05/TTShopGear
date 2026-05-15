<?php
if (! defined('ABSPATH')) {
	exit;
}

do_action('woocommerce_before_checkout_form', $checkout);

if (! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in()) {
	echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
	return;
}
?>
<form name="checkout" method="post" class="checkout woocommerce-checkout tt-checkout-layout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data" aria-label="Thanh toán">
	<div class="tt-checkout-flow">
		<span>Giỏ hàng</span>
		<span class="tt-checkout-flow-sep">›</span>
		<span>Thông tin</span>
		<span class="tt-checkout-flow-sep">›</span>
		<span class="is-active">Thanh toán</span>
		<span class="tt-checkout-flow-sep">›</span>
		<span>Hoàn tất</span>
	</div>

	<div class="tt-checkout-main">
		<?php if ($checkout->get_checkout_fields()) : ?>
			<?php do_action('woocommerce_checkout_before_customer_details'); ?>
			<?php do_action('woocommerce_checkout_billing'); ?>
			<?php do_action('woocommerce_checkout_shipping'); ?>
			<?php do_action('woocommerce_checkout_after_customer_details'); ?>
		<?php endif; ?>

		<?php if (function_exists('woocommerce_checkout_payment')) : ?>
			<div class="tt-panel-card tt-checkout-payment-card">
				<?php woocommerce_checkout_payment(); ?>
			</div>
		<?php endif; ?>
	</div>

	<div class="tt-checkout-side">
		<?php do_action('woocommerce_checkout_before_order_review_heading'); ?>
		<div class="tt-panel-card tt-checkout-summary-card">
			<?php do_action('woocommerce_checkout_before_order_review'); ?>
			<div id="order_review" class="woocommerce-checkout-review-order">
				<?php do_action('woocommerce_checkout_order_review'); ?>
			</div>
			<?php do_action('woocommerce_checkout_after_order_review'); ?>
		</div>
	</div>
</form>
<?php do_action('woocommerce_after_checkout_form', $checkout); ?>

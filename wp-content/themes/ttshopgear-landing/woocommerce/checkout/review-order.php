<?php
defined('ABSPATH') || exit;

$item_count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
$shipping_total = WC()->cart ? ((float) WC()->cart->get_shipping_total() + (float) WC()->cart->get_shipping_tax()) : 0;
?>
<div class="tt-order-review-shell">
	<div class="tt-order-review-head">
		<h3>Đơn hàng của bạn <span>(<?php echo esc_html((string) $item_count); ?> sản phẩm)</span></h3>
		<a href="<?php echo esc_url(function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart/')); ?>">Sửa</a>
	</div>

	<div class="tt-order-review-items">
		<?php do_action('woocommerce_review_order_before_cart_contents'); ?>
		<?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) : ?>
			<?php
			$_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
			if (! ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key))) {
				continue;
			}
			?>
			<div class="tt-order-review-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
				<div class="tt-order-review-item-thumb">
					<?php echo wp_kses_post($_product->get_image('woocommerce_thumbnail')); ?>
				</div>
				<div class="tt-order-review-item-copy">
					<strong><?php echo esc_html($_product->get_name()); ?></strong>
					<span>x<?php echo esc_html((string) $cart_item['quantity']); ?></span>
				</div>
				<div class="tt-order-review-item-price">
					<?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
			</div>
		<?php endforeach; ?>
		<?php do_action('woocommerce_review_order_after_cart_contents'); ?>
	</div>

	<div class="tt-order-review-totals">
		<div class="tt-order-review-total-row">
			<span>Tạm tính</span>
			<strong><?php wc_cart_totals_subtotal_html(); ?></strong>
		</div>

		<?php if ($shipping_total > 0) : ?>
			<div class="tt-order-review-total-row">
				<span>Phí vận chuyển</span>
				<strong><?php echo esc_html(ttshopgear_format_catalog_price($shipping_total)); ?></strong>
			</div>
		<?php endif; ?>

		<?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
			<div class="tt-order-review-total-row tt-order-review-total-row--discount">
				<span><?php echo esc_html(wc_cart_totals_coupon_label($coupon, false)); ?></span>
				<strong><?php wc_cart_totals_coupon_html($coupon); ?></strong>
			</div>
		<?php endforeach; ?>

		<?php foreach (WC()->cart->get_fees() as $fee) : ?>
			<div class="tt-order-review-total-row">
				<span><?php echo esc_html($fee->name); ?></span>
				<strong><?php wc_cart_totals_fee_html($fee); ?></strong>
			</div>
		<?php endforeach; ?>

		<?php if (wc_tax_enabled() && ! WC()->cart->display_prices_including_tax()) : ?>
			<div class="tt-order-review-total-row">
				<span><?php echo esc_html(WC()->countries->tax_or_vat()); ?></span>
				<strong><?php wc_cart_totals_taxes_total_html(); ?></strong>
			</div>
		<?php endif; ?>

		<div class="tt-order-review-total-row tt-order-review-total-row--grand">
			<span>Tổng cộng</span>
			<strong><?php wc_cart_totals_order_total_html(); ?></strong>
		</div>
	</div>
</div>

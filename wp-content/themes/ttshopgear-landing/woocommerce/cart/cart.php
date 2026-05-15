<?php
defined('ABSPATH') || exit;

do_action('woocommerce_before_cart');
?>
<div class="tt-cart-layout">
	<div class="tt-panel-card tt-cart-main">
		<div class="tt-panel-head">
			<div class="tt-panel-head-icon">
				<?php echo ttshopgear_icon('cart', 'tt-icon tt-icon-sm'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
			<div>
				<span class="tt-route-badge">GIỎ HÀNG</span>
				<h2>Sản phẩm đã chọn</h2>
			</div>
		</div>

		<form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
			<?php do_action('woocommerce_before_cart_table'); ?>
			<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
				<thead>
					<tr>
						<th class="product-remove"><span class="screen-reader-text">Xóa sản phẩm</span></th>
						<th class="product-thumbnail"><span class="screen-reader-text">Ảnh sản phẩm</span></th>
						<th scope="col" class="product-name">Sản phẩm</th>
						<th scope="col" class="product-price">Giá</th>
						<th scope="col" class="product-quantity">Số lượng</th>
						<th scope="col" class="product-subtotal">Tạm tính</th>
					</tr>
				</thead>
				<tbody>
					<?php do_action('woocommerce_before_cart_contents'); ?>

					<?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) : ?>
						<?php
						$_product        = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
						$product_id      = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
						$product_name    = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
						$product_visible = $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key);
						?>
						<?php if (! $product_visible) : ?>
							<?php continue; ?>
						<?php endif; ?>
						<?php $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key); ?>
						<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
							<td class="product-remove">
								<?php
								echo apply_filters(
									'woocommerce_cart_item_remove_link',
									sprintf(
										'<a role="button" href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
										esc_url(wc_get_cart_remove_url($cart_item_key)),
										esc_attr(sprintf(__('Remove %s from cart', 'woocommerce'), wp_strip_all_tags($product_name))),
										esc_attr((string) $product_id),
										esc_attr($_product->get_sku())
									),
									$cart_item_key
								);
								?>
							</td>
							<td class="product-thumbnail">
								<?php
								$thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
								if (! $product_permalink) {
									echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								} else {
									printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								}
								?>
							</td>
							<td class="product-name" data-title="Sản phẩm">
								<?php
								if (! $product_permalink) {
									echo wp_kses_post($product_name . '&nbsp;');
								} else {
									echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
								}
								do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);
								echo wc_get_formatted_cart_item_data($cart_item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
							</td>
							<td class="product-price" data-title="Giá"><?php echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
							<td class="product-quantity" data-title="Số lượng">
								<?php
								$min_quantity = $_product->is_sold_individually() ? 1 : 0;
								$max_quantity = $_product->is_sold_individually() ? 1 : $_product->get_max_purchase_quantity();
								$product_quantity = woocommerce_quantity_input(
									array(
										'input_name'   => "cart[{$cart_item_key}][qty]",
										'input_value'  => $cart_item['quantity'],
										'max_value'    => $max_quantity,
										'min_value'    => $min_quantity,
										'product_name' => $product_name,
									),
									$_product,
									false
								);
								echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
							</td>
							<td class="product-subtotal" data-title="Tạm tính"><?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
						</tr>
					<?php endforeach; ?>

					<?php do_action('woocommerce_cart_contents'); ?>
					<tr>
						<td colspan="6" class="actions">
							<?php if (wc_coupons_enabled()) : ?>
								<div class="coupon">
									<label for="coupon_code" class="screen-reader-text">Mã giảm giá</label>
									<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="Mã ưu đãi" />
									<button type="submit" class="button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" name="apply_coupon" value="Áp dụng">Áp dụng</button>
									<?php do_action('woocommerce_cart_coupon'); ?>
								</div>
							<?php endif; ?>

							<button type="submit" class="button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" name="update_cart" value="Cập nhật giỏ hàng">Cập nhật giỏ hàng</button>
							<?php do_action('woocommerce_cart_actions'); ?>
							<?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
						</td>
					</tr>
					<?php do_action('woocommerce_after_cart_contents'); ?>
				</tbody>
			</table>
			<?php do_action('woocommerce_after_cart_table'); ?>
		</form>
	</div>

	<div class="tt-cart-side">
		<?php do_action('woocommerce_before_cart_collaterals'); ?>
		<div class="cart-collaterals">
			<?php do_action('woocommerce_cart_collaterals'); ?>
		</div>
	</div>
</div>
<?php do_action('woocommerce_after_cart'); ?>

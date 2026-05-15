<?php
defined('ABSPATH') || exit;

$fields = $checkout->get_checkout_fields('billing');
$order_fields = $checkout->get_checkout_fields('order');

$left_field_keys = array(
	'billing_country',
	'billing_address_1',
	'billing_city',
	'billing_state',
);

$right_field_keys = array(
	'billing_first_name',
	'billing_phone',
	'billing_email',
	'order_comments',
);
?>
<div class="woocommerce-billing-fields tt-panel-card tt-checkout-billing-card">
	<div class="tt-panel-head">
		<div class="tt-panel-head-icon">
			<?php echo ttshopgear_icon('user', 'tt-icon tt-icon-sm'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
		<div>
			<span class="tt-route-badge">THÔNG TIN</span>
			<h2>Thông tin nhận hàng</h2>
		</div>
	</div>

	<?php do_action('woocommerce_before_checkout_billing_form', $checkout); ?>

	<div class="tt-checkout-contact-grid">
		<div class="tt-checkout-contact-column">
			<div class="woocommerce-billing-fields__field-wrapper tt-checkout-fields tt-checkout-fields--stack">
				<?php foreach ($left_field_keys as $key) : ?>
					<?php
					if (empty($fields[ $key ])) {
						continue;
					}

					woocommerce_form_field($key, $fields[ $key ], $checkout->get_value($key));
					?>
				<?php endforeach; ?>
			</div>
		</div>

		<div class="tt-checkout-contact-column">
			<div class="woocommerce-billing-fields__field-wrapper tt-checkout-fields tt-checkout-fields--stack">
				<?php foreach ($right_field_keys as $key) : ?>
					<?php
					if ('order_comments' === $key) {
						if (! empty($order_fields['order_comments'])) {
							woocommerce_form_field('order_comments', $order_fields['order_comments'], $checkout->get_value('order_comments'));
						}

						continue;
					}

					if (empty($fields[ $key ])) {
						continue;
					}

					woocommerce_form_field($key, $fields[ $key ], $checkout->get_value($key));
					?>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<?php do_action('woocommerce_after_checkout_billing_form', $checkout); ?>
</div>

<?php if (! is_user_logged_in() && $checkout->is_registration_enabled()) : ?>
	<div class="woocommerce-account-fields tt-panel-card tt-checkout-account-card">
		<div class="tt-checkout-account-header">
			<?php echo ttshopgear_icon('zap', 'tt-icon tt-icon-sm'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<span>Tùy chọn tài khoản</span>
		</div>
		<?php if (! $checkout->is_registration_required()) : ?>
			<p class="form-row form-row-wide create-account">
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox tt-checkbox-label">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox tt-checkbox" id="createaccount" <?php checked((true === $checkout->get_value('createaccount') || (true === apply_filters('woocommerce_create_account_default_checked', false))), true); ?> type="checkbox" name="createaccount" value="1" />
					<span class="tt-checkbox-box"></span>
					<span>Tạo tài khoản cùng đơn hàng này</span>
				</label>
			</p>
		<?php endif; ?>

		<?php do_action('woocommerce_before_checkout_registration_form', $checkout); ?>
		<?php if ($checkout->get_checkout_fields('account')) : ?>
			<div class="create-account tt-checkout-fields">
				<?php foreach ($checkout->get_checkout_fields('account') as $key => $field) : ?>
					<?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<?php do_action('woocommerce_after_checkout_registration_form', $checkout); ?>
	</div>
<?php endif; ?>

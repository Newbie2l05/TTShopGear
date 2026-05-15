<?php
defined('ABSPATH') || exit;

$icon_name = 'shield';
$icon_label = '';

if ('ttshopgear_momo_qr' === $gateway->id) {
	$icon_label = 'MoMo';
} elseif ('cod' === $gateway->id) {
	$icon_name = 'award';
} elseif ('bacs' === $gateway->id) {
	$icon_name = 'cpu';
}
?>
<li class="wc_payment_method payment_method_<?php echo esc_attr($gateway->id); ?>">
	<input id="payment_method_<?php echo esc_attr($gateway->id); ?>" type="radio" class="input-radio" name="payment_method" value="<?php echo esc_attr($gateway->id); ?>" <?php checked($gateway->chosen, true); ?> data-order_button_text="<?php echo esc_attr($gateway->order_button_text); ?>" />

	<label for="payment_method_<?php echo esc_attr($gateway->id); ?>">
		<span class="tt-payment-method-icon<?php echo $icon_label ? ' is-momo' : ''; ?>">
			<?php if ($icon_label) : ?>
				<span><?php echo esc_html($icon_label); ?></span>
			<?php else : ?>
				<?php echo ttshopgear_icon($icon_name, 'tt-icon tt-icon-sm'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php endif; ?>
		</span>
		<span class="tt-payment-method-copy">
			<strong><?php echo wp_kses_post($gateway->get_title()); ?></strong>
			<?php if ($gateway->get_description()) : ?>
				<small><?php echo esc_html(wp_strip_all_tags($gateway->get_description())); ?></small>
			<?php endif; ?>
		</span>
		<span class="tt-payment-method-check">
			<?php echo ttshopgear_icon('check', 'tt-icon tt-icon-xs'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</span>
	</label>

	<?php if ($gateway->has_fields() || $gateway->get_description()) : ?>
		<div class="payment_box payment_method_<?php echo esc_attr($gateway->id); ?>" <?php if (! $gateway->chosen) : ?>style="display:none;"<?php endif; ?>>
			<?php $gateway->payment_fields(); ?>
		</div>
	<?php endif; ?>
</li>

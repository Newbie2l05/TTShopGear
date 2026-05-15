<?php
defined('ABSPATH') || exit;

do_action('woocommerce_before_account_navigation');

$nav_icons = array(
	'edit-account'    => 'user',
	'orders'          => 'cart',
	'payment-methods' => 'shield',
	'customer-logout' => 'close',
);
?>
<nav class="woocommerce-MyAccount-navigation tt-account-nav" aria-label="<?php echo esc_attr__('Trang tài khoản', 'ttshopgear-landing'); ?>">
	<div class="tt-account-nav-head">
		<span class="tt-route-badge">TÀI KHOẢN</span>
		<h2>Quản lý tài khoản</h2>
		<p>Theo dõi đơn hàng, phương thức thanh toán và thông tin tài khoản trên cùng một giao diện.</p>
	</div>
	<ul>
		<?php foreach (wc_get_account_menu_items() as $endpoint => $label) : ?>
			<li class="<?php echo esc_attr(wc_get_account_menu_item_classes($endpoint)); ?>">
				<?php $endpoint_url = 'orders' === $endpoint && function_exists('wc_get_cart_url') ? wc_get_cart_url() : wc_get_account_endpoint_url($endpoint); ?>
				<a href="<?php echo esc_url($endpoint_url); ?>" <?php echo wc_is_current_account_menu_item($endpoint) ? 'aria-current="page"' : ''; ?><?php echo 'customer-logout' === $endpoint ? ' data-logout-confirm' : ''; ?>>
					<?php
					$icon_name = isset($nav_icons[ $endpoint ]) ? $nav_icons[ $endpoint ] : 'chevron-right';
					echo ttshopgear_icon($icon_name, 'tt-icon tt-icon-sm tt-nav-icon'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>
					<?php echo esc_html($label); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>
<?php do_action('woocommerce_after_account_navigation'); ?>

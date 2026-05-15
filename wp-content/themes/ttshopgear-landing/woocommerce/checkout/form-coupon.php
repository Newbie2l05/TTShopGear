<?php
defined('ABSPATH') || exit;

if (! wc_coupons_enabled()) {
	return;
}
?>
<div class="woocommerce-form-coupon-toggle">
	<?php
	wc_print_notice(
		'Có mã ưu đãi? <a href="#" role="button" aria-expanded="false" aria-controls="checkout_coupon" class="showcoupon">Bấm vào đây để nhập mã</a>',
		'notice'
	);
	?>
</div>

<form class="checkout_coupon woocommerce-form-coupon" method="post" style="display:none">
	<p>Nếu bạn có mã giảm giá, hãy nhập tại đây để áp dụng cho đơn hàng.</p>

	<p class="form-row form-row-first">
		<label for="coupon_code" class="screen-reader-text">Mã ưu đãi</label>
		<input type="text" name="coupon_code" class="input-text" placeholder="Nhập mã ưu đãi" id="coupon_code" value="" />
	</p>

	<p class="form-row form-row-last">
		<button type="submit" class="button" name="apply_coupon" value="Áp dụng">Áp dụng</button>
	</p>

	<div class="clear"></div>
</form>

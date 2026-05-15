<?php
defined('ABSPATH') || exit;
?>
<div class="tt-panel-card tt-empty-cart-card">
	<div class="tt-panel-head">
		<span class="tt-route-badge">GIỎ HÀNG</span>
		<h2>Chưa có sản phẩm nào</h2>
		<p>Giỏ hàng của bạn đang trống. Khám phá các nhóm sản phẩm chính để bắt đầu cấu hình góc gear phù hợp.</p>
	</div>

	<div class="tt-chip-row">
		<a href="<?php echo esc_url(ttshopgear_get_category_url('keyboards')); ?>" class="tt-chip">Bàn phím gaming</a>
		<a href="<?php echo esc_url(ttshopgear_get_category_url('mice')); ?>" class="tt-chip">Chuột gaming</a>
		<a href="<?php echo esc_url(ttshopgear_get_category_url('headsets')); ?>" class="tt-chip">Tai nghe gaming</a>
		<a href="<?php echo esc_url(ttshopgear_get_category_url('streaming')); ?>" class="tt-chip">Streaming</a>
	</div>
</div>

<?php
if (! defined('ABSPATH')) {
	exit;
}

class TTShopGear_Gateway_Momo_QR extends WC_Payment_Gateway {
	public function __construct() {
		$this->id                 = 'ttshopgear_momo_qr';
		$this->icon               = '';
		$this->has_fields         = false;
		$this->method_title       = 'TTShopGear MoMo QR';
		$this->method_description = 'Tạo mã VietQR động để MoMo quét và tự điền đúng số tiền đơn hàng.';
		$this->supports           = array('products');

		$this->init_form_fields();
		$this->init_settings();

		$this->title        = (string) $this->get_option('title', 'Thanh toán QR MoMo');
		$this->description  = (string) $this->get_option('description', '');
		$this->instructions = (string) $this->get_option('instructions', '');

		add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
		add_action('woocommerce_thankyou_' . $this->id, array($this, 'thankyou_page'));
		add_action('woocommerce_email_before_order_table', array($this, 'email_instructions'), 10, 3);
	}

	public function init_form_fields() {
		$this->form_fields = array(
			'enabled' => array(
				'title' => 'Bật / tắt',
				'type' => 'checkbox',
				'label' => 'Bật thanh toán QR MoMo',
				'default' => 'yes',
			),
			'title' => array(
				'title' => 'Tiêu đề',
				'type' => 'text',
				'default' => 'Thanh toán QR MoMo',
			),
			'description' => array(
				'title' => 'Mô tả ngắn',
				'type' => 'textarea',
				'default' => 'Quét mã QR bằng MoMo để tự điền đúng số tiền đơn hàng và chuyển khoản tới MB Bank.',
			),
			'bank_id' => array(
				'title' => 'Mã ngân hàng VietQR',
				'type' => 'text',
				'default' => 'MB',
			),
			'account_number' => array(
				'title' => 'Số tài khoản MB Bank',
				'type' => 'text',
				'default' => '1234567872005',
			),
			'account_name' => array(
				'title' => 'Tên tài khoản',
				'type' => 'text',
				'default' => 'LAM CHI THANH',
			),
			'phone_number' => array(
				'title' => 'Số MoMo hiển thị tham chiếu',
				'type' => 'text',
				'default' => '0355379198',
			),
			'instructions' => array(
				'title' => 'Hướng dẫn thanh toán',
				'type' => 'textarea',
				'default' => 'Quét mã QR bằng MoMo hoặc app ngân hàng để tự điền đúng số tiền. Sau khi đặt hàng, vui lòng dùng mã đơn hàng làm nội dung chuyển khoản nếu app không tự điền.',
			),
		);
	}

	protected function get_qr_amount() {
		if (! function_exists('WC') || ! WC()->cart) {
			return 0;
		}

		return (int) round((float) WC()->cart->get_total('edit'));
	}

	protected function sanitize_transfer_note($value) {
		$value = wp_strip_all_tags((string) $value);
		$value = remove_accents($value);
		$value = preg_replace('/[^A-Za-z0-9 ]/', ' ', $value);
		$value = trim(preg_replace('/\s+/', ' ', $value));

		if (strlen($value) > 50) {
			$value = substr($value, 0, 50);
		}

		return $value;
	}

	protected function build_vietqr_url($amount, $note = '') {
		$bank_id        = (string) $this->get_option('bank_id', 'MB');
		$account_number = preg_replace('/\s+/', '', (string) $this->get_option('account_number', '1234567872005'));
		$account_name   = trim((string) $this->get_option('account_name', 'LAM CHI THANH'));

		$query_args = array(
			'amount' => max(0, (int) $amount),
			'accountName' => $account_name,
		);

		if ($note) {
			$query_args['addInfo'] = $this->sanitize_transfer_note($note);
		}

		return add_query_arg(
			$query_args,
			sprintf(
				'https://img.vietqr.io/image/%1$s-%2$s-compact2.png',
				rawurlencode($bank_id),
				rawurlencode($account_number)
			)
		);
	}

	public function payment_fields() {
		$phone_number   = (string) $this->get_option('phone_number', '0355379198');
		$account_number = (string) $this->get_option('account_number', '1234567872005');
		$account_name   = (string) $this->get_option('account_name', 'LAM CHI THANH');
		$amount         = $this->get_qr_amount();
		$transfer_note  = 'TTSHOPGEAR';
		$qr_image_url   = $this->build_vietqr_url($amount, $transfer_note);
		?>
		<div class="tt-momo-card">
			<div class="tt-momo-card-header">
				<div class="tt-momo-brand">
					<span class="tt-momo-logo-text">Mo</span><span class="tt-momo-logo-text tt-momo-logo-mo">Mo</span>
				</div>
				<span class="tt-momo-badge">Quét VietQR bằng MoMo</span>
			</div>

			<div class="tt-momo-body">
				<div class="tt-momo-qr-wrap">
					<img src="<?php echo esc_url($qr_image_url); ?>" alt="QR thanh toán đơn hàng" class="tt-momo-qr-image">
					<p class="tt-momo-qr-hint">MoMo sẽ tự điền sẵn số tiền đơn hàng</p>
				</div>

				<div class="tt-momo-info">
					<div class="tt-momo-info-row">
						<span class="tt-momo-info-label">Ngân hàng nhận</span>
						<strong class="tt-momo-info-value">MB Bank</strong>
					</div>
					<div class="tt-momo-info-row">
						<span class="tt-momo-info-label">Số tài khoản</span>
						<strong class="tt-momo-info-value tt-momo-phone"><?php echo esc_html($account_number); ?></strong>
					</div>
					<div class="tt-momo-info-row">
						<span class="tt-momo-info-label">Tên tài khoản</span>
						<strong class="tt-momo-info-value"><?php echo esc_html($account_name); ?></strong>
					</div>
					<div class="tt-momo-info-row">
						<span class="tt-momo-info-label">Số MoMo tham chiếu</span>
						<strong class="tt-momo-info-value"><?php echo esc_html($phone_number); ?></strong>
					</div>
					<div class="tt-momo-info-row">
						<span class="tt-momo-info-label">Số tiền cần thanh toán</span>
						<strong class="tt-momo-info-value"><?php echo esc_html(ttshopgear_format_catalog_price((float) $amount)); ?></strong>
					</div>
				</div>

				<div class="tt-momo-steps">
					<p class="tt-momo-steps-title">Cách thanh toán:</p>
					<ol class="tt-momo-step-list">
						<li>Mở <strong>MoMo</strong> và chọn quét mã QR</li>
						<li>Quét QR ở trên, app sẽ tự điền <strong>đúng số tiền đơn hàng</strong></li>
						<li>Kiểm tra người nhận <strong><?php echo esc_html($account_name); ?></strong></li>
						<li>Nếu app không tự điền nội dung, hãy nhập mã đơn hàng sau khi đặt</li>
						<li>Xác nhận thanh toán để hoàn tất</li>
					</ol>
				</div>

				<p class="tt-momo-note">
					<?php echo function_exists('ttshopgear_icon') ? ttshopgear_icon('shield', 'tt-icon tt-icon-xs') : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					Mã này là VietQR động theo tổng tiền giỏ hàng, MoMo quét được và có sẵn số tiền.
				</p>
			</div>
		</div>
		<?php
	}

	public function process_payment($order_id) {
		$order = wc_get_order($order_id);
		if (! $order instanceof WC_Order) {
			return array(
				'result' => 'failure',
			);
		}

		$account_number = (string) $this->get_option('account_number', '1234567872005');
		$order->update_status(
			'on-hold',
			'Chờ đối soát thanh toán VietQR / MoMo tới tài khoản ' . $account_number . '.'
		);
		$order->add_order_note('Khách đã chọn thanh toán QR MoMo qua VietQR tới MB Bank ' . $account_number . '.');
		WC()->cart->empty_cart();

		return array(
			'result' => 'success',
			'redirect' => $this->get_return_url($order),
		);
	}

	public function thankyou_page($order_id = 0) {
		$order = wc_get_order($order_id);

		if ($order instanceof WC_Order) {
			$amount        = (int) round((float) $order->get_total());
			$transfer_note = 'DH' . $order->get_order_number();
			$qr_image_url  = $this->build_vietqr_url($amount, $transfer_note);
			?>
			<div class="tt-momo-card tt-momo-card--thankyou">
				<div class="tt-momo-card-header">
					<div class="tt-momo-brand">
						<span class="tt-momo-logo-text">Mo</span><span class="tt-momo-logo-text tt-momo-logo-mo">Mo</span>
					</div>
					<span class="tt-momo-badge">QR đơn hàng #<?php echo esc_html($order->get_order_number()); ?></span>
				</div>
				<div class="tt-momo-body">
					<div class="tt-momo-qr-wrap">
						<img src="<?php echo esc_url($qr_image_url); ?>" alt="QR thanh toán đơn hàng <?php echo esc_attr($order->get_order_number()); ?>" class="tt-momo-qr-image">
						<p class="tt-momo-qr-hint">Quét để thanh toán đúng số tiền của đơn #<?php echo esc_html($order->get_order_number()); ?></p>
					</div>
					<div class="tt-momo-info">
						<div class="tt-momo-info-row">
							<span class="tt-momo-info-label">Số tiền</span>
							<strong class="tt-momo-info-value"><?php echo esc_html(ttshopgear_format_catalog_price((float) $amount)); ?></strong>
						</div>
						<div class="tt-momo-info-row">
							<span class="tt-momo-info-label">Nội dung</span>
							<strong class="tt-momo-info-value"><?php echo esc_html($transfer_note); ?></strong>
						</div>
					</div>
				</div>
			</div>
			<?php
		}

		if (! empty($this->instructions)) {
			echo wp_kses_post(wpautop($this->instructions));
		}
	}

	public function email_instructions($order, $sent_to_admin, $plain_text = false) {
		if ($sent_to_admin || ! $order instanceof WC_Order || $this->id !== $order->get_payment_method() || ! $order->has_status('on-hold')) {
			return;
		}

		if ($plain_text) {
			echo wp_strip_all_tags($this->instructions) . PHP_EOL;
			return;
		}

		echo wp_kses_post(wpautop($this->instructions));
	}
}

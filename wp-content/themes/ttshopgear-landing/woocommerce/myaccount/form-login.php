<?php
defined('ABSPATH') || exit;

do_action('woocommerce_before_customer_login_form');
?>

<div class="tt-auth-wrap">

<?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>
<div class="tt-auth-tabs" id="tt-auth-tabs">
	<button type="button" class="tt-auth-tab is-active" data-auth-tab="login" id="tab-login-btn">
		<?php echo ttshopgear_icon('user', 'tt-icon tt-icon-sm'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		Đăng nhập
	</button>
	<button type="button" class="tt-auth-tab" data-auth-tab="register" id="tab-register-btn">
		<?php echo ttshopgear_icon('zap', 'tt-icon tt-icon-sm'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		Đăng ký
	</button>
</div>
<?php endif; ?>

<div id="customer_login" class="tt-auth-panels">

	<div class="tt-auth-panel is-active" id="auth-panel-login" data-auth-panel="login">
		<div class="tt-auth-card">

			<div class="tt-auth-card-header">
				<div class="tt-auth-card-icon">
					<?php echo ttshopgear_icon('user', 'tt-icon tt-icon-lg'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
				<div>
					<span class="tt-route-badge">ĐĂNG NHẬP</span>
					<h2>Chào mừng trở lại</h2>
					<p>Đăng nhập để xem đơn hàng, lịch sử mua sắm và quản lý thông tin giao nhận.</p>
				</div>
			</div>

			<form class="woocommerce-form woocommerce-form-login login tt-auth-form" method="post" novalidate>
				<?php do_action('woocommerce_login_form_start'); ?>

				<div class="tt-form-field">
					<label for="username" class="tt-form-label">
						<?php echo ttshopgear_icon('user', 'tt-icon tt-icon-xs'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						Email hoặc tên đăng nhập <span class="required" aria-hidden="true">*</span>
					</label>
					<input
						type="text"
						class="woocommerce-Input woocommerce-Input--text input-text tt-form-input"
						name="username"
						id="username"
						autocomplete="username"
						placeholder="example@email.com"
						value="<?php echo (! empty($_POST['username']) && is_string($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>"
						required
						aria-required="true"
					/>
				</div>

				<div class="tt-form-field">
					<label for="password" class="tt-form-label">
						<?php echo ttshopgear_icon('shield', 'tt-icon tt-icon-xs'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						Mật khẩu <span class="required" aria-hidden="true">*</span>
					</label>
					<div class="tt-input-wrap">
						<input
							class="woocommerce-Input woocommerce-Input--text input-text tt-form-input"
							type="password"
							name="password"
							id="password"
							autocomplete="current-password"
							placeholder="••••••••"
							required
							aria-required="true"
						/>
						<button type="button" class="tt-pw-toggle" data-pw-toggle="password" aria-label="Hiện mật khẩu" aria-pressed="false">
							<span class="tt-pw-toggle-icon tt-pw-toggle-icon--show">
								<?php echo ttshopgear_icon('eye', 'tt-icon tt-icon-xs'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</span>
							<span class="tt-pw-toggle-icon tt-pw-toggle-icon--hide">
								<?php echo ttshopgear_icon('eye-off', 'tt-icon tt-icon-xs'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</span>
						</button>
					</div>
				</div>

				<?php do_action('woocommerce_login_form'); ?>

				<div class="tt-auth-row">
					<label class="tt-checkbox-label woocommerce-form__label-for-checkbox">
						<input
							class="woocommerce-form__input woocommerce-form__input-checkbox tt-checkbox"
							name="rememberme"
							type="checkbox"
							id="rememberme"
							value="forever"
						/>
						<span class="tt-checkbox-box"></span>
						<span>Ghi nhớ đăng nhập</span>
					</label>
					<a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="tt-auth-link">Quên mật khẩu?</a>
				</div>

				<?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>

				<button type="submit" class="tt-button tt-button-primary tt-button-full" name="login" value="Đăng nhập">
					<?php echo ttshopgear_icon('zap', 'tt-icon tt-icon-sm'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					Đăng nhập
				</button>

				<?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>
				<p class="tt-auth-note tt-auth-switch-note">
					Chưa có tài khoản?
					<button type="button" class="tt-auth-switch-link" data-auth-switch="register">Đăng ký ngay</button>
				</p>
				<?php endif; ?>

				<?php do_action('woocommerce_login_form_end'); ?>
			</form>

		</div>
	</div>

<?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>

	<div class="tt-auth-panel" id="auth-panel-register" data-auth-panel="register">
		<div class="tt-auth-card">

			<div class="tt-auth-card-header">
				<div class="tt-auth-card-icon tt-auth-card-icon--accent">
					<?php echo ttshopgear_icon('zap', 'tt-icon tt-icon-lg'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
				<div>
					<span class="tt-route-badge tt-route-badge--accent">ĐĂNG KÝ</span>
					<h2>Tạo tài khoản</h2>
					<p>Đăng ký để lưu địa chỉ, thanh toán nhanh hơn và theo dõi đơn hàng thuận tiện.</p>
				</div>
			</div>

			<form method="post" class="woocommerce-form woocommerce-form-register register tt-auth-form" <?php do_action('woocommerce_register_form_tag'); ?>>
				<?php do_action('woocommerce_register_form_start'); ?>

				<?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>
				<div class="tt-form-field">
					<label for="reg_username" class="tt-form-label">
						<?php echo ttshopgear_icon('user', 'tt-icon tt-icon-xs'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						Tên đăng nhập <span class="required" aria-hidden="true">*</span>
					</label>
					<input
						type="text"
						class="woocommerce-Input woocommerce-Input--text input-text tt-form-input"
						name="username"
						id="reg_username"
						autocomplete="username"
						placeholder="Tên đăng nhập của bạn"
						value="<?php echo (! empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>"
						required
						aria-required="true"
					/>
				</div>
				<?php endif; ?>

				<div class="tt-form-field">
					<label for="reg_email" class="tt-form-label">
						<?php echo ttshopgear_icon('send', 'tt-icon tt-icon-xs'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						Email <span class="required" aria-hidden="true">*</span>
					</label>
					<input
						type="email"
						class="woocommerce-Input woocommerce-Input--text input-text tt-form-input"
						name="email"
						id="reg_email"
						autocomplete="email"
						placeholder="example@email.com"
						value="<?php echo (! empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>"
						required
						aria-required="true"
					/>
				</div>

				<?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>
				<div class="tt-form-field">
					<label for="reg_password" class="tt-form-label">
						<?php echo ttshopgear_icon('shield', 'tt-icon tt-icon-xs'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						Mật khẩu <span class="required" aria-hidden="true">*</span>
					</label>
					<div class="tt-input-wrap">
						<input
							type="password"
							class="woocommerce-Input woocommerce-Input--text input-text tt-form-input"
							name="password"
							id="reg_password"
							autocomplete="new-password"
							placeholder="Tối thiểu 8 ký tự"
							required
							aria-required="true"
						/>
						<button type="button" class="tt-pw-toggle" data-pw-toggle="reg_password" aria-label="Hiện mật khẩu" aria-pressed="false">
							<span class="tt-pw-toggle-icon tt-pw-toggle-icon--show">
								<?php echo ttshopgear_icon('eye', 'tt-icon tt-icon-xs'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</span>
							<span class="tt-pw-toggle-icon tt-pw-toggle-icon--hide">
								<?php echo ttshopgear_icon('eye-off', 'tt-icon tt-icon-xs'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</span>
						</button>
					</div>
				</div>
				<?php else : ?>
				<div class="tt-auth-info-box">
					<?php echo ttshopgear_icon('shield', 'tt-icon tt-icon-sm'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<p>Hệ thống sẽ gửi email để bạn thiết lập mật khẩu mới.</p>
				</div>
				<?php endif; ?>

				<?php do_action('woocommerce_register_form'); ?>

				<div class="tt-auth-benefits">
					<div class="tt-auth-benefit-item">
						<?php echo ttshopgear_icon('truck', 'tt-icon tt-icon-xs'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<span>Theo dõi đơn hàng</span>
					</div>
					<div class="tt-auth-benefit-item">
						<?php echo ttshopgear_icon('refresh', 'tt-icon tt-icon-xs'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<span>Thanh toán nhanh hơn</span>
					</div>
					<div class="tt-auth-benefit-item">
						<?php echo ttshopgear_icon('award', 'tt-icon tt-icon-xs'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<span>Ưu đãi thành viên</span>
					</div>
				</div>

				<?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>

				<button type="submit" class="tt-button tt-button-accent tt-button-full" name="register" value="Đăng ký">
					<?php echo ttshopgear_icon('zap', 'tt-icon tt-icon-sm'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					Tạo tài khoản miễn phí
				</button>

				<p class="tt-auth-note tt-auth-switch-note">
					Đã có tài khoản?
					<button type="button" class="tt-auth-switch-link" data-auth-switch="login">Đăng nhập</button>
				</p>

				<?php do_action('woocommerce_register_form_end'); ?>
			</form>

		</div>
	</div>

<?php endif; ?>

</div><!-- .tt-auth-panels -->
</div><!-- .tt-auth-wrap -->

<?php do_action('woocommerce_after_customer_login_form'); ?>

<?php
/**
 * Contact form (AJAX, same fields + wording as original site).
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="bp-form-card">
	<h2><?php esc_html_e( 'Send Us a Message', 'brickpoint' ); ?></h2>
	<p><?php esc_html_e( 'Fill in the form below and our team will get back to you. For faster response, use WhatsApp.', 'brickpoint' ); ?></p>

	<div class="bp-alert bp-alert-success" data-bp-form-success style="display:none">
		<?php echo brickpoint_icon( 'check', 20 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<div>
			<strong><?php esc_html_e( 'Message Received!', 'brickpoint' ); ?></strong>
			<p><?php printf( esc_html__( 'Thank you! Our team will contact you shortly. For urgent inquiries, WhatsApp us at %s.', 'brickpoint' ), esc_html( brickpoint_get( 'phone' ) ) ); ?></p>
		</div>
	</div>

	<div class="bp-alert bp-alert-error" data-bp-form-error style="display:none">
		<?php echo brickpoint_icon( 'info', 20 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<p data-bp-form-error-text></p>
	</div>

	<form data-bp-contact-form class="bp-form-grid" novalidate>
		<div class="bp-form-grid bp-form-grid-2">
			<div class="bp-field">
				<label for="bp-name"><?php esc_html_e( 'Full Name', 'brickpoint' ); ?> <span class="bp-req">*</span></label>
				<input type="text" id="bp-name" name="name" placeholder="<?php esc_attr_e( 'Your full name', 'brickpoint' ); ?>" required>
			</div>
			<div class="bp-field">
				<label for="bp-phone"><?php esc_html_e( 'Phone Number', 'brickpoint' ); ?> <span class="bp-req">*</span></label>
				<input type="tel" id="bp-phone" name="phone" placeholder="<?php esc_attr_e( 'e.g., 03xxxxxxxxx', 'brickpoint' ); ?>">
			</div>
		</div>
		<div class="bp-field">
			<label for="bp-email"><?php esc_html_e( 'Email Address', 'brickpoint' ); ?> <span class="bp-opt">(<?php esc_html_e( 'optional', 'brickpoint' ); ?>)</span></label>
			<input type="email" id="bp-email" name="email" placeholder="your@email.com">
		</div>
		<div class="bp-field">
			<label for="bp-product"><?php esc_html_e( 'Product of Interest', 'brickpoint' ); ?> <span class="bp-opt">(<?php esc_html_e( 'optional', 'brickpoint' ); ?>)</span></label>
			<select id="bp-product" name="product">
				<option value=""><?php esc_html_e( 'Select a product...', 'brickpoint' ); ?></option>
				<?php foreach ( brickpoint_contact_products() as $opt ) : ?>
					<option value="<?php echo esc_attr( $opt ); ?>"><?php echo esc_html( $opt ); ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="bp-field">
			<label for="bp-message"><?php esc_html_e( 'Message', 'brickpoint' ); ?> <span class="bp-opt">(<?php esc_html_e( 'optional', 'brickpoint' ); ?>)</span></label>
			<textarea id="bp-message" name="message" rows="5" placeholder="<?php esc_attr_e( 'Tell us about your requirements, quantity, delivery location...', 'brickpoint' ); ?>"></textarea>
		</div>
		<button type="submit" class="bp-btn bp-btn-red" style="width:100%">
			<?php echo brickpoint_icon( 'send', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php esc_html_e( 'Send Message', 'brickpoint' ); ?>
		</button>
		<p style="font-size:12px;color:var(--bp-gray-500);text-align:center;margin:0"><?php esc_html_e( 'Prefer instant chat? Message us on WhatsApp for the fastest response.', 'brickpoint' ); ?></p>
	</form>
</div>

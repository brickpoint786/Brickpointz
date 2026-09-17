<?php
/**
 * Shared WhatsApp order modal (quantity / location / message → wa.me link).
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="bp-modal-backdrop" data-bp-modal role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Order on WhatsApp', 'brickpoint' ); ?>">
	<div class="bp-modal">
		<div class="bp-modal-head">
			<div>
				<h3><?php esc_html_e( 'Order on WhatsApp', 'brickpoint' ); ?></h3>
				<p data-bp-modal-product></p>
			</div>
			<button type="button" class="bp-modal-close" data-bp-modal-close aria-label="<?php esc_attr_e( 'Close', 'brickpoint' ); ?>">
				<?php echo brickpoint_icon( 'close', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</button>
		</div>
		<div class="bp-modal-body">
			<div class="bp-field">
				<label for="bp-qty"><?php esc_html_e( 'Quantity', 'brickpoint' ); ?> <span class="bp-opt">(<?php esc_html_e( 'optional', 'brickpoint' ); ?>)</span></label>
				<input type="text" id="bp-qty" placeholder="<?php esc_attr_e( 'e.g., 10,000 bricks / 5 bags', 'brickpoint' ); ?>">
			</div>
			<div class="bp-field">
				<label for="bp-loc"><?php esc_html_e( 'Delivery Location', 'brickpoint' ); ?> <span class="bp-opt">(<?php esc_html_e( 'optional', 'brickpoint' ); ?>)</span></label>
				<input type="text" id="bp-loc" placeholder="<?php esc_attr_e( 'e.g., DHA Lahore, Bahria Town', 'brickpoint' ); ?>">
			</div>
			<div class="bp-field">
				<label for="bp-msg"><?php esc_html_e( 'Additional Message', 'brickpoint' ); ?> <span class="bp-opt">(<?php esc_html_e( 'optional', 'brickpoint' ); ?>)</span></label>
				<textarea id="bp-msg" rows="3" placeholder="<?php esc_attr_e( 'Any specific requirements or questions...', 'brickpoint' ); ?>"></textarea>
			</div>
		</div>
		<div class="bp-modal-foot">
			<button type="button" class="bp-btn bp-btn-ghost" data-bp-modal-close><?php esc_html_e( 'Cancel', 'brickpoint' ); ?></button>
			<button type="button" class="bp-btn bp-btn-wa" data-bp-modal-send>
				<?php echo brickpoint_icon( 'whatsapp', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php esc_html_e( 'Send on WhatsApp', 'brickpoint' ); ?>
			</button>
		</div>
	</div>
</div>

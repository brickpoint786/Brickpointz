<?php
/**
 * Floating WhatsApp button + tooltip (same behavior as original site).
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="bp-wa-float">
	<div class="bp-wa-tip" data-bp-wa-tip>
		<div class="bp-wa-tip-head">
			<strong>BrickPoint</strong>
			<button data-bp-wa-dismiss aria-label="<?php esc_attr_e( 'Dismiss', 'brickpoint' ); ?>">
				<?php echo brickpoint_icon( 'close', 12 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</button>
		</div>
		<p><?php esc_html_e( 'Hi! Order bricks & materials on WhatsApp 👋', 'brickpoint' ); ?></p>
		<a href="<?php echo brickpoint_whatsapp_link(); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Chat Now', 'brickpoint' ); ?></a>
	</div>
	<button class="bp-wa-btn" data-bp-wa-toggle aria-label="WhatsApp">
		<?php echo brickpoint_icon( 'whatsapp', 28 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</button>
</div>

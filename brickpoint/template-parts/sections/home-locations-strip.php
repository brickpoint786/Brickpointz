<?php
/**
 * Homepage: locations strip.
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="bp-strip">
	<div class="bp-container bp-strip-inner">
		<div>
			<h3><?php esc_html_e( 'Find Our Locations', 'brickpoint' ); ?></h3>
			<p><?php esc_html_e( 'Visit our brick factories or contact us for delivery to your site.', 'brickpoint' ); ?></p>
		</div>
		<div class="bp-strip-btns">
			<a class="bp-btn bp-btn-white-navy" href="<?php echo esc_url( home_url( '/locations/' ) ); ?>">
				<?php echo brickpoint_icon( 'map-pin', 15 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php esc_html_e( 'View All Locations', 'brickpoint' ); ?>
			</a>
			<a class="bp-btn bp-btn-wa" href="<?php echo brickpoint_whatsapp_link(); ?>" target="_blank" rel="noopener noreferrer">
				<?php echo brickpoint_icon( 'whatsapp', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php esc_html_e( 'Contact on WhatsApp', 'brickpoint' ); ?>
			</a>
		</div>
	</div>
</section>

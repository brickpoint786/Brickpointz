<?php
/**
 * Red CTA banner (shared).
 * Args: title, sub, note, primary_label, show_call (bool).
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$title    = isset( $args['title'] ) ? $args['title'] : __( 'Ready to Start Your Project?', 'brickpoint' );
$sub      = isset( $args['sub'] ) ? $args['sub'] : __( 'Contact BrickPoint today for SS7 bricks and quality construction materials. Our sales team is ready to help.', 'brickpoint' );
$note     = isset( $args['note'] ) ? $args['note'] : sprintf(
	/* translators: 1: CEO, 2: sales manager */
	__( 'CEO: %1$s | Sales Manager: %2$s', 'brickpoint' ),
	brickpoint_get( 'ceo' ),
	brickpoint_get( 'sales_manager' )
);
$show_call = ! isset( $args['show_call'] ) || $args['show_call'];
$phone     = brickpoint_get( 'phone' );
?>
<section class="bp-cta bp-pattern-diag">
	<div class="bp-container bp-cta-box">
		<h2><?php echo esc_html( $title ); ?></h2>
		<p class="bp-cta-sub"><?php echo esc_html( $sub ); ?></p>
		<div class="bp-cta-btns">
			<a class="bp-btn bp-btn-white bp-btn-lg" href="<?php echo brickpoint_whatsapp_link(); ?>" target="_blank" rel="noopener noreferrer">
				<?php echo brickpoint_icon( 'whatsapp', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php esc_html_e( 'Order on WhatsApp', 'brickpoint' ); ?>
			</a>
			<?php if ( $show_call ) : ?>
				<a class="bp-btn bp-btn-outline-w bp-btn-lg" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>">
					<?php echo brickpoint_icon( 'phone', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php printf( esc_html__( 'Call %s', 'brickpoint' ), esc_html( $phone ) ); ?>
				</a>
			<?php endif; ?>
		</div>
		<?php if ( $note ) : ?>
			<p class="bp-cta-note"><?php echo esc_html( $note ); ?></p>
		<?php endif; ?>
	</div>
</section>

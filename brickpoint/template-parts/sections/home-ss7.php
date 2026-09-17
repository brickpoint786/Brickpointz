<?php
/**
 * Homepage: featured SS7 bricks section.
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$points = array(
	__( 'SS7 Branded Quality', 'brickpoint' ),
	__( 'Consistent Dimensions', 'brickpoint' ),
	__( 'Reliable Bulk Supply', 'brickpoint' ),
	__( 'Suitable for All Construction', 'brickpoint' ),
);
?>
<section class="bp-section bp-bg-navy bp-pattern-brick">
	<div class="bp-container">
		<div class="bp-grid-2">
			<div class="bp-ss7-visual">
				<div class="bp-ss7-img">
					<img src="<?php echo brickpoint_img( 'ss7-brick.jpg' ); ?>" alt="<?php esc_attr_e( 'SS7 Bricks - Premium Quality', 'brickpoint' ); ?>" loading="lazy">
				</div>
				<div class="bp-ss7-badge-corner"><strong>SS7</strong><small><?php esc_html_e( 'Bricks', 'brickpoint' ); ?></small></div>
				<div class="bp-ss7-float-card">
					<div class="bp-ss7-float-inner">
						<div class="bp-ss7-float-icon"><?php echo brickpoint_icon( 'star', 20 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
						<div>
							<strong><?php esc_html_e( 'Featured Brick Brand', 'brickpoint' ); ?></strong>
							<small><?php esc_html_e( 'Reliable Quality Supply', 'brickpoint' ); ?></small>
						</div>
					</div>
				</div>
			</div>

			<div>
				<span class="bp-badge bp-badge-ss7" style="margin-bottom:20px"><?php echo brickpoint_icon( 'star', 12 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Featured Brick Brand', 'brickpoint' ); ?></span>
				<h2 class="bp-h2 bp-h2-light">
					<?php esc_html_e( 'SS7 Bricks — Built for', 'brickpoint' ); ?><br>
					<span style="color:var(--bp-red)"><?php esc_html_e( 'Stronger Foundations', 'brickpoint' ); ?></span>
				</h2>
				<p class="bp-lead bp-lead-light bp-mb-4">
					<?php esc_html_e( 'Discover SS7 bricks from BrickPoint — a trusted choice for construction projects where quality, consistency, and dependable supply matter.', 'brickpoint' ); ?>
				</p>
				<p class="bp-lead bp-lead-light bp-mb-8" style="font-size:16px;color:#9ca3af">
					<?php
					printf(
						/* translators: 1: company, 2: company */
						esc_html__( 'Through %1$s and %2$s, BrickPoint ensures you receive genuine SS7 bricks with reliable availability and professional service for every project size.', 'brickpoint' ),
						'<span style="color:#fff;font-weight:500">' . esc_html( brickpoint_get( 'company_1' ) ) . '</span>',
						'<span style="color:#fff;font-weight:500">' . esc_html( brickpoint_get( 'company_2' ) ) . '</span>'
					);
					?>
				</p>
				<ul class="bp-check-list" style="color:#d1d5db">
					<?php foreach ( $points as $p ) : ?>
						<li><?php echo brickpoint_icon( 'check', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html( $p ); ?></li>
					<?php endforeach; ?>
				</ul>
				<div class="bp-btn-row">
					<a class="bp-btn bp-btn-red" href="<?php echo esc_url( home_url( '/ss7-bricks/' ) ); ?>">
						<?php esc_html_e( 'View SS7 Bricks', 'brickpoint' ); ?>
						<?php echo brickpoint_icon( 'arrow', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>
					<a class="bp-btn bp-btn-outline-wa" href="<?php echo brickpoint_whatsapp_link( __( "Assalam-o-Alaikum BrickPoint,\nI am interested in SS7 Bricks. Please share availability and pricing.", 'brickpoint' ) ); ?>" target="_blank" rel="noopener noreferrer">
						<?php echo brickpoint_icon( 'whatsapp', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php esc_html_e( 'Order on WhatsApp', 'brickpoint' ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>

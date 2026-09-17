<?php
/**
 * Homepage: brand trust / who we are.
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$features = array(
	array( 'icon' => 'shield', 'title' => __( 'Quality Focus', 'brickpoint' ), 'desc' => __( 'We source and supply materials that meet consistent quality standards, starting with our signature SS7 branded bricks.', 'brickpoint' ) ),
	array( 'icon' => 'truck', 'title' => __( 'Reliable Supply', 'brickpoint' ), 'desc' => __( 'Dependable material availability and delivery coordination for uninterrupted construction progress.', 'brickpoint' ) ),
	array( 'icon' => 'package', 'title' => __( 'Construction Expertise', 'brickpoint' ), 'desc' => __( 'Deep knowledge of construction materials allows us to help you find the right product for every application.', 'brickpoint' ) ),
	array( 'icon' => 'phone', 'title' => __( 'Customer Support', 'brickpoint' ), 'desc' => __( 'Direct WhatsApp and phone access to our team. We are available to answer your inquiries promptly.', 'brickpoint' ) ),
);
?>
<section class="bp-section bp-bg-warm">
	<div class="bp-container">
		<div class="bp-section-head">
			<p class="bp-eyebrow"><?php esc_html_e( 'Who We Are', 'brickpoint' ); ?></p>
			<h2 class="bp-h2"><?php esc_html_e( 'Quality Materials. Stronger Foundations.', 'brickpoint' ); ?></h2>
			<p class="bp-lead">
				<?php
				printf(
					/* translators: 1: company, 2: company */
					esc_html__( 'BrickPoint represents %1$s and %2$s — supplying SS7 branded bricks and construction materials to builders, contractors, developers, and homeowners.', 'brickpoint' ),
					'<strong style="color:var(--bp-navy)">' . esc_html( brickpoint_get( 'company_1' ) ) . '</strong>',
					'<strong style="color:var(--bp-navy)">' . esc_html( brickpoint_get( 'company_2' ) ) . '</strong>'
				);
				?>
			</p>
		</div>

		<div class="bp-grid-4">
			<?php foreach ( $features as $f ) : ?>
				<div class="bp-feature-card" data-bp-reveal>
					<div class="bp-feature-icon"><?php echo brickpoint_icon( $f['icon'], 28 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
					<h3><?php echo esc_html( $f['title'] ); ?></h3>
					<p><?php echo esc_html( $f['desc'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="bp-company-pills">
			<div class="bp-company-pill"><span class="bp-dot" style="background:var(--bp-red)"></span><span><?php echo esc_html( brickpoint_get( 'company_1' ) ); ?></span></div>
			<div class="bp-company-pill"><span class="bp-dot" style="background:var(--bp-navy)"></span><span><?php echo esc_html( brickpoint_get( 'company_2' ) ); ?></span></div>
		</div>
	</div>
</section>

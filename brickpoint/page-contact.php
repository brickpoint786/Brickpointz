<?php
/**
 * Template Name: BrickPoint — Contact
 * Contact page matching the original design.
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="primary" class="bp-main">
	<?php
	if ( brickpoint_is_elementor_page() ) {
		while ( have_posts() ) {
			the_post();
			the_content();
		}
	} else {
		$phone   = brickpoint_get( 'phone' );
		$socials = brickpoint_social_links();
		?>
		<section class="bp-page-hero">
			<div class="bp-page-hero-bg"><img src="<?php echo brickpoint_img( 'about-team.jpg' ); ?>" alt="<?php esc_attr_e( 'Contact BrickPoint', 'brickpoint' ); ?>"></div>
			<div class="bp-page-hero-overlay"></div>
			<div class="bp-container bp-page-hero-inner">
				<?php
				brickpoint_breadcrumb(
					array(
						array( __( 'Home', 'brickpoint' ), home_url( '/' ) ),
						array( __( 'Contact Us', 'brickpoint' ), null ),
					)
				);
				?>
				<h1><?php esc_html_e( "Let's Build Something Stronger", 'brickpoint' ); ?></h1>
				<p class="bp-hero-sub"><?php esc_html_e( 'Reach out to our team for product pricing, availability, bulk orders, and general inquiries.', 'brickpoint' ); ?></p>
			</div>
		</section>

		<section class="bp-section bp-bg-warm">
			<div class="bp-container bp-contact-grid">
				<div class="bp-contact-side">
					<div class="bp-wa-card">
						<h3><?php echo brickpoint_icon( 'whatsapp', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php esc_html_e( 'Order on WhatsApp', 'brickpoint' ); ?></h3>
						<p><?php esc_html_e( 'The fastest way to reach us. Send your order or inquiry directly on WhatsApp.', 'brickpoint' ); ?></p>
						<a class="bp-btn bp-btn-wa" style="width:100%" href="<?php echo brickpoint_whatsapp_link(); ?>" target="_blank" rel="noopener noreferrer">
							<?php echo brickpoint_icon( 'whatsapp', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<?php esc_html_e( 'Chat on WhatsApp', 'brickpoint' ); ?>
						</a>
					</div>

					<div class="bp-info-card">
						<h3><?php echo brickpoint_icon( 'phone', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php esc_html_e( 'Call Us', 'brickpoint' ); ?></h3>
						<a class="bp-big-phone" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
						<p class="bp-muted"><?php esc_html_e( 'CEO:', 'brickpoint' ); ?> <?php echo esc_html( brickpoint_get( 'ceo' ) ); ?></p>
						<p class="bp-muted"><?php esc_html_e( 'Sales:', 'brickpoint' ); ?> <?php echo esc_html( brickpoint_get( 'sales_manager' ) ); ?></p>
					</div>

					<div class="bp-info-card">
						<h3><?php echo brickpoint_icon( 'map-pin', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php esc_html_e( 'Our Locations', 'brickpoint' ); ?></h3>
						<div class="bp-loc-mini">
							<div><strong><?php esc_html_e( 'Masha Allah Bricks — Bhatta 1', 'brickpoint' ); ?></strong><p><?php esc_html_e( 'Ram Thaman', 'brickpoint' ); ?></p></div>
							<div><strong><?php esc_html_e( 'Fine Bricks Co. — Bhatta 2', 'brickpoint' ); ?></strong><p><?php esc_html_e( 'Raja Jang', 'brickpoint' ); ?></p></div>
							<div>
								<strong><?php esc_html_e( 'BrickPoint Office', 'brickpoint' ); ?></strong>
								<p><a class="bp-text-link" style="font-size:12px" href="<?php echo esc_url( home_url( '/locations/' ) ); ?>"><?php esc_html_e( 'View All Locations →', 'brickpoint' ); ?></a></p>
							</div>
						</div>
					</div>

					<div class="bp-info-card">
						<h3 style="margin-bottom:16px"><?php esc_html_e( 'Follow Us', 'brickpoint' ); ?></h3>
						<div class="bp-socials-row">
							<a class="bp-social-ghost" href="<?php echo esc_url( $socials['facebook'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><?php echo brickpoint_icon( 'facebook', 20 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
							<a class="bp-social-ghost" href="<?php echo esc_url( $socials['instagram'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><?php echo brickpoint_icon( 'instagram', 20 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
							<a class="bp-social-ghost" href="<?php echo esc_url( $socials['twitter'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="X"><?php echo brickpoint_icon( 'x', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
							<a class="bp-social-ghost" href="<?php echo esc_url( $socials['tiktok'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="TikTok"><?php echo brickpoint_icon( 'tiktok', 20 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
							<a class="bp-social-ghost" href="<?php echo esc_url( $socials['whatsapp'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"><?php echo brickpoint_icon( 'whatsapp', 20 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
						</div>
						<a class="bp-channel-btn" href="<?php echo esc_url( brickpoint_get( 'whatsapp_channel' ) ); ?>" target="_blank" rel="noopener noreferrer">
							<?php echo brickpoint_icon( 'whatsapp', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<?php esc_html_e( 'Join WhatsApp Channel', 'brickpoint' ); ?>
						</a>
					</div>
				</div>

				<div>
					<?php get_template_part( 'template-parts/content/contact-form' ); ?>
				</div>
			</div>
		</section>
		<?php
	}
	?>
</main>
<?php
get_footer();

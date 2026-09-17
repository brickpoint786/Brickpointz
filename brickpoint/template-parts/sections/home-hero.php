<?php
/**
 * Homepage: hero section.
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$phone     = brickpoint_get( 'phone' );
$video_url = brickpoint_get( 'video_url' );
$poster    = brickpoint_img( 'brick-factory.jpg' );
$shop_url  = class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/products/' );
?>
<section class="bp-hero">
	<div class="bp-hero-bg">
		<img src="<?php echo brickpoint_img( 'hero-bricks.jpg' ); ?>" alt="<?php esc_attr_e( 'BrickPoint construction bricks', 'brickpoint' ); ?>" fetchpriority="high">
	</div>
	<div class="bp-hero-gradient"></div>

	<div class="bp-container bp-hero-inner">
		<div class="bp-hero-grid">
			<div>
				<div class="bp-trust-badge"><span class="bp-pulse-dot"></span><?php esc_html_e( 'SS7 Bricks Now Available', 'brickpoint' ); ?></div>
				<h1>
					<?php esc_html_e( 'Building Strong', 'brickpoint' ); ?><br>
					<span class="bp-red"><?php esc_html_e( 'Foundations', 'brickpoint' ); ?></span> <?php esc_html_e( 'with', 'brickpoint' ); ?><br>
					<?php esc_html_e( 'Quality Materials', 'brickpoint' ); ?>
				</h1>
				<p class="bp-hero-sub">
					<?php esc_html_e( 'From SS7 bricks to essential construction materials, BrickPoint helps builders, contractors, and homeowners build with confidence.', 'brickpoint' ); ?>
				</p>
				<div class="bp-hero-btns">
					<a class="bp-btn bp-btn-red bp-btn-lg" href="<?php echo esc_url( $shop_url ? $shop_url : home_url( '/products/' ) ); ?>">
						<?php esc_html_e( 'Explore Products', 'brickpoint' ); ?>
						<?php echo brickpoint_icon( 'arrow', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>
					<a class="bp-btn bp-btn-wa bp-btn-lg" href="<?php echo brickpoint_whatsapp_link(); ?>" target="_blank" rel="noopener noreferrer">
						<?php echo brickpoint_icon( 'whatsapp', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php esc_html_e( 'Order on WhatsApp', 'brickpoint' ); ?>
					</a>
				</div>
				<div class="bp-hero-trust">
					<?php echo brickpoint_icon( 'check', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<span><?php esc_html_e( 'Quality Bricks', 'brickpoint' ); ?></span>
					<span class="bp-dot-sep">•</span>
					<?php echo brickpoint_icon( 'check', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<span><?php esc_html_e( 'Reliable Supply', 'brickpoint' ); ?></span>
					<span class="bp-dot-sep">•</span>
					<?php echo brickpoint_icon( 'check', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<span><?php esc_html_e( 'Construction Materials', 'brickpoint' ); ?></span>
				</div>
			</div>

			<div class="bp-hero-side">
				<div class="bp-hero-card">
					<div class="bp-hero-card-img">
						<img src="<?php echo brickpoint_img( 'ss7-brick.jpg' ); ?>" alt="<?php esc_attr_e( 'SS7 Bricks — Premium Quality', 'brickpoint' ); ?>" fetchpriority="high">
						<div class="bp-hero-card-shade"></div>
						<div class="bp-hero-card-body">
							<span class="bp-badge bp-badge-ss7"><?php echo brickpoint_icon( 'star', 10 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Featured Brick Brand', 'brickpoint' ); ?></span>
							<h3><?php esc_html_e( 'SS7 Bricks', 'brickpoint' ); ?></h3>
							<p><?php esc_html_e( 'Premium quality for strong construction', 'brickpoint' ); ?></p>
						</div>
					</div>
				</div>

				<div class="bp-hero-video">
					<div class="bp-hero-video-frame">
						<?php if ( $video_url ) : ?>
							<video autoplay muted loop playsinline poster="<?php echo esc_url( $poster ); ?>">
								<source src="<?php echo esc_url( $video_url ); ?>" type="video/mp4">
							</video>
						<?php else : ?>
							<img src="<?php echo esc_url( $poster ); ?>" alt="<?php esc_attr_e( 'Brick manufacturing', 'brickpoint' ); ?>" loading="lazy">
						<?php endif; ?>
						<div class="bp-hero-video-shade"></div>
						<div class="bp-play-btn" aria-hidden="true"><span class="bp-play-tri"></span></div>
						<span class="bp-hero-video-label"><?php esc_html_e( 'SS7 Brick Manufacturing', 'brickpoint' ); ?></span>
					</div>
				</div>

				<div class="bp-hero-contact">
					<div>
						<small><?php esc_html_e( 'Speak to Sales', 'brickpoint' ); ?></small>
						<strong><?php echo esc_html( $phone ); ?></strong>
						<span class="bp-role"><?php echo esc_html( brickpoint_get( 'sales_manager' ) ); ?> — <?php esc_html_e( 'Sales Manager', 'brickpoint' ); ?></span>
					</div>
					<div class="bp-hero-contact-btns">
						<a class="bp-icon-btn bp-icon-btn-navy" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>" aria-label="<?php esc_attr_e( 'Call sales', 'brickpoint' ); ?>">
							<?php echo brickpoint_icon( 'phone', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</a>
						<a class="bp-icon-btn bp-icon-btn-wa" href="<?php echo brickpoint_whatsapp_link(); ?>" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp">
							<?php echo brickpoint_icon( 'whatsapp', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="bp-hero-wave" aria-hidden="true">
		<svg viewBox="0 0 1440 60" fill="none" preserveAspectRatio="none"><path d="M0 60V30C240 0 480 60 720 30C960 0 1200 60 1440 30V60H0Z" fill="#faf8f5"/></svg>
	</div>
</section>

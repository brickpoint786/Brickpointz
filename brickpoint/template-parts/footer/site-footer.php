<?php
/**
 * Fallback site footer (matches original design). Overridden by Elementor
 * Theme Builder footer when one is assigned.
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$socials = brickpoint_social_links();
$phone   = brickpoint_get( 'phone' );
?>
<footer class="bp-footer">
	<div class="bp-footer-main">
		<div class="bp-container bp-footer-grid">
			<div class="bp-footer-brand">
				<a class="bp-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<span class="bp-logo-mark"><?php echo brickpoint_logo_svg( 'footer' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<span class="bp-logo-text">
						<span class="bp-logo-name">Brick<span>Point</span></span>
						<span class="bp-logo-tag"><?php esc_html_e( 'Construction Materials', 'brickpoint' ); ?></span>
					</span>
				</a>
				<p class="bp-footer-desc">
					<?php esc_html_e( 'BrickPoint is your trusted destination for SS7 bricks and quality construction materials. Serving builders, contractors, developers, and homeowners with reliable supply.', 'brickpoint' ); ?>
				</p>
				<div class="bp-footer-companies">
					<strong><?php esc_html_e( 'Our Companies:', 'brickpoint' ); ?></strong>
					<div>• <?php echo esc_html( brickpoint_get( 'company_1' ) ); ?></div>
					<div>• <?php echo esc_html( brickpoint_get( 'company_2' ) ); ?></div>
				</div>
				<div class="bp-socials">
					<a class="bp-social-btn" href="<?php echo esc_url( $socials['facebook'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><?php echo brickpoint_icon( 'facebook', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
					<a class="bp-social-btn" href="<?php echo esc_url( $socials['instagram'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><?php echo brickpoint_icon( 'instagram', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
					<a class="bp-social-btn" href="<?php echo esc_url( $socials['twitter'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="X / Twitter"><?php echo brickpoint_icon( 'x', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
					<a class="bp-social-btn" href="<?php echo esc_url( $socials['tiktok'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="TikTok"><?php echo brickpoint_icon( 'tiktok', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
					<a class="bp-social-btn bp-wa-social" href="<?php echo esc_url( $socials['whatsapp'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"><?php echo brickpoint_icon( 'whatsapp', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				</div>
			</div>

			<div>
				<h4><?php esc_html_e( 'Quick Links', 'brickpoint' ); ?></h4>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'menu_class'     => 'bp-footer-links',
						'container'      => false,
						'depth'          => 1,
						'fallback_cb'    => 'brickpoint_footer_links_fallback',
						'link_before'    => '<span class="bp-arrow">›</span> ',
					)
				);
				?>
			</div>

			<div>
				<h4><?php esc_html_e( 'Products', 'brickpoint' ); ?></h4>
				<?php
				if ( has_nav_menu( 'footer-products' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'footer-products',
							'menu_class'     => 'bp-footer-links',
							'container'      => false,
							'depth'          => 1,
							'link_before'    => '<span class="bp-arrow">›</span> ',
						)
					);
				} else {
					brickpoint_footer_products_fallback();
				}
				?>
			</div>

			<div>
				<h4><?php esc_html_e( 'Contact', 'brickpoint' ); ?></h4>
				<ul class="bp-footer-contact">
					<li>
						<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>">
							<?php echo brickpoint_icon( 'phone', 15 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<span>
								<span class="bp-fc-label" style="display:block"><?php esc_html_e( 'Phone / WhatsApp', 'brickpoint' ); ?></span>
								<?php echo esc_html( $phone ); ?>
							</span>
						</a>
					</li>
					<?php $email = brickpoint_get( 'email' ); ?>
					<?php if ( $email ) : ?>
					<li>
						<a href="mailto:<?php echo esc_attr( $email ); ?>">
							<?php echo brickpoint_icon( 'mail', 15 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<span>
								<span class="bp-fc-label" style="display:block"><?php esc_html_e( 'Email', 'brickpoint' ); ?></span>
								<?php echo esc_html( $email ); ?>
							</span>
						</a>
					</li>
					<?php endif; ?>
					<li>
						<div class="bp-fc-row">
							<?php echo brickpoint_icon( 'map-pin', 15 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<span>
								<span class="bp-fc-label" style="display:block"><?php esc_html_e( 'Locations', 'brickpoint' ); ?></span>
								<?php esc_html_e( 'Ram Thaman & Raja Jang', 'brickpoint' ); ?><br>
								<a class="bp-fc-small" href="<?php echo esc_url( home_url( '/locations/' ) ); ?>"><?php esc_html_e( 'View All Locations →', 'brickpoint' ); ?></a>
							</span>
						</div>
					</li>
					<li>
						<a class="bp-footer-channel" href="<?php echo esc_url( brickpoint_get( 'whatsapp_channel' ) ); ?>" target="_blank" rel="noopener noreferrer">
							<?php echo brickpoint_icon( 'whatsapp', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<?php esc_html_e( 'Join Our WhatsApp Channel', 'brickpoint' ); ?>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<div class="bp-footer-follow">
		<div class="bp-container bp-footer-follow-inner">
			<p><?php esc_html_e( 'Follow BrickPoint for the latest updates, products, construction insights, and company news.', 'brickpoint' ); ?></p>
			<div class="bp-footer-follow-links">
				<a href="<?php echo esc_url( $socials['facebook'] ); ?>" target="_blank" rel="noopener noreferrer">Facebook</a>
				<a href="<?php echo esc_url( $socials['instagram'] ); ?>" target="_blank" rel="noopener noreferrer">Instagram</a>
				<a href="<?php echo esc_url( $socials['twitter'] ); ?>" target="_blank" rel="noopener noreferrer">X / Twitter</a>
				<a href="<?php echo esc_url( $socials['tiktok'] ); ?>" target="_blank" rel="noopener noreferrer">TikTok</a>
			</div>
		</div>
	</div>

	<div class="bp-footer-copy">
		<div class="bp-container bp-footer-copy-inner">
			<p>
				<?php
				printf(
					/* translators: 1: year */
					esc_html__( '© %1$s BrickPoint. All rights reserved. | Masha Allah Bricks Company & Fine Bricks Company', 'brickpoint' ),
					esc_html( gmdate( 'Y' ) )
				);
				?>
			</p>
			<p><?php esc_html_e( 'Quality Bricks • Reliable Supply • Construction Materials', 'brickpoint' ); ?></p>
		</div>
	</div>
</footer>
<?php
/**
 * Footer quick links fallback.
 */
function brickpoint_footer_links_fallback() {
	$links = array(
		home_url( '/' )            => __( 'Home', 'brickpoint' ),
		home_url( '/about/' )      => __( 'About Us', 'brickpoint' ),
		home_url( '/ss7-bricks/' ) => __( 'SS7 Bricks', 'brickpoint' ),
		home_url( '/projects/' )   => __( 'Projects', 'brickpoint' ),
		home_url( '/locations/' )  => __( 'Locations', 'brickpoint' ),
		home_url( '/blog/' )       => __( 'Blog', 'brickpoint' ),
		home_url( '/contact/' )    => __( 'Contact Us', 'brickpoint' ),
	);
	echo '<ul class="bp-footer-links">';
	foreach ( $links as $url => $label ) {
		echo '<li><a href="' . esc_url( $url ) . '"><span class="bp-arrow">›</span> ' . esc_html( $label ) . '</a></li>';
	}
	echo '</ul>';
}

/**
 * Footer products fallback.
 */
function brickpoint_footer_products_fallback() {
	$cats = array( 'bricks', 'cement', 'crush', 'sand', 'steel', 'paints' );
	echo '<ul class="bp-footer-links">';
	foreach ( $cats as $slug ) {
		$meta = brickpoint_category_by_slug( $slug );
		if ( ! $meta ) {
			continue;
		}
		$url = function_exists( 'wc_get_page_permalink' ) && class_exists( 'WooCommerce' ) ? home_url( '/product-category/' . $slug . '/' ) : home_url( '/products/' . $slug . '/' );
		echo '<li><a href="' . esc_url( $url ) . '"><span class="bp-arrow">›</span> ' . esc_html( $meta['name'] ) . '</a></li>';
	}
	$shop = class_exists( 'WooCommerce' ) ? home_url( '/shop/' ) : home_url( '/products/' );
	echo '<li><a href="' . esc_url( $shop ) . '"><span class="bp-arrow">›</span> ' . esc_html__( 'All Products →', 'brickpoint' ) . '</a></li>';
	echo '</ul>';
}

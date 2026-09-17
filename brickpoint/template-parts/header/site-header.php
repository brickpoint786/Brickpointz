<?php
/**
 * Fallback site header (matches original design). Overridden by Elementor
 * Theme Builder header when one is assigned.
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$phone = brickpoint_get( 'phone' );
?>
<div class="bp-topbar">
	<div class="bp-container bp-topbar-inner">
		<span class="bp-topbar-companies"><?php echo esc_html( brickpoint_get( 'company_1' ) ); ?> &amp; <?php echo esc_html( brickpoint_get( 'company_2' ) ); ?></span>
		<div class="bp-topbar-links">
			<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>">
				<?php echo brickpoint_icon( 'phone', 12 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php echo esc_html( $phone ); ?>
			</a>
			<a class="bp-wa-link" href="<?php echo brickpoint_whatsapp_link(); ?>" target="_blank" rel="noopener noreferrer">
				<?php echo brickpoint_icon( 'whatsapp', 12 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php esc_html_e( 'WhatsApp', 'brickpoint' ); ?>
			</a>
		</div>
	</div>
</div>

<header class="bp-header">
	<div class="bp-container bp-header-inner">
		<a class="bp-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'BrickPoint home', 'brickpoint' ); ?>">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<span class="bp-logo-mark"><?php echo brickpoint_logo_svg( 'header' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				<span class="bp-logo-text">
					<span class="bp-logo-name">Brick<span>Point</span></span>
					<span class="bp-logo-tag"><?php esc_html_e( 'Construction Materials', 'brickpoint' ); ?></span>
				</span>
			<?php endif; ?>
		</a>

		<nav class="bp-nav" aria-label="<?php esc_attr_e( 'Primary', 'brickpoint' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'menu_class'     => 'bp-nav-list',
					'container'      => false,
					'fallback_cb'    => 'brickpoint_fallback_menu',
					'depth'          => 2,
				)
			);
			?>
		</nav>

		<div class="bp-header-cta">
			<a class="bp-btn bp-btn-wa bp-btn-sm bp-header-wa" href="<?php echo brickpoint_whatsapp_link(); ?>" target="_blank" rel="noopener noreferrer">
				<?php echo brickpoint_icon( 'whatsapp', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<span class="bp-hidden-sm"><?php esc_html_e( 'Order on WhatsApp', 'brickpoint' ); ?></span>
				<span class="bp-only-sm"><?php esc_html_e( 'WhatsApp', 'brickpoint' ); ?></span>
			</a>
			<button class="bp-menu-toggle" data-bp-menu-toggle aria-label="<?php esc_attr_e( 'Toggle menu', 'brickpoint' ); ?>" aria-expanded="false">
				<span data-icon-open><?php echo brickpoint_icon( 'menu', 22 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				<span data-icon-close style="display:none"><?php echo brickpoint_icon( 'close', 22 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
			</button>
		</div>
	</div>

	<div class="bp-mobile-menu" data-bp-mobile-menu>
		<div class="bp-mobile-inner">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'menu_class'     => '',
					'container'      => false,
					'fallback_cb'    => 'brickpoint_fallback_menu',
					'depth'          => 2,
					'items_wrap'     => '<ul>%3$s</ul>',
				)
			);
			?>
			<div class="bp-mobile-cta">
				<a class="bp-btn bp-btn-wa" href="<?php echo brickpoint_whatsapp_link(); ?>" target="_blank" rel="noopener noreferrer">
					<?php echo brickpoint_icon( 'whatsapp', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php esc_html_e( 'Order on WhatsApp', 'brickpoint' ); ?>
				</a>
				<a class="bp-btn bp-btn-navy" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>">
					<?php echo brickpoint_icon( 'phone', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php printf( esc_html__( 'Call %s', 'brickpoint' ), esc_html( $phone ) ); ?>
				</a>
			</div>
		</div>
	</div>
</header>

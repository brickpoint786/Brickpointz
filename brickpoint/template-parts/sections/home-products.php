<?php
/**
 * Homepage: products section.
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$shop_url = class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/products/' );
?>
<section class="bp-section bp-bg-neutral">
	<div class="bp-container">
		<div class="bp-section-head">
			<p class="bp-eyebrow"><?php esc_html_e( 'Our Product Range', 'brickpoint' ); ?></p>
			<h2 class="bp-h2"><?php esc_html_e( 'Explore Our Construction Materials', 'brickpoint' ); ?></h2>
			<p class="bp-lead"><?php esc_html_e( 'From SS7 bricks to complete construction solutions — everything your project needs, in one place.', 'brickpoint' ); ?></p>
		</div>

		<?php get_template_part( 'template-parts/sections/category-grid' ); ?>

		<div class="bp-center bp-mt-10">
			<a class="bp-btn bp-btn-navy" href="<?php echo esc_url( $shop_url ? $shop_url : home_url( '/products/' ) ); ?>">
				<?php esc_html_e( 'View All Products', 'brickpoint' ); ?>
				<?php echo brickpoint_icon( 'arrow', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</a>
		</div>
	</div>
</section>

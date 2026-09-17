<?php
/**
 * Product category grid (shared by homepage + products page).
 * Links resolve to WooCommerce product categories when available.
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cats = brickpoint_category_meta();
?>
<div class="bp-cat-grid">
	<?php foreach ( $cats as $cat ) : ?>
		<a class="bp-cat-card" href="<?php echo esc_url( brickpoint_cat_url( $cat['slug'] ) ); ?>">
			<div class="bp-cat-img">
				<img src="<?php echo brickpoint_img( $cat['image'] ); ?>" alt="<?php echo esc_attr( $cat['name'] ); ?>" loading="lazy">
				<div class="bp-cat-shade"></div>
				<?php if ( $cat['badge'] ) : ?>
					<span class="bp-cat-flag"><?php echo esc_html( $cat['badge'] ); ?></span>
				<?php endif; ?>
				<span class="bp-cat-emoji"><?php echo esc_html( $cat['icon'] ); ?></span>
			</div>
			<div class="bp-cat-body">
				<h3><?php echo esc_html( $cat['name'] ); ?></h3>
				<p class="bp-clamp-2"><?php echo esc_html( $cat['desc'] ); ?></p>
			</div>
		</a>
	<?php endforeach; ?>
</div>

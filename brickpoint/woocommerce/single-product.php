<?php
/**
 * WooCommerce single product (branded breadcrumb bar + default product summary).
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header( 'shop' );

global $product;
$shop_url = wc_get_page_permalink( 'shop' );
$trail    = array(
	array( __( 'Home', 'brickpoint' ), home_url( '/' ) ),
	array( __( 'Products', 'brickpoint' ), $shop_url ? $shop_url : home_url( '/products/' ) ),
);
if ( $product ) {
	$cats = wp_get_post_terms( $product->get_id(), 'product_cat' );
	if ( $cats && ! is_wp_error( $cats ) ) {
		$link = get_term_link( $cats[0] );
		$trail[] = array( $cats[0]->name, is_wp_error( $link ) ? null : $link );
	}
	$trail[] = array( $product->get_name(), null );
}
?>
<div style="background:var(--bp-navy);border-bottom:1px solid rgba(255,255,255,0.1)">
	<div class="bp-container" style="padding-top:16px;padding-bottom:16px">
		<?php brickpoint_breadcrumb( $trail ); ?>
	</div>
</div>

<?php
/**
 * Hook: woocommerce_before_main_content.
 */
do_action( 'woocommerce_before_main_content' );
?>

	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<?php wc_get_template_part( 'content', 'single-product' ); ?>
	<?php endwhile; ?>

<?php
/**
 * Hook: woocommerce_after_main_content.
 */
do_action( 'woocommerce_after_main_content' );
get_footer( 'shop' );

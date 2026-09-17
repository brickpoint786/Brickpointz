<?php
/**
 * WhatsApp order button (opens the shared order modal).
 *
 * Args: product, category, price, variant (primary|outline|small), class.
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$product  = isset( $args['product'] ) ? $args['product'] : '';
$category = isset( $args['category'] ) ? $args['category'] : '';
$price    = isset( $args['price'] ) ? $args['price'] : __( 'Price on Request', 'brickpoint' );
$variant  = isset( $args['variant'] ) ? $args['variant'] : 'primary';
$extra    = isset( $args['class'] ) ? $args['class'] : '';

$class = 'bp-btn bp-btn-wa';
if ( 'outline' === $variant ) {
	$class = 'bp-btn bp-btn-outline-wa';
} elseif ( 'small' === $variant ) {
	$class = 'bp-btn bp-btn-wa bp-btn-sm';
}
?>
<button
	type="button"
	class="<?php echo esc_attr( $class . ' ' . $extra ); ?>"
	data-bp-order
	data-product="<?php echo esc_attr( $product ); ?>"
	data-category="<?php echo esc_attr( $category ); ?>"
	data-price="<?php echo esc_attr( $price ); ?>"
>
	<?php echo brickpoint_icon( 'whatsapp', 'small' === $variant ? 14 : 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<?php echo 'small' === $variant ? esc_html__( 'Order', 'brickpoint' ) : esc_html__( 'Order on WhatsApp', 'brickpoint' ); ?>
</button>

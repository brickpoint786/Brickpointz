<?php
/**
 * WooCommerce shop archive (branded BrickPoint hero + product loop).
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header( 'shop' );
?>
<section class="bp-page-hero">
	<div class="bp-page-hero-bg" style="opacity:0.15"><img src="<?php echo brickpoint_img( 'bricks-stacked.jpg' ); ?>" alt="<?php esc_attr_e( 'Products', 'brickpoint' ); ?>"></div>
	<div class="bp-page-hero-overlay" style="background:rgba(15,31,61,0.85)"></div>
	<div class="bp-container bp-page-hero-inner">
		<?php
		brickpoint_breadcrumb(
			array(
				array( __( 'Home', 'brickpoint' ), home_url( '/' ) ),
				array( __( 'Products', 'brickpoint' ), null ),
			)
		);
		?>
		<h1><?php woocommerce_page_title(); ?></h1>
		<?php $desc = wc_format_content( get_the_archive_description() ); ?>
		<p class="bp-hero-sub"><?php echo $desc ? wp_kses_post( $desc ) : esc_html__( 'From SS7 bricks to complete construction solutions — quality materials for every project stage.', 'brickpoint' ); ?></p>
	</div>
</section>

<?php
/**
 * Hook: woocommerce_before_main_content.
 */
do_action( 'woocommerce_before_main_content' );
?>
	<?php
	if ( woocommerce_product_loop() ) {
		/**
		 * Hook: woocommerce_before_shop_loop.
		 */
		do_action( 'woocommerce_before_shop_loop' );

		woocommerce_product_loop_start();
		if ( wc_get_loop_prop( 'total' ) ) {
			while ( have_posts() ) {
				the_post();
				/**
				 * Hook: woocommerce_shop_loop.
				 */
				do_action( 'woocommerce_shop_loop' );
				wc_get_template_part( 'content', 'product' );
			}
		}
		woocommerce_product_loop_end();

		/**
		 * Hook: woocommerce_after_shop_loop.
		 */
		do_action( 'woocommerce_after_shop_loop' );
	} else {
		/**
		 * Hook: woocommerce_no_products_found.
		 */
		do_action( 'woocommerce_no_products_found' );
	}
	?>
<?php
/**
 * Hook: woocommerce_after_main_content.
 */
do_action( 'woocommerce_after_main_content' );
get_footer( 'shop' );

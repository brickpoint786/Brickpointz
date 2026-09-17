<?php
/**
 * WooCommerce product category archive (mirrors original /products/{category}).
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header( 'shop' );

$term = get_queried_object();
$slug = $term ? $term->slug : '';
$meta = brickpoint_category_by_slug( $slug );
$icon = $meta ? $meta['icon'] : '📦';
$badge = $meta ? $meta['badge'] : '';
$hero_img = $meta ? brickpoint_img( $meta['image'] ) : brickpoint_img( 'hero-bricks.jpg' );
$is_bricks = 'bricks' === $slug;
$shop_url  = wc_get_page_permalink( 'shop' );
?>
<section class="bp-page-hero">
	<div class="bp-page-hero-bg"><img src="<?php echo esc_url( $hero_img ); ?>" alt="<?php echo esc_attr( single_term_title( '', false ) ); ?>"></div>
	<div class="bp-page-hero-overlay bp-page-hero-gradient"></div>
	<div class="bp-container bp-page-hero-inner">
		<?php
		brickpoint_breadcrumb(
			array(
				array( __( 'Home', 'brickpoint' ), home_url( '/' ) ),
				array( __( 'Products', 'brickpoint' ), $shop_url ? $shop_url : home_url( '/products/' ) ),
				array( single_term_title( '', false ), null ),
			)
		);
		?>
		<div style="display:flex;align-items:flex-start;gap:16px">
			<span style="font-size:36px;line-height:1"><?php echo esc_html( $icon ); ?></span>
			<div>
				<?php if ( $badge ) : ?>
					<span class="bp-badge bp-badge-ss7" style="margin-bottom:12px"><?php echo brickpoint_icon( 'star', 10 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php echo esc_html( $badge ); ?></span>
				<?php endif; ?>
				<h1><?php echo esc_html( single_term_title( '', false ) ); ?></h1>
				<?php $desc = wc_format_content( term_description() ); ?>
				<?php if ( $desc ) : ?>
					<div class="bp-hero-sub"><?php echo wp_kses_post( $desc ); ?></div>
				<?php elseif ( $meta ) : ?>
					<p class="bp-hero-sub"><?php echo esc_html( $meta['desc'] ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<?php if ( $is_bricks ) : ?>
	<section class="bp-ss7-strip">
		<div class="bp-container bp-ss7-strip-inner">
			<div class="bp-ss7-strip-info">
				<div class="bp-ss7-strip-logo"><strong>SS7</strong></div>
				<div>
					<h2><?php esc_html_e( 'SS7 Bricks — Featured Brand', 'brickpoint' ); ?></h2>
					<p><?php esc_html_e( 'Premium quality SS7 branded bricks from Masha Allah Bricks Co. & Fine Bricks Co.', 'brickpoint' ); ?></p>
				</div>
			</div>
			<div class="bp-ss7-strip-btns">
				<a class="bp-btn bp-btn-white bp-btn-sm" href="<?php echo esc_url( home_url( '/ss7-bricks/' ) ); ?>">
					<?php esc_html_e( 'SS7 Details', 'brickpoint' ); ?>
					<?php echo brickpoint_icon( 'arrow', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</a>
				<a class="bp-btn bp-btn-wa bp-btn-sm" href="<?php echo brickpoint_whatsapp_link( __( "Assalam-o-Alaikum BrickPoint,\nI am interested in SS7 Bricks. Please share availability and pricing.", 'brickpoint' ) ); ?>" target="_blank" rel="noopener noreferrer">
					<?php esc_html_e( 'Order SS7 Bricks', 'brickpoint' ); ?>
				</a>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php
/**
 * Hook: woocommerce_before_main_content.
 */
do_action( 'woocommerce_before_main_content' );
?>
	<h2 class="bp-mb-8" style="font-size:24px;font-weight:700;color:var(--bp-navy)">
		<?php
		/* translators: %s category */
		printf( esc_html__( 'Available %s', 'brickpoint' ), esc_html( single_term_title( '', false ) ) );
		?>
	</h2>
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

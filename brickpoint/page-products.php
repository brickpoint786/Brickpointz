<?php
/**
 * Template Name: BrickPoint — Products
 * Products overview page (category directory). When WooCommerce is active,
 * categories link to product-category archives.
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
		$cats     = brickpoint_category_meta();
		$featured = array_values( array_filter( $cats, function ( $c ) { return ! empty( $c['badge'] ); } ) );
		$rest     = array_values( array_filter( $cats, function ( $c ) { return empty( $c['badge'] ); } ) );
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
				<h1><?php esc_html_e( 'Our Construction Materials', 'brickpoint' ); ?></h1>
				<p class="bp-hero-sub"><?php esc_html_e( 'From SS7 bricks to complete construction solutions — quality materials for every project stage.', 'brickpoint' ); ?></p>
			</div>
		</section>

		<?php if ( $featured ) : ?>
			<section class="bp-section bp-bg-warm" style="padding-top:48px;padding-bottom:48px">
				<div class="bp-container">
					<h2 class="bp-mb-4" style="font-size:20px;font-weight:700;color:var(--bp-navy);display:flex;align-items:center;gap:8px">
						<?php echo brickpoint_icon( 'star', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php esc_html_e( 'Featured Category', 'brickpoint' ); ?>
					</h2>
					<?php foreach ( $featured as $cat ) : ?>
						<a class="bp-featured-cat" href="<?php echo esc_url( brickpoint_cat_url( $cat['slug'] ) ); ?>">
							<div class="bp-featured-cat-img"><img src="<?php echo brickpoint_img( $cat['image'] ); ?>" alt="<?php echo esc_attr( $cat['name'] ); ?>" loading="lazy"></div>
							<div class="bp-featured-cat-body">
								<span class="bp-badge bp-badge-ss7" style="width:fit-content"><?php echo brickpoint_icon( 'star', 10 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php echo esc_html( $cat['badge'] ); ?></span>
								<h3><?php echo esc_html( $cat['name'] ); ?></h3>
								<p><?php echo esc_html( $cat['desc'] ); ?></p>
								<span class="bp-btn bp-btn-red" style="width:fit-content">
									<?php printf( esc_html__( 'View %s', 'brickpoint' ), esc_html( $cat['name'] ) ); ?>
									<?php echo brickpoint_icon( 'arrow', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</span>
							</div>
						</a>
					<?php endforeach; ?>
				</div>
			</section>
		<?php endif; ?>

		<section class="bp-section bp-bg-neutral" style="padding-top:48px;padding-bottom:48px">
			<div class="bp-container">
				<h2 class="bp-mb-4" style="font-size:20px;font-weight:700;color:var(--bp-navy)"><?php esc_html_e( 'All Product Categories', 'brickpoint' ); ?></h2>
				<div class="bp-cat-grid">
					<?php foreach ( $rest as $cat ) : ?>
						<a class="bp-cat-card" href="<?php echo esc_url( brickpoint_cat_url( $cat['slug'] ) ); ?>">
							<div class="bp-cat-img tall">
								<img src="<?php echo brickpoint_img( $cat['image'] ); ?>" alt="<?php echo esc_attr( $cat['name'] ); ?>" loading="lazy">
								<div class="bp-cat-shade"></div>
								<span class="bp-cat-emoji"><?php echo esc_html( $cat['icon'] ); ?></span>
							</div>
							<div class="bp-cat-body">
								<h3><?php echo esc_html( $cat['name'] ); ?></h3>
								<span class="bp-cat-view"><?php esc_html_e( 'View', 'brickpoint' ); ?> <?php echo brickpoint_icon( 'arrow', 10 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
							</div>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="bp-section-sm bp-bg-navy">
			<div class="bp-container bp-cta-box">
				<h2 style="font-size:30px;font-weight:700;color:#fff;margin:0 0 16px"><?php esc_html_e( "Can't Find What You're Looking For?", 'brickpoint' ); ?></h2>
				<p class="bp-lead bp-lead-light bp-mb-8"><?php esc_html_e( 'Contact us on WhatsApp with your specific requirements. We will help you source the right materials.', 'brickpoint' ); ?></p>
				<a class="bp-btn bp-btn-wa bp-btn-lg" href="<?php echo brickpoint_whatsapp_link( __( "Assalam-o-Alaikum BrickPoint,\nI need help finding a specific construction material. Please assist.", 'brickpoint' ) ); ?>" target="_blank" rel="noopener noreferrer">
					<?php echo brickpoint_icon( 'whatsapp', 20 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php esc_html_e( 'Inquire on WhatsApp', 'brickpoint' ); ?>
				</a>
			</div>
		</section>
		<?php
	}
	?>
</main>
<?php
get_footer();

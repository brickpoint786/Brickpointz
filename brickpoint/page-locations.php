<?php
/**
 * Template Name: BrickPoint — Locations
 * Locations page (dynamic from Locations CPT).
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
		$factories = brickpoint_get_locations( 'factory' );
		$offices   = brickpoint_get_locations( 'office' );
		$all       = brickpoint_get_locations();
		$phone     = brickpoint_get( 'phone' );

		// Fallback to original static data when CPT is empty (fresh install).
		if ( ! $all ) {
			$fallback = array(
				array( 'name' => 'Masha Allah Bricks Company — Bhatta 1', 'company' => 'Masha Allah Bricks Company', 'area' => 'Ram Thaman', 'link' => 'https://maps.app.goo.gl/6Pi5BNTsxPRkn1cn7?g_st=awb', 'type' => 'factory' ),
				array( 'name' => 'Masha Allah Bricks Company — Bhatta 3', 'company' => 'Masha Allah Bricks Company', 'area' => '', 'link' => 'https://google.com/maps?q=31.2328,74.3169424&z=17&hl=en', 'type' => 'factory' ),
				array( 'name' => 'Fine Bricks Company — Bhatta 2', 'company' => 'Fine Bricks Company', 'area' => 'Raja Jang', 'link' => 'https://maps.app.goo.gl/SDaxqVM55qXt66wW8?g_st=awb', 'type' => 'factory' ),
				array( 'name' => 'BrickPoint Office', 'company' => 'BrickPoint', 'area' => '', 'link' => 'https://maps.app.goo.gl/GACXw15YxyV4bK5t8?g_st=awb', 'type' => 'office' ),
			);
			$factories = array_values( array_filter( $fallback, function ( $l ) { return 'factory' === $l['type']; } ) );
			$offices   = array_values( array_filter( $fallback, function ( $l ) { return 'office' === $l['type']; } ) );
			$all       = $fallback;
			$is_array  = true;
		} else {
			$is_array = false;
		}
		?>
		<section class="bp-page-hero">
			<div class="bp-page-hero-bg"><img src="<?php echo brickpoint_img( 'brick-factory.jpg' ); ?>" alt="<?php esc_attr_e( 'Our Locations', 'brickpoint' ); ?>"></div>
			<div class="bp-page-hero-overlay"></div>
			<div class="bp-container bp-page-hero-inner">
				<?php
				brickpoint_breadcrumb(
					array(
						array( __( 'Home', 'brickpoint' ), home_url( '/' ) ),
						array( __( 'Locations', 'brickpoint' ), null ),
					)
				);
				?>
				<h1><?php esc_html_e( 'Find Us', 'brickpoint' ); ?></h1>
				<p class="bp-hero-sub"><?php esc_html_e( 'Visit our brick factories or contact us for delivery to your construction site. Multiple locations for your convenience.', 'brickpoint' ); ?></p>
			</div>
		</section>

		<section class="bp-section bp-bg-warm">
			<div class="bp-container">
				<div class="bp-mb-12">
					<p class="bp-eyebrow"><?php esc_html_e( 'Manufacturing Facilities', 'brickpoint' ); ?></p>
					<h2 class="bp-h2"><?php esc_html_e( 'Our Brick Factory Locations', 'brickpoint' ); ?></h2>
					<p class="bp-lead"><?php esc_html_e( 'BrickPoint operates three brick manufacturing facilities (bhattas) producing SS7 bricks and quality construction materials.', 'brickpoint' ); ?></p>
				</div>
				<div class="bp-grid-3">
					<?php
					foreach ( $factories as $loc ) :
						if ( $is_array ) {
							$name = $loc['name']; $company = $loc['company']; $area = $loc['area']; $link = $loc['link'];
						} else {
							$name = $loc->post_title; $company = get_post_meta( $loc->ID, '_bp_company', true ); $area = get_post_meta( $loc->ID, '_bp_area', true ); $link = get_post_meta( $loc->ID, '_bp_maps_link', true );
						}
						?>
						<div class="bp-loc-card">
							<div class="bp-loc-map">
								<img class="bg" src="<?php echo brickpoint_img( 'brick-factory.jpg' ); ?>" alt="" loading="lazy">
								<div class="bp-loc-pin-wrap">
									<div class="bp-loc-pin"><?php echo brickpoint_icon( 'map-pin', 28 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
									<p><?php echo $area ? esc_html( $area ) : esc_html__( 'View on Map', 'brickpoint' ); ?></p>
								</div>
								<span class="bp-badge bp-badge-ss7 bp-card-flag-tl" style="border-radius:4px"><?php esc_html_e( 'Brick Factory', 'brickpoint' ); ?></span>
							</div>
							<div class="bp-loc-body">
								<div class="bp-loc-head">
									<div class="bp-loc-icon"><?php echo brickpoint_icon( 'building', 20 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
									<div><h3><?php echo esc_html( $name ); ?></h3><small><?php echo esc_html( $company ); ?></small></div>
								</div>
								<?php if ( $area ) : ?>
									<div class="bp-loc-area"><?php echo brickpoint_icon( 'map-pin', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php echo esc_html( $area ); ?></span></div>
								<?php endif; ?>
								<div class="bp-loc-actions">
									<a class="bp-btn bp-btn-navy" href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener noreferrer">
										<?php echo brickpoint_icon( 'navigation', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
										<?php esc_html_e( 'Get Directions', 'brickpoint' ); ?>
									</a>
									<a class="bp-btn bp-btn-outline-navy bp-icon-only" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>" aria-label="<?php esc_attr_e( 'Call', 'brickpoint' ); ?>">
										<?php echo brickpoint_icon( 'phone', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									</a>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="bp-section bp-bg-neutral" style="padding-top:56px;padding-bottom:56px">
			<div class="bp-container">
				<div class="bp-mb-8">
					<p class="bp-eyebrow"><?php esc_html_e( 'Main Office', 'brickpoint' ); ?></p>
					<h2 class="bp-h2" style="font-size:30px"><?php esc_html_e( 'BrickPoint Office', 'brickpoint' ); ?></h2>
				</div>
				<div class="bp-office-grid">
					<?php
					foreach ( $offices as $office ) :
						if ( $is_array ) {
							$name = $office['name']; $link = $office['link'];
						} else {
							$name = $office->post_title; $link = get_post_meta( $office->ID, '_bp_maps_link', true );
						}
						?>
						<div class="bp-office-card">
							<div class="bp-office-visual">
								<div class="bp-loc-pin-wrap">
									<div class="bp-loc-pin"><?php echo brickpoint_icon( 'building', 32 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
									<p><?php esc_html_e( 'BrickPoint Office', 'brickpoint' ); ?></p>
								</div>
							</div>
							<div class="bp-office-body">
								<h3><?php echo esc_html( $name ); ?></h3>
								<p><?php esc_html_e( 'Main office for BrickPoint — handling sales, inquiries, and customer support.', 'brickpoint' ); ?></p>
								<div class="bp-contact-row">
									<?php echo brickpoint_icon( 'phone', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									<div>
										<small><?php esc_html_e( 'Phone / WhatsApp', 'brickpoint' ); ?></small>
										<a class="tel" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
									</div>
								</div>
								<a class="bp-btn bp-btn-navy" href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener noreferrer">
									<?php echo brickpoint_icon( 'navigation', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									<?php esc_html_e( 'Get Directions', 'brickpoint' ); ?>
									<?php echo brickpoint_icon( 'external', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</a>
							</div>
						</div>
					<?php endforeach; ?>

					<div class="bp-help-card">
						<h3><?php esc_html_e( 'Need Help Finding Us?', 'brickpoint' ); ?></h3>
						<p><?php esc_html_e( 'Contact our sales team on WhatsApp or phone for directions and delivery arrangements.', 'brickpoint' ); ?></p>
						<div class="bp-help-meta">
							<div><small><?php esc_html_e( 'CEO', 'brickpoint' ); ?></small><strong><?php echo esc_html( brickpoint_get( 'ceo' ) ); ?></strong></div>
							<div><small><?php esc_html_e( 'Sales Manager', 'brickpoint' ); ?></small><strong><?php echo esc_html( brickpoint_get( 'sales_manager' ) ); ?></strong></div>
							<div><small><?php esc_html_e( 'Phone / WhatsApp', 'brickpoint' ); ?></small><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></div>
						</div>
						<div class="bp-help-btns">
							<a class="bp-btn bp-btn-wa" href="<?php echo brickpoint_whatsapp_link(); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'WhatsApp Us', 'brickpoint' ); ?></a>
							<a class="bp-btn bp-btn-outline-w" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>">
								<?php echo brickpoint_icon( 'phone', 15 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<?php esc_html_e( 'Call Now', 'brickpoint' ); ?>
							</a>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="bp-section bp-bg-warm" style="padding-top:56px;padding-bottom:56px">
			<div class="bp-container">
				<div class="bp-center bp-mb-8">
					<h2 style="font-size:24px;font-weight:700;color:var(--bp-navy);margin:0"><?php esc_html_e( 'All Locations at a Glance', 'brickpoint' ); ?></h2>
				</div>
				<div class="bp-glance-grid">
					<?php
					foreach ( $all as $loc ) :
						if ( $is_array ) {
							$name = $loc['name']; $area = $loc['area']; $link = $loc['link']; $type = $loc['type'];
						} else {
							$name = $loc->post_title; $area = get_post_meta( $loc->ID, '_bp_area', true ); $link = get_post_meta( $loc->ID, '_bp_maps_link', true ); $type = get_post_meta( $loc->ID, '_bp_type', true );
						}
						?>
						<a class="bp-glance-card" href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener noreferrer">
							<div class="bp-glance-tag">
								<?php echo brickpoint_icon( 'map-pin', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<span><?php echo 'office' === $type ? esc_html__( 'Office', 'brickpoint' ) : esc_html__( 'Factory', 'brickpoint' ); ?></span>
							</div>
							<h3><?php echo esc_html( $name ); ?></h3>
							<?php if ( $area ) : ?>
								<p><?php echo esc_html( $area ); ?></p>
							<?php endif; ?>
							<div class="bp-glance-link"><?php esc_html_e( 'Open in Maps', 'brickpoint' ); ?> <?php echo brickpoint_icon( 'external', 10 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<?php
	}
	?>
</main>
<?php
get_footer();

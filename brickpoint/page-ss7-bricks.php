<?php
/**
 * Template Name: BrickPoint — SS7 Bricks
 * SS7 Bricks page matching the original design.
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
		$faqs = array(
			array(
				'q' => __( 'What are SS7 bricks?', 'brickpoint' ),
				'a' => __( 'SS7 bricks are a branded variety of red clay construction bricks available through BrickPoint via Masha Allah Bricks Company and Fine Bricks Company. They are recognized for consistent quality and reliable availability.', 'brickpoint' ),
			),
			array(
				'q' => __( 'Where can I order SS7 bricks?', 'brickpoint' ),
				'a' => sprintf(
					/* translators: %s phone */
					__( 'You can order SS7 bricks directly through WhatsApp at %s, by calling the same number, or by visiting our factory locations at Ram Thaman (Bhatta 1 & 3) and Raja Jang (Bhatta 2).', 'brickpoint' ),
					brickpoint_get( 'phone' )
				),
			),
			array(
				'q' => __( 'Do you supply SS7 bricks in bulk?', 'brickpoint' ),
				'a' => __( 'Yes, we supply SS7 bricks in bulk quantities for residential, commercial, and development projects. Contact us on WhatsApp with your quantity requirements for a quotation.', 'brickpoint' ),
			),
			array(
				'q' => __( 'What is the price of SS7 bricks?', 'brickpoint' ),
				'a' => __( 'Brick prices can vary based on quantity, location, and market conditions. Contact us on WhatsApp or by phone for the latest pricing and availability.', 'brickpoint' ),
			),
			array(
				'q' => __( 'Do you deliver to construction sites?', 'brickpoint' ),
				'a' => __( 'Please contact us directly on WhatsApp or by phone to discuss delivery arrangements and logistics for your project location.', 'brickpoint' ),
			),
			array(
				'q' => __( 'What other products does BrickPoint supply?', 'brickpoint' ),
				'a' => __( 'In addition to SS7 bricks, BrickPoint supplies a wide range of construction materials including cement, steel, sand, crush, electric pipes, plumbing fittings, construction chemicals, paints, lights, and more.', 'brickpoint' ),
			),
		);
		$phone = brickpoint_get( 'phone' );
		$ss7_msg = __( "Assalam-o-Alaikum BrickPoint,\nI am interested in SS7 Bricks. Please share the latest price and availability.", 'brickpoint' );
		?>
		<section class="bp-page-hero" style="min-height:70vh;display:flex;align-items:center">
			<div class="bp-page-hero-bg" style="opacity:0.2"><img src="<?php echo brickpoint_img( 'bricks-stacked.jpg' ); ?>" alt="<?php esc_attr_e( 'SS7 Bricks', 'brickpoint' ); ?>"></div>
			<div class="bp-page-hero-overlay" style="background:linear-gradient(to right, var(--bp-navy), rgba(15,31,61,0.9), rgba(15,31,61,0.5))"></div>
			<div class="bp-container bp-page-hero-inner" style="width:100%">
				<?php
				brickpoint_breadcrumb(
					array(
						array( __( 'Home', 'brickpoint' ), home_url( '/' ) ),
						array( __( 'SS7 Bricks', 'brickpoint' ), null ),
					)
				);
				?>
				<div class="bp-grid-2">
					<div>
						<span class="bp-badge bp-badge-ss7" style="margin-bottom:24px"><?php echo brickpoint_icon( 'star', 12 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Featured Brick Brand — BrickPoint', 'brickpoint' ); ?></span>
						<h1 style="font-size:clamp(36px,5vw,60px)">
							<?php esc_html_e( 'SS7 Bricks', 'brickpoint' ); ?><br>
							<span style="color:var(--bp-red)"><?php esc_html_e( 'Trusted Quality', 'brickpoint' ); ?></span><br>
							<?php esc_html_e( 'for Construction', 'brickpoint' ); ?>
						</h1>
						<p class="bp-hero-sub bp-mb-8"><?php esc_html_e( 'Discover SS7 bricks from BrickPoint — a recognized choice for construction projects where quality, consistency, and dependable supply matter.', 'brickpoint' ); ?></p>
						<div class="bp-btn-row bp-mb-8">
							<?php
							get_template_part(
								'template-parts/content/whatsapp-order',
								null,
								array( 'product' => 'SS7 Bricks', 'category' => __( 'Bricks', 'brickpoint' ), 'price' => __( 'Price on Request', 'brickpoint' ) )
							);
							?>
							<a class="bp-btn bp-btn-outline-w" href="<?php echo esc_url( function_exists( 'brickpoint_cat_url' ) ? brickpoint_cat_url( 'bricks' ) : home_url( '/products/bricks/' ) ); ?>">
								<?php esc_html_e( 'View All Bricks', 'brickpoint' ); ?>
								<?php echo brickpoint_icon( 'arrow', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</a>
						</div>
						<ul class="bp-check-list" style="color:#d1d5db;margin-bottom:0">
							<?php
							foreach ( array( __( 'SS7 Branded Quality', 'brickpoint' ), __( 'Consistent Supply', 'brickpoint' ), __( 'Bulk Orders Welcome', 'brickpoint' ), __( 'Multiple Locations', 'brickpoint' ) ) as $f ) :
								?>
								<li><?php echo brickpoint_icon( 'check', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html( $f ); ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
					<div class="bp-ss7-visual">
						<div class="bp-ss7-img"><img src="<?php echo brickpoint_img( 'ss7-brick.jpg' ); ?>" alt="<?php esc_attr_e( 'SS7 Brick — Premium Quality', 'brickpoint' ); ?>" style="height:384px" loading="lazy"></div>
						<div class="bp-ss7-badge-corner" style="top:-20px;right:-20px;padding:20px"><strong style="font-size:30px">SS7</strong><small><?php esc_html_e( 'Bricks', 'brickpoint' ); ?></small></div>
						<div class="bp-ss7-float-card" style="bottom:-20px;left:-20px">
							<div class="bp-ss7-float-inner">
								<div class="bp-ss7-float-icon"><?php echo brickpoint_icon( 'star', 20 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
								<div><strong><?php esc_html_e( 'Premium Brand', 'brickpoint' ); ?></strong><small><?php esc_html_e( 'via BrickPoint', 'brickpoint' ); ?></small></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="bp-section bp-bg-warm">
			<div class="bp-container bp-grid-2">
				<div>
					<p class="bp-eyebrow"><?php esc_html_e( 'About SS7 Bricks', 'brickpoint' ); ?></p>
					<h2 class="bp-h2"><?php esc_html_e( 'A Trusted Choice for', 'brickpoint' ); ?><br><?php esc_html_e( 'Strong Construction', 'brickpoint' ); ?></h2>
					<div class="bp-prose">
						<p>
							<?php
							printf(
								/* translators: 1: company, 2: company */
								esc_html__( 'SS7 bricks are available through BrickPoint, representing two established brick manufacturing companies in Pakistan — %1$s and %2$s.', 'brickpoint' ),
								'<strong>' . esc_html( brickpoint_get( 'company_1' ) ) . '</strong>',
								'<strong>' . esc_html( brickpoint_get( 'company_2' ) ) . '</strong>'
							);
							?>
						</p>
						<p><?php esc_html_e( 'The SS7 mark represents a commitment to consistent dimensions, quality clay, and reliable supply — making them a preferred choice among builders, contractors, and construction companies who need dependable materials.', 'brickpoint' ); ?></p>
						<p><?php esc_html_e( 'Whether you are building a residential home, commercial structure, boundary wall, or any other masonry project, SS7 bricks from BrickPoint offer consistent quality and dependable availability.', 'brickpoint' ); ?></p>
					</div>
				</div>
				<div class="bp-ss7-visual">
					<img class="bp-rounded-img" src="<?php echo brickpoint_img( 'brick-factory.jpg' ); ?>" alt="<?php esc_attr_e( 'Brick manufacturing', 'brickpoint' ); ?>" loading="lazy">
				</div>
			</div>
		</section>

		<section class="bp-section bp-bg-neutral">
			<div class="bp-container">
				<div class="bp-section-head">
					<h2 class="bp-h2"><?php esc_html_e( 'SS7 Brick Details', 'brickpoint' ); ?></h2>
					<p class="bp-lead"><?php esc_html_e( 'Everything you need to know about ordering SS7 bricks from BrickPoint.', 'brickpoint' ); ?></p>
				</div>
				<div class="bp-detail-layout">
					<div class="bp-detail-card">
						<div class="bp-detail-hero">
							<img src="<?php echo brickpoint_img( 'ss7-brick.jpg' ); ?>" alt="<?php esc_attr_e( 'SS7 Bricks', 'brickpoint' ); ?>" loading="lazy">
							<span class="bp-flag"><?php echo brickpoint_icon( 'star', 12 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'SS7 Brand', 'brickpoint' ); ?></span>
						</div>
						<div class="bp-detail-body">
							<h3><?php esc_html_e( 'SS7 Bricks — Standard', 'brickpoint' ); ?></h3>
							<p style="color:var(--bp-gray-600);line-height:1.7" class="bp-mb-4"><?php esc_html_e( 'Premium SS7 branded standard bricks for residential and commercial construction. Manufactured under strict quality control with excellent dimensional consistency for walls, foundations, and structural applications.', 'brickpoint' ); ?></p>
							<ul class="bp-check-list" style="color:var(--bp-gray-700);grid-template-columns:1fr 1fr">
								<?php
								foreach ( array( __( 'SS7 Branded Quality', 'brickpoint' ), __( 'Consistent Dimensions', 'brickpoint' ), __( 'Suitable for Load-Bearing Walls', 'brickpoint' ), __( 'Available in Bulk Orders', 'brickpoint' ), __( 'Reliable Supply Chain', 'brickpoint' ), __( 'Multiple Factory Locations', 'brickpoint' ) ) as $f ) :
									?>
									<li><?php echo brickpoint_icon( 'check', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html( $f ); ?></li>
								<?php endforeach; ?>
							</ul>
							<div class="bp-btn-row">
								<?php
								get_template_part(
									'template-parts/content/whatsapp-order',
									null,
									array( 'product' => 'SS7 Bricks', 'category' => __( 'Bricks', 'brickpoint' ), 'price' => __( 'Price on Request', 'brickpoint' ), 'class' => 'bp-woo-whatsapp' )
								);
								?>
								<a class="bp-btn bp-btn-navy" style="flex:1" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>">
									<?php echo brickpoint_icon( 'phone', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									<?php esc_html_e( 'Call to Order', 'brickpoint' ); ?>
								</a>
							</div>
						</div>
					</div>

					<div class="bp-side-stack">
						<div class="bp-side-card">
							<h3><?php esc_html_e( 'Product Information', 'brickpoint' ); ?></h3>
							<?php
							foreach ( array(
								__( 'Brand', 'brickpoint' )        => 'SS7',
								__( 'Type', 'brickpoint' )         => __( 'Standard Clay Brick', 'brickpoint' ),
								__( 'Product Code', 'brickpoint' ) => 'SS7-STD',
								__( 'Supplier', 'brickpoint' )     => 'BrickPoint',
								__( 'Companies', 'brickpoint' )    => __( 'Masha Allah / Fine Bricks Co.', 'brickpoint' ),
								__( 'Availability', 'brickpoint' ) => __( 'Available', 'brickpoint' ),
								__( 'Order Unit', 'brickpoint' )   => __( 'Per 1,000 Bricks', 'brickpoint' ),
							) as $k => $v ) :
								?>
								<div class="bp-kv"><span><?php echo esc_html( $k ); ?></span><span><?php echo esc_html( $v ); ?></span></div>
							<?php endforeach; ?>
						</div>
						<div class="bp-side-card bp-dark">
							<h3><?php esc_html_e( 'Quick Order', 'brickpoint' ); ?></h3>
							<a class="bp-btn bp-btn-wa" style="width:100%;margin-bottom:12px" href="<?php echo brickpoint_whatsapp_link( $ss7_msg ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Order on WhatsApp', 'brickpoint' ); ?></a>
							<a class="bp-btn bp-btn-outline-w" style="width:100%" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>">
								<?php echo brickpoint_icon( 'phone', 15 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<?php echo esc_html( $phone ); ?>
							</a>
							<p style="color:var(--bp-gray-400);font-size:12px;margin:16px 0 0;text-align:center"><?php esc_html_e( 'Sales Manager:', 'brickpoint' ); ?> <?php echo esc_html( brickpoint_get( 'sales_manager' ) ); ?></p>
						</div>
						<div class="bp-side-card">
							<h3><?php esc_html_e( 'Factory Locations', 'brickpoint' ); ?></h3>
							<div style="font-size:14px;color:var(--bp-gray-600);display:flex;flex-direction:column;gap:8px">
								<div><strong style="color:var(--bp-navy)"><?php esc_html_e( 'Bhatta 1 & 3', 'brickpoint' ); ?></strong> — <?php esc_html_e( 'Ram Thaman', 'brickpoint' ); ?><br><small style="color:var(--bp-gray-400)"><?php echo esc_html( brickpoint_get( 'company_1' ) ); ?></small></div>
								<div><strong style="color:var(--bp-navy)"><?php esc_html_e( 'Bhatta 2', 'brickpoint' ); ?></strong> — <?php esc_html_e( 'Raja Jang', 'brickpoint' ); ?><br><small style="color:var(--bp-gray-400)"><?php echo esc_html( brickpoint_get( 'company_2' ) ); ?></small></div>
							</div>
							<a class="bp-text-link" style="font-size:12px;margin-top:12px" href="<?php echo esc_url( home_url( '/locations/' ) ); ?>"><?php esc_html_e( 'View All Locations', 'brickpoint' ); ?> <?php echo brickpoint_icon( 'arrow', 10 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="bp-section bp-bg-warm" style="padding-top:64px;padding-bottom:64px">
			<div class="bp-container">
				<h2 class="bp-mb-4" style="font-size:24px;font-weight:700;color:var(--bp-navy)"><?php esc_html_e( 'SS7 Bricks Gallery', 'brickpoint' ); ?></h2>
				<div class="bp-gallery-grid">
					<?php foreach ( array( 'ss7-brick.jpg', 'bricks-stacked.jpg', 'brick-factory.jpg', 'construction-project.jpg' ) as $i => $g ) : ?>
						<div class="bp-gallery-item"><img src="<?php echo brickpoint_img( $g ); ?>" alt="<?php printf( esc_attr__( 'SS7 Bricks %d', 'brickpoint' ), esc_attr( $i + 1 ) ); ?>" loading="lazy"></div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="bp-section bp-bg-navy" style="padding-top:64px;padding-bottom:64px">
			<div class="bp-container">
				<div class="bp-center bp-mb-8">
					<h2 style="font-size:30px;font-weight:700;color:#fff;margin:0 0 12px"><?php esc_html_e( 'SS7 Brick Applications', 'brickpoint' ); ?></h2>
					<p style="color:var(--bp-gray-400);margin:0"><?php esc_html_e( 'Suitable for a wide range of construction projects', 'brickpoint' ); ?></p>
				</div>
				<div class="bp-app-grid">
					<?php
					foreach ( array( __( 'Residential Homes', 'brickpoint' ), __( 'Commercial Buildings', 'brickpoint' ), __( 'Boundary Walls', 'brickpoint' ), __( 'Villa Construction', 'brickpoint' ), __( 'Housing Projects', 'brickpoint' ), __( 'General Masonry', 'brickpoint' ) ) as $app ) :
						?>
						<div class="bp-app-card"><div class="bp-emoji">🧱</div><p><?php echo esc_html( $app ); ?></p></div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="bp-section bp-bg-warm">
			<div class="bp-container bp-narrow">
				<div class="bp-center bp-mb-8">
					<h2 class="bp-h2" style="font-size:30px"><?php esc_html_e( 'Frequently Asked Questions', 'brickpoint' ); ?></h2>
					<p class="bp-lead" style="font-size:16px"><?php esc_html_e( 'Common questions about SS7 bricks and ordering', 'brickpoint' ); ?></p>
				</div>
				<div class="bp-faq-list">
					<?php foreach ( $faqs as $faq ) : ?>
						<div class="bp-faq-item">
							<div class="bp-faq-inner">
								<?php echo brickpoint_icon( 'help', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<div><h3><?php echo esc_html( $faq['q'] ); ?></h3><p><?php echo esc_html( $faq['a'] ); ?></p></div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<?php
		get_template_part(
			'template-parts/sections/cta-red',
			null,
			array(
				'title' => __( 'Order SS7 Bricks Today', 'brickpoint' ),
				'sub'   => __( 'Contact BrickPoint on WhatsApp for pricing, availability, and bulk orders.', 'brickpoint' ),
				'note'  => '',
			)
		);
	}
	?>
</main>
<?php
get_footer();

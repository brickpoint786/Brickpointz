<?php
/**
 * Template Name: BrickPoint — About
 * About page matching the original design.
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
		$highlights = array(
			__( 'SS7 Branded Bricks', 'brickpoint' ),
			__( 'Multiple Manufacturing Locations', 'brickpoint' ),
			__( 'Bulk Order Capability', 'brickpoint' ),
			__( 'WhatsApp Ordering', 'brickpoint' ),
			__( 'Direct Manufacturer Access', 'brickpoint' ),
			__( 'Wide Construction Material Range', 'brickpoint' ),
		);
		$audience = array(
			array( 'icon' => 'target', 'label' => __( 'Builders & Contractors', 'brickpoint' ) ),
			array( 'icon' => 'building', 'label' => __( 'Developers', 'brickpoint' ) ),
			array( 'icon' => 'users', 'label' => __( 'Construction Companies', 'brickpoint' ) ),
			array( 'icon' => 'check', 'label' => __( 'Homeowners', 'brickpoint' ) ),
			array( 'icon' => 'target', 'label' => __( 'Architects', 'brickpoint' ) ),
			array( 'icon' => 'building', 'label' => __( 'Project Managers', 'brickpoint' ) ),
		);
		?>
		<section class="bp-page-hero">
			<div class="bp-page-hero-bg"><img src="<?php echo brickpoint_img( 'hero-bricks.jpg' ); ?>" alt="<?php esc_attr_e( 'About BrickPoint', 'brickpoint' ); ?>"></div>
			<div class="bp-page-hero-overlay"></div>
			<div class="bp-container bp-page-hero-inner">
				<?php
				brickpoint_breadcrumb(
					array(
						array( __( 'Home', 'brickpoint' ), home_url( '/' ) ),
						array( __( 'About Us', 'brickpoint' ), null ),
					)
				);
				?>
				<p class="bp-eyebrow"><?php esc_html_e( 'About BrickPoint', 'brickpoint' ); ?></p>
				<h1><?php esc_html_e( 'Your Trusted Partner in', 'brickpoint' ); ?><br><span style="color:var(--bp-red)"><?php esc_html_e( 'Construction Materials', 'brickpoint' ); ?></span></h1>
				<p class="bp-hero-sub">
					<?php
					printf(
						/* translators: 1: company, 2: company */
						esc_html__( 'BrickPoint represents %1$s and %2$s — supplying SS7 bricks and essential construction materials to builders, contractors, and developers.', 'brickpoint' ),
						esc_html( brickpoint_get( 'company_1' ) ),
						esc_html( brickpoint_get( 'company_2' ) )
					);
					?>
				</p>
			</div>
		</section>

		<section class="bp-section bp-bg-warm">
			<div class="bp-container bp-grid-2">
				<div>
					<p class="bp-eyebrow"><?php esc_html_e( 'Our Story', 'brickpoint' ); ?></p>
					<h2 class="bp-h2"><?php esc_html_e( 'Building Relationships,', 'brickpoint' ); ?><br><?php esc_html_e( 'One Brick at a Time', 'brickpoint' ); ?></h2>
					<div class="bp-prose">
						<p>
							<?php
							printf(
								/* translators: 1: company, 2: company */
								esc_html__( 'BrickPoint is the digital face of two established brick manufacturing companies in Pakistan — %1$s and %2$s. Together, they operate multiple brick manufacturing facilities (bhattas) producing quality bricks for the construction industry.', 'brickpoint' ),
								'<strong>' . esc_html( brickpoint_get( 'company_1' ) ) . '</strong>',
								'<strong>' . esc_html( brickpoint_get( 'company_2' ) ) . '</strong>'
							);
							?>
						</p>
						<p>
							<?php
							printf(
								/* translators: %s product */
								esc_html__( 'Our primary product is the %s — a recognized name among builders, contractors, and construction companies looking for consistent quality and dependable supply.', 'brickpoint' ),
								'<strong>' . esc_html__( 'SS7 branded brick', 'brickpoint' ) . '</strong>'
							);
							?>
						</p>
						<p><?php esc_html_e( 'Through BrickPoint, we bring together our manufacturing expertise and customer service under one brand, making it easier for builders, developers, architects, and homeowners to source quality construction materials efficiently.', 'brickpoint' ); ?></p>
					</div>
					<ul class="bp-check-list" style="color:var(--bp-gray-700);margin-top:32px;margin-bottom:0">
						<?php foreach ( $highlights as $h ) : ?>
							<li><?php echo brickpoint_icon( 'check', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html( $h ); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<div class="bp-about-img">
					<img class="main" src="<?php echo brickpoint_img( 'about-team.jpg' ); ?>" alt="<?php esc_attr_e( 'BrickPoint Team', 'brickpoint' ); ?>" loading="lazy">
					<div class="bp-about-corner"><strong>SS7</strong><small><?php esc_html_e( 'Brick Brand', 'brickpoint' ); ?></small></div>
				</div>
			</div>
		</section>

		<section class="bp-section bp-bg-neutral">
			<div class="bp-container">
				<div class="bp-section-head">
					<p class="bp-eyebrow"><?php esc_html_e( 'Our Companies', 'brickpoint' ); ?></p>
					<h2 class="bp-h2"><?php esc_html_e( 'Under the BrickPoint Brand', 'brickpoint' ); ?></h2>
					<p class="bp-lead"><?php esc_html_e( 'BrickPoint represents two manufacturing companies operating brick production facilities across multiple locations.', 'brickpoint' ); ?></p>
				</div>
				<div class="bp-grid-2" style="align-items:stretch">
					<div class="bp-company-card">
						<div class="bp-feature-icon"><?php echo brickpoint_icon( 'building', 28 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
						<h3><?php echo esc_html( brickpoint_get( 'company_1' ) ); ?></h3>
						<p><?php esc_html_e( 'Masha Allah Bricks Company operates two brick manufacturing facilities (bhattas), producing quality SS7 branded bricks and other construction bricks for the local market.', 'brickpoint' ); ?></p>
						<ul class="bp-mini-list">
							<li><span class="bp-dot" style="background:var(--bp-red)"></span><?php esc_html_e( 'Bhatta 1 — Ram Thaman', 'brickpoint' ); ?></li>
							<li><span class="bp-dot" style="background:var(--bp-red)"></span><?php esc_html_e( 'Bhatta 3 — Active Location', 'brickpoint' ); ?></li>
						</ul>
					</div>
					<div class="bp-company-card">
						<div class="bp-feature-icon" style="color:var(--bp-navy)"><?php echo brickpoint_icon( 'building', 28 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
						<h3><?php echo esc_html( brickpoint_get( 'company_2' ) ); ?></h3>
						<p><?php esc_html_e( 'Fine Bricks Company operates a brick manufacturing facility (Bhatta 2) producing quality bricks under the SS7 brand and serving construction projects across the region.', 'brickpoint' ); ?></p>
						<ul class="bp-mini-list">
							<li><span class="bp-dot" style="background:var(--bp-navy)"></span><?php esc_html_e( 'Bhatta 2 — Raja Jang', 'brickpoint' ); ?></li>
						</ul>
					</div>
				</div>
			</div>
		</section>

		<section class="bp-section bp-bg-warm">
			<div class="bp-container bp-grid-2">
				<div class="bp-order-2 bp-order-lg-1">
					<img class="bp-rounded-img" src="<?php echo brickpoint_img( 'brick-factory.jpg' ); ?>" alt="<?php esc_attr_e( 'Brick manufacturing', 'brickpoint' ); ?>" loading="lazy">
				</div>
				<div class="bp-order-1 bp-order-lg-2">
					<p class="bp-eyebrow"><?php esc_html_e( 'Who We Serve', 'brickpoint' ); ?></p>
					<h2 class="bp-h2"><?php esc_html_e( 'Built for Every Builder', 'brickpoint' ); ?></h2>
					<p class="bp-lead bp-mb-8" style="font-size:16px"><?php esc_html_e( 'BrickPoint serves a wide range of customers from large-scale construction companies to individual homeowners starting their first project.', 'brickpoint' ); ?></p>
					<div class="bp-serve-grid">
						<?php foreach ( $audience as $a ) : ?>
							<div class="bp-serve-item"><?php echo brickpoint_icon( $a['icon'], 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php echo esc_html( $a['label'] ); ?></span></div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</section>

		<section class="bp-section bp-bg-navy">
			<div class="bp-container">
				<div class="bp-section-head">
					<p class="bp-eyebrow"><?php esc_html_e( 'Our Leadership', 'brickpoint' ); ?></p>
					<h2 class="bp-h2 bp-h2-light"><?php esc_html_e( 'Meet the Team', 'brickpoint' ); ?></h2>
				</div>
				<div class="bp-team-grid">
					<div class="bp-team-card">
						<div class="bp-team-avatar"><span><?php echo esc_html( mb_substr( brickpoint_get( 'ceo' ), 0, 1 ) ); ?></span></div>
						<h3><?php echo esc_html( brickpoint_get( 'ceo' ) ); ?></h3>
						<p class="bp-role"><?php esc_html_e( 'Chief Executive Officer', 'brickpoint' ); ?></p>
						<p><?php esc_html_e( 'Leading BrickPoint with a vision for quality construction materials and exceptional customer service.', 'brickpoint' ); ?></p>
					</div>
					<div class="bp-team-card">
						<div class="bp-team-avatar"><span><?php echo esc_html( mb_substr( brickpoint_get( 'sales_manager' ), 0, 1 ) ); ?></span></div>
						<h3><?php echo esc_html( brickpoint_get( 'sales_manager' ) ); ?></h3>
						<p class="bp-role"><?php esc_html_e( 'Sales Manager', 'brickpoint' ); ?></p>
						<p><?php esc_html_e( 'Managing customer relationships and ensuring timely fulfillment of orders for all product categories.', 'brickpoint' ); ?></p>
					</div>
				</div>
			</div>
		</section>

		<?php
		get_template_part(
			'template-parts/sections/cta-red',
			null,
			array(
				'title' => __( 'Ready to Order Construction Materials?', 'brickpoint' ),
				'sub'   => __( 'Contact our team on WhatsApp for product pricing, availability, and delivery.', 'brickpoint' ),
				'note'  => '',
			)
		);
	}
	?>
</main>
<?php
get_footer();

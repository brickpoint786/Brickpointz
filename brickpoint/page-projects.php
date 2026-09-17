<?php
/**
 * Template Name: BrickPoint — Projects
 * Projects page (dynamic from Projects CPT).
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
		$projects = brickpoint_get_projects();
		$terms    = get_terms( array( 'taxonomy' => 'project_category', 'hide_empty' => false ) );
		$filters  = array( __( 'All', 'brickpoint' ) );
		if ( $terms && ! is_wp_error( $terms ) ) {
			foreach ( $terms as $t ) {
				$filters[] = $t->name;
			}
		} else {
			$filters = array( __( 'All', 'brickpoint' ), __( 'Residential', 'brickpoint' ), __( 'Commercial', 'brickpoint' ), __( 'Brickwork / Masonry', 'brickpoint' ) );
		}

		if ( ! $projects ) {
			$fallback_imgs = array( 'construction-project.jpg', 'hero-bricks.jpg', 'brick-factory.jpg', 'bricks-stacked.jpg', 'construction-project.jpg', 'about-team.jpg' );
			$projects_data = array(
				array( 'title' => __( 'Modern Residential Villa — DHA Lahore', 'brickpoint' ), 'cat' => __( 'Residential', 'brickpoint' ), 'loc' => __( 'DHA Lahore', 'brickpoint' ), 'desc' => __( 'A modern residential villa featuring premium SS7 brickwork and quality construction materials. The clean brick facade showcases consistent quality and professional execution.', 'brickpoint' ), 'mats' => array( 'SS7 Bricks', 'Cement', 'Steel', 'Sand', 'Crush' ) ),
				array( 'title' => __( 'Commercial Development — Bahria Town Lahore', 'brickpoint' ), 'cat' => __( 'Commercial', 'brickpoint' ), 'loc' => __( 'Bahria Town Lahore', 'brickpoint' ), 'desc' => __( 'A multi-storey commercial building project utilizing quality construction materials including bricks, cement, and structural steel for a robust and durable structure.', 'brickpoint' ), 'mats' => array( 'Bricks', 'Cement', 'Steel Rebar', 'Construction Chemicals' ) ),
				array( 'title' => __( 'Residential Housing — Lake City Lahore', 'brickpoint' ), 'cat' => __( 'Residential', 'brickpoint' ), 'loc' => __( 'Lake City Lahore', 'brickpoint' ), 'desc' => __( "Premium residential construction featuring quality brickwork and modern construction materials in one of Lahore's premium residential communities.", 'brickpoint' ), 'mats' => array( 'SS7 Bricks', 'Cement', 'Plumbing Pipes', 'Paints' ) ),
				array( 'title' => __( 'Expert Brickwork — Etihad Town Lahore', 'brickpoint' ), 'cat' => __( 'Brickwork / Masonry', 'brickpoint' ), 'loc' => __( 'Etihad Town Lahore', 'brickpoint' ), 'desc' => __( 'Precision masonry and brickwork using SS7 branded bricks, demonstrating the consistent quality and clean finish achievable with properly sourced construction bricks.', 'brickpoint' ), 'mats' => array( 'SS7 Bricks', 'Cement', 'Sand' ) ),
				array( 'title' => __( 'Villa Construction — Al-Kabir Town Lahore', 'brickpoint' ), 'cat' => __( 'Residential', 'brickpoint' ), 'loc' => __( 'Al-Kabir Town Lahore', 'brickpoint' ), 'desc' => __( 'Double-storey residential villa construction featuring quality brick masonry, structural steel, and comprehensive construction material supply.', 'brickpoint' ), 'mats' => array( 'Bricks', 'Steel', 'Cement', 'Crush' ) ),
				array( 'title' => __( 'Construction Project — Paragon City Lahore', 'brickpoint' ), 'cat' => __( 'Residential', 'brickpoint' ), 'loc' => __( 'Paragon City Lahore', 'brickpoint' ), 'desc' => __( 'Residential construction project featuring quality masonry and modern construction material application for a premium community development.', 'brickpoint' ), 'mats' => array( 'Bricks', 'Cement', 'Sand', 'Steel' ) ),
			);
		}
		?>
		<section class="bp-page-hero">
			<div class="bp-page-hero-bg"><img src="<?php echo brickpoint_img( 'construction-project.jpg' ); ?>" alt="<?php esc_attr_e( 'Projects', 'brickpoint' ); ?>"></div>
			<div class="bp-page-hero-overlay"></div>
			<div class="bp-container bp-page-hero-inner">
				<?php
				brickpoint_breadcrumb(
					array(
						array( __( 'Home', 'brickpoint' ), home_url( '/' ) ),
						array( __( 'Projects', 'brickpoint' ), null ),
					)
				);
				?>
				<h1><?php esc_html_e( 'Construction Showcases', 'brickpoint' ); ?></h1>
				<p class="bp-hero-sub"><?php esc_html_e( 'Explore featured construction project inspirations showcasing quality brickwork and construction material applications.', 'brickpoint' ); ?></p>
			</div>
		</section>

		<div class="bp-notice-bar">
			<div class="bp-container bp-notice-inner">
				<?php echo brickpoint_icon( 'info', 16 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<p style="margin:0"><strong><?php esc_html_e( 'Note:', 'brickpoint' ); ?></strong> <?php esc_html_e( 'Projects marked as "Illustrative" are representative construction showcases for inspiration purposes. They do not represent confirmed BrickPoint client projects or official supply agreements with the mentioned communities.', 'brickpoint' ); ?></p>
			</div>
		</div>

		<section class="bp-section bp-bg-warm">
			<div class="bp-container">
				<div class="bp-filter-row">
					<?php foreach ( $filters as $i => $f ) : ?>
						<button type="button" class="bp-filter-pill <?php echo 0 === $i ? 'active' : ''; ?>" data-bp-filter="<?php echo esc_attr( $f ); ?>"><?php echo esc_html( $f ); ?></button>
					<?php endforeach; ?>
				</div>

				<div class="bp-grid-3">
					<?php if ( isset( $projects_data ) ) : ?>
						<?php foreach ( $projects_data as $i => $p ) : ?>
							<div class="bp-card" data-bp-project-cat="<?php echo esc_attr( $p['cat'] ); ?>">
								<div class="bp-card-img">
									<img src="<?php echo brickpoint_img( $fallback_imgs[ $i % count( $fallback_imgs ) ] ); ?>" alt="<?php echo esc_attr( $p['title'] ); ?>" loading="lazy">
									<div class="bp-shade"></div>
									<span class="bp-badge bp-badge-cat bp-card-flag-tl"><?php echo esc_html( $p['cat'] ); ?></span>
									<span class="bp-badge-illus bp-card-flag-tr"><?php esc_html_e( 'Illustrative', 'brickpoint' ); ?></span>
								</div>
								<div class="bp-card-body">
									<h3><?php echo esc_html( $p['title'] ); ?></h3>
									<div class="bp-card-meta"><?php echo brickpoint_icon( 'map-pin', 12 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html( $p['loc'] ); ?></div>
									<p class="bp-card-excerpt"><?php echo esc_html( $p['desc'] ); ?></p>
									<div class="bp-project-mats">
										<?php foreach ( $p['mats'] as $m ) : ?>
											<span class="bp-mat-tag"><?php echo esc_html( $m ); ?></span>
										<?php endforeach; ?>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					<?php else : ?>
						<?php
						foreach ( $projects as $p ) :
							$pts  = get_the_terms( $p->ID, 'project_category' );
							$cat  = ( $pts && ! is_wp_error( $pts ) ) ? $pts[0]->name : __( 'Project', 'brickpoint' );
							$loc  = get_post_meta( $p->ID, '_bp_location', true );
							$mats = array_filter( array_map( 'trim', explode( ',', (string) get_post_meta( $p->ID, '_bp_materials', true ) ) ) );
							$img  = get_the_post_thumbnail_url( $p->ID, 'brickpoint-card' );
							if ( ! $img ) {
								$img = brickpoint_img( 'construction-project.jpg' );
							}
							$illus = get_post_meta( $p->ID, '_bp_illustrative', true );
							?>
							<div class="bp-card" data-bp-project-cat="<?php echo esc_attr( $cat ); ?>">
								<div class="bp-card-img">
									<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $p->post_title ); ?>" loading="lazy">
									<div class="bp-shade"></div>
									<span class="bp-badge bp-badge-cat bp-card-flag-tl"><?php echo esc_html( $cat ); ?></span>
									<?php if ( '0' !== $illus ) : ?>
										<span class="bp-badge-illus bp-card-flag-tr"><?php esc_html_e( 'Illustrative', 'brickpoint' ); ?></span>
									<?php endif; ?>
								</div>
								<div class="bp-card-body">
									<h3><?php echo esc_html( $p->post_title ); ?></h3>
									<?php if ( $loc ) : ?>
										<div class="bp-card-meta"><?php echo brickpoint_icon( 'map-pin', 12 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html( $loc ); ?></div>
									<?php endif; ?>
									<?php if ( $p->post_excerpt ) : ?>
										<p class="bp-card-excerpt"><?php echo esc_html( $p->post_excerpt ); ?></p>
									<?php endif; ?>
									<?php if ( $mats ) : ?>
										<div class="bp-project-mats">
											<?php foreach ( $mats as $m ) : ?>
												<span class="bp-mat-tag"><?php echo esc_html( $m ); ?></span>
											<?php endforeach; ?>
										</div>
									<?php endif; ?>
								</div>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>
		</section>

		<?php
		get_template_part(
			'template-parts/sections/cta-red',
			null,
			array(
				'title' => __( 'Have a Project in Mind?', 'brickpoint' ),
				'sub'   => __( 'Tell us about your material requirements and get a quotation on WhatsApp.', 'brickpoint' ),
				'note'  => '',
			)
		);
	}
	?>
</main>
<?php
get_footer();

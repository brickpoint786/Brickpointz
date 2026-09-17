<?php
/**
 * Homepage: featured projects preview (dynamic from Projects CPT).
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$projects = brickpoint_get_projects();
$projects = array_slice( $projects, 0, 3 );

$fallback = array(
	array( 'title' => __( 'Modern Residential Villa — DHA Lahore', 'brickpoint' ), 'cat' => __( 'Residential', 'brickpoint' ), 'loc' => __( 'DHA Lahore', 'brickpoint' ), 'img' => 'construction-project.jpg' ),
	array( 'title' => __( 'Commercial Development — Bahria Town', 'brickpoint' ), 'cat' => __( 'Commercial', 'brickpoint' ), 'loc' => __( 'Bahria Town Lahore', 'brickpoint' ), 'img' => 'hero-bricks.jpg' ),
	array( 'title' => __( 'Premium Brickwork — Lake City', 'brickpoint' ), 'cat' => __( 'Brickwork', 'brickpoint' ), 'loc' => __( 'Lake City Lahore', 'brickpoint' ), 'img' => 'bricks-stacked.jpg' ),
);
?>
<section class="bp-section bp-bg-warm">
	<div class="bp-container">
		<div class="bp-split-head">
			<div>
				<p class="bp-eyebrow"><?php esc_html_e( 'Our Work', 'brickpoint' ); ?></p>
				<h2 class="bp-h2"><?php esc_html_e( 'Featured Projects', 'brickpoint' ); ?></h2>
			</div>
			<a class="bp-text-link" href="<?php echo esc_url( home_url( '/projects/' ) ); ?>">
				<?php esc_html_e( 'View All Projects', 'brickpoint' ); ?>
				<?php echo brickpoint_icon( 'arrow', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</a>
		</div>

		<div class="bp-grid-3">
			<?php if ( $projects ) : ?>
				<?php foreach ( $projects as $p ) : ?>
					<?php
					$terms = get_the_terms( $p->ID, 'project_category' );
					$cat   = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : __( 'Project', 'brickpoint' );
					$loc   = get_post_meta( $p->ID, '_bp_location', true );
					$img   = get_the_post_thumbnail_url( $p->ID, 'brickpoint-card' );
					if ( ! $img ) {
						$img = brickpoint_img( 'construction-project.jpg' );
					}
					?>
					<a class="bp-card" href="<?php echo esc_url( home_url( '/projects/' ) ); ?>">
						<div class="bp-card-img">
							<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $p->post_title ); ?>" loading="lazy">
							<div class="bp-shade"></div>
							<span class="bp-badge bp-badge-cat bp-card-flag-tl"><?php echo esc_html( $cat ); ?></span>
							<span class="bp-badge-illus bp-card-flag-tr"><?php esc_html_e( 'Illustrative', 'brickpoint' ); ?></span>
						</div>
						<div class="bp-card-body">
							<h3><?php echo esc_html( $p->post_title ); ?></h3>
							<?php if ( $loc ) : ?>
								<div class="bp-card-meta"><?php echo brickpoint_icon( 'map-pin', 12 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html( $loc ); ?></div>
							<?php endif; ?>
						</div>
					</a>
				<?php endforeach; ?>
			<?php else : ?>
				<?php foreach ( $fallback as $proj ) : ?>
					<a class="bp-card" href="<?php echo esc_url( home_url( '/projects/' ) ); ?>">
						<div class="bp-card-img">
							<img src="<?php echo brickpoint_img( $proj['img'] ); ?>" alt="<?php echo esc_attr( $proj['title'] ); ?>" loading="lazy">
							<div class="bp-shade"></div>
							<span class="bp-badge bp-badge-cat bp-card-flag-tl"><?php echo esc_html( $proj['cat'] ); ?></span>
							<span class="bp-badge-illus bp-card-flag-tr"><?php esc_html_e( 'Illustrative', 'brickpoint' ); ?></span>
						</div>
						<div class="bp-card-body">
							<h3><?php echo esc_html( $proj['title'] ); ?></h3>
							<div class="bp-card-meta"><?php echo brickpoint_icon( 'map-pin', 12 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html( $proj['loc'] ); ?></div>
						</div>
					</a>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php
/**
 * Homepage: blog preview (dynamic latest 3 posts).
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$posts = get_posts(
	array(
		'numberposts' => 3,
		'post_status' => 'publish',
	)
);
$blog_url = get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/blog/' );
?>
<section class="bp-section bp-bg-warm">
	<div class="bp-container">
		<div class="bp-split-head">
			<div>
				<p class="bp-eyebrow"><?php esc_html_e( 'Knowledge Base', 'brickpoint' ); ?></p>
				<h2 class="bp-h2"><?php esc_html_e( 'Construction Insights', 'brickpoint' ); ?></h2>
			</div>
			<a class="bp-text-link" href="<?php echo esc_url( $blog_url ); ?>">
				<?php esc_html_e( 'View All Posts', 'brickpoint' ); ?>
				<?php echo brickpoint_icon( 'arrow', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</a>
		</div>

		<?php if ( $posts ) : ?>
			<div class="bp-grid-3">
				<?php foreach ( $posts as $post ) : ?>
					<?php setup_postdata( $post ); ?>
					<a class="bp-card" href="<?php the_permalink(); ?>">
						<div class="bp-card-img sm">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'brickpoint-card' ); ?>
							<?php else : ?>
								<img src="<?php echo brickpoint_img( 'bricks-stacked.jpg' ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
							<?php endif; ?>
							<?php
							$cats = get_the_category();
							if ( $cats ) :
								?>
								<span class="bp-badge bp-badge-cat bp-card-flag-tl"><?php echo esc_html( $cats[0]->name ); ?></span>
							<?php endif; ?>
						</div>
						<div class="bp-card-body">
							<h3 class="bp-hover-red bp-clamp-2"><?php the_title(); ?></h3>
							<div class="bp-card-foot">
								<span><?php the_author(); ?></span>
								<span>
									<?php
									/* translators: %d minutes */
									printf( esc_html__( '%d min read', 'brickpoint' ), esc_html( brickpoint_reading_time() ) );
									?>
								</span>
							</div>
						</div>
					</a>
				<?php endforeach; ?>
				<?php wp_reset_postdata(); ?>
			</div>
		<?php endif; ?>
	</div>
</section>

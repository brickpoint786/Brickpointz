<?php
/**
 * Search results template.
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
	if ( brickpoint_elementor_location( 'archive' ) ) {
		// Rendered by Elementor Theme Builder.
	} else {
		get_template_part(
			'template-parts/content/page-hero',
			null,
			array(
				/* translators: %s search query */
				'title' => sprintf( __( 'Results for "%s"', 'brickpoint' ), get_search_query() ),
				'trail' => array(
					array( __( 'Home', 'brickpoint' ), home_url( '/' ) ),
					array( __( 'Search', 'brickpoint' ), null ),
				),
			)
		);
		?>
		<section class="bp-section bp-bg-warm">
			<div class="bp-container">
				<?php if ( have_posts() ) : ?>
					<div class="bp-grid-3">
						<?php
						while ( have_posts() ) :
							the_post();
							get_template_part( 'template-parts/content/blog-card' );
						endwhile;
						?>
					</div>
					<div class="bp-center bp-mt-10">
						<?php
						echo wp_kses_post(
							paginate_links(
								array(
									'total'   => $GLOBALS['wp_query']->max_num_pages,
									'current' => max( 1, get_query_var( 'paged' ) ),
									'type'    => 'list',
								)
							)
						);
						?>
					</div>
				<?php else : ?>
					<div class="bp-empty">
						<?php echo brickpoint_icon( 'search', 48 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<h2><?php esc_html_e( 'No results found', 'brickpoint' ); ?></h2>
						<p><?php esc_html_e( 'Try different keywords or browse our products and articles.', 'brickpoint' ); ?></p>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
	?>
</main>
<?php
get_footer();

<?php
/**
 * Default page template. Elementor-built pages render their content directly;
 * other pages get the branded hero + content wrapper.
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
	while ( have_posts() ) :
		the_post();
		if ( brickpoint_is_elementor_page() ) {
			the_content();
		} else {
			get_template_part(
				'template-parts/content/page-hero',
				null,
				array(
					'title' => get_the_title(),
					'trail' => array(
						array( __( 'Home', 'brickpoint' ), home_url( '/' ) ),
						array( get_the_title(), null ),
					),
				)
			);
			?>
			<section class="bp-section bp-bg-warm">
				<div class="bp-container bp-narrow bp-content">
					<?php
					the_content();
					wp_link_pages();
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
					?>
				</div>
			</section>
			<?php
		}
	endwhile;
	?>
</main>
<?php
get_footer();

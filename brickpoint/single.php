<?php
/**
 * Single post template (Elementor single location first).
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
	if ( brickpoint_elementor_location( 'single' ) ) {
		// Rendered by Elementor Theme Builder.
	} else {
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content/single-post' );
		endwhile;
	}
	?>
</main>
<?php
get_footer();

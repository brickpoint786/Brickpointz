<?php
/**
 * Main template: Elementor archive location first, else theme blog archive.
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
		get_template_part( 'template-parts/content/blog-archive' );
	}
	?>
</main>
<?php
get_footer();

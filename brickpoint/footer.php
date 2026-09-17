<?php
/**
 * Footer — Elementor Theme Builder location first, fallback theme footer otherwise.
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! brickpoint_elementor_location( 'footer' ) ) {
	get_template_part( 'template-parts/footer/site-footer' );
}
get_template_part( 'template-parts/footer/whatsapp-float' );
get_template_part( 'template-parts/content/whatsapp-modal' );
wp_footer();
?>
</body>
</html>

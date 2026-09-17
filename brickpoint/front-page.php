<?php
/**
 * Homepage. If the assigned front page is built with Elementor, its content
 * renders instead; otherwise the full original-design fallback renders.
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
		get_template_part( 'template-parts/sections/home-hero' );
		get_template_part( 'template-parts/sections/home-trust' );
		get_template_part( 'template-parts/sections/home-ss7' );
		get_template_part( 'template-parts/sections/home-products' );
		get_template_part( 'template-parts/sections/home-projects' );
		get_template_part( 'template-parts/sections/home-locations-strip' );
		get_template_part( 'template-parts/sections/home-blog' );
		get_template_part( 'template-parts/sections/cta-red' );
	}
	?>
</main>
<?php
get_footer();

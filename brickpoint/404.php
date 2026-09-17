<?php
/**
 * 404 template.
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="primary" class="bp-main">
	<?php if ( ! brickpoint_elementor_location( 'single' ) ) : ?>
		<section class="bp-404 bp-bg-warm">
			<div class="bp-container">
				<p class="bp-404-code">4<span>0</span>4</p>
				<h1 class="bp-h2"><?php esc_html_e( 'Page Not Found', 'brickpoint' ); ?></h1>
				<p class="bp-lead" style="max-width:480px;margin:0 auto"><?php esc_html_e( 'The page you are looking for might have been removed or is temporarily unavailable.', 'brickpoint' ); ?></p>
				<form class="bp-search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<input type="search" name="s" placeholder="<?php esc_attr_e( 'Search...', 'brickpoint' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>">
					<button class="bp-btn bp-btn-red" type="submit"><?php esc_html_e( 'Search', 'brickpoint' ); ?></button>
				</form>
				<div class="bp-mt-10" style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
					<a class="bp-btn bp-btn-navy" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to Home', 'brickpoint' ); ?></a>
					<a class="bp-btn bp-btn-wa" href="<?php echo brickpoint_whatsapp_link(); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Contact on WhatsApp', 'brickpoint' ); ?></a>
				</div>
			</div>
		</section>
	<?php endif; ?>
</main>
<?php
get_footer();

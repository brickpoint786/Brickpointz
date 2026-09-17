<?php
/**
 * Inner page hero with background image + breadcrumb.
 * Args: title, sub, image, trail (array of [label, url|null]), eyebrow.
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$title   = isset( $args['title'] ) ? $args['title'] : get_the_title();
$sub     = isset( $args['sub'] ) ? $args['sub'] : '';
$image   = isset( $args['image'] ) ? $args['image'] : brickpoint_img( 'hero-bricks.jpg' );
$trail   = isset( $args['trail'] ) ? $args['trail'] : array();
$eyebrow = isset( $args['eyebrow'] ) ? $args['eyebrow'] : '';
?>
<section class="bp-page-hero bp-page-hero-auto">
	<div class="bp-page-hero-bg"><img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( wp_strip_all_tags( $title ) ); ?>"></div>
	<div class="bp-page-hero-overlay"></div>
	<div class="bp-container bp-page-hero-inner">
		<?php
		if ( $trail ) {
			brickpoint_breadcrumb( $trail );
		}
		?>
		<?php if ( $eyebrow ) : ?>
			<p class="bp-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
		<?php endif; ?>
		<h1><?php echo wp_kses_post( $title ); ?></h1>
		<?php if ( $sub ) : ?>
			<p class="bp-hero-sub"><?php echo esc_html( $sub ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php
/**
 * Blog post card.
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$cats = get_the_category();
?>
<a class="bp-card" href="<?php the_permalink(); ?>">
	<div class="bp-card-img">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'brickpoint-card' ); ?>
		<?php else : ?>
			<img src="<?php echo brickpoint_img( 'bricks-stacked.jpg' ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
		<?php endif; ?>
		<?php if ( $cats ) : ?>
			<span class="bp-badge bp-badge-cat bp-card-flag-tl"><?php echo esc_html( $cats[0]->name ); ?></span>
		<?php endif; ?>
	</div>
	<div class="bp-card-body">
		<h3 class="bp-hover-red bp-clamp-2"><?php the_title(); ?></h3>
		<p class="bp-card-excerpt bp-clamp-2"><?php echo esc_html( get_the_excerpt() ); ?></p>
		<div class="bp-card-foot">
			<span><?php echo brickpoint_icon( 'user', 11 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php the_author(); ?></span>
			<span><?php echo brickpoint_icon( 'clock', 11 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php
				/* translators: %d minutes */
				printf( esc_html__( '%d min', 'brickpoint' ), esc_html( brickpoint_reading_time() ) );
				?>
			</span>
		</div>
	</div>
</a>

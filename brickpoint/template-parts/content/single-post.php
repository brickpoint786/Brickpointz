<?php
/**
 * Single blog post (matches original blog/[slug] design).
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$cats     = get_the_category();
$blog_url = get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/blog/' );
$bg       = get_the_post_thumbnail_url( get_the_ID(), 'brickpoint-hero' );
if ( ! $bg ) {
	$bg = brickpoint_img( 'bricks-stacked.jpg' );
}
?>
<div class="bp-article-hero">
	<div class="bp-page-hero-bg"><img src="<?php echo esc_url( $bg ); ?>" alt="<?php the_title_attribute(); ?>"></div>
	<div class="bp-page-hero-overlay"></div>
	<div class="bp-container bp-page-hero-inner">
		<?php
		brickpoint_breadcrumb(
			array(
				array( __( 'Home', 'brickpoint' ), home_url( '/' ) ),
				array( __( 'Blog', 'brickpoint' ), $blog_url ),
				array( get_the_title(), null ),
			)
		);
		?>
		<?php if ( $cats ) : ?>
			<span class="bp-badge bp-badge-cat"><?php echo esc_html( $cats[0]->name ); ?></span>
		<?php endif; ?>
		<h1><?php the_title(); ?></h1>
		<div class="bp-article-meta">
			<span><?php echo brickpoint_icon( 'user', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php the_author(); ?></span>
			<span><?php echo brickpoint_icon( 'clock', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php
				/* translators: %d minutes */
				printf( esc_html__( '%d min read', 'brickpoint' ), esc_html( brickpoint_reading_time() ) );
				?>
			</span>
			<span><?php echo brickpoint_icon( 'calendar', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html( get_the_date() ); ?></span>
		</div>
	</div>
</div>

<article class="bp-article">
	<div class="bp-container">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="bp-article-img"><?php the_post_thumbnail( 'brickpoint-wide' ); ?></div>
		<?php endif; ?>

		<?php if ( has_excerpt() ) : ?>
			<div class="bp-excerpt-box"><p><?php echo esc_html( get_the_excerpt() ); ?></p></div>
		<?php endif; ?>

		<div class="bp-content">
			<?php
			the_content();
			wp_link_pages();
			?>
		</div>

		<div class="bp-article-cta">
			<h3><?php esc_html_e( 'Need Construction Materials?', 'brickpoint' ); ?></h3>
			<p><?php esc_html_e( 'BrickPoint supplies SS7 bricks and quality construction materials. Order on WhatsApp for pricing and availability.', 'brickpoint' ); ?></p>
			<div class="bp-cta-btns">
				<a class="bp-btn bp-btn-wa" href="<?php echo brickpoint_whatsapp_link(); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Order on WhatsApp', 'brickpoint' ); ?></a>
				<a class="bp-btn bp-btn-red" href="<?php echo esc_url( class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/products/' ) ); ?>"><?php esc_html_e( 'View Products', 'brickpoint' ); ?></a>
			</div>
		</div>

		<?php
		$related = new WP_Query(
			array(
				'post_type'      => 'post',
				'posts_per_page' => 3,
				'post__not_in'   => array( get_the_ID() ),
			)
		);
		if ( $related->have_posts() ) :
			?>
			<div class="bp-related-head">
				<h2><?php esc_html_e( 'Related Articles', 'brickpoint' ); ?></h2>
				<a class="bp-text-link" href="<?php echo esc_url( $blog_url ); ?>"><?php esc_html_e( 'View All', 'brickpoint' ); ?> <?php echo brickpoint_icon( 'arrow', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
			</div>
			<div class="bp-grid-3">
				<?php
				while ( $related->have_posts() ) :
					$related->the_post();
					get_template_part( 'template-parts/content/blog-card' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		<?php endif; ?>

		<?php if ( comments_open() || get_comments_number() ) : ?>
			<div class="bp-comments">
				<?php comments_template(); ?>
			</div>
		<?php endif; ?>
	</div>
</article>

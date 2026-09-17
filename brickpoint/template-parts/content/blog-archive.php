<?php
/**
 * Blog archive (matches original blog page: hero, category bar, featured, grid).
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blog_url = get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/blog/' );
$paged    = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
$cat_id   = 0;
if ( is_category() ) {
	$cat_id = get_queried_object_id();
}

$query = new WP_Query(
	array(
		'post_type'      => 'post',
		'posts_per_page' => 9,
		'paged'          => $paged,
		'cat'            => $cat_id,
	)
);
$all_posts = $query->posts;
$featured  = null;
$rest      = $all_posts;
if ( 1 === $paged && ! $cat_id ) {
	foreach ( $all_posts as $i => $p ) {
		if ( is_sticky( $p->ID ) ) {
			$featured = $p;
			unset( $rest[ $i ] );
			break;
		}
	}
	if ( ! $featured && $all_posts ) {
		$featured = array_shift( $rest );
	}
}
$categories = get_categories( array( 'hide_empty' => true ) );
?>
<section class="bp-page-hero">
	<div class="bp-page-hero-bg"><img src="<?php echo brickpoint_img( 'bricks-stacked.jpg' ); ?>" alt="<?php esc_attr_e( 'BrickPoint Blog', 'brickpoint' ); ?>"></div>
	<div class="bp-page-hero-overlay"></div>
	<div class="bp-container bp-page-hero-inner">
		<?php
		brickpoint_breadcrumb(
			array(
				array( __( 'Home', 'brickpoint' ), home_url( '/' ) ),
				array( __( 'Blog', 'brickpoint' ), null ),
			)
		);
		?>
		<h1><?php esc_html_e( 'Construction Insights', 'brickpoint' ); ?></h1>
		<p class="bp-hero-sub"><?php esc_html_e( 'Guides, tips, and insights on construction materials, bricks, and building practices — from the BrickPoint team.', 'brickpoint' ); ?></p>
	</div>
</section>

<div class="bp-cat-bar">
	<div class="bp-container bp-cat-bar-inner">
		<a class="bp-cat-pill <?php echo 0 === $cat_id ? 'active' : ''; ?>" href="<?php echo esc_url( $blog_url ); ?>"><?php esc_html_e( 'All', 'brickpoint' ); ?></a>
		<?php foreach ( $categories as $c ) : ?>
			<a class="bp-cat-pill <?php echo $cat_id === $c->term_id ? 'active' : ''; ?>" href="<?php echo esc_url( get_category_link( $c ) ); ?>"><?php echo esc_html( $c->name ); ?></a>
		<?php endforeach; ?>
	</div>
</div>

<section class="bp-section bp-bg-warm">
	<div class="bp-container">
		<?php if ( $all_posts ) : ?>
			<?php if ( $featured ) : ?>
				<?php
				$fcats = get_the_category( $featured->ID );
				$fimg  = get_the_post_thumbnail_url( $featured->ID, 'brickpoint-wide' );
				if ( ! $fimg ) {
					$fimg = brickpoint_img( 'bricks-stacked.jpg' );
				}
				?>
				<h2 class="bp-mb-4" style="font-size:18px;font-weight:700;color:var(--bp-navy);display:flex;align-items:center;gap:8px">
					<span style="width:12px;height:12px;background:var(--bp-red);border-radius:50%;display:inline-block"></span>
					<?php esc_html_e( 'Featured Article', 'brickpoint' ); ?>
				</h2>
				<a class="bp-featured-post" href="<?php echo esc_url( get_permalink( $featured->ID ) ); ?>">
					<div class="bp-featured-post-img">
						<img src="<?php echo esc_url( $fimg ); ?>" alt="<?php echo esc_attr( $featured->post_title ); ?>">
						<?php if ( $fcats ) : ?>
							<span class="bp-badge bp-badge-cat bp-card-flag-tl"><?php echo esc_html( $fcats[0]->name ); ?></span>
						<?php endif; ?>
					</div>
					<div class="bp-featured-post-body">
						<h3><?php echo esc_html( $featured->post_title ); ?></h3>
						<p class="bp-clamp-3"><?php echo esc_html( get_the_excerpt( $featured ) ); ?></p>
						<div class="bp-post-meta">
							<span><?php echo brickpoint_icon( 'user', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html( get_the_author_meta( 'display_name', $featured->post_author ) ); ?></span>
							<span><?php echo brickpoint_icon( 'clock', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<?php
								/* translators: %d minutes */
								printf( esc_html__( '%d min read', 'brickpoint' ), esc_html( brickpoint_reading_time( $featured->ID ) ) );
								?>
							</span>
						</div>
						<span class="bp-text-link"><?php esc_html_e( 'Read Article', 'brickpoint' ); ?> <?php echo brickpoint_icon( 'arrow', 14 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					</div>
				</a>
			<?php endif; ?>

			<div class="bp-grid-3">
				<?php
				foreach ( $rest as $post ) :
					setup_postdata( $post );
					get_template_part( 'template-parts/content/blog-card' );
				endforeach;
				wp_reset_postdata();
				?>
			</div>

			<?php
			$pagination = paginate_links(
				array(
					'total'   => $query->max_num_pages,
					'current' => $paged,
					'type'    => 'list',
				)
			);
			if ( $pagination ) {
				echo '<div class="bp-center bp-mt-10 bp-pagination">' . wp_kses_post( $pagination ) . '</div>';
			}
			?>
		<?php else : ?>
			<div class="bp-empty">
				<?php echo brickpoint_icon( 'search', 48 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<h2><?php esc_html_e( 'Blog Coming Soon', 'brickpoint' ); ?></h2>
				<p><?php esc_html_e( 'We are preparing construction guides and material insights. Check back soon.', 'brickpoint' ); ?></p>
			</div>
		<?php endif; ?>
	</div>
</section>

<section class="bp-section-sm bp-bg-navy">
	<div class="bp-container bp-cta-box">
		<h2 style="font-size:30px;font-weight:800;color:#fff;margin:0 0 16px"><?php esc_html_e( 'Stay Updated with BrickPoint', 'brickpoint' ); ?></h2>
		<p class="bp-lead bp-lead-light bp-mb-8"><?php esc_html_e( 'Follow us on social media and join our WhatsApp channel for construction tips, product updates, and company news.', 'brickpoint' ); ?></p>
		<a class="bp-btn bp-btn-wa bp-btn-lg" href="<?php echo esc_url( brickpoint_get( 'whatsapp_channel' ) ); ?>" target="_blank" rel="noopener noreferrer">
			<?php echo brickpoint_icon( 'whatsapp', 20 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php esc_html_e( 'Join WhatsApp Channel', 'brickpoint' ); ?>
		</a>
	</div>
</section>
<?php wp_reset_postdata(); ?>

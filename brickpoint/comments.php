<?php
/**
 * Comments template.
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( post_password_required() ) {
	return;
}
?>
<div id="comments">
	<?php if ( have_comments() ) : ?>
		<h2>
			<?php
			printf(
				/* translators: %s comment count */
				esc_html( _nx( '%1$s Comment', '%1$s Comments', get_comments_number(), 'comments title', 'brickpoint' ) ),
				esc_html( number_format_i18n( get_comments_number() ) )
			);
			?>
		</h2>
		<ol>
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 48,
				)
			);
			?>
		</ol>
		<?php the_comments_navigation(); ?>
	<?php endif; ?>

	<?php
	comment_form(
		array(
			'title_reply' => __( 'Leave a Reply', 'brickpoint' ),
		)
	);
	?>
</div>

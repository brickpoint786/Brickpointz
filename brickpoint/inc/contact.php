<?php
/**
 * Contact form handling (AJAX + fallback), stores messages as private CPT entries
 * and emails the admin. Compatible with Contact Form 7 if the admin prefers it.
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'brickpoint_register_message_cpt' );
/**
 * Private contact-message storage.
 */
function brickpoint_register_message_cpt() {
	register_post_type(
		'bp_message',
		array(
			'labels'       => array(
				'name'          => __( 'Messages', 'brickpoint' ),
				'singular_name' => __( 'Message', 'brickpoint' ),
			),
			'public'       => false,
			'show_ui'      => true,
			'show_in_menu' => 'edit.php?post_type=page',
			'supports'     => array( 'title', 'editor' ),
			'capabilities' => array( 'create_posts' => 'do_not_allow' ),
			'map_meta_cap' => true,
		)
	);
}

add_action( 'wp_ajax_brickpoint_contact', 'brickpoint_handle_contact' );
add_action( 'wp_ajax_nopriv_brickpoint_contact', 'brickpoint_handle_contact' );
add_shortcode( 'brickpoint_contact_form', 'brickpoint_contact_form_shortcode' );

/**
 * Contact form shortcode (used by the Elementor Contact page design).
 *
 * @return string
 */
function brickpoint_contact_form_shortcode() {
	ob_start();
	get_template_part( 'template-parts/content/contact-form' );
	return ob_get_clean();
}
/**
 * Handle contact submission.
 */
function brickpoint_handle_contact() {
	check_ajax_referer( 'brickpoint_contact', 'nonce' );

	$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$phone   = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$product = isset( $_POST['product'] ) ? sanitize_text_field( wp_unslash( $_POST['product'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if ( '' === $name || ( '' === $phone && '' === $email ) ) {
		wp_send_json_error( array( 'message' => __( 'Please provide your name and at least a phone number or email.', 'brickpoint' ) ) );
	}

	$post_id = wp_insert_post(
		array(
			'post_type'   => 'bp_message',
			'post_title'  => sprintf( '%s — %s', $name, current_time( 'mysql' ) ),
			'post_status' => 'private',
			'post_content' => "Name: {$name}\nPhone: {$phone}\nEmail: {$email}\nProduct: {$product}\n\n{$message}",
		)
	);

	if ( $post_id && ! is_wp_error( $post_id ) ) {
		update_post_meta( $post_id, '_bp_phone', $phone );
		update_post_meta( $post_id, '_bp_email', $email );
		update_post_meta( $post_id, '_bp_product', $product );
	}

	$admin = get_option( 'admin_email' );
	/* translators: 1: site name */
	wp_mail(
		$admin,
		sprintf( __( '[%1$s] New contact message from %2$s', 'brickpoint' ), get_bloginfo( 'name' ), $name ),
		"Name: {$name}\nPhone: {$phone}\nEmail: {$email}\nProduct: {$product}\n\n{$message}"
	);

	wp_send_json_success( array( 'message' => __( 'Message received! Our team will contact you shortly.', 'brickpoint' ) ) );
}

/**
 * Product options for the contact form (mirrors original site).
 *
 * @return array
 */
function brickpoint_contact_products() {
	return array(
		'SS7 Bricks',
		'Standard Bricks',
		'Cement',
		'Crush / Bajri',
		'Sand / Rait',
		'Steel / Rebar',
		'Electric Pipes',
		'Plumbing Pipes & Fittings',
		'Construction Chemicals',
		'Insulation & Membrane',
		'Cables & Wires',
		'Paints',
		'Lights',
		'Switches & Sockets',
		'Other / General Inquiry',
	);
}

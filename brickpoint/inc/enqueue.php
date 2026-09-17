<?php
/**
 * Asset enqueueing.
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_enqueue_scripts', 'brickpoint_enqueue' );
/**
 * Frontend assets.
 */
function brickpoint_enqueue() {
	// Inter font (same as original site).
	wp_enqueue_style(
		'brickpoint-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap',
		array(),
		BRICKPOINT_VERSION
	);

	wp_enqueue_style(
		'brickpoint-main',
		BRICKPOINT_URI . '/assets/css/main.css',
		array(),
		BRICKPOINT_VERSION
	);
	wp_enqueue_style( 'brickpoint-style', get_stylesheet_uri(), array( 'brickpoint-main' ), BRICKPOINT_VERSION );

	wp_enqueue_script(
		'brickpoint-main',
		BRICKPOINT_URI . '/assets/js/main.js',
		array(),
		BRICKPOINT_VERSION,
		true
	);

	wp_localize_script(
		'brickpoint-main',
		'brickpointData',
		array(
			'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
			'contactNonce'=> wp_create_nonce( 'brickpoint_contact' ),
			'whatsapp'    => preg_replace( '/[^0-9]/', '', brickpoint_get( 'whatsapp' ) ),
			'i18n'        => array(
				'orderTitle' => __( 'Order on WhatsApp', 'brickpoint' ),
			),
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'enqueue_block_editor_assets', 'brickpoint_editor_assets' );
/**
 * Block editor assets.
 */
function brickpoint_editor_assets() {
	wp_enqueue_style(
		'brickpoint-editor',
		BRICKPOINT_URI . '/assets/css/main.css',
		array(),
		BRICKPOINT_VERSION
	);
}

<?php
/**
 * WooCommerce integration. Products map 1:1 from the original catalog;
 * ordering stays WhatsApp-first (price-on-request supported).
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'after_setup_theme', 'brickpoint_woo_setup' );
/**
 * WooCommerce support.
 */
function brickpoint_woo_setup() {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 600,
			'single_image_width'    => 800,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'max_rows'        => 8,
				'default_columns' => 3,
				'min_columns'     => 1,
				'max_columns'     => 5,
			),
		)
	);
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}

/**
 * Products per page.
 */
add_filter( 'loop_shop_per_page', function () {
	return 12;
} );

/**
 * Shop columns.
 */
add_filter( 'loop_shop_columns', function () {
	return 3;
} );

/**
 * Redirect legacy /products/... URLs to WooCommerce equivalents where possible.
 * Original: /products (categories), /products/{category} (category),
 * /products/{category}/{slug} (product detail).
 */
function brickpoint_legacy_product_redirects() {
	if ( is_admin() || ! class_exists( 'WooCommerce' ) ) {
		return;
	}
	$uri = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
	$path = trim( wp_parse_url( $uri, PHP_URL_PATH ), '/' );

	// /products/{category}/{slug} -> WooCommerce product permalink.
	if ( preg_match( '#^products/([^/]+)/([^/]+)/?$#', $path, $m ) ) {
		$product = get_page_by_path( $m[2], OBJECT, 'product' );
		if ( $product ) {
			wp_safe_redirect( get_permalink( $product->ID ), 301 );
			exit;
		}
	}
	// /products/{category} -> product category archive.
	if ( preg_match( '#^products/([^/]+)/?$#', $path, $m ) ) {
		$term = get_term_by( 'slug', $m[1], 'product_cat' );
		if ( $term ) {
			wp_safe_redirect( get_term_link( $term ), 301 );
			exit;
		}
	}
}
add_action( 'template_redirect', 'brickpoint_legacy_product_redirects', 1 );

/**
 * "Price on Request" support: when _bp_price_on_request = yes, replace price HTML.
 */
add_filter( 'woocommerce_get_price_html', 'brickpoint_price_on_request_html', 20, 2 );
/**
 * Price HTML filter.
 *
 * @param string     $html    Price HTML.
 * @param WC_Product $product Product.
 * @return string
 */
function brickpoint_price_on_request_html( $html, $product ) {
	if ( ! $product ) {
		return $html;
	}
	$por = get_post_meta( $product->get_id(), '_bp_price_on_request', true );
	if ( 'yes' === $por ) {
		return '<span class="bp-price-on-request">' . esc_html__( 'Price on Request', 'brickpoint' ) . '</span>';
	}
	return $html;
}

/**
 * Add "Price on Request" + "SS7 Brand" + "Price Unit" fields to product editor.
 */
function brickpoint_product_fields() {
	woocommerce_wp_checkbox(
		array(
			'id'    => '_bp_price_on_request',
			'label' => __( 'Price on Request (WhatsApp pricing)', 'brickpoint' ),
		)
	);
	woocommerce_wp_checkbox(
		array(
			'id'    => '_bp_is_ss7',
			'label' => __( 'SS7 Brand product', 'brickpoint' ),
		)
	);
	woocommerce_wp_text_input(
		array(
			'id'          => '_bp_price_unit',
			'label'       => __( 'Price Unit', 'brickpoint' ),
			'placeholder' => __( 'Per 1,000 Bricks', 'brickpoint' ),
		)
	);
}
add_action( 'woocommerce_product_options_pricing', 'brickpoint_product_fields' );

/**
 * Save product fields.
 *
 * @param int $post_id Post ID.
 */
function brickpoint_save_product_fields( $post_id ) {
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	update_post_meta( $post_id, '_bp_price_on_request', isset( $_POST['_bp_price_on_request'] ) ? 'yes' : 'no' );
	update_post_meta( $post_id, '_bp_is_ss7', isset( $_POST['_bp_is_ss7'] ) ? 'yes' : 'no' );
	if ( isset( $_POST['_bp_price_unit'] ) ) {
		update_post_meta( $post_id, '_bp_price_unit', sanitize_text_field( wp_unslash( $_POST['_bp_price_unit'] ) ) );
	}
}
add_action( 'woocommerce_process_product_meta', 'brickpoint_save_product_fields' );

/**
 * Show price unit under price on single product.
 */
function brickpoint_price_unit_display() {
	global $product;
	if ( ! $product ) {
		return;
	}
	$unit = get_post_meta( $product->get_id(), '_bp_price_unit', true );
	if ( $unit ) {
		echo '<p class="bp-price-unit">' . esc_html( $unit ) . '</p>';
	}
}
add_action( 'woocommerce_single_product_summary', 'brickpoint_price_unit_display', 11 );

/**
 * WhatsApp order button on single product (after add to cart) + on loop items.
 */
function brickpoint_single_whatsapp_button() {
	global $product;
	if ( ! $product ) {
		return;
	}
	$cats = wp_get_post_terms( $product->get_id(), 'product_cat', array( 'fields' => 'names' ) );
	$cat  = $cats ? $cats[0] : __( 'Products', 'brickpoint' );
	get_template_part(
		'template-parts/content/whatsapp-order',
		null,
		array(
			'product'  => $product->get_name(),
			'category' => $cat,
			'price'    => 'yes' === get_post_meta( $product->get_id(), '_bp_price_on_request', true ) ? __( 'Price on Request', 'brickpoint' ) : wp_strip_all_tags( $product->get_price_html() ),
			'variant'  => 'primary',
			'class'    => 'bp-woo-whatsapp',
		)
	);
}
add_action( 'woocommerce_single_product_summary', 'brickpoint_single_whatsapp_button', 32 );

/**
 * SS7 / Featured badges on loop + single.
 */
function brickpoint_product_badges() {
	global $product;
	if ( ! $product ) {
		return;
	}
	if ( 'yes' === get_post_meta( $product->get_id(), '_bp_is_ss7', true ) ) {
		echo '<span class="bp-badge bp-badge-ss7">' . esc_html__( 'SS7 Brand', 'brickpoint' ) . '</span>';
	} elseif ( $product->is_featured() ) {
		echo '<span class="bp-badge bp-badge-featured">' . esc_html__( 'Featured', 'brickpoint' ) . '</span>';
	}
}
add_action( 'woocommerce_before_shop_loop_item_title', 'brickpoint_product_badges', 6 );

/**
 * Related products count.
 */
add_filter( 'woocommerce_output_related_products_args', function ( $args ) {
	$args['posts_per_page'] = 3;
	$args['columns']        = 3;
	return $args;
} );

/**
 * Display key features list on single product (from demo import / _bp_features).
 */
function brickpoint_product_features_display() {
	global $product;
	if ( ! $product ) {
		return;
	}
	$features = get_post_meta( $product->get_id(), '_bp_features', true );
	if ( empty( $features ) || ! is_array( $features ) ) {
		return;
	}
	echo '<div class="bp-mb-4"><h3 style="font-weight:600;color:var(--bp-navy);margin:0 0 12px">' . esc_html__( 'Key Features', 'brickpoint' ) . '</h3><div style="display:grid;gap:8px">';
	foreach ( $features as $feat ) {
		echo '<div style="display:flex;align-items:center;gap:8px;font-size:14px;color:var(--bp-gray-700)">' . brickpoint_icon( 'check', 15 ) . esc_html( $feat ) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
	echo '</div></div>';
}
add_action( 'woocommerce_single_product_summary', 'brickpoint_product_features_display', 25 );

/**
 * Ensure shop pages use theme CSS wrappers.
 */
function brickpoint_woo_wrappers() {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	add_action( 'woocommerce_before_main_content', 'brickpoint_woo_wrapper_start', 10 );
	add_action( 'woocommerce_after_main_content', 'brickpoint_woo_wrapper_end', 10 );
}
add_action( 'init', 'brickpoint_woo_wrappers' );

/**
 * Wrapper start.
 */
function brickpoint_woo_wrapper_start() {
	echo '<main id="primary" class="bp-main bp-woo"><div class="bp-container">';
}

/**
 * Wrapper end.
 */
function brickpoint_woo_wrapper_end() {
	echo '</div></main>';
}

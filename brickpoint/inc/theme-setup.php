<?php
/**
 * Theme setup: supports, menus, image sizes.
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'after_setup_theme', 'brickpoint_setup' );
/**
 * Theme setup.
 */
function brickpoint_setup() {
	load_theme_textdomain( 'brickpoint', BRICKPOINT_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 80,
			'width'       => 320,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	// BrickPoint brand palette (from original design).
	add_theme_support(
		'editor-color-palette',
		array(
			array( 'name' => __( 'Navy', 'brickpoint' ), 'slug' => 'navy', 'color' => '#0f1f3d' ),
			array( 'name' => __( 'Navy Light', 'brickpoint' ), 'slug' => 'navy-light', 'color' => '#1a3260' ),
			array( 'name' => __( 'Brick Red', 'brickpoint' ), 'slug' => 'brick-red', 'color' => '#c0392b' ),
			array( 'name' => __( 'Brick Dark', 'brickpoint' ), 'slug' => 'brick-dark', 'color' => '#96281b' ),
			array( 'name' => __( 'Gold', 'brickpoint' ), 'slug' => 'gold', 'color' => '#b8860b' ),
			array( 'name' => __( 'Charcoal', 'brickpoint' ), 'slug' => 'charcoal', 'color' => '#2c2c2c' ),
			array( 'name' => __( 'Warm White', 'brickpoint' ), 'slug' => 'warm-white', 'color' => '#faf8f5' ),
			array( 'name' => __( 'Warm Neutral', 'brickpoint' ), 'slug' => 'warm-neutral', 'color' => '#f0ebe3' ),
			array( 'name' => __( 'WhatsApp', 'brickpoint' ), 'slug' => 'whatsapp', 'color' => '#25d366' ),
		)
	);

	add_image_size( 'brickpoint-card', 600, 400, true );
	add_image_size( 'brickpoint-hero', 1200, 800, true );
	add_image_size( 'brickpoint-wide', 900, 500, true );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'brickpoint' ),
			'footer'  => __( 'Footer Quick Links', 'brickpoint' ),
			'footer-products' => __( 'Footer Products', 'brickpoint' ),
		)
	);
}

/**
 * Content width.
 */
function brickpoint_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'brickpoint_content_width', 1280 );
}
add_action( 'after_setup_theme', 'brickpoint_content_width', 0 );

/**
 * Register widget areas.
 */
function brickpoint_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Blog Sidebar', 'brickpoint' ),
			'id'            => 'sidebar-blog',
			'description'   => __( 'Appears on blog archive and single posts when Elementor sidebar is not used.', 'brickpoint' ),
			'before_widget' => '<div id="%1$s" class="bp-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="bp-widget-title">',
			'after_title'   => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name'          => __( 'Shop Sidebar', 'brickpoint' ),
			'id'            => 'sidebar-shop',
			'description'   => __( 'Appears on WooCommerce pages.', 'brickpoint' ),
			'before_widget' => '<div id="%1$s" class="bp-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="bp-widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'brickpoint_widgets_init' );

/**
 * Fallback primary menu (used when no menu assigned): mirrors original nav.
 */
function brickpoint_fallback_menu() {
	$items = array(
		home_url( '/' )              => __( 'Home', 'brickpoint' ),
		home_url( '/about/' )        => __( 'About Us', 'brickpoint' ),
		home_url( '/products/' )     => __( 'Products', 'brickpoint' ),
		home_url( '/ss7-bricks/' )   => __( 'SS7 Bricks', 'brickpoint' ),
		home_url( '/projects/' )     => __( 'Projects', 'brickpoint' ),
		home_url( '/locations/' )    => __( 'Locations', 'brickpoint' ),
		home_url( '/blog/' )         => __( 'Blog', 'brickpoint' ),
		home_url( '/contact/' )      => __( 'Contact Us', 'brickpoint' ),
	);
	echo '<ul class="bp-nav-list">';
	foreach ( $items as $url => $label ) {
		echo '<li><a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a></li>';
	}
	echo '</ul>';
}

/**
 * Body classes.
 *
 * @param array $classes Classes.
 * @return array
 */
function brickpoint_body_classes( $classes ) {
	if ( ! is_active_sidebar( 'sidebar-blog' ) ) {
		$classes[] = 'bp-no-sidebar';
	}
	return $classes;
}
add_filter( 'body_class', 'brickpoint_body_classes' );

/**
 * Excerpt length.
 *
 * @param int $length Length.
 * @return int
 */
function brickpoint_excerpt_length( $length ) {
	return 28;
}
add_filter( 'excerpt_length', 'brickpoint_excerpt_length', 999 );

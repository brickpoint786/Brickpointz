<?php
/**
 * Elementor integration: Theme Builder locations, CPT support, global defaults,
 * and custom BrickPoint widgets (WhatsApp order, locations, categories, CTA...).
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'after_setup_theme', 'brickpoint_elementor_setup' );
/**
 * Declare Elementor / Theme Builder support.
 */
function brickpoint_elementor_setup() {
	add_theme_support( 'elementor' );
	// Header/footer rendered via Elementor Pro Theme Builder when available.
	add_theme_support( 'header-footer-elementor' );
}

/**
 * Check whether Elementor (free) is active.
 *
 * @return bool
 */
function brickpoint_has_elementor() {
	return defined( 'ELEMENTOR_VERSION' );
}

/**
 * Check whether Elementor Pro Theme Builder locations are available.
 *
 * @return bool
 */
function brickpoint_has_elementor_pro() {
	return defined( 'ELEMENTOR_PRO_VERSION' );
}

add_action( 'elementor/init', 'brickpoint_elementor_init' );
/**
 * Elementor init: CPT support + category.
 */
function brickpoint_elementor_init() {
	// Allow Elementor editing on CPTs by default.
	$cpts = get_option( 'elementor_cpt_support', array( 'page', 'post' ) );
	foreach ( array( 'location', 'project', 'product' ) as $cpt ) {
		if ( ! in_array( $cpt, $cpts, true ) ) {
			$cpts[] = $cpt;
		}
	}
	update_option( 'elementor_cpt_support', $cpts );

	// Register widgets + category.
	add_action( 'elementor/widgets/register', 'brickpoint_register_widgets' );
	add_action( 'elementor/elements/categories_registered', 'brickpoint_widget_category' );
}

/**
 * Widget category.
 *
 * @param object $manager Category manager.
 */
function brickpoint_widget_category( $manager ) {
	$manager->add_category(
		'brickpoint',
		array( 'title' => __( 'BrickPoint', 'brickpoint' ) )
	);
}

/**
 * Register custom widgets.
 *
 * @param object $widgets_manager Widgets manager.
 */
function brickpoint_register_widgets( $widgets_manager ) {
	require_once BRICKPOINT_DIR . '/inc/elementor/widgets/class-widget-whatsapp-button.php';
	require_once BRICKPOINT_DIR . '/inc/elementor/widgets/class-widget-section-heading.php';
	require_once BRICKPOINT_DIR . '/inc/elementor/widgets/class-widget-location-grid.php';
	require_once BRICKPOINT_DIR . '/inc/elementor/widgets/class-widget-category-grid.php';
	require_once BRICKPOINT_DIR . '/inc/elementor/widgets/class-widget-cta-banner.php';
	require_once BRICKPOINT_DIR . '/inc/elementor/widgets/class-widget-feature-cards.php';

	$widgets_manager->register( new \BrickPoint_Widget_WhatsApp_Button() );
	$widgets_manager->register( new \BrickPoint_Widget_Section_Heading() );
	$widgets_manager->register( new \BrickPoint_Widget_Location_Grid() );
	$widgets_manager->register( new \BrickPoint_Widget_Category_Grid() );
	$widgets_manager->register( new \BrickPoint_Widget_CTA_Banner() );
	$widgets_manager->register( new \BrickPoint_Widget_Feature_Cards() );
}

/**
 * Render an Elementor Theme Builder location if available.
 *
 * @param string $location Location slug (header, footer, single, archive...).
 * @return bool Whether a location template was rendered.
 */
function brickpoint_elementor_location( $location ) {
	if ( ! brickpoint_has_elementor_pro() ) {
		return false;
	}
	if ( ! function_exists( 'elementor_theme_do_location' ) ) {
		return false;
	}
	$did = elementor_theme_do_location( $location );
	return (bool) $did;
}

/**
 * Whether current singular content is built with Elementor canvas.
 *
 * @return bool
 */
function brickpoint_is_elementor_page() {
	if ( ! brickpoint_has_elementor() ) {
		return false;
	}
	if ( ! is_singular() ) {
		return false;
	}
	$doc = \Elementor\Plugin::$instance->documents->get( get_the_ID() );
	return $doc && $doc->is_built_with_elementor();
}

/**
 * Seed Elementor Kit defaults (global colors + fonts) on first activation so the
 * visual output matches the original design out of the box. Only fills empty kit.
 */
function brickpoint_seed_elementor_kit() {
	if ( ! brickpoint_has_elementor() ) {
		return;
	}
	$kit_id = (int) get_option( 'elementor_active_kit', 0 );
	if ( ! $kit_id ) {
		$kit = \Elementor\Plugin::$instance->kits_manager->get_active_kit();
		if ( ! $kit ) {
			return;
		}
		$kit_id = $kit->get_id();
	}
	$colors = get_post_meta( $kit_id, '_elementor_page_settings', true );
	if ( ! is_array( $colors ) ) {
		$colors = array();
	}
	if ( empty( $colors['system_colors'] ) ) {
		$colors['system_colors'] = array(
			array( '_id' => 'bp_navy', 'title' => __( 'Navy', 'brickpoint' ), 'color' => '#0F1F3D' ),
			array( '_id' => 'bp_red', 'title' => __( 'Brick Red', 'brickpoint' ), 'color' => '#C0392B' ),
			array( '_id' => 'bp_gold', 'title' => __( 'Gold', 'brickpoint' ), 'color' => '#B8860B' ),
			array( '_id' => 'bp_dark', 'title' => __( 'Charcoal', 'brickpoint' ), 'color' => '#2C2C2C' ),
		);
	}
	if ( empty( $colors['system_typography'] ) ) {
		$colors['system_typography'] = array(
			array(
				'_id'                         => 'bp_primary',
				'title'                       => __( 'Primary', 'brickpoint' ),
				'typography_typography'       => 'custom',
				'typography_font_family'      => 'Inter',
				'typography_font_weight'      => '700',
			),
			array(
				'_id'                         => 'bp_text',
				'title'                       => __( 'Text', 'brickpoint' ),
				'typography_typography'       => 'custom',
				'typography_font_family'      => 'Inter',
				'typography_font_weight'      => '400',
			),
		);
	}
	if ( empty( $colors['container_width'] ) ) {
		$colors['container_width'] = array( 'unit' => 'px', 'size' => 1280 );
	}
	update_post_meta( $kit_id, '_elementor_page_settings', $colors );
}
add_action( 'after_switch_theme', 'brickpoint_seed_elementor_kit' );
add_action( 'elementor/init', 'brickpoint_seed_elementor_kit' );

/**
 * Admin notice prompting to install Elementor + WooCommerce.
 */
function brickpoint_plugin_notice() {
	if ( ! current_user_can( 'install_plugins' ) ) {
		return;
	}
	$missing = array();
	if ( ! brickpoint_has_elementor() ) {
		$missing[] = 'Elementor';
	}
	if ( ! class_exists( 'WooCommerce' ) ) {
		$missing[] = 'WooCommerce';
	}
	if ( ! $missing ) {
		return;
	}
	$screen = get_current_screen();
	if ( $screen && 'appearance_page_brickpoint-setup' === $screen->id ) {
		return;
	}
	echo '<div class="notice notice-warning"><p>';
	printf(
		/* translators: 1: plugins, 2: setup link */
		esc_html__( 'BrickPoint works best with %1$s. Visit the %2$s page to install them and import demo content.', 'brickpoint' ),
		esc_html( implode( ' + ', $missing ) ),
		'<a href="' . esc_url( admin_url( 'themes.php?page=brickpoint-setup' ) ) . '">' . esc_html__( 'BrickPoint Setup', 'brickpoint' ) . '</a>'
	);
	echo '</p></div>';
}
add_action( 'admin_notices', 'brickpoint_plugin_notice' );

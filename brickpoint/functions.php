<?php
/**
 * BrickPoint theme bootstrap.
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'BRICKPOINT_VERSION', '1.0.0' );
define( 'BRICKPOINT_DIR', get_template_directory() );
define( 'BRICKPOINT_URI', get_template_directory_uri() );

require BRICKPOINT_DIR . '/inc/helpers.php';
require BRICKPOINT_DIR . '/inc/theme-setup.php';
require BRICKPOINT_DIR . '/inc/enqueue.php';
require BRICKPOINT_DIR . '/inc/customizer.php';
require BRICKPOINT_DIR . '/inc/cpt.php';
require BRICKPOINT_DIR . '/inc/elementor.php';
require BRICKPOINT_DIR . '/inc/woocommerce.php';
require BRICKPOINT_DIR . '/inc/contact.php';
require BRICKPOINT_DIR . '/inc/demo-import.php';
require BRICKPOINT_DIR . '/inc/elementor/demo-content.php';

<?php
/**
 * Customizer: centralized global settings (contact info, WhatsApp, socials).
 * Page/section design stays in Elementor; only genuinely global data lives here.
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'customize_register', 'brickpoint_customize_register' );
/**
 * Register Customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer.
 */
function brickpoint_customize_register( $wp_customize ) {
	$defaults = brickpoint_defaults();

	$wp_customize->add_section(
		'brickpoint_settings',
		array(
			'title'    => __( 'BrickPoint Settings', 'brickpoint' ),
			'priority' => 30,
		)
	);

	$fields = array(
		'phone'         => array( 'label' => __( 'Phone Number', 'brickpoint' ), 'type' => 'text' ),
		'whatsapp'      => array( 'label' => __( 'WhatsApp Number (country code, no +)', 'brickpoint' ), 'type' => 'text' ),
		'email'         => array( 'label' => __( 'Email', 'brickpoint' ), 'type' => 'email' ),
		'ceo'           => array( 'label' => __( 'CEO Name', 'brickpoint' ), 'type' => 'text' ),
		'sales_manager' => array( 'label' => __( 'Sales Manager Name', 'brickpoint' ), 'type' => 'text' ),
		'company_1'     => array( 'label' => __( 'Company 1', 'brickpoint' ), 'type' => 'text' ),
		'company_2'     => array( 'label' => __( 'Company 2', 'brickpoint' ), 'type' => 'text' ),
		'address'       => array( 'label' => __( 'Address Summary', 'brickpoint' ), 'type' => 'text' ),
		'hours'         => array( 'label' => __( 'Business Hours', 'brickpoint' ), 'type' => 'text' ),
		'facebook'      => array( 'label' => __( 'Facebook URL', 'brickpoint' ), 'type' => 'url' ),
		'instagram'     => array( 'label' => __( 'Instagram URL', 'brickpoint' ), 'type' => 'url' ),
		'twitter'       => array( 'label' => __( 'X / Twitter URL', 'brickpoint' ), 'type' => 'url' ),
		'tiktok'        => array( 'label' => __( 'TikTok URL', 'brickpoint' ), 'type' => 'url' ),
		'whatsapp_channel' => array( 'label' => __( 'WhatsApp Channel URL', 'brickpoint' ), 'type' => 'url' ),
		'video_url'     => array( 'label' => __( 'Homepage Hero Video URL (MP4, optional)', 'brickpoint' ), 'type' => 'url' ),
	);

	foreach ( $fields as $key => $field ) {
		$sanitize = 'sanitize_text_field';
		if ( 'url' === $field['type'] || 'email' === $field['type'] ) {
			$sanitize = 'email' === $field['type'] ? 'sanitize_email' : 'esc_url_raw';
		}
		$wp_customize->add_setting(
			'brickpoint_' . $key,
			array(
				'default'           => isset( $defaults[ $key ] ) ? $defaults[ $key ] : '',
				'sanitize_callback' => $sanitize,
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			'brickpoint_' . $key,
			array(
				'label'   => $field['label'],
				'section' => 'brickpoint_settings',
				'type'    => 'text',
			)
		);
	}
}

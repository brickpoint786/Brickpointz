<?php
/**
 * Custom Post Types: Locations & Projects (editable, Elementor-compatible).
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'brickpoint_register_cpts' );
/**
 * Register CPTs.
 */
function brickpoint_register_cpts() {
	register_post_type(
		'location',
		array(
			'labels'       => array(
				'name'          => __( 'Locations', 'brickpoint' ),
				'singular_name' => __( 'Location', 'brickpoint' ),
				'add_new_item'  => __( 'Add New Location', 'brickpoint' ),
				'edit_item'     => __( 'Edit Location', 'brickpoint' ),
			),
			'public'       => true,
			'has_archive'  => false,
			'rewrite'      => array( 'slug' => 'location' ),
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'elementor' ),
			'show_in_rest' => true,
			'menu_icon'    => 'dashicons-location-alt',
		)
	);

	register_post_type(
		'project',
		array(
			'labels'       => array(
				'name'          => __( 'Projects', 'brickpoint' ),
				'singular_name' => __( 'Project', 'brickpoint' ),
				'add_new_item'  => __( 'Add New Project', 'brickpoint' ),
				'edit_item'     => __( 'Edit Project', 'brickpoint' ),
			),
			'public'       => true,
			'has_archive'  => false,
			'rewrite'      => array( 'slug' => 'project' ),
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'elementor' ),
			'show_in_rest' => true,
			'menu_icon'    => 'dashicons-portfolio',
		)
	);

	register_taxonomy(
		'project_category',
		'project',
		array(
			'labels'       => array(
				'name'          => __( 'Project Categories', 'brickpoint' ),
				'singular_name' => __( 'Project Category', 'brickpoint' ),
			),
			'public'       => true,
			'hierarchical' => true,
			'rewrite'      => array( 'slug' => 'project-category' ),
			'show_in_rest' => true,
		)
	);
}

/**
 * Meta keys for locations.
 *
 * @return array
 */
function brickpoint_location_meta_keys() {
	return array(
		'_bp_company'    => __( 'Company', 'brickpoint' ),
		'_bp_area'       => __( 'Area', 'brickpoint' ),
		'_bp_type'       => __( 'Type (factory/office)', 'brickpoint' ),
		'_bp_maps_link'  => __( 'Google Maps URL', 'brickpoint' ),
		'_bp_maps_embed' => __( 'Google Maps Embed URL', 'brickpoint' ),
		'_bp_address'    => __( 'Address', 'brickpoint' ),
		'_bp_phone'      => __( 'Phone', 'brickpoint' ),
		'_bp_hours'      => __( 'Opening Hours', 'brickpoint' ),
	);
}

/**
 * Meta keys for projects.
 *
 * @return array
 */
function brickpoint_project_meta_keys() {
	return array(
		'_bp_location'       => __( 'Location', 'brickpoint' ),
		'_bp_materials'      => __( 'Materials Used (comma separated)', 'brickpoint' ),
		'_bp_illustrative'   => __( 'Illustrative showcase (1/0)', 'brickpoint' ),
		'_bp_video'          => __( 'Video URL', 'brickpoint' ),
		'_bp_completion'     => __( 'Completion Info', 'brickpoint' ),
		'_bp_gallery'        => __( 'Gallery image URLs (one per line)', 'brickpoint' ),
	);
}

add_action( 'add_meta_boxes', 'brickpoint_add_meta_boxes' );
/**
 * Meta boxes.
 */
function brickpoint_add_meta_boxes() {
	add_meta_box( 'bp-location', __( 'Location Details', 'brickpoint' ), 'brickpoint_location_box', 'location', 'normal', 'high' );
	add_meta_box( 'bp-project', __( 'Project Details', 'brickpoint' ), 'brickpoint_project_box', 'project', 'normal', 'high' );
}

/**
 * Location meta box.
 *
 * @param WP_Post $post Post.
 */
function brickpoint_location_box( $post ) {
	wp_nonce_field( 'bp_location_save', 'bp_location_nonce' );
	foreach ( brickpoint_location_meta_keys() as $key => $label ) {
		$value = get_post_meta( $post->ID, $key, true );
		echo '<p><label style="display:block;font-weight:600;margin-bottom:4px;">' . esc_html( $label ) . '</label>';
		if ( '_bp_type' === $key ) {
			echo '<select name="' . esc_attr( $key ) . '" style="width:100%;max-width:400px;">';
			foreach ( array( 'factory', 'office' ) as $opt ) {
				echo '<option value="' . esc_attr( $opt ) . '"' . selected( $value, $opt, false ) . '>' . esc_html( ucfirst( $opt ) ) . '</option>';
			}
			echo '</select>';
		} elseif ( in_array( $key, array( '_bp_maps_embed', '_bp_address' ), true ) ) {
			echo '<textarea name="' . esc_attr( $key ) . '" rows="2" style="width:100%;max-width:600px;">' . esc_textarea( $value ) . '</textarea>';
		} else {
			echo '<input type="text" name="' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '" style="width:100%;max-width:600px;" />';
		}
		echo '</p>';
	}
}

/**
 * Project meta box.
 *
 * @param WP_Post $post Post.
 */
function brickpoint_project_box( $post ) {
	wp_nonce_field( 'bp_project_save', 'bp_project_nonce' );
	foreach ( brickpoint_project_meta_keys() as $key => $label ) {
		$value = get_post_meta( $post->ID, $key, true );
		echo '<p><label style="display:block;font-weight:600;margin-bottom:4px;">' . esc_html( $label ) . '</label>';
		if ( '_bp_illustrative' === $key ) {
			echo '<select name="' . esc_attr( $key ) . '"><option value="1"' . selected( $value, '1', false ) . '>Yes</option><option value="0"' . selected( $value, '0', false ) . '>No</option></select>';
		} elseif ( '_bp_gallery' === $key ) {
			echo '<textarea name="' . esc_attr( $key ) . '" rows="3" style="width:100%;max-width:600px;" placeholder="https://...">' . esc_textarea( $value ) . '</textarea>';
		} else {
			echo '<input type="text" name="' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '" style="width:100%;max-width:600px;" />';
		}
		echo '</p>';
	}
}

add_action( 'save_post', 'brickpoint_save_meta' );
/**
 * Save meta.
 *
 * @param int $post_id Post ID.
 */
function brickpoint_save_meta( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( isset( $_POST['bp_location_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['bp_location_nonce'] ) ), 'bp_location_save' ) ) {
		if ( current_user_can( 'edit_post', $post_id ) ) {
			foreach ( array_keys( brickpoint_location_meta_keys() ) as $key ) {
				if ( isset( $_POST[ $key ] ) ) {
					$val = wp_unslash( $_POST[ $key ] );
					if ( '_bp_maps_link' === $key || '_bp_maps_embed' === $key ) {
						update_post_meta( $post_id, $key, esc_url_raw( $val ) );
					} else {
						update_post_meta( $post_id, $key, sanitize_text_field( $val ) );
					}
				}
			}
		}
	}
	if ( isset( $_POST['bp_project_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['bp_project_nonce'] ) ), 'bp_project_save' ) ) {
		if ( current_user_can( 'edit_post', $post_id ) ) {
			foreach ( array_keys( brickpoint_project_meta_keys() ) as $key ) {
				if ( isset( $_POST[ $key ] ) ) {
					$val = wp_unslash( $_POST[ $key ] );
					if ( '_bp_video' === $key ) {
						update_post_meta( $post_id, $key, esc_url_raw( $val ) );
					} elseif ( '_bp_gallery' === $key ) {
						update_post_meta( $post_id, $key, sanitize_textarea_field( $val ) );
					} else {
						update_post_meta( $post_id, $key, sanitize_text_field( $val ) );
					}
				}
			}
		}
	}
}

/**
 * Get all locations ordered.
 *
 * @param string $type Optional filter: factory|office.
 * @return WP_Post[]
 */
function brickpoint_get_locations( $type = '' ) {
	$args = array(
		'post_type'      => 'location',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'post_status'    => 'publish',
	);
	if ( $type ) {
		$args['meta_query'] = array(
			array( 'key' => '_bp_type', 'value' => $type ),
		);
	}
	return get_posts( $args );
}

/**
 * Get all projects.
 *
 * @return WP_Post[]
 */
function brickpoint_get_projects() {
	return get_posts(
		array(
			'post_type'      => 'project',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'post_status'    => 'publish',
		)
	);
}

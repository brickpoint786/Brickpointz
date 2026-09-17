<?php
/**
 * Elementor widget: BrickPoint locations grid (dynamic from Locations CPT).
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Location grid widget.
 */
class BrickPoint_Widget_Location_Grid extends \Elementor\Widget_Base {

	/**
	 * Name.
	 */
	public function get_name() {
		return 'brickpoint-location-grid';
	}

	/**
	 * Title.
	 */
	public function get_title() {
		return __( 'BrickPoint Locations', 'brickpoint' );
	}

	/**
	 * Icon.
	 */
	public function get_icon() {
		return 'eicon-google-maps';
	}

	/**
	 * Categories.
	 */
	public function get_categories() {
		return array( 'brickpoint' );
	}

	/**
	 * Controls.
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'content',
			array( 'label' => __( 'Content', 'brickpoint' ) )
		);
		$this->add_control(
			'type',
			array(
				'label'   => __( 'Show', 'brickpoint' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					''        => __( 'All Locations', 'brickpoint' ),
					'factory' => __( 'Factories Only', 'brickpoint' ),
					'office'  => __( 'Offices Only', 'brickpoint' ),
				),
			)
		);
		$this->add_control(
			'layout',
			array(
				'label'   => __( 'Layout', 'brickpoint' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'cards',
				'options' => array(
					'cards'   => __( 'Factory Cards', 'brickpoint' ),
					'glance'  => __( 'Compact (At a Glance)', 'brickpoint' ),
				),
			)
		);
		$this->add_control(
			'columns',
			array(
				'label'   => __( 'Columns (desktop)', 'brickpoint' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '3',
				'options' => array(
					'2' => '2',
					'3' => '3',
					'4' => '4',
				),
			)
		);
		$this->end_controls_section();
	}

	/**
	 * Render.
	 */
	protected function render() {
		$s = $this->get_settings_for_display();
		$locations = brickpoint_get_locations( $s['type'] );
		if ( ! $locations ) {
			echo '<p>' . esc_html__( 'No locations found. Add them under Locations in the WordPress admin.', 'brickpoint' ) . '</p>';
			return;
		}
		$phone = brickpoint_get( 'phone' );
		$cols  = absint( $s['columns'] );
		$grid_style = 'grid-template-columns:repeat(' . $cols . ',1fr)';
		if ( 'glance' === $s['layout'] ) {
			echo '<div class="bp-glance-grid" style="' . esc_attr( $grid_style ) . '">';
			foreach ( $locations as $loc ) {
				$name = $loc->post_title;
				$area = get_post_meta( $loc->ID, '_bp_area', true );
				$link = get_post_meta( $loc->ID, '_bp_maps_link', true );
				$type = get_post_meta( $loc->ID, '_bp_type', true );
				echo '<a class="bp-glance-card" href="' . esc_url( $link ) . '" target="_blank" rel="noopener noreferrer">';
				echo '<div class="bp-glance-tag">' . brickpoint_icon( 'map-pin', 16 ) . '<span>' . ( 'office' === $type ? esc_html__( 'Office', 'brickpoint' ) : esc_html__( 'Factory', 'brickpoint' ) ) . '</span></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo '<h3>' . esc_html( $name ) . '</h3>';
				if ( $area ) {
					echo '<p>' . esc_html( $area ) . '</p>';
				}
				echo '<div class="bp-glance-link">' . esc_html__( 'Open in Maps', 'brickpoint' ) . ' ' . brickpoint_icon( 'external', 10 ) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo '</a>';
			}
			echo '</div>';
			return;
		}

		echo '<div class="bp-grid-3" style="' . esc_attr( $grid_style ) . '">';
		foreach ( $locations as $loc ) {
			$name    = $loc->post_title;
			$company = get_post_meta( $loc->ID, '_bp_company', true );
			$area    = get_post_meta( $loc->ID, '_bp_area', true );
			$link    = get_post_meta( $loc->ID, '_bp_maps_link', true );
			echo '<div class="bp-loc-card">';
			echo '<div class="bp-loc-map"><img class="bg" src="' . brickpoint_img( 'brick-factory.jpg' ) . '" alt="" loading="lazy">';
			echo '<div class="bp-loc-pin-wrap"><div class="bp-loc-pin">' . brickpoint_icon( 'map-pin', 28 ) . '</div><p>' . ( $area ? esc_html( $area ) : esc_html__( 'View on Map', 'brickpoint' ) ) . '</p></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo '<span class="bp-badge bp-badge-ss7 bp-card-flag-tl" style="border-radius:4px">' . esc_html__( 'Brick Factory', 'brickpoint' ) . '</span></div>';
			echo '<div class="bp-loc-body"><div class="bp-loc-head"><div class="bp-loc-icon">' . brickpoint_icon( 'building', 20 ) . '</div><div><h3>' . esc_html( $name ) . '</h3><small>' . esc_html( $company ) . '</small></div></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			if ( $area ) {
				echo '<div class="bp-loc-area">' . brickpoint_icon( 'map-pin', 14 ) . '<span>' . esc_html( $area ) . '</span></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			echo '<div class="bp-loc-actions"><a class="bp-btn bp-btn-navy" href="' . esc_url( $link ) . '" target="_blank" rel="noopener noreferrer">' . brickpoint_icon( 'navigation', 14 ) . esc_html__( 'Get Directions', 'brickpoint' ) . '</a>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo '<a class="bp-btn bp-btn-outline-navy bp-icon-only" href="tel:' . esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ) . '" aria-label="' . esc_attr__( 'Call', 'brickpoint' ) . '">' . brickpoint_icon( 'phone', 14 ) . '</a></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo '</div></div>';
		}
		echo '</div>';
	}
}

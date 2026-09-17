<?php
/**
 * Elementor widget: BrickPoint product category grid.
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Category grid widget.
 */
class BrickPoint_Widget_Category_Grid extends \Elementor\Widget_Base {

	/**
	 * Name.
	 */
	public function get_name() {
		return 'brickpoint-category-grid';
	}

	/**
	 * Title.
	 */
	public function get_title() {
		return __( 'BrickPoint Categories', 'brickpoint' );
	}

	/**
	 * Icon.
	 */
	public function get_icon() {
		return 'eicon-gallery-grid';
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
			'show_desc',
			array(
				'label'   => __( 'Show Descriptions', 'brickpoint' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);
		$this->add_control(
			'source',
			array(
				'label'   => __( 'Source', 'brickpoint' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'theme',
				'options' => array(
					'theme' => __( 'BrickPoint Catalog (14 categories)', 'brickpoint' ),
					'woo'   => __( 'WooCommerce Product Categories', 'brickpoint' ),
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
		echo '<div class="bp-cat-grid">';
		if ( 'woo' === $s['source'] && class_exists( 'WooCommerce' ) ) {
			$terms = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => false, 'parent' => 0 ) );
			if ( $terms && ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					$thumb_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
					$img = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'brickpoint-card' ) : brickpoint_img( 'hero-bricks.jpg' );
					echo '<a class="bp-cat-card" href="' . esc_url( get_term_link( $term ) ) . '">';
					echo '<div class="bp-cat-img"><img src="' . esc_url( $img ) . '" alt="' . esc_attr( $term->name ) . '" loading="lazy"><div class="bp-cat-shade"></div></div>';
					echo '<div class="bp-cat-body"><h3>' . esc_html( $term->name ) . '</h3>';
					if ( $s['show_desc'] && $term->description ) {
						echo '<p class="bp-clamp-2">' . esc_html( wp_strip_all_tags( $term->description ) ) . '</p>';
					}
					echo '</div></a>';
				}
			}
			echo '</div>';
			return;
		}
		foreach ( brickpoint_category_meta() as $cat ) {
			echo '<a class="bp-cat-card" href="' . esc_url( brickpoint_cat_url( $cat['slug'] ) ) . '">';
			echo '<div class="bp-cat-img"><img src="' . brickpoint_img( $cat['image'] ) . '" alt="' . esc_attr( $cat['name'] ) . '" loading="lazy"><div class="bp-cat-shade"></div>';
			if ( $cat['badge'] ) {
				echo '<span class="bp-cat-flag">' . esc_html( $cat['badge'] ) . '</span>';
			}
			echo '<span class="bp-cat-emoji">' . esc_html( $cat['icon'] ) . '</span></div>';
			echo '<div class="bp-cat-body"><h3>' . esc_html( $cat['name'] ) . '</h3>';
			if ( $s['show_desc'] ) {
				echo '<p class="bp-clamp-2">' . esc_html( $cat['desc'] ) . '</p>';
			}
			echo '</div></a>';
		}
		echo '</div>';
	}
}

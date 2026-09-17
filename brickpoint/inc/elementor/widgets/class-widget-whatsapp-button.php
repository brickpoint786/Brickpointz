<?php
/**
 * Elementor widget: BrickPoint WhatsApp order button.
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WhatsApp button widget.
 */
class BrickPoint_Widget_WhatsApp_Button extends \Elementor\Widget_Base {

	/**
	 * Name.
	 */
	public function get_name() {
		return 'brickpoint-whatsapp-button';
	}

	/**
	 * Title.
	 */
	public function get_title() {
		return __( 'BrickPoint WhatsApp Button', 'brickpoint' );
	}

	/**
	 * Icon.
	 */
	public function get_icon() {
		return 'eicon-button';
	}

	/**
	 * Categories.
	 */
	public function get_categories() {
		return array( 'brickpoint' );
	}

	/**
	 * Keywords.
	 */
	public function get_keywords() {
		return array( 'whatsapp', 'order', 'button', 'brickpoint' );
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
			'label',
			array(
				'label'   => __( 'Button Label', 'brickpoint' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Order on WhatsApp', 'brickpoint' ),
			)
		);
		$this->add_control(
			'mode',
			array(
				'label'   => __( 'Behavior', 'brickpoint' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'modal',
				'options' => array(
					'modal'  => __( 'Open order popup (quantity/location)', 'brickpoint' ),
					'direct' => __( 'Direct WhatsApp chat link', 'brickpoint' ),
				),
			)
		);
		$this->add_control(
			'product',
			array(
				'label'   => __( 'Product Name (for message)', 'brickpoint' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'SS7 Bricks',
			)
		);
		$this->add_control(
			'category',
			array(
				'label'   => __( 'Category (for message)', 'brickpoint' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Bricks', 'brickpoint' ),
			)
		);
		$this->add_control(
			'price',
			array(
				'label'   => __( 'Price Text (for message)', 'brickpoint' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Price on Request', 'brickpoint' ),
			)
		);
		$this->add_control(
			'variant',
			array(
				'label'   => __( 'Style', 'brickpoint' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'primary',
				'options' => array(
					'primary' => __( 'WhatsApp Green', 'brickpoint' ),
					'outline' => __( 'Outline Green', 'brickpoint' ),
					'small'   => __( 'Small', 'brickpoint' ),
				),
			)
		);
		$this->add_control(
			'align',
			array(
				'label'   => __( 'Alignment', 'brickpoint' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => array(
					'left'   => array( 'title' => __( 'Left', 'brickpoint' ), 'icon' => 'eicon-text-align-left' ),
					'center' => array( 'title' => __( 'Center', 'brickpoint' ), 'icon' => 'eicon-text-align-center' ),
					'right'  => array( 'title' => __( 'Right', 'brickpoint' ), 'icon' => 'eicon-text-align-right' ),
				),
				'default' => 'left',
				'selectors' => array(
					'{{WRAPPER}} .bp-el-wa-wrap' => 'text-align: {{VALUE}};',
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
		$class = 'bp-btn bp-btn-wa';
		if ( 'outline' === $s['variant'] ) {
			$class = 'bp-btn bp-btn-outline-wa';
		} elseif ( 'small' === $s['variant'] ) {
			$class = 'bp-btn bp-btn-wa bp-btn-sm';
		}
		echo '<div class="bp-el-wa-wrap">';
		if ( 'direct' === $s['mode'] ) {
			echo '<a class="' . esc_attr( $class ) . '" href="' . brickpoint_whatsapp_link( brickpoint_product_message( $s['product'], $s['category'], $s['price'] ) ) . '" target="_blank" rel="noopener noreferrer">';
			echo brickpoint_icon( 'whatsapp', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo esc_html( $s['label'] ) . '</a>';
		} else {
			echo '<button type="button" class="' . esc_attr( $class ) . '" data-bp-order data-product="' . esc_attr( $s['product'] ) . '" data-category="' . esc_attr( $s['category'] ) . '" data-price="' . esc_attr( $s['price'] ) . '">';
			echo brickpoint_icon( 'whatsapp', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo esc_html( $s['label'] ) . '</button>';
		}
		echo '</div>';
	}
}

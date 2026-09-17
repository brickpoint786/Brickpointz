<?php
/**
 * Elementor widget: BrickPoint red CTA banner.
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * CTA banner widget.
 */
class BrickPoint_Widget_CTA_Banner extends \Elementor\Widget_Base {

	/**
	 * Name.
	 */
	public function get_name() {
		return 'brickpoint-cta-banner';
	}

	/**
	 * Title.
	 */
	public function get_title() {
		return __( 'BrickPoint CTA Banner', 'brickpoint' );
	}

	/**
	 * Icon.
	 */
	public function get_icon() {
		return 'eicon-call-to-action';
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
			'title',
			array(
				'label'   => __( 'Heading', 'brickpoint' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Ready to Start Your Project?', 'brickpoint' ),
			)
		);
		$this->add_control(
			'sub',
			array(
				'label'   => __( 'Sub Text', 'brickpoint' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'Contact BrickPoint today for SS7 bricks and quality construction materials. Our sales team is ready to help.', 'brickpoint' ),
			)
		);
		$this->add_control(
			'note',
			array(
				'label'   => __( 'Bottom Note', 'brickpoint' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'CEO: Syed Iftikhar Haider | Sales Manager: Qasim Iqbal', 'brickpoint' ),
			)
		);
		$this->add_control(
			'primary_label',
			array(
				'label'   => __( 'Primary Button Label', 'brickpoint' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Order on WhatsApp', 'brickpoint' ),
			)
		);
		$this->add_control(
			'show_call',
			array(
				'label'   => __( 'Show Call Button', 'brickpoint' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'style',
			array(
				'label' => __( 'Style', 'brickpoint' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'bg',
			array(
				'label'     => __( 'Background Color', 'brickpoint' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#C0392B',
				'selectors' => array( '{{WRAPPER}} .bp-el-cta' => 'background-color: {{VALUE}};' ),
			)
		);
		$this->end_controls_section();
	}

	/**
	 * Render.
	 */
	protected function render() {
		$s = $this->get_settings_for_display();
		$phone = brickpoint_get( 'phone' );
		echo '<section class="bp-cta bp-pattern-diag bp-el-cta"><div class="bp-cta-box">';
		echo '<h2>' . esc_html( $s['title'] ) . '</h2>';
		echo '<p class="bp-cta-sub">' . esc_html( $s['sub'] ) . '</p>';
		echo '<div class="bp-cta-btns">';
		echo '<a class="bp-btn bp-btn-white bp-btn-lg" href="' . brickpoint_whatsapp_link() . '" target="_blank" rel="noopener noreferrer">' . brickpoint_icon( 'whatsapp', 18 ) . esc_html( $s['primary_label'] ) . '</a>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		if ( $s['show_call'] ) {
			echo '<a class="bp-btn bp-btn-outline-w bp-btn-lg" href="tel:' . esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ) . '">' . brickpoint_icon( 'phone', 18 ) . sprintf( esc_html__( 'Call %s', 'brickpoint' ), esc_html( $phone ) ) . '</a>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		echo '</div>';
		if ( $s['note'] ) {
			echo '<p class="bp-cta-note">' . esc_html( $s['note'] ) . '</p>';
		}
		echo '</div></section>';
	}
}

<?php
/**
 * Elementor widget: BrickPoint section heading (eyebrow + title + lead).
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Section heading widget.
 */
class BrickPoint_Widget_Section_Heading extends \Elementor\Widget_Base {

	/**
	 * Name.
	 */
	public function get_name() {
		return 'brickpoint-section-heading';
	}

	/**
	 * Title.
	 */
	public function get_title() {
		return __( 'BrickPoint Section Heading', 'brickpoint' );
	}

	/**
	 * Icon.
	 */
	public function get_icon() {
		return 'eicon-heading';
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
			'eyebrow',
			array(
				'label'   => __( 'Eyebrow (small red label)', 'brickpoint' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Who We Are', 'brickpoint' ),
			)
		);
		$this->add_control(
			'title',
			array(
				'label'   => __( 'Heading', 'brickpoint' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'Quality Materials. Stronger Foundations.', 'brickpoint' ),
			)
		);
		$this->add_control(
			'lead',
			array(
				'label'   => __( 'Sub Text', 'brickpoint' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => '',
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
				),
				'default' => 'center',
			)
		);
		$this->add_control(
			'dark',
			array(
				'label'   => __( 'On Dark Background', 'brickpoint' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
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
			'title_color',
			array(
				'label'     => __( 'Heading Color', 'brickpoint' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .bp-el-h' => 'color: {{VALUE}};' ),
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .bp-el-h',
			)
		);
		$this->end_controls_section();
	}

	/**
	 * Render.
	 */
	protected function render() {
		$s = $this->get_settings_for_display();
		$align = 'center' === $s['align'] ? 'text-align:center;margin-left:auto;margin-right:auto' : 'text-align:left';
		$h_class = 'bp-h2 bp-el-h' . ( $s['dark'] ? ' bp-h2-light' : '' );
		$lead_class = 'bp-lead' . ( $s['dark'] ? ' bp-lead-light' : '' );
		echo '<div style="' . esc_attr( $align ) . '">';
		if ( $s['eyebrow'] ) {
			echo '<p class="bp-eyebrow">' . esc_html( $s['eyebrow'] ) . '</p>';
		}
		if ( $s['title'] ) {
			echo '<h2 class="' . esc_attr( $h_class ) . '">' . esc_html( $s['title'] ) . '</h2>';
		}
		if ( $s['lead'] ) {
			$style = 'center' === $s['align'] ? 'max-width:640px;margin-left:auto;margin-right:auto' : '';
			echo '<p class="' . esc_attr( $lead_class ) . '" style="' . esc_attr( $style ) . '">' . esc_html( $s['lead'] ) . '</p>';
		}
		echo '</div>';
	}
}

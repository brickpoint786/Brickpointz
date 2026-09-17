<?php
/**
 * Elementor widget: BrickPoint feature cards (repeater).
 *
 * @package BrickPoint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Feature cards widget.
 */
class BrickPoint_Widget_Feature_Cards extends \Elementor\Widget_Base {

	/**
	 * Name.
	 */
	public function get_name() {
		return 'brickpoint-feature-cards';
	}

	/**
	 * Title.
	 */
	public function get_title() {
		return __( 'BrickPoint Feature Cards', 'brickpoint' );
	}

	/**
	 * Icon.
	 */
	public function get_icon() {
		return 'eicon-icon-box';
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
			array( 'label' => __( 'Cards', 'brickpoint' ) )
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'icon',
			array(
				'label'   => __( 'Icon', 'brickpoint' ),
				'type'    => \Elementor\Controls_Manager::ICONS,
				'default' => array( 'value' => 'fas fa-shield-alt', 'library' => 'fa-solid' ),
			)
		);
		$repeater->add_control(
			'title',
			array(
				'label'   => __( 'Title', 'brickpoint' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Quality Focus', 'brickpoint' ),
			)
		);
		$repeater->add_control(
			'desc',
			array(
				'label'   => __( 'Description', 'brickpoint' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'Description text.', 'brickpoint' ),
			)
		);
		$this->add_control(
			'cards',
			array(
				'label'       => __( 'Feature Cards', 'brickpoint' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array( 'title' => __( 'Quality Focus', 'brickpoint' ), 'desc' => __( 'We source and supply materials that meet consistent quality standards, starting with our signature SS7 branded bricks.', 'brickpoint' ) ),
					array( 'title' => __( 'Reliable Supply', 'brickpoint' ), 'desc' => __( 'Dependable material availability and delivery coordination for uninterrupted construction progress.', 'brickpoint' ) ),
					array( 'title' => __( 'Construction Expertise', 'brickpoint' ), 'desc' => __( 'Deep knowledge of construction materials allows us to help you find the right product for every application.', 'brickpoint' ) ),
					array( 'title' => __( 'Customer Support', 'brickpoint' ), 'desc' => __( 'Direct WhatsApp and phone access to our team. We are available to answer your inquiries promptly.', 'brickpoint' ) ),
				),
				'title_field' => '{{{ title }}}',
			)
		);
		$this->add_control(
			'columns',
			array(
				'label'   => __( 'Columns (desktop)', 'brickpoint' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '4',
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
		$cols = absint( $s['columns'] );
		echo '<div class="bp-grid-4" style="grid-template-columns:repeat(' . esc_attr( $cols ) . ',1fr)">';
		foreach ( (array) $s['cards'] as $card ) {
			echo '<div class="bp-feature-card"><div class="bp-feature-icon">';
			if ( ! empty( $card['icon']['value'] ) ) {
				\Elementor\Icons_Manager::render_icon( $card['icon'], array( 'aria-hidden' => 'true' ) );
			}
			echo '</div><h3>' . esc_html( $card['title'] ) . '</h3><p>' . esc_html( $card['desc'] ) . '</p></div>';
		}
		echo '</div>';
	}
}

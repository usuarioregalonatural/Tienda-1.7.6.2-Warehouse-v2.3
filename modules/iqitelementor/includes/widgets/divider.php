<?php
namespace Elementor;

if ( ! defined( 'ELEMENTOR_ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Divider extends Widget_Base {

	public function get_id() {
		return 'divider';
	}

	public function get_title() {
		return \IqitElementorWpHelper::__( 'Divider', 'elementor' );
	}

	public function get_icon() {
		return 'divider';
	}

	protected function _register_controls() {
		$this->add_control(
			'section_divider',
			[
				'label' => \IqitElementorWpHelper::__( 'Divider', 'elementor' ),
				'type' => Controls_Manager::SECTION,
			]
		);

		$this->add_control(
			'style',
			[
				'label' => \IqitElementorWpHelper::__( 'Style', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'section' => 'section_divider',
				'options' => [
					'solid' => \IqitElementorWpHelper::__( 'Solid', 'elementor' ),
					'double' => \IqitElementorWpHelper::__( 'Double', 'elementor' ),
					'dotted' => \IqitElementorWpHelper::__( 'Dotted', 'elementor' ),
					'dashed' => \IqitElementorWpHelper::__( 'Dashed', 'elementor' ),
				],
				'default' => 'solid',
				'selectors' => [
					'{{WRAPPER}} .elementor-divider-separator' => 'border-top-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'weight',
			[
				'label' => \IqitElementorWpHelper::__( 'Weight', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'section' => 'section_divider',
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-divider-separator' => 'border-top-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'color',
			[
				'label' => \IqitElementorWpHelper::__( 'Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'section' => 'section_divider',
				'default' => '',
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-divider-separator' => 'border-top-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'width',
			[
				'label' => \IqitElementorWpHelper::__( 'Width', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 100,
					'unit' => '%',
				],
				'section' => 'section_divider',
				'selectors' => [
					'{{WRAPPER}} .elementor-divider-separator' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => \IqitElementorWpHelper::__( 'Alignment', 'elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'section' => 'section_divider',
				'options' => [
					'left'    => [
						'title' => \IqitElementorWpHelper::__( 'Left', 'elementor' ),
						'icon' => 'align-left',
					],
					'center' => [
						'title' => \IqitElementorWpHelper::__( 'Center', 'elementor' ),
						'icon' => 'align-center',
					],
					'right' => [
						'title' => \IqitElementorWpHelper::__( 'Right', 'elementor' ),
						'icon' => 'align-right',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-divider' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'gap',
			[
				'label' => \IqitElementorWpHelper::__( 'Gap', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 15,
				],
				'range' => [
					'px' => [
						'min' => 2,
						'max' => 50,
					],
				],
				'section' => 'section_divider',
				'selectors' => [
					'{{WRAPPER}} .elementor-divider' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'view',
			[
				'label' => \IqitElementorWpHelper::__( 'View', 'elementor' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
				'section' => 'section_divider',
			]
		);
	}

	protected function render( $instance = [] ) {
		?>
		<div class="elementor-divider">
			<span class="elementor-divider-separator"></span>
		</div>
		<?php
	}

	protected function content_template() {
		?>
		<div class="elementor-divider">
			<span class="elementor-divider-separator"></span>
		</div>
		<?php
	}
}

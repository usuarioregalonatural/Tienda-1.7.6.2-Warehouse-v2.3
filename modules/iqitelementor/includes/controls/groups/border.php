<?php
namespace Elementor;

if ( ! defined( 'ELEMENTOR_ABSPATH' ) ) exit; // Exit if accessed directly

class Group_Control_Border extends Group_Control_Base {


	public static function get_type() {
		return 'border';
	}

	protected function _get_controls( $args ) {
		$controls = [];

        $property = 'border';
        if ( isset($args['property']) && ($args['property']  == 'outline') ) {
            $property = 'outline';
        }


		$controls['border'] = [
			'label' => \IqitElementorWpHelper::_x( 'Border Type', 'Border Control', 'elementor' ),
			'type' => Controls_Manager::SELECT,
			'options' => [
				'' => \IqitElementorWpHelper::__( 'None', 'elementor' ),
				'solid' => \IqitElementorWpHelper::_x( 'Solid', 'Border Control', 'elementor' ),
				'double' => \IqitElementorWpHelper::_x( 'Double', 'Border Control', 'elementor' ),
				'dotted' => \IqitElementorWpHelper::_x( 'Dotted', 'Border Control', 'elementor' ),
				'dashed' => \IqitElementorWpHelper::_x( 'Dashed', 'Border Control', 'elementor' ),
			],
			'selectors' => [
				$args['selector'] => $property . '-style: {{VALUE}};',
			],
			'separator' => 'before',
		];

		$controls['width'] = [
			'label' => \IqitElementorWpHelper::_x( 'Width', 'Border Control', 'elementor' ),
			'type' => Controls_Manager::DIMENSIONS,
			'selectors' => [
				$args['selector'] => $property . '-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
			'condition' => [
				'border!' => '',
			],
		];

		$controls['color'] = [
			'label' => \IqitElementorWpHelper::_x( 'Color', 'Border Control', 'elementor' ),
			'type' => Controls_Manager::COLOR,
			'default' => '',
			'tab' => $args['tab'],
			'selectors' => [
				$args['selector'] => $property . '-color: {{VALUE}};',
			],
			'condition' => [
				'border!' => '',
			],
		];

		return $controls;
	}
}

<?php
namespace Elementor;

if ( ! defined( 'ELEMENTOR_ABSPATH' ) ) exit; // Exit if accessed directly

class Group_Control_Box_Shadow extends Group_Control_Base {

	public static function get_type() {
		return 'box-shadow';
	}

	protected function _get_controls( $args ) {
		$controls = [];

		$controls['box_shadow_type'] = [
			'label' => \IqitElementorWpHelper::_x( 'Box Shadow', 'Box Shadow Control', 'elementor' ),
			'type' => Controls_Manager::SELECT,
			'options' => [
				'' => \IqitElementorWpHelper::__( 'No', 'elementor' ),
				'outset' => \IqitElementorWpHelper::_x( 'Yes', 'Box Shadow Control', 'elementor' ),
			],
			'separator' => 'before',
		];

		$controls['box_shadow'] = [
			'label' => \IqitElementorWpHelper::_x( 'Box Shadow', 'Box Shadow Control', 'elementor' ),
			'type' => Controls_Manager::BOX_SHADOW,
			'selectors' => [
				$args['selector'] => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}};',
			],
			'condition' => [
				'box_shadow_type!' => '',
			],
		];

		return $controls;
	}
}

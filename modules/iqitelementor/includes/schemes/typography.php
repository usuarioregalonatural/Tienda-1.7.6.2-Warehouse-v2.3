<?php
namespace Elementor;

if ( ! defined( 'ELEMENTOR_ABSPATH' ) ) exit; // Exit if accessed directly

class Scheme_Typography extends Scheme_Base {

	const TYPOGRAPHY_1 = '1';
	const TYPOGRAPHY_2 = '2';
	const TYPOGRAPHY_3 = '3';
	const TYPOGRAPHY_4 = '4';

	public static function get_type() {
		return 'typography';
	}

	public function get_title() {
		return \IqitElementorWpHelper::__( 'Typography', 'elementor' );
	}

	public function get_disabled_title() {
		return \IqitElementorWpHelper::__( 'Default Fonts', 'elementor' );
	}

	public function get_scheme_titles() {
		return [
			self::TYPOGRAPHY_1 => \IqitElementorWpHelper::__( 'Primary Headline', 'elementor' ),
			self::TYPOGRAPHY_2 => \IqitElementorWpHelper::__( 'Secondary Headline', 'elementor' ),
			self::TYPOGRAPHY_3 => \IqitElementorWpHelper::__( 'Body Text', 'elementor' ),
			self::TYPOGRAPHY_4 => \IqitElementorWpHelper::__( 'Accent Text', 'elementor' ),
		];
	}

	public function get_default_scheme() {
		return [
			self::TYPOGRAPHY_1 => [
				'font_family' => 'Roboto',
				'font_weight' => '600',
			],
			self::TYPOGRAPHY_2 => [
				'font_family' => 'Roboto Slab',
				'font_weight' => '400',
			],
			self::TYPOGRAPHY_3 => [
				'font_family' => 'Roboto',
				'font_weight' => '400',
			],
			self::TYPOGRAPHY_4 => [
				'font_family' => 'Roboto',
				'font_weight' => '500',
			],
		];
	}

	public static function get_system_schemes() {
		return [];
	}
}

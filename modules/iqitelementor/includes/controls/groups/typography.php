<?php
namespace Elementor;

if ( ! defined( 'ELEMENTOR_ABSPATH' ) ) exit; // Exit if accessed directly

class Group_Control_Typography extends Group_Control_Base {

	private static $_fields;

	private static $_scheme_fields_keys = [ 'font_family', 'font_weight' ];

	public static function get_scheme_fields_keys() {
		return self::$_scheme_fields_keys;
	}

	public static function get_type() {
		return 'typography';
	}

	public static function get_fields() {
		if ( null === self::$_fields ) {
			self::_init_fields();
		}

		return self::$_fields;
	}

	private static function _init_fields() {
		$fields = [];

		$fields['font_size'] = [
			'label' => \IqitElementorWpHelper::_x( 'Size', 'Typography Control', 'elementor' ),
			'type' => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em', 'rem' ],
			'range' => [
				'px' => [
					'min' => 1,
					'max' => 200,
				],
			],
			'responsive' => true,
			'selector_value' => 'font-size: {{SIZE}}{{UNIT}}',
		];

		$default_fonts = 'Sans-serif';

		if ( $default_fonts ) {
			$default_fonts = ', ' . $default_fonts;
		}

		$fields['font_family'] = [
			'label' => \IqitElementorWpHelper::_x( 'Family', 'Typography Control', 'elementor' ),
			'type' => Controls_Manager::FONT,
			'default' => '',
			'selector_value' => 'font-family: {{VALUE}}' . $default_fonts . ';',
		];

        $fields['font_family_custom'] = [
            'label' => \IqitElementorWpHelper::_x( 'Custom font family', 'Typography Control', 'elementor' ),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'selector_value' => 'font-family: {{VALUE}}' . $default_fonts . ';',
        ];



		$typo_weight_options = [ '' => \IqitElementorWpHelper::__( 'Default', 'elementor' ) ];
		foreach ( array_merge( [ 'normal', 'bold' ], range( 100, 900, 100 ) ) as $weight ) {
			$typo_weight_options[ $weight ] = ucfirst( $weight );
		}

		$fields['font_weight'] = [
			'label' => \IqitElementorWpHelper::_x( 'Weight', 'Typography Control', 'elementor' ),
			'type' => Controls_Manager::SELECT,
			'default' => '',
			'options' => $typo_weight_options,
		];

		$fields['text_transform'] = [
			'label' => \IqitElementorWpHelper::_x( 'Transform', 'Typography Control', 'elementor' ),
			'type' => Controls_Manager::SELECT,
			'default' => '',
			'options' => [
				'' => \IqitElementorWpHelper::__( 'Default', 'elementor' ),
				'uppercase' => \IqitElementorWpHelper::_x( 'Uppercase', 'Typography Control', 'elementor' ),
				'lowercase' => \IqitElementorWpHelper::_x( 'Lowercase', 'Typography Control', 'elementor' ),
				'capitalize' => \IqitElementorWpHelper::_x( 'Capitalize', 'Typography Control', 'elementor' ),
			],
		];

		$fields['font_style'] = [
			'label' => \IqitElementorWpHelper::_x( 'Style', 'Typography Control', 'elementor' ),
			'type' => Controls_Manager::SELECT,
			'default' => '',
			'options' => [
				'' => \IqitElementorWpHelper::__( 'Default', 'elementor' ),
				'normal' => \IqitElementorWpHelper::_x( 'Normal', 'Typography Control', 'elementor' ),
				'italic' => \IqitElementorWpHelper::_x( 'Italic', 'Typography Control', 'elementor' ),
				'oblique' => \IqitElementorWpHelper::_x( 'Oblique', 'Typography Control', 'elementor' ),
			],
		];

		$fields['line_height'] = [
			'label' => \IqitElementorWpHelper::_x( 'Line-Height', 'Typography Control', 'elementor' ),
			'type' => Controls_Manager::SLIDER,
			'default' => [
				'unit' => 'em',
			],
			'range' => [
				'px' => [
					'min' => 1,
				],
			],
			'responsive' => true,
			'size_units' => [ 'px', 'em' ],
			'selector_value' => 'line-height: {{SIZE}}{{UNIT}}',
		];

		$fields['letter_spacing'] = [
			'label' => \IqitElementorWpHelper::_x( 'Letter Spacing', 'Typography Control', 'elementor' ),
			'type' => Controls_Manager::SLIDER,
			'range' => [
				'px' => [
					'min' => -5,
					'max' => 10,
					'step' => 0.1,
				],
			],
			'responsive' => true,
			'selector_value' => 'letter-spacing: {{SIZE}}{{UNIT}}',
		];

		self::$_fields = $fields;
	}

	protected function _get_controls( $args ) {
		$controls = self::get_fields();

		array_walk( $controls, function ( &$control, $control_name ) use ( $args ) {
			$selector_value = ! empty( $control['selector_value'] ) ? $control['selector_value'] : str_replace( '_', '-', $control_name ) . ': {{VALUE}};';

			$control['selectors'] = [
				$args['selector'] => $selector_value,
			];

			$control['condition'] = [
				'typography' => [ 'custom' ],
			];
		} );


        $controls['font_family_custom']['condition'] = [
            'typography' => [ 'custom' ],
            'font_family' => [ 'custom' ],
        ];

		$typography_control = [
			'typography' => [
				'label' => \IqitElementorWpHelper::_x( 'Typography', 'Typography Control', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => \IqitElementorWpHelper::__( 'Default', 'elementor' ),
					'custom' => \IqitElementorWpHelper::__( 'Custom', 'elementor' ),
				],
			],
		];



		$controls = $typography_control + $controls;

		return $controls;
	}

	protected function _add_group_args_to_control( $control_id, $control_args ) {
		$control_args = parent::_add_group_args_to_control( $control_id, $control_args );

		$args = $this->get_args();

		if ( in_array( $control_id, self::get_scheme_fields_keys() ) && ! empty( $args['scheme'] ) ) {
			$control_args['scheme'] = [
				'type' => self::get_type(),
				'value' => $args['scheme'],
				'key' => $control_id,
			];
		}

		return $control_args;
	}
}

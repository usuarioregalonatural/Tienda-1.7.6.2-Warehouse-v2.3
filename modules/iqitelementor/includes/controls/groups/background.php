<?php
namespace Elementor;

if ( ! defined( 'ELEMENTOR_ABSPATH' ) ) exit; // Exit if accessed directly

class Group_Control_Background extends Group_Control_Base {

	public static function get_type() {
		return 'background';
	}

	protected function _get_child_default_args() {
		return [
			'types' => [ 'classic' ],
		];
	}

	protected function _get_controls( $args ) {
		$available_types = [
			'classic' => [
				'title' => \IqitElementorWpHelper::_x( 'Classic', 'Background Control', 'elementor' ),
				'icon' => 'paint-brush',
			],
            'gradient' => [
                'title' => \IqitElementorWpHelper::_x('Gradient', 'Background Control', 'elementor'),
                'icon' => 'fa fa-barcode',
            ],
			'video' => [
				'title' => \IqitElementorWpHelper::_x( 'Background Video', 'Background Control', 'elementor' ),
				'icon' => 'video-camera',
			],
		];

		$choose_types = [
			'none' => [
				'title' => \IqitElementorWpHelper::_x( 'None', 'Background Control', 'elementor' ),
				'icon' => 'ban',
			],
		];

		foreach ( $args['types'] as $type ) {
			if ( isset( $available_types[ $type ] ) ) {
				$choose_types[ $type ] = $available_types[ $type ];
			}
		}

		$controls = [];

		$controls['background'] = [
			'label' => \IqitElementorWpHelper::_x( 'Background Type', 'Background Control', 'elementor' ),
			'type' => Controls_Manager::CHOOSE,
			'default' => $args['default'],
			'options' => $choose_types,
			'label_block' => true,
		];

		// Background:color
		if ( in_array( 'classic', $args['types'] ) ) {
			$controls['color'] = [
				'label' => \IqitElementorWpHelper::_x( 'Color', 'Background Control', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'tab' => $args['tab'],
				'title' => \IqitElementorWpHelper::_x( 'Background Color', 'Background Control', 'elementor' ),
				'selectors' => [
					$args['selector'] => 'background-color: {{VALUE}};',
				],
				'condition' => [
                    'background' => [ 'classic', 'gradient' ],
				],
			];

            if ( in_array( 'gradient', $args['types'] ) ) {
                $controls['color_stop'] = [
                    'label' =>\IqitElementorWpHelper::_x( 'Location', 'Background Control', 'elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ '%' ],
                    'default' => [
                        'unit' => '%',
                        'size' => 0,
                    ],
                    'render_type' => 'ui',
                    'condition' => [
                        'background' => [ 'gradient' ],
                    ],
                ];
                $controls['color_b'] = [
                    'label' => \IqitElementorWpHelper::_x( 'Second Color', 'Background Control', 'elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => 'transparent',
                    'render_type' => 'ui',
                    'condition' => [
                        'background' => [ 'gradient' ],
                    ],
                ];
                $controls['color_b_stop'] = [
                    'label' => \IqitElementorWpHelper::_x( 'Location', 'Background Control', 'elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ '%' ],
                    'default' => [
                        'unit' => '%',
                        'size' => 100,
                    ],
                    'render_type' => 'ui',
                    'condition' => [
                        'background' => [ 'gradient' ],
                    ],
                ];
                $controls['gradient_type'] = [
                    'label' => \IqitElementorWpHelper::_x( 'Type', 'Background Control', 'elementor' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'linear' => \IqitElementorWpHelper::_x( 'Linear', 'Background Control', 'elementor' ),
                        'radial' => \IqitElementorWpHelper::_x( 'Radial', 'Background Control', 'elementor' ),
                    ],
                    'default' => 'linear',
                    'render_type' => 'ui',
                    'condition' => [
                        'background' => [ 'gradient' ],
                    ],
                ];
                $controls['gradient_angle'] = [
                    'label' => \IqitElementorWpHelper::_x( 'Angle', 'Background Control', 'elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'deg' ],
                    'default' => [
                        'unit' => 'deg',
                        'size' => 180,
                    ],
                    'range' => [
                        'deg' => [
                            'step' => 10,
                        ],
                    ],
                    'selectors' => [
                        $args['selector'] => 'background-image: linear-gradient({{SIZE}}{{UNIT}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
                    ],
                    'condition' => [
                        'background' => [ 'gradient' ],
                        'gradient_type' => 'linear',
                    ],
                ];
                $controls['gradient_position'] = [
                    'label' => \IqitElementorWpHelper::_x( 'Position', 'Background Control', 'elementor' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'center center' => \IqitElementorWpHelper::_x( 'Center Center', 'Background Control', 'elementor' ),
                        'center left' => \IqitElementorWpHelper::_x( 'Center Left', 'Background Control', 'elementor' ),
                        'center right' => \IqitElementorWpHelper::_x( 'Center Right', 'Background Control', 'elementor' ),
                        'top center' => \IqitElementorWpHelper::_x( 'Top Center', 'Background Control', 'elementor' ),
                        'top left' => \IqitElementorWpHelper::_x( 'Top Left', 'Background Control', 'elementor' ),
                        'top right' => \IqitElementorWpHelper::_x( 'Top Right', 'Background Control', 'elementor' ),
                        'bottom center' => \IqitElementorWpHelper::_x( 'Bottom Center', 'Background Control', 'elementor' ),
                        'bottom left' => \IqitElementorWpHelper::_x( 'Bottom Left', 'Background Control', 'elementor' ),
                        'bottom right' => \IqitElementorWpHelper::_x( 'Bottom Right', 'Background Control', 'elementor' ),
                    ],
                    'default' => 'center center',
                    'selectors' => [
                        $args['selector'] => 'background-image: radial-gradient(at {{VALUE}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
                    ],
                    'condition' => [
                        'background' => [ 'gradient' ],
                        'gradient_type' => 'radial',
                    ],
                ];
            }
		}
		// End Background:color

		// Background:image
		if ( in_array( 'classic', $args['types'] ) ) {
			$controls['image'] = [
				'label' => \IqitElementorWpHelper::_x( 'Image', 'Background Control', 'elementor' ),
				'type' => Controls_Manager::MEDIA,
				'title' => \IqitElementorWpHelper::_x( 'Background Image', 'Background Control', 'elementor' ),
				'selectors' => [
					$args['selector'] => 'background-image: url("{{URL}}");',
				],
				'condition' => [
					'background' => [ 'classic' ],
				],
			];

			$controls['position'] = [
				'label' => \IqitElementorWpHelper::_x( 'Position', 'Background Control', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => \IqitElementorWpHelper::_x( 'None', 'Background Control', 'elementor' ),
					'top left' => \IqitElementorWpHelper::_x( 'Top Left', 'Background Control', 'elementor' ),
					'top center' => \IqitElementorWpHelper::_x( 'Top Center', 'Background Control', 'elementor' ),
					'top right' => \IqitElementorWpHelper::_x( 'Top Right', 'Background Control', 'elementor' ),
					'center left' => \IqitElementorWpHelper::_x( 'Center Left', 'Background Control', 'elementor' ),
					'center center' => \IqitElementorWpHelper::_x( 'Center Center', 'Background Control', 'elementor' ),
					'center right' => \IqitElementorWpHelper::_x( 'Center Right', 'Background Control', 'elementor' ),
					'bottom left' => \IqitElementorWpHelper::_x( 'Bottom Left', 'Background Control', 'elementor' ),
					'bottom center' => \IqitElementorWpHelper::_x( 'Bottom Center', 'Background Control', 'elementor' ),
					'bottom right' => \IqitElementorWpHelper::_x( 'Bottom Right', 'Background Control', 'elementor' ),
				],
				'selectors' => [
					$args['selector'] => 'background-position: {{VALUE}};',
				],
				'condition' => [
					'background' => [ 'classic' ],
					'image[url]!' => '',
				],
			];

			$controls['attachment'] = [
				'label' => \IqitElementorWpHelper::_x( 'Attachment', 'Background Control', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => \IqitElementorWpHelper::_x( 'None', 'Background Control', 'elementor' ),
					'scroll' => \IqitElementorWpHelper::_x( 'Scroll', 'Background Control', 'elementor' ),
					'fixed' => \IqitElementorWpHelper::_x( 'Fixed', 'Background Control', 'elementor' ),
				],
				'selectors' => [
					$args['selector'] => 'background-attachment: {{VALUE}};',
				],
				'condition' => [
					'background' => [ 'classic' ],
					'image[url]!' => '',
				],
			];

			$controls['repeat'] = [
				'label' => \IqitElementorWpHelper::_x( 'Repeat', 'Background Control', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => \IqitElementorWpHelper::_x( 'None', 'Background Control', 'elementor' ),
					'no-repeat' => \IqitElementorWpHelper::_x( 'No-repeat', 'Background Control', 'elementor' ),
					'repeat' => \IqitElementorWpHelper::_x( 'Repeat', 'Background Control', 'elementor' ),
					'repeat-x' => \IqitElementorWpHelper::_x( 'Repeat-x', 'Background Control', 'elementor' ),
					'repeat-y' => \IqitElementorWpHelper::_x( 'Repeat-y', 'Background Control', 'elementor' ),
				],
				'selectors' => [
					$args['selector'] => 'background-repeat: {{VALUE}};',
				],
				'condition' => [
					'background' => [ 'classic' ],
					'image[url]!' => '',
				],
			];

			$controls['size'] = [
				'label' => \IqitElementorWpHelper::_x( 'Size', 'Background Control', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => \IqitElementorWpHelper::_x( 'None', 'Background Control', 'elementor' ),
					'auto' => \IqitElementorWpHelper::_x( 'Auto', 'Background Control', 'elementor' ),
					'cover' => \IqitElementorWpHelper::_x( 'Cover', 'Background Control', 'elementor' ),
					'contain' => \IqitElementorWpHelper::_x( 'Contain', 'Background Control', 'elementor' ),
				],
				'selectors' => [
					$args['selector'] => 'background-size: {{VALUE}};',
				],
				'condition' => [
					'background' => [ 'classic' ],
					'image[url]!' => '',
				],
			];
		}
		// End Background:image

		// Background:video
		$controls['video_link'] = [
			'label' => \IqitElementorWpHelper::_x( 'Video Link', 'Background Control', 'elementor' ),
			'type' => Controls_Manager::TEXT,
			'placeholder' => 'https://www.youtube.com/watch?v=9uOETcuFjbE',
			'description' => \IqitElementorWpHelper::__( 'Insert YouTube link or video file (mp4 is recommended)', 'elementor' ),
			'label_block' => true,
			'default' => '',
			'condition' => [
				'background' => [ 'video' ],
			],
		];

		$controls['video_fallback'] = [
			'label' => \IqitElementorWpHelper::_x( 'Background Fallback', 'Background Control', 'elementor' ),
			'description' => \IqitElementorWpHelper::__( 'This cover image will replace the background video on mobile or tablet.', 'elementor' ),
			'type' => Controls_Manager::MEDIA,
			'label_block' => true,
			'condition' => [
				'background' => [ 'video' ],
			],
			'selectors' => [
				$args['selector'] . ' .elementor-background-video-fallback' => 'background: url("{{URL}}") 50% 50%; background-size: cover;',
			],
		];
		// End Background:video

		return $controls;
	}
}

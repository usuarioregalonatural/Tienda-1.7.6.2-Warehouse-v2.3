<?php
namespace Elementor;

if ( ! defined( 'ELEMENTOR_ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Image_Carousel extends Widget_Base {

	public function get_id() {
		return 'image-carousel';
	}

	public function get_title() {
		return \IqitElementorWpHelper::__( 'Image Carousel', 'elementor' );
	}

	public function get_icon() {
		return 'slider-push';
	}

	protected function _register_controls() {
		$this->add_control(
			'section_image_carousel',
			[
				'label' => \IqitElementorWpHelper::__( 'Images list', 'elementor' ),
				'type' => Controls_Manager::SECTION,
			]
		);

        $this->add_control(
            'images_list',
            [
                'label' => '',
                'type' => Controls_Manager::REPEATER,
                'default' => [],
                'section' => 'section_image_carousel',
                'fields' => [
                    [
                        'name' => 'text',
                        'label' => \IqitElementorWpHelper::__( 'Image alt', 'elementor' ),
                        'type' => Controls_Manager::TEXT,
                        'label_block' => true,
                        'placeholder' => \IqitElementorWpHelper::__( 'Image alt', 'elementor' ),
                        'default' => \IqitElementorWpHelper::__( 'Image alt', 'elementor' ),
                    ],
                    [
                        'name' => 'image',
                        'label' => \IqitElementorWpHelper::__( 'Choose Image', 'elementor' ),
                        'type' => Controls_Manager::MEDIA,
                        'placeholder' => \IqitElementorWpHelper::__( 'Image', 'elementor' ),
                        'label_block' => true,
                        'default' => [
                            'url' => UtilsElementor::get_placeholder_image_src(),
                        ],
                    ],
                    [
                        'name' => 'link',
                        'label' => \IqitElementorWpHelper::__( 'Link', 'elementor' ),
                        'type' => Controls_Manager::URL,
                        'label_block' => true,
                        'placeholder' => \IqitElementorWpHelper::__( 'http://your-link.com', 'elementor' ),
                    ],
                ],
                'title_field' => 'text',
            ]
        );

		$this->add_control(
			'view',
			[
				'label' => \IqitElementorWpHelper::__( 'View', 'elementor' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
				'section' => 'section_image_carousel',
			]
		);

		$this->add_control(
			'section_additional_options',
			[
				'label' => \IqitElementorWpHelper::__( 'Carousel settings', 'elementor' ),
				'type' => Controls_Manager::SECTION,
			]
		);

		$slides_to_show = range( 1, 10 );
		$slides_to_show = array_combine( $slides_to_show, $slides_to_show );

		$this->add_control(
			'slides_to_show',
			[
				'label' => \IqitElementorWpHelper::__( 'Slides to Show', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
				'section' => 'section_additional_options',
				'options' => $slides_to_show,
			]
		);

		$this->add_control(
			'slides_to_scroll',
			[
				'label' => \IqitElementorWpHelper::__( 'Slides to Scroll', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '2',
				'section' => 'section_additional_options',
				'options' => $slides_to_show,
				'condition' => [
					'slides_to_show!' => '1',
				],
			]
		);

		$this->add_control(
			'image_stretch',
			[
				'label' => \IqitElementorWpHelper::__( 'Image Stretch', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'no',
				'section' => 'section_additional_options',
				'options' => [
					'no' => \IqitElementorWpHelper::__( 'No', 'elementor' ),
					'yes' => \IqitElementorWpHelper::__( 'Yes', 'elementor' ),
				],
			]
		);
		$this->add_control(
			'image_lazy',
			[
				'label' => \IqitElementorWpHelper::__( 'Lazy load', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'yes',
				'section' => 'section_additional_options',
				'options' => [
					'no' => \IqitElementorWpHelper::__( 'No', 'elementor' ),
					'yes' => \IqitElementorWpHelper::__( 'Yes', 'elementor' ),
				],
			]
		);

		$this->add_control(
			'navigation',
			[
				'label' => \IqitElementorWpHelper::__( 'Navigation', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'both',
				'section' => 'section_additional_options',
				'options' => [
					'both' => \IqitElementorWpHelper::__( 'Arrows and Dots', 'elementor' ),
					'arrows' => \IqitElementorWpHelper::__( 'Arrows', 'elementor' ),
					'dots' => \IqitElementorWpHelper::__( 'Dots', 'elementor' ),
					'none' => \IqitElementorWpHelper::__( 'None', 'elementor' ),
				],
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label' => \IqitElementorWpHelper::__( 'Pause on Hover', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'yes',
				'section' => 'section_additional_options',
				'options' => [
					'yes' => \IqitElementorWpHelper::__( 'Yes', 'elementor' ),
					'no' => \IqitElementorWpHelper::__( 'No', 'elementor' ),
				],
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => \IqitElementorWpHelper::__( 'Autoplay', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'yes',
				'section' => 'section_additional_options',
				'options' => [
					'yes' => \IqitElementorWpHelper::__( 'Yes', 'elementor' ),
					'no' => \IqitElementorWpHelper::__( 'No', 'elementor' ),
				],
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label' => \IqitElementorWpHelper::__( 'Autoplay Speed', 'elementor' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 5000,
				'section' => 'section_additional_options',
			]
		);

		$this->add_control(
			'infinite',
			[
				'label' => \IqitElementorWpHelper::__( 'Infinite Loop', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'yes',
				'section' => 'section_additional_options',
				'options' => [
					'yes' => \IqitElementorWpHelper::__( 'Yes', 'elementor' ),
					'no' => \IqitElementorWpHelper::__( 'No', 'elementor' ),
				],
			]
		);

		$this->add_control(
			'effect',
			[
				'label' => \IqitElementorWpHelper::__( 'Effect', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'slide',
				'section' => 'section_additional_options',
				'options' => [
					'slide' => \IqitElementorWpHelper::__( 'Slide', 'elementor' ),
					'fade' => \IqitElementorWpHelper::__( 'Fade', 'elementor' ),
				],
				'condition' => [
					'slides_to_show' => '1',
				],
			]
		);

		$this->add_control(
			'speed',
			[
				'label' => \IqitElementorWpHelper::__( 'Animation Speed', 'elementor' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 500,
				'section' => 'section_additional_options',
			]
		);

		$this->add_control(
			'direction',
			[
				'label' => \IqitElementorWpHelper::__( 'Direction', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'ltr',
				'section' => 'section_additional_options',
				'options' => [
					'ltr' => \IqitElementorWpHelper::__( 'Left', 'elementor' ),
					'rtl' => \IqitElementorWpHelper::__( 'Right', 'elementor' ),
				],
			]
		);

		$this->add_control(
			'section_style_navigation',
			[
				'label' => \IqitElementorWpHelper::__( 'Navigation', 'elementor' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_STYLE,
				'condition' => [
					'navigation' => [ 'arrows', 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'heading_style_arrows',
			[
				'label' => \IqitElementorWpHelper::__( 'Arrows', 'elementor' ),
				'type' => Controls_Manager::HEADING,
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_navigation',
				'separator' => 'before',
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_position',
			[
				'label' => \IqitElementorWpHelper::__( 'Arrows Position', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'inside',
				'section' => 'section_style_navigation',
				'tab' => self::TAB_STYLE,
				'options' => [
					'inside' => \IqitElementorWpHelper::__( 'Inside', 'elementor' ),
					'outside' => \IqitElementorWpHelper::__( 'Outside', 'elementor' ),
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_size',
			[
				'label' => \IqitElementorWpHelper::__( 'Arrows Size', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'section' => 'section_style_navigation',
				'tab' => self::TAB_STYLE,
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 60,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-image-carousel-wrapper .slick-slider .slick-prev:before, {{WRAPPER}} .elementor-image-carousel-wrapper .slick-slider .slick-next:before' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label' => \IqitElementorWpHelper::__( 'Arrows Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_navigation',
				'selectors' => [
					'{{WRAPPER}} .elementor-image-carousel-wrapper .slick-slider .slick-prev:before, {{WRAPPER}} .elementor-image-carousel-wrapper .slick-slider .slick-next:before' => 'color: {{VALUE}};',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);
		$this->add_control(
			'arrows_bg_color',
			[
				'label' => \IqitElementorWpHelper::__( 'Arrows background', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_navigation',
				'selectors' => [
					'{{WRAPPER}} .elementor-image-carousel-wrapper  .slick-slider .slick-prev, {{WRAPPER}} .elementor-image-carousel-wrapper  .slick-slider .slick-next' => 'background: {{VALUE}};',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'heading_style_dots',
			[
				'label' => \IqitElementorWpHelper::__( 'Dots', 'elementor' ),
				'type' => Controls_Manager::HEADING,
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_navigation',
				'separator' => 'before',
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_position',
			[
				'label' => \IqitElementorWpHelper::__( 'Dots Position', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'outside',
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_navigation',
				'options' => [
					'outside' => \IqitElementorWpHelper::__( 'Outside', 'elementor' ),
					'inside' => \IqitElementorWpHelper::__( 'Inside', 'elementor' ),
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_size',
			[
				'label' => \IqitElementorWpHelper::__( 'Dots Size', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_navigation',
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-image-carousel-wrapper .elementor-image-carousel .slick-dots li button:before' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_color',
			[
				'label' => \IqitElementorWpHelper::__( 'Dots Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_navigation',
				'selectors' => [
					'{{WRAPPER}} .elementor-image-carousel-wrapper .elementor-image-carousel .slick-dots li button:before' => 'color: {{VALUE}};',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'section_style_image',
			[
				'label' => \IqitElementorWpHelper::__( 'Image', 'elementor' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_spacing',
			[
				'label' => \IqitElementorWpHelper::__( 'Spacing', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_image',
				'options' => [
					'' => \IqitElementorWpHelper::__( 'Default', 'elementor' ),
					'custom' => \IqitElementorWpHelper::__( 'Custom', 'elementor' ),
				],
				'default' => '',
				'condition' => [
					'slides_to_show!' => '1',
				],
			]
		);

		$this->add_control(
			'image_spacing_custom',
			[
				'label' => \IqitElementorWpHelper::__( 'Image Spacing', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_image',
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'default' => [
					'size' => 20,
				],
				'show_label' => false,
				'selectors' => [
					'{{WRAPPER}} .slick-list' => 'margin-left: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .slick-slide .slick-slide-inner' => 'padding-left: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'image_spacing' => 'custom',
					'slides_to_show!' => '1',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_image',
				'selector' => '{{WRAPPER}} .elementor-image-carousel-wrapper .elementor-image-carousel .slick-slide-image',
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label' => \IqitElementorWpHelper::__( 'Border Radius', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'tab' => self::TAB_STYLE,
				'section' => 'section_style_image',
				'selectors' => [
					'{{WRAPPER}} .elementor-image-carousel-wrapper .elementor-image-carousel .slick-slide-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
	}

	protected function render( $instance = [] ) {
		if ( empty( $instance['images_list'] ) )
			return;

		$slides = [];

		$lazy = 'src';
		if ( 'yes' === $instance['image_lazy'] ) {
			$lazy = 'data-lazy';
		}


		foreach ( $instance['images_list'] as $item ) {
			$image_url = $item['image']['url'];
			$image_html = '<img class="slick-slide-image" '.$lazy.'="' . \IqitElementorWpHelper::esc_attr(\IqitElementorWpHelper::getImage($image_url)   ) . '" alt="' . \IqitElementorWpHelper::esc_attr( $item['text']  ) . '" />';

            if ( ! empty( $item['link']['url'] ) ) {
                $target = $item['link']['is_external'] ? ' target="_blank" rel="noopener noreferrer"' : '';

                $image_html = sprintf( '<a href="%s"%s>%s</a>', $item['link']['url'], $target, $image_html );
            }

			$slides[] = '<div><div class="slick-slide-inner">' . $image_html . '</div></div>';
		}

		if ( empty( $slides ) ) {
			return;
		}

		$is_slideshow = '1' === $instance['slides_to_show'];
		$is_rtl = ( 'rtl' === $instance['direction'] );
		$direction = $is_rtl ? 'rtl' : 'ltr';
		$show_dots = ( in_array( $instance['navigation'], [ 'dots', 'both' ] ) );
		$show_arrows = ( in_array( $instance['navigation'], [ 'arrows', 'both' ] ) );

		$slick_options = [
			'slidesToShow' => \IqitElementorWpHelper::absint( $instance['slides_to_show'] ),
			'autoplaySpeed' => \IqitElementorWpHelper::absint( $instance['autoplay_speed'] ),
			'autoplay' => ( 'yes' === $instance['autoplay'] ),
			'infinite' => ( 'yes' === $instance['infinite'] ),
			'pauseOnHover' => ( 'yes' === $instance['pause_on_hover'] ),
			'speed' => \IqitElementorWpHelper::absint( $instance['speed'] ),
			'arrows' => $show_arrows,
			'dots' => $show_dots,
			'rtl' => $is_rtl,
		];

		$carousel_classes = [ 'elementor-image-carousel' ];

		if ( $show_arrows ) {
			$carousel_classes[] = 'slick-arrows-' . $instance['arrows_position'];
		}

		if ( $show_dots ) {
			$carousel_classes[] = 'slick-dots-' . $instance['dots_position'];
		}

		if ( 'yes' === $instance['image_stretch'] ) {
			$carousel_classes[] = 'slick-image-stretch';
		}

		if ( ! $is_slideshow ) {
			$slick_options['slidesToScroll'] = \IqitElementorWpHelper::absint( $instance['slides_to_scroll'] );
		} else {
			$slick_options['fade'] = ( 'fade' === $instance['effect'] );
		}

		?>
		<div class="elementor-image-carousel-wrapper elementor-slick-slider" dir="<?php echo $direction; ?>">
			<div class="<?php echo implode( ' ', $carousel_classes ); ?>" data-slider_options='<?php echo json_encode( $slick_options ); ?>'>
				<?php echo implode( '', $slides ); ?>
			</div>
		</div>
	<?php
	}

	protected function content_template() {}

}

<?php
namespace Elementor;

if ( ! defined( 'ELEMENTOR_ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Testimonial extends Widget_Base {

    public function get_id() {
        return 'testimonial';
    }

    public function get_title() {
        return \IqitElementorWpHelper::__( 'Testimonial', 'elementor' );
    }

    public function get_icon() {
        return 'testimonial';
    }

    protected function _register_controls() {

        $this->add_control(
            'section_testimonial',
            [
                'label' => \IqitElementorWpHelper::__( 'Testimonial', 'elementor' ),
                'type' => Controls_Manager::SECTION,
            ]
        );

        $this->add_control(
            'testimonials_list',
            [
                'label' => '',
                'type' => Controls_Manager::REPEATER,
                'default' => [],
                'section' => 'section_testimonial',
                'fields' => [
                    [
                        'name' => 'name',
                        'label' => \IqitElementorWpHelper::__( 'Name', 'elementor' ),
                        'type' => Controls_Manager::TEXT,
                        'default' => 'John Doe',
                    ],
                    [
                        'name' => 'job',
                        'label' => \IqitElementorWpHelper::__( 'Job', 'elementor' ),
                        'type' => Controls_Manager::TEXT,
                        'default' => 'Designer',
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
                        'label' => \IqitElementorWpHelper::__( 'Content', 'elementor' ),
                        'type' => Controls_Manager::TEXTAREA,
                        'rows' => '10',
                        'name' => 'content',
                        'default' => 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.',
                    ]
                ],
                'title_field' => 'name',
            ]
        );

        $this->add_control(
            'section_additional_options',
            [
                'label' => \IqitElementorWpHelper::__( 'Settings', 'elementor' ),
                'type' => Controls_Manager::SECTION,
            ]
        );

        $this->add_control(
            'testimonial_image_position',
            [
                'label' => \IqitElementorWpHelper::__( 'Image Position', 'elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'aside',
                'section' => 'section_additional_options',
                'options' => [
                    'aside' => \IqitElementorWpHelper::__( 'Aside to name', 'elementor' ),
                    'top' => \IqitElementorWpHelper::__( 'Top (above content)', 'elementor' ),
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'testimonial_alignment',
            [
                'label' => \IqitElementorWpHelper::__( 'Alignment', 'elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'center',
                'section' => 'section_additional_options',
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

        // Box
        $this->add_control(
            'section_style_testimonial_box',
            [
                'label' => \IqitElementorWpHelper::__( 'Testimonial box', 'elementor' ),
                'type' => Controls_Manager::SECTION,
                'tab' => self::TAB_STYLE,
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label' => \IqitElementorWpHelper::__( 'Background Color', 'elementor' ),
                'type' => Controls_Manager::COLOR,
                'tab' => self::TAB_STYLE,
                'section' => 'section_style_testimonial_box',
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_4,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'testimonial_border',
                'label' => \IqitElementorWpHelper::__( 'Image Border', 'elementor' ),
                'tab' => self::TAB_STYLE,
                'section' => 'section_style_testimonial_box',
                'selector' => '{{WRAPPER}} .elementor-testimonial-wrapper',
            ]
        );

        $this->add_control(
            'testimonial_border_radius',
            [
                'label' => \IqitElementorWpHelper::__( 'Border Radius', 'elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'tab' => self::TAB_STYLE,
                'section' => 'section_style_testimonial_box',
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'testimonial_padding',
            [
                'label' => \IqitElementorWpHelper::__( 'Box padding', 'elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'tab' => self::TAB_STYLE,
                'section' => 'section_style_testimonial_box',
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'testimonial_margin',
            [
                'label' => \IqitElementorWpHelper::__( 'Box Margin', 'elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'tab' => self::TAB_STYLE,
                'section' => 'section_style_testimonial_box',
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'testimonial_box_shadow',
                'section' => 'section_style_testimonial_box',
                'tab' => self::TAB_STYLE,
                'selector' => '{{WRAPPER}} .elementor-testimonial-wrapper',
            ]
        );



        // Content
        $this->add_control(
            'section_style_testimonial_content',
            [
                'label' => \IqitElementorWpHelper::__( 'Content', 'elementor' ),
                'type' => Controls_Manager::SECTION,
                'tab' => self::TAB_STYLE,
            ]
        );

        $this->add_control(
            'content_content_color',
            [
                'label' => \IqitElementorWpHelper::__( 'Content Color', 'elementor' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                ],
                'tab' => self::TAB_STYLE,
                'section' => 'section_style_testimonial_content',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'label' => \IqitElementorWpHelper::__( 'Typography', 'elementor' ),
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
                'tab' => self::TAB_STYLE,
                'section' => 'section_style_testimonial_content',
                'selector' => '{{WRAPPER}} .elementor-testimonial-content',
            ]
        );

        // Image
        $this->add_control(
            'section_style_testimonial_image',
            [
                'label' => \IqitElementorWpHelper::__( 'Image', 'elementor' ),
                'type' => Controls_Manager::SECTION,
                'tab' => self::TAB_STYLE,
            ]
        );

        $this->add_control(
            'image_size',
            [
                'label' => \IqitElementorWpHelper::__( 'Image Size', 'elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 200,
                    ],
                ],
                'section' => 'section_style_testimonial_image',
                'tab' => self::TAB_STYLE,
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-wrapper .elementor-testimonial-image img' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'image_border',
                'tab' => self::TAB_STYLE,
                'section' => 'section_style_testimonial_image',
                'selector' => '{{WRAPPER}} .elementor-testimonial-wrapper .elementor-testimonial-image img',
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label' => \IqitElementorWpHelper::__( 'Border Radius', 'elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'tab' => self::TAB_STYLE,
                'section' => 'section_style_testimonial_image',
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-wrapper .elementor-testimonial-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Name
        $this->add_control(
            'section_style_testimonial_name',
            [
                'label' => \IqitElementorWpHelper::__( 'Name', 'elementor' ),
                'type' => Controls_Manager::SECTION,
                'tab' => self::TAB_STYLE,
            ]
        );

        $this->add_control(
            'name_text_color',
            [
                'label' => \IqitElementorWpHelper::__( 'Text Color', 'elementor' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'tab' => self::TAB_STYLE,
                'section' => 'section_style_testimonial_name',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'name_typography',
                'label' => \IqitElementorWpHelper::__( 'Typography', 'elementor' ),
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'tab' => self::TAB_STYLE,
                'section' => 'section_style_testimonial_name',
                'selector' => '{{WRAPPER}} .elementor-testimonial-name',
            ]
        );

        // Job
        $this->add_control(
            'section_style_testimonial_job',
            [
                'label' => \IqitElementorWpHelper::__( 'Job', 'elementor' ),
                'type' => Controls_Manager::SECTION,
                'tab' => self::TAB_STYLE,
            ]
        );

        $this->add_control(
            'job_text_color',
            [
                'label' => \IqitElementorWpHelper::__( 'Text Color', 'elementor' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'tab' => self::TAB_STYLE,
                'section' => 'section_style_testimonial_job',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-job' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'job_typography',
                'label' => \IqitElementorWpHelper::__( 'Typography', 'elementor' ),
                'scheme' => Scheme_Typography::TYPOGRAPHY_2,
                'tab' => self::TAB_STYLE,
                'section' => 'section_style_testimonial_job',
                'selector' => '{{WRAPPER}} .elementor-testimonial-job',
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
                    'middle' => \IqitElementorWpHelper::__( 'Middle', 'elementor' ),
                    'above' => \IqitElementorWpHelper::__( 'Above', 'elementor' ),
                ],
                'condition' => [
                    'navigation' => [ 'arrows', 'both' ],
                ],
            ]
        );

        $this->add_control(
            'arrows_position_top',
            [
                'label' => \IqitElementorWpHelper::__( 'Arrows Top Position', 'elementor' ),
                'type' => Controls_Manager::NUMBER,
                'section' => 'section_style_navigation',
                'tab' => self::TAB_STYLE,
                'default' => '-20',
                'min' => '-100',
                'condition' => [
                    'arrows_position' => ['above'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .slick-arrows-above .slick-arrow' => 'top: {{VALUE}}px;',
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
                    '{{WRAPPER}} .elementor-testimonial-carousel-wrapper .slick-slider .slick-prev:before, {{WRAPPER}} .elementor-testimonial-carousel-wrapper .slick-slider .slick-next:before' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-testimonial-carousel-wrapper .slick-slider .slick-prev, {{WRAPPER}} .elementor-testimonial-carousel-wrapper .slick-slider .slick-next' => 'background: {{VALUE}};',
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
            'dots_color',
            [
                'label' => \IqitElementorWpHelper::__( 'Dots Color', 'elementor' ),
                'type' => Controls_Manager::COLOR,
                'tab' => self::TAB_STYLE,
                'section' => 'section_style_navigation',
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-carousel-wrapper .elementor-testimonial-carousel .slick-dots li button:before' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'navigation' => [ 'dots', 'both' ],
                ],
            ]
        );
    }

    protected function render( $instance = [] ) {
        if ( empty( $instance['testimonials_list'] ) )
            return;


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

        $carousel_classes = [ 'elementor-testimonial-carousel' ];

        if ( $show_arrows ) {
            $carousel_classes[] = 'slick-arrows-' . $instance['arrows_position'];
        }

        if ( ! $is_slideshow ) {
            $slick_options['slidesToScroll'] = \IqitElementorWpHelper::absint( $instance['slides_to_scroll'] );
        } else {
            $slick_options['fade'] = ( 'fade' === $instance['effect'] );
        }

        $testimonial_alignment = $instance['testimonial_alignment'] ? ' elementor-testimonial-text-align-' . $instance['testimonial_alignment'] : '';
        $testimonial_image_position = $instance['testimonial_image_position'] ? ' elementor-testimonial-image-position-' . $instance['testimonial_image_position'] : '';
        ?>

        <div class="elementor-testimonial-carousel-wrapper elementor-slick-slider" dir="<?php echo $direction; ?>">
            <div class="<?php echo implode( ' ', $carousel_classes ); ?>" data-slider_options='<?php echo json_encode( $slick_options ); ?>'>
                <?php foreach ( $instance['testimonials_list']as $item ) : ?>
                    <div><div class="slick-slide-inner">
                        <?php
                        $has_image = false;
                        if ( '' !== $item['image']['url'] ) {
                            $image_url = $item['image']['url'];
                            $has_image = ' elementor-has-image';
                        }
                        ?>
                            <div class="elementor-testimonial-wrapper<?php echo $testimonial_alignment; ?>">

                                <?php if ( isset( $image_url ) && $instance['testimonial_image_position'] == 'top') : ?>
                                <div class="elementor-testimonial-meta<?php if ( $has_image ) echo $has_image; ?><?php echo $testimonial_image_position; ?>">
                                    <div class="elementor-testimonial-image">
                                        <img src="<?php echo \IqitElementorWpHelper::esc_attr( $image_url ); ?>" alt="<?php echo \IqitElementorWpHelper::esc_attr( Control_Media::get_image_alt( $item['image'] ) ); ?>" />
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if ( ! empty( $item['content'] ) ) : ?>
                                    <div class="elementor-testimonial-content">
                                        <?php echo $item['content']; ?>
                                    </div>
                                <?php endif; ?>

                                <div class="elementor-testimonial-meta<?php if ( $has_image ) echo $has_image; ?><?php echo $testimonial_image_position; ?>">
                                    <div class="elementor-testimonial-meta-inner">
                                        <?php if ( isset( $image_url ) && $instance['testimonial_image_position'] == 'aside' ) : ?>
                                            <div class="elementor-testimonial-image">
                                                <img src="<?php echo \IqitElementorWpHelper::esc_attr( $image_url ); ?>" alt="<?php echo \IqitElementorWpHelper::esc_attr( Control_Media::get_image_alt( $item['image'] ) ); ?>" />
                                            </div>
                                        <?php endif; ?>

                                        <div class="elementor-testimonial-details">
                                            <?php if ( ! empty( $item['name'] ) ) : ?>
                                                <div class="elementor-testimonial-name">
                                                    <?php echo $item['name']; ?>
                                                </div>
                                            <?php endif; ?>

                                            <?php if ( ! empty( $item['job'] ) ) : ?>
                                                <div class="elementor-testimonial-job">
                                                    <?php echo $item['job']; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div></div>
                    <?php
                endforeach; ?>
            </div>
        </div>
    <?php }

    protected function content_template() {}
}

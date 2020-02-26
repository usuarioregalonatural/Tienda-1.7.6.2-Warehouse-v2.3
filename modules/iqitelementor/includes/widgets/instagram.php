<?php
namespace Elementor;

if ( ! defined( 'ELEMENTOR_ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Instagram extends Widget_Base {

    protected $_current_instance = [];

    public function get_id() {
        return 'instagram';
    }

    public function get_title() {
        return \IqitElementorWpHelper::__( 'Instagram', 'elementor' );
    }

    public function get_icon() {
        return 'instagram';
    }

    protected function _register_controls() {
        $this->add_control(
            'section_instagram',
            [
                'label' => \IqitElementorWpHelper::__( 'Instagram feed', 'elementor' ),
                'type' => Controls_Manager::SECTION,
            ]
        );

        $this->add_control(
            'instagram_description',
            [
                'raw' => \IqitElementorWpHelper::__( 'If you do not know your access token you can get it there: ', 'elementor' ).'<a target="_blank" href="https://elfsight.com/service/get-instagram-access-token/">'.\IqitElementorWpHelper::__( 'token generator ', 'elementor' ).'</a>',
                'type' => Controls_Manager::RAW_HTML,
                'section' => 'section_instagram',
                'classes' => 'elementor-control-descriptor',
            ]
        );

        $this->add_control(
            'instagram_token',
            [
                'label' => \IqitElementorWpHelper::__( 'Access Token', 'elementor' ),
                'type' => Controls_Manager::TEXT,
                'section' => 'section_instagram',
                'placeholder' => \IqitElementorWpHelper::__( 'Enter your token', 'elementor' ),
                'default' => '',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'instagram_limit',
            [
                'label' => \IqitElementorWpHelper::__( 'Limit', 'elementor' ),
                'type' => Controls_Manager::NUMBER,
                'description' => \IqitElementorWpHelper::__( 'An integer that indicates the amount of photos to be feed.', 'elementor' ),
                'min' => 1,
                'default' => 10,
                'section' => 'section_instagram',
            ]
        );

        $this->add_control(
            'instagram_linked',
            [
                'label' => \IqitElementorWpHelper::__( 'Linked', 'elementor' ),
                'type' => Controls_Manager::SELECT,
                'section' => 'section_instagram',
                'description' => \IqitElementorWpHelper::__( 'Value that indicates whether or not the images should be linked to their page on Instagram', 'elementor' ),
                'options' => [
                    'no' => \IqitElementorWpHelper::__( 'No', 'elementor' ),
                    'yes' => \IqitElementorWpHelper::__( 'Yes', 'elementor' ),
                ],
                'default' => '1',
            ]
        );


        $this->add_control(
            'instagram_info',
            [
                'label' => \IqitElementorWpHelper::__( 'Hover info', 'elementor' ),
                'type' => Controls_Manager::SELECT,
                'section' => 'section_instagram',
                'description' => \IqitElementorWpHelper::__( 'Show info like comments, likes and date on hover', 'elementor' ),
                'options' => [
                    'none' => \IqitElementorWpHelper::__( 'No', 'elementor' ),
                    '' => \IqitElementorWpHelper::__( 'Yes', 'elementor' ),
                ],
                'default' => 'block',
                'selectors' => [
                    '{{WRAPPER}} .il-item-inner:hover .il-photo__metainner' => 'display: {{VALUE}};',
                ],

            ]
        );

        $this->add_control(
            'section_instagram_options',
            [
                'label' => \IqitElementorWpHelper::__( 'View options', 'elementor' ),
                'type' => Controls_Manager::SECTION,
            ]
        );

        $this->add_control(
            'instagram_view',
            [
                'label' => \IqitElementorWpHelper::__( 'View', 'elementor' ),
                'type' => Controls_Manager::SELECT,
                'section' => 'section_instagram_options',
                'options' => [
                    'slider' => \IqitElementorWpHelper::__( 'Slider', 'elementor' ),
                    'grid' => \IqitElementorWpHelper::__( 'Grid', 'elementor' ),
                ],
                'default' => 'grid',
            ]
        );

        $slidesToShow = [
            12 => 1,
            6 => 2,
            4 => 3,
            3 => 4,
            2 => 6,
            1 => 12,
        ];

        $this->add_responsive_control(
            'photos_to_show',
            [
                'label' => \IqitElementorWpHelper::__( 'Show per line', 'elementor' ),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'section' => 'section_instagram_options',
                'default' => '6',
                'options' => $slidesToShow,
                'condition' => [
                    'instagram_view' => 'grid',
                ],
            ]
        );

        $slides_to_show = range( 1, 10 );
        $slides_to_show = array_combine( $slides_to_show, $slides_to_show );

        $this->add_responsive_control(
            'photos_to_show_s',
            [
                'label' => \IqitElementorWpHelper::__( 'Show per line', 'elementor' ),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'section' => 'section_instagram_options',
                'default' => '6',
                'options' =>  $slides_to_show,
                'condition' => [
                    'instagram_view' => 'slider',
                ],
            ]
        );



        $this->add_control(
            'navigation',
            [
                'label' => \IqitElementorWpHelper::__( 'Navigation', 'elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'both',
                'section' => 'section_instagram_options',
                'options' => [
                    'both' => \IqitElementorWpHelper::__( 'Arrows and Dots', 'elementor' ),
                    'arrows' => \IqitElementorWpHelper::__( 'Arrows', 'elementor' ),
                    'dots' => \IqitElementorWpHelper::__( 'Dots', 'elementor' ),
                    'none' => \IqitElementorWpHelper::__( 'None', 'elementor' ),
                ],
                'condition' => [
                    'instagram_view' => 'slider',
                ],
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label' => \IqitElementorWpHelper::__( 'Pause on Hover', 'elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'section' => 'section_instagram_options',
                'options' => [
                    'yes' => \IqitElementorWpHelper::__( 'Yes', 'elementor' ),
                    'no' => \IqitElementorWpHelper::__( 'No', 'elementor' ),
                ],
                'condition' => [
                    'instagram_view' => 'slider',
                ],
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => \IqitElementorWpHelper::__( 'Autoplay', 'elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'section' => 'section_instagram_options',
                'options' => [
                    'yes' => \IqitElementorWpHelper::__( 'Yes', 'elementor' ),
                    'no' => \IqitElementorWpHelper::__( 'No', 'elementor' ),
                ],
                'condition' => [
                    'instagram_view' => 'slider',
                ],
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label' => \IqitElementorWpHelper::__( 'Autoplay Speed', 'elementor' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 5000,
                'section' => 'section_instagram_options',
                'condition' => [
                    'instagram_view' => 'slider',
                ],
            ]
        );

        $this->add_control(
            'infinite',
            [
                'label' => \IqitElementorWpHelper::__( 'Infinite Loop', 'elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'section' => 'section_instagram_options',
                'options' => [
                    'yes' => \IqitElementorWpHelper::__( 'Yes', 'elementor' ),
                    'no' => \IqitElementorWpHelper::__( 'No', 'elementor' ),
                ],
                'condition' => [
                    'instagram_view' => 'slider',
                ],
            ]
        );

        $this->add_control(
            'effect',
            [
                'label' => \IqitElementorWpHelper::__( 'Effect', 'elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'slide',
                'section' => 'section_instagram_options',
                'options' => [
                    'slide' => \IqitElementorWpHelper::__( 'Slide', 'elementor' ),
                    'fade' => \IqitElementorWpHelper::__( 'Fade', 'elementor' ),
                ],
                'condition' => [
                    'slides_to_show' => '1',
                    'instagram_view' => 'slider',
                ],
            ]
        );

        $this->add_control(
            'speed',
            [
                'label' => \IqitElementorWpHelper::__( 'Animation Speed', 'elementor' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 500,
                'section' => 'section_instagram_options',
                'condition' => [
                    'instagram_view' => 'slider',
                ],
            ]
        );


        //STYLE TAB
        $this->add_control(
            'section_style',
            [
                'label' => \IqitElementorWpHelper::__( 'Instagram photo', 'elementor' ),
                'type' => Controls_Manager::SECTION,
                'tab' => self::TAB_STYLE,
            ]
        );

        $this->add_control(
            'instagram_photo_height',
            [
                'label' => \IqitElementorWpHelper::__( 'Max height', 'elementor' ),
                'type' => Controls_Manager::TEXT,
                'tab' => self::TAB_STYLE,
                'section' => 'section_style',
                'description' => \IqitElementorWpHelper::__( 'Helpful when you use various aspect ratio for images', 'elementor' ),
                'default' => '100%',
                'selectors' => [
                    '{{WRAPPER}} .il-item a' => 'max-height: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'instagram_text_color',
            [
                'label' => \IqitElementorWpHelper::__( 'Text Color', 'elementor' ),
                'type' => Controls_Manager::COLOR,
                'tab' => self::TAB_STYLE,
                'section' => 'section_style',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .il-photo__meta' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'instagram_overlay_color',
            [
                'label' => \IqitElementorWpHelper::__( 'Overlay background', 'elementor' ),
                'type' => Controls_Manager::COLOR,
                'tab' => self::TAB_STYLE,
                'section' => 'section_style',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .il-photo__meta' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'instagram_padding',
            [
                'label' => \IqitElementorWpHelper::__( 'Photo padding', 'elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'tab' => self::TAB_STYLE,
                'section' => 'section_style',
                'selectors' => [
                    '{{WRAPPER}} .il-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-instagram' => 'margin-left: -{{LEFT}}{{UNIT}}; margin-right:-{{RIGHT}}{{UNIT}} ;',
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
                    '{{WRAPPER}} .elementor-instagram-carousel-wrapper .slick-slider .slick-prev:before, {{WRAPPER}} .elementor-instagram-carousel-wrapper .slick-slider .slick-next:before' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-instagram-carousel-wrapper .slick-slider .slick-prev, {{WRAPPER}} .elementor-instagram-carousel-wrapper .slick-slider .slick-next' => 'background: {{VALUE}};',
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
            'dots_color',
            [
                'label' => \IqitElementorWpHelper::__( 'Dots Color', 'elementor' ),
                'type' => Controls_Manager::COLOR,
                'tab' => self::TAB_STYLE,
                'section' => 'section_style_navigation',
                'selectors' => [
                    '{{WRAPPER}} .elementor-instagram-carousel-wrapper .elementor-instagram-carousel .slick-dots li button:before' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'navigation' => [ 'dots', 'both' ],
                ],
            ]
        );
    }

    protected function render( $instance = [] ) {


        if ($instance['instagram_view'] == 'grid') {
            $class = 'col-'.$instance['photos_to_show_mobile']. ' col-md-'.$instance['photos_to_show_tablet']. ' col-lg-'.$instance['photos_to_show'];

            $instagram_options = [
                'token' => $instance['instagram_token'],
                'limit' => $instance['instagram_limit'],
                'linked' => ( 'yes' === $instance['instagram_linked'] ),
                'class' => $class,
            ];

        } else {
            $is_slideshow = '1' === $instance['photos_to_show_s'];
            $show_dots = ( in_array( $instance['navigation'], [ 'dots', 'both' ] ) );
            $show_arrows = ( in_array( $instance['navigation'], [ 'arrows', 'both' ] ) );

            $slick_options = [
                'slidesToShow' => \IqitElementorWpHelper::absint( $instance['photos_to_show_s'] ),
                'slidesToShowTablet' => \IqitElementorWpHelper::absint( $instance['photos_to_show_s_tablet'] ),
                'slidesToShowMobile' => \IqitElementorWpHelper::absint( $instance['photos_to_show_s_mobile'] ),
                'autoplaySpeed' => \IqitElementorWpHelper::absint( $instance['autoplay_speed'] ),
                'autoplay' => ( 'yes' === $instance['autoplay'] ),
                'infinite' => ( 'yes' === $instance['infinite'] ),
                'pauseOnHover' => ( 'yes' === $instance['pause_on_hover'] ),
                'speed' => \IqitElementorWpHelper::absint( $instance['speed'] ),
                'arrows' => $show_arrows,
                'dots' => $show_dots,
            ];

            $carousel_classes = [ 'elementor-instagram-carousel' ];

            if ( $show_arrows ) {
                $carousel_classes[] = 'slick-arrows-' . $instance['arrows_position'];
            }

            if ( $show_dots ) {
                $carousel_classes[] = 'slick-dots-' . $instance['dots_position'];
            }

            if ( ! $is_slideshow ) {
                $slick_options['slidesToScroll'] = \IqitElementorWpHelper::absint( $instance['photos_to_show_s'] );
            } else {
                $slick_options['fade'] = ( 'fade' === $instance['effect'] );
            }

            $instagram_options = [
                'token' => $instance['instagram_token'],
                'limit' => $instance['instagram_limit'],
                'linked' => ( 'yes' === $instance['instagram_linked'] ),
                'class' => '',
            ];

        }


        if (  $instance['instagram_view'] == 'grid'  ) : ?>
            <div class="elementor-instagram row" data-options='<?php echo json_encode( $instagram_options  ); ?>'></div>
        <?php endif;

        if (  $instance['instagram_view'] == 'slider'  ) : ?>
            <div class="elementor-instagram-carousel-wrapper elementor-slick-slider" >
                <div class="elementor-instagram <?php echo implode( ' ', $carousel_classes ); ?>" data-options='<?php echo json_encode( $instagram_options  ); ?>' data-slider_options='<?php echo json_encode( $slick_options ); ?>'></div>
            </div>
        <?php endif; ?>



        <?php

    }




    protected function content_template() {
    }
}

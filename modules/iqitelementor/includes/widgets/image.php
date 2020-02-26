<?php
namespace Elementor;

if ( ! defined( 'ELEMENTOR_ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Image extends Widget_Base {

    public function get_id() {
        return 'image';
    }

    public function get_title() {
        return \IqitElementorWpHelper::__( 'Image', 'elementor' );
    }

    public function get_icon() {
        return 'insert-image';
    }

    protected function _register_controls() {
        $this->add_control(
            'section_image',
            [
                'label' => \IqitElementorWpHelper::__( 'Image', 'elementor' ),
                'type' => Controls_Manager::SECTION,
            ]
        );

        $this->add_control(
            'image',
            [
                'label' => \IqitElementorWpHelper::__( 'Choose Image', 'elementor' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => UtilsElementor::get_placeholder_image_src(),
                ],
                'section' => 'section_image',
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => \IqitElementorWpHelper::__( 'Alignment', 'elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
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
                'default' => 'center',
                'section' => 'section_image',
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'caption',
            [
                'label' => \IqitElementorWpHelper::__( 'Alt text', 'elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => \IqitElementorWpHelper::__( 'Enter your Alt about the image', 'elementor' ),
                'title' => \IqitElementorWpHelper::__( 'Input image Alt here', 'elementor' ),
                'section' => 'section_image',
            ]
        );

        $this->add_control(
            'link_to',
            [
                'label' => \IqitElementorWpHelper::__( 'Link to', 'elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'section' => 'section_image',
                'options' => [
                    'none' => \IqitElementorWpHelper::__( 'None', 'elementor' ),
                    'file' => \IqitElementorWpHelper::__( 'Media File', 'elementor' ),
                    'custom' => \IqitElementorWpHelper::__( 'Custom URL', 'elementor' ),
                ],
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => \IqitElementorWpHelper::__( 'Link to', 'elementor' ),
                'type' => Controls_Manager::URL,
                'placeholder' => \IqitElementorWpHelper::__( 'http://your-link.com', 'elementor' ),
                'section' => 'section_image',
                'condition' => [
                    'link_to' => 'custom',
                ],
                'show_label' => false,
            ]
        );

        $this->add_control(
            'view',
            [
                'label' => \IqitElementorWpHelper::__( 'View', 'elementor' ),
                'type' => Controls_Manager::HIDDEN,
                'default' => 'traditional',
                'section' => 'section_image',
            ]
        );

        $this->add_control(
            'section_style_image',
            [
                'type'  => Controls_Manager::SECTION,
                'label' => \IqitElementorWpHelper::__( 'Image', 'elementor' ),
                'tab'   => self::TAB_STYLE,
            ]
        );

        $this->add_control(
            'space',
            [
                'label' => \IqitElementorWpHelper::__( 'Size (%)', 'elementor' ),
                'type' => Controls_Manager::SLIDER,
                'tab' => self::TAB_STYLE,
                'section' => 'section_style_image',
                'default' => [
                    'size' => 100,
                    'unit' => '%',
                ],
                'size_units' => [ '%' ],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'opacity',
            [
                'label' => \IqitElementorWpHelper::__( 'Opacity (%)', 'elementor' ),
                'type' => Controls_Manager::SLIDER,
                'tab' => self::TAB_STYLE,
                'section' => 'section_style_image',
                'default' => [
                    'size' => 1,
                ],
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_control(
            'hover_animation',
            [
                'label' => \IqitElementorWpHelper::__( 'Hover Animation', 'elementor' ),
                'type' => Controls_Manager::HOVER_ANIMATION,
                'tab' => self::TAB_STYLE,
                'section' => 'section_style_image',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'image_border',
                'label' => \IqitElementorWpHelper::__( 'Image Border', 'elementor' ),
                'tab' => self::TAB_STYLE,
                'section' => 'section_style_image',
                'selector' => '{{WRAPPER}} .elementor-image img',
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
                    '{{WRAPPER}} .elementor-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_box_shadow',
                'section' => 'section_style_image',
                'tab' => self::TAB_STYLE,
                'selector' => '{{WRAPPER}} .elementor-image img',
            ]
        );

    }

    protected function render( $instance = [] ) {
        if ( empty( $instance['image']['url'] ) ) {
            return;
        }
        $has_caption = ! empty( $instance['caption'] );

        $image_html = '<div class="elementor-image' . ( ! empty( $instance['shape'] ) ? ' elementor-image-shape-' . $instance['shape'] : '' ) . '">';


        $image_class_html = ! empty( $instance['hover_animation'] ) ? ' class="elementor-animation-' . $instance['hover_animation'] . '"' : '';

        $image_html .= sprintf( '<img src="%s" alt="%s"%s />', \IqitElementorWpHelper::esc_attr( \IqitElementorWpHelper::getImage($instance['image']['url'])  ), \IqitElementorWpHelper::esc_attr( $instance['caption'] ) , $image_class_html );

        $link = $this->get_link_url( $instance );
        if ( $link ) {
            $target = '';
            if ( ! empty( $link['is_external'] ) ) {
                $target = ' target="_blank" rel="noopener noreferrer"';
            }
            $image_html = sprintf( '<a href="%s"%s>%s</a>', $link['url'], $target, $image_html );
        }

        $image_html .= '</div>';

        echo $image_html;
    }



    protected function content_template() {
        ?>
        <# if ( '' !== settings.image.url ) { #>
            <div class="elementor-image{{ settings.shape ? ' elementor-image-shape-' + settings.shape : '' }}">
                <#
                var imgClass = '', image_html = '',
                    hasCaption = '' !== settings.caption,
                    image_html = '';

                if ( '' !== settings.hover_animation ) {
                    imgClass = 'elementor-animation-' + settings.hover_animation;
                }

                image_html = '<img src="' + settings.image.url + '" class="' + imgClass + '" alt="' + settings.caption + '" />';
                
                var link_url;
                if ( 'custom' === settings.link_to ) {
                    link_url = settings.link.url;
                }
                
                if ( 'file' === settings.link_to ) {
                    link_url = settings.image.url;
                }
                
                if ( link_url ) {
                    image_html = '<a href="' + link_url + '">' + image_html + '</a>';
                }


                print( image_html );
                #>
            </div>
        <# } #>
        <?php
    }

    private function get_link_url( $instance ) {
        if ( 'none' === $instance['link_to'] ) {
            return false;
        }

        if ( 'custom' === $instance['link_to'] ) {
            if ( empty( $instance['link']['url'] ) ) {
                return false;
            }
            return $instance['link'];
        }

        return [
            'url' => $instance['image']['url'],
        ];
    }
}

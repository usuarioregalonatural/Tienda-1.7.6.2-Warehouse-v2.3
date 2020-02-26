<?php
namespace Elementor;

if ( ! defined( 'ELEMENTOR_ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Banner extends Widget_Base {

    public function get_id() {
        return 'banner';
    }

    public function get_title() {
        return \IqitElementorWpHelper::__( 'Banner', 'elementor' );
    }

    public function get_icon() {
        return 'banner';
    }

    public static function get_button_sizes() {
        return [
            'small' => \IqitElementorWpHelper::__( 'Small', 'elementor' ),
            'medium' => \IqitElementorWpHelper::__( 'Medium', 'elementor' ),
            'large' => \IqitElementorWpHelper::__( 'Large', 'elementor' ),
            'xl' => \IqitElementorWpHelper::__( 'XL', 'elementor' ),
            'xxl' => \IqitElementorWpHelper::__( 'XXL', 'elementor' ),
        ];
    }

    protected function _register_controls() {
        $this->add_control(
            'section_image',
            [
                'label' => \IqitElementorWpHelper::__( 'Banner', 'elementor' ),
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
            'above_title_text',
            [
                'label' => \IqitElementorWpHelper::__( 'Subtitle', 'elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => \IqitElementorWpHelper::__( 'Above title', 'elementor' ),
                'placeholder' => \IqitElementorWpHelper::__( 'Your subtitle', 'elementor' ),
                'section' => 'section_image',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'title_text',
            [
                'label' => \IqitElementorWpHelper::__( 'Title', 'elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => \IqitElementorWpHelper::__( 'This is the heading', 'elementor' ),
                'placeholder' => \IqitElementorWpHelper::__( 'Your Title', 'elementor' ),
                'section' => 'section_image',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'title_size',
            [
                'label' => \IqitElementorWpHelper::__( 'Title HTML Tag', 'elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => \IqitElementorWpHelper::__( 'H1', 'elementor' ),
                    'h2' => \IqitElementorWpHelper::__( 'H2', 'elementor' ),
                    'h3' => \IqitElementorWpHelper::__( 'H3', 'elementor' ),
                    'h4' => \IqitElementorWpHelper::__( 'H4', 'elementor' ),
                    'h5' => \IqitElementorWpHelper::__( 'H5', 'elementor' ),
                    'h6' => \IqitElementorWpHelper::__( 'H6', 'elementor' ),
                    'div' => \IqitElementorWpHelper::__( 'div', 'elementor' ),
                    'span' => \IqitElementorWpHelper::__( 'span', 'elementor' ),
                    'p' => \IqitElementorWpHelper::__( 'p', 'elementor' ),
                ],
                'default' => 'h4',
                'section' => 'section_image',
            ]
        );

        $this->add_control(
            'description_text',
            [
                'label' => \IqitElementorWpHelper::__( 'Description', 'elementor' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' =>  \IqitElementorWpHelper::__( 'I am text block. Click edit button to change this text.', 'elementor' ),
                'section' => 'section_image',
            ]
        );
        $this->add_control(
            'button_text',
            [
                'label' => \IqitElementorWpHelper::__( 'Button txt', 'elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => \IqitElementorWpHelper::__( 'Click', 'elementor' ),
                'placeholder' => \IqitElementorWpHelper::__( 'View', 'elementor' ),
                'section' => 'section_image',
            ]
        );

        $this->add_control(
            'button_icon',
            [
                'label' => \IqitElementorWpHelper::__( 'Button icon', 'elementor' ),
                'type' => Controls_Manager::ICON,
                'label_block' => true,
                'default' => '',
                'section' => 'section_image',
            ]
        );

        $this->add_control(
            'button_icon_align',
            [
                'label' => \IqitElementorWpHelper::__( 'Button icon Position', 'elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left' => \IqitElementorWpHelper::__( 'Before', 'elementor' ),
                    'right' => \IqitElementorWpHelper::__( 'After', 'elementor' ),
                ],
                'condition' => [
                    'button_icon!' => '',
                ],
                'section' => 'section_image',
            ]
        );

        $this->add_control(
            'button_icon_indent',
            [
                'label' => \IqitElementorWpHelper::__( 'Button icon Spacing', 'elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'condition' => [
                    'button_icon!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-button .elementor-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
                'section' => 'section_image',
            ]
        );


        $this->add_control(
            'link',
            [
                'label' => \IqitElementorWpHelper::__( 'Link to', 'elementor' ),
                'type' => Controls_Manager::URL,
                'placeholder' => \IqitElementorWpHelper::__( 'http://your-link.com', 'elementor' ),
                'section' => 'section_image',
                'separator' => 'before',
            ]
        );


        $this->add_control(
            'view',
            [
                'label' => \IqitElementorWpHelper::__( 'View', 'elementor' ),
                'type' => Controls_Manager::HIDDEN,
                'default' => 'traditional',
                'section' => 'section_content',
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
            'hover_animation',
            [
                'label' => \IqitElementorWpHelper::__( 'Animation', 'elementor' ),
                'type' => Controls_Manager::HOVER_ANIMATION,
                'tab' => self::TAB_STYLE,
                'section' => 'section_style_image',
            ]
        );

        $this->add_control(
            'heading_overlay',
            [
                'label' => \IqitElementorWpHelper::__( 'Hover overlay', 'elementor' ),
                'type' => Controls_Manager::HEADING,
                'section' => 'section_style_image',
                'tab' => self::TAB_STYLE,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'background',
                'tab' => self::TAB_STYLE,
                'section' => 'section_style_image',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}}  .elementor-iqit-banner-overlay',
            ]
        );

        $this->add_control(
            'section_style_content',
            [
                'type'  => Controls_Manager::SECTION,
                'label' => \IqitElementorWpHelper::__( 'Content', 'elementor' ),
                'tab'   => self::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'text_align',
            [
                'label' => \IqitElementorWpHelper::__( 'Text Alignment', 'elementor' ),
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
                'section' => 'section_style_content',
                'tab' => self::TAB_STYLE,
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .elementor-iqit-banner-content' => 'text-align: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'content_position',
            [
                'label' => \IqitElementorWpHelper::__( 'Text position', 'elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'on' => \IqitElementorWpHelper::__( 'On image', 'elementor' ),
                    'below' => \IqitElementorWpHelper::__( 'Below', 'elementor' ),
                ],
                'default' => 'on',
                'section' => 'section_style_content',
                'tab' => self::TAB_STYLE,
            ]
        );

        $this->add_control(
            'content_vertical_alignment',
            [
                'label' => \IqitElementorWpHelper::__( 'Text position', 'elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'top-left' => \IqitElementorWpHelper::__( 'Top Left', 'elementor' ),
                    'top-center' => \IqitElementorWpHelper::__( 'Top Center', 'elementor' ),
                    'top-right' => \IqitElementorWpHelper::__( 'Top Right', 'elementor' ),
                    'middle-left' => \IqitElementorWpHelper::__( 'Middle Left', 'elementor' ),
                    'middle-center' => \IqitElementorWpHelper::__( 'Middle Center', 'elementor' ),
                    'middle-right' => \IqitElementorWpHelper::__( 'Middle Right', 'elementor' ),
                    'bottom-left' => \IqitElementorWpHelper::__( 'Bottom Left', 'elementor' ),
                    'bottom-center' => \IqitElementorWpHelper::__( 'Bottom Center', 'elementor' ),
                    'bottom-right' => \IqitElementorWpHelper::__( 'Bottom Right', 'elementor' ),
                ],
                'default' => 'middle-center',
                'section' => 'section_style_content',
                'condition' => [
                    'content_position' => 'on',
                ],
                'tab' => self::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'text_padding',
            [
                'label' => \IqitElementorWpHelper::__( 'Text Padding', 'elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [  'rem' , 'px', 'em', '%' ],
                'tab' => self::TAB_STYLE,
                'section' => 'section_style_content',
                'selectors' => [
                    '{{WRAPPER}} .elementor-iqit-banner-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_title',
            [
                'label' => \IqitElementorWpHelper::__( 'Title', 'elementor' ),
                'type' => Controls_Manager::HEADING,
                'section' => 'section_style_content',
                'tab' => self::TAB_STYLE,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'title_bottom_space',
            [
                'label' => \IqitElementorWpHelper::__( 'Title Spacing', 'elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'section' => 'section_style_content',
                'tab' => self::TAB_STYLE,
                'selectors' => [
                    '{{WRAPPER}} .elementor-iqit-banner .elementor-iqit-banner-title' => 'margin: {{SIZE}}{{UNIT}} 0;',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => \IqitElementorWpHelper::__( 'Title Color', 'elementor' ),
                'type' => Controls_Manager::COLOR,
                'tab' => self::TAB_STYLE,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-iqit-banner .elementor-iqit-banner-title' => 'color: {{VALUE}};',
                ],
                'section' => 'section_style_content',
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .elementor-iqit-banner .elementor-iqit-banner-title',
                'tab' => self::TAB_STYLE,
                'section' => 'section_style_content',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
            ]
        );

        $this->add_control(
            'heading_description',
            [
                'label' => \IqitElementorWpHelper::__( 'Description', 'elementor' ),
                'type' => Controls_Manager::HEADING,
                'section' => 'section_style_content',
                'tab' => self::TAB_STYLE,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => \IqitElementorWpHelper::__( 'Description Color', 'elementor' ),
                'type' => Controls_Manager::COLOR,
                'tab' => self::TAB_STYLE,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-iqit-banner .elementor-iqit-banner-description' => 'color: {{VALUE}};',
                ],
                'section' => 'section_style_content',
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .elementor-iqit-banner .elementor-iqit-banner-description',
                'tab' => self::TAB_STYLE,
                'section' => 'section_style_content',
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
            ]
        );

        $this->add_control(
            'section_style_button',
            [
                'type'  => Controls_Manager::SECTION,
                'label' => \IqitElementorWpHelper::__( 'Button', 'elementor' ),
                'tab'   => self::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'button_space',
            [
                'label' => \IqitElementorWpHelper::__( 'Button spacing', 'elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'section' => 'section_style_button',
                'tab' => self::TAB_STYLE,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_size',
            [
                'label' => \IqitElementorWpHelper::__( 'Size', 'elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'medium',
                'tab' => self::TAB_STYLE,
                'options' => self::get_button_sizes(),
                'section' => 'section_style_button',
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => \IqitElementorWpHelper::__( 'Text Color', 'elementor' ),
                'type' => Controls_Manager::COLOR,
                'tab' => self::TAB_STYLE,
                'section' => 'section_style_button',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => \IqitElementorWpHelper::__( 'Typography', 'elementor' ),
                'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                'tab' => self::TAB_STYLE,
                'section' => 'section_style_button',
                'selector' => '{{WRAPPER}} .elementor-button',
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label' => \IqitElementorWpHelper::__( 'Background Color', 'elementor' ),
                'type' => Controls_Manager::COLOR,
                'tab' => self::TAB_STYLE,
                'section' => 'section_style_button',
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_4,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'label' => \IqitElementorWpHelper::__( 'Border', 'elementor' ),
                'tab' => self::TAB_STYLE,
                'placeholder' => '1px',
                'default' => '1px',
                'section' => 'section_style_button',
                'selector' => '{{WRAPPER}} .elementor-button',
            ]
        );


        $this->add_control(
            'heading_button',
            [
                'label' => \IqitElementorWpHelper::__( 'Button hover', 'elementor' ),
                'type' => Controls_Manager::HEADING,
                'section' => 'section_style_button',
                'tab' => self::TAB_STYLE,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'button_text_color_h',
            [
                'label' => \IqitElementorWpHelper::__( 'Text Color', 'elementor' ),
                'type' => Controls_Manager::COLOR,
                'tab' => self::TAB_STYLE,
                'section' => 'section_style_button',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_color_h',
            [
                'label' => \IqitElementorWpHelper::__( 'Background Color', 'elementor' ),
                'type' => Controls_Manager::COLOR,
                'tab' => self::TAB_STYLE,
                'section' => 'section_style_button',
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_4,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_border_h',
            [
                'label' => \IqitElementorWpHelper::__( 'Border Color', 'elementor' ),
                'type' => Controls_Manager::COLOR,
                'tab' => self::TAB_STYLE,
                'section' => 'section_style_button',
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_4,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );


    }

    protected function render( $instance = [] ) {
        $has_content = ! empty( $instance['title_text'] ) || ! empty( $instance['description_text'] );


        if ( ! empty( $instance['button_icon'] ) )  {
            $this->add_render_attribute( 'button-icon-align', 'class', 'elementor-align-icon-' . $instance['button_icon_align'] );
            $this->add_render_attribute( 'button-icon-align', 'class', 'elementor-button-icon' );
        }

        $html = '<div class="elementor-iqit-banner">';


        if ( ! empty( $instance['link']['url'] ) ) {
            $target = '';

            if ( ! empty( $instance['link']['is_external'] ) ) {
                $target = ' target="_blank" rel="noopener noreferrer"';
            }
            $html .= sprintf( '<a href="%s"%s>', $instance['link']['url'], $target );
        }
        if ( ! empty( $instance['image']['url'] ) ) {
            $this->add_render_attribute( 'image', 'src', \IqitElementorWpHelper::getImage($instance['image']['url'])  );
            $this->add_render_attribute( 'image', 'alt', \IqitElementorWpHelper::esc_attr( $instance['caption'] ) );


            if ( $instance['hover_animation'] ) {
                $this->add_render_attribute( 'image', 'class', 'elementor-animation-' . $instance['hover_animation'] );
            }

            $image_html = '<img ' . $this->get_render_attribute_string( 'image' ) . '>';


            $html .= '<figure class="elementor-iqit-banner-img"><span class="elementor-iqit-banner-overlay"></span>' . $image_html . '</figure>';
        }

        if ( $has_content ) {
            $html .= '<div class="elementor-iqit-banner-content elementor-iqit-banner-content-' . $instance['content_position'] . ' elementor-banner-align-'. $instance['content_vertical_alignment'] .'">';

            if ( ! empty( $instance['above_title_text'] ) ) {
                $html .= '<span class="elementor-iqit-banner-subtitle elementor-iqit-banner-description">' . $instance['above_title_text'] . '</span>' ;
            }

            if ( ! empty( $instance['title_text'] ) ) {
                $title_html = $instance['title_text'];
                $html .= sprintf( '<%1$s class="elementor-iqit-banner-title">%2$s</%1$s>', $instance['title_size'], $title_html );
            }

            if ( ! empty( $instance['description_text'] ) ) {
                $html .= '<div class="elementor-iqit-banner-description">' . $instance['description_text'] . '</div>' ;
            }

            if ( ! empty( $instance['button_text'] ) ) {
                $html .= '<div><span class="elementor-button-link elementor-button btn elementor-size-' . $instance['button_size'] . ' btn-primary">';

                if ( ! empty( $instance['button_icon'] ) ) {
                    $html .= '<span '. $this->get_render_attribute_string( 'button-icon-align' ). '>
                    <i class="'. \IqitElementorWpHelper::esc_attr( $instance['button_icon'] ). '"></i>
                    </span>';
                }

                $html .= '<span class="elementor-button-text">'.$instance['button_text'] .'</span></span></div>' ;
            }


            $html .= '</div>';
        }

        if ( ! empty( $instance['link']['url'] ) ) {
            $html .= '</a>';
        }

        $html .= '</div>';

        echo $html;
    }




    protected function content_template() {
        ?>
        <#
        var html = '<div class="elementor-iqit-banner">';

        if ( settings.link.url ) {
                html += '<a href="' + settings.link.url + '">';
        }

        if ( settings.image.url ) {
            var imageHtml = '<img src="' + settings.image.url + '" class="elementor-animation-' + settings.hover_animation + '"   alt="' + settings.caption + '"  />';
            html += '<figure class="elementor-iqit-banner-img"><span class="elementor-iqit-banner-overlay"></span>' + imageHtml + '</figure>';
        }

        var hasContent = !! ( settings.title_text || settings.description_text );

        if ( hasContent ) {
            html += '<div class="elementor-iqit-banner-content elementor-iqit-banner-content-' + settings.content_position + ' elementor-banner-align-'+ settings.content_vertical_alignment + '">';

            if ( settings.above_title_text ) {
                html += '<span class="elementor-iqit-banner-subtitle elementor-iqit-banner-description">' + settings.above_title_text + '</span>';
            }

            if ( settings.title_text ) {
                var title_html = settings.title_text;

                html += '<' + settings.title_size  + ' class="elementor-iqit-banner-title">' + title_html + '</' + settings.title_size  + '>';
            }

            if ( settings.description_text ) {
                html += '<div class="elementor-iqit-banner-description">' + settings.description_text + '</div>';
            }

            if ( settings.button_text ) {
                html += '<div><span class="elementor-button-link elementor-button btn elementor-size-' + settings.button_size + ' btn-primary">';

                if ( settings.button_icon ) {
                    html += '<span class="elementor-button-icon elementor-align-icon-' + settings.button_icon_align + '"><i class="' + settings.button_icon + '"></i></span>';
                }

                 html += '<span class="elementor-button-text">' + settings.button_text + '</span></span></div>';
            }

            html += '</div>';
        }

        if ( settings.link.url ) {
            html += '</a>';
        }

        html += '</div>';

        print( html );
        #>
        <?php
    }
}


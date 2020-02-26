<?php
namespace Elementor;

if ( ! defined( 'ELEMENTOR_ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Image_box extends Widget_Base {

    public function get_id() {
        return 'image-box';
    }

    public function get_title() {
        return \IqitElementorWpHelper::__( 'Image Box', 'elementor' );
    }

    public function get_icon() {
        return 'image-box';
    }

    protected function _register_controls() {
        $this->add_control(
            'section_image',
            [
                'label' => \IqitElementorWpHelper::__( 'Image Box', 'elementor' ),
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
            'title_text',
            [
                'label' => \IqitElementorWpHelper::__( 'Title & Description', 'elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => \IqitElementorWpHelper::__( 'This is the heading', 'elementor' ),
                'placeholder' => \IqitElementorWpHelper::__( 'Your Title', 'elementor' ),
                'section' => 'section_image',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'description_text',
            [
                'show_label' => false,
                'label' => \IqitElementorWpHelper::__( 'Content', 'elementor' ),
                'type' => Controls_Manager::WYSIWYG,
                'default' => '<p>' . \IqitElementorWpHelper::__( 'I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'elementor' ) . '</p>',
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
            'position',
            [
                'label' => \IqitElementorWpHelper::__( 'Image Position', 'elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'top',
                'options' => [
                    'left' => [
                        'title' => \IqitElementorWpHelper::__( 'Left', 'elementor' ),
                        'icon' => 'align-left',
                    ],
                    'top' => [
                        'title' => \IqitElementorWpHelper::__( 'Top', 'elementor' ),
                        'icon' => 'align-center',
                    ],
                    'right' => [
                        'title' => \IqitElementorWpHelper::__( 'Right', 'elementor' ),
                        'icon' => 'align-right',
                    ],
                ],
                'prefix_class' => 'elementor-position-',
                'toggle' => false,
                'section' => 'section_image',
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
                'default' => 'h3',
                'section' => 'section_image',
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
            'image_space',
            [
                'label' => \IqitElementorWpHelper::__( 'Image Spacing', 'elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 15,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'section' => 'section_style_image',
                'tab' => self::TAB_STYLE,
                'selectors' => [
                    '{{WRAPPER}}.elementor-position-right .elementor-image-box-img' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.elementor-position-left .elementor-image-box-img' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.elementor-position-top .elementor-image-box-img' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_size',
            [
                'label' => \IqitElementorWpHelper::__( 'Image Size', 'elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 30,
                    'unit' => '%',
                ],
                'size_units' => [ '%' ],
                'range' => [
                    '%' => [
                        'min' => 5,
                        'max' => 100,
                    ],
                ],
                'section' => 'section_style_image',
                'tab' => self::TAB_STYLE,
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-wrapper .elementor-image-box-img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_opacity',
            [
                'label' => \IqitElementorWpHelper::__( 'Opacity (%)', 'elementor' ),
                'type' => Controls_Manager::SLIDER,
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
                'section' => 'section_style_image',
                'tab' => self::TAB_STYLE,
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-wrapper .elementor-image-box-img img' => 'opacity: {{SIZE}};',
                ],
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
                    'justify' => [
                        'title' => \IqitElementorWpHelper::__( 'Justified', 'elementor' ),
                        'icon' => 'align-justify',
                    ],
                ],
                'section' => 'section_style_content',
                'tab' => self::TAB_STYLE,
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'content_vertical_alignment',
            [
                'label' => \IqitElementorWpHelper::__( 'Vertical Alignment', 'elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'top' => \IqitElementorWpHelper::__( 'Top', 'elementor' ),
                    'middle' => \IqitElementorWpHelper::__( 'Middle', 'elementor' ),
                    'bottom' => \IqitElementorWpHelper::__( 'Bottom', 'elementor' ),
                ],
                'default' => 'top',
                'section' => 'section_style_content',
                'tab' => self::TAB_STYLE,
                'prefix_class' => 'elementor-vertical-align-',
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
                    '{{WRAPPER}} .elementor-image-box-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-image-box-content .elementor-image-box-title' => 'color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .elementor-image-box-content .elementor-image-box-title',
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
                    '{{WRAPPER}} .elementor-image-box-content .elementor-image-box-description' => 'color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .elementor-image-box-content .elementor-image-box-description',
                'tab' => self::TAB_STYLE,
                'section' => 'section_style_content',
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
            ]
        );
    }

    protected function render( $instance = [] ) {
        $has_content = ! empty( $instance['title_text'] ) || ! empty( $instance['description_text'] );

        $html = '<div class="elementor-image-box-wrapper">';

        if ( ! empty( $instance['image']['url'] ) ) {
            $this->add_render_attribute( 'image', 'src', \IqitElementorWpHelper::getImage($instance['image']['url'])   );
            $this->add_render_attribute( 'image', 'alt', \IqitElementorWpHelper::esc_attr( $instance['caption'] ) );

            if ( $instance['hover_animation'] ) {
                $this->add_render_attribute( 'image', 'class', 'elementor-animation-' . $instance['hover_animation'] );
            }

            $image_html = '<img ' . $this->get_render_attribute_string( 'image' ) . '>';

            if ( ! empty( $instance['link']['url'] ) ) {
                $target = '';
                if ( ! empty( $instance['link']['is_external'] ) ) {
                    $target = ' target="_blank" rel="noopener noreferrer"';
                }
                $image_html = sprintf( '<a href="%s"%s>%s</a>', $instance['link']['url'], $target, $image_html );
            }

            $html .= '<figure class="elementor-image-box-img">' . $image_html . '</figure>';
        }

        if ( $has_content ) {
            $html .= '<div class="elementor-image-box-content">';

            if ( ! empty( $instance['title_text'] ) ) {
                $title_html = $instance['title_text'];

                if ( ! empty( $instance['link']['url'] ) ) {
                    $target = '';

                    if ( ! empty( $instance['link']['is_external'] ) ) {
                        $target = ' target="_blank" rel="noopener noreferrer"';
                    }

                    $title_html = sprintf( '<a href="%s"%s>%s</a>', $instance['link']['url'], $target, $title_html );
                }

                $html .= sprintf( '<%1$s class="elementor-image-box-title">%2$s</%1$s>', $instance['title_size'], $title_html );
            }

            if ( ! empty( $instance['description_text'] ) ) {
                $html .= sprintf( '<div class="elementor-image-box-description">%s</div>', $instance['description_text'] );
            }

            $html .= '</div>';
        }

        $html .= '</div>';

        echo $html;
    }

    protected function content_template() {
        ?>
        <#
        var html = '<div class="elementor-image-box-wrapper">';

        if ( settings.image.url ) {
            var imageHtml = '<img src="' + settings.image.url + '"  alt="' + settings.caption + '" class="elementor-animation-' + settings.hover_animation + '" />';

            if ( settings.link.url ) {
                imageHtml = '<a href="' + settings.link.url + '">' + imageHtml + '</a>';
            }

            html += '<figure class="elementor-image-box-img">' + imageHtml + '</figure>';
        }

        var hasContent = !! ( settings.title_text || settings.description_text );

        if ( hasContent ) {
            html += '<div class="elementor-image-box-content">';

            if ( settings.title_text ) {
                var title_html = settings.title_text;

                if ( settings.link.url ) {
                    title_html = '<a href="' + settings.link.url + '">' + title_html + '</a>';
                }

                html += '<' + settings.title_size  + ' class="elementor-image-box-title">' + title_html + '</' + settings.title_size  + '>';
            }

            if ( settings.description_text ) {
                html += '<div class="elementor-image-box-description">' + settings.description_text + '</div>';
            }

            html += '</div>';
        }

        html += '</div>';

        print( html );
        #>
        <?php
    }
}

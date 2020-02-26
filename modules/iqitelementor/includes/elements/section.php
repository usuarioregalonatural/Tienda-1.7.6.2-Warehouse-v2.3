<?php
namespace Elementor;

if ( ! defined( 'ELEMENTOR_ABSPATH' ) ) exit; // Exit if accessed directly

class Element_Section extends Element_Base {

    private static $presets = [];

    public function get_id() {
        return 'section';
    }

    public function get_title() {
        return \IqitElementorWpHelper::__( 'Section', 'elementor' );
    }

    public function get_icon() {
        return 'columns';
    }

    public static function get_presets( $columns_count = null, $preset_index = null ) {
        if ( ! self::$presets ) {
            self::init_presets();
        }

        $presets = self::$presets;

        if ( null !== $columns_count ) {
            $presets = $presets[ $columns_count ];
        }

        if ( null !== $preset_index ) {
            $presets = $presets[ $preset_index ];
        }

        return $presets;
    }

    public static function init_presets() {
        $additional_presets = [
            2 => [
                [
                    'preset' => [ 33, 66 ],
                ],
                [
                    'preset' => [ 66, 33 ],
                ],
            ],
            3 => [
                [
                    'preset' => [ 25, 25, 50 ],
                ],
                [
                    'preset' => [ 50, 25, 25 ],
                ],
                [
                    'preset' => [ 25, 50, 25 ],
                ],
                [
                    'preset' => [ 16, 66, 16 ],
                ],
            ],
        ];

        foreach ( range( 1, 10 ) as $columns_count ) {
            self::$presets[ $columns_count ] = [
                [
                    'preset' => [],
                ],
            ];

            $preset_unit = floor( 1 / $columns_count * 100 );

            for ( $i = 0; $i < $columns_count; $i++ ) {
                self::$presets[ $columns_count ][0]['preset'][] = $preset_unit;
            }

            if ( ! empty( $additional_presets[ $columns_count ] ) ) {
                self::$presets[ $columns_count ] = array_merge( self::$presets[ $columns_count ], $additional_presets[ $columns_count ] );
            }

            foreach ( self::$presets[ $columns_count ] as $preset_index => & $preset ) {
                $preset['key'] = $columns_count . $preset_index;
            }
        }
    }

    public function get_data() {
        $data = parent::get_data();

        $data['presets'] = self::get_presets();

        return $data;
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'section_layout',
            [
                'label' => \IqitElementorWpHelper::__( 'Layout', 'elementor' ),
                'tab' => self::TAB_LAYOUT,
            ]
        );

        $this->add_control(
            'stretch_section',
            [
                'label' => \IqitElementorWpHelper::__( 'Stretch Section', 'elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => \IqitElementorWpHelper::__( 'Yes', 'elementor' ),
                'label_off' => \IqitElementorWpHelper::__( 'No', 'elementor' ),
                'return_value' => 'section-stretched',
                'prefix_class' => 'elementor-',
                'force_render' => true,
                'hide_in_inner' => true,
                'description' => \IqitElementorWpHelper::__( 'Stretch the section to the full width of the page using JS.', 'elementor' ) . sprintf( ' <a href="%s" target="_blank">%s</a>', 'https://go.elementor.com/stretch-section/', \IqitElementorWpHelper::__( 'Learn more.', 'elementor' ) ),
            ]
        );

        $this->add_control(
            'layout',
            [
                'label' => \IqitElementorWpHelper::__( 'Content Width', 'elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'boxed',
                'options' => [
                    'boxed' => \IqitElementorWpHelper::__( 'Boxed', 'elementor' ),
                    'full_width' => \IqitElementorWpHelper::__( 'Full Width', 'elementor' ),
                ],
                'prefix_class' => 'elementor-section-',
            ]
        );

        $this->add_control(
            'content_width',
            [
                'label' => \IqitElementorWpHelper::__( 'Content Width', 'elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 500,
                        'max' => 1600,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} > .elementor-container' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'layout' => [ 'boxed' ],
                ],
                'show_label' => false,
                'separator' => 'none',
            ]
        );

        $this->add_control(
            'gap',
            [
                'label' => \IqitElementorWpHelper::__( 'Columns Gap', 'elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => \IqitElementorWpHelper::__( 'Default', 'elementor' ),
                    'no' => \IqitElementorWpHelper::__( 'No Gap', 'elementor' ),
                    'narrow' => \IqitElementorWpHelper::__( 'Narrow', 'elementor' ),
                    'extended' => \IqitElementorWpHelper::__( 'Extended', 'elementor' ),
                    'wide' => \IqitElementorWpHelper::__( 'Wide', 'elementor' ),
                    'wider' => \IqitElementorWpHelper::__( 'Wider', 'elementor' ),
                ],
            ]
        );

        $this->add_control(
            'height',
            [
                'label' => \IqitElementorWpHelper::__( 'Height', 'elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => \IqitElementorWpHelper::__( 'Default', 'elementor' ),
                    'full' => \IqitElementorWpHelper::__( 'Fit To Screen', 'elementor' ),
                    'min-height' => \IqitElementorWpHelper::__( 'Min Height', 'elementor' ),
                ],
                'prefix_class' => 'elementor-section-height-',
                'hide_in_inner' => true,
            ]
        );

        $this->add_control(
            'custom_height',
            [
                'label' => \IqitElementorWpHelper::__( 'Minimum Height', 'elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 400,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1440,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} > .elementor-container' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'height' => [ 'min-height' ],
                ],
                'hide_in_inner' => true,
            ]
        );

        $this->add_control(
            'height_inner',
            [
                'label' => \IqitElementorWpHelper::__( 'Height', 'elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => \IqitElementorWpHelper::__( 'Default', 'elementor' ),
                    'min-height' => \IqitElementorWpHelper::__( 'Min Height', 'elementor' ),
                ],
                'prefix_class' => 'elementor-section-height-',
                'hide_in_top' => true,
            ]
        );

        $this->add_control(
            'custom_height_inner',
            [
                'label' => \IqitElementorWpHelper::__( 'Minimum Height', 'elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 400,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1440,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} > .elementor-container' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'height_inner' => [ 'min-height' ],
                ],
                'hide_in_top' => true,
            ]
        );

        $this->add_control(
            'column_position',
            [
                'label' => \IqitElementorWpHelper::__( 'Column Position', 'elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'middle',
                'options' => [
                    'stretch' => \IqitElementorWpHelper::__( 'Stretch', 'elementor' ),
                    'top' => \IqitElementorWpHelper::__( 'Top', 'elementor' ),
                    'middle' => \IqitElementorWpHelper::__( 'Middle', 'elementor' ),
                    'bottom' => \IqitElementorWpHelper::__( 'Bottom', 'elementor' ),
                ],
                'prefix_class' => 'elementor-section-items-',
                'condition' => [
                    'height' => [ 'full', 'min-height' ],
                ],
            ]
        );

        $this->add_control(
            'content_position',
            [
                'label' => \IqitElementorWpHelper::__( 'Content Position', 'elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => \IqitElementorWpHelper::__( 'Default', 'elementor' ),
                    'top' => \IqitElementorWpHelper::__( 'Top', 'elementor' ),
                    'middle' => \IqitElementorWpHelper::__( 'Middle', 'elementor' ),
                    'bottom' => \IqitElementorWpHelper::__( 'Bottom', 'elementor' ),
                ],
                'prefix_class' => 'elementor-section-content-',
            ]
        );

        $this->add_control(
            'structure',
            [
                'label' => \IqitElementorWpHelper::__( 'Structure', 'elementor' ),
                'type' => Controls_Manager::STRUCTURE,
                'default' => '10',
            ]
        );

        $this->end_controls_section();

        // Section background
        $this->start_controls_section(
            'section_background',
            [
                'label' => \IqitElementorWpHelper::__( 'Background', 'elementor' ),
                'tab' => self::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'background',
                'types' => [ 'classic', 'gradient', 'video' ],
            ]
        );

        $this->end_controls_section();

        // Background Overlay
        $this->start_controls_section(
            'background_overlay_section',
            [
                'label' => \IqitElementorWpHelper::__( 'Background Overlay', 'elementor' ),
                'tab' => self::TAB_STYLE,
                'condition' => [
                    'background_background' => [ 'classic', 'gradient', 'video' ],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'background_overlay',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} > .elementor-background-overlay',
                'condition' => [
                    'background_background' => [ 'classic', 'gradient', 'video' ],
                ],
            ]
        );

        $this->add_control(
            'background_overlay_opacity',
            [
                'label' => \IqitElementorWpHelper::__( 'Opacity (%)', 'elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => .5,
                ],
                'range' => [
                    'px' => [
                        'max' => 1,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} > .elementor-background-overlay' => 'opacity: {{SIZE}};',
                ],
                'condition' => [
                    'background_overlay_background' => [ 'classic', 'gradient', ],
                ],
            ]
        );

        $this->end_controls_section();

        // Section border
        $this->start_controls_section(
            'section_border',
            [
                'label' => \IqitElementorWpHelper::__( 'Border', 'elementor' ),
                'tab' => self::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border',
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => \IqitElementorWpHelper::__( 'Border Radius', 'elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}}, {{WRAPPER}} > .elementor-background-overlay' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
            ]
        );

        $this->end_controls_section();

        // Section Typography
        $this->start_controls_section(
            'section_typo',
            [
                'label' => \IqitElementorWpHelper::__( 'Typography', 'elementor' ),
                'tab' => self::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label' => \IqitElementorWpHelper::__( 'Heading Color', 'elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} > .elementor-container .elementor-heading-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'color_text',
            [
                'label' => \IqitElementorWpHelper::__( 'Text Color', 'elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} > .elementor-container' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'color_link',
            [
                'label' => \IqitElementorWpHelper::__( 'Link Color', 'elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} > .elementor-container a' => 'color: {{VALUE}};',
                ],
                'tab' => self::TAB_STYLE,
                'section' => 'section_typo',
            ]
        );

        $this->add_control(
            'color_link_hover',
            [
                'label' => \IqitElementorWpHelper::__( 'Link Hover Color', 'elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} > .elementor-container a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'text_align',
            [
                'label' => \IqitElementorWpHelper::__( 'Text Align', 'elementor' ),
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
                'selectors' => [
                    '{{WRAPPER}} > .elementor-container' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Section Advanced
        $this->start_controls_section(
            'section_advanced',
            [
                'label' => \IqitElementorWpHelper::__( 'Advanced', 'elementor' ),
                'tab' => self::TAB_ADVANCED,
            ]
        );

        $this->add_responsive_control(
            'margin',
            [
                'label' => \IqitElementorWpHelper::__( 'Margin', 'elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'allowed_dimensions' => 'vertical',
                'placeholder' => [
                    'top' => '',
                    'right' => 'auto',
                    'bottom' => '',
                    'left' => 'auto',
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'margin-top: {{TOP}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'padding',
            [
                'label' => \IqitElementorWpHelper::__( 'Padding', 'elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'animation',
            [
                'label' => \IqitElementorWpHelper::__( 'Entrance Animation', 'elementor' ),
                'type' => Controls_Manager::ANIMATION,
                'default' => '',
                'prefix_class' => 'animated ',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'animation_duration',
            [
                'label' => \IqitElementorWpHelper::__( 'Animation Duration', 'elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    'slow' => \IqitElementorWpHelper::__( 'Slow', 'elementor' ),
                    '' => \IqitElementorWpHelper::__( 'Normal', 'elementor' ),
                    'fast' => \IqitElementorWpHelper::__( 'Fast', 'elementor' ),
                ],
                'prefix_class' => 'animated-',
                'condition' => [
                    'animation!' => '',
                ],
            ]
        );

        $this->add_control(
            'css_classes',
            [
                'label' => \IqitElementorWpHelper::__( 'CSS Classes', 'elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'prefix_class' => '',
                'label_block' => true,
                'title' => \IqitElementorWpHelper::__( 'Add your custom class WITHOUT the dot. e.g: my-class', 'elementor' ),
            ]
        );

        $this->end_controls_section();

        // Section Responsive
        $this->start_controls_section(
            '_section_responsive',
            [
                'label' => \IqitElementorWpHelper::__( 'Responsive', 'elementor' ),
                'tab' => self::TAB_ADVANCED,
            ]
        );

        $this->add_control(
            'reverse_order_mobile',
            [
                'label' => \IqitElementorWpHelper::__( 'Reverse Columns', 'elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'prefix_class' => 'elementor-',
                'label_on' => \IqitElementorWpHelper::__( 'Yes', 'elementor' ),
                'label_off' => \IqitElementorWpHelper::__( 'No', 'elementor' ),
                'return_value' => 'reverse-mobile',
                'description' => \IqitElementorWpHelper::__( 'Reverse column order - When on mobile, the column order is reversed, so the last column appears on top and vice versa.', 'elementor' ),
            ]
        );

        $this->add_control(
            'heading_visibility',
            [
                'label' => \IqitElementorWpHelper::__( 'Visibility', 'elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'responsive_description',
            [
                'raw' => \IqitElementorWpHelper::__( 'Attention: The display settings (show/hide for mobile, tablet or desktop) will only take effect once you are on the preview or live page, and not while you\'re in editing mode in Elementor.', 'elementor' ),
                'type' => Controls_Manager::RAW_HTML,
                'classes' => 'elementor-control-descriptor',
            ]
        );

        $this->add_control(
            'hide_desktop',
            [
                'label' => \IqitElementorWpHelper::__( 'Hide On Desktop', 'elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'prefix_class' => 'elementor-',
                'label_on' => \IqitElementorWpHelper::__( 'Hide', 'elementor' ),
                'label_off' => \IqitElementorWpHelper::__( 'Show', 'elementor' ),
                'return_value' => 'hidden-desktop',
            ]
        );

        $this->add_control(
            'hide_tablet',
            [
                'label' => \IqitElementorWpHelper::__( 'Hide On Tablet', 'elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'prefix_class' => 'elementor-',
                'label_on' => \IqitElementorWpHelper::__( 'Hide', 'elementor' ),
                'label_off' => \IqitElementorWpHelper::__( 'Show', 'elementor' ),
                'return_value' => 'hidden-tablet',
            ]
        );

        $this->add_control(
            'hide_mobile',
            [
                'label' => \IqitElementorWpHelper::__( 'Hide On Mobile', 'elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'prefix_class' => 'elementor-',
                'label_on' => \IqitElementorWpHelper::__( 'Hide', 'elementor' ),
                'label_off' => \IqitElementorWpHelper::__( 'Show', 'elementor' ),
                'return_value' => 'hidden-phone',
            ]
        );

        $this->end_controls_section();
    }

    protected function render_settings() {
        ?>
        <div class="elementor-element-overlay"></div>
        <?php
    }

    protected function content_template() {
        ?>
        <# if ( 'video' === settings.background_background ) {
            var videoLink = settings.background_video_link;

            if ( videoLink ) {
                var videoID = elementor.helpers.getYoutubeIDFromURL( settings.background_video_link ); #>

                <div class="elementor-background-video-container ">
                    <# if ( videoID ) { #>
                        <div class="elementor-background-video" data-video-id="{{ videoID }}"></div>
                    <# } else { #>
                        <video class="elementor-background-video" src="{{ videoLink }}" autoplay loop muted></video>
                    <# } #>
                </div>
            <# }#>

            <#
        }

        if ( -1 !== [ 'classic', 'gradient' ].indexOf( settings.background_overlay_background ) ) { #>
            <div class="elementor-background-overlay"></div>
        <# } #>
        <div class="elementor-container elementor-column-gap-{{ settings.gap }}" <# if ( settings.get_render_attribute_string ) { #>{{{ settings.get_render_attribute_string( 'wrapper' ) }}} <# } #> >
            <div class="elementor-row"></div>
        </div>
        <?php
    }

    public function before_render( $instance, $element_id, $element_data = [] ) {
        $section_type = ! empty( $element_data['isInner'] ) ? 'inner' : 'top';

        $this->add_render_attribute( 'wrapper', 'class', [
            'elementor-section',
            'elementor-element',
            'elementor-element-' . $element_id,
            'elementor-' . $section_type . '-section',
        ] );

        foreach ( $this->get_class_controls() as $control ) {
            if ( empty( $instance[ $control['name'] ] ) )
                continue;

            if ( ! $this->is_control_visible( $instance, $control ) )
                continue;

            $this->add_render_attribute( 'wrapper', 'class', $control['prefix_class'] . $instance[ $control['name'] ] );
        }

        if ( ! empty( $instance['animation'] ) ) {
            $this->add_render_attribute( 'wrapper', 'data-animation', $instance['animation'] );
        }

        $this->add_render_attribute( 'wrapper', 'data-element_type', $this->get_id() );
        ?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <?php
            if ( 'video' === $instance['background_background'] ) :
                if ( $instance['background_video_link'] ) :
                    $video_id = UtilsElementor::get_youtube_id_from_url( $instance['background_video_link'] );
                    ?>
                    <div class="elementor-background-video-container">
                        <?php if ( $video_id ) : ?>
                            <div class="elementor-background-video-fallback elementor-hidden-desktop "></div>
                            <div class="elementor-background-video" data-video-id="<?php echo $video_id; ?>"></div>
                        <?php else : ?>
                            <video class="elementor-background-video elementor-html5-video" src="<?php echo $instance['background_video_link'] ?>" autoplay loop muted></video>
                        <?php endif; ?>
                    </div>
                <?php endif;
            endif;

            if ( in_array( $instance['background_overlay_background'], [ 'classic', 'gradient' ] ) ) : ?>
                <div class="elementor-background-overlay"></div>
            <?php endif; ?>
            <div class="elementor-container elementor-column-gap-<?php echo \IqitElementorWpHelper::esc_attr( $instance['gap'] ); ?>">
                <div class="elementor-row">
        <?php
    }

    public function after_render( $instance, $element_id, $element_data = [] ) {
        ?>
                </div>
            </div>
        </div>
        <?php
    }
}

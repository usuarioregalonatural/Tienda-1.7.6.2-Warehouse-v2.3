<?php
namespace Elementor;

if ( ! defined( 'ELEMENTOR_ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Image_Gallery extends Widget_Base {

	public function get_id() {
		return 'image-gallery';
	}

	public function get_title() {
		return \IqitElementorWpHelper::__( 'Image Gallery', 'elementor' );
	}

	public function get_icon() {
		return 'gallery-grid';
	}

	protected function _register_controls() {
		$this->add_control(
			'section_gallery',
			[
				'label' => \IqitElementorWpHelper::__( 'Image Gallery', 'elementor' ),
				'type' => Controls_Manager::SECTION,
			]
		);

		$this->add_control(
			'wp_gallery',
			[
				'label' => \IqitElementorWpHelper::__( 'Add Images', 'elementor' ),
				'type' => Controls_Manager::GALLERY,
				'section' => 'section_gallery',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'exclude' => [ 'custom' ],
				'section' => 'section_gallery',
			]
		);

		$gallery_columns = range( 1, 10 );
		$gallery_columns = array_combine( $gallery_columns, $gallery_columns );

		$this->add_control(
			'gallery_columns',
			[
				'label' => \IqitElementorWpHelper::__( 'Columns', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 4,
				'options' => $gallery_columns,
				'section' => 'section_gallery',
			]
		);

		$this->add_control(
			'gallery_link',
			[
				'label' => \IqitElementorWpHelper::__( 'Link to', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'file',
				'section' => 'section_gallery',
				'options' => [
					'file' => \IqitElementorWpHelper::__( 'Media File', 'elementor' ),
					'attachment' => \IqitElementorWpHelper::__( 'Attachment Page', 'elementor' ),
					'none' => \IqitElementorWpHelper::__( 'None', 'elementor' ),
				],
			]
		);

		$this->add_control(
			'gallery_rand',
			[
				'label' => \IqitElementorWpHelper::__( 'Ordering', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'section' => 'section_gallery',
				'options' => [
					'' => \IqitElementorWpHelper::__( 'Default', 'elementor' ),
					'rand' => \IqitElementorWpHelper::__( 'Random', 'elementor' ),
				],
				'default' => '',
			]
		);

		$this->add_control(
			'view',
			[
				'label' => \IqitElementorWpHelper::__( 'View', 'elementor' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
				'section' => 'section_gallery',
			]
		);

		$this->add_control(
			'section_gallery_images',
			[
				'label' => \IqitElementorWpHelper::__( 'Images', 'elementor' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_spacing',
			[
				'label' => \IqitElementorWpHelper::__( 'Spacing', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'section' => 'section_gallery_images',
				'tab' => self::TAB_STYLE,
				'options' => [
					'' => \IqitElementorWpHelper::__( 'Default', 'elementor' ),
					'custom' => \IqitElementorWpHelper::__( 'Custom', 'elementor' ),
				],
				'prefix_class' => 'gallery-spacing-',
				'default' => '',
			]
		);

		$columns_margin = \IqitElementorWpHelper::is_rtl() ? '0 0 -{{SIZE}}{{UNIT}} -{{SIZE}}{{UNIT}};' : '0 -{{SIZE}}{{UNIT}} -{{SIZE}}{{UNIT}} 0;';
		$columns_padding = \IqitElementorWpHelper::is_rtl() ? '0 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}};' : '0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0;';

		$this->add_control(
			'image_spacing_custom',
			[
				'label' => \IqitElementorWpHelper::__( 'Image Spacing', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'section' => 'section_gallery_images',
				'tab' => self::TAB_STYLE,
				'show_label' => false,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'default' => [
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .gallery-item' => 'padding:' . $columns_padding,
					'{{WRAPPER}} .gallery' => 'margin: ' . $columns_margin,
				],
				'condition' => [
					'image_spacing' => 'custom',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'label' => \IqitElementorWpHelper::__( 'Image Border', 'elementor' ),
				'tab' => self::TAB_STYLE,
				'section' => 'section_gallery_images',
				'selector' => '{{WRAPPER}} .gallery-item img',
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label' => \IqitElementorWpHelper::__( 'Border Radius', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'tab' => self::TAB_STYLE,
				'section' => 'section_gallery_images',
				'selectors' => [
					'{{WRAPPER}} .gallery-item img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'section_caption',
			[
				'label' => \IqitElementorWpHelper::__( 'Caption', 'elementor' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_STYLE,
			]
		);

		$this->add_control(
			'gallery_display_caption',
			[
				'label' => \IqitElementorWpHelper::__( 'Display', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'section' => 'section_caption',
				'tab' => self::TAB_STYLE,
				'default' => '',
				'options' => [
					'' => \IqitElementorWpHelper::__( 'Show', 'elementor' ),
					'none' => \IqitElementorWpHelper::__( 'Hide', 'elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .gallery-item .gallery-caption' => 'display: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'align',
			[
				'label' => \IqitElementorWpHelper::__( 'Alignment', 'elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'tab' => self::TAB_STYLE,
				'section' => 'section_caption',
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
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .gallery-item .gallery-caption' => 'text-align: {{VALUE}};',
				],
				'condition' => [
					'gallery_display_caption' => '',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => \IqitElementorWpHelper::__( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_caption',
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .gallery-item .gallery-caption' => 'color: {{VALUE}};',
				],
				'condition' => [
					'gallery_display_caption' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'label' => \IqitElementorWpHelper::__( 'Typography', 'elementor' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'tab' => self::TAB_STYLE,
				'section' => 'section_caption',
				'selector' => '{{WRAPPER}} .gallery-item .gallery-caption',
				'condition' => [
					'gallery_display_caption' => '',
				],
			]
		);
	}

	protected function render( $instance = [] ) {
			return;
	}

	protected function content_template() {}
}

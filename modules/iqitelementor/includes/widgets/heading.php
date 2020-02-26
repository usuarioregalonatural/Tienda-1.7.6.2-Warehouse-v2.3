<?php
namespace Elementor;

if ( ! defined( 'ELEMENTOR_ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Heading extends Widget_Base {

	public function get_id() {
		return 'heading';
	}

	public function get_title() {
		return \IqitElementorWpHelper::__( 'Heading', 'elementor' );
	}

	public function get_icon() {
		return 'type-tool';
	}

	protected function _register_controls() {
		$this->add_control(
			'section_title',
			[
				'label' => \IqitElementorWpHelper::__( 'Title', 'elementor' ),
				'type' => Controls_Manager::SECTION,
			]
		);

		$this->add_control(
			'title',
			[
				'label' => \IqitElementorWpHelper::__( 'Title', 'elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => \IqitElementorWpHelper::__( 'Enter your title', 'elementor' ),
				'default' => \IqitElementorWpHelper::__( 'This is heading element', 'elementor' ),
				'section' => 'section_title',
			]
		);

		$this->add_control(
			'link',
			[
				'label' => \IqitElementorWpHelper::__( 'Link', 'elementor' ),
				'type' => Controls_Manager::URL,
				'placeholder' => 'http://your-link.com',
				'default' => [
					'url' => '',
				],
				'section' => 'section_title',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'size',
			[
				'label' => \IqitElementorWpHelper::__( 'Size', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => \IqitElementorWpHelper::__( 'Default', 'elementor' ),
					'small' => \IqitElementorWpHelper::__( 'Small', 'elementor' ),
					'medium' => \IqitElementorWpHelper::__( 'Medium', 'elementor' ),
					'large' => \IqitElementorWpHelper::__( 'Large', 'elementor' ),
					'xl' => \IqitElementorWpHelper::__( 'XL', 'elementor' ),
					'xxl' => \IqitElementorWpHelper::__( 'XXL', 'elementor' ),
				],
				'section' => 'section_title',
			]
		);

		$this->add_control(
			'header_size',
			[
				'label' => \IqitElementorWpHelper::__( 'HTML Tag', 'elementor' ),
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
				'default' => 'h2',
				'section' => 'section_title',
			]
		);

		$this->add_control(
			'header_style',
			[
				'label' => \IqitElementorWpHelper::__( 'Inherit from global', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => \IqitElementorWpHelper::__( 'None', 'elementor' ),
					'page-title' => \IqitElementorWpHelper::__( 'Page title', 'elementor' ),
					'section-title' => \IqitElementorWpHelper::__( 'Section title', 'elementor' ),
					'block-title' => \IqitElementorWpHelper::__( 'Block title', 'elementor' ),
				],
				'default' => 'none',
				'section' => 'section_title',
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
					'justify' => [
						'title' => \IqitElementorWpHelper::__( 'Justified', 'elementor' ),
						'icon' => 'align-justify',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
				'section' => 'section_title',
			]
		);

		$this->add_control(
			'view',
			[
				'label' => \IqitElementorWpHelper::__( 'View', 'elementor' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
				'section' => 'section_title',
			]
		);

		$this->add_control(
			'section_title_style',
			[
				'label' => \IqitElementorWpHelper::__( 'Title', 'elementor' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => \IqitElementorWpHelper::__( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
				    'type' => Scheme_Color::get_type(),
				    'value' => Scheme_Color::COLOR_1,
				],
				'tab' => self::TAB_STYLE,
				'section' => 'section_title_style',
				'selectors' => [
					'{{WRAPPER}} .elementor-heading-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'tab' => self::TAB_STYLE,
				'section' => 'section_title_style',
				'selector' => '{{WRAPPER}} .elementor-heading-title',
			]
		);
	}

	protected function render( $instance = [] ) {
		if ( empty( $instance['title'] ) )
			return;

		$this->add_render_attribute( 'heading', 'class', 'elementor-heading-title' );

		if ( ! empty( $instance['size'] ) ) {
			$this->add_render_attribute( 'heading', 'class', 'elementor-size-' . $instance['size'] );
		}

		if ( ! empty( $instance['header_style'] ) ) {
			$this->add_render_attribute( 'heading', 'class', $instance['header_style'] );
		}


		if ( ! empty( $instance['link']['url'] ) ) {

			$this->add_render_attribute( 'url', 'href', $instance['link']['url'] );
			if ( $instance['link']['is_external'] ) {
				$this->add_render_attribute( 'url', 'target', '_blank' );
				$this->add_render_attribute( 'url', 'rel', 'noopener noreferrer');
			}
			$url = sprintf( '<a %1$s>%2$s</a>', $this->get_render_attribute_string( 'url' ), $instance['title'] );

			$title_html = sprintf( '<%1$s %2$s>%3$s</%1$s>', $instance['header_size'], $this->get_render_attribute_string( 'heading' ), $url );
		} else {
			$title_html = sprintf( '<%1$s %2$s>%3$s</%1$s>', $instance['header_size'], $this->get_render_attribute_string( 'heading' ), '<span>'.$instance['title'].'</span>' );
		}

		echo $title_html;
	}

	protected function content_template() {
		?>
		<#
		if ( '' !== settings.title ) {
			var title_html = '<' + settings.header_size  + ' class="elementor-heading-title elementor-size-' + settings.size + ' ' +  settings.header_style + '"><span>' + settings.title + '</span></' + settings.header_size + '>';
		}
		
		if ( '' !== settings.link.url ) {
			var title_html = '<' + settings.header_size  + ' class="elementor-heading-title elementor-size-' + settings.size + ' ' +  settings.header_style + '"><a href="' + settings.link.url + '"><span>' + title_html + '</span></a></' + settings.header_size + '>';
		}

		print( title_html );
		#>
		<?php
	}
}

<?php
namespace Elementor;

if ( ! defined( 'ELEMENTOR_ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Button extends Widget_Base {

	public function get_id() {
		return 'button';
	}

	public function get_title() {
		return \IqitElementorWpHelper::__( 'Button', 'elementor' );
	}

	public function get_icon() {
		return 'button';
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
			'section_button',
			[
				'label' => \IqitElementorWpHelper::__( 'Button', 'elementor' ),
				'type' => Controls_Manager::SECTION,
			]
		);

		$this->add_control(
			'button_type',
			[
				'label' => \IqitElementorWpHelper::__( 'Type', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'secondary',
				'section' => 'section_button',
				'options' => [
					'secondary' => \IqitElementorWpHelper::__( 'Default', 'elementor' ),
					'primary' => \IqitElementorWpHelper::__( 'Action', 'elementor' ),
					'info' => \IqitElementorWpHelper::__( 'Info', 'elementor' ),
					'success' => \IqitElementorWpHelper::__( 'Success', 'elementor' ),
					'warning' => \IqitElementorWpHelper::__( 'Warning', 'elementor' ),
					'danger' => \IqitElementorWpHelper::__( 'Danger', 'elementor' ),
				],
			]
		);

		$this->add_control(
			'text',
			[
				'label' => \IqitElementorWpHelper::__( 'Text', 'elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => \IqitElementorWpHelper::__( 'Click me', 'elementor' ),
				'placeholder' => \IqitElementorWpHelper::__( 'Click me', 'elementor' ),
				'section' => 'section_button',
			]
		);

		$this->add_control(
			'link',
			[
				'label' => \IqitElementorWpHelper::__( 'Link', 'elementor' ),
				'type' => Controls_Manager::URL,
				'placeholder' => 'http://your-link.com',
				'default' => [
					'url' => '#',
				],
				'section' => 'section_button',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => \IqitElementorWpHelper::__( 'Alignment', 'elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'section' => 'section_button',
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
					'justify' => [
						'title' => \IqitElementorWpHelper::__( 'Justified', 'elementor' ),
						'icon' => 'align-justify',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default' => '',
			]
		);

		$this->add_control(
			'size',
			[
				'label' => \IqitElementorWpHelper::__( 'Size', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'medium',
				'options' => self::get_button_sizes(),
				'section' => 'section_button',
			]
		);

		$this->add_control(
			'view',
			[
				'label' => \IqitElementorWpHelper::__( 'View', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'traditional',
				'section' => 'section_button',
				'options' => [
					'traditional' => \IqitElementorWpHelper::__( 'Default', 'elementor' ),
					'block' => \IqitElementorWpHelper::__( 'Block', 'elementor' ),
				],
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => \IqitElementorWpHelper::__( 'Icon', 'elementor' ),
				'type' => Controls_Manager::ICON,
				'label_block' => true,
				'default' => '',
				'section' => 'section_button',
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label' => \IqitElementorWpHelper::__( 'Icon Position', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' => \IqitElementorWpHelper::__( 'Before', 'elementor' ),
					'right' => \IqitElementorWpHelper::__( 'After', 'elementor' ),
				],
				'condition' => [
					'icon!' => '',
				],
				'section' => 'section_button',
			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label' => \IqitElementorWpHelper::__( 'Icon Spacing', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'icon!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-button .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-button .elementor-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				'section' => 'section_button',
			]
		);


		$this->add_control(
			'section_style',
			[
				'label' => \IqitElementorWpHelper::__( 'Button', 'elementor' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_STYLE,
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' => \IqitElementorWpHelper::__( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_style',
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-button' => 'color: {{VALUE}};',
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
				'section' => 'section_style',
				'selector' => '{{WRAPPER}} .elementor-button',
			]
		);

		$this->add_control(
			'background_color',
			[
				'label' => \IqitElementorWpHelper::__( 'Background Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_style',
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
				'name' => 'border',
				'label' => \IqitElementorWpHelper::__( 'Border', 'elementor' ),
				'tab' => self::TAB_STYLE,
				'placeholder' => '1px',
				'default' => '1px',
				'section' => 'section_style',
				'selector' => '{{WRAPPER}} .elementor-button',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => \IqitElementorWpHelper::__( 'Border Radius', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'tab' => self::TAB_STYLE,
				'section' => 'section_style',
				'selectors' => [
					'{{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'text_padding',
			[
				'label' => \IqitElementorWpHelper::__( 'Text Padding', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'tab' => self::TAB_STYLE,
				'section' => 'section_style',
				'selectors' => [
					'{{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'section_hover',
			[
				'label' => \IqitElementorWpHelper::__( 'Button Hover', 'elementor' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_STYLE,
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label' => \IqitElementorWpHelper::__( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_hover',
				'selectors' => [
					'{{WRAPPER}} .elementor-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label' => \IqitElementorWpHelper::__( 'Background Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_hover',
				'selectors' => [
					'{{WRAPPER}} .elementor-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => \IqitElementorWpHelper::__( 'Border Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_hover',
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => \IqitElementorWpHelper::__( 'Animation', 'elementor' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
				'tab' => self::TAB_STYLE,
				'section' => 'section_hover',
			]
		);
	}

	protected function render( $instance = [] ) {
		$this->add_render_attribute( 'wrapper', 'class', 'elementor-button-wrapper' );

		//if ( ! empty( $instance['align'] ) ) {
		//	$this->add_render_attribute( 'wrapper', 'class', 'elementor-align-' . $instance['align'] );
		//}

		if ( ! empty( $instance['link']['url'] ) ) {
			$this->add_render_attribute( 'button', 'href', $instance['link']['url'] );
			$this->add_render_attribute( 'button', 'class', 'elementor-button-link' );

			if ( ! empty( $instance['link']['is_external'] ) ) {
				$this->add_render_attribute( 'button', 'target', '_blank' );
				$this->add_render_attribute( 'button', 'rel', 'noopener noreferrer');

			}
		}

		$this->add_render_attribute( 'button', 'class', 'elementor-button' );
		$this->add_render_attribute( 'button', 'class', 'btn' );

		if ( ! empty( $instance['size'] ) ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $instance['size'] );
		}

		if ( ! empty( $instance['button_type'] ) ) {
			$this->add_render_attribute( 'button', 'class', 'btn-' . $instance['button_type'] );
		}

		if ( ! empty( $instance['view'] ) ) {
			$this->add_render_attribute( 'button', 'class', 'btn-' . $instance['view'] );
		}

		if ( $instance['hover_animation'] ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $instance['hover_animation'] );
		}

		$this->add_render_attribute( 'content-wrapper', 'class', 'elementor-button-content-wrapper' );


		if ( ! empty( $instance['icon'] ) )  {
			$this->add_render_attribute( 'icon-align', 'class', 'elementor-align-icon-' . $instance['icon_align'] );
			$this->add_render_attribute( 'icon-align', 'class', 'elementor-button-icon' );
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
				<span <?php echo $this->get_render_attribute_string( 'content-wrapper' ); ?>>
					<?php if ( ! empty( $instance['icon'] ) ) : ?>
						<span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>
							<i class="<?php echo \IqitElementorWpHelper::esc_attr( $instance['icon'] ); ?>"></i>
						</span>
					<?php endif; ?>
					<span class="elementor-button-text"><?php echo $instance['text']; ?></span>
				</span>
			</a>
		</div>
		<?php
	}

	protected function content_template() {
		?>
		<div class="elementor-button-wrapper">
			<a class="elementor-button btn btn-{{ settings.button_type }} elementor-size-{{ settings.size }} elementor-animation-{{ settings.hover_animation }} btn-{{ settings.view }}" href="{{ settings.link.url }}">
				<span class="elementor-button-content-wrapper">
					<# if ( settings.icon ) { #>
					<span class="elementor-button-icon elementor-align-icon-{{ settings.icon_align }}">
						<i class="{{ settings.icon }}"></i>
					</span>
					<# } #>
					<span class="elementor-button-text">{{{ settings.text }}}</span>
				</span>
			</a>
		</div>
		<?php
	}
}

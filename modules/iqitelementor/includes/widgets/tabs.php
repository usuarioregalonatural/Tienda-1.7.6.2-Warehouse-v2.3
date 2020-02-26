<?php
namespace Elementor;

if ( ! defined( 'ELEMENTOR_ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Tabs extends Widget_Base {

	public function get_id() {
		return 'tabs';
	}

	public function get_title() {
		return \IqitElementorWpHelper::__( 'Tabs', 'elementor' );
	}

	public function get_icon() {
		return 'tabs';
	}

	protected function _register_controls() {
		$this->add_control(
			'section_title',
			[
				'label' => \IqitElementorWpHelper::__( 'Tabs', 'elementor' ),
				'type' => Controls_Manager::SECTION,
			]
		);

		$this->add_control(
			'tabs',
			[
				'label' => \IqitElementorWpHelper::__( 'Tabs Items', 'elementor' ),
				'type' => Controls_Manager::REPEATER,
				'section' => 'section_title',
				'default' => [
					[
						'tab_title' => \IqitElementorWpHelper::__( 'Tab #1', 'elementor' ),
						'tab_content' => \IqitElementorWpHelper::__( 'I am tab content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'elementor' ),
					],
					[
						'tab_title' => \IqitElementorWpHelper::__( 'Tab #2', 'elementor' ),
						'tab_content' => \IqitElementorWpHelper::__( 'I am tab content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'elementor' ),
					],
				],
				'fields' => [
					[
						'name' => 'tab_title',
						'label' => \IqitElementorWpHelper::__( 'Title & Content', 'elementor' ),
						'type' => Controls_Manager::TEXT,
						'default' => \IqitElementorWpHelper::__( 'Tab Title', 'elementor' ),
						'placeholder' => \IqitElementorWpHelper::__( 'Tab Title', 'elementor' ),
						'label_block' => true,
					],
					[
						'name' => 'tab_content',
						'label' => \IqitElementorWpHelper::__( 'Content', 'elementor' ),
						'default' => \IqitElementorWpHelper::__( 'Tab Content', 'elementor' ),
						'placeholder' => \IqitElementorWpHelper::__( 'Tab Content', 'elementor' ),
						'type' => Controls_Manager::WYSIWYG,
						'show_label' => false,
					],
				],
				'title_field' => 'tab_title',
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
				'label' => \IqitElementorWpHelper::__( 'Tabs Style', 'elementor' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_STYLE,
			]
		);

		$this->add_control(
			'position',
			[
				'label' => \IqitElementorWpHelper::__( 'Position', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'tab' => self::TAB_STYLE,
				'default' => 'left',
				'section' => 'section_title_style',
				'options' => [
					'left' => \IqitElementorWpHelper::__( 'Left', 'elementor' ),
					'center' => \IqitElementorWpHelper::__( 'Center', 'elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .nav-tabs' => 'justify-content:  {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'border_color',
			[
				'label' => \IqitElementorWpHelper::__( 'Border Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_title_style',
				'selectors' => [
					'{{WRAPPER}} .nav-tabs .nav-link.active, .nav-tabs .nav-link:hover, .nav-tabs .nav-link:focus' => 'border-color: {{VALUE}};',
				],
			]
		);


		$this->add_control(
			'tab_color',
			[
				'label' => \IqitElementorWpHelper::__( 'Title Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_title_style',
				'selectors' => [
					'{{WRAPPER}} .elementor-tab-title' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'separator' => 'before',
			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'tab_typography',
				'tab' => self::TAB_STYLE,
				'section' => 'section_title_style',
				'selector' => '{{WRAPPER}} .nav-tabs .nav-link',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
			]
		);

		$this->add_control(
			'section_tab_content',
			[
				'label' => \IqitElementorWpHelper::__( 'Tab Content', 'elementor' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_color',
			[
				'label' => \IqitElementorWpHelper::__( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_tab_content',
				'selectors' => [
					'{{WRAPPER}} .elementor-tab-content' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'tab' => self::TAB_STYLE,
				'section' => 'section_tab_content',
				'selector' => '{{WRAPPER}} .elementor-tab-content',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
			]
		);
	}

	protected function render( $instance = [] ) {
		?>
		<div class="elementor-tabs tabs">
			<?php $counter = 1; ?>
			<ul class="nav nav-tabs">
				<?php foreach ( $instance['tabs'] as $item ) : ?>
					<li class="nav-item"><a class="nav-link elementor-tab-title"  data-tab="<?php echo $counter; ?>" ><?php echo $item['tab_title']; ?></a></li>
				<?php
					$counter++;
				endforeach; ?>
			</ul>

			<?php $counter = 1; ?>
			<div class="elementor-tabs-content-wrapper tab-content">
				<?php foreach ( $instance['tabs'] as $item ) : ?>
					<div data-tab="<?php echo $counter; ?>" class="elementor-tab-content tab-pane"><?php echo $this->parse_text_editor( $item['tab_content'], $item ); ?></div>
				<?php
					$counter++;
				endforeach; ?>
			</div>
		</div>
		<?php
	}

	protected function content_template() {
		?>
		<div class="elementor-tabs tabs" data-active-tab="{{ editSettings.activeItemIndex ? editSettings.activeItemIndex : 0 }}">
			<#
			if ( settings.tabs ) {
				var counter = 1; #>
				<ul class="nav nav-tabs">
					<#
					_.each( settings.tabs, function( item ) { #>

						<li class="nav-item"><a class="nav-link elementor-tab-title" data-tab="{{ counter }}">{{{ item.tab_title }}}</a></li>
					<#
						counter++;
					} ); #>
				</ul>

				<# counter = 1; #>
				<div class="elementor-tabs-content-wrapper tab-content">
					<#
					_.each( settings.tabs, function( item ) { #>
						<div class="elementor-tab-content tab-pane" data-tab="{{ counter }}">{{{ item.tab_content }}}</div>
					<#
					counter++;
					} ); #>
				</div>
			<# } #>
		</div>
		<?php
	}
}

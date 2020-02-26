<?php
namespace Elementor;

if ( ! defined( 'ELEMENTOR_ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Shape_Separator extends Widget_Base {

	public function get_id() {
		return 'shape-separator';
	}

	public function get_title() {
		return \IqitElementorWpHelper::__( 'Row shape separator', 'elementor' );
	}

	public function get_icon() {
		return 'divider';
	}

	protected function _register_controls() {
		$this->add_control(
			'section_separator',
			[
				'label' => \IqitElementorWpHelper::__( 'Separator', 'elementor' ),
				'type' => Controls_Manager::SECTION,
			]
		);
		$this->add_control(

			'direction',
			[
				'label' => \IqitElementorWpHelper::__( 'Direction', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'section' => 'section_separator',
				'options' => [
					'top' => \IqitElementorWpHelper::__( 'Top', 'elementor' ),
					'bottom' => \IqitElementorWpHelper::__( 'Bottom', 'elementor' ),
				],
				'default' => 'top',
			]
		);

		$this->add_control(
			'shape',
			[
				'label' => \IqitElementorWpHelper::__( 'Shape', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'section' => 'section_separator',
				'options' => [
					'triangle-center' => \IqitElementorWpHelper::__( 'Triangle center', 'elementor' ),
					'triangle-left' => \IqitElementorWpHelper::__( 'Triangle left', 'elementor' ),
					'triangle-right' => \IqitElementorWpHelper::__( 'Triangle right', 'elementor' ),
					'triangle-rect-left' => \IqitElementorWpHelper::__( 'Rectangular triangle left', 'elementor' ),
					'triangle-rect-right' => \IqitElementorWpHelper::__( 'Rectangular triangle right', 'elementor' ),
				],
				'default' => 'triangle-rect-left',
			]
		);


		$this->add_control(
			'shape_size',
			[
				'label' => \IqitElementorWpHelper::__( 'Shape height', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 50,
				],
				'range' => [
					'px' => [
						'min' => 30,
						'max' => 600,
					],
				],
				'section' => 'section_separator',
			]
		);

		$this->add_control(
			'shape_color',
			[
				'label' => \IqitElementorWpHelper::__( 'Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'section' => 'section_separator',
				'selectors' => [
					'{{WRAPPER}} svg' => 'fill: {{VALUE}};',
				],
			]
		);
	}

	protected function render( $instance = [] ) {

		$direction = $instance['direction'];
		$shape = $instance['shape'];
		$shape_color = $instance['shape_color'];
		$shape_size = $instance['shape_size'];

		if ( $shape == 'triangle-rect-left' ) : ?>
			<svg height="<?php echo $shape_size['size'].$shape_size['unit']; ?>" width="100%" preserveAspectRatio="none" viewBox="0 0 50 50" >
				<polygon points="<?php echo ($direction == 'top') ?  '0,0 0,50 50,50' : '0,0 50,0 0,50' ?>" />
			</svg>
		<?php endif;

		if ( $shape == 'triangle-rect-right' ) : ?>
			<svg height="<?php echo $shape_size['size'].$shape_size['unit']; ?>" width="100%" preserveAspectRatio="none" viewBox="0 0 50 50" >
				<polygon points="<?php echo ($direction == 'top') ?  '0,50 50,50 50,0' : '0,0 50,0 50,50' ?>" />
			</svg>
		<?php endif;

		if ( $shape == 'triangle-center' ) : ?>
			<svg height="<?php echo $shape_size['size'].$shape_size['unit']; ?>" width="100%" preserveAspectRatio="none" viewBox="0 0 50 50" >
				<polygon points="<?php echo ($direction == 'top') ?  '0,50 50,50 25,0' : '0,0 50,0 25,50' ?>" />
			</svg>
		<?php endif;

		if ( $shape == 'triangle-left' ) : ?>
			<svg height="<?php echo $shape_size['size'].$shape_size['unit']; ?>" width="100%" preserveAspectRatio="none" viewBox="0 0 50 50" >
				<polygon points="<?php echo ($direction == 'top') ?  '11,25 0,0 0,50 50,50 50,0' : '0,0 0,50, 11,25 50,50 50,0' ?>" />
			</svg>
		<?php endif;

		if ( $shape == 'triangle-right' ) : ?>
			<svg height="<?php echo $shape_size['size'].$shape_size['unit']; ?>" width="100%" preserveAspectRatio="none" viewBox="0 0 50 50" >
				<polygon points="<?php echo ($direction == 'top') ?  '39,25 0,0 0,50 50,50 50,0' : '0,0 0,50, 39,25 50,50 50,0' ?>" />
			</svg>
		<?php endif;
	}

	protected function content_template() {}
}

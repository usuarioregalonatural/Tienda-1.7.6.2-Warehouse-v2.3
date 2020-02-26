<?php
namespace Elementor;

if ( ! defined( 'ELEMENTOR_ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Image_hotspots extends Widget_Base {

	public function get_id() {
		return 'image-hotspots';
	}

	public function get_title() {
		return \IqitElementorWpHelper::__( 'Image hotspots', 'elementor' );
	}

	public function get_icon() {
		return 'bullet-list';
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
			'section_icon',
			[
				'label' => \IqitElementorWpHelper::__( 'Hotspots', 'elementor' ),
				'type' => Controls_Manager::SECTION,
			]
		);

		$this->add_control(
			'icon_list',
			[
				'label' => '',
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'text' => \IqitElementorWpHelper::__( 'List Item #1', 'elementor' ),
						'icon' => 'fa fa-check',
						'type' => 'product',
						'left' => 10,
						'top' => 10,
					],
				],
				'section' => 'section_icon',
				'fields' => [
					[
						'name' => 'top',
						'label' => \IqitElementorWpHelper::__( 'Position top', 'elementor' ),
						'type' => Controls_Manager::NUMBER,
						'min' => 0,
						'step' => 0.25,
						'default' => 10,
						'max' => 100,
						'selectors' => [
							'{{WRAPPER}} {{CURRENT_ITEM}} .elementor-hotspot' => 'top: {{VALUE}}%;',
						],
					],
					[
						'name' => 'left',
						'label' => \IqitElementorWpHelper::__( 'Position Left', 'elementor' ),
						'type' => Controls_Manager::NUMBER,
						'min' => 0,
						'step' => 0.25,
						'default' => 10,
						'max' => 100,
						'selectors' => [
							'{{WRAPPER}} {{CURRENT_ITEM}} .elementor-hotspot' => 'left: {{VALUE}}%;',
						],
					],
					[
						'name' => 'type',
						'label' => \IqitElementorWpHelper::__( 'Type', 'elementor' ),
						'type' => Controls_Manager::SELECT,
						'default' => 'custom',
						'options' => [
							'custom' => \IqitElementorWpHelper::__( 'Custom text', 'elementor' ),
							'product' => \IqitElementorWpHelper::__( 'Product', 'elementor' ),
						],
					],
					[
						'name' => 'text',
						'label' => \IqitElementorWpHelper::__( 'Title', 'elementor' ),
						'type' => Controls_Manager::TEXT,
						'label_block' => true,
						'placeholder' => \IqitElementorWpHelper::__( 'Hotspot', 'elementor' ),
						'default' => \IqitElementorWpHelper::__( 'Hotspot', 'elementor' ),
					],
					[
						'name' => 'icon',
						'label' => \IqitElementorWpHelper::__( 'Icon', 'elementor' ),
						'type' => Controls_Manager::ICON,
						'label_block' => true,
						'default' => 'fa fa-check',
					],
					[
						'name' => 'text_content',
						'label' => \IqitElementorWpHelper::__( 'Text', 'elementor' ),
						'type' => Controls_Manager::TEXT,
						'label_block' => true,
						'placeholder' => \IqitElementorWpHelper::__( 'Lorem ipsum dolor sit amet', 'elementor' ),
						'default' => \IqitElementorWpHelper::__( 'Lorem ipsum dolor sit amet', 'elementor' ),
						'condition' => [
							'type' => 'custom',
						],
					],
					[   'name' => 'products_ids',
						'label' => \IqitElementorWpHelper::__( 'Search for product', 'elementor' ),
						'placeholder' => \IqitElementorWpHelper::__( 'Product name, id, ref', 'elementor' ),
						'single' => true,
						'type' => 'autocomplete_products',
						'label_block' => true,
						'condition' => [
							'type' => 'product',
						],
					],
					[
						'name' => 'link',
						'label' => \IqitElementorWpHelper::__( 'Link', 'elementor' ),
						'type' => Controls_Manager::URL,
						'label_block' => true,
						'placeholder' => \IqitElementorWpHelper::__( 'http://your-link.com', 'elementor' ),
						'condition' => [
							'type' => 'custom',
						],
					],

				],
				'title_field' => 'text',
			]
		);

		$this->add_control(
			'view',
			[
				'label' => \IqitElementorWpHelper::__( 'View', 'elementor' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
				'section' => 'section_icon',
			]
		);

		$this->add_control(
			'section_icon_style',
			[
				'label' => \IqitElementorWpHelper::__( 'Hotspot', 'elementor' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label' => \IqitElementorWpHelper::__( 'Font Size', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'tab' => self::TAB_STYLE,
				'section' => 'section_icon_style',
				'default' => [
					'size' => 14,
				],
				'range' => [
					'px' => [
						'min' => 6,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-hotspot' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => \IqitElementorWpHelper::__( 'Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_icon_style',
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-hotspot, {{WRAPPER}} .elementor-hotspot a' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
			]
		);
		$this->add_control(
			'icon_background',
			[
				'label' => \IqitElementorWpHelper::__( 'Background', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_icon_style',
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-hotspot' => 'background: {{VALUE}};',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
			]
		);

		$this->add_control(
			'tooltip_content_color',
			[
				'label' => \IqitElementorWpHelper::__( 'Tooltip color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_icon_style',
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tooltip-inner' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
			]
		);
		$this->add_control(
			'tooltip_content_background',
			[
				'label' => \IqitElementorWpHelper::__( 'Tooltip background', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_icon_style',
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tooltip-inner' => 'background: {{VALUE}};',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'tooltip_box_shadow',
				'section' => 'section_icon_style',
				'tab' => self::TAB_STYLE,
				'selector' => '{{WRAPPER}} .tooltip-inner',
			]
		);




	}

	 protected function render( $instance = [] ) {
        if ( empty( $instance['image']['url'] ) ) {
            return;
        } ?>


		 <div  class="elementor-image-hotspots-wrapper">
		 <?php

        $has_caption = ! empty( $instance['caption'] );
        $image_html = '<div class="elementor-hotspot-image' . ( ! empty( $instance['shape'] ) ? ' elementor-image-shape-' . $instance['shape'] : '' ) . '">';
        $image_class_html = ! empty( $instance['hover_animation'] ) ? ' class="elementor-animation-' . $instance['hover_animation'] . '"' : '';
        $image_html .= sprintf( '<img src="%s" alt="%s"%s />', \IqitElementorWpHelper::esc_attr( \IqitElementorWpHelper::getImage($instance['image']['url'])   ), \IqitElementorWpHelper::esc_attr( $instance['caption'] ) , $image_class_html );
        $image_html .= '</div>';
        echo $image_html;
		 ?>
			 <div class="elementor-image-hotspots">
				 <?php foreach ( $instance['icon_list'] as $item ) : ?>

					 <?php
					 $tooltip = '';
					 $tooltipText = '';
					 $tooltipLink = $item['link']['url'];
					 $tooltipLinkTarget = 'target="_blank" rel="noopener noreferrer"';


					 if ($item['type'] == 'custom'){
						 $tooltipText = $item['text_content'];
						 $tooltipLink = $item['link']['url'];
						 $tooltipLinkTarget = $item['link']['is_external'] ? ' target="_blank" rel="noopener noreferrer"' : '';
					 } else{
					 	$product = \IqitElementorWpHelper::getProduct( $item['products_ids']);
						 if ( ! empty( $product['name']) ) {
							 $tooltipText = "<div class='row align-items-center list-small-gutters'>
								<div class='thumbnail-container col-4'><img src='".$product['cover']['url']."' class='img-fluid' width='".$product['cover']['width']."' height='".$product['cover']['height']."'></div>
								<div class='product-description col'>
									<div class='product-title'>".$product['name']."</div>
    								 <span class='product-price-hotspot'>".$product['price']."</span>
							 	</div>
							 </div>";
							 $tooltipLink = $product['url'];
						 }

					 }
					 if (isset($instance['id_widget_instance'])){
					 if ( ! empty( $tooltipText) ) {
					 	$tpl = "<div class='elementor-element elementor-element-".$instance['id_widget_instance']." tooltip' role='tooltip'><div class='tooltip-inner tooltip-inner-hotspot'></div></div>";
						$tooltip = 'data-toggle="tooltip" data-html="true" data-template="'.$tpl.'" title="'.$tooltipText.'"';
					 }
					 }
					 ?>

					 <div class="elementor-hotspot" style="top: <?php echo $item['top']; ?>%; left: <?php echo $item['left']; ?>%;"  <?php echo $tooltip; ?>>
						 <?php
						 if ( ! empty( $tooltipLink) ) {

							 echo '<a href="' . $tooltipLink . '"  ' . $tooltipLinkTarget . '>';
						 }

						 if ( $item['icon'] ) : ?>
							 <span class="elementor-hotspot-icon">
							<i class="<?php echo \IqitElementorWpHelper::esc_attr( $item['icon'] ); ?>"></i>
						</span>
						 <?php endif; ?>
						 <span class="elementor-hotspot-text"><?php echo $item['text']; ?></span>
						 <?php
						 if ( ! empty( $tooltipLink) ) {
							 echo '</a>';
						 }
						 ?>
					 </div>
					 <?php
				 endforeach; ?>
			 </div>
		 </div>
		 <?php

    }

    protected function content_template() {
        ?>
        <# if ( '' !== settings.image.url ) { #>
			<div class="elementor-image-hotspots-wrapper">
            <div class="elementor-hotspot-image{{ settings.shape ? ' elementor-image-shape-' + settings.shape : '' }}">
                <#
                var imgClass = '', image_html = '',
                    hasCaption = '' !== settings.caption,
                    image_html = '';

                if ( '' !== settings.hover_animation ) {
                    imgClass = 'elementor-animation-' + settings.hover_animation;
                }

                image_html = '<img src="' + settings.image.url + '" class="' + imgClass + '" alt="' + settings.caption + '" />';

                print( image_html );
                #>
            </div>
				<div class="elementor-image-hotspots">
					<#
						if ( settings.icon_list ) {
						_.each( settings.icon_list, function( item ) { #>
						<div class="elementor-hotspot" style="top: {{ item.top }}%; left: {{ item.left }}%;" >
							<# if ( item.link && item.link.url ) { #>
								<a href="{{ item.link.url }}">
									<# } #>
						<span class="elementor-hotspot-icon">
							<i class="{{ item.icon }}"></i>
						</span>
										<span class="elementor-hotspot-text">{{{ item.text }}}</span>
										<# if ( item.link && item.link.url ) { #>
								</a>
								<# } #>
						</div>
						<#
							} );
							} #>
				</div>
			</div>
        <# } #>


        <?php
    }

}

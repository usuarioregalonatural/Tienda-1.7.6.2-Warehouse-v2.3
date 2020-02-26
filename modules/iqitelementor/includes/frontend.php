<?php
namespace Elementor;

if ( ! defined( 'ELEMENTOR_ABSPATH' ) ) exit; // Exit if accessed directly

class Frontend {

	private $_enqueue_google_fonts = [];
	private $_enqueue_google_early_access_fonts = [];

	private $_column_widths = [];

	/**
	 * @var Stylesheet
	 */
	private $stylesheet;
	private $data = [];

	public function init() {
        $this->_init_stylesheet();
	}

	private function _init_stylesheet() {
		$this->stylesheet = new Stylesheet();

		$breakpoints = Responsive::get_breakpoints();

		$this->stylesheet
			->add_device( 'mobile', $breakpoints['md'] - 1 )
			->add_device( 'tablet', $breakpoints['lg'] - 1 );
	}

	protected function _print_section( $section_data ) {
		$section_obj = PluginElementor::instance()->elements_manager->get_element( 'section' );
		$instance = $section_obj->get_parse_values( $section_data['settings'] );

		$section_obj->before_render( $instance, $section_data['id'], $section_data );

		foreach ( $section_data['elements'] as $column_data ) {
			$this->_print_column( $column_data );
		}

		$section_obj->after_render( $instance, $section_data['id'], $section_data );

	}

	protected function _print_column( $column_data ) {
		$column_obj = PluginElementor::instance()->elements_manager->get_element( 'column' );
		$instance = $column_obj->get_parse_values( $column_data['settings'] );

		$column_obj->before_render( $instance, $column_data['id'], $column_data );

		foreach ( $column_data['elements'] as $widget_data ) {
			if ( 'section' === $widget_data['elType'] ) {
				$this->_print_section( $widget_data );
			} else {
				$this->_print_widget( $widget_data );
			}
		}

		$column_obj->after_render( $instance, $column_data['id'], $column_data );
	}

	protected function _print_widget( $widget_data ) {
		$widget_obj = PluginElementor::instance()->widgets_manager->get_widget( $widget_data['widgetType'] );
		if ( false === $widget_obj )
			return;

		if ( empty( $widget_data['settings'] ) )
			$widget_data['settings'] = [];

		$instance = $widget_obj->get_parse_values( $widget_data['settings'] );

		$widget_obj->before_render( $instance, $widget_data['id'], $widget_data );
		$instance['id_widget_instance'] = $widget_data['id'];
		$widget_obj->render_content( $instance );
		$widget_obj->after_render( $instance, $widget_data['id'], $widget_data );

	}

	public function print_css() {

		$container_width = \IqitElementorWpHelper::absint( \IqitElementorWpHelper::get_option( 'elementor_container_width' ) );
		if ( ! empty( $container_width ) ) {
			$this->stylesheet->add_rules( '.elementor-section.elementor-section-boxed > .elementor-container', 'max-width:' . $container_width . 'px' );
		}


		foreach ( $this->data as $section ) {
			$this->_parse_style_item( $section );
		}

		$css_code = $this->stylesheet;

		if ( ! empty( $this->_column_widths ) ) {
			$css_code .= '@media (min-width: 768px) {';
			foreach ( $this->_column_widths as $column_width ) {
				$css_code .= $column_width;
			}
			$css_code .= '}';
		}

		if ( empty( $css_code ) )
			return;

		?>
		<style id="elementor-frontend-stylesheet"><?php echo $css_code; ?></style>
		<?php

		// Enqueue used fonts
		if ( ! empty( $this->_enqueue_google_fonts ) ) {
			foreach ( $this->_enqueue_google_fonts as &$font ) {
				$font = str_replace( ' ', '+', $font ) . ':100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic';
			}
			printf( '<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=%s">', implode( '|', $this->_enqueue_google_fonts ) );
			$this->_enqueue_google_fonts = [];
		}

		if ( ! empty( $this->_enqueue_google_early_access_fonts ) ) {
			foreach ( $this->_enqueue_google_early_access_fonts as $current_font ) {
				printf( '<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/earlyaccess/%s.css">', strtolower( str_replace( ' ', '', $current_font ) ) );
			}
			$this->_enqueue_google_early_access_fonts = [];
		}
	}

	protected function _add_enqueue_font( $font ) {
		switch ( Fonts::get_font_type( $font ) ) {
			case Fonts::GOOGLE :
				if ( ! in_array( $font, $this->_enqueue_google_fonts ) )
					$this->_enqueue_google_fonts[] = $font;
				break;

			case Fonts::EARLYACCESS :
				if ( ! in_array( $font, $this->_enqueue_google_early_access_fonts ) )
					$this->_enqueue_google_early_access_fonts[] = $font;
				break;
		}
	}

	protected function _parse_style_item( $element ) {
		if ( 'widget' === $element['elType'] ) {
			$element_obj = PluginElementor::instance()->widgets_manager->get_widget( $element['widgetType'] );
		} else {
			$element_obj = PluginElementor::instance()->elements_manager->get_element( $element['elType'] );
		}

		if ( ! $element_obj )
			return;
		$values = $element['settings'];
		$element_instance = $element_obj->get_parse_values( $element['settings'] );
		$element_unique_class = '.elementor-element.elementor-element-' . $element['id'];
		if ( 'column' === $element_obj->get_id() ) {
			if ( ! empty( $element_instance['_inline_size'] ) ) {
				$this->_column_widths[] = $element_unique_class . '{width:' . $element_instance['_inline_size'] . '%;}';
			}
		}

		foreach ( $element_obj->get_style_controls() as $control ) {
			if ( ! isset( $element_instance[ $control['name'] ] ) )
				continue;

			$control_value = $element_instance[ $control['name'] ];
			if ( ! is_numeric( $control_value ) && ! is_float( $control_value ) && empty( $control_value ) ) {
				continue;
			}

			$control_obj = PluginElementor::instance()->controls_manager->get_control( $control['type'] );
			if ( ! $control_obj ) {
				continue;
			}

			if ( ! $element_obj->is_control_visible( $element_instance, $control ) ) {
				continue;
			}


			if ( Controls_Manager::FONT === $control_obj->get_type() ) {
				$this->_add_enqueue_font( $control_value );
			}

			foreach ( $control['selectors'] as $selector => $css_property ) {

				$this->add_control_rules($element_unique_class, $control, function( $control ) use ( $values ) {
					return $this->get_style_control_value( $control, $values );
				}, $element_obj->get_controls_for_css(), $control_value );

			}
		}

		if ( ! empty( $element['elements'] ) ) {
			foreach ( $element['elements'] as $child_element ) {
				$this->_parse_style_item( $child_element );
			}
		}
	}

	public function add_control_rules( $element_unique_class, array $control, $value_callback,  array $controls_stack, $control_value) {
		$value = $control_value;

		if ( null === $value ) {
			return;
		}

		foreach ( $control['selectors'] as $selector => $css_property ) {

			$output_selector = str_replace( '{{WRAPPER}}', $element_unique_class, $selector );

			try {
				$output_css_property = preg_replace_callback( '/\{\{(?:([^.}]+)\.)?([^}]*)}}/', function( $matches ) use ( $control, $value_callback, $controls_stack, $value, $css_property ) {
					$parser_control = $control;
					$value_to_insert = $value;

					if ( ! empty( $matches[1] ) ) {
						$parser_control = $controls_stack[ $matches[1] ];
						$value_to_insert = call_user_func( $value_callback, $parser_control );
					}

					$control_obj = PluginElementor::instance()->controls_manager->get_control( $parser_control['type'] );
					$parsed_value = $control_obj->get_style_value( strtolower( $matches[2] ), $value_to_insert );



					if ($parser_control['name'] === 'background_image'){
						$parsed_value = \IqitElementorWpHelper::getImage($parsed_value);
					}

					return $parsed_value;
				}, $css_property );
			} catch ( \Exception $e ) {
				return;
			}

			if ( ! $output_css_property ) {
				continue;
			}

			$device = ! empty( $control['responsive'] ) ? $control['responsive'] : Element_Base::RESPONSIVE_DESKTOP;

			$this->stylesheet->add_rules( $output_selector, $output_css_property, $device );
		}
	}

	/**
	 * @param array $control
	 * @param array $values
	 *
	 * @return mixed
	 */
	private function get_style_control_value( array $control, array $values ) {
		$value = $values[ $control['name'] ];
		if ( isset( $control['selectors_dictionary'][ $value ] ) ) {
			$value = $control['selectors_dictionary'][ $value ];
		}
		if ( ! is_numeric( $value ) && ! is_float( $value ) && empty( $value ) ) {
			return null;
		}
		return $value;
	}


	public function apply_builder_in_content() {

		 ?>
		<div id="elementor" class="elementor">
			<div id="elementor-inner">
				<div id="elementor-section-wrap">
					<?php foreach ( $this->data as $section ) : ?>
						<?php $this->_print_section( $section ); ?>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<?php
	}

	public function __construct($data) {

		if (!is_null($data)){
			$this->data = $data;
		}
		$this->init();
		$this->print_css();
	    $this->apply_builder_in_content();
	}
}

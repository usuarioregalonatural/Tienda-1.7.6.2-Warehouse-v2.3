<?php
namespace Elementor;

if ( ! defined( 'ELEMENTOR_ABSPATH' ) ) exit; // Exit if accessed directly

class Group_Control_Image_Size extends Group_Control_Base {

	public static function get_type() {
		return 'image-size';
	}

	protected function _get_child_default_args() {
		return [
			'include' => [],
			'exclude' => [],
		];
	}

	private function _get_image_sizes() {
        $image_sizes = array();
		return $image_sizes;
	}

	protected function _get_controls( $args ) {
		$controls = [];

		$image_sizes = $this->_get_image_sizes();

		// Get the first item for default value
		$default_value = array_keys( $image_sizes );
		$default_value = array_shift( $default_value );

		$controls['size'] = [
			'label' => \IqitElementorWpHelper::_x( 'Image Size', 'Image Size Control', 'elementor' ),
			'type' => Controls_Manager::SELECT,
			'options' => $image_sizes,
			'default' => $default_value,
		];

		if ( isset( $image_sizes['custom'] ) ) {
			$controls['custom_dimension'] = [
				'label' => \IqitElementorWpHelper::_x( 'Image Dimension', 'Image Size Control', 'elementor' ),
				'type' => Controls_Manager::IMAGE_DIMENSIONS,
				'description' => \IqitElementorWpHelper::__( 'You can crop the original image size to any custom size. You can also set a single value for height or width in order to keep the original size ratio.', 'elementor' ),
				'condition' => [
					'size' => [ 'custom' ],
				],
				'separator' => 'none',
			];
		}

		return $controls;
	}

	public static function get_attachment_image_src( $attachment_id, $group_name, $instance ) {
	    return '';
	}
}

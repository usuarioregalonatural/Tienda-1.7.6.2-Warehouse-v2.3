<?php
namespace Elementor;

if ( ! defined( 'ELEMENTOR_ABSPATH' ) ) exit; // Exit if accessed directly

class Control_Media extends Control_Base_Multiple {

	public function get_type() {
		return 'media';
	}

	public function get_default_value() {
		return [
			'url' => '',
			'id' => '',
		];
	}

	public function content_template() {
		?>
		<div class="elementor-control-field">
			<label class="elementor-control-title">{{{ data.label }}}</label>
			<div class="elementor-control-input-wrapper">
				<div class="elementor-control-media">
					<div class="elementor-control-media-upload-button">
						<i class="fa fa-plus-circle"></i>
					</div>
					<div class="elementor-control-media-image-area">
						<div class="elementor-control-media-image" style="background-image: url({{ data.controlValue.url }});"></div>
						<div class="elementor-control-media-delete"><?php \IqitElementorWpHelper::_e( 'Delete', 'elementor' ); ?></div>
					</div>

				</div>
				<input type="text" id="elementor-control-media-field-{{ data._cid }}" class="elementor-control-media-field" value="{{ data.controlValue.url }}" />
			</div>
			<# if ( data.description ) { #>
				<div class="elementor-control-description">{{{ data.description }}}</div>
			<# } #>
			<input type="hidden" data-setting="{{ data.name }}" />
		</div>
		<?php
	}

	protected function get_default_settings() {
		return [
			'label_block' => true,
		];
	}

	public static function get_image_title( $instance ) {
		return 'imagetitle';
	}

	public static function get_image_alt( $instance ) {
		return 'imagealt';
	}
}

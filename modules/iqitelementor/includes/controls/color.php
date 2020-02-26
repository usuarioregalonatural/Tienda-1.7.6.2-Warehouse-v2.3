<?php
namespace Elementor;

if ( ! defined( 'ELEMENTOR_ABSPATH' ) ) exit; // Exit if accessed directly

class Control_Color extends Control_Base {

	public function get_type() {
		return 'color';
	}

	public function content_template() {
		?>
		<# var defaultValue = '', dataAlpha = '';
			if ( data.default ) {
			if ( '#' !== data.default.substring( 0, 1 ) ) {
			defaultValue = '#' + data.default;
			} else {
			defaultValue = data.default;
			}
			defaultValue = ' data-default-color=' + defaultValue; // Quotes added automatically.
			}
			if ( data.alpha ) {
			dataAlpha = ' data-alpha=true';
			} #>
		<div class="elementor-control-field">
			<label class="elementor-control-title">
				<# if ( data.label ) { #>
					{{{ data.label }}}
					<# } #>
						<# if ( data.description ) { #>
							<span class="elementor-control-description">{{{ data.description }}}</span>
							<# } #>
			</label>
			<div class="elementor-control-input-wrapper">
				<input data-setting="{{ name }}" class="color-picker-hex" type="text" maxlength="7" placeholder="<?php \IqitElementorWpHelper::esc_attr_e( 'Hex Value', 'elementor' ); ?>" {{ defaultValue }}{{ dataAlpha }} />
			</div>
		</div>
		<?php
	}

	protected function get_default_settings() {
		return [
			'alpha' => true,
		];
	}
}

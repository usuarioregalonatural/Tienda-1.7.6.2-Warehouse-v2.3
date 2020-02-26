<?php
namespace Elementor;

if ( ! defined( 'ELEMENTOR_ABSPATH' ) ) exit; // Exit if accessed directly

class Control_Modules extends Control_Base {

	public function get_type() {
		return 'modules';
	}

	public function content_template() {
		?>
		<# if ( data.description ) { #>
			<div class="elementor-control-description">{{{ data.description }}}</div>
			<# } #>
		<div class="elementor-control-field">
			<label class="elementor-control-title">{{{ data.label }}}</label>
			<div class="elementor-control-input-wrapper">
				<select data-setting="{{ data.name }}">
					<option value="0"><?php \IqitElementorWpHelper::_e( 'Select module', 'elementor' ); ?></option>
					<# _.each( data.options, function( module ) { #>
						<option value="{{ module.name }}">{{{ module.name }}}</option>
						<# } ); #>
				</select>
			</div>
		</div>
		<div class="elementor-control-field">
			<label class="elementor-control-title"><?php \IqitElementorWpHelper::_e( 'Hook', 'elementor' ); ?></label>
			<div class="elementor-control-input-wrapper">
				<input type="text" class="elementor-control-autocomplete-search" placeholder="{{ data.placeholder }}" />
			</div>
		</div>
		<?php
	}
}

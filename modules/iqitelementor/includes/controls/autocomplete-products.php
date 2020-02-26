<?php
namespace Elementor;

if ( ! defined( 'ELEMENTOR_ABSPATH' ) ) exit; // Exit if accessed directly

class Control_Autocomplete_Products extends Control_Base {

	public function get_type() {
		return 'autocomplete_products';
	}

	public function content_template() {
		?>
		<div class="elementor-control-field">
			<label class="elementor-control-title">{{{ data.label }}}</label>
			<div class="elementor-control-input-wrapper">
				<input type="text" class="elementor-control-autocomplete-search" placeholder="{{ data.placeholder }}" <# if ( data.single ) { #> data-single="true" <# } #> />



				<div class="elementor-control-content elementor-selected-products-wrapper">
						<div class="elementor-control-field">
							<label class="elementor-control-title"> <# if ( data.single ) { #> <?php \IqitElementorWpHelper::_e( 'Selected product', 'elementor' ); ?><# } else { #> <?php \IqitElementorWpHelper::_e( 'Selected products', 'elementor' ); ?><# } #></label>

							<div class="elementor-control-input-wrapper">

								<div class="elementor-control-selected-preview"></div>

								<select class="elementor-control-selected-options" multiple="multiple"  data-setting="{{ data.name }}">
									<# _.each( data.controlValue, function(product) { #>
										<option value="{{ product }}">{{{ product }}}</option>
									<# } ); #>
								</select>
							</div>
						</div>

					</div>

			</div>
		</div>
		<# if ( data.description ) { #>
			<div class="elementor-control-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}
}

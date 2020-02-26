<?php
namespace Elementor;

if ( ! defined( 'ELEMENTOR_ABSPATH' ) ) exit; // Exit if accessed directly

abstract class Scheme_Base implements Scheme_Interface {

	public function get_scheme_value() {
		$scheme_values = json_decode(\IqitElementorWpHelper::get_option( 'elementor_scheme_' . static::get_type() ));

		if ( ! $scheme_values ) {
			$scheme_values = $this->get_default_scheme();

			\IqitElementorWpHelper::update_option( 'elementor_scheme_' . static::get_type(), json_encode($scheme_values) );
		}

		return $scheme_values;
	}


	public function get_scheme() {
		$schemes = [];

		foreach ( $this->get_scheme_titles() as $scheme_key => $scheme_title ) {
			$schemes[ $scheme_key ] = [
				'title' => $scheme_title,
				'value' => $this->get_scheme_value()[ $scheme_key ],
			];
		}

		return $schemes;
	}
}

<?php
namespace Elementor;

if ( ! defined( 'ELEMENTOR_ABSPATH' ) ) exit; // Exit if accessed directly

?>
<div id="elementor-editor-wrapper">
	<div id="elementor-preview">
		<div id="elementor-loading">
			<div class="elementor-loader-wrapper">
				<div class="elementor-loader">
					<div class="elementor-loader-box"></div>
					<div class="elementor-loader-box"></div>
					<div class="elementor-loader-box"></div>
					<div class="elementor-loader-box"></div>
				</div>
				<div class="elementor-loading-title"><?php \IqitElementorWpHelper::_e( 'Loading', 'elementor' ) ?></div>
			</div>
		</div>
		<div id="elementor-preview-responsive-wrapper" class="elementor-device-desktop elementor-device-rotate-portrait">
			<?php
			// IFrame will be create here by the Javascript later.
			?>
		</div>
	</div>
	<div id="elementor-panel"></div>
</div>



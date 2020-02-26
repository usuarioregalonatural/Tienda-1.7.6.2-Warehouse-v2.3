<?php
namespace Elementor;

if ( ! defined( 'ELEMENTOR_ABSPATH' ) ) exit; // Exit if accessed directly
?>
<script type="text/template" id="tmpl-elementor-panel-elements">
	<div id="elementor-panel-elements-languageselector-area"></div>
	<div id="elementor-panel-elements-search-area"></div>
	<div id="elementor-panel-elements-wrapper"></div>
</script>

<script type="text/template" id="tmpl-elementor-panel-elements-category">
	<div class="panel-elements-category-title">{{{ title }}}</div>
	<div class="panel-elements-category-items"></div>
</script>

<script type="text/template" id="tmpl-elementor-panel-element-languageselector">
		<div><?php \IqitElementorWpHelper::_e( 'Editing:', 'elementor' ); ?>
			<select>
				<# _.each( elementor.config.languages, function( language ) { #>
					<option value="{{{ language.id_lang }}}" <# if (elementor.config.id_lang == language.id_lang) {#> selected <# } #> >{{{ language.name }}}</option>
					<# } ); #>
			</select>
			<div  title="<?php \IqitElementorWpHelper::_e( 'Import from  other language', 'elementor' ); ?>" id="elementor-panel-elements-language-import">
				<span id="elementor-panel-elements-language-import-btn"><i class="fa fa-files-o elementor-panel-elements-language-clone"></i><i class="fa fa-times elementor-panel-elements-language-close"></i></span>

				<div id="elementor-panel-elements-language-import-list">
					<?php \IqitElementorWpHelper::_e( 'Import content from  other language', 'elementor' ); ?>
					<ul>
					<# _.each( elementor.config.languages, function( language ) { #>
						<# if (!(elementor.config.id_lang == language.id_lang)) {#> <li><a href="#" class="elementor-panel-elements-language-import-lng" data-language="{{{ language.id_lang }}}"  >{{{ language.name }}}</a></li><# } #>
								<# } ); #>
					</ul>
				</div>
			</div>
</script>



<script type="text/template" id="tmpl-elementor-panel-element-search">
	<input id="elementor-panel-elements-search-input" placeholder="<?php  \IqitElementorWpHelper::_e( 'Search Widget...', 'elementor' ); ?>" />
	<i class="fa fa-search"></i>
</script>

<script type="text/template" id="tmpl-elementor-element-library-element">
	<div class="elementor-element">
		<div class="icon">
			<i class="eicon-{{ icon }}"></i>
		</div>
		<div class="elementor-element-title-wrapper">
			<div class="title">{{{ title }}}</div>
		</div>
	</div>
</script>

<?php
namespace Elementor;

if ( ! defined( 'ELEMENTOR_ABSPATH' ) ) exit; // Exit if accessed directly
?>
<script type="text/template" id="tmpl-elementor-template-library-header">
	<div id="elementor-template-library-header-logo-area"></div>
	<div id="elementor-template-library-header-menu-area"></div>
	<div id="elementor-template-library-header-items-area">
		<div id="elementor-template-library-header-close-modal" class="elementor-template-library-header-item" title="<?php \IqitElementorWpHelper::_e( 'Close', 'elementor' ); ?>">
			<i class="eicon-close" title="<?php \IqitElementorWpHelper::_e( 'Close', 'elementor' ); ?>"></i>
		</div>
		<div id="elementor-template-library-header-tools2"></div>
		<div id="elementor-template-library-header-tools"></div>
	</div>
</script>

<script type="text/template" id="tmpl-elementor-template-library-header-logo">
	<i class="eicon-elementor-square"></i><span><?php \IqitElementorWpHelper::_e( 'Library', 'elementor' ); ?></span>
</script>

<script type="text/template" id="tmpl-elementor-template-library-header-save">
	<i class="eicon-save" title="<?php \IqitElementorWpHelper::_e( 'Save Template', 'elementor' ); ?>"></i>
</script>

<script type="text/template" id="tmpl-elementor-template-library-header-load">
	<i class="icon-upload" title="<?php \IqitElementorWpHelper::_e( 'Load Template', 'elementor' ); ?>"></i>
</script>

<script type="text/template" id="tmpl-elementor-template-library-header-menu">
	<div id="elementor-template-library-menu-my-templates" class="elementor-template-library-menu-item" data-template-source="local"><?php \IqitElementorWpHelper::_e( 'Templates list', 'elementor' ); ?></div>
</script>

<script type="text/template" id="tmpl-elementor-template-library-header-preview">
	<div id="elementor-template-library-header-preview-insert-wrapper" class="elementor-template-library-header-item">
		<button id="elementor-template-library-header-preview-insert" class="elementor-template-library-template-insert elementor-button elementor-button-success">
			<i class="eicon-file-download"></i><span class="elementor-button-title"><?php \IqitElementorWpHelper::_e( 'Insert', 'elementor' ); ?></span>
		</button>
	</div>
</script>

<script type="text/template" id="tmpl-elementor-template-library-header-back">
	<i class="eicon-"></i><span><?php \IqitElementorWpHelper::_e( 'Back To library', 'elementor' ); ?></span>
</script>

<script type="text/template" id="tmpl-elementor-template-library-loading">
	<div class="elementor-loader-wrapper">
		<div class="elementor-loader">
			<div class="elementor-loader-box"></div>
			<div class="elementor-loader-box"></div>
			<div class="elementor-loader-box"></div>
			<div class="elementor-loader-box"></div>
		</div>
		<div class="elementor-loading-title"><?php \IqitElementorWpHelper::_e( 'Loading', 'elementor' ) ?></div>
	</div>
</script>

<script type="text/template" id="tmpl-elementor-template-library-templates">
	<div id="elementor-template-library-templates-container"></div>
	<div id="elementor-template-library-footer-banner">
		<i class="eicon-nerd"></i>
		<div class="elementor-excerpt"><?php echo \IqitElementorWpHelper::__( 'Stay tuned! More awesome templates coming real soon.', 'elementor' ); ?></div>
	</div>
</script>


<script type="text/template" id="tmpl-elementor-template-library-template-local">
	<div class="elementor-template-library-template-icon">
		<i class="fa fa-{{ 'section' === type ? 'columns' : 'file-text-o' }}"></i>
	</div>
	<div class="elementor-template-library-template-name">{{{ title }}}</div>
	<div class="elementor-template-library-template-controls">
		<button class="elementor-template-library-template-insert elementor-button elementor-button-success">
			<i class="eicon-file-download"></i><span class="elementor-button-title"><?php \IqitElementorWpHelper::_e( 'Insert', 'elementor' ); ?></span>
		</button>
		<div class="elementor-template-library-template-export">
			<a href="{{ export_link }}">
				<i class="fa fa-sign-out"></i><span class="elementor-template-library-template-control-title"><?php echo \IqitElementorWpHelper::__( 'Export', 'elementor' ); ?></span>
			</a>
		</div>
		<div class="elementor-template-library-template-delete">
			<i class="fa fa-trash-o"></i><span class="elementor-template-library-template-control-title"><?php echo \IqitElementorWpHelper::__( 'Delete', 'elementor' ); ?></span>
		</div>
		<div class="elementor-template-library-template-preview">
			<i class="eicon-zoom-in"></i><span class="elementor-template-library-template-control-title"><?php echo \IqitElementorWpHelper::__( 'Preview', 'elementor' ); ?></span>
		</div>
	</div>
</script>

<script type="text/template" id="tmpl-elementor-template-library-save-template">
	<div class="elementor-template-library-blank-title">{{{ elementor.translate( 'save_your_template', [ elementor.translate( sectionID ? 'section' : 'page' ) ] ) }}}</div>
	<div class="elementor-template-library-blank-excerpt"><?php \IqitElementorWpHelper::_e( 'Your designs will be available for export and reuse on any page or website', 'elementor' ); ?></div>
	<form id="elementor-template-library-save-template-form">
		<input id="elementor-template-library-save-template-name" name="title" placeholder="<?php \IqitElementorWpHelper::_e( 'Enter Template Name', 'elementor' ); ?>" required>
		<button id="elementor-template-library-save-template-submit" class="elementor-button elementor-button-success">
			<span class="elementor-state-icon">
				<i class="fa fa-spin fa-circle-o-notch "></i>
			</span>
			<?php \IqitElementorWpHelper::_e( 'Save', 'elementor' ); ?>
		</button>
	</form>
	<div class="elementor-template-library-blank-footer">
		<?php \IqitElementorWpHelper::_e( 'What is Library?', 'elementor' ); ?>
		<a class="elementor-template-library-blank-footer-link" href="https://go.elementor.com/docs-library/" target="_blank"><?php \IqitElementorWpHelper::_e( 'Read our tutorial on using Library templates.', 'elementor' ); ?></a>
	</div>
</script>


<script type="text/template" id="tmpl-elementor-template-library-load-template">
	<div class="elementor-template-library-blank-title">{{{ elementor.translate( 'load_your_template'  ) }}}</div>
	<div class="elementor-template-library-blank-excerpt"><?php \IqitElementorWpHelper::_e( 'Import your .json design file from your local pc', 'elementor' ); ?></div>
	<form id="elementor-template-library-load-template-form">
		<div id="elementor-template-library-load-wrapper">
		<button id="elementor-template-library-load-btn-file"><?php \IqitElementorWpHelper::_e( 'Select template .json file', 'elementor' ); ?></button>
		<input id="elementor-template-library-load-template-file" type="file" name="file" required>
		</div>
		<button id="elementor-template-library-load-template-submit" class="elementor-button elementor-button-success">
			<span class="elementor-state-icon">
				<i class="fa fa-spin fa-circle-o-notch "></i>
			</span>
			<?php \IqitElementorWpHelper::_e( 'load', 'elementor' ); ?>
		</button>
	</form>
</script>

<script type="text/template" id="tmpl-elementor-template-library-templates-empty">
	<div id="elementor-template-library-templates-empty-icon">
		<i class="eicon-nerd"></i>
	</div>
	<div class="elementor-template-library-blank-title"><?php \IqitElementorWpHelper::_e( 'Haven’t Saved Templates Yet?', 'elementor' ); ?></div>
	<div class="elementor-template-library-blank-excerpt"><?php \IqitElementorWpHelper::_e( 'This is where your templates should be. Design it. Save it. Reuse it.', 'elementor' ); ?></div>
	<div class="elementor-template-library-blank-footer">
		<?php \IqitElementorWpHelper::_e( 'What is Library?', 'elementor' ); ?>
		<a class="elementor-template-library-blank-footer-link" href="https://go.elementor.com/docs-library/" target="_blank"><?php \IqitElementorWpHelper::_e( 'Read our tutorial on using Library templates.', 'elementor' ); ?></a>
	</div>
</script>

<script type="text/template" id="tmpl-elementor-template-library-preview">
	<iframe></iframe>
</script>

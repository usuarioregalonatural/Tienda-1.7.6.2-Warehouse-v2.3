{extends file="helpers/form/form.tpl"}
{block name="script"}
$(document).ready(function() {
	$('.iframe-upload').fancybox({	
		'width'		: 900,
		'height'	: 600,
		'type'		: 'iframe',
		'autoScale' : false,
		'autoDimensions': false,
		'fitToView' : false,
		'autoSize' : false,
		onUpdate : function() { 
			$('.fancybox-iframe').contents().find('a.link').data('field_id', $(this.element).data("input-name"));
	 		$('.fancybox-iframe').contents().find('a.link').attr('data-field_id', $(this.element).data("input-name"));
	 	},
		afterShow: function() {
		 	$('.fancybox-iframe').contents().find('a.link').data('field_id', $(this.element).data("input-name"));
		 	$('.fancybox-iframe').contents().find('a.link').attr('data-field_id', $(this.element).data("input-name"));
		}
	});
});

{/block}
{block name="input"}
	{if $input.type == 'select_image'}
            <input name="{$input.name|escape:'html':'UTF-8'}" id="{$input.name|escape:'html':'UTF-8'}" value="{$fields_value[$input.name]|escape:'html':'UTF-8'}" type="text" />
            <p>
            <a href="filemanager/dialog.php?type=1&amp;field_id={$input.name|escape:'html':'UTF-8'}" class="btn btn-default iframe-upload"  data-input-name="{$input.name|escape:'html':'UTF-8'}" type="button">{l s='Image selector' mod='ph_simpleblog'} <i class="icon-angle-right"></i></a>
            </p>
	{else}
		{$smarty.block.parent}
	{/if}
{/block}
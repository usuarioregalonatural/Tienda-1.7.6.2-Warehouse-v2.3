{**
* NOTICE OF LICENSE
*
* This product is licensed for one customer to use on one installation (test stores and multishop included).
* Site developer has the right to modify this module to suit their needs, but can not redistribute the module in
* whole or in part. Any other use of this module constitues a violation of the user agreement.
*
* DISCLAIMER
*
* NO WARRANTIES OF DATA SAFETY OR MODULE SECURITY
* ARE EXPRESSED OR IMPLIED. USE THIS MODULE IN ACCORDANCE
* WITH YOUR MERCHANT AGREEMENT, KNOWING THAT VIOLATIONS OF
* PCI COMPLIANCY OR A DATA BREACH CAN COST THOUSANDS OF DOLLARS
* IN FINES AND DAMAGE A STORES REPUTATION. USE AT YOUR OWN RISK.
*
*  @author    idnovate.com <info@idnovate.com>
*  @copyright 2019 idnovate.com
*  @license   See above
*}

{if isset($files) && $files|count > 0}
	{assign var='show_thumbnail' value=false}
	{foreach $files as $file}
		{if isset($file.image) && $file.type == 'image'}
			{assign var='show_thumbnail' value=true}
		{/if}
	{/foreach}
{if $show_thumbnail}
<div class="form-group">
	<div class="col-lg-12" id="{$id|escape:'html':'UTF-8'}-images-thumbnails">
		{foreach $files as $file}
		{if isset($file.image) && $file.type == 'image'}
		<div>
			{$file.image}
			{if isset($file.size)}<p>{l s='File size' mod='whatsappchat'} {$file.size|escape:'html':'UTF-8'}kb</p>{/if}
			{if isset($file.delete_url)}
			<p>
				<a class="btn btn-default" href="{$file.delete_url nofilter}">
					<i class="icon-trash"></i> {l s='Delete' d='Admin.Actions'}
				</a>
			</p>
			{/if}
		</div>
		{/if}
		{/foreach}
	</div>
</div>
{/if}
{/if}
{if isset($max_files) && $files|count >= $max_files}
<div class="row">
	<div class="alert alert-warning">{l s='You have reached the limit (%s) of files to upload, please remove files to continue uploading' sprintf=[$max_files] mod='whatsappchat'}</div>
</div>
{else}
<div class="form-group">
	<div class="col-sm-6">
		<input id="{$id|escape:'html':'UTF-8'}" type="file" name="{$name|escape:'html':'UTF-8'}{if isset ($multiple) && $multiple}[]{/if}"{if isset($multiple) && $multiple} multiple="multiple"{/if} class="hide" />
		<div class="dummyfile input-group">
			<span class="input-group-addon"><i class="icon-file"></i></span>
			<input id="{$id|escape:'html':'UTF-8'}-name" type="text" name="{$name|escape:'html':'UTF-8'}" readonly />
			<span class="input-group-btn">
				<button id="{$id|escape:'html':'UTF-8'}-selectbutton" type="button" name="submitAddAttachments" class="btn btn-default">
					<i class="icon-folder-open"></i> {if isset($multiple) && $multiple}{l s='Add files' mod='whatsappchat'}{else}{l s='Add file' mod='whatsappchat'}{/if}
				</button>
				{if (!isset($multiple) || !$multiple) && isset($files) && $files|count == 1 && isset($files[0].download_url)}
					<a href="{$files[0].download_url|escape:'html':'UTF-8'}" class="btn btn-default">
						<i class="icon-cloud-download"></i>
						{if isset($size)}{l s='Download current file (%skb)' sprintf=[$size] mod='whatsappchat'}{else}{l s='Download current file' mod='whatsappchat'}{/if}
					</a>
				{/if}
			</span>
		</div>
	</div>
</div>
<script type="text/javascript">
{if isset($multiple) && isset($max_files)}
	var {$id|escape:'html':'UTF-8'}_max_files = {$max_files - ($files|count)};
{/if}

	$(document).ready(function(){
		$('#{$id|escape:'html':'UTF-8'}-selectbutton').click(function(e) {
			$('#{$id|escape:'html':'UTF-8'}').trigger('click');
		});

		$('#{$id|escape:'html':'UTF-8'}-name').click(function(e) {
			$('#{$id|escape:'html':'UTF-8'}').trigger('click');
		});

		$('#{$id|escape:'html':'UTF-8'}-name').on('dragenter', function(e) {
			e.stopPropagation();
			e.preventDefault();
		});

		$('#{$id|escape:'html':'UTF-8'}-name').on('dragover', function(e) {
			e.stopPropagation();
			e.preventDefault();
		});

		$('#{$id|escape:'html':'UTF-8'}-name').on('drop', function(e) {
			e.preventDefault();
			var files = e.originalEvent.dataTransfer.files;
			$('#{$id|escape:'html':'UTF-8'}')[0].files = files;
			$(this).val(files[0].name);
		});

		$('#{$id|escape:'html':'UTF-8'}').change(function(e) {
			if ($(this)[0].files !== undefined)
			{
				var files = $(this)[0].files;
				var name  = '';

				$.each(files, function(index, value) {
					name += value.name+', ';
				});

				$('#{$id|escape:'html':'UTF-8'}-name').val(name.slice(0, -2));
			}
			else // Internet Explorer 9 Compatibility
			{
				var name = $(this).val().split(/[\\/]/);
				$('#{$id|escape:'html':'UTF-8'}-name').val(name[name.length-1]);
			}
		});

		if (typeof {$id|escape:'html':'UTF-8'}_max_files !== 'undefined')
		{
			$('#{$id|escape:'html':'UTF-8'}').closest('form').on('submit', function(e) {
				if ($('#{$id|escape:'html':'UTF-8'}')[0].files.length > {$id|escape:'html':'UTF-8'}_max_files) {
					e.preventDefault();
					alert('{l s='You can upload a maximum of %s files' sprintf=[$max_files] mod='whatsappchat'}');
				}
			});
		}
	});
</script>
{/if}

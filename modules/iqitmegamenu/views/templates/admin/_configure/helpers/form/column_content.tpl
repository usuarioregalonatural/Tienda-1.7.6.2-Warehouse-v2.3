{*
* 2007-2017 IQIT-COMMERCE.COM
*
* NOTICE OF LICENSE
*
*  @author    IQIT-COMMERCE.COM <support@iqit-commerce.com>
*  @copyright 2007-2017 IQIT-COMMERCE.COM
*  @license   GNU General Public License version 2
*
* You can not resell or redistribute this software.
*
*}


	<div class="menu-column-content">
		<p>
			<label>{l s='Column width' mod='iqitmegamenu'}:</label>

			<select class="select-column-width">
				{for $i=1 to 12}
				<option value="{$i}" {if isset($node.width)}{if $node.width==$i}selected{/if}{else}{if $i==3}selected{/if}{/if}>{$i}/12</option>
				{/for}
			</select>
		</p>
		<label>{l s='Column content' mod='iqitmegamenu'}:</label>
		<p class="column-content-info">{l s='Empty' mod='iqitmegamenu'}</p>
		<p class="edit-btn-wrapper"><button type="button" class="btn btn-default column-content-edit"><i class="icon-pencil"></i> {l s='Edit content' mod='iqitmegamenu'}</button></p>

		<div class="modal fade column-content-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-body">

						<div class="form-group">
							<label class="control-label col-lg-3">
								{l s='Column title' mod='iqitmegamenu'}
							</label>


							{foreach from=$languages item=language}
							{if $languages|count > 1}
							<div class="translatable-field lang-{$language.id_lang}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
								{/if}
								<div class="col-lg-7">
									<input value="{if isset($node.content_s.title[$language.id_lang])}{$node.content_s.title[$language.id_lang]}{/if}" type="text" class="column-title-{$language.id_lang}">
									<p class="help-block">
										{l s='Optional column title' mod='iqitmegamenu'}
									</p>
								</div>
								{if $languages|count > 1}
								<div class="col-lg-2">
									<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
										{$language.iso_code}
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu">
										{foreach from=$languages item=lang}
										<li><a href="javascript:hideOtherLanguage({$lang.id_lang} );" tabindex="-1">{$lang.name|escape:'html'}</a></li>
										{/foreach}
									</ul>
								</div>
								{/if}
								{if $languages|count > 1}
							</div>
							{/if}
							{/foreach}
						</div>

						<div class="form-group">
							<label class="control-label col-lg-3">
								{l s='Column title link' mod='iqitmegamenu'}
							</label>


							{foreach from=$languages item=language}
							{if $languages|count > 1}
							<div class="translatable-field lang-{$language.id_lang}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
								{/if}
								<div class="col-lg-7">
									<input value="{if isset($node.content_s.href[$language.id_lang])}{$node.content_s.href[$language.id_lang]}{/if}" type="text" class="column-href-{$language.id_lang}">
									<p class="help-block">
								{l s='Optional link. Use entire url with http:// prefix' mod='iqitmegamenu'}
							</p>
								</div>
								{if $languages|count > 1}
								<div class="col-lg-2">
									<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
										{$language.iso_code}
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu">
										{foreach from=$languages item=lang}
										<li><a href="javascript:hideOtherLanguage({$lang.id_lang} );" tabindex="-1">{$lang.name|escape:'html'}</a></li>
										{/foreach}
									</ul>
								</div>
								{/if}
								{if $languages|count > 1}
							</div>
							{/if}
							{/foreach}
						</div>

						<div class="form-group">
							<label class="control-label col-lg-3">
								{l s='Title legend' mod='iqitmegamenu'}
							</label>


							{foreach from=$languages item=language}
							{if $languages|count > 1}
							<div class="translatable-field lang-{$language.id_lang}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
								{/if}
								<div class="col-lg-7">
									<input value="{if isset($node.content_s.legend[$language.id_lang])}{$node.content_s.legend[$language.id_lang]}{/if}" type="text" class="column-legend-{$language.id_lang}">
									<p class="help-block">
										{l s='Optional additional text showed in tooltip' mod='iqitmegamenu'}
									</p>
								</div>
								{if $languages|count > 1}
								<div class="col-lg-2">
									<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
										{$language.iso_code}
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu">
										{foreach from=$languages item=lang}
										<li><a href="javascript:hideOtherLanguage({$lang.id_lang} );" tabindex="-1">{$lang.name|escape:'html'}</a></li>
										{/foreach}
									</ul>
								</div>
								{/if}
								{if $languages|count > 1}
							</div>
							{/if}
							{/foreach}
						</div>




						<div class="form-group">
							<label class="control-label col-lg-3">{l s='Content type' mod='iqitmegamenu'}</label>
							<select class="select-column-content col-lg-9">
								<option value="7" {if isset($node.contentType) && $node.contentType==7}selected{/if}>{l s='Suppliers logos' mod='iqitmegamenu'}</option>
								<option value="6" {if isset($node.contentType) && $node.contentType==6}selected{/if}>{l s='Banner image' mod='iqitmegamenu'}</option>
								<option value="5" {if isset($node.contentType) && $node.contentType==5}selected{/if}>{l s='Manufacturers logos' mod='iqitmegamenu'}</option>
								<option value="4" {if isset($node.contentType) && $node.contentType==4}selected{/if}>{l s='Products' mod='iqitmegamenu'}</option>
								<option value="3" {if isset($node.contentType) && $node.contentType==3}selected{/if}>{l s='Various links' mod='iqitmegamenu'}</option>
								<option value="2" {if isset($node.contentType) && $node.contentType==2}selected{/if}>{l s='Categories tree' mod='iqitmegamenu'}</option>
								<option value="1" {if isset($node.contentType) && $node.contentType==1}selected{/if}>{l s='Html Content' mod='iqitmegamenu'}</option>
								<option value="0" {if isset($node.contentType)}{if $node.contentType==0}selected{/if}{else}selected{/if} >{l s='Empty' mod='iqitmegamenu'}</option>

							</select></div>

					<div class="htmlcontent-wrapper content-options-wrapper">
							<div class="form-group">
							<label class="control-label col-lg-3">
								{l s='Custom Html content' mod='iqitmegamenu'}
							</label>
								<select class="select-customhtml col-lg-9">
							<option value="0">{l s='No content' mod='iqitmegamenu'}</option>
							{foreach from=$custom_html_select item=customhtml}
							<option value="{$customhtml.id_html}" {if isset($node.content.ids) && $node.content.ids == $customhtml.id_html}selected{/if} >{$customhtml.title}</option>
							{/foreach}
							</select>




						</div>
					</div>

					<div class="categorytree-wrapper content-options-wrapper">

						<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Categories' mod='iqitmegamenu'}</label>
								<select class="select-categories-ids col-lg-9" multiple="multiple" style="height: 160px;">
									{foreach from=$categories_select item=category}
										<option value="{$category.id}" {if isset($node.content.ids) && $node.contentType == 2 && in_array($category.id, $node.content.ids)}selected{/if} disabled>{$category.name}</option>

										{if isset($category.children)}
											{if isset($node.content.ids) && $node.contentType == 2}
												{include file="./subcategory.tpl" categories=$category.children ids=$node.content.ids type=$node.contentType}
											{else}
												{include file="./subcategory.tpl" categories=$category.children}
											{/if}
										{/if}
									{/foreach}
								</select>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Selected categories as tree root' mod='iqitmegamenu'}</label>
								<div class="col-lg-9"><select class="select-categories-treep">
									<option value="1" {if isset($node.content.treep) && $node.content.treep == 1}selected{/if} >{l s='Yes' mod='iqitmegamenu'}</option>
									<option value="0"  {if isset($node.content.treep) && $node.content.treep == 0}selected{/if}>{l s='No' mod='iqitmegamenu'}</option>
								</select>
							<p class="help-block">
								{l s='If enabled each selected category will have block title style. Enable only if you selecting categories with subcategories' mod='iqitmegamenu'}
							</p></div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Show category thumb' mod='iqitmegamenu'}</label>
								<div class="col-lg-9"><select class="select-categories-thumb">
									<option value="1" {if isset($node.content.thumb) && $node.content.thumb == 1}selected{/if} >{l s='Yes' mod='iqitmegamenu'}</option>
									<option value="0"  {if isset($node.content.thumb) && $node.content.thumb == 0}selected{/if}>{l s='No' mod='iqitmegamenu'}</option>
								</select>
							<p class="help-block">
								{l s='It works only with enabled option "selected categories as tree root". It will show first menu thumbail. You can define menu thumbail during category edit.' mod='iqitmegamenu'}
							</p></div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Categories per line' mod='iqitmegamenu'}</label>
								<div class="col-lg-9"><select class="select-categories-line">
									<option value="12"  {if isset($node.content.line) && $node.content.line == 12}selected{/if} >1</option>
									<option value="6"  {if isset($node.content.line) && $node.content.line == 6}selected{/if}>2</option>
									<option value="4"  {if isset($node.content.line) && $node.content.line == 4}selected{/if} >3</option>
									<option value="3"  {if isset($node.content.line) && $node.content.line == 3}selected{/if}>4</option>
									<option value="15"  {if isset($node.content.line) && $node.content.line == 15}selected{/if}>5</option>
									<option value="2"  {if isset($node.content.line) && $node.content.line == 2}selected{/if}>6</option>
								</select>
								<p class="help-block">
								{l s='If Selected categories as root is enabled, you can decide how meny cats per row to show' mod='iqitmegamenu'}
							</p>
							</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Depth limit' mod='iqitmegamenu'}</label>
								<select class="select-categories-depth col-lg-9">
									<option value="4" {if isset($node.content.depth) && $node.content.depth == 4}selected{/if} >{l s='4' mod='iqitmegamenu'}</option>
									<option value="3" {if isset($node.content.depth) && $node.content.depth == 3}selected{/if} >{l s='3' mod='iqitmegamenu'}</option>
									<option value="2" {if isset($node.content.depth) && $node.content.depth == 2}selected{/if} >{l s='2' mod='iqitmegamenu'}</option>
									<option value="1" {if isset($node.content.depth) && $node.content.depth == 1}selected{/if} >{l s='1' mod='iqitmegamenu'}</option>
									<option value="0" {if isset($node.content.depth) && $node.content.depth == 0}selected{/if} >{l s='0' mod='iqitmegamenu'}</option>
								</select>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Subcategories limit' mod='iqitmegamenu'}</label>
								<div class="col-lg-9">
								<select class="select-categories-sublimit">
									{for $i=5 to 60 step 5}
										<option value="{$i}" {if isset($node.content.sublimit)}{if $node.content.sublimit==$i}selected{/if}{else}{if $i==15}selected{/if}{/if}>{$i}</option>
									{/for}
								</select>
							<p class="help-block">
								{l s='If limit will be reach, they will be not showed. Helpfull if you have some category with long list of subcategories' mod='iqitmegamenu'}
							</p></div>
							</div>
					</div>

					<div class="va-links-wrapper content-options-wrapper {if isset($node.elementId)}va-links-wrapper-{$node.elementId}{/if}">
							<div class="form-group">
								<label class="control-label col-lg-3">{l s='Select links' mod='iqitmegamenu'}</label>
								{*HTML CONTENT*} {$va_links_select nofilter}
								{if isset($node.content.ids) && $node.contentType == 3}
								<script>
								$(".{if isset($node.elementId)}va-links-wrapper-{$node.elementId}{/if} .select-links-ids").val({$node.content.ids|json_encode});
								</script>
								{/if}
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Select view' mod='iqitmegamenu'}</label>
								<select class="select-links-view col-lg-9">
									<option value="2" {if isset($node.content.view) && $node.content.view == 2}selected{/if} >{l s='Horizontal(with column title inline)' mod='iqitmegamenu'}</option>
									<option value="1" {if isset($node.content.view) && $node.content.view == 1}selected{/if} >{l s='Vertical' mod='iqitmegamenu'}</option>
									<option value="0"  {if isset($node.content.view)}{if $node.content.view == 0}selected{/if}{else}selected{/if}>{l s='Horizontal(with column title above)' mod='iqitmegamenu'}</option>
								</select>
							</div>
					</div>

					<div class="column-image-wrapper content-options-wrapper">

						<div class="form-group">
							<label class="control-label col-lg-3">
								{l s='Image source' mod='iqitmegamenu'}
							</label>
							{foreach from=$languages item=language}
							{if $languages|count > 1}
							<div class="translatable-field lang-{$language.id_lang}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
								{/if}
								<div class="col-lg-7">
									<input value="{if isset($node.content.source[$language.id_lang])}{$node.content.source[$language.id_lang]}{/if}" type="text" class="image-source image-source-{$language.id_lang}" name="{if isset($node.elementId)}{$node.elementId}-{/if}image-source-{$language.id_lang}"  id="{if isset($node.elementId)}{$node.elementId}-{/if}image-source-{$language.id_lang}" data-lang-id="{$language.id_lang}" >
									<a href="filemanager/dialog.php?type=1&field_id={if isset($node.elementId)}{$node.elementId}-{/if}image-source-{$language.id_lang}" class="btn btn-default iframe-column-upload"  data-input-name="{if isset($node.elementId)}{$node.elementId}-{/if}image-source-{$language.id_lang}" type="button">{l s='Select image' mod='iqitmegamenu'} <i class="icon-angle-right"></i></a>
								</div>
								{if $languages|count > 1}
								<div class="col-lg-2">
									<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
										{$language.iso_code}
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu">
										{foreach from=$languages item=lang}
										<li><a href="javascript:hideOtherLanguage({$lang.id_lang} );" tabindex="-1">{$lang.name|escape:'html'}</a></li>
										{/foreach}
									</ul>
								</div>
								{/if}
								{if $languages|count > 1}
							</div>
							{/if}
							{/foreach}
						</div>

						<div class="form-group">
							<label class="control-label col-lg-3">
								{l s='Image link' mod='iqitmegamenu'}
							</label>
							{foreach from=$languages item=language}
							{if $languages|count > 1}
							<div class="translatable-field lang-{$language.id_lang}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
								{/if}
								<div class="col-lg-7">
									<input value="{if isset($node.content.href[$language.id_lang])}{$node.content.href[$language.id_lang]}{/if}" type="text" class="image-href-{$language.id_lang}">
									<p class="help-block">
								{l s='Optional link. Use entire url with http:// prefix' mod='iqitmegamenu'}
							</p>
								</div>
								{if $languages|count > 1}
								<div class="col-lg-2">
									<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
										{$language.iso_code}
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu">
										{foreach from=$languages item=lang}
										<li><a href="javascript:hideOtherLanguage({$lang.id_lang});" tabindex="-1">{$lang.name|escape:'html'}</a></li>
										{/foreach}
									</ul>
								</div>
								{/if}
								{if $languages|count > 1}
							</div>
							{/if}
							{/foreach}
						</div>

						<div class="form-group">
							<label class="control-label col-lg-3">
								{l s='Alt tag(image description)' mod='iqitmegamenu'}
							</label>
							{foreach from=$languages item=language}
							{if $languages|count > 1}
							<div class="translatable-field lang-{$language.id_lang}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
								{/if}
								<div class="col-lg-7">
									<input value="{if isset($node.content.alt[$language.id_lang])}{$node.content.alt[$language.id_lang]}{/if}" type="text" class="image-alt-{$language.id_lang}">
								</div>
								{if $languages|count > 1}
								<div class="col-lg-2">
									<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
										{$language.iso_code}
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu">
										{foreach from=$languages item=lang}
										<li><a href="javascript:hideOtherLanguage({$lang.id_lang});" tabindex="-1">{$lang.name|escape:'html'}</a></li>
										{/foreach}
									</ul>
								</div>
								{/if}
								{if $languages|count > 1}
							</div>
							{/if}
							{/foreach}
						</div>

						<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Absolute positions' mod='iqitmegamenu'}</label>
								<div class="col-lg-9">
								<select class="select-image-absolute">
									<option value="1" {if isset($node.content.absolute) && $node.content.absolute == 1}selected{/if} >{l s='Yes' mod='iqitmegamenu'}</option>
									<option value="0" {if isset($node.content.absolute)}{if $node.content.absolute == 0}selected{/if}{else}selected{/if}>{l s='No' mod='iqitmegamenu'}</option>
								</select>
								<p class="help-block">
									{l s='Thanks to that option you can position image for example in a corner of submenu. You can use - values. If you want to position in right bottom corner set values like: right: -20, bottom: -20, left: , top: . Two values should be always empty. You should not set column title or style when this option is enabled' mod='iqitmegamenu'}
								</p>
								</div>
							</div>

						<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Top' mod='iqitmegamenu'}</label>
								<div class="col-lg-9">
								<input value="{if isset($node.content.i_a_t)}{$node.content.i_a_t}{/if}" type="text" class="image-absolute-t">
								</div>
						</div>
						<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Right' mod='iqitmegamenu'}</label>
								<div class="col-lg-9">
								<input value="{if isset($node.content.i_a_r)}{$node.content.i_a_r}{/if}" type="text" class="image-absolute-r">
								</div>
						</div>
						<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Bottom' mod='iqitmegamenu'}</label>
								<div class="col-lg-9">
								<input value="{if isset($node.content.i_a_b)}{$node.content.i_a_b}{/if}" type="text" class="image-absolute-b">
								</div>
						</div>
						<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Left' mod='iqitmegamenu'}</label>
								<div class="col-lg-9">
								<input value="{if isset($node.content.i_a_l)}{$node.content.i_a_l}{/if}" type="text" class="image-absolute-l">
								</div>
						</div>


					</div>


					<div class="products-wrapper content-options-wrapper">
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Search product' mod='iqitmegamenu'}</label>
								<div class="col-lg-9"><div class="autocomplete-wrapper"><input type="text" class="product-autocomplete form-control" ></div></div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-3">{l s='Selected products' mod='iqitmegamenu'}</label>
								<div class="col-lg-9">
								<select class="select-products-ids" multiple="multiple" style="height: 160px;">
								{if isset($node.content.ids) && $node.contentType == 4}
								{foreach from=$node.content.ids item=product}
									<option value="{$product.id_product}" >(ID: {$product.id_product}) {$product.name}</option>
								{/foreach}
								{/if}
								</select>
								<br />
								<button type="button" class="btn btn-danger remove-products-ids"><i class="icon-trash"></i> {l s='Remove selected' mod='iqitmegamenu'}</button>
								</div>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Select view' mod='iqitmegamenu'}</label>
								<select class="select-products-view col-lg-9">
									<option value="1" {if isset($node.content.view) && $node.content.view == 1}selected{/if} >{l s='Grid(big image + product name below)' mod='iqitmegamenu'}</option>
									<option value="0"  {if isset($node.content.view) && $node.content.view == 0}selected{/if}>{l s='List(small image + product name next to it)' mod='iqitmegamenu'}</option>
								</select>
							</div>

							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Products per line' mod='iqitmegamenu'}</label>
								<select class="select-products-line col-lg-9">
									<option value="12"  {if isset($node.content.line) && $node.content.line == 12}selected{/if} >1</option>
									<option value="6"  {if isset($node.content.line) && $node.content.line == 6}selected{/if}>2</option>
									<option value="4"  {if isset($node.content.line) && $node.content.line == 4}selected{/if} >3</option>
									<option value="3"  {if isset($node.content.line) && $node.content.line == 3}selected{/if}>4</option>
									<option value="15"  {if isset($node.content.line) && $node.content.line == 15}selected{/if}>5</option>
									<option value="2"  {if isset($node.content.line) && $node.content.line == 2}selected{/if}>6</option>
								</select>
							</div>




					</div>

					<div class="manufacturers-wrapper content-options-wrapper">
						<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Select manufacturers' mod='iqitmegamenu'}</label>
								<select class="select-manufacturers-ids col-lg-9" multiple="multiple" style="height: 160px;">
									{foreach from=$manufacturers_select item=manufacturer}
										<option value="{$manufacturer.id}" {if isset($node.content.ids) && $node.contentType == 5 && in_array($manufacturer.id, $node.content.ids)}selected{/if} >{$manufacturer.name}</option>
									{/foreach}
								</select>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Logos per line' mod='iqitmegamenu'}</label>
								<select class="select-manufacturers-line col-lg-9">
									<option value="12"  {if isset($node.content.line) && $node.content.line == 12}selected{/if} >1</option>
									<option value="6"  {if isset($node.content.line) && $node.content.line == 6}selected{/if}>2</option>
									<option value="4"  {if isset($node.content.line) && $node.content.line == 4}selected{/if} >3</option>
									<option value="3"  {if isset($node.content.line) && $node.content.line == 3}selected{/if}>4</option>
									<option value="15"  {if isset($node.content.line) && $node.content.line == 15}selected{/if}>5</option>
									<option value="2"  {if isset($node.content.line) && $node.content.line == 2}selected{/if}>6</option>
									<option value="1" {if isset($node.content.line) && $node.content.line == 1}selected{/if}>12</option>
								</select>
							</div>
					</div>

					<div class="suppliers-wrapper content-options-wrapper">
						<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Select suppliers' mod='iqitmegamenu'}</label>
								<select class="select-suppliers-ids col-lg-9" multiple="multiple" style="height: 160px;">
									{foreach from=$suppliers_select item=supplier}
										<option value="{$supplier.id}" {if isset($node.content.ids) && $node.contentType == 7 && in_array($supplier.id, $node.content.ids)}selected{/if} >{$supplier.name}</option>
									{/foreach}
								</select>
							</div>
							<div class="form-group">
								<label  class="control-label col-lg-3">{l s='Logos per line' mod='iqitmegamenu'}</label>
								<select class="select-suppliers-line col-lg-9">
									<option value="12"  {if isset($node.content.line) && $node.content.line == 12}selected{/if} >1</option>
									<option value="6"  {if isset($node.content.line) && $node.content.line == 6}selected{/if}>2</option>
									<option value="4"  {if isset($node.content.line) && $node.content.line == 4}selected{/if} >3</option>
									<option value="3"  {if isset($node.content.line) && $node.content.line == 3}selected{/if}>4</option>
									<option value="15"  {if isset($node.content.line) && $node.content.line == 15}selected{/if}>5</option>
									<option value="2"  {if isset($node.content.line) && $node.content.line == 2}selected{/if}>6</option>
									<option value="1" {if isset($node.content.line) && $node.content.line == 1}selected{/if}>12</option>
								</select>
							</div>
					</div>


					<div class="style-wrapper clearfix">
						<div class="col-lg-9 col-md-offset-3">
						<p class="help-block">
								{l s='Optional column style fields' mod='iqitmegamenu'}
							</p>
						</div>
						<div class="form-group">
						<label class="control-label col-lg-3">
							{l s='Backgrund color' mod='iqitmegamenu'}
						</label>
					<div class="col-lg-3 ">
							<div class="form-group">
								<div class="col-lg-10">
									<div class="row">
										<div class="input-group">
											<input type="text" data-hex="true" class="column_bg_color {if isset($node.elementId)}column_bg_color-{$node.elementId}{/if}"	name="column_bg_color" value="{if isset($node.content_s.bg_color)}{$node.content_s.bg_color}{/if}" />
										</div>
									</div>
								</div>
							</div>

						</div>
						<label class="control-label col-lg-3">
							{l s='Title border color if exist' mod='iqitmegamenu'}
						</label>
					<div class="col-lg-3 ">
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<div class="input-group">
											<input type="text" data-hex="true" class="title_borderc {if isset($node.elementId)}title_borderc-{$node.elementId}{/if}" value="{if isset($node.content_s.title_borderc)}{$node.content_s.title_borderc}{/if}" />
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>


					<div class="form-group">
						<label class="control-label col-lg-3">
							{l s='Title color' mod='iqitmegamenu'}
						</label>
					<div class="col-lg-3 ">
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<div class="input-group">
											<input type="text" data-hex="true" class="title_color {if isset($node.elementId)}title_color-{$node.elementId}{/if}" value="{if isset($node.content_s.title_color)}{$node.content_s.title_color}{/if}" />
										</div>
									</div>
								</div>
							</div>

						</div>

						<label class="control-label col-lg-3">
							{l s='Title hover color' mod='iqitmegamenu'}
						</label>
					<div class="col-lg-3 ">
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<div class="input-group">
											<input type="text" data-hex="true" class="title_colorh {if isset($node.elementId)}title_colorh-{$node.elementId}{/if}" value="{if isset($node.content_s.title_colorh)}{$node.content_s.title_colorh}{/if}" />
										</div>
									</div>
								</div>
							</div>

						</div>

					</div>

					<div class="form-group">
						<label class="control-label col-lg-3">
							{l s='Title legend backgrund color' mod='iqitmegamenu'}
						</label>
					<div class="col-lg-3 ">
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<div class="input-group">
											<input type="text" data-hex="true" class="legend_bg {if isset($node.elementId)}legend_bg-{$node.elementId}{/if}"	name="legend_bg" value="{if isset($node.content_s.legend_bg)}{$node.content_s.legend_bg}{/if}" />
										</div>
									</div>
								</div>
							</div>

						</div>

						<label class="control-label col-lg-3">
							{l s='Title legend text color' mod='iqitmegamenu'}
						</label>
					<div class="col-lg-3 ">
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<div class="input-group">
											<input type="text" data-hex="true" class="legend_txt {if isset($node.elementId)}legend_txt-{$node.elementId}{/if}"	name="legend_txt" value="{if isset($node.content_s.legend_txt)}{$node.content_s.legend_txt}{/if}" />
										</div>
									</div>
								</div>
							</div>

						</div>

					</div>

					<div class="form-group">
						<label class="control-label col-lg-3">
							{l s='Text color' mod='iqitmegamenu'}
						</label>
					<div class="col-lg-3 ">
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<div class="input-group">
											<input type="text" data-hex="true" class="txt_color {if isset($node.elementId)}txt_color-{$node.elementId}{/if}" value="{if isset($node.content_s.txt_color)}{$node.content_s.txt_color}{/if}" />
										</div>
									</div>
								</div>
							</div>

						</div>

						<label class="control-label col-lg-3">
							{l s='Text hover color' mod='iqitmegamenu'}
						</label>
					<div class="col-lg-3 ">
							<div class="form-group">
								<div class="col-lg-12">
									<div class="row">
										<div class="input-group">
											<input type="text" data-hex="true" class="txt_colorh {if isset($node.elementId)}txt_colorh-{$node.elementId}{/if}" value="{if isset($node.content_s.txt_colorh)}{$node.content_s.txt_colorh}{/if}" />
										</div>
									</div>
								</div>
							</div>

						</div>

					</div>



					<div class="form-group">
						<label class="control-label col-lg-3">
							{l s='Border top' mod='iqitmegamenu'}
						</label>
					<div class="col-lg-9 ">
							<div class="form-group">
									<div class="row">
										<div class="col-xs-6">
											<select name="br_top_st" class="br_top_st">
												<option value="5" {if isset($node.content_s.br_top_st) && $node.content_s.br_top_st==5}selected{/if}>{l s='groove' mod='iqitmegamenu'}</option>
												<option value="4" {if isset($node.content_s.br_top_st) && $node.content_s.br_top_st==4}selected{/if}>{l s='double' mod='iqitmegamenu'}</option>
												<option value="3" {if isset($node.content_s.br_top_st) && $node.content_s.br_top_st==3}selected{/if}>{l s='dotted' mod='iqitmegamenu'}</option>
												<option value="2" {if isset($node.content_s.br_top_st) && $node.content_s.br_top_st==2}selected{/if}>{l s='dashed' mod='iqitmegamenu'}</option>
												<option value="1" {if isset($node.content_s.br_top_st) && $node.content_s.br_top_st==1}selected{/if}>{l s='solid' mod='iqitmegamenu'}</option>
												<option value="0" {if isset($node.content_s.br_top_st)}{if $node.content_s.br_top_st==0}selected{/if}{else}selected{/if}>{l s='none' mod='iqitmegamenu'}</option>
											</select>
										</div>
										<div class="col-xs-3">
											<select name="br_top_wh" class="br_top_wh">
												{for $i=1 to 10}
												<option value="{$i}" {if isset($node.content_s.br_top_wh)}{if $i==$node.content_s.br_top_wh}selected{/if}{else}{if $i==1}selected{/if}{/if}>{$i}px</option>
												{/for}
											</select>

										</div>

										<div class="col-xs-3">
											<div class="form-group">
												<div class="col-xs-12">
													<div class="row">
														<div class="input-group">
															<input type="text" data-hex="true" class="br_top_c {if isset($node.elementId)}br_top_c-{$node.elementId}{/if}" value="{if isset($node.content_s.br_top_c)}{$node.content_s.br_top_c}{/if}" />
														</div>
													</div>
												</div>
											</div>

										</div>


									</div>

							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-3">
							{l s='Border right' mod='iqitmegamenu'}
						</label>
					<div class="col-lg-9 ">
							<div class="form-group">
									<div class="row">
										<div class="col-xs-6">
											<select name="br_right_st" class="br_right_st">
												<option value="5" {if isset($node.content_s.br_right_st) && $node.content_s.br_right_st==5}selected{/if}>{l s='groove' mod='iqitmegamenu'}</option>
												<option value="4" {if isset($node.content_s.br_right_st) && $node.content_s.br_right_st==4}selected{/if}>{l s='double' mod='iqitmegamenu'}</option>
												<option value="3" {if isset($node.content_s.br_right_st) && $node.content_s.br_right_st==3}selected{/if}>{l s='dotted' mod='iqitmegamenu'}</option>
												<option value="2" {if isset($node.content_s.br_right_st) && $node.content_s.br_right_st==2}selected{/if}>{l s='dashed' mod='iqitmegamenu'}</option>
												<option value="1" {if isset($node.content_s.br_right_st) && $node.content_s.br_right_st==1}selected{/if}>{l s='solid' mod='iqitmegamenu'}</option>
												<option value="0" {if isset($node.content_s.br_right_st)}{if $node.content_s.br_right_st==0}selected{/if}{else}selected{/if}>{l s='none' mod='iqitmegamenu'}</option>
											</select>
										</div>
										<div class="col-xs-3">
											<select name="br_right_wh" class="br_right_wh">
												{for $i=1 to 10}
												<option value="{$i}" {if isset($node.content_s.br_right_wh)}{if $i==$node.content_s.br_right_wh}selected{/if}{else}{if $i==1}selected{/if}{/if}>{$i}px</option>
												{/for}
											</select>

										</div>

										<div class="col-xs-3">
											<div class="form-group">
												<div class="col-xs-12">
													<div class="row">
														<div class="input-group">
															<input type="text" data-hex="true" class="br_right_c {if isset($node.elementId)}br_right_c-{$node.elementId}{/if}" value="{if isset($node.content_s.br_right_c)}{$node.content_s.br_right_c}{/if}" />
														</div>
													</div>
												</div>
											</div>

										</div>

									</div>

							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-3">
							{l s='Border bottom' mod='iqitmegamenu'}
						</label>
					<div class="col-lg-9 ">
							<div class="form-group">
									<div class="row">
										<div class="col-xs-6">
											<select name="br_bottom_st" class="br_bottom_st">
												<option value="5" {if isset($node.content_s.br_bottom_st) && $node.content_s.br_bottom_st==5}selected{/if}>{l s='groove' mod='iqitmegamenu'}</option>
												<option value="4" {if isset($node.content_s.br_bottom_st) && $node.content_s.br_bottom_st==4}selected{/if}>{l s='double' mod='iqitmegamenu'}</option>
												<option value="3" {if isset($node.content_s.br_bottom_st) && $node.content_s.br_bottom_st==3}selected{/if}>{l s='dotted' mod='iqitmegamenu'}</option>
												<option value="2" {if isset($node.content_s.br_bottom_st) && $node.content_s.br_bottom_st==2}selected{/if}>{l s='dashed' mod='iqitmegamenu'}</option>
												<option value="1" {if isset($node.content_s.br_bottom_st) && $node.content_s.br_bottom_st==1}selected{/if}>{l s='solid' mod='iqitmegamenu'}</option>
												<option value="0" {if isset($node.content_s.br_bottom_st)}{if $node.content_s.br_bottom_st==0}selected{/if}{else}selected{/if}>{l s='none' mod='iqitmegamenu'}</option>
											</select>
										</div>
										<div class="col-xs-3">
											<select name="br_bottom_wh" class="br_bottom_wh">
												{for $i=1 to 10}
												<option value="{$i}" {if isset($node.content_s.br_bottom_wh)}{if $i==$node.content_s.br_bottom_wh}selected{/if}{else}{if $i==1}selected{/if}{/if}>{$i}px</option>
												{/for}
											</select>

										</div>

										<div class="col-xs-3">
											<div class="form-group">
												<div class="col-xs-12">
													<div class="row">
														<div class="input-group">
															<input type="text" data-hex="true" class="br_bottom_c {if isset($node.elementId)}br_bottom_c-{$node.elementId}{/if}" value="{if isset($node.content_s.br_bottom_c)}{$node.content_s.br_bottom_c}{/if}" />
														</div>
													</div>
												</div>
											</div>

										</div>
									</div>

							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-3">
							{l s='Border left' mod='iqitmegamenu'}
						</label>
					<div class="col-lg-9 ">
							<div class="form-group">
									<div class="row">
										<div class="col-xs-6">
											<select name="br_left_st" class="br_left_st">
												<option value="5" {if isset($node.content_s.br_left_st) && $node.content_s.br_left_st==5}selected{/if}>{l s='groove' mod='iqitmegamenu'}</option>
												<option value="4" {if isset($node.content_s.br_left_st) && $node.content_s.br_left_st==4}selected{/if}>{l s='double' mod='iqitmegamenu'}</option>
												<option value="3" {if isset($node.content_s.br_left_st) && $node.content_s.br_left_st==3}selected{/if}>{l s='dotted' mod='iqitmegamenu'}</option>
												<option value="2" {if isset($node.content_s.br_left_st) && $node.content_s.br_left_st==2}selected{/if}>{l s='dashed' mod='iqitmegamenu'}</option>
												<option value="1" {if isset($node.content_s.br_left_st) && $node.content_s.br_left_st==1}selected{/if}>{l s='solid' mod='iqitmegamenu'}</option>
												<option value="0" {if isset($node.content_s.br_left_st)}{if $node.content_s.br_left_st==0}selected{/if}{else}selected{/if}>{l s='none' mod='iqitmegamenu'}</option>
											</select>
										</div>
										<div class="col-xs-3">
											<select name="br_left_wh" class="br_left_wh">
												{for $i=1 to 10}
												<option value="{$i}" {if isset($node.content_s.br_left_wh)}{if $i==$node.content_s.br_left_wh}selected{/if}{else}{if $i==1}selected{/if}{/if}>{$i}px</option>
												{/for}
											</select>

										</div>

										<div class="col-xs-3">
											<div class="form-group">
												<div class="col-xs-12">
													<div class="row">
														<div class="input-group">
															<input type="text" data-hex="true" class="br_left_c {if isset($node.elementId)}br_left_c-{$node.elementId}{/if}" value="{if isset($node.content_s.br_left_c)}{$node.content_s.br_left_c}{/if}" />
														</div>
													</div>
												</div>
											</div>

										</div>
									</div>

							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3">
							{l s='Padding' mod='iqitmegamenu'}
						</label>
					<div class="col-lg-9 ">
					<div class="column-checkbox"><input type="checkbox" class="c-padding-top" value="1" {if isset($node.content_s.c_p_t) && $node.content_s.c_p_t==1}checked{/if}> {l s='Top' mod='iqitmegamenu'} </div>
					<div class="column-checkbox"><input type="checkbox" class="c-padding-right" value="1" {if isset($node.content_s.c_p_r) && $node.content_s.c_p_r==1}checked{/if} > {l s='Right' mod='iqitmegamenu'} </div>
					<div class="column-checkbox"><input type="checkbox" class="c-padding-bottom" value="1" {if isset($node.content_s.c_p_b) && $node.content_s.c_p_b==1}checked{/if}> {l s='Bottom' mod='iqitmegamenu'} </div>
					<div class="column-checkbox"><input type="checkbox" class="c-padding-left" value="1" {if isset($node.content_s.c_p_l) && $node.content_s.c_p_l==1}checked{/if}> {l s='Left' mod='iqitmegamenu'} </div>
					<p class="help-block">
								{l s='If you enabled borders or custom background color it maybe needed to add padding for better effect' mod='iqitmegamenu'}
					</p>
					</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-3">
							{l s='Negative margin' mod='iqitmegamenu'}
						</label>
					<div class="col-lg-9 ">
					<div class="column-checkbox"><input type="checkbox" class="c-margin-top" value="1" {if isset($node.content_s.c_m_t) && $node.content_s.c_m_t==1}checked{/if}> {l s='Top' mod='iqitmegamenu'} </div>
					<div class="column-checkbox"><input type="checkbox" class="c-margin-right" value="1" {if isset($node.content_s.c_m_r) && $node.content_s.c_m_r==1}checked{/if}> {l s='Right' mod='iqitmegamenu'} </div>
					<div class="column-checkbox"><input type="checkbox" class="c-margin-left" value="1" {if isset($node.content_s.c_m_l) && $node.content_s.c_m_l==1}checked{/if}> {l s='Left' mod='iqitmegamenu'} </div>
					<p class="help-block">
								{l s='If you enabled padding, it maybe needed to add negative margin. For example you added background and padding only in one column from a row and you want to position title on the same height as other blocks, you have to add top negative margin.' mod='iqitmegamenu'}
					</p>
					</div>
					</div>



					</div>


					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">{l s='Save' mod='iqitmegamenu'}</button>
					</div>
				</div>
			</div>
		</div>



	</div>



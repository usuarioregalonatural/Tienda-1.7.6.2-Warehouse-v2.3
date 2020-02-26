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

{if isset($params.type)}
	{if $params.type == 'text'}
		{if isset($params.lang) && $params.lang == true}
			<div style="overflow:hidden">
				<label for="{$params.name|escape:'quotes':'UTF-8'}">{$params.label|escape:'quotes':'UTF-8'}</label>
				<div class="margin-form">
					<div style="float:left">
						{foreach $languages as $language}
							<div>
								<input type="text" name="{$params.name|escape:'quotes':'UTF-8'}_{$language['id_lang']|escape:'quotes':'UTF-8'}" id="{$params.name|escape:'quotes':'UTF-8'}_{$language['id_lang']|escape:'quotes':'UTF-8'}" value="{$fields_value[$params.name|escape:'quotes':'UTF-8'][$language['id_lang']]|escape:'quotes':'UTF-8'}" />
								<img src="{$THEME_LANG_DIR|escape:'quotes':'UTF-8'}{$language['id_lang']|escape:'quotes':'UTF-8'}.jpg" alt="{$language['iso_code']|escape:'quotes':'UTF-8'}" title="{$language['name']|escape:'quotes':'UTF-8'}" />
							</div>
						{/foreach}
					</div>
					{if isset($params.desc) && $params.desc}<p style="clear: both;">{$params.desc|escape:'quotes':'UTF-8'}</p>
					{elseif isset($params.hint) && $params.hint}<p style="clear: both;">{$params.hint|escape:'quotes':'UTF-8'}</p>
					{/if}
				</div>
			</div>
			<br />
		{else}
			<div style="overflow:hidden">
				<label for="{$params.name|escape:'quotes':'UTF-8'}">{$params.label|escape:'quotes':'UTF-8'}</label>
				<div class="margin-form">
					<input type="text" name="{$params.name|escape:'quotes':'UTF-8'}" id="{$params.name|escape:'quotes':'UTF-8'}" value="{$fields_value[$params.name|escape:'quotes':'UTF-8']|escape:'quotes':'UTF-8'}" />
					{if isset($params.desc) && $params.desc}<p style="clear: both;">{$params.desc|escape:'quotes':'UTF-8'}</p>
					{elseif isset($params.hint) && $params.hint}<p style="clear: both;">{$params.hint|escape:'quotes':'UTF-8'}</p>
					{/if}
				</div>
			</div>
			<br />
		{/if}
	{elseif $params.type == 'switch' || $params.type == 'radio'}
		<div style="overflow:hidden">
			<label for="{$params.name|escape:'quotes':'UTF-8'}">{$params.label|escape:'quotes':'UTF-8'}</label>
			<div class="margin-form">
				{foreach $params.values as $value}
					<input type="radio" name="{$params.name|escape:'quotes':'UTF-8'}" id="{$value.id|intval}" value="{$value.value|escape:'quotes':'UTF-8'}"
							{if $fields_value[$params.name] == $value.value}checked="checked"{/if}
							{if isset($params.disabled) && $params.disabled}disabled="disabled"{/if} />
					<label class="{if isset($params.class)}{$params.class|escape:'quotes':'UTF-8'}{/if}" for="{$value.id|intval}">
					 {if isset($params.is_bool) && $params.is_bool == true}
						{if $value.value == 1}
							<img src="../img/admin/enabled.gif" alt="{$value.label|escape:'quotes':'UTF-8'}" title="{$value.label|escape:'quotes':'UTF-8'}" />
						{else}
							<img src="../img/admin/disabled.gif" alt="{$value.label|escape:'quotes':'UTF-8'}" title="{$value.label|escape:'quotes':'UTF-8'}" />
						{/if}
					 {else}
						{$value.label|escape:'quotes':'UTF-8'}
					 {/if}
					</label>
					{if isset($params.br) && $params.br}<br />{/if}
					{if isset($value.p) && $value.p}<p>{$value.p|escape:'quotes':'UTF-8'}</p>{/if}
				{/foreach}
			</div>
		</div>
		<br />
	{elseif $params.type == 'submit'}
		<div style="overflow:hidden">
			<center>
				<input class="button" type="submit" name="{if isset($params.name)}{$params.name|escape:'quotes':'UTF-8'}{else}btnSubmit{/if}" />
			</center>
		</div>
	{elseif $params.type == 'select'}
		<div style="overflow:hidden">
			<label for="{$params.name|escape:'quotes':'UTF-8'}">{$params.label|escape:'quotes':'UTF-8'}</label>
			<div class="margin-form">
				{assign var=index value=$params.options.id}
				{assign var=value value=$params.options.name}
				<select name="{$params.name|escape:'quotes':'UTF-8'}">
				{foreach $params.options.query as $option}
					<option value="{$option.$index|escape:'quotes':'UTF-8'}" {if ($fields_value[$params.name] == $option.$index) || ($fields_value[$params.name] == '' && isset($params.default_value) && $params.default_value == $option.$index)}selected{/if}>{$option.$value|escape:'quotes':'UTF-8'}</option>
				{/foreach}
				</select>
			</div>
		</div>
		<br />
	{elseif $params.type == 'file'}
		<div style="overflow:hidden">
			<label for="{$params.name|escape:'quotes':'UTF-8'}">{$params.label|escape:'quotes':'UTF-8'}</label>
			<div class="margin-form">
				<input type="file" name="{$params.name|escape:'quotes':'UTF-8'}" />
			</div>
		</div>
		<br />
	{elseif $params.type == 'checkbox'}
		<div style="overflow:hidden">
			<label for="{$params.name|escape:'quotes':'UTF-8'}">{$params.label|escape:'quotes':'UTF-8'}</label>
			<div class="margin-form">
				{assign var=index value=$params.values.id}
				{assign var=name value=$params.values.name}
				{foreach $params.values.query as $option}
					<input type="checkbox" style="margin-bottom: 8px;" name="{$params.name|escape:'quotes':'UTF-8'}_{$option.$index|escape:'quotes':'UTF-8'}" id="{$params.name|escape:'quotes':'UTF-8'}_{$option.$index|escape:'quotes':'UTF-8'}" value="{$option.val|escape:'quotes':'UTF-8'}" {if isset($fields_value[$params.name|escape:'quotes':'UTF-8'|cat:_|cat:$option.$index|escape:'quotes':'UTF-8']) && $fields_value[$params.name|escape:'quotes':'UTF-8'|cat:_|cat:$option.$index|escape:'quotes':'UTF-8'] == 'on'}checked="checked"{/if}><label class="t" style="color: black; margin-left: 5px; vertical-align: top;" for="$params.name|escape:'quotes':'UTF-8'}_{$option.$index|escape:'quotes':'UTF-8'}">{$option.name|escape:'quotes':'UTF-8'}</label></option>
					<br />
				{/foreach}
			</div>
		</div>
		<br />
	{elseif $params.type == 'color'}
		<div style="overflow:hidden">
			<label for="{$params.name|escape:'quotes':'UTF-8'}">{$params.label|escape:'quotes':'UTF-8'}</label>
			<div class="margin-form">
				<input type="text" name="{$params.name|escape:'quotes':'UTF-8'}" value="{$fields_value[$params.name|escape:'quotes':'UTF-8']|escape:'quotes':'UTF-8'}" />
			</div>
		</div>
		<br />
	{elseif $params.type == 'textarea'}
		{if isset($params.lang) && $params.lang == true}
		<div style="overflow:hidden">
			<label for="{$params.name|escape:'quotes':'UTF-8'}">{$params.label|escape:'quotes':'UTF-8'}</label>
			<div class="margin-form">
				{foreach $languages as $language}
				<div class="lang_{$language['id_lang']|escape:'quotes':'UTF-8'}">
					<textarea {if $params.class == 'rte'}class="rte"{/if} name="{$params.name|escape:'quotes':'UTF-8'}_{$language['id_lang']|escape:'quotes':'UTF-8'}" id="{$params.name|escape:'quotes':'UTF-8'}[{$language['id_lang']|escape:'quotes':'UTF-8'}]" cols="{$params.cols|escape:'quotes':'UTF-8'}" rows="{$params.rows|escape:'quotes':'UTF-8'}">{$fields_value[$params.name|escape:'quotes':'UTF-8'][$language['id_lang']]|escape:'quotes':'UTF-8'}</textarea>
					<img src="{$THEME_LANG_DIR|escape:'quotes':'UTF-8'}{$language['id_lang']|escape:'quotes':'UTF-8'}.jpg" alt="{$language['iso_code']|escape:'quotes':'UTF-8'}" title="{$language['name']|escape:'quotes':'UTF-8'}" onclick="toggleLanguageFlags(this);" alt="" />
				</div>
				{/foreach}
			</div>
		</div>
		<br />
		{else}
		<div style="overflow:hidden">
			<label for="{$params.name|escape:'quotes':'UTF-8'}">{$params.label|escape:'quotes':'UTF-8'}</label>
			<div class="margin-form">
				<textarea name="{$params.name|escape:'quotes':'UTF-8'}" id="{$params.name|escape:'quotes':'UTF-8'}" cols="{$params.cols|escape:'quotes':'UTF-8'}" rows="{$params.rows|escape:'quotes':'UTF-8'}">{$fields_value[$params.name|escape:'quotes':'UTF-8']|escape:'quotes':'UTF-8'}</textarea>
				{if isset($params.desc) && $params.desc}<p style="clear: both;">{$params.desc|escape:'quotes':'UTF-8'}</p>
				{elseif isset($params.hint) && $params.hint}<p style="clear: both;">{$params.hint|escape:'quotes':'UTF-8'}</p>
				{/if}
			</div>
		</div>
		<br />
		{/if}
	{elseif $params.type == 'free'}
		<label for="{$params.name|escape:'quotes':'UTF-8'}">{$params.label|escape:'quotes':'UTF-8'}</label>
		{if $fields_value[$params.name]}{$fields_value[{$params.name nofilter}] nofilter}{/if}
	{elseif $params.type == 'html'}
		{if isset($params.label) && $params.label}<label for="{$params.name|escape:'quotes':'UTF-8'}">{$params.label|escape:'quotes':'UTF-8'}</label>{/if}
		<div class="margin-form">
			{if isset($params.html_content)}{$params.html_content nofilter}{elseif isset($params.name)}{$params.name nofilter}{/if}
		</div>
	{/if}
{/if}
{*
* 2017 IQIT-COMMERCE.COM
*
* NOTICE OF LICENSE
*
* This file is licenced under the Software License Agreement.
* With the purchase or the installation of the software in your application
* you accept the licence agreement
*
* @author    IQIT-COMMERCE.COM <support@iqit-commerce.com>
* @copyright 2017 IQIT-COMMERCE.COM
* @license   Commercial license (You can not resell or redistribute this software.)
*
*}

{extends file="helpers/form/form.tpl"}

{block name="input"}

	{if $input.type == 'separator'}
		<hr>
	{elseif $input.type == 'info'}
		<div class="alert alert-info">
			<h4>{l s='How to config' mod='iqitsociallogin'} {$input.infoTitle} {l s='login' mod='iqitsociallogin'}</h4>
			{l s='Check documentation' mod='iqitsociallogin'}: <a href="{$input.info}" target="_blank">{$input.info}</a>
		</div>
	{else}
		{$smarty.block.parent}
    {/if}
{/block}




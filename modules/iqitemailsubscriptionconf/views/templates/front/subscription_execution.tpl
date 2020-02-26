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


{extends file='page.tpl'}
 
{block name="page_content"}
	<h1 class="h1 page-title"><span>{l s='Newsletter subscription' mod='iqitemailsubscriptionconf'}</span></h1>
	{widget_block name="ps_emailsubscription"}

		{if $msg}
			<p class="alert {if $nw_error}alert-danger{else}alert-success{/if}">
				{$msg}
			</p>
		{/if}

		{if $conditions}
			<p>{$conditions}</p>
		{/if}

	{/widget_block}
{/block}


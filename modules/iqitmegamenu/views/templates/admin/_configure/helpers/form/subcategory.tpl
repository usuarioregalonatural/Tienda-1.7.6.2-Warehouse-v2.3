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


{foreach $categories as $category}
	<option value="{$category.id}" {if isset($ids) && $type == 2 && in_array($category.id, $ids)}selected{/if} > {$category.name}</option>
	{if isset($category.children)}

		{if isset($ids) && $type == 2}
			{include file="./subcategory.tpl" categories=$category.children ids=$ids type=$type}
		{else}
			{include file="./subcategory.tpl" categories=$category.children}
		{/if}
	{/if}
{/foreach}

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

<ul class="{if $level==1}cbp-links cbp-category-tree{elseif $level==2}cbp-hrsub-level2{elseif $level==3}cbp-hrsub-level2 cbp-hrsub-level3{/if}">
{foreach $categories as $category}
	{if isset($category.title)}<li  {if isset($category.children)} class="{if $level==1}cbp-hrsub-haslevel2{else}cbp-hrsub-haslevel3{/if}" {/if} >
	<div class="cbp-category-link-w">
	<a href="{$category.href}">{$category.title}</a>
	{if isset($category.children)}
			{include file="./front_subcategory.tpl" categories=$category.children level=$level+1}
	{/if}
	</div>
	</li>
	{/if}
{/foreach}
</ul>

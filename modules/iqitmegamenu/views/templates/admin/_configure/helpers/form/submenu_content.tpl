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


	{if $node.type==1}
	<div data-element-type="1" data-depth="{$node.depth}" data-element-id="{$node.elementId}" class="row menu_row menu-element {if $node.depth==0} first_rows{/if} menu-element-id-{$node.elementId}">
		{elseif $node.type==2}
		<div data-element-type="2" data-depth="{$node.depth}" data-width="{$node.width}" data-contenttype="{$node.contentType}" data-element-id="{$node.elementId}" class="col-xs-{$node.width} menu_column menu-element menu-element-id-{$node.elementId}">
			{/if}

			<div class="action-buttons-container">
				<button type="button" class="btn btn-default  add-row-action" ><i class="icon icon-plus"></i> {l s='Row' mod='iqitmegamenu'}</button>
				<button type="button" class="btn btn-default  add-column-action" ><i class="icon icon-plus"></i> {l s='Column' mod='iqitmegamenu'}</button>
				<button type="button" class="btn btn-default duplicate-element-action" ><i class="icon icon-files-o"></i> </button>
				<button type="button" class="btn btn-danger remove-element-action" ><i class="icon-trash"></i> </button>
			</div>
			<div class="dragger-handle btn btn-danger"><i class="icon-arrows "></i></a></div>

			{if $node.type==2}
				{include file="./column_content.tpl" node=$node}
			{/if}

			{if isset($node.children) && $node.children|@count > 0}
			{foreach from=$node.children item=child name=categoryTreeBranch}
			{include file="./submenu_content.tpl" node=$child }
			{/foreach}
			{/if}
		</div>

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

<div class="panel"><h3><i class="icon-list-ul"></i> {if $menu_type==1}{l s='Horizontal tabs list' mod='iqitmegamenu'}{elseif $menu_type==2}{l s='Vertical tabs list' mod='iqitmegamenu'}{elseif $menu_type==3}{l s='Predefinied submenu tabs' mod='iqitmegamenu'}{/if}
	<span class="panel-heading-action">
		<a id="desc-product-new" class="list-toolbar-btn" href="{$link->getAdminLink('AdminModules')}&configure=iqitmegamenu&addTab=1&menu_type={$menu_type}">
			<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Add new" data-html="true">
				<i class="process-icon-new "></i>
			</span>
		</a>
	</span>
	</h3>
	<div id="tabsContent">
		<div id="tabs{$menu_type}">
			{foreach from=$tabs item=tab}
				<div id="tabs_{$tab.id_tab}" class="panel" style="padding: 10px 10px 0px 10px;">
					<div class="row">
						<div class="col-lg-1">
							<span><i class="icon-arrows "></i></span>
						</div>
						<div class="col-md-11">
							<h4 class="pull-left">#{$tab.id_tab} - {$tab.title}</h4>
							<div class="btn-group-action pull-right">
								<a class="btn btn-default"
									href="{$link->getAdminLink('AdminModules')}&configure=iqitmegamenu&duplicateTabC={$tab.id_tab}">
									<i class="icon-edit"></i>
									{l s='Duplicate' mod='iqitmegamenu'}
								</a>
								<a class="btn btn-default"
									href="{$link->getAdminLink('AdminModules')}&configure=iqitmegamenu&id_tab={$tab.id_tab}&menu_type={$menu_type}">
									<i class="icon-edit"></i>
									{l s='Edit' mod='iqitmegamenu'}
								</a>
								<a class="btn btn-default"
									href="{$link->getAdminLink('AdminModules')}&configure=iqitmegamenu&delete_id_tab={$tab.id_tab}">
									<i class="icon-trash"></i>
									{l s='Delete' mod='iqitmegamenu'}
								</a>
							</div>
						</div>
					</div>
				</div>
			{/foreach}
		</div>
	</div>
</div>

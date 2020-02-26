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

<nav id="cbp-hrmenu1" class="cbp-hrmenu  iqitmegamenu-all cbp-vertical {if !isset($ontop)}cbp-not-on-top{/if}">
	<div class="cbp-vertical-title"><i class="fa fa-bars cbp-iconbars"></i> <span class="cbp-vertical-title-text">{l s='Navigation' mod='iqitmegamenu'}</span></div>
					<ul id="cbp-hrmenu1-ul">
						{foreach $vertical_menu as $tab}
						<li id="cbp-hrmenu-tab-{$tab.id_tab}" class="cbp-hrmenu-tab cbp-hrmenu-tab-{$tab.id_tab} {if $tab.active_label} cbp-onlyicon{/if}{if $tab.float} pull-right cbp-pulled-right{/if}">
	{if $tab.url_type == 2}<a role="button" class="cbp-empty-mlink">{else}<a href="{$tab.url}" onclick="" {if $tab.new_window}target="_blank" rel="noopener noreferrer"{/if}>{/if}
								{if $tab.icon_type && !empty($tab.icon_class)} <i class="fa fa {$tab.icon_class} cbp-mainlink-icon"></i>{/if}
								{if !$tab.icon_type && !empty($tab.icon)} <img src="{$tab.icon}" alt="{$tab.title}" class="cbp-mainlink-iicon" />{/if}
								{if !$tab.active_label}<span>{$tab.title|replace:'/n':'<br />' nofilter}</span>{/if}{if $tab.submenu_type} <i class="fa fa-angle-right cbp-submenu-aindicator"></i>{/if}
								{if !empty($tab.label)}<span class="label cbp-legend cbp-legend-vertical cbp-legend-main">{if !empty($tab.legend_icon)} <i class="fa fa {$tab.legend_icon} cbp-legend-icon"></i>{/if} {$tab.label}
								<span class="cbp-legend-arrow"></span></span>{/if}
						</a>
							{if $tab.submenu_type && !empty($tab.submenu_content)}
							<div class="cbp-hrsub-wrapper">
							<div class="cbp-hrsub col-{$tab.submenu_width}">
								<div class="cbp-hrsub-inner">

									{if $tab.submenu_type==1}
									<div class="cbp-tabs-container">
									<div class="row no-gutters">
										<div class="tabs-links col-2">
										<ul class="cbp-hrsub-tabs-names cbp-tabs-names">
											{if isset($tab.submenu_content_tabs)}
											{foreach $tab.submenu_content_tabs as $innertab name=innertabsnames}
											<li class="innertab-{$innertab->id} {if $smarty.foreach.innertabsnames.first}active{/if}"><a data-target="#iq-{$innertab->id}-innertab-{$tab.id_tab}" {if $innertab->url_type != 2} href="{$innertab->url}" {/if}>
												{if $innertab->icon_type && !empty($innertab->icon_class)} <i class="fa fa {$innertab->icon_class} cbp-mainlink-icon"></i>{/if}
												{if !$innertab->icon_type && !empty($innertab->icon)} <img src="{$innertab->icon}" alt="{$innertab->title}" class="cbp-mainlink-iicon" />{/if}
												{$innertab->title}
												{if !empty($innertab->label)}<span class="label cbp-legend cbp-legend-inner">{if !empty($innertab->legend_icon)} <i class="fa fa {$innertab->legend_icon} cbp-legend-icon"></i>{/if} {$innertab->label}
												<span class="cbp-legend-arrow"></span></span>{/if}
													<i class="fa fa-angle-right cbp-submenu-it-indicator"></i></a><span class="cbp-inner-border-hider"></span></li>
											{/foreach}
											{/if}
										</ul>
									</div>

											{if isset($tab.submenu_content_tabs)}
												<div class="tab-content col-10">
											{foreach $tab.submenu_content_tabs as $innertab name=innertabscontent}
											<div role="tabpanel" class="tab-pane cbp-tab-pane {if $smarty.foreach.innertabscontent.first}active{/if} innertabcontent-{$innertab->id}"  id="iq-{$innertab->id}-innertab-{$tab.id_tab}">

												{if !empty($innertab->submenu_content)}
												<div class="clearfix">
												{foreach $innertab->submenu_content as $element}
													{include file="module:iqitmegamenu/views/templates/hook/_partials/submenu_content.tpl" node=$element}
												{/foreach}
												</div>
												{/if}

											</div>
											{/foreach}
												</div>
											{/if}
									</div></div>
									{else}

										{if !empty($tab.submenu_content)}
											{foreach $tab.submenu_content as $element}
												{include file="module:iqitmegamenu/views/templates/hook/_partials/submenu_content.tpl" node=$element}
											{/foreach}
										{/if}

									{/if}

								</div>
							</div></div>
							{/if}
						</li>
						{/foreach}
					</ul>
				</nav>

{if isset($mobile_menu_v)}
<div id="_desktop_iqitmegamenu-mobile">
	<ul id="iqitmegamenu-mobile">
		{include file="module:iqitmegamenu/views/templates/hook/_partials/mobile_menu.tpl" menu=$mobile_menu_v}
	</ul>
</div>
{/if}
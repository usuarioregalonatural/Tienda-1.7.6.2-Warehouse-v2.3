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
	<div id="iqitmegamenu-wrapper" class="iqitmegamenu-wrapper iqitmegamenu-all">
		<div class="container container-iqitmegamenu">
		<div id="iqitmegamenu-horizontal" class="iqitmegamenu  clearfix" role="navigation">

				{if isset($menu_settings_v) && $menu_settings_v.ver_position == 2 }

					<div class="cbp-vertical-on-top">
						{include file="module:iqitmegamenu/views/templates/hook/vertical.tpl" ontop=1}
					</div>
				{/if}
				{hook h='displayAfterIqitMegamenu'}
				<nav id="cbp-hrmenu" class="cbp-hrmenu cbp-horizontal cbp-hrsub-narrow">
					<ul>
						{foreach $horizontal_menu as $tab}
						<li id="cbp-hrmenu-tab-{$tab.id_tab}" class="cbp-hrmenu-tab cbp-hrmenu-tab-{$tab.id_tab}{if $tab.active_label} cbp-onlyicon{/if}{if $tab.float} pull-right cbp-pulled-right{/if} {if $tab.submenu_type && !empty($tab.submenu_content)} cbp-has-submeu{/if}">
	{if $tab.url_type == 2}<a role="button" class="cbp-empty-mlink nav-link">{else}<a href="{$tab.url}" class="nav-link" {if $tab.new_window}target="_blank" rel="noopener noreferrer"{/if}>{/if}


								<span class="cbp-tab-title">{if $tab.icon_type && !empty($tab.icon_class)} <i class="icon fa {$tab.icon_class} cbp-mainlink-icon"></i>{/if}

								{if !$tab.icon_type && !empty($tab.icon)} <img src="{$tab.icon}" alt="{$tab.title}" class="cbp-mainlink-iicon" />{/if}{if !$tab.active_label}{$tab.title|replace:'/n':'<br />' nofilter}{/if}{if $tab.submenu_type} <i class="fa fa-angle-down cbp-submenu-aindicator"></i>{/if}</span>
								{if !empty($tab.label)}<span class="label cbp-legend cbp-legend-main">{if !empty($tab.legend_icon)} <i class="icon fa {$tab.legend_icon} cbp-legend-icon"></i>{/if} {$tab.label}
								</span>{/if}
						</a>
							{if $tab.submenu_type && !empty($tab.submenu_content)}
							<div class="cbp-hrsub col-{$tab.submenu_width}">
								<div class="cbp-hrsub-inner">
									<div class="container iqitmegamenu-submenu-container">
									{if $tab.submenu_type==1}
									<div class="cbp-tabs-container">
									<div class="row no-gutters">
									<div class="tabs-links col-2">
										<ul class="cbp-hrsub-tabs-names cbp-tabs-names" >
											{if isset($tab.submenu_content_tabs)}
											{foreach $tab.submenu_content_tabs as $innertab name=innertabsnames}
											<li class="innertab-{$innertab->id} ">
												<a data-target="#iq-{$innertab->id}-innertab-{$tab.id_tab}" {if $innertab->url_type != 2} href="{$innertab->url}" {/if} class="nav-link {if $smarty.foreach.innertabsnames.first}active{/if}">
												{if $innertab->icon_type && !empty($innertab->icon_class)} <i class="icon fa {$innertab->icon_class} cbp-mainlink-icon"></i>{/if}
												{if !$innertab->icon_type && !empty($innertab->icon)} <img src="{$innertab->icon}" alt="{$innertab->title}" class="cbp-mainlink-iicon" />{/if}
												{if !$innertab->active_label}{$innertab->title} {/if}
												{if !empty($innertab->label)}<span class="label cbp-legend cbp-legend-inner">{if !empty($innertab->legend_icon)} <i class="icon fa {$innertab->legend_icon} cbp-legend-icon"></i>{/if} {$innertab->label}
												</span>{/if}
													<i class="fa fa-angle-right cbp-submenu-it-indicator"></i></a><span class="cbp-inner-border-hider"></span></li>
											{/foreach}
											{/if}
										</ul>
									</div>

										{if isset($tab.submenu_content_tabs)}
										<div class="tab-content col-10">
											{foreach $tab.submenu_content_tabs as $innertab name=innertabscontent}
											<div class="tab-pane cbp-tab-pane {if $smarty.foreach.innertabscontent.first}active{/if} innertabcontent-{$innertab->id}"
												 id="iq-{$innertab->id}-innertab-{$tab.id_tab}" role="tabpanel">

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
								</div>
							</div>
							{/if}
						</li>
						{/foreach}
					</ul>
				</nav>
		</div>
		</div>
		<div id="sticky-cart-wrapper"></div>
	</div>

<div id="_desktop_iqitmegamenu-mobile">
	<ul id="iqitmegamenu-mobile">
		{include file="module:iqitmegamenu/views/templates/hook/_partials/mobile_menu.tpl" menu=$mobile_menu}
	</ul>
</div>

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

<div class="panel"><h3><i class="icon-list-ul"></i> {l s='Charts list' mod='iqitsizecharts'}
    <span class="panel-heading-action">
        <a id="desc-product-new" class="list-toolbar-btn" href="{$link->getAdminLink('AdminModules')}&configure={$module}&addIqitSizeChart=1">
            <span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="{l s='Add new' mod='iqitsizecharts'}" data-html="true">
                <i class="process-icon-new "></i>
            </span>
        </a>
    </span>
    </h3>
    <div id="chartsContent">
        <div id="iqitCharts">
            {foreach from=$charts item=chart}
                <div id="charts_{$chart.id_iqitsizechart}" class="panel">
                    <div class="row">
                        <div class="col-xs-12">
                            <h4 class="pull-left">
                                #{$chart.id_iqitsizechart} - {$chart.title}
                                {if $chart.is_shared}
                                    <div>
                                        <span class="label color_field pull-left" style="background-color:#108510;color:white;margin-top:5px;">
                                            {l s='Shared chart' mod='iqitsizecharts'}
                                        </span>
                                    </div>
                                {/if}
                            </h4>
                            <div class="btn-group-action pull-right">
                                <a class="btn btn-default"
                                    href="{$link->getAdminLink('AdminModules')}&configure={$module}&updateiqitsizecharts=1&id_iqitsizechart={$chart.id_iqitsizechart}">
                                    <i class="icon-edit"></i>
                                    {l s='Edit' mod='iqitsizecharts'}
                                </a>
                                <a class="btn btn-default"
                                    href="{$link->getAdminLink('AdminModules')}&configure={$module}&deleteiqitsizecharts=1&id_iqitsizechart={$chart.id_iqitsizechart}">
                                    <i class="icon-trash"></i>
                                    {l s='Delete' mod='iqitsizecharts'}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            {/foreach}
        </div>
    </div>
</div>

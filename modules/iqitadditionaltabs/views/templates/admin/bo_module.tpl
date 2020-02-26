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

<div class="panel"><h3><i class="icon-list-ul"></i> {l s='Tabs list' mod='iqitadditionaltabs'}
    <span class="panel-heading-action">
        <a id="desc-product-new" class="list-toolbar-btn" href="{$link->getAdminLink('AdminModules')}&configure={$module}&addIqitAdditionalTab=1">
            <span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="{l s='Add new' mod='iqitadditionaltabs'}" data-html="true">
                <i class="process-icon-new "></i>
            </span>
        </a>
    </span>
    </h3>
    <div id="tabsContent">
        <div id="tabs">
            {foreach from=$tabs item=tab}
                <div id="tabs_{$tab.id_iqitadditionaltab}" class="panel">
                    <div class="row">
                        <div class="col-xs-12">
                            <h4 class="pull-left">
                             <span><i class="icon-arrows"></i></span>
                                #{$tab.id_iqitadditionaltab} - {$tab.title}
                                {if $tab.is_shared}
                                    <div>
                                        <span class="label color_field pull-left" style="background-color:#108510;color:white;margin-top:5px;">
                                            {l s='Shared tab' mod='iqitadditionaltabs'}
                                        </span>
                                    </div>
                                {/if}
                            </h4>
                            <div class="btn-group-action pull-right">
                                {$tab.status}
                                <a class="btn btn-default"
                                    href="{$link->getAdminLink('AdminModules')}&configure={$module}&updateiqitadditionaltabs=1&id_iqitadditionaltab={$tab.id_iqitadditionaltab}">
                                    <i class="icon-edit"></i>
                                    {l s='Edit' mod='iqitadditionaltabs'}
                                </a>
                                <a class="btn btn-default"
                                    href="{$link->getAdminLink('AdminModules')}&configure={$module}&deleteiqitadditionaltabs=1&id_iqitadditionaltab={$tab.id_iqitadditionaltab}">
                                    <i class="icon-trash"></i>
                                    {l s='Delete' mod='iqitadditionaltabs'}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            {/foreach}
        </div>
    </div>
</div>

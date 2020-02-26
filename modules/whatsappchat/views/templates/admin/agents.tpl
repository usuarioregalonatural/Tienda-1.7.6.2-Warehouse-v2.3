{**
* NOTICE OF LICENSE
*
* This product is licensed for one customer to use on one installation (test stores and multishop included).
* Site developer has the right to modify this module to suit their needs, but can not redistribute the module in
* whole or in part. Any other use of this module constitues a violation of the user agreement.
*
* DISCLAIMER
*
* NO WARRANTIES OF DATA SAFETY OR MODULE SECURITY
* ARE EXPRESSED OR IMPLIED. USE THIS MODULE IN ACCORDANCE
* WITH YOUR MERCHANT AGREEMENT, KNOWING THAT VIOLATIONS OF
* PCI COMPLIANCY OR A DATA BREACH CAN COST THOUSANDS OF DOLLARS
* IN FINES AND DAMAGE A STORES REPUTATION. USE AT YOUR OWN RISK.
*
*  @author    idnovate.com <info@idnovate.com>
*  @copyright 2019 idnovate.com
*  @license   See above
*}
{if $agents !== false}
    {foreach key=key from=$agents item=agent}
        <div class="col-lg-4 col-md-6 col-xs-12">
            <a href="{$agent.edit|escape:'html':'UTF-8'}" class="whatsappchat-agents-content-agent">
                <div class="whatsappchat-agents-content-image{if !$agent.active} offline{/if}">
                    <img src="{$agents_img_dir|escape:'html':'UTF-8'}{$agent.image|escape:'html':'UTF-8'}" alt="{$agent.name|escape:'html':'UTF-8'} ({$agent.department|escape:'html':'UTF-8'})">
                </div>
                <div class="whatsappchat-agents-content-info whatsappchat-agents-content-info17">
                    <span class="whatsappchat-agents-content-department">{$agent.department|escape:'html':'UTF-8'}</span>
                    <span class="whatsappchat-agents-content-name whatsappchat-agents-content-name17">{$agent.name|escape:'html':'UTF-8'}</span>
                    <span class="whatsappchat-agents-content-phone"><i class="icon-phone"></i> {$agent.mobile_phone|escape:'html':'UTF-8'}</span>
                </div>
                <div class="clearfix" style="margin-top: 10px;">
                    <button class="btn btn-default" onclick="goChatAgent('{$agent.url|escape:'html':'UTF-8'}');return false;">
                        <i class="icon-whatsapp"></i> {l s='Chat' mod='whatsappchat'}
                    </button>
                    <button class="btn btn-default" onclick="goEditAgent('{$agent.edit|escape:'html':'UTF-8'}');return false;" style="float: right;margin-right: 5px;">
                        <i class="icon-edit"></i> {l s='Edit' mod='whatsappchat'}
                    </button>
                </div>
            </a>
        </div>
    {/foreach}
    <div class="col-lg-4 col-md-6 col-xs-12">
        <a href="{$agents_new_agent_url|escape:'html':'UTF-8'}" class="whatsappchat-agents-content-agent">
            <div class="whatsappchat-agents-content-image new">
                <img src="{$agents_img_default|escape:'html':'UTF-8'}" alt="{l s='Create a new agent' mod='whatsappchat'}">
            </div>
            <div class="whatsappchat-agents-content-info whatsappchat-agents-content-info17">
                <span class="whatsappchat-agents-content-name whatsappchat-agents-content-name17">{l s='Create a new agent' mod='whatsappchat'}</span>
            </div>
            <div class="clearfix"></div>
        </a>
    </div>
    <script>
        function goEditAgent(url) {
            window.location.href = url;

        }
        function goChatAgent(url) {
            window.open(url);
        }
    </script>
{/if}
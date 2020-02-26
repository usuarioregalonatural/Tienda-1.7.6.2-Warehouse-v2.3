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

{if ($custom_js != '' && $from_bo != '1')}
<script>
    {$custom_js nofilter}
</script>
{/if}
{if ($custom_css != '' && $from_bo != '1')}
<style id="whatsappchat_custom_css" type="text/css">
    {$custom_css nofilter}
</style>
{/if}
{if version_compare($smarty.const._PS_VERSION_,'1.5','<')}
    {literal}
    <script>
    $(document).ready(function() {
        $("a.whatsappchat-anchor").click(function(event) {
            event.preventDefault();
            window.open($(this).attr("href"), this.target);
        });
    });
    </script>
    {/literal}
{/if}
{if $agents !== false && $from_bo != '1' && $offline_message == ''}
    <script>
        {if ($whatsapp_action === 'quickview' || $whatsapp_action === 1)}
            $('.jBox-wrapper').each(function(){
                $(this).remove();
            });
            $('.whatsappchat-agents-container').last().remove();
            setAgentsBox();
            $('#whatsappchat-agents{$whatsappchat_id|escape:'html':'UTF-8'}{if ($whatsapp_action === 'quickview' || $whatsapp_action === 1)}quickview{/if}').click(function(){
                if ($('.jBox-wrapper').size() > 1) {
                    $('.jBox-wrapper').last().remove();
                }
            });
        {else}
            if (document.addEventListener) {
                window.addEventListener('load', setAgentsBox, false);
            } else {
                window.attachEvent('onload', setAgentsBox);
            }
        {/if}
        {literal}
        function setAgentsBox() {
            var test = new jBox('Tooltip', {
                attach: '#whatsappchat-agents{/literal}{$whatsappchat_id|escape:'html':'UTF-8'}{if ($whatsapp_action === 'quickview' || $whatsapp_action === 1)}quickview{/if}{literal}',
                position: {
                    x: 'center',
                    y: 'top'
                },
                content: $('.whatsappchat-agents-container{/literal}{$whatsappchat_id|escape:'html':'UTF-8'}{if ($whatsapp_action === 'quickview' || $whatsapp_action === 1)}quickview{/if}{literal}'),
                trigger: 'click',
                animation: {open: 'move', close: 'move'},
                closeButton: true,
                closeOnClick: true,
                closeOnEsc: true,
                adjustPosition: true,
                adjustTracker: true,
                adjustDistance: {top: 45, right: 5, bottom: 5, left: 5},
                zIndex: 8000,
                preventDefault: true
            });
        }
        {/literal}
    </script>
    <div class="whatsappchat-agents-container whatsappchat-agents-container{$whatsappchat_id|escape:'html':'UTF-8'}{if ($whatsapp_action === 'quickview' || $whatsapp_action === 1)}quickview{/if}" style="display: none;">
        <div class="whatsappchat-agents-title{if version_compare($smarty.const._PS_VERSION_,'1.7','>=')} whatsappchat-agents-title17{/if}" style="background-color: {$color|escape:'html':'UTF-8'}">{l s="Hi! Click one of our agents below and we will get back to you as soon as possible." mod='whatsappchat'}</div>
        <div class="whatsappchat-agents-content">
            {foreach $agents as $agent}
                <a href="{$agent.url|escape:'quotes'}" target="_blank" class="whatsappchat-agents-content-agent">
                    <div class="whatsappchat-agents-content-image">
                        <img src="{$agents_img_src|escape:'html':'UTF-8'}{$agent.image|escape:'html':'UTF-8'}">
                    </div>
                    <div class="whatsappchat-agents-content-info{if version_compare($smarty.const._PS_VERSION_,'1.7','>=')} whatsappchat-agents-content-info17{/if}">
                        <span class="whatsappchat-agents-content-department">{$agent.department|escape:'html':'UTF-8'}</span>
                        <span class="whatsappchat-agents-content-name{if version_compare($smarty.const._PS_VERSION_,'1.7','>=')} whatsappchat-agents-content-name17{/if}">{$agent.name|escape:'html':'UTF-8'}</span>
                    </div>
                    <div class="clearfix"></div>
                </a>
            {/foreach}
        </div>
    </div>
{/if}
{if $whatsapp_class != 'floating'}
    {if $open_chat && $from_bo != '1' && $offline_link != ''}<a class="whatsappchat-anchor whatsappchat-anchor{$whatsappchat_id|escape:'html':'UTF-8'}" href="{$offline_link|escape:'html':'UTF-8'}">{/if}
    {if $open_chat && $from_bo != '1' && $offline_message == ''}<a class="whatsappchat-anchor whatsappchat-anchor{$whatsappchat_id|escape:'html':'UTF-8'}" target="_blank" {if $agents !== false && $from_bo != '1' && version_compare($smarty.const._PS_VERSION_,'1.5','>=')}href="javascript:void(0);" {else}href="{$url|escape:'html':'UTF-8'}"{/if}>{/if}
        <div class="whatsapp whatsapp_{$whatsappchat_id|escape:'html':'UTF-8'} whatsapp-{if isset($from_bo) && $from_bo != '1'}{$whatsapp_class|escape:'html':'UTF-8'} {$position|escape:'html':'UTF-8'}{/if}{if $offline_message != '' && ($whatsapp_class == 'topWidth' || $whatsapp_class == 'bottomWidth')} whatsapp-offline{/if}"
            {if $color != '' && ($whatsapp_class == 'topWidth' || $whatsapp_class == 'bottomWidth') && $from_bo != '1'}style="background-color: {$color|escape:'html':'UTF-8'}"{/if}>
            <span {if $color != ''}style="background-color: {$color|escape:'html':'UTF-8'}"{/if}{if $offline_message != ''} class="whatsapp-offline"{/if}{if $agents !== false && $from_bo != '1'} id="whatsappchat-agents{$whatsappchat_id|escape:'html':'UTF-8'}{if ($whatsapp_action === 'quickview' || $whatsapp_action === 1)}quickview{/if}"{/if}>
                <i class="whatsapp-icon" {if $button_text == ''}style="padding-right:0px!important;"{/if}></i>
                {if $offline_message != ''}{$offline_message|escape:'html':'UTF-8'}{else}{$button_text|escape:'html':'UTF-8'}{/if}
            </span>
        </div>
    {if $open_chat && $from_bo != '1' && $offline_message == ''}</a>{/if}
    {if $open_chat && $from_bo != '1' && $offline_link != ''}</a>{/if}
{else}
    {if $open_chat && $from_bo != '1' && $offline_message == ''}
        <a{if $agents !== false && $from_bo != '1'} id="whatsappchat-agents{$whatsappchat_id|escape:'html':'UTF-8'}{if ($whatsapp_action === 'quickview' || $whatsapp_action === 1)}quickview{/if}"{/if} target="_blank" href="{$url|escape:'html':'UTF-8'}" class="float whatsapp_{$whatsappchat_id|escape:'html':'UTF-8'} float-{$position|escape:'html':'UTF-8'} float-{$whatsapp_class|escape:'html':'UTF-8'}{if $offline_message != ''} whatsapp-offline{/if}" style="background-color: {$color|escape:'html':'UTF-8'}">
    {/if}
    {if $open_chat && $from_bo != '1' && $offline_message != ''}
        <a class="float float-{$position|escape:'html':'UTF-8'} float-{$whatsapp_class|escape:'html':'UTF-8'}{if $offline_message != ''} whatsapp-offline{/if}" {if $offline_link != ''}href="{$offline_link|escape:'html':'UTF-8'}"{/if} style="background-color: {$color|escape:'html':'UTF-8'}">
    {/if}
    {if $from_bo == '1'}
        <a class="float float-floating floating-bo{if $offline_message != ''} whatsapp-offline{/if}" style="background-color: {$color|escape:'html':'UTF-8'}">
    {/if}
    <i class="whatsapp-icon{if version_compare($smarty.const._PS_VERSION_,'1.5','>=')}-3x{/if}" {if $button_text != ''}style="padding-right:0px!important;"{/if}></i>
    {if $from_bo == '1'}</a>{/if}
    {if $open_chat && $from_bo != '1'}</a>{/if}
    {if $button_text != '' && $from_bo != '1'}
        <div class="label-container label-container-{$position|escape:'html':'UTF-8'} float-{$whatsapp_class|escape:'html':'UTF-8'}">
            {if (strpos($position, 'left') != false || $position == 'left')}
            <i class="icon icon-caret-left label-arrow" style="font-size: x-large;"></i>
            <div class="label-text">{if $offline_message != ''}{$offline_message|escape:'html':'UTF-8'}{else}{$button_text|escape:'html':'UTF-8'}{/if}</div>
            {else}
            <div class="label-text">{if $offline_message != ''}{$offline_message|escape:'html':'UTF-8'}{else}{$button_text|escape:'html':'UTF-8'}{/if}</div>
            <i class="icon icon-play label-arrow"></i>
            {/if}
        </div>
    {/if}
{/if}
{if !$from_bo && $whatsapp_class == 'hookDisplayWhatsAppProductSocialButtons'}
<script>
if (document.addEventListener) {
    window.addEventListener('load', setWhatsAppSocialButton, false);
} else {
    window.attachEvent('onload', setWhatsAppSocialButton);
}
function setWhatsAppSocialButton() {
    {if version_compare($smarty.const._PS_VERSION_,'1.7','>=')}
        var element_to_copy = $('div.product-additional-info .social-sharing ul li').last().clone();
        if (typeof element_to_copy === 'undefined') {
            $('.whatsapp-hookDisplayWhatsAppProductSocialButtons').show();
        } else {
            element_to_copy.addClass('whatsapp-social-button');
            element_to_copy.children().attr('href', "{$url nofilter}").attr('title', 'WhatsApp');
            $(element_to_copy).appendTo('div.product-additional-info .social-sharing ul');
        }
    {else}
        var element_to_copy16 = $('p.socialsharing_product button').last().clone();
        if (typeof element_to_copy16 === 'undefined') {
            $('.whatsapp-hookDisplayWhatsAppProductSocialButtons').show();
        } else {
            element_to_copy16.addClass('whatsapp-social-button');
            element_to_copy.children().attr('href', "{$url nofilter}").attr('title', 'WhatsApp');
            $(element_to_copy16).appendTo('p.socialsharing_product');
        }
    {/if}
}
</script>
{/if}
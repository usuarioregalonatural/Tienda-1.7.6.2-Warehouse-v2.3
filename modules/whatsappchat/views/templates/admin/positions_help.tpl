{**
* WhatsApp Chat
*
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
*  @author    idnovate
*  @copyright 2019 idnovate
*  @license   See above
*}
<script>
    var AdminWhatsappChatController = '{$AdminWhatsappChatController|escape:'htmlall':'UTF-8'}';
    $("select[name='id_hook']").siblings().css('margin', '0').parent().parent().css('margin', '0');
</script>
<!-- <span id="positions_help"><i class="icon icon-hand-right"></i> [<a href="#" title="">{l s='HELP' mod='whatsappchat'} <i class="icon icon-share"></i></a>]</span> -->
<span id="positions_help_hook" class="" style="display: block;">
    {l s='If you select to show it in a TPL page, you need to insert next code:' mod='whatsappchat'}<br />
    {literal}{hook h="displayWhatsAppChat" id_whatsappchat="{/literal}{$id_whatsappchatblock|escape:'htmlall':'UTF-8'}{literal}"}{/literal}
</span>
<span id="positions_help_content" class="list-group bootstrap" style="display: none;">
    <span class="col-md-4">
        <span class="positions-help-page-text message-item">{l s='General pages' mod='whatsappchat'}</span>
        <span class="positions-help-page"><i class="icon icon-home"></i> <a class="" href="{$whatsappchat_homepage|escape:'htmlall':'UTF-8'}" target="_blank" title="">{l s='Home page' mod='whatsappchat'}</a></span>
        <span class="positions-help-page"><i class="icon icon-book"></i> <a class="" href="{$whatsappchat_categorypage|escape:'htmlall':'UTF-8'}" target="_blank" title="">{l s='Category page' mod='whatsappchat'}</a></span>
        <span class="positions-help-page"><i class="icon icon-th"></i> <a class="" href="{$whatsappchat_productpage|escape:'htmlall':'UTF-8'}" target="_blank" title="">{l s='Product page' mod='whatsappchat'}</a></span>
        <span class="positions-help-page"><i class="icon icon-shopping-cart"></i> <a class="" href="{$whatsappchat_cartpage|escape:'htmlall':'UTF-8'}" target="_blank" title="">{l s='Cart page' mod='whatsappchat'}</a></span>
        {if $whatsappchat_manufacturerpage}
            <span class="positions-help-page"><i class="icon icon-AdminShop"></i> <a class="" href="{$whatsappchat_manufacturerpage.link_rewrite|escape:'htmlall':'UTF-8'}?show_whatsapp=1" target="_blank" title="">{l s='Brand page' mod='whatsappchat'}</a></span>
        {/if}
        {if $whatsappchat_supplierpage}
            <span class="positions-help-page"><i class="icon icon-user"></i> <a class="" href="{$whatsappchat_supplierpage.link_rewrite|escape:'htmlall':'UTF-8'}?show_whatsapp=1" target="_blank" title="">{l s='Supplier page' mod='whatsappchat'}</a></span>
        {/if}
    </span>
    <span class="col-md-4">
        <span class="positions-help-page-text message-item">{l s='CMS pages' mod='whatsappchat'}</span>
        {foreach from=$whatsappchat_cmspages item=cms_page}
            <span class="positions-help-page"><i class="icon icon-navicon"></i> <a class="" href="{$cms_page.link_rewrite|escape:'htmlall':'UTF-8'}?show_whatsapp=1" target="_blank" title="">{$cms_page.name|escape:'htmlall':'UTF-8'}</a></span>
        {/foreach}
    </span>
    <span class="col-md-4">
        <span class="positions-help-page-text message-item">{l s='Other pages' mod='whatsappchat'}</span>
        {foreach from=$whatsappchat_otherpages item=other_page}
            {if $other_page.title != ''}
            <span class="positions-help-page"><i class="icon icon-stop"></i> <a class="" href="{$other_page.link_rewrite|escape:'htmlall':'UTF-8'}?show_whatsapp=1{if $other_page.id === 'cart'}&action=show{/if}" target="_blank" title="">{$other_page.name|escape:'htmlall':'UTF-8'}</a></span>
            {/if}
        {/foreach}
    </span>
</span>
<script>
$(document).ready(function() {
    var AdminWhatsappChatController = '{$AdminWhatsappChatController|escape:'htmlall':'UTF-8'}';
    new jBox('Modal', {
        attach: '#positions_help',
        title: "{l s='Select a type of page to show available positions you can place the WhatsApp button:' mod='whatsappchat'}",
        closeButton: 'title',
        overlay: true,
        createOnInit: true,
        content: $('#positions_help_content'),
        draggable: 'title',
        responsiveWidth: true,
        responsiveHeight: true,
        reposition: true,
        repositionOnOpen: true,
        repositionOnContent: true,
    });
});
</script>
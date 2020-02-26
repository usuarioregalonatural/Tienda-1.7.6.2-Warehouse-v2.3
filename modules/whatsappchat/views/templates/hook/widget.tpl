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

<style>
    .whatsapp-layout {
        position: fixed;
        bottom: 0;
        z-index: 9999;
        {if $position == 1}
        left: 0;
        {else}
        right: 0;
        {/if}
        margin: 10px;
        width: auto !important;
    }

    .whatsapp-layout span {
        border-radius: 4px;
        background: #25D366;
        color: #fff;
        font-size: 13px;
        padding: 6px 8px;
        display: inline-block;
        font-family: helvetica, arial, sans-serif;
        white-space: nowrap;
    }
    .whatsapp_icon {
        position: relative;
        background-image: url('{$this_path|escape:'htmlall':'UTF-8'}views/img/whatsapp.png');
        background-size: auto;
        background-repeat: no-repeat;
        display: inline-block;
        height: 16px;
        width: 16px;
        margin-right: 4px;
        top: -1px;
        vertical-align: middle;
    }

    .whatsapp-layout:focus {
        border: 0;
        outline: none !important;
    }
</style>

<a target="_blank" class="whatsapp-layout" href="{$url|escape:'html':'UTF-8'}">
    <span {if $color != ''}style="background-color: {$color|escape:'html':'UTF-8'}"{/if}>
        <i class="whatsapp_icon"></i>
        {$tab_message|escape:'html':'UTF-8'}
    </span>
</a>
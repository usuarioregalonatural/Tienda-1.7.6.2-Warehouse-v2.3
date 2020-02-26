{**
* WhatsApp Chat
*
* NOTICE OF LICENSE
*
* This product is licensed for one customer to use on one installation (test stores and multishop included).
* Site developer has the right to modify this module to suit their needs, but can not redistribute the module in
* whole or in part. Any other use of this module constitutes a violation of the user agreement.
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
<div class="input-group productseverywhere-valid-icon">
    {if version_compare($smarty.const._PS_VERSION_,'1.6','<')}
        <span
                class="time-column {$icon_class|escape:'quotes':'UTF-8'} label-tooltip"
                data-toggle="tooltip"
                data-original-title="{$date_title|escape:'quotes':'UTF-8'}"
                data-html="true"
                data-placement="top"
        ></span>
    {else}
        <span
                class="time-column {$icon_class|escape:'quotes':'UTF-8'}-icon label-tooltip"
                data-toggle="tooltip"
                data-original-title="{$date_title|escape:'quotes':'UTF-8'}"
                data-html="true"
                data-placement="top"
        >
            <i class="icon-time"></i>
        </span>
    {/if}
</div>

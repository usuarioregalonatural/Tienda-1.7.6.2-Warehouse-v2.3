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
<div class="input-group whatsappchat-display-on">
    <span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="{$display_on_selection_all|escape:'html':'UTF-8'}" data-html="true" data-placement="top">
        {if $entity == '11'}
            {$display_on_selection nofilter}
        {else}
            {$display_on.name|escape:'html':'UTF-8'}
            {if $entity == '2' || $entity == '4' || $entity == '6' || $entity == '8' || $entity == '10'}
                <span><i class="icon-folder-open-alt"></i></span>
            {/if}
        {/if}
    </span>
</div>

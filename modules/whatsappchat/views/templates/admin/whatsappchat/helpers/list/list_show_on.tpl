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
<div class="input-group whatsappchat-show-on">
    {if $config.only_mobile == '1'}
        <i
                data-toggle="tooltip"
                data-original-title="{l s='Mobile' mod='whatsappchat'}"
                data-html="true"
                data-placement="top"
                class="icon icon-4x icon-mobile-phone {$value|escape:'quotes':'UTF-8'} label-tooltip">

        </i>
    {/if}
    {if $config.only_tablet == '1'}
        <i
                data-toggle="tooltip"
                data-original-title="{l s='Tablet' mod='whatsappchat'}"
                data-html="true"
                data-placement="top"
                class="icon icon-4x icon-tablet {$value|escape:'quotes':'UTF-8'} label-tooltip">

        </i>
    {/if}
    {if $config.only_desktop == '1'}
        <i
                data-toggle="tooltip"
                data-original-title="{l s='Desktop' mod='whatsappchat'}"
                data-html="true"
                data-placement="top"
                class="icon icon-4x icon-desktop {$value|escape:'quotes':'UTF-8'} label-tooltip">

        </i>
    {/if}
</div>

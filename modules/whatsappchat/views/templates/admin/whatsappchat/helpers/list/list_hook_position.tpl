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
<span><i class="icon-list-alt"></i></span> {$hook_position|escape:'quotes':'UTF-8'}<br />
{if strpos($pos_id, 'right') !== false}
    <span><i class="icon-arrow-right"></i></span>
{elseif strpos($pos_id, 'left') !== false}
    <span><i class="icon-arrow-left"></i></span>
{else}
    <span><i class="icon-resize-horizontal"></i></span>
{/if}
{$horizontal_pos|escape:'quotes':'UTF-8'}

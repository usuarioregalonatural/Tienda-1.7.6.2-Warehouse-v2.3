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




<div class="alert alert-info iqitfreedeliverycount p-2 {if $hide}hidden-xs-up{/if}" role="alert">
    <div class="iqitfreedeliverycount-title {if isset($txt) && $txt != ''}mb-1{/if}"><strong>{l s='Spend' mod='iqitfreedeliverycount'} <span class="ifdc-remaining-price">{$free_ship_remaining}</span> {l s='more to get free shipping!' mod='iqitfreedeliverycount'}</strong></div>
    {if isset($txt) && $txt != ''}{$txt nofilter}{/if} {* HTML, cannot escape*}
</div>

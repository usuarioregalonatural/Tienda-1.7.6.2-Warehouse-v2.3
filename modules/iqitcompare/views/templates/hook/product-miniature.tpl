{*
* 2017 IQIT-COMMERCE.COM
*
* @author    IQIT-COMMERCE.COM <support@iqit-commerce.com>
* @copyright 2017 IQIT-COMMERCE.COM
* @license   Commercial license (You can not resell or redistribute this software.)
*
*}

{if isset($id_product)}
<a href="#" class="btn-iqitcompare-add js-iqitcompare-add"  data-id-product="{$id_product|intval}"
   data-url="{url entity='module' name='iqitcompare' controller='actions'}" data-toggle="tooltip" title="{l s='Compare' mod='iqitcompare'}">
    <i class="fa fa-random" aria-hidden="true"></i>
</a>
{/if}
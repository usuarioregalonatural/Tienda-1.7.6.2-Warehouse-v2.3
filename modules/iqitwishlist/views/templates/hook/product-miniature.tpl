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

{if isset($id_product_attribute)}
<a href="#" class="btn-iqitwishlist-add js-iqitwishlist-add"  data-id-product="{$id_product|intval}" data-id-product-attribute="{$id_product_attribute|intval}"
   data-url="{url entity='module' name='iqitwishlist' controller='actions'}" data-toggle="tooltip" title="{l s='Add to wishlist' mod='iqitwishlist'}">
    <i class="fa fa-heart-o not-added" aria-hidden="true"></i> <i class="fa fa-heart added" aria-hidden="true"></i>
</a>
{/if}
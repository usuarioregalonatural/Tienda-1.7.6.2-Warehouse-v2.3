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

{if isset($product.id_product_attribute)}
    <div class="col col-sm-auto">
        <button type="button" data-toggle="tooltip" data-placement="top"  title="{l s='Add to wishlist' mod='iqitwishlist'}"
           class="btn btn-secondary btn-lg btn-iconic btn-iqitwishlist-add js-iqitwishlist-add" data-animation="false" id="iqit-wishlist-product-btn"
           data-id-product="{$product.id_product|intval}"
           data-id-product-attribute="{$product.id_product_attribute|intval}"
           data-url="{url entity='module' name='iqitwishlist' controller='actions'}">
            <i class="fa fa-heart-o not-added" aria-hidden="true"></i> <i class="fa fa-heart added"
                                                                          aria-hidden="true"></i>
        </button>
    </div>
{/if}
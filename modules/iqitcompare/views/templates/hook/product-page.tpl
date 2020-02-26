{*
* 2017 IQIT-COMMERCE.COM
*
* @author    IQIT-COMMERCE.COM <support@iqit-commerce.com>
* @copyright 2017 IQIT-COMMERCE.COM
* @license   Commercial license (You can not resell or redistribute this software.)
*
*}

{if isset($product.id_product)}
    <div class="col col-sm-auto">
        <button type="button" data-toggle="tooltip" data-placement="top" title="{l s='Add to compare' mod='iqitcompare'}"
           class="btn btn-secondary btn-lg btn-iconic btn-iqitcompare-add js-iqitcompare-add" data-animation="false" id="iqit-compare-product-btn"
           data-id-product="{$product.id_product|intval}"
           data-url="{url entity='module' name='iqitcompare' controller='actions'}">
            <i class="fa fa-random not-added" aria-hidden="true"></i><i class="fa fa-check added"
                                                                        aria-hidden="true"></i>
        </button>
    </div>
{/if}
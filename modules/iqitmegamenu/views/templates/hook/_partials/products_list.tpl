{*
* 2007-2017 IQIT-COMMERCE.COM
*
* NOTICE OF LICENSE
*
*  @author    IQIT-COMMERCE.COM <support@iqit-commerce.com>
*  @copyright 2007-2017 IQIT-COMMERCE.COM
*  @license   GNU General Public License version 2
*
* You can not resell or redistribute this software.
*
*}
<div class="cbp-products-list {if $perline==12}cbp-products-list-one{/if} row ">
    {foreach from=$products item=product name=homeFeaturedProducts}
        <div class="col-{$perline}">
            <div class="product-container clearfix">
                <div class="row align-items-center list-small-gutters">

                    <div class="thumbnail-container col-3">
                        <a class="thumbnail product-thumbnail" href="{$product.url}" title="{$product.name}">
                            <img class="img-fluid"
                                 src="{$product.cover.bySize.small_default.url}"
                                 alt="{if !empty($product.legend)}{$product.legend}{else}{$product.name}{/if}"
                                    {if isset($mediumSize)} width="{$mediumSize.width}" height="{$mediumSize.height}"{/if}/>
                        </a>
                    </div>

                    <div class="product-description col">
                        <a class="cbp-product-name" href="{$product.link}" title="{$product.name}">
                            {$product.name|truncate:100:'...'}
                        </a>
                        <div class="product-price-and-shipping" >
                            <span class="product-price">{$product.price}</span>
                            {if $product.has_discount}
                                {hook h='displayProductPriceBlock' product=$product type="old_price"}
                                <span class="regular-price text-muted">{$product.regular_price}</span>
                            {/if}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    {/foreach}
</div>



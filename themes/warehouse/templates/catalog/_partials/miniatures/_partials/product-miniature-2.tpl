{**
 * 2007-2017 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2017 PrestaShop SA
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
{block name='product_thumbnail'}
    {include file='catalog/_partials/miniatures/_partials/product-miniature-thumb.tpl'}
{/block}

{block name='product_description_block'}
<div class="product-description">

    {if $product.has_discount}
        {hook h='displayCountDown'}
    {/if}

    <div class="row extra-small-gutters justify-content-end">
        <div class="col">
            {block name='product_category_name'}
                {if $product.category_name != ''}
                    <div class="product-category-name text-muted">{$product.category_name}</div>{/if}
            {/block}

            {block name='product_name'}
                <h3 class="h3 product-title">
                    <a href="{$product.canonical_url}">{$product.name|truncate:90:'...'}</a>
                </h3>
            {/block}

            {block name='product_brand'}
                {if isset($product.manufacturer_name ) && $product.manufacturer_name != ''}
                    <div class="product-brand text-muted">{$product.manufacturer_name}</div>{/if}
            {/block}

            {block name='product_reference'}
                {if $product.reference != ''}
                    <div class="product-reference text-muted">{$product.reference}</div>{/if}
            {/block}


            {block name='product_variants'}
                {if $product.main_variants}
                    <div class="products-variants">
                        {if $product.main_variants}
                            {include file='catalog/_partials/variant-links.tpl' variants=$product.main_variants}
                        {/if}
                    </div>
                {/if}
            {/block}

        </div>
        <div class="col col-auto product-miniature-right">

            {block name='product_price_and_shipping'}
                {if $product.show_price}
                    <div class="product-price-and-shipping">
                        {hook h='displayProductPriceBlock' product=$product type="before_price"}
                        <span class="product-price" content="{$product.price_amount}">{$product.price}</span>
                        {if $product.has_discount}
                            {hook h='displayProductPriceBlock' product=$product type="old_price"}
                            <span class="regular-price text-muted">{$product.regular_price}</span>
                        {/if}
                        {hook h='displayProductPriceBlock' product=$product type='unit_price'}
                        {hook h='displayProductPriceBlock' product=$product type='weight'}
                    </div>
                {/if}
            {/block}

            {block name='product_reviews'}
                {hook h='displayProductListReviews' product=$product}
            {/block}
        </div>
    </div>

    {block name='product_description_short'}
        <div class="product-description-short text-muted">
            {$product.description_short|strip_tags:'UTF-8'|truncate:360:'...'}
        </div>
    {/block}

    {block name='product_add_cart'}
        {include file='catalog/_partials/miniatures/_partials/product-miniature-btn.tpl'}
    {/block}

    {block name='product_add_cart_below'}
        {hook h='displayProductListBelowButton' product=$product}
    {/block}

</div>
{/block}
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
{block name='product_miniature_item'}
{if isset($elementor) && $elementor}<div class="{if isset($carousel) && $carousel}product-carousel{else}col-{$nbMobile} col-md-{$nbTablet} col-lg-{$nbDesktop} col-xl-{$nbDesktop}{/if}">{/if}
    <article class="product-miniature product-miniature-small product-miniature-small-grid js-product-miniature" data-id-product="{$product.id_product}"
             data-id-product-attribute="{$product.id_product_attribute}">
        <div class="row align-items-center list-small-gutters">
            {block name='product_thumbnail'}
                <div class="thumbnail-container col-12">
                    <a href="{$product.canonical_url}" class="thumbnail product-thumbnail">
                        {if $product.cover}
                            <img
                                    src="{$product.cover.small.url}"
                                    alt="{$product.cover.legend}"
                                    data-full-size-image-url="{$product.cover.large.url}"
                                    class="img-fluid"
                            >
                        {else}
                            <img
                                    src="{$urls.no_picture_image.bySize.small_default.url}"
                                    data-full-size-image-url="{$urls.no_picture_image.bySize.large_default.url}"
                                    class="img-fluid"
                            >
                        {/if}
                    </a>
                </div>
            {/block}

            <div class="product-description col-12">
                {block name='product_name'}
                    <h4 class="product-title" ><a
                                href="{$product.canonical_url}">{$product.name|truncate:40:'...'}</a></h4>
                {/block}

                {block name='product_reviews'}
                    {hook h='displayProductListReviews' product=$product}
                {/block}

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


            </div>
        </div>
    </article>
    {if isset($elementor) && $elementor}</div>{/if}
{/block}

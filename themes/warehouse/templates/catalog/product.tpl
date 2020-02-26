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
{extends file=$layout}

{block name='head_seo' prepend}
    <link rel="canonical" href="{$product.canonical_url}">
{/block}


{block name='head_og_tags'}
    <meta property="og:type" content="product">
    <meta property="og:url" content="{$urls.current_url}">
    <meta property="og:title" content="{$page.meta.title}">
    <meta property="og:site_name" content="{$shop.name}">
    <meta property="og:description" content="{$page.meta.description}">
    <meta property="og:image" content="{$product.cover.large.url}">
    <meta property="og:image:width" content="{$product.cover.large.width}">
    <meta property="og:image:height" content="{$product.cover.large.height}">
{/block}


{block name='head' append}
    {if $product.show_price}
        <meta property="product:pretax_price:amount" content="{$product.price_tax_exc}">
        <meta property="product:pretax_price:currency" content="{$currency.iso_code}">
        <meta property="product:price:amount" content="{$product.price_amount}">
        <meta property="product:price:currency" content="{$currency.iso_code}">
    {/if}
    {if isset($product.weight) && ($product.weight != 0)}
        <meta property="product:weight:value" content="{$product.weight}">
        <meta property="product:weight:units" content="{$product.weight_unit}">
    {/if}

    {if $iqitTheme.bread_bg_category}
        {assign var="categoryImage"  value="img/c/`$product.id_category_default`-category_default.jpg"}
        {if file_exists($categoryImage)}
            <style> #wrapper .breadcrumb{  background-image: url('{$link->getCatImageLink($product.category, $product.id_category_default, 'category_default')}'); }</style>
        {/if}
    {/if}

{/block}


{block name='content'}
    <section id="main" itemscope itemtype="https://schema.org/Product">
        <div id="product-preloader"><i class="fa fa-circle-o-notch fa-spin"></i></div>
        <div id="main-product-wrapper">
        <meta itemprop="url" content="{$product.url}">

        <div class="row product-info-row">
            <div class="col-md-{$iqitTheme.pp_img_width} col-product-image">
                {block name='page_content_container'}
                    <section class="page-content" id="content">
                        {block name='page_content'}

                            {block name='product_cover_thumbnails'}
                                {include file='catalog/_partials/product-cover-thumbnails.tpl'}
                            {/block}

                            {block name='after_cover_thumbnails'}
                                <div class="after-cover-tumbnails text-center">{hook h='displayAfterProductThumbs'}</div>
                            {/block}

                        {/block}
                    </section>
                {/block}
            </div>

            <div class="col-md-{$iqitTheme.pp_content_width} col-product-info">
                {block name='page_header_container'}
                    <div class="product_header_container clearfix">

                        {block name='product_brand_below'}
                            {if $iqitTheme.pp_man_logo == 'next-title'}
                                {if isset($product_manufacturer->id)}
                                    {if isset($manufacturer_image_url)}
                                        <meta itemprop="brand" content="{$product_manufacturer->name}">
                                        <div class="product-manufacturer product-manufacturer-next float-right">
                                            <a href="{$product_brand_url}">
                                                <img src="{$manufacturer_image_url}"
                                                     class="img-fluid  manufacturer-logo" alt="{$product_manufacturer->name}" />
                                            </a>
                                        </div>
                                    {/if}
                                {/if}
                            {/if}
                        {/block}

                        {block name='page_header'}
                        <h1 class="h1 page-title" itemprop="name"><span>{block name='page_title'}{$product.name}{/block}</span></h1>
                    {/block}
                        {block name='product_brand_below'}
                            {if $iqitTheme.pp_man_logo == 'title'}
                                {if isset($product_manufacturer->id)}
                                    <meta itemprop="brand" content="{$product_manufacturer->name}">
                                        {if isset($manufacturer_image_url)}
                                            <div class="product-manufacturer mb-3">
                                            <a href="{$product_brand_url}">
                                                <img src="{$manufacturer_image_url}"
                                                     class="img-fluid  manufacturer-logo" alt="{$product_manufacturer->name}" />
                                            </a>
                                            </div>
                                        {else}
                                            <label class="label">{l s='Brand' d='Shop.Theme.Catalog'}:</label>
                                            <span>
            <a href="{$product_brand_url}">{$product_manufacturer->name}</a>
          </span>
                                        {/if}

                                {/if}
                            {/if}
                            {if $iqitTheme.pp_man_logo == 'next-title'}
                                {if isset($product_manufacturer->id)}
                                    {if !isset($manufacturer_image_url)}
                                        <meta itemprop="brand" content="{$product_manufacturer->name}">
                                        <label class="label">{l s='Brand' d='Shop.Theme.Catalog'}:</label>
                                        <span>
                                        <a href="{$product_brand_url}">{$product_manufacturer->name}</a>
                                        </span>
                                    {/if}
                                {/if}
                            {/if}
                        {/block}

                        {block name='hook_display_product_rating'}
                            {hook h='displayProductRating' product=$product}
                        {/block}

                        {if $iqitTheme.pp_price_position == 'below-title'}
                            {block name='product_prices'}
                                {include file='catalog/_partials/product-prices.tpl'}
                            {/block}
                        {/if}
                    </div>
                {/block}

                <div class="product-information">
                    {block name='product_description_short'}
                        <div id="product-description-short-{$product.id}"
                             itemprop="description" class="rte-content">{$product.description_short nofilter}</div>
                    {/block}

                    {if $product.is_customizable && count($product.customizations.fields)}
                        {block name='product_customization'}
                            {include file="catalog/_partials/product-customization.tpl" customizations=$product.customizations}
                        {/block}
                    {/if}

                    <div class="product-actions">
                        {block name='product_buy'}
                            <form action="{$urls.pages.cart}" method="post" id="add-to-cart-or-refresh">
                                <input type="hidden" name="token" value="{$static_token}">
                                <input type="hidden" name="id_product" value="{$product.id}"
                                       id="product_page_product_id">
                                <input type="hidden" name="id_customization" value="{$product.id_customization}"
                                       id="product_customization_id">

                                {block name='product_variants'}
                                    {hook h='displayProductVariants' product=$product}
                                    {include file='catalog/_partials/product-variants.tpl'}
                                {/block}

                                {block name='product_pack'}
                                    {if $packItems}
                                        <section class="product-pack">
                                            <p class="h4">{l s='This pack contains' d='Shop.Theme.Catalog'}</p>
                                            {foreach from=$packItems item="product_pack"}
                                                {block name='product_miniature'}
                                                    {include file='catalog/_partials/miniatures/pack-product.tpl' product=$product_pack}
                                                {/block}
                                            {/foreach}
                                        </section>
                                    {/if}
                                {/block}

                                {if $iqitTheme.pp_price_position == 'above-button'}
                                    <div class="product_p_price_container">
                                    {block name='product_prices'}
                                        {include file='catalog/_partials/product-prices.tpl'}
                                    {/block}
                                    </div>
                                {/if}

                                {block name='product_add_to_cart'}
                                    {include file='catalog/_partials/product-add-to-cart.tpl'}
                                {/block}

                                {block name='product_discounts'}
                                    {include file='catalog/_partials/product-discounts.tpl'}
                                {/block}

                                {block name='product_additional_info'}
                                    {include file='catalog/_partials/product-additional-info.tpl'}
                                {/block}

                                {block name='product_refresh'}{/block}
                            </form>
                        {/block}

                        {block name='hook_display_reassurance'}
                            {hook h='displayReassurance'}
                        {/block}

                    </div>
                </div>
            </div>

            {if $iqitTheme.pp_sidebar}
            <div class="col-md-{$iqitTheme.pp_sidebar} sidebar product-sidebar">

                {if $iqitTheme.pp_accesories == 'sidebar'}
                    {block name='product_accessories_sidebar'}
                        {if $accessories}
                            <section class="product-accessories product-accessories-sidebar block">
                                <p class="block-title"><span>{l s='You might also like' d='Shop.Theme.Catalog'}</span></p>
                                <div id="product-accessories-sidebar" class="block-content products products-grid">
                                    {foreach from=$accessories item="product_accessory"}
                                        {block name='product_miniature'}
                                            {include file='catalog/_partials/miniatures/product-small.tpl' product=$product_accessory carousel=true elementor=true richData=true}
                                        {/block}
                                    {/foreach}
                                </div>
                            </section>
                        {/if}
                    {/block}
                {/if}

                {hook h='displayRightColumnProduct'}

            </div>
            {/if}

        </div>

        {if $iqitTheme.pp_tabs== 'tabh' || $iqitTheme.pp_tabs== 'tabha'}
            {include file='catalog/_partials/_product_partials/product-tabs-h.tpl'}
        {elseif $iqitTheme.pp_tabs== 'section'}
            {include file='catalog/_partials/_product_partials/product-tabs-sections.tpl'}
        {/if}

        </div>
        {if $iqitTheme.pp_accesories == 'footer'}
            {block name='product_accessories_footer'}
                {if $accessories}
                    <section class="product-accessories block block-section">
                        <p class="section-title">{l s='You might also like' d='Shop.Theme.Catalog'}</p>
                        <div class="block-content">
                            <div class="products slick-products-carousel products-grid slick-default-carousel">
                                {foreach from=$accessories item="product_accessory"}
                                    {block name='product_miniature'}
                                        {include file='catalog/_partials/miniatures/product.tpl' product=$product_accessory carousel=true richData=true}
                                    {/block}
                                {/foreach}
                            </div>
                        </div>
                    </section>
                {/if}
            {/block}
        {/if}

        {block name='product_footer'}
            {hook h='displayFooterProduct' product=$product category=$category}
        {/block}

        {block name='product_images_modal'}
            {include file='catalog/_partials/product-images-modal.tpl'}
        {/block}

        {block name='page_footer_container'}
            <footer class="page-footer">
                {block name='page_footer'}
                    <!-- Footer content -->
                {/block}
            </footer>
        {/block}

    </section>
{/block}

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

    <div class="thumbnail-container">
        <a href="{$product.canonical_url}" class="thumbnail product-thumbnail">

            {if $product.cover}
                <img
                        {if $iqitTheme.pl_lazyload}
                            {if isset($carousel) && $carousel}
                                src="{$product.cover.bySize.home_default.url}"
                            {else}
                                data-src="{$product.cover.bySize.home_default.url}"
                                src="{$iqitTheme.theme_assets}img/blank.png"
                            {/if}
                        {else}
                            src="{$product.cover.bySize.home_default.url}"
                        {/if}
                        alt="{if !empty($product.cover.legend)}{$product.cover.legend}{else}{$product.name|truncate:30:'...'}{/if}"
                        data-full-size-image-url="{$product.cover.large.url}"
                        width="{$product.cover.bySize.home_default.width}"
                        height="{$product.cover.bySize.home_default.height}"
                        class="img-fluid {if $iqitTheme.pl_lazyload}{if isset($carousel) && $carousel} {else}js-lazy-product-image{/if}{/if} product-thumbnail-first"
                >
            {else}
                <a href="{$product.canonical_url}" class="thumbnail product-thumbnail">
                    <img class="img-fluid product-thumbnail-first" src="{$urls.no_picture_image.bySize.home_default.url}"
                        alt="{if !empty($product.cover.legend)}{$product.cover.legend}{else}{$product.name|truncate:30:'...'}{/if}"
                         width="{$urls.no_picture_image.bySize.home_default.width}"
                         height="{$urls.no_picture_image.bySize.home_default.height}">
            {/if}

            {if !isset($overlay)}
                {if $iqitTheme.pl_rollover}
                    {foreach from=$product.images item=image}
                        {if !$image.cover}
                            <img
                                src="{$iqitTheme.theme_assets}img/blank.png"
                                data-src="{$image.bySize.home_default.url}"
                                width="{$image.bySize.home_default.width}"
                                height="{$image.bySize.home_default.height}"
                                alt="{if !empty($product.cover.legend)}{$product.cover.legend}{else}{$product.name|truncate:30:'...'}{/if} 2"
                                class="img-fluid js-lazy-product-image product-thumbnail-second"
                            >
                            {break}
                        {/if}
                    {/foreach}
                {/if}
            {/if}
        </a>

        {block name='product_flags'}
            <ul class="product-flags">
                {foreach from=$product.flags item=flag}
                    <li class="product-flag {$flag.type}">{$flag.label}</li>
                {/foreach}
            </ul>
        {/block}

        {if !isset($overlay) && !isset($list)}
        {block name='product_list_functional_buttons'}
            <div class="product-functional-buttons product-functional-buttons-bottom">
                <div class="product-functional-buttons-links">
                    {hook h='displayProductListFunctionalButtons' product=$product}
                    {block name='quick_view'}
                        <a class="js-quick-view-iqit" href="#" data-link-action="quickview" data-toggle="tooltip"
                           title="{l s='Quick view' d='Shop.Theme.Actions'}">
                            <i class="fa fa-eye" aria-hidden="true"></i></a>
                    {/block}
                </div>
            </div>
        {/block}
        {/if}

        {if !isset($list)}
        {block name='product_availability'}
            <div class="product-availability d-block">
                {if $product.show_availability && $product.availability_message}
                    <span
                            class="badge {if $product.availability == 'available'} {if $product.quantity <= 0  && $product.allow_oosp} badge-danger product-unavailable {else}badge-success product-available{/if}{elseif $product.availability == 'last_remaining_items'}badge-warning d-none product-last-items{else}badge-danger product-unavailable{/if} mt-2">
                  {if $product.availability == 'available'}
                      <i class="fa fa-check rtl-no-flip" aria-hidden="true"></i>
                                                     {$product.availability_message}
                  {elseif $product.availability == 'last_remaining_items'}
                      <i class="fa fa-exclamation" aria-hidden="true"></i>
                                                     {$product.availability_message}
                  {else}
                      <i class="fa fa-ban" aria-hidden="true"></i>
                              {$product.availability_message}
                      {if isset($product.available_date) && $product.available_date != '0000-00-00'}
                      {if $product.available_date|strtotime > $smarty.now}<span
                              class="available-date">{l s='until' d='Shop.Theme.Catalog'} {$product.available_date}</span>{/if}
                  {/if}
                  {/if}
                </span>
                {/if}

            </div>
        {/block}
        {/if}

    </div>



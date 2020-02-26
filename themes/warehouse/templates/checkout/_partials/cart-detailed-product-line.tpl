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
<div class="product-line-grid row align-items-center small-gutters">


    <!--  product left body: description -->
    <div class="product-line-grid-body col-12 col-sm-6 col-md-6">
        <div class="row align-items-center small-gutters">
            <div class="col product-image">
                {if $product.cover}
                <a href="{$product.url}" data-id_customization="{$product.id_customization|intval}">
                    <img src="{$product.cover.bySize.cart_default.url}" alt="{$product.name|escape:'quotes'}"
                         class="img-fluid">
                </a>
                {/if}
            </div>
            <div class="col col-9">
                <div class="product-line-info">
                    <a class="label" href="{$product.url}"
                       data-id_customization="{$product.id_customization|intval}">{$product.name}</a>
                </div>

                {foreach from=$product.attributes key="attribute" item="value"}
                    <div class="product-line-info product-line-info-secondary text-muted">
                        <span class="label">{$attribute}:</span>
                        <span class="value">{$value}</span>
                    </div>
                {/foreach}

                {if is_array($product.customizations) && $product.customizations|count}
                    {block name='cart_detailed_product_line_customization'}
                        {foreach from=$product.customizations item="customization"}
                            <a href="#" data-toggle="modal"
                               data-target="#product-customizations-modal-{$customization.id_customization}"
                               class="product-line-info-secondary text-muted">{l s='Product customization' d='Shop.Theme.Catalog'}
                                <i class="fa fa-external-link" aria-hidden="true"></i></a>
                            <div class="modal fade customization-modal"
                                 id="product-customizations-modal-{$customization.id_customization}" tabindex="-1"
                                 role="dialog"
                                 aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <span class="modal-title">{l s='Product customization' d='Shop.Theme.Catalog'}</span>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            {foreach from=$customization.fields item="field"}
                                                <div class="product-customization-line row">
                                                    <div class="col-sm-3 col-xs-4 label">
                                                        {$field.label}
                                                    </div>
                                                    <div class="col-sm-9 col-xs-8 value">
                                                        {if $field.type == 'text'}
                                                            {if (int)$field.id_module}
                                                                {$field.text nofilter}
                                                            {else}
                                                                {$field.text}
                                                            {/if}
                                                        {elseif $field.type == 'image'}
                                                            <a href="{$field.image.large.url}" target="_blank"><img
                                                                        class="img-fluid"
                                                                        src="{$field.image.small.url}"></a>
                                                        {/if}
                                                    </div>
                                                </div>
                                            {/foreach}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {/foreach}
                    {/block}
                {/if}
            </div>
        </div>
    </div>

    <!--  product left body: description -->
    <div class="col-12 col-sm-6 col-md-6 product-line-grid-right product-line-actions">
        <div class="row align-items-center small-gutters justify-content-end">
            <!--  product unit-->
            <div class="col col-auto col-md unit-price">
                {if $product.has_discount}
                    <span class="product-discount">
                        <span class="regular-price">{$product.regular_price}</span>
                            {if $product.discount_type === 'percentage'}
                                <span class="discount discount-percentage mr-1">
                                 -{$product.discount_percentage_absolute}
                                </span>
                            {else}
                            <span class="discount discount-amount mr-1">
                                 -{$product.discount_to_display}
                            </span>
                        	{/if}
                    </span>
                {/if}
                <span class="value">{$product.price}</span>
                {if $product.unit_price_full}
                    <div class="unit-price-cart">{$product.unit_price_full}</div>
                {/if}
            </div>

            <div class="col col-auto col-md qty">
                {if isset($product.is_gift) && $product.is_gift}
                    <span class="gift-quantity">{$product.quantity}</span>
                {else}
                    <input
                            class="js-cart-line-product-quantity"
                            data-down-url="{$product.down_quantity_url}"
                            data-up-url="{$product.up_quantity_url}"
                            data-update-url="{$product.update_quantity_url}"
                            data-product-id="{$product.id_product}"
                            type="number"
                            value="{$product.quantity}"
                            name="product-quantity-spin"
                            min="{$product.minimal_quantity}"
                            step="1"
                    />
                {/if}
            </div>
            <div class="col col-auto col-md price">
            <span class="product-price">
              <strong>
                {if isset($product.is_gift) && $product.is_gift}
                    <span class="gift">{l s='Gift' d='Shop.Theme.Checkout'}</span>
                {else}
                    {$product.total}
                {/if}
              </strong>
            </span>
            </div>

            <div class="col col-auto">
                <div class="cart-line-product-actions">
                    <a
                            class="remove-from-cart"
                            rel="nofollow"
                            href="{$product.remove_from_cart_url}"
                            data-link-action="delete-from-cart"
                            data-id-product="{$product.id_product|escape:'javascript'}"
                            data-id-product-attribute="{$product.id_product_attribute|escape:'javascript'}"
                            data-id-customization="{$product.id_customization|escape:'javascript'}"
                    >
                        {if !isset($product.is_gift) || !$product.is_gift}
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        {/if}
                    </a>

                    {block name='hook_cart_extra_product_actions'}
                        {hook h='displayCartExtraProductActions' product=$product}
                    {/block}

                </div>
            </div>
        </div>
    </div>

</div>

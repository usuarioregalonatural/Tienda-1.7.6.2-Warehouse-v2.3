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
<div class="product-add-to-cart pt-3">

    {if !$configuration.is_catalog}
        {block name='product_quantity'}
            <div class="row extra-small-gutters product-quantity">
                <div class="col col-12 col-sm-auto">
                    <div class="qty">
                        <input
                                type="number"
                                name="qty"
                                id="quantity_wanted"
                                value="{$product.quantity_wanted}"
                                class="input-group"
                                min="{$product.minimal_quantity}"
                        >
                    </div>
                </div>
                <div class="col col-12 col-sm-auto">
                    <div class="add">
                        <button
                                class="btn btn-primary btn-lg add-to-cart"
                                data-button-action="add-to-cart"
                                type="submit"
                                {if !$product.add_to_cart_url}
                                    disabled
                                {/if}
                        >
                            <i class="fa fa-shopping-bag fa-fw bag-icon" aria-hidden="true"></i>
                            <i class="fa fa-circle-o-notch fa-spin fa-fw spinner-icon" aria-hidden="true"></i>
                            {l s='Add to cart' d='Shop.Theme.Actions'}
                        </button>

                    </div>
                </div>
                {hook h='displayAfterProductAddCartBtn' product=$product}
            </div>
            {hook h='displayProductActions' product=$product}
        {/block}

        {block name='product_minimal_quantity'}
            <p class="product-minimal-quantity">
                {if $product.minimal_quantity > 1}
                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                    {l
                    s='The minimum purchase order quantity for the product is %quantity%.'
                    d='Shop.Theme.Checkout'
                    sprintf=['%quantity%' => $product.minimal_quantity]
                    }
                {/if}
            </p>
        {/block}
    {/if}
</div>

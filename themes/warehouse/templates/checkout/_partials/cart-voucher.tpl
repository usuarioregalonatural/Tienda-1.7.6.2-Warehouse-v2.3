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
{if $cart.vouchers.allowed}
    {block name='cart_voucher'}
        <div class="block-promo">
            <div class="cart-voucher">
                {if $cart.vouchers.added}
                    {block name='cart_voucher_list'}
                        <ul class="promo-name card-body">
                            {foreach from=$cart.vouchers.added item=voucher}
                                <li class="cart-summary-line">
                                    <a href="{$voucher.delete_url}" data-link-action="remove-voucher"><i
                                                class="fa fa-trash-o" aria-hidden="true"></i></a>
                                    <span class="label">{$voucher.name}</span>
                                    <div class="pull-right">
                                        <span>{$voucher.reduction_formatted}</span>
                                    </div>
                                </li>
                            {/foreach}
                        </ul>
                    {/block}
                {/if}

                <div class="cart-voucher-area">

                    <div class="promo-code" id="promo-code">

                        {block name='cart_voucher_notifications'}
                            <div class="alert alert-danger js-error" role="alert">
                                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span
                                        class="m-l-1 js-error-text"></span>
                            </div>
                        {/block}

                        {block name='cart_voucher_form'}
                            <form action="{$urls.pages.cart}" data-link-action="add-voucher" method="post"
                                  class="">
                                <div class="input-group">
                                    <i class="fa fa-tag btn voucher-icon" aria-hidden="true"></i>
                                <input type="hidden" name="token" value="{$static_token}">
                                <input type="hidden" name="addDiscount" value="1">
                                <input class="form-control" type="text" name="discount_name"
                                       placeholder="{l s='Promo code' d='Shop.Theme.Checkout'}">
                                <button type="submit" class="btn btn-secondary">
                                    <span>{l s='Add' d='Shop.Theme.Actions'}</span></button>
                                </div>
                            </form>
                        {/block}

                    </div>

                    {if $cart.discounts|count > 0}
                        <p class="block-promo promo-highlighted text-muted">
                            {l s='Take advantage of our exclusive offers:' d='Shop.Theme.Actions'}
                        </p>
                        <ul class="js-discount promo-discounts text-muted">
                            {foreach from=$cart.discounts item=discount}
                                <li class="cart-summary-line">
                                    <span class="label"><span
                                                class="code">{$discount.code}</span> - {$discount.name}</span>
                                </li>
                            {/foreach}
                        </ul>
                    {/if}
                </div>
            </div>
        </div>
    {/block}
{/if}

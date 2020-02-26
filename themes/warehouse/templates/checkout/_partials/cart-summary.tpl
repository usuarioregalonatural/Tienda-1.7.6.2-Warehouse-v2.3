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
<section id="js-checkout-summary" class="card cart-summary js-cart"
         data-refresh-url="{$urls.pages.cart}?ajax=1&action=refresh">
    <div class="card-body">

        {block name='hook_checkout_summary_top'}
            {hook h='displayCheckoutSummaryTop'}
        {/block}

        {block name='cart_summary_products'}
            <div class="cart-summary-products">

                <div>{$cart.summary_string}
                    <a href="#" data-toggle="collapse" class="text-muted pull-right" data-target="#cart-summary-product-list">
                        {l s='show details' d='Shop.Theme.Actions'} <i class="fa fa-angle-down" aria-hidden="true"></i>
                    </a>
                </div>

                {block name='cart_summary_product_list'}
                    <div class="collapse" id="cart-summary-product-list">
                        <ul class="media-list">
                            {foreach from=$cart.products item=product}
                                <li class="media cart-summary-product">{include file='checkout/_partials/cart-summary-product-line.tpl' product=$product}</li>
                            {/foreach}
                        </ul>
                        <div class="text-right"><a href="{url entity=cart params=['action' => 'show']}"><span class="step-edit"><i class="fa fa-pencil" aria-hidden="true"></i> {l s='edit' d='Shop.Theme.Actions'}</span></a></div>
                    </div>
                {/block}
            </div>
        {/block}
    </div>
    <hr>

        {block name='cart_summary_subtotals'}
            {include file='checkout/_partials/cart-summary-subtotals.tpl' cart=$cart}
        {/block}

    <hr>

    {block name='cart_summary_totals'}
        {include file='checkout/_partials/cart-summary-totals.tpl' cart=$cart}
    {/block}

    <hr>

    {block name='cart_summary_voucher'}
        {include file='checkout/_partials/cart-voucher.tpl'}
    {/block}

</section>

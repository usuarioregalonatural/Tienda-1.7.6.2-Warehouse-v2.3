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
<div class="card-body cart-summary-totals">

  {block name='cart_summary_total'}
    {if isset($configuration.display_prices_tax_incl)}
      {if !$configuration.display_prices_tax_incl && $configuration.taxes_enabled}
        <div class="cart-summary-line">
          <span class="label">{$cart.totals.total.label}&nbsp;{$cart.labels.tax_short}</span>
          <span class="value">{$cart.totals.total.value}</span>
        </div>
        <div class="cart-summary-line cart-total">
          <span class="label">{$cart.totals.total_including_tax.label}</span>
          <span class="value">{$cart.totals.total_including_tax.value}</span>
        </div>
      {else}
        <div class="cart-summary-line cart-total">
          <span class="label">{$cart.totals.total.label}&nbsp;{if $configuration.taxes_enabled}{$cart.labels.tax_short}{/if}</span>
          <span class="value">{$cart.totals.total.value}</span>
        </div>
      {/if}
      {else}
      <div class="cart-summary-line cart-total">
        <span class="label">{$cart.totals.total.label} {$cart.labels.tax_short}</span>
        <span class="value">{$cart.totals.total.value}</span>
      </div>
    {/if}
  {/block}

{block name='cart_summary_tax'}
    {if $cart.subtotals.tax}
      <div class="cart-summary-line">
        <span class="label sub">{l s='%label%:' sprintf=['%label%' => $cart.subtotals.tax.label] d='Shop.Theme.Global'}</span>
        <span class="value sub">{$cart.subtotals.tax.value}</span>
      </div>
    {/if}
  {/block}

  {hook h='displayCartAjaxInfo'}

</div>

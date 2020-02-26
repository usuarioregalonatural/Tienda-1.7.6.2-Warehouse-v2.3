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
{block name='cart_summary_product_line'}
  <div class="media-left mr-3 align-self-center">
    {if $product.cover}
    <a href="{$product.url}" title="{$product.name}">
      <img class="media-object img-fluid" src="{$product.cover.small.url}" alt="{$product.name|escape:'quotes'}">
    </a>
    {/if}
  </div>
  <div class="media-body align-self-center">
    <a href="{$product.url}" title="{$product.name}"><span class="product-name">{$product.name}</span></a>
    {foreach from=$product.attributes key="attribute" item="value"}
      <div class="product-line-info product-line-info-secondary text-muted">
        <span class="label">{$attribute}:</span>
        <span class="value">{$value}</span>
      </div>
    {/foreach}
    <span class="pull-right"><span class="product-quantity text-muted">x{$product.quantity}</span> {$product.price}</span>
    {hook h='displayProductPriceBlock' product=$product type="unit_price"}
  </div>
{/block}

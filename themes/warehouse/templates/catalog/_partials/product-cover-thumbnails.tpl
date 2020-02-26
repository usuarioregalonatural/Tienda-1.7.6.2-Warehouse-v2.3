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
<div class="images-container images-container-{if $iqitTheme.pp_thumbs == "left" || $iqitTheme.pp_thumbs == "leftd"}left images-container-d-{$iqitTheme.pp_thumbs} {else}bottom{/if}">
    {if $iqitTheme.pp_thumbs == "left" || $iqitTheme.pp_thumbs == "leftd"}
        <div class="row no-gutters">
            {if $product.images|@count gt 1}<div class="col-2 col-left-product-thumbs">{include file='catalog/_partials/_product_partials/product-thumbnails.tpl'}</div>{/if}
            <div class="{if $product.images|@count gt 1}col-10{else}col-12{/if} col-left-product-cover">{include file='catalog/_partials/_product_partials/product-cover.tpl'}</div>
        </div>
     {else}
        {include file='catalog/_partials/_product_partials/product-cover.tpl'}
        {include file='catalog/_partials/_product_partials/product-thumbnails.tpl'}
     {/if}
</div>

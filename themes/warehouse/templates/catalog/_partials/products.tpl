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
<div id="js-product-list">
    <div class="products row {if $iqitTheme.pl_default_view == 'grid'}products-grid{else}products-list{/if}">
        {foreach from=$listing.products item="product"}
            {block name='product_miniature'}
                {if $iqitTheme.pl_default_view == 'grid'}
                    {include file='catalog/_partials/miniatures/product.tpl' product=$product}
                {else}
                    {include file='catalog/_partials/miniatures/product-list.tpl' product=$product}
                {/if}
            {/block}
        {/foreach}
    </div>

    {block name='pagination_bottom'}
        {if $iqitTheme.pl_top_pagination && !$iqitTheme.pl_infinity}
            <div class="pagination-wrapper pagination-wrapper-bottom">
            <div class="row align-items-center justify-content-between">
                <div class="col col-auto">
                     <span class="showing hidden-sm-down">
                        {l s='Showing %from%-%to% of %total% item(s)' d='Shop.Theme.Catalog' sprintf=[
                        '%from%' => $listing.pagination.items_shown_from ,
                        '%to%' => $listing.pagination.items_shown_to,
                        '%total%' => $listing.pagination.total_items
                        ]}
                    </span>
                </div>
                <div class="col col-auto">
                    {include file='_partials/pagination.tpl' pagination=$listing.pagination}
                </div>
            </div>
            </div>
        {else}
            {if $iqitTheme.pl_infinity}
                <div class="hidden-xs-up">{include file='_partials/pagination.tpl' pagination=$listing.pagination}</div>
            {else}
                {include file='_partials/pagination.tpl' pagination=$listing.pagination}
            {/if}
        {/if}
    {/block}

</div>

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
<div id="js-product-list-top" class="products-selection">
    <div class="row align-items-center justify-content-between small-gutters">
        {if !empty($listing.rendered_facets)}
            {if $iqitTheme.pl_faceted_position}
                <div class="col col-auto facated-toggler">
                    <div class="filter-button">
                        <button id="search_center_filter_toggler" class="btn btn-secondary">
                            <i class="fa fa-filter" aria-hidden="true"></i> {l s='Filter' d='Shop.Theme.Actions'}
                        </button>
                    </div>
                </div>
            {else}
                <div class="col col-auto facated-toggler hidden-md-up">
                    <div class="filter-button">
                        <button id="search_filter_toggler" class="btn btn-secondary">
                            <i class="fa fa-filter" aria-hidden="true"></i> {l s='Filter' d='Shop.Theme.Actions'}
                        </button>
                    </div>
                </div>
            {/if}
        {else}
            <div class="col col-auto facated-toggler"></div>
        {/if}

        {foreach from=$listing.sort_orders item=sort_order}
            {if $sort_order.current}
                {if isset($sort_order.url)}
                {assign var="currentSortUrl" value=$sort_order.url|regex_replace:"/&productListView=\d+$/":""}
                {/if}
                {break}

            {/if}
        {/foreach}

        {if !isset($currentSortUrl)}
            {if isset($sort_order.url)}
                 {assign var="currentSortUrl" value=$sort_order.url|regex_replace:"/&productListView=\d+$/":""}
            {/if}
        {/if}




        {if isset($currentSortUrl)}
        <div class="col view-switcher hidden-sm-down">
            <a href="{$currentSortUrl}&productListView=grid" class="{if $iqitTheme.pl_default_view == 'grid'}current{/if} {['js-search-link' => true]|classnames}" data-button-action="change-list-view" data-view="grid"  rel="nofollow"><i class="fa fa-th" aria-hidden="true"></i></a>
            <a href="{$currentSortUrl}&productListView=list" class="{if $iqitTheme.pl_default_view == 'list'}current{/if} {['js-search-link' => true]|classnames}" data-button-action="change-list-view" data-view="list"  rel="nofollow"><i class="fa fa-th-list" aria-hidden="true"></i></a>
        </div>
            {else}

            {if isset($smarty.get.q) || isset($smarty.get.page) || isset($smarty.get.productListView)}


                {foreach from=$listing.pagination.pages item="page"}
                    {if $page.current}
                        {assign var="currentSortUrl2" value=$page.url|regex_replace:"/&productListView=\d+$/":""}
                    {/if}
                {/foreach}


               <div class="col view-switcher hidden-sm-down">
                   <a href="{$currentSortUrl2}&productListView=grid" class="{if $iqitTheme.pl_default_view == 'grid'}current{/if} {['js-search-link' => true]|classnames}" data-button-action="change-list-view" data-view="grid"  rel="nofollow"><i class="fa fa-th" aria-hidden="true"></i></a>
                   <a href="{$currentSortUrl2}&productListView=list" class="{if $iqitTheme.pl_default_view == 'list'}current{/if} {['js-search-link' => true]|classnames}" data-button-action="change-list-view" data-view="list"  rel="nofollow"><i class="fa fa-th-list" aria-hidden="true"></i></a>
               </div>


            {else}

                {foreach from=$listing.pagination.pages item="page"}
                    {if $page.current}
                        {assign var="currentSortUrl2" value=$page.url|regex_replace:"/&productListView=\d+$/":""}
                    {/if}
                {/foreach}

                <div class="col view-switcher hidden-sm-down">
                    <a href="{$currentSortUrl2}?productListView=grid" class="{if $iqitTheme.pl_default_view == 'grid'}current{/if} {['js-search-link' => true]|classnames}" data-button-action="change-list-view" data-view="grid"  rel="nofollow"><i class="fa fa-th" aria-hidden="true"></i></a>
                    <a href="{$currentSortUrl2}?productListView=list" class="{if $iqitTheme.pl_default_view == 'list'}current{/if} {['js-search-link' => true]|classnames}" data-button-action="change-list-view" data-view="list"  rel="nofollow"><i class="fa fa-th-list" aria-hidden="true"></i></a>
                </div>

            {/if}


        {/if}

        {if $iqitTheme.pl_top_pagination && !$iqitTheme.pl_infinity}
            <div class="col col-auto col-left-sort">
                {block name='sort_by'}
                    {include file='catalog/_partials/sort-orders.tpl' sort_orders=$listing.sort_orders}
                {/block}
            </div>
            <div class="col col-auto pagination-wrapper hidden-sm-down">
                {include file='_partials/pagination.tpl' pagination=$listing.pagination}
            </div>
        {else}
            <div class="col col-auto">
            <span class="showing hidden-sm-down">
            {l s='Showing %from%-%to% of %total% item(s)' d='Shop.Theme.Catalog' sprintf=[
            '%from%' => $listing.pagination.items_shown_from ,
            '%to%' => $listing.pagination.items_shown_to,
            '%total%' => $listing.pagination.total_items
            ]}
            </span>
                {block name='sort_by'}
                    {include file='catalog/_partials/sort-orders.tpl' sort_orders=$listing.sort_orders}
                {/block}
            </div>
        {/if}
    </div>
</div>


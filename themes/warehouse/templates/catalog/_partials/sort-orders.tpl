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

<div class="products-sort-nb-dropdown products-sort-order dropdown">
    <a class="select-title expand-more form-control" rel="nofollow" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
       <span class="select-title-name">{if isset($listing.sort_selected)}{$listing.sort_selected}{else}{l s='Select' d='Shop.Theme.Actions'}{/if}</span>
        <i class="fa fa-angle-down" aria-hidden="true"></i>
    </a>
    <div class="dropdown-menu">
        {foreach from=$listing.sort_orders item=sort_order}
            {if $sort_order.current}
                {assign var="currentSortUrl" value=$sort_order.url|regex_replace:"/&resultsPerPage=\d+$/":""}
            {/if}
            <a
                    rel="nofollow"
                    href="{$sort_order.url}"
                    class="select-list dropdown-item {['current' => $sort_order.current, 'js-search-link' => true]|classnames}"
            >
                {$sort_order.label}
            </a>
        {/foreach}
    </div>
</div>

{if isset($currentSortUrl)}
<div class="products-sort-nb-dropdown products-nb-per-page dropdown">
    <a class="select-title expand-more form-control" rel="nofollow" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
        {$listing.products|count}
        <i class="fa fa-angle-down" aria-hidden="true"></i>
    </a>

    <div class="dropdown-menu">
        <a
                rel="nofollow"
                href="{$currentSortUrl}&resultsPerPage=12"
                class="select-list dropdown-item {['js-search-link' => true]|classnames}"
        >
            12
        </a>
        <a
                rel="nofollow"
                href="{$currentSortUrl}&resultsPerPage=24"
                class="select-list dropdown-item {['js-search-link' => true]|classnames}"
        >
            24
        </a>
        <a
                rel="nofollow"
                href="{$currentSortUrl}&resultsPerPage=36"
                class="select-list dropdown-item {['js-search-link' => true]|classnames}"
        >
            36
        </a>
        <a
                rel="nofollow"
                href="{$currentSortUrl}&resultsPerPage=9999999"
                class="select-list dropdown-item {['js-search-link' => true]|classnames}"
        >
            {l s='Show all' d='Shop.Warehousetheme'}
        </a>
     </div>
</div>
{/if}

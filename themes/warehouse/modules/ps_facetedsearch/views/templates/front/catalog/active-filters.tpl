{**
  * 2007-2019 PrestaShop.
  *
  * NOTICE OF LICENSE
  *
  * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
  * that is bundled with this package in the file LICENSE.txt.
  * It is also available through the world-wide-web at this URL:
  * https://opensource.org/licenses/AFL-3.0
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
  * @copyright 2007-2019 PrestaShop SA
  * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
  * International Registered Trademark & Property of PrestaShop SA
  *}

<div id="js-active-search-filters" class="{if $activeFilters|count}active_filters{else}hide{/if}">
    {if $activeFilters|count}
        <div id="active-search-filters">
            {block name='active_filters_title'}
                <span class="active-filter-title">{l s='Active filters' d='Shop.Theme.Global'}</span>
            {/block}
            <ul class="filter-blocks">
                {foreach from=$activeFilters item="filter"}
                    {block name='active_filters_item'}
                        <li class="filter-block">
                            <a class="js-search-link btn btn-secondary btn-sm" href="{$filter.nextEncodedFacetsURL}">
                                <i class="fa fa-times" aria-hidden="true"></i>
                                {l s='%1$s: ' d='Shop.Theme.Catalog' sprintf=[$filter.facetLabel]}
                                {$filter.label}
                            </a>
                        </li>
                    {/block}
                {/foreach}
                {if $activeFilters|count > 1}
                    {block name='facets_clearall_button'}
                        <li class="filter-block filter-block-all">
                            <a class="js-search-link btn btn-secondary btn-sm" href="{$clear_all_link}">
                                <i class="fa fa-times" aria-hidden="true"></i>
                                {l s='Clear all' d='Shop.Theme.Actions'}
                            </a>
                        </li>
                    {/block}
                {/if}
            </ul>
        </div>
    {/if}
</div>

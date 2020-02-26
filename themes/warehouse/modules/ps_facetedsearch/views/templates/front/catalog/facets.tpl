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
{if $displayedFacets|count}
  <div id="search_filters">
      {block name='facets_title'}{/block}


    {foreach from=$displayedFacets item="facet"}
      <aside class="facet clearfix">
          <h4 class="block-title facet-title"><span>{$facet.label}</span></h4>
        {assign var=_expand_id value=10|mt_rand:100000}
        {assign var=_collapse value=true}
        {foreach from=$facet.filters item="filter"}
          {if $filter.active}{assign var=_collapse value=false}{/if}
        {/foreach}


        {if in_array($facet.widgetType, ['radio', 'checkbox'])}
          {block name='facet_item_other'}
              <ul id="facet_{$_expand_id}" class="facet-type-{$facet.widgetType}{if isset($facet.filters[0].properties.color) || isset($facet.filters[0].properties.texture)} facet_color{/if}">
              {foreach from=$facet.filters key=filter_key item="filter"}
                {if !$filter.displayed}
                  {continue}
                {/if}

                <li>
                  <label class="facet-label{if $filter.active} active {/if}" for="facet_input_{$_expand_id}_{$filter_key}">
                    {if $facet.multipleSelectionAllowed}
                      <span class="custom-checkbox"
                              {if isset($filter.properties.color) || isset($filter.properties.texture)}
                          data-toggle="tooltip"
                          data-animation="false"
                          data-placement="top"
                          data-boundary="window"
                          data-original-title="{$filter.label} {if $filter.magnitude and $show_quantities}({$filter.magnitude}){/if}"
                              {/if}
                      >
                        <input
                          id="facet_input_{$_expand_id}_{$filter_key}"
                          data-search-url="{$filter.nextEncodedFacetsURL}"
                          type="checkbox"
                          {if $filter.active }checked{/if}
                        >
                          {if isset($filter.properties.color)}
                              <span class="color" style="background-color:{$filter.properties.color}"></span>
                              {elseif isset($filter.properties.texture)}
                                <span class="color texture" style="background-image:url({$filter.properties.texture})"></span>
                              {else}
                              <span {if !$js_enabled} class="ps-shown-by-js" {/if}><i class="fa fa-check checkbox-checked" aria-hidden="true"></i></span>
                          {/if}
                      </span>
                    {else}
                      <span class="custom-radio">
                        <input
                          id="facet_input_{$_expand_id}_{$filter_key}"
                          data-search-url="{$filter.nextEncodedFacetsURL}"
                          type="radio"
                          name="filter {$facet.label}"
                          {if $filter.active }checked{/if}
                        >
                        <span {if !$js_enabled} class="ps-shown-by-js" {/if}></span>
                      </span>
                    {/if}

                      {if !isset($filter.properties.color) && !isset($filter.properties.texture)}
                          <a
                                  href="{$filter.nextEncodedFacetsURL}"
                                  class="_gray-darker search-link js-search-link"
                                  rel="nofollow"
                          >
                              {$filter.label}
                              {if $filter.magnitude and $show_quantities}
                                  <span class="magnitude">({$filter.magnitude})</span>
                              {/if}
                          </a>
                      {/if}

                  </label>
                </li>
              {/foreach}
            </ul>
          {/block}

        {elseif $facet.widgetType == 'dropdown'}
          {block name='facet_item_dropdown'}
            <ul id="facet_{$_expand_id}" class="">
              <li>
                  <div class="facet-dropdown dropdown">
                      <a class="form-control select-title expand-more" rel="nofollow" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                    {$active_found = false}
                    <span>
                      {foreach from=$facet.filters item="filter"}
                        {if $filter.active}
                          {$filter.label}
                          {if $filter.magnitude and $show_quantities}
                            ({$filter.magnitude})
                          {/if}
                          {$active_found = true}
                        {/if}
                      {/foreach}
                      {if !$active_found}
                        {l s='(no filter)' d='Shop.Theme.Global'}
                      {/if}
                    </span>
                          <i class="fa fa-angle-down drop-icon" aria-hidden="true"></i>
                  </a>
                  <div class="dropdown-menu">
                    {foreach from=$facet.filters item="filter"}

                        <a
                          rel="nofollow"
                          href="{$filter.nextEncodedFacetsURL}"
                          class="select-list dropdown-item {if $filter.active}current{/if} search-link js-search-link"
                        >
                          {$filter.label}
                          {if $filter.magnitude and $show_quantities}
                            ({$filter.magnitude})
                          {/if}
                            {if $filter.active}
                                <i class="fa fa-times" aria-hidden="true"></i>
                            {/if}
                        </a>

                    {/foreach}
                  </div>
                </div>
              </li>
            </ul>
          {/block}

        {elseif $facet.widgetType == 'slider'}
          {block name='facet_item_slider'}
            {foreach from=$facet.filters item="filter"}
              <ul id="facet_{$_expand_id}"
                class="faceted-slider"
                data-slider-min="{$facet.properties.min}"
                data-slider-max="{$facet.properties.max}"
                data-slider-id="{$_expand_id}"
                data-slider-values="{$filter.value|@json_encode}"
                data-slider-unit="{$facet.properties.unit}"
                data-slider-label="{$facet.label}"
                data-slider-specifications="{$facet.properties.specifications|@json_encode}"
                data-slider-encoded-url="{$filter.nextEncodedFacetsURL}"
              >
                <li>
                  <p id="facet_label_{$_expand_id}">
                    {$filter.label}
                  </p>

                  <div id="slider-range_{$_expand_id}"></div>
                </li>
              </ul>
            {/foreach}
          {/block}
        {/if}
      </aside>
    {/foreach}
  </div>
{/if}

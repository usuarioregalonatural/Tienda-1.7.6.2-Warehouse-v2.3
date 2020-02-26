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
{extends file='catalog/listing/product-list.tpl'}

{block name='product_list_header'}
    <h1 class="h1 page-title">
        <span>{l s='List of products by brand %s' sprintf=[$manufacturer.name] d='Shop.Theme.Catalog'}</span></h1>

    {if $manufacturer.short_description || $manufacturer.description}
    <div id="manufacturer-description-wrapper" class="mb-3">
    {if $manufacturer.short_description}
        <div class="card">
        <div id="manufacturer-short-description">
                {$manufacturer.short_description nofilter}

                {if $manufacturer.description}
                    <a class="btn btn-secondary btn-brands-more float-right collapsed "  data-toggle="collapse" data-parent="#manufacturer-description"
                   href="#manufacturer-description">
                        {l s='More' d='Shop.Warehousetheme'}
                    </a>
                {/if}

        </div>
        </div>

        {if $manufacturer.description}
            <div class="card">
                <div id="manufacturer-description" class="collapse" role="tabpanel">
                    {$manufacturer.description nofilter}
                    <a class="btn btn-secondary float-right"  data-toggle="collapse" data-parent="#manufacturer-description"
                       href="#manufacturer-description">
                        {l s='Less' d='Shop.Warehousetheme'}
                    </a>
                </div>   </div>
        {/if}
        {else}
        <div class="card">
            <div id="manufacturer-description">
                {$manufacturer.description nofilter}
            </div>
        </div>
    {/if}
    </div>
    {/if}
{/block}

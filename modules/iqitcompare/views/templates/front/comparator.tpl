{*
* 2017 IQIT-COMMERCE.COM
*
* @author    IQIT-COMMERCE.COM <support@iqit-commerce.com>
* @copyright 2017 IQIT-COMMERCE.COM
* @license   Commercial license (You can not resell or redistribute this software.)
*
*}

{extends file='page.tpl'}

{block name='page_content'}


    <h1 class="h1 page-title"><span>{l s='Products compare' mod='iqitcompare'}</span></h1>
    {if isset($compareProducts) && $compareProducts}
        <div id="iqitcompare-table">

            <div class="iqitcompare-table-actions text-right">
                <a href="#" class="js-iqitcompare-remove-all iqitcompare-remove-all"
                   data-url="{url entity='module' name='iqitcompare' controller='actions'}">
                    <i class="fa fa-trash-o" aria-hidden="true"></i> {l s='Remove all products' mod='iqitcompare'}
                </a>
            </div>

            <div class="iqitcompare-table-container">
                <table class="table table-hover">
                    <tbody>
                    <tr class="iqitcompare-product-tr">
                        <td class="iqitcompare-product-td"></td>
                        {foreach from=$compareProducts item="compareProduct"}
                            <td class="iqitcompare-product-td js-iqitcompare-product-{$compareProduct.id_product}">
                                {include 'module:iqitcompare/views/templates/front/product.tpl' product=$compareProduct}
                            </td>
                        {/foreach}
                    </tr>
                    {if $orderedFeatures}
                        {foreach from=$orderedFeatures item=feature}
                            <tr>
                                {cycle values='comparison_feature_odd,comparison_feature_even' assign='classname'}
                                <td class="{$classname} feature-name">
                                    <strong>{$feature.name}</strong>
                                </td>
                                {foreach from=$compareProducts item="product"}

                                    {assign var='product_id' value=$product.id_product}
                                    {assign var='feature_id' value=$feature.id_feature}

                                    {if isset($listFeatures[$product_id])}
                                        {assign var='tab' value=$listFeatures[$product_id]}
                                        <td class="{$classname} iqitcompare-feature-td js-iqitcompare-product-{$product.id_product}">
                                            {if (isset($tab[$feature_id]))}
                                                {foreach from=$tab[$feature_id] item=tabfeature}
                                                    {$tabfeature|escape:'htmlall'|nl2br nofilter}
                                                {/foreach}
                                                {/if}
                                        </td>
                                    {else}
                                        <td class="{$classname} iqitcompare-feature-td js-iqitcompare-product-{$product.id_product}">
                                            ---
                                        </td>
                                    {/if}

                                {/foreach}
                            </tr>
                        {/foreach}
                    {else}
                        <tr>
                            <td></td>
                            <td colspan="{$compareProducts|@count}">{l s='No features to compare.' mod='iqitcompare'}</td>
                        </tr>
                    {/if}
                    </tbody>
                </table>
            </div>
        </div>
        <p class="alert alert-warning hidden-xs-up"
           id="iqitcompare-warning">{l s='There is no products to compare.' mod='iqitcompare'}</p>
    {else}
        <p class="alert alert-warning">{l s='There is no products to compare.' mod='iqitcompare'}</p>
    {/if}
{/block}



<div id="product-details" data-product="{$product.embedded_attributes|json_encode}" class="clearfix">
{block name='product_features'}
    {if $product.grouped_features}
        <section class="product-features">
            <dl class="data-sheet">
                {foreach from=$product.grouped_features item=feature}
                    <dt class="name">{$feature.name}</dt>
                    <dd class="value">{$feature.value|escape:'htmlall'|nl2br nofilter}</dd>
                {/foreach}
            </dl>
        </section>
    {/if}
{/block}


{block name='product_brand'}
{if $iqitTheme.pp_man_logo == 'tab'}
        {if isset($product_manufacturer->id)}
        <meta itemprop="brand" content="{$product_manufacturer->name}">
        <div class="product-manufacturer {if isset($manufacturer_image_url)} float-right{/if}">
            {if isset($manufacturer_image_url)}
                <label class="label">{l s='Brand' d='Shop.Theme.Catalog'}</label>
                <a href="{$product_brand_url}">
                    <img src="{$manufacturer_image_url}" class="img-fluid  manufacturer-logo" alt="{$product_manufacturer->name}"/>
                </a>
            {else}
                <label class="label">{l s='Brand' d='Shop.Theme.Catalog'}</label>
                <span>
            <a href="{$product_brand_url}">{$product_manufacturer->name}</a>
          </span>
            {/if}
        </div>
    {/if}
{/if}
{/block}


{block name='product_reference'}
    {if $iqitTheme.pp_reference == 'details'}
        {if isset($product.reference_to_display) && $product.reference_to_display neq ''}
        <div class="product-reference">
            <label class="label">{l s='Reference' d='Shop.Theme.Catalog'} </label>
            <span itemprop="sku">{$product.reference_to_display}</span>
        </div>
    {/if}
    {/if}
{/block}

{block name='product_quantities'}
    {if $product.show_quantities}
        <div class="product-quantities">
            <label class="label">{l s='In stock' d='Shop.Theme.Catalog'}</label>
            <span data-stock="{$product.quantity}" data-allow-oosp="{$product.allow_oosp}">{$product.quantity} {$product.quantity_label}</span>
        </div>
    {/if}
{/block}

{block name='product_condition'}
    {if $product.condition}
        <div class="product-condition">
            <label class="label">{l s='Condition' d='Shop.Theme.Catalog'} </label>
            <link itemprop="itemCondition" href="{$product.condition.schema_url}"/>
            <span>{$product.condition.label}</span>
        </div>
    {/if}
{/block}

{* if product have specific references, a table will be added to product details section *}
{block name='product_specific_references'}
    {if !empty($product.specific_references)}
        <div class="specific-references">
            {foreach from=$product.specific_references item=reference key=key}
                <div>
                    <label class="label">{$key}</label>
                    <span>{$reference}</span>
                </div>
            {/foreach}
        </div>
    {/if}
{/block}

{block name='product_availability_date'}
    {if $product.availability_date}
        <div class="product-availability-date">
            <label>{l s='Availability date:' d='Shop.Theme.Catalog'} </label>
            <span>{$product.availability_date}</span>
        </div>
    {/if}
{/block}

{block name='product_out_of_stock'}
    <div class="product-out-of-stock">
        {hook h='actionProductOutOfStock' product=$product}
    </div>
{/block}
</div>




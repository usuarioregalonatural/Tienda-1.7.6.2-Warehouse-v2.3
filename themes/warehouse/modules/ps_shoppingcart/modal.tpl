<div id="blockcart-modal-wrap">
<div id="blockcart-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {if $product}
            <div class="modal-header">
                <span class="modal-title"><i class="fa fa-check rtl-no-flip"
                                             aria-hidden="true"></i> {l s='Product successfully added to your shopping cart' d='Shop.Theme.Checkout'}</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row align-items-center"">
                    <div class="col-md-5 divide-right mb-1">
                        <div class="row no-gutters align-items-center">
                            {if $product.cover}
                                <div class="col-6 text-center">
                                    <a href="{$product.url}">
                                        <img src="{$product.cover.bySize.medium_default.url}" alt="{$product.name|escape:'quotes'}" class="img-fluid">
                                    </a>
                                </div>
                            {/if}
                            <div class="col col-info">
                                <div class="pb-1">
                                    <span class="product-name"><a href="{$product.url}">{$product.name}</a></span>
                                </div>
                                {if isset($product.attributes) && $product.attributes}
                                    <div class="product-attributes text-muted pb-1">
                                        {foreach from=$product.attributes key="attribute" item="value"}
                                            <div class="product-line-info">
                                                <span class="label">{$attribute}:</span>
                                                <span class="value">{$value}</span>
                                            </div>
                                        {/foreach}
                                    </div>
                                {/if}
                                <span class="text-muted">{$product.quantity} x</span> <span>{$product.price}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="cart-content pt-3">
                            {if $cart.products_count > 1}
                                <p class="cart-products-count">{l s='There are %products_count% items in your cart.' sprintf=['%products_count%' => $cart.products_count] d='Shop.Theme.Checkout'}</p>
                            {else}
                                <p class="cart-products-count">{l s='There is %product_count% item in your cart.' sprintf=['%product_count%' =>$cart.products_count] d='Shop.Theme.Checkout'}</p>
                            {/if}
                            <p>
                                <strong>{l s='Total products:' d='Shop.Theme.Checkout'}</strong>&nbsp;{$cart.subtotals.products.value}
                            </p>
                            {hook h='displayCartAjaxInfo'}
                            <div class="cart-content-btn">
                                <a href="{$cart_url}"
                                   class="btn btn-primary btn-block btn-lg mb-2">{l s='Proceed to checkout' d='Shop.Theme.Actions'}</a>
                                <button type="button" class="btn btn-secondary btn-block"
                                        data-dismiss="modal">{l s='Continue shopping' d='Shop.Theme.Actions'}</button>
                            </div>
                        </div>
                    </div>
                </div>

                {hook h='displayModalCartCrosseling' product=$product}


            </div>
            {else}
                <div class="modal-header">
                <span class="modal-title"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {l s='There are not enough products in stock' d='Shop.Theme.Checkout'}</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="cart-content">
                                <div class="cart-content-btn">
                                    <button type="button" class="btn btn-secondary btn-block"
                                            data-dismiss="modal">{l s='Continue shopping' d='Shop.Theme.Actions'}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {/if}
        </div>
    </div>
</div>

<div id="blockcart-notification" class="ns-box {if !$product}ns-box-danger{/if} ns-effect-thumbslider">
    <div class="ns-box-inner row align-items-center no-gutters">
        {if $product}
        {if $product.cover}
        <div class="ns-thumb col-3">
            <img src="{$product.cover.bySize.small_default.url}"
                 alt="{$product.name|escape:'quotes'}"
                 class="img-fluid">
        </div>
        {/if}
        <div class="ns-content col-9">
            <span class="ns-title"><i class="fa fa-check" aria-hidden="true"></i> <strong>{$product.name}</strong> {l s='is added to your shopping cart' d='Shop.Theme.Checkout'}</span>
        </div>
        <div class="ns-delivery col-12 mt-4">{hook h='displayCartAjaxInfo'}</div>
        {else}
            <div class="ns-content col-12">
                <span class="ns-title"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>  {l s='There are not enough products in stock' d='Shop.Theme.Checkout'}</span>
            </div>
        {/if}

    </div>
</div>

</div>
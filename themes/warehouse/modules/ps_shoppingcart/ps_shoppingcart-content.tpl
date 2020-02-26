<div id="_desktop_blockcart-content" class="dropdown-menu-custom dropdown-menu">
    <div id="blockcart-content" class="blockcart-content" >
        <div class="cart-title">
            <span class="modal-title">{l s='Your cart' d='Shop.Theme.Checkout'}</span>
            <button type="button" id="js-cart-close" class="close">
                <span>×</span>
            </button>
            <hr>
        </div>
        {if isset($cart.products) && $cart.products}
            <ul class="cart-products">
                {foreach from=$cart.products item=product}
                    <li>{include 'module:ps_shoppingcart/ps_shoppingcart-product-line.tpl' product=$product}</li>
                {/foreach}
            </ul>
            <div class="cart-subtotals">
                {foreach from=$cart.subtotals item="subtotal"}
                    {if $subtotal.type == 'products'}
                        <div class="{$subtotal.type} clearfix">
                            <span class="label">{$subtotal.label}</span>
                            <span class="value float-right">{$subtotal.value}</span>
                        </div>
                    {/if}
                {/foreach}
            </div>
            {hook h='displayCartAjaxInfo'}
            <div class="cart-buttons text-center">
                {if $cart.products_count > 0}
                    <a href="{url entity=order}"
                       class="btn btn-primary btn-block btn-lg mb-2">{l s='Checkout' d='Shop.Theme.Actions'}</a>
                    <a rel="nofollow" class="btn btn-secondary btn-block"
                       href="{$cart_url}">{l s='Cart' d='Shop.Theme.Checkout'}</a>
                {/if}
            </div>
        {else}
            <span class="no-items">{l s='There are no more items in your cart' d='Shop.Theme.Checkout'}</span>
        {/if}
    </div>
</div>
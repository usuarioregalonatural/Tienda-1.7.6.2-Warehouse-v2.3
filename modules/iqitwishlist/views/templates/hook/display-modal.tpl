{*
* 2017 IQIT-COMMERCE.COM
*
* NOTICE OF LICENSE
*
* This file is licenced under the Software License Agreement.
* With the purchase or the installation of the software in your application
* you accept the licence agreement
*
* @author    IQIT-COMMERCE.COM <support@iqit-commerce.com>
* @copyright 2017 IQIT-COMMERCE.COM
* @license   Commercial license (You can not resell or redistribute this software.)
*
*}

{if isset($login_form)}
<div id="iqitwishlist-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">{l s='You need to login or create account' mod='iqitwishlist'}</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <section class="login-form">
                   <p> {l s='Save products on your wishlist to buy them later or share with your friends.' mod='iqitwishlist'}</p>
                    {render file='customer/_partials/login-form.tpl' idForm='login-form-modal' ui=$login_form wishlistModal=true}
                </section>
                <hr/>
                {block name='display_after_login_form'}
                    {hook h='displayCustomerLoginFormAfter'}
                {/block}
                <div class="no-account">
                    <a href="{$urls.pages.register}" data-link-action="display-register-form">
                        {l s='No account? Create one here' mod='iqitwishlist'}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
{/if}

<div id="iqitwishlist-notification" class="ns-box ns-effect-thumbslider ns-text-only">
    <div class="ns-box-inner">
        <div class="ns-content">
            <span class="ns-title"><i class="fa fa-check" aria-hidden="true"></i> <strong>{l s='Product added to wishlist' mod='iqitwishlist'}</strong></span>
        </div>
    </div>
</div>
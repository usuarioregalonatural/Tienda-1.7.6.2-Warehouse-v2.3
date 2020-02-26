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
{extends file='page.tpl'}

{block name='page_header_container'}
    <header class="page-header">
      <h1 class="h1 page-title"><span>{l s='Your account' d='Shop.Theme.Customeraccount'}</span></h1>
    </header>
{/block}

{block name='notifications'}{/block}


{block name='page_content_container'}
  <section id="content" class="page-content my-account-page-content-wrapper">
    <div class="row">

    {block name='my_account_side_links'}
      {if $customer.is_logged}
      <div class="my-account-side-links col-sm-3">
          <a class="col-lg-4 col-md-6 col-sm-6 col-xs-12" id="identity-link" href="{$urls.pages.identity}">
        <span class="link-item">
          <i class="fa fa-user fa-fw" aria-hidden="true"></i>
          {l s='Information' d='Shop.Theme.Customeraccount'}
        </span>
          </a>

          {if $customer.addresses|count}
            <a class="col-lg-4 col-md-6 col-sm-6 col-xs-12" id="addresses-link" href="{$urls.pages.addresses}">
          <span class="link-item">
            <i class="fa fa-map-marker fa-fw" aria-hidden="true"></i>
            {l s='Addresses' d='Shop.Theme.Customeraccount'}
          </span>
            </a>
          {else}
            <a class="col-lg-4 col-md-6 col-sm-6 col-xs-12" id="address-link" href="{$urls.pages.address}">
          <span class="link-item">
            <i class="fa fa-map-marker fa-fw" aria-hidden="true"></i>
            {l s='Add first address' d='Shop.Theme.Customeraccount'}
          </span>
            </a>
          {/if}

          {if !$configuration.is_catalog}
            <a class="col-lg-4 col-md-6 col-sm-6 col-xs-12" id="history-link" href="{$urls.pages.history}">
          <span class="link-item">
            <i class="fa fa-history fa-fw" aria-hidden="true"></i>
            {l s='Order history and details' d='Shop.Theme.Customeraccount'}
          </span>
            </a>
          {/if}

          {if !$configuration.is_catalog}
            <a class="col-lg-4 col-md-6 col-sm-6 col-xs-12" id="order-slips-link" href="{$urls.pages.order_slip}">
          <span class="link-item">
            <i class="fa fa-file-o fa-fw" aria-hidden="true"></i>
            {l s='Credit slips' d='Shop.Theme.Customeraccount'}
          </span>
            </a>
          {/if}

          {if $configuration.voucher_enabled && !$configuration.is_catalog}
            <a class="col-lg-4 col-md-6 col-sm-6 col-xs-12" id="discounts-link" href="{$urls.pages.discount}">
          <span class="link-item">
            <i class="fa fa-tags fa-fw" aria-hidden="true"></i>
            {l s='Vouchers' d='Shop.Theme.Customeraccount'}
          </span>
            </a>
          {/if}

          {if $configuration.return_enabled && !$configuration.is_catalog}
            <a class="col-lg-4 col-md-6 col-sm-6 col-xs-12" id="returns-link" href="{$urls.pages.order_follow}">
          <span class="link-item">
            <i class="fa fa-undo fa-fw"" aria-hidden="true"></i>
            {l s='Merchandise returns' d='Shop.Theme.Customeraccount'}
          </span>
            </a>
          {/if}

          {block name='display_customer_account'}
            {hook h='displayCustomerAccount'}
          {/block}

          <a class="col-lg-4 col-md-6 col-sm-6 col-xs-12" href="{url entity='index' params=['mylogout' => '']}">
          <span class="link-item">
            <i class="fa fa-sign-out fa-fw" aria-hidden="true"></i>
            {l s='Sign out' d='Shop.Theme.Actions'}
          </span>
          </a>
      </div>
      {/if}
    {/block}


    <div class="my-account-page-content {if $customer.is_logged}col-sm-9{else}col{/if}">

      {block name='page_title' hide}
          <h2>{$smarty.block.child}</h2>
      {/block}

      {block name='page_content_top'}
        {block name='customer_notifications'}
          {include file='_partials/notifications.tpl'}
        {/block}
      {/block}

      {block name='page_content'}
       <!-- Page content -->
      {/block}
    </div>

    </div>
  </section>

{/block}

{block name='page_footer'}
  {block name='my_account_links'}
    {include file='customer/_partials/my-account-links.tpl'}
  {/block}
{/block}

{extends file='page.tpl'}




{block name='content'}

    <section id="content-hook_order_confirmation">
      <div class="row">
        <div class="col-sm-12 col-md-7 order-confirmation-title-payment">
          <h1 class="h1 page-title">
            <span><i class="fa fa-check rtl-no-flip" aria-hidden="true"></i> {l s='Your order is confirmed' d='Shop.Theme.Checkout'}</span>
          </h1>

          <div class="mail-sent-info">
            {l s='An email has been sent to your mail address %email%.' d='Shop.Theme.Checkout' sprintf=['%email%' => $customer.email]}
            {if $order.details.invoice_url}
              {* [1][/1] is for a HTML tag. *}
              {l
              s='You can also [1]download your invoice[/1]'
              d='Shop.Theme.Checkout'
              sprintf=[
              '[1]' => "<a href='{$order.details.invoice_url}'>",
              '[/1]' => "</a>"
              ]
              }
            {/if}
          </div>

          {block name='hook_order_confirmation'}
            {$HOOK_ORDER_CONFIRMATION nofilter}
          {/block}

          {block name='hook_payment_return'}
            {if ! empty($HOOK_PAYMENT_RETURN)}
              <section id="content-hook_payment_return" class="definition-list">
                  <div class="row">
                    <div class="col-md-12">
                      {$HOOK_PAYMENT_RETURN nofilter}
                    </div>
                  </div>
              </section>
            {/if}
          {/block}

          {block name='hook_order_confirmation_1'}
            {hook h='displayOrderConfirmation1'}
          {/block}


        </div>
        <div class="col-sm-12 col-md-5 order-confirmation-details">

          {block name='order_details'}
            <div id="order-details">
              <h3 class="h3 card-title">{l s='Order details' d='Shop.Theme.Checkout'}:</h3>
              <ul>
                <li>{l s='Order reference: %reference%' d='Shop.Theme.Checkout' sprintf=['%reference%' => $order.details.reference]}</li>
                <li>{l s='Payment method: %method%' d='Shop.Theme.Checkout' sprintf=['%method%' => $order.details.payment]}</li>
                {if !$order.details.is_virtual}
                  <li>
                    {l s='Shipping method: %method%' d='Shop.Theme.Checkout' sprintf=['%method%' => $order.carrier.name]}
                    <em class="text-muted">{$order.carrier.delay}</em>
                  </li>
                {/if}
              </ul>
            </div>
          {/block}

          {block name='order_confirmation_table'}
            {include
            file='checkout/_partials/order-confirmation-table-simple.tpl'
            products=$order.products
            subtotals=$order.subtotals
            totals=$order.totals
            labels=$order.labels
            add_product_link=false
            }
          {/block}


        </div>
      </div>
  </section>


    {block name='customer_registration_form'}
        {if $customer.is_guest}
            <div id="registration-form" class="card">
                <div class="card-body">
                    <h4 class="h4">{l s='Save time on your next order, sign up now' d='Shop.Theme.Checkout'}</h4>
                    {render file='customer/_partials/customer-form.tpl' ui=$register_form}
                </div>
            </div>
        {/if}
    {/block}

  {block name='hook_order_confirmation_2'}
    <section id="content-hook-order-confirmation-footer">
      {hook h='displayOrderConfirmation2'}
    </section>
  {/block}

{/block}



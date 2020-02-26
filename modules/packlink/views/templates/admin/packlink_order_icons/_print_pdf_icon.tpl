{**
 * 2020 Packlink
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Apache License 2.0
 * that is bundled with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * http://www.apache.org/licenses/LICENSE-2.0.txt
 *
 * @author    Packlink <support@packlink.com>
 * @copyright 2020 Packlink Shipping S.L
 * @license   http://www.apache.org/licenses/LICENSE-2.0.txt  Apache License 2.0
 *}

{* Generate HTML code for extending existing template for printing Invoice Icon with shipment labels icons *}
<p id="pl-label-printed" hidden>{l s='Printed' mod='packlink'}</p>
<p id="pl-label-ready" hidden>{l s='Ready' mod='packlink'}</p>
<p id="pl-disable-popup" hidden>
  {l s='Please disable pop-up blocker on this page in order to bulk open shipment labels' mod='packlink'}
</p>
<p id="pl-print-labels-url" hidden>
  {html_entity_decode($printLabelsUrl|escape:'html':'UTF-8')}
</p>
<span class="btn-group-action">
    <span class="btn-group">
      {if Configuration::get('PS_INVOICE') && $order->invoice_number}
        <a class="btn btn-default _blank"
           href="{html_entity_decode($link->getAdminLink('AdminPdf')|escape:'html':'UTF-8')}&amp;submitAction=generateInvoicePDF&amp;id_order={$order->id}"
        >
                   <i class="icon-file-text"></i>
              </a>
      {/if}

      {if $isLabelAvailable}
        <a class="btn btn-default _blank shipment-label" href=""
           data-order="{$orderId|escape:'html':'UTF-8'}"
           onclick="plPrintLabelOnOrdersPage(this)"
                {if $isLabelPrinted}
                  title="{l s='Printed' mod='packlink'}" style="color: #c3c3c3"
                {else}
                  title="{l s='Ready' mod='packlink'}"
                {/if}
              >
                <i class="icon-tag"
                  {if $isLabelPrinted}
                    style="color: #c3c3c3"
                  {/if}
                ></i>
        </a>
      {/if}


      {* Generate HTML code for printing Delivery Icon with link *}
      {if $order->delivery_number}
        <a class="btn btn-default _blank"
           href="{html_entity_decode($link->getAdminLink('AdminPdf')|escape:'html':'UTF-8')}&amp;submitAction=generateDeliverySlipPDF&amp;id_order={$order->id}">
            <i class="icon-truck"></i>
        </a>
      {/if}
    </span>
</span>

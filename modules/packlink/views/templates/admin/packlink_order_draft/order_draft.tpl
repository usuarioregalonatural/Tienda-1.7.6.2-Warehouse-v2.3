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

{* Generate HTML code for printing link to order draft on Packlink *}
<span class="btn-group-action">
    <span class="btn-group">
        {* Generate HTML code for printing Delivery Icon with link *}
        {if !$deleted }<a href="{html_entity_decode($orderDraftLink|escape:'html':'UTF-8')}" target="_blank">{/if}
            <img
                    src="{html_entity_decode($imgSrc|escape:'html':'UTF-8')}"
                    alt="{l s='Packlink order draft' mod='packlink'}"
                    style="width: 32px;"
            >
        {if !$deleted }</a>{/if}
    </span>
</span>

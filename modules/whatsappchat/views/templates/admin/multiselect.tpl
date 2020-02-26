{**
* WhatsApp Chat
*
* NOTICE OF LICENSE
*
* This product is licensed for one customer to use on one installation (test stores and multishop included).
* Site developer has the right to modify this module to suit their needs, but can not redistribute the module in
* whole or in part. Any other use of this module constitues a violation of the user agreement.
*
* DISCLAIMER
*
* NO WARRANTIES OF DATA SAFETY OR MODULE SECURITY
* ARE EXPRESSED OR IMPLIED. USE THIS MODULE IN ACCORDANCE
* WITH YOUR MERCHANT AGREEMENT, KNOWING THAT VIOLATIONS OF
* PCI COMPLIANCY OR A DATA BREACH CAN COST THOUSANDS OF DOLLARS
* IN FINES AND DAMAGE A STORES REPUTATION. USE AT YOUR OWN RISK.
*
*  @author    idnovate
*  @copyright 2019 idnovate
*  @license   See above
*}
<script src="../modules/whatsappchat/views/js/plugin/ui.multiselect.js?time={$smarty.now|escape:'htmlall':'UTF-8'}"></script>
<script type="text/javascript">
{if isset($customers_available)}
    var customers_append = [];
    {foreach $customers_available as $c}
        customers_append.push('<option value="{$c['id_customer']|escape:'htmlall':'UTF-8'}">{$c['email']|escape:'htmlall':'UTF-8'}</option>');
    {/foreach}
    $("select[name='customers[]']").append(customers_append.join(''));
{/if}

{if isset($customers_selected)}
    var customers_selected = "{$customers_selected|escape:'htmlall':'UTF-8'}";
    var customers_sel_array = customers_selected.split(";");
    for (i = 0; i < customers_sel_array.length; ++i) {
        setSelectedIndex($("select[name='customers[]']")[0], customers_sel_array[i]);
    }
{/if}
$(document).ready(function() {
    $(".multiple_select").each(function() {
        $(this).multiselect();
    });
});
function setSelectedIndex(s, v) {
    for ( var i = 0; i < s.options.length; i++ ) {
        if ( s.options[i].value == v ) {
            s.options[i].selected = true;
            return;
        }
    }
}
</script>
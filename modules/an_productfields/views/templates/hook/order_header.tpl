{**
* 2019 Anvanto
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
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
*  @author Anvanto (anvantoco@gmail.com)
*  @copyright  2019 anvanto.com

*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<script>
    var an_opc_ulr = decodeURIComponent("{$link->getModuleLink('an_productfields', 'opc', [], true)|escape:'url'}");
    var an_new = {if $an_new}true{else}false{/if};
    var an_pf_text_counter = {if $an_pf_text_counter}true{else}false{/if};
    var an_pf_dynamic_price = {if $an_pf_dynamic_price}true{else}false{/if};
    var an_pf_js_position = "{$an_pf_js_position|escape:'htmlall':'UTF-8'}";
    var an_pf_js_position_type = "{$an_pf_js_position_type|escape:'htmlall':'UTF-8'}";
    var an_date_format = "{$an_date_format|escape:'htmlall':'UTF-8'}";

    if (!an_pf_js_position) {
        an_pf_js_position = '.product-add-to-cart';
    }
</script>
<script>
    function defer(method) {
        //TODO rewrite native!
        if (
            document.querySelector(an_pf_js_position) != null
            && document.querySelector('#an_productfields') != null
            && document.querySelector('#an_productfields').hasChildNodes()
        ) {
            setTimeout(function() { method();}, 1);
        } else {
            setTimeout(function() { defer(method); }, 1);
        }
    }
    function ready(){
        defer(function () {
            switch (an_pf_js_position_type) {
                case 'after':
                    document.querySelector(an_pf_js_position).after(document.querySelector('#an_productfields'));
                    break;
                case 'prepend':
                    document.querySelector(an_pf_js_position).prepend(document.querySelector('#an_productfields'));
                    break;
                case 'append':
                    document.querySelector(an_pf_js_position).append(document.querySelector('#an_productfields'));
                    break;
                default:
                    document.querySelector(an_pf_js_position).before(document.querySelector('#an_productfields'));
            }
        });
    }
    document.addEventListener("DOMContentLoaded", ready);

</script>
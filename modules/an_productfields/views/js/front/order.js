/**
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
 */

(function ($) {

    var currentHash = '';

    function hashAdd(elements, direction = 'up')
    {
        if (elements.length) {
            for (var i = 0; i < elements.length; i++) {
                elements[i].addEventListener("touchstart", function (e) {
                    producthashListener(this);

                    $.ajax({
                        url: an_opc_ulr,
                        async:false,
                        type: 'POST',
                        dataType: 'JSON',
                        data: {'hash': currentHash, 'action': 'updateQtyByHash','direction':direction},
                        success: function (json) {
                            currentHash = '';
                        }
                    });
                })
            }
        }
    }

    function producthashListener(element)
    {
        var up;
        if (an_new) {
            up = element.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement;
        } else {
            up = element.parentElement.parentElement.parentElement;
        }


        if (up.getElementsByClassName('productattrib_hash').length > 0) {
            currentHash=up.getElementsByClassName('productattrib_hash')[0].value;
        } else {
            currentHash='no';
        }console.log(currentHash);
    }

    function bindListeners()
    {
        var elems = document.getElementsByClassName('product-line-info');

        for (i = 0; i < elems.length; i++) {
            elem = elems[i];
            if (elem.innerHTML.indexOf('productfields_hash:') !== -1) {
                //console.log(elem.getElementsByClassName('value')[0].innerHTML);
                hashInput =
                    '<input type="hidden" class="productattrib_hash" value="'
                    + elem.getElementsByClassName('value')[0].innerHTML + '">';

                elem.innerHTML = elem.innerHTML + hashInput;
                $(elem).hide();
            }
        }

        var elements_plus = document.getElementsByClassName('button-plus');
        hashAdd(elements_plus,'up');
        var elements_minus = document.getElementsByClassName('button-minus');
        hashAdd(elements_minus,'down');

        var elements_increase = document.getElementsByClassName('js-increase-product-quantity');
        hashAdd(elements_increase,'up');
        var elements_decrease = document.getElementsByClassName('js-decrease-product-quantity');
        hashAdd(elements_decrease,'down');

        var cartItem = document.getElementsByClassName('cart_item');
        if (cartItem.length) {
            for (var i = 0; i < cartItem.length; i++) {
                cartItem[i].addEventListener("mouseenter", function () {
                    if (this.getElementsByClassName('productattrib_hash').length > 0) {
                        currentHash=this.getElementsByClassName('productattrib_hash')[0].value;
                    } else {
                        currentHash='no';
                    }
                })
            }
        }

        var lineGrid = document.getElementsByClassName('product-line-grid');
        if (lineGrid.length) {
            for (var i = 0; i < lineGrid.length; i++) {
                lineGrid[i].addEventListener("mouseenter", function () {
                    if (this.getElementsByClassName('productattrib_hash').length > 0) {
                        currentHash=this.getElementsByClassName('productattrib_hash')[0].value;
                    } else {
                        currentHash='no';
                    }
                })
            }
        }
    }

    $(document).ready(function () {
        bindListeners();
    });

    $(document).ajaxSend(function (event, jqxhr, settings) {
        if (settings.hasOwnProperty('data')
            && typeof settings.data != 'undefined'
            && settings.data != null
            && currentHash != ''
            && settings.data.indexOf('updateQtyByHash') == -1
            && settings.data.indexOf('editCustomer') == -1
            && settings.data.indexOf('submitAddress') == -1
            && settings.data.indexOf('updateAddressesSelected') == -1
            && settings.data.indexOf('submitAccount') == -1
        ) {
            settings.data += '&anproductfieldshash=' + currentHash;
        }
    });

    $(document).ajaxComplete(function (event, xhr, settings) {
        if (settings.hasOwnProperty('data')
            && typeof settings.url != 'undefined'
            && settings.url != null
            && settings.url.indexOf('ajax=1') != -1
            && settings.url.indexOf('action=refresh') != -1
        ) {
            setTimeout(bindListeners, 50);
        }
    });

})(jQuery);




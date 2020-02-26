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
    var initialized = 0;
    $(document).ready(function () {
        $('input').on('keyup', function () {
            var max = $(this).attr('maxlength'),
                val = $(this).val(),
                trimmed;

            if (max && val) {
                trimmed = val.substr(0, max);
                $(this).val(trimmed);
            }
        });

        $('input.an_date').datepicker({ dateFormat: an_date_format});

        $('#an_productfields input[type="radio"]').each(function () {
            $(this).parents('.form-group:first').find('input[type="radio"]:first').click();
        });

        var isValid = function () {
            var error = false;
            $('#an_productfields .required input, #an_productfields .required select, #an_productfields .required textarea').each(function () {
                var elem = $('#an_productfields *[name="' + $(this).attr('name') + '"]');
                var val = elem.val();
                if (typeof val == 'object' && val != null) {
                    val = val.join(';');
                }

                if (val == '' || val == null) {
                    error = true;
                }
            });

            return !error;
        };

        function validateFields(id_product = false)
        {
            var data = {};

            $('#an_productfields input, #an_productfields select, #an_productfields textarea').each(function () {
                var elem =  $(this);
                if (elem.attr('type') == 'radio' || elem.attr('type') == 'checkbox') {
                    if (elem[0]['checked']) {
                        var val = elem.val();
                    }
                } else {
                    var val = elem.val();
                }

                if (typeof val != 'undefined') {
                    data[$(this).attr('name')] = encodeURIComponent(val);
                }
            });
            data.action = 'validateProductfields';
            if (!id_product) {
                data.id_product = $('#product_page_product_id').val();
            } else {
                data.id_product = id_product;
            }
            var ret = true;
            $.ajax({
                async: false,
                url: an_opc_ulr,
                type: 'POST',
                dataType: 'JSON',
                responseType: 'JSON',
                data: data,
                success: function (json) {
                    if (json.an_error) {
                        sweetAlert(json.an_error_text, json.errors, "error");
                        ret = false;
                    } else {
                        ret = true;
                    }
                }
            });
            return ret;
        }

        function bindValidateFields()
        {
            $('p#add_to_cart button.exclusive, button.add-to-cart, a.ajax_add_to_cart_button').click(function (event) {

                if (typeof event.currentTarget.dataset.idProduct != undefined) {
                    id_product = event.currentTarget.dataset.idProduct;
                } else {
                    id_product = false;
                }

                if (!validateFields(id_product)) {
                    event.preventDefault();
                    return false;
                }
            });
        }

        function counterCount()
        {
            if (!an_pf_text_counter) {
                return false;
            }

            if (
                (this.type == 'text' || this.type == 'textarea')
                && typeof this.maxLength != 'undefined'
                && this.maxLength != null
            ) {
                max_sumb = this.maxLength;
                curr_sumb = $(this).val().length;


                document.getElementById('counter_'+this.id).innerHTML = '(' + curr_sumb + '/' + max_sumb + ')';

                /*if (curr_sumb != 0) {
                 document.getElementById('counter_'+this.id).innerHTML = '(' + curr_sumb + '/' + max_sumb + ')';
                 } else {
                 document.getElementById('counter_'+this.id).innerHTML = '';
                 }*/
            }
        }

        $(document).ajaxSend(function (event, jqxhr, settings) {
            if (settings.hasOwnProperty('data')
                && typeof settings.data != 'undefined'
                && settings.data != null
                && typeof settings.data.indexOf === 'function'
                && settings.data.indexOf('an_productfields') == -1
            ) {
                $('#an_productfields input, #an_productfields select, #an_productfields textarea').each(function () {
                    var elem = $(this);


                    if (elem.attr('type') == 'radio' || elem.attr('type') == 'checkbox') {
                        if (elem[0]['checked']) {
                            var val = elem.val();
                        }
                    } else {
                        var val = elem.val();
                    }
                    if (typeof val == 'object' && val != null) {
                        val = val.join(';');
                    }

                    if (typeof val != 'undefined') {
                        settings.data += '&' + $(this).attr('name') + '=' + encodeURIComponent(val);
                    }
                });
            }
        });

        $(document).on("click", ".an-remove-line", function () {
            location.reload(true);
        });
        bindValidateFields();
        if (typeof pricecontoller == 'undefined') {
            pricecontoller = new anvantoPriceControllerObject();
            pricecontoller.init();
        }
        $('#an_productfields input, #an_productfields textarea').each(function () {
            var elem = $(this);
            elem.on("keyup", counterCount);
            elem.trigger('keyup');

        });

        $(document).ajaxComplete(function (event, xhr, settings) {
            if (
                (
                    xhr.hasOwnProperty('responseJSON')
                    && typeof xhr.responseJSON != 'undefined'
                    && ((
                        typeof xhr.responseJSON.quickview_html != 'undefined'
                        && xhr.responseJSON.quickview_html != null
                        && xhr.responseJSON.quickview_html.indexOf('add-to-cart') != -1
                    ) || (
                        typeof xhr.responseJSON.product_add_to_cart != 'undefined'
                        && xhr.responseJSON.product_add_to_cart != null
                        && xhr.responseJSON.product_add_to_cart.indexOf('add-to-cart') != -1
                    ))
                )
            ) {
                bindValidateFields();
                if (self.initialized == 0) {
                    pricecontoller = new anvantoPriceControllerObject();
                    pricecontoller.init();
                    self.initialized = 1;
                }
                //$('.product-add-to-cart').before($('#an_productfields'));
                $('input.an_date').datepicker({ dateFormat: an_date_format});

                $('#an_productfields input[type="radio"]').each(function () {
                    /* $(this).parents('.form-group:first').find('input[type="radio"]:first').click(); */
                });
            }
        });
    });

    function anvantoPriceControllerObject()
    {
        productFieldsPricesTable = [];
        id_product_attribute = '';
        id_customization = '';

        this.init = function () {

            if($('#an_pf_ipa').length > 0) {
                self.id_product_attribute = $('input#an_pf_ipa').val();
            }

            $('#quantity_wanted').on("change", function () {
                setTimeout(function () {
                    changeProductPrice();}, 50);
            });

            if ($('div.product-variants select').length > 0) {
                $('div.product-variants select').each(function () {
                    var elem = $(this);

                    elem.on("change", {elem: elem}, function () {
                        self.id_product_attribute = elem.value;
                        changeProductPrice();
                    });
                });
            };
            /*if ($('div.product-variants input.input-radio').length > 0) {
             $('div.product-variants input.input-radio').each(function () {
             var elem = $(this);

             elem.on("change", {elem: elem}, function () {
             self.id_customization = elem[0].value;
             changeProductPrice();
             setTimeout(function () {
             changeProductPrice();
             }, 250);
             });
             });
             };*/

            $(document).ajaxComplete(function (event, xhr, settings) {
                if (
                    (
                        xhr.hasOwnProperty('responseJSON')
                        && typeof xhr.responseJSON != 'undefined'
                        && (
                            typeof xhr.responseJSON.product_prices != 'undefined'
                            && xhr.responseJSON.product_prices != null
                        )
                    )
                ) {
                    changeProductPrice();
                }
            });

            $(document).ajaxComplete(function (event, xhr, settings) {
                if (
                    xhr.hasOwnProperty('responseJSON')
                    && typeof xhr.responseJSON != 'undefined'
                    && (
                        typeof xhr.responseJSON.product != 'undefined'
                        && xhr.responseJSON.product != null
                        && typeof xhr.responseJSON.quickview_html != 'undefined'
                        && xhr.responseJSON.quickview_html != null
                    )
                ) {
                    $('#an_productfields input, #an_productfields select, #an_productfields textarea').each(function () {
                        var elem = $(this);

                        elem.on("change", {elem: elem}, changeProductPrice);
                    });
                }
            });

            $('#an_productfields input, #an_productfields select, #an_productfields textarea').each(function () {
                var elem = $(this);

                elem.on("change", {elem: elem}, changeProductPrice);
            });
            changeProductPrice();
            return this;
        };

        function changeProductPrice()
        {
            if (!an_pf_dynamic_price) {
                return false;
            }
            additional = 0;
            productFieldsPricesTable = [];
            $('#an_productfields input, #an_productfields select, #an_productfields textarea').each(function () {
                var elem = $(this);
                if (productFieldsPricesTable[elem.attr('name')] == undefined) {
                    price = getElemPrice(elem);
                    self.productFieldsPricesTable[price['name']] = price['price'];
                    additional += price['price'];
                }
            });
            productFieldsPricesTable = [];
            serverCalculatePrice(additional);
        }

        function serverCalculatePrice(added)
        {
            product_id = $('input#product_page_product_id').val();
            qty = $('input#quantity_wanted').val();
            id_product_attribute = self.id_product_attribute;
            $('div#product-details').each(function(){
                if(this.getAttribute('data-product') != null) {
                    id_product_attribute = JSON.parse(this.getAttribute('data-product')).id_product_attribute;
                    return false;
                }
            });

            $.ajax({
                url: an_opc_ulr,
                async:false,
                type: 'POST',
                data: {
                    'action': 'calculateFullprice',
                    'id_product':product_id,
                    'fieldsprice' : added,
                    'qty' : qty,
                    'id_product_attribute' : self.id_product_attribute,
                    'id_customization' : self.id_customization
                },
                success: function (ret) {
                    if (typeof document.getElementsByClassName('current-price')[0] != 'undefined') {
                        $(document.getElementsByClassName('current-price')[0].querySelector('[itemprop="price"]')).html(ret);
                    } else if (typeof document.getElementsByClassName('our_price_display')[0] != 'undefined') {
                        $(document.getElementsByClassName('our_price_display')[0].querySelector('[itemprop="price"]')).html(ret);
                    }
                }
            });
        }

        function getElemPrice(elem)
        {
            name = elem.attr('name');
            elemsByName = document.getElementsByName(name);

            optionPrice = 0;
            if (elemsByName[0].type == 'checkbox' || elemsByName[0].type == 'radio') {//checkbox or radio
                mainpriceAdded = false;
                elemsByName.forEach(function (element) {
                    if (element['checked']) {
                        if (!mainpriceAdded) {
                            mainpriceAdded = true;
                            optionPrice += parseFloat(element.dataset.pricemain);
                        }
                        optionPrice += parseFloat(element.dataset.price);
                    }
                })
            } else {
                if (elemsByName[0].tagName == 'SELECT') {
                    currentElemValue = $(elemsByName[0]).val();
                    if (typeof currentElemValue == 'object' && currentElemValue != null) {//multiselect
                        mainpriceAdded = false;
                        currentElemValue.forEach(function (element) {
                            currentElementOption = elemsByName[0].querySelector('[value="'+element+'"]');
                            console.log(element);
                            if (!mainpriceAdded && currentElementOption != null) {
                                mainpriceAdded = true;
                                optionPrice += parseFloat(currentElementOption.dataset.pricemain == undefined ? 0 : currentElementOption.dataset.pricemain);
                            }
                            optionPrice += parseFloat(currentElementOption.dataset.price == undefined ? 0 : currentElementOption.dataset.price);
                        });
                    } else {//single option in select
                        currentElementOption = elemsByName[0].querySelector('[value="'+currentElemValue+'"]');
                        if (currentElementOption != null) {
                            optionPrice += parseFloat(currentElementOption.dataset.pricemain == undefined ? 0 : currentElementOption.dataset.pricemain);
                            optionPrice += parseFloat(currentElementOption.dataset.price == undefined ? 0 : currentElementOption.dataset.price);
                        }
                    }
                } else {
                    if (elemsByName[0].value != undefined && elemsByName[0].value != '' && elemsByName[0].value != null) {
                        optionPrice += parseFloat(elemsByName[0].dataset.price == undefined ? 0 : elemsByName[0].dataset.price);
                        optionPrice += parseFloat(elemsByName[0].dataset.pricemain== undefined ? 0 : elemsByName[0].dataset.pricemain);
                    }
                }
            }
            return {name:name,price:optionPrice};
        }
    }
})(jQuery);

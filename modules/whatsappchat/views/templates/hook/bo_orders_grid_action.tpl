{**
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
*  @author    idnovate.com <info@idnovate.com>
*  @copyright 2019 idnovate.com
*  @license   See above
*}

{if version_compare($smarty.const._PS_VERSION_,'1.5','<')}
    <!-- TODO PS14 -->
    {literal}
    <script type="text/javascript">
        if (document.URL.indexOf('id_order') > 0) {
            $(document).ready(function() {
                var id_order = '{/literal}{$smarty.get.id_order|default:0|escape:'htmlall':'UTF-8'}{literal}'
                //var html = ' <a href="#" onclick="orders_list.getCustomerPhoneAndOpenWhatsAppChat(' + id_order + ');return false;"><img src="{/literal}{$this_path_bo|escape:'htmlall':'UTF-8'}{literal}views/img/whatsapp-32x32.png" /> {/literal}{$action_whatsappchat|escape:'htmlall':'UTF-8'}{literal}</a>';
                //$(this).find("a[href='javascript:window.print()']").append(html);
            });
        } else {
            $(document).ready(function() {
                $('.table.table tbody tr').each(function(){
                    //var html = '<a href="#" onclick="orders_list.getCustomerPhoneAndOpenWhatsAppChat(' + id_order + ');return false;" ' + 'title="{/literal}{$action|escape:'htmlall':'UTF-8'}{literal}"><img src="{/literal}{$this_path_bo|escape:'htmlall':'UTF-8'}{literal}views/img/whatsapp-green.png" width="16px"/></a>';
                    //$(this).find('td:last').append(html);
                })
            });
        }
    </script>
    {/literal}
{else}
    {literal}
    <script type="text/javascript">
        var orders_list = {
            init: function() {
                orders_list.createListDropdown();
            },
            createListDropdown: function() {
                var parent = $('table.table.order');
                if (parent.length) {
                    var items = parent.find('tbody tr');
                    if (items.length) {
                        items.each(function(){
                            var last_cell = $(this).find('td:last');
                            var checkbox = $(this).find('td:first input[type=checkbox]');
                            if (checkbox.length > 0) {
                                var id_order = parseInt(checkbox.attr('value'));
                            } else {
                                {/literal}{if version_compare($smarty.const._PS_VERSION_,'1.6','>=')}{literal}
                                var id_order = parseInt($(this).find('td:first').html());
                                {/literal}{else}{literal}
                                var id_order = parseInt($(this).find('td.pointer:first').html());
                                {/literal}{/if}{literal}
                            }
                            if (last_cell.length) {
                                {/literal}{if version_compare($smarty.const._PS_VERSION_,'1.6','<')}{literal}
                                    var html = '<a href="#" onclick="orders_list.getCustomerPhoneAndOpenWhatsAppChat(' + id_order + ');return false;" title="{/literal}{$action|escape:'htmlall':'UTF-8'}{literal}" class="btn btn-default"> <i class="icon-trash"></i> {/literal}{if version_compare($smarty.const._PS_VERSION_,'1.6','<')}{literal}<img src="{/literal}{$this_path_bo|escape:'htmlall':'UTF-8'}{literal}views/img/whatsapp-green.png" width="16px"/>{/literal}{else}{$action|escape:'htmlall':'UTF-8'}{/if}{literal}</a>';
                                    {/literal}{if version_compare($smarty.const._PS_VERSION_,'1.5','<')}{literal}
                                        $(this).find('td:last div').append(html);
                                    {/literal}{elseif version_compare($smarty.const._PS_VERSION_,'1.6','<')}{literal}
                                        $(this).find('td:last').append(html);
                                    {/literal}{/if}{literal}
                                {/literal}{else}{literal}
                                    var button_container = last_cell.find('.btn-group'),
                                        button = orders_list.createWhatsAppChatButton(id_order);
                                    if (last_cell.find('.btn-group-action').length) {
                                        button_container.find('ul.dropdown-menu').append($(document.createElement('li')).attr({'class': 'divider'}));
                                        button_container.find('ul.dropdown-menu').append(button);
                                    } else {
                                        button_container.wrap($(document.createElement('div')).addClass('btn-group-action'));
                                        button_container.append(
                                            $(document.createElement('button')).addClass('btn btn-default dropdown-toggle').attr('data-toggle', 'dropdown')
                                                .append($(document.createElement('i')).addClass('icon-caret-down'))
                                        ).append($(document.createElement('ul')).addClass('dropdown-menu').append(button))
                                    }
                                {/literal}{/if}{literal}
                            }
                        });
                    }
                }
            },
            createWhatsAppChatButton: function(id_order) {
                return $(document.createElement('li')).append($(document.createElement('a')).attr({'href': '#', 'title':'{/literal}{$action|escape:'htmlall':'UTF-8'}{literal}', 'onclick': 'orders_list.getCustomerPhoneAndOpenWhatsAppChat(' + id_order + ')'}).html('<i class="icon-whatsapp"></i> ' + orders_list.tr('{/literal}{$action|escape:'htmlall':'UTF-8'}{literal}')));
            },
            tr: function(str) {
                return str;
            },
            getCustomerPhoneAndOpenWhatsAppChat: function(id_order) {
                $.ajax({
                    type: 'POST',
                    url: '{/literal}{$whatsappchat_admincontroller|escape:"quotes":"UTF-8"}{literal}',
                    async: true,
                    cache: false,
                    dataType : "json",
                    data: 'method=getCustomerMobilePhone&id_order=' + id_order,
                    success: function(jsonData)
                    {
                        if (jsonData.whatsappchat_response.code == 'OK') {
                            window.open(jsonData.whatsappchat_response.url, "sharer", "toolbar=0,status=0,width=660,height=525");
                        } else if (jsonData.whatsappchat_response.code == 'NOK') {
                            alert(jsonData.whatsappchat_response.msg);
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log(XMLHttpRequest);
                        if (textStatus != 'abort') {
                            alert("TECHNICAL ERROR: unable to open WhatsApp chat window \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
                        }
                    }
                });
            },
            openWhatsAppChat: function() {
                window.open("{/literal}{$url|escape:'quotes':'UTF-8'}{literal}", "sharer", "toolbar=0,status=0,width=660,height=525");
            },
        }
        $(function(){
            orders_list.init();
        });
        if (document.URL.indexOf('id_order') > 0) {
            $(document).ready(function(){
                {/literal}{if $show_button !== false}{literal}
                    {/literal}{if version_compare($smarty.const._PS_VERSION_,'1.6','>=')}{literal}
                        var toolbar = $('ul#toolbar-nav').prepend('<li><a id="page-header-desc-order-whatsapp" class="toolbar_btn" href="#" onclick="orders_list.openWhatsAppChat();return false;" title="{/literal}{$action_whatsappchat|escape:'htmlall':'UTF-8'}{literal}"><i class="icon-whatsapp bo"></i><div>{/literal}{$action_whatsappchat|escape:'htmlall':'UTF-8'}{literal}</div></a></li>');
                    {/literal}{/if}{literal}
                    var html = '<a class="btn btn-default" href="#" onclick="orders_list.openWhatsAppChat();return false;" ><i class="icon-whatsapp"></i> {/literal}{$action_whatsappchat|escape:'htmlall':'UTF-8'}{literal}</a>';
                    {/literal}{if version_compare($smarty.const._PS_VERSION_,'1.5','<')}{literal}
                        $("#content div.col-lg-7 .panel:first .hidden-print:first").prepend(html);
                    {/literal}{elseif version_compare($smarty.const._PS_VERSION_,'1.6','>=')}{literal}
                        $("#content div.col-lg-7 .panel:first .hidden-print:first").prepend(html);
                    {/literal}{else}{literal}
                        var html = '<a class="toolbar_btn" href="#" onclick="orders_list.openWhatsAppChat();return false;" ><span class="icon-whatsapp"><img src="{/literal}{$this_path_bo|escape:'htmlall':'UTF-8'}{literal}views/img/whatsapp-32x32.png" /></span> <div>{/literal}{$action_whatsappchat|escape:'htmlall':'UTF-8'}{literal}</div></a>';
                        $('ul.cc_button').prepend('<li>' + html + '</li>');
                    {/literal}{/if}{literal}
                {/literal}{/if}{literal}
            });
        }
    </script>
    {/literal}
{/if}

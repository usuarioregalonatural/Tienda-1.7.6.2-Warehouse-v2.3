/**
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
*/

 $('document').ready(function() {
     jQuery(function($) {
        $("select[name='id_hook']").change(function(){
            if ($("select[name='id_hook'] option:selected").val() == 'badge') {
                $("select[name='pos']").children("option").show();
                $("select[name='pos']").children("option[value='left']").hide();
                $("select[name='pos']").children("option[value='center']").hide();
                $("select[name='pos']").children("option[value='right']").hide();
                $("select[name='pos']").children("option[value='top-left']").hide();
                $("select[name='pos']").children("option[value='top-right']").hide();
                //$("select[name='pos']").val('bottom-left');
            } else if ($("select[name='id_hook'] option:selected").val() == 'floating') {
                $("select[name='pos']").children("option").show();
                //$("select[name='pos']").children("option[value='center']").hide();
            } else {
                $("select[name='pos']").children("option").show();
                $("select[name='pos']").children("option[value='bottom-left']").hide();
                $("select[name='pos']").children("option[value='bottom-right']").hide();
                $("select[name='pos']").children("option[value='top-left']").hide();
                $("select[name='pos']").children("option[value='top-right']").hide();
                //$("select[name='pos']").val('left');
            }

            if (_PS_VERSION_ < '1.6') {
                var version = '15';
            } else {
                var version = '16';
            }

            if ($("select[name='id_hook'] option:selected").val() === 'hookDisplayWhatsAppChat') {
                $('#positions_help_hook').show();
            } else {
                $('#positions_help_hook').hide();
            }

            var val = $("select[name='id_hook']  option:selected").val();
            var path = module_dir+'whatsappchat/views/img/';
            if ($.inArray(val, ['badge']) !== -1) {
                $('#hook-position').attr('href', path+'badge_'+version+'.png');
            } else if ($.inArray(val, ['hookDisplayBanner', 'top', 'header', 'footer', 'leftcolumn', 'rightcolumn', 'hookDisplayTopColumn']) !== -1) {
                $('#hook-position').attr('href', path+'allpages_'+version+'.png');
            } else if ($.inArray(val, ['hookDisplayNav', 'home']) !== -1) {
                $('#hook-position').attr('href', path+'home_'+version+'.png');
            } else if ($.inArray(val, ['hookDisplayProductButtons','hookDisplayProductActions', 'hookDisplayWhatsAppProductSocialButtons', 'hookDisplayLeftColumnProduct', 'hookDisplayRightColumnProduct', 'hookDisplayFooterProduct']) !== -1) {
                $('#hook-position').attr('href', path+'product_'+version+'.png');
            } else if ($.inArray(val, ['shoppingcart', 'shoppingcartextra', 'paymenttop', 'beforecarrier', 'orderconfirmation']) !== -1) {
                $('#hook-position').attr('href', path+'checkout_'+version+'.png');
            } else if ($.inArray(val, ['customeraccount', 'hookDisplayCustomerAccountForm', 'hookDisplayCustomerAccountFormTop', 'hookDisplayCustomerIdentityForm', 'myaccountblock']) !== -1) {
                $('#hook-position').attr('href', path+'customeraccount_'+version+'.png');
            } else if ($.inArray(val, ['hookDisplayMaintenance']) !== -1) {
                $('#hook-position').attr('href', path+'maintenance_'+version+'.png');
            }
        }).change();
         var positions_help = $('select[name="positions[]"]');
         //positions_help.parent().parent().css('margin-bottom', '0');
         positions_help.siblings('p').css('margin', '0');
         $("input:radio[name=filter_by_customer]").click(function() {
             toggleFields($(this).attr('name'), $(this).attr('type'));
         });
         toggleFields('filter_by_customer', 'radio');
         $("select[name=display_on]").change(function() {
             var display_on_selection_el = $("select[name='display_on_selection[]']");
             var entities = ['2', '4', '6', '8', '10', '11'];
             if ($.inArray($(this).val(), entities) !== -1) {
                 $.ajax({
                     type: 'POST',
                     url: AdminWhatsappChatController,
                     async: false,
                     cache: false,
                     dataType: 'json',
                     data: 'method=entity&entity=' + $(this).val(),
                     success: function (jsonData) {
                         display_on_selection_el.empty().multiselect('refresh');
                         jQuery.each( jsonData, function( key, value ) {
                             display_on_selection_el.append($('<option></option>').attr('value', value.id).text(value.name));
                         });
                         display_on_selection_el.multiselect('refresh');
                     },
                     error: function (XMLHttpRequest, textStatus, errorThrown) {
                         console.log(XMLHttpRequest);
                         if (textStatus !== 'abort') {
                             alert("TECHNICAL ERROR: AdminWhatsappChatController \n\nDetails:\nError thrown: " + errorThrown + "\n" + 'Text status: ' + textStatus);
                         }
                     }
                 });
             }
             toggleFields($(this).attr('name'), 'select');
         });
         toggleFields('display_on', 'select');
         $("input:radio[name=filter_by_customer]").change(function() {
             var customers_el = $("select[name='customers[]']");
             if (customers_el.children('option').length === 0) {
                 if ($(this).val() === '1') {
                     $.ajax({
                         type: 'POST',
                         url: AdminWhatsappChatController,
                         async: true,
                         cache: false,
                         dataType: 'json',
                         data: 'method=entity&entity=customers',
                         success: function (jsonData) {
                             customers_el.empty().multiselect('refresh');
                             jQuery.each( jsonData, function( key, value ) {
                                 console.log(value);
                                 customers_el.append($('<option></option>').attr('value', value.id_customer).text(value.email));
                             });
                             customers_el.multiselect('refresh');
                         },
                         error: function (XMLHttpRequest, textStatus, errorThrown) {
                             console.log(XMLHttpRequest);
                             if (textStatus !== 'abort') {
                                 alert("TECHNICAL ERROR: AdminWhatsappChatController \n\nDetails:\nError thrown: " + errorThrown + "\n" + 'Text status: ' + textStatus);
                             }
                         }
                     });
                 }
             }
         });
    });
     if (_PS_VERSION_ < '1.6') {
        $("select[name='id_hook']").children("option[value='hookDisplayBanner']").hide();
        $("select[name='id_hook']").children("option[value='hookDisplayTopColumn']").hide();
        $("select[name='id_hook']").children("option[value='hookDisplayNav']").hide();
        $("select[name='id_hook']").children("option[value='hookDisplayCustomerIdentityForm']").hide();
     }
});
function deleteImage() {
    $('img.whatsappchat_avatar').attr('src', '').hide();
    $('input#image-name').val(' ');
    $('input#image_prev').val('');
}
function toggleFields(fieldName, type)
{
    if ($('#'+fieldName) != null && $('#'+fieldName+'_on').is(':checked') && type === 'radio') {
        $('.form-group').each(function() {
            if ($(this).find('.toggle_'+fieldName).length > 0) {
                if (!$(this).hasClass('translatable-field')) {
                    $(this).slideDown('slow');
                }
                if (id_language) {
                    if ($(this).hasClass('lang-'+id_language)) {
                        $(this).slideDown('slow');
                    }
                } else {
                    if ($(this).hasClass('lang-1')) {
                        $(this).slideDown('slow');
                    }
                }
            }
            if (fieldName === 'carousel') {
                if ($(this).find('#autoplay_carousel_on').length > 0) {
                    $(this).slideDown('slow');
                }
                if ($(this).find('#show_nav_carousel_on').length > 0) {
                    $(this).slideDown('slow');
                }
            }
        });
        if (fieldName === 'filter_store') {
            $('.tree-panel-heading-controls').closest('.panel').closest('.form-group').slideDown('slow');
        }
    } else if (
        (
            $("select[name=" + fieldName + "]").val()  === '2' ||
            $("select[name=" + fieldName + "]").val()  === '3' ||
            $("select[name=" + fieldName + "]").val()  === '4' ||
            $("select[name=" + fieldName + "]").val()  === '6' ||
            $("select[name=" + fieldName + "]").val()  === '8' ||
            $("select[name=" + fieldName + "]").val()  === '10' ||
            $("select[name=" + fieldName + "]").val()  === '11'
        ) &&
        type === 'select'
    ) {
        $('.form-group').each(function() {
            if ($(this).find('.toggle_'+fieldName).length > 0) {
                if ($("select[name=" + fieldName + "]").val()  !== '3') {
                    $(this).slideDown('slow');
                } else {
                    $(this).slideUp();
                }
            }
            if ($("select[name=" + fieldName + "]").val()  === '3' || $("select[name=" + fieldName + "]").val()  === '4') {
                if ($(this).find('#only_same_category_on').length > 0) {
                    $(this).slideDown('slow');
                }
            } else {
                $(this).find('#only_same_category_on').parent().parent().parent().slideUp();
            }
        });
    } else {
        $('.form-group').each(function() {
            if ($(this).find('.toggle_'+fieldName).length > 0) {
                $(this).slideUp();
            }
            if (fieldName === 'display_on') {
                if ($(this).find('#only_same_category_on').length > 0) {
                    $(this).slideUp();
                }
            }
        });
        if (fieldName === 'filter_store') {
            $('.tree-panel-heading-controls').closest('.panel').closest('.form-group').slideUp();
        }
    }
}
/*!
 * jquery.businessHours v1.0.1 - jQuery plugin allows you to easy show & manage business hours
 * Copyright (c) 2015 Alex Padalka - http://gendelf.github.io/jquery.businessHours/
 * License: APACHE
 */

!function(a){a.fn.businessHours=function(b){function c(a,b,c){a.val(b),c&&a.prop("readonly",!0)}var d={preInit:function(){},postInit:function(){},inputDisabled:!1,checkedColorClass:"WorkingDayState",uncheckedColorClass:"RestDayState",colorBoxValContainerClass:"colorBoxContainer",weekdays:["Mon","Tue","Wed","Thu","Fri","Sat","Sun"],operationTime:[{},{},{},{},{},{},{}],defaultOperationTimeFrom:"9:00",defaultOperationTimeTill:"18:00",defaultActive:!0,containerTmpl:'<div class="clean"/>',dayTmpl:'<div class="dayContainer"><div data-original-title="" class="colorBox"><input type="checkbox" class="invisible operationState"/></div><div class="weekday"></div><div class="operationDayTimeContainer"><div class="operationTime"><input type="text" name="startTime" class="mini-time operationTimeFrom" value=""/></div><div class="operationTime"><input type="text" name="endTime" class="mini-time operationTimeTill" value=""/></div></div></div>'},e=a(this),f={getValueOrDefault:function(a,b){return"undefined"===jQuery.type(a)||null==a?b:a},init:function(b){return this.options=a.extend(d,b),e.html(""),"function"==typeof this.options.preInit&&this.options.preInit(),this.initView(this.options),"function"==typeof this.options.postInit&&this.options.postInit(),{serialize:function(){var b=[];return e.find(".operationState").each(function(c,d){var e=a(d).prop("checked"),f=a(d).parents(".dayContainer");b.push({isActive:e,timeFrom:e?f.find("[name='startTime']").val():null,timeTill:e?f.find("[name='endTime']").val():null})}),b}}},initView:function(b){for(var d=[b.checkedColorClass,b.uncheckedColorClass],f=e.append(a(b.containerTmpl)),g=this,h=0;h<b.weekdays.length;h++)f.append(b.dayTmpl);a.each(b.weekdays,function(a,d){var f=b.operationTime[a],h=e.find(".dayContainer").eq(a);h.find(".weekday").html(d);var i=g.getValueOrDefault(f.isActive,b.defaultActive);h.find(".operationState").prop("checked",i);var j=g.getValueOrDefault(f.timeFrom,b.defaultOperationTimeFrom);c(h.find('[name="startTime"]'),j,b.inputDisabled);var k=g.getValueOrDefault(f.timeTill,b.defaultOperationTimeTill);c(h.find('[name="endTime"]'),k,b.inputDisabled)}),e.find(".operationState").change(function(){var c=a(this),e=b.checkedColorClass,f=!1;c.prop("checked")||(e=b.uncheckedColorClass,f=!0),c.parents(".colorBox").removeClass(d.join(" ")).addClass(e),c.parents(".dayContainer").find(".operationTime").toggle(!f)}).trigger("change"),b.inputDisabled||e.find(".colorBox").on("click",function(){var b=a(this).find(".operationState");b.prop("checked",!b.prop("checked")).trigger("change")})}};return f.init(b)}}(jQuery);

/*!
 * jquery-timepicker v1.11.12 - A jQuery timepicker plugin inspired by Google Calendar. It supports both mouse and keyboard navigation.
 * Copyright (c) 2017 Jon Thornton - http://jonthornton.github.com/jquery-timepicker/
 * License: MIT
 */

!function(a){"object"==typeof exports&&exports&&"object"==typeof module&&module&&module.exports===exports?a(require("jquery")):"function"==typeof define&&define.amd?define(["jquery"],a):a(jQuery)}(function(a){function b(a){var b=a[0];return b.offsetWidth>0&&b.offsetHeight>0}function c(b){if(b.minTime&&(b.minTime=t(b.minTime)),b.maxTime&&(b.maxTime=t(b.maxTime)),b.durationTime&&"function"!=typeof b.durationTime&&(b.durationTime=t(b.durationTime)),"now"==b.scrollDefault)b.scrollDefault=function(){return b.roundingFunction(t(new Date),b)};else if(b.scrollDefault&&"function"!=typeof b.scrollDefault){var c=b.scrollDefault;b.scrollDefault=function(){return b.roundingFunction(t(c),b)}}else b.minTime&&(b.scrollDefault=function(){return b.roundingFunction(b.minTime,b)});if("string"===a.type(b.timeFormat)&&b.timeFormat.match(/[gh]/)&&(b._twelveHourTime=!0),b.showOnFocus===!1&&-1!=b.showOn.indexOf("focus")&&b.showOn.splice(b.showOn.indexOf("focus"),1),b.disableTimeRanges.length>0){for(var d in b.disableTimeRanges)b.disableTimeRanges[d]=[t(b.disableTimeRanges[d][0]),t(b.disableTimeRanges[d][1])];b.disableTimeRanges=b.disableTimeRanges.sort(function(a,b){return a[0]-b[0]});for(var d=b.disableTimeRanges.length-1;d>0;d--)b.disableTimeRanges[d][0]<=b.disableTimeRanges[d-1][1]&&(b.disableTimeRanges[d-1]=[Math.min(b.disableTimeRanges[d][0],b.disableTimeRanges[d-1][0]),Math.max(b.disableTimeRanges[d][1],b.disableTimeRanges[d-1][1])],b.disableTimeRanges.splice(d,1))}return b}function d(b){var c=b.data("timepicker-settings"),d=b.data("timepicker-list");if(d&&d.length&&(d.remove(),b.data("timepicker-list",!1)),c.useSelect){d=a("<select />",{"class":"ui-timepicker-select"});var g=d}else{d=a("<ul />",{"class":"ui-timepicker-list"});var g=a("<div />",{"class":"ui-timepicker-wrapper",tabindex:-1});g.css({display:"none",position:"absolute"}).append(d)}if(c.noneOption)if(c.noneOption===!0&&(c.noneOption=c.useSelect?"Time...":"None"),a.isArray(c.noneOption)){for(var i in c.noneOption)if(parseInt(i,10)==i){var k=e(c.noneOption[i],c.useSelect);d.append(k)}}else{var k=e(c.noneOption,c.useSelect);d.append(k)}if(c.className&&g.addClass(c.className),(null!==c.minTime||null!==c.durationTime)&&c.showDuration){"function"==typeof c.step?"function":c.step;g.addClass("ui-timepicker-with-duration"),g.addClass("ui-timepicker-step-"+c.step)}var l=c.minTime;"function"==typeof c.durationTime?l=t(c.durationTime()):null!==c.durationTime&&(l=c.durationTime);var n=null!==c.minTime?c.minTime:0,o=null!==c.maxTime?c.maxTime:n+v-1;n>o&&(o+=v),o===v-1&&"string"===a.type(c.timeFormat)&&c.show2400&&(o=v);var p=c.disableTimeRanges,w=0,x=p.length,z=c.step;"function"!=typeof z&&(z=function(){return c.step});for(var i=n,A=0;o>=i;A++,i+=60*z(A)){var B=i,C=s(B,c);if(c.useSelect){var D=a("<option />",{value:C});D.text(C)}else{var D=a("<li />");D.addClass(v/2>B%v?"ui-timepicker-am":"ui-timepicker-pm"),D.data("time",u(B,c)),D.text(C)}if((null!==c.minTime||null!==c.durationTime)&&c.showDuration){var E=r(i-l,c.step);if(c.useSelect)D.text(D.text()+" ("+E+")");else{var F=a("<span />",{"class":"ui-timepicker-duration"});F.text(" ("+E+")"),D.append(F)}}x>w&&(B>=p[w][1]&&(w+=1),p[w]&&B>=p[w][0]&&B<p[w][1]&&(c.useSelect?D.prop("disabled",!0):D.addClass("ui-timepicker-disabled"))),d.append(D)}if(g.data("timepicker-input",b),b.data("timepicker-list",g),c.useSelect)b.val()&&d.val(f(t(b.val()),c)),d.on("focus",function(){a(this).data("timepicker-input").trigger("showTimepicker")}),d.on("blur",function(){a(this).data("timepicker-input").trigger("hideTimepicker")}),d.on("change",function(){m(b,a(this).val(),"select")}),m(b,d.val(),"initial"),b.hide().after(d);else{var G=c.appendTo;"string"==typeof G?G=a(G):"function"==typeof G&&(G=G(b)),G.append(g),j(b,d),d.on("mousedown click","li",function(c){b.off("focus.timepicker"),b.on("focus.timepicker-ie-hack",function(){b.off("focus.timepicker-ie-hack"),b.on("focus.timepicker",y.show)}),h(b)||b[0].focus(),d.find("li").removeClass("ui-timepicker-selected"),a(this).addClass("ui-timepicker-selected"),q(b)&&(b.trigger("hideTimepicker"),d.on("mouseup.timepicker click.timepicker","li",function(a){d.off("mouseup.timepicker click.timepicker"),g.hide()}))})}}function e(b,c){var d,e,f;return"object"==typeof b?(d=b.label,e=b.className,f=b.value):"string"==typeof b?d=b:a.error("Invalid noneOption value"),c?a("<option />",{value:f,"class":e,text:d}):a("<li />",{"class":e,text:d}).data("time",String(f))}function f(a,b){return a=b.roundingFunction(a,b),null!==a?s(a,b):void 0}function g(b){if(b.target!=window){var c=a(b.target);c.closest(".ui-timepicker-input").length||c.closest(".ui-timepicker-wrapper").length||(y.hide(),a(document).unbind(".ui-timepicker"),a(window).unbind(".ui-timepicker"))}}function h(a){var b=a.data("timepicker-settings");return(window.navigator.msMaxTouchPoints||"ontouchstart"in document)&&b.disableTouchKeyboard}function i(b,c,d){if(!d&&0!==d)return!1;var e=b.data("timepicker-settings"),f=!1,d=e.roundingFunction(d,e);return c.find("li").each(function(b,c){var e=a(c);if("number"==typeof e.data("time"))return e.data("time")==d?(f=e,!1):void 0}),f}function j(a,b){b.find("li").removeClass("ui-timepicker-selected");var c=a.data("timepicker-settings"),d=t(l(a),c);if(null!==d){var e=i(a,b,d);if(e){var f=e.offset().top-b.offset().top;(f+e.outerHeight()>b.outerHeight()||0>f)&&b.scrollTop(b.scrollTop()+e.position().top-e.outerHeight()),(c.forceRoundTime||e.data("time")===d)&&e.addClass("ui-timepicker-selected")}}}function k(b,c){if("timepicker"!=c){var d=a(this);if(""===this.value)return void m(d,null,c);if(!d.is(":focus")||b&&"change"==b.type){var e=d.data("timepicker-settings"),f=t(this.value,e);if(null===f)return void d.trigger("timeFormatError");var g=!1;if(null!==e.minTime&&null!==e.maxTime&&(f<e.minTime||f>e.maxTime)&&(g=!0),a.each(e.disableTimeRanges,function(){return f>=this[0]&&f<this[1]?(g=!0,!1):void 0}),e.forceRoundTime){var h=e.roundingFunction(f,e);h!=f&&(f=h,c=null)}var i=s(f,e);g?(m(d,i,"error")||b&&"change"==b.type)&&d.trigger("timeRangeError"):m(d,i,c)}}}function l(a){return a.is("input")?a.val():a.data("ui-timepicker-value")}function m(a,b,c){if(a.is("input")){a.val(b);var d=a.data("timepicker-settings");d.useSelect&&"select"!=c&&a.data("timepicker-list").val(f(t(b),d))}return a.data("ui-timepicker-value")!=b?(a.data("ui-timepicker-value",b),"select"==c?a.trigger("selectTime").trigger("changeTime").trigger("change","timepicker"):-1==["error","initial"].indexOf(c)&&a.trigger("changeTime"),!0):(-1==["error","initial"].indexOf(c)&&a.trigger("selectTime"),!1)}function n(a){switch(a.keyCode){case 13:case 9:return;default:a.preventDefault()}}function o(c){var d=a(this),e=d.data("timepicker-list");if(!e||!b(e)){if(40!=c.keyCode)return!0;y.show.call(d.get(0)),e=d.data("timepicker-list"),h(d)||d.focus()}switch(c.keyCode){case 13:return q(d)&&(k.call(d.get(0),{type:"change"}),y.hide.apply(this)),c.preventDefault(),!1;case 38:var f=e.find(".ui-timepicker-selected");return f.length?f.is(":first-child")||(f.removeClass("ui-timepicker-selected"),f.prev().addClass("ui-timepicker-selected"),f.prev().position().top<f.outerHeight()&&e.scrollTop(e.scrollTop()-f.outerHeight())):(e.find("li").each(function(b,c){return a(c).position().top>0?(f=a(c),!1):void 0}),f.addClass("ui-timepicker-selected")),!1;case 40:return f=e.find(".ui-timepicker-selected"),0===f.length?(e.find("li").each(function(b,c){return a(c).position().top>0?(f=a(c),!1):void 0}),f.addClass("ui-timepicker-selected")):f.is(":last-child")||(f.removeClass("ui-timepicker-selected"),f.next().addClass("ui-timepicker-selected"),f.next().position().top+2*f.outerHeight()>e.outerHeight()&&e.scrollTop(e.scrollTop()+f.outerHeight())),!1;case 27:e.find("li").removeClass("ui-timepicker-selected"),y.hide();break;case 9:y.hide();break;default:return!0}}function p(c){var d=a(this),e=d.data("timepicker-list"),f=d.data("timepicker-settings");if(!e||!b(e)||f.disableTextInput)return!0;if("paste"===c.type||"cut"===c.type)return void setTimeout(function(){f.typeaheadHighlight?j(d,e):e.hide()},0);switch(c.keyCode){case 96:case 97:case 98:case 99:case 100:case 101:case 102:case 103:case 104:case 105:case 48:case 49:case 50:case 51:case 52:case 53:case 54:case 55:case 56:case 57:case 65:case 77:case 80:case 186:case 8:case 46:f.typeaheadHighlight?j(d,e):e.hide()}}function q(a){var b=a.data("timepicker-settings"),c=a.data("timepicker-list"),d=null,e=c.find(".ui-timepicker-selected");return e.hasClass("ui-timepicker-disabled")?!1:(e.length&&(d=e.data("time")),null!==d&&("string"!=typeof d&&(d=s(d,b)),m(a,d,"select")),!0)}function r(a,b){a=Math.abs(a);var c,d,e=Math.round(a/60),f=[];return 60>e?f=[e,w.mins]:(c=Math.floor(e/60),d=e%60,30==b&&30==d&&(c+=w.decimal+5),f.push(c),f.push(1==c?w.hr:w.hrs),30!=b&&d&&(f.push(d),f.push(w.mins))),f.join(" ")}function s(b,c){if("number"!=typeof b)return null;var d=parseInt(b%60),e=parseInt(b/60%60),f=parseInt(b/3600%24),g=new Date(1970,0,2,f,e,d,0);if(isNaN(g.getTime()))return null;if("function"===a.type(c.timeFormat))return c.timeFormat(g);for(var h,i,j="",k=0;k<c.timeFormat.length;k++)switch(i=c.timeFormat.charAt(k)){case"a":j+=g.getHours()>11?w.pm:w.am;break;case"A":j+=g.getHours()>11?w.PM:w.AM;break;case"g":h=g.getHours()%12,j+=0===h?"12":h;break;case"G":h=g.getHours(),b===v&&(h=c.show2400?24:0),j+=h;break;case"h":h=g.getHours()%12,0!==h&&10>h&&(h="0"+h),j+=0===h?"12":h;break;case"H":h=g.getHours(),b===v&&(h=c.show2400?24:0),j+=h>9?h:"0"+h;break;case"i":var e=g.getMinutes();j+=e>9?e:"0"+e;break;case"s":d=g.getSeconds(),j+=d>9?d:"0"+d;break;case"\\":k++,j+=c.timeFormat.charAt(k);break;default:j+=i}return j}function t(a,b){if(""===a||null===a)return null;if("object"==typeof a)return 3600*a.getHours()+60*a.getMinutes()+a.getSeconds();if("string"!=typeof a)return a;a=a.toLowerCase().replace(/[\s\.]/g,""),("a"==a.slice(-1)||"p"==a.slice(-1))&&(a+="m");var c="("+w.am.replace(".","")+"|"+w.pm.replace(".","")+"|"+w.AM.replace(".","")+"|"+w.PM.replace(".","")+")?",d=new RegExp("^"+c+"([0-9]?[0-9])\\W?([0-5][0-9])?\\W?([0-5][0-9])?"+c+"$"),e=a.match(d);if(!e)return null;var f=parseInt(1*e[2],10),g=e[1]||e[5],h=f,i=1*e[3]||0,j=1*e[4]||0;if(12>=f&&g){var k=g==w.pm||g==w.PM;h=12==f?k?12:0:f+(k?12:0)}else if(b){var l=3600*f+60*i+j;if(l>=v+(b.show2400?1:0)){if(b.wrapHours===!1)return null;h=f%24}}var m=3600*h+60*i+j;if(12>f&&!g&&b&&b._twelveHourTime&&b.scrollDefault){var n=m-b.scrollDefault();0>n&&n>=v/-2&&(m=(m+v/2)%v)}return m}function u(a,b){return a==v&&b.show2400?a:a%v}var v=86400,w={am:"am",pm:"pm",AM:"AM",PM:"PM",decimal:".",mins:"mins",hr:"hr",hrs:"hrs"},x={appendTo:"body",className:null,closeOnWindowScroll:!1,disableTextInput:!1,disableTimeRanges:[],disableTouchKeyboard:!1,durationTime:null,forceRoundTime:!1,maxTime:null,minTime:null,noneOption:!1,orientation:"l",roundingFunction:function(a,b){if(null===a)return null;if("number"!=typeof b.step)return a;var c=a%(60*b.step),d=b.minTime||0;return c-=d%(60*b.step),c>=30*b.step?a+=60*b.step-c:a-=c,u(a,b)},scrollDefault:null,selectOnBlur:!1,show2400:!1,showDuration:!1,showOn:["click","focus"],showOnFocus:!0,step:30,stopScrollPropagation:!1,timeFormat:"g:ia",typeaheadHighlight:!0,useSelect:!1,wrapHours:!0},y={init:function(b){return this.each(function(){var e=a(this),f=[];for(var g in x)e.data(g)&&(f[g]=e.data(g));var h=a.extend({},x,b,f);if(h.lang&&(w=a.extend(w,h.lang)),h=c(h),e.data("timepicker-settings",h),e.addClass("ui-timepicker-input"),h.useSelect)d(e);else{if(e.prop("autocomplete","off"),h.showOn)for(var i in h.showOn)e.on(h.showOn[i]+".timepicker",y.show);e.on("change.timepicker",k),e.on("keydown.timepicker",o),e.on("keyup.timepicker",p),h.disableTextInput&&e.on("keydown.timepicker",n),e.on("cut.timepicker",p),e.on("paste.timepicker",p),k.call(e.get(0),null,"initial")}})},show:function(c){var e=a(this),f=e.data("timepicker-settings");if(c&&c.preventDefault(),f.useSelect)return void e.data("timepicker-list").focus();h(e)&&e.blur();var k=e.data("timepicker-list");if(!e.prop("readonly")&&(k&&0!==k.length&&"function"!=typeof f.durationTime||(d(e),k=e.data("timepicker-list")),!b(k))){e.data("ui-timepicker-value",e.val()),j(e,k),y.hide(),k.show();var m={};f.orientation.match(/r/)?m.left=e.offset().left+e.outerWidth()-k.outerWidth()+parseInt(k.css("marginLeft").replace("px",""),10):m.left=e.offset().left+parseInt(k.css("marginLeft").replace("px",""),10);var n;n=f.orientation.match(/t/)?"t":f.orientation.match(/b/)?"b":e.offset().top+e.outerHeight(!0)+k.outerHeight()>a(window).height()+a(window).scrollTop()?"t":"b","t"==n?(k.addClass("ui-timepicker-positioned-top"),m.top=e.offset().top-k.outerHeight()+parseInt(k.css("marginTop").replace("px",""),10)):(k.removeClass("ui-timepicker-positioned-top"),m.top=e.offset().top+e.outerHeight()+parseInt(k.css("marginTop").replace("px",""),10)),k.offset(m);var o=k.find(".ui-timepicker-selected");if(!o.length){var p=t(l(e));null!==p?o=i(e,k,p):f.scrollDefault&&(o=i(e,k,f.scrollDefault()))}if((!o.length||o.hasClass("ui-timepicker-disabled"))&&(o=k.find("li:not(.ui-timepicker-disabled):first")),o&&o.length){var q=k.scrollTop()+o.position().top-o.outerHeight();k.scrollTop(q)}else k.scrollTop(0);return f.stopScrollPropagation&&a(document).on("wheel.ui-timepicker",".ui-timepicker-wrapper",function(b){b.preventDefault();var c=a(this).scrollTop();a(this).scrollTop(c+b.originalEvent.deltaY)}),a(document).on("touchstart.ui-timepicker mousedown.ui-timepicker",g),a(window).on("resize.ui-timepicker",g),f.closeOnWindowScroll&&a(document).on("scroll.ui-timepicker",g),e.trigger("showTimepicker"),this}},hide:function(c){var d=a(this),e=d.data("timepicker-settings");return e&&e.useSelect&&d.blur(),a(".ui-timepicker-wrapper").each(function(){var c=a(this);if(b(c)){var d=c.data("timepicker-input"),e=d.data("timepicker-settings");e&&e.selectOnBlur&&q(d),c.hide(),d.trigger("hideTimepicker")}}),this},option:function(b,e){return"string"==typeof b&&"undefined"==typeof e?a(this).data("timepicker-settings")[b]:this.each(function(){var f=a(this),g=f.data("timepicker-settings"),h=f.data("timepicker-list");"object"==typeof b?g=a.extend(g,b):"string"==typeof b&&(g[b]=e),g=c(g),f.data("timepicker-settings",g),k.call(f.get(0),{type:"change"},"initial"),h&&(h.remove(),f.data("timepicker-list",!1)),g.useSelect&&d(f)})},getSecondsFromMidnight:function(){return t(l(this))},getTime:function(a){var b=this,c=l(b);if(!c)return null;var d=t(c);if(null===d)return null;a||(a=new Date);var e=new Date(a);return e.setHours(d/3600),e.setMinutes(d%3600/60),e.setSeconds(d%60),e.setMilliseconds(0),e},isVisible:function(){var a=this,c=a.data("timepicker-list");return!(!c||!b(c))},setTime:function(a){var b=this,c=b.data("timepicker-settings");if(c.forceRoundTime)var d=f(t(a),c);else var d=s(t(a),c);return a&&null===d&&c.noneOption&&(d=a),m(b,d,"initial"),k.call(b.get(0),{type:"change"},"initial"),b.data("timepicker-list")&&j(b,b.data("timepicker-list")),this},remove:function(){var a=this;if(a.hasClass("ui-timepicker-input")){var b=a.data("timepicker-settings");return a.removeAttr("autocomplete","off"),a.removeClass("ui-timepicker-input"),a.removeData("timepicker-settings"),a.off(".timepicker"),a.data("timepicker-list")&&a.data("timepicker-list").remove(),b.useSelect&&a.show(),a.removeData("timepicker-list"),this}}};a.fn.timepicker=function(b){return this.length?y[b]?this.hasClass("ui-timepicker-input")?y[b].apply(this,Array.prototype.slice.call(arguments,1)):this:"object"!=typeof b&&b?void a.error("Method "+b+" does not exist on jQuery.timepicker"):y.init.apply(this,arguments):this}});

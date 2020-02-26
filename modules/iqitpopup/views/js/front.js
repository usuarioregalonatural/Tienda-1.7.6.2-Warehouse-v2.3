/**
 * 2017 IQIT-COMMERCE.COM
 *
 * NOTICE OF LICENSE
 *
 * This file is licenced under the Software License Agreement.
 * With the purchase or the installation of the software in your application
 * you accept the licence agreement
 *
 *  @author    IQIT-COMMERCE.COM <support@iqit-commerce.com>
 *  @copyright 2017 IQIT-COMMERCE.COM
 *  @license   Commercial license (You can not resell or redistribute this software)
 *
 */

$(document).ready(function(){

    iqitpopup.script = (function() {

        var $el = $('#iqitpopup');
        var $overlay = $('#iqitpopup-overlay');
        var elHeight = $el.outerHeight();
        var elWidth = $el.outerWidth();
        var $wrapper = $( window );
        var offset = -30;

        var sizeData = {
            size: {
                width: $wrapper.width() + offset,
                height: $wrapper.height() + offset
            }
        };

        function init() {


            setTimeout(function() {
                $el.addClass('showed-iqitpopup');
                $overlay .addClass('showed-iqitpopupo');
            },  iqitpopup.delay);

            $el.find('.iqit-btn-newsletter').first().click(function() {
                setCookie();
                $overlay.removeClass('showed-iqitpopupo');
                $el.removeClass('showed-iqitpopup');
            });

            $(document).on('click', '#iqitpopup .cross, #iqitpopup-overlay', function () {
                $overlay.removeClass('showed-iqitpopupo');
                $el.removeClass('showed-iqitpopup');

                if ($("#iqitpopup-checkbox").is(':checked')) {
                    setCookie();
                }
            });
            doResize(sizeData, false);

            $wrapper.resize(function() {
                sizeData.size.width = $wrapper.width() + offset ;
                sizeData.size.height = $wrapper.height() + offset ;
                doResize(sizeData, true);

            });
        }


        function doResize(ui, resize) {
            if (elWidth >= ui.size.width  || elHeight >= ui.size.height) {
                var scale;
                scale = Math.min(
                    ui.size.width / elWidth,
                    ui.size.height / elHeight
                );
                $el.css({
                    transform: "translate(-50%, -50%) scale(" + scale + ")"
                });
            }
            else{
                if (resize){
                    $el.css({
                        transform: "translate(-50%, -50%) scale(1)"
                    });
                }
            }
        }

        function setCookie() {
            var name = iqitpopup.name;
            var value = '1';
            var expire = new Date();
            expire.setDate(expire.getDate() + iqitpopup.time);
            document.cookie = name + "=" + escape(value) + ";path=/;" + ((expire == null) ? "" : ("; expires=" + expire.toGMTString()))
        }

        return { init : init};

    })();

    iqitpopup.script.init();

});









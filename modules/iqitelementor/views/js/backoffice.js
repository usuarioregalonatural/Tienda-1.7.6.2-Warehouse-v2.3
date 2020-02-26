(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
var iqitElementorButton;

document.addEventListener("DOMContentLoaded", function (event) {

    $(document).ready(function () {


        iqitElementorButton = (function () {

            var $wrapperCms = $('form[name="cms_page"]').first().find('.card-block').first().find('.card-text').first(),
                $wrapperProduct = $('#features'),
                $wrapperBlog = $('#elementor-button-blog-wrapper'),
                $wrapperCategory = $('form[name="category"]').first().find('.card-block').first().find('.card-text').first(),
                $btnTemplate = $('#tmpl-btn-edit-with-elementor'),
                $btnTemplateProduct = $('#tmpl-btn-edit-with-elementor-product'),
                $btnTemplateBlog = $('#tmpl-btn-edit-with-elementor-blog'),
                $btnTemplateCategory = $('#tmpl-btn-edit-with-elementor-category');

            function init() {
                $wrapperCms.prepend($btnTemplate.html());
                $wrapperProduct.prepend($btnTemplateProduct.html());
                $wrapperBlog.prepend($btnTemplateBlog.html());
                $wrapperCategory.prepend($btnTemplateCategory.html());

                if (typeof elementorPageType !== 'undefined') {

                    if (elementorPageType == 'cms') {
                        var hideEditor = false;
                        jQuery.each(onlyElementor, function (i, val) {
                            if (val) {
                                hideEditor = true;
                            }
                        });
                        if (hideEditor) {
                            let $cmsPageContent =  $("#cms_page_content");
                            $cmsPageContent.first().parents('.form-group').last().hide();
                            $cmsPageContent.find('.autoload_rte').removeClass('autoload_rte');
                        }
                    }

                    if (elementorPageType == 'blog') {
                        var  hideEditor = false;
                        jQuery.each(onlyElementor, function(i, val) {
                            if(val){
                                hideEditor = true;
                            }
                        });
                        if (hideEditor){
                            $("[id^=content_]").first().parents('.form-group').last().remove();
                        }
                    }

                    if (elementorPageType == 'category') {
                        var $form = $('form[name="category"]').first();
                        $form.submit(function (event) {
                            $.ajax({
                                type: 'POST',
                                url: elementorAjaxUrl,
                                data: {
                                    action: 'categoryLayout',
                                    categoryId: $form.find("input[name='idPageElementor']").val(),
                                    justElementor: $form.find("input[name='justElementor']:checked").val()
                                },
                                success: function (resp) {
                                },
                                error: function () {
                                    console.log("error");
                                }
                            });

                        });

                    }
                }

            }

            return {init: init};

        })();

        iqitElementorButton.init();


    });

});

},{}]},{},[1])
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIm5vZGVfbW9kdWxlcy9icm93c2VyLXBhY2svX3ByZWx1ZGUuanMiLCJ2aWV3cy9fZGV2L2pzL2JhY2tvZmZpY2UvYmFja29mZmljZS5qcyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiQUFBQTtBQ0FBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBIiwiZmlsZSI6ImdlbmVyYXRlZC5qcyIsInNvdXJjZVJvb3QiOiIiLCJzb3VyY2VzQ29udGVudCI6WyIoZnVuY3Rpb24oKXtmdW5jdGlvbiByKGUsbix0KXtmdW5jdGlvbiBvKGksZil7aWYoIW5baV0pe2lmKCFlW2ldKXt2YXIgYz1cImZ1bmN0aW9uXCI9PXR5cGVvZiByZXF1aXJlJiZyZXF1aXJlO2lmKCFmJiZjKXJldHVybiBjKGksITApO2lmKHUpcmV0dXJuIHUoaSwhMCk7dmFyIGE9bmV3IEVycm9yKFwiQ2Fubm90IGZpbmQgbW9kdWxlICdcIitpK1wiJ1wiKTt0aHJvdyBhLmNvZGU9XCJNT0RVTEVfTk9UX0ZPVU5EXCIsYX12YXIgcD1uW2ldPXtleHBvcnRzOnt9fTtlW2ldWzBdLmNhbGwocC5leHBvcnRzLGZ1bmN0aW9uKHIpe3ZhciBuPWVbaV1bMV1bcl07cmV0dXJuIG8obnx8cil9LHAscC5leHBvcnRzLHIsZSxuLHQpfXJldHVybiBuW2ldLmV4cG9ydHN9Zm9yKHZhciB1PVwiZnVuY3Rpb25cIj09dHlwZW9mIHJlcXVpcmUmJnJlcXVpcmUsaT0wO2k8dC5sZW5ndGg7aSsrKW8odFtpXSk7cmV0dXJuIG99cmV0dXJuIHJ9KSgpIiwidmFyIGlxaXRFbGVtZW50b3JCdXR0b247XG5cbmRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoXCJET01Db250ZW50TG9hZGVkXCIsIGZ1bmN0aW9uIChldmVudCkge1xuXG4gICAgJChkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24gKCkge1xuXG5cbiAgICAgICAgaXFpdEVsZW1lbnRvckJ1dHRvbiA9IChmdW5jdGlvbiAoKSB7XG5cbiAgICAgICAgICAgIHZhciAkd3JhcHBlckNtcyA9ICQoJ2Zvcm1bbmFtZT1cImNtc19wYWdlXCJdJykuZmlyc3QoKS5maW5kKCcuY2FyZC1ibG9jaycpLmZpcnN0KCkuZmluZCgnLmNhcmQtdGV4dCcpLmZpcnN0KCksXG4gICAgICAgICAgICAgICAgJHdyYXBwZXJQcm9kdWN0ID0gJCgnI2ZlYXR1cmVzJyksXG4gICAgICAgICAgICAgICAgJHdyYXBwZXJCbG9nID0gJCgnI2VsZW1lbnRvci1idXR0b24tYmxvZy13cmFwcGVyJyksXG4gICAgICAgICAgICAgICAgJHdyYXBwZXJDYXRlZ29yeSA9ICQoJ2Zvcm1bbmFtZT1cImNhdGVnb3J5XCJdJykuZmlyc3QoKS5maW5kKCcuY2FyZC1ibG9jaycpLmZpcnN0KCkuZmluZCgnLmNhcmQtdGV4dCcpLmZpcnN0KCksXG4gICAgICAgICAgICAgICAgJGJ0blRlbXBsYXRlID0gJCgnI3RtcGwtYnRuLWVkaXQtd2l0aC1lbGVtZW50b3InKSxcbiAgICAgICAgICAgICAgICAkYnRuVGVtcGxhdGVQcm9kdWN0ID0gJCgnI3RtcGwtYnRuLWVkaXQtd2l0aC1lbGVtZW50b3ItcHJvZHVjdCcpLFxuICAgICAgICAgICAgICAgICRidG5UZW1wbGF0ZUJsb2cgPSAkKCcjdG1wbC1idG4tZWRpdC13aXRoLWVsZW1lbnRvci1ibG9nJyksXG4gICAgICAgICAgICAgICAgJGJ0blRlbXBsYXRlQ2F0ZWdvcnkgPSAkKCcjdG1wbC1idG4tZWRpdC13aXRoLWVsZW1lbnRvci1jYXRlZ29yeScpO1xuXG4gICAgICAgICAgICBmdW5jdGlvbiBpbml0KCkge1xuICAgICAgICAgICAgICAgICR3cmFwcGVyQ21zLnByZXBlbmQoJGJ0blRlbXBsYXRlLmh0bWwoKSk7XG4gICAgICAgICAgICAgICAgJHdyYXBwZXJQcm9kdWN0LnByZXBlbmQoJGJ0blRlbXBsYXRlUHJvZHVjdC5odG1sKCkpO1xuICAgICAgICAgICAgICAgICR3cmFwcGVyQmxvZy5wcmVwZW5kKCRidG5UZW1wbGF0ZUJsb2cuaHRtbCgpKTtcbiAgICAgICAgICAgICAgICAkd3JhcHBlckNhdGVnb3J5LnByZXBlbmQoJGJ0blRlbXBsYXRlQ2F0ZWdvcnkuaHRtbCgpKTtcblxuICAgICAgICAgICAgICAgIGlmICh0eXBlb2YgZWxlbWVudG9yUGFnZVR5cGUgIT09ICd1bmRlZmluZWQnKSB7XG5cbiAgICAgICAgICAgICAgICAgICAgaWYgKGVsZW1lbnRvclBhZ2VUeXBlID09ICdjbXMnKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgaGlkZUVkaXRvciA9IGZhbHNlO1xuICAgICAgICAgICAgICAgICAgICAgICAgalF1ZXJ5LmVhY2gob25seUVsZW1lbnRvciwgZnVuY3Rpb24gKGksIHZhbCkge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmICh2YWwpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgaGlkZUVkaXRvciA9IHRydWU7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAgICAgICAgICAgICBpZiAoaGlkZUVkaXRvcikge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGxldCAkY21zUGFnZUNvbnRlbnQgPSAgJChcIiNjbXNfcGFnZV9jb250ZW50XCIpO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICRjbXNQYWdlQ29udGVudC5maXJzdCgpLnBhcmVudHMoJy5mb3JtLWdyb3VwJykubGFzdCgpLmhpZGUoKTtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkY21zUGFnZUNvbnRlbnQuZmluZCgnLmF1dG9sb2FkX3J0ZScpLnJlbW92ZUNsYXNzKCdhdXRvbG9hZF9ydGUnKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgICAgIGlmIChlbGVtZW50b3JQYWdlVHlwZSA9PSAnYmxvZycpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciAgaGlkZUVkaXRvciA9IGZhbHNlO1xuICAgICAgICAgICAgICAgICAgICAgICAgalF1ZXJ5LmVhY2gob25seUVsZW1lbnRvciwgZnVuY3Rpb24oaSwgdmFsKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgaWYodmFsKXtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgaGlkZUVkaXRvciA9IHRydWU7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAgICAgICAgICAgICBpZiAoaGlkZUVkaXRvcil7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJChcIltpZF49Y29udGVudF9dXCIpLmZpcnN0KCkucGFyZW50cygnLmZvcm0tZ3JvdXAnKS5sYXN0KCkucmVtb3ZlKCk7XG4gICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgICAgICBpZiAoZWxlbWVudG9yUGFnZVR5cGUgPT0gJ2NhdGVnb3J5Jykge1xuICAgICAgICAgICAgICAgICAgICAgICAgdmFyICRmb3JtID0gJCgnZm9ybVtuYW1lPVwiY2F0ZWdvcnlcIl0nKS5maXJzdCgpO1xuICAgICAgICAgICAgICAgICAgICAgICAgJGZvcm0uc3VibWl0KGZ1bmN0aW9uIChldmVudCkge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICQuYWpheCh7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHR5cGU6ICdQT1NUJyxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdXJsOiBlbGVtZW50b3JBamF4VXJsLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBkYXRhOiB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBhY3Rpb246ICdjYXRlZ29yeUxheW91dCcsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjYXRlZ29yeUlkOiAkZm9ybS5maW5kKFwiaW5wdXRbbmFtZT0naWRQYWdlRWxlbWVudG9yJ11cIikudmFsKCksXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBqdXN0RWxlbWVudG9yOiAkZm9ybS5maW5kKFwiaW5wdXRbbmFtZT0nanVzdEVsZW1lbnRvciddOmNoZWNrZWRcIikudmFsKClcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgc3VjY2VzczogZnVuY3Rpb24gKHJlc3ApIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgZXJyb3I6IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNvbnNvbGUubG9nKFwiZXJyb3JcIik7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9KTtcblxuICAgICAgICAgICAgICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICByZXR1cm4ge2luaXQ6IGluaXR9O1xuXG4gICAgICAgIH0pKCk7XG5cbiAgICAgICAgaXFpdEVsZW1lbnRvckJ1dHRvbi5pbml0KCk7XG5cblxuICAgIH0pO1xuXG59KTtcbiJdfQ==

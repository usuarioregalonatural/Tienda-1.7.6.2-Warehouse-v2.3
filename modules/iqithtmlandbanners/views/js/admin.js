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



$(document).ready(function () {
    var uploaderIqitBanners = (function () {
        var $tmpl = $('#tmpl-iqitbanner'),
            $bannersContainer = $('#iqit-banners'),
            $bannersField = $('#iqit-banners-field');
        var tmplHtml = $tmpl.html(),
            imageRow = '';

        return {
            'init': function init() {

                $('#banners').on('fileuploaddone', function (e, data) {

                    if (typeof data.result.banners !== 'undefined') {
                        for (var i = 0; i < data.result.banners.length; i++) {
                            if (data.result.banners[i] !== null) {
                                if (typeof data.result.banners[i].error !== 'undefined' && data.result.banners[i].error != '') {
                                    console.log('upload error')
                                }
                                else {
                                    if (typeof data.result.banners[i].name !== 'undefined') {

                                        imageRow = tmplHtml.replace(new RegExp('::imgSrc::', 'g'), data.result.banners[i].name);
                                        $bannersContainer.append(imageRow);

                                    }
                                }
                            }
                        }
                    }
                });

                //init sortable
                $bannersContainer.sortable({
                    items: "div.js-list-group-item",
                    opacity: 0.9,
                    containment: 'parent',
                    distance: 42,
                    tolerance: 'pointer',
                    handle: '.js-iqit-banner-reorder',
                    placeholder: 'js-list-group-item-highlight',
                    cursorAt: {
                        left: 64,
                        top: 64
                    },
                    cancel: '.disabled',
                    start: function start(event, ui) {
                        //init zindex
                        $bannersContainer.find('div.js-list-group-item').css('zIndex', 1);
                        ui.item.css('zIndex', 10);
                    }
                });

                $bannersContainer.on('click', '.js-iqit-banner-delete', function () {
                    $(this).parents('.list-group-item').first().remove();
                });

                if (typeof iqitBannerPage !== "undefined") {
                    $('button[name="submitIqitHtmlAndBanner"]').on('click', function(e) {
                        var bannersArr = [], bannersFull = {banners: [], options:{}},
                            $banners = $bannersContainer.find('.js-list-group-item');

                        $banners.each(function() {
                            var $el = $(this),
                                imgSrc = $el.find('.js-iqit-banner-image').first().data('image'),
                                status = $el.find('.js-iqit-banner-active').first().prop('checked'),
                                url = $el.find('.js-iqit-banner-link').first().val(),
                                language = $el.find('.js-iqit-banner-language').first().val(),
                                banner;
                            banner = {img: imgSrc, status: status, url: url, language: language};
                            bannersArr.push(banner);
                        });

                        bannersFull.banners = bannersArr;
                        bannersFull.options.view = $('.js-iqit-banner-options-view').first().val();

                        if($.isEmptyObject(bannersArr)){
                            $bannersField.val('');
                        }
                        else{
                            $bannersField.val(JSON.stringify(bannersFull));
                        }
                    });
                }
            }
        };
    })();

    uploaderIqitBanners.init();

});




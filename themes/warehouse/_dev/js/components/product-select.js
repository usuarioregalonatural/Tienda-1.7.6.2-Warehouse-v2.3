/**
 * 2007-2017 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
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
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2017 PrestaShop SA
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */
import $ from 'jquery';

export default class ProductSelect {
    init() {
        let easyzoomInstance;
        let carouselInstance;
        let $productThumbs;
        let $wrapper = $('#wrapper');

        $wrapper.on('show.bs.modal', '#product-modal', function (e) {
            let newSrc = $('#product-images-large .slick-current img').first().data('image-large-src');
            $('.js-modal-product-cover-easyzoom').first().attr('href', newSrc);
            $('.js-modal-product-cover').first().attr('src', newSrc);

            if (iqitTheme.pp_zoom == 'inner' || iqitTheme.pp_zoom == 'modalzoom') {
                let easyzoom = $('.easyzoom-modal').easyZoom();
                easyzoomInstance = easyzoom.data('easyZoom');
            } else{
                $wrapper.on('click', '.js-modal-product-cover-easyzoom', (event) => {
                   event.preventDefault();
                });
            }
        });

        $wrapper.on('shown.bs.modal', '#product-modal', function (e) {
            $productThumbs = $('#modal-product-thumbs');
            carouselInstance = $productThumbs.slick({
                slidesToShow: 10,
                slidesToScroll: 10,
                dots: false,
                arrows: true,
                focusOnSelect: true,
                responsive: [
                    {
                        breakpoint: 575,
                        settings: {
                            slidesToShow: 6,
                            slidesToScroll: 6,
                        }
                    },
                    {
                        breakpoint: 420,
                        settings: {
                            slidesToShow: 5,
                            slidesToScroll: 5,
                        }
                    },
                ]
            });
        });

        $wrapper.on('hidden.bs.modal', '#product-modal', function (e) {
            if (iqitTheme.pp_zoom == 'inner' || iqitTheme.pp_zoom == 'modalzoom') {
                easyzoomInstance.teardown();
            }
            $productThumbs.slick('unslick');
        });

        $('body').on('click', '.js-modal-thumb', (event) => {
            if (iqitTheme.pp_zoom == 'inner' || iqitTheme.pp_zoom == 'modalzoom') {
                easyzoomInstance.swap($(event.target).data('image-large-src'), $(event.target).data('image-large-src'));
            } else {
                $('.js-modal-product-cover').attr('src', $(event.target).data('image-large-src'));
            }
        });
    }
}

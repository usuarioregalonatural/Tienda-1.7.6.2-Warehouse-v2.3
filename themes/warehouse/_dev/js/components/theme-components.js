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
import debounce from 'throttle-debounce/debounce';

export default class ThemeCompontents {

    init() {
        this.backToTop();
        this.productCarousels();
        this.otherCarousels();

        if (iqitTheme.op_preloader) {
            this.pagePreloader();
        }
    }

    backToTop() {

        let $backToTop = $('#back-to-top');

        $(window).scroll(debounce(300, function () {
            if ($(this).scrollTop() > 300) {
                $backToTop.addClass('-back-to-top-visible');
            } else {
                $backToTop.stop().removeClass('-back-to-top-visible');
            }
        }));

        $backToTop.on('click', function (event) {
            event.preventDefault();
            $('body, html').animate({
                    scrollTop: 0,
                }, 300
            );
        });
    }

    productCarousels(){

        let $carousels = $('.slick-default-carousel');
        let defaultOptions = {
            dots: true,
            accessibility: false,
            speed: 300,
            autoplay: iqitTheme.pl_crsl_autoplay,
            autoplaySpeed: 4500,
            slidesToShow: iqitTheme.pl_slider_ld,
            slidesToScroll: iqitTheme.pl_slider_ld,
            infinite: false,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: iqitTheme.pl_slider_d,
                        slidesToScroll: iqitTheme.pl_slider_d
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: iqitTheme.pl_slider_t,
                        slidesToScroll: iqitTheme.pl_slider_t
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: iqitTheme.pl_slider_p,
                        slidesToScroll: iqitTheme.pl_slider_p
                    }
                },
            ]
        };

        $carousels.each(function() {
            let $carousel = $(this);
            let slickOptions = $.extend({}, defaultOptions, $carousel.data('slider_options'));
            $carousel.slick( slickOptions );
        });

    }

    otherCarousels(){

       $('.js-iqithtmlandbanners-block-banner-slider').slick({
           arrows: false,
           autoplay: true,
           autoplaySpeed: 5000,
           dots: true,
       });

    }

    pagePreloader() {

        $(window).load(function () {
            $('#page-preloader').fadeOut('slow', function () {
                $(this).remove();
            });
            $('#main-page-content').removeAttr('style');
        });

    }
}

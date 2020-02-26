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

export default class ThemeOptions {

    init() {

        if (iqitTheme.h_layout != 6 && iqitTheme.h_layout != 7) {
            if (iqitTheme.h_sticky == 'menu' || iqitTheme.h_sticky == 'header') {
                this.stickyHeader(iqitTheme.h_sticky);
            }
        }

        if (iqitTheme.f_fixed) {
            let isIE11 = !!window.MSInputMethodContext && !!document.documentMode;
            if (!isIE11){
                $('#footer').footerReveal({shadow: false, zIndex: -1});
            }
        }

        if( 'ontouchstart' in document.documentElement ) {
            $('body').addClass('touch-device');
        }
    }

    stickyHeader(scrollElement) {
        let $header;
        let $stickyCartWrapper;
        let $defaultCartWrapper;
        let $cart;
        let handler;

        if (scrollElement == 'menu') {
            $header = $('#iqitmegamenu-wrapper');
            $stickyCartWrapper = $('#sticky-cart-wrapper');
            $defaultCartWrapper = $('#ps-shoppingcart-wrapper');
            $cart = $('#ps-shoppingcart');
            handler = function(direction) {
                if (direction == 'down'){
                    $stickyCartWrapper.append($cart);
                } else{
                    $defaultCartWrapper.append($cart);
                }
            };
        } else {
            $header = $('#desktop-header');
            handler = function(direction) {};
        }


        if ( $header.length ) {
            let sticky = new Waypoint.Sticky({
                element: $header[0],
                wrapper: '<div class="sticky-desktop-wrapper" />',
                stuckClass: 'stuck stuck-' + scrollElement,
                handler: handler,
                offset: 0
            })
        }
    }
}

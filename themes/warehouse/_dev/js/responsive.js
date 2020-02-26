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
import prestashop from 'prestashop';

prestashop.responsive = prestashop.responsive || {};

prestashop.responsive.current_width = window.innerWidth;
prestashop.responsive.min_width = 991;
prestashop.responsive.mobile = prestashop.responsive.current_width <= prestashop.responsive.min_width;

function swapChildren(obj1, obj2) {
    var temp = obj2.children().detach();
    obj2.empty().append(obj1.children().detach());
    obj1.append(temp);
}

function toggleMobileStyles() {
    if (prestashop.responsive.mobile) {
        $("*[id^='_desktop_']").each(function (idx, el) {
            var target = $('#' + el.id.replace('_desktop_', '_mobile_'));
            if (target) {
                swapChildren($(el), target);
            }
        });
    } else {
        $("*[id^='_mobile_']").each(function (idx, el) {
            var target = $('#' + el.id.replace('_mobile_', '_desktop_'));
            if (target) {
                swapChildren($(el), target);
            }
        });
    }

    prestashop.emit('responsive update', {
        mobile: prestashop.responsive.mobile
    });
}

function switchMobileStylesCart() {
    if (prestashop.responsive.mobile) {
        $("*[id^='_desktop_blockcart']").each(function (idx, el) {
            var target = $('#' + el.id.replace('_desktop_blockcart', '_mobile_blockcart'));
            if (target) {
                swapChildren($(el), target);
            }
        });
    }
}

function makeStickyHeader(scrollDirection) {

    let $mobileHeader = $('#mobile-header-sticky');

    if (scrollDirection == 'up') {
        $mobileHeader.stickyUpHeader();
    }
    if ( $mobileHeader.length ) {
        let sticky = new Waypoint.Sticky({
            element: $mobileHeader[0],
            wrapper: '<div class="sticky-mobile-wrapper" />',
            stuckClass: 'stuck stuck-' + scrollDirection,
        })
    }
}

$(window).on('resize', function () {
    var _cw = prestashop.responsive.current_width;
    var _mw = prestashop.responsive.min_width;
    var _w = window.innerWidth;
    var _toggle = (_cw >= _mw && _w < _mw) || (_cw < _mw && _w >= _mw);
    prestashop.responsive.current_width = _w;
    prestashop.responsive.mobile = prestashop.responsive.current_width <= prestashop.responsive.min_width;
    if (_toggle) {
        toggleMobileStyles();
    }
});

$(document).ready(function () {

    if (iqitTheme.rm_breakpoint == 1) {
        prestashop.responsive.min_width = 5000;
        prestashop.responsive.mobile = true;
    }

    if (prestashop.responsive.mobile) {
        toggleMobileStyles();
    }

    prestashop.on('responsive updateAjax', function(event) {
        switchMobileStylesCart();
    });

    if (iqitTheme.rm_sticky == 'up' || iqitTheme.rm_sticky == 'down') {
        makeStickyHeader(iqitTheme.rm_sticky);
    }
});


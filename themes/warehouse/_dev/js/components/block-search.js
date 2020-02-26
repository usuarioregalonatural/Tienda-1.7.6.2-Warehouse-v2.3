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
import autoComplete from '../lib/jquery.auto-complete';

export default class BlockSearch {
    init() {
        let $searchWidget = $('#search_widget');
        let $searchWidgetMobile = $('#search-widget-mobile');
        let $searchBox = $searchWidget.find('input[type=text]');
        let $searchBoxMobile = $searchWidgetMobile.find('input[type=text]');
        let searchURL = $searchWidget.attr('data-search-controller-url');
        let $searchToggle = $('#header-search-btn');
        let $searchToggleMobile = $('#mobile-btn-search');

        this.autocomplete($searchWidget, $searchBox, searchURL);
        this.autocomplete($searchWidgetMobile, $searchBoxMobile, searchURL);

        $searchToggle.on('shown.bs.dropdown', function () {
            setTimeout(function(){
                $searchBox.focus();
            }, 300);
        });

        $searchToggleMobile.on('shown.bs.dropdown', function () {
            setTimeout(function(){
                $('#mobile-btn-search').find('input[type=text]').focus();
            }, 300);
        });

        $('#fullscreen-search-backdrop').on('touchstart', function(e){
            e.stopPropagation();
            $('#header-search-btn-drop').dropdown('toggle');
        });
    }

    autocomplete($searchWidget, $searchBox, searchURL) {

        let xhr;
        let resultsPerPage = 10;
        let allText = $searchBox.data('all-text');

        let iqitSearchAutocomplete = $searchBox.autoComplete({
            minChars: 2,
            cache: false,
            source: function (query, response) {
                try { xhr.abort(); } catch(e){}
                xhr = $.post(searchURL, {
                    s: query,
                    resultsPerPage: resultsPerPage,
                    ajax: true
                }, null, 'json')
                    .then(function (resp) {
                        let showAll = {type: 'all'};
                        if (resp.products.length >= resultsPerPage){
                            resp.products.push(showAll);
                        }
                        response(resp.products);
                    })
                    .fail(response);
            },
            renderItem: function (product, search) {
                if(product.type == 'all') {
                    return '<div class="autocomplete-suggestion autocomplete-suggestion-show-all dropdown-item" data-type="all" data-val="'+ search + '">' +
                        '<div class="row no-gutters align-items-center">' +
                        '<div class="col"><span class="name">' + allText + ' <i class="fa fa-angle-right" aria-hidden="true"></i></span></div>' +
                        '</div>' +
                        '</div>';
                }
                else {
                    let imageHtml = '';
                    try{ imageHtml = '<div class="col col-auto col-img"><img class="img-fluid" src="' + product.cover.small.url + '" /></div>';} catch(e){ imageHtml = ''; }
                    return '<div class="autocomplete-suggestion dropdown-item" data-url="' + product.url + '">' +
                        '<div class="row no-gutters align-items-center">' + imageHtml +
                        '<div class="col"><span class="name">' + product.name + '</span><span class="product-price">' + product.price + '</span></div>' +
                        '</div>' +
                        '</div>';
                }
            },
            onSelect: function (e, term, item) {
                if (item.data('type') == 'all'){
                    $searchWidget.find('form').submit();
                } else{
                    window.location.href = item.data('url');
                }

            }
        });
    }

}
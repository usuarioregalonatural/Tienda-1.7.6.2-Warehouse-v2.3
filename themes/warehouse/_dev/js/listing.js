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
import ProductMinitature from './components/product-miniature';
import LazyLoad from 'vanilla-lazyload/dist/lazyload.min';
import infiniteScroll from './components/infinite-scroll';


$(document).ready(() => {

  let $body = $('body');
  let $productDiv = $('#products');

  prestashop.iqitLazyLoad = new LazyLoad({
      elements_selector: '.js-lazy-product-image',
      threshold: 600,
      class_loading: 'lazy-product-loading'
  });

  if (iqitTheme.pl_infinity) {
      infiniteScroll($productDiv);
  }

  $(document).ready(function () {
    $body.on('click', '.js-quick-view-iqit', function (event) {
      let elm = $(event.target).closest('.js-product-miniature');
      prestashop.emit('clickQuickView', {
        miniature: elm,
        dataset: elm.data()
      });
      event.preventDefault();
    })
  });

  prestashop.on('clickQuickView', function (elm) {

    let data = {
      'action': 'quickview',
      'id_product': elm.dataset.idProduct,
      'id_product_attribute': elm.dataset.idProductAttribute,
    };

    let prevProductMinature = elm.miniature.parent().prev().children('.js-product-miniature').first();
    let nextProductMinature = elm.miniature.parent().next().children('.js-product-miniature').first();

    $.post(prestashop.urls.pages.product, data, null, 'json').then(function (resp) {
      let $quickModal = $('.modal.quickview').first();
      if ($quickModal.length) {
          showQuickViewModal($body, resp, prevProductMinature, nextProductMinature, $quickModal);
      } else{
          showQuickViewModal($body, resp, prevProductMinature, nextProductMinature, false);
      }
    }).fail((resp) => {
      prestashop.emit('handleError', {eventType: 'clickQuickView', resp: resp});
    });
  });


  var showQuickViewModal = ($body, resp, prevProductMinature, nextProductMinature, $oldModal) => {


    var quickViewAfterShown = (productModal) => {

      let fade = false;
      if (iqitTheme.pp_zoom == 'inner') {
        fade = true;
      }

      $productCover = productModal.find('#product-images-large');
      $productCover.slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        fade: fade,
        lazyLoad: 'ondemand',
      });

      if (iqitTheme.pp_zoom == 'inner') {
        let $easyzoom = productModal.find('.easyzoom-product').easyZoom();
      } else {
        productModal.find('.js-easyzoom-trigger').on('click', (event) => {
          event.preventDefault();
        });
      }

      $('.modal-backdrop.show').first().addClass('backdrop-second');

      prestashop.emit('quickViewShown', {
        modal: productModal
      });

    };

    if(!$oldModal){
      $body.append(resp.quickview_html);
    } else{
      $oldModal.find('#quickview-modal-product-content').replaceWith($(resp.quickview_html).find('#quickview-modal-product-content'));
    }

    let productModal = $(`#quickview-modal`);
    let $prevQuickViewBtn = $('#js-quickview-prev-btn');
    let $nextQuickViewBtn =  $('#js-quickview-next-btn');

    if(!prevProductMinature.length){
      $prevQuickViewBtn.hide();
    }
    if(!nextProductMinature.length){
      $nextQuickViewBtn.hide();
    }

    $prevQuickViewBtn.on('click', function (event) {
      let elm = prevProductMinature;
      prestashop.emit('clickQuickView', {
        miniature: elm,
        dataset: elm.data()
      });
      event.preventDefault();
    });

    $nextQuickViewBtn.on('click', function (event) {
      let elm = nextProductMinature;
      prestashop.emit('clickQuickView', {
        miniature: elm,
        dataset: elm.data()
      });
      event.preventDefault();
    });


    if(!$oldModal){
      productModal.modal('show');
      productModal.on('shown.bs.modal', function () {
        quickViewAfterShown(productModal);
      });
      productModal.on('hide.bs.modal', function () {
        productModal.remove();
        $('#iqitsizecharts-modal').remove();
      });
    } else{
        quickViewAfterShown(productModal);
    }

    let sizeChartModal = $('#iqitsizecharts-modal');
    let $productCover;

    productModal.find('#quantity_wanted').TouchSpin({
      verticalbuttons: true,
      verticalupclass: 'fa fa-angle-up touchspin-up',
      verticaldownclass: 'fa fa-angle-down touchspin-down',
      buttondown_class: 'btn btn-touchspin js-touchspin',
      buttonup_class: 'btn btn-touchspin js-touchspin',
      min: 1,
      max: 1000000
    });

    sizeChartModal.on('show.bs.modal', function () {
      sizeChartModal.detach();
      sizeChartModal.appendTo('body');
      $(this).addClass('fv-modal-stack');
      productModal.addClass('quickview-second-modal');
    });

  };

  $body.on('click', '#search_filter_toggler', function () {
    $('#search_filters_wrapper').removeClass('hidden-sm-down');
    $('#content-wrapper').addClass('hidden-sm-down');
    $('#footer').addClass('hidden-sm-down');
    $('#left-column, #right-column').addClass('-only-facet-search');
  });

  $body.on('click', '#search_center_filter_toggler', function () {
    $('#facets_search_center').slideToggle('100');
  });

  $('#search_filter_controls .ok, #search_filter_controls .js-search-filters-clear-all').on('click', function () {
    $('#search_filters_wrapper').addClass('hidden-sm-down');
    $('#content-wrapper').removeClass('hidden-sm-down');
    $('#footer').removeClass('hidden-sm-down');
    $('#left-column, #right-column').removeClass('-only-facet-search');
    prestashop.iqitLazyLoad.update();
  });

  const parseSearchUrl = function (event) {
    if (event.target.dataset.searchUrl !== undefined) {
      return event.target.dataset.searchUrl;
    }

    if ($(event.target).parent()[0].dataset.searchUrl === undefined) {
      throw new Error('Can not parse search URL');
    }

    return $(event.target).parent()[0].dataset.searchUrl;
  };

  $body.on('change', '#search_filters input[data-search-url]', function (event) {
    console.log(event);
    prestashop.emit('updateFacets', parseSearchUrl(event));
  });

  $body.on('click', '.js-search-filters-clear-all', function (event) {
    prestashop.emit('updateFacets', parseSearchUrl(event));
  });

  $body.on('click', '.js-search-link', function (event) {
    event.preventDefault();
    prestashop.emit('updateFacets',$(event.target).closest('a').get(0).href);

    if($(event.target).data('afterClick') == 'backToTop'){
      prestashop.emit('updateFacetsBackToTop',$(event.target).closest('a').get(0).href);
    }
  });

  $body.on('change', '#search_filters select', function (event) {
    const form = $(event.target).closest('form');
    prestashop.emit('updateFacets', '?' + form.serialize());
  });

  $body.on('click', '[data-button-action="change-list-view"]', (event) => {
        console.log(event.currentTarget.getAttribute('data-view'));
      }
  );

  prestashop.on('updateFacets', () => {
    $productDiv.addClass('-facets-loading');
  });


  prestashop.on('updateFacetsBackToTop', () => {
    window.scrollTo(0, 0);
  });



  prestashop.on('updateProductList', (data) => {
    updateProductListDOM(data);
    prestashop.emit('afterUpdateProductListFacets');
    prestashop.emit('afterUpdateProductList');
  });

  prestashop.on('afterUpdateProductList', (data) => {

    if(!('ontouchstart' in document.documentElement)) {
      $('body > .tooltip.bs-tooltip-top').remove();
      $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })
    }

    prestashop.iqitLazyLoad.update();
    $productDiv.removeClass('-facets-loading');

  });

});

function updateProductListDOM (data) {
  $('#search_filters').replaceWith(data.rendered_facets);
  $('#js-active-search-filters').replaceWith(data.rendered_active_filters);
  $('#js-product-list-top').replaceWith(data.rendered_products_top);
  $('#js-product-list').replaceWith(data.rendered_products);
  $('#js-product-list-bottom').replaceWith(data.rendered_products_bottom);
  if (data.rendered_products_header) {
    $('#js-product-list-header').replaceWith(data.rendered_products_header);
  }

  let productMinitature = new ProductMinitature();
  productMinitature.init();
}


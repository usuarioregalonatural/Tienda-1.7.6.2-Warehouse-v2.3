/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';
	
	__webpack_require__(1);
	
	__webpack_require__(2);

/***/ }),
/* 1 */
/***/ (function(module, exports) {

	'use strict';
	
	$(document).ready(function () {
	
	    $('#iqitwishlist-nb').text(iqitwishlist.nbProducts);
	
	    $('body').on('click', '.js-iqitwishlist-add', function (event) {
	        var self = this;
	        prestashop.emit('clickIqitWishlistAdd', {
	            dataset: self.dataset,
	            self: self
	        });
	        event.preventDefault();
	    });
	
	    $('body').on('click', '.js-iqitwishlist-remove', function (event) {
	
	        var self = this;
	        prestashop.emit('clickIqitWishlistRemove', {
	            dataset: self.dataset
	        });
	        event.preventDefault();
	    });
	
	    prestashop.on('clickIqitWishlistAdd', function (elm) {
	
	        var data = {
	            'process': 'add',
	            'ajax': 1,
	            'idProduct': elm.dataset.idProduct,
	            'idProductAttribute': elm.dataset.idProductAttribute
	        };
	
	        $.post(elm.dataset.url, data, null, 'json').then(function (resp) {
	
	            if (!resp.success && resp.data.type == 'notLogged') {
	                var quickModal = $('.modal.quickview').first();
	
	                if (quickModal.length) {
	                    $(quickModal).modal('hide');
	                    $(quickModal).on('hidden.bs.modal', function (e) {
	                        $('#iqitwishlist-modal').modal('show');
	                    });
	                } else {
	                    $('#iqitwishlist-modal').modal('show');
	                }
	
	                return;
	            }
	            $(elm.self).addClass('iqitwishlist-added');
	            if (resp.success) {
	                (function () {
	                    iqitwishlist.nbProducts++;
	                    $('#iqitwishlist-nb').text(iqitwishlist.nbProducts);
	
	                    var $notification = $('#iqitwishlist-notification');
	                    $notification.addClass('ns-show');
	
	                    setTimeout(function () {
	                        $notification.removeClass('ns-show');
	                    }, 3500);
	                })();
	            }
	        }).fail(function (resp) {
	            prestashop.emit('handleError', { eventType: 'clickIqitWishlistAdd', resp: resp });
	        });
	    });
	
	    prestashop.on('clickIqitWishlistRemove', function (elm) {
	
	        var data = {
	            'process': 'remove',
	            'ajax': 1,
	            'idProduct': elm.dataset.idProduct
	        };
	
	        $.post(elm.dataset.url, data, null, 'json').then(function (resp) {
	            console.log('#iqitwishlist-product-' + elm.dataset.idProduct);
	            $('#iqitwishlist-product-' + elm.dataset.idProduct).remove();
	            iqitwishlist.nbProducts--;
	            $('#iqitwishlist-nb').text(iqitwishlist.nbProducts);
	
	            if (iqitwishlist.nbProducts == 0) {
	                $('#iqitwishlist-warning').removeClass('hidden-xs-up');
	                $('#iqitwishlist-crosseling, #iqitwishlist-share').addClass('hidden-xs-up');
	            }
	        }).fail(function (resp) {
	            prestashop.emit('handleError', { eventType: 'clickIqitWishlistRemove', resp: resp });
	        });
	    });
	
	    prestashop.on('updatedProduct', function (elm) {
	        $('#iqit-wishlist-product-btn').data('id-product-attribute', elm.id_product_attribute);
	        $('#iqit-wishlist-product-btn').attr('data-id-product-attribute', elm.id_product_attribute);
	    });
	
	    $('#iqitwishlist-clipboard-btn').on('click', function () {
	
	        var $btn = $(this);
	
	        var copyInput = $btn.closest('.input-group').children('input.js-to-clipboard');
	        copyInput.select();
	
	        try {
	            var successful = document.execCommand('copy');
	            if (successful) {
	                $btn.text($btn.data('textCopied'));
	                setTimeout(function () {
	                    $btn.text($btn.data('textCopy'));
	                }, 1500);
	            }
	        } catch (err) {
	            console.log('Oops, unable to copy');
	        }
	    });
	});

/***/ }),
/* 2 */
/***/ (function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);
//# sourceMappingURL=front.js.map
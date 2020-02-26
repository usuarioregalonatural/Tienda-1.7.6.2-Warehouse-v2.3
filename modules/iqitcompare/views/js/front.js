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
	
	    $('#iqitcompare-nb').text(iqitcompare.nbProducts);
	
	    $('body').on('click', '.js-iqitcompare-add', function (event) {
	        var self = this;
	        prestashop.emit('clickIqitCompareAdd', {
	            dataset: self.dataset,
	            self: self
	        });
	        event.preventDefault();
	    });
	
	    $('body').on('click', '.js-iqitcompare-remove', function (event) {
	
	        var self = this;
	        prestashop.emit('clickIqitCompareRemove', {
	            dataset: self.dataset
	        });
	        event.preventDefault();
	    });
	
	    $('body').on('click', '.js-iqitcompare-remove-all', function (event) {
	
	        var self = this;
	        prestashop.emit('clickIqitCompareRemoveAll', {
	            dataset: self.dataset
	        });
	        event.preventDefault();
	    });
	
	    prestashop.on('clickIqitCompareAdd', function (elm) {
	
	        var data = {
	            'process': 'add',
	            'ajax': 1,
	            'idProduct': elm.dataset.idProduct
	        };
	
	        $.post(elm.dataset.url, data, null, 'json').then(function (resp) {
	
	            if (resp.success) {
	                iqitcompare.nbProducts++;
	                $('#iqitcompare-nb').text(iqitcompare.nbProducts);
	            }
	
	            $(elm.self).addClass('iqitcompare-added');
	
	            var $notification = $('#iqitcompare-notification');
	            $notification.addClass('ns-show');
	
	            setTimeout(function () {
	                $notification.removeClass('ns-show');
	            }, 3500);
	        }).fail(function (resp) {
	            prestashop.emit('handleError', { eventType: 'clickIqitCompareAdd', resp: resp });
	        });
	    });
	
	    prestashop.on('clickIqitCompareRemove', function (elm) {
	
	        var data = {
	            'process': 'remove',
	            'ajax': 1,
	            'idProduct': elm.dataset.idProduct
	        };
	
	        $.post(elm.dataset.url, data, null, 'json').then(function (resp) {
	            $('.js-iqitcompare-product-' + elm.dataset.idProduct).remove();
	            iqitcompare.nbProducts--;
	            $('#iqitcompare-nb').text(iqitcompare.nbProducts);
	
	            if (iqitcompare.nbProducts == 0) {
	                $('#iqitcompare-table').remove();
	                $('#iqitcompare-warning').removeClass('hidden-xs-up');
	            }
	        }).fail(function (resp) {
	            prestashop.emit('handleError', { eventType: 'clickIqitCompareRemove', resp: resp });
	        });
	    });
	
	    prestashop.on('clickIqitCompareRemoveAll', function (elm) {
	
	        var data = {
	            'process': 'removeAll',
	            'ajax': 1
	        };
	
	        $.post(elm.dataset.url, data, null, 'json').then(function (resp) {
	
	            $('#iqitcompare-nb').text(0);
	            $('#iqitcompare-table').remove();
	            $('#iqitcompare-warning').removeClass('hidden-xs-up');
	        }).fail(function (resp) {
	            prestashop.emit('handleError', { eventType: 'clickIqitCompareRemove', resp: resp });
	        });
	    });
	});

/***/ }),
/* 2 */
/***/ (function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);
//# sourceMappingURL=front.js.map
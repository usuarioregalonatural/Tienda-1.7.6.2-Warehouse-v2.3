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

/***/ }),
/* 1 */
/***/ (function(module, exports) {

	/**
	 * IqitReviews management
	 */
	
	'use strict';
	
	$(document).ready(function () {
	
	    var iqitReviews = (function () {
	        var $statusLink = $('.iqitreviews_products .list-action-enable');
	
	        return {
	            'init': function init() {
	                $statusLink.click(function (e) {
	                    e.preventDefault();
	                    var $self = $(this);
	
	                    $.post($(this).attr('href') + '&ajax=1&action=statusProductReview', null, null, 'json').then(function (resp) {
	                        if (resp.success) {
	                            $self.toggleClass('action-disabled');
	                            $self.toggleClass('action-enabled');
	
	                            $self.find('.icon-check').toggleClass('hidden');
	                            $self.find('.icon-remove').toggleClass('hidden');
	                            showSuccessMessage(resp.text);
	                        } else {
	                            showErrorMessage(resp.text);
	                        }
	                    }).fail(function (resp) {
	                        console.log(resp);
	                    });
	                });
	            }
	        };
	    })();
	
	    iqitReviews.init();
	});

/***/ })
/******/ ]);
//# sourceMappingURL=admin.js.map
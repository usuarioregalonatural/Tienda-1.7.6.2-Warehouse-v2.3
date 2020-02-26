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
	
	__webpack_require__(7);
	
	__webpack_require__(9);

/***/ }),
/* 1 */,
/* 2 */,
/* 3 */,
/* 4 */,
/* 5 */,
/* 6 */,
/* 7 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }
	
	var _libThreesixtyThreesixtyMin = __webpack_require__(8);
	
	var _libThreesixtyThreesixtyMin2 = _interopRequireDefault(_libThreesixtyThreesixtyMin);
	
	$(document).ready(function () {
	    var videoIframes = undefined,
	        $videoIframesWrapper = undefined,
	        $videoModal = $('#iqit-iqitvideos-modal');
	
	    $('#iqit-threesixty-modal').on('shown.bs.modal', function () {
	        var iqitThreeSixtySlider = (0, _libThreesixtyThreesixtyMin2['default'])(document.querySelector('#iqit-threesixty'), $('#iqit-threesixty').data('threesixty'), {
	            interactive: true,
	            currentImage: 0
	        });
	        iqitThreeSixtySlider.init();
	    });
	
	    $videoModal.on('shown.bs.modal', function () {
	        $videoIframesWrapper = $('#iqitvideos-block');
	        videoIframes = $videoIframesWrapper.html();
	    });
	
	    $videoModal.on('hidden.bs.modal', function () {
	        $videoIframesWrapper.html(videoIframes);
	    });
	});

/***/ }),
/* 8 */
/***/ (function(module, exports) {

	'use strict';
	
	Object.defineProperty(exports, '__esModule', {
	    value: true
	});
	var threesixty = function threesixty(container, images, options) {
	    if (!container) {
	        throw new Error('A container argument is required');
	    }
	
	    if (!images) {
	        throw new Error('An images argument is required');
	    }
	
	    var defaults = {
	        interactive: true,
	        currentFrame: 0
	    };
	
	    var o = Object.assign({}, defaults, options);
	    var totalFrames = images.length;
	
	    var mouseX = 0;
	    var oldMouseX = 0;
	    var dragOrigin = false;
	    var dragTolerance = 10;
	    var swipeTolerance = 10;
	    var loopTimeoutId = null;
	    var looping = false;
	    var speed = 70;
	
	    //------------------------------------------------------------------------------
	    //
	    //  Initialisation
	    //
	    //------------------------------------------------------------------------------
	
	    var init = function init() {
	        preloadimages(images, start);
	    };
	
	    var preloadimages = function preloadimages(sourceImages, cb) {
	        var total = sourceImages.length;
	        var loaded = 0;
	
	        var onload = function onload() {
	            if (++loaded >= total) cb(finalImages);
	        };
	
	        var finalImages = sourceImages.map(function (item) {
	            var image = new Image();
	            image.src = item;
	            image.onload = onload;
	            image.onerror = onload;
	            image.onabort = onload;
	            image.draggable = false;
	            return image;
	        });
	    };
	
	    var start = function start(loadedImages) {
	        images = loadedImages;
	
	        emptyDomNode(container);
	        container.appendChild(images[o.currentFrame]);
	
	        initListeners();
	        play();
	    };
	
	    //------------------------------------------------------------------------------
	    //
	    //  Events
	    //
	    //------------------------------------------------------------------------------
	
	    var initListeners = function initListeners() {
	        //drag
	        container.addEventListener('mousedown', function (e) {
	            dragOrigin = e.pageX;
	        });
	
	        document.addEventListener('mouseup', function () {
	            dragOrigin = false;
	        });
	
	        document.addEventListener('mousemove', function (e) {
	            if (dragOrigin && Math.abs(dragOrigin - e.pageX) > dragTolerance) {
	                stop();
	                dragOrigin > e.pageX ? previous() : next();
	                dragOrigin = e.pageX;
	            }
	        });
	
	        //swipe
	        container.addEventListener('touchstart', function (e) {
	            dragOrigin = e.touches[0].clientX;
	        });
	
	        container.addEventListener('touchend', function () {
	            dragOrigin = false;
	        });
	
	        document.addEventListener('touchmove', function (e) {
	            if (dragOrigin && Math.abs(dragOrigin - e.touches[0].clientX) > swipeTolerance) {
	                stop();
	                dragOrigin > e.touches[0].clientX ? previous() : next();
	                dragOrigin = e.touches[0].clientX;
	            }
	        });
	    };
	
	    //------------------------------------------------------------------------------
	    //
	    //  Sequence management
	    //
	    //------------------------------------------------------------------------------
	
	    var replaceImage = function replaceImage() {
	        container.replaceChild(images[o.currentFrame], container.childNodes[0]);
	    };
	
	    var previous = function previous() {
	        o.currentFrame--;
	        if (o.currentFrame < 0) o.currentFrame = totalFrames - 1;
	        replaceImage();
	    };
	
	    var next = function next() {
	        o.currentFrame++;
	        if (o.currentFrame === totalFrames) o.currentFrame = 0;
	        replaceImage();
	    };
	
	    var isInteractive = function isInteractive() {
	        return o.interactive;
	    };
	    var getCurrentFrame = function getCurrentFrame() {
	        return o.currentFrame;
	    };
	
	    var play = function play() {
	        if (looping) {
	            return;
	        }
	
	        loop(false);
	        looping = true;
	    };
	
	    var stop = function stop() {
	        if (!looping) {
	            return;
	        }
	
	        window.clearTimeout(loopTimeoutId);
	        looping = false;
	    };
	
	    var loop = function loop(reversed) {
	        reversed ? previous() : next();
	
	        loopTimeoutId = window.setTimeout(function () {
	            loop(reversed);
	        }, speed);
	    };
	
	    //------------------------------------------------------------------------------
	    //
	    //  API
	    //
	    //------------------------------------------------------------------------------
	
	    return {
	        init: init,
	        previous: previous,
	        next: next,
	        isInteractive: isInteractive,
	        getCurrentFrame: getCurrentFrame,
	        play: play,
	        stop: stop,
	        loop: loop
	    };
	};
	
	//------------------------------------------------------------------------------
	//
	//  Utilities
	//
	//------------------------------------------------------------------------------
	
	var emptyDomNode = function emptyDomNode(element) {
	    if (element.hasChildNodes()) {
	        while (element.firstChild) {
	            element.removeChild(element.firstChild);
	        }
	    }
	};
	
	exports['default'] = threesixty;
	module.exports = exports['default'];

/***/ }),
/* 9 */
/***/ (function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);
//# sourceMappingURL=front.js.map
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
	
	__webpack_require__(5);

/***/ }),
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

	'use strict';
	
	__webpack_require__(2);
	
	__webpack_require__(3);
	
	__webpack_require__(4);
	
	function CodeFlask() {}CodeFlask.prototype.run = function (a, b) {
	    var c = document.querySelectorAll(a);if (c.length > 1) throw "CodeFlask.js ERROR: run() expects only one element, " + c.length + " given. Use .runAll() instead.";this.scaffold(c[0], !1, b);
	}, CodeFlask.prototype.runAll = function (a, b) {
	    this.update = null, this.onUpdate = null;var d,
	        c = document.querySelectorAll(a);for (d = 0; d < c.length; d++) this.scaffold(c[d], !0, b);
	}, CodeFlask.prototype.scaffold = function (a, b, c) {
	    var d = document.createElement("TEXTAREA"),
	        e = document.createElement("PRE"),
	        f = document.createElement("CODE"),
	        g = a.textContent;1 == !c.enableAutocorrect && (d.setAttribute("spellcheck", "false"), d.setAttribute("name", a.id), d.setAttribute("autocapitalize", "off"), d.setAttribute("autocomplete", "off"), d.setAttribute("autocorrect", "off")), c.language = this.handleLanguage(c.language), this.defaultLanguage = a.dataset.language || c.language || "markup", b || (this.textarea = d, this.highlightCode = f), a.classList.add("CodeFlask"), d.classList.add("CodeFlask__textarea"), e.classList.add("CodeFlask__pre"), f.classList.add("CodeFlask__code"), f.classList.add("language-" + this.defaultLanguage), /iPad|iPhone|iPod/.test(navigator.platform) && (f.style.paddingLeft = "3px"), a.innerHTML = "", a.appendChild(d), a.appendChild(e), e.appendChild(f), d.value = g, this.renderOutput(f, d), Prism.highlightAll(), this.handleInput(d, f, e), this.handleScroll(d, e);
	}, CodeFlask.prototype.renderOutput = function (a, b) {
	    a.innerHTML = b.value.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;") + "\n";
	}, CodeFlask.prototype.handleInput = function (a, b, c) {
	    var e,
	        f,
	        g,
	        d = this;a.addEventListener("input", function (a) {
	        e = this, d.renderOutput(b, e), Prism.highlightAll();
	    }), a.addEventListener("keydown", function (a) {
	        e = this, f = e.selectionStart, g = e.value, 9 === a.keyCode && (e.value = g.substring(0, f) + "    " + g.substring(f, e.value.length), e.selectionStart = f + 4, e.selectionEnd = f + 4, a.preventDefault(), b.innerHTML = e.value.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;") + "\n", Prism.highlightAll());
	    });
	}, CodeFlask.prototype.handleScroll = function (a, b) {
	    a.addEventListener("scroll", function () {
	        var a = Math.floor(this.scrollTop);navigator.userAgent.toLowerCase().indexOf("firefox") < 0 && (this.scrollTop = a), b.style.top = "-" + a + "px";
	    });
	}, CodeFlask.prototype.handleLanguage = function (a) {
	    return a.match(/html|xml|xhtml|svg/) ? "markup" : a.match(/js/) ? "javascript" : a;
	}, CodeFlask.prototype.onUpdate = function (a) {
	    if ("function" != typeof a) throw "CodeFlask.js ERROR: onUpdate() expects function, " + typeof a + " given instead.";this.textarea.addEventListener("input", function (b) {
	        a(this.value);
	    });
	}, CodeFlask.prototype.update = function (a) {
	    var b = document.createEvent("HTMLEvents");this.textarea.value = a, this.renderOutput(this.highlightCode, this.textarea), Prism.highlightAll(), b.initEvent("input", !1, !0), this.textarea.dispatchEvent(b);
	};
	
	var iqitBoxShadowGenerator;
	
	$(document).ready(function () {
	
	    var $boxShadowGenerators = $('.js-box-shadow-generator');
	    var $borderGenerators = $('.js-border-generator');
	    var $typographyGenerators = $('.js-typography-generator');
	    var $configurationForm = $('#configuration_form');
	    var iqitBaseUrl = $('#iqit-base-url').val();
	
	    $('#iqit-config-tabs').on('click', 'a[data-toggle="tab"]', function (e) {
	        e.preventDefault();
	        $('#iqit-config-tabs').find('a[data-toggle="tab"]').parent().removeClass('active');
	    });
	
	    $('#iqit-config-tabs').on('click', '.parent-tab', function (e) {
	        e.preventDefault();
	        var $link = $(this);
	
	        if ($link.parent().find('ul').length) {
	            var $firstChild = $link.parent().find('ul').find('a[data-toggle="tab"]').first();
	
	            $('#iqit-config-tabs').find('.parent-tab').parent().removeClass('active');
	            $link.parent().addClass('active');
	
	            $link.parent().addClass('active');
	            $firstChild.click();
	            $firstChild.tab('show');
	        }
	    });
	
	    //submit
	    $configurationForm.submit(function (event) {
	        $configurationForm.trigger('beforeSubmit', []);
	    });
	
	    $configurationForm.on('beforeSubmit', function (event) {
	
	        $boxShadowGenerators.each(function () {
	            var $controls = $(this).find('.js-shadow-color, .js-box-shadow-switch, .js-shadow-blur, .js-shadow-spread, .js-shadow-horizontal, .js-shadow-vertical');
	            $(this).find('.js-box-shadow-input').first().val(encodeURIComponent(JSON.stringify($controls.serializeToJSON())));
	        });
	
	        $borderGenerators.each(function () {
	            var $controls = $(this).find('.js-border-color, .js-border-type, .js-border-width');
	            $(this).find('.js-border-input').first().val(encodeURIComponent(JSON.stringify($controls.serializeToJSON())));
	        });
	
	        $typographyGenerators.each(function () {
	            var $controls = $(this).find('.js-font-size, .js-font-spacing, .js-font-bold, .js-font-italic, .js-font-uppercase');
	            $(this).find('.js-font-input').first().val(encodeURIComponent(JSON.stringify($controls.serializeToJSON())));
	        });
	    });
	
	    $borderGenerators.each(function () {
	
	        var $controls = $(this).find('.js-border-type, .js-border-width');
	
	        $controls.on('change input', function (e) {
	            if ($(this).data('name') == 'type') {
	                if ($(this).val() != 'none') {
	                    $(this).parents('.js-border-generator ').first().find('.js-border-controls-wrapper').addClass('visible-inline-option');
	                } else {
	                    $(this).parents('.js-border-generator ').first().find('.js-border-controls-wrapper').removeClass('visible-inline-option');
	                }
	            }
	
	            var self = this;
	            if ($(this).data('timeout')) {
	                clearTimeout($(this).data('timeout'));
	            }
	            $(this).data('timeout', setTimeout(function () {
	                $(self).parents('.js-border-generator').first().find('.js-border-input').change();
	            }, 50));
	        });
	        $(this).find('.js-border-color').on('keydown', function (e) {
	            var self = this;
	            if ($(this).data('timeout')) {
	                clearTimeout($(this).data('timeout'));
	            }
	            $(this).data('timeout', setTimeout(function () {
	                $(self).parents('.js-border-generator').first().find('.js-border-input').change();
	            }, 50));
	        });
	    });
	
	    $typographyGenerators.each(function () {
	        var $controls = $(this).find('.js-font-size, .js-font-spacing, .js-font-bold, .js-font-italic, .js-font-uppercase');
	        var $field = $(this).find('.js-font-input').first();
	
	        $controls.on('change input', function () {
	            $field.val(encodeURIComponent(JSON.stringify($controls.serializeToJSON())));
	            $field.change();
	        });
	    });
	
	    // new colorpicker
	    $('.colorpicker-component').colorpicker().on('changeColor', function (e) {
	        $(this).find('input').keydown();
	    });
	
	    $('.js-range-slider').on('input', function (e) {
	        $('#' + $(this).data('vinput')).change();
	    });
	
	    //filemanager iframe
	    $('.js-iframe-upload').fancybox({
	        'width': 900,
	        'height': 600,
	        'type': 'iframe',
	        'autoScale': false,
	        'autoDimensions': false,
	        'fitToView': false,
	        'autoSize': false,
	        onUpdate: function onUpdate() {
	            var $linkImage = $('.fancybox-iframe').contents().find('a.link');
	            var inputName = $(this.element).data('input-name');
	            $linkImage.data('field_id', inputName);
	            $linkImage.attr('data-field_id', inputName);
	        },
	        afterShow: function afterShow() {
	            var $linkImage = $('.fancybox-iframe').contents().find('a.link');
	            var inputName = $(this.element).data('input-name');
	            $linkImage.data('field_id', inputName);
	            $linkImage.attr('data-field_id', inputName);
	        },
	        beforeClose: function beforeClose() {
	            var $input = $('#' + $(this.element).data("input-name"));
	            var val = $input.val();
	
	            $input.val(val.replace(iqitBaseUrl, ""));
	            $input.change();
	        }
	    });
	
	    // field condition
	    $('#configuration_form').find('.condition-option').each(function () {
	
	        var $field = $(this);
	        var condition = $(this).data('condition');
	
	        $.each(condition, function (input, value) {
	            var parsedValue = value.match(/(\w+)(?:\[(\w+)])?/gi),
	                conditionValue = undefined;
	            var conditionOperator = value.match(/(\!=|<=|==)(?:\[(\w+)])?/gi)[0];
	            var $checker = $('input[name=' + input + '], select[name=' + input + ']');
	            var checkerVal = $checker.val();
	
	            if ($checker.attr('type') == 'radio') {
	                checkerVal = $('input[name=' + input + ']:checked').val();
	            }
	
	            if (parsedValue) {
	                conditionValue = parsedValue[0];
	            } else {
	                conditionValue = '';
	            }
	
	            if (conditionOperator == '<=') {
	                conditionValue = parsedValue;
	            }
	
	            if (iqitConditionCheck(checkerVal, conditionValue, conditionOperator)) {
	                $field.addClass('visible-option');
	            } else {
	                $field.removeClass('visible-option');
	            }
	            $checker.on('change input', function () {
	                if (iqitConditionCheck(this.value, conditionValue, conditionOperator)) {
	                    $field.addClass('visible-option');
	                } else {
	                    $field.removeClass('visible-option');
	                }
	            });
	        });
	    });
	    function iqitConditionCheck(leftValue, rightValue, operator) {
	        switch (operator) {
	            case '==':
	                return leftValue == rightValue;
	            case '!=':
	                return leftValue != rightValue;
	            case '<=':
	                if (jQuery.inArray(leftValue, rightValue) == -1) {
	                    return false;
	                } else {
	                    return true;
	                }
	            default:
	                return leftValue === rightValue;
	        }
	    }
	
	    //boxshadow
	    iqitBoxShadowGenerator = (function () {
	
	        function init() {
	            $boxShadowGenerators.each(function () {
	
	                var $generator = $(this),
	                    $input = $generator.find('.js-box-shadow-input'),
	                    $colorControl = $generator.find('.js-shadow-color'),
	                    $controls = $generator.find(' .js-shadow-blur, .js-shadow-spread, .js-shadow-horizontal, .js-shadow-vertical'),
	                    $switch = $generator.find('.js-box-shadow-switch'),
	                    $controlsWrapper = $generator.find('.js-box-shadow-controls');
	
	                setShadow($generator);
	
	                if ($switch.val() == 1) {
	                    $controlsWrapper.addClass('visible-option');
	                } else {
	                    $controlsWrapper.removeClass('visible-option');
	                }
	
	                $colorControl.keydown(function () {
	                    setShadow($generator);
	                    $input.change();
	                });
	
	                $controls.on('input', function () {
	                    setShadow($generator);
	                    $input.change();
	                });
	
	                $switch.change(function () {
	                    if (this.value == 1) {
	                        $controlsWrapper.addClass('visible-option');
	                    } else {
	                        $controlsWrapper.removeClass('visible-option');
	                    }
	                    $input.change();
	                });
	            });
	        }
	
	        function setShadow($generator) {
	
	            var color = $generator.find('.js-shadow-color').val(),
	                blur = $generator.find('.js-shadow-blur').val(),
	                spread = $generator.find('.js-shadow-spread').val(),
	                horizontal = $generator.find('.js-shadow-horizontal').val(),
	                vertical = $generator.find('.js-shadow-vertical').val(),
	                $preview = $generator.find('.js-shadow-preview'),
	                shdw = '';
	
	            shdw += horizontal + 'px ' + vertical + 'px ' + blur + 'px ' + spread + 'px ' + color;
	            $preview.css('box-shadow', shdw);
	            $preview.html('box-shadow: ' + shdw);
	        }
	
	        return { init: init };
	    })();
	    iqitBoxShadowGenerator.init();
	
	    //codes editor
	    var flask = new CodeFlask();
	    flask.run('#codes_css', { language: 'css' });
	    flask.onUpdate(function (code) {
	        $('#codes_css').trigger('cssCodeChanged', code);
	    });
	    flask.run('#codes_js', { language: 'javascript' });
	});

/***/ }),
/* 2 */
/***/ (function(module, exports, __webpack_require__) {

	/*!
	 * Bootstrap Colorpicker v2.3.6
	 * https://itsjavi.com/bootstrap-colorpicker/
	 */
	"use strict";
	
	!(function (a) {
	  "use strict"; true ? module.exports = a(window.jQuery) : "function" == typeof define && define.amd ? define(["jquery"], a) : window.jQuery && !window.jQuery.fn.colorpicker && a(window.jQuery);
	})(function (a) {
	  "use strict";var b = function b(_b, c) {
	    this.value = { h: 0, s: 0, b: 0, a: 1 }, this.origFormat = null, c && a.extend(this.colors, c), _b && (void 0 !== _b.toLowerCase ? (_b += "", this.setColor(_b)) : void 0 !== _b.h && (this.value = _b));
	  };b.prototype = { constructor: b, colors: { aliceblue: "#f0f8ff", antiquewhite: "#faebd7", aqua: "#00ffff", aquamarine: "#7fffd4", azure: "#f0ffff", beige: "#f5f5dc", bisque: "#ffe4c4", black: "#000000", blanchedalmond: "#ffebcd", blue: "#0000ff", blueviolet: "#8a2be2", brown: "#a52a2a", burlywood: "#deb887", cadetblue: "#5f9ea0", chartreuse: "#7fff00", chocolate: "#d2691e", coral: "#ff7f50", cornflowerblue: "#6495ed", cornsilk: "#fff8dc", crimson: "#dc143c", cyan: "#00ffff", darkblue: "#00008b", darkcyan: "#008b8b", darkgoldenrod: "#b8860b", darkgray: "#a9a9a9", darkgreen: "#006400", darkkhaki: "#bdb76b", darkmagenta: "#8b008b", darkolivegreen: "#556b2f", darkorange: "#ff8c00", darkorchid: "#9932cc", darkred: "#8b0000", darksalmon: "#e9967a", darkseagreen: "#8fbc8f", darkslateblue: "#483d8b", darkslategray: "#2f4f4f", darkturquoise: "#00ced1", darkviolet: "#9400d3", deeppink: "#ff1493", deepskyblue: "#00bfff", dimgray: "#696969", dodgerblue: "#1e90ff", firebrick: "#b22222", floralwhite: "#fffaf0", forestgreen: "#228b22", fuchsia: "#ff00ff", gainsboro: "#dcdcdc", ghostwhite: "#f8f8ff", gold: "#ffd700", goldenrod: "#daa520", gray: "#808080", green: "#008000", greenyellow: "#adff2f", honeydew: "#f0fff0", hotpink: "#ff69b4", indianred: "#cd5c5c", indigo: "#4b0082", ivory: "#fffff0", khaki: "#f0e68c", lavender: "#e6e6fa", lavenderblush: "#fff0f5", lawngreen: "#7cfc00", lemonchiffon: "#fffacd", lightblue: "#add8e6", lightcoral: "#f08080", lightcyan: "#e0ffff", lightgoldenrodyellow: "#fafad2", lightgrey: "#d3d3d3", lightgreen: "#90ee90", lightpink: "#ffb6c1", lightsalmon: "#ffa07a", lightseagreen: "#20b2aa", lightskyblue: "#87cefa", lightslategray: "#778899", lightsteelblue: "#b0c4de", lightyellow: "#ffffe0", lime: "#00ff00", limegreen: "#32cd32", linen: "#faf0e6", magenta: "#ff00ff", maroon: "#800000", mediumaquamarine: "#66cdaa", mediumblue: "#0000cd", mediumorchid: "#ba55d3", mediumpurple: "#9370d8", mediumseagreen: "#3cb371", mediumslateblue: "#7b68ee", mediumspringgreen: "#00fa9a", mediumturquoise: "#48d1cc", mediumvioletred: "#c71585", midnightblue: "#191970", mintcream: "#f5fffa", mistyrose: "#ffe4e1", moccasin: "#ffe4b5", navajowhite: "#ffdead", navy: "#000080", oldlace: "#fdf5e6", olive: "#808000", olivedrab: "#6b8e23", orange: "#ffa500", orangered: "#ff4500", orchid: "#da70d6", palegoldenrod: "#eee8aa", palegreen: "#98fb98", paleturquoise: "#afeeee", palevioletred: "#d87093", papayawhip: "#ffefd5", peachpuff: "#ffdab9", peru: "#cd853f", pink: "#ffc0cb", plum: "#dda0dd", powderblue: "#b0e0e6", purple: "#800080", red: "#ff0000", rosybrown: "#bc8f8f", royalblue: "#4169e1", saddlebrown: "#8b4513", salmon: "#fa8072", sandybrown: "#f4a460", seagreen: "#2e8b57", seashell: "#fff5ee", sienna: "#a0522d", silver: "#c0c0c0", skyblue: "#87ceeb", slateblue: "#6a5acd", slategray: "#708090", snow: "#fffafa", springgreen: "#00ff7f", steelblue: "#4682b4", tan: "#d2b48c", teal: "#008080", thistle: "#d8bfd8", tomato: "#ff6347", turquoise: "#40e0d0", violet: "#ee82ee", wheat: "#f5deb3", white: "#ffffff", whitesmoke: "#f5f5f5", yellow: "#ffff00", yellowgreen: "#9acd32", transparent: "transparent" }, _sanitizeNumber: function _sanitizeNumber(a) {
	      return "number" == typeof a ? a : isNaN(a) || null === a || "" === a || void 0 === a ? 1 : "" === a ? 0 : void 0 !== a.toLowerCase ? (a.match(/^\./) && (a = "0" + a), Math.ceil(100 * parseFloat(a)) / 100) : 1;
	    }, isTransparent: function isTransparent(a) {
	      return !!a && (a = a.toLowerCase().trim(), "transparent" === a || a.match(/#?00000000/) || a.match(/(rgba|hsla)\(0,0,0,0?\.?0\)/));
	    }, rgbaIsTransparent: function rgbaIsTransparent(a) {
	      return 0 === a.r && 0 === a.g && 0 === a.b && 0 === a.a;
	    }, setColor: function setColor(a) {
	      a = a.toLowerCase().trim(), a && (this.isTransparent(a) ? this.value = { h: 0, s: 0, b: 0, a: 0 } : this.value = this.stringToHSB(a) || { h: 0, s: 0, b: 0, a: 1 });
	    }, stringToHSB: function stringToHSB(b) {
	      b = b.toLowerCase();var c;"undefined" != typeof this.colors[b] && (b = this.colors[b], c = "alias");var d = this,
	          e = !1;return a.each(this.stringParsers, function (a, f) {
	        var g = f.re.exec(b),
	            h = g && f.parse.apply(d, [g]),
	            i = c || f.format || "rgba";return !h || (e = i.match(/hsla?/) ? d.RGBtoHSB.apply(d, d.HSLtoRGB.apply(d, h)) : d.RGBtoHSB.apply(d, h), d.origFormat = i, !1);
	      }), e;
	    }, setHue: function setHue(a) {
	      this.value.h = 1 - a;
	    }, setSaturation: function setSaturation(a) {
	      this.value.s = a;
	    }, setBrightness: function setBrightness(a) {
	      this.value.b = 1 - a;
	    }, setAlpha: function setAlpha(a) {
	      this.value.a = Math.round(parseInt(100 * (1 - a), 10) / 100 * 100) / 100;
	    }, toRGB: function toRGB(a, b, c, d) {
	      a || (a = this.value.h, b = this.value.s, c = this.value.b), a *= 360;var e, f, g, h, i;return a = a % 360 / 60, i = c * b, h = i * (1 - Math.abs(a % 2 - 1)), e = f = g = c - i, a = ~ ~a, e += [i, h, 0, 0, h, i][a], f += [h, i, i, h, 0, 0][a], g += [0, 0, h, i, i, h][a], { r: Math.round(255 * e), g: Math.round(255 * f), b: Math.round(255 * g), a: d || this.value.a };
	    }, toHex: function toHex(a, b, c, d) {
	      var e = this.toRGB(a, b, c, d);return this.rgbaIsTransparent(e) ? "transparent" : "#" + (1 << 24 | parseInt(e.r) << 16 | parseInt(e.g) << 8 | parseInt(e.b)).toString(16).substr(1);
	    }, toHSL: function toHSL(a, b, c, d) {
	      a = a || this.value.h, b = b || this.value.s, c = c || this.value.b, d = d || this.value.a;var e = a,
	          f = (2 - b) * c,
	          g = b * c;return g /= f > 0 && f <= 1 ? f : 2 - f, f /= 2, g > 1 && (g = 1), { h: isNaN(e) ? 0 : e, s: isNaN(g) ? 0 : g, l: isNaN(f) ? 0 : f, a: isNaN(d) ? 0 : d };
	    }, toAlias: function toAlias(a, b, c, d) {
	      var e = this.toHex(a, b, c, d);for (var f in this.colors) if (this.colors[f] === e) return f;return !1;
	    }, RGBtoHSB: function RGBtoHSB(a, b, c, d) {
	      a /= 255, b /= 255, c /= 255;var e, f, g, h;return g = Math.max(a, b, c), h = g - Math.min(a, b, c), e = 0 === h ? null : g === a ? (b - c) / h : g === b ? (c - a) / h + 2 : (a - b) / h + 4, e = (e + 360) % 6 * 60 / 360, f = 0 === h ? 0 : h / g, { h: this._sanitizeNumber(e), s: f, b: g, a: this._sanitizeNumber(d) };
	    }, HueToRGB: function HueToRGB(a, b, c) {
	      return c < 0 ? c += 1 : c > 1 && (c -= 1), 6 * c < 1 ? a + (b - a) * c * 6 : 2 * c < 1 ? b : 3 * c < 2 ? a + (b - a) * (2 / 3 - c) * 6 : a;
	    }, HSLtoRGB: function HSLtoRGB(a, b, c, d) {
	      b < 0 && (b = 0);var e;e = c <= .5 ? c * (1 + b) : c + b - c * b;var f = 2 * c - e,
	          g = a + 1 / 3,
	          h = a,
	          i = a - 1 / 3,
	          j = Math.round(255 * this.HueToRGB(f, e, g)),
	          k = Math.round(255 * this.HueToRGB(f, e, h)),
	          l = Math.round(255 * this.HueToRGB(f, e, i));return [j, k, l, this._sanitizeNumber(d)];
	    }, toString: function toString(a) {
	      a = a || "rgba";var b = !1;switch (a) {case "rgb":
	          return b = this.toRGB(), this.rgbaIsTransparent(b) ? "transparent" : "rgb(" + b.r + "," + b.g + "," + b.b + ")";case "rgba":
	          return b = this.toRGB(), "rgba(" + b.r + "," + b.g + "," + b.b + "," + b.a + ")";case "hsl":
	          return b = this.toHSL(), "hsl(" + Math.round(360 * b.h) + "," + Math.round(100 * b.s) + "%," + Math.round(100 * b.l) + "%)";case "hsla":
	          return b = this.toHSL(), "hsla(" + Math.round(360 * b.h) + "," + Math.round(100 * b.s) + "%," + Math.round(100 * b.l) + "%," + b.a + ")";case "hex":
	          return this.toHex();case "alias":
	          return this.toAlias() || this.toHex();default:
	          return b;}
	    }, stringParsers: [{ re: /rgb\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*?\)/, format: "rgb", parse: function parse(a) {
	        return [a[1], a[2], a[3], 1];
	      } }, { re: /rgb\(\s*(\d*(?:\.\d+)?)\%\s*,\s*(\d*(?:\.\d+)?)\%\s*,\s*(\d*(?:\.\d+)?)\%\s*?\)/, format: "rgb", parse: function parse(a) {
	        return [2.55 * a[1], 2.55 * a[2], 2.55 * a[3], 1];
	      } }, { re: /rgba\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*(?:,\s*(\d*(?:\.\d+)?)\s*)?\)/, format: "rgba", parse: function parse(a) {
	        return [a[1], a[2], a[3], a[4]];
	      } }, { re: /rgba\(\s*(\d*(?:\.\d+)?)\%\s*,\s*(\d*(?:\.\d+)?)\%\s*,\s*(\d*(?:\.\d+)?)\%\s*(?:,\s*(\d*(?:\.\d+)?)\s*)?\)/, format: "rgba", parse: function parse(a) {
	        return [2.55 * a[1], 2.55 * a[2], 2.55 * a[3], a[4]];
	      } }, { re: /hsl\(\s*(\d*(?:\.\d+)?)\s*,\s*(\d*(?:\.\d+)?)\%\s*,\s*(\d*(?:\.\d+)?)\%\s*?\)/, format: "hsl", parse: function parse(a) {
	        return [a[1] / 360, a[2] / 100, a[3] / 100, a[4]];
	      } }, { re: /hsla\(\s*(\d*(?:\.\d+)?)\s*,\s*(\d*(?:\.\d+)?)\%\s*,\s*(\d*(?:\.\d+)?)\%\s*(?:,\s*(\d*(?:\.\d+)?)\s*)?\)/, format: "hsla", parse: function parse(a) {
	        return [a[1] / 360, a[2] / 100, a[3] / 100, a[4]];
	      } }, { re: /#?([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/, format: "hex", parse: function parse(a) {
	        return [parseInt(a[1], 16), parseInt(a[2], 16), parseInt(a[3], 16), 1];
	      } }, { re: /#?([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/, format: "hex", parse: function parse(a) {
	        return [parseInt(a[1] + a[1], 16), parseInt(a[2] + a[2], 16), parseInt(a[3] + a[3], 16), 1];
	      } }], colorNameToHex: function colorNameToHex(a) {
	      return "undefined" != typeof this.colors[a.toLowerCase()] && this.colors[a.toLowerCase()];
	    } };var c = { horizontal: !1, inline: !1, color: !1, format: !1, input: "input", container: !1, component: ".add-on, .input-group-addon", sliders: { saturation: { maxLeft: 100, maxTop: 100, callLeft: "setSaturation", callTop: "setBrightness" }, hue: { maxLeft: 0, maxTop: 100, callLeft: !1, callTop: "setHue" }, alpha: { maxLeft: 0, maxTop: 100, callLeft: !1, callTop: "setAlpha" } }, slidersHorz: { saturation: { maxLeft: 100, maxTop: 100, callLeft: "setSaturation", callTop: "setBrightness" }, hue: { maxLeft: 100, maxTop: 0, callLeft: "setHue", callTop: !1 }, alpha: { maxLeft: 100, maxTop: 0, callLeft: "setAlpha", callTop: !1 } }, template: '<div class="colorpicker dropdown-menu"><div class="colorpicker-saturation"><i><b></b></i></div><div class="colorpicker-hue"><i></i></div><div class="colorpicker-alpha"><i></i></div><div class="colorpicker-color"><div /></div><div class="colorpicker-selectors"></div></div>', align: "right", customClass: null, colorSelectors: null },
	      d = function d(_d, e) {
	    if ((this.element = a(_d).addClass("colorpicker-element"), this.options = a.extend(!0, {}, c, this.element.data(), e), this.component = this.options.component, this.component = this.component !== !1 && this.element.find(this.component), this.component && 0 === this.component.length && (this.component = !1), this.container = this.options.container === !0 ? this.element : this.options.container, this.container = this.container !== !1 && a(this.container), this.input = this.element.is("input") ? this.element : !!this.options.input && this.element.find(this.options.input), this.input && 0 === this.input.length && (this.input = !1), this.color = new b(this.options.color !== !1 ? this.options.color : this.getValue(), this.options.colorSelectors), this.format = this.options.format !== !1 ? this.options.format : this.color.origFormat, this.options.color !== !1 && (this.updateInput(this.color), this.updateData(this.color)), this.picker = a(this.options.template), this.options.customClass && this.picker.addClass(this.options.customClass), this.options.inline ? this.picker.addClass("colorpicker-inline colorpicker-visible") : this.picker.addClass("colorpicker-hidden"), this.options.horizontal && this.picker.addClass("colorpicker-horizontal"), "rgba" !== this.format && "hsla" !== this.format && this.options.format !== !1 || this.picker.addClass("colorpicker-with-alpha"), "right" === this.options.align && this.picker.addClass("colorpicker-right"), this.options.inline === !0 && this.picker.addClass("colorpicker-no-arrow"), this.options.colorSelectors)) {
	      var f = this;a.each(this.options.colorSelectors, function (b, c) {
	        var d = a("<i />").css("background-color", c).data("class", b);d.click(function () {
	          f.setValue(a(this).css("background-color"));
	        }), f.picker.find(".colorpicker-selectors").append(d);
	      }), this.picker.find(".colorpicker-selectors").show();
	    }this.picker.on("mousedown.colorpicker touchstart.colorpicker", a.proxy(this.mousedown, this)), this.picker.appendTo(this.container ? this.container : a("body")), this.input !== !1 && (this.input.on({ "keyup.colorpicker": a.proxy(this.keyup, this) }), this.input.on({ "change.colorpicker": a.proxy(this.change, this) }), this.component === !1 && this.element.on({ "focus.colorpicker": a.proxy(this.show, this) }), this.options.inline === !1 && this.element.on({ "focusout.colorpicker": a.proxy(this.hide, this) })), this.component !== !1 && this.component.on({ "click.colorpicker": a.proxy(this.show, this) }), this.input === !1 && this.component === !1 && this.element.on({ "click.colorpicker": a.proxy(this.show, this) }), this.input !== !1 && this.component !== !1 && "color" === this.input.attr("type") && this.input.on({ "click.colorpicker": a.proxy(this.show, this), "focus.colorpicker": a.proxy(this.show, this) }), this.update(), a(a.proxy(function () {
	      this.element.trigger("create");
	    }, this));
	  };d.Color = b, d.prototype = { constructor: d, destroy: function destroy() {
	      this.picker.remove(), this.element.removeData("colorpicker", "color").off(".colorpicker"), this.input !== !1 && this.input.off(".colorpicker"), this.component !== !1 && this.component.off(".colorpicker"), this.element.removeClass("colorpicker-element"), this.element.trigger({ type: "destroy" });
	    }, reposition: function reposition() {
	      if (this.options.inline !== !1 || this.options.container) return !1;var a = this.container && this.container[0] !== document.body ? "position" : "offset",
	          b = this.component || this.element,
	          c = b[a]();"right" === this.options.align && (c.left -= this.picker.outerWidth() - b.outerWidth()), this.picker.css({ top: c.top + b.outerHeight(), left: c.left });
	    }, show: function show(b) {
	      return !this.isDisabled() && (this.picker.addClass("colorpicker-visible").removeClass("colorpicker-hidden"), this.reposition(), a(window).on("resize.colorpicker", a.proxy(this.reposition, this)), !b || this.hasInput() && "color" !== this.input.attr("type") || b.stopPropagation && b.preventDefault && (b.stopPropagation(), b.preventDefault()), !this.component && this.input || this.options.inline !== !1 || a(window.document).on({ "mousedown.colorpicker": a.proxy(this.hide, this) }), void this.element.trigger({ type: "showPicker", color: this.color }));
	    }, hide: function hide() {
	      this.picker.addClass("colorpicker-hidden").removeClass("colorpicker-visible"), a(window).off("resize.colorpicker", this.reposition), a(document).off({ "mousedown.colorpicker": this.hide }), this.update(), this.element.trigger({ type: "hidePicker", color: this.color });
	    }, updateData: function updateData(a) {
	      return a = a || this.color.toString(this.format), this.element.data("color", a), a;
	    }, updateInput: function updateInput(a) {
	      if ((a = a || this.color.toString(this.format), this.input !== !1)) {
	        if (this.options.colorSelectors) {
	          var c = new b(a, this.options.colorSelectors),
	              d = c.toAlias();"undefined" != typeof this.options.colorSelectors[d] && (a = d);
	        }this.input.prop("value", a);
	      }return a;
	    }, updatePicker: function updatePicker(a) {
	      void 0 !== a && (this.color = new b(a, this.options.colorSelectors));var c = this.options.horizontal === !1 ? this.options.sliders : this.options.slidersHorz,
	          d = this.picker.find("i");if (0 !== d.length) return this.options.horizontal === !1 ? (c = this.options.sliders, d.eq(1).css("top", c.hue.maxTop * (1 - this.color.value.h)).end().eq(2).css("top", c.alpha.maxTop * (1 - this.color.value.a))) : (c = this.options.slidersHorz, d.eq(1).css("left", c.hue.maxLeft * (1 - this.color.value.h)).end().eq(2).css("left", c.alpha.maxLeft * (1 - this.color.value.a))), d.eq(0).css({ top: c.saturation.maxTop - this.color.value.b * c.saturation.maxTop, left: this.color.value.s * c.saturation.maxLeft }), this.picker.find(".colorpicker-saturation").css("backgroundColor", this.color.toHex(this.color.value.h, 1, 1, 1)), this.picker.find(".colorpicker-alpha").css("backgroundColor", this.color.toHex()), this.picker.find(".colorpicker-color, .colorpicker-color div").css("backgroundColor", this.color.toString(this.format)), a;
	    }, updateComponent: function updateComponent(a) {
	      if ((a = a || this.color.toString(this.format), this.component !== !1)) {
	        var b = this.component.find("i").eq(0);b.length > 0 ? b.css({ backgroundColor: a }) : this.component.css({ backgroundColor: a });
	      }return a;
	    }, update: function update(a) {
	      var b;return this.getValue(!1) === !1 && a !== !0 || (b = this.updateComponent(), this.updateInput(b), this.updateData(b), this.updatePicker()), b;
	    }, setValue: function setValue(a) {
	      this.color = new b(a, this.options.colorSelectors), this.update(!0), this.element.trigger({ type: "changeColor", color: this.color, value: a });
	    }, getValue: function getValue(a) {
	      a = void 0 === a ? "#000000" : a;var b;return b = this.hasInput() ? this.input.val() : this.element.data("color"), void 0 !== b && "" !== b && null !== b || (b = a), b;
	    }, hasInput: function hasInput() {
	      return this.input !== !1;
	    }, isDisabled: function isDisabled() {
	      return !!this.hasInput() && this.input.prop("disabled") === !0;
	    }, disable: function disable() {
	      return !!this.hasInput() && (this.input.prop("disabled", !0), this.element.trigger({ type: "disable", color: this.color, value: this.getValue() }), !0);
	    }, enable: function enable() {
	      return !!this.hasInput() && (this.input.prop("disabled", !1), this.element.trigger({ type: "enable", color: this.color, value: this.getValue() }), !0);
	    }, currentSlider: null, mousePointer: { left: 0, top: 0 }, mousedown: function mousedown(b) {
	      !b.pageX && !b.pageY && b.originalEvent && b.originalEvent.touches && (b.pageX = b.originalEvent.touches[0].pageX, b.pageY = b.originalEvent.touches[0].pageY), b.stopPropagation(), b.preventDefault();var c = a(b.target),
	          d = c.closest("div"),
	          e = this.options.horizontal ? this.options.slidersHorz : this.options.sliders;if (!d.is(".colorpicker")) {
	        if (d.is(".colorpicker-saturation")) this.currentSlider = a.extend({}, e.saturation);else if (d.is(".colorpicker-hue")) this.currentSlider = a.extend({}, e.hue);else {
	          if (!d.is(".colorpicker-alpha")) return !1;this.currentSlider = a.extend({}, e.alpha);
	        }var f = d.offset();this.currentSlider.guide = d.find("i")[0].style, this.currentSlider.left = b.pageX - f.left, this.currentSlider.top = b.pageY - f.top, this.mousePointer = { left: b.pageX, top: b.pageY }, a(document).on({ "mousemove.colorpicker": a.proxy(this.mousemove, this), "touchmove.colorpicker": a.proxy(this.mousemove, this), "mouseup.colorpicker": a.proxy(this.mouseup, this), "touchend.colorpicker": a.proxy(this.mouseup, this) }).trigger("mousemove");
	      }return !1;
	    }, mousemove: function mousemove(a) {
	      !a.pageX && !a.pageY && a.originalEvent && a.originalEvent.touches && (a.pageX = a.originalEvent.touches[0].pageX, a.pageY = a.originalEvent.touches[0].pageY), a.stopPropagation(), a.preventDefault();var b = Math.max(0, Math.min(this.currentSlider.maxLeft, this.currentSlider.left + ((a.pageX || this.mousePointer.left) - this.mousePointer.left))),
	          c = Math.max(0, Math.min(this.currentSlider.maxTop, this.currentSlider.top + ((a.pageY || this.mousePointer.top) - this.mousePointer.top)));return this.currentSlider.guide.left = b + "px", this.currentSlider.guide.top = c + "px", this.currentSlider.callLeft && this.color[this.currentSlider.callLeft].call(this.color, b / this.currentSlider.maxLeft), this.currentSlider.callTop && this.color[this.currentSlider.callTop].call(this.color, c / this.currentSlider.maxTop), "setAlpha" === this.currentSlider.callTop && this.options.format === !1 && (1 !== this.color.value.a ? (this.format = "rgba", this.color.origFormat = "rgba") : (this.format = "hex", this.color.origFormat = "hex")), this.update(!0), this.element.trigger({ type: "changeColor", color: this.color }), !1;
	    }, mouseup: function mouseup(b) {
	      return b.stopPropagation(), b.preventDefault(), a(document).off({ "mousemove.colorpicker": this.mousemove, "touchmove.colorpicker": this.mousemove, "mouseup.colorpicker": this.mouseup, "touchend.colorpicker": this.mouseup }), !1;
	    }, change: function change(a) {
	      this.keyup(a);
	    }, keyup: function keyup(a) {
	      38 === a.keyCode ? (this.color.value.a < 1 && (this.color.value.a = Math.round(100 * (this.color.value.a + .01)) / 100), this.update(!0)) : 40 === a.keyCode ? (this.color.value.a > 0 && (this.color.value.a = Math.round(100 * (this.color.value.a - .01)) / 100), this.update(!0)) : (this.color = new b(this.input.val(), this.options.colorSelectors), this.color.origFormat && this.options.format === !1 && (this.format = this.color.origFormat), this.getValue(!1) !== !1 && (this.updateData(), this.updateComponent(), this.updatePicker())), this.element.trigger({ type: "changeColor", color: this.color, value: this.input.val() });
	    } }, a.colorpicker = d, a.fn.colorpicker = function (b) {
	    var c = Array.prototype.slice.call(arguments, 1),
	        e = 1 === this.length,
	        f = null,
	        g = this.each(function () {
	      var e = a(this),
	          g = e.data("colorpicker"),
	          h = "object" == typeof b ? b : {};g || (g = new d(this, h), e.data("colorpicker", g)), "string" == typeof b ? a.isFunction(g[b]) ? f = g[b].apply(g, c) : (c.length && (g[b] = c[0]), f = g[b]) : f = e;
	    });return e ? f : g;
	  }, a.fn.colorpicker.constructor = d;
	});

/***/ }),
/* 3 */
/***/ (function(module, exports) {

	/**
	 * serializeToJSON jQuery plugin
	 * https://github.com/raphaelm22/jquery.serializeToJSON
	 * @version: v1.2.1 (November, 2016)
	 * @author: Raphael Nunes
	 *
	 * Created by Raphael Nunes on 2015-08-28.
	 *
	 * Licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
	 */
	
	"use strict";
	
	(function ($) {
	    "use strict";
	
	    $.fn.serializeToJSON = function (options) {
	
	        var f = {
	            settings: $.extend(true, {}, $.fn.serializeToJSON.defaults, options),
	
	            getValue: function getValue($input) {
	                var value = $input.val();
	
	                if ($input.is(":radio")) {
	                    value = $input.filter(":checked").val() || null;
	                }
	
	                if ($input.is(":checkbox")) {
	                    value = $($input).prop('checked');
	                }
	
	                if (this.settings.parseBooleans) {
	                    var boolValue = (value + "").toLowerCase();
	                    if (boolValue === "true" || boolValue === "false") {
	                        value = boolValue === "true";
	                    }
	                }
	
	                var floatCondition = this.settings.parseFloat.condition;
	                if (floatCondition !== undefined && (typeof floatCondition === "string" && $input.is(floatCondition) || typeof floatCondition === "function" && floatCondition($input))) {
	
	                    value = this.settings.parseFloat.getInputValue($input);
	                    value = Number(value);
	
	                    if (this.settings.parseFloat.nanToZero && isNaN(value)) {
	                        value = 0;
	                    }
	                }
	
	                return value;
	            },
	
	            createProperty: function createProperty(o, value, names, $input) {
	                var navObj = o;
	
	                for (var i = 0; i < names.length; i++) {
	                    var currentName = names[i];
	
	                    if (i === names.length - 1) {
	                        var isSelectMultiple = $input.is("select") && $input.prop("multiple");
	
	                        if (isSelectMultiple && value !== null) {
	                            navObj[currentName] = new Array();
	
	                            if (Array.isArray(value)) {
	                                $(value).each(function () {
	                                    navObj[currentName].push(this);
	                                });
	                            } else {
	                                navObj[currentName].push(value);
	                            }
	                        } else {
	                            navObj[currentName] = value;
	                        }
	                    } else {
	                        var arrayKey = /\[\w+\]/g.exec(currentName);
	                        var isArray = arrayKey != null && arrayKey.length > 0;
	
	                        if (isArray) {
	                            currentName = currentName.substr(0, currentName.indexOf("["));
	
	                            if (this.settings.associativeArrays) {
	                                if (!navObj.hasOwnProperty(currentName)) {
	                                    navObj[currentName] = {};
	                                }
	                            } else {
	                                if (!Array.isArray(navObj[currentName])) {
	                                    navObj[currentName] = new Array();
	                                }
	                            }
	
	                            navObj = navObj[currentName];
	
	                            var keyName = arrayKey[0].replace(/[\[\]]/g, "");
	                            currentName = keyName;
	                        }
	
	                        if (!navObj.hasOwnProperty(currentName)) {
	                            navObj[currentName] = {};
	                        }
	
	                        navObj = navObj[currentName];
	                    }
	                }
	            },
	
	            includeUncheckValues: function includeUncheckValues(selector, formAsArray) {
	                $(":radio", selector).each(function () {
	                    var isUncheckRadio = $("input[name='" + this.name + "']:radio:checked").length === 0;
	                    if (isUncheckRadio) {
	                        formAsArray.push({
	                            name: this.name,
	                            value: null
	                        });
	                    }
	                });
	
	                $("select[multiple]", selector).each(function () {
	                    if ($(this).val() === null) {
	                        formAsArray.push({
	                            name: this.name,
	                            value: null
	                        });
	                    }
	                });
	            },
	
	            serializer: function serializer(selector) {
	                var self = this;
	
	                //this.includeUncheckValues(selector, formAsArray);
	
	                var serializedObject = {};
	
	                selector.each(function () {
	                    var $input = $(this);
	
	                    var value = self.getValue($input);
	                    var names = $(this).data('name').split(".");
	
	                    self.createProperty(serializedObject, value, names, $input);
	                });
	
	                return serializedObject;
	            }
	        };
	
	        return f.serializer(this);
	    };
	
	    $.fn.serializeToJSON.defaults = {
	        associativeArrays: true,
	        parseBooleans: true,
	        parseFloat: {
	            condition: undefined,
	            nanToZero: true,
	            getInputValue: function getInputValue($input) {
	                return $input.val().split(",").join("");
	            }
	        }
	    };
	})(jQuery);

/***/ }),
/* 4 */
/***/ (function(module, exports) {

	/* WEBPACK VAR INJECTION */(function(global) {/* http://prismjs.com/download.html?themes=prism&languages=css+clike+javascript */
	"use strict";
	
	var _self = "undefined" != typeof window ? window : "undefined" != typeof WorkerGlobalScope && self instanceof WorkerGlobalScope ? self : {},
	    Prism = (function () {
	  var e = /\blang(?:uage)?-(\w+)\b/i,
	      t = 0,
	      n = _self.Prism = { util: { encode: function encode(e) {
	        return e instanceof a ? new a(e.type, n.util.encode(e.content), e.alias) : "Array" === n.util.type(e) ? e.map(n.util.encode) : e.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/\u00a0/g, " ");
	      }, type: function type(e) {
	        return Object.prototype.toString.call(e).match(/\[object (\w+)\]/)[1];
	      }, objId: function objId(e) {
	        return e.__id || Object.defineProperty(e, "__id", { value: ++t }), e.__id;
	      }, clone: function clone(e) {
	        var t = n.util.type(e);switch (t) {case "Object":
	            var a = {};for (var r in e) e.hasOwnProperty(r) && (a[r] = n.util.clone(e[r]));return a;case "Array":
	            return e.map && e.map(function (e) {
	              return n.util.clone(e);
	            });}return e;
	      } }, languages: { extend: function extend(e, t) {
	        var a = n.util.clone(n.languages[e]);for (var r in t) a[r] = t[r];return a;
	      }, insertBefore: function insertBefore(e, t, a, r) {
	        r = r || n.languages;var i = r[e];if (2 == arguments.length) {
	          a = arguments[1];for (var l in a) a.hasOwnProperty(l) && (i[l] = a[l]);return i;
	        }var o = {};for (var s in i) if (i.hasOwnProperty(s)) {
	          if (s == t) for (var l in a) a.hasOwnProperty(l) && (o[l] = a[l]);o[s] = i[s];
	        }return n.languages.DFS(n.languages, function (t, n) {
	          n === r[e] && t != e && (this[t] = o);
	        }), r[e] = o;
	      }, DFS: function DFS(e, t, a, r) {
	        r = r || {};for (var i in e) e.hasOwnProperty(i) && (t.call(e, i, e[i], a || i), "Object" !== n.util.type(e[i]) || r[n.util.objId(e[i])] ? "Array" !== n.util.type(e[i]) || r[n.util.objId(e[i])] || (r[n.util.objId(e[i])] = !0, n.languages.DFS(e[i], t, i, r)) : (r[n.util.objId(e[i])] = !0, n.languages.DFS(e[i], t, null, r)));
	      } }, plugins: {}, highlightAll: function highlightAll(e, t) {
	      var a = { callback: t, selector: 'code[class*="language-"], [class*="language-"] code, code[class*="lang-"], [class*="lang-"] code' };n.hooks.run("before-highlightall", a);for (var r, i = a.elements || document.querySelectorAll(a.selector), l = 0; r = i[l++];) n.highlightElement(r, e === !0, a.callback);
	    }, highlightElement: function highlightElement(t, a, r) {
	      for (var i, l, o = t; o && !e.test(o.className);) o = o.parentNode;o && (i = (o.className.match(e) || [, ""])[1].toLowerCase(), l = n.languages[i]), t.className = t.className.replace(e, "").replace(/\s+/g, " ") + " language-" + i, o = t.parentNode, /pre/i.test(o.nodeName) && (o.className = o.className.replace(e, "").replace(/\s+/g, " ") + " language-" + i);var s = t.textContent,
	          u = { element: t, language: i, grammar: l, code: s };if ((n.hooks.run("before-sanity-check", u), !u.code || !u.grammar)) return n.hooks.run("complete", u), void 0;if ((n.hooks.run("before-highlight", u), a && _self.Worker)) {
	        var g = new Worker(n.filename);g.onmessage = function (e) {
	          u.highlightedCode = e.data, n.hooks.run("before-insert", u), u.element.innerHTML = u.highlightedCode, r && r.call(u.element), n.hooks.run("after-highlight", u), n.hooks.run("complete", u);
	        }, g.postMessage(JSON.stringify({ language: u.language, code: u.code, immediateClose: !0 }));
	      } else u.highlightedCode = n.highlight(u.code, u.grammar, u.language), n.hooks.run("before-insert", u), u.element.innerHTML = u.highlightedCode, r && r.call(t), n.hooks.run("after-highlight", u), n.hooks.run("complete", u);
	    }, highlight: function highlight(e, t, r) {
	      var i = n.tokenize(e, t);return a.stringify(n.util.encode(i), r);
	    }, tokenize: function tokenize(e, t) {
	      var a = n.Token,
	          r = [e],
	          i = t.rest;if (i) {
	        for (var l in i) t[l] = i[l];delete t.rest;
	      }e: for (var l in t) if (t.hasOwnProperty(l) && t[l]) {
	        var o = t[l];o = "Array" === n.util.type(o) ? o : [o];for (var s = 0; s < o.length; ++s) {
	          var u = o[s],
	              g = u.inside,
	              c = !!u.lookbehind,
	              h = !!u.greedy,
	              f = 0,
	              d = u.alias;if (h && !u.pattern.global) {
	            var p = u.pattern.toString().match(/[imuy]*$/)[0];u.pattern = RegExp(u.pattern.source, p + "g");
	          }u = u.pattern || u;for (var m = 0, y = 0; m < r.length; y += r[m].length, ++m) {
	            var v = r[m];if (r.length > e.length) break e;if (!(v instanceof a)) {
	              u.lastIndex = 0;var b = u.exec(v),
	                  k = 1;if (!b && h && m != r.length - 1) {
	                if ((u.lastIndex = y, b = u.exec(e), !b)) break;for (var w = b.index + (c ? b[1].length : 0), _ = b.index + b[0].length, A = m, P = y, j = r.length; j > A && _ > P; ++A) P += r[A].length, w >= P && (++m, y = P);if (r[m] instanceof a || r[A - 1].greedy) continue;k = A - m, v = e.slice(y, P), b.index -= y;
	              }if (b) {
	                c && (f = b[1].length);var w = b.index + f,
	                    b = b[0].slice(f),
	                    _ = w + b.length,
	                    O = v.slice(0, w),
	                    x = v.slice(_),
	                    S = [m, k];O && S.push(O);var N = new a(l, g ? n.tokenize(b, g) : b, d, b, h);S.push(N), x && S.push(x), Array.prototype.splice.apply(r, S);
	              }
	            }
	          }
	        }
	      }return r;
	    }, hooks: { all: {}, add: function add(e, t) {
	        var a = n.hooks.all;a[e] = a[e] || [], a[e].push(t);
	      }, run: function run(e, t) {
	        var a = n.hooks.all[e];if (a && a.length) for (var r, i = 0; r = a[i++];) r(t);
	      } } },
	      a = n.Token = function (e, t, n, a, r) {
	    this.type = e, this.content = t, this.alias = n, this.length = 0 | (a || "").length, this.greedy = !!r;
	  };if ((a.stringify = function (e, t, r) {
	    if ("string" == typeof e) return e;if ("Array" === n.util.type(e)) return e.map(function (n) {
	      return a.stringify(n, t, e);
	    }).join("");var i = { type: e.type, content: a.stringify(e.content, t, r), tag: "span", classes: ["token", e.type], attributes: {}, language: t, parent: r };if (("comment" == i.type && (i.attributes.spellcheck = "true"), e.alias)) {
	      var l = "Array" === n.util.type(e.alias) ? e.alias : [e.alias];Array.prototype.push.apply(i.classes, l);
	    }n.hooks.run("wrap", i);var o = Object.keys(i.attributes).map(function (e) {
	      return e + '="' + (i.attributes[e] || "").replace(/"/g, "&quot;") + '"';
	    }).join(" ");return "<" + i.tag + ' class="' + i.classes.join(" ") + '"' + (o ? " " + o : "") + ">" + i.content + "</" + i.tag + ">";
	  }, !_self.document)) return _self.addEventListener ? (_self.addEventListener("message", function (e) {
	    var t = JSON.parse(e.data),
	        a = t.language,
	        r = t.code,
	        i = t.immediateClose;_self.postMessage(n.highlight(r, n.languages[a], a)), i && _self.close();
	  }, !1), _self.Prism) : _self.Prism;var r = document.currentScript || [].slice.call(document.getElementsByTagName("script")).pop();return r && (n.filename = r.src, document.addEventListener && !r.hasAttribute("data-manual") && ("loading" !== document.readyState ? window.requestAnimationFrame ? window.requestAnimationFrame(n.highlightAll) : window.setTimeout(n.highlightAll, 16) : document.addEventListener("DOMContentLoaded", n.highlightAll))), _self.Prism;
	})();"undefined" != typeof module && module.exports && (module.exports = Prism), "undefined" != typeof global && (global.Prism = Prism);
	Prism.languages.css = { comment: /\/\*[\w\W]*?\*\//, atrule: { pattern: /@[\w-]+?.*?(;|(?=\s*\{))/i, inside: { rule: /@[\w-]+/ } }, url: /url\((?:(["'])(\\(?:\r\n|[\w\W])|(?!\1)[^\\\r\n])*\1|.*?)\)/i, selector: /[^\{\}\s][^\{\};]*?(?=\s*\{)/, string: { pattern: /("|')(\\(?:\r\n|[\w\W])|(?!\1)[^\\\r\n])*\1/, greedy: !0 }, property: /(\b|\B)[\w-]+(?=\s*:)/i, important: /\B!important\b/i, "function": /[-a-z0-9]+(?=\()/i, punctuation: /[(){};:]/ }, Prism.languages.css.atrule.inside.rest = Prism.util.clone(Prism.languages.css), Prism.languages.markup && (Prism.languages.insertBefore("markup", "tag", { style: { pattern: /(<style[\w\W]*?>)[\w\W]*?(?=<\/style>)/i, lookbehind: !0, inside: Prism.languages.css, alias: "language-css" } }), Prism.languages.insertBefore("inside", "attr-value", { "style-attr": { pattern: /\s*style=("|').*?\1/i, inside: { "attr-name": { pattern: /^\s*style/i, inside: Prism.languages.markup.tag.inside }, punctuation: /^\s*=\s*['"]|['"]\s*$/, "attr-value": { pattern: /.+/i, inside: Prism.languages.css } }, alias: "language-css" } }, Prism.languages.markup.tag));
	Prism.languages.clike = { comment: [{ pattern: /(^|[^\\])\/\*[\w\W]*?\*\//, lookbehind: !0 }, { pattern: /(^|[^\\:])\/\/.*/, lookbehind: !0 }], string: { pattern: /(["'])(\\(?:\r\n|[\s\S])|(?!\1)[^\\\r\n])*\1/, greedy: !0 }, "class-name": { pattern: /((?:\b(?:class|interface|extends|implements|trait|instanceof|new)\s+)|(?:catch\s+\())[a-z0-9_\.\\]+/i, lookbehind: !0, inside: { punctuation: /(\.|\\)/ } }, keyword: /\b(if|else|while|do|for|return|in|instanceof|function|new|try|throw|catch|finally|null|break|continue)\b/, "boolean": /\b(true|false)\b/, "function": /[a-z0-9_]+(?=\()/i, number: /\b-?(?:0x[\da-f]+|\d*\.?\d+(?:e[+-]?\d+)?)\b/i, operator: /--?|\+\+?|!=?=?|<=?|>=?|==?=?|&&?|\|\|?|\?|\*|\/|~|\^|%/, punctuation: /[{}[\];(),.:]/ };
	Prism.languages.javascript = Prism.languages.extend("clike", { keyword: /\b(as|async|await|break|case|catch|class|const|continue|debugger|default|delete|do|else|enum|export|extends|finally|for|from|function|get|if|implements|import|in|instanceof|interface|let|new|null|of|package|private|protected|public|return|set|static|super|switch|this|throw|try|typeof|var|void|while|with|yield)\b/, number: /\b-?(0x[\dA-Fa-f]+|0b[01]+|0o[0-7]+|\d*\.?\d+([Ee][+-]?\d+)?|NaN|Infinity)\b/, "function": /[_$a-zA-Z\xA0-\uFFFF][_$a-zA-Z0-9\xA0-\uFFFF]*(?=\()/i, operator: /--?|\+\+?|!=?=?|<=?|>=?|==?=?|&&?|\|\|?|\?|\*\*?|\/|~|\^|%|\.{3}/ }), Prism.languages.insertBefore("javascript", "keyword", { regex: { pattern: /(^|[^\/])\/(?!\/)(\[.+?]|\\.|[^\/\\\r\n])+\/[gimyu]{0,5}(?=\s*($|[\r\n,.;})]))/, lookbehind: !0, greedy: !0 } }), Prism.languages.insertBefore("javascript", "string", { "template-string": { pattern: /`(?:\\\\|\\?[^\\])*?`/, greedy: !0, inside: { interpolation: { pattern: /\$\{[^}]+\}/, inside: { "interpolation-punctuation": { pattern: /^\$\{|\}$/, alias: "punctuation" }, rest: Prism.languages.javascript } }, string: /[\s\S]+/ } } }), Prism.languages.markup && Prism.languages.insertBefore("markup", "tag", { script: { pattern: /(<script[\w\W]*?>)[\w\W]*?(?=<\/script>)/i, lookbehind: !0, inside: Prism.languages.javascript, alias: "language-javascript" } }), Prism.languages.js = Prism.languages.javascript;
	/* WEBPACK VAR INJECTION */}.call(exports, (function() { return this; }())))

/***/ }),
/* 5 */
/***/ (function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);
//# sourceMappingURL=backoffice.js.map
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
/******/ ({

/***/ 0:
/***/ (function(module, exports, __webpack_require__) {

	'use strict';
	
	__webpack_require__(14);
	
	__webpack_require__(15);

/***/ }),

/***/ 14:
/***/ (function(module, exports) {

	'use strict';
	
	$(document).ready(function () {
	
	    $.fn.serializeObject = function () {
	        var o = {};
	        var a = this.serializeArray();
	        $.each(a, function () {
	            if (o[this.name] !== undefined) {
	                if (!o[this.name].push) {
	                    o[this.name] = [o[this.name]];
	                }
	                o[this.name].push(this.value || '');
	            } else {
	                o[this.name] = this.value || '';
	            }
	        });
	        return o;
	    };
	
	    var iqitMenuPanels;
	
	    iqitMenuPanels = (function () {
	
	        var $menuTrigger = $('#iqitfronteditor-tools-trigger');
	        var $menuPanelInner = $('#iqit-config-pans');
	        var $deviceSwitchBtn = $('.js-preview-device-switch');
	        var $exitModal = $('#iqitfronteditor-exit-modal');
	        var $exitModalCloseBtn = $('#iqitfronteditor-modal-close');
	        var $exitBtn = $('#iqit-exit-editor-btn');
	        var $closeWarningBtn = $('.js-iqit-close-warning');
	        var level = 1;
	
	        var $previewIframe = $('#iqitfronteditor-iframe');
	        var iFrameDOM, iFrameStyle, iFrameCustomStyle, iFrameLink;
	        var $preview = $('#iqitfronteditor-preview');
	        var $menuPanel = $('#iqitfronteditor-tools');
	        var $previewPageSelector = $('#preview-page');
	        var $saveButton = $('#iqitfronteditor-save');
	        var $saveSuccess = $('#iqitfronteditor-save-success');
	        var $saveFail = $('#iqitfronteditor-save-false');
	
	        var sass = new Sass();
	        var $form = $('#configuration_form');
	        var $formFieldsInput = $('#configuration_form input, #configuration_form textarea').not('.js-scss-ignore');
	        var $formFieldsSelect = $('#configuration_form select').not('.js-scss-ignore');
	        var $formFieldsColor = $('#configuration_form .colorpicker-component input').not('.js-scss-ignore');
	        var $formCustomCss = $('#codes_css');
	        var values = {};
	        var vars = {};
	        var options = {};
	
	        var base = '../../scss/';
	        var directory = '';
	        var files = ['_mixins.scss', 'options/_breadcrumb.scss', 'options/_buttons.scss', 'options/_cart.scss', 'options/_forms.scss', 'options/_modals.scss', 'options/_label.scss', 'options/_options.scss', 'options/_typo.scss', 'content/_category.scss', 'content/_content.scss', 'content/_list.scss', 'content/_product.scss', '_mobile.scss', '_footers.scss', '_general.scss', '_header.scss', '_menu.scss', '_maintenance.scss', 'iqitthemeeditor.scss'];
	
	        function init() {
	            initPanels();
	            initScss();
	        }
	
	        function initPanels() {
	
	            $previewIframe.on('load', function () {
	                iFrameDOM = $previewIframe.contents();
	                $('#iqitfronteditor-style').clone().appendTo(iFrameDOM.find('head'));
	                $('#iqitfronteditor-custom-style').clone().appendTo(iFrameDOM.find('head'));
	                iFrameStyle = iFrameDOM.find('#iqitfronteditor-style');
	                iFrameLink = iFrameDOM.find('a');
	                iFrameCustomStyle = iFrameDOM.find('#iqitfronteditor-custom-style');
	                $menuPanel.removeClass('loading-tools');
	
	                sass.preloadFiles(base, directory, files, function callback() {
	                    console.log('sass files loaded');
	                    appendScss(true);
	                });
	
	                appendCustomCss($formCustomCss.text());
	
	                iFrameLink.click(function (e) {
	                    var url = $(this).attr('href');
	                    if (!url.match(/^\#/)) {
	                        e.preventDefault();
	                        $preview.addClass('loading-preview');
	                        url = parsePreviewUrl($(this).attr('href'));
	                        $previewIframe.prop('src', url);
	                    }
	                });
	            });
	
	            $menuTrigger.click(function () {
	                $(this).toggleClass('_closed-panel');
	                $menuPanel.toggleClass('_closed-panel');
	                $preview.toggleClass('_full-width');
	            });
	
	            $exitBtn.click(function (e) {
	                if (!$saveButton.hasClass('_saved')) {
	                    e.preventDefault();
	                    $exitModal.addClass('_visible');
	                }
	            });
	
	            $saveButton.click(function () {
	                $form.trigger('beforeSubmit', []);
	
	                tinymce.triggerSave();
	
	                $.ajax({
	                    type: 'POST',
	                    url: iqitFrontEditor.ajaxurl,
	                    data: {
	                        action: 'saveForm',
	                        formData: $('#configuration_form').serialize()
	                    },
	                    success: function success(resp) {
	                        if (resp.success) {
	                            $saveButton.addClass('_saved');
	                            $saveSuccess.addClass('_saved');
	                            $preview.addClass('loading-preview');
	                            $previewIframe.prop('src', function (i, val) {
	                                return val;
	                            });
	                            setTimeout(function () {
	                                $saveSuccess.removeClass('_saved');
	                            }, 2500);
	                        } else {
	                            $saveFail.html(resp.message);
	                            setTimeout(function () {
	                                $saveFail.html('');
	                            }, 3500);
	                        }
	                    },
	                    error: function error() {
	                        console.log("error");
	                    }
	                });
	            });
	
	            $closeWarningBtn.click(function (e) {
	                $(this).parent().remove();
	            });
	
	            $exitModalCloseBtn.click(function (e) {
	                $exitModal.removeClass('_visible');
	            });
	
	            $previewPageSelector.on('change', function () {
	                $preview.addClass('loading-preview');
	                var url = parsePreviewUrl($previewPageSelector.val());
	                $previewIframe.prop('src', url);
	            });
	
	            $exitModal.on('click', function (e) {
	                if (e.target.id == 'iqitfronteditor-exit-modal') {
	                    $exitModal.removeClass('_visible');
	                }
	            });
	
	            $('.iqit-config-tab-title').click(function () {
	
	                var $this = $(this);
	
	                if ($this.data('fieldset')) {
	                    $($this.data('fieldset')).addClass('_opened-fieldset');
	                    $menuPanelInner.addClass('_opened-panels');
	                    level = $this.data('level');
	                } else {
	                    $(this).next('.iqit-config-tab-group').addClass('_opened-group');
	                    $menuPanelInner.addClass('_opened-panels');
	                    level = 1;
	                }
	            });
	
	            $('.iqit-config-tab-close').click(function () {
	                $(this).parents('.iqit-config-tab-group').removeClass('_opened-group');
	                $(this).parents('.iqit-config-fieldset').removeClass('_opened-fieldset');
	
	                if (level < 2) {
	                    $menuPanelInner.removeClass('_opened-panels');
	                } else {
	                    level = 1;
	                }
	            });
	
	            $deviceSwitchBtn.click(function () {
	                $deviceSwitchBtn.removeClass('active');
	                $(this).addClass('active');
	
	                if ($(this).data('device') == 'tablet') {
	                    $preview.removeClass('_phone-preview');
	                    $preview.addClass('_tablet-preview');
	                } else if ($(this).data('device') == 'phone') {
	                    $preview.removeClass('_tablet-preview');
	                    $preview.addClass('_phone-preview');
	                } else {
	                    $preview.removeClass('_phone-preview');
	                    $preview.removeClass('_tablet-preview');
	                }
	            });
	        }
	
	        function initScss() {
	
	            initDefaults();
	
	            $formFieldsInput.on('change input', function (e) {
	                var self = this;
	                if ($(this).data('timeout')) {
	                    clearTimeout($(this).data('timeout'));
	                }
	                $(this).data('timeout', setTimeout(function () {
	                    fieldChange(self);
	                }, 50));
	            });
	
	            $formFieldsSelect.on('change', function () {
	                fieldChange(this);
	            });
	
	            $formFieldsColor.on('keydown', function (e) {
	                var self = this;
	                if ($(this).data('timeout')) {
	                    clearTimeout($(this).data('timeout'));
	                }
	                $(this).data('timeout', setTimeout(function () {
	                    fieldChange(self);
	                }, 30));
	            });
	
	            $formCustomCss.on('cssCodeChanged', function (event, code) {
	                appendCustomCss(code);
	            });
	        }
	
	        function configToScssVar(name, type, options) {
	
	            var scssVar = '';
	
	            if (type == 'default') {
	                values[name] = values[name] == 0 ? 'null' : values[name];
	                scssVar = '$' + name + ': ' + (values[name] || 'null') + ';';
	            } else if (type == 'box-shadow') {
	                if (parseInt(values[name + '_switch'])) {
	                    scssVar = '$' + name + ':  ' + (parseInt(values[name + '_horizontal']) || 0) + 'px ' + (parseInt(values[name + '_vertical']) || 0) + 'px ' + (parseInt(values[name + '_blur']) || 0) + 'px ' + (parseInt(values[name + '_spread']) || 0) + 'px ' + values[name + '_color'] + ';';
	                } else {
	                    scssVar = '$' + name + ': none;';
	                }
	            } else if (type == 'border') {
	                scssVar = '$' + name + ': ' + values[name + '_type'] + ' ' + (parseInt(values[name + '_width']) || 0) + 'px ' + values[name + '_color'] + ';' + '$' + name + '_width: ' + (parseInt(values[name + '_width']) || 0) + ';' + '$' + name + '_type: ' + (values[name + '_type'] || 'none') + ';';
	            } else if (type == 'background') {
	
	                if (values[name + 'bg_image'] != '') {
	                    scssVar = '$' + name + 'background: ' + values[name + 'bg_color'] + ' url("' + values[name + 'bg_image'] + '") ' + values[name + 'bg_position'].replace('-', ' ') + ' / ' + values[name + 'bg_size'] + ' ' + values[name + 'bg_repeat'] + ' ' + values[name + 'bg_attachment'] + ';';
	                } else {
	                    scssVar = '$' + name + 'background: ' + (values[name + 'bg_color'] || 'null') + ';';
	                }
	            } else if (type == 'font') {
	                scssVar = '$' + name + '_size: ' + (parseInt(values[name + '_size']) || 'null') + '; ' + '$' + name + '_spacing: ' + (parseInt(values[name + '_spacing']) || 'null') + '; ' + '$' + name + '_style: ' + (parseInt(values[name + '_italic']) ? 'italic' : 'normal') + '; ' + '$' + name + '_weight: ' + (parseInt(values[name + '_bold']) ? 'bold' : 'normal') + '; ' + '$' + name + '_uppercase: ' + (parseInt(values[name + '_uppercase']) ? 'uppercase' : 'none') + '; ';
	            }
	            return scssVar;
	        }
	
	        function fieldChange(field) {
	
	            $saveButton.removeClass('_saved');
	
	            var type;
	            var fieldName = field.name;
	
	            values[fieldName] = field.value;
	
	            if (iqitThemeEditor.defaults[fieldName].cached) {
	                options[fieldName] = values[fieldName];
	                $preview.addClass('loading-preview');
	                var url = parsePreviewUrl($previewIframe.prop('src'));
	                $previewIframe.prop('src', url);
	            }
	
	            if (iqitThemeEditor.defaults[fieldName].scssType == null) {
	                type = 'default';
	            } else if (iqitThemeEditor.defaults[fieldName].scssType == 'background') {
	                fieldName = fieldName.substring(0, fieldName.indexOf('_bg_')) + '_';
	                type = 'background';
	            } else if (iqitThemeEditor.defaults[fieldName].scssType == 'box-shadow') {
	
	                var $wrapper = $(field).parent();
	                values[fieldName + '_switch'] = $wrapper.find('.js-box-shadow-switch').first().val();
	                values[fieldName + '_horizontal'] = $wrapper.find('.js-shadow-horizontal').first().val();
	                values[fieldName + '_vertical'] = $wrapper.find('.js-shadow-vertical').first().val();
	                values[fieldName + '_blur'] = $wrapper.find('.js-shadow-blur').first().val();
	                values[fieldName + '_spread'] = $wrapper.find('.js-shadow-spread').first().val();
	                values[fieldName + '_color'] = $wrapper.find('.js-shadow-color').first().val();
	                type = iqitThemeEditor.defaults[fieldName].scssType;
	            } else if (iqitThemeEditor.defaults[fieldName].scssType == 'border') {
	
	                var $wrapper = $(field).parent();
	                values[fieldName + '_type'] = $wrapper.find('.js-border-type').first().val();
	                values[fieldName + '_width'] = $wrapper.find('.js-border-width').first().val();
	                values[fieldName + '_color'] = $wrapper.find('.js-border-color').first().val();
	                type = iqitThemeEditor.defaults[fieldName].scssType;
	            } else if (iqitThemeEditor.defaults[fieldName].scssType == 'font') {
	
	                var object = JSON.parse(decodeURIComponent(field.value));
	                values[fieldName + '_size'] = object.size;
	                values[fieldName + '_spacing'] = object.spacing;
	                values[fieldName + '_italic'] = object.italic;
	                values[fieldName + '_bold'] = object.bold;
	                values[fieldName + '_uppercase'] = object.uppercase;
	                type = iqitThemeEditor.defaults[fieldName].scssType;
	            } else if (iqitThemeEditor.defaults[fieldName].scssType == 'ignore') {
	                return true;
	            } else {
	                type = iqitThemeEditor.defaults[fieldName].scssType;
	            }
	            vars[fieldName] = configToScssVar(fieldName, type, '');
	            appendScss(false);
	        }
	
	        function appendScss(removePreloader) {
	
	            var txtVar = '';
	
	            $.each(vars, function (key, value) {
	                txtVar = txtVar + value + '\n';
	            });
	
	            sass.writeFile('dynamicvariables.scss', txtVar);
	            sass.writeFile('final.scss', '' + '@import "dynamicvariables.scss"; ' + '@import "iqitthemeeditor.scss";');
	
	            sass.compileFile('final.scss', function (result) {
	                iFrameStyle.html(result.text);
	                if (removePreloader) {
	                    $preview.removeClass('loading-preview');
	                }
	                $previewIframe[0].contentWindow.$('body').trigger('resize');
	            });
	        }
	
	        function appendCustomCss(code) {
	            iFrameCustomStyle.html(code);
	        }
	
	        function initDefaults() {
	
	            values = $form.serializeObject();
	            $.each(iqitThemeEditor.defaults, function (key, value) {
	
	                var type;
	
	                if (value.cached) {
	                    options[key] = values[key];
	                }
	
	                if (value.scssType == null) {
	                    type = 'default';
	                } else if (value.scssType == 'background') {
	                    key = key.substring(0, key.indexOf('_bg_')) + '_';
	                    type = 'background';
	                } else if (value.scssType == 'ignore') {
	                    return true;
	                } else {
	                    type = value.scssType;
	                }
	                vars[key] = configToScssVar(key, type, '');
	            });
	        }
	
	        function parsePreviewUrl(url) {
	
	            url = removeURLParameter(url, 'isIqitThemeEditor');
	            url = removeURLParameter(url, 'iqitThemeEditorOptions');
	            url = removeURLParameter(url, 'iqit_fronteditor_token');
	            url = removeURLParameter(url, 'admin_webpath');
	            url = removeURLParameter(url, 'id_employee');
	
	            url = addUrlParameter(url, 'isIqitThemeEditor', 1, false);
	            url = addUrlParameter(url, 'iqitThemeEditorOptions', encodeURIComponent(JSON.stringify(options)), false);
	            url = addUrlParameter(url, 'iqit_fronteditor_token', iqitFrontEditor.iqit_fronteditor_token, false);
	            url = addUrlParameter(url, 'admin_webpath', iqitFrontEditor.admin_webpath, false);
	            url = addUrlParameter(url, 'id_employee', iqitFrontEditor.id_employee, false);
	
	            return url;
	        }
	
	        function removeURLParameter(url, parameter) {
	            //prefer to use l.search if you have a location/link object
	            var urlparts = url.split('?');
	            if (urlparts.length >= 2) {
	
	                var prefix = encodeURIComponent(parameter) + '=';
	                var pars = urlparts[1].split(/[&;]/g);
	
	                //reverse iteration as may be destructive
	                for (var i = pars.length; i-- > 0;) {
	                    //idiom for string.startsWith
	                    if (pars[i].lastIndexOf(prefix, 0) !== -1) {
	                        pars.splice(i, 1);
	                    }
	                }
	
	                url = urlparts[0] + (pars.length > 0 ? '?' + pars.join('&') : "");
	                return url;
	            } else {
	                return url;
	            }
	        }
	
	        function addUrlParameter(url, parameterName, parameterValue, atStart) {
	            var replaceDuplicates = true;
	            var urlhash;
	            if (url.indexOf('#') > 0) {
	                var cl = url.indexOf('#');
	                urlhash = url.substring(url.indexOf('#'), url.length);
	            } else {
	                urlhash = '';
	                cl = url.length;
	            }
	            var sourceUrl = url.substring(0, cl);
	
	            var urlParts = sourceUrl.split("?");
	            var newQueryString = "";
	
	            if (urlParts.length > 1) {
	                var parameters = urlParts[1].split("&");
	                for (var i = 0; i < parameters.length; i++) {
	                    var parameterParts = parameters[i].split("=");
	                    if (!(replaceDuplicates && parameterParts[0] == parameterName)) {
	                        if (newQueryString == "") newQueryString = "?";else newQueryString += "&";
	                        newQueryString += parameterParts[0] + "=" + (parameterParts[1] ? parameterParts[1] : '');
	                    }
	                }
	            }
	            if (newQueryString == "") newQueryString = "?";
	
	            if (atStart) {
	                newQueryString = '?' + parameterName + "=" + parameterValue + (newQueryString.length > 1 ? '&' + newQueryString.substring(1) : '');
	            } else {
	                if (newQueryString !== "" && newQueryString != '?') newQueryString += "&";
	                newQueryString += parameterName + "=" + (parameterValue ? parameterValue : '');
	            }
	            return urlParts[0] + newQueryString + urlhash;
	        };
	
	        return { init: init };
	    })();
	
	    iqitMenuPanels.init();
	});

/***/ }),

/***/ 15:
/***/ (function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ })

/******/ });
//# sourceMappingURL=front.js.map
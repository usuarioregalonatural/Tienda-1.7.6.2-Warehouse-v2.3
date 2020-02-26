(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
var ElementsHandler;

ElementsHandler = function( $ ) {
	var registeredHandlers = {},
		registeredGlobalHandlers = [];

	var runGlobalHandlers = function( $scope ) {
		$.each( registeredGlobalHandlers, function() {
			this.call( $scope, $ );
		} );
	};

	this.addHandler = function( widgetType, callback ) {
		registeredHandlers[ widgetType ] = callback;
	};

	this.addGlobalHandler = function( callback ) {
		registeredGlobalHandlers.push( callback );
	};

	this.runReadyTrigger = function( $scope ) {
		var elementType = $scope.data( 'element_type' );

		if ( ! elementType ) {
			return;
		}

		runGlobalHandlers( $scope );

		if ( ! registeredHandlers[ elementType ] ) {
			return;
		}

		registeredHandlers[ elementType ].call( $scope, $ );
	};
};

module.exports = ElementsHandler;

},{}],2:[function(require,module,exports){
/* global elementorFrontendConfig */
( function( $ ) {
	var ElementsHandler = require( 'elementor-frontend/elements-handler' ),
	    Utils = require( 'elementor-frontend/utils' );

	var ElementorFrontend = function() {
		var self = this,
			scopeWindow = window;

		var elementsDefaultHandlers = {
			accordion: require( 'elementor-frontend/handlers/accordion' ),
			alert: require( 'elementor-frontend/handlers/alert' ),
			counter: require( 'elementor-frontend/handlers/counter' ),
			//'image-hotspots': require( 'elementor-frontend/handlers/image-hotspots' ),
			'image-carousel': require( 'elementor-frontend/handlers/image-carousel' ),
			instagram: require( 'elementor-frontend/handlers/instagram' ),
			testimonial: require( 'elementor-frontend/handlers/testimonial' ),
			progress: require( 'elementor-frontend/handlers/progress' ),
			section: require( 'elementor-frontend/handlers/section' ),
			tabs: require( 'elementor-frontend/handlers/tabs' ),
			'prestashop-widget-Blog': require( 'elementor-frontend/handlers/prestashop-blog' ),
			'prestashop-widget-ProductsList': require( 'elementor-frontend/handlers/prestashop-productlist' ),
			'prestashop-widget-ProductsListTabs': require( 'elementor-frontend/handlers/prestashop-productlisttabs' ),
			'prestashop-widget-Brands': require( 'elementor-frontend/handlers/prestashop-brands' ),
			//'prestashop-widget-RevolutionSlider': require( 'elementor-frontend/handlers/prestashop-revolutionslider' ),
			toggle: require( 'elementor-frontend/handlers/toggle' ),
			video: require( 'elementor-frontend/handlers/video' )
		};

		var addGlobalHandlers = function() {
			self.elementsHandler.addGlobalHandler( require( 'elementor-frontend/handlers/global' ) );
		};

		var addElementsHandlers = function() {
			$.each( elementsDefaultHandlers, function( elementName ) {
				self.elementsHandler.addHandler( elementName, this );
			} );
		};

		var runElementsHandlers = function() {
			$( '.elementor-element' ).each( function() {
				self.elementsHandler.runReadyTrigger( $( this ) );
			} );
		};

		this.config = elementorFrontendConfig;

		this.getScopeWindow = function() {
			return scopeWindow;
		};

		this.setScopeWindow = function( window ) {
			scopeWindow = window;
		};

		this.isEditMode = function() {
			return self.config.isEditMode;
		};

		this.elementsHandler = new ElementsHandler( $ );

		this.utils = new Utils( $ );

		this.init = function() {
			addGlobalHandlers();

			addElementsHandlers();


			runElementsHandlers();
		};

		// Based on underscore function
		this.throttle = function( func, wait ) {
			var timeout,
				context,
				args,
				result,
				previous = 0;

			var later = function() {
				previous = Date.now();
				timeout = null;
				result = func.apply( context, args );

				if ( ! timeout ) {
					context = args = null;
				}
			};

			return function() {
				var now = Date.now(),
					remaining = wait - ( now - previous );

				context = this;
				args = arguments;

				if ( remaining <= 0 || remaining > wait ) {
					if ( timeout ) {
						clearTimeout( timeout );
						timeout = null;
					}

					previous = now;
					result = func.apply( context, args );

					if ( ! timeout ) {
						context = args = null;
					}
				} else if ( ! timeout ) {
					timeout = setTimeout( later, remaining );
				}

				return result;
			};
		};
	};

	window.elementorFrontend = new ElementorFrontend();
} )( jQuery );

jQuery( function() {
	if ( ! elementorFrontend.isEditMode() ) {
		elementorFrontend.init();
	}
} );

},{"elementor-frontend/elements-handler":1,"elementor-frontend/handlers/accordion":3,"elementor-frontend/handlers/alert":4,"elementor-frontend/handlers/counter":5,"elementor-frontend/handlers/global":6,"elementor-frontend/handlers/image-carousel":7,"elementor-frontend/handlers/instagram":8,"elementor-frontend/handlers/prestashop-blog":9,"elementor-frontend/handlers/prestashop-brands":10,"elementor-frontend/handlers/prestashop-productlist":11,"elementor-frontend/handlers/prestashop-productlisttabs":12,"elementor-frontend/handlers/progress":13,"elementor-frontend/handlers/section":14,"elementor-frontend/handlers/tabs":15,"elementor-frontend/handlers/testimonial":16,"elementor-frontend/handlers/toggle":17,"elementor-frontend/handlers/video":18,"elementor-frontend/utils":19}],3:[function(require,module,exports){
var activateSection = function( sectionIndex, $accordionTitles ) {
	var $activeTitle = $accordionTitles.filter( '.active' ),
		$requestedTitle = $accordionTitles.filter( '[data-section="' + sectionIndex + '"]' ),
		isRequestedActive = $requestedTitle.hasClass( 'active' );

	$activeTitle
		.removeClass( 'active' )
		.next()
		.slideUp();

	if ( ! isRequestedActive ) {
		$requestedTitle
			.addClass( 'active' )
			.next()
			.slideDown();
	}
};

module.exports = function( $ ) {
	var $this = $( this ),
		$accordionDiv = $this.find( '.elementor-accordion' ),
		defaultActiveSection = $accordionDiv.data( 'active-section' ),
		activeFirst =  $accordionDiv.data( 'active-first' ),
		$accordionTitles = $this.find( '.elementor-accordion-title' );

	if ( ! defaultActiveSection ) {
		defaultActiveSection = 1;
	}

	if(activeFirst){
		activateSection( defaultActiveSection, $accordionTitles );
	}


	$accordionTitles.on( 'click', function() {
		activateSection( this.dataset.section, $accordionTitles );
	} );
};

},{}],4:[function(require,module,exports){
module.exports = function( $ ) {
	$( this ).find( '.elementor-alert-dismiss' ).on( 'click', function() {
		$( this ).parent().fadeOut();
	} );
};

},{}],5:[function(require,module,exports){
module.exports = function( $ ) {

	var $number = $( this ).find(  '.elementor-counter-number' );

	$number.waypoint( function() {
		$number.numerator( {
			duration: $number.data( 'duration' )
		} );
	}, { offset: '90%' } );
};

},{}],6:[function(require,module,exports){
module.exports = function() {
	if ( elementorFrontend.isEditMode() ) {
		return;
	}

	var $element = this,
		animation = $element.data( 'animation' );

	if ( ! animation ) {
		return;
	}

	$element.addClass( 'elementor-invisible' ).removeClass( animation );

	$element.waypoint( function() {
		$element.removeClass( 'elementor-invisible' ).addClass( animation );
	}, { offset: '90%' } );

};

},{}],7:[function(require,module,exports){
module.exports = function( $ ) {
	var $carousel = $( this ).find( '.elementor-image-carousel' );
	if ( ! $carousel.length ) {
		return;
	}

	var savedOptions = $carousel.data( 'slider_options' ),
		tabletSlides = 1 === savedOptions.slidesToShow ? 1 : 2,
		defaultOptions = {
			responsive: [
				{
					breakpoint: 767,
					settings: {
						slidesToShow: tabletSlides,
						slidesToScroll: tabletSlides
					}
				},
				{
					breakpoint: 480,
					settings: {
						slidesToShow: 1,
						slidesToScroll: 1
					}
				}
			]
		},



		slickOptions = $.extend( {}, defaultOptions, savedOptions );

	$carousel.slick( slickOptions );
};

},{}],8:[function(require,module,exports){
module.exports = function( $ ) {

	var $instagramWrapper = $( this ).find( '.elementor-instagram' );
    var $carousel = $( this ).find( '.elementor-instagram-carousel' );

	if ( ! $instagramWrapper.length ) {
		return;
	}

	var options = $instagramWrapper.data( 'options' );

	if (options.token == '' ) {
		return;
	}

	$instagramWrapper.instagramLite({
		accessToken: options.token,
		limit: options.limit,
		urls: options.linked,
		element_class: options.class,
		comments_count: true,
		likes: true,
		videos: false,
		date: false,
		list: true,
		captions: false,
        success: function() {

            if ( ! $carousel.length ) {
                return;
            }

            var savedOptions = $carousel.data( 'slider_options' ),
                defaultOptions = {
                    responsive: [
                        {
                            breakpoint: 767,
                            settings: {
                                slidesToShow: savedOptions.slidesToShowTablet,
                                slidesToScroll: savedOptions.slidesToShowTablet
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: savedOptions.slidesToShowMobile,
                                slidesToScroll: savedOptions.slidesToShowMobile
                            }
                        }
                    ]
                },

                slickOptions = $.extend( {}, defaultOptions, $carousel.data( 'slider_options' ) );

            $carousel.slick( slickOptions );

        },
	});
};

},{}],9:[function(require,module,exports){
module.exports = function( $ ) {
    var $carousel = $( this ).find( '.elementor-blog-carousel' );
    if ( ! $carousel.length ) {
        return;
    }

    var savedOptions = $carousel.data( 'slider_options' ),
        defaultOptions = {
            responsive: [
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: savedOptions.slidesToShowTablet,
                        slidesToScroll: savedOptions.slidesToShowTablet
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: savedOptions.slidesToShowMobile,
                        slidesToScroll: savedOptions.slidesToShowMobile
                    }
                }
            ]
        },

        slickOptions = $.extend( {}, defaultOptions, $carousel.data( 'slider_options' ) );

    $carousel.slick( slickOptions );
};

},{}],10:[function(require,module,exports){
module.exports = function ($) {
    var $carousel = $(this).find('.elementor-brands-carousel');
    if (!$carousel.length) {
        return;
    }

    var respondTo = 'window';

    if (elementorFrontendConfig.isEditMode) {
        respondTo = 'iframe-window';
    }

    var savedOptions = $carousel.data('slider_options'),
        defaultOptions = {
            respondTo: respondTo,
            infinite: false,
            autoplaySpeed: 4500,
            rows: savedOptions.itemsPerColumn,
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: savedOptions.slidesToShowTablet,
                        slidesToScroll: savedOptions.slidesToShowTablet
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: savedOptions.slidesToShowMobile,
                        slidesToScroll: savedOptions.slidesToShowMobile
                    }
                }
            ]
        },

        slickOptions = $.extend({}, defaultOptions, $carousel.data('slider_options'));

    $carousel.slick(slickOptions);

    if (elementorFrontendConfig.isEditMode) {
        $(window).on('changedDeviceMode', function () {
            $carousel.slick('getSlick').checkResponsive();
        });
    }
};

},{}],11:[function(require,module,exports){
module.exports = function ($) {
    var $carousel = $(this).find('.elementor-products-carousel');
    if (!$carousel.length) {
        if (elementorFrontendConfig.isEditMode) {
            $(this).find('img[data-src]').each(function() {
                $(this).attr('src', $(this).data('src'));
            });
        }
        return;
    }

    var respondTo = 'window';

    if (elementorFrontendConfig.isEditMode) {
        respondTo = 'iframe-window';
    }

    var savedOptions = $carousel.data('slider_options'),
        defaultOptions = {
            respondTo: respondTo,
            infinite: false,
            autoplaySpeed: 4500,
            rows: savedOptions.itemsPerColumn,
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: savedOptions.slidesToShowTablet,
                        slidesToScroll: savedOptions.slidesToShowTablet
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: savedOptions.slidesToShowMobile,
                        slidesToScroll: savedOptions.slidesToShowMobile
                    }
                }
            ]
        },

        slickOptions = $.extend({}, defaultOptions, $carousel.data('slider_options'));

    $carousel.slick(slickOptions);

    if (elementorFrontendConfig.isEditMode) {
        $(window).on('changedDeviceMode', function () {
            $carousel.slick('getSlick').checkResponsive();
        });
    }
};

},{}],12:[function(require,module,exports){
module.exports = function ($) {
    var $carousel = $(this).find('.elementor-products-carousel');
    if (!$carousel.length) {
        if (elementorFrontendConfig.isEditMode) {
            $(this).find('img[data-src]').each(function() {
                $(this).attr('src', $(this).data('src'));
            });
        }
        return;
    }

    var respondTo = 'window';

    if (elementorFrontendConfig.isEditMode) {
        respondTo = 'iframe-window';
    }

    var savedOptions = $carousel.data('slider_options'),
        defaultOptions = {
            respondTo: respondTo,
            infinite: false,
            autoplaySpeed: 4500,
            rows: savedOptions.itemsPerColumn,
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: savedOptions.slidesToShowTablet,
                        slidesToScroll: savedOptions.slidesToShowTablet
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: savedOptions.slidesToShowMobile,
                        slidesToScroll: savedOptions.slidesToShowMobile
                    }
                }
            ]
        },

        slickOptions = $.extend({}, defaultOptions, $carousel.data('slider_options'));

    $carousel.slick(slickOptions);

    if (elementorFrontendConfig.isEditMode) {
        $(window).on('changedDeviceMode', function () {
            $carousel.slick('getSlick').checkResponsive();
        });
    }

    $(document).on('shown.bs.tab', $(this).find('a[data-toggle="tab"]'), function (e) {
        prestashop.iqitLazyLoad.update();
    })


};

},{}],13:[function(require,module,exports){
module.exports = function( $ ) {
	var $progressbar = $( this ).find( '.elementor-progress-bar' );

	$progressbar.waypoint( function() {
		$progressbar.css( 'width', $progressbar.data( 'max' ) + '%' )
	}, { offset: '90%' } );
};

},{}],14:[function(require,module,exports){
var BackgroundVideo = function( $, $backgroundVideoContainer ) {
	var player,
		elements = {},
		isYTVideo = false;

	var calcVideosSize = function() {
		var containerWidth = $backgroundVideoContainer.outerWidth(),
			containerHeight = $backgroundVideoContainer.outerHeight(),
			aspectRatioSetting = '16:9', //TEMP
			aspectRatioArray = aspectRatioSetting.split( ':' ),
			aspectRatio = aspectRatioArray[ 0 ] / aspectRatioArray[ 1 ],
			ratioWidth = containerWidth / aspectRatio,
			ratioHeight = containerHeight * aspectRatio,
			isWidthFixed = containerWidth / containerHeight > aspectRatio;

		return {
			width: isWidthFixed ? containerWidth : ratioHeight,
			height: isWidthFixed ? ratioWidth : containerHeight
		};
	};

	var changeVideoSize = function() {
		var $video = isYTVideo ? $( player.getIframe() ) : elements.$backgroundVideo,
			size = calcVideosSize();

		$video.width( size.width ).height( size.height );
	};

	var prepareYTVideo = function( YT, videoID ) {
		player = new YT.Player( elements.$backgroundVideo[ 0 ], {
			videoId: videoID,
			events: {
				onReady: function() {
					player.mute();

					changeVideoSize();

					player.playVideo();
				},
				onStateChange: function( event ) {
					if ( event.data === YT.PlayerState.ENDED ) {
						player.seekTo( 0 );
					}
				}
			},
			playerVars: {
				controls: 0,
				mute: 1,
				showinfo: 0
			}
		} );

		$( elementorFrontend.getScopeWindow() ).on( 'resize', changeVideoSize );
	};

	var initElements = function() {
		elements.$backgroundVideo = $backgroundVideoContainer.children( '.elementor-background-video' );
	};

	var run = function() {
		var videoID = elements.$backgroundVideo.data( 'video-id' );

		if ( videoID ) {
			isYTVideo = true;

			elementorFrontend.utils.onYoutubeApiReady( function( YT ) {
				setTimeout( function() {
					prepareYTVideo( YT, videoID );
				}, 1 );
			} );
		} else {
			elements.$backgroundVideo.one( 'canplay', changeVideoSize );
		}
	};

	var init = function() {
		initElements();
		run();
	};

	init();
};



module.exports = function( $ ) {
	//new StretchedSection( $, this );

	var $backgroundVideoContainer = this.find( '.elementor-background-video-container' );

	if ( $backgroundVideoContainer ) {
		new BackgroundVideo( $, $backgroundVideoContainer );
	}
};

},{}],15:[function(require,module,exports){
module.exports = function( $ ) {
	var $this = $( this ),
		defaultActiveTab = $this.find( '.elementor-tabs' ).data( 'active-tab' ),
		$tabsTitles = $this.find( '.elementor-tab-title' ),
		$tabs = $this.find( '.elementor-tab-content' ),
		$active,
		$content;

	if ( ! defaultActiveTab ) {
		defaultActiveTab = 1;
	}

	var activateTab = function( tabIndex ) {
		if ( $active ) {
			$active.removeClass( 'active' );

			$content.removeClass( 'active' );
		}

		$active = $tabsTitles.filter( '[data-tab="' + tabIndex + '"]' );
		$active.addClass( 'active' );
		$content = $tabs.filter( '[data-tab="' + tabIndex + '"]' );
		$content.addClass( 'active' );
	};

	activateTab( defaultActiveTab );

	$tabsTitles.on( 'click', function() {
		activateTab( this.dataset.tab );
	} );
};

},{}],16:[function(require,module,exports){
module.exports = function( $ ) {
	var $carousel = $( this ).find( '.elementor-testimonial-carousel' );
	if ( ! $carousel.length ) {
		return;
	}

	var savedOptions = $carousel.data( 'slider_options' ),
		tabletSlides = 1 === savedOptions.slidesToShow ? 1 : 2,
		defaultOptions = {
			responsive: [
				{
					breakpoint: 767,
					settings: {
						slidesToShow: tabletSlides,
						slidesToScroll: tabletSlides
					}
				},
				{
					breakpoint: 480,
					settings: {
						slidesToShow: 1,
						slidesToScroll: 1
					}
				}
			]
		},

		slickOptions = $.extend( {}, defaultOptions, $carousel.data( 'slider_options' ) );

	$carousel.slick( slickOptions );
};

},{}],17:[function(require,module,exports){
module.exports = function( $ ) {
	var $toggleTitles = $( this ).find( '.elementor-toggle-title' );

	$toggleTitles.on( 'click', function() {
		var $active = $( this ),
			$content = $active.next();

		if ( $active.hasClass( 'active' ) ) {
			$active.removeClass( 'active' );
			$content.slideUp();
		} else {
			$active.addClass( 'active' );
			$content.slideDown();
		}
	} );
};

},{}],18:[function(require,module,exports){
module.exports = function( $ ) {
	var $this = $( this ),
		$imageOverlay = $this.find( '.elementor-custom-embed-image-overlay' ),
		$videoModalBtn = $this.find( '.elementor-video-open-modal' ).first(),
		$videoModal = $this.find( '.elementor-video-modal' ).first(),
		$videoFrame = $this.find( 'iframe' );

	if ( $imageOverlay.length ) {

		$imageOverlay.on( 'click', function() {
			$imageOverlay.remove();
			var newSourceUrl = $videoFrame[0].src;
			// Remove old autoplay if exists
			newSourceUrl = newSourceUrl.replace( 'autoplay=0', 'autoplay=1' );
			$videoFrame[0].src = newSourceUrl;
		} );
	}

	if ( ! $videoModalBtn.length ) {
		return;
	}


	$videoModalBtn.on( 'click', function() {
		var newSourceUrl = $videoFrame[0].src;
		// Remove old autoplay if exists
		newSourceUrl = newSourceUrl.replace( 'autoplay=0', 'autoplay=1' );
		$videoFrame[0].src = newSourceUrl;
	} );


	$videoModal.on('hide.bs.modal', function () {
		var newSourceUrl = $videoFrame[0].src;
		// Remove old autoplay if exists
		newSourceUrl = newSourceUrl.replace( 'autoplay=1', 'autoplay=0' );
		$videoFrame[0].src = newSourceUrl;
	});


};

},{}],19:[function(require,module,exports){
var Utils;

Utils = function( $ ) {
	var self = this;
	var isYTInserted = false;

	this.onYoutubeApiReady = function( callback ) {

		if ( ! isYTInserted ) {
			insertYTApi();
		}

		if ( window.YT && YT.loaded ) {
			callback( YT );
		} else {
			// If not ready check again by timeout..
			setTimeout( function() {
				self.onYoutubeApiReady( callback );
			}, 350 );
		}
	};



	var insertYTApi = function() {
		isYTInserted = true;

		$( 'script:first' ).before(  $( '<script>', { src: 'https://www.youtube.com/iframe_api' } ) );
	};
};

module.exports = Utils;

},{}]},{},[2])
//# sourceMappingURL=frontend.js.map

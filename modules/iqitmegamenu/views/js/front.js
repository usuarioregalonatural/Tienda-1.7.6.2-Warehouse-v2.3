/**
* 2014-2017 IQIT-COMMERCE.COM
*
* NOTICE OF LICENSE
*
*  @author    IQIT-COMMERCE.COM <support@iqit-commerce.com>
*  @copyright 2007-2017 IQIT-COMMERCE.COM
*  @license   GNU General Public License version 2
*
* You can not resell or redistribute this software.
* 
*/

// classie - class helper functions, from bonzo https://github.com/ded/bonzo

!function(a){"use strict";function b(a){return new RegExp("(^|\\s+)"+a+"(\\s+|$)")}function f(a,b){var f=c(a,b)?e:d;f(a,b)}var c,d,e;"classList"in document.documentElement?(c=function(a,b){return a.classList.contains(b)},d=function(a,b){a.classList.add(b)},e=function(a,b){a.classList.remove(b)}):(c=function(a,c){return b(c).test(a.className)},d=function(a,b){c(a,b)||(a.className=a.className+" "+b)},e=function(a,c){a.className=a.className.replace(b(c)," ")});var g={hasClass:c,addClass:d,removeClass:e,toggleClass:f,has:c,add:d,remove:e,toggle:f};"function"==typeof define&&define.amd?define(g):a.classie=g}(window);

//hover intent
(function($){$.fn.hoverIntent=function(handlerIn,handlerOut,selector){var cfg={interval:100,sensitivity:6,timeout:0};if(typeof handlerIn==="object"){cfg=$.extend(cfg,handlerIn)}else{if($.isFunction(handlerOut)){cfg=$.extend(cfg,{over:handlerIn,out:handlerOut,selector:selector})}else{cfg=$.extend(cfg,{over:handlerIn,out:handlerIn,selector:handlerOut})}}var cX,cY,pX,pY;var track=function(ev){cX=ev.pageX;cY=ev.pageY};var compare=function(ev,ob){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);if(Math.sqrt((pX-cX)*(pX-cX)+(pY-cY)*(pY-cY))<cfg.sensitivity){$(ob).off("mousemove.hoverIntent",track);ob.hoverIntent_s=true;return cfg.over.apply(ob,[ev])}else{pX=cX;pY=cY;ob.hoverIntent_t=setTimeout(function(){compare(ev,ob)},cfg.interval)}};var delay=function(ev,ob){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);ob.hoverIntent_s=false;return cfg.out.apply(ob,[ev])};var handleHover=function(e){var ev=$.extend({},e);var ob=this;if(ob.hoverIntent_t){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t)}if(e.type==="mouseenter"){pX=ev.pageX;pY=ev.pageY;$(ob).on("mousemove.hoverIntent",track);if(!ob.hoverIntent_s){ob.hoverIntent_t=setTimeout(function(){compare(ev,ob)},cfg.interval)}}else{$(ob).off("mousemove.hoverIntent",track);if(ob.hoverIntent_s){ob.hoverIntent_t=setTimeout(function(){delay(ev,ob)},cfg.timeout)}}};return this.on({"mouseenter.hoverIntent":handleHover,"mouseleave.hoverIntent":handleHover},cfg.selector)}})(jQuery);

//double tap
;(function(e,t,n,r){e.fn.doubleTapToGo=function(r){if(!("ontouchstart"in t)&&!navigator.msMaxTouchPoints&&!navigator.userAgent.toLowerCase().match(/windows phone os 7/i))return false;this.each(function(){var t=false;e(this).on("click",function(n){var r=e(this);if(r[0]!=t[0]){n.preventDefault();t=r}});e(n).on("click touchstart MSPointerDown",function(n){var r=true,i=e(n.target).parents();for(var s=0;s<i.length;s++)if(i[s]==t[0])r=false;if(r)t=false})});return this}})(jQuery,window,document);

var cbpHorizontalMenu, cbpVerticalmenu;

$(document).ready(function(){

  cbpHorizontalMenu = (function() {

    var menuId = '#cbp-hrmenu',
        $listItems = $( menuId + '> ul > li'  ),
        $menuItems = $listItems.children( 'a, .cbp-main-link' ),
        $innerTabs = $( menuId + ' .cbp-hrsub-tabs-names li > a'  ),
        $body = $( 'body' ),
        $header = $( '#desktop-header-container' ),
        current = -1;
    currentlevel = -1;

    $listItems.has('ul').find(' > a').doubleTapToGo();

    function init() {
      var isTouchDevice = 'ontouchstart' in document.documentElement;
      if( isTouchDevice ) {
        $menuItems.on( 'mouseover', open );
      }
      else{
        $menuItems.hoverIntent( {
          over: open,
          out: dnthing,
          interval: 30
        } );
      }

      $listItems.on( 'mouseover', function( event ) { event.stopPropagation(); } );

      $innerTabs.hover( function(){
        $innerTabs.removeClass('active');
        $(this).tab('show');
      });
    }

    var setCurrent = function(strName) {
      current = strName;
    };

    function dnthing( event ) {

    }

    function open( event ) {

      $othemenuitem = $('#cbp-hrmenu1').find('.cbp-hropen');


      $othemenuitem.find('.cbp-hrsub').removeClass('cbp-show');
      $othemenuitem.removeClass( 'cbp-hropen' );

      cbpVerticalmenu.setCurrent(-1);

      var $item = $( event.currentTarget ).parent( 'li' ),
          idx = $item.index();


      $submenu = $item.find('.cbp-hrsub');

      if(current == idx )
        return;

      $submenu.removeClass('cbp-notfit');
      $submenu.removeClass('cbp-show');

      if( current !== -1 ) {
        $listItems.eq( current ).removeClass( 'cbp-hropen' );
      }

      if( current === idx ) {
        $item.removeClass( 'cbp-hropen' );
        current = -1;

      }
      else {
        $submenu.addClass( 'cbp-show' );
        iqitmenuwidth = $header.width();
        iqititemposition = $item.offset().left - $header.offset().left;

        if((iqitmenuwidth-iqititemposition)<=$submenu.width())
        {
          $submenu.addClass( 'cbp-notfit' );
        }

        $item.addClass( 'cbp-hropen' );
        current = idx;
        $body.off( 'mouseover' ).on( 'mouseover', close );
      }



      return false;

    }

    function close( event ) {
      $listItems.eq( current ).removeClass( 'cbp-hropen' );
      current = -1;
    }

    return { init : init,
      setCurrent: setCurrent
    };

  })();

  cbpHorizontalMenu.init();

});

$(document).ready(function(){

  $('.cbp-vertical-on-top').on( 'mouseover', function() {
    $(this).addClass('cbp-vert-expanded');
  });

  $('.cbp-vertical-on-top').on( 'mouseleave', function() {
    $(this).removeClass('cbp-vert-expanded');
  });



  cbpVerticalmenu = (function(test) {

    var menuId = '#cbp-hrmenu1-ul',
        $listItems = $( menuId + ' > li'  ),
        $menuItems = $listItems.children( 'a' ),
        $innerTabs = $( menuId + ' .cbp-hrsub-tabs-names li > a'  ),
        $body = $( 'body' ),
        current = -1,
        currentlevel = -1;

    $listItems.has('ul').find(' > a').doubleTapToGo();



    function init() {

      var isTouchDevice = 'ontouchstart' in document.documentElement;
      if( isTouchDevice ) {
        $menuItems.on( 'mouseover', open );
      }
      else{
        $menuItems.hoverIntent( {
          over: open,
          out: dnthing,
          interval: 30
        } );
      }

      $listItems.on( 'mouseover', function( event ) { event.stopPropagation(); } );

      $innerTabs.hover( function(){
        $innerTabs.removeClass('active');
        $(this).tab('show');
      });

      $( window ).resize(function() {
        $('cbp-hrmenu-tab').not('.cbp-hropen').find( '.cbp-hrsub-wrapper' ).removeAttr( 'style' );
      });
    }

    function dnthing( event ) {

    }

    var setCurrent = function(strName) {
      current = strName;
    };

    function open( event ) {


      $othemenuitem = $('#cbp-hrmenu').find('.cbp-hropen');

      $othemenuitem.find('.cbp-hrsub').removeClass('cbp-show');
      closeElement($othemenuitem);

      cbpHorizontalMenu.setCurrent(-1);

      var $item = $( event.currentTarget ).parent( 'li' ),
          idx = $item.index();

      if(current == idx )
        return;

      $submenu = $item.find('.cbp-hrsub');
      $submenu.removeClass('cbp-show');

      if( current !== -1 ) {
        closeElement($listItems.eq( current ));
      }

      if( current === idx ) {
        closeElement($item);
        current = -1;
      }
      else {
        $submenu.parent().width($(iqitmegamenu.containerSelector).width()-$(menuId).width());
        callerHeight = $item.height();
        $submenu.parent().css( { marginLeft : $item.innerWidth()+"px", marginRight : $item.innerWidth()+"px", marginTop : -callerHeight+"px" } );
        $submenu.addClass( 'cbp-show' );
        $item.addClass( 'cbp-hropen' );
        current = idx;
        $body.off( 'mouseover' ).on( 'mouseover', close );
      }

      return false;
    }

    function close( event ) {
      closeElement($listItems.eq( current ));
      current = -1;
    }

    function closeElement( $element ) {
      $element.removeClass( 'cbp-hropen' );
    }

    return { init : init,
      setCurrent: setCurrent
    };

  })();

  cbpVerticalmenu.init();

});


$(document).ready(function(){

  var iqitMobileMenu = (function() {

    var $menu = $('#iqitmegamenu-mobile');
    var $expander = $menu.find('.mm-expand');

    $menu.on('click', function (e) {
      e.stopPropagation()
    });

    $expander.on('click', function () {
      $(this).parent().toggleClass('show');
    });
  });

  iqitMobileMenu();
  
});




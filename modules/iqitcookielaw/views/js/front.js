/**
 * 2017 IQIT-COMMERCE.COM
 *
 * NOTICE OF LICENSE
 *
 * This file is licenced under the Software License Agreement.
 * With the purchase or the installation of the software in your application
 * you accept the licence agreement
 *
 *  @author    IQIT-COMMERCE.COM <support@iqit-commerce.com>
 *  @copyright 2017 IQIT-COMMERCE.COM
 *  @license   Commercial license (You can not resell or redistribute this software)
 *
 */

$(document).ready(function(){
  $("#iqitcookielaw").addClass('iqitcookielaw-showed');
  $("#iqitcookielaw-accept").click(function (event) {
    event.preventDefault();
    $("#iqitcookielaw").removeClass('iqitcookielaw-showed');
    setcook();
  });
});

function setcook() {
  var name = 'cookielaw_module';
  var value = '1';
  var today = new Date();
  var expire = new Date();
  expire.setTime(today.getTime() + 3600000*24*14);
  document.cookie = name + "=" + escape(value) +";path=/;" + ((expire==null)?"" : ("; expires=" + expire.toGMTString()))
}

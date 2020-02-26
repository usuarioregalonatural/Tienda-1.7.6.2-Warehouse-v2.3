/**
 * 2020 Packlink
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Apache License 2.0
 * that is bundled with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * http://www.apache.org/licenses/LICENSE-2.0.txt
 *
 * @author    Packlink <support@packlink.com>
 * @copyright 2020 Packlink Shipping S.L
 * @license   http://www.apache.org/licenses/LICENSE-2.0.txt  Apache License 2.0
 */

var Packlink = window.Packlink || {};

/**
 * Creates order draft for the order with provided ID.
 *
 * @param {object} element
 */
function plCreateOrderDraft(element) {
  let ajaxService = Packlink.ajaxService,
      orderId = parseInt(element.dataset.order),
      controllerUrl = element.dataset.createDraftUrl;

  element.disabled = true;
  ajaxService.post(
      controllerUrl,
      {orderId: orderId},
      function () {
        window.location.reload();
      },
      function () {
        element.disabled = false;
      }
  );
}

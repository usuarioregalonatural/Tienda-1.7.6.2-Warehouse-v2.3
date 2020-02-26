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

// needed because this could be loaded before core's service file.
setTimeout(packlinkOverrideCoreAjaxService, 100);

function packlinkOverrideCoreAjaxService() {
    if (Packlink.ajaxService) {
        Packlink.ajaxService.internalPerformPost = function (request, data) {
            request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            request.send('plPostData=' + encodeURIComponent(JSON.stringify(data)));
        };
    } else {
        setTimeout(packlinkOverrideCoreAjaxService, 100);
    }
}

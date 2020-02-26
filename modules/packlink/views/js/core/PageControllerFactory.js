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

(function () {
    function PageControllerFactory() {
        /**
         * Instantiates page controller;
         *
         * @param {string} controller
         * @param {object} configuration
         */
        this.getInstance = function (controller, configuration) {
            let parts = controller.split('-');
            let name = '';
            for (let part of parts) {
                part = part.charAt(0).toUpperCase() + part.slice(1);
                name += part;
            }

            name += 'Controller';

            return new Packlink[name](configuration);
        };
    }

    Packlink.pageControllerFactory = new PageControllerFactory();
})();

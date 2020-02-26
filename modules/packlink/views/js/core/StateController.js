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
    /**
     * Main controller of the application.
     *
     * @param {{
     *      sidebarButtons: array,
     *      submenuItems: array,
     *      pageConfiguration: array,
     *      scrollConfiguration: {scrollOffset: number, rowHeight: number},
     *      hasTaxConfiguration: boolean,
     *      hasCountryConfiguration: boolean,
     *      canDisplayCarrierLogos: boolean,
     *      shippingServiceMaxTitleLength: number,
     *      autoConfigureStartUrl: string,
     *      dashboardGetStatusUrl: string,
     *      defaultParcelGetUrl: string,
     *      defaultParcelSubmitUrl: string,
     *      defaultWarehouseGetUrl: string,
     *      defaultWarehouseSubmitUrl: string,
     *      defaultWarehouseSearchPostalCodesUrl: string,
     *      debugGetStatusUrl: string,
     *      debugSetStatusUrl: string,
     *      shippingMethodsGetAllUrl: string,
     *      shippingMethodsGetStatusUrl: string,
     *      shippingMethodsGetTaxClassesUrl: string,
     *      shippingMethodsSaveUrl: string,
     *      shippingMethodsActivateUrl: string,
     *      shippingMethodsDeactivateUrl: string,
     *      shopShippingMethodCountGetUrl: string,
     *      shopShippingMethodsDisableUrl: string,
     *      getSystemOrderStatusesUrl: string,
     *      orderStatusMappingsSaveUrl: string,
     *      orderStatusMappingsGetUrl: string,
     *      getShippingCountriesUrl: string
     * }} configuration
     *
     * @constructor
     */
    function StateController(configuration) {
        let pageControllerFactory = Packlink.pageControllerFactory;

        let sidebarButtons = [
            'shipping-methods',
            'basic-settings'
        ];

        if (typeof configuration.sidebarButtons !== 'undefined') {
            sidebarButtons = sidebarButtons.concat(configuration.sidebarButtons);
        }

        let submenuItems = [
            'order-state-mapping',
            'default-parcel',
            'default-warehouse'
        ];

        if (typeof configuration.submenuItems !== 'undefined') {
            submenuItems = submenuItems.concat(configuration.submenuItems);
        }

        let sidebarController = new Packlink.SidebarController(navigate, sidebarButtons, submenuItems);
        let utilityService = Packlink.utilityService;
        let context = '';

        let pageConfiguration = {
            'default-parcel': {
                getUrl: configuration.defaultParcelGetUrl,
                submitUrl: configuration.defaultParcelSubmitUrl
            },
            'default-warehouse': {
                getUrl: configuration.defaultWarehouseGetUrl,
                submitUrl: configuration.defaultWarehouseSubmitUrl,
                searchPostalCodesUrl: configuration.defaultWarehouseSearchPostalCodesUrl
            },
            'shipping-methods': {
                getDashboardStatusUrl: configuration.dashboardGetStatusUrl,
                getAllMethodsUrl: configuration.shippingMethodsGetAllUrl,
                getMethodsStatusUrl: configuration.shippingMethodsGetStatusUrl,
                activateUrl: configuration.shippingMethodsActivateUrl,
                deactivateUrl: configuration.shippingMethodsDeactivateUrl,
                saveUrl: configuration.shippingMethodsSaveUrl,
                rowHeight: configuration.scrollConfiguration.rowHeight,
                scrollOffset: configuration.scrollConfiguration.scrollOffset,
                maxTitleLength: configuration.shippingServiceMaxTitleLength,
                getShopShippingMethodCountUrl: configuration.shopShippingMethodCountGetUrl,
                disableShopShippingMethodsUrl: configuration.shopShippingMethodsDisableUrl,
                autoConfigureStartUrl: configuration.autoConfigureStartUrl,
                hasTaxConfiguration: configuration.hasTaxConfiguration,
                getTaxClassesUrl: configuration.shippingMethodsGetTaxClassesUrl,
                canDisplayCarrierLogos: configuration.canDisplayCarrierLogos,
                getShippingCountries: configuration.getShippingCountriesUrl,
                hasCountryConfiguration: configuration.hasCountryConfiguration
            },
            'order-state-mapping': {
                getSystemOrderStatusesUrl: configuration.getSystemOrderStatusesUrl,
                getUrl: configuration.orderStatusMappingsGetUrl,
                saveUrl: configuration.orderStatusMappingsSaveUrl
            },
            'footer': {
                getDebugStatusUrl: configuration.debugGetStatusUrl,
                setDebugStatusUrl: configuration.debugSetStatusUrl
            }
        };

        if (typeof configuration.pageConfiguration !== 'undefined') {
            pageConfiguration = {...pageConfiguration, ...configuration.pageConfiguration};
        }

        this.display = function () {
            pageControllerFactory.getInstance('footer', getControllerConfiguration('footer')).display();

            let dp = pageControllerFactory.getInstance(
                'shipping-methods',
                getControllerConfiguration('shipping-methods')
            );
            dp.display();
        };

        /**
         * Opens configuration page that corresponds to particular step.
         *
         * @param {string} step
         */
        this.startStep = function (step) {
            utilityService.disableInputMask();
            let controller = pageControllerFactory.getInstance(step, getControllerConfiguration(step, true));
            controller.display();
        };

        /**
         * Called when configuration step is finished.
         */
        this.stepFinished = function () {
            pageControllerFactory.getInstance(
                'shipping-methods',
                getControllerConfiguration('shipping-methods')).display();
        };

        /**
         * Returns context.
         */
        this.getContext = function () {
            return context;
        };

        /**
         * Navigation callback.
         * Handles navigation menu button clicked event.
         *
         * @param event
         */
        function navigate(event) {
            let state = event.target.getAttribute('data-pl-sidebar-btn');
            sidebarController.setState(state);
            if (state !== 'basic-settings') {
                utilityService.disableInputMask();

                let controller = pageControllerFactory.getInstance(state, getControllerConfiguration(state));
                controller.display();
            }
        }

        function getControllerConfiguration(controller, fromStep) {
            let config = utilityService.cloneObject(pageConfiguration[controller]);

            setContext();
            config.context = context;

            if (fromStep) {
                config.fromStep = true;
            }

            return config;
        }

        /**
         * Sets context.
         */
        function setContext() {
            context = Math.random().toString(36);
        }
    }

    Packlink.StateController = StateController;
})();

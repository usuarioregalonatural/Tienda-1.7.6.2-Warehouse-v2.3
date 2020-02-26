/**
 * 2007-2019 PrestaShop
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author 2007-2019 PayPal
 *  @author 202 ecommerce <tech@202-ecommerce.com>
 * @copyright PayPal
 * @license   http://addons.prestashop.com/en/content/12-terms-and-conditions-of-use
 * 
 */

// Import functions for scrolling effect to necessary block on click
import {hoverConfig, hoverTabConfig} from './functions.js';

const SetupAdmin = {
  init() {

    // Disconnect from braintree account
    $('#logoutAccount').on('click', (event) => {
      SetupAdmin.logoutAccount();
    });
    
    // Connect to braintree account
    $('#confirmCredentials').click((event) => {
      $(event.currentTarget).closest('form').submit();
    });

    // Check credentials (TLS version, country, enabling SSL)
    $(document).on('click', '#btn-check-requirements', () => {
      SetupAdmin.checkRequirements();
    });

    // Scroll to necessary block
    $('[data-pp-link-settings]').on('click', (e) => {
      e.preventDefault();
      const el = $(e.target.attributes.href.value);

      if (el.length) {
        hoverConfig(el);
      } else {
        hoverTabConfig();
      }
    });

    // Remove effect after leaving cursor from the block
    $('.defaultForm').on('mouseleave', (e) => {
      $(e.currentTarget).removeClass('pp-settings-link-on');
    });
  },

  logoutAccount() {
    $.ajax({
      url: controllerUrl,
      type: 'POST',
      data: {
        ajax: true,
        action: 'logOutAccount',
      },
      success(response) {
        if (response.status) {
          document.location = response.redirectUrl;
        }
      },
    });

  },

  checkRequirements() {
    $.ajax({
      url: controllerUrl,
      type: 'POST',
      data: {
        ajax: true,
        action: 'CheckCredentials',
      },
      success(response) {
        $('#btn-check-requirements').closest('.status-block-container').html(response);
      },
    });
  },

};

$(document).ready(() => SetupAdmin.init());

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

/**
 * Initializes register form on login page.
 */
function initRegisterForm() {
  let registerBtnClicked = function () {
    let form = document.getElementById('pl-register-form');
    form.style.display = 'block';

    let closeBtn = document.getElementById('pl-register-form-close-btn');
    closeBtn.addEventListener('click', function () {
      form.style.display = 'none';
    })
  };

  let btn = document.getElementById('pl-register-btn');
  btn.addEventListener('click', registerBtnClicked, true);
}

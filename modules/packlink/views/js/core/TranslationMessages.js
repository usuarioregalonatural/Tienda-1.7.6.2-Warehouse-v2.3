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

Packlink.errorMsgs = {
    required: 'This field is required.',
    numeric: 'Value must be valid number.',
    invalid: 'This field is not valid.',
    phone: 'This field must be valid phone number.',
    titleLength: 'Title can have at most 64 characters.',
    greaterThanZero: 'Value must be greater than 0.',
    numberOfDecimalPlaces: 'Field must have 2 decimal places.',
    integer: 'Field must be an integer.',
    invalidCountryList: 'You must select destination countries.'
};

Packlink.successMsgs = {
    shippingMethodSaved: 'Shipping service successfully saved.'
};

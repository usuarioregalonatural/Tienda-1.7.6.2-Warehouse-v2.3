<?php
/**
* NOTICE OF LICENSE
*
* This product is licensed for one customer to use on one installation (test stores and multishop included).
* Site developer has the right to modify this module to suit their needs, but can not redistribute the module in
* whole or in part. Any other use of this module constitues a violation of the user agreement.
*
* DISCLAIMER
*
* NO WARRANTIES OF DATA SAFETY OR MODULE SECURITY
* ARE EXPRESSED OR IMPLIED. USE THIS MODULE IN ACCORDANCE
* WITH YOUR MERCHANT AGREEMENT, KNOWING THAT VIOLATIONS OF
* PCI COMPLIANCY OR A DATA BREACH CAN COST THOUSANDS OF DOLLARS
* IN FINES AND DAMAGE A STORES REPUTATION. USE AT YOUR OWN RISK.
*
*  @author    idnovate.com <info@idnovate.com>
*  @copyright 2019 idnovate.com
*  @license   See above
*/

/**
 * Backward function compatibility
 * Need to be called for each module in 1.4
 */

// Get out if the context is already defined
if (!in_array('Context', get_declared_classes())) {
    require_once(dirname(__FILE__).'/Context.php');
}

// Get out if the Display (BWDisplay to avoid any conflict)) is already defined
if (!in_array('BWDisplay', get_declared_classes())) {
    require_once(dirname(__FILE__).'/Display.php');
}

if (!in_array('HelperCore', get_declared_classes())) {
    require_once(dirname(__FILE__).'/HelperCore.php');
}

if (!in_array('Helper', get_declared_classes())) {
    require_once(dirname(__FILE__).'/Helper.php');
}


if (!in_array('Mobile_Detect', get_declared_classes())) {
    require_once(dirname(__FILE__).'/Mobile_Detect.php');
}

// If not under an object we don't have to set the context
if (!isset($this)) {
    return;
} else if (isset($this->context)) {
    // If we are under an 1.5 version and backoffice, we have to set some backward variable
    if (_PS_VERSION_ >= '1.5' && isset($this->context->employee->id) && $this->context->employee->id && isset(AdminController::$currentIndex) && !empty(AdminController::$currentIndex)) {
        global $currentIndex;
        $currentIndex = AdminController::$currentIndex;
    }
    return;
}

$this->context = Context::getContext();
$this->smarty = $this->context->smarty;

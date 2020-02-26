<?php
/**
* 2016 Revolution Slider
*
*  @author    SmatDataSoft <support@smartdatasoft.com>
*  @copyright 2016 SmatDataSoft
*  @license   private
*  @version   5.1.3
*  International Registered Trademark & Property of SmatDataSoft
*/

// @codingStandardsIgnoreStart

$generalSettings = new UniteSettingsRev();

$generalSettings->addSelect("role", array(UniteBaseAdminClassRev::ROLE_ADMIN => RevsliderPrestashop::$lang['To_Admin'],
    UniteBaseAdminClassRev::ROLE_EDITOR => RevsliderPrestashop::$lang['Editor_Admin'],
    UniteBaseAdminClassRev::ROLE_AUTHOR => RevsliderPrestashop::$lang['Author_Editor_Admin']), RevsliderPrestashop::$lang['Plugin_Permission'], UniteBaseAdminClassRev::ROLE_ADMIN, array("description" => RevsliderPrestashop::$lang['edit_plugin']));

$generalSettings->addRadio("includes_globally", array("on" => RevsliderPrestashop::$lang['on'], "off" => RevsliderPrestashop::$lang['off']), RevsliderPrestashop::$lang['RevSlider_libraries'], "on", array("description" => RevsliderPrestashop::$lang['shortcode_exists']));

$generalSettings->addTextBox("pages_for_includes", "", RevsliderPrestashop::$lang['Pages_RevSlider'], array("description" => RevsliderPrestashop::$lang['Specify_homepage']));

$generalSettings->addRadio("js_to_footer", array("on" => RevsliderPrestashop::$lang['on'], "off" => RevsliderPrestashop::$lang['off']), RevsliderPrestashop::$lang['JS_Includes'], "off", array("description" => RevsliderPrestashop::$lang['fixing_javascript']));

$generalSettings->addRadio("show_dev_export", array("on" => RevsliderPrestashop::$lang['on'], "off" => RevsliderPrestashop::$lang['off']), RevsliderPrestashop::$lang['Export_option'], "off", array("description" => RevsliderPrestashop::$lang['export_Slider']));

$generalSettings->addRadio("enable_logs", array("on" => RevsliderPrestashop::$lang['on'], "off" => RevsliderPrestashop::$lang['off']), RevsliderPrestashop::$lang['Enable_Logs'], "off", array("description" => RevsliderPrestashop::$lang['Enable_console']));

$operations = new RevOperations();
$arrValues = $operations->getGeneralSettingsValues();
$generalSettings->setStoredValues($arrValues);

self::storeSettings("general", $generalSettings);

// @codingStandardsIgnoreEnd
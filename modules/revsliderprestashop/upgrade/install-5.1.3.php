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

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_5_1_3()
{
    $revmodule = Module::getInstanceByName('revsliderprestashop');

    require_once ABSPATH . "/revslider_admin.php";
    new RevSliderAdmin(ABSPATH, false);

    $removeTabs = array('Revolutionslider_ajax', 'Revolutionslider_upload');
    foreach ($removeTabs as $tabClass) {
        $id_tab = Tab::getIdFromClassName($tabClass);
        if ($id_tab) {
            $tabobj = new Tab($id_tab);
            $tabobj->delete();
        }
    }

    $revmodule->moduleControllerRegistration();

    $db = Db::getInstance();

    RevSliderAdmin::createTable(GlobalsRevSlider::TABLE_NAVIGATION_NAME);

    RevSliderAdmin::createTable(GlobalsRevSlider::TABLE_REVSLIDER_OPTIONS_NAME);

    // Sliders table
    $sql = 'ALTER TABLE `' . _DB_PREFIX_ . GlobalsRevSlider::TABLE_SLIDERS_NAME . '` MODIFY `params` MEDIUMTEXT NOT NULL';
    $db->execute($sql);

    $sql = 'ALTER TABLE `' . _DB_PREFIX_ . GlobalsRevSlider::TABLE_SLIDERS_NAME . '` ADD COLUMN `settings` MEDIUMTEXT NULL';
    $db->execute($sql);

    $sql = 'ALTER TABLE `' . _DB_PREFIX_ . GlobalsRevSlider::TABLE_SLIDERS_NAME . '` ADD COLUMN `type` VARCHAR(191) NOT NULL';
    $db->execute($sql);

    // Slides table
    $sql = 'ALTER TABLE `' . _DB_PREFIX_ . GlobalsRevSlider::TABLE_SLIDES_NAME . '` MODIFY `params` MEDIUMTEXT NOT NULL';
    $db->execute($sql);

    $sql = 'ALTER TABLE `' . _DB_PREFIX_ . GlobalsRevSlider::TABLE_SLIDES_NAME . '` MODIFY `layers` MEDIUMTEXT NOT NULL';
    $db->execute($sql);

    $sql = 'ALTER TABLE `' . _DB_PREFIX_ . GlobalsRevSlider::TABLE_SLIDES_NAME . '` ADD COLUMN `settings` MEDIUMTEXT NULL';
    $db->execute($sql);

    // static slides table

    $sql = 'ALTER TABLE `' . _DB_PREFIX_ . GlobalsRevSlider::TABLE_STATIC_SLIDES_NAME . '` MODIFY `params` MEDIUMTEXT NOT NULL';
    $db->execute($sql);

    $sql = 'ALTER TABLE `' . _DB_PREFIX_ . GlobalsRevSlider::TABLE_STATIC_SLIDES_NAME . '` MODIFY `layers` MEDIUMTEXT NOT NULL';
    $db->execute($sql);

    // settings table

    $sql = 'ALTER TABLE `' . _DB_PREFIX_ . GlobalsRevSlider::TABLE_SETTINGS_NAME . '` MODIFY `params` MEDIUMTEXT NOT NULL';
    $db->execute($sql);

    $sql = 'ALTER TABLE `' . _DB_PREFIX_ . GlobalsRevSlider::TABLE_SETTINGS_NAME . '` MODIFY `general` MEDIUMTEXT NOT NULL';
    $db->execute($sql);

    // css table

    $sql = 'ALTER TABLE `' . _DB_PREFIX_ . GlobalsRevSlider::TABLE_CSS_NAME . '` MODIFY `settings` MEDIUMTEXT NULL';
    $db->execute($sql);

    $sql = 'ALTER TABLE `' . _DB_PREFIX_ . GlobalsRevSlider::TABLE_CSS_NAME . '` MODIFY `hover` MEDIUMTEXT NULL';
    $db->execute($sql);

    $sql = 'ALTER TABLE `' . _DB_PREFIX_ . GlobalsRevSlider::TABLE_CSS_NAME . '` MODIFY `params` MEDIUMTEXT NOT NULL';
    $db->execute($sql);

    $sql = 'ALTER TABLE `' . _DB_PREFIX_ . GlobalsRevSlider::TABLE_CSS_NAME . '` ADD COLUMN `advanced` MEDIUMTEXT NULL';
    $db->execute($sql);


    RevSliderPluginUpdate::doUpdateChecks();

    return true;
}

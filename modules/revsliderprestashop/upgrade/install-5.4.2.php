<?php
/**
* 2016 Revolution Slider
*
*  @author    SmatDataSoft <support@smartdatasoft.com>
*  @copyright 2016 SmatDataSoft
*  @license   private
*  @version   5.4.2
*  International Registered Trademark & Property of SmatDataSoft
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_5_4_2($object)
{
     
    $revmodule = Module::getInstanceByName('revsliderprestashop'); 

    $removeTabs = array('AdminRevolutionslider','AdminRevolutionsliderNavigation','AdminRevolutionsliderSettings','AdminRevolutionsliderUpload','AdminRevolutionslider');
    foreach ($removeTabs as $tabClass) {
        $id_tab = Tab::getIdFromClassName($tabClass);
        if ($id_tab) {
            $tabobj = new Tab($id_tab);
            $tabobj->delete();
        }
    }
    
    $langs = Language::getLanguages();
            $newtab = new Tab();
            $newtab->class_name = "AdminRevslider";
            $newtab->id_parent = 0;
            $newtab->module = "revsliderprestashop";
            foreach ($langs as $l) {
                $newtab->name[$l['id_lang']] = $object->l("Revolution Slider");
            }

            $newtab->save();
    
    
    
    $rs_tab_id = Tab::getIdFromClassName("AdminRevslider");
$tabvalue = array(
    array(
        'class_name' => 'AdminRevsliderSliders',
        'id_parent' => $rs_tab_id,
        'module' => 'revsliderprestashop',
        'name' => 'Sliders',
        'active' => 1,
    ),
    array(
        'class_name' => 'AdminRevolutionsliderGlobalSettings',
        'id_parent' => $rs_tab_id,
        'module' => 'revsliderprestashop',
        'name' => 'Global Settings',
        'active' => 1,
    ),
    array(
        'class_name' => 'AdminRevolutionsliderAddons',
        'id_parent' => $rs_tab_id,
        'module' => 'revsliderprestashop',
        'name' => 'Addons',
        'active' => 1,
    ),
    array(
        'class_name' => 'AdminRevolutionsliderNavigation',
        'id_parent' => $rs_tab_id,
        'module' => 'revsliderprestashop',
        'name' => 'Navigation',
        'active' => 1,
    ),
    array(
        'class_name' => 'AdminRevolutionsliderAjax',
        'id_parent' => -1,
        'module' => 'revsliderprestashop',
        'name' => 'Revolution Ajax Controller',
        'active' => 0,
    ),
    array(
        'class_name' => 'AdminRevolutionsliderFmanager',
        'id_parent' => -1,
        'module' => 'revsliderprestashop',
        'name' => 'Revolution File Manager',
        'active' => 1,
    ),
);

 foreach ($tabvalue as $tab) {
            $newtab = new Tab();
            $newtab->class_name = $tab['class_name'];
            $newtab->id_parent = $tab['id_parent'];
            $newtab->module = $tab['module'];
            foreach ($langs as $l) {
                $newtab->name[$l['id_lang']] = $object->l($tab['name']);
            }

            $newtab->save();
        }


    $revmodule->moduleControllerRegistration();

    $db = Db::getInstance();
 
    $sql = 'ALTER TABLE `' . _DB_PREFIX_ . GlobalsRevSlider::TABLE_ATTACHMENT_IMAGES . '` ADD COLUMN `subdir` VARCHAR(200) NOT NULL';
    $db->execute($sql);

    $sql = 'ALTER TABLE `' . _DB_PREFIX_ . GlobalsRevSlider::TABLE_CSS_NAME . '` MODIFY `settings` LONGTEXT NULL';
    $db->execute($sql);
    
    $sql = 'ALTER TABLE `' . _DB_PREFIX_ . GlobalsRevSlider::TABLE_CSS_NAME . '` MODIFY `hover` LONGTEXT NULL';
    $db->execute($sql);
    
    $sql = 'ALTER TABLE `' . _DB_PREFIX_ . GlobalsRevSlider::TABLE_CSS_NAME . '` MODIFY `params` LONGTEXT NOT NULL';
    $db->execute($sql);
    
    $sql = 'ALTER TABLE `' . _DB_PREFIX_ . GlobalsRevSlider::TABLE_CSS_NAME . '` MODIFY `advanced` LONGTEXT NULL';
    $db->execute($sql);
    
    $sql = 'ALTER TABLE `' . _DB_PREFIX_ . GlobalsRevSlider::TABLE_LAYER_ANIMS_NAME . '` MODIFY `params` LONGTEXT NULL';
    $db->execute($sql);
    
    
    $sql = 'ALTER TABLE `' . _DB_PREFIX_ . GlobalsRevSlider::TABLE_NAVIGATION_NAME . '` MODIFY `css` LONGTEXT NULL';
    $db->execute($sql);
    $sql = 'ALTER TABLE `' . _DB_PREFIX_ . GlobalsRevSlider::TABLE_NAVIGATION_NAME . '` MODIFY `markup` LONGTEXT NULL';
    $db->execute($sql);
    $sql = 'ALTER TABLE `' . _DB_PREFIX_ . GlobalsRevSlider::TABLE_NAVIGATION_NAME . '` MODIFY `settings` LONGTEXT NULL';
    $db->execute($sql);
    
    $sql = 'ALTER TABLE `' . _DB_PREFIX_ . GlobalsRevSlider::TABLE_REVSLIDER_OPTIONS_NAME . '` CHANGE id option_id  INT(11) NOT NULL AUTO_INCREMENT';
    $db->execute($sql);
    $sql = 'ALTER TABLE `' . _DB_PREFIX_ . GlobalsRevSlider::TABLE_REVSLIDER_OPTIONS_NAME . '` CHANGE name option_name VARCHAR(200)';
    $db->execute($sql);
    $sql = 'ALTER TABLE `' . _DB_PREFIX_ . GlobalsRevSlider::TABLE_REVSLIDER_OPTIONS_NAME . '` CHANGE value option_value mediumtext';
    $db->execute($sql);
     
    $sql = 'ALTER TABLE `' . _DB_PREFIX_ . GlobalsRevSlider::TABLE_SLIDERS_NAME . '` MODIFY `params` LONGTEXT NULL';
    $db->execute($sql);
    $sql = 'ALTER TABLE `' . _DB_PREFIX_ . GlobalsRevSlider::TABLE_SLIDERS_NAME . '` MODIFY `settings` TEXT NULL';
    $db->execute($sql);
    
    $sql = 'ALTER TABLE `' . _DB_PREFIX_ . GlobalsRevSlider::TABLE_SLIDES_NAME . '` MODIFY `params` LONGTEXT NULL';
    $db->execute($sql);
    $sql = 'ALTER TABLE `' . _DB_PREFIX_ . GlobalsRevSlider::TABLE_SLIDES_NAME . '` MODIFY `layers` LONGTEXT NULL';
    $db->execute($sql);
    $sql = 'ALTER TABLE `' . _DB_PREFIX_ . GlobalsRevSlider::TABLE_SLIDES_NAME . '` MODIFY `settings` TEXT NULL';
    $db->execute($sql);
    
    $sql = 'ALTER TABLE `' . _DB_PREFIX_ . GlobalsRevSlider::TABLE_STATIC_SLIDES_NAME . '` ADD COLUMN `settings` TEXT NOT NULL';
    $db->execute($sql);
     $sql = 'ALTER TABLE `' . _DB_PREFIX_ . GlobalsRevSlider::TABLE_SLIDES_NAME . '` MODIFY `params` LONGTEXT NULL';
    $db->execute($sql);
    $sql = 'ALTER TABLE `' . _DB_PREFIX_ . GlobalsRevSlider::TABLE_SLIDES_NAME . '` MODIFY `layers` LONGTEXT NULL';
    $db->execute($sql);
    
    return true;
}

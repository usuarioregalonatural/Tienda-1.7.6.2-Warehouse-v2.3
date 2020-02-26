<?php
/**
 * 2017 IQIT-COMMERCE.COM
 *
 * NOTICE OF LICENSE
 *
 * This file is licenced under the Software License Agreement.
 * With the purchase or the installation of the software in your application
 * you accept the licence agreement
 *
 *  @author    IQIT-COMMERCE.COM <support@iqit-commerce.com>
 *  @copyright 2017 IQIT-COMMERCE.COM
 *  @license   Commercial license (You can not resell or redistribute this software.)
 *
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class IqitDashboardNews extends Module
{

    public function __construct()
    {
        $this->name = 'iqitdashboardnews';
        $this->tab = 'dashboard';
        $this->version = '1.0';
        $this->author = 'IQIT-COMMERCE.COM';

        parent::__construct();
        $this->displayName = $this->l('IQITDASHBOARDNEWS');
        $this->description = $this->l('Display theme update notification in dashboard');
        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
    }

    public function install()
    {
        return (parent::install()
            && $this->registerHook('dashboardZoneOne')
            && $this->updatePosition(Hook::getIdByName('dashboardZoneOne'), 0, 1)
        );
    }

    public function hookDashboardZoneOne($params)
    {
        $module = Module::getInstanceByName('iqitthemeeditor');
        if ($module instanceof Module) {

            $this->context->smarty->assign(
                array(
                    'current_version' => $module->version,
                )
            );
        }
        
        return $this->display(__FILE__, 'dashboard_zone_one.tpl');
    }

}

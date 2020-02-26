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

class IqitEmailSubscriptionConf extends Module 
{
    public function __construct()
    {
        $this->name = 'iqitemailsubscriptionconf';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'IQIT-COMMERCE.COM';
        $this->bootstrap = true;
        $this->controllers = array('subscription');
        $this->dependencies = array('ps_emailsubscription');

        parent::__construct();

        $this->displayName = $this->l('IQITEMAILSUBSCRIPTIONCONF');
        $this->description = $this->l('Adds confirmation page for Prestashop core module: ps_emailsubscription. Needed for popup subscription or iqitelementor');
    }

    public function install()
    {
        return (parent::install());
    }

    public function uninstall()
    {
        return (parent::uninstall());
    }

}

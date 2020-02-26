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

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

require_once dirname(__FILE__).'/src/IqitLinkBlockRepository.php';
require_once dirname(__FILE__).'/src/IqitLinkBlock.php';
require_once dirname(__FILE__).'/src/IqitLinkBlockPresenter.php';

class IqitLinksManager extends Module implements WidgetInterface
{
    private $iqitLinkBlockPresenter;
    private $iqitLinkBlockRepository;
    protected $templateFile;

    public function __construct()
    {
        $this->name = 'iqitlinksmanager';
        $this->tab = 'front_office_features';
        $this->version = '1.4.0';
        $this->author = 'IQIT-COMMERCE.COM';
        $this->bootstrap = true;
        $this->cfgName = 'iqitlinkmng_';
        $this->need_instance = 0;
        $this->secure_key = Tools::encrypt($this->name);

        parent::__construct();

        $this->displayName = $this->l('IQITLINKSMANAGER - block links');
        $this->description = $this->l('Adds block with links in variouse hooks in your page');

        $this->iqitLinkBlockRepository = new IqitLinkBlockRepository(
            Db::getInstance(),
            $this->context->shop
        );
        $this->iqitLinkBlockPresenter = new IqitLinkBlockPresenter(
            new Link(),
            $this->context->language
        );

        $this->templateFile = 'module:'.$this->name.'/views/templates/hook/'.$this->name.'.tpl';
    }

    public function install()
    {
        if (parent::install()
            && $this->iqitLinkBlockRepository->createTables() && $this->iqitLinkBlockRepository->installFixtures() && $this->registerHook('displayHeader') && $this->registerHook('displayFooter') && $this->registerHook('displayNav1')) {
            return true;
        }
        return false;
    }

    public function uninstall()
    {
        return parent::uninstall() && $this->iqitLinkBlockRepository->dropTables();
    }

    public function installTab()
    {

        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = "AdminIqitLinkWidget";
        $tab->name = array();
        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = "Iqit Links Manager";
        }
        $tab->id_parent = (int)Tab::getIdFromClassName('AdminParentThemes');
        $tab->module = $this->name;
        return $tab->add();
    }

    public function uninstallTab()
    {
        $id_tab = (int)Tab::getIdFromClassName('AdminIqitLinkWidget');
        $tab = new Tab($id_tab);
        return $tab->delete();
    }

    public function getContent()
    {
        Tools::redirectAdmin(
            $this->context->link->getAdminLink('AdminIqitLinkWidget')
        );
    }

    public function renderWidget($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }

        if (!$this->isCached($this->templateFile, $this->getCacheId($hookName))) {
            $this->smarty->assign([
                'linkBlocks' => $this->getWidgetVariables($hookName, $configuration),
            ]);
        }

        return $this->fetch($this->templateFile, $this->getCacheId($hookName));
    }

    public function getWidgetVariables($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }

        $id_hook = Hook::getIdByName($hookName);
        $linkBlocks = $this->iqitLinkBlockRepository->getByIdHook($id_hook);

        $blocks = array();
        foreach ($linkBlocks as $block) {
            $blocks[] = $this->iqitLinkBlockPresenter->present($block);
        }

        return $blocks;
    }

    public function clearCache($template = null, $cache_id = null, $compile_id = null)
    {
        parent::_clearCache($this->templateFile);
    }

    public function getCacheId($hookName = null)
    {
        return parent::getCacheId() . '|' . $hookName;
    }

    private function addNameArrayToPost()
    {
        $languages = Language::getLanguages();
        $names = array();
        foreach ($languages as $lang) {
            if ($name = Tools::getValue('name_'.(int)$lang['id_lang'])) {
                $names[(int)$lang['id_lang']] = $name;
            }
        }
        $_POST['name_iqit_link_block'] = $names;
    }
}

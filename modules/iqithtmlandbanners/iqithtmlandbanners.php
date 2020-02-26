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

require_once dirname(__FILE__).'/src/IqitHtmlAndBannerRepository.php';
require_once dirname(__FILE__).'/src/IqitHtmlAndBannerPresenter.php';
require_once dirname(__FILE__).'/src/IqitHtmlAndBanner.php';

class IqitHtmlAndBanners extends Module implements WidgetInterface
{
    private $iqitHtmlAndBannerPresenter;
    private $iqitHtmlAndBannerRepository;
    public $imgBannersPath;
    protected $templateFile;

    public function __construct()
    {
        $this->name = 'iqithtmlandbanners';
        $this->tab = 'front_office_features';
        $this->version = '1.1.0';
        $this->author = 'IQIT-COMMERCE.COM';
        $this->bootstrap = true;
        $this->cfgName = 'iqithab';
        $this->need_instance = 0;


        parent::__construct();

        $this->displayName = $this->l('IQITHTMLANDBANNERS');
        $this->description = $this->l('Adds block with HTML or BANNERS in variouse hooks in your page');

        $this->iqitHtmlAndBannerRepository = new IqitHtmlAndBannerRepository(
            Db::getInstance(),
            $this->context->shop
        );
        $this->iqitHtmlAndBannerPresenter = new IqitHtmlAndBannerPresenter(
            $this->context->language
        );

        $this->imgBannersPath = $this->_path.'uploads/images/';

        $this->templateFile = 'module:'.$this->name.'/views/templates/hook/'.$this->name.'.tpl';
    }

    public function install()
    {
        if (parent::install() && $this->iqitHtmlAndBannerRepository->createTables() && $this->iqitHtmlAndBannerRepository->installFixtures()) {
            return true;
        }
        return false;
    }

    public function uninstall()
    {
        return parent::uninstall() && $this->iqitHtmlAndBannerRepository->dropTables();
    }

    public function installTab()
    {
        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = "AdminIqitHtmlBannerWidget";
        $tab->name = array();
        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = "Iqit Html and Banner Widget";
        }
        $tab->id_parent = (int)Tab::getIdFromClassName('AdminParentThemes');
        $tab->module = $this->name;
        return $tab->add();
    }

    public function uninstallTab()
    {
        $id_tab = (int)Tab::getIdFromClassName('AdminIqitHtmlBannerWidget');
        $tab = new Tab($id_tab);
        return $tab->delete();
    }

    public function getContent()
    {
        Tools::redirectAdmin(
            $this->context->link->getAdminLink('AdminIqitHtmlBannerWidget')
        );
    }

    public function renderWidget($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }

        if (!$this->isCached($this->templateFile, $this->getCacheId($hookName))) {
            $this->smarty->assign([
                'blocks' => $this->getWidgetVariables($hookName, $configuration),
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
        $blocks = $this->iqitHtmlAndBannerRepository->getByIdHook($id_hook);
        $blocksArr = array();
        foreach ($blocks as $block) {
            $blocksArr[] = $this->iqitHtmlAndBannerPresenter->present($block);
        }

        return $blocksArr;
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

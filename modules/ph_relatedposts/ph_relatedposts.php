<?php

/*
* @author    Krystian Podemski <podemski.krystian@gmail.com>
* @site
* @copyright  Copyright (c) 2014 impSolutions (http://www.impsolutions.pl) && PrestaHome.com
* @license    You only can use module, nothing more!
*
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;
use PrestaShop\PrestaShop\Core\Product\ProductExtraContent;

if(file_exists(_PS_MODULE_DIR_ . 'ph_simpleblog/models/SimpleBlogPost.php'))
    require_once _PS_MODULE_DIR_ . 'ph_simpleblog/models/SimpleBlogPost.php';

if(file_exists(_PS_MODULE_DIR_ . 'ph_relatedposts/models/SimpleBlogRelatedPost.php'))
    require_once _PS_MODULE_DIR_ . 'ph_relatedposts/models/SimpleBlogRelatedPost.php';

class ph_relatedposts extends Module implements WidgetInterface
{
    public function __construct()
    {
        $this->name = 'ph_relatedposts';
        $this->tab = 'front_office_features';
        $this->version = '1.2';
        $this->author = 'www.PrestaHome.com';
        $this->need_instance = 0;
        $this->is_configurable = 1;
        $this->ps_versions_compliancy['min'] = '1.7.1.0';
        $this->ps_versions_compliancy['max'] = _PS_VERSION_;
        $this->secure_key = Tools::encrypt($this->name);

        $moduleManagerBuilder = \PrestaShop\PrestaShop\Core\Addon\Module\ModuleManagerBuilder::getInstance();
        $moduleManager = $moduleManagerBuilder->build();

        if(!$moduleManager->isInstalled('ph_simpleblog') || !Module::isEnabled('ph_simpleblog'))
            $this->warning = $this->l('You have to install and activate ph_simpleblog before use ph_relatedposts');

        parent::__construct();

        $this->displayName = $this->l('Blog for PrestaShop - Related Posts');
        $this->description = $this->l('Widget to display posts related to your products from PrestaHome Blog for PrestaShop module');

        $this->confirmUninstall = $this->l('Are you sure you want to delete this module ?');
    }

    public function install()
    {
        return (parent::install() 
                && $this->prepareModuleSettings() 
                && $this->registerHook('actionObjectProductDeleteAfter')
                && $this->registerHook('actionObjectSimpleBlogPostDeleteAfter')
                && $this->registerHook('displayProductExtraContent')
                && $this->registerHook('displayAdminProductsExtra')
                && $this->registerHook('actionObjectProductUpdateAfter'));
    }

    public function prepareModuleSettings()
    {
        $sql = array();
        include (dirname(__file__) . '/init/install_sql.php');
        foreach ($sql as $s) {
            if (!Db::getInstance()->execute($s)) {
                return false;
            }
        }
        return true;
    }

    public function uninstall() {
        if (!parent::uninstall()) {
            return false;
        }
        $sql = array();
        include (dirname(__file__) . '/init/uninstall_sql.php');
        foreach ($sql as $s) {
            if (!Db::getInstance()->execute($s)) {
                return false;
            }
        }

        return true;
    }

    public function hookActionObjectProductDeleteAfter($params) {
        return SimpleBlogRelatedPost::cleanRelatedForProduct($params['object']->id);
    }

    public function hookActionObjectSimpleBlogPostDeleteAfter($params) {
        return SimpleBlogRelatedPost::cleanRelatedForPost($params['object']->id);
    }

    public function hookActionObjectProductUpdateAfter($params) {
        if (!isset($params['object']->id)) {
            return;
        }
        $idProduct = (int) $params['object']->id;

        SimpleBlogRelatedPost::cleanRelatedForProduct($idProduct);

        $relatedPosts = Tools::getValue('ph_relatedposts')['related_posts'];
        if($relatedPosts)
        {
            foreach($relatedPosts as $post)
            {
                $instance = new SimpleBlogRelatedPost();
                $instance->id_simpleblog_post = $post;
                $instance->id_product = $idProduct;
                $instance->add();
            }    
        }
    }

    public function hookDisplayAdminProductsExtra($params){

        $moduleManagerBuilder = \PrestaShop\PrestaShop\Core\Addon\Module\ModuleManagerBuilder::getInstance();
        $moduleManager = $moduleManagerBuilder->build();

        if(!$moduleManager->isInstalled('ph_simpleblog') || !Module::isEnabled('ph_simpleblog'))
            return;

        $idProduct = (int) Tools::getValue('id_product', $params['id_product']);

        $posts = SimpleBlogPost::getSimplePosts($this->context->language->id);

        $selected_posts = array();
        $related_posts = array();

        foreach(SimpleBlogRelatedPost::getByProductId($idProduct) as $key => $post)
        {
            $related_posts[] = $post['id_simpleblog_post'];
        }

        if(sizeof($related_posts) > 0)
        {
            $posts = SimpleBlogPost::getSimplePosts($this->context->language->id, null, null, 'NOT IN', $related_posts);
            $selected_posts = SimpleBlogPost::getSimplePosts($this->context->language->id, null, null, 'IN', $related_posts);
        }

        $this->context->smarty->assign(array(
            'idProduct ' => $idProduct ,
            'posts' => $posts,
            'selected_posts' => $selected_posts,
            'module_path' => $this->_path,
            'secure_key' => $this->secure_key,
            'path' => $this->_path,
        ));

        return $this->display(__FILE__, 'views/templates/admin/admin-tab.tpl');
    }

    public function renderWidget($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }

        if (preg_match('/^displayProductExtraContent\d*$/', $hookName)) {

            $templateFile = 'related-posts.tpl';
            $assign = $this->getWidgetVariables($hookName, $configuration);

            $this->smarty->assign($assign);
            $array = array();
            if($assign)
            {
                $array[] = (new ProductExtraContent())
                    ->setTitle($this->l('Related posts'))
                    ->setContent($this->fetch('module:' . $this->name . '/views/templates/hook/' . $templateFile));
                return $array;
            }
            return  $array;
        } else{

            $templateFile = 'related-posts-section.tpl';
            $assign = $this->getWidgetVariables($hookName, $configuration);

            $this->smarty->assign($assign);
            return $this->fetch('module:' . $this->name . '/views/templates/hook/' .$templateFile);

        }
    }

    public function getWidgetVariables($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }

        if (preg_match('/^displayProductExtraContent\d*$/', $hookName) || preg_match('/^displayFooterProduct\d*$/', $hookName)) {


            if (isset($configuration['product']->id)){
                $idProduct = (int) $configuration['product']->id;
            } else{
                $idProduct = (int) $configuration['product']['id'];
            }

            $cacheId = 'PhRelatedPosts' . $idProduct;

            if (!Cache::isStored($cacheId)) {
                $relatedPostsById = SimpleBlogRelatedPost::getByProductId((int)$idProduct);
                $relatedPosts = [];

                if(sizeof($relatedPostsById) < 1){
                    return false;
                }

                foreach($relatedPostsById as $key => $post) {
                    $relatedPosts[] = $post['id_simpleblog_post'];
                }

                $posts = SimpleBlogPost::getPosts($this->context->language->id, 999, null, null, true, false, false, null, false, false, null, 'IN', $relatedPosts);

               Cache::store($cacheId, array('posts' => $posts));
            }
            return Cache::retrieve($cacheId);
        }
        return false;
    }
}
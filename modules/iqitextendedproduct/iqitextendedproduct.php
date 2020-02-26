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

require_once dirname(__FILE__).'/src/IqitThreeSixty.php';
require_once dirname(__FILE__).'/src/IqitProductVideo.php';

class IqitExtendedProduct extends Module implements WidgetInterface
{
    const INSTALL_SQL_FILE = '/sql/install.sql';
    const UNINSTALL_SQL_FILE = '/sql/uninstall.sql';
    const ACCESS_RIGHTS = 0775;

    protected $SOURCE_INDEX;
    protected $UPLOAD_DIR;
    protected $templateFile;

    public function __construct()
    {
        $this->name = 'iqitextendedproduct';
        $this->author = 'IQIT-COMMERCE.COM';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->cfgName = 'iqitextendedp_';
        $this->defaults = array(
            'bg' => '#151515',
            'color' => '#ffffff',
        );

        $this->SOURCE_INDEX = _PS_PROD_IMG_DIR_ . 'index.php';
        $this->UPLOAD_DIR = _PS_MODULE_DIR_ . 'iqitextendedproduct/uploads/';

        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->l('IQITEXTENDEDPRODUCT - 360 degree image rotation and videos');
        $this->description = $this->l('Extend your product presentation with additional features');
        $this->templateFile = 'module:'.$this->name.'/views/templates/hook/below-thumbs.tpl';
    }

    public function install()
    {
        if (!parent::install()
            || !$this->registerHook('backOfficeHeader')
            || !$this->registerHook('header')
            || !$this->registerHook('displayAfterProductThumbs')
            || !$this->registerHook('displayAdminProductsExtra')
            || !$this->registerHook('actionObjectProductUpdateAfter')
            || !$this->registerHook('actionObjectProductDeleteAfter')
            || !$this->registerHook('actionObjectProductAddAfter')
            || !$this->installSQL()) {
            return false;
        }

        foreach ($this->defaults as $default => $value) {
            if ($default == 'content') {
                $message_trads = array();
                foreach (Language::getLanguages(false) as $lang) {
                    $message_trads[(int) $lang['id_lang']] = $value;
                }
                Configuration::updateValue($this->cfgName . $default, $message_trads, true);
            } else {
                Configuration::updateValue($this->cfgName . $default, $value);
            }
        }
        return true;
    }

    public function hookHeader()
    {
        $this->context->controller->registerStylesheet('modules-'.$this->name.'-style', 'modules/'.$this->name.'/views/css/front.css', ['media' => 'all', 'priority' => 150]);
        $this->context->controller->registerJavascript('modules'.$this->name.'-script', 'modules/'.$this->name.'/views/js/front.js', ['position' => 'bottom', 'priority' => 150]);
    }

    public function uninstall()
    {
        foreach ($this->defaults as $default => $value) {
            Configuration::deleteByName($this->cfgName . $default);
        }

        return $this->uninstallSQL() && parent::uninstall();
    }


    public function hookDisplayAdminProductsExtra($params)
    {
        $idProduct = (int) Tools::getValue('id_product', $params['id_product']);

        $idThreeSixty = IqitThreeSixty::getIdByProduct($idProduct);
        $threeSixty = new IqitThreeSixty($idThreeSixty);

        $threeSixtyContent = array();
        if (Validate::isLoadedObject($threeSixty)) {
            foreach ($threeSixty->content as $key => $image) {
                $threeSixtyContent[$key]['path'] = $this->_path.'uploads/threesixty/'.$this->getFolder($idProduct).'/'.$image['n'];
                $threeSixtyContent[$key]['name'] = $image['n'];
            }

        }

        $idProductVideo = IqitProductVideo::getIdByProduct($idProduct);
        $productVideo = new IqitProductVideo($idProductVideo);
        $productVideoContent = array();

        if (Validate::isLoadedObject($productVideo)) {
            $productVideoContent = $productVideo->content;
        }

        $this->context->smarty->assign(array(
            'product' =>$idProduct,
            'path' => $this->_path,
            'threeSixtyContent' => $threeSixtyContent,
            'productVideoContent' => $productVideoContent,
            'threeSixtyActionUrl' => $this->context->link->getAdminLink('AdminModules', true) . '&configure=' . $this->name . '&action=UploaderThreeSixty&ajax=1&id_product=' . $idProduct,
        ));

        return $this->display(__FILE__, 'views/templates/admin/bo_productab.tpl');
    }

    public function hookBackOfficeHeader()
    {
        if ($this->context->controller->controller_name == 'AdminProducts') {
            $this->context->controller->addCSS($this->_path . 'views/css/admin_tab.css');
        }
    }

    public function ajaxProcessUploaderThreeSixty()
    {
        $idProduct = (int) Tools::getValue('id_product');
        $folder = 'threesixty/';

        $product = new Product((int) $idProduct);
        if (!Validate::isLoadedObject($product)) {
            $files = array();
            $files[0]['error'] = Tools::displayError('Cannot add image because product creation failed.');
        }
        header('Content-Type: application/json');
        $step = (int) Tools::getValue('step');

        if ($step == 1) {
            $image_uploader = new HelperImageUploader('threesixty-file-upload');
            $image_uploader->setAcceptTypes(array('jpeg', 'gif', 'png', 'jpg'));
            $files = $image_uploader->process();
            $new_destination = $this->getPathForCreation($idProduct, $folder);

            foreach ($files as &$file) {
                $filename = uniqid() . '.jpg';
                $error = 0;
                if (!ImageManager::resize($file['save_path'], $new_destination . $filename, null, null, 'jpg', false, $error)) {
                    switch ($error) {
                        case ImageManager::ERROR_FILE_NOT_EXIST:
                        $file['error'] = Tools::displayError('An error occurred while copying image, the file does not exist anymore.');
                        break;
                        case ImageManager::ERROR_FILE_WIDTH:
                        $file['error'] = Tools::displayError('An error occurred while copying image, the file width is 0px.');
                        break;
                        case ImageManager::ERROR_MEMORY_LIMIT:
                        $file['error'] = Tools::displayError('An error occurred while copying image, check your memory limit.');
                        break;
                        default:
                        $file['error'] = Tools::displayError('An error occurred while copying image.');
                        break;
                    }
                    continue;
                }
                unlink($file['save_path']);
                unset($file['save_path']);
                $file['status'] = 'ok';
                $file['name'] = $filename;
            }
            die(json_encode($files[0]));
        } elseif ($step == 2) {
            $file = (string) Tools::getValue('file');
            if (file_exists($this->UPLOAD_DIR . $folder . $idProduct . '/' . $file)) {
                $res = @unlink($this->UPLOAD_DIR . $folder . $idProduct . '/' . $file);
            }
            if ($res) {
                die('ok');
            } else {
                die('error');
            }
        }
    }

    private function getPathForCreation($id_product, $folder)
    {
        $path = $this->getFolder($id_product);
        $this->createFolder($id_product, $this->UPLOAD_DIR . $folder);
        return $this->UPLOAD_DIR . $folder . $path;
    }

    private function createFolder($id_product, $folder)
    {
        if (!file_exists($folder . $this->getFolder($id_product))) {
            $success = @mkdir($folder . $this->getFolder($id_product), self::ACCESS_RIGHTS, true);
            $chmod = @chmod($folder . $this->getFolder($id_product), self::ACCESS_RIGHTS);
            if (($success || $chmod)
                && !file_exists($folder . $this->getFolder($id_product) . 'index.php')
                && file_exists($this->SOURCE_INDEX)) {
                return @copy($this->SOURCE_INDEX, $folder . $this->getFolder($id_product) . 'index.php');
            }
        }
        return true;
    }

    private function getFolder($id_product)
    {
        if (!is_numeric($id_product)) {
            return false;
        }
        $folders = str_split((string) $id_product);
        return implode('/', $folders) . '/';
    }

    private function deleteFolder($id_product, $folder)
    {
        $path = $this->getPathForCreation($id_product, $folder);
        if (is_dir($path)) {
            $deleteFolder = true;
        }
        if (isset($deleteFolder) && $deleteFolder) {
            array_map('unlink', glob($path.'*.*'));
            @rmdir($path);
        }
    }

    public function renderWidget($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];
        }
        $idProduct = (int) $configuration['smarty']->tpl_vars['product']->value['id_product'];

        $cacheId = 'iqitextendedproduct|'.$idProduct;

        if (!$this->isCached($this->templateFile, $this->getCacheId($cacheId))) {
            $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));
        }
        return $this->fetch($this->templateFile, $this->getCacheId($cacheId));
    }

    public function getWidgetVariables($hookName = null, array $configuration = [])
    {
        $idProduct = (int) $configuration['smarty']->tpl_vars['product']->value['id_product'];

        $idThreeSixty = IqitThreeSixty::getIdByProduct($idProduct);
        $threeSixty = new IqitThreeSixty($idThreeSixty);
        $threeSixtyContent = array();
        $isThreeSixtyContent = false;
        if (Validate::isLoadedObject($threeSixty)) {
            foreach ($threeSixty->content as $key => $image) {
                $threeSixtyContent[$key] = $this->_path.'uploads/threesixty/'.$this->getFolder($idProduct).'/'.$image['n'];
            }
            $isThreeSixtyContent = true;
        }


        $idProductVideo = IqitProductVideo::getIdByProduct($idProduct);
        $productVideo = new IqitProductVideo($idProductVideo);
        $productVideoContent = array();

        if (Validate::isLoadedObject($productVideo)) {
            $productVideoContent = $productVideo->content;
        }

        return array(
            'threeSixtyContent' => htmlspecialchars(json_encode($threeSixtyContent), ENT_COMPAT, 'UTF-8'),
            'isThreeSixtyContent' => $isThreeSixtyContent,
            'productVideoContent' => $productVideoContent,
            'path' => $this->_path,
            'idProduct' => $idProduct
        );
    }

    public function hookActionObjectProductUpdateAfter($params)
    {
        if (!isset($params['object']->id)) {
            return;
        }
        $this->joinWithProduct($params['object']->id);

        $this->clearCache($params['object']->id);
    }

    public function joinWithProduct($idProduct)
    {

        if (!isset(Tools::getValue('iqitextendedproduct')['threesixty'])){
            return;
        }

        if (!isset(Tools::getValue('iqitextendedproduct')['videos'])){
            return;
        }




        $idProduct = (int) $idProduct;

        $images = Tools::getValue('iqitextendedproduct')['threesixty'];
        $imagesArray = json_decode($images);
        $idThreeSixty = IqitThreeSixty::getIdByProduct($idProduct);
        $threeSixty = new IqitThreeSixty($idThreeSixty);

        $videos = Tools::getValue('iqitextendedproduct')['videos'];
        $idProductVideo = IqitProductVideo::getIdByProduct($idProduct);
        $productVideo = new IqitProductVideo($idProductVideo);
        $videosArray = json_decode($videos);



        if (!is_array($imagesArray) || empty($imagesArray)) {
            if (Validate::isLoadedObject($threeSixty)) {
                $threeSixty->delete();
            }
        } else {
            if (Validate::isLoadedObject($threeSixty)) {
                $threeSixty->content = $images;
                $threeSixty->update();
            } else {
                $threeSixty = new IqitThreeSixty();
                $threeSixty->id_product = $idProduct;
                $threeSixty->content = $images;
                $threeSixty->add();
            }
        }

        if (!is_array($videosArray) || empty($videosArray)) {
            if (Validate::isLoadedObject($productVideo)) {
                $productVideo->delete();
            }
        } else {
            if (Validate::isLoadedObject($productVideo)) {
                $productVideo->content = $videos;
                $productVideo->update();
            } else {
                $productVideo = new IqitProductVideo();
                $productVideo->id_product = $idProduct;
                $productVideo->content = $videos;
                $productVideo->add();
            }
        }
    }

    public function hookcActionObjectProductDeleteAfter($params)
    {
        if (!isset($params['object']->id)) {
            return;
        }
        $idProduct = (int) $params['object']->id;

        $idThreeSixty = IqitThreeSixty::getIdByProduct($idProduct);
        $threeSixty = new IqitThreeSixty($idThreeSixty);
        $idProductVideo = IqitProductVideo::getIdByProduct($idProduct);
        $productVideo = new IqitProductVideo($idProductVideo);

        if (Validate::isLoadedObject($threeSixty)) {
            $threeSixty->delete();
        }
        if (Validate::isLoadedObject($productVideo)) {
            $productVideo->delete();
        }
        $this->deleteFolder($idProduct, 'threesixty/');

        $this->clearCache($idProduct);
    }

    public function hookActionObjectProductAddAfter($params)
    {
        if (!isset($params['object']->id)) {
            return;
        }
        $this->joinWithProduct($params['object']->id);
    }

    public function clearCache($idProduct = 0)
    {
        if ($idProduct) {
            $this->_clearCache($this->templateFile, 'iqitextendedproduct|' . $idProduct);
        } else {
            $this->_clearCache($this->templateFile);
        }
    }

    protected function getWarningMultishopHtml()
    {
        if (Shop::getContext() == Shop::CONTEXT_GROUP || Shop::getContext() == Shop::CONTEXT_ALL) {
            return '<p class="alert alert-warning">' .
            $this->l('You cannot manage module from a "All Shops" or a "Group Shop" context, select directly the shop you want to edit') .
                '</p>';
        } else {
            return '';
        }
    }

    /**
     * Install SQL
     * @return boolean
     */
    private function installSQL()
    {
          if (!file_exists(dirname(__FILE__) . self::INSTALL_SQL_FILE)) {
                return false;
            } elseif (!$sql = file_get_contents(dirname(__FILE__) . self::INSTALL_SQL_FILE)) {
                return false;
            }
            $sql = str_replace(array('PREFIX', 'ENGINE_TYPE'), array(_DB_PREFIX_, _MYSQL_ENGINE_), $sql);
            $sql = preg_split("/;\s*[\r\n]+/", trim($sql));
            foreach ($sql as $query) {
                if (!Db::getInstance()->execute(trim($query))) {
                    return false;
                }
            }


        // Clean memory
        unset($sql, $q, $replace);

        return true;
    }

    /**
     * Uninstall SQL
     * @return boolean
     */
    private function uninstallSQL()
    {
        if (!file_exists(dirname(__FILE__)  . self::UNINSTALL_SQL_FILE)) {
                return false;
            } elseif (!$sql = file_get_contents(dirname(__FILE__) . self::UNINSTALL_SQL_FILE)) {
                return false;
            }
            $sql = str_replace(array('PREFIX', 'ENGINE_TYPE'), array(_DB_PREFIX_, _MYSQL_ENGINE_), $sql);
            $sql = preg_split("/;\s*[\r\n]+/", trim($sql));
            foreach ($sql as $query) {
                if (!Db::getInstance()->execute(trim($query))) {
                    return false;
                }
            }
        // Clean memory
        unset($sql, $q, $replace);

        return true;
    }
}

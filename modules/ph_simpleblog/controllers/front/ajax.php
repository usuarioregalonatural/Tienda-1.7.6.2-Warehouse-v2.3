<?php
/**
 * Blog for PrestaShop module by Krystian Podemski from PrestaHome.
 *
 * @author    Krystian Podemski <krystian@prestahome.com>
 * @copyright Copyright (c) 2008-2019 Krystian Podemski - www.PrestaHome.com / www.Podemski.info
 * @license   You only can use module, nothing more!
 */
require_once _PS_MODULE_DIR_ . 'ph_simpleblog/ph_simpleblog.php';

class Ph_SimpleBlogAjaxModuleFrontController extends ModuleFrontController
{
    public $product;

    public function init()
    {
        parent::init();
    }

    public function postProcess()
    {
        if (Module::isEnabled('ph_simpleblog')
            && (Tools::getValue('action') == 'addRating' || Tools::getValue('action') == 'removeRating')
            && Tools::getValue('secure_key') == $this->module->secure_key) {
            parent::postProcess();
        } else {
            die('Access denied');
        }
    }

    public function displayAjaxAddRating()
    {
        $id_simpleblog_post = Tools::getValue('id_simpleblog_post');
        $reply = SimpleBlogPost::changeRating('up', (int) $id_simpleblog_post);
        $message = $reply[0]['likes'];
        $this->ajaxDie(
            json_encode(
                array(
                    'hasError' => false,
                    'status' => 'success',
                    'message' => $message
                )
            )
        );
    }

    public function displayAjaxRemoveRating()
    {
        $id_simpleblog_post = Tools::getValue('id_simpleblog_post');
        $reply = SimpleBlogPost::changeRating('down', (int) $id_simpleblog_post);
        $message = $reply[0]['likes'];
        $this->ajaxDie(
            json_encode(
                array(
                    'hasError' => false,
                    'status' => 'success',
                    'message' => $message
                )
            )
        );
    }
}

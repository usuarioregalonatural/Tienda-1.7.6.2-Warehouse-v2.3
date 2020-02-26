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

class IqitThemeEditorPreviewModuleFrontController extends ModuleFrontController
{
    public function setMedia()
    {

        $page = Tools::getValue('page');

        if ($page == 'maintenance') {
            $this->registerStylesheet('theme-error', '/assets/css/error.css', ['media' => 'all', 'priority' => 50]);
        } else {
            parent::setMedia();
        }
    }

    public function initContent()
    {
        if (!Tools::getValue('iqit_fronteditor_token') || !(Tools::getValue('iqit_fronteditor_token') == $this->module->getFrontEditorToken()) || !Tools::getIsset('id_employee') || !$this->module->checkEnvironment()) {
            Tools::redirect('index.php');
        }
        $this->page_name = 'preview';
        parent::initContent();
        $this->page_name = 'preview';
        $page = Tools::getValue('page');

        if ($page == 'maintenance') {
            $this->context->smarty->assign(array(
                'shop' => $this->getTemplateVarShop(),
                'pageType' => $page,
                'HOOK_MAINTENANCE' => Hook::exec('displayMaintenance', array()),
                'maintenance_text' => Configuration::get('PS_MAINTENANCE_TEXT', (int) $this->context->language->id),
            ));
        } elseif ($page == 'form') {
            $address_form = $this->makeAddressForm();

            $formFields = array(
                'text' => array(
                    'label' => 'Test title',
                    'type' => 'text',
                    'name' => 'test',
                    'required' => true,
                    'placeholder' => 'test',
                    'value' => '',
                    'maxLength' => 255,
                    'errors' => []
                ),
                'text1' => array(
                    'label' => 'Test title',
                    'type' => 'text',
                    'name' => 'test',
                    'required' => true,
                    'value' => 'test1',
                    'maxLength' => 255,
                    'errors' => []
                ),
                'select' => array(
                    'label' => 'Test title',
                    'type' => 'select',
                    'name' => 'test',
                    'required' => true,
                    'value' => 'test1',
                    'maxLength' => 255,
                    'availableValues' => [
                        'name' => 'test',
                        'name1' => 'test1',
                        'name2' => 'test2',
                        'name3' => 'test3',
                    ],
                    'errors' => []
                ),
                'checkbox' => array(
                    'label' => 'Test title',
                    'type' => 'checkbox',
                    'name' => 'test',
                    'required' => true,
                    'value' => 'test1',
                    'maxLength' => 255,
                    'availableValues' => [
                        'name' => 'test',
                        'name1' => 'test1',
                        'name2' => 'test2',
                        'name3' => 'test3',
                    ],
                    'errors' => []
                ),
                'radio-buttons' => array(
                    'label' => 'Test title',
                    'type' => 'radio-buttons',
                    'name' => 'test',
                    'required' => true,
                    'value' => 'test1',
                    'maxLength' => 255,
                    'availableValues' => [
                        'name' => 'test',
                        'name1' => 'test1',
                        'name2' => 'test2',
                        'name3' => 'test3',
                    ],
                    'errors' => []
                ),
            );

            $this->context->smarty->assign(array(
                'page' => $this->getTemplateVarPage(),
                'page_name' => 'a',
                'pageType' => $page,
                'formFields'=> $formFields,
                'address_form' => $address_form->getProxy()
            ));
        }
        $this->setTemplate('module:iqitthemeeditor/views/templates/front/preview.tpl');
    }

    public function getTemplateVarPage()
    {
        $page = parent::getTemplateVarPage();
        $page['body_classes']['iqitthemeeditor-preview'] = true;
        $page['page_name'] = 'iqithtmeeeditor-preview';
        return $page;
    }

  
}

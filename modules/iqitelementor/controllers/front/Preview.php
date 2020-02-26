<?php

use Elementor\PluginElementor;

if (!defined('_PS_VERSION_')) {
    exit;
}
require_once _PS_MODULE_DIR_ . '/iqitelementor/src/iqitElementorWpHelper.php';
require_once dirname(__FILE__) . '/../../includes/plugin-elementor.php';

class IqitElementorPreviewModuleFrontController extends ModuleFrontController
{
    public function setMedia()
    {
        parent::setMedia();

        //$this->requireAssets(['font-awesome']);
        $this->module->registerCssFiles();
        $this->context->controller->registerStylesheet('modules-iqitelementor-editor-preview', 'modules/'.$this->module->name.'/views/css/editor-preview.css', ['media' => 'all', 'priority' => 150]);

        if (Tools::getValue('template_id')){

            $this->module->registerJSFiles();

            Media::addJsDef(
                array('elementorFrontendConfig' => [
                    'isEditMode' => '',
                    'stretchedSectionContainer' =>'',
                    'is_rtl' => '',
                ]));
        }
    }

    public function initContent()
    {
        if (!Tools::getValue('iqit_fronteditor_token') || !(Tools::getValue('iqit_fronteditor_token') == $this->module->getFrontEditorToken()) || !Tools::getIsset('id_employee') || !$this->module->checkEnvironment()){
            Tools::redirect('index.php');
        }

        parent::initContent();

        if (Tools::getValue('template_id')){

            $templateId = (int) Tools::getValue('template_id');
            $template =  new IqitElementorTemplate($templateId);

            ob_start();
            PluginElementor::instance()->get_frontend((array) json_decode($template->data, true));
            $content = ob_get_clean();
            $this->context->smarty->assign(array(
                'content' => $content,
            ));

              $this->setTemplate('module:iqitelementor/views/templates/front/preview_template.tpl');
        }
        else{
            $this->setTemplate('module:iqitelementor/views/templates/front/preview.tpl');
        }
    }

    public function getLayout()
    {

        $pageType = Tools::getValue('elementor_page_type');

        if ($pageType == 'category'){

            $entity = 'category';

            $layout = $this->context->shop->theme->getLayoutRelativePathForPage($entity);
            $content_only = (int) Tools::getValue('content_only');
            if ($overridden_layout = Hook::exec(
                'overrideLayoutTemplate',
                array(
                    'default_layout' => $layout,
                    'entity' => $entity,
                    'locale' => $this->context->language->locale,
                    'controller' => $this,
                    'content_only' => $content_only,
                )
            )) {
                return $overridden_layout;
            }
            if ($content_only) {
                $layout = 'layouts/layout-content-only.tpl';
            }
            return $layout;

        } else{
            return parent::getLayout();
        }


    }



    public function getTemplateVarPage()
    {
        $page = parent::getTemplateVarPage();
        $page['body_classes']['elementor-body'] = true;

        if (Tools::getValue('elementor_page_type') == 'landing'){
            $page['body_classes']['elementor-landing-body'] = true;
        }


        return $page;
    }
}

<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

class IqitElementorWidgetModuleFrontController extends ModuleFrontController
{

    public function setMedia(){}
    public function initContent(){
        if (!Tools::getValue('iqit_fronteditor_token') || !(Tools::getValue('iqit_fronteditor_token') == $this->module->getFrontEditorToken())){
            Tools::redirect('index.php');
        }

        $this->assignGeneralPurposeVariables();
    }

    public function getLayout(){}
    public function display(){}
    public function getTemplateVarPage(){}


    public function displayAjaxWidgetPreview()
    {
        $name = Tools::getValue('widgetName');
        $options = Tools::getValue('widgetOptions');
        $templateFile = strtolower($name) . '.tpl';

        $this->context->smarty->assign($this->getIqitElementorWidgetVariables($name, $options));
        $this->smartyOutputContent('module:iqitelementor/views/templates/widgets/' . $templateFile);
        return true;
    }

    protected function displayMaintenancePage(){
        return;
    }

    public function getIqitElementorWidgetVariables($name, $options = [])
    {
        $className = 'IqitElementorWidget_' . $name;
        $widget = new $className();
        return $widget->parseOptions($options, true);
    }
}

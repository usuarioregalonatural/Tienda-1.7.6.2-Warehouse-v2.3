<?php

use Elementor\PluginElementor;
use Elementor\Responsive;
use Elementor\Schemes_Manager;

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once _PS_MODULE_DIR_ . '/iqitelementor/src/iqitElementorWpHelper.php';
require_once dirname(__FILE__) . '/../../includes/plugin-elementor.php';

class IqitElementorEditorController  extends ModuleAdminController
{

    public function __construct()
    {
        $this->bootstrap = true;
        $this->display_header = false;
        parent::__construct();
        if (!$this->module->active) {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminHome'));
        }
        $this->name = 'IqitElementorEditor';

    }

    public function renderView(){}
    public function initContent(){
        $this->setMedia();
        $this->initHeader();
    }
    public function setMedia($isNewTheme = false){

        $this->addJquery();
        $this->addJS(_PS_JS_DIR_.'tiny_mce/tinymce.min.js');
        $this->addJqueryPlugin('fancybox');
        $this->addJqueryPlugin('autocomplete');


        $this->addCSS(array(
            __PS_BASE_URI__.$this->admin_webpath.'/themes/'.$this->bo_theme.'/css/admin-theme.css',
            __PS_BASE_URI__.$this->admin_webpath.'/themes/'.$this->bo_theme.'/public/theme.css',
            _MODULE_DIR_.'iqitelementor/views/lib/font-awesome/css/font-awesome.min.css',
            _MODULE_DIR_.'iqitelementor/views/lib/select2/css/select2.min.css',
            _MODULE_DIR_.'iqitelementor/views/lib/eicons/css/elementor-icons.css',
            _MODULE_DIR_.'iqitelementor/views/lib/color-picker/color-picker.min.css',
            _MODULE_DIR_.'iqitelementor/views/css/editor.min.css'
        ));

        $this->addJS(array(
            _MODULE_DIR_.'iqitelementor/views/lib/jquery/ui/core.min.js?ver=1.11.4',
            _MODULE_DIR_.'iqitelementor/views/lib/jquery/ui/widget.min.js?ver=1.11.4',
            _MODULE_DIR_.'iqitelementor/views/lib/jquery/ui/mouse.min.js?ver=1.11.4',
            _MODULE_DIR_.'iqitelementor/views/lib/jquery/ui/sortable.min.js?ver=1.11.4',
            _MODULE_DIR_.'iqitelementor/views/lib/jquery/ui/resizable.min.js?ver=1.11.4',
            _MODULE_DIR_.'iqitelementor/views/lib/jquery/ui/position.min.js?ver=1.11.4"',
            _MODULE_DIR_.'iqitelementor/views/lib/jquery/ui/draggable.min.js?ver=1.11.4',
            _MODULE_DIR_.'iqitelementor/views/lib/jquery/ui/slider.min.js?ver=1.11.4',
            _MODULE_DIR_.'iqitelementor/views/lib/jquery/jquery.ui.touch-punch.js?ver=0.2.2',
            _MODULE_DIR_.'iqitelementor/views/lib/color-picker/iris.min.js?ver=1.0.7',
            _MODULE_DIR_.'iqitelementor/views/lib/color-picker/color-picker.min.js?ver=4.6.1',
            _MODULE_DIR_.'iqitelementor/views/lib/color-picker/wp-color-picker-alpha.js?ver=1.1',
            _MODULE_DIR_.'iqitelementor/views/lib/waypoints/waypoints-for-editor.js?ver=2.0.2',
            _MODULE_DIR_.'iqitelementor/views/lib/imagesloaded/imagesloaded.min.js?ver=4.1.0',
            _MODULE_DIR_.'iqitelementor/views/lib/lazyload/lazyload.transpiled.min.js',
            _MODULE_DIR_.'iqitelementor/views/lib/jquery-numerator/jquery-numerator.min.js?ver=0.2.0',
            _MODULE_DIR_.'iqitelementor/views/lib/slick/slick.min.js?ver=1.6.0',
            _MODULE_DIR_.'iqitelementor/views/lib/underscore/underscore-min.js',
            _MODULE_DIR_.'iqitelementor/views/lib/instagram-lite-master/instagramLite.min.js',
            _MODULE_DIR_.'iqitelementor/views/lib/backbone/backbone-min.js',
            _MODULE_DIR_.'iqitelementor/views/lib/backbone/backbone.marionette.js?ver=2.4.5',
            _MODULE_DIR_.'iqitelementor/views/lib/backbone/backbone.radio.min.js?ver=1.0.4',
            _MODULE_DIR_.'iqitelementor/views/lib/perfect-scrollbar/perfect-scrollbar.jquery.min.js?ver=0.6.12',
            _MODULE_DIR_.'iqitelementor/views/lib/jquery-easing/jquery-easing.min.js?ver=1.3.2',
            _MODULE_DIR_.'iqitelementor/views/lib/nprogress/nprogress.js?ver=0.2.0',
            _MODULE_DIR_.'iqitelementor/views/lib/tipsy/tipsy.min.js?ver=1.0.0',
            _MODULE_DIR_.'iqitelementor/views/lib/ps-helper/ps-helper.js',
            _MODULE_DIR_.'iqitelementor/views/lib/dialog/dialog.js?ver=3.0.0',
            _MODULE_DIR_.'iqitelementor/views/lib/select2/js/select2.min.js?ver=4.0.2',
            _MODULE_DIR_.'iqitelementor/views/js/frontend.js?ver=0.9.3',
            _MODULE_DIR_.'iqitelementor/views/js/editor.js?ver=0.9.3',
        ));


        $base_url = Tools::getHttpHost(true);  // DON'T TOUCH (base url (only domain) of site (without final /)).
        $base_url = Configuration::get('PS_SSL_ENABLED') && Configuration::get('PS_SSL_ENABLED_EVERYWHERE') ? $base_url : str_replace('https', 'http', $base_url);

        Media::addJsDef(
            array('elementorFrontendConfig' => [
                'isEditMode' => 1,
                'stretchedSectionContainer' =>'',
                'is_rtl' => '',
                'iqitBaseUrl' => Tools::safeOutput($base_url)
        ]));

        Hook::exec('actionAdminControllerSetMedia');

    }

    public function display()
    {
        ob_start();
        PluginElementor::instance()->editor->print_panel_html();
        $output = ob_get_contents();
        ob_end_clean();

        $pageId = (int) Tools::getValue('pageId');
        $pageType = Tools::getValue('pageType');
        $idLang = (int) Tools::getValue('idLang');

        if (!$idLang){
            $idLang = (int) Configuration::get('PS_LANG_DEFAULT');
        }

        $languages = $this->context->controller->getLanguages();
        $elementorData = '';

        switch ($pageType) {
            case 'landing':
                $editedPage = new IqitElementorLanding($pageId, $idLang);
                $editedPageLink = $this->context->link->getAdminLink('AdminIqitElementor') . '&id_page='. $pageId .'&updateiqit_elementor_landing';
                $elementorData  = json_decode($editedPage->data, true);
                break;
            case 'cms':
                $editedPage = new CMS($pageId, $idLang);
                $editedPageLink = $this->context->link->getAdminLink('AdminCmsContent') . '&id_cms='. $pageId .'&updatecms';

                $strippedCms = preg_replace('/^<p[^>]*>(.*)<\/p[^>]*>/is', '$1', $editedPage->content);
                $strippedCms = str_replace(array("\r", "\n"), '', $strippedCms);
                $content = json_decode($strippedCms, true);

                if (json_last_error() == JSON_ERROR_NONE){
                    $elementorData = $content;
                }
                break;
            case 'blog':
                $editedPage = new SimpleBlogPost($pageId, $idLang);
                $editedPageLink = $this->context->link->getAdminLink('AdminSimpleBlogPosts') . '&id_simpleblog_post='. $pageId .'&updatesimpleblog_post';

                $strippedCms = preg_replace('/^<p[^>]*>(.*)<\/p[^>]*>/is', '$1', $editedPage->content);
                $strippedCms = str_replace(array("\r", "\n"), '', $strippedCms);
                $content = json_decode($strippedCms, true);

                if (json_last_error() == JSON_ERROR_NONE){
                    $elementorData = $content;
                }
                break;
            case 'category':
                $id = IqitElementorCategory::getIdByCategory($pageId);

                if ($id){
                    $editedPage = new IqitElementorCategory($id, $idLang);
                } else {
                    $editedPage = new IqitElementorCategory();
                }

                $editedPageLink = $this->context->link->getAdminLink('AdminCategories') . '&id_category='. $pageId .'&updatecategory=1';
                $elementorData  = json_decode($editedPage->data, true);
                break;
            case 'product':
                $id = IqitElementorProduct::getIdByProduct($pageId);

                if ($id){
                    $editedPage = new IqitElementorProduct($id, $idLang);
                } else {
                    $editedPage = new IqitElementorProduct();
                }

                $editedPageLink = $this->context->link->getAdminLink('AdminProducts') . '&id_product='. $pageId .'&addproduct=1';
                $elementorData  = json_decode($editedPage->data, true);
                break;
        }

        $previewLink = $this->context->link->getModuleLink('iqitelementor', 'Preview', array(
            'iqit_fronteditor_token' => $this->module->getFrontEditorToken(),
            'admin_webpath' => $this->context->controller->admin_webpath,
            'elementor_page_type' => $pageType,
            'id_employee' => is_object($this->context->employee) ? (int)$this->context->employee->id :
                Tools::getValue('id_employee')
        ), true);


        Media::addJsDef(
            array('ElementorConfig' => [
                'ajaxurl' =>  $this->context->link->getAdminLink('IqitElementorEditor').'&ajax=1',
                'preview_link' => $previewLink,
                'elements_categories' =>  PluginElementor::instance()->elements_manager->get_categories(),
                'controls' =>   PluginElementor::instance()->controls_manager->get_controls_data(),
                'elements' => PluginElementor::instance()->elements_manager->get_register_elements_data(),
                'widgets' =>  PluginElementor::instance()->widgets_manager->get_registered_widgets_data(),
                'schemes' => [
                    'items' => PluginElementor::instance()->schemes_manager->get_registered_schemes_data(),
                    'enabled_schemes' => [],
                ],
                'default_schemes' =>  PluginElementor::instance()->schemes_manager->get_schemes_defaults(),
                'system_schemes' => '',
                'wp_editor' => '<div class="wp-core-ui wp-editor-wrap html-active" id="wp-elementorwpeditor-wrap"><div class="wp-editor-container" id="wp-elementorwpeditor-editor-container"><textarea class="elementor-wp-editor wp-editor-area" cols="40" id="elementorwpeditor" name="elementorwpeditor" rows="15">%%EDITORCONTENT%%</textarea></div></div> ',
                'post_id' => $pageId,
                'page_type' => $pageType,
                'languages' => $languages,
                'id_lang' => $idLang,
                'post_permalink' => '',
                'edit_post_link' => $editedPageLink,
                'elementor_site' => 'https://go.elementor.com/about-elementor/',
                'help_the_content_url' => 'http://iqit-commerce.com/xdocs/warehouse-theme-documentation/#iqitelementor',
                'maintance_url_settings' =>  $this->context->link->getAdminLink('AdminMaintenance'),
                'assets_url' => $this->module->getPathUri().'views/',
                'data' => $elementorData,
                'is_rtl' => '',
                'introduction' => PluginElementor::instance()->get_current_introduction(),
                'viewportBreakpoints' =>  Responsive::get_breakpoints(),
                'i18n' => [
                    'elementor' => $this->l('Elementor'),
                    'dialog_confirm_delete' => $this->l('Are you sure you want to remove this?').' {0}',
                    'dialog_user_taken_over' => '{0} '.$this->l('has taken over and is currently editing. Do you want to take over this page editing?'),
                    'delete' =>  $this->l('Delete'),
                    'cancel' =>  $this->l('Cancel'),
                    'delete_element' => $this->l('Delete').' {0}',
                    'take_over' => $this->l('Take Over'),
                    'go_back' => $this->l('Go Back'),
                    'saved' => $this->l('Saved'),
                    'before_unload_alert' => $this->l('Please note: All unsaved changes will be lost.'),
                    'edit_element' => $this->l('Edit').' {0}',
                    'global_colors' => $this->l('Global Colors'),
                    'global_fonts' => $this->l('Global Fonts'),
                    'about_elementor' => $this->l('About Elementor'),
                    'clear_page' => $this->l('Delete all content'),
                    'dialog_confirm_clear_page' => $this->l('Are you shure you want delete all content?'),
                    'changes_lost' => $this->l('You have unsaved changes!'),
                    'dialog_confirm_changes_lost' => $this->l('Please return and save, otherwise your changes will be lost.'),
                    'import_language_dialog_title' => $this->l('Erase content and import'),
                    'import_language_dialog_msg' => $this->l('Please confirm that you want to erase content of this page and import content of other language'),
                    'inner_section' => $this->l('Columns'),
                    'dialog_confirm_gallery_delete' => $this->l('Are you sure you want to reset this gallery?'),
                    'delete_gallery' => $this->l('Reset Gallery'),
                    'gallery_images_selected' => '{0}' . $this->l('Images Selected'),
                    'insert_media' => $this->l('Insert Media'),
                    'preview_el_not_found_header' => $this->l('Preview not found'),
                    'preview_el_not_found_message' => $this->l('Make sure you added own ip in Maintenance settings (Backoffice > shop parameters > general > maintenance)'),
                    'learn_more' => $this->l('Learn more'),
                    'ie_edge_browser' => $this->l('Builder do not support IE/Edge browsers'),
                    'ie_edge_browser_info' => $this->l('Please edit your layout in different browser, like Chrome, Firefox, Opera or Safari'),
                    'an_error_occurred' => $this->l('An error occurred'),
                    'templates_request_error' => $this->l('The following error occurred when processing the request:'),
                    'save_your_template' => $this->l('Save Your {0} to Library'),
                    'load_your_template' => $this->l('Load your template from file'),
                    'page' => $this->l('Page'),
                    'section' => $this->l('Section'),
                    'delete_template' => $this->l('Delete Template'),
                    'delete_template_confirm' => $this->l('Are you sure you want to delete this template?'),
                ],
            ]));

        Media::addJsDef(
            array('wpColorPickerL10n' => [
                'clear' => $this->l('Clear'),
                'defaultString' => $this->l('Default'),
                'pick' => $this->l('Pick a color'),
                'current' => $this->l('Current color')
            ]));

        $this->context->smarty->assign(array(
            'js_def_vars' => Media::getJsDef(),
        ));

        $this->context->smarty->assign(array(
            'baseDir' => __PS_BASE_URI__.basename(_PS_ADMIN_DIR_).'/',
            'pluginContent' => $output,
        ));

        $this->smartyOutputContent(_PS_MODULE_DIR_ .'/iqitelementor/views/templates/admin/adminiqitelementor.tpl');
    }

    public function ajaxProcessRenderWidget()
    {
        PluginElementor::instance()->widgets_manager->ajax_render_widget();
        die;
    }

    public function ajaxProcessSaveEditor()
    {
        header('Content-Type: application/json');

        $pageId = (int) Tools::getValue('page_id');
        $pageType = Tools::getValue('page_type');
        $data =  $this->getJsonValue('data');
        $idLang = (int) Tools::getValue('id_lang');

        switch ($pageType) {
            case 'landing':
                $landing = new IqitElementorLanding($pageId, $idLang);
                $landing->data = $data;
                $landing->update();
                $this->module->clearHomeCache();
                break;
            case 'cms':

                if ($data == '[]'){
                    $data = '';
                }
                $cms = new CMS($pageId);
                $cms->content[$idLang] = $data;
                $cms->update();
                break;
            case 'blog':
                $blogPost = new SimpleBlogPost($pageId);
                $blogPost->content[$idLang] = $data;
                $blogPost->update();
                break;
            case 'category':
                $id = IqitElementorCategory::getIdByCategory($pageId);
                if ($id){
                    $category = new IqitElementorCategory($id, $idLang);
                    $category->data = $data;
                    $category->update();
                } else {
                    $category = new IqitElementorCategory(null, $idLang);
                    $category->data = $data;
                    $category->id_category = (int) $pageId;
                    $category->add();
                }
                $this->module->clearCategoryCache($pageId);
                break;
            case 'product':
                $id = IqitElementorProduct::getIdByProduct($pageId);
                if ($id){
                    $product = new IqitElementorProduct($id, $idLang);
                    $product->data = $data;
                    $product->update();
                } else {
                    $product = new IqitElementorProduct(null, $idLang);
                    $product->data = $data;
                    $product->id_product = (int) $pageId;
                    $product->add();
                }
                $this->module->clearProductCache($pageId);
                break;
        }

        $return = array(
            'success' => true
        );

        die(json_encode($return));
    }


    public function ajaxProcessGetLanguageContent()
    {
        header('Content-Type: application/json');

        $pageId = (int) Tools::getValue('page_id');
        $pageType = Tools::getValue('page_type');
        $idLang = Tools::getValue('id_lang');
        $data = '';

        switch ($pageType) {
            case 'landing':
                $source = new IqitElementorLanding($pageId, $idLang);
                $data = json_decode($source->data, true);
                break;
            case 'cms':
                $source = new CMS($pageId, $idLang);
                $strippedCms = preg_replace('/^<p[^>]*>(.*)<\/p[^>]*>/is', '$1', $source->content);
                $strippedCms = str_replace(array("\r", "\n"), '', $strippedCms);
                $content = json_decode($strippedCms, true);

                if (json_last_error() == JSON_ERROR_NONE){
                    $data = $content;
                }
                break;
            case 'blog':
                $source = new SimpleBlogPost($pageId, $idLang);
                $strippedCms = preg_replace('/^<p[^>]*>(.*)<\/p[^>]*>/is', '$1', $source->content);
                $strippedCms = str_replace(array("\r", "\n"), '', $strippedCms);
                $content = json_decode($strippedCms, true);

                if (json_last_error() == JSON_ERROR_NONE){
                    $data = $content;
                }
                break;
            case 'category':
                $id = IqitElementorCategory::getIdByCategory($pageId);
                if ($id){
                    $source = new IqitElementorCategory($id, $idLang);
                    $data = json_decode($source->data, true);
                } else {
                    $data = json_decode('', true);
                }
                break;
            case 'product':
                $id = IqitElementorProduct::getIdByProduct($pageId);
                if ($id){
                    $source = new IqitElementorProduct($id, $idLang);
                    $data = json_decode($source->data, true);
                } else {
                    $data = json_decode('', true);
                }
                break;
        }

        $return = array(
            'success' => true,
            'data' => $data
        );

        die(json_encode($return));
    }

    public function ajaxProcessGetTemplates()
    {
        header('Content-Type: application/json');

        $templatesSource = IqitElementorTemplate::getTemplates();
        $templates = array();

        foreach ($templatesSource as $index => $template){

            $templates[$index] = array(
                'template_id' => $template['id_template'],
                'source' => 'local',
                'title' => $template['title'],
                'export_link' => $this->context->link->getAdminLink($this->name, true) . '&ajax=1&action=ExportTemplate&templateId='.$template['id_template'],
                'url' => $this->getTemplatePreviewLink($template['id_template']),
            );
        }

        $return = array(
            'success' => true,
            'data' => $templates
        );

        die(json_encode($return));
    }

    public function ajaxProcessSaveTemplate()
    {
        header('Content-Type: application/json');
        $title = Tools::getValue('title');
        $data = $this->getJsonValue('data');
        $template = new IqitElementorTemplate();
        $template->title = $title;
        $template->data = $data;
        $template->add();

        $templateInfo = array(
            'template_id' => $template->id,
            'source' => 'local',
            'title' => $title,
            'export_link' => $this->context->link->getAdminLink($this->name, true) . '&ajax=1&action=ExportTemplate&templateId='.$template->id,
            'url' => $this->getTemplatePreviewLink($template->id),
        );

        $return = array(
            'success' => true,
            'data' => $templateInfo
        );

        die(json_encode($return));
    }

    public function ajaxProcessDeleteTemplate()
    {
        header('Content-Type: application/json');
        $templateId = (int) Tools::getValue('template_id');
        $template = new IqitElementorTemplate($templateId);
        $template->delete();

        $return = array(
            'success' => true,
            'data' => true
        );

        die(json_encode($return));
    }

    public function ajaxProcessGetTemplateContent()
    {
        header('Content-Type: application/json');

        $templateId = (int) Tools::getValue('template_id');
        $template = new IqitElementorTemplate($templateId);

        $return = array(
            'success' => true,
            'data' => json_decode($template->data, true)
        );

        die(json_encode($return));
    }

    public function ajaxProcessExportTemplate()
    {
        $templateId = (int) Tools::getValue('templateId');
        $template = new IqitElementorTemplate($templateId);

        $content = array(
            'title' =>  $template->title,
            'data' => $template->data
        );

        header('Content-disposition: attachment; filename=iqitelementor_template_id_'.$template->id.'.json');
        header('Content-type: application/json');
        print_r(json_encode($content));
        die;
    }

    public function ajaxProcessImportTemplate()
    {
        header('Content-Type: application/json');

        $return = array(
            'error' => true,
            'data' => array(
                'message' => $this->l('Problem with file')
            )
        );

        if (isset($_FILES['file']) && isset($_FILES['file']['tmp_name'])) {
            $templateSource = json_decode(Tools::file_get_contents($_FILES['file']['tmp_name']));
            $template = new IqitElementorTemplate();
            if (isset($templateSource->title)){
                $template->title = $templateSource->title;
                $template->data = $templateSource->data;
                $template->add();

                $templateInfo = array(
                    'template_id' => $template->id,
                    'source' => 'local',
                    'title' => $templateSource->title,
                    'export_link' => $this->context->link->getAdminLink($this->name, true) . '&ajax=1&action=ExportTemplate&templateId='.$template->id,
                    'url' => $this->getTemplatePreviewLink($template->id),
                );

                $return = array(
                    'success' => true,
                    'data' => $templateInfo
                );
            }
        }
        die(json_encode($return));
    }

    public function ajaxProcessGetProducts()
    {
        header('Content-Type: application/json');

        $product_ids = Tools::getValue('ids');

        if (!$product_ids) {
            $return = array(
                'success' => true,
                'data' => '',
            );
        die(json_encode($return));
        }

        $id_shop = (int) $this->context->shop->id;
        $id_lang = (int) $this->context->language->id;

        $sql = 'SELECT p.`id_product`, product_shop.`id_product`,
				    pl.`name`, pl.`link_rewrite`,
					image_shop.`id_image` id_image
				FROM  `'._DB_PREFIX_.'product` p 
				'.Shop::addSqlAssociation('product', 'p').'
				LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (
					p.`id_product` = pl.`id_product`
					AND pl.`id_lang` = '.(int) $id_lang.Shop::addSqlRestrictionOnLang('pl').'
				)
				LEFT JOIN `'._DB_PREFIX_.'image_shop` image_shop
					ON (image_shop.`id_product` = p.`id_product` AND image_shop.cover=1 AND image_shop.id_shop='.(int) $id_shop.')
	  
				WHERE p.id_product IN ('.$product_ids.')'.'
				ORDER BY FIELD(product_shop.id_product, '.$product_ids.')';
        if (!$results = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql)) {
            return false;
        }

        foreach ($results as &$result) {
            $result['image'] = str_replace('http://', Tools::getShopProtocol(), $this->context->link->getImageLink($result['link_rewrite'], $result['id_image'], ImageType::getFormattedName('small')));
        }

        $return = array(
            'success' => true,
            'data' => $results,
        );

        die(json_encode($return));
    }

    public function ajaxProcessSearchProducts()
    {
        $query = Tools::getValue('q', false);
        if (!$query or $query == '' or Tools::strlen($query) < 1) {
            die();
        }
        if ($pos = strpos($query, ' (ref:')) {
            $query = Tools::substr($query, 0, $pos);
        }
        $excludeIds = Tools::getValue('excludeIds', false);
        if ($excludeIds && $excludeIds != 'NaN') {
            $excludeIds = implode(',', array_map('intval', explode(',', $excludeIds)));
        } else {
            $excludeIds = '';
        }
        $excludeVirtuals = false;
        $exclude_packs = false;
        $context = Context::getContext();
        $sql = 'SELECT p.`id_product`, pl.`link_rewrite`, p.`reference`, pl.`name`, image.`id_image` id_image, il.`legend`, p.`cache_default_attribute`
        FROM `' . _DB_PREFIX_ . 'product` p
        ' . Shop::addSqlAssociation('product', 'p') . '
        LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl ON (pl.id_product = p.id_product AND pl.id_lang = ' . (int)$context->language->id . Shop::addSqlRestrictionOnLang('pl') . ')
        LEFT JOIN `' . _DB_PREFIX_ . 'image` image
        ON (image.`id_product` = p.`id_product` AND image.cover=1)
        LEFT JOIN `' . _DB_PREFIX_ . 'image_lang` il ON (image.`id_image` = il.`id_image` AND il.`id_lang` = ' . (int)$context->language->id . ')
        WHERE (pl.name LIKE \'%' . pSQL($query) . '%\' OR p.reference LIKE \'%' . pSQL($query) . '%\') AND p.`active` = 1' .
            (!empty($excludeIds) ? ' AND p.id_product NOT IN (' . $excludeIds . ') ' : ' ') .
            ($excludeVirtuals ? 'AND NOT EXISTS (SELECT 1 FROM `' . _DB_PREFIX_ . 'product_download` pd WHERE (pd.id_product = p.id_product))' : '') .
            ($exclude_packs ? 'AND (p.cache_is_pack IS NULL OR p.cache_is_pack = 0)' : '') .
            ' GROUP BY p.id_product';

        $items = Db::getInstance()->executeS($sql);

        if ($items) {
            $results = array();
            foreach ($items as $item) {
                $product = array(
                    'id' => (int)($item['id_product']),
                    'name' => $item['name'],
                    'ref' => (!empty($item['reference']) ? $item['reference'] : ''),
                    'image' => str_replace('http://', Tools::getShopProtocol(), $context->link->getImageLink($item['link_rewrite'], $item['id_image'], ImageType::getFormattedName('small'))),
                );
                array_push($results, $product);
            }
            $results = array_values($results);
            die(json_encode($results));
        } else {
            die(json_encode(new stdClass));
        }
    }

    public function getTemplatePreviewLink($templateId){
        return $previewLink = $this->context->link->getModuleLink('iqitelementor', 'Preview', array(
            'iqit_fronteditor_token' => $this->module->getFrontEditorToken(),
            'admin_webpath' => $this->context->controller->admin_webpath,
            'template_id' =>  $templateId,
            'id_employee' => is_object($this->context->employee) ? (int)$this->context->employee->id :
                Tools::getValue('id_employee')
        ), true);
    }

    public static function getJsonValue($key, $default_value = false)
    {
        if (!isset($key) || empty($key) || !is_string($key)) {
            return false;
        }

        if (getenv('kernel.environment') === 'test' && self::$request instanceof Request) {
            $value = self::$request->request->get($key, self::$request->query->get($key, $default_value));
        } else {
            $value = (isset($_POST[$key]) ? $_POST[$key] : (isset($_GET[$key]) ? $_GET[$key] : $default_value));
        }

        if (is_string($value)) {
            return urldecode(preg_replace('/((\%5C0+)|(\%00+))/i', '', urlencode($value)));
        }

        return $value;
    }
}



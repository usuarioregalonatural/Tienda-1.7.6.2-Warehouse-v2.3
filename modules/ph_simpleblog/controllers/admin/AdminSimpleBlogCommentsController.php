<?php
/**
 * Blog for PrestaShop module by Krystian Podemski from PrestaHome.
 *
 * @author    Krystian Podemski <krystian@prestahome.com>
 * @copyright Copyright (c) 2014-2016 Krystian Podemski - www.PrestaHome.com / www.Podemski.info
 * @license   You only can use module, nothing more!
 */
require_once _PS_MODULE_DIR_ . 'ph_simpleblog/ph_simpleblog.php';

class AdminSimpleBlogCommentsController extends ModuleAdminController
{
    public $is_16;

    public function __construct()
    {

        $this->table = 'simpleblog_comment';
        $this->className = 'SimpleBlogComment';

        $this->bootstrap = true;

        $this->addRowAction('edit');
        $this->addRowAction('delete');

        $this->is_16 = (bool)(version_compare(_PS_VERSION_, '1.6.0', '>=') === true);

        parent::__construct();
        
        $this->bulk_actions = array(
                'delete' => array(
                    'text' => $this->l('Delete selected'),
                    'confirm' => $this->l('Delete selected items?')
                ),
                'enableSelection' => array('text' => $this->l('Enable selection')),
                'disableSelection' => array('text' => $this->l('Disable selection'))
            );

        $this->_select = 'sbpl.title AS `post_title`';

        $this->_join = 'LEFT JOIN `'._DB_PREFIX_.'simpleblog_post_lang` sbpl ON (sbpl.`id_simpleblog_post` = a.`id_simpleblog_post` AND sbpl.`id_lang` = '.(int)Context::getContext()->language->id.')';

        $this->fields_list = array(
            'id_simpleblog_comment' => array(
                'title' => $this->l('ID'),
                'type' => 'int',
                'align' => 'center',
                'width' => 25
            ),
            'id_simpleblog_post' => array(
                'title' => $this->l('Post ID'),
                'type' => 'int',
                'align' => 'center',
                'width' => 25
            ),
            'post_title' => array(
                'title' => $this->l('Comment for'),
                'width' => 'auto'
            ),
            'name' => array(
                'title' => $this->l('Name'),
            ),
            'email' => array(
                'title' => $this->l('E-mail'),
            ),
            'comment' => array(
                'title' => $this->l('Comment'),
                'width' => 'auto'
            ),
            'active' => array(
                'title' => $this->l('Status'),
                'width' => 70,
                'active' => 'status',
                'align' => 'center',
                'type' => 'bool'
            )
        );
    }
    
    public function renderForm()
    {
        $id_lang = $this->context->language->id;
        $obj = $this->loadObject(true);
       
        $this->fields_form[0]['form'] = array(
            'legend' => array(
                'title' => $this->l('Comment'),
            ),
            'input' => array(
                array(
                    'type' => 'hidden',
                    'name' => 'id_simpleblog_post',
                ),
                array(
                    'type' => 'hidden',
                    'name' => 'id_customer',
                    'label' => $this->l('Customer'),
                ),
                array(
                    'type' => 'text',
                    'name' => 'id_simpleblog_post',
                    'label' => $this->l('Post ID'),
                ),
                array(
                    'type' => 'text',
                    'name' => 'name',
                    'label' => $this->l('Name'),
                    'required' => false,
                    'lang' => false
                ),
                array(
                    'type' => 'text',
                    'name' => 'email',
                    'label' => $this->l('E-mail'),
                    'required' => false,
                    'lang' => false
                ),
                array(
                    'type' => 'text',
                    'name' => 'ip',
                    'label' => $this->l('IP Address'),
                    'required' => false,
                    'lang' => false
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Comment'),
                    'name' => 'comment',
                    'cols' => 75,
                    'rows' => 7,
                    'required' => false,
                    'lang' => false
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Displayed'),
                    'name' => 'active',
                    'required' => false,
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    )
                )
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'name' => 'savePostComment'
            )
        );

        $this->multiple_fieldsets = true;
        
        $SimpleBlogPost = new SimpleBlogPost($obj->id_simpleblog_post, $id_lang);
        
        $this->tpl_form_vars = array(
            'customerLink' => $this->context->link->getAdminLink('AdminCustomers'),
            'blogPostLink' => $this->context->link->getAdminLink('AdminSimpleBlogPost'),
            'blogPostName' => $SimpleBlogPost->meta_title
        );
        
        return parent::renderForm();
        
    }
}

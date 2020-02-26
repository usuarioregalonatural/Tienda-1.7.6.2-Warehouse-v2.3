<?php
/**
 * Blog for PrestaShop module by Krystian Podemski from PrestaHome.
 *
 * @author    Krystian Podemski <krystian@prestahome.com>
 * @copyright Copyright (c) 2008-2019 Krystian Podemski - www.PrestaHome.com / www.Podemski.info
 * @license   You only can use module, nothing more!
 */
require_once _PS_MODULE_DIR_ . 'ph_simpleblog/ph_simpleblog.php';

class AdminSimpleBlogAuthorsController extends ModuleAdminController
{
    public function __construct()
    {
        $this->errors[] = 'Coming SOON';
        return parent::__construct();

        $this->table = 'simpleblog_author';
        $this->className = 'SimpleBlogPostAuthor';
        $this->lang = true;

        $this->addRowAction('edit');
        $this->addRowAction('delete');
        
        $this->bootstrap = true;

        parent::__construct();

        $this->bulk_actions = array('delete' => array('text' => $this->l('Delete selected'), 'confirm' => $this->l('Delete selected items?')));

        $this->_select = 'IFNULL(sbp.posts, 0) as number_of_posts';
        $this->_join = 'LEFT JOIN (SELECT id_simpleblog_author, COUNT(*) as posts FROM '._DB_PREFIX_.'simpleblog_post GROUP BY id_simpleblog_author) sbp ON a.id_simpleblog_author = sbp.id_simpleblog_author';

        $this->fields_list = array(
            'id_simpleblog_author' => array(
                'title' => $this->l('ID'),
                'align' => 'center',
                'width' => 30
            ),
            'firstname' => array(
                'title' => $this->l('Firstname'),
                'width' => 'auto'
            ),
            'lastname' => array(
                'title' => $this->l('Lastname'),
                'width' => 'auto'
            ),
            'email' => array(
                'title' => $this->l('E-mail'),
                'width' => 'auto'
            ),
            'number_of_posts' => array(
                'title' => $this->l('Posts'),
                'width' => 'auto'
            ),
            'active' => array(
                'title' => $this->l('Active'),
                'width' => 25,
                'active' => 'status',
                'align' => 'center',
                'type' => 'bool',
                'orderby' => false
            ),
        );
    }
  
    
    public function initFormToolBar()
    {
        unset($this->toolbar_btn['back']);
        $this->toolbar_btn['save-and-stay'] = array(
            'short' => 'SaveAndStay',
            'href' => '#',
            'desc' => $this->l('Save and stay'),
        );
        $this->toolbar_btn['back'] = array(
            'href' => self::$currentIndex.'&token='.Tools::getValue('token'),
            'desc' => $this->l('Back to list'),
        );
    }

    public function renderForm()
    {
        $this->initFormToolBar();
        if (!$this->loadObject(true)) {
            return;
        }

        $obj = $this->loadObject(true);

        $this->fields_form = array(
            'legend' => array(
                'title' => $this->l('Author'),
            ),
            'input' => array(

                array(
                    'type' => 'text',
                    'label' => $this->l('Firstname:'),
                    'name' => 'firstname',
                    'lang' => false,
                ),

                array(
                    'type' => 'text',
                    'label' => $this->l('Lastname:'),
                    'name' => 'lastname',
                    'lang' => false,
                ),

                array(
                    'type' => 'select_image',
                    'label' => $this->l('Photo:'),
                    'name' => 'photo',
                    'lang' => false,
                ),

                array(
                    'type' => 'textarea',
                    'label' => $this->l('Bio:'),
                    'name' => 'bio',
                    'lang' => true,
                    'rows' => 5,
                    'cols' => 40,
                    'autoload_rte' => true,
                ),

                array(
                    'type' => 'textarea',
                    'label' => $this->l('Additional info:'),
                    'name' => 'additional_info',
                    'lang' => true,
                    'rows' => 5,
                    'cols' => 40,
                    'autoload_rte' => true,
                ),

                array(
                    'type' => 'text',
                    'label' => $this->l('E-mail:'),
                    'name' => 'email',
                    'lang' => false,
                ),

                array(
                    'type' => 'text',
                    'label' => $this->l('Phone:'),
                    'name' => 'phone',
                    'lang' => false,
                ),

                array(
                    'type' => 'text',
                    'label' => $this->l('Facebook:'),
                    'name' => 'facebook',
                    'lang' => false,
                ),

                array(
                    'type' => 'text',
                    'label' => $this->l('Instagram:'),
                    'name' => 'instagram',
                    'lang' => false,
                ),

                array(
                    'type' => 'text',
                    'label' => $this->l('Twitter:'),
                    'name' => 'twitter',
                    'lang' => false,
                ),

                array(
                    'type' => 'text',
                    'label' => $this->l('Google:'),
                    'name' => 'google',
                    'lang' => false,
                ),

                array(
                    'type' => 'text',
                    'label' => $this->l('LinkedIn:'),
                    'name' => 'linkedin',
                    'lang' => false,
                ),

                array(
                    'type' => 'text',
                    'label' => $this->l('WWW:'),
                    'name' => 'www',
                    'lang' => false,
                ),

                array(
                    'type' => 'switch',
                    'label' => $this->l('Active'),
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
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save'),
            )
        );

        return parent::renderForm();
    }
}

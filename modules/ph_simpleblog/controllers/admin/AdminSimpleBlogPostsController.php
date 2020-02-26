<?php
/**
 * Blog for PrestaShop module by Krystian Podemski from PrestaHome.
 *
 * @author    Krystian Podemski <krystian@prestahome.com>
 * @copyright Copyright (c) 2008-2019 Krystian Podemski - www.PrestaHome.com / www.Podemski.info
 * @license   You only can use module, nothing more!
 */
require_once _PS_MODULE_DIR_.'ph_simpleblog/ph_simpleblog.php';

class AdminSimpleBlogPostsController extends ModuleAdminController
{
    public function __construct()
    {
        $this->table = 'simpleblog_post';
        $this->className = 'SimpleBlogPost';
        $this->lang = true;

        $this->bootstrap = true;

        $this->addRowAction('edit');
        $this->addRowAction('view');
        $this->addRowAction('delete');

        $this->list_no_link = true;

        $this->_select = 'sbcl.name AS `category`, sbpt.name AS `post_type`';

        $this->_join = 'LEFT JOIN `'._DB_PREFIX_.'simpleblog_category_lang` sbcl ON (sbcl.`id_simpleblog_category` = a.`id_simpleblog_category` AND sbcl.`id_lang` = '.(int) Context::getContext()->language->id.')';
        $this->_join .= 'LEFT JOIN `'._DB_PREFIX_.'simpleblog_post_type` sbpt ON (sbpt.`id_simpleblog_post_type` = a.`id_simpleblog_post_type`)';

        $this->_defaultOrderWay = 'DESC';

        parent::__construct();

        $this->displayInformations = $this->l('Some option may be available after saving post');

        $this->bulk_actions = array(
            'delete' => array(
                'text' => $this->l('Delete selected'),
                'confirm' => $this->l('Delete selected items?'),
            ),
            'enableSelection' => array('text' => $this->l('Enable selection')),
            'disableSelection' => array('text' => $this->l('Disable selection')),
        );

        $this->fields_list = array(
            'id_simpleblog_post' => array(
                'title' => $this->l('ID'),
                'align' => 'center',
                'width' => 30,
            ),
            'post_type' => array(
                'title' => $this->l('Type'),
                'width' => 'auto',
                'filter_key' => 'sbpt!name',
            ),
            'cover' => array(
                'title' => $this->l('Post thumbnail'),
                'width' => 150,
                'orderby' => false,
                'search' => false,
                'callback' => 'getPostThumbnail',
            ),
            'category' => array(
                'title' => $this->l('Category'),
                'width' => 'auto',
                'filter_key' => 'sbcl!name',
            ),
            'title' => array(
                'title' => $this->l('Title'),
                'width' => 'auto',
                'filter_key' => 'b!title',
            ),
            'short_content' => array(
                'title' => $this->l('Description'),
                'width' => 500,
                'orderby' => false,
                'callback' => 'getDescriptionClean',
            ),
            'views' => array(
                'title' => $this->l('Views'),
                'width' => 30,
                'align' => 'center',
                'search' => false,
            ),
            'likes' => array(
                'title' => $this->l('Likes'),
                'width' => 30,
                'align' => 'center',
                'search' => false,
            ),
            'is_featured' => array(
                'title' => $this->l('Featured?'),
                'orderby' => false,
                'align' => 'center',
                'type' => 'bool',
                'active' => 'is_featured',
            ),
            'date_add' => array(
                'title' => $this->l('Publication date'),
                'type' => 'date',
                'filter_key' => 'a!date_add',
            ),
            'active' => array(
                'title' => $this->l('Displayed'), 'width' => 25, 'active' => 'status',
                'align' => 'center', 'type' => 'bool', 'orderby' => false,
            ),
        );


        if (!Tools::getValue('id_simpleblog_post', 0)) {
            $this->informations[] = $this->l('You can view blog here: ').'<a href="'.ph_simpleblog::getLink().'" title="" class="_blank">'.ph_simpleblog::getLink().'</a>';
        }
    }

    public function init()
    {
        parent::init();

        Shop::addTableAssociation($this->table, array('type' => 'shop'));

        if (Shop::getContext() == Shop::CONTEXT_SHOP) {
            $this->_join .= ' LEFT JOIN `'._DB_PREFIX_.'simpleblog_post_shop` sa ON (a.`id_simpleblog_post` = sa.`id_simpleblog_post` AND sa.id_shop = '.(int) $this->context->shop->id.') ';
        }

        if (Shop::getContext() == Shop::CONTEXT_SHOP && Shop::isFeatureActive()) {
            $this->_where = ' AND sa.`id_shop` = '.(int) Context::getContext()->shop->id;
        }

        if (Shop::isFeatureActive() && Shop::getContext() != Shop::CONTEXT_SHOP) {
            unset($this->fields_list['position']);
        }
    }

    public function setMedia($isNewTheme = false)
    {
        parent::setMedia();

        $this->addjQueryPlugin(array(
            'autocomplete',
            'tablednd',
            'date',
            'tagify',
            'validate',
            'fancybox'
        ));

        $this->addJS(array(
            _PS_JS_DIR_.'admin-dnd.js',
            _PS_JS_DIR_.'jquery/ui/jquery.ui.progressbar.min.js',
            _PS_JS_DIR_.'vendor/spin.js',
            _PS_JS_DIR_.'vendor/ladda.js',
            _MODULE_DIR_.'ph_simpleblog/js/admin.js',
            _MODULE_DIR_.'ph_simpleblog/views/js/select2/select2.full.min.js'
        ));

        $this->addCSS(array(
            _MODULE_DIR_.'ph_simpleblog/views/css/select2/select2.min.css'
        ));
    }

    public static function getDescriptionClean($description)
    {
        return substr(strip_tags(stripslashes($description)), 0, 80).'...';
    }

    public static function getPostThumbnail($cover, $row)
    {
        return ImageManager::thumbnail(_PS_MODULE_DIR_.'ph_simpleblog/covers/'.$row['id_simpleblog_post'].'.'.$cover, 'ph_simpleblog_'.$row['id_simpleblog_post'].'-list.'.$cover, 75, $cover, true);
    }

    public function renderList()
    {
        $this->initToolbar();

        return parent::renderList();
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

    public function initPageHeaderToolbar()
    {
        $this->page_header_toolbar_title = $this->l('Posts');

        if ($this->display == 'add' || $this->display == 'edit') {
            $this->page_header_toolbar_btn['back_to_list'] = array(
                'href' => Context::getContext()->link->getAdminLink('AdminSimpleBlogPosts'),
                'desc' => $this->l('Back to list', null, null, false),
                'icon' => 'process-icon-back',
            );

            if (Tools::getValue('id_simpleblog_post', 0)) {
                if ($this->loadObject(true)) {
                    $obj = $this->loadObject(true);
                }

                $SimpleBlogPost = new SimpleBlogPost($obj->id, $this->context->language->id);

                $this->page_header_toolbar_btn['preview_post'] = array(
                    'href' => Context::getContext()->link->getModuleLink('ph_simpleblog', 'single', array('rewrite' => $SimpleBlogPost->link_rewrite, 'sb_category' => $SimpleBlogPost->category_rewrite)),
                    'desc' => $this->l('View post', null, null, false),
                    'icon' => 'process-icon-preview',
                    'target' => true,
                );
            }
        }

        if (!isset($this->display)) {
            $this->page_header_toolbar_btn['new_post'] = array(
                'href' => self::$currentIndex.'&addsimpleblog_post&token='.$this->token,
                'desc' => $this->l('Add new post', null, null, false),
                'icon' => 'process-icon-new',
            );

            $this->page_header_toolbar_btn['go_to_blog'] = array(
                'href' => ph_simpleblog::getLink(),
                'desc' => $this->l('Go to blog', null, null, false),
                'icon' => 'process-icon-plus',
                'target' => true,
            );
        }

        parent::initPageHeaderToolbar();
    }

    public function renderForm()
    {
        $this->initFormToolbar();
        if (!$this->loadObject(true)) {
            return;
        }

        $obj = $this->loadObject(true);

        $cover = false;
        $featured = false;

        if (isset($obj->id)) {
            $this->display = 'edit';

            $cover = ImageManager::thumbnail(_PS_MODULE_DIR_.'ph_simpleblog/covers/'.$obj->id.'.'.$obj->cover, 'ph_simpleblog_'.$obj->id.'.'.$obj->cover, 350, $obj->cover, false);
            $featured = ImageManager::thumbnail(_PS_MODULE_DIR_.'ph_simpleblog/featured/'.$obj->id.'.'.$obj->featured, 'ph_simpleblog_featured_'.$obj->id.'.'.$obj->featured, 350, $obj->featured, false);
        } else {
            $this->display = 'add';
        }

        $this->fields_value = array(
            'cover' => $cover ? $cover : false,
            'cover_size' => $cover ? filesize(_PS_MODULE_DIR_.'ph_simpleblog/covers/'.$obj->id.'.'.$obj->cover) / 1000 : false,
            'featured' => $featured ? $featured : false,
            'featured_size' => $featured ? filesize(_PS_MODULE_DIR_.'ph_simpleblog/featured/'.$obj->id.'.'.$obj->featured) / 1000 : false,
        );

        $obj->tags = SimpleBlogTag::getPostTags($obj->id);

        $this->tpl_form_vars['PS_ALLOW_ACCENTED_CHARS_URL'] = (int) Configuration::get('PS_ALLOW_ACCENTED_CHARS_URL');
        $this->tpl_form_vars['languages'] = $this->_languages;
        $this->tpl_form_vars['simpleblogpost'] = $obj;

        if (isset($obj->id) && $obj->access) {
            $groupAccess = unserialize($obj->access);

            foreach ($groupAccess as $groupAccessID => $value) {
                $groupBox = 'groupBox_'.$groupAccessID;
                $this->fields_value[$groupBox] = $value;
            }
        } else {
            $groups = Group::getGroups($this->context->language->id);
            $preselected = array(
                Configuration::get('PS_UNIDENTIFIED_GROUP'),
                Configuration::get('PS_GUEST_GROUP'),
                Configuration::get('PS_CUSTOMER_GROUP'),
            );
            foreach ($groups as $group) {
                $this->fields_value['groupBox_'.$group['id_group']] = (in_array($group['id_group'], $preselected));
            }
        }

        if (!isset($obj->id)) {
            $this->fields_value['date_add'] = date('Y-m-d H:i:s');
        }

        $available_categories = SimpleBlogCategory::getCategories($this->context->language->id, true, false);

        foreach ($available_categories as &$category) {
            if ($category['is_child']) {
                $category['name'] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$category['name'];
            }
        }

        $authors = array();
        $authors = SimpleBlogPostAuthor::getAll();
        array_unshift($authors, array('name' => $this->l('Custom'), 'id_simpleblog_author' => 0));

        $i = 0;
        $this->fields_form[$i]['form'] = array(
            'legend' => array(
                'title' => $this->l('SimpleBlog Post'),
                'icon' => 'icon-folder-close',
            ),
            'input' => array(
                array(
                    'type' => 'hidden',
                    'label' => $this->l('Post type:'),
                    'name' => 'id_simpleblog_post_type',
                    'required' => true,
                    'value' => 1,
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Category:'),
                    'name' => 'id_simpleblog_category',
                    'required' => true,
                    'options' => array(
                        'id' => 'id',
                        'query' => $available_categories,
                        'name' => 'name',
                        ),
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Post author:'),
                    'name' => 'id_simpleblog_author',
                    'required' => false,
                    'options' => array(
                        'id' => 'id_simpleblog_author',
                        'query' => $authors,
                        'name' => 'name',
                    ),
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Author:'),
                    'name' => 'author',
                    'form_group_class' => 'post_author'
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Title:'),
                    'name' => 'title',
                    'required' => true,
                    'lang' => true,
                    'id' => 'name',
                    'class' => 'copyNiceUrl',
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Short content:'),
                    'name' => 'short_content',
                    'lang' => true,
                    'rows' => 5,
                    'cols' => 40,
                    'autoload_rte' => true,
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Full post content:'),
                    'name' => 'content',
                    'lang' => true,
                    'rows' => 15,
                    'cols' => 40,
                    'autoload_rte' => true,
                ),
                array(
                    'type' => 'elementor-button',
                    'label' => $this->l(''),
                    'name' => 'elementor-button',
                    'id'
                ),
                array(
                    'type' => 'tags',
                    'label' => $this->l('Tags:'),
                    'desc' => $this->l('separate by comma for eg. ipod, apple, something'),
                    'name' => 'tags',
                    'required' => false,
                    'lang' => true,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Featured?'),
                    'name' => 'is_featured',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'is_featured_on',
                            'value' => 1,
                            'label' => $this->l('Yes'),
                        ),
                        array(
                            'id' => 'is_featured_off',
                            'value' => 0,
                            'label' => $this->l('No'),
                        ),
                    ),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Displayed:'),
                    'name' => 'active',
                    'required' => false,
                    'class' => 't',
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Enabled'),
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Disabled'),
                        ),
                    ),
                ),
                array(
                    'type' => 'radio',
                    'label' => $this->l('Allow comments?'),
                    'name' => 'allow_comments',
                    'required' => false,
                    'class' => 't',
                    'values' => array(
                        array(
                            'id' => 'allow_comments_1',
                            'value' => 1,
                            'label' => $this->l('Yes'),
                        ),
                        array(
                            'id' => 'allow_comments_2',
                            'value' => 2,
                            'label' => $this->l('No'),
                        ),
                        array(
                            'id' => 'allow_comments_3',
                            'value' => 3,
                            'label' => $this->l('Use global setting'),
                        ),
                    ),
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save and stay'),
                'stay' => true,
            ),
        );
        $i++;

        $this->fields_value['id_simpleblog_post_type'] = 1;

        if (isset($obj->id)) {
            $this->addjQueryPlugin(array(
                'ajaxfileupload',
            ));
            // Get images
            $images = SimpleBlogPostImage::getAllById($obj->id);
            foreach ($images as $k => $image) {
                $images[$k] = new SimpleBlogPostImage($image['id_simpleblog_post_image']);
            }

            $image_uploader = new HelperImageUploader('file');
            $image_uploader
                ->setMultiple(!(Tools::getUserBrowser() == 'Apple Safari' && Tools::getUserPlatform() == 'Windows'))
                ->setUseAjax(true)
                ->setUrl(Context::getContext()->link->getAdminLink('AdminSimpleBlogPosts').'&ajax=1&id_simpleblog_post='.(int) $obj->id.'&action=addPostImages');

            $this->tpl_form_vars['images'] = $images;
            $this->tpl_form_vars['image_uploader'] = $image_uploader->render();

            $i++;
        } else {
            $i++;
        }

        $this->fields_form[$i]['form'] = array(
            'legend' => array(
                'title' => $this->l('Post Images'),
                'icon' => 'icon-picture',
            ),
            'input' => array(
               array(
                    'type' => 'file',
                    'label' => $this->l('Post cover:'),
                    'display_image' => true,
                    'name' => 'cover',
                    'desc' => $this->l('Upload a image from your computer.'),
                ),
               array(
                    'type' => 'file',
                    'label' => $this->l('Post featured image:'),
                    'display_image' => true,
                    'name' => 'featured',
                    'desc' => $this->l('Upload a image from your computer. Featured image will be displayed only if you want on the single post page.'),
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save and stay'),
                'stay' => true,
            ),
        );
        $i++;

        $available_products = array();
        if ($obj->id_product) {
            $available_products = self::getSimpleProducts($this->context->language->id, $obj->id_product);

            foreach ($available_products as &$available_related_product) {
                if (empty($available_related_product['product_name'])) {
                    if (isset($available_related_product['name']) && !empty($available_related_product['name'])) {
                        $available_related_product['product_name'] = $available_related_product['name'];
                    }
                }
            }
        }

        $this->fields_form[$i]['form'] = array(
            'legend' => array(
                'title' => $this->l('Related products'),
            ),
            'input' => array(
               array(
                    'type' => 'select',
                    'label' => $this->l('Product:'),
                    'name' => 'id_product[]',
                    'id' => 'select_product',
                    'multiple' => true,
                    'required' => false,
                    'options' => array(
                        'id' => 'id_product',
                        'query' => $available_products,
                        'name' => 'product_name',
                    ),
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save and stay'),
                'stay' => true,
            ),
        );
        $i++;

        $this->fields_value['id_product[]'] = explode(',', $obj->id_product);

        $this->fields_form[$i]['form'] = array(
            'legend' => array(
                'title' => $this->l('SEO'),
                'icon' => 'icon-folder-close',
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Meta title:'),
                    'name' => 'meta_title',
                    'lang' => true,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Meta description:'),
                    'name' => 'meta_description',
                    'lang' => true,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Meta keywords:'),
                    'name' => 'meta_keywords',
                    'lang' => true,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Friendly URL:'),
                    'name' => 'link_rewrite',
                    'required' => true,
                    'lang' => true,
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save and stay'),
                'stay' => true,
            ),
        );
        $i++;

        $unidentified = new Group(Configuration::get('PS_UNIDENTIFIED_GROUP'));
        $guest = new Group(Configuration::get('PS_GUEST_GROUP'));
        $default = new Group(Configuration::get('PS_CUSTOMER_GROUP'));

        $unidentified_group_information = sprintf($this->l('%s - All people without a valid customer account.'), '<b>'.$unidentified->name[$this->context->language->id].'</b>');
        $guest_group_information = sprintf($this->l('%s - Customer who placed an order with the guest checkout.'), '<b>'.$guest->name[$this->context->language->id].'</b>');
        $default_group_information = sprintf($this->l('%s - All people who have created an account on this site.'), '<b>'.$default->name[$this->context->language->id].'</b>');

        $this->fields_form[$i]['form'] = array(
            'legend' => array(
                'title' => $this->l('Availability'),
            ),
            'input' => array(
                array(
                    'type' => 'datetime',
                    'label' => $this->l('Publication date:'),
                    'name' => 'date_add',
                    'desc' => $this->l('Remember to set correctly your timezone in Blog for PrestaShop -> Settings. Current timezone:').' '.Configuration::get('PH_BLOG_TIMEZONE').', '.$this->l('current time with this setting:').' '.SimpleBlogHelper::now(Configuration::get('PH_BLOG_TIMEZONE')),
                    'required' => true,
                ),
                array(
                    'type' => 'group',
                    'label' => $this->l('Group access'),
                    'name' => 'groupBox',
                    'values' => Group::getGroups(Context::getContext()->language->id),
                    'info_introduction' => $this->l('You now have three default customer groups.'),
                    'unidentified' => $unidentified_group_information,
                    'guest' => $guest_group_information,
                    'customer' => $default_group_information,
                    'hint' => $this->l('Mark all of the customer groups which you would like to have access to this category.'),
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save and stay'),
                'stay' => true,
            ),
        );
        $i++;

        if (Shop::isFeatureActive()) {
            $this->fields_form[$i]['form'] = array(
                'legend' => array(
                    'title' => $this->l('Shop association:'),
                ),
                'input' => array(
                    array(
                        'type' => 'shop',
                        'label' => $this->l('Shop association:'),
                        'name' => 'checkBoxShopAsso',
                    ),

                ),
            );
        }

        $this->multiple_fieldsets = true;

        return parent::renderForm();
    }

    public function postProcess()
    {
        if (Tools::getValue('id_simpleblog_post', 0) || Tools::getValue('submitAddsimpleblog_post', 0)) {
            if (Tools::getValue('id_product')) {
                $_POST['id_product'] = implode(Tools::getValue('id_product'), ',');
            } else {
                $_POST['id_product'] = '';
            }
        }

        if (Tools::isSubmit('viewsimpleblog_post')
            && ($id_simpleblog_post = (int) Tools::getValue('id_simpleblog_post'))
            && ($SimpleBlogPost = new SimpleBlogPost($id_simpleblog_post, $this->context->language->id))
            && Validate::isLoadedObject($SimpleBlogPost)) {
            Tools::redirectAdmin(Context::getContext()->link->getModuleLink('ph_simpleblog', 'single', array('rewrite' => $SimpleBlogPost->link_rewrite, 'sb_category' => $SimpleBlogPost->category_rewrite)));
        }

        if (Tools::isSubmit('deleteCover')) {
            SimpleBlogPost::deleteCover((int) Tools::getValue('id_simpleblog_post'));
            Tools::redirectAdmin(self::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminSimpleBlogPosts').'&conf=7&id_simpleblog_post='.(int) Tools::getValue('id_simpleblog_post').'&updatesimpleblog_post');
        }

        if (Tools::isSubmit('deleteFeatured')) {
            SimpleBlogPost::deleteFeatured((int) Tools::getValue('id_simpleblog_post'));
            Tools::redirectAdmin(self::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminSimpleBlogPosts').'&conf=7&id_simpleblog_post='.(int) Tools::getValue('id_simpleblog_post').'&updatesimpleblog_post');
        }

        if (Tools::isSubmit('is_featuredsimpleblog_post')) {
            $SimpleBlogPost = new SimpleBlogPost((int) Tools::getValue('id_simpleblog_post'));
            $SimpleBlogPost->is_featured = !$SimpleBlogPost->is_featured;
            $SimpleBlogPost->update();
            Tools::redirectAdmin(self::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminSimpleBlogPosts').'&conf=4');
        }

        return parent::postProcess();
    }

    public function handlePostImage($idPost, $type)
    {
        if (isset($_FILES[$type]) && (int) $_FILES[$type]['size'] > 0) {
            $extension = pathinfo($_FILES[$type]['name'], PATHINFO_EXTENSION);
            if (Db::getInstance()->update(
                'simpleblog_post',
                array(
                    $type => $extension
                ),
                'id_simpleblog_post = '.(int) $idPost
            )) {
                $this->handlePostImageUpload($type, $idPost, $_FILES[$type]['tmp_name'], $extension);
                return $extension;
            }
        }

        return false;
    }

    public function handlePostImageUpload($type, $idPost, $file, $extension = 'jpg')
    {
        $fileTmpLoc = $file;

        if ($type == 'cover') {
            $thumbX = Configuration::get('PH_BLOG_THUMB_X');
            $thumbY = Configuration::get('PH_BLOG_THUMB_Y');

            $thumb_wide_X = Configuration::get('PH_BLOG_THUMB_X_WIDE');
            $thumb_wide_Y = Configuration::get('PH_BLOG_THUMB_Y_WIDE');

            $thumbMethod = Configuration::get('PH_BLOG_THUMB_METHOD');

            $origPath = _PS_MODULE_DIR_.'ph_simpleblog/covers/'.$idPost.'.'.$extension;
            $pathAndName = _PS_MODULE_DIR_.'ph_simpleblog/covers/'.$idPost.'-thumb.'.$extension;
            $pathAndNameWide = _PS_MODULE_DIR_.'ph_simpleblog/covers/'.$idPost.'-wide.'.$extension;

            $tmp_location = _PS_TMP_IMG_DIR_.'ph_simpleblog_'.$idPost.'.'.$extension;
            if (file_exists($tmp_location)) {
                @unlink($tmp_location);
            }

            $tmp_location_list = _PS_TMP_IMG_DIR_.'ph_simpleblog_'.$idPost.'-list.'.$extension;
            if (file_exists($tmp_location_list)) {
                @unlink($tmp_location_list);
            }

            try {
                $orig = PhpThumbFactory::create($fileTmpLoc);
                $thumb = PhpThumbFactory::create($fileTmpLoc);
                $thumbWide = PhpThumbFactory::create($fileTmpLoc);
            } catch (Exception $e) {
                echo $e;
            }

            if ($thumbMethod == '1') {
                $thumb->adaptiveResize($thumbX, $thumbY);
                $thumbWide->adaptiveResize($thumb_wide_X, $thumb_wide_Y);
            } elseif ($thumbMethod == '2') {
                $thumb->cropFromCenter($thumbX, $thumbY);
                $thumbWide->cropFromCenter($thumb_wide_X, $thumb_wide_Y);
            }

            $orig->save($origPath);
            $thumb->save($pathAndName);
            $thumbWide->save($pathAndNameWide);
            ImageManager::thumbnail(
                _PS_MODULE_DIR_.'ph_simpleblog/covers/'.$idPost.'.'.$extension,
                'ph_simpleblog_'.$idPost.'.'.$extension,
                350,
                $extension,
                true,
                true
            );
        }

        if ($type == 'featured') {
            $origPath = _PS_MODULE_DIR_.'ph_simpleblog/featured/'.$idPost.'.'.$extension;

            try {
                $orig = PhpThumbFactory::create($fileTmpLoc);
            } catch (Exception $e) {
                echo $e;
            }

            try {
                $orig->save($origPath);
            } catch (Exception $e) {
                echo $e;
            }

            ImageManager::thumbnail(
                _PS_MODULE_DIR_.'ph_simpleblog/featured/'.$idPost.'.'.$extension,
                'ph_simpleblog_featured_'.$idPost.'.'.$extension,
                350,
                $extension,
                true,
                true
            );
        }
    }

    public function assignGroupsToPost()
    {
        $groups = Group::getGroups($this->context->language->id);
        $groupBox = Tools::getValue('groupBox', array());

        if (!$groupBox) {
            foreach ($groups as $group) {
                $access[$group['id_group']] = false;
            }
        } else {
            foreach ($groups as $group) {
                $access[$group['id_group']] = in_array($group['id_group'], $groupBox);
            }
        }

        $access = serialize($access);
        $_POST['access'] = $access;
    }

    public function processAdd()
    {
        $languages = Language::getLanguages(false);
        $this->assignGroupsToPost();

        $post = parent::processAdd();

        $post->cover = $this->handlePostImage($post->id, 'cover');
        $post->featured = $this->handlePostImage($post->id, 'featured');
        
        $this->updateTags($languages, $post);
        $this->updateAssoShop($post->id);

        $modulesForCache = array('phblogrecentposts');
        foreach ($modulesForCache as $module) {
            if (Module::isEnabled($module)) {
                $instance = Module::getInstanceByName($module);
                $instance->clearPostsCache();
            }
        }

        return $post;
    }

    public function processUpdate()
    {
        $languages = Language::getLanguages(false);
        $this->assignGroupsToPost();

        $idPost = (int) Tools::getValue('id_simpleblog_post');

        if ($cover = $this->handlePostImage($idPost, 'cover')) {
            $_POST['cover'] = $cover;
        }

        if ($featured = $this->handlePostImage($idPost, 'featured')) {
            $_POST['featured'] = $featured;
        }

        $post = parent::processUpdate();

        $this->updateTags($languages, $post);

        $modulesForCache = array('phblogrecentposts');
        foreach ($modulesForCache as $module) {
            if (Module::isEnabled($module)) {
                $instance = Module::getInstanceByName($module);
                $instance->clearPostsCache();
            }
        }

        return $post;
    }

    public function updateTags($languages, $post)
    {
        $tag_success = true;
        foreach ($languages as $language) {
            if ($value = Tools::getValue('tags_'.$language['id_lang'])) {
                if (!Validate::isTagsList($value)) {
                    $this->errors[] = sprintf(
                        Tools::displayError('The tags list (%s) is invalid.'),
                        $language['name']
                    );
                }
            }
        }

        if (!SimpleBlogTag::deleteTagsForPost((int) $post->id)) {
            $this->errors[] = Tools::displayError('An error occurred while attempting to delete previous tags.');
        }

        foreach ($languages as $language) {
            if ($value = Tools::getValue('tags_'.$language['id_lang'])) {
                $tag_success &= SimpleBlogTag::addTags($language['id_lang'], (int) $post->id, $value);
            }
        }

        if (!$tag_success) {
            $this->errors[] = Tools::displayError('An error occurred while adding tags.');
        }
    }

    public function ajaxProcessAddPostImages()
    {
        $image_dir = _SIMPLEBLOG_GALLERY_DIR_;

        $image_uploader = new HelperImageUploader('file');
        $image_uploader->setAcceptTypes(array('jpeg', 'gif', 'png', 'jpg'));
        $files = $image_uploader->process();

        foreach ($files as &$file) {
            $SimpleBlogPostImage = new SimpleBlogPostImage();
            $SimpleBlogPostImage->id_simpleblog_post = (int) Tools::getValue('id_simpleblog_post');
            $SimpleBlogPostImage->position = SimpleBlogPostImage::getNewLastPosition((int) Tools::getValue('id_simpleblog_post'));
            $SimpleBlogPostImage->add();

            $filenameParts = explode('.', $file['name']);

            $destFiles = array(
                'original' => $image_dir.$SimpleBlogPostImage->id.'-'.$SimpleBlogPostImage->id_simpleblog_post.'-'.Tools::link_rewrite($filenameParts[0]).'.jpg',
                'thumbnail' => $image_dir.$SimpleBlogPostImage->id.'-'.$SimpleBlogPostImage->id_simpleblog_post.'-'.Tools::link_rewrite($filenameParts[0]).'-thumb.jpg',
                'square' => $image_dir.$SimpleBlogPostImage->id.'-'.$SimpleBlogPostImage->id_simpleblog_post.'-'.Tools::link_rewrite($filenameParts[0]).'-square.jpg',
                'wide' => $image_dir.$SimpleBlogPostImage->id.'-'.$SimpleBlogPostImage->id_simpleblog_post.'-'.Tools::link_rewrite($filenameParts[0]).'-wide.jpg',
            );

            if (!ImageManager::resize($file['save_path'], $destFiles['original'], null, null, 'jpg', false, $error)) {
                switch ($error) {
                    case ImageManager::ERROR_FILE_NOT_EXIST:
                        $file['error'] = Tools::displayError('An error occurred while copying image, the file does not exist anymore.');
                        $SimpleBlogPostImage->delete();
                        break;

                    case ImageManager::ERROR_FILE_WIDTH:
                        $file['error'] = Tools::displayError('An error occurred while copying image, the file width is 0px.');
                        $SimpleBlogPostImage->delete();
                        break;

                    case ImageManager::ERROR_MEMORY_LIMIT:
                        $file['error'] = Tools::displayError('An error occurred while copying image, check your memory limit.');
                        $SimpleBlogPostImage->delete();
                        break;

                    default:
                        $file['error'] = Tools::displayError('An error occurred while copying image.');
                        $SimpleBlogPostImage->delete();
                        break;
                }
                continue;
            } else {
                $SimpleBlogPostImage->image = $SimpleBlogPostImage->id.'-'.$SimpleBlogPostImage->id_simpleblog_post.'-'.Tools::link_rewrite($filenameParts[0]);
                $SimpleBlogPostImage->update();

                $thumbX = Configuration::get('PH_BLOG_THUMB_X');
                $thumbY = Configuration::get('PH_BLOG_THUMB_Y');

                $thumb_wide_X = Configuration::get('PH_BLOG_THUMB_X_WIDE');
                $thumb_wide_Y = Configuration::get('PH_BLOG_THUMB_Y_WIDE');

                $thumbMethod = Configuration::get('PH_BLOG_THUMB_METHOD');

                try {
                    $orig = PhpThumbFactory::create($destFiles['original']);
                    $thumb = PhpThumbFactory::create($destFiles['original']);
                    $square = PhpThumbFactory::create($destFiles['original']);
                    $wide = PhpThumbFactory::create($destFiles['original']);
                } catch (Exception $e) {
                    echo $e;
                }

                if ($thumbMethod == '1') {
                    $thumb->adaptiveResize($thumbX, $thumbY);
                    $square->adaptiveResize(800, 800);
                    $wide->adaptiveResize($thumb_wide_X, $thumb_wide_Y);
                } elseif ($thumbMethod == '2') {
                    $thumb->cropFromCenter($thumbX, $thumbY);
                    $square->cropFromCenter(800, 800);
                    $wide->cropFromCenter($thumb_wide_X, $thumb_wide_Y);
                }

                $orig->save($destFiles['original']);
                $thumb->save($destFiles['thumbnail']);
                $square->save($destFiles['square']);
                $wide->save($destFiles['wide']);

                unlink($file['save_path']);
                unset($file['save_path']);

                $file['status'] = 'ok';
                $file['name'] = $SimpleBlogPostImage->id.'-'.$SimpleBlogPostImage->id_simpleblog_post.'-'.Tools::link_rewrite($filenameParts[0]);
                $file['id'] = $SimpleBlogPostImage->id;
                $file['position'] = $SimpleBlogPostImage->position;
                $file['path'] = $image_dir;
            }
        }

        die(Tools::jsonEncode(array($image_uploader->getName() => $files)));
    }

    public function ajaxProcessUpdateImagePosition()
    {
        $response = false;
        if ($json = Tools::getValue('json')) {
            $response = true;
            $json = stripslashes($json);
            $images = Tools::jsonDecode($json, true);
            foreach ($images as $id_simpleblog_post_image => $position) {
                $SimpleBlogPostImage = new SimpleBlogPostImage((int) $id_simpleblog_post_image);
                $SimpleBlogPostImage->position = (int) $position;
                $response &= $SimpleBlogPostImage->update();
            }
        }
        if ($response) {
            $this->jsonConfirmation($this->_conf[25]);
        } else {
            $this->jsonError(Tools::displayError('An error occurred while attempting to move this picture.'));
        }
    }

    public function ajaxProcessDeletePostImage()
    {
        $response = true;

        $SimpleBlogPostImage = new SimpleBlogPostImage((int) Tools::getValue('id_simpleblog_post_image'));
        $response &= $SimpleBlogPostImage->delete();

        if ($response) {
            die(Tools::jsonEncode(
                array(
                    'status' => 'ok',
                    'id' => $SimpleBlogPostImage->id_simpleblog_post_image,
                    'confirmations' => array($this->_conf[7]),
                )
            ));
        } else {
            $this->jsonError(Tools::displayError('An error occurred while attempting to delete the product image.'));
        }
    }

    public static function getSimpleProducts($id_lang, $products = false)
    {
        $context = Context::getContext();

        $front = true;
        if (!in_array($context->controller->controller_type, array('front', 'modulefront'))) {
            $front = false;
        }

        $sql = 'SELECT p.`id_product`, pl.`name`, p.`reference`, CONCAT(pl.`name`, \' REF: \', p.reference) product_name
                FROM `'._DB_PREFIX_.'product` p
                '.Shop::addSqlAssociation('product', 'p').'
                LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` '.Shop::addSqlRestrictionOnLang('pl').')
                WHERE pl.`id_lang` = '.(int) $id_lang.'
                '.($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '');

        if ($products) {
            $sql .= ' AND pl.`id_product` IN('.$products.') ';
        }

        $sql .= 'ORDER BY pl.`name`';

        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
    }

    public function ajaxProcessSearchProducts()
    {
        $context = Context::getContext();

        $id_lang = $context->language->id;

        $sql = 'SELECT p.`id_product`, pl.`link_rewrite`, pl.`name`, p.`reference`, CONCAT(pl.`name`, \' REF: \', p.reference) product_name
                FROM `'._DB_PREFIX_.'product` p
                '.Shop::addSqlAssociation('product', 'p').'
                LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` '.Shop::addSqlRestrictionOnLang('pl').')
                WHERE pl.`id_lang` = '.(int) $id_lang.' AND pl.`name` LIKE \'%'.pSQL(Tools::getValue('q')).'%\'
                OR pl.`id_lang` = '.(int) $id_lang.' AND p.`reference` LIKE \'%'.pSQL(Tools::getValue('q')).'%\'
                ORDER BY pl.`name`';

        $results = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

        if ($results) {
            foreach ($results as &$result) {
                $result['text'] = $result['product_name'];
                $result['id'] = $result['id_product'];

                $cover = Product::getCover($result['id_product']);
                if ($cover) {
                    $result['image'] = $context->link->getImageLink($result['link_rewrite'], $cover['id_image'], ImageType::getFormatedName('small'));
                }
            }
            die(Tools::jsonEncode($results));
        } else {
            $this->jsonError(Tools::displayError('Nothing found.'));
        }
    }
}

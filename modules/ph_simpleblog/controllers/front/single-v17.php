<?php
/**
 * Blog for PrestaShop module by Krystian Podemski from PrestaHome.
 *
 * @author    Krystian Podemski <krystian@prestahome.com>
 * @copyright Copyright (c) 2008-2019 Krystian Podemski - www.PrestaHome.com / www.Podemski.info
 * @license   You only can use module, nothing more!
 */

use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Core\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;

class PH_SimpleBlogSingleModuleFrontController extends ModuleFrontController
{
    protected $SimpleBlogPost;
    protected $previousPost = false;
    protected $nextPost = false;


    public function init()
    {
        parent::init();

        $this->php_self = 'module-ph_simpleblog-single';

        // Get Post by link_rewrite
        $simpleblog_post_rewrite = Tools::getValue('rewrite');

        if ($simpleblog_post_rewrite && Validate::isLinkRewrite($simpleblog_post_rewrite)) {
            $this->simpleblog_post_rewrite = $simpleblog_post_rewrite;
        } else {
            die('Blog for PrestaShop: URL is not valid');
        }

        $SimpleBlogPost = SimpleBlogPost::getByRewrite($this->simpleblog_post_rewrite, (int) Context::getContext()->language->id);

        // Check for matching current url with post url informations
        if (!Validate::isLoadedObject($SimpleBlogPost) || Validate::isLoadedObject($SimpleBlogPost) && !$SimpleBlogPost->active) {
            Tools::redirect('index.php?controller=404');
        }
        
        if (Validate::isLoadedObject($SimpleBlogPost)
            && $this->simpleblog_post_rewrite != $SimpleBlogPost->link_rewrite
            ||
            Tools::getValue('sb_category') != $SimpleBlogPost->category_rewrite) {
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: '.SimpleBlogPost::getLink($SimpleBlogPost->link_rewrite, $SimpleBlogPost->category_rewrite));
        }

        // There you go, our blog post
        $this->SimpleBlogPost = $SimpleBlogPost;

        $this->previousPost = $this->SimpleBlogPost->getPreviousPost();
        $this->nextPost     = $this->SimpleBlogPost->getNextPost();

        // Check access to post
        if (!$this->SimpleBlogPost->isAccessGranted()) {
            Tools::redirect('index.php?controller=404');
        }

        // Assign meta tags
        $this->assignMetas();
    }

    public function checkForSmartShortcodeAddons()
    {
        $context = Context::getContext();
        $dir = _PS_MODULE_DIR_.'smartshortcode/addons';

        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if ($file != '.' && $file != '..') {
                        if (is_dir("{$dir}/{$file}/front")) {
                            include_once "{$dir}/{$file}/front/shortcode.php";
                        }
                    }
                }
                closedir($dh);
            }
        }
    }

    public function initContent()
    {
        // Assign JS and CSS for single post page
        $this->addModulePageAssets();
        
        parent::initContent();

        // Increase post views
        $this->SimpleBlogPost->increaseViewsNb();

        // Support for SmartShortcode module from CodeCanyon
        $this->supportThirdPartyPlugins();

        // Smarty variables
        $this->context->smarty->assign('is_16', true);
        $this->context->smarty->assign('post', $this->SimpleBlogPost);
        $this->context->smarty->assign('guest', (int) $this->context->cookie->id_guest);
        $this->context->smarty->assign('gallery_dir', _MODULE_DIR_.'ph_simpleblog/galleries/');
        $this->context->smarty->assign('previousPost', $this->previousPost);
        $this->context->smarty->assign('nextPost', $this->nextPost);
        $this->context->smarty->assign('jsonld', $this->SimpleBlogPost->renderJsonLd());

        Media::addJsDef(
            array(
                'ph_simpleblog_ajax'    => $this->context->link->getModuleLink('ph_simpleblog', 'ajax'),
                'ph_simpleblog_token'   => $this->module->secure_key,
            )
        );

        // Comments
        $this->prepareCommentsSection();

        // Related products
        if (Configuration::get('PH_BLOG_DISPLAY_RELATED')) {
            $related_products = $this->getRelatedProducts();
            $this->context->smarty->assign('related_products', $related_products);
        }

        $this->setTemplate('module:ph_simpleblog/views/templates/front/1.7/single.tpl');
    }

    public function getRelatedProducts()
    {
        $products = SimpleBlogPost::getRelatedProducts($this->SimpleBlogPost->id_product);

        $productsArray = array();
        if ($products) {
            $assembler = new ProductAssembler($this->context);

            $presenterFactory = new ProductPresenterFactory($this->context);
            $presentationSettings = $presenterFactory->getPresentationSettings();
            $presenter = new ProductListingPresenter(
                new ImageRetriever(
                    $this->context->link
                ),
                $this->context->link,
                new PriceFormatter(),
                new ProductColorsRetriever(),
                $this->context->getTranslator()
            );
            foreach ($products as $rawProduct) {
                $productInfo = $assembler->assembleProduct($rawProduct);
                if ($productInfo) {
                    $productsArray[] = $presenter->present(
                        $presentationSettings,
                        $productInfo,
                        $this->context->language
                    );
                }
            }
        }

        return $productsArray;
    }

    public function getBreadcrumbLinks()
    {
        $breadcrumb = parent::getBreadcrumbLinks();

        $id_lang = Context::getContext()->language->id;
        $SimpleBlogPost = SimpleBlogPost::getByRewrite($this->simpleblog_post_rewrite, $id_lang);

        $breadcrumb['links'][] = [
                'title' => $this->l('Blog'),
                'url' => $this->context->link->getModuleLink('ph_simpleblog', 'list')
        ];

        $breadcrumb['links'][] = [
            'title' => $SimpleBlogPost->category,
            'url' => $SimpleBlogPost->category_url
        ];

        $breadcrumb['links'][] = [
            'title' => $SimpleBlogPost->title,
            'url' => $SimpleBlogPost->url
        ];
        return $breadcrumb;
    }


    public function postProcess()
    {
        $errors = array();
        $confirmation = '1';

        if (Tools::isSubmit('submitNewComment') && Tools::getValue('id_simpleblog_post')) {
            if (Configuration::get('PH_BLOG_COMMENT_ALLOW_GUEST') && Configuration::get('PH_BLOG_COMMENTS_RECAPTCHA')) {
                if (!class_exists('ReCaptcha') && file_exists(_PS_MODULE_DIR_ . 'ph_simpleblog/assets/recaptchalib.php')) {
                    require_once(_PS_MODULE_DIR_ . 'ph_simpleblog/assets/recaptchalib.php');
                }

                $secret = Configuration::get('PH_BLOG_COMMENTS_RECAPTCHA_SECRET_KEY');
                $response = null;

                if (!class_exists('ReCaptcha')) {
                    die('Sorry, you want to use reCAPTCHA but class to handle this doesn\'t exists');
                }

                $reCaptcha = new ReCaptcha($secret);

                if (Tools::getValue('g-recaptcha-response')) {
                    $response = $reCaptcha->verifyResponse(
                        $_SERVER["REMOTE_ADDR"],
                        Tools::getValue('g-recaptcha-response')
                    );
                }

                if ($response == null) {
                    $errors[] = $this->module->l('Please provide valid reCAPTCHA value', 'single-v17');
                }
            }

            if (Tools::getValue('comment_content') && Validate::isGenericName(Tools::getValue('comment_content'))) {
                $comment_content = Tools::getValue('comment_content');
            } else {
                $errors[] = $this->module->l('Please write something and remember that HTML is not allowed in comment content.', 'single-v17');
            }

            $customer_name = Tools::getValue('customer_name');

            if (!Validate::isGenericName($customer_name)) {
                $errors[] = $this->module->l('Please provide valid name', 'single-v17');
            }

            if (!Validate::isInt(Tools::getValue('id_parent'))) {
                die('FATAL ERROR [2]');
            } else {
                $id_parent = Tools::getValue('id_parent');
            }

            $ip_address = Tools::getRemoteAddr();

            if (sizeof($errors)) {
                $this->errors = $errors;
            } else {
                $comment = new SimpleBlogComment();
                $comment->id_simpleblog_post = (int)Tools::getValue('id_simpleblog_post');
                $comment->id_parent = $id_parent;
                $comment->id_customer = (int)$this->context->customer->id ? (int)$this->context->customer->id : 0;
                $comment->id_guest = (int)$this->context->customer->id_guest ? (int)$this->context->customer->id_guest : 0;
                $comment->name = $customer_name;
                $comment->email = isset($this->context->customer->email) ? $this->context->customer->email : null;
                $comment->comment = $comment_content;
                $comment->active = Configuration::get('PH_BLOG_COMMENT_AUTO_APPROVAL') ? 1 : 0;
                $comment->ip = Tools::getRemoteAddr();
                
                if ($comment->add()) {
                    if (!Configuration::get('PH_BLOG_COMMENT_AUTO_APPROVAL')) {
                        $confirmation = $this->l('Your comment was sucessfully added but it will be visible after moderator approval.', 'single-v17');
                    } else {
                        $confirmation = $this->l('Your comment was sucessfully added.', 'single-v17');
                    }

                    $link = $this->context->link->getModuleLink('ph_simpleblog', 'single', array('rewrite' => $this->SimpleBlogPost->link_rewrite, 'sb_category' => $this->SimpleBlogPost->category_rewrite));

                    if (Configuration::get('PH_BLOG_COMMENT_NOTIFICATIONS')) {
                        $toName = strval(Configuration::get('PS_SHOP_NAME'));
                        $fromName = strval(Configuration::get('PS_SHOP_NAME'));
                        $to = Configuration::get('PH_BLOG_COMMENT_NOTIFY_EMAIL');
                        $from = Configuration::get('PS_SHOP_EMAIL');
                        $customer = $this->context->customer;

                        if ($this->context->customer->isLogged()) {
                            $lastname = $this->context->customer->lastname;
                            $firstname = $this->context->customer->firstname;
                        } else {
                            $lastname = '';
                            $firstname = $customer_name;
                        }

                        Mail::Send(
                            $this->context->language->id,
                            'new_comment',
                            sprintf($this->l('New comment on %1$s blog for article: %2$s', 'single-v17'), $toName, $this->SimpleBlogPost->title),
                            array(
                                '{lastname}' => $customer->lastname,
                                '{firstname}' => $customer->firstname,
                                '{post_title}' => $this->SimpleBlogPost->title,
                                '{post_link}' => $this->SimpleBlogPost->url,
                                '{comment_content}' => $comment_content,
                            ),
                            $to,
                            $toName,
                            $from,
                            $fromName,
                            null,
                            null,
                            _PS_MODULE_DIR_.'ph_simpleblog/mails/'
                        );
                    }

                    $this->success[] = $confirmation;

                    $this->redirectWithNotifications($link);
                } else {
                    $this->errors = $this->module->l('Something went wrong! Comment can not be added!', 'single-v17');
                }
            }
        }
        return parent::postProcess();
    }

    /**
     * Assign meta tags to single post page.
     */
    protected function assignMetas()
    {
        if (!empty($this->SimpleBlogPost->meta_title)) {
            $this->context->smarty->assign('meta_title', $this->SimpleBlogPost->meta_title);
        } else {
            $this->context->smarty->assign('meta_title', $this->SimpleBlogPost->title);
        }

        if (!empty($this->SimpleBlogPost->meta_description)) {
            $this->context->smarty->assign('meta_description', $this->SimpleBlogPost->meta_description);
        }

        if (!empty($this->SimpleBlogPost->meta_keywords)) {
            $this->context->smarty->assign('meta_keywords', $this->SimpleBlogPost->meta_keywords);
        }
    }

    /**
     * Prepare comments section, check for access to add comments etc.
     */
    protected function prepareCommentsSection()
    {
        $this->context->smarty->assign('allow_comments', $this->SimpleBlogPost->allowComments());

        if ($this->SimpleBlogPost->allowComments() == true) {
            $comments = SimpleBlogComment::getComments($this->SimpleBlogPost->id_simpleblog_post);
            $this->context->smarty->assign('comments', $comments);
        }
    }

    /**
     * CSS, JS and other assets for this page.
     */
    protected function addModulePageAssets()
    {
        $this->context->controller->addJqueryPlugin('cooki-plugin');
        $this->context->controller->addJqueryPlugin('cookie-plugin');
        $this->context->controller->addjqueryPlugin('fancybox');

        $this->context->controller->addCSS(array(
            _THEME_CSS_DIR_.'category.css' => 'all',
            _THEME_CSS_DIR_.'product_list.css' => 'all',
        ));
    }

    /**
     * This method check for existing other third party plugins in store
     * and if such a plugins exists we are preparing them to use.
     */
    protected function supportThirdPartyPlugins()
    {

    }

    /**
     * Return SimpleBlogPost object
     * @return object
     */
    public function getPost()
    {
        return $this->SimpleBlogPost;
    }
}

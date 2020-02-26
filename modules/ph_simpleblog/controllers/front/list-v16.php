<?php
/**
 * Blog for PrestaShop module by Krystian Podemski from PrestaHome.
 *
 * @author    Krystian Podemski <krystian@prestahome.com>
 * @copyright Copyright (c) 2008-2019 Krystian Podemski - www.PrestaHome.com / www.Podemski.info
 * @license   You only can use module, nothing more!
 */

class PH_SimpleBlogListModuleFrontController extends ModuleFrontController
{
    public $context;
    public $sb_category = false;
    public $simpleblog_search;
    public $simpleblog_keyword;
    public $is_search = false;
    public $is_category = false;

    public $posts_per_page;
    public $n;
    public $p;

    private $blogCategory;

    private $listController;

    public function init()
    {
        parent::init();

        $sb_category = Tools::getValue('sb_category');
        $simpleblog_search = Tools::getValue('simpleblog_search');
        $simpleblog_keyword = Tools::getValue('simpleblog_keyword');
        $this->listController = Tools::getValue('controller');

        if ($sb_category) {
            $this->sb_category = $sb_category;
            $this->is_category = true;
        }

        if ($this->listController == 'category' && !$this->sb_category) {
            Tools::redirect($this->context->link->getModuleLink('ph_simpleblog', 'list'));
        }

        if ($simpleblog_search && $simpleblog_keyword) {
            $this->simpleblog_search = $simpleblog_search;
            $this->simpleblog_keyword = $simpleblog_keyword;
            $this->is_search = true;
        }

        $this->posts_per_page = Configuration::get('PH_BLOG_POSTS_PER_PAGE');
        $this->p = (int) Tools::getValue('p', 0);

        $this->context = Context::getContext();
    }

    public function assignGeneralPurposesVariables()
    {
        $gridType = Configuration::get('PH_BLOG_COLUMNS');
        $gridColumns = Configuration::get('PH_BLOG_GRID_COLUMNS');
        $blogLayout = Configuration::get('PH_BLOG_LIST_LAYOUT');

        $this->context->smarty->assign(array(
            'categories' => SimpleBlogCategory::getCategories((int) $this->context->language->id),
            'blogMainTitle' => Configuration::get('PH_BLOG_MAIN_TITLE', (int) $this->context->language->id),
            'grid' => Configuration::get('PH_BLOG_COLUMNS'),
            'columns' => $gridColumns,
            'blogLayout' => $blogLayout,
            'module_dir' => _MODULE_DIR_.'ph_simpleblog/',
            'tpl_path' => _PS_MODULE_DIR_.'ph_simpleblog/views/templates/front/',
            'gallery_dir' => _MODULE_DIR_.'ph_simpleblog/galleries/',
            'is_category' => false,
            'is_search' => false,
            'shopLogo' => $this->context->link->getMediaLink(_PS_IMG_.Configuration::get('PS_LOGO')),
            'shopUrl' => $this->context->shop->getBaseURL(true, false),
        ));
    }

    public function initContent()
    {
        $id_lang = $this->context->language->id;

        parent::initContent();

        $this->context->smarty->assign('is_16', (bool) (version_compare(_PS_VERSION_, '1.6.0', '>=') === true));

        $this->assignGeneralPurposesVariables();

        // Category things
        if ($this->sb_category != '') {
            $this->context->smarty->assign('is_category', true);

            $SimpleBlogCategory = SimpleBlogCategory::getByRewrite($this->sb_category, $id_lang);

            // Category not found so now we are looking for categories in same rewrite but other languages and if we found something, then we redirect 301
            if (!Validate::isLoadedObject($SimpleBlogCategory)) {
                $SimpleBlogCategory = SimpleBlogCategory::getByRewrite($this->sb_category, false);

                if (Validate::isLoadedObject($SimpleBlogCategory)) {
                    $SimpleBlogCategory = new SimpleBlogCategory($SimpleBlogCategory->id, $id_lang);
                    header('HTTP/1.1 301 Moved Permanently');
                    header('Location: '.SimpleBlogCategory::getLink($SimpleBlogCategory->link_rewrite));
                } else {
                    header('HTTP/1.1 404 Not Found');
                    header('Status: 404 Not Found');
                    Tools::redirect($this->context->link->getPageLink('404'));
                }
            }

            $this->blogCategory = $SimpleBlogCategory;

            if ($SimpleBlogCategory->id_parent > 0) {
                $parent = new SimpleBlogCategory($SimpleBlogCategory->id_parent, $id_lang);
                $this->context->smarty->assign('parent_category', $parent);
            }

            $finder = new BlogPostsFinder();
            $finder->setIdCategory($SimpleBlogCategory->id);
            $posts = $finder->findPosts();

            $this->context->smarty->assign('blogCategory', $SimpleBlogCategory);
            $this->context->smarty->assign('category_rewrite', $SimpleBlogCategory->link_rewrite);
        } else {
            $finder = new BlogPostsFinder();
            $posts = $finder->findPosts();
        }

        $this->assignPagination($this->posts_per_page, sizeof($posts));
        $posts = array_splice($posts, $this->p ? ($this->p - 1) * $this->posts_per_page : 0, $this->posts_per_page);

        $this->assignMetas();

        $this->context->smarty->assign('posts', $posts);

        if (version_compare(_PS_VERSION_, '1.7', '>=')) {
            $this->setTemplate('module:ph_simpleblog/views/templates/front/1.7/list.tpl');
        } else {
            $this->setTemplate('list.tpl');
        }
    }

    public function assignMetas()
    {
        $defaultMetaTitleForBlog = Configuration::get('PH_BLOG_MAIN_TITLE', $this->context->language->id);
        $defaultMetaDescriptionForBlog = Configuration::get('PH_BLOG_MAIN_META_DESCRIPTION', $this->context->language->id);

        if ($this->sb_category) {
            $meta_title = $this->blogCategory->name.' - '.Configuration::get('PS_SHOP_NAME');
        } else {
            if (empty($defaultMetaTitleForBlog)) {
                $meta_title = Configuration::get('PS_SHOP_NAME').' - '.$this->module->l('Blog', 'list-v16');
            } else {
                $meta_title = $defaultMetaTitleForBlog;
            }
        }

        if ($this->sb_category) {
            if (!empty($this->blogCategory->meta_description)) {
                $meta_description = $this->blogCategory->meta_description;
            }
        }

        if ($this->p > 1) {
            $meta_title .= ' ('.$this->p.')';
        }

        $this->context->smarty->assign('meta_title', $meta_title);

        if (!empty($meta_description)) {
            $this->context->smarty->assign('meta_description', strip_tags($meta_description));
        }
    }

    public function assignPagination($limit, $nbPosts)
    {
        $this->n = $limit;
        $this->p = abs((int) Tools::getValue('p', 1));

        $current_url = tools::htmlentitiesUTF8($_SERVER['REQUEST_URI']);
        //delete parameter page
        $current_url = preg_replace('/(\?)?(&amp;)?p=\d+/', '$1', $current_url);

        $range = 2; /* how many pages around page selected */

        if ($this->p < 1) {
            $this->p = 1;
        }

        $pages_nb = ceil($nbPosts / (int) $this->n);

        $start = (int) ($this->p - $range);

        if ($start < 1) {
            $start = 1;
        }
        $stop = (int) ($this->p + $range);

        if ($stop > $pages_nb) {
            $stop = (int) $pages_nb;
        }
        $this->context->smarty->assign('nb_posts', $nbPosts);
        $pagination_infos = array(
            'products_per_page' => $limit,
            'pages_nb' => $pages_nb,
            'p' => $this->p,
            'n' => $this->n,
            'range' => $range,
            'start' => $start,
            'stop' => $stop,
            'current_url' => $current_url,
        );
        $this->context->smarty->assign($pagination_infos);
    }

    public function getBlogCategory()
    {
        return $this->blogCategory;
    }
}

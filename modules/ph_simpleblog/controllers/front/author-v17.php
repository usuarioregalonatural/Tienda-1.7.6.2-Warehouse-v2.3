<?php
/**
 * Blog for PrestaShop module by Krystian Podemski from PrestaHome.
 *
 * @author    Krystian Podemski <krystian@prestahome.com>
 * @copyright Copyright (c) 2008-2019 Krystian Podemski - www.PrestaHome.com / www.Podemski.info
 * @license   You only can use module, nothing more!
 */

class PH_SimpleBlogAuthorModuleFrontController extends ModuleFrontController
{
    protected $SimpleBlogAuthor;

    public function init()
    {
        parent::init();

        // Get Post by link_rewrite
        $id_simpleblog_author = Tools::getValue('author_id');


        if ($id_simpleblog_author && Validate::isUnsignedInt($id_simpleblog_author)) {
            $author = new SimpleBlogPostAuthor($id_simpleblog_author, (int) Context::getContext()->language->id);
            if (!Validate::isLoadedObject($author)) {
                Tools::redirect('index.php?controller=404');
            } else {
                $this->SimpleBlogAuthor = $author;
            }
        } else {
            die('Blog for PrestaShop: URL is not valid');
        }

        
        // Assign meta tags
        $this->assignMetas();
    }

    public function initContent()
    {
        // Assign JS and CSS for single post page
        $this->addModulePageAssets();
        
        parent::initContent();

        // Smarty variables
        $this->context->smarty->assign('is_16', true);
        $this->context->smarty->assign('author', $this->SimpleBlogAuthor);

        $this->setTemplate('author.tpl');
    }

    /**
     * Assign meta tags to single post page.
     */
    protected function assignMetas()
    {
        $this->context->smarty->assign('meta_title', sprintf($this->module->l('Posts by %s', 'author-v16'), $this->SimpleBlogAuthor->firstname));
    }

    /**
     * CSS, JS and other assets for this page.
     */
    protected function addModulePageAssets()
    {

    }

    /**
     * Return SimpleBlogPost object
     * @return object
     */
    public function getAuthor()
    {
        return $this->SimpleBlogAuthor;
    }
}

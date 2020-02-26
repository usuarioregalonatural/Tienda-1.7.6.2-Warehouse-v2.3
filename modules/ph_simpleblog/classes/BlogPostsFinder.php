<?php
/**
 * Blog for PrestaShop module by Krystian Podemski from PrestaHome.
 *
 * @author    Krystian Podemski <krystian@prestahome.com>
 * @copyright Copyright (c) 2008-2019 Krystian Podemski - www.PrestaHome.com / www.Podemski.info
 * @license   You only can use module, nothing more!
 */

class BlogPostsFinder
{
    private $id_shop;
    private $id_lang;
    private $tablePrefix = 'sbp.';
    private $customer;
    private $id_simpleblog_category = 0;
    private $onlyActive = true;
    private $ignoredPosts = array();
    private $selectedPosts = array();
    private $featured = false;
    private $author = null;
    private $orderBy = 'sbp.date_add';
    private $orderWay = 'DESC';
    private $onlyPublished = true;
    private $checkForAccess = true;
    private $postType = false;
    private $limit = null;
    private $simpleResults = false;
    private $customWhere = false;

    public function __construct(Context $context = null)
    {
        if (!$context) {
            $context = Context::getContext();
        }

        if ($context) {
            $this->id_shop = $context->shop->id;
            $this->id_lang = $context->language->id;
            $this->customer = $context->customer;
        }
    }

    public function getTablePrefix()
    {
        return $this->tablePrefix;
    }

    public function setSimpleResults($value)
    {
        $this->simpleResults = $value;
        return $this;
    }

    public function onlySimpleResults()
    {
        return $this->simpleResults;
    }

    public function setPostType($type)
    {
        $this->postType = $type;
        return $this;
    }

    public function getPostType()
    {
        return $this->postType;
    }

    public function setCheckForAccess($value)
    {
        $this->checkForAccess = $value;
        return $this;
    }

    public function getCheckForAccess()
    {
        return $this->checkForAccess;
    }

    public function setOnlyPublished($value)
    {
        $this->onlyPublished = $value;
        return $this;
    }

    public function getOnlyPublished()
    {
        return $this->onlyPublished;
    }

    public function setOnlyActive($value)
    {
        $this->onlyActive = $value;
        return $this;
    }

    public function getOnlyActive()
    {
        return (bool) $this->onlyActive;
    }

    public function setIdShop($id_shop)
    {
        $this->id_shop = $id_shop;
        return $this;
    }

    public function getIdShop()
    {
        return (int) $this->id_shop;
    }

    public function setIdLang($id_lang)
    {
        $this->id_lang = $id_lang;
        return $this;
    }

    public function getIdLang()
    {
        return (int) $this->id_lang;
    }

    public function setCustomer($id_customer)
    {
        $this->customer = $customer;
        return $this;
    }

    public function getCustomer()
    {
        return $this->customer;
    }

    public function setIdCategory($id_simpleblog_category)
    {
        $this->id_simpleblog_category = $id_simpleblog_category;
        return $this;
    }

    public function getIdCategory()
    {
        return (int) $this->id_simpleblog_category;
    }

    public function setIgnoredPosts($ids)
    {
        if (!is_array($ids)) {
            return;
        }

        $this->ignoredPosts = $ids;
        return $this;
    }

    public function getIgnoredPosts()
    {
        return $this->ignoredPosts;
    }

    public function setSelectedPosts($ids)
    {
        if (!is_array($ids)) {
            return;
        }

        $this->selectedPosts = $ids;
        return $this;
    }

    public function getSelectedPosts()
    {
        return $this->selectedPosts;
    }

    public function setFeatured($value)
    {
        $this->featured = (bool) $value;
        return $this;
    }

    public function getFeatured()
    {
        return $this->featured;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setOrderBy($field)
    {
        $this->orderBy = $field;
        return $this;
    }

    public function getOrderBy()
    {
        return $this->orderBy;
    }

    public function setOrderWay($way)
    {
        $this->orderWay = $way;
        return $this;
    }

    public function getOrderWay()
    {
        return $this->orderWay;
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function setCustomWhere($conditions)
    {
        $this->customWhere = $conditions;
        return $this;
    }

    public function getCustomWhere()
    {
        return $this->customWhere;
    }

    /**
     * Return posts from Finder
     * @return array Posts
     */
    public function findPosts()
    {
        $sql = new DbQuery();
        $sql->select('*');
        $sql->from('simpleblog_post', 'sbp');

        $sql->innerJoin('simpleblog_post_lang', 'l', 'sbp.id_simpleblog_post = l.id_simpleblog_post AND l.id_lang = '.$this->getIdLang());

        $sql->innerJoin('simpleblog_post_shop', 'sbps', 'sbp.id_simpleblog_post = sbps.id_simpleblog_post AND sbps.id_shop = '.$this->getIdShop());

        if ($this->getOnlyActive()) {
            $sql->where('sbp.active = 1');
        }

        if ($this->getIdCategory() > 0) {
            $childrens = SimpleBlogCategory::getChildrens($this->getIdCategory());
            if ($childrens && sizeof($childrens)) {
                $child_categories = array($this->getIdCategory());
                foreach ($childrens as $child) {
                    $child_categories[] = $child['id_simpleblog_category'];
                }
                $sql->where('sbp.id_simpleblog_category IN ('.implode(',', $child_categories).')');
            } else {
                $sql->where('sbp.id_simpleblog_category = '.$this->getIdCategory());
            }
        }

        if (count($this->getIgnoredPosts())) {
            $sql->where('sbp.id_simpleblog_post NOT IN ('.implode(',', $this->getIgnoredPosts()).')');
        }

        if (count($this->getSelectedPosts())) {
            $sql->where('sbp.id_simpleblog_post IN ('.implode(',', $this->getSelectedPosts()).')');
        }

        if ($this->getFeatured()) {
            $sql->where('sbp.is_featured = 1');
        }

        if ($this->getPostType()) {
            $sql->where('sbp.id_simpleblog_post_type = '.(int) $this->getPostType());
        }

        if ($this->getAuthor()) {
            if ($this->getAuthor() == 'list') {
                $sql->where('sbp.id_simpleblog_author > 0');
            } else {
                $sql->where('sbp.id_simpleblog_author = '.(int) $this->getAuthor());
            }
        }

        if ($this->getOnlyPublished()) {
            $sql->where('sbp.date_add <= \''.SimpleBlogHelper::now(Configuration::get('PH_BLOG_TIMEZONE')).'\'');
        }

        if ($this->getCustomWhere()) {
            if (is_array($this->getCustomWhere())) {
                foreach ($this->getCustomWhere() as $condition) {
                    $sql->where($this->getCustomWhere());
                }
            } else {
                $sql->where($this->getCustomWhere());
            }
        }

        $sql->orderBy($this->getOrderBy().' '.$this->getOrderWay());

        if ($this->getLimit()) {
            $sql->limit($this->getLimit());
        }
        
        $result = Db::getInstance()->executeS($sql);

        if ($this->onlySimpleResults()) {
            return $result;
        }

        if (!$result) {
            return array();
        }

        if ($this->getCheckForAccess()) {
            foreach ($result as $key => $post) {
                if (Validate::isLoadedObject($this->getCustomer())) {
                    $userGroups = $this->getCustomer()->getGroups();
                } else {
                    $userGroups = array(1, 2);
                }
                
                if ($userGroups) {
                    $tmpLinkGroups = unserialize($post['access']);
                    $linkGroups = array();

                    foreach ($tmpLinkGroups as $groupID => $status) {
                        if ($status) {
                            $linkGroups[] = $groupID;
                        }
                    }

                    $intersect = array_intersect($userGroups, $linkGroups);
                    if (!count($intersect)) {
                        unset($result[$key]);
                    }
                }
            }
        }

        $posts = $this->getPostProperties($result, $this->getIdLang());

        if ($this->getLimit() === 1) {
            return array_shift($posts);
        }

        return $posts;
    }

    private function getPostProperties($posts, $id_lang)
    {
        foreach ($posts as &$row) {
            $blogCategory = new SimpleBlogCategory($row['id_simpleblog_category'], $id_lang);

            $row['url'] = SimpleBlogPost::getLink($row['link_rewrite'], $blogCategory->link_rewrite, $id_lang);
            $row['category'] = $blogCategory->name;
            $row['category_rewrite'] = $blogCategory->link_rewrite;
            $row['category_url'] = $blogCategory->getObjectLink();

            if (file_exists(_PS_MODULE_DIR_.'ph_simpleblog/covers/'.$row['id_simpleblog_post'].'.'.$row['cover'])) {
                $row['banner'] = _MODULE_DIR_.'ph_simpleblog/covers/'.$row['id_simpleblog_post'].'.'.$row['cover'];
                $row['banner_thumb'] = _MODULE_DIR_.'ph_simpleblog/covers/'.$row['id_simpleblog_post'].'-thumb.'.$row['cover'];
                $row['banner_wide'] = _MODULE_DIR_.'ph_simpleblog/covers/'.$row['id_simpleblog_post'].'-wide.'.$row['cover'];
            }

            if (file_exists(_PS_MODULE_DIR_.'ph_simpleblog/featured/'.$row['id_simpleblog_post'].'.'.$row['featured'])) {
                $row['featured'] = _MODULE_DIR_.'ph_simpleblog/featured/'.$row['id_simpleblog_post'].'.'.$row['featured'];
            }

            $row['allow_comments'] = SimpleBlogPost::checkIfAllowComments($row['allow_comments']);
            $row['comments'] = SimpleBlogComment::getCommentsCount((int) $row['id_simpleblog_post']);

            $tags = SimpleBlogTag::getPostTags((int) $row['id_simpleblog_post']);
            $row['tags'] = isset($tags[$id_lang]) && isset($tags[$id_lang]) ? $tags[$id_lang] : array();

            $row['post_type'] = SimpleBlogPostType::getSlugById((int) $row['id_simpleblog_post_type']);
            if ($row['post_type'] == 'gallery') {
                $row['gallery'] = SimpleBlogPostImage::getAllById((int) $row['id_simpleblog_post']);
            }
        }

        return $posts;
    }
}

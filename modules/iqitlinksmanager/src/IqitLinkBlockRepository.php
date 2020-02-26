<?php
/**
 * 2017 IQIT-COMMERCE.COM
 *
 * NOTICE OF LICENSE
 *
 * This file is licenced under the Software License Agreement.
 * With the purchase or the installation of the software in your application
 * you accept the licence agreement
 *
 *  @author    IQIT-COMMERCE.COM <support@iqit-commerce.com>
 *  @copyright 2017 IQIT-COMMERCE.COM
 *  @license   Commercial license (You can not resell or redistribute this software.)
 *
 */

class IqitLinkBlockRepository
{
    private $db;
    private $shop;
    private $db_prefix;

    public function __construct(Db $db, Shop $shop)
    {
        $this->db = $db;
        $this->shop = $shop;
        $this->db_prefix = $db->getPrefix();
    }

    public function createTables()
    {
        $engine = _MYSQL_ENGINE_;
        $success = true;
        $this->dropTables();

        $queries = [
            "CREATE TABLE IF NOT EXISTS `{$this->db_prefix}iqit_link_block`(
    			`id_iqit_link_block` int(10) unsigned NOT NULL auto_increment,
    			`id_hook` int(1) unsigned DEFAULT NULL,
    			`position` int(10) unsigned NOT NULL default '0',
    			`content` text default NULL,
    			PRIMARY KEY (`id_iqit_link_block`)
            ) ENGINE=$engine DEFAULT CHARSET=utf8",
            "CREATE TABLE IF NOT EXISTS `{$this->db_prefix}iqit_link_block_lang`(
    			`id_iqit_link_block` int(10) unsigned NOT NULL,
    			`id_lang` int(10) unsigned NOT NULL,
    			`name` varchar(40) NOT NULL default '',
    			PRIMARY KEY (`id_iqit_link_block`, `id_lang`)
            ) ENGINE=$engine DEFAULT CHARSET=utf8",
            "CREATE TABLE IF NOT EXISTS `{$this->db_prefix}iqit_link_block_shop` (
    			`id_iqit_link_block` int(10) unsigned NOT NULL auto_increment,
    			`id_shop` int(10) unsigned NOT NULL,
    			PRIMARY KEY (`id_iqit_link_block`, `id_shop`)
            ) ENGINE=$engine DEFAULT CHARSET=utf8",
        ];

        foreach ($queries as $query) {
            $success &= $this->db->execute($query);
        }

        return $success;
    }

    public function dropTables()
    {
        $sql = "DROP TABLE IF EXISTS
			`{$this->db_prefix}iqit_link_block`,
			`{$this->db_prefix}iqit_link_block_lang`,
			`{$this->db_prefix}iqit_link_block_shop`";

        return Db::getInstance()->execute($sql);
    }

    public function getCMSBlocksSortedByHook($id_shop = null, $id_lang = null)
    {
        $id_lang = (int) (($id_lang) ?: Context::getContext()->language->id);
        $id_shop = (int) (($id_shop) ?: Context::getContext()->shop->id);

        $sql = 'SELECT
                bc.`id_iqit_link_block`,
                bcl.`name` as block_name,
                bc.`id_hook`,
                h.`name` as hook_name,
                h.`title` as hook_title,
                h.`description` as hook_description,
                bcl.`id_lang`  as id_lang,
                bc.`position`
            FROM `' . _DB_PREFIX_ . 'iqit_link_block` bc
                INNER JOIN `' . _DB_PREFIX_ . 'iqit_link_block_shop` bcs 
                    ON (bc.`id_iqit_link_block` = bcs.`id_iqit_link_block`)
                INNER JOIN `' . _DB_PREFIX_ . 'iqit_link_block_lang` bcl
                    ON (bc.`id_iqit_link_block` = bcl.`id_iqit_link_block`)
                LEFT JOIN `' . _DB_PREFIX_ . 'hook` h
                    ON (bc.`id_hook` = h.`id_hook`)
            WHERE bcs.`id_shop` = ' . $id_shop . '
            ORDER BY bc.`position`';

        $blocksSrc = Db::getInstance()->executeS($sql);
        $blocks = array();
        foreach ($blocksSrc as $key => $block) {


            if ($block['id_lang'] == $id_lang && $block['block_name'] != ''){
                $blocks[$block['id_iqit_link_block']] = $block;
                unset($block);
            } else{
                $blocks[$block['id_iqit_link_block']] = $block;
            }
        }

        $orderedBlocks = array();
        foreach ($blocks as $block) {
            if (!isset($orderedBlocks[$block['id_hook']])) {
                $id_hook = ($block['id_hook']) ?: 'not_hooked';
                $orderedBlocks[$id_hook] = array(
                    'id_hook' => $block['id_hook'],
                    'hook_name' => $block['hook_name'],
                    'hook_title' => $block['hook_title'],
                    'hook_description' => $block['hook_description'],
                    'blocks' => array(),
                );
            }
        }

        foreach ($blocks as $block) {
            $id_hook = ($block['id_hook']) ?: 'not_hooked';
            unset($block['id_hook']);
            unset($block['hook_name']);
            unset($block['hook_title']);
            unset($block['hook_description']);

            $orderedBlocks[$id_hook]['blocks'][] = $block;
        }

        return $orderedBlocks;
    }

    public function getDisplayHooksForHelper()
    {
        $usableHooks = ['displayFooter', 'displayFooterBefore', 'displayFooterAFter', 'displayLeftColumn', 'displayRightColumn', 'displayReassurance', 'displayRightColumnProduct', 'displayNav1' , 'displayNav2'];

        $sql = "SELECT h.id_hook as id, h.name as name
                FROM {$this->db_prefix}hook h
                WHERE (lower(h.`name`) LIKE 'display%')
                ORDER BY h.name ASC
            ";
        $hooks = $this->db->executeS($sql);

        foreach ($hooks as $key => $hook) {
            if (preg_match('/admin/i', $hook['name'])
                || preg_match('/backoffice/i', $hook['name'])) {
                    unset($hooks[$key]);
            } else{
                if (!in_array($hook['name'], $usableHooks)){
                    unset($hooks[$key]);
                }
            }
        }
        return $hooks;
    }

    public function getByIdHook($id_hook)
    {
        $id_hook = (int) $id_hook;
        $id_shop = Context::getContext()->shop->id;

        $sql = "SELECT cb.`id_iqit_link_block`
                    FROM {$this->db_prefix}iqit_link_block cb
                    INNER JOIN {$this->db_prefix}iqit_link_block_shop cs ON (cb.`id_iqit_link_block` = cs.`id_iqit_link_block`)
                    WHERE `id_hook` = ". (int) $id_hook . "
                    AND cs.`id_shop` = ".(int)$id_shop."
                    ORDER BY cb.position ASC
                ";
        $ids = $this->db->executeS($sql);

        $cmsBlock = array();
        foreach ($ids as $id) {
            $cmsBlock[] = new IqitLinkBlock((int) $id['id_iqit_link_block']);
        }

        return $cmsBlock;
    }

    public function getCategories($id_lang = null) {

        $id_lang = (int) (($id_lang) ?: Context::getContext()->language->id);
        $catSource = $this->customGetNestedCategories($this->shop->id, null, (int)$id_lang, false);

        return $this->buildCategoryTree($catSource, $parentId = 0);
    }

    public function buildCategoryTree(array &$elements, $parentId = 0)
    {
        $branch = array();

        foreach ($elements as $element) {
            if ($element['id_parent'] == $parentId) {
                $children = $this->buildCategoryTree($elements, $element['id_category']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[$element['id_category']] = $element;
                unset($elements[$element['id_category']]);
            }
        }
        return $branch;
    }

    public function customGetNestedCategories($shop_id, $root_category = null, $id_lang = false, $active = false, $groups = null, $use_shop_restriction = true, $sql_filter = '', $sql_sort = '', $sql_limit = '')
    {
        if (isset($root_category) && !Validate::isInt($root_category)) {
            die(Tools::displayError());
        }

        if (!Validate::isBool($active)) {
            die(Tools::displayError());
        }

        if (isset($groups) && Group::isFeatureActive() && !is_array($groups)) {
            $groups = (array)$groups;
        }

        $cache_id = 'Category::getNestedCategories_'.md5((int)$shop_id.(int)$root_category.(int)$id_lang.(int)$active.(int)$active
                .(isset($groups) && Group::isFeatureActive() ? implode('', $groups) : ''));

        if (!Cache::isStored($cache_id)) {
            $result = Db::getInstance()->executeS('
							SELECT c.*, cl.*
				FROM `'._DB_PREFIX_.'category` c
				INNER JOIN `'._DB_PREFIX_.'category_shop` category_shop ON (category_shop.`id_category` = c.`id_category` AND category_shop.`id_shop` = "'.(int)$shop_id.'")
				LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON (c.`id_category` = cl.`id_category` AND cl.`id_shop` = "'.(int)$shop_id.'")
				WHERE 1 '.$sql_filter.' '.($id_lang ? 'AND cl.`id_lang` = '.(int)$id_lang : '').'
				'.($active ? ' AND (c.`active` = 1 OR c.`is_root_category` = 1)' : '').'
				'.(isset($groups) && Group::isFeatureActive() ? ' AND cg.`id_group` IN ('.implode(',', $groups).')' : '').'
				'.(!$id_lang || (isset($groups) && Group::isFeatureActive()) ? ' GROUP BY c.`id_category`' : '').'
				'.($sql_sort != '' ? $sql_sort : ' ORDER BY c.`level_depth` ASC').'
				'.($sql_sort == '' && $use_shop_restriction ? ', category_shop.`position` ASC' : '').'
				'.($sql_limit != '' ? $sql_limit : '')
            );

            $categories = array();
            $buff = array();

            foreach ($result as $row) {
                $current = &$buff[$row['id_category']];
                $current = $row;

                if ($row['id_parent'] == 0) {
                    $categories[$row['id_category']] = &$current;
                } else {
                    $buff[$row['id_parent']]['children'][$row['id_category']] = &$current;
                }
            }

            Cache::store($cache_id, $categories);
        }

        return Cache::retrieve($cache_id);
    }

   public function getCmsPages($id_lang = null)
    {
        $id_lang = (int) (($id_lang) ?: Context::getContext()->language->id);
        $this->shop->id = (int) $this->shop->id;
        $categories = "SELECT  cc.`id_cms_category`,
                        ccl.`name`,
                        ccl.`description`,
                        ccl.`link_rewrite`,
                        cc.`id_parent`,
                        cc.`level_depth`,
                        NULL as pages
            FROM {$this->db_prefix}cms_category cc
            INNER JOIN {$this->db_prefix}cms_category_lang ccl
                ON (cc.`id_cms_category` = ccl.`id_cms_category`)
            INNER JOIN {$this->db_prefix}cms_category_shop ccs
                ON (cc.`id_cms_category` = ccs.`id_cms_category`)
            WHERE `active` = 1
                AND ccl.`id_lang`= $id_lang
                AND ccs.`id_shop`= {$this->shop->id}
        ";
        $pages = $this->db->executeS($categories);
        foreach ($pages as &$category) {
            $category['pages'] =
                $this->db->executeS("SELECT c.`id_cms`,
                        c.`position`,
                        cl.`meta_title` as title,
                        cl.`meta_description` as description,
                        cl.`link_rewrite`
                    FROM {$this->db_prefix}cms c
                    INNER JOIN {$this->db_prefix}cms_lang cl
                        ON (c.`id_cms` = cl.`id_cms`)
                    INNER JOIN {$this->db_prefix}cms_shop cs
                        ON (c.`id_cms` = cs.`id_cms`)
                    WHERE c.`active` = 1
                        AND c.`id_cms_category` = {$category['id_cms_category']}
                        AND cl.`id_lang` = $id_lang
                        AND cs.`id_shop` = {$this->shop->id}
                ");
        }
        return $pages;
    }

    public function buildCmsTree(array &$elements, $parentId = 0)
    {
        $branch = array();

        foreach ($elements as $element) {
            if ($element['id_parent'] == $parentId) {
                $children = $this->buildCmsTree($elements, $element['id_cms_category']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[$element['id_cms_category']] = $element;
                unset($elements[$element['id_cms_category']]);
            }
        }
        return $branch;
    }


    public function getStaticPages($id_lang = null)
    {
        $statics = array();
        $pages = array();
        $staticPages = array(
            'prices-drop',
            'new-products',
            'best-sales',
            'manufacturer',
            'supplier',
            'contact',
            'sitemap',
            'stores',
            'authentication',
            'my-account',
            'identity',
            'history',
            'addresses',
            'guest-tracking',
        );

        foreach ($staticPages as $staticPage) {
            $meta = Meta::getMetaByPage($staticPage, ($id_lang) ? (int) $id_lang : (int) Context::getContext()->language->id);
            $statics[] = [
                'id_cms' => $staticPage,
                'title' => $meta['title'],
            ];
        }

        $pages[]['pages'] = $statics;

        return $pages;
    }

    public function getCountByIdHook($id_hook)
    {
        $id_hook = (int) $id_hook;

        $sql = "SELECT COUNT(*) FROM {$this->db_prefix}iqit_link_block
                    WHERE `id_hook` = $id_hook";

        return Db::getInstance()->getValue($sql);
    }

    public function installFixtures()
    {
        $success = true;
        $id_hook = (int) Hook::getIdByName('displayFooter');
        $id_hook2 = (int) Hook::getIdByName('displayNav1');

        $queries = [
            'INSERT INTO `' . _DB_PREFIX_ . 'iqit_link_block` (`id_iqit_link_block`, `id_hook`, `position`, `content`) VALUES
                (1, ' . $id_hook . ', 2, \'[{"type":"cms_page","id":1},{"type":"cms_page","id":2},{"type":"cms_category","id":1}]\');',
        ];

        $queries[] =
            'INSERT INTO `' . _DB_PREFIX_ . 'iqit_link_block` (`id_iqit_link_block`, `id_hook`, `position`, `content`) VALUES
                (2, ' . $id_hook2 . ', 2, \'[{"type":"cms_page","id":1},{"type":"cms_page","id":2},{"type":"cms_category","id":1}]\');';

        foreach (Language::getLanguages(true, Context::getContext()->shop->id) as $lang) {
            $queries[] = 'INSERT INTO `' . _DB_PREFIX_ . 'iqit_link_block_lang` (`id_iqit_link_block`, `id_lang`, `name`) VALUES
                (1, ' . $lang['id_lang'] . ', \'iqitlinksmanager module\')'
            ;
            $queries[] = 'INSERT INTO `' . _DB_PREFIX_ . 'iqit_link_block_lang` (`id_iqit_link_block`, `id_lang`, `name`) VALUES
                (2, ' . $lang['id_lang'] . ', \'iqitlinksmanager module\')'
            ;
        }

        foreach (Shop::getShopsCollection() as $shop) {
            $queries[] = 'INSERT INTO `' . _DB_PREFIX_ . 'iqit_link_block_shop` (`id_iqit_link_block`, `id_shop`) VALUES
                (1, ' . (int)$shop->id . ')';
            $queries[] = 'INSERT INTO `' . _DB_PREFIX_ . 'iqit_link_block_shop` (`id_iqit_link_block`, `id_shop`) VALUES
                (2, ' . (int)$shop->id . ')';
        }

        foreach ($queries as $query) {
            $success &= $this->db->execute($query);
        }
        return $success;
    }
}

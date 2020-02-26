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

class IqitHtmlAndBannerRepository
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
            "CREATE TABLE IF NOT EXISTS `{$this->db_prefix}iqit_htmlandbanner`(
    			`id_iqit_htmlandbanner` int(10) unsigned NOT NULL auto_increment,
    			`id_hook` int(1) unsigned DEFAULT NULL,
    			`width` int(1) unsigned DEFAULT NULL,
    			`type` int(10) unsigned NOT NULL,
    			`position` int(10) unsigned NOT NULL default '0',
    			`content` text default NULL,
    			PRIMARY KEY (`id_iqit_htmlandbanner`)
            ) ENGINE=$engine DEFAULT CHARSET=utf8",
            "CREATE TABLE IF NOT EXISTS `{$this->db_prefix}iqit_htmlandbanner_lang`(
    			`id_iqit_htmlandbanner` int(10) unsigned NOT NULL,
    			`id_lang` int(10) unsigned NOT NULL,
    			`name` varchar(40) NOT NULL default '',
    			`description` text default NULL,    			
    			PRIMARY KEY (`id_iqit_htmlandbanner`, `id_lang`)
            ) ENGINE=$engine DEFAULT CHARSET=utf8",
            "CREATE TABLE IF NOT EXISTS `{$this->db_prefix}iqit_htmlandbanner_shop` (
    			`id_iqit_htmlandbanner` int(10) unsigned NOT NULL auto_increment,
    			`id_shop` int(10) unsigned NOT NULL,
    			PRIMARY KEY (`id_iqit_htmlandbanner`, `id_shop`)
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
			`{$this->db_prefix}iqit_htmlandbanner`,
			`{$this->db_prefix}iqit_htmlandbanner_shop`,
			`{$this->db_prefix}iqit_htmlandbanner_lang`";

        return Db::getInstance()->execute($sql);
    }

    public function getCMSBlocksSortedByHook($id_shop = null, $id_lang = null)
    {
        $id_lang = (int) (($id_lang) ?: Context::getContext()->language->id);
        $id_shop = (int) (($id_shop) ?: Context::getContext()->shop->id);

        $sql = 'SELECT
                bc.`id_iqit_htmlandbanner`,
                bc.`type`,
                bcl.`name` as block_name,
                bc.`id_hook`,
                h.`name` as hook_name,
                h.`title` as hook_title,
                h.`description` as hook_description,
                bcl.`id_lang`  as id_lang,
                bc.`position`
            FROM `' . _DB_PREFIX_ . 'iqit_htmlandbanner` bc
                INNER JOIN `' . _DB_PREFIX_ . 'iqit_htmlandbanner_shop` bcs 
                    ON (bc.`id_iqit_htmlandbanner` = bcs.`id_iqit_htmlandbanner`)
                INNER JOIN `' . _DB_PREFIX_ . 'iqit_htmlandbanner_lang` bcl
                    ON (bc.`id_iqit_htmlandbanner` = bcl.`id_iqit_htmlandbanner`)
                LEFT JOIN `' . _DB_PREFIX_ . 'hook` h
                    ON (bc.`id_hook` = h.`id_hook`)
            WHERE bcs.`id_shop` = ' . $id_shop . '
            ORDER BY bc.`position`';

        $blocksSrc = Db::getInstance()->executeS($sql);
        $blocks = array();
        foreach ($blocksSrc as $key => $block) {


            if ($block['id_lang'] == $id_lang && $block['block_name'] != ''){
                $blocks[$block['id_iqit_htmlandbanner']] = $block;
                unset($block);
            } else{
                $blocks[$block['id_iqit_htmlandbanner']] = $block;
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
        $usableHooks = ['displayFooter', 'displayFooterBefore', 'displayFooterAFter', 'displayLeftColumn', 'displayRightColumn',  'displayWrapperTopInContainer', 'displayWrapperTop', 'displayNavCenter', 'displayWrapperBottom', 'displayWrapperBottomInContainer', 'displayMyAccountDashboard', 'displayReassurance', 'displayRightColumnProduct', 'displayNav1', 'displayNav2', 'displayProductAdditionalInfo'];

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
            } else {
                if (!in_array($hook['name'], $usableHooks)){
                    unset($hooks[$key]);
                }
            }
        }
        return $hooks;
    }



    public function getDisplayHooksForHelperBanner()
    {
        $usableHooks = ['displayFooter', 'displayFooterBefore', 'displayFooterAFter', 'displayLeftColumn', 'displayRightColumn',   'displayWrapperTopInContainer', 'displayWrapperTop', 'displayWrapperBottom', 'displayWrapperBottomInContainer',  'displayMyAccountDashboard',  'displayReassurance', 'displayRightColumnProduct', 'displayBanner', 'displayProductAdditionalInfo'];

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
            } else {
                if (!in_array($hook['name'], $usableHooks)){
                    unset($hooks[$key]);
                }
            }
        }
        return $hooks;
    }

    public function getByIdHook($id_hook, $id_lang = null)
    {
        $id_hook = (int) $id_hook;
        $id_lang = (int) (($id_lang) ?: Context::getContext()->language->id);
        $id_shop = Context::getContext()->shop->id;

        $sql = "SELECT cb.`id_iqit_htmlandbanner`
                    FROM {$this->db_prefix}iqit_htmlandbanner cb
                    INNER JOIN {$this->db_prefix}iqit_htmlandbanner_shop cs ON (cb.`id_iqit_htmlandbanner` = cs.`id_iqit_htmlandbanner`)
                    WHERE `id_hook` = ". (int) $id_hook. "
                    AND cs.`id_shop` = ".(int)$id_shop."
                    ORDER BY cb.position ASC
                ";
        $ids = $this->db->executeS($sql);

        $block = array();
        foreach ($ids as $id) {
            $block[] = new IqitHtmlAndBanner((int) $id['id_iqit_htmlandbanner'], $id_lang, $id_shop);
        }

        return $block;
    }

    public function getCountByIdHook($id_hook)
    {
        $id_hook = (int) $id_hook;

        $sql = "SELECT COUNT(*) FROM {$this->db_prefix}iqit_htmlandbanner
                    WHERE `id_hook` = $id_hook";

        return Db::getInstance()->getValue($sql);
    }



    public function installFixtures()
    {
        $success = true;
        $id_hook = (int) Hook::getIdByName('displayRightColumnProduct');

        $queries = [
            'INSERT INTO `' . _DB_PREFIX_ . 'iqit_htmlandbanner` (`id_iqit_htmlandbanner`, `id_hook`, `width`, `type`, `position`, `content`) VALUES
                (1, ' . $id_hook . ', 0, 1, 2, \'\');',
        ];

        foreach (Language::getLanguages(true, Context::getContext()->shop->id) as $lang) {
            $queries[] = 'INSERT INTO `' . _DB_PREFIX_ . 'iqit_htmlandbanner_lang` (`id_iqit_htmlandbanner`, `id_lang`, `name`, `description`) VALUES
                (1, ' . $lang['id_lang'] . ', \'custom html\',
                 \'you can configure this block in <strong>iqithtmlbanners</strong> module. It is hooked in displayRightColumnProduct hook. <br><br>
                 To disable entire area go to iqitthemeeditor module > Content/Pages > Product page and set hidden for Right sidebar option\')'
            ;
        }

        foreach (Shop::getShopsCollection() as $shop) {
            $queries[] = 'INSERT INTO `' . _DB_PREFIX_ . 'iqit_htmlandbanner_shop` (`id_iqit_htmlandbanner`, `id_shop`) VALUES
                (1, ' . (int)$shop->id . ')';
        }

        foreach ($queries as $query) {
            $success &= $this->db->execute($query);
        }
        return $success;
    }

}

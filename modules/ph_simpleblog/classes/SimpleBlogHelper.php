<?php
/**
 * Blog for PrestaShop module by Krystian Podemski from PrestaHome.
 *
 * @author    Krystian Podemski <krystian@prestahome.com>
 * @copyright Copyright (c) 2008-2019 Krystian Podemski - www.PrestaHome.com / www.Podemski.info
 * @license   You only can use module, nothing more!
 */
require_once _PS_MODULE_DIR_.'ph_simpleblog/ph_simpleblog.php';

class SimpleBlogHelper
{
    public static function uploadImage()
    {
        // Nothing to do here atm
    }

    public static function now($str_user_timezone)
    {
        $date = new DateTime('now');
        $date->setTimezone(new DateTimeZone($str_user_timezone));
        $str_server_now = $date->format('Y.m.d H:i:s');

        return $str_server_now;
    }

    public static function checkForArchives($type)
    {
        $id_shop = Context::getContext()->shop->id;

        switch ($type) {
            case 'year':
                $sql = new DbQuery();
                $sql->select('YEAR(sbp.date_add) as year, MONTH(sbp.date_add) as month, COUNT(sbp.id_simpleblog_post) as nbPosts');
                $sql->from('simpleblog_post', 'sbp');
                $sql->innerJoin('simpleblog_post_shop', 'sbps', 'sbp.id_simpleblog_post = sbps.id_simpleblog_post AND sbps.id_shop = '.(int) $id_shop);
                $sql->where('sbp.date_add <= \''.SimpleBlogHelper::now(Configuration::get('PH_BLOG_TIMEZONE')).'\'');
                $sql->where('sbp.active = 1');
                $sql->groupBy('YEAR(sbp.date_add)');
                $sql->orderBy('year DESC');

                $result = Db::getInstance()->executeS($sql);

                return $result;

                break;

            case 'month':
                # code...
                break;    
        }
    }
}

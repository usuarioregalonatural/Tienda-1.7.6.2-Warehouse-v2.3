<?php
/**
* 2016 Revolution Slider
*
*  @author    SmatDataSoft <support@smartdatasoft.com>
*  @copyright 2016 SmatDataSoft
*  @license   private
*  @version   5.1.3
*  International Registered Trademark & Property of SmatDataSoft
*/

// @codingStandardsIgnoreStart
include_once('../../config/config.inc.php');
include_once('../../init.php');
include_once('inc_php/revslider_globals.class.php');
include_once('inc_php/revslider_db.class.php');
// defined('_PS_VERSION_') OR die('No Direct Script Access Allowed');
$action = Tools::getValue('action');
$mod_url = context::getcontext()->shop->getBaseURL() . "modules/revsliderprestashop/";
switch ($action) {
    case 'revsliderprestashop_show_image':
        $imgsrc = Tools::getValue('img');
        if ($imgsrc) {
            if (is_numeric($imgsrc)) {
                $table = _DB_PREFIX_ . GlobalsRevSlider::TABLE_ATTACHMENT_IMAGES;
                $result = rev_db_class::revDbInstance()->getVar("SELECT file_name FROM {$table} WHERE ID={$imgsrc}");
                if (empty($result)) {
                    die();
                }
                $imgsrc = "uploads/$result";
            } else {
                $imgsrc = str_replace('../', '', urldecode($imgsrc));
            }

            if (strpos($imgsrc, 'uploads') !== false) {
                $file = @getimagesize($imgsrc);

                if (!empty($file) && @RevsliderPrestashop::getIsset($file['mime'])) {
                    $size = GlobalsRevSlider::IMAGE_SIZE_MEDIUM;
                    $filename = basename($imgsrc);
                    $filetitle = Tools::substr($filename, 0, strrpos($filename, '.'));
                    $fileext = Tools::substr($filename, strrpos($filename, '.'));

                    $newfile = "uploads/{$filetitle}-{$size}x{$size}{$fileext}";

                    if ($newfilesize = @getimagesize($newfile)) {
                        $file = $newfilesize;
                        $imgsrc = $newfile;
                    }
                    header('Content-Type:' . $file['mime']);
                    echo Tools::file_get_contents($mod_url . $imgsrc);
                }
            }
        }
        break;
}
die();
// @codingStandardsIgnoreEnd
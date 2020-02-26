<?php
/**
 * Blog for PrestaShop module by Krystian Podemski from PrestaHome.
 *
 * @author    Krystian Podemski <krystian@prestahome.com>
 * @copyright Copyright (c) 2008-2019 Krystian Podemski - www.PrestaHome.com / www.Podemski.info
 * @license   You only can use module, nothing more!
 */
include dirname(__FILE__).'/../../config/config.inc.php';
include dirname(__FILE__).'/../../init.php';

$status = 'success';
$message = '';

include_once dirname(__FILE__).'/ph_simpleblog.php';
include_once dirname(__FILE__).'/models/SimpleBlogPost.php';

$action = Tools::getValue('action');

switch ($action) {
    case 'addRating':
        $id_simpleblog_post = Tools::getValue('id_simpleblog_post');
        $reply = SimpleBlogPost::changeRating('up', (int) $id_simpleblog_post);
        $message = $reply[0]['likes'];
        break;

    case 'removeRating':
        $id_simpleblog_post = Tools::getValue('id_simpleblog_post');
        $reply = SimpleBlogPost::changeRating('down', (int) $id_simpleblog_post);
        $message = $reply[0]['likes'];
        break;

    default:
        $status = 'error';
        $message = 'Unknown parameters!';
        break;
}
$response = new stdClass();
$response->status = $status;
$response->message = $message;
$response->action = $action;
echo json_encode($response);

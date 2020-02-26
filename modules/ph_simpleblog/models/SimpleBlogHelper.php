<?php
/*
* @author    Krystian Podemski <podemski.krystian@gmail.com>
* @site
* @copyright  Copyright (c) 2013-2014 Krystian Podemski - www.PrestaHome.com
* @license    You only can use module, nothing more!
*/
require_once _PS_MODULE_DIR_ . 'ph_simpleblog/ph_simpleblog.php';

class SimpleBlogHelper
{
	public static function uploadImage($type = 'cover', $path = null, Array $params)
	{
		
	}

	public static function now($str_user_timezone) {
		$date = new DateTime('now');
		$date->setTimezone(new DateTimeZone($str_user_timezone));
		$str_server_now = $date->format('Y.m.d H:i:s');

		return $str_server_now;
	}
}
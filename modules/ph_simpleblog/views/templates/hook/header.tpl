{*
* 2007-2014 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2014 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<meta property="og:url" content="{$post_url|escape:'html':'UTF-8'}" />
<meta property="og:title" content="{$post_title|escape:'html':'UTF-8'}" />
<meta property="og:type" content="article" />
<meta property="og:site_name" content="{Configuration::get('PS_SHOP_NAME')|escape:'html':'UTF-8'}" />
<meta property="og:description" content="{$post_description|escape:'html':'UTF-8'}" />
{if isset($post_image) && !empty($post_image)}
<meta property="og:image" content="{$post_image|escape:'html':'UTF-8'}" />
{/if}
<meta property="fb:admins" content="{Configuration::get('PH_BLOG_FACEBOOK_MODERATOR')|intval}"/>
<meta property="fb:app_id" content="{Configuration::get('PH_BLOG_FACEBOOK_APP_ID')|intval}"/>
{*
* 2007-2013 PrestaShop
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
*  @copyright  2007-2013 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

{extends file="helpers/list/list_footer.tpl"}
{block name="after"}
{if Configuration::get('PH_BLOG_ADVERTISING')}
<iframe style="overflow:hidden;border:1px solid #f0f0f0;border-radius:10px;width:100%;height:175px;" src="https://api.prestahome.com/check_offer.php?from=ph_simpleblog" border="0"></iframe>
<small>{l s='You can disable this panel in the Settings' mod='ph_simpleblog'}</small>
{/if}
{/block}
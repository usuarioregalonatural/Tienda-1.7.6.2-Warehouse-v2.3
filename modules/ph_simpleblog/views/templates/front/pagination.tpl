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
<!-- Pagination -->
<div id="pagination" class="pagination simpleblog-pagination">
{if $start!=$stop}
	<ul class="pagination">
	{if $p != 1}
		{assign var='p_previous' value=$p-1}
		<li id="pagination_previous" class="pagination_previous"><a href="{SimpleBlogPost::getPageLink($p_previous, $type, $rewrite)|escape:'html':'UTF-8'}" rel="prev">&laquo;&nbsp;{l s='Previous' mod='ph_simpleblog'}</a></li>
	{else}
		<li id="pagination_previous" class="disabled pagination_previous"><span>&laquo;&nbsp;{l s='Previous' mod='ph_simpleblog'}</span></li>
	{/if}
	{if $start>3}
		<li><a href="{SimpleBlogPost::getPageLink(1, $type, $rewrite)|escape:'html':'UTF-8'}">1</a></li>
		<li class="truncate">...</li>
	{/if}
	{section name=pagination start=$start loop=$stop+1 step=1}
		{if $p == $smarty.section.pagination.index}
			<li class="current"><span>{$p|escape:'htmlall':'UTF-8'}</span></li>
		{else}
			<li><a href="{SimpleBlogPost::getPageLink($smarty.section.pagination.index, $type, $rewrite)|escape:'html':'UTF-8'}">{$smarty.section.pagination.index|escape:'htmlall':'UTF-8'}</a></li>
		{/if}
	{/section}
	{if $pages_nb>$stop+2}
		<li class="truncate">...</li>
		<li><a href="{SimpleBlogPost::getPageLink($pages_nb, $type, $rewrite)|escape:'html':'UTF-8'}">{$pages_nb|intval}</a></li>
	{/if}
	{if $pages_nb > 1 AND $p != $pages_nb}
		{assign var='p_next' value=$p+1}
		<li id="pagination_next" class="pagination_next"><a href="{SimpleBlogPost::getPageLink($p_next, $type, $rewrite)|escape:'html':'UTF-8'}" rel="next">{l s='Next' mod='ph_simpleblog'}&nbsp;&raquo;</a></li>
	{else}
		<li id="pagination_next" class="disabled pagination_next"><span>{l s='Next' mod='ph_simpleblog'}&nbsp;&raquo;</span></li>
	{/if}
	</ul>
{/if}
</div>
<!-- /Pagination -->		
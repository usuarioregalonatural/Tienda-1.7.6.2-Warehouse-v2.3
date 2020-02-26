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
{if isset($logged) AND $logged || Configuration::get('PH_BLOG_COMMENT_ALLOW_GUEST')}
<form class="std clearfix" action="{$post->url|escape:'html':'UTF-8'}" method="post">
	<fieldset>
		<div class="box">
			<h3 class="page-heading bottom-indent">{l s='New comment' mod='ph_simpleblog'}</h3>
			<div class="form-group">
				<label for="customer_name">{l s='Your name' mod='ph_simpleblog'}</label>
				<input type="text" class="form-control" name="customer_name" id="customer_name" value="{if isset($logged) AND $logged}{$customerName|escape:'html':'UTF-8'}{else}{if isset($smarty.post.comment_content)}{$smarty.post.customer_name|escape:'htmlall':'UTF-8'}{/if}{/if}" />
			</div>
			<div class="form-group">
				<label for="comment_content">{l s='Your comment' mod='ph_simpleblog'}</label>
				<textarea class="form-control"id="comment_content" name="comment_content" cols="26" rows="5">{if isset($smarty.post.comment_content)}{$smarty.post.comment_content|escape:'htmlall':'UTF-8'}{/if}</textarea>
			</div>
			{if Configuration::get('PH_BLOG_COMMENTS_RECAPTCHA')}
			<div class="form-group">
				<div class="g-recaptcha" data-sitekey="{Configuration::get('PH_BLOG_COMMENTS_RECAPTCHA_SITE_KEY')}" data-theme="{Configuration::get('PH_BLOG_COMMENTS_RECAPTCHA_THEME')}"></div>
				<script src='https://www.google.com/recaptcha/api.js'></script>
			</div>
			{/if}
		</div>
		<p class="cart_navigation required submit clearfix">
			<input type="hidden" name="id_simpleblog_post" value="{$post->id_simpleblog_post|intval}" />
			<input type="hidden" name="id_parent" id="id_parent" value="0" />
			{if $is_16}
			<button type="submit" class="button btn btn-default button-medium" name="submitNewComment" id="submitNewComment">
				<span>
					{l s='Add new comment' mod='ph_simpleblog'}
					<i class="fa fa-chevron-right right"></i>
				</span>
			</button>
			{else}
			<input type="submit" class="button" name="submitNewComment" value="{l s='Add new comment' mod='ph_simpleblog'}" />
			{/if}
		</p>
	</fieldset>
</form>
{else}
	<div class="warning alert alert-warning">
		<a href="{$link->getPageLink('authentication', true, null, ['back' => $post->url])|escape:'html':'UTF-8'}">{l s='Only registered and logged customers can add comments' mod='ph_simpleblog'}</a>
	</div><!-- .warning -->
{/if}

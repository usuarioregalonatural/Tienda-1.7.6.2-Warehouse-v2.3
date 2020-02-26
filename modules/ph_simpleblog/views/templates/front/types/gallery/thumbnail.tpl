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
{if isset($post.banner) && Configuration::get('PH_BLOG_DISPLAY_THUMBNAIL')}
	<div class="post-thumbnail">
		<a {if isset($post.gallery) && sizeof($post.gallery)}href="{$gallery_dir|escape:'html':'UTF-8'}{$post.gallery.0.image|escape:'html':'UTF-8'}.jpg" data-fancybox-group="post-gallery-slideshow-{$post.id_simpleblog_post|intval}" class="post-gallery-link"{else}href="{$post.url|escape:'html':'UTF-8'}"{/if} title="{l s='Permalink link to' mod='ph_simpleblog'} {$post.title|escape:'html':'UTF-8'}">
			{if $blogLayout eq 'full'}
				<meta itemprop="image" content="{$shopUrl}{$post.banner_wide|escape:'html':'UTF-8'}">
				<img src="{$post.banner_wide|escape:'html':'UTF-8'}" alt="{$post.title|escape:'html':'UTF-8'}" class="img-responsive" />
			{else}
				<meta itemprop="image" content="{$shopUrl}{$post.banner_wide|escape:'html':'UTF-8'}">
				<img src="{$post.banner_thumb|escape:'html':'UTF-8'}" alt="{$post.title|escape:'html':'UTF-8'}" class="img-responsive" />
			{/if}
		</a>
		{foreach $post.gallery as $image name=gallery_loop}
		{if !$smarty.foreach.gallery_loop.first}
		<a class="post-gallery-link" data-fancybox-group="post-gallery-slideshow-{$post.id_simpleblog_post|intval}" href="{$gallery_dir|escape:'html':'UTF-8'}{$image.image|escape:'html':'UTF-8'}.jpg" style="display: none;"><img src="{$gallery_dir|escape:'html':'UTF-8'}{$image.image|escape:'html':'UTF-8'}-{if $blogLayout eq 'full'}wide{else}thumb{/if}.jpg" /></a>
		{/if}
		{/foreach}
	</div>
{else}
	{if isset($post.gallery) && sizeof($post.gallery)}
	<div class="post-thumbnail post-gallery-container">
		<ul class="bxslider" id="post-gallery-slideshow-{$post.id_simpleblog_post|intval}">
		{foreach $post.gallery as $image}
			<li style="visibility: hidden;"><a class="post-gallery-link" data-fancybox-group="post-gallery-slideshow-{$post.id_simpleblog_post|intval}" href="{$gallery_dir|escape:'html':'UTF-8'}{$image.image|escape:'html':'UTF-8'}.jpg"><img src="{$gallery_dir|escape:'html':'UTF-8'}{$image.image|escape:'html':'UTF-8'}-{if $blogLayout eq 'full'}wide{else}thumb{/if}.jpg" /></a></li>
		{/foreach}
		</ul>
		<script>
		$(function() {
			$('#post-gallery-slideshow-{$post.id_simpleblog_post|intval}').bxSlider({
				mode: 'fade',
				preloadImages: 'all',
				pager: false,
				onSliderLoad: function() {
			        $("#post-gallery-slideshow-{$post.id_simpleblog_post|intval} li").css("visibility", "visible");
			    }
			});
		});
		</script>
	</div>
	{/if}
{/if}
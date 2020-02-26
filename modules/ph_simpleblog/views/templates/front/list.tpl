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

{if Configuration::get('PH_BLOG_DISPLAY_BREADCRUMBS')}
	{capture name=path}
		{if isset($parent_category) || $is_category eq true}
		<a href="{$link->getModuleLink('ph_simpleblog', 'list')|escape:'html':'UTF-8'}">
			{l s='Blog' mod='ph_simpleblog'}
		</a>
		{else}
			{l s='Blog' mod='ph_simpleblog'}
		{/if}
		{if isset($parent_category)}
			<span class="navigation-pipe">
				{$navigationPipe|escape:'html':'UTF-8'}
			</span>
			<a href="{$link->getModuleLink('ph_simpleblog', 'category', ['sb_category' => $parent_category->link_rewrite])|escape:'html':'UTF-8'}">{$parent_category->name|escape:'html':'UTF-8'}</a>
		{/if}
		{if $is_category eq true}
			<span class="navigation-pipe">
				{$navigationPipe|escape:'html':'UTF-8'}
			</span>
			{$blogCategory->name|escape:'html':'UTF-8'}
		{/if}
	{/capture}
	{if !$is_16}
		{include file="$tpl_dir./breadcrumb.tpl"}
	{/if}
{/if}

<div class="ph_simpleblog simpleblog-{if $is_category}category{else}home{/if}">
	{if $is_category eq true}
		<h1>{$blogCategory->name|escape:'html':'UTF-8'}</h1>

		{if Configuration::get('PH_BLOG_DISPLAY_CATEGORY_IMAGE') && isset($blogCategory->image)}
		<div class="simpleblog-category-image">
			<img src="{$blogCategory->image|escape:'html':'UTF-8'}" alt="{$blogCategory->name|escape:'html':'UTF-8'}" class="img-responsive" />
		</div>
		{/if}

		{if !empty($blogCategory->description) && Configuration::get('PH_BLOG_DISPLAY_CAT_DESC')}
		<div class="ph_cat_description rte">
			{$blogCategory->description}
		</div>
		{/if}
	{else}
		<h1>{$blogMainTitle|escape:'html':'UTF-8'}</h1>
	{/if}

	{if isset($posts) && count($posts)}
		<div class="row simpleblog-posts">
			{foreach from=$posts item=post}

				<div class="simpleblog-post-item simpleblog-post-type-{$post.post_type|escape:'html':'UTF-8'}
				{if $blogLayout eq 'grid' AND $columns eq '3'}
					col-md-4 col-sm-6 col-xs-12 col-ms-12 {cycle values="first-in-line,second-in-line,last-in-line"}
				{elseif $blogLayout eq 'grid' AND $columns eq '4'}
					col-md-3 col-sm-6 col-xs-12 col-ms-12 {cycle values="first-in-line,second-in-line,third-in-line,last-in-line"}
				{elseif $blogLayout eq 'grid' AND $columns eq '2'}
					col-md-6 col-sm-6 col-xs-12 col-ms-12 {cycle values="first-in-line,last-in-line"}
				{else}
				col-md-12
				{/if}">

					<div class="post-item">
						{assign var='post_type' value=$post.post_type}

						{* How it works? *}
						{* We slice post at few parts, thumbnail, title, description etc. we check if override for specific parts exists for current post type and if so we include this tpl file *}

						{if $post_type != 'post' && file_exists("$tpl_path./types/$post_type/thumbnail.tpl")}
							{include file="./types/$post_type/thumbnail.tpl"}
						{else}
							{if isset($post.banner) && Configuration::get('PH_BLOG_DISPLAY_THUMBNAIL')}
							<div class="post-thumbnail">
								<a href="{$post.url|escape:'html':'UTF-8'}" title="{l s='Permalink to' mod='ph_simpleblog'} {$post.title|escape:'html':'UTF-8'}">
									{if $blogLayout eq 'full'}
										<img src="{$post.banner_wide|escape:'html':'UTF-8'}" alt="{$post.title|escape:'html':'UTF-8'}" class="img-responsive" />
									{else}
										<img src="{$post.banner_thumb|escape:'html':'UTF-8'}" alt="{$post.title|escape:'html':'UTF-8'}" class="img-responsive" />
									{/if}
								</a>
							</div><!-- .post-thumbnail -->
							{/if}
						{/if}

						{if $post_type != 'post' && file_exists("$tpl_path./types/$post_type/title.tpl")}
							{include file="./types/$post_type/title.tpl"}
						{else}
							<div class="post-title">
								<h2>
									<a href="{$post.url|escape:'html':'UTF-8'}" title="{l s='Permalink to' mod='ph_simpleblog'} {$post.title|escape:'html':'UTF-8'}">
										{$post.title|escape:'html':'UTF-8'}
									</a>
								</h2>
							</div><!-- .post-title -->
						{/if}

						{if $post_type != 'post' && file_exists("$tpl_path./types/$post_type/description.tpl")}
							{include file="./types/$post_type/description.tpl"}
						{else}
							{if Configuration::get('PH_BLOG_DISPLAY_DESCRIPTION')}
							<div class="post-content">
								{$post.short_content|strip_tags:'UTF-8'}

								{if Configuration::get('PH_BLOG_DISPLAY_MORE')}
								<div class="post-read-more">
									<a href="{$post.url|escape:'html':'UTF-8'}" title="{l s='Read more' mod='ph_simpleblog'}">
										{l s='Read more' mod='ph_simpleblog'} <i class="fa fa-chevron-right"></i>
									</a>
								</div><!-- .post-read-more -->
								{/if}
							</div><!-- .post-content -->	
							{/if}
						{/if}

						{if $post_type != 'post' && file_exists("$tpl_path./types/$post_type/meta.tpl")}
							{include file="./types/$post_type/meta.tpl"}
						{else}
							<div class="post-additional-info post-meta-info">
								{if Configuration::get('PH_BLOG_DISPLAY_DATE')}
									<span class="post-date">
										<i class="fa fa-calendar"></i> <time datetime="{$post.date_add|date_format:'c'}">{$post.date_add|date_format:Configuration::get('PH_BLOG_DATEFORMAT')}</time>
									</span>
								{/if}

								{if $is_category eq false && Configuration::get('PH_BLOG_DISPLAY_CATEGORY')}
									<span class="post-category">
										<i class="fa fa-tags"></i> <a href="{$post.category_url}" title="{$post.category|escape:'html':'UTF-8'}" rel="category">{$post.category|escape:'html':'UTF-8'}</a>
									</span>
								{/if}

								{if isset($post.author) && !empty($post.author) && Configuration::get('PH_BLOG_DISPLAY_AUTHOR')}
									<span class="post-author">
										<i class="fa fa-user"></i> <span>{$post.author|escape:'html':'UTF-8'}</span>
									</span>
								{/if}
							</div><!-- .post-additional-info post-meta-info -->
						{/if}
					</div><!-- .post-item -->
				</div><!-- .simpleblog-post-item -->

			{/foreach}
		</div><!-- .row -->
		
		{if $is_category}
			{include file="./pagination.tpl" rewrite=$blogCategory->link_rewrite type='category'}
		{else}
			{include file="./pagination.tpl" rewrite=false type=false}
		{/if}
	{else}
		<p class="warning alert alert-warning">{l s='There are no posts' mod='ph_simpleblog'}</p>
	{/if}
</div><!-- .ph_simpleblog -->
<script>
var currentBlog = '{if $is_category}category{else}home{/if}';
$(window).load(function() {
	$('body').addClass('simpleblog simpleblog-'+currentBlog);
});
</script>
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

<div class="post-item">

    {if isset($post.banner) && Configuration::get('PH_BLOG_DISPLAY_THUMBNAIL')}
    <div class="post-thumbnail">
    <a href="{$post.url|escape:'html':'UTF-8'}"
       title="{l s='Permalink to' mod='ph_simpleblog'} {$post.title|escape:'html':'UTF-8'}">
            <img src="{$post.banner_thumb|escape:'html':'UTF-8'}" alt="{$post.title|escape:'html':'UTF-8'}"
                 class="img-fluid"/>
    </a>
    </div><!-- .post-thumbnail -->
    {/if}


    <div class="post-title">
        <h2>
            <a href="{$post.url|escape:'html':'UTF-8'}"
               title="{l s='Permalink to' mod='ph_simpleblog'} {$post.title|escape:'html':'UTF-8'}">
                {$post.title|escape:'html':'UTF-8'}
            </a>
        </h2>
    </div><!-- .post-title -->


    {if Configuration::get('PH_BLOG_DISPLAY_DESCRIPTION')}
        <div class="post-content">
            {$post.short_content|strip_tags:'UTF-8'}

            {if Configuration::get('PH_BLOG_DISPLAY_MORE')}
                    <a href="{$post.url|escape:'html':'UTF-8'}" title="{l s='Read more' mod='ph_simpleblog'}" class="post-read-more text-muted">
                         <span>{l s='read more' mod='ph_simpleblog'}</span> <i class="fa fa-chevron-right"></i>
                    </a>
                <!-- .post-read-more -->
            {/if}
        </div>
        <!-- .post-content -->
    {/if}


    <div class="post-additional-info post-meta-info text-muted">
        {if Configuration::get('PH_BLOG_DISPLAY_DATE')}
            <span class="post-date">
                                            <i class="fa fa-calendar"></i> <time
                        datetime="{$post.date_add|date_format:'c'}">{$post.date_add|date_format:Configuration::get('PH_BLOG_DATEFORMAT')}</time>
                                        </span>
        {/if}

        {if isset($is_category)}
        {if $is_category eq false && Configuration::get('PH_BLOG_DISPLAY_CATEGORY')}
            <span class="post-category">
                                            <i class="fa fa-tags"></i> <a href="{$post.category_url}"
                                                                          title="{$post.category|escape:'html':'UTF-8'}"
                                                                          rel="category">{$post.category|escape:'html':'UTF-8'}</a>
                                        </span>
        {/if}
        {/if}

        {if isset($post.author) && !empty($post.author) && Configuration::get('PH_BLOG_DISPLAY_AUTHOR')}
            <span class="post-author">
                                            <i class="fa fa-user"></i> <span>{$post.author|escape:'html':'UTF-8'}</span>
                                        </span>
        {/if}
    </div><!-- .post-additional-info post-meta-info -->

</div><!-- .post-item -->

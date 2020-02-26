{*
* 2007-2016 PrestaShop
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
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<article>

    {if isset($post.banner_thumb)}
    <div class="post-image">
        <figure>
            <a href="{$post.url}">
                 <img src="{$post.banner_thumb}" alt="{$post.title}" class="img-fluid" />
            </a>
        </figure>
    </div>
    {/if}

    <div class="post-title">{$post.title}</div>
    <div class="post-content">{$post.short_content nofilter}</div>
    <div class="post-meta">
        <span class="post-category"><i class="fa fa-tags"></i> <a href="{$post.category_url}" title="{$post.category}" rel="category">{$post.category}</a></span>
        <span class="post-date"><i class="fa fa-calendar"></i> <time datetime="{$post.date_add|date_format:'c'}">{$post.date_add|date_format:'c'}</time></span>
    </div>

</article>




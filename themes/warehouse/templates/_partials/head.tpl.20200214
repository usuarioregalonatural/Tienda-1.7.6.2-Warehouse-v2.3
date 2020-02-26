{**
 * 2007-2017 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
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
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2017 PrestaShop SA
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
{block name='head_charset'}
  <meta charset="utf-8">
{/block}
{block name='head_ie_compatibility'}
  <meta http-equiv="x-ua-compatible" content="ie=edge">
{/block}

{block name='head_seo'}
  <title>{block name='head_seo_title'}{$page.meta.title}{/block}</title>
  <meta name="description" content="{block name='head_seo_description'}{$page.meta.description}{/block}">
  <meta name="keywords" content="{block name='head_seo_keywords'}{$page.meta.keywords}{/block}">
  {if $page.meta.robots !== 'index'}
    <meta name="robots" content="{$page.meta.robots}">
  {/if}
  {block name='head_seo_canonical'}
  {if $page.canonical}
    <link rel="canonical" href="{$page.canonical}">
  {/if}
  {/block}

  {block name='head_hreflang'}
    {foreach from=$urls.alternative_langs item=pageUrl key=code}
      <link rel="alternate" href="{$pageUrl}" hreflang="{$code}">
    {/foreach}
  {/block}
{/block}

{block name='head_og_tags'}
    <meta property="og:title" content="{$page.meta.title}"/>
    <meta property="og:url" content="https://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}"/>
    <meta property="og:site_name" content="{$shop.name}"/>
    <meta property="og:description" content="{$page.meta.description}">
    <meta property="og:type" content="website">

    {if isset($iqitTheme.sm_og_logo) == 1 && $iqitTheme.sm_og_logo != ''}
      <meta property="og:image" content="https://{$smarty.server.HTTP_HOST}{$iqitTheme.sm_og_logo }" />
      {else}
      <meta property="og:image" content="https://{$smarty.server.HTTP_HOST}{$shop.logo}" />
    {/if}
{/block}



{block name='head_viewport'}
  {if $iqitTheme.rm_pinch_zoom == 1}
    <meta name="viewport" content="width=device-width, initial-scale=1">
  {else}
    <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width">
  {/if}
{/block}


{if isset($iqitTheme.rm_address_bg) && $iqitTheme.rm_address_bg != ''}
  <meta name="theme-color" content="{$iqitTheme.rm_address_bg}">
  <meta name="msapplication-navbutton-color" content="{$iqitTheme.rm_address_bg}">
{/if}

{block name='head_icons'}
  <link rel="icon" type="image/vnd.microsoft.icon" href="{$shop.favicon}?{$shop.favicon_update_time}">
  <link rel="shortcut icon" type="image/x-icon" href="{$shop.favicon}?{$shop.favicon_update_time}">
  {if isset($iqitTheme.rm_icon_apple) && $iqitTheme.rm_icon_apple != ''}
    <link rel="apple-touch-icon" href="{$iqitTheme.rm_icon_apple }">
  {/if}
  {if isset($iqitTheme.rm_icon_android) && $iqitTheme.rm_icon_android != ''}
    <link rel="icon" sizes="192x192" href="{$iqitTheme.rm_icon_android}">
  {/if}
{/block}

{block name='hook_fonts'}
  {if $iqitTheme.typo_bfont_t == 'google'}
    <link href="{$iqitTheme.typo_bfont_g_url}" rel="stylesheet">
  {/if}
  {if $iqitTheme.typo_hfont_t == 'google'}
    <link href="{$iqitTheme.typo_hfont_g_url}" rel="stylesheet">
  {/if}
{/block}


{block name='head_organization_snippet'}
<script type="application/ld+json">
{literal}
{
"@context": "https://schema.org",
"@type": "Organization",
"url": "{/literal}{$urls.base_url}{literal}",
"name": "{/literal}{$shop.name}{literal}",
"logo": "{/literal}{$shop.logo}{literal}",
"@id": "#store-organization"
}
{/literal}
</script>
{/block}


{block name='stylesheets'}
  {include file="_partials/stylesheets.tpl" stylesheets=$stylesheets}
{/block}

{block name='javascript_head'}
  {include file="_partials/javascript.tpl" javascript=$javascript.head vars=$js_custom_vars}
{/block}

{block name='hook_header'}
  {$HOOK_HEADER nofilter}
{/block}

{block name='hook_extra'}{/block}

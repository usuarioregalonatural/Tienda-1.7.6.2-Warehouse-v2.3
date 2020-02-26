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
{block name='header_banner'}
  <div class="header-banner">
    {hook h='displayBanner'}
  </div>
{/block}


{block name='header_nav'}
    {if $iqitTheme.tb_width == 'fullwidth'}
        <nav class="header-nav">
        <div class="container">
    {else}
        <div class="container">
        <nav class="header-nav">
    {/if}

        <div class="row justify-content-between">
            <div class="col col-auto col-md left-nav">
                {if $iqitTheme.tb_social == 1} <div class="d-inline-block"> {include file='_elements/social-links.tpl' class='_topbar'} </div> {/if}
                {hook h='displayNav1'}
            </div>
            <div class="col col-auto center-nav text-center">
                {hook h='displayNavCenter'}
             </div>
            <div class="col col-auto col-md right-nav text-right">
                {hook h='displayNav2'}
             </div>
        </div>

        {if $iqitTheme.tb_width == 'fullwidth'}
                </div>
            </nav>
        {else}
                </nav>
            </div>
        {/if}
{/block}


{block name='header_desktop'}
<div id="desktop-header" class="desktop-header-style-{$iqitTheme.h_layout}">
    {if $iqitTheme.h_layout == 1}
        {include file='_partials/_variants/header-1.tpl'}
    {elseif $iqitTheme.h_layout == 2}
        {include file='_partials/_variants/header-2.tpl'}
    {elseif $iqitTheme.h_layout == 3}
        {include file='_partials/_variants/header-3.tpl'}
    {elseif $iqitTheme.h_layout == 4}
        {include file='_partials/_variants/header-4.tpl'}
    {elseif $iqitTheme.h_layout == 5}
        {include file='_partials/_variants/header-5.tpl'}
    {elseif $iqitTheme.h_layout == 6}
        {include file='_partials/_variants/header-6.tpl'}
    {elseif $iqitTheme.h_layout == 7}
        {include file='_partials/_variants/header-7.tpl'}
    {/if}
</div>
{/block}

{block name='header_mobile'}
    <div id="mobile-header" class="mobile-header-style-{$iqitTheme.rm_header}">
        {if $iqitTheme.rm_header == 1}
            {include file='_partials/_variants/mobile-header-1.tpl'}
        {elseif $iqitTheme.rm_header == 2}
            {include file='_partials/_variants/mobile-header-2.tpl'}
        {elseif $iqitTheme.rm_header == 3}
            {include file='_partials/_variants/mobile-header-3.tpl'}
        {/if}
    </div>
{/block}

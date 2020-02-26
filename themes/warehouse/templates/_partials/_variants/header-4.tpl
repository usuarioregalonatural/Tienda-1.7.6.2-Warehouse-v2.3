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


<div class="header-top">
    <div id="desktop-header-container" class="container">
        <div class="row align-items-center">
            {if $iqitTheme.h_logo_position == 'left'}
                <div class="col col-auto col-header-left">
                    <div id="desktop_logo">
                        <a href="{$urls.base_url}">
                            <img class="logo img-fluid"
                                 src="{$shop.logo}" {if isset($iqitTheme.rm_logo) && $iqitTheme.rm_logo != ''} srcset="{$iqitTheme.rm_logo} 2x"{/if}
                                 alt="{$shop.name}">
                        </a>
                    </div>
                    {hook h='displayHeaderLeft'}
                </div>
                <div class="col col-header-center col-header-menu">
                    {if isset($iqitTheme.h_txt) && $iqitTheme.h_txt}
                        <div class="header-custom-html">
                            {$iqitTheme.h_txt nofilter}
                        </div>
                    {/if}
                    {hook h='displayMainMenu'}
                    {hook h='displayHeaderCenter'}
                </div>
            {else}
                <div class="col col-header-left col-header-menu">
                    {if isset($iqitTheme.h_txt) && $iqitTheme.h_txt}
                        <div class="header-custom-html">
                            {$iqitTheme.h_txt nofilter}
                        </div>
                    {/if}
                    {hook h='displayMainMenu'}
                    {hook h='displayHeaderLeft'}
                </div>
                <div class="col col-auto col-header-center text-center">
                    <div id="desktop_logo">
                        <a href="{$urls.base_url}">
                            <img class="logo img-fluid"
                                 src="{$shop.logo}" {if isset($iqitTheme.rm_logo) && $iqitTheme.rm_logo != ''} srcset="{$iqitTheme.rm_logo} 2x"{/if}
                                 alt="{$shop.name}">
                        </a>
                    </div>
                    {hook h='displayHeaderCenter'}
                </div>
            {/if}
            <div class="col {if $iqitTheme.h_logo_position == 'left'}col-auto{/if} col-header-right">
                <div class="row no-gutters justify-content-end">
                    {widget_block name="iqitsearch"}
                        {include 'module:iqitsearch/views/templates/hook/iqitsearch-btn.tpl'}
                    {/widget_block}

                    {hook h="litespeedEsiBegin" m="ps_customersignin" field="widget_block" tpl="module:ps_customersignin/ps_customersignin-btn.tpl"}
                    {widget_block name="ps_customersignin"}
                        {include 'module:ps_customersignin/ps_customersignin-btn.tpl'}
                    {/widget_block}
                    {hook h="litespeedEsiEnd"}

                    {hook h='displayHeaderButtons'}

                    {if !$configuration.is_catalog}
                        {hook h="litespeedEsiBegin" m="ps_shoppingcart" field="widget_block" tpl="module:ps_shoppingcart/ps_shoppingcart-btn.tpl"}
                        {widget_block name="ps_shoppingcart"}
                            {include 'module:ps_shoppingcart/ps_shoppingcart-btn.tpl'}
                        {/widget_block}
                        {hook h="litespeedEsiEnd"}
                    {/if}
                </div>
                {hook h='displayHeaderRight'}
            </div>
            <div class="col-12">
                <div class="row">
                    {hook h='displayTop'}
                </div>
            </div>
        </div>
    </div>
</div>
{hook h='displayNavFullWidth'}


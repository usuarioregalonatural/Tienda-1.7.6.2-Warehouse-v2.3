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
            <div class="col-12 col-header-left">
                <div id="desktop_logo">
                    <a href="{$urls.base_url}">
                        <img class="logo img-fluid"
                             src="{$shop.logo}" {if isset($iqitTheme.rm_logo) && $iqitTheme.rm_logo != ''} srcset="{$iqitTheme.rm_logo} 2x"{/if}
                             alt="{$shop.name}">
                    </a>
                </div>
                {hook h='displayHeaderLeft'}
            </div>
            <div class="col-12 col-header-center">
                {if isset($iqitTheme.h_txt) && $iqitTheme.h_txt}
                    <div class="header-custom-html">
                        {$iqitTheme.h_txt nofilter}
                    </div>
                {/if}

                <div class="row no-gutters justify-content-center">
                    {if !$configuration.is_catalog}
                        {hook h="litespeedEsiBegin" m="ps_shoppingcart" field="widget_block" tpl="module:ps_shoppingcart/ps_shoppingcart-default.tpl"}
                        {widget_block name="ps_shoppingcart"}
                            {include 'module:ps_shoppingcart/ps_shoppingcart-default.tpl'}
                        {/widget_block}
                        {hook h="litespeedEsiEnd"}
                    {/if}

                    {hook h="litespeedEsiBegin" m="ps_customersignin" field="widget"}
                    {widget name="ps_customersignin"}
                    {hook h="litespeedEsiEnd"}

                    {widget name="iqitsearch"}

                    {hook h="displayVerticalMenu"}

                </div>


                {hook h='displayHeaderCenter'}
            </div>

            <div class="col-12 col-header-right">
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



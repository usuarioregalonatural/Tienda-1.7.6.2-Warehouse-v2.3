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

<section id="main">

    {block name='page_header_container'}

    {/block}

    {block name='page_content_container'}


        {block name='page_header_logo'}
            <div id="maintenance-header">
                <div class="row align-items-center">
                    <div class="col-12 col-sm-6 logo-wrapper">
                        <div class="logo"><img
                                    src="{if isset($iqitTheme.mcs_logo) && $iqitTheme.mcs_logo != ''}{$iqitTheme.mcs_logo}{else}{$shop.logo}{/if}"
                                    alt="logo" class="img-fluid"></div>
                    </div>
                    {if $iqitTheme.mcs_social == 1}
                        <div class="col-12 col-sm-6 social-wrapper">
                            {include file='_elements/social-links.tpl'}
                        </div>
                    {/if}
                </div>
            </div>
        {/block}


        <section id="content" class="page-content page-maintenance ">

            <div id="inner-content" class="">
                <div class="row align-items-center">

                    <div class="col-12 {if $iqitTheme.mcs_countdown == 1}col-sm-6{else}center-text-wrapper{/if} text-wrapper">
                        {block name='page_header'}
                            <h1>{block name='page_title'}{l s='We\'ll be back soon.' d='Shop.Theme.Global'}{/block}</h1>
                        {/block}
                        {block name='page_content'}
                            {$maintenance_text nofilter}
                        {/block}
                    </div>


                    {if $iqitTheme.mcs_countdown == 1}
                        <div class="col-12 col-sm-6 countdown-wrapper">
                            {include file='errors/_maintenance/_partials/maintenance-countdown.tpl'}
                        </div>
                    {/if}

                </div>

                {if $iqitTheme.mcs_newsletter == 1}
                    <div class="newsletter-wrapper">
                        <h2>{l s='Stay in touch' d='Shop.Theme.Global'}</h2>
                        {include file='errors/_maintenance/_partials/maintenance-newsletter.tpl'}
                    </div>
                {/if}

                {block name='hook_maintenance'}
                    {$HOOK_MAINTENANCE nofilter}
                {/block}


            </div>

        </section>
    {/block}

    {block name='page_footer_container'}

    {/block}

</section>


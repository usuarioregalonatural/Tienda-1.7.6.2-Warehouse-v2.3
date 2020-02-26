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
<div id="footer-container-main" class="footer-container footer-style-1">
    <div class="container">
        <div class="row">
            {block name='hook_footer_before'}
                {hook h='displayFooterBefore'}
            {/block}
        </div>
        <div class="row">
            {block name='hook_footer'}
                {hook h='displayFooter'}
            {/block}
            {if $iqitTheme.f_newsletter_status == 1 || $iqitTheme.f_social_status == 1}
            <div class="col-12  col-md-auto">

                {if $iqitTheme.f_social_status == 1}
                {block name='socials_footer'}
                <div class="block block-footer block-toggle block-social-links js-block-toggle">
                    <h5 class="block-title"><span>{l s='Follow us' d='Shop.Warehousetheme'}</span></h5>
                    <div class="block-content">
                        {include file='_elements/social-links.tpl' class='_footer'}
                    </div>
                </div>
                {/block}
                {/if}
                {block name='newsletter_footer'}
                {if $iqitTheme.f_newsletter_status == 1}
                <div class="block block-footer block-toggle block-newsletter js-block-toggle">
                    <h5 class="block-title"><span>{l s='Newsletter' d='Shop.Warehousetheme'}</span></h5>
                    <div class="block-content">
                        {widget name="ps_emailsubscription" hook='displayFooter'}
                    </div>
                </div>
                {/if}
                {/block}
            </div>
            {/if}
        </div>
        <div class="row">
            {block name='hook_footer_after'}
                {hook h='displayFooterAfter'}
            {/block}
        </div>
    </div>
</div>
{include file='_partials/_variants/footer-copyrights-1.tpl'}

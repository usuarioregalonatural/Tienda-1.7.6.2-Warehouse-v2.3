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

{if $iqitTheme.fc_status}
    {block name='footer_copyrights'}
        <div id="footer-copyrights" class="_footer-copyrights-2 dropup">
            <div class="container">
                <div class="row">

                    {if isset($iqitTheme.fc_img) && $iqitTheme.fc_img}
                        <div class="col-12 copyright-img ">
                            <img src="{$iqitTheme.fc_img}" class="img-fluid" alt="{l s='Payments' d='Shop.Warehousetheme'}"/>
                        </div>
                    {/if}

                    {if isset($iqitTheme.fc_txt) && $iqitTheme.fc_txt}
                        <div class="col-12 copyright-txt">
                            {$iqitTheme.fc_txt nofilter}
                        </div>
                    {/if}

                    {if $iqitTheme.f_social_status == 1}
                    <div class="col-12 block-social-links">
                        {include file='_elements/social-links.tpl' class='_footer'}
                    </div>
                    {/if}

                </div>
            </div>
        </div>
    {/block}
{/if}

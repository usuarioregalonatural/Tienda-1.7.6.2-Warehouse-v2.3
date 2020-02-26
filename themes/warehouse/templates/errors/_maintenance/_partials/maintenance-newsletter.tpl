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

{widget_block name="ps_emailsubscription"}
    <div class="maintenance-page-newsletter-wrapper">

        {if $msg}
            <div class="maintenance-page-newsletter-alert {if $nw_error}alert-danger{else}alert-success{/if}">
                {$msg}
            </div>
        {/if}

        <form action="{url entity=index params=['fc' => 'module', 'module' => 'iqitemailsubscriptionconf', 'controller' => 'subscription']}"
              method="post">
            <div class="maintenance-page-newsletter">
                    <input
                            class="maintenance-page-newsletter-btn"
                            name="submitNewsletter"
                            type="submit"
                            value="{l s='Subscribe' d='Shop.Theme.Actions'}"
                    >
                    <div class="input-wrapper">
                        <input
                                name="email"
                                type="email"
                                value="{$value}"
                                placeholder="{l s='Your email address' d='Shop.Forms.Labels'}"
                        >
                    </div>
            </div>
                    <input type="hidden" name="action" value="0">
        </form>
    </div>
{/widget_block}
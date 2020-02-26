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


<div class="elementor-newsletter">
    <form action="{url entity=index params=['fc' => 'module', 'module' => 'iqitemailsubscriptionconf', 'controller' => 'subscription']}" method="post" class="elementor-newsletter-form">
        <div class="row">
            <div class="col-12">
                <input
                        class="btn btn-primary pull-right hidden-xs-down elementor-newsletter-btn"
                        name="submitNewsletter"
                        type="submit"
                        value="{l s='Subscribe' d='Shop.Theme.Actions'}"
                >
                <input
                        class="btn btn-primary pull-right hidden-sm-up elementor-newsletter-btn"
                        name="submitNewsletter"
                        type="submit"
                        value="{l s='OK'  mod='iqitelementor'}"
                >
                <div class="input-wrapper">
                    <input
                            name="email"
                            class="form-control elementor-newsletter-input"
                            type="email"
                            value=""
                            placeholder="{l s='Your email address' d='Shop.Forms.Labels'}"
                    >
                </div>
                <input type="hidden" name="action" value="0">
                {if isset($id_module)}
                    <div class="mt-2 text-muted"> {hook h='displayGDPRConsent' id_module=$id_module}</div>
                {/if}
            </div>
        </div>
    </form>
</div>
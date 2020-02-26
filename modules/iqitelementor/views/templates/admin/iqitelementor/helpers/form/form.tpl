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

{extends file="helpers/form/form.tpl"}

{block name="input_row"}
    {if $input.type == 'elementor_trigger'}

        <div class="form-group">
            <label class="control-label col-lg-3"></label>
            <div class="col-lg-9">
                {if $input.url}
                    <a href="{$input.url|escape:'html':'UTF-8'}" class="m-b-2 m-r-1 btn pointer btn-edit-with-elementor"><i class="icon-external-link"></i> {l s='Edit with Elementor - Visual Page Builder' mod='iqitelementor'}</a>
                {else}
                    {l s=' Save page first to enable page builder' mod='iqitelementor'}
                {/if}
            </div>
        </div>

    {else}
        {$smarty.block.parent}
    {/if}
{/block}

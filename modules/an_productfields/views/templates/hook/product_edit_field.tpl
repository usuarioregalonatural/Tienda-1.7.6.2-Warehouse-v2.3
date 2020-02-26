{**
* 2019 Anvanto
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
*  @author Anvanto (anvantoco@gmail.com)
*  @copyright  2019 anvanto.com

*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div class="row">
    <div class="control-label col-md-5" style="padding-top: 2px;">
        {if !$an_disabledfield}
            <input type="checkbox" data-toggle="switch" name="{$inputName|escape:'htmlall':'UTF-8'}[is_enabled]"{if $productData != false && $productData->is_enabled} checked="checked"{/if} />
        {else}
            <b style="float: left;border-bottom: solid #25b9d7;">{l s='Activated with field settings' mod='an_productfields'}</b>
        {/if}
    </div>
    <div class="control-label col-md-7">
        {if !$an_disabledfield}<input type="text" class="form-control" style="width:150px;" name="{$inputName|escape:'html':'UTF-8'}[position]" value="{if $productData != false}{$productData->position|escape:intval}{/if}"/>{/if}
    </div>
</div>

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
{if count($an_attributes)}
    <div id="an_productfields" class="an_productfields">
        <input type="hidden" name="an_productfields" value="1"/>
        {if $an_pf_header_text != ''}
            <h3 class="page-heading"{if !$an_new} style="text-transform: none;"{/if}>
                {$an_pf_header_text|escape:'htmlall':'UTF-8'}
                {*l s='Additional information' mod='an_productfields'*}
            </h3>
        {/if}
        {foreach from=$an_attributes item=attribute}
            {assign var=input_name value='an_productfields_'|cat:$attribute->id}
            <div id="{$input_name|escape:'htmlall':'UTF-8'}" class="form-group {if $attribute->required eq 1}required {/if}{if $attribute->type eq 'radio'} {elseif $attribute->type eq 'textarea'} textarea{elseif ($attribute->type eq 'multiselect' || $attribute->type eq 'dropdown')}select{else}text{/if}">
                {if $attribute->type eq 'radio' || $attribute->type eq 'checkbox'}
                    <label>{$attribute->name|escape:'htmlall':'UTF-8'}{if $attribute->required eq 1}<sup style="color: red;">*</sup>{/if}
                    </label>

                {else}
                    <label for="{$input_name|escape:'htmlall':'UTF-8'}" class="label-title">
                        {$attribute->name|escape:'htmlall':'UTF-8'}{if $attribute->required eq 1}<sup style="color: red;">*</sup>{/if}
                    </label>
                {/if}
                {if $attribute->price neq 0}(+{Tools::displayPrice(Tools::convertPrice($attribute->price))}){/if}
                {if $attribute->type eq 'text'}
                    <input type="text" class="text form-control an_pf_text" id="{$input_name|escape:'htmlall':'UTF-8'}"
                           name="{$input_name|escape:'htmlall':'UTF-8'}"
                           placeholder="{$attribute->placeholder|escape:'htmlall':'UTF-8'}"
                            {if $attribute->max_text_length|intval != 0}
                                maxlength="{$attribute->max_text_length|intval}"
                            {/if} value="{*$customer_value*}"
                           data-pricemain="{if $attribute->price neq 0}{$attribute->price}{else}0{/if}"
                    >
                    <div class="symbol_counter" id="counter_{$input_name|escape:'htmlall':'UTF-8'}"></div>
                {elseif $attribute->type eq 'textarea'}
                    <textarea name="{$input_name|escape:'htmlall':'UTF-8'}" id="{$input_name|escape:'htmlall':'UTF-8'}"
                            {if $attribute->max_text_length|intval != 0}
                                maxlength="{$attribute->max_text_length|intval}"
                            {/if}
                              class="form-control an_pf_textarea"
                              data-pricemain="{if $attribute->price neq 0}{$attribute->price}{else}0{/if}"
                    >{*$customer_value*}</textarea>
                    <div class="symbol_counter" id="counter_{$input_name|escape:'htmlall':'UTF-8'}"></div>
                {elseif $attribute->type eq 'date'}
                    <input type="text" class="text an_date form-control"
                           id="{$input_name|escape:'htmlall':'UTF-8'}" name="{$input_name|escape:'htmlall':'UTF-8'}"
                           value="{*$customer_value*}"
                           data-pricemain="{if $attribute->price neq 0}{$attribute->price}{else}0{/if}"
                    >
                    <!--                     <style>
                                            div#ui-datepicker-div {
                                                z-index: 9999 !important;
                                            }
                                        </style> -->
                {elseif $attribute->type eq 'radio'}
                    <div class="clearfix">
                        {foreach from=$attribute->getValues() item=value key=id}
                            <div  class="radio-inline an_radio" {if !$an_new}style="display: block;"{else}style="display: inline-block;"{/if}>
                                <label class="top"style="min-width: 7px">
                                    <input type="radio" name="{$input_name|escape:'htmlall':'UTF-8'}"
                                           id="{$input_name|escape:'htmlall':'UTF-8'}_{$id|intval}"
                                           value="{$value|escape:'htmlall':'UTF-8'}"{*if $customer_value eq $value} checked="checked"{/if*}
                                           class="{$value|escape:'htmlall':'UTF-8'}"
                                           data-price="{Module::getInstanceByName('an_productfields')->getPriceFromValue($value, false)|escape:'htmlall':'UTF-8'}"
                                           data-pricemain="{if $attribute->price neq 0}{$attribute->price}{else}0{/if}"
                                           class="form-control">
                                    <div class="{$value|escape:'htmlall':'UTF-8'}"> {Module::getInstanceByName('an_productfields')->cleanFromPrice($value)|escape:'htmlall':'UTF-8'}
                                        {Module::getInstanceByName('an_productfields')->getPriceFromValue($value)|escape:'htmlall':'UTF-8'}</div>
                                </label>
                            </div>
                        {/foreach}
                    </div>
                {elseif $attribute->type eq 'checkbox'}
                    <div class="clearfix">
                        {foreach from=$attribute->getValues() item=value key=id}
                            <div class="radio-inline an_radio" {if !$an_new}style="display: block;"{else}style="display: inline-block;"{/if}>
                                <label class="top" style="min-width: 7px">
                                    <input type="checkbox" name="{$input_name|escape:'htmlall':'UTF-8'}[]"
                                           id="{$input_name|escape:'htmlall':'UTF-8'}_{$id|intval}"
                                           value="{$value|escape:'htmlall':'UTF-8'}"{*if $customer_value eq $value} checked="checked"{/if*}
                                           class="{$value|escape:'htmlall':'UTF-8'}"
                                           data-price="{Module::getInstanceByName('an_productfields')->getPriceFromValue($value, false)|escape:'htmlall':'UTF-8'}"
                                           data-pricemain="{if $attribute->price neq 0}{$attribute->price}{else}0{/if}"
                                           class="form-control">
                                    {Module::getInstanceByName('an_productfields')->cleanFromPrice($value)|escape:'htmlall':'UTF-8'}
                                    {Module::getInstanceByName('an_productfields')->getPriceFromValue($value)|escape:'htmlall':'UTF-8'}
                                </label>
                            </div>
                        {/foreach}
                    </div>
                {elseif $attribute->type eq 'multiselect'}
                    <select name="{$input_name|escape:'htmlall':'UTF-8'}[]" id="{$input_name|escape:'htmlall':'UTF-8'}"
                            multiple="multiple" size="{$attribute->getValues()|@count}" style="width: 372px;" class="form-control">
                        {foreach from=$attribute->getValues() item=value key=id}
                            <option {*if in_array($value, $customer_value)}selected="selected" {/if*}
                                    value="{$value|escape:'htmlall':'UTF-8'}"
                                    class="{$value|escape:'htmlall':'UTF-8'}"
                                    data-price="{Module::getInstanceByName('an_productfields')->getPriceFromValue($value, false)|escape:'htmlall':'UTF-8'}"
                                    data-pricemain="{if $attribute->price neq 0}{$attribute->price}{else}0{/if}"
                            >
                                {Module::getInstanceByName('an_productfields')->cleanFromPrice($value)|escape:'htmlall':'UTF-8'}
                                {Module::getInstanceByName('an_productfields')->getPriceFromValue($value)|escape:'htmlall':'UTF-8'}
                            </option>
                        {/foreach}
                    </select>
                {elseif $attribute->type eq 'dropdown'}
                    <select name="{$input_name|escape:'htmlall':'UTF-8'}" id="{$input_name|escape:'htmlall':'UTF-8'}"
                            style="width: 372px;" class="form-control">
                        {foreach from=$attribute->getValues() item=value key=id}
                            <option {*if $customer_value eq $value}selected="selected" {/if*}
                                    value="{$value|escape:'htmlall':'UTF-8'}"
                                    class="{$value|escape:'htmlall':'UTF-8'}"
                                    data-price="{Module::getInstanceByName('an_productfields')->getPriceFromValue($value, false)|escape:'htmlall':'UTF-8'}"
                                    data-pricemain="{if $attribute->price neq 0}{$attribute->price}{else}0{/if}"
                            >
                                {Module::getInstanceByName('an_productfields')->cleanFromPrice($value)|escape:'htmlall':'UTF-8'}
                                {Module::getInstanceByName('an_productfields')->getPriceFromValue($value)|escape:'htmlall':'UTF-8'}
                            </option>
                        {/foreach}
                    </select>
                {elseif $attribute->type eq 'image'}
                    <input type="file" class="text form-control image" name="{$input_name|escape:'htmlall':'UTF-8'}"
                           id="{$input_name|escape:'htmlall':'UTF-8'}"/>
                {/if}
            </div>
        {/foreach}
    </div>
    <script>
        {literal}
        var an_translator = {
            {/literal}
            error_title: '{l s='Oops...' mod='an_productfields' js=1}',
            error_content: '{l s='Please fill the required fields.' mod='an_productfields' js=1}'
            {literal}
        };
        {/literal}
    </script>
{/if}
{if !$an_new}
    <style>
        #an_productfields .form-group, #an_productfields .page-heading{
            margin: 10px;
        }
        .an_radio{
            margin-left: 0px !important;
            float:none !important;
        }
    </style>
{/if}
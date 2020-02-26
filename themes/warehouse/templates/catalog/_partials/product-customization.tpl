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

{if !$configuration.is_catalog}
    <div class="product-customization">
        <p class="h4">{l s='Product customization' d='Shop.Theme.Catalog'}</p>
        {l s='Don\'t forget to save your customization to be able to add to cart' d='Shop.Forms.Help'}

        {block name='product_customization_form'}
            <form method="post" action="{$product.url}" enctype="multipart/form-data">
                <ul class="clearfix">
                    {foreach from=$customizations.fields item="field"}
                        <li class="product-customization-item">
                            <label> {$field.label}</label>
                            {if $field.type == 'text'}
                                <textarea placeholder="{l s='Your message here' d='Shop.Forms.Help'}"
                                          class="form-control product-message"
                                          maxlength="250" {if $field.required} required {/if}
                                          name="{$field.input_name}">{if $field.text !== ''}{$field.text}{/if}</textarea>
                                <div class="clearfix">{if !$field.required}
                                        <small class="pull-left">{l s='optional' d='Shop.Forms.Help'}</small>{/if}
                                    <small class="pull-right">{l s='250 char. max' d='Shop.Forms.Help'}</small>
                                 
                                </div>
                                   {if $field.text !== ''}
                                       <div class="clearfix mt-3"> <h6 class="customization-message float-left">{l s='Your customization:' d='Shop.Theme.Catalog'}
                                            <label>{$field.text}</label>
                                        </h6></div>
                                    {/if}
                            {elseif $field.type == 'image'}
                                <input class="filestyle file-input js-file-input" {if $field.required} required {/if}
                                       type="file" name="{$field.input_name}" data-buttontext="{l s='Choose file' d='Shop.Theme.Actions'}">
                                <div class="clearfix">{if !$field.required}
                                    <small class="pull-left">{l s='optional' d='Shop.Forms.Help'}</small>{/if}
                                <small class="pull-right">{l s='.png .jpg .gif' d='Shop.Forms.Help'}</small>
                                </div>

                                {if $field.is_customized}
                                    <img src="{$field.image.small.url}">
                                    <a class="remove-image" href="{$field.remove_image_url}" rel="nofollow"><i
                                                class="fa fa-trash-o" aria-hidden="true"></i></a>
                                {/if}
                            {/if}
                        </li>
                    {/foreach}
                </ul>
                <div class="clearfix mt-2">
                    <button class="btn btn-secondary btn-block" type="submit"
                            name="submitCustomizedData">{l s='Save Customization' d='Shop.Theme.Actions'}</button>
                </div>
            </form>
        {/block}
    </div>
{/if}






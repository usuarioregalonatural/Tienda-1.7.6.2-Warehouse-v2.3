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

{if isset($anProductLines)}
    <div class="an-productfields-line">
        {foreach from=$anProductLines item=line}
            <br/>
            {foreach from=$line.lines item=fields}
                <div class="product-line-info">
                    <span class="label">{$fields.label|escape:'htmlall':'UTF-8'}:</span>

                    {assign var="string" value="{$fields.value|escape:'htmlall':'UTF-8'}"}
                    {assign var="aValues" value=";"|explode:$string}

                    {foreach from=$aValues item=value}
                        <div class="extra-values">
                            {Module::getInstanceByName('an_productfields')->cleanFromPrice($value)}
                        </div>
                    {/foreach}
                </div>
            {/foreach}
            <br/>
            <a href="#" data-hash="{$line.hash|escape:'htmlall':'UTF-8'}" class="an-remove-line{if $new} label{/if}"{if !$new} style="color: black"{/if}>{l s='Remove' mod='an_productfields'}</a>
        {/foreach}
    </div>
{/if}

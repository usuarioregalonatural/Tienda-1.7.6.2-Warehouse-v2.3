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

<div class="tab-pane box" id="an_product_fields">
    {foreach $product_fields as $key => $field}
        <h4 class="page-heading bottom-indent">
            {l s='Product fields for ' mod='an_productfields'} {$field.reference|escape:'htmlall':'UTF-8'}
            _{$field.product|escape:'htmlall':'UTF-8'}.
            <br>{l s='QTY:' mod='an_productfields'} {$field.qty|intval}
        </h4>
        <div class="table-responsive">
            <table class="table" id="documents_table">
                <thead>
                <tr>
                    <th>
                        <span class="title_box "><b>{l s='Field' mod='an_productfields'}</b></span>
                    </th>
                    <th>
                        <span class="title_box "><b>{l s='Value' mod='an_productfields'}</b></span>
                    </th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                {foreach $field.fields as $value}
                    <tr>
                        <td>
                            {$value->name|escape:'htmlall':'UTF-8'}:
                        </td>
                        <td>
                            {$value->value|escape:'htmlall':'UTF-8'}
                        </td>
                        <td></td>
                    </tr>
                {/foreach}
                </tbody>
            </table>
        </div>
    {/foreach}
</div>

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
*  International Registered tdademark & Property of PrestaShop SA
*}


{foreach $product_fields as $key => $field}
<table style="border: solid 1pt black; padding:0 10pt">
    <tr><td></td><td></td></tr>
    <tr><td><b>{l s='Product fields for ' mod='an_productfields'} </b></td><td>{$field.product|escape:'htmlall':'UTF-8'} {$field.reference|escape:'htmlall':'UTF-8'}</td></tr>
    <tr><td></td><td></td></tr>
    {foreach $field.fields as $value}
        <tr><td><b>{$value->name|escape:'htmlall':'UTF-8'}</b></td><td>{$value->value|escape:'htmlall':'UTF-8'},{$value->price|escape:'htmlall':'UTF-8'}</td></tr>
    {/foreach}
    <tr><td></td><td></td></tr>
</table>
{/foreach}
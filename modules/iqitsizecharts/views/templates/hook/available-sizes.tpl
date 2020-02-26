{*
* 2017 IQIT-COMMERCE.COM
*
* NOTICE OF LICENSE
*
* This file is licenced under the Software License Agreement.
* With the purchase or the installation of the software in your application
* you accept the licence agreement
*
* @author    IQIT-COMMERCE.COM <support@iqit-commerce.com>
* @copyright 2017 IQIT-COMMERCE.COM
* @license   Commercial license (You can not resell or redistribute this software.)
*
*}

{if isset($avaiableSizes) && $avaiableSizes}
    <div class="iqitsizeguide-avaiable-sizes pt-2">
    {foreach from=$avaiableSizes item="size"}
        <span {if !$size.available}class="unavailable-size"{/if}>{$size.attribute_name}</span>
    {/foreach}
    </div>
{/if}
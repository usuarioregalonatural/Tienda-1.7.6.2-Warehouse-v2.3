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

<div id="iqitproductsnav">
    {if isset($previous)}
        <a href="{$previous}" title="{l s='Previous product' mod='iqitproductsnav'}">
            <i class="fa fa-angle-left" aria-hidden="true"></i>
        </a>
    {/if}
    {if isset($next)}
        <a href="{$next}" title="{l s='Next product' mod='iqitproductsnav'}">
            <i class="fa fa-angle-right" aria-hidden="true"></i>
        </a>
    {/if}
</div>

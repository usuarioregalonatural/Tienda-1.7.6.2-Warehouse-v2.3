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

{if isset($tags)}
    <div class="iqitproducttags">
        <ul>
            {foreach from=$tags item=tag key=i}
                <li><a href="{url entity='search' params=['tag' => $tag|urlencode]}" class="tag tag-default">{$tag}</a>
                </li>
            {/foreach}
        </ul>
    </div>
{/if}

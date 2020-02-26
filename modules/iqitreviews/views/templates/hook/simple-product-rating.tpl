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

{if $snippetData.reviewsNb > 0}
    <div class="iqitreviews-simple" >

        <span class="iqitreviews-rating">
        {math equation="floor(x)" x=$snippetData.avarageRating assign=stars}
        {section name="i" start=0 loop=5 step=1}
            {if ($stars - $smarty.section.i.index) >= 1 }
                <i class="fa fa-star iqit-review-star"></i>
            {elseif $snippetData.avarageRating - $smarty.section.i.index > 0}
                <i class="fa fa-star-half-o iqit-review-star"></i>
            {else}
                <i class="fa fa-star-o iqit-review-star"></i>
            {/if}
        {/section}
        </span>
        <span class="iqitreviews-nb">{$snippetData.reviewsNb} {l s='Reviews' mod='iqitreviews'}</span>
    </div>
{/if}

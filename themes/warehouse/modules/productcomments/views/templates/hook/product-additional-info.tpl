{**
 * 2007-2019 PrestaShop and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2019 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}



{if $nb_comments != 0}
    <div class="product-comments-additional-info iqitreviews-simple">
        <span class="iqitreviews-rating">
        {math equation="floor(x)" x=$average_grade assign=stars}
            {section name="i" start=0 loop=5 step=1}
                {if ($stars - $smarty.section.i.index) >= 1 }
                    <i class="fa fa-star iqit-review-star"></i>
            {elseif $average_grade- $smarty.section.i.index > 0}
                <i class="fa fa-star-half-o iqit-review-star"></i>
            {else}
                <i class="fa fa-star-o iqit-review-star"></i>
                {/if}
            {/section}
        </span>


        <a class="link-comment" href="#product-comments-list-header">
            {l s='Read user reviews' d='Modules.Productcomments.Shop'} ({$nb_comments})
        </a>


        {* Rich snippet rating*}
        <div itemprop="aggregateRating" itemtype="http://schema.org/AggregateRating" itemscope>
            <meta itemprop="reviewCount" content="{$nb_comments}" />
            <meta itemprop="ratingValue" content="{$average_grade}" />
        </div>
    </div>
{/if}






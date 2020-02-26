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

<div class="ms-alphabetical">

    {if $brands}
        {block name='brands_letter_selector'}
            <div class="ms-letter-selector">
                {foreach from=$brands item=brand name=brands}
                    {if !isset($currentLetterSelector)}

                        {$currentLetterSelector = $brand.name|substr:0:1}
                        <a href="#man-letter-{if in_array($currentLetterSelector, array('0','1','2','3','4','5','6','7','8','9'))}1{else}{$currentLetterSelector}{/if}">
                            {if in_array($currentLetterSelector, array('0','1','2','3','4','5','6','7','8','9'))}0-9{$currentLetterSelector = 1}{else}{$brand.name|substr:0:1}{/if}
                        </a>
                        {if !$smarty.foreach.brands.last}<span class="ms-l-sep">/</span>{/if}

                    {elseif isset($currentLetterSelector) && $currentLetterSelector|upper != $brand.name|substr:0:1|upper && (string)($brand.name|substr:0:1) != (string)((int)($brand.name|substr:0:1))}

                        {$currentLetterSelector = $brand.name|substr:0:1}
                        <a href="#man-letter-{$currentLetterSelector}">{$brand.name|substr:0:1}</a>
                        {if !$smarty.foreach.brands.last}<span class="ms-l-sep">/</span>{/if}

                    {/if}

                    {$alphabeticalBrands[$currentLetterSelector][]=$brand}

                {/foreach}
            </div>
        {/block}
        <div class="ms-letter-lists">
            {block name='brands_letter'}
                {foreach from=$alphabeticalBrands key=letter item=letterBrands}
                    <a
                            name="man-letter-{$letter}"></a>
                    <div class="ms-letter-list">
                        <div class="ms-letter">{if $letter == 1}0-9{else}{$letter}{/if}</div>

                        <div class="ms-letter-brands">
                            <div class="row">
                                {math equation="ceil(x/4)" x=($letterBrands|@count) assign=brandsPerColumn}
                                <div class="col col-sm-3">
                                    <ul>
                                        {section loop=$letterBrands name=id}
                                        <li><a href="{$letterBrands[id].url}">{$letterBrands[id].name}</a></li>
                                        {if $smarty.section.id.iteration % $brandsPerColumn == 0}
                                    </ul>
                                </div>
                                <div class="col col-sm-3">
                                    <ul>
                                        {/if}
                                        {/section}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                {/foreach}
            {/block}
        </div>
    {/if}

</div>



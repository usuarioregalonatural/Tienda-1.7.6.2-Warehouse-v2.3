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
{foreach $linkBlocks as $linkBlock}
    {if $linkBlock.hook == 'displayNav1' || $linkBlock.hook == 'displayNav2'}
        <div class="block-iqitlinksmanager block-iqitlinksmanager-{$linkBlock.id} block-links-inline d-inline-block">
            <ul>
                {foreach $linkBlock.links as $link}
                    {if isset($link.data.url) && isset($link.data.title)}
                        <li>
                            <a
                                    href="{$link.data.url}"
                                    {if isset($link.data.description)}title="{$link.data.description}"{/if}
                            >
                                {$link.data.title}
                            </a>
                        </li>
                    {/if}
                {/foreach}
            </ul>
        </div>
    {elseif $linkBlock.hook == 'displayLeftColumn' || $linkBlock.hook == 'displayRightColumn'}
        <div class="block block-toggle block-iqitlinksmanager block-iqitlinksmanager-{$linkBlock.id} block-links js-block-toggle">
            <h5 class="block-title"><span>{$linkBlock.title}</span></h5>
            <div class="block-content">
                <ul>
                    {foreach $linkBlock.links as $link}
                        {if isset($link.data.url) && isset($link.data.title)}
                            <li>
                                <a
                                        href="{$link.data.url}"
                                        {if isset($link.data.description)}title="{$link.data.description}"{/if}
                                >
                                    {$link.data.title}
                                </a>
                            </li>
                        {/if}
                    {/foreach}
                </ul>
            </div>
        </div>
    {else}
        <div class="col col-md block block-toggle block-iqitlinksmanager block-iqitlinksmanager-{$linkBlock.id} block-links js-block-toggle">
            <h5 class="block-title"><span>{$linkBlock.title}</span></h5>
            <div class="block-content">
                <ul>
                    {foreach $linkBlock.links as $link}
                        {if isset($link.data.url) && isset($link.data.title)}
                            <li>
                                <a
                                        href="{$link.data.url}"
                                        {if isset($link.data.description)}title="{$link.data.description}"{/if}
                                >
                                    {$link.data.title}
                                </a>
                            </li>
                        {/if}
                    {/foreach}
                </ul>
            </div>
        </div>
    {/if}
{/foreach}

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

{if $block.content.options.view == 'list'}
    <div id="iqithtmlandbanners-block-{$block.id}" class="iqithtmlandbanners-block iqithtmlandbanners-block-banner iqithtmlandbanners-block-banner-list mb-4">
        {foreach from=$block.content.banners item=banner}
            {if $banner.link != ''}<a href="{$banner.link}">{/if}
            <img src="{$banner.image}"  alt="{$banner.image}" class="img-fluid mb-3">
            {if $banner.link != ''}</a>{/if}
        {/foreach}
    </div>
{else}
    <div id="iqithtmlandbanners-block-{$block.id}" class="iqithtmlandbanners-block iqithtmlandbanners-block-banner iqithtmlandbanners-block-banner-slider slick-slider js-iqithtmlandbanners-block-banner-slider mb-4">
        {foreach from=$block.content.banners item=banner}
            <div>
            {if $banner.link != ''}<a href="{$banner.link}">{/if}
                <img src="{$banner.image}"  alt="{$banner.image}" class="img-fluid">
            {if $banner.link != ''}</a>{/if}
            </div>
        {/foreach}
    </div>
{/if}

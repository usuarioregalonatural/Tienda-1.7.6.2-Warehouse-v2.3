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

{if $block.hook == 'displayNav1' || $block.hook == 'displayNav2' || $block.hook == 'displayNavCenter'}
    <div id="iqithtmlandbanners-block-{$block.id}"  class="d-inline-block">
        <div class="rte-content d-inline-block">
            {$block.content nofilter}
        </div>
    </div>
{elseif $block.hook == 'displayProductAdditionalInfo' || $block.hook == 'displayWrapperTopInContainer' || $block.hook == 'displayWrapperTop'}
    <div id="iqithtmlandbanners-block-{$block.id}">
        <div class="rte-content">
            {$block.content nofilter}
        </div>
    </div>
{elseif $block.hook == 'displayLeftColumn' || $block.hook == 'displayRightColumn'}
    <div id="iqithtmlandbanners-block-{$block.id}"  class="block block-toggle block-iqithtmlandbanners-html js-block-toggle">
        <h5 class="block-title"><span>{$block.title}</span></h5>
        <div class="block-content rte-content">
            {$block.content nofilter}
        </div>
    </div>
{elseif $block.hook == 'displayMyAccountDashboard'}
    <div id="iqithtmlandbanners-block-{$block.id}"  class="col {if $block.width == 0}col-md{else}col-md-{$block.width}{/if} block block-toggle block-iqithtmlandbanners-html mt-4 js-block-toggle">
        <h5 class="block-title"><span>{$block.title}</span></h5>
        <div class="block-content rte-content">
            {$block.content nofilter}
        </div>
    </div>
{else}
    <div id="iqithtmlandbanners-block-{$block.id}"  class="col {if $block.width == 0}col-md{else}col-md-{$block.width}{/if} block block-toggle block-iqithtmlandbanners-html js-block-toggle">
        <h5 class="block-title"><span>{$block.title}</span></h5>
        <div class="block-content rte-content">
            {$block.content nofilter}
        </div>
    </div>
{/if}



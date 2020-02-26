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

{if isset($to) && $to != '0000-00-00 00:00:00'}
    <div class="price-countdown-wrapper">
        <div class="price-countdown badge-discount discount">
            <span class="price-countdown-title"><i class="fa fa-clock-o fa-spin" aria-hidden="true"></i> <span
                        class="time-txt">{l s='Time left' mod='iqitcountdown'}</span></span>
            <div class="count-down-timer" id="price-countdown-product" data-countdown-product="{$to}"></div>
        </div>
    </div>
{/if}
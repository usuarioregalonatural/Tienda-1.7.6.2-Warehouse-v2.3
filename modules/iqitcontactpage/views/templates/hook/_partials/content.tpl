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

{block name='iqitcontactpage-info'}
    <div class="contact-rich">
            {if $company} <strong>{$company}</strong>{/if}
            {if $address}
            <div class="part">
                <div class="icon"><i class="fa fa-map-marker" aria-hidden="true"></i></div>
                <div class="data">{$address|nl2br nofilter}</div>
            </div>
            {/if}
            {if $phone}
                <hr/>
                <div class="part">
                    <div class="icon"><i class="fa fa-phone" aria-hidden="true"></i></div>
                    <div class="data">
                        <a href="tel:{$phone}">{$phone}</a>
                    </div>
                </div>
            {/if}
            {if $mail}
                <hr/>
                <div class="part">
                    <div class="icon"><i class="fa fa-envelope-o" aria-hidden="true"></i></div>
                    <div class="data email">
                        <a href="mailto:{$mail}">{$mail}</a>
                    </div>
                </div>
            {/if}
    </div>
{/block}

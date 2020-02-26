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
    <div class="col-sm-4 contact-page-info">
        {include 'module:iqitcontactpage/views/templates/hook/_partials/content.tpl'}
            {if $content}
                <hr/>
                <div class="part">
                    {$content|nl2br nofilter}
                </div>
            {/if}
    </div>
{/block}

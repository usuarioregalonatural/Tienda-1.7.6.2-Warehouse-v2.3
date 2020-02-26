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

{block name='iqitcontactpage-map'}
{if $show_map}
    <div id="iqitcontactpage-map">
        <iframe frameborder="0" marginheight="0" style="border:0" allowfullscreen marginwidth="0" src="https://maps.google.com/maps?q={$point.latitude},{$point.longitude}&t=m&z=10&output=embed&iwloc=near"></iframe>
    </div>
{/if}
{/block}
{*
* 2017 IQIT-COMMERCE.COM
*
* @author    IQIT-COMMERCE.COM <support@iqit-commerce.com>
* @copyright 2017 IQIT-COMMERCE.COM
* @license   Commercial license (You can not resell or redistribute this software.)
*
*}

<div class="additional_button">
    {$addthisplugin_content nofilter}

</div>
{if isset($addthisplugin_id) && ($addthisplugin_id == "0")}
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-50d44b832bee7204"></script>
{else}
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid={$addthisplugin_id}"></script>
{/if}
{*
* 2017 IQIT-COMMERCE.COM
*
* @author    IQIT-COMMERCE.COM <support@iqit-commerce.com>
* @copyright 2017 IQIT-COMMERCE.COM
* @license   Commercial license (You can not resell or redistribute this software.)
*
*}
{extends file='page.tpl'}

{block name='page_content'}
    {if isset($message)}
    <h1 class="h1 page-title"><span>{l s='Problem with login' mod='iqitsociallogin'}</span></h1>
    <p class="alert alert-warning">{l s='There is some problem with login. Please use traditional login/registration' mod='iqitsociallogin'}</p>
    {else}
        {if $popup}
            <script type="text/javascript">
                {literal}
                    window.opener.location.reload();
                    self.close();
                {/literal}
            </script>
        {/if}
    {/if}
{/block}


{if $facebook_status || $google_status ||  $twitter_status ||  $instagram_status}
<div class="iqitsociallogin iqitsociallogin-checkout iqitsociallogin-colors-{$btn_colors} pb-3 pt-1">
        <span class="text-muted pr-1">{l s='Or connect with social account:' mod='iqitsociallogin'}</span>

    {if $facebook_status}
        <a {if $type}
                onclick="iqitSocialPopup('{url entity='module' name='iqitsociallogin' controller='authenticate' params=['provider' => 'facebook', 'page' => $page]}')"
            {else}
                href="{url entity='module' name='iqitsociallogin' controller='authenticate' params=['provider' => 'facebook', 'page' => $page]}"
            {/if}
           class="btn btn-secondary btn-iqitsociallogin btn-facebook btn-sm mt-1 mb-1">
            <i class="fa fa-facebook-square" aria-hidden="true"></i>
            {l s='Facebook' mod='iqitsociallogin'}
        </a>
    {/if}

    {if $google_status}
        <a {if $type}
                onclick="iqitSocialPopup('{url entity='module' name='iqitsociallogin' controller='authenticate' params=['provider' => 'google', 'page' => $page]}')"
            {else}
                href="{url entity='module' name='iqitsociallogin' controller='authenticate' params=['provider' => 'google', 'page' => $page]}"
            {/if}
           class="btn btn-secondary btn-iqitsociallogin btn-google btn-sm mt-1 mb-1">
            <i class="fa fa-google-plus-square" aria-hidden="true"></i>
            {l s='Google+' mod='iqitsociallogin'}
        </a>
    {/if}

    {if $instagram_status}
        <a {if $type}
                onclick="iqitSocialPopup('{url entity='module' name='iqitsociallogin' controller='authenticate' params=['provider' => 'instagram', 'page' => $page]}')"
            {else}
                href="{url entity='module' name='iqitsociallogin' controller='authenticate' params=['provider' => 'instagram', 'page' => $page]}"
            {/if}
           class="btn btn-secondary btn-iqitsociallogin btn-instagram btn-sm mt-1 mb-1">
            <i class="fa fa-instagram" aria-hidden="true"></i>
            {l s='Instagram' mod='iqitsociallogin'}
        </a>
    {/if}

    {if $twitter_status}
        <a {if $type}
                onclick="iqitSocialPopup('{url entity='module' name='iqitsociallogin' controller='authenticate' params=['provider' => 'twitter', 'page' => $page]}')"
            {else}
                href="{url entity='module' name='iqitsociallogin' controller='authenticate' params=['provider' => 'twitter', 'page' => $page]}"
            {/if}
           class="btn btn-secondary btn-iqitsociallogin btn-twitter btn-sm mt-1 mb-1">
            <i class="fa fa-twitter-square" aria-hidden="true"></i>
            {l s='Twitter' mod='iqitsociallogin'}
        </a>
    {/if}
</div>
{/if}

<script type="text/javascript">
    {literal}
    function iqitSocialPopup(url) {
        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
        var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;
        var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;
        var left = ((width / 2) - (960 / 2)) + dualScreenLeft;
        var top = ((height / 2) - (600 / 2)) + dualScreenTop;
        var newWindow = window.open(url, '_blank', 'scrollbars=yes,top=' + top + ',left=' + left + ',width=960,height=600');
        if (window.focus) {
            newWindow.focus();
        }
    }
    {/literal}
</script>





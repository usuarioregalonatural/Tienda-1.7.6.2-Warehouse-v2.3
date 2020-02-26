<div id="user_info">
    {if $logged}
        <a
                class="account"
                href="{$my_account_url}"
                title="{l s='View my customer account' d='Shop.Theme.Customeraccount'}"
                rel="nofollow"
        >
            <i class="fa fa-user" aria-hidden="true"></i>
            <span>{$customer.firstname|truncate:15:'...'}</span>
        </a> <span class="text-faded"> / </span>
        <a
                class="logout"
                href="{$logout_url}"
                rel="nofollow"
        >
            <span >{l s='Sign out' d='Shop.Theme.Actions'}</span>
        </a>
    {else}
        <a
                href="{$my_account_url}"
                title="{l s='Log in to your customer account' d='Shop.Theme.Customeraccount'}"
                rel="nofollow"
        ><i class="fa fa-user" aria-hidden="true"></i>
            <span>{l s='Sign in' d='Shop.Theme.Actions'}</span>
        </a>
    {/if}
</div>

{if Configuration::get('PH_BLOG_DISPLAY_MORE')}
<div class="simpleblog__listing__post__wrapper__content__footer">
    <a href="{$post.url}" class="btn btn-primary">
        {l s='Read more' mod='ph_simpleblog'}
    </a>
    {if $is_category eq false && Configuration::get('PH_BLOG_DISPLAY_CATEGORY')}
    <div class="simpleblog__listing__post__wrapper__content__footer__category">
        <i class="material-icons">label</i> <a href="{$post.category_url}" title="{$post.category}" rel="category">{$post.category}</a>
    </div>
    {/if}
</div>
{/if}
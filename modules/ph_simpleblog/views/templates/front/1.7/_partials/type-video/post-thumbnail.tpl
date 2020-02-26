{if Configuration::get('PH_BLOG_DISPLAY_THUMBNAIL') && (isset($post.banner_wide) || isset($post.banner_thumb))}
<a href="{$post.url}" title="{$post.title}">
    {if $blogLayout eq 'full'}
        <img src="{$post.banner_wide}" alt="{$post.title}" class="img-fluid photo">
    {else}
        <img src="{$post.banner_thumb}" alt="{$post.title}" class="img-fluid photo">
    {/if}
</a>
{else}
<div itemprop="video">
{$post.video_code nofilter}
</div>
{/if}
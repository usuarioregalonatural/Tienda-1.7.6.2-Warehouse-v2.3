<div class="simpleblog__listing__post__wrapper__footer">
    <div class="row">
        {if Configuration::get('PH_BLOG_DISPLAY_DATE')}
        <div class="simpleblog__listing__post__wrapper__footer__block col-md-6 col-xs-12">
            <i class="material-icons">label</i> <time datetime="{$post.date_add|date_format:'c'}">{$post.date_add|date_format:Configuration::get('PH_BLOG_DATEFORMAT')}</time>
        </div>
        {/if}
        {if isset($post.author) && !empty($post.author) && Configuration::get('PH_BLOG_DISPLAY_AUTHOR')}
        <div class="simpleblog__listing__post__wrapper__footer__block col-md-6 col-xs-12">
            <i class="material-icons">perm_identity</i> <span>{$post.author}</span>
        </div>
        {/if}
        {if $post.allow_comments eq true && Configuration::get('PH_BLOG_COMMENTS_SYSTEM') == 'native'}
        <div class="simpleblog__listing__post__wrapper__footer__block col-md-6 col-xs-12">
            <i class="material-icons">comment</i>
            <span>
                <a href="{$post.url}#phsimpleblog_comments">{$post.comments} {l s='comments'  mod='ph_simpleblog'}</a>
            </span>
        </div>
        {/if}
        {if Configuration::get('PH_BLOG_DISPLAY_VIEWS')}
        <div class="simpleblog__listing__post__wrapper__footer__block col-md-6 col-xs-12">
            <i class="material-icons">remove_red_eye</i>
            <span>
                {$post.views} {l s='views'  mod='ph_simpleblog'}
            </span>
        </div>
        {/if}
    </div><!-- .row -->
</div><!-- .simpleblog__listing__post__wrapper__footer -->
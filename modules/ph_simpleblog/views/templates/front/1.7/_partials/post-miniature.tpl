<div class="post-item">

    {if Configuration::get('PH_BLOG_DISPLAY_THUMBNAIL') && (isset($post.banner_wide) || isset($post.banner_thumb))}
        <div class="post-thumbnail">
            <a href="{$post.url}">
                    <img src="{$post.banner_thumb}" alt="{$post.title}" class="img-fluid photo">
            </a>
        </div><!-- .post-thumbnail -->
    {/if}

    <div class="post-title">
        <h2>
            <a href="{$post.url}">
                {$post.title}
            </a>
        </h2>
    </div><!-- .post-title -->


    {if Configuration::get('PH_BLOG_DISPLAY_DESCRIPTION')}
        <div class="post-content">
            {$post.short_content|strip_tags:'UTF-8'}

            {if Configuration::get('PH_BLOG_DISPLAY_MORE')}
                <a href="{$post.url}" title="{l s='Read more' mod='ph_simpleblog'}" class="post-read-more text-muted">
                    <span>{l s='read more' mod='ph_simpleblog'}</span> <i class="fa fa-chevron-right"></i>
                </a>
                <!-- .post-read-more -->
            {/if}
        </div>
        <!-- .post-content -->
    {/if}

    <div class="post-additional-info post-meta-info text-muted">
        {if Configuration::get('PH_BLOG_DISPLAY_DATE')}
            <span class="post-date">
                                            <i class="fa fa-calendar"></i>  <time datetime="{$post.date_add|date_format:'c'}">{$post.date_add|date_format:Configuration::get('PH_BLOG_DATEFORMAT')}</time>
                                        </span>
        {/if}

        {if isset($is_category)}
            {if $is_category eq false && Configuration::get('PH_BLOG_DISPLAY_CATEGORY')}
                <span class="post-category">
                                            <i class="fa fa-tags"></i> <a href="{$post.category_url}"
                                                                          title="{$post.category}"
                                                                          rel="category">{$post.category}</a>
                                        </span>
            {/if}
        {/if}

        {if isset($post.author) && !empty($post.author) && Configuration::get('PH_BLOG_DISPLAY_AUTHOR')}
            <span class="post-author">
                                            <i class="fa fa-user"></i> <span>{$post.author}</span>
                                        </span>
        {/if}

        {if $post.allow_comments eq true && Configuration::get('PH_BLOG_COMMENTS_SYSTEM') == 'native'}
            <span class="post-comments">
                <i class="fa fa-comments"></i>
                <span>{$post.comments} {l s='comments'  mod='ph_simpleblog'}</span>
            </span>
        {/if}
    </div><!-- .post-additional-info post-meta-info -->


</div><!-- .simpleblog__listing__post -->
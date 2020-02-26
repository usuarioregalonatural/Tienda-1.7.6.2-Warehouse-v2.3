    <div class="form-group">
        <div class="col-12">

            <div class="row">
                <div class="col-xs-6">
                    <input type="text" class="form-control" id="related_posts_filter" size="60" placeholder="{l s='Type to filter posts:' mod='ph_relatedposts'}" />
                </div>
            </div>

            <div class="row" style="margin-top: 2rem">
                <div class="col-xs-6">
                    <p>{l s='Available posts' mod='ph_relatedposts'}</p>

                    <select multiple id="ph_relatedposts_left" class="form-control">
                        {foreach $posts as $post}
                            <option value="{$post.id_simpleblog_post|intval}">{$post.title|escape:'html':'UTF-8'}</option>
                        {/foreach}
                    </select>

                    <a href="#" id="ph_relatedposts_move_to_right" class="btn btn-primary" style="margin-top: 1rem">
                        {l s='Add' mod='ph_relatedposts'}
                        <i class="material-icons">chevron_right</i>
                    </a>

                </div>
                <div class="col-xs-6">
                    <p>{l s='Posts related to this product' mod='ph_relatedposts'}</p>

                    <select multiple id="ph_relatedposts_right" name="ph_relatedposts[related_posts][]" class="form-control">
                        {foreach $selected_posts as $post}
                            <option value="{$post.id_simpleblog_post|intval}">{$post.title|escape:'html':'UTF-8'}</option>
                        {/foreach}
                    </select>

                    <a href="#" id="move_to_left" class="btn btn-danger" style="margin-top: 1rem">
                        <i class="material-icons">delete</i>
                        {l s='Remove' mod='ph_relatedposts'}
                    </a>

                </div>
            </div>
        </div>
    </div>




    <script type="text/javascript" src="{$path}views/js/admin_tab.js"></script>
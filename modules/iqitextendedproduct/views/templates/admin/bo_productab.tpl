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

<div class="alert alert-info" role="alert">
    <p class="alert-text">{l s='You need to save product to changes took effect' mod='iqitextendedproduct'}</p>
</div>

<h2>{l s='Products videos:' mod='iqitextendedproduct'}</h2>

<div id="iqitvideos-container" class="clearfix mb-2">
    <div class="form-inline mb-2">
        <fieldset class="form-group mr-3">
            <label class="mb-2 text-left" style="justify-content: left;">{l s='YouTube/Vimeo/Dailymotion link' mod='iqitextendedproduct'}</label>
            <input type="text" class="form-control" id="iqitthreesixty-videourl"
                   placeholder="{l s='Ex.: https://www.youtube.com/watch?v=GQxGetpe1ws' mod='iqitextendedproduct'}"></input>
        </fieldset>
        <button type="button" class="btn btn-primary mt-4"
                id="iqitthreesixty-addvideo">{l s='Add video' mod='iqitextendedproduct'}</button>
    </div>

    <div id="iqitvideos-list" class="iqitvideos-list row">

        {foreach $productVideoContent as $video}
            <div class="iqitvideo-preview js-iqitvideo-preview col-3" data-video-url="{$video.id}" data-video-provider="{$video.p}">
                <div class="vcontent">
                    <div class="info clearfix">
                        <span><i class="material-icons">drag_handle</i></span>
                        <button type="button" class="btn btn-danger-outline btn-sm float-right js-delete-video"><i
                                    class="material-icons">delete_forever</i>{l s='Remove' mod='iqitextendedproduct'}
                        </button>
                    </div>
                    <div class="video">
                        <iframe class="iframe js-video-iframe" width="200" height="150"
                                {if $video.p == 'youtube'}src="//www.youtube.com/embed/{$video.id}"{/if}
                                {if $video.p == 'dailymotion'}src="//www.dailymotion.com/embed/video/{$video.id}"{/if}
                                {if $video.p == 'vimeo'}src="//player.vimeo.com/video/{$video.id}"{/if}
                                ></iframe>
                    </div>
                </div>
            </div>
        {/foreach}

    </div>
    <input name="iqitextendedproduct[videos]" id="iqitextendedproduct_videos" type="hidden" value=""/>
</div>


<div id="iqitvideo-previewsample">
    <div class="iqitvideo-preview js-iqitvideo-preview col-3" data-video-url="" data-video-provider="">
        <div class="vcontent">
            <div class="info clearfix">
                <span><i class="material-icons">drag_handle</i></span>
                <button type="button" class="btn btn-danger-outline btn-sm float-right js-delete-video"><i
                            class="material-icons">delete_forever</i>{l s='Remove' mod='iqitextendedproduct'}
                </button>
            </div>
            <div class="video">
                <iframe class="iframe js-video-iframe" width="200" height="150"
                        src="https://www.youtube.com/embed/XGSy3_Czz8k"></iframe>
            </div>
        </div>
    </div>
</div>

<h2>{l s='360 product view' mod='iqitextendedproduct'}</h2>

<div id="iqitthreesixty-images-container" class="m-b-2">
    <div id="iqitthreesixty-images-dropzone" class="panel dropzone ui-sortable col-md-12"
         url-upload="{$threeSixtyActionUrl}&step=1"
         url-delete="{$threeSixtyActionUrl}&step=2">
        <div id="iqitthreesixty-images-dropzone-error" class="text-danger"></div>
        <div class="dz-default dz-message threesixty-openfilemanager">
            <i class="material-icons">add_a_photo</i><br/>
            {l s='Drop images here' mod='iqitextendedproduct'}<br/>
            <a>{l s='or select files' mod='iqitextendedproduct'}</a><br/>
        </div>

        {foreach $threeSixtyContent as $image}
            <div class="dz-preview dz-processing dz-image-preview dz-complete ui-sortable-handle"
                 data-name="{$image.name}">
                <div class="dz-image bg"
                     style="background-image: url('{$image.path}');"></div>
                <div class="dz-details">
                    <div class="dz-size"><span data-dz-size=""></span></div>
                    <div class="dz-filename"><span data-dz-name=""></span></div>
                </div>
                <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress="" style="width: 100%;"></span>
                </div>
                <div class="dz-error-message"><span data-dz-errormessage=""></span></div>
                <div class="dz-success-mark"></div>
                <div class="dz-error-mark"></div>
                <a class="dz-remove-custom" href="javascript:undefined;"
                   data-dz-remove="">{l s='Delete' mod='iqitextendedproduct'}</a>
            </div>
        {/foreach}
        <div class="fallback">
            <input name="threesixty-file-upload" type="file" multiple/>
        </div>


    </div>
    <input name="iqitextendedproduct[threesixty]" id="iqitextendedproduct_threesixty" type="hidden" value=""/>
    <div class="form-group">
        <button type="button" class="btn btn-danger btn-lg btn-block" id="iqitthreesixty-removeall"><i
                    class="material-icons">delete_forever</i>{l s='Remove all' mod='iqitextendedproduct'}
        </button>
    </div>

</div>

<script type="text/javascript" src="{$path}views/js/admin_tab.js"></script>


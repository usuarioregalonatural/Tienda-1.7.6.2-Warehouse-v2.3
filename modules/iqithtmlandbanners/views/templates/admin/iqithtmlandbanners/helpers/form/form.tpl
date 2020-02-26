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

{extends file="helpers/form/form.tpl"}

{block name="label"}
    {if $input.type == 'blocks'}

    {else}
        {$smarty.block.parent}
    {/if}
{/block}

{block name="legend"}
    <h3>
        {if isset($field.image)}<img src="{$field.image}" alt="{$field.title|escape:'html':'UTF-8'}" />{/if}
        {if isset($field.icon)}<i class="{$field.icon}"></i>{/if}
        {$field.title}
        <span class="panel-heading-action">
            {foreach from=$toolbar_btn item=btn key=k}
                {if $k != 'modules-list' && $k != 'back'}
                    <a id="desc-{$table}-{if isset($btn.imgclass)}{$btn.imgclass}{else}{$k}{/if}" class="list-toolbar-btn" {if isset($btn.href)}href="{$btn.href}"{/if} {if isset($btn.target) && $btn.target}target="_blank"{/if}{if isset($btn.js) && $btn.js}onclick="{$btn.js}"{/if}>
                        <span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="{$btn.desc}" data-html="true">
                            <i class="process-icon-{if isset($btn.imgclass)}{$btn.imgclass}{else}{$k}{/if} {if isset($btn.class)}{$btn.class}{/if}" ></i>
                        </span>
                    </a>
                {/if}
            {/foreach}
            </span>
    </h3>
{/block}

{block name="input_row"}
    {if $input.type == 'blocks'}
        <div class="row">
            <script type="text/javascript">
                var come_from = '{$name_controller}';
                var token = '{$token}';
                var alternate = 1;
            </script>
            {foreach $input.values as $key => $link_blocks_position name='blocksLoop'}
                <div class="col-lg-6">
                    <div class="panel">
                        <div class="panel-heading">
                            {$link_blocks_position.hook_name}
                             <small>{$link_blocks_position.hook_title}</small>
                        </div>
                        <table class="table tableDnD cms" id="iqit_htmlandbanner_{$link_blocks_position.id_hook}">
                            <thead>
                                <tr class="nodrag nodrop">
                                    <th>{l s='ID' mod='iqithtmlandbanners'}</th>
                                    <th>{l s='Position' mod='iqithtmlandbanners'}</th>
                                    <th>{l s='Name of the block' mod='iqithtmlandbanners'}</th>
                                    <th>{l s='Type' mod='iqithtmlandbanners'}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                {foreach $link_blocks_position.blocks as $link_block}
                                    <tr class="{if $key%2}alt_row{else}not_alt_row{/if} row_hover" id="tr_{$link_blocks_position.id_hook}_{$link_block['id_iqit_htmlandbanner']}_{$link_block['position']}">
                                        <td>{$link_block['id_iqit_htmlandbanner']}</td>
                                        <td class="center pointer dragHandle" id="td_{$link_blocks_position.id_hook}_{$link_block['id_iqit_htmlandbanner']}">
                                            <div class="dragGroup">
                                                <div class="positions">
                                                    {$link_block['position'] + 1}
                                                </div>
                                            </div>
                                        </td>
                                        <td>{$link_block['block_name']}</td>
                                        <td>{if $link_block['type']}html{else}banner{/if}</td>
                                        <td>
                                            <div class="btn-group-action">
                                                <div class="btn-group pull-right">
                                                    <a class="btn btn-default" href="{$current}&amp;edit{$identifier}&amp;id_iqit_htmlandbanner={(int)$link_block['id_iqit_htmlandbanner']}&amp;type={$link_block['type']}" title="{l s='Edit' mod='iqithtmlandbanners'}">
                                                        <i class="icon-edit"></i> {l s='Edit' mod='iqithtmlandbanners'}
                                                    </a>
                                                    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                        <i class="icon-caret-down"></i>&nbsp;
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="{$current}&amp;delete{$identifier}&amp;id_iqit_htmlandbanner={(int)$link_block['id_iqit_htmlandbanner']}" title="{l s='Delete' mod='iqithtmlandbanners'}">
                                                            <i class="icon-trash"></i> {l s='Delete' mod='iqithtmlandbanners'}
                                                        </a>
                                                    </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                {/foreach}
                            </tbody>
                        </table>
                    </div>
                </div>
                {if $smarty.foreach.blocksLoop.index%2}<div class="clearfix"></div>{/if}
            {/foreach}
        </div>
    {elseif $input.type == 'banners'}
        <script type="text/javascript">
            var iqitBannerPage = true;
        </script>


        <input type="hidden" name="content" id="iqit-banners-field" />

        <div class="form-group">
            <label class="control-label col-lg-3"></label>
            <div class="col-lg-9">
               <div id="iqit-banners">

                   <div class="list-group-item list-group-item-header row-table">
                       <div class="col-table"></div>
                       <div class="col-table col-table-image">
                           {l s='Image' mod='iqithtmlandbanners'}
                       </div>
                       <div class="col-table">
                           {l s='Link' mod='iqithtmlandbanners'}
                       </div>
                       <div class="col-table">
                           {l s='Languages' mod='iqithtmlandbanners'}
                       </div>
                       <div class="col-table">
                           {l s='Status' mod='iqithtmlandbanners'}
                       </div>
                       <div class="col-table">
                           {l s='Remove' mod='iqithtmlandbanners'}
                       </div>
                   </div>

                   {foreach from=$bannerImages.banners item=banner}
                       <div class="list-group-item row-table js-list-group-item">
                           <div class="col-table">
                               <i class="icon-bars js-iqit-banner-reorder iqit-banner-reorder"></i>
                           </div>
                           <div class="col-table col-table-image">
                               <img src="{$imgBannersPath}{$banner.img}" class="img-responsive js-iqit-banner-image"  data-image="{$banner.img}" />
                           </div>

                           <div class="col-table">
                               <input type="text" class="js-iqit-banner-link" placeholder="{l s='Link' mod='iqithtmlandbanners'}" value="{$banner.url}"/>
                           </div>
                           <div class="col-table">
                               <select type="text" class="js-iqit-banner-language">
                                   <option value="all" {if $banner.language == 'all'} selected{/if}>{l s='All' mod='iqithtmlandbanners'}</option>
                                   {foreach from=$languages item=lang}
                                       <option value="{$lang.id_lang}"  {if $banner.language == $lang.id_lang} selected{/if}>{$lang.name}</option>
                                   {/foreach}
                               </select>
                           </div>
                           <div class="col-table">
                               <input type="checkbox" class="js-iqit-banner-active" {if $banner.status} checked{/if}/>
                           </div>
                           <div class="col-table">
                               <div class="btn-group-action pull-right">
                                   <button type="button" class="js-iqit-banner-delete  btn btn-danger" >
                                       <i class="icon-trash"></i> {l s='Delete' mod='iqithtmlandbanners'}
                                   </button>
                               </div>
                           </div>
                       </div>
                   {/foreach}

               </div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-3">
                {l s='View' mod='iqithtmlandbanners'}
            </label>
            <div class="col-lg-9">
                <select type="text" class="js-iqit-banner-options-view">
                    <option value="list" {if $bannerImages.options.view == 'list'} selected{/if}>{l s='List' mod='iqithtmlandbanners'}</option>
                    <option value="slider" {if $bannerImages.options.view == 'slider'} selected{/if}>{l s='Slider' mod='iqithtmlandbanners'}</option>
                </select>
            </div>
        </div>



        <script type="text/template" id="tmpl-iqitbanner">
            <div class="list-group-item row-table js-list-group-item">
                    <div class="col-table">
                        <i class="icon-bars js-iqit-banner-reorder iqit-banner-reorder"></i>
                    </div>
                    <div class="col-table col-table-image">
                        <img src="{$imgBannersPath}::imgSrc::" class="img-responsive js-iqit-banner-image"  data-image="::imgSrc::" />
                    </div>

                    <div class="col-table">
                     <input type="text" class="js-iqit-banner-link" placeholder="{l s='Link' mod='iqithtmlandbanners'}"/>
                    </div>
                    <div class="col-table">
                        <select  type="text" class="js-iqit-banner-language">
                            <option value="all">all</option>
                            {foreach from=$languages item=lang}
                                <option value="{$lang.id_lang}">{$lang.name}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="col-table">
                        <input type="checkbox" class="js-iqit-banner-active" checked />
                    </div>
                    <div class="col-table">
                         <div class="btn-group-action pull-right">
                           <button type="button" class="js-iqit-banner-delete  btn btn-danger" >
                                <i class="icon-trash"></i> {l s='Delete' mod='iqithtmlandbanners'}
                            </button>
                        </div>
                    </div>
            </div>
        </script>

    {else}
        {$smarty.block.parent}
    {/if}
{/block}




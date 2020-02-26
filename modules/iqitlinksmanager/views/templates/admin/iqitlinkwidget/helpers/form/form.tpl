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
    {if $input.type == 'link_blocks'}

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
    {if $input.type == 'link_blocks'}
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
                        <table class="table tableDnD cms" id="iqit_link_block_{$link_blocks_position.id_hook}">
                            <thead>
                                <tr class="nodrag nodrop">
                                    <th>{l s='ID' mod='iqitlinksmanager'}</th>
                                    <th>{l s='Position' mod='iqitlinksmanager'}</th>
                                    <th>{l s='Name of the block' mod='iqitlinksmanager'}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                {foreach $link_blocks_position.blocks as $link_block}
                                    <tr class="{if $key%2}alt_row{else}not_alt_row{/if} row_hover" id="tr_{$link_blocks_position.id_hook}_{$link_block['id_iqit_link_block']}_{$link_block['position']}">
                                        <td>{$link_block['id_iqit_link_block']}</td>
                                        <td class="center pointer dragHandle" id="td_{$link_blocks_position.id_hook}_{$link_block['id_iqit_link_block']}">
                                            <div class="dragGroup">
                                                <div class="positions">
                                                    {$link_block['position'] + 1}
                                                </div>
                                            </div>
                                        </td>
                                        <td>{$link_block['block_name']}</td>
                                        <td>
                                            <div class="btn-group-action">
                                                <div class="btn-group pull-right">
                                                    <a class="btn btn-default" href="{$current}&amp;edit{$identifier}&amp;id_iqit_link_block={(int)$link_block['id_iqit_link_block']}" title="{l s='Edit' mod='iqitlinksmanager'}">
                                                        <i class="icon-edit"></i> {l s='Edit' mod='iqitlinksmanager'}
                                                    </a>
                                                    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                        <i class="icon-caret-down"></i>&nbsp;
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="{$current}&amp;delete{$identifier}&amp;id_iqit_link_block={(int)$link_block['id_iqit_link_block']}" title="{l s='Delete' mod='iqitlinksmanager'}">
                                                            <i class="icon-trash"></i> {l s='Delete' mod='iqitlinksmanager'}
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


    {elseif $input.type == 'repository_links'}

    {function name="cms_tree" nodes=[] depth=0}
    {strip}
    {if $nodes|count}
        {foreach from=$nodes item=node}
            <li data-id="{$node.id_cms_category}" data-type="cms_category" style="margin-left:{math equation="17 * depth" depth=$depth}px" class="cms-category"><span class="drag-handle">&#9776;</span>{$node.name|escape} <small>({l s='cms category' mod='iqitlinksmanager'})</small> <i class="icon-trash js-remove "></i></li>
            {foreach from=$node.pages item=page}
                <li data-id="{$page.id_cms}" data-type="cms_page" style="margin-left:{math equation="17 * (depth+1)" depth=$depth}px"><span class="drag-handle">&#9776;</span>{$page.title|escape} <small>({l s='cms page' mod='iqitlinksmanager'})</small><i class="icon-trash js-remove "></i></li>
            {/foreach}
            {if isset($node.children)} {cms_tree nodes=$node.children depth=$depth+1} {/if}
         {/foreach}
    {/if}
    {/strip}
    {/function}

    {function name="category_tree" nodes=[] depth=0}
         {strip}
              {if $nodes|count}
                  {foreach from=$nodes item=node}
                      {if $node.level_depth > 1}
                      <li data-id="{$node.id_category}" data-type="category" style="margin-left:{math equation="17 * (depth - 2)" depth=$depth}px" class=""><span class="drag-handle">&#9776;</span>{$node.name|escape} <small>({l s='category' mod='iqitlinksmanager'})</small> <i class="icon-trash js-remove "></i></li>
                      {/if}
                      {if isset($node.children)}
                       {category_tree nodes=$node.children depth=$depth+1}
                      {/if}
                  {/foreach}
              {/if}
          {/strip}
    {/function}

    <div class="col-xs-7">
    <div class="panel link-selector">

        <div class="panel-heading">{$input.label}</div>
        <ul id="repository-list">
          <li class="list-subtitle">{l s='Cms pages' mod='iqitlinksmanager'}</li>
          {cms_tree nodes=$cms_tree}

          <li class="list-subtitle">{l s='Static pages' mod='iqitlinksmanager'}</li>
          {foreach $static_pages as $static}
            {foreach $static.pages as $key => $page}
              <li data-id="{$page.id_cms}" data-type="static"><span class="drag-handle">&#9776;</span>{$page.title|escape} <small>({l s='static page' mod='iqitlinksmanager'})</small> <i class="icon-trash js-remove "></i></li>
            {/foreach}
          {/foreach}
            <li class="list-subtitle">{l s='Categories' mod='iqitlinksmanager'}</li>

                {category_tree nodes=$category_tree}

        </ul>
    </div>
    </div>

    {elseif $input.type == 'selected_links'}
    <input type="hidden" name="content" id="selected-links" value="">

    {function name="custom_link_lang" page=[]}
    {strip}
    <div class="form-group">
        <label class="control-label col-lg-3">
            {l s='Title' mod='iqitlinksmanager'}
        </label>
        {foreach from=$languages item=language}
        {if $languages|count > 1}
        <div class="translatable-field lang-{$language.id_lang|escape:'htmlall':'UTF-8'}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
            {/if}
            <div class="col-lg-7">
                <input value="{$page.title[$language.id_lang]}" type="text" class="link-title-{$language.id_lang|escape:'htmlall':'UTF-8'}">
            </div>
            {if $languages|count > 1}
            <div class="col-lg-2">
                <button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
                    {$language.iso_code|escape:'htmlall':'UTF-8'}
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    {foreach from=$languages item=lang}
                    <li><a href="javascript:hideOtherLanguage({$lang.id_lang|escape:'htmlall':'UTF-8'} );" tabindex="-1">{$lang.name|escape:'html'}</a></li>
                    {/foreach}
                </ul>
            </div>
            {/if}
            {if $languages|count > 1}
        </div>
        {/if}
        {/foreach}
    </div>

    <div class="form-group">
        <label class="control-label col-lg-3">
            {l s='Url' mod='iqitlinksmanager'}
        </label>
        {foreach from=$languages item=language}
        {if $languages|count > 1}
        <div class="translatable-field lang-{$language.id_lang|escape:'htmlall':'UTF-8'}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
            {/if}
            <div class="col-lg-7">
                <input value="{$page.url[$language.id_lang]}" type="text" class="link-url-{$language.id_lang|escape:'htmlall':'UTF-8'}">
                <p class="help-block">{l s='Put absolute url with http:// or https:// prefix' mod='iqitlinksmanager'}</p>
            </div>
            {if $languages|count > 1}
            <div class="col-lg-2">
                <button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
                    {$language.iso_code|escape:'htmlall':'UTF-8'}
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    {foreach from=$languages item=lang}
                    <li><a href="javascript:hideOtherLanguage({$lang.id_lang|escape:'htmlall':'UTF-8'} );" tabindex="-1">{$lang.name|escape:'html'}</a></li>
                    {/foreach}
                </ul>
            </div>
            {/if}
            {if $languages|count > 1}
        </div>
        {/if}
        {/foreach}

    </div>
    {/strip}
    {/function}

    <div class="col-xs-5">
    <div class="panel link-selector">
        <div class="panel-heading">{$input.label}</div>
        <div class="drag-info"><span class="drag-handle">&#9776;</span>{l s='Drag&drop links below from repository' mod='iqitlinksmanager'}</div>
        <ul id="selected-list">
        {foreach $selected_links as $page}
            {if ($page.type == 'custom')}
                <li data-type="{$page.type}"><span class="drag-handle">&#9776;</span>
                    {custom_link_lang page=$page}
                <i class="icon-trash js-remove "></i></li>
            {else}
                {if isset($page.data.title)}<li data-type="{$page.type}" data-id="{$page.id}"><span class="drag-handle">&#9776;</span>{$page.data.title}<small>
                 {if ($page.type == 'static')}({l s='static pages' mod='iqitlinksmanager'}){/if} {if ($page.type == 'cms_category')}({l s='cms category' mod='iqitlinksmanager'}){/if} {if ($page.type == 'cms_page')}({l s='cms page' mod='iqitlinksmanager'}){/if}

                </small> <i class="icon-trash js-remove "></i></li>{/if}
            {/if}
        {/foreach}
        </ul>
    </div>
     <div class="drag-info">{l s='Or add custom link' mod='iqitlinksmanager'} </div>
    <div id="custom-links-panel">
    <div class="form-group">
        <label class="control-label col-lg-3">
            {l s='Title' mod='iqitlinksmanager'}
        </label>
        {foreach from=$languages item=language}
        {if $languages|count > 1}
        <div class="translatable-field lang-{$language.id_lang|escape:'htmlall':'UTF-8'}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
            {/if}
            <div class="col-lg-7">
                <input value="" type="text" class="link-title-{$language.id_lang|escape:'htmlall':'UTF-8'}">
            </div>
            {if $languages|count > 1}
            <div class="col-lg-2">
                <button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
                    {$language.iso_code|escape:'htmlall':'UTF-8'}
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    {foreach from=$languages item=lang}
                    <li><a href="javascript:hideOtherLanguage({$lang.id_lang|escape:'htmlall':'UTF-8'} );" tabindex="-1">{$lang.name|escape:'html'}</a></li>
                    {/foreach}
                </ul>
            </div>
            {/if}
            {if $languages|count > 1}
        </div>
        {/if}
        {/foreach}
    </div>

    <div class="form-group">
        <label class="control-label col-lg-3">
           {l s='Url' mod='iqitlinksmanager'}
        </label>
        {foreach from=$languages item=language}
        {if $languages|count > 1}
        <div class="translatable-field lang-{$language.id_lang|escape:'htmlall':'UTF-8'}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
            {/if}
            <div class="col-lg-7">
                <input value="" type="text" class="link-url-{$language.id_lang|escape:'htmlall':'UTF-8'}">
                <p class="help-block">{l s='Put absolute url with http:// or https:// prefix' mod='iqitlinksmanager'}</p>
            </div>
            {if $languages|count > 1}
            <div class="col-lg-2">
                <button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
                    {$language.iso_code|escape:'htmlall':'UTF-8'}
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    {foreach from=$languages item=lang}
                    <li><a href="javascript:hideOtherLanguage({$lang.id_lang|escape:'htmlall':'UTF-8'} );" tabindex="-1">{$lang.name|escape:'html'}</a></li>
                    {/foreach}
                </ul>
            </div>
            {/if}
            {if $languages|count > 1}
        </div>
        {/if}
        {/foreach}

    </div>
    </div>

    <div class="form-group">
        <button type="button" id="add-custom-link" class="btn btn-default btn-lg">
             <i class="icon-plus"></i> {l s='Add' mod='iqitlinksmanager'}
        </button>
    </div>


    </div>
    <div class="clearfix"></div>

    {else}
        {$smarty.block.parent}
    {/if}
{/block}




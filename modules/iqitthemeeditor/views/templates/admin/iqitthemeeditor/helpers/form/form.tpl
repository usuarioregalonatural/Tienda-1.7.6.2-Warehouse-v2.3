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

{block name="defaultForm"}
    {if $formType == 'front'}
        <ul id="iqit-config-pans" class="iqit-config-pans">
            <li class="iqit-config-tab-heading iqit-config-tab-heading-main"><a href="{$backToBoLink}"
                                                                                class="iqit-config-tab-close"
                                                                                id="iqit-exit-editor-btn"><i
                            class="icon-times"></i></a> {l s='Iqit Theme Editor' mod='iqitthemeeditor'}</li>
            {foreach $fields as $f => $fieldset}
                {if !isset($fieldset.form.child)}
                    <li class="iqit-config-tab">
                        <span class="iqit-config-tab-title"
                              {if !isset($fieldset.form.childForms)}data-fieldset="#te-{$fieldset.form.legend.id}"
                              data-level="1" {/if} >{$fieldset.form.legend.title} <i
                                    class="icon-angle-right"></i></span>

                        {if isset($fieldset.form.childForms)}
                            <ul class="iqit-config-tab-group">
                                <li class="iqit-config-tab-heading">
                                    <button type="button" class="iqit-config-tab-close"><i class="icon-angle-left"></i>
                                    </button> {$fieldset.form.legend.title}</li>
                                {foreach  key=key item=item from=$fieldset.form.childForms}
                                    <li class="iqit-config-tab"><span class="iqit-config-tab-title"
                                                                      data-fieldset="#te-{$key}" data-level="2">{$item}
                                            <i class="icon-angle-right"></i></span></li>
                                {/foreach}
                            </ul>
                        {/if}

                    </li>
                {/if}
            {/foreach}
        </ul>
        <div id="iqit-config-fieldsets">
            {$smarty.block.parent}
        </div>
    {else}
        <div class="info-tabs">

            <div class="iqit-buttons">
                <a target="_blank" href="{$frontEditorLink}">{l s='Go to live editor' mod='iqitthemeeditor'} <i
                            class="icon-angle-right"></i></a>
            </div>

            <div class="theme-info">

                <img src="{$base_url}modules/iqitthemeeditor/views/img/logo-iq.png" alt="Iqit-commerce.com"/>
                {l s='Theme version' mod='iqitthemeeditor'}  {$theme_version}

                <iframe width="100%" height="180px"
                        src="//iqit-commerce.com/iframe/lastnews/news17.php?product=warehouse&version={$theme_version|escape:'html':'UTF-8'}"
                        style="border: none; overflow: hidden;"></iframe>
            </div>


            <ul id="iqit-config-tabs" class="iqit-config-tabs" role="tablist">
                {foreach $fields as $f => $fieldset}
                    {if !isset($fieldset.form.child)}
                        <li class="tab  {if $fieldset@first} active {/if} ">
                            <a href="#te-{$fieldset.form.legend.id}" role="tab"
                               {if !isset($fieldset.form.childForms)}data-toggle="tab"{/if}  {if isset($fieldset.form.childForms)}class="parent-tab"{/if}>
                                {$fieldset.form.legend.title}
                            </a>

                            {if isset($fieldset.form.childForms)}
                                <ul>
                                    {foreach  key=key item=item from=$fieldset.form.childForms}
                                        <li class="tab tab-child"><a href="#te-{$key}" role="tab"
                                                                     data-toggle="tab">{$item}</a></li>
                                    {/foreach}
                                </ul>
                            {/if}

                        </li>
                    {/if}
                {/foreach}
            </ul>
        </div>
        <div class="tab-content iqit-config-panels ">
            {$smarty.block.parent}
        </div>
    {/if}

    <input type="hidden" value="{$iqit_base_url|escape:'html':'UTF-8'}" id="iqit-base-url"/>
{/block}


{block name="legend"}
    {if $formType == 'front'}
        <div class="iqit-config-tab-heading">
            <button type="button" class="iqit-config-tab-close"><i class="icon-angle-left"></i></button> {$field.title}
        </div>
    {else}
        {$smarty.block.parent}
    {/if}
{/block}

{block name="footer"}
    {if $formType != 'front'}
        {$smarty.block.parent}
    {/if}
{/block}



{block name="fieldset"}
    {if $formType == 'front'}
        <div class="iqit-config-fieldset" id="te-{$fieldset.form.legend.id}">
            {$smarty.block.parent}
        </div>
    {else}
        <div role="tabpanel" class="tab-panel {if $fieldset.form.legend.id == 'iqit-general'}active{/if}"
             id="te-{$fieldset.form.legend.id}">
            {$smarty.block.parent}
        </div>
    {/if}
{/block}


{block name="input_row"}

    {if $input.type != 'wrapper_start' ||  $input.type != 'wrapper_start' }
        <div class="{if isset($input.condition)}condition-option hidden-option{/if}" {if isset($input.condition)}data-condition='{$input.condition|@json_encode nofilter}'{/if}>
    {/if}

    {if $input.type == 'title_separator'}
        {if isset($input.border_top)}
            <hr>
        {/if}
        {if isset($input.label)}
            <div class="col-lg-12 title-reparator"><div class="col-lg-offset-3">{$input.label}</div></div>{/if}
    {elseif $input.type == 'info_text'}
    {if isset($input.desc)}<p class="alert alert-info col-lg-offset-3">{$input.desc}</p>{/if}
    {elseif $input.type == 'subtitle_separator'}
        {if isset($input.border_top)}
            <hr>
        {/if}
        <label class="control-label col-lg-3"></label>
        <div class="col-lg-9 subtitle-reparator">{$input.label} </div>
    {elseif $input.type == 'wrapper_start'}
        <div class="clearfix">
            <div class="col-lg-3"></div>
            <div class="background-wrapper col-lg-9 clearfix">
                {elseif $input.type == 'wrapper_end'}
            </div>
        </div>
    {else}

        {$smarty.block.parent}
    {/if}

    {if $input.type != 'wrapper_start' ||  $input.type != 'wrapper_start' }
        </div>
    {/if}
{/block}

{block name="label"}
    {if ($input.type == 'import_export') }
    {else}
        {$smarty.block.parent}
    {/if}
{/block}



{block name="input"}
    {if $formType == 'front'} {if isset($input.descFront)}
        <div class="alert alert-warning">{$input.descFront}</div>
    {/if}{/if}
    {if $input.type == 'boxshadow'}
        <div class="box-shadow-generator js-box-shadow-generator">

            <select class="js-box-shadow-switch js-scss-ignore" data-name="switch" name="{$input.name}_switch">
                <option value="0">{l s='No' mod='iqitthemeeditor'}</option>
                <option value="1" {if $fields_value[$input.name].switch} selected{/if}>{l s='yes' mod='iqitthemeeditor'}</option>
            </select>

            <input type="hidden" value="" name="{$input.name}" id="{$input.name}" class="js-box-shadow-input"/>
            <div class="box-shadow-controls js-box-shadow-controls hidden-option">

                <div class="boxshadow-control"> {l s='Color' mod='iqitthemeeditor'}
                    <div class="input-group colorpicker-component">
                        <input type="text" value="{$fields_value[$input.name].color|escape:'html':'UTF-8'}"
                               class="form-control js-scss-ignore js-shadow-color" data-name="color"
                               name="{$input.name}_color"/>
                        <span class="input-group-addon"><i></i></span>
                    </div>
                </div>
                <div class="boxshadow-control">{l s='Blur' mod='iqitthemeeditor'} <input data-name="blur"
                                                                                         name="{$input.name}_blur"
                                                                                         type="number"
                                                                                         class="form-control js-scss-ignore js-shadow-blur"
                                                                                         step="1"
                                                                                         max="100" min="0"
                                                                                         value="{if $fields_value[$input.name].blur == ''}0{else}{$fields_value[$input.name].blur|escape:'html':'UTF-8'}{/if}"/>
                </div>
                <div class="boxshadow-control">{l s='Spread' mod='iqitthemeeditor'} <input data-name="spread"
                                                                                           name="{$input.name}_spread"
                                                                                           type="number"
                                                                                           class="form-control js-scss-ignore js-shadow-spread"
                                                                                           step="1"
                                                                                           max="100" min="0"
                                                                                           value="{if $fields_value[$input.name].spread == ''}0{else}{$fields_value[$input.name].spread|escape:'html':'UTF-8'}{/if}"/>
                </div>
                <div class="boxshadow-control">{l s='Horizontal' mod='iqitthemeeditor'} <input data-name="horizontal"
                                                                                               name="{$input.name}_horizontal"
                                                                                               class="form-control js-scss-ignore js-shadow-horizontal"
                                                                                               type="number"
                                                                                               step="1" min="-100"
                                                                                               max="100"
                                                                                               value="{if $fields_value[$input.name].horizontal == ''}0{else}{$fields_value[$input.name].horizontal|escape:'html':'UTF-8'}{/if}"/>
                </div>
                <div class="boxshadow-control">{l s='Vertical' mod='iqitthemeeditor'} <input data-name="vertical"
                                                                                             name="{$input.name}_vertical"
                                                                                             class="form-control js-scss-ignore js-shadow-vertical"
                                                                                             type="number"
                                                                                             step="1" min="-100"
                                                                                             max="100"
                                                                                             value="{if $fields_value[$input.name].vertical == ''}0{else}{$fields_value[$input.name].vertical|escape:'html':'UTF-8'}{/if}"/>
                </div>

                <div>
                    <div class="shadowpreview js-shadow-preview"></div>
                </div>
            </div>
        </div>
    {elseif $input.type == 'border'}
        <div class="js-border-generator border-generator row">
            <input type="hidden" value="" name="{$input.name}" id="{$input.name}" class="js-border-input"/>
            <div class="col-xs-2">
                <select name="{$input.name}_type" id="{$input.name}_type" class="js-border-type js-scss-ignore"
                        data-name="type">
                    <option value="none"
                            {if $fields_value[$input.name].type=='none'}selected{/if}>{l s='none' mod='iqitthemeeditor'}</option>
                    <option value="solid"
                            {if $fields_value[$input.name].type=='solid'}selected{/if}>{l s='solid' mod='iqitthemeeditor'}</option>
                    <option value="dotted"
                            {if $fields_value[$input.name].type=='dotted'}selected{/if}>{l s='dotted' mod='iqitthemeeditor'}</option>
                    <option value="dashed"
                            {if $fields_value[$input.name].type=='dashed'}selected{/if}>{l s='dashed' mod='iqitthemeeditor'}</option>
                    <option value="groove"
                            {if $fields_value[$input.name].type=='groove'}selected{/if}>{l s='groove' mod='iqitthemeeditor'}</option>
                    <option value="double"
                            {if $fields_value[$input.name].type=='double'}selected{/if}>{l s='double' mod='iqitthemeeditor'}</option>
                </select>
            </div>
            <div class="col-xs-4 js-border-controls-wrapper hidden-option {if $fields_value[$input.name].type != 'none'}visible-inline-option{/if}">
                <div class="row">
            <div class="col-xs-6 border-width">
                <select name="{$input.name}_width" id="{$input.name}_width" class="js-border-width js-scss-ignore"
                        data-name="width">
                    {for $i=1 to 20}
                        <option value="{$i}" {if $fields_value[$input.name].width == $i}selected{/if}>{$i}px
                        </option>
                    {/for}
                </select>
            </div>
            <div class="col-xs-6 border-color">
                <div class="row">
                    <div class="input-group colorpicker-component">
                        <input type="text" value="{$fields_value[$input.name].color|escape:'html':'UTF-8'}"
                               class="form-control js-border-color js-scss-ignore" name="{$input.name}_color"
                               data-name="color"/>
                        <span class="input-group-addon"><i></i></span>
                    </div>
                </div>
            </div>
            </div>
            </div>
        </div>
    {elseif $input.type == 'color2'}
        <div class="form-group">
            <div class="col-lg-2">
                <div class="row">
                    <div class="input-group colorpicker-component">
                        <input type="text" value="{$fields_value[$input.name]|escape:'html':'UTF-8'}"
                               class="form-control" name="{$input.name}"/>
                        <span class="input-group-addon"><i></i></span>
                    </div>

                </div>
            </div>
        </div>
    {elseif $input.type == 'range'}
        <div class="form-group">
            <div class="col-lg-5">
                <div class="row">
                    <div class="input-group input-group-range">
                        <input type="range"
                               name="{$input.name}_s"
                               id="{$input.name}_s"
                               data-vinput="{$input.name}"
                               value="{$fields_value[$input.name]|escape:'html':'UTF-8'}"
                                {if isset($input.min)} min="{$input.min|intval}"{/if}
                                {if isset($input.step)} step="{$input.step|intval}"{/if}
                                {if isset($input.max)} max="{$input.max|intval}"{/if}
                               oninput="{$input.name}.value = {$input.name}_s.value"
                               class="js-scss-ignore js-range-slider range-slider"/>
                        <input type="number"
                               name="{$input.name}"
                               id="{$input.name}"
                               value="{$fields_value[$input.name]|escape:'html':'UTF-8'}"
                                {if isset($input.min)} min="{$input.min|intval}"{/if}
                                {if isset($input.step)} step="{$input.step|intval}"{/if}
                                {if isset($input.max)} max="{$input.max|intval}"{/if}
                               oninput="{$input.name}_s.value = {$input.name}.value"
                               class="form-control width-70 js-range-slider-val"/>
                    </div>

                </div>
            </div>
        </div>
    {elseif $input.type == 'info_text'}
        <div class="form-group">
            <div class="col-lg-2">

            </div>
        </div>
    {elseif $input.type == 'number'}
        {assign var='value_text' value=$fields_value[$input.name]}
        {if isset($input.prefix) || isset($input.suffix)}
            <div class="input-group{if isset($input.class)} {$input.class}{/if}">
        {/if}
        {if isset($input.prefix)}
            <span class="input-group-addon">{$input.prefix}</span>
        {/if}
        <input type="number"
               name="{$input.name}"
               id="{if isset($input.id)}{$input.id}{else}{$input.name}{/if}"
               value="{if isset($input.string_format) && $input.string_format}{$value_text|string_format:$input.string_format|escape:'html':'UTF-8'}{else}{$value_text|escape:'html':'UTF-8'}{/if}"
               class="form-control {if isset($input.class)}{$input.class}{/if}"
                {if isset($input.size)} size="{$input.size}"{/if}
                {if isset($input.min)} min="{$input.min|floatval}"{/if}
                {if isset($input.max)} max="{$input.max|floatval}"{/if}
                {if isset($input.step)} step="{$input.step|floatval}"{/if}
                {if isset($input.maxchar) && $input.maxchar} data-maxchar="{$input.maxchar|intval}"{/if}
                {if isset($input.maxlength) && $input.maxlength} maxlength="{$input.maxlength|intval}"{/if}
                {if isset($input.readonly) && $input.readonly} readonly="readonly"{/if}
                {if isset($input.disabled) && $input.disabled} disabled="disabled"{/if}
                {if isset($input.autocomplete) && !$input.autocomplete} autocomplete="off"{/if}
                {if isset($input.required) && $input.required } required="required" {/if}
                {if isset($input.placeholder) && $input.placeholder } placeholder="{$input.placeholder}"{/if}
        />
        {if isset($input.suffix)}
            <span class="input-group-addon">{$input.suffix}</span>
        {/if}
        {if isset($input.prefix) || isset($input.suffix)}
            </div>
        {/if}
    {elseif $input.type == 'font'}
        {assign var='value_font' value=$fields_value[$input.name]}
        <div class="input-group{if isset($input.class)} {$input.class}{/if} js-typography-generator">
            {if isset($input.prefix)}
                <span class="input-group-addon">{$input.prefix}</span>
            {/if}
            <input type="hidden" value="" name="{$input.name}" id="{$input.name}" class="js-font-input"/>
            <input type="number"
                   id="{if isset($input.id)}{$input.id}{else}{$input.name}{/if}_size"
                   value="{if isset($value_font.size)}{$value_font.size}{/if}"
                   data-name="size"
                   name="{$input.name}_size"
                   class="form-control js-font-size js-scss-ignore width-60"
                   step="1"
                    {if isset($input.size)} size="{$input.size}"{/if}
                    {if isset($input.min)} min="{$input.min|intval}"{/if}
                    {if isset($input.maxchar) && $input.maxchar} data-maxchar="{$input.maxchar|intval}"{/if}
                    {if isset($input.maxlength) && $input.maxlength} maxlength="{$input.maxlength|intval}"{/if}
                    {if isset($input.readonly) && $input.readonly} readonly="readonly"{/if}
                    {if isset($input.disabled) && $input.disabled} disabled="disabled"{/if}
                    {if isset($input.autocomplete) && !$input.autocomplete} autocomplete="off"{/if}
                    {if isset($input.required) && $input.required } required="required" {/if}
                    {if isset($input.placeholder) && $input.placeholder } placeholder="{$input.placeholder}"{/if}
            />
            {if isset($input.suffix)}
                <span class="input-group-addon">{$input.suffix}</span>
            {/if}
            <span class="input-group-addon single-option-switch-wrapper">
                <span class="single-option-switch">
                    <input data-name="bold" type="radio" class="js-font-bold js-scss-ignore" id="{$input.name}_unbold"
                           name="{$input.name}_bold"
                           value="0" {if !isset($value_font.bold) || !$value_font.bold} checked{/if} />
                    <label for="{$input.name}_unbold"><i class="icon-bold"></i></label>
                    <input data-name="bold" type="radio" class="js-font-bold js-scss-ignore" id="{$input.name}_bold"
                           name="{$input.name}_bold"
                           value="1" {if isset($value_font.bold) && $value_font.bold} checked{/if}/>
                    <label for="{$input.name}_bold"><i class="icon-bold"></i></label>
                </span>
            </span>
            <span class="input-group-addon single-option-switch-wrapper">
                <span class="single-option-switch">
                    <input data-name="italic" type="radio" class="js-font-italic js-scss-ignore"
                           id="{$input.name}_unitalic" name="{$input.name}_italic"
                           value="0" {if !isset($value_font.italic) || !$value_font.italic} checked{/if}/>
                    <label for="{$input.name}_unitalic"><i class="icon-italic"></i></label>
                    <input data-name="italic" type="radio" class="js-font-italic js-scss-ignore"
                           id="{$input.name}_italic" name="{$input.name}_italic"
                           value="1" {if isset($value_font.italic) && $value_font.italic} checked{/if}/>
                    <label for="{$input.name}_italic"><i class="icon-italic"></i></label>
                </span>
            </span>
            <span class="input-group-addon single-option-switch-wrapper">
                <span class="single-option-switch">
                    <input data-name="uppercase" type="radio" class="js-font-uppercase js-scss-ignore"
                           id="{$input.name}_unuppercase" name="{$input.name}_uppercase"
                           value="0" {if !isset($value_font.uppercase) || !$value_font.uppercase} checked{/if}/>
                    <label for="{$input.name}_unuppercase">ABC</label>
                    <input data-name="uppercase" type="radio" class="js-font-uppercase js-scss-ignore"
                           id="{$input.name}_uppercase" name="{$input.name}_uppercase"
                           value="1" {if isset($value_font.uppercase) && $value_font.uppercase} checked{/if}/>
                    <label for="{$input.name}_uppercase">Abc</label>
                </span>
            </span>
            <span class="input-group-addon"><i class="icon icon-arrows-h" aria-hidden="true"></i></span>
            <input type="number"
                   value="{if isset($value_font.spacing)}{$value_font.spacing}{/if}"
                   data-name="spacing"
                   name="{$input.name}_spacing"
                   class="form-control js-font-spacing js-scss-ignore width-60"
                   step="1"
                   min="-10"
                   max="20"
            />
        </div>
    {elseif $input.type == 'code_textarea'}
        <div id="{$input.name|escape:'html':'UTF-8'}" class="iqit-code-editor form-control"
             data-language="{$input.language}">{$fields_value[$input.name]|escape:'html':'UTF-8'}</div>
    {elseif $input.type == 'filemanager'}
        <div class="form-group">
            <div class="col-lg-10">
                <div class="row">
                    <div class="input-group">
                        <input type="text" value="{$fields_value[$input.name]|escape:'html':'UTF-8'}" id="{$input.name}"
                               class="form-control" name="{$input.name}"/>
                        <span class="input-group-addon"><a href="filemanager/dialog.php?type=1&field_id={$input.name}"
                                                           class="js-iframe-upload"
                                                           data-input-name="{$input.name|escape:'html':'UTF-8'}"
                                                           type="button">{l s='Select image' mod='iqitthemeeditor'} <i
                                        class="icon-external-link"></i></a></span>
                    </div>

                </div>
            </div>
        </div>
    {elseif $input.type == 'import_export'}
        <div class="title-reparator">{l s='Import configuration' mod='iqitthemeeditor'}</div>
        <div class="alert alert-info">{l s='Upload own style or downloade our samples from below' mod='iqitthemeeditor'}  </div>
        <div style="display:inline-block;"><input type="file" id="uploadConfig" name="uploadConfig"/></div>
        <button type="submit" class="btn btn-default btn-lg" name="importConfiguration"><span
                    class="icon icon-upload"></span> {l s='Import' mod='iqitthemeeditor'}</button>
        <hr>
        <div class="title-reparator">{l s='Export configuration' mod='iqitthemeeditor'}</div>
        <div class="alert alert-info">{l s='Only saved changes are exported. Save first if you made any modifications.' mod='iqitthemeeditor'}  </div>
        <a class="btn btn-default btn-lg"
           href="{$current_link|escape:'html':'UTF-8'}&ajax=1&action=exportThemeConfiguration"><span
                    class="icon icon-share"></span> {l s='Export to file' mod='iqitthemeeditor'} </a>
    {elseif $input.type == 'image-select'}
        <div class="image-select {if isset($input.direction)} image-select-{$input.direction}{/if}">

            {foreach $input.options.query AS $option }
                <input id="{$input.name|escape:'html':'utf-8'}-{$option.id_option}" type="radio"
                       name="{$input.name|escape:'html':'utf-8'}"
                       value="{$option.id_option}" {if $fields_value[$input.name] == ''}{if $option@index eq 0} checked{/if}{/if} {if $option.id_option == $fields_value[$input.name]}checked{/if} />
                <div class="image-option">
                    <span class="image-option-title">{$option.name} <i
                                class="icon-check-circle image-option-check"> </i>  </span>
                    <label class="image-option-label"
                           for="{$input.name|escape:'html':'utf-8'}-{$option.id_option}"></label>
                    <img src="{$base_url}modules/iqitthemeeditor/views/img/{$option.img}" alt="{$option.name}"
                         class="img-responsive"/>
                </div>
            {/foreach}
        </div>
    {elseif $input.type == 'preloader-select'}
        <div class="image-select">

        {foreach $input.options.query AS $option}
            <input id="{$input.name|escape:'html':'utf-8'}-{$option.id_option}" type="radio"
                   name="{$input.name|escape:'html':'utf-8'}" value="{$option.id_option}"
                   {if $option.id_option == $fields_value[$input.name]}checked{/if} />
            <div class="image-option preloader-option"
            ">
            <span class="image-option-title">{$option.name} <i
                        class="icon-check-circle image-option-check"> </i>  </span>
            <label class="image-option-label" for="{$input.name|escape:'html':'utf-8'}-{$option.id_option}"></label>
            <div class="loader-wrapper">
                <div class="loader loader-{$option.id_option}">Loading...</div>
            </div>
            </div>
        {/foreach}
        </div>
    {elseif $input.type == 'textarea2'}
        <textarea
                name="{$input.name}" {if $formType == 'front'} {if isset($input.disableFront) && $input.disableFront} readonly="readonly"{/if}{/if}
                id="{if isset($input.id)}{$input.id}{else}{$input.name}{/if}" {if isset($input.cols)}cols="{$input.cols}"{/if} {if isset($input.rows)}rows="{$input.rows}"{/if}
                class="{if isset($input.autoload_rte) && $input.autoload_rte}rte autoload_rte{else}textarea-autosize{/if}{if isset($input.class)} {$input.class}{/if}"{if isset($input.maxlength) && $input.maxlength} maxlength="{$input.maxlength|intval}"{/if}{if isset($input.maxchar) && $input.maxchar} data-maxchar="{$input.maxchar|intval}"{/if}>{$fields_value[$input.name]|escape:'html':'UTF-8'}</textarea>
    {else}
        {$smarty.block.parent}
    {/if}
{/block}

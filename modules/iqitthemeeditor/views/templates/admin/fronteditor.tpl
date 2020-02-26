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

<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" {$full_cldr_language_code}> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" {$full_cldr_language_code}> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9" {$full_cldr_language_code}> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" {$full_cldr_language_code}> <!--<![endif]-->
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{l s='Iqit Theme Editor' mod='iqitthemeeditor'}</title>
  {* heade section *}
  <script type="text/javascript">
    var iso_user = '{$iso_user|@addcslashes:'\''}';
    var lang_is_rtl = '{$lang_is_rtl|intval}';
    var full_language_code = '{$full_language_code|@addcslashes:'\''}';
    var full_cldr_language_code = '{$full_cldr_language_code|@addcslashes:'\''}';
    var country_iso_code = '{$country_iso_code|@addcslashes:'\''}';
    var _PS_VERSION_ = '{$smarty.const._PS_VERSION_|@addcslashes:'\''}';
    var roundMode = {$round_mode|intval};
    var token = '{$token|addslashes}';
    var youEditFieldFor = 'a';
    var baseAdminDir = '{$baseDir|addslashes}';
    var from_msg ='a';
    var token_admin_orders = '{getAdminToken tab='AdminOrders'}';
    var token_admin_customers = '{getAdminToken tab='AdminCustomers'}';
    var token_admin_customer_threads = '{getAdminToken tab='AdminCustomerThreads'}';
    var currentIndex = '{$currentIndex|@addcslashes:'\''}';
    var employee_token = '{getAdminToken tab='AdminEmployees'}';
    var default_language = '{$default_language|intval}';
    var admin_modules_link = '{$link->getAdminLink("AdminModulesSf", true, ['route' => "admin_module_catalog_post"])|addslashes}';
    var tab_modules_list = '{if isset($tab_modules_list) && $tab_modules_list}{$tab_modules_list|addslashes}{/if}';
  </script>

  {if isset($js_def_vars) && is_array($js_def_vars) && $js_def_vars|@count}
    <script type="text/javascript">
      {foreach from=$js_def_vars key=k item=def}
      var {$k} = {$def|json_encode nofilter};
      {/foreach}
    </script>
  {/if}
  {if isset($js_files) && count($js_files)}
    {include file=$smarty.const._PS_ALL_THEMES_DIR_|cat:"javascript.tpl"}
  {/if}

  {if isset($css_files)}
    {foreach from=$css_files key=css_uri item=media}
      <link href="{$css_uri|escape:'html':'UTF-8'}" rel="stylesheet" type="text/css"/>
    {/foreach}
  {/if}

  {if isset($displayBackOfficeHeader)}
    	{$displayBackOfficeHeader}
  {/if}
</head>
<body class="iqit-front-editor">

<style id="iqitfronteditor-style"></style>
<style id="iqitfronteditor-custom-style"></style>

<div>
  <div id="iqitfronteditor-tools" class="loading-tools">
    <div id="iqitfronteditor-tools-loader"><div class="loader loader-1"></div></div>
    <button type="button" id="iqitfronteditor-tools-trigger" ><i class="icon-angle-left"></i></button>
    <div id="iqitfronteditor-tools-panels">

      {if $cacheStatus}
        <div class="alert alert-warning">
          <button type="button" class="iqit-close-warning js-iqit-close-warning"><i class="icon-times"></i></button>
          <strong>{l s='There is a cache enabled in your shop!' mod='iqitthemeeditor'}</strong>
          <p>{l s='It may cause that some options of themeeditor will be not refreshed in preview after modification.' mod='iqitthemeeditor'}</p>
          <p>{l s='Consider to disable it during the work with editor' mod='iqitthemeeditor'} (<a href="{$cacheLink}" target="_blank">{l s='Go to Performance tab' mod='iqitthemeeditor'}</a>)
            {l s='Re-enable it once you finish!' mod='iqitthemeeditor'}
          </p>
        </div>
      {/if}

      {$editorForm nofilter}

    </div>

    <div id="iqitfronteditor-tools-bottom">
      <div class="preview-selector">
        {l s='Preview page' mod='iqitthemeeditor'}
        <select id="preview-page">
          {foreach $previewLinks AS $link}
            <option value="{$link.link}">{$link.title}</option>

          {/foreach}
        </select>
      </div>
      <div class="tools">
        <div id="iqitfronteditor-save-false"></div>
        <button type="button" id="iqitfronteditor-save" class="_saved"><i
                  class="icon-save"></i> {l s='Save' mod='iqitthemeeditor'} </button>
        <div id="iqitfronteditor-save-success"><i class="icon-check"></i></div>
        <div class="responsive-buttons">
          <button type="button" class="js-preview-device-switch active" data-device="desktop"><i
                    class="icon-desktop"></i></button>
          <button type="button" class="js-preview-device-switch" data-device="tablet"><i class="icon-tablet"></i>
          </button>
          <button type="button" class="js-preview-device-switch" data-device="phone"><i class="icon-mobile"></i>
          </button>
        </div>
      </div>
    </div>

  </div>
  <div id="iqitfronteditor-preview" class="loading-preview">
    <div id="iqitfronteditor-preview-loader"><div class="loader loader-1"></div></div>
    <iframe id="iqitfronteditor-iframe" src="{$previewLinks.index.link}"></iframe>
  </div>

</div>

<div id="iqitfronteditor-exit-modal">
    <div id="iqitfronteditor-exit-modal-content">
        <span class="modal-tile">{l s='You have unsaved changes, are you sure you want to exit?' mod='iqitthemeeditor'}</span>
        <button type="button" id="iqitfronteditor-modal-close">{l s='Return' mod='iqitthemeeditor'} </button>
        <a href="{$backToBo}" id="iqitfronteditor-modal-back">{l s='Exit without saving changes' mod='iqitthemeeditor'} </a>
    </div>
</div>

</body>
</html>



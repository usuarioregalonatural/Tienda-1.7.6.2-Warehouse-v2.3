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
  <title>{l s='Elementor editor' mod='iqitelementor'}</title>
  {* heade section *}
  <script type="text/javascript">
    var iso_user = '{$iso_user|@addcslashes:'\''}';
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
  {if isset($css_files)}
    {foreach from=$css_files key=css_uri item=media}
      <link href="{$css_uri|escape:'html':'UTF-8'}" rel="stylesheet" type="text/css"/>
    {/foreach}
  {/if}
</head>
<body class="elementor-editor-active">
{$pluginContent}

{* footer section *}

<script type="text/template" id="tmpl-elementor-empty-preview">
  <div class="elementor-first-add">
    <div class="elementor-icon eicon-plus"></div>
  </div>
</script>
<script type="text/template" id="tmpl-elementor-preview">
  <div id="elementor-section-wrap"></div>
  <div id="elementor-add-section" class="elementor-visible-desktop">
    <div id="elementor-add-section-inner">
      <div id="elementor-add-new-section">
        <button id="elementor-add-section-button"
                class="elementor-button">{l s='Add New Section' mod='iqitelementor'}</button>
        <button id="elementor-add-template-button"
                class="elementor-button">{l s='Add Template' mod='iqitelementor'}</button>
        <div id="elementor-add-section-drag-title">{l s='Or drag widget here' mod='iqitelementor'}</div>
      </div>
      <div id="elementor-select-preset">
        <div id="elementor-select-preset-close">
          <i class="fa fa-times"></i>
        </div>
        <div id="elementor-select-preset-title">{l s='Select your Structure' mod='iqitelementor'}</div>
        <ul id="elementor-select-preset-list">
          {literal}
          <#
                  var structures = [ 10, 20, 30, 40, 21, 22, 31, 32, 33, 50, 60, 34 ];

                  _.each( structures, function( structure ) {
                  var preset = elementor.presetsFactory.getPresetByStructure( structure ); #>

            <li class="elementor-preset elementor-column elementor-col-16"
                data-structure="{{ structure }}">
              {{{ elementor.presetsFactory.getPresetSVG( preset.preset ).outerHTML }}}
            </li>
            <# } ); #>
              {/literal}
        </ul>
      </div>
    </div>
  </div>
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


</body>
</html>



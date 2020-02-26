{**
 * 2007-2017 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2017 PrestaShop SA
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
{extends file='layouts/layout-error.tpl'}

 {block name='stylesheets' append}
      <script src="https://use.fontawesome.com/f26ca72beb.js"></script>
    {/block}




{block name='body_tag'}
<body id="maintenance-page" class="maintenance-page maintenance-page-layout-{$iqitTheme.mcs_layout}">
{/block}

{block name='layout_error_tag'}
    <div>
{/block}

    {block name='content'}

        {if $iqitTheme.mcs_layout == 1}
            {include file='errors/_maintenance/maintenance-1.tpl'}
        {elseif $iqitTheme.mcs_layout == 2}
            {include file='errors/_maintenance/maintenance-2.tpl'}
        {/if}
    {/block}

{block name='maintenance_js'}

    <script
  src="https://code.jquery.com/jquery-3.1.1.slim.min.js"
  integrity="sha256-/SIrNqv8h6QGKDuNoLGA4iret+kyesCkHGzVUUV0shc="
  crossorigin="anonymous"></script>
    <script type="text/javascript" src="{$iqitThemeMaintenanceJs}"></script>
{/block}
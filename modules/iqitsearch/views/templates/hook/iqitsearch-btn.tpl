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

<div id="header-search-btn" class="col col-auto header-btn-w header-search-btn-w">
    <a data-toggle="dropdown" id="header-search-btn-drop"  class="header-btn header-search-btn" data-display="static">
        <i class="fa fa-search fa-fw icon" aria-hidden="true"></i>
        <span class="title">{l s='Search' d='Shop.Theme.Catalog'}</span>
    </a>
    {if isset($iqitTheme.h_search_type) && $iqitTheme.h_search_type == 'full'}
    <div class="dropdown-menu-custom  dropdown-menu">
        <div class="dropdown-content modal-backdrop fullscreen-search">
            {include 'module:iqitsearch/views/templates/hook/search-bar.tpl'}
            <div id="fullscreen-search-backdrop"></div>
        </div>
    </div>
    {else}
        <div class="dropdown-content dropdown-menu dropdown-search">
            {include 'module:iqitsearch/views/templates/hook/search-bar.tpl'}
        </div>
    {/if}
</div>

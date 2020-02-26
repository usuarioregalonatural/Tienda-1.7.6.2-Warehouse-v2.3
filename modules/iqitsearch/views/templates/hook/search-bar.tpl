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


<!-- Block search module TOP -->
<div id="search_widget" class="search-widget" data-search-controller-url="{$search_controller_url}">
    <form method="get" action="{$search_controller_url}">
        <input type="hidden" name="controller" value="search">
        <div class="input-group">
            <input type="text" name="s" value="{$search_string}" data-all-text="{l s='Show all results' mod='iqitsearch'}"
                   placeholder="{l s='Search our catalog' mod='iqitsearch'}" class="form-control form-search-control" />
            <button type="submit" class="search-btn">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </form>
</div>
<!-- /Block search module TOP -->


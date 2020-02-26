{*
* 2007-2018 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
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
* @author    Anvanto <applynovation@gmail.com>
* @copyright 2007-2018 Anvanto
* @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*}
<script>
    jQuery(document).ready(function(){
        jQuery('.an_tabs_btn').click(function(){
            $('.an_tabs_btn').removeClass('btn-info');
            $(this).addClass('btn-info');
            $('.tab_content').hide();
            $('#' + $(this).attr('id') + '_content').show();
        });
    });
</script>
<div id="tabs" class="an_productfields-style col-lg-3 col-md-12">
    <div class="tabswrapper">
        <button id="btn_tab_1" class="btn btn-default btn-info an_tabs_btn">
            {l s='Product fields' mod='an_productfields'}
        </button>
        <button id="btn_tab_2" class="btn btn-default an_tabs_btn">
            {l s='Settings' mod='an_productfields'}
        </button>
        <a href="http://bit.ly/2V5FJi3" class="btn btn-default an_tabs_btn">
            {l s='Support' mod='an_productfields'}
        </a>
        <a href="http://bit.ly/2K9MYjW" class="btn btn-default an_tabs_btn">
            {l s='Another modules' mod='an_productfields'}
        </a>
    </div>
    <div class="an_theme-text-menu">
        <strong>Rating:</strong> <br>
        If you like this module, Please RATE me 5 stars <a style="padding: 0px;" href="http://bit.ly/2WGXfp0">here</a>.<br>
        Thank you very much!
    </div>
</div>
<div class="an_productfields-style col-lg-9 col-md-12">
    <div id="btn_tab_1_content" class="tab_content">{$an_pf_feildslist}</div> {* HTML form, no escape necessary *}
    <div id="btn_tab_2_content" class="tab_content" style="display: none"> {$an_pf_settings}</div> {* HTML form, no escape necessary *}
</div>
<div class="clearfix"></div>
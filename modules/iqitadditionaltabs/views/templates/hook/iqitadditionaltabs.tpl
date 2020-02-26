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

{if isset($tabs) && $tabs}
    <div id="iqitadditionaltabs-accordion" class="iqit-accordion" role="tablist" aria-multiselectable="true">
        {foreach from=$tabs item="tab" name=foo}
            <div class="card">
                <div class="title" role="tab">
                        <a class="collapsed" data-toggle="collapse" data-parent="#iqitadditionaltabs-accordion" href="#iqitadditionaltabs-accordion-{$smarty.foreach.foo.index}" aria-expanded="true">
                            {$tab.title}

                            <i class="fa fa-angle-down float-right angle-down" aria-hidden="true"></i>
                            <i class="fa fa-angle-up float-right angle-up" aria-hidden="true"></i>
                        </a>
                </div>
                <div id="iqitadditionaltabs-accordion-{$smarty.foreach.foo.index}" class="content collapse" role="tabpanel">
                    <div class="rte-content">
                        {$tab.description nofilter}
                    </div>
                </div>
            </div>
        {/foreach}
    </div>
{/if}


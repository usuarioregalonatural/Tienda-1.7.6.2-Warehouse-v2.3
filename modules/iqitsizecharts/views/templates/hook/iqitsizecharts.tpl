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

{if isset($charts) && $charts}

    <button class="btn btn-secondary mt-3" data-button-action="open-iqitsizecharts" type="button" data-toggle="modal" data-target="#iqitsizecharts-modal">
        <i class="fa fa-table"></i> {l s='Size chart' mod='iqitsizecharts'}
    </button>

    <div class="modal fade js-iqitsizecharts-modal" id="iqitsizecharts-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                        <span class="modal-title">{l s='Size charts' mod='iqitsizecharts'}</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <ul class="nav nav-tabs">
                    {foreach from=$charts key=i item=chart name=charts}
                        <li class="nav-item">
                            <a class="nav-link{if $smarty.foreach.charts.first} active{/if}" data-toggle="tab" href="#iqitcharts-tab-{$i}">
                                {$chart.title}
                            </a>
                        </li>
                    {/foreach}
                </ul>

                <div class="tab-content" id="tab-content">
                {foreach from=$charts key=i item=chart name=charts}
                    <div class="tab-pane in{if $smarty.foreach.charts.first} active{/if}" id="iqitcharts-tab-{$i}">
                        <div class="rte-content">{$chart.description nofilter}</div>
                    </div>
                {/foreach}
                </div>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{/if}
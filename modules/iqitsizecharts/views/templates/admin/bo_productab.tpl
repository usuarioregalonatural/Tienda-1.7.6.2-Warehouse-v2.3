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

<fieldset class="form-group">
    <label class="form-control-label">{l s='Select from created guides'  mod='iqitsizecharts'}</label>

    <div class="row">
        <div class="col-md-6">
            <select  name="iqitsizecharts[chart]" id="iqitsizecharts_chart"  data-toggle="select2">
                <option value="-1" {if !isset($selectedChart) || isset($selectedChart) && ($selectedChart == -1)}selected="selected"{/if}>{l s='Inherit from category associations'  mod='iqitsizecharts'}</option>
                <option value="0" {if isset($selectedChart) && ($selectedChart == 0)}selected="selected"{/if}>{l s='Disable'  mod='iqitsizecharts'}</option>
                <option value="-2" disabled>- {l s='Choose (it will override category associations)'  mod='iqitsizecharts'} - </option>
                {if isset($charts)}
                    {foreach from=$charts item=chart}
                        <option value="{$chart.id_iqitsizechart}" {if isset($selectedChart) && ($chart.id_iqitsizechart == $selectedChart)}selected="selected"{/if}>{$chart.title}</option>
                    {/foreach}
                {/if}
            </select>
        </div>
    </div>
    <hr>
    <div>{l s='Or'  mod='iqitsizecharts'}</div>
 <a href="{$moduleLink}" target="_blank"><i class="material-icons">open_in_new</i> {l s='Create new guide'  mod='iqitsizecharts'}</a>
</fieldset>



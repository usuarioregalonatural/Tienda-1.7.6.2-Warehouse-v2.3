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

{extends file='page.tpl'}

{block name='page_title'}{/block}
{block name='head_seo'}{/block}

{block name='page_content'}
    <section id="content" class="page-content">
        <section class="form-fields">
            {block name='form_fields'}
                {foreach from=$formFields item="field"}
                    {block name='form_field'}
                        {form_field field=$field}
                    {/block}
                {/foreach}
            {/block}

            <span data-toggle="tooltip" data-animation="false" data-placement="top" title="" data-original-title="Test">Tooltip</span>
            <div class="products-sort-nb-dropdown products-sort-order dropdown">
                <a class="select-title expand-more form-control" rel="nofollow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="select-title-name">Dropdown</span>
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                </a>
                <div class="dropdown-menu">
                    <a class="select-list dropdown-item current">
                        Dropdown
                    </a>
                    <a class="select-list dropdown-item">
                        Name, A to Z
                    </a>
                    <a class="select-list dropdown-item">
                        Name, Z to A
                    </a>
                    <a class="select-list dropdown-item">
                        Price, low to high
                    </a>
                </div>
            </div>
        </section>
    </section>
{/block}


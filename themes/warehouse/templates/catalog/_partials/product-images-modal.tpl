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
<div class="modal fade js-product-images-modal" id="product-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">{l s='Tap to zoom' d='Shop.Theme.Catalog'}</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {assign var=imagesCount value=$product.images|count}
                <div class="easyzoom easyzoom-modal">
                    <a href="{$product.cover.large.url}" class="js-modal-product-cover-easyzoom">
                        <img class="js-modal-product-cover product-cover-modal img-fluid"
                             width="{$product.cover.large.width}"
                             alt="{$product.cover.legend}" title="{$product.cover.legend}">
                    </a>
                </div>
                <aside id="thumbnails" class="thumbnails js-thumbnails text-xs-center">
                    {block name='product_images'}
                        {if $product.images|@count gt 1}
                        <div class="js-modal-mask mask {if $imagesCount <= 5} nomargin {/if}">
                            <div id="modal-product-thumbs" class="product-images js-modal-product-images slick-slider">
                                {foreach from=$product.images item=image}
                                    <div class="thumb-container">
                                        <img data-image-large-src="{$image.large.url}" class="thumb js-modal-thumb img-fluid"
                                             data-lazy="{$image.medium.url}" alt="{$image.legend}" title="{$image.legend}"
                                             width="{$image.medium.width}" itemprop="image">
                                    </div>
                                {/foreach}
                            </div>
                        </div>
                        {/if}
                    {/block}
                </aside>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

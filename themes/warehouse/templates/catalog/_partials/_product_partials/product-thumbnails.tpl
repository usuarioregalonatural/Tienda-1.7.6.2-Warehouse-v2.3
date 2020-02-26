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

{block name='product_images'}
    {if $product.images|@count gt 1}
    <div class="js-qv-mask mask">
        <div id="product-images-thumbs" class="product-images js-qv-product-images slick-slider">
            {foreach from=$product.images item=image name=thumbs}
                <div class="thumb-container">
                    <img
                            class="thumb js-thumb {if $image.id_image == $product.cover.id_image} selected {/if}img-fluid"
                            data-image-medium-src="{$image.bySize.medium_default.url}"
                            data-image-large-src="{$image.large.url}"
                            src="{$image.bySize.medium_default.url}"
                            alt="{$image.legend}"
                            title="{$image.legend}"
                            width="{$image.bySize.medium_default.width}"
                            height="{$image.bySize.medium_default.height}"
                            itemprop="image"
                    >
                </div>
            {/foreach}
        </div>
    </div>
    {/if}
{/block}

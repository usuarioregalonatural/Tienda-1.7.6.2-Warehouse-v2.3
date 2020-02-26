{*
* 2017 IQIT-COMMERCE.COM
*
* @author    IQIT-COMMERCE.COM <support@iqit-commerce.com>
* @copyright 2017 IQIT-COMMERCE.COM
* @license   Commercial license (You can not resell or redistribute this software.)
*
*}

<article class="iqitcompare-product">
    <div class="pack-product-container">
      <div class="thumb-mask">
          <a href="{$product.url}" > <img class="img-fluid"
                  src = "{$product.cover.medium.url}"
                  alt = "{$product.cover.legend}"
          ></a>
      </div>
      <div class="pack-product-name">
        <a href="{$product.url}">{$product.name}</a>
      </div>
      {if $product.show_price}
        <div class="product-price">
          {if $product.has_discount}
            <span class="product-discount"><span class="regular-price">{$product.regular_price}</span></span>
          {/if}
          <span class="product-price">{$product.price}</span>
        </div>
      {/if}

          <a href="#" class="js-iqitcompare-remove iqitcompare-remove"
             data-id-product="{$product.id_product|intval}"
            data-url="{url entity='module' name='iqitcompare' controller='actions'}">
              <i class="fa fa-trash-o" aria-hidden="true"></i>
            </a>

        {hook h='displayProductRating' product=$product}

      </div>
    </div>
</article>
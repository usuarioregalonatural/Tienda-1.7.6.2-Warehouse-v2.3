<div class="block-section simpleblog-related-products">
	<h4 class="section-title"><span>{l s='Related products' mod='ph_simpleblog'}</span></h4>

	<div class="block-content">
		<div class="products slick-products-carousel products-grid slick-default-carousel">
			{foreach from=$related_products item="product"}
				{block name='product_miniature'}
					{include file='catalog/_partials/miniatures/product.tpl' product=$product carousel=true}
				{/block}
			{/foreach}
		</div>
	</div>
</div><!-- .simpleblog-related-products -->
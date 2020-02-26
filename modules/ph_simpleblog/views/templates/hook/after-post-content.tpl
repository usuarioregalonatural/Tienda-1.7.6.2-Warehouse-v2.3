{if Configuration::get('PH_BLOG_DISPLAY_SHARER')}
<div class="post-block simpleblog-socialshare">
	<h3 class="block-title">{l s='Share this post' mod='ph_simpleblog'}</h3>

	<div class="simpleblog-socialshare-icons">
		<button data-type="twitter" type="button" class="btn btn-default btn-twitter">
			<i class="fa fa-twitter"></i> {l s="Tweet" mod='ph_simpleblog'}
		</button>
		<button data-type="facebook" type="button" class="btn btn-default btn-facebook">
			<i class="fa fa-facebook"></i> {l s="Share" mod='ph_simpleblog'}
		</button>
		<button data-type="google-plus" type="button" class="btn btn-default btn-google-plus">
			<i class="fa fa-google-plus"></i> {l s="Google+" mod='ph_simpleblog'}
		</button>
		<button data-type="pinterest" type="button" class="btn btn-default btn-pinterest">
			<i class="fa fa-pinterest"></i> {l s="Pinterest" mod='ph_simpleblog'}
		</button>
	</div><!-- simpleblog-socialshare-icons. -->
</div><!-- .simpleblog-socialshare -->
{/if}
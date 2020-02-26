{if $posts}
<section class="related-blog-posts ph_simpleblog block block-section">
	<h4 class="section-title"><span>{l s='Related posts' mod='ph_relatedposts'}</span>
	</h4>
	<div class="block-content">
		<div class="row simpleblog-posts">
			{foreach $posts as $post}
				<div class="simpleblog-posts-column col-6 col-md-4 col-lg-3">{include file="module:ph_simpleblog/views/templates/front/1.7/_partials/post-miniature.tpl" post=$post}</div>
			{/foreach}
		</div>
	</div>
</section>
{/if}
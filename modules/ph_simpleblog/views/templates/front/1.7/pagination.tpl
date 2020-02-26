<!-- Pagination -->
{if $start!=$stop}
<nav class="simpleblog__listing__pagination pagination">
        <ul class="page-list clearfix text-center">
        	{if $p != 1}
				{assign var='p_previous' value=$p-1}
				<li>
					<a rel="prev" href="{SimpleBlogPost::getPageLink($p_previous, $type, $rewrite)}" class="previous disabled "><i class="fa fa-angle-left" aria-hidden="true"></i> {l s='Previous' mod='ph_simpleblog'} </a>
				</li>
			{else}
				<li>
					<a rel="prev" href="#" class="previous disabled "><i class="fa fa-angle-left" aria-hidden="true"></i> {l s='Previous' mod='ph_simpleblog'} </a>
				</li>
			{/if}
			{if $start > 1}
				<li><a href="{SimpleBlogPost::getPageLink(1, $type, $rewrite)}">1</a></li>
				<li class="spacer">
					<span >…</span>
				</li>
			{/if}
			{section name=pagination start=$start loop=$stop+1 step=1}
				{if $p == $smarty.section.pagination.index}
					<li class="current">
						<a href="#" class="disabled">{$p}</a>
					</li>
				{else}
					<li>
						<a href="{SimpleBlogPost::getPageLink($smarty.section.pagination.index, $type, $rewrite)}">{$smarty.section.pagination.index}</a>
					</li>
				{/if}
			{/section}
            {if $pages_nb>$stop}
				<li  class="spacer">
					<span>…</span>
				</li>
				<li><a href="{SimpleBlogPost::getPageLink($pages_nb, $type, $rewrite)}">{$pages_nb|intval}</a></li>
			{/if}
			{if $pages_nb > 1 AND $p != $pages_nb}
				{assign var='p_next' value=$p+1}
				<li>
	                <a rel="next" href="{SimpleBlogPost::getPageLink($p_next, $type, $rewrite)}" class="next ">
	                	{l s='Next' mod='ph_simpleblog'} <i class="fa fa-angle-right" aria-hidden="true"></i>
	                </a>
	            </li>
			{else}
				<li>
	                <a rel="next" href="#" class="next  disabled">{l s='Next' mod='ph_simpleblog'} <i class="fa fa-angle-right" aria-hidden="true"></i></a>
	            </li>
			{/if}
        </ul>
</nav>
{/if}
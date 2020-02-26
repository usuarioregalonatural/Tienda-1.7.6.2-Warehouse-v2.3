{if $phpWarning eq true}
<div class="alert alert-warning">
{l s='Important! Starting April 2017, Blog for PrestaShop will support only PHP in version 5.6 or higher, ask your hosting provider to update PHP version on your server.' mod='ph_simpleblog'}
</div>
{/if}

<div class="panel">
	<div class="panel-heading">
		{l s='Blog for PrestaShop' mod='ph_simpleblog'}
	</div>

	<p>
		{l s='THANK YOU for choosing my module.' mod='ph_simpleblog'}
		<br>
		{l s='You can start fun with Blog for PrestaShop by going to Blog for PrestaShop -> Posts' mod='ph_simpleblog'}
	</p>
	<p>
		<b>{l s='What is next?' mod='ph_simpleblog'}</b>
		<ol>
			<li>{l s='First of all make sure to subscribe to our newsletter :-) We promise to keep everything PrestaShop related and provide you with a lot of quality content.' mod='ph_simpleblog'}</li>
			<li>{l s='Secondly, after installing main module - ph_simpleblog - make sure to install Recent Posts widget, it is a module to display Posts on your store homepage.' mod='ph_simpleblog'}</li>
			<li>{l s='And, finally, make sure to read Articles available on http://prestahome.ticksy.com, there\'s a lot of tutorials and tips of how to use Blog for PrestaShop.' mod='ph_simpleblog'}</li>
		</ol>
	</p>
	<p>
		{l s='Remember that if you have any issues or questions related to my module you can contact me on support system at http://prestahome.ticksy.com' mod='ph_simpleblog'}
		<br>
		{l s='Best regards, Krystian from PrestaHome' mod='ph_simpleblog'}
	</p>
</div>

<div class="panel">
	<div class="panel-heading">
		{l s='PrestaHome Newsletter - Stay updated!' mod='ph_simpleblog'}
	</div>
	<form action="//prestahome.us9.list-manage.com/subscribe/post?u=141a9ffd729586fe723fb1eaf&amp;id=711790c865" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate defaultForm form-horizontal" target="_blank" novalidate>
		<div class="form-wrapper">
			<p class="text-center">
				<img src="{$module_path}logo-big.png" alt="{l s='PrestaHome Newsletter' mod='ph_simpleblog'}" style="max-width: 150px;" />
			</p>
			<div class="row">
				<div class="col-lg-4 col-lg-push-4 alert alert-info">
					{l s='If you\'re interested in our work, and you want to receive information about PrestaHome new products, updates or new articles on our blog, you can add your e-mail to PrestaHome Newsletter list!' mod='ph_simpleblog'}
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-lg-5">
					{l s='Your e-mail address:' mod='ph_simpleblog'}
				</label>
				<div class="col-lg-6 ">
					<div class="input-group" style="width: 40%;">
						<input type="text" name="EMAIL">
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-lg-5">
					{l s='Your First Name:' mod='ph_simpleblog'}
				</label>
				<div class="col-lg-6 ">
					<div class="input-group" style="width: 40%;">
						<input type="text" name="FNAME" placeholder="{l s='optional' mod='ph_simpleblog'}" />
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-lg-5">
					{l s='Your Last Name:' mod='ph_simpleblog'}
				</label>
				<div class="col-lg-6">
					<div class="input-group" style="width: 40%;">
						<input type="text" name="LNAME" placeholder="{l s='optional' mod='ph_simpleblog'}" />
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-lg-5">
					{l s='Your website URL:' mod='ph_simpleblog'}
				</label>
				<div class="col-lg-6 ">
					<div class="input-group" style="width: 40%;">
						<input type="text" name="MMERGE3" placeholder="{l s='optional' mod='ph_simpleblog'}" value="{$shopUrl}" />
					</div>
				</div>
			</div>
		</div>
		<div style="position: absolute; left: -5000px;"><input type="text" name="b_141a9ffd729586fe723fb1eaf_711790c865" tabindex="-1" value=""></div>
	<div class="panel-footer">
		<button type="submit" name="subscribe" id="mc-embedded-subscribe" class="btn btn-default pull-right">
			<i class="process-icon-save"></i>
			{l s='Subscribe' mod='ph_simpleblog'}
		</button>
	</div>
	</form>
</div>

{if Configuration::get('PH_BLOG_ADVERTISING')}
<iframe style="overflow:hidden;border:1px solid #f0f0f0;border-radius:10px;width:100%;height:175px;" src="https://api.prestahome.com/check_offer.php?from=ph_simpleblog" border="0"></iframe>
<small>{l s='You can disable this panel in the Settings' mod='ph_simpleblog'}</small>
{/if}
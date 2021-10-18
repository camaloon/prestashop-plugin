<div class="camaloon-connect-block container">
  <img src="{$connectImgUrl}">
	{if $connected}
		<h6>{l s="Start selling! Create your first product!" mod="Camaloon"}</h6>
		<a class="btn btn-camaloon" target= "_blank" href="{$connectUrl}">{l s="Go to Camaloon store" mod="Camaloon"}</a>
	{else}
		<h6>{l s="Connect your store to Camaloon" mod="Camaloon"}</h6>
		<a class="btn btn-camaloon" target= "_blank" href="{$connectUrl}">{l s="Connect" mod="Camaloon"}</a>
	{/if}
	<div class="row support">
		<div class="col-md-5 col-sm-offset-1">
			<p>{l s="Something wrong with your store?" mod="Camaloon"}</p>
			<a href="{$connectUrl}" class="btn btn-blue">{l s="Check store status" mod="Camaloon"}</a>
		</div>
		<div class="col-md-5 col-sm-offset-1">
			<p>{l s="Need help with your Prestashop setup?" mod="Camaloon"}</p>
			<a href="{$connectUrl}" class="btn btn-blue">{l s="Review our FAQs" mod="Camaloon"}</a>
		</div>
	</div>
</div>


<div class="camaloon-connect-block container">
  <img src="{$connectImgUrl}">

  {if $connected}
    <h6>{l s="Start selling! Create your first product!" mod="Camaloon"}</h6>
    <a class="btn btn-camaloon" target= "_blank" href="{$connectUrl}">{l s="Go to Camaloon store" mod="Camaloon"}</a>

    <form method="post" action="{$disconnectUrl|escape:'html':'UTF-8'}" id="CamaloonConnectForm">
      <button type="submit" class="btn btn-camaloon" name="camaloon_connect" data-connecting-text="{l s='Connecting...' d='Admin.Actions' mod='camaloon'}">
        {l s='Disconnect' d='Admin.Actions' mod='camaloon'}
      </button>
    </form>

  {else}
    <h6>{l s="Connect your store to Camaloon" mod="Camaloon"}</h6>

    <form method="post" action="{$connectUrl|escape:'html':'UTF-8'}" id="CamaloonConnectForm">
      <button type="submit" class="btn btn-camaloon" name="camaloon_connect" data-connecting-text="{l s='Connecting...' d='Admin.Actions' mod='camaloon'}">
        {l s='Connect' mod='camaloon'}
      </button>
    </form>
  {/if}

  <div class="row support">
    <div class="col-md-5 col-sm-offset-1">
      <p>{l s="Something wrong with your store?" mod="Camaloon"}</p>
      <a href="{$statusUrl}" class="btn btn-blue">{l s="Check store status" mod="Camaloon"}</a>
    </div>
    <div class="col-md-5 col-sm-offset-1">
      <p>{l s="Need help with your Prestashop setup?" mod="Camaloon"}</p>
      <a href="{$supportUrl}" class="btn btn-blue">{l s="Review our FAQs" mod="Camaloon"}</a>
    </div>
  </div>
</div>

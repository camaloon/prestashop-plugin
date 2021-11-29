{*
 * 2007-2021 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
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
 *  @author    PrestaShop SA <contact@prestashop.com>
 *  @copyright 2007-2021 PrestaShop SA
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 *}
<div class="camaloon-connect-block container-fluid">
  <div class="row white-content-box">
  <img src="{$connectImgUrl|escape:'htmlall':'UTF-8'}">

  {if $connected}
    <p>{l s='Start selling! Create your first product!' mod='camaloon'}</p>
    <a class="btn btn-camaloon" target= "_blank" href="{$viewStoreUrl|escape:'htmlall':'UTF-8'}">{l s='Go to Camaloon store' mod='camaloon'}</a>

    <form method="post" action="{$disconnectUrl|escape:'html':'UTF-8'}" id="CamaloonConnectForm">
      <button type="submit" class="btn btn-camaloon" name="camaloon_connect" data-connecting-text="{l s='Connecting...' d='Admin.Actions' mod='camaloon'}">
        {l s='Disconnect' d='Admin.Actions' mod='camaloon'}
      </button>
    </form>

  {else}
    <p>{l s='Connect your store to Camaloon' mod='camaloon'}</p>

    <form method="post" action="{$connectUrl|escape:'html':'UTF-8'}" id="CamaloonConnectForm">
      <button type="submit" class="btn btn-camaloon" name="camaloon_connect" data-connecting-text="{l s='Connecting...' d='Admin.Actions' mod='camaloon'}" onClick="setCookieFlashAlert()">
        {l s='Connect' mod='camaloon'}
      </button>
    </form>
  {/if}
  </div>

  <div class="row support">
    <div class="col-md-6 padding-right-white">
      <div class="white-content-box">
        <p>{l s='Something wrong with your store?' mod='camaloon'}</p>
        <a href="{$statusUrl|escape:'htmlall':'UTF-8'}" class="btn btn-blue">{l s='Check store status' mod='camaloon'}</a>
      </div>
    </div>
    <div class="col-md-6 padding-lef-white">
      <div class="white-content-box">
        <p>{l s='Need help with your Prestashop setup?' mod='camaloon'}</p>
        <a href="{$supportUrl|escape:'htmlall':'UTF-8'}" class="btn btn-blue">{l s='Review our FAQs' mod='camaloon'}</a>
      </div>
    </div>
  </div>
</div>

<script>
  function setCookieFlashAlert() {
    document.cookie = "pluginInstalledAlert=true"
  }
</script>

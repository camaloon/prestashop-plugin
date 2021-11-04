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
<div class="container-fluid status-container-block">
  <div class="row">
    <div class="col-md-12 status-container">
      <h3 class="system-status">{l s='System status' mod='camaloon'}</h3>
      <div class="description">
        {l s='Review the status of your connection. Errors in the connection of your store setup may cause the Camaloon integration to not work as intended.' mod='camaloon'}
      </div>
      <div class="table-responsive-row clearfix">
        <table class="table table-hover">
          <thead class="top-thead">
            <tr>
              <td><h3>{l s='Name' mod='camaloon'}</h3></td>
              <td><h3>{l s='Description' mod='camaloon'}</h3></td>
              <td class="text-center"><h3>{l s='Status' mod='camaloon'}</h3></td>
            </tr>
        </thead>
        {foreach key=key item=item from=$items}
            <tr>
              <td>{$item['name']|escape:'htmlall':'UTF-8'}</td>
              <td>{$item['description']|escape:'htmlall':'UTF-8'}</td>
              <td class="text-center {(($item['value'] == 1) ? 'green-text' : 'red-text')|escape:'htmlall':'UTF-8'}">{(($item['value'] == 1) ? 'OK' : 'FAIL')|escape:'htmlall':'UTF-8'}</td>
            </tr>
        {/foreach}
          <thead>
            <tr>
              <td><h3>{l s='Name' mod='camaloon'}</h3></td>
              <td><h3>{l s='Description' mod='camaloon'}</h3></td>
              <td class="text-center"><h3>{l s='Status' mod='camaloon'}</h3></td>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>

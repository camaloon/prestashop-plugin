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
<div class="container-fluid support-container-block">
  <div class="row">
    <div class="col-md-12 faqs-container">
      <p>
        <h2>{l s='Frequently Asked Questions' mod='camaloon'}</h2>
        <div class="description">
          {l s='Getting started made easy. Read the FAQs to jumpstart your business.' mod='camaloon'}
        </div>
      </p>
      <div class="white-content-box white-box-ordered white-content-box-left">
        {foreach key=key item=faq from=$faqs}
            <div class="faq">
              <h2>{html_entity_decode($faq["question_{$iso_code}"]|escape:'htmlall':'UTF-8')}</h2>
              <p>{html_entity_decode($faq["answer_{$iso_code}"]|escape:'htmlall':'UTF-8')}</p>
            </div>
        {/foreach}
      </div>
    </div>
  </div>
</div>

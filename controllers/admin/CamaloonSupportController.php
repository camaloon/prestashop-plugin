<?php
/**
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
 */

require_once 'CamaloonPluginController.php';

class CamaloonSupportController extends CamaloonPluginController
{
    public function initContent()
    {
        parent::initContent();

        $this->checksService = Camaloon::getService(Camaloon\services\CamaloonChecksService::class);
        $this->clientService = Camaloon::getService(Camaloon\services\CamaloonClientService::class);

        $response = $this->clientService->get('/api/print_on_demand/faqs?target=prestashop')['result'];
        $iso_code = $this->context->language->language_code;

        $this->setMedia();
        $this->renderTemplate($this->l('support'), [
            'title' => $this->l('FAQs'),
            'faqs' => $response,
            'iso_code' => $this->getLocaleCodeBySelectedLanguage($iso_code),
            'items' => $this->checksService->camaloonGetChecklistItems()
        ]);
    }

    public function setMedia($isNewTheme = false)
    {
        $this->addCSS($this->module->getLocalPath() . 'views/css/support.css');
        $this->addJS($this->module->getLocalPath() . 'views/js/support.js');
        parent::setMedia($isNewTheme);
    }

    private static function getLocaleCodeBySelectedLanguage($iso_code)
    {
        switch ($iso_code) {
            case 'es-es':
                return 'es';
            case 'en-gb':
                return 'en';
            case 'da-dk':
                return 'da';
            case 'de-de':
                return 'de';
            case 'fr-fr':
                return 'fr';
            case 'it-it':
                return 'it';
            case 'nl-nl':
                return 'nl';
            case 'nn-no':
                return 'no';
            case 'pt-pt':
                return 'pt';
            case 'sv-se':
                return 'sv';
            default:
                return 'en';
        }
    }
}

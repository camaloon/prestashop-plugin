<?php

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
            'items' => $this->checksService->camaloon_getChecklistItems()
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

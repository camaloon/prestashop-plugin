<?php

require_once("CamaloonPluginController.php");

class CamaloonConnectController extends CamaloonPluginController
{
    const CONNECT_ACTION = 'connect';
    const DISCONNECT_ACTION = 'disconnect';

    public function __construct()
    {
        parent::__construct();

        $this->connectService = Camaloon::getService(Camaloon\services\ConnectService::class);
        $this->webserviceService = Camaloon::getService(Camaloon\services\WebserviceService::class);
    }

    public function initContent()
    {
        parent::initContent();

        # $connected = false;
        $connected = $this->connectService->isConnected();

        // This controller will deal with prestashop connection side.
        // The action atribute is used to define the user request.
        $connectControllerLink = $this->context->link->getAdminLink(Camaloon::CONNECT_CONTROLLER);

        $this->loadConnectionMessages($connected);

        $this->addCSS($this->getCssPath('connect.css'));

        $this->renderTemplate('connect', array(
            'title' => 'Camaloon Print on Demand',
            'connectUrl' => $connectControllerLink . '&action=' . self::CONNECT_ACTION,
            'disconnectUrl' => $connectControllerLink . '&action=' . self::DISCONNECT_ACTION,
            'statusUrl' => $this->context->link->getAdminLink(Camaloon::STATUS_CONTROLLER),
            'supportUrl' => $this->context->link->getAdminLink(Camaloon::SUPPORT_CONTROLLER),
            'connectImgUrl' => $this->module->getPathUri() . 'views/img/camaloon-homepage.svg',
            'connected' => $connected
        ));
    }

    public function postProcess()
    {
        if (Tools::getValue('action') == self::CONNECT_ACTION) {
            $this->connectAction();
        } else if (Tools::getValue('action') == self::DISCONNECT_ACTION) {
            $this->disconnectAction();
        }

        return true;
    }

    public function connectAction() {
        // asures webservice prestashop feature is enabled
        $this->webserviceService->enableWebservice();

        // get previous connection if it exists
        $webService = $this->webserviceService->getConnectedWebservice();

        // otherwise, create a new one
        if(!$webService) {
            $webService = $this->webserviceService->createNewWebservice();
        }

        // Set/renew required permissions
        $this->webserviceService->renewPermissions($webService);

        // Save websersvice on configurations table
        $this->webserviceService->registerWebservice($webService);

        $redirectUrl = $this->connectService->buildConnectUrl($webService);
        Tools::redirect($redirectUrl);
    }

    public function disconnectAction() {
        $this->connectService->disconnect();

        // TODO: Should we notify camaloon?

        $this->warnings[] = $this->module->l('You have successfully disconnected your store from Camaloon.');
  }

  // Only renders connection message on the first access after connection attempt.
  public function loadConnectionMessages($connected) {
      if (Configuration::get(Camaloon::CONFIG_IS_FIRST_CONNECTION)) {
          if ($connected) {
              $this->informations[] = $this->module->l('You have successfully connected to Camaloon');
          } else {
              $this->errors[] = $this->module->l('Your connection to Camaloon failed');
          }

          Configuration::updateValue(Camaloon::CONFIG_IS_FIRST_CONNECTION, false);
      }
  }
}

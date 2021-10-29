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
        $this->clientService = Camaloon::getService(Camaloon\services\CamaloonClientService::class);
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
        $this->checkForStore($connectControllerLink);

        $this->renderTemplate('connect', array(
            'title' => $this->l('Camaloon Print on Demand'),
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

    public function connectAction()
    {
        // asures webservice prestashop feature is enabled
        $this->webserviceService->enableWebservice();

        // get previous connection if it exists
        $webService = $this->webserviceService->getConnectedWebservice();

        // otherwise, create a new one
        if (!$webService) {
            $webService = $this->webserviceService->createNewWebservice();
        }

        // Set/renew required permissions
        $this->webserviceService->renewPermissions($webService);

        // Save websersvice on configurations table
        $this->webserviceService->registerWebservice($webService);

        $redirectUrl = $this->connectService->buildConnectUrl($webService);
        Tools::redirect($redirectUrl);
    }

    public function disconnectAction($deleteCamaloonInfo=true)
    {
        if($deleteCamaloonInfo === true){
            $webService = $this->webserviceService->getConnectedWebservice();
        
            if ($webService !== null) {
                $response = $this->clientService->put(Camaloon\services\CamaloonClientService::DISCONNECT_STORE_URL.$webService->key);
            }
        }
        $this->connectService->disconnect();
        $this->warnings[] = $this->module->l('Your store has been disconnected');
        
    }

    public function checkForStore($connectControllerLink)
    {
        $webService = $this->webserviceService->getConnectedWebservice();
        
        if($webService !== null){
            $response = $this->clientService->get(Camaloon\services\CamaloonClientService::STORE_STATUS_URL.$webService->key);
            if($response['status'] === 404 || $response['result'] && $response['result']['inactive'] === true){
                $this->disconnectAction(false);
                Tools::redirectAdmin($this->context->link->getAdminLink(Camaloon::CONNECT_CONTROLLER));
            }
        }
    }

    // Only renders connection message on the first access after connection attempt.
    public function loadConnectionMessages($connected)
    {
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

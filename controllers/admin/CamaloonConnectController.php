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
        $this->checksService = Camaloon::getService(Camaloon\services\CamaloonChecksService::class);
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
        $this->checkForStore();

        $this->renderTemplate('connect', array(
            'title' => $this->l('Camaloon Print on Demand'),
            'viewStoreUrl' => Camaloon::CAMALOON_HOST . "/print_on_demand/stores/" . $this->connectService->getStoreId() . "/edit",
            'connectUrl' => $connectControllerLink . '&action=' . self::CONNECT_ACTION,
            'disconnectUrl' => $connectControllerLink . '&action=' . self::DISCONNECT_ACTION,
            'statusUrl' => $this->context->link->getAdminLink(Camaloon::STATUS_CONTROLLER),
            'supportUrl' => $this->context->link->getAdminLink(Camaloon::SUPPORT_CONTROLLER),
            'connectImgUrl' => $this->module->getPathUri() . 'views/img/camaloon-homepage.svg',
            'connected' => $connected
        ));

        if ($this->checksService->camaloonChecksFailed() === -1 && isset($_COOKIE["pluginInstalledAlert"])) {
            $this->errors[] =  $this->module->l('Something went wrong with the connection. 
Please check status section or try again.');
        }
    }

    public function postProcess()
    {
        if (Tools::getValue('action') == self::CONNECT_ACTION) {
            $this->connectAction();
        } elseif (Tools::getValue('action') == self::DISCONNECT_ACTION) {
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

    public function disconnectAction($deleteCamaloonInfo = true)
    {
        if ($deleteCamaloonInfo === true) {
            $webService = $this->webserviceService->getConnectedWebservice();
        
            if ($webService !== null) {
                $deleteUrl = Camaloon\services\CamaloonClientService::DISCONNECT_STORE_URL.$webService->key;
                $this->clientService->put($deleteUrl);
            }
        }
        $this->connectService->disconnect();
        $this->warnings[] = $this->module->l('Your store has been disconnected');
    }

    public function checkForStore()
    {
        $webService = $this->webserviceService->getConnectedWebservice();
        
        if ($webService !== null) {
            $statusUrl = Camaloon\services\CamaloonClientService::STORE_STATUS_URL.$webService->key;
            $response = $this->clientService->get($statusUrl);
            if ($response['status'] === 404 || $response['result'] && $response['result']['inactive'] === true) {
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

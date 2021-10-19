<?php

/**
 * PrestaShop module for Camaloon
 *
 * @author    Camaloon
 * @copyright 2021 Camaloon
 * @license   GPL 3 license see LICENSE.txt
 */

namespace Camaloon\services;

use Configuration;
use Camaloon;
use WebserviceKeyCore;

/**
 * Class ConnectService
 * @package Camaloon\services
 */
class ConnectService
{
    const CONNECT_URL = '/print_on_demand/prestashop/bridge';

    /** @var WebserviceService */
    private $webserviceService;

    /**
     * ConnectService constructor.
     * @param WebserviceService $webserviceService
     */
    public function __construct(WebserviceService $webserviceService)
    {
        $this->webserviceService = $webserviceService;
    }

    /**
     * @return bool
     */
    public function isConnected()
    {
        $apiKey = Configuration::get(Camaloon::CONFIG_API_KEY);
        $serviceKeyId = Configuration::get(Camaloon::CONFIG_WEBSERVICE_KEY_ID);
        $webService = $this->webserviceService->getWebserviceById($serviceKeyId);

        return $apiKey && $webService;
    }

    /**
     * @return string
     */
    public function buildCallbackUrl()
    {
        $adminLink = (new \LinkCore())->getModuleLink('camaloon', 'connect');
        return $adminLink;
    }

    public function buildConnectUrl(WebserviceKeyCore $webService)
    {
        $url = Camaloon::CAMALOON_HOST . self::CONNECT_URL;
        $callbackUrl = $this->buildCallbackUrl();

        $params = array(
            'domain' => Camaloon::getStoreAddress(),
            'ssl_enabled' => !!Configuration::get('PS_SSL_ENABLED'),
            'webservice_key' => $webService->key,
            'callback_url' => $callbackUrl
        );

        return $url . '?' . http_build_query($params);
    }

    public function disconnect()
    {
        Configuration::deleteByName(Camaloon::CONFIG_WEBSERVICE_KEY_ID);
        Configuration::deleteByName(Camaloon::CONFIG_API_KEY);
    }
}

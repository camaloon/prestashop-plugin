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
        $storeId = Configuration::get(Camaloon::CONFIG_STORE_ID);
        $serviceKeyId = Configuration::get(Camaloon::CONFIG_WEBSERVICE_KEY_ID);
        $webService = $this->webserviceService->getWebserviceById($serviceKeyId);

        return $storeId && $apiKey && $webService;
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
        Configuration::deleteByName(Camaloon::CONFIG_STORE_ID);
    }
}

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

use Exception;

class CamaloonClientService
{
    private $apiUrl;
    const STORE_STATUS_URL = '/print_on_demand/api/prestashop/stores/store_status/';
    const DISCONNECT_STORE_URL = '/print_on_demand/api/prestashop/stores/disconnect_store/';
    /**
     * @param string $host_param Host for api data
     *
     * @throws CamaloonException if the library failed to initialize
     */
    public function __construct()
    {
        if (!function_exists('json_decode') || !function_exists('json_encode')) {
            throw new CamaloonException('PHP JSON extension is required for the Camaloon API library to work!');
        }
        //setup api host
        $this->apiUrl = 'https://camaloon.com';
    }

    /**
     * Perform a GET request to the API
     * @param string $path Request path (e.g. 'orders' or 'orders/123')
     * @return mixed API response
     * @throws CamaloonApiException if the API call status code is not in the 2xx range
     * @throws CamaloonException if the API call has failed or the response is invalid
     */
    public function get($path)
    {
        return $this->request('GET', $path);
    }

    /**
     * Perform a DELETE request to the API
     * @param string $path Request path (e.g. 'orders' or 'orders/123')
     * @return mixed API response
     * @throws CamaloonApiException if the API call status code is not in the 2xx range
     * @throws CamaloonException if the API call has failed or the response is invalid
     */
    public function delete($path)
    {
        return $this->request('DELETE', $path);
    }

    /**
     * Perform a POST request to the API
     * @param string $path Request path (e.g. 'orders' or 'orders/123')
     * @param array $data Request body data as an associative array
     * @return mixed API response
     * @throws CamaloonApiException if the API call status code is not in the 2xx range
     * @throws CamaloonException if the API call has failed or the response is invalid
     */
    public function post($path, $data = [])
    {
        return $this->request('POST', $path, $data);
    }

    /**
     * Perform a PUT request to the API
     * @param string $path Request path (e.g. 'orders' or 'orders/123')
     * @param array $data Request body data as an associative array
     * @return mixed API response
     * @throws CamaloonApiException if the API call status code is not in the 2xx range
     * @throws CamaloonException if the API call has failed or the response is invalid
     */
    public function put($path, $data = [])
    {
        return $this->request('PUT', $path, $data);
    }

    /**
     * Perform a PATCH request to the API
     * @param string $path Request path
     * @param array $data Request body data as an associative array
     * @return mixed API response
     * @throws CamaloonApiException if the API call status code is not in the 2xx range
     * @throws CamaloonException if the API call has failed or the response is invalid
     */
    public function patch($path, $data = [])
    {
        return $this->request('PATCH', $path, $data);
    }

    /**
     * Internal request implementation
     *
     * @param $method
     * @param $path
     * @param null $data
     *
     * @return
     * @throws CamaloonApiException
     * @throws CamaloonException
     */
    private function request($method, $path, $data = null)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $this->apiUrl . $path,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $data,
        ]);

        $response = curl_exec($curl);

        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        switch ($http_status) {
            case 200:
                return json_decode($response, true);
            default:
                return false;
        }
    }
}

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

use Tools;

class CamaloonConnectModuleFrontController extends ModuleFrontController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function postProcess()
    {
        $data = Tools::file_get_contents("php://input");
        $data = json_decode($data);

        $apiKey = $data->api_key;
        $storeId = $data->store_id;

        Configuration::updateValue(Camaloon::CONFIG_API_KEY, $apiKey);
        Configuration::updateValue(Camaloon::CONFIG_STORE_ID, $storeId);
        Configuration::updateValue(Camaloon::CONFIG_IS_FIRST_CONNECTION, true);

        $this->ajaxDie('');
    }
}

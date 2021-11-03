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
use Db;
use PrestaShopDatabaseException;
use Camaloon;
use Tools;
use WebserviceKey;
use WebserviceKeyCore;

/**
 * Class WebserviceService
 * @package Camaloon\services
 */
class WebserviceService
{
    const WEBSERVICE_KEY_LENGTH = 32;

    const PS_RESOURCES = array(
        'addresses', 'carriers', 'carts', 'cart_rules', 'categories'
        , 'combinations', 'configurations',
        'contacts', 'countries', 'currencies', 'customers', 'customer_threads'
        , 'customer_messages', 'deliveries',
        'groups', 'guests', 'images', 'image_types', 'languages', 'manufacturers'
        , 'messages', 'order_carriers', 'order_details',
        'order_histories', 'order_invoices', 'orders', 'order_payments', 'order_states',
        'order_slip', 'price_ranges', 'product_features',
        'product_feature_values', 'product_options', 'product_option_values', 'products',
        'states', 'stores', 'suppliers', 'tags',
        'translated_configurations', 'weight_ranges', 'zones', 'employees', 'search',
        'content_management_system', 'shops', 'shop_groups',
        'taxes', 'stock_movements', 'stock_movement_reasons', 'warehouses', 'stocks',
        'stock_availables', 'warehouse_product_locations',
        'supply_orders', 'supply_order_details', 'supply_order_states', 'supply_order_histories',
        'supply_order_receipt_histories', 'product_suppliers',
        'tax_rules', 'tax_rule_groups', 'specific_prices', 'specific_price_rules', 'shop_urls',
        'product_customization_fields', 'customizations'
    );

    const PS_ALL_PERMISSIONS = array(
        'GET' => true,
        'PUT' => true,
        'POST' => true,
        'DELETE' => true,
        'HEAD' => true,
    );

    /**
     * Return connected Webservice
     *
     * @return WebserviceKeyCore|null
     * @throws PrestaShopDatabaseException
     * @throws \PrestaShopException
     */
    public function getConnectedWebservice()
    {
        $keyId = Configuration::get(Camaloon::CONFIG_WEBSERVICE_KEY_ID);
        if (!$keyId) {
            return null;
        }

        return $this->getWebserviceById($keyId);
    }

    /**
     * todo: make/find repo for this
     * @param $id
     * @return WebserviceKeyCore|null
     * @throws PrestaShopDatabaseException
     * @throws \PrestaShopException
     */
    public function getWebserviceById($id)
    {
        $webService = new WebserviceKeyCore($id);
        if (!$webService || !$this->isValidWebservice($webService)) {
            return null;
        }

        return $webService;
    }

    /**
     * @param WebserviceKeyCore $webService
     * @return false|string|null
     */
    public function isValidWebservice(WebserviceKeyCore $webService)
    {
        return WebserviceKey::keyExists($webService->key);
    }

    /**
     * Create new web service key
     * @return WebserviceKeyCore
     * @throws PrestaShopDatabaseException
     * @throws \PrestaShopException
     */
    public function createNewWebservice()
    {
        // create webservice
        $webService = $this->generateWebservice();

        // save webservice
        $webService->add();

        return $webService;
    }

    /**
     * Register Webservice id for further reference
     * @param WebserviceKeyCore $key
     */
    public function registerWebservice(WebserviceKeyCore $key)
    {
        // store id in configuration for later reference
        Configuration::updateValue(Camaloon::CONFIG_WEBSERVICE_KEY_ID, $key->id);
    }

    /**
     * @return WebserviceKeyCore
     * @throws PrestaShopDatabaseException
     * @throws \PrestaShopException
     */
    protected function generateWebservice()
    {
        $webService = new WebserviceKeyCore;

        do {
            $key = Tools::substr(str_shuffle(md5(microtime())), 0, self::WEBSERVICE_KEY_LENGTH);
        } while (WebserviceKey::keyExists($key)); // make me unique

        $webService->key = $key;
        $webService->description = 'Service key for integration with Camaloon';

        return $webService;
    }

    /**
     * @param WebserviceKeyCore $webService
     * @return bool
     */
    public function renewPermissions(WebserviceKeyCore $webService)
    {
        if (!$this->isValidWebservice($webService)) {
            return false;
        }

        $permissions = array();
        foreach (self::PS_RESOURCES as $name) {
            $permissions[$name] = self::PS_ALL_PERMISSIONS;
        }

        WebserviceKey::setPermissionForAccount($webService->id, $permissions);

        return true;
    }

    /**
     * Enable Prestashop Webservice
     */
    public function enableWebservice()
    {
        Configuration::updateValue('PS_WEBSERVICE', true);
    }
}

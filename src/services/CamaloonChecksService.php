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

class CamaloonChecksService
{
    const STATUS_OK = 1;
    const STATUS_FAIL = -1;

    private static function camaloonValidPrestashopVersion()
    {
        if (version_compare(_PS_VERSION_, '1.6.1.24', '>=') === true) {
            return self::STATUS_OK;
        }
        return self::STATUS_FAIL;
    }

    private static function camaloonCheckPhpMemoryLimit()
    {
        $memory_limit = ini_get('memory_limit');

        if (preg_match('/^(\d+)(.)$/', $memory_limit, $matches)) {
            if ($matches[2] == 'M') {
                $memory_limit = $matches[1] * 1024 * 1024; // nnnM -> nnn MB
            } elseif ($matches[2] == 'K') {
                $memory_limit = $matches[1] * 1024; // nnnK -> nnn KB
            }
        }

        $ok = ($memory_limit >= 128 * 1024 * 1024); // at least 128M?
        if ($ok) {
            return self::STATUS_OK;
        }

        return self::STATUS_FAIL;
    }

    private static function camaloonCheckWebserviceApi()
    {
        if (Configuration::get('PS_WEBSERVICE')) {
            return self::STATUS_OK;
        }

        return self::STATUS_FAIL;
    }

    private static function camaloonCheckPhpTimeLimit()
    {
        $time_limit = ini_get('max_execution_time');

        if (!$time_limit || $time_limit >= 30) {
            return self::STATUS_OK;
        }

        return self::STATUS_FAIL;
    }

    public static function camaloonGetChecklistItems()
    {
        return [
            [
                'name' => 'Prestashop version',
                'description' => 'Prestashop should always be updated to the latest version.',
                'value' => CamaloonChecksService::camaloonValidPrestashopVersion(),
            ],
            [
                'name' => 'PHP memory limit',
                'description' => 'Set PHP allocated memory limit to at least 128mb. 
                Contact your hosting provider if you need help with this.',
                'value' => CamaloonChecksService::camaloonCheckPhpMemoryLimit(),
            ],
            [
                'name' => 'PHP script time limit',
                'description' => 'Set PHP script execution time limit to at least 30 seconds. 
                This is required to successfully push products with many variants. Contact your 
                hosting provider if you need help with this.',
                'value' => CamaloonChecksService::camaloonCheckPhpTimeLimit(),
            ],
            [
                'name' => 'Webservice API',
                'description' => 'PrestaShop enables merchants to give third-party tools access to 
                their shop’s database through a CRUD API, otherwise called a web service.',
                'value' => CamaloonChecksService::camaloonCheckWebserviceApi(),
            ]
        ];
    }

    public static function camaloonChecksFailed()
    {
        $items = CamaloonChecksService::camaloonGetChecklistItems();
        $status = 1;
        foreach ($items as $item) {
            if (1 != $item['value']) {
                $status = -1;
            }
        }
        return $status;
    }
}

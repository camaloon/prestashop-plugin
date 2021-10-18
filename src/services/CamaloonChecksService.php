<?php

namespace Camaloon\services;

use Configuration;

/**
 * Class Camaloon_ChecksService
 * @package Camaloon\services
 */
class CamaloonChecksService
{
    const STATUS_OK = 1;
    const STATUS_FAIL = -1;

    private static function camaloon_validPrestashopVersion()
    {
        if (version_compare(_PS_VERSION_, '1.6.1.24', '>=') === true) {
            return self::STATUS_OK;
        }
        return self::STATUS_FAIL;
    }

    private static function camaloon_check_PHP_memory_limit()
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

    private static function camaloon_checkWebserviceAPI()
    {
        if (Configuration::get('PS_WEBSERVICE')) {
            return self::STATUS_OK;
        }

        return self::STATUS_FAIL;
    }

    private static function camaloon_check_PHP_time_limit()
    {
        $time_limit = ini_get('max_execution_time');

        if (!$time_limit || $time_limit >= 30) {
            return self::STATUS_OK;
        }

        return self::STATUS_FAIL;
    }

    public static function camaloon_getChecklistItems()
    {
        return [
            [
                'name' => 'Prestashop version',
                'description' => 'Prestashop should always be updated to the latest version.',
                'value' => CamaloonChecksService::camaloon_validPrestashopVersion(),
            ],
            [
                'name' => 'PHP memory limit',
                'description' => 'Set PHP allocated memory limit to at least 128mb. Contact your hosting provider if you need help with this.',
                'value' => CamaloonChecksService::camaloon_check_PHP_memory_limit(),
            ],
            [
                'name' => 'PHP script time limit',
                'description' => 'Set PHP script execution time limit to at least 30 seconds. This is required to successfully push products with many variants. Contact your hosting provider if you need help with this.',
                'value' => CamaloonChecksService::camaloon_check_PHP_time_limit(),
            ],
            [
                'name' => 'Webservice API',
                'description' => 'PrestaShop enables merchants to give third-party tools access to their shop’s database through a CRUD API, otherwise called a web service.',
                'value' => CamaloonChecksService::camaloon_checkWebserviceAPI(),
            ]
        ];
    }
}

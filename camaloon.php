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

if (!defined('_PS_VERSION_')) {
    exit;
}

class Camaloon extends Module
{
    protected $config_form = false;

    const CAMALOON_HOST = 'https://dev.camaloon.com';

    // Plugin controllers
    const HOME_CONTROLLER = 'CamaloonHome';
    const CONNECT_CONTROLLER = 'CamaloonConnect';
    const STATUS_CONTROLLER = 'CamaloonStatus';
    const SUPPORT_CONTROLLER = 'CamaloonSupport';

    // Configuration table keys
    const CONFIG_WEBSERVICE_KEY_ID = 'CAMALOON_WEBSERVICE_KEY_ID';
    const CONFIG_IS_FIRST_CONNECTION = 'CAMALOON_IS_FIRST_CONNECTION';
    const CONFIG_API_KEY = 'CAMALOON_API_KEY';
    const CONFIG_STORE_ID = 'CAMALOON_STORE_ID';

    public function __construct()
    {
        $this->name = 'camaloon';
        $this->tab = 'others';
        $this->version = '1.0.0';
        $this->author = 'Camalize S.L.';
        $this->need_instance = 1;
        $this->bootstrap = true;

        parent::__construct();
        $this->autoLoad();

        $this->displayName = $this->l('Camaloon Print on Demand');
        $this->description = $this->l('Print-on-demand is a process where you sell your own custom 
        branded designs on a variety of different products. With print-on-demand there is no need 
        to have any inventory, as products are printed as soon as an order is made through your store.');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall the camaloon plugin?');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    private function autoLoad()
    {
        $autoLoadPath = $this->getLocalPath() . 'vendor/autoload.php';

        require_once $autoLoadPath;
    }

    /**
     * @return string
     */
    public static function getStoreAddress()
    {
        return Tools::getHttpHost(false) . __PS_BASE_URI__;
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */

    public function install()
    {
        // install tab
        foreach ($this->getTabs() as $tab) {
            $this->installTab($this, $tab);
        }
        Configuration::updateValue('CAMALOON_LIVE_MODE', false);

        include(dirname(__FILE__) . '/sql/install.php');

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('backOfficeHeader') &&
            $this->registerHook('displayBackOfficeHeader') &&
            $this->registerHook('actionProductAdd');
    }

    public function uninstall()
    {
        Configuration::deleteByName('CAMALOON_LIVE_MODE');

        include(dirname(__FILE__) . '/sql/uninstall.php');

        // remove tabs
        if (version_compare(_PS_VERSION_, '1.6.1.24', '<=') === true) {
          $tabs = Tab::getCollectionFromModule($this->name);
          // Check tabs
          if ($tabs && count($tabs)) {
            // Loop tabs for delete
            foreach ($tabs as $tab) {
                $result &= $tab->delete();
            }
          }
        }
        return parent::uninstall();
    }

    public function getTabs()
    {
        return array(
            array(
                'name' => $this->l('Camaloon'),
                'class_name' => self::HOME_CONTROLLER,
                'parent' => 'SELL',
            ),
            array(
                'name' =>  $this->l('home'),
                'class_name' => self::CONNECT_CONTROLLER,
                'parent' => self::HOME_CONTROLLER,
            ),
            array(
                'name' => $this->l('status'),
                'class_name' => self::STATUS_CONTROLLER,
                'parent' => self::HOME_CONTROLLER,
            ),
            array(
                'name' => $this->l('support'),
                'class_name' => self::SUPPORT_CONTROLLER,
                'parent' => self::HOME_CONTROLLER,
            ),
        );
    }


    public function installTab($module, $tabData)
    {
        $className = isset($tabData['class_name']) ? $tabData['class_name'] : null;
        $parent = isset($tabData['parent']) ? $tabData['parent'] : null;
        $tabName = isset($tabData['name']) ? $tabData['name'] : null;

        if (!$className) {
            return 0;
        }

        $tab = new Tab();
        $tab->id_parent = $parent ? Tab::getIdFromClassName($parent) : "-1";
        $tab->name = array();
        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = $tabName;
        }
        $tab->class_name = $className;
        $tab->module = $module->name;
        $tab->active = 1;

        $result = $tab->add();

        return  $result;
    }


    public function getContent()
    {
        $redirectLink = $this->context->link->getAdminLink(self::CONNECT_CONTROLLER);
        Tools::redirectAdmin($redirectLink);
    }

    public static function getService($className)
    {
        if (class_exists('Adapter_ServiceLocator')) {
            return Adapter_ServiceLocator::get($className);
        } elseif (class_exists('PrestaShop\PrestaShop\Adapter\ServiceLocator')) {
            return PrestaShop\PrestaShop\Adapter\ServiceLocator::get($className);
        }

        throw new Exception('No service locator found');
    }

    /**
     * Include tab css for icon
     */
    public function hookDisplayBackOfficeHeader()
    {
        $this->context->controller->addCss($this->_path . 'views/css/tab.css');
    }

    /**
     * Add the CSS & JavaScript files you want to be loaded in the BO.
     */
    public function hookBackOfficeHeader()
    {
        if (Tools::getValue('module_name') == $this->name) {
            $this->context->controller->addJS($this->_path . 'views/js/back.js');
            $this->context->controller->addCSS($this->_path . 'views/css/back.css');
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path . '/views/js/front.js');
        $this->context->controller->addCSS($this->_path . '/views/css/front.css');
    }

    public function hookActionProductAdd()
    {
        /* Place your code here. */
    }
}

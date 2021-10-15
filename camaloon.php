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

    const CONNECT_CONTROLLER = 'CamaloonConnect';
    const ADMIN_SUPPORT_CONTROLLER = 'AdminCamaloonSupport';

    public function __construct()
    {
        $this->name = 'camaloon';
        $this->tab = 'other_modules';
        $this->version = '1.0.0';
        $this->author = 'Camaloon';
        $this->need_instance = 1;
        $this->bootstrap = true;

        parent::__construct();
        $this->autoLoad();

        $this->displayName = $this->l('Camaloon Print on Demand');
        $this->description = $this->l('Print-on-demand is a process where you sell your own custom branded designs on a variety of different products. With print-on-demand there is no need to have any inventory, as products are printed as soon as an order is made through your store.');

        $this->confirmUninstall = $this->l('');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    private function autoLoad()
    {
        $autoLoadPath = $this->getLocalPath() . 'vendor/autoload.php';

        require_once $autoLoadPath;
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('CAMALOON_LIVE_MODE', false);

        include(dirname(__FILE__).'/sql/install.php');

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('backOfficeHeader') &&
            $this->registerHook('displayBackOfficeHeader') &&
            $this->registerHook('actionProductAdd');
    }

    public function uninstall()
    {
        Configuration::deleteByName('CAMALOON_LIVE_MODE');

        include(dirname(__FILE__).'/sql/uninstall.php');

        return parent::uninstall();
    }

    public function getTabs()
    {
        return array(
            array(
                'name' => $this->l('Camaloon'),
                'class_name' => self::CONNECT_CONTROLLER,
                'ParentClassName' => 'SELL',
            ),
            array(
                'name' => $this->l('Support', __CLASS__),
                'class_name' => self::ADMIN_SUPPORT_CONTROLLER,
                'ParentClassName' => self::ADMIN_PARENT_CONTROLLER,
            )
        );
    }

    public function getContent()
    {
        $redirectLink = $this->context->link->getAdminLink(self::CONNECT_CONTROLLER);
        Tools::redirectAdmin($redirectLink);
    }

    public function hookActionAdminControllerSetMedia()
    {
        $this->context->controller->addCSS($this->getPathUri() . 'views/css/camaloonController.css');
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
            $this->context->controller->addJS($this->_path.'views/js/back.js');
            $this->context->controller->addCSS($this->_path.'views/css/back.css');
        }
    }

    public function hookActionProductAdd()
    {
        /* Place your code here. */
    }

}
